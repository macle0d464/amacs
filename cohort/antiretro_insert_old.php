<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//validate_data("antiretro_treatments", $_GET);
$data_array2 = prepare_data("antiretro_treatments", $_GET);
$names = array_keys($data_array2);

$sql = "";
for ($k = 0; $k < $_GET['exams']; $k++)
{  
$sql = "INSERT INTO `antiretro_treatments` ( `PatientCode` , `MELCode` , `StartDate` , `EndDate` , `Reason` , `OtherReason` , `Unwanted1` , `Unwanted2` , `Unwanted3` , `OtherUnwanted` , `Drugs1` , `Drugs2`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['MELCode']."', '".$data_array2['StartDate'.$k]."', '".$data_array2['EndDate'.$k]."', '".$data_array2['Reason'.$k];
$sql .="', '".$data_array2['OtherReason']."', '".$data_array2['Unwanted1_'.$k]."', '".$data_array2['Unwanted2_'.$k]."', '".$data_array2['Unwanted3_'.$k];
$sql .="', '".$data_array2['OtherUnwanted']."', '".$data_array2['Drugs1'.$k]."', '".$data_array2['Drugs1'.$k]."');";
echo "<BR>".$sql."<BR><BR>";
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }
}

?>

<HTML><HEAD>
<TITLE>Καταχώρηση Δημογραφικών Στοιχείων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></HEAD>

<BODY bgcolor="FFCCFF">

<?php
//form_data2table($_GET);
/*
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }
*/
mysql_close($dbconnection);
?>

</BODY></HTML>
