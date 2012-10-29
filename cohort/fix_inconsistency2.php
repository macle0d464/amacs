<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντιρετροϊκών Θεραπειών</TITLE>
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

$patient_code=$_GET['code'];

check_patient($patient_code);
show_patient_data($patient_code);

//    Load Reasons for discontinuation (Antiretrovial Treatment) and Medicines (Antiretrovial Treatment)

$medicine_query = "SELECT ID,Name,Category FROM medicines";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$i]['id'] = $row['ID'];
	$medicine_array[$i]['name'] = $row['Name'];
	$medicine_array[$i]['category'] = $row['Category'];
}

$reasons_query = "SELECT * FROM antiretro_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['id']] = $row['description'];
}

// Load Saved Antiretroviral Medicines for Patient $patient_code

$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$patient_code." AND antiretro_treatments.Medicine=medicines.ID";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $therapies[0] = -1;
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies[$j]['med_id'] = $row['med_id'];
            $therapies[$j]['med'] = $row['med'];
            $therapies[$j]['start'] = $row['StartDate'];
            $therapies[$j]['end'] = $row['EndDate'];
        }
    }
mysql_free_result($result);

// Convert Medicines to Schema

for ($i=0; $i< count($therapies); $i++)
{
	$old_dates[2*$i] = $therapies[$i]['start'];
	$old_dates[2*$i+1] = $therapies[$i]['end'];
}
$temp = array_unique($old_dates);
$old_dates = array_values($temp);
sort($old_dates);
reset($old_dates);
for ($i=0; $i < 2*count($therapies)-1; $i++)
{
	for ($j=0; $j < count($therapies); $j++)
	{
		if ($old_dates[$i] == $therapies[$j]['start'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}
		if ($old_dates[$i] > $therapies[$j]['start'] && $old_dates[$i] <= $therapies[$j]['end'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}		
		if ($old_dates[$i] >= $therapies[$j]['end'])
		{
			$old_schema[$i] = str_replace($therapies[$j]['med']. " / ", "", $old_schema[$i]);
		}
	}
	$old_schema[$i] = substr($old_schema[$i], 0, strlen($old_schema[$i])-3);
}

// Print Medicines and Computed Schema

echo "<p>&nbsp;</p>";
echo "<table border=0 cellspacing=10 cellpadding=0>";
echo "<tr><td valign=top>";

echo "<P align=center><B> Αποθηκευμένα Αντιρετροϊκά Φάρμακα </B></P>";
$sql = "SELECT antiretro_treatments.medicine as medicineid, medicines.Name as Medicine, StartDate, EndDate FROM antiretro_treatments, medicines WHERE antiretro_treatments.Medicine = medicines.ID AND PatientCode=".$patient_code." GROUP BY StartDate";
$result = execute_query($sql);
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
	echo "<th class=result>Φάρμακο</th>";
	echo "<th class=result>Ημερομηνία Έναρξης</th>";
	echo "<th class=result>Ημερομηνία Διακοπής</th>";
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
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_reason_".$j."' value='".$resultrow['reasonid']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "medicineid" && $field->name != "reasonid")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
                		echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
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
echo "</td><td valign=top>";

echo "<P align=center><B> Ήδη αποθηκευμένο φαρμακευτικό σχήμα </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
	echo "<TR>";
	echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
	echo $old_schema[$i];
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".show_date($old_dates[$i]);
	if ($old_dates[$i+1] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " εως ".show_date($old_dates[$i+1])."</TD></TR>";
	}
}
echo "</TABLE>";
echo "</td></tr>";
echo "</table>";
echo "<p>&nbsp;</p>";

// Print Extra Stored Information (Compliance, Reasons for discontinuation)

echo "<P><B> Συμμόρφωση Ασθενούς και Λόγοι Διακοπής Θεραπειών - <font color=blue>ΑΠΟΘΗΚΕΥΜΕΝΑ</font></B></P>";
$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_treatments_compliance.Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_treatments_compliance WHERE PatientCode=".$patient_code." GROUP BY antiretro_treatments_compliance.StartDate";
$result = execute_query($sql);
    echo "<form method=get action='delete_antiretro_data.php'>";
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$patient_code.">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    echo "<th class=result> Αλλαγή </th>";
	echo "<th class=result>Σχήμα</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "<th class=result>Συμμόρφωση<BR>Ασθενούς</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής 1</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής 2</th>";
	echo "<th class=result>Σημειώσεις</th>";
    echo "</tr>\n";
    $extra_data = array();
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        $jj = 0;
    	for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <img src='./images/b_edit.png' style='cursor: pointer' ";
            echo "onclick='location.href=\"edit_antiretro_extra.php?code=".$patient_code."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";'>";
            echo "<input type=hidden name='del_schema_".$j."' value='".$resultrow['Schema']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_compliance_".$j."' value='".$resultrow['Compliance']."'></td>\n";
            $k = 0;
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "PatientCode")
                {
                	if ($field->name == "StartDate")
                	{
                		echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                		$extra_data[$j]['start'] = $resultrow[$field->name];
                	}
                	else if ($field->name == "EndDate")
                	{
                		echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                		$extra_data[$j]['end'] = $resultrow[$field->name];
                	}
                	else if ($field->name == "Schema")
                	{
                		if ($old_schema[$jj] == "")
                		{
                			$jj++;
               		}
//                		echo "<td class=result style='width: 150px'>".$old_schema[$jj]."</td>";
                		echo "<td class=result style='width: 150px'>".$resultrow[$field->name]."</td>";
                		$jj++;
                	}
                	else if ($field->name == "Compliance")
                	{
                		$extra_data[$j]['compliance'] = $resultrow[$field->name];
                		echo "<td class=result>";
                		if ($resultrow[$field->name] == "-1")
                		{
                			echo "'Αγνωστη";
                		}
                		if ($resultrow[$field->name] == "1")
                		{
                			echo "Κακή";
                		}
                		if ($resultrow[$field->name] == "2")
                		{
                			echo "Μέτρια";
                		}
                		if ($resultrow[$field->name] == "3")
                		{
                			echo "Καλή";
                		}
                		echo "</td>";
                	}
                	else if ($field->name == "Reason1")
                	{
                		echo "<td class=result>".$reasons[$resultrow[$field->name]]."</td>";
                		$extra_data[$j]['reason1'] = $resultrow[$field->name];
                	}
					else if ($field->name == "Reason2")
                	{
                		echo "<td class=result>".$reasons[$resultrow[$field->name]]."</td>";
                		$extra_data[$j]['reason2'] = $resultrow[$field->name];
                	}
					else if ($field->name == "Notes")
                	{
                		echo "<td class=result>".$reasons[$resultrow[$field->name]]."</td>";
                		$extra_data[$j]['notes'] = $resultrow[$field->name];
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
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "</form>";
    }
    
// Generate CORRECTED Information Array

$corrected = array();
$c=0;
//echo "<table>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
	
	if ($old_schema[$i] != "")
	{
//		echo "<TR>";
		$corrected[$c]['schema'] = $old_schema[$i];
		$corrected[$c]['start'] = $old_dates[$i];
		$corrected[$c]['end'] = $old_dates[$i+1];
/*		
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
		echo $old_schema[$i];
		echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".show_date($old_dates[$i]);
		if ($old_dates[$i+1] == "3000-01-01")
		{
			echo "</TD></TR>";
		}
		else
		{
		echo " εως ".show_date($old_dates[$i+1])."</TD></TR>";
		}*/
		$c++;
	}
}
//echo "</table>";

