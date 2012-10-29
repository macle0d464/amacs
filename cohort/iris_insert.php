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
//print_r($_GET);
//print_r($data_array2);

if ($_GET['EndDate_year'] == "")
{
	$enddate = "0000-00-00";
}
else 
{
	$enddate = join_date($_GET, 'EndDate');
}	

$sql = "";
$sql = "INSERT INTO `iris` ( `PatientCode` , `StartDate` , `EndDate` , `What` , `Type` , `Antimetopisi`)";
$sql .= " VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'StartDate');
$sql .="', '".$enddate."', '".$_GET['What']."', '".$_GET['Type']."', '".$_GET['Antimetopisi'];
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

echo mysql_error();
//form_data2table($_GET);
mysql_close($dbconnection);
perform_post_insert_actions("iris", "iris.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
