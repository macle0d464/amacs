<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ορολογικών Εξετάσεων Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
//form_data2table($_GET);
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

check_patient($_GET['PatientCode']);
check_hcv_coinfection($_GET['PatientCode']);
$sql = "INSERT INTO `hcv_lab` VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'ExamDate')."', '".$_GET['ALT']."', '".$_GET['AST']."', '".$_GET['gammaGT']."')";
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
//       echo "<p><a href='orologikes.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να καταχωρήσετε και άλλη εξέταση</a></p>";
//       echo "<p><a href='antiretro.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να καταχωρήσετε αντιρετροϊκές θεραπείες</a></p>";
    }
else
    {
        echo "<P>$what_happened</P>";
        echo mysql_error();
    }

echo "<p><a href='hcv_lab.php?code=".$_GET['PatientCode']."'>Καντε click εδώ για να καταχωρήσετε κι άλλη εξέταση</a></p>";
mysql_close($dbconnection);
?>

</BODY></HTML>
