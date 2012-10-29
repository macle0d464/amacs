<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
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
*/
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

$sql = "";
if ($_GET['HIVSubtype_combination'] != "")
{
	$subtype = $_GET['HIVSubtype_combination'];
}
else 
{
	$subtype = $_GET['HIVSubtype'];
}
$sql = "INSERT INTO `hiv_subtype` VALUES('".$_GET['code']."', '$subtype')";
//echo $sql;
$what_happened = execute_query($sql);

mysql_close($dbconnection);
perform_post_insert_actions("hiv_subtype", "hiv_resistance.php?code=".$_GET['code'], "");

?>

</BODY></HTML>
