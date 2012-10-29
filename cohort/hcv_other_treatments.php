<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$medicine_query = "SELECT * FROM hcv_other_meds";
	$reasons_query = "SELECT * FROM hbv_other_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	mysql_free_result($reason_result);
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Θεραπειών για HCV εκτός αντιρετροϊκών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<? 
if (isset($_GET['error']))
{
	echo "<center><table><tr><td class='errormsg'>" . $_GET['error'] . "</td></tr></table></center><br>";
}
?>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("hcv_other_treatments.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hcv_coinfection($_GET['code']);
}
?>

<FORM id="hcv_other_treatments_form" name="hcv_other_treatments_form" action="hcv_other_insert.php" method="GET">
<? show_patient_data($_GET['code']); ?>
<a href="#view">Προβολή Θεραπειών Ασθενή</a>
<input type="hidden" name=code value="<? echo $_GET['code']?>">

<a name="top"></a>
<h3>Θεραπεία για HCV</h3>

    <TABLE width=1000>
    </TR>
    <TR>
    <TD class="show">Φαρμακευτικό Σχήμα</TD>
    <TD class="show" align="center">Ημερομηνία Έναρξης</TD>
    <TD class="show" align="center">Ημερομηνία Διακοπής </TD>
     <TD class="show" align="center">Αιτία<BR>διακοπής</TD>    
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
    <tr><td><table>
    <TR><TD>
<table>
<?php
	$results = execute_query("SELECT * FROM hcv_other_meds");		
	$num = mysql_num_rows($results);
	for ($i = 0; $i < $num; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$id = $row['ID'];
		$name = $row['Name'];
		$description = $row['Description'];
		$j = $i+1;
?>
	<TR>
 	<TD><b><? echo $name; ?></b><br><? echo $description; ?></TD><TD><input type="checkbox" name="<? echo $name; ?>_ba" value=<? echo $id; ?> /></TD>
 	</TR>
 	<?  }  ?>
	</table>
	</TD>
	</TR>
	</table></td>
 	<TD align="center" valign="top">Ημέρα: <select name=StartDate_day>
 	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name=StartDate_year>
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select></TD>
    <TD align="center" valign="top">Ημέρα: <select name=EndDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name=EndDate_year>
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select> </TD>
    <TD align="center" valign="top"><select name=Reason>
    <option value="0" selected>0</option>
    <? print_opts($reasons-1); ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./hcv_other_reasons.php?field=Reason', 'Λόγοι', 'width=450,height=300,status=yes');"/>
    </TD>
	</TR>
<?php
	mysql_free_result($results);
?> 
</TABLE>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<hr>
<a name="view"><h3>Καταχωρημένες Θεραπείες &nbsp; <a href="#top"><small>Επιστροφή</small></a> </h3></a>
<div>
<?php
$sql = "SELECT hcv_other_treatments.Sxima, hcv_other_treatments.StartDate, hcv_other_treatments.EndDate, hbv_other_reasons.Reason, hcv_other_treatments.Sxima FROM hcv_other_treatments, hbv_other_reasons WHERE hbv_other_reasons.ID=hcv_other_treatments.Reason AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_other_treatments.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=hcv_other_treatments>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result>Θεραπευτικό Σχήμα</th>";
   	echo "<th class=result>Ημερομηνία Έναρξης</th>";
   	echo "<th class=result>Ημερομηνία Διακοπής</th>";
   	echo "<th class=result>Αιτία Διακοπής</th>";
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
            echo "<td align=center> <input type=checkbox name='del_therapy_sw_".$j."'>";
            echo "<input type=hidden name='del_therapy_id_".$j."' value='".$resultrow['Sxima']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";

            for ($i = 0; $i < 4; $i++)
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "id" && $field->name != "therapyid")
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }
    
mysql_free_result($result);   
?>
</div>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>