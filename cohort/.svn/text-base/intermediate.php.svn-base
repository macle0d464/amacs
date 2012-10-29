<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

$code = $_GET['code'];
check_patient($code);

$query3  = "SELECT clinic_visits.PatientCode, Name, Surname, BirthDate, MAX(DateOfVisit) ";
$query3 .= "FROM clinic_visits, patients,last_state ";
$query3 .= "WHERE patients.PatientCode=clinic_visits.PatientCode AND patients.PatientCode=last_state.PatientCode AND ";
$query3 .= "last_state.LastState=1 AND clinic_visits.PatientCode='".$code."' ";
$query3 .= "GROUP BY PatientCode ";
$query3 .= "HAVING DATEDIFF(NOW(), MAX(DateOfVisit)) > 364";
$result = execute_query($query3);
//echo mysql_error();
$num = mysql_num_rows($result);
if ($num>0)
{
	perform_post_insert_actions("", "jail.php?code=".$code, "");
}
else
{
	perform_post_insert_actions("", "main.php?code=".$code, "");
}

mysql_close($dbconnection); 
?>