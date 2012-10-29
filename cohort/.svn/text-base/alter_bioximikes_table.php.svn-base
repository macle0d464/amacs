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
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Βιοχημικών Εξετάσεων Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>

<?php
$lab = array();
$exams_sql = "SELECT * FROM laboratory_codes";
$lab_result = execute_query($exams_sql);
for ($i=0; $i<mysql_num_rows($lab_result); $i++)
{
  	$row = mysql_fetch_assoc($lab_result);
	$lab[$i]['code'] = $row['Code'];
	$lab[$i]['upper'] = $row['Upper'];
	$lab[$i]['lower'] = $row['Lower'];
}

//echo "<pre>";
//print_r($lab);
//echo "</pre>";

$alter_table = "ALTER TABLE `exams_bioximikes` ADD `Lower` FLOAT NOT NULL AFTER `Value`, ADD `Upper` FLOAT NOT NULL AFTER `Lower`";
execute_query($alter_table);
echo "$alter_table<BR>";
for ($i=0; $i<count($lab); $i++)
{
	$sql = "UPDATE `exams_bioximikes` SET Lower='".$lab[$i]['lower']."', Upper='".$lab[$i]['upper']."' WHERE Code='".$lab[$i]['code']."'";
	echo $sql."<br>";
	execute_query($sql);
}
	$sql = "ALTER TABLE `prophylactic_therapies` ADD `Note` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
	echo $sql."<br>";
	execute_query($sql);
	$sql = "ALTER TABLE `exams_iologikes` ADD `Units` TINYINT UNSIGNED DEFAULT '10' NOT NULL AFTER `Value` ;";
	echo $sql."<br>";
	execute_query($sql);
	$sql = "ALTER TABLE `exams_iologikes` CHANGE `Method` `Method` TINYINT NOT NULL DEFAULT '1'";
	echo $sql."<br>";
	execute_query($sql);
	$sql = "ALTER TABLE `hbv_iologikes` CHANGE `Method` `Method` TINYINT NOT NULL";
	echo $sql."<br>";
	execute_query($sql);
	$sql = "ALTER TABLE `hcv_iologikes` CHANGE `Method` `Method` TINYINT NOT NULL";
	echo $sql."<br>";
	execute_query($sql);

	
// ALTER TABLE `prophylactic_therapies` ADD `Note` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci;
?>