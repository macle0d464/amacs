<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Εισαγωγής σε νοσοκομείο</TITLE>
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
//form_data2table($_GET);


$data_array2 = $_GET;
$names = array_keys($data_array2);

if ($_GET['Diagnosis'] == "XX99")
{
	$data_array2['Diagnosis'] = $_GET['DiagnosisICD'];
	$_GET['Diagnosis'] = $_GET['DiagnosisICD'];
}


$sql = "";
$sql = "INSERT INTO `hospitalization` ( `PatientCode` , `EntryDate` , `ExitDate` , `Diagnosis` , `Ekbasi`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".join_date($data_array2, 'EntryDate')."', '".join_date($data_array2, 'ExitDate')."'";
$sql .=", '".$data_array2['Diagnosis']."', '".$data_array2['Ekbasi']."');";
//echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
{
//   	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
}
else
{
//   	echo "<P>$what_happened</P>";
}

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
?>
<?
mysql_close($dbconnection);
perform_post_insert_actions("", "hospitalization.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
