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

$what_happened = insert_data("exams_orologikes", $_GET);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
        echo "<p><a href='orologikes.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να καταχωρήσετε και άλλη εξέταση</a></p>";
        echo "<p><a href='antiretro.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να καταχωρήσετε αντιρετροϊκές θεραπείες</a></p>";
    }
else
    {
        echo "<P>$what_happened</P>";
        echo mysql_error();
    }

$HBV_antihbs_negative = "SELECT * FROM exams_orologikes WHERE `Anti-HBs`='-1' AND PatientCode=".$_GET['PatientCode'];
$HBV_others_positive = "SELECT * FROM exams_orologikes WHERE (HBsAg='1' OR `Anti-HBc`='1' OR HBeAg='1' OR `Anti-HBe`='1') AND PatientCode=".$_GET['PatientCode'];
$antihbs_negative_result = execute_query($HBV_antihbs_negative);
$hbv_others_positive_result = execute_query($HBV_others_positive);
if (mysql_num_rows($antihbs_negative_result) && mysql_num_rows($hbv_others_positive_result))
{
	echo "<p><b>Ο ασθενής έχει μια τουλάχιστον από τις εξετάσεις HBsAg, Anti-HBc, HBeAg, Anti-HBe θετική και την εξέταση Anti-HBs αρνητική και πιθανόν να έχει HΒV συλλοίμωξη</b></p>";
	echo "<p><a href='coinfection.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να καταχωρήσετε τη συλλοίμωξη</a></p>";

}

$HCV_antihcv_positive = "SELECT * FROM exams_orologikes WHERE `Anti-HCV`='1' AND PatientCode=".$_GET['PatientCode'];	
$ok_HCV_result = execute_query($HCV_antihcv_positive);
$ok_HCV = mysql_num_rows($ok_HCV_result);
if ($ok_HCV)
{
	echo "<p><b>Ο ασθενής έχει μια τουλάχιστον εξέταση Anti-HCV θετική και πιθανόν να έχει HCV συλλοίμωξη</b></p>";
	echo "<p><a href='coinfection.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να καταχωρήσετε τη συλλοίμωξη</a></p>";
} 
echo "<p>&nbsp;</p>";
echo "<p><a href='orologikes.php?code=".$_GET['PatientCode']."'>Καντε click εδώ για να καταχωρήσετε κι άλλη εξέταση</a></p>";
mysql_close($dbconnection);
?>

</BODY></HTML>
