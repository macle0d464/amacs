<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αιματολογικών Εξετάσεων Ασθενούς</TITLE>
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

check_patient($_GET['PatientCode']);
$data_array2 = prepare_data("exams_aimatologikes", $_GET);
$names = array_keys($data_array2);

$sql = "";
for ($k = 0; $k < $_GET['exams']; $k++)
{  
$sql = "INSERT INTO `exams_aimatologikes` ( `PatientCode` , `ExamDate` , `Leuka` , `Aimosfairini` , `Aimopetalia` , `Aimatokritis`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['ExamDate'.$k];
$sql .="', '".replacecomma($data_array2['Leuka'.$k])."', '".replacecomma($data_array2['Aimosfairini'.$k])."', '".replacecomma($data_array2['Aimopetalia'.$k])."', '".replacecomma($data_array2['Aimatokritis'.$k]);
$sql .="');";
//echo $sql;
$sql = replace2null($sql);
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
//        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
//        echo "<P>$what_happened</P>";
    }
}
//form_data2table($_GET);
mysql_close($dbconnection);
perform_post_insert_actions("aimatologikes", "aimatologikes.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
