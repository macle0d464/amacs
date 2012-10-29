<?php 
require_once('../include/basic_defines.inc.php');
require_once('../include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
	die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
execute_query("set names utf8;");

$type = $_POST['from'];
$sql = $_POST['sql'];
$id = $_POST['id'];
$code = $_POST['code'];

function check_patient($code)
{
	$query = "SELECT * FROM patients WHERE PatientCode = ".$code;
	$result = execute_query($query);
	$row = mysql_fetch_array($result);        
	$num_rows = mysql_num_rows($result);
    mysql_free_result($result);
	if ($num_rows == 1)	{
		return 1;
	} else {
		return 0;
	}     	
}

if (check_patient($code)) {
	$result = execute_query(stripslashes($sql));
	$error = mysql_error(); 
	if ($error == "") {
		echo "{ \"id\": \"".$id."\" , \"msg\": \"Success!\" }";	
	} elseif (strpos($error, "Duplicate entry") !== false) {
		echo "{ \"id\": \"".$id."\" , \"msg\": \"Υπάρχει εγγραφή στη βάση με ίδια ημερομηνία και εξέταση!\" }";
	} else {
		echo "{ \"id\": \"".$id."\" , \"msg\": \"".$error."\" }";
	}
	mysql_free_result($result);
} else {
	echo "{ \"id\": \"".$id."\" , \"msg\": \"Ο κωδικός ασθενούς δεν υπάρχει στη βάση!\" }";
}



?>