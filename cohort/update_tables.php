﻿<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}   

$version_update_sql = "INSERT INTO `setup` VALUES ('db_version', '1.6')";
$version_update2_sql = "UPDATE `setup` SET Value='1.6' WHERE Setting='db_version'";

execute_query($version_update_sql);
execute_query($version_update2_sql);
?>