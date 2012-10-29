<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ανοσολογικών Εξετάσεων Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//validate_data("exams_anosologikes", $_GET);
$sql="UPDATE aids_clinical_status SET CD4State=".$_GET['state']." WHERE PatientCode=".$_GET['code'];
//echo $sql;
//form_data2table($_GET);
$result=execute_query($sql);
mysql_error();
echo "<p>Η αλλαγή καταχωρήθηκε με επιτυχία!</p>";
echo "<p><a href='javascript:history.back(-1)'>Καντε click εδώ για επιστροφή</a></p>";
mysql_close($dbconnection);
?>

</BODY></HTML>
