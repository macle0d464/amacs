<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
require_once('Date/Calc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντι-ιικών Θεραπειών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

check_patient($_GET['code']);
show_patient_data($_GET['code']);

// Parse data from form

$medicine_query = "SELECT ID,Name,Category FROM hbv_medicines";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$i]['id'] = $row['ID'];
	$medicine_array[$i]['name'] = $row['Name'];
	$medicine_array[$i]['category'] = $row['Category'];
}

$reasons_query = "SELECT * FROM hbv_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['ID']] = $row['Reason'];
}

$io_methods_query = "SELECT * FROM hbv_iologikes_methods";
$results = execute_query($io_methods_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$io_methods[$row['ID']] = $row['Method'];
}

$units = array();
$units[1] ="copies/ml";
$units[2] ="Eq/ml";
$units[3] ="Pg/ml";
$units[4] ="Meg/ml";
$units[5] ="IU/ml";

echo "<p><a href='hbv_antiiikes.php?code=".$_GET['code']."'><b>Επιστροφή στην καταχώρηση θεραπειών</b></a></p><p>&nbsp;<p>";

$query = "SELECT * FROM hbv_antiiikes_treatments_antapokrisi WHERE PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
if ($num_rows == 0)
{
	$therapies[0] = -1;
}
if ($therapies[0] == -1 && !$previous_med)
{
	echo "<h2>Δεν υπάρχουν καταχωρημένες αντι-ιικές θεραπείες για τον ασθενή ".$_GET['code']."</h2>";
}
else
{
	echo "<P><B> Ήδη αποθηκευμένο φαρμακευτικό σχήμα </B></P>";
	echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Διαγραφή</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
	for ($i=0; $i<$num_previous_med; $i++)
	{
		$row = mysql_fetch_array($result_temp);	
		echo "<TR><TD align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_previous_med(\"".$row[0]."\");'></TD><TD class=result>".$row[0]."</TD><TD class=result align=center> <i>(στο παρελθόν)</i></TD></TR>";
	}
	for ($i=0; $i<$num_rows; $i++)
	{
	$schema_row = mysql_fetch_assoc($result);
	echo "<TR>";
	echo "<TD align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_schema(\"".$schema_row['Schema']."\", \"".$schema_row['StartDate']."\", \"".$schema_row['EndDate']."\");'>";
	echo "<TD class=result>".$schema_row['Schema']."</TD>";
	echo "<TD class=result align=center> Από ".show_date($schema_row['StartDate']);
	if ($schema_row['EndDate'] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " εως ".show_date($schema_row['EndDate'])."</TD></TR>";
	}
}
echo "</TABLE>";


echo "<p>&nbsp;</p>";
echo "<P><B> Αποθηκευμένα Αντι-ιικά Φάρμακα </B></P>";
$sql = "SELECT hbv_antiiikes_treatments.medicine as medicineid, hbv_medicines.Name as Medicine, StartDate, EndDate FROM hbv_antiiikes_treatments, hbv_medicines WHERE hbv_antiiikes_treatments.Medicine = hbv_medicines.ID AND PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($sql);
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>Φάρμακο</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "medicineid" && $field->name != "reasonid")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
						if ($resultrow[$field->name] == "3000-01-01")
						{
							echo "<td class=result  style='cursor: pointer'></td>";
						}
						else
						{
                			echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
						}                		
                	}
                	else
                	{
						echo "<td class=result>".$resultrow[$field->name]."</td>";
                	}
                }
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
    }
}

echo "<p>&nbsp;</p>";

