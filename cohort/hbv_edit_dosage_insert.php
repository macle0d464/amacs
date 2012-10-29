<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντι-ιικών Θεραπειών</TITLE>
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

$sql  = "UPDATE hbv_antiiikes_treatments_dosages SET ";
if ($_GET['dosage1'] != "")
{
	$sql .= "Dosage1='".replacecomma($_GET['dosage1'])."', Dosage1Type='".$_GET['dosage1type']."', Dosage2Type='".$_GET['dosage2type']."' ";	
}
else
{
	$sql .= "Dosage1=NULL, Dosage1Type=NULL, Dosage2Type=NULL ";
}
$sql .= " WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."'";
$sql .= " AND Medicine='".$_GET['Medicine']."' AND link_id='".$_GET['link_id']."'";
execute_query($sql);
//echo "<pre>$sql";
//echo mysql_error();
mysql_close($dbconnection);
perform_post_insert_actions("","hbv_show_antiiikes_data.php?code=".$_GET['code'],"");
?>
</BODY></HTML>
