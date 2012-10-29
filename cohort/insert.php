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
//validate_data("exams_orologikes", $_GET);
//prepare_data("exams_orologikes", $_GET);
//$data_array2 = prepare_data("atomiko_anamnistiko", $_GET);
//$names = array_keys($data_array2);
/*
$neoplasma_sql = "";
for ($i = 0; $i < $_GET['num_neoplasmata']; $i++)
{  
	$neoplasma_sql .= " INSERT INTO `patient_neoplasma` ( `PatientCode` , `MELCode` , `NeoplasmaID`, `NeoplasmaDate` )";
	$date = join_date($_GET, 'NeoplasmaDate'.$i);
	$neoplasma_sql .= " VALUES ( '". $_GET['PatientCode'] ."' , '". $_GET['MELCode'] ."' , '". $_GET['NeoplasmaID'.$i] ."', '". $date ."' );";
//	$neoplasma_sql .= "\n";
}

$clinic_state_sql = "";
for ($i = 0; $i < $_GET['num_states']; $i++)
{  
	$neoplasma_sql .= " INSERT INTO `patient__other_clinical_state` ( `PatientCode` , `MELCode` , `ClinicalStatusID`, `ClinicalStatusDate` )";
	$date = join_date($_GET, 'ClinicalStatusDate'.$i);
	$neoplasma_sql .= " VALUES ( '". $_GET['PatientCode'] ."' , '". $_GET['MELCode'] ."' , '". $_GET['ClinicalStatusID'.$i] ."', '". $date ."' );";
//	$neoplasma_sql .= "\n";
}

//$sql= $atomic_sql . "\n" . $neoplasma_sql . "\n" . $clinic_state_sql;   
$sql= $atomic_sql . $neoplasma_sql . $clinic_state_sql;   
echo $sql."<BR><BR>";
*/
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

$what_happened = insert_data("demographic_data", $_GET);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }

mysql_close($dbconnection);
?>

</BODY></HTML>