echo "<P><B> Αποθηκευμένες Δόσεις Φαρμάκων </B></P>";
$sql = "SELECT Medicine, Dosage1, Dosage1Type, Dosage2Type, StartDate, EndDate, link_id FROM hbv_antiiikes_treatments_dosages WHERE PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($sql);
    echo "<input type=hidden name=therapy_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    echo "<th class=result> Προσθήκη </th>";
    echo "<th class=result> Αλλαγή </th>";
	echo "<th class=result>Φάρμακο</th>";
	echo "<th class=result>Δόση</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
			echo "<td align=center> <img src='./images/b_edit.png' ";
            echo "onclick='location.href=\"hbv_add_dosage.php?code=".$_GET['code']."&Medicine=".$resultrow['Medicine']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."&link_id=".$resultrow['link_id']."\";' style='cursor:pointer;'>";            
            echo "<td align=center> <img src='./images/b_edit.png' ";
            echo "onclick='location.href=\"hbv_edit_dosage.php?code=".$_GET['code']."&Medicine=".$resultrow['Medicine']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."&link_id=".$resultrow['link_id']."\";' style='cursor:pointer;'>";
			echo "<td class=result>".$resultrow['Medicine']."</td>";
			echo "<td class=result>";
			echo show_dec($resultrow['Dosage1'])." ".$resultrow['Dosage1Type'];
			if ($resultrow['Dosage1'] != "")
			{
				echo " ~ ";
			}
			else 
			{
				echo " - ";
			}
			switch ($resultrow['Dosage2Type'])
			{
				case '1':
					echo "1 φορά την εβδομάδα";
					break;
				case '2':
					echo "2 φορές την εβδομάδα";
					break;
				case '3':
					echo "3 φορές την εβδομάδα";
					break;
				case '4':
					echo "4 φορές την εβδομάδα";
					break;
				case '5':
					echo "5 φορές την εβδομάδα";
					break;
				case '6':
					echo "6 φορές την εβδομάδα";
					break;
				case '7':
					echo "Καθημερινά";
					break;
			}
			echo "</td>";
            echo "<td class=result>".show_date($resultrow['StartDate'])."</td>";
            if ($resultrow['EndDate'] == "3000-01-01")
            {
            		echo "<td class=result> - </td>";
            }
            else
            {
            	echo "<td class=result>".show_date($resultrow['EndDate'])."</td>";
            }
            echo "</tr>\n";
        }
        echo "</table>";
    }



echo "<p>&nbsp;</p>";

