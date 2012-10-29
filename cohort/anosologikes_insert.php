<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
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
*/
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//validate_data("exams_anosologikes", $_GET);
check_patient($_GET['PatientCode']);
$data_array2 = prepare_data("exams_anosologikes", $_GET);
$names = array_keys($data_array2);

$sql = "";
for ($k = 0; $k < $_GET['exams']; $k++)
{  
$sql = "INSERT INTO `exams_anosologikes` ( `PatientCode` , `ExamDate` , `AbsoluteLemf` , `AbsoluteCD4` , `PercentCD4` , `AbsoluteCD8` , `PercentCD8`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['ExamDate'.$k]."', ";
$sql .="'".replacecomma($data_array2['AbsoluteLemf'.$k])."', '".replacecomma($data_array2['AbsoluteCD4'.$k])."', '".replacecomma($data_array2['PercentCD4'.$k]);
$sql .="', '".replacecomma($data_array2['AbsoluteCD8'.$k])."', '".replacecomma($data_array2['PercentCD8'.$k])."');";
//echo $sql;
$sql = replace2null($sql);
$what_happened = execute_query($sql);
echo mysql_error();
/*
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }*/
}
/*
$sql="SELECT CD4State FROM aids_clinical_status WHERE PatientCode=".$_GET['PatientCode'];
//form_data2table($_GET);
$result=execute_query($sql);
$row=mysql_fetch_assoc($result);
if ($row['CD4State'] == "" && $_GET['AbsoluteCD40'] >= 500)
{
	echo "<p>Παρατηρήθηκε αλλαγή της κατάστασης των CD4 του ασθενή στην κατάσταση 1 (CD4 >= 500 μL).<p>";
	echo "<p><a href='change.php?code=".$_GET['PatientCode']."&state=1'>Καντε click εδώ για να καταχωρήσετε την αλλαγή</a><p>";
}
elseif (($row['CD4State'] == "" || $row['CD4State'] == "1")&& ($_GET['AbsoluteCD40'] < 500 && $_GET['AbsoluteCD40'] >= 200))
{
	echo "<p>Παρατηρήθηκε αλλαγή της κατάστασης των CD4 του ασθενή";
	if ($row['CD4State'] == "1")
	{
		echo " από την κατάσταση 1 (CD4 >= 500 μL)";
	}
	echo" στην κατάσταση 2 (200 =< CD4 < 500 μL).<p>";
	echo "<p><a href='change.php?code=".$_GET['PatientCode']."&state=2'>Καντε click εδώ για να καταχωρήσετε την αλλαγή</a><p>";
}
elseif (($row['CD4State'] == "" || $row['CD4State'] == "2") && $_GET['AbsoluteCD40'] < 200)
{
	echo "<p>Παρατηρήθηκε αλλαγή της κατάστασης των CD4 του ασθενή";
	if ($row['CD4State'] == "2")
	{
		echo " από την κατάσταση 2 (200 =< CD4 < 500 μL)";
	}
	echo" στην κατάσταση 3 (CD4 < 200 μL).<p>";
	echo "<p><a href='change.php?code=".$_GET['PatientCode']."&state=3'>Καντε click εδώ για να καταχωρήσετε την αλλαγή</a><p>";
}

echo "<p>&nbsp;</p>";
echo "<p><a href='anosologikes.php?code=".$_GET['PatientCode']."'>Καντε click εδώ για να καταχωρήσετε κι άλλη εξέταση</a></p>";
echo "<p><a href='bioximikes.php?code=".$_GET['PatientCode']."'>Καντε click εδώ για να καταχωρήσετε βιοχημικές εξετάσεις</a></p>";
*/
mysql_close($dbconnection);
perform_post_insert_actions("anosologikes", "anosologikes.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>