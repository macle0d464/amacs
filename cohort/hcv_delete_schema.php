<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Delete Schema</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php

	$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
	$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
	if (!$db_selected) {
   		die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
	}

	execute_query("DELETE FROM hcv_antiiikes_treatments WHERE StartDate>='".$_GET['start']."' AND EndDate<='".$_GET['end']."' AND PatientCode=".$_GET['code']);
	execute_query("DELETE FROM hcv_antiiikes_treatments_antapokrisi WHERE `Schema`='".$_GET['schema']."' AND StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."' AND PatientCode=".$_GET['code']);
	execute_query("DELETE FROM hcv_antiiikes_treatments_dosages WHERE StartDate>='".$_GET['start']."' AND EndDate<='".$_GET['end']."' AND PatientCode=".$_GET['code']);
	perform_post_insert_actions("", $_GET['table']."?code=".$_GET['code'], "");
	mysql_close($dbconnection);
?>
