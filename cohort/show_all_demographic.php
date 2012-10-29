<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

PrintHeaders();

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use " . $cohort_db_name . " : ' . mysql_error());
}

$result = execute_query("SELECT * FROM demographic_data");

query2table($result);

//query2xls($result, 'query.xls');

//query2csv($result, 'query.csv');

//send_file('query.csv');

mysql_close($dbconnection);

//createMenu();

CloseHTML();
?>