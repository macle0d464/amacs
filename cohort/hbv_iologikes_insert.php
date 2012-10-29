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
$data_array2 = $_GET;
$names = array_keys($data_array2);
$data_array2['Value'] = replacecomma($data_array2['Value']);
if ($_GET['Result'] == "-1")
   {
   		$data_array2['Operator'] = $_GET['Operator1'];
   }
else
   {
   		$data_array2['Operator'] = $_GET['Operator2'];
   }
$sql = "";

$sql = "INSERT INTO `hbv_iologikes` ( `PatientCode` , `ExamDate` , `Result` , `Value` , `Units`, `Operator`, `Method`)";
$sql .= " VALUES ( '".$_GET['PatientCode']."', '".join_date($data_array2, 'ExamDate')."', '".$data_array2['Result']."', ";
//if (is_numeric($data_array2['Value']))
//{
	$sql .= "'".$data_array2['Value']."', '".$data_array2['Units']."', '".$data_array2['Operator']."', ";
//}
//else
//{
//	$sql .= "NULL, NULL, NULL, ";
//}
$sql .=" '".$data_array2['Method']."')";
$sql = replace2null($sql);
//echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
//        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
//        echo "<P>$what_happened</P>".mysql_error();
    }

//form_data2table($_GET);

mysql_close($dbconnection);
perform_post_insert_actions("hbv_iologikes", "hbv_iolog_observe.php?code=".$_GET['PatientCode'], "");
//echo "<p><a href='iologikes.php?code=".$_GET['PatientCode']."'>Καντε click εδώ για να καταχωρήσετε κι άλλη εξέταση</a></p>";
?>

</BODY></HTML>