/*
echo "<pre><table><tr><td>";
print_r($corrected);
echo "</td><td>";
print_r($extra_data);
echo "</td></tr></table></pre>";
*/

echo "<pre>";
for ($i=0; $i< count($corrected); $i++)
{
	$corrected2[$i]['schema'] = $corrected[$i]['schema'];
	$corrected2[$i]['start'] = $corrected[$i]['start'];
	$corrected2[$i]['end'] = $corrected[$i]['end'];
	$corrected2[$i]['reason1'] = $extra_data[$i]['reason1'];
	$corrected2[$i]['reason2'] = $extra_data[$i]['reason2'];
	$corrected2[$i]['compliance'] = $extra_data[$i]['compliance'];
	$corrected2[$i]['notes'] = $extra_data[$i]['notes'];
}
//print_r($corrected2);
echo "</pre>";

// Print Extra CORRECTED Information (Compliance, Reasons for discontinuation)

echo "<P><B> Συμμόρφωση Ασθενούς και Λόγοι Διακοπής Θεραπειών - <font color=red>ΔΙΟΡΘΩΣΗ</font></B></P>";

	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
	echo "<th class=result>Σχήμα</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "<th class=result>Συμμόρφωση<BR>Ασθενούς</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής 1</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής 2</th>";
	echo "<th class=result>Σημειώσεις</th>";
    echo "</tr>\n";
for ($i=0; $i<count($corrected2); $i++)
{
	echo "<TR>";	
	echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
	echo $corrected2[$i]['schema'];
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".show_date($corrected2[$i]['start']);
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".show_date($corrected2[$i]['end']);
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>"; //.$corrected2[$i]['compliance'];
	               		if ($corrected2[$i]['compliance'] == "-1")
                		{
                			echo "'Αγνωστη";
                		}
                		if ($corrected2[$i]['compliance'] == "1")
                		{
                			echo "Κακή";
                		}
                		if ($corrected2[$i]['compliance'] == "2")
                		{
                			echo "Μέτρια";
                		}
                		if ($corrected2[$i]['compliance'] == "3")
                		{
                			echo "Καλή";
                		}
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF; width: 300px'>".$reasons[$corrected2[$i]['reason1']];
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF; width: 300px'>".$reasons[$corrected2[$i]['reason2']];
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".$corrected2[$i]['notes'];
	echo "</TR>";
}
echo "</table>";

execute_query("DELETE FROM `antiretro_treatments_compliance` WHERE PatientCode='".$patient_code."'");
for ($i=0; $i<count($corrected2); $i++)
{
	$sql = "INSERT INTO `antiretro_treatments_compliance` VALUES('".$patient_code."', '".$corrected2[$i]['schema']."', '".$corrected2[$i]['start']."', '".$corrected2[$i]['end']."', '".$corrected2[$i]['compliance']."', '".$corrected2[$i]['reason1']."', '".$corrected2[$i]['reason2']."', '".$corrected2[$i]['notes']."')";
	echo $sql."<BR>";
	execute_query($sql);
}
?>