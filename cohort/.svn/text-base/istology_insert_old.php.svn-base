<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αιματολογικών Εξετάσεων Ασθενούς</TITLE>
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

check_patient($_GET['PatientCode']);
$data_array2['PatientCode']=$_GET['PatientCode'];
$data_array2['ExamDate']=join_date($_GET,'ExamDate');
$data_array2['System1']=$_GET['System1'];
$data_array2['System2']=$_GET['System2'];
if ($_GET['System1'] == 1)
{
	$data_array2['Score1']=$_GET['Grade1_1'];
}
else
{
	$data_array2['Score1']=$_GET['Grade1_2'];
}
if ($_GET['System2'] == 1)
{
	$data_array2['Score2']=$_GET['Grade2_1'];
}
else
{
	$data_array2['Score2']=$_GET['Grade2_2'];
}

$sql = "INSERT INTO `".$_GET['table']."` ( `PatientCode` , `ExamDate` , `System1` , `Score1` , `System2` , `Score2`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['ExamDate'];
$sql .="', '".$data_array2['System1']."', '".$data_array2['Score1']."', '".$data_array2['System2']."', '".$data_array2['Score2'];
$sql .="');";
echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }

//form_data2table($_GET);
mysql_close($dbconnection);
perform_post_insert_actions($_GET['table'], $_GET['table'].".php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
