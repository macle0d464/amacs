<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ιολογικών Εξετάσεων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//validate_data("exams_iologikes", $_GET);
$data_array2 = prepare_data("exams_iologikes", $_GET);
$names = array_keys($data_array2);

$sql = "";
for ($k = 0; $k < $_GET['exams']; $k++)
{  
$sql = "INSERT INTO `exams_iologikes` ( `PatientCode` , `ExamDate` , `Result` , `Value` , `Method`, `Units`, `Operator`)";
$sql .= " VALUES ( '".$data_array2['PatientCode']."', '".$data_array2['ExamDate'.$k]."', '".$data_array2['Result'.$k];
$sql .="', '".$data_array2['Value'.$k]."', '".$data_array2['Method'.$k]."', '".$data_array2['Units'.$k]."', '".$data_array2['Operator'.$k]."');";
//echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>".mysql_error();
    }
}
//form_data2table($_GET);

mysql_close($dbconnection);
perform_post_insert_actions("exams_iologikes", "iologikes.php?code=".$_GET['PatientCode'], "");
//echo "<p><a href='iologikes.php?code=".$_GET['PatientCode']."'>Καντε click εδώ για να καταχωρήσετε κι άλλη εξέταση</a></p>";
?>

</BODY></HTML>
