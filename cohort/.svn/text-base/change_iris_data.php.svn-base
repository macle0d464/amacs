<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντιρετροϊκών Θεραπειών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

//if ($_GET['code'] == "" || !is_numeric($_GET['code']))
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
check_patient($_GET['code']);

$sql  = "UPDATE iris SET EndDate='".join_date($_GET, 'EndDate')."' ";
$sql .= "WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."' AND Type='".$_GET['type']."'";
$sql .= " AND What='".$_GET['what']."' AND Antimetopisi='".$_GET['ant']."'";
execute_query($sql);
//echo $sql;
perform_post_insert_actions("","iris.php?code=".$_GET['code'],"");

mysql_close($dbconnection);
?>
</BODY></HTML>