$sql =  " SELECT * FROM hbv_antiiikes_treatments_antapokrisi WHERE PatientCode='".$_GET['code']."' GROUP BY hbv_antiiikes_treatments_antapokrisi.StartDate";
$result = execute_query($sql);
echo mysql_error();
//query2table($result);
    echo "<form method=get action='delete_antiiikes_data.php'>";
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    echo "<th class=result>Διαγραφή<br>Αλλαγή</th>";
    $i = 0;
	echo "<th width='10px' class=result >Σχήμα</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "<th class=result>Ανταποκρίσεις</th>";
	echo "<th class=result>Ολοκλήρωση<BR>Θεραπείας</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής</th>";
	echo "<th class=result>Σημειώσεις</th>";
    echo "</tr>\n";
	$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        $jj = 0;
		$today = getdate();
		$now_days = round(strtotime("now")/86400);
    	for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_schema(\"".$resultrow['Schema']."\", \"".$resultrow['StartDate']."\", \"".$resultrow['EndDate']."\");'><br><br><img src='./images/b_edit.png' style='cursor: pointer' ";
            echo "onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";'>";
            echo "<td class=result style='width: 150px'>".$resultrow['Schema']."</td>";
            echo "<td class=result>".show_date($resultrow['StartDate'])."</td>";
       		echo "<td class=result>";
       		if ($resultrow['EndDate'] != "3000-01-01")
       		{ 
       		echo show_date($resultrow['EndDate']);
        	}
        	else 
        	{
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></div>";
//        		echo " ";
        	}
       		echo "</td>";                	
			echo "<td class=result>";
?>
			<center><u><b>Βιοχημική Ανταπόκριση:</b></u></center>
			<table>
<?			
			echo "<tr><td>Αρχική:<BR><i>(φυσιολογική ALT)</i>&nbsp;&nbsp;</td><td>";
			if ($resultrow['Bioximiki_arxiki'] != -1)
			{
				if ($resultrow['Bioximiki_arxiki'] == 1)
				{
					echo "<b>NAI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_arxiki_date']."</td></tr>";
				}
				else if ($resultrow['Bioximiki_arxiki'] == 0)
				{
					echo "<b>OXI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_arxiki_date']."</td></tr>";
				}
				else
				{
					echo "<b>ΑΓΝΩΣΤΗ,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_arxiki_date']."</td></tr>";
				}
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></div>";
			}
			echo "</td></tr>";
			echo "<tr><td valign='middle'>Διαφυγή υπό θεραπεία&nbsp;&nbsp;</td><td>";
			if ($resultrow['Bioximiki_diafugi'] != -1)
			{
				if ($resultrow['Bioximiki_diafugi'] == 1)
				{
					echo "<b>NAI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_diafugi_date']."</td></tr>";
				}
				else if ($resultrow['Bioximiki_diafugi'] == 0)
				{
					echo "<b>OXI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_diafugi_date']."</td></tr>";
				}
				else
				{
					echo "<b>ΑΓΝΩΣΤΗ,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_diafugi_date']."</td></tr>";
				}
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></div>";
			}
			echo "</td></tr>";
			echo "<tr><td>Τέλος σχήματος&nbsp;&nbsp;</td><td>";
			if ($resultrow['Bioximiki_end'] != -1)
			{
				if ($resultrow['Bioximiki_end'] == 1)
				{
					echo "<b>NAI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_end_date']."</td></tr>";
				}
				else if ($resultrow['Bioximiki_end'] == 0)
				{
					echo "<b>OXI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_end_date']."</td></tr>";
				}
				else
				{
					echo "<b>ΑΓΝΩΣΤΗ,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_end_date']."</td></tr>";
				}
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></div>";
			}
			echo "</td></tr>";
			echo "<tr><td><b>Μακροχρόνια</b><i><BR>(>12 μήνες μετά την<BR>διακοπή κάθε θεραπείας)</i>&nbsp;&nbsp;</td><td>";
			if ($resultrow['Bioximiki_longterm'] != -1)
			{
				if ($resultrow['Bioximiki_longterm'] == 1)
				{
					echo "<b>NAI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_longterm_date']."</td></tr>";
				}
				else if ($resultrow['Bioximiki_longterm'] == 0)
				{
					echo "<b>OXI,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_longterm_date']."</td></tr>";
				}
				else
				{
					echo "<b>ΑΓΝΩΣΤΗ,</b>&nbsp;Ημ/νια ".$resultrow['Bioximiki_longterm_date']."</td></tr>";
				}
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></div>";
			}
			echo "</td></tr>";						
?>
			</table>
			<center><u><b>Ιολογική Ανταπόκριση:</b></u></center>
			<table>
<?			
			echo "<tr><td>Αρχική<BR><i>(ελάχιστα επίπεδα<BR>εντός πρώτου έτος)</i>&nbsp;&nbsp;</td><td>";
			if ($resultrow['Iologiki_arxiki_value'] != "")
			{
				echo "<b>".$resultrow['Iologiki_arxiki_value']." ".$units[$resultrow['Iologiki_arxiki_units']]."</b>,<BR>Μέθοδος: ".$io_methods[$resultrow['Iologiki_arxiki_method']];
				echo "<BR>Ημ/νια ".$resultrow['Iologiki_arxiki_date']."</td></tr>";
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<center><font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></center></div>";
			}
			echo "</td></tr>";		
			echo "<tr><td>Διαφυγή υπό θεραπεία<BR><i>(αύξηση >= 1log<SUB>10</SUB>)</i>&nbsp;&nbsp;</td><td>";
			if ($resultrow['Iologiki_diafugi_value'] != "")
			{
				echo "<b>".$resultrow['Iologiki_diafugi_value']." ".$units[$resultrow['Iologiki_diafugi_units']]."</b>,<BR>Μέθοδος: ".$io_methods[$resultrow['Iologiki_diafugi_method']];
				echo "<BR>Ημ/νια ".$resultrow['Iologiki_diafugi_date']."</td></tr>";
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<center><font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></center></div>";
			}
			echo "</td></tr>";
			echo "<tr><td>Στο τέλος θεραπείας&nbsp;&nbsp;</td><td>";
			if ($resultrow['Iologiki_end_value'] != "")
			{
				echo "<b>".$resultrow['Iologiki_end_value']." ".$units[$resultrow['Iologiki_end_units']]."</b>,<BR>Μέθοδος: ".$io_methods[$resultrow['Iologiki_end_method']];
				echo "<BR>Ημ/νια ".$resultrow['Iologiki_end_date']."</td></tr>";
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<center><font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></center></div>";
			}
			echo "</td></tr>";			
			echo "<tr><td><b>Μακροχρόνια</b><BR><i>(>12 μήνες μετά την<BR>διακοπή κάθε θεραπείας)</i>&nbsp;&nbsp;</td><td>";
			if ($resultrow['Iologiki_longterm_value'] != "")
			{
				echo "<b>".$resultrow['Iologiki_longterm_value']." ".$units[$resultrow['Iologiki_longterm_units']]."</b>,<BR>Μέθοδος: ".$io_methods[$resultrow['Iologiki_longterm_method']];
				echo "<BR>Ημ/νια ".$resultrow['Iologiki_longterm_date']."</td></tr>";
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<center><font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></center></div>";
			}
			echo "</td></tr>";			
?>
			</table>
			<center><u><b>Ορολογική Ανταπόκριση:</b></u></center>		
<?			
    $HBeAg_positive_query = "SELECT Result FROM exams_orologikes WHERE Type='HBeAg' AND PatientCode=".$_GET['code'];
	$HBeAg_result = execute_query($HBeAg_positive_query);
	$HBeAg_result_row = mysql_fetch_row($HBeAg_result);
	$HBeAg_positive = $HBeAg_result_row[0];
	if ($HBeAg_positive == "1")
	{
			echo "<table>";
			echo "<tr><td>Υπό/Τέλος θεραπείας&nbsp;&nbsp;</td><td>";
			if ($resultrow['Orologiki_end'] != -1)
			{              	
				switch ($resultrow['Orologiki_end']) {
						case '1':	echo "HBeAg(+)";
									break;
						case '2':	echo "HBeAg(-)/anti-HBe(-)";
									break;
						case '3':	echo "HBeAg(-)/anti-HBe(+)";
									break;																		
				}
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<center><font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></center></div>";
			}			
			echo "</td></tr>";
			echo "<tr><td><b>Μακροχρόνια</b><BR><i>(>12 μήνες μετά την<BR>διακοπή κάθε θεραπείας)</i>&nbsp;&nbsp;</td><td>";
			if ($resultrow['Orologiki_longterm'] != -1)
			{              	
				switch ($resultrow['Orologiki_longterm']) {
						case '1':	echo "HBeAg(+)";
									break;
						case '2':	echo "HBeAg(-)/anti-HBe(-)";
									break;
						case '3':	echo "HBeAg(-)/anti-HBe(+)";
									break;																		
				}
			}
			else
			{ 
				echo "<div onclick='location.href=\"hbv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<center><font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'></center></div>";
			}
			echo "</td></tr>";
			echo "</table>";
	}
	else
	{
?>
			<center>
			<font color=red>
			Δεν μπορείτε να καταχωρήσετε ορολογική ανταπόκριση<BR>
			γιατί δεν έχετε δηλώσει <STRONG>HBeAg θετική XHB</STRONG> για τον ασθενή
			</font>
			</center>
<?
	}
            echo "<td class=result align=center>";
            if ($resultrow['Info1'] == 1)
            {
            	echo "NAI";
            }
            else if ($resultrow['Info1'] == 2)
            {
            	echo "OXI";
            }
            echo "</td>";
            echo "<td class=result>".$reasons[$resultrow['Info2']]."</td>";
            echo "<td class=result>".$resultrow['Notes']."</td>";
            $i++;
   			$jj++;
        }
            echo "</tr>\n";
    }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//        echo " <input type=submit value='Αλλαγή'></p>";
        echo "</form>";
    

echo "<p>&nbsp;</p>";

mysql_close($dbconnection);
?>

<script>
function delete_entry(link)
{
	location.href = "delete_with_query.php?table=hcv_show_antiiikes_data.php&code=<? echo $_GET['code']?>&query=" + link;
}

function delete_schema(schema, start, end)
{
	ok = confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το σχήμα " + schema +";");
	if (ok) {
		location.href = "hbv_delete_schema.php?table=hcv_show_antiiikes_data.php&code=<? echo $_GET['code']?>&schema=" + schema + "&start=" + start + "&end=" + end;
	}
}

function delete_previous_med(med)
{
	ok = confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το φάρμακο " + med +";");
	if (ok) {
		query = "DELETE FROM extra_meds WHERE PatientCode=,<? echo $_GET['code']?>, AND Medicine=," + med + ",";
		location.href = "delete_with_query.php?table=hcv_show_antiiikes_data.php&code=<? echo $_GET['code']?>&query=" + query;
	}
}

</script>
</BODY></HTML>
