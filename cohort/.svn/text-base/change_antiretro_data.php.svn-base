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

if ($_GET['EndDate_year'] == '')
{
	$enddate = "3000-01-01";
}
else
{
	$enddate = join_date($_GET, 'EndDate');
}

$start = join_date($_GET, 'StartDate');

// Check for overlaps

$sql = "SELECT * FROM antiretro_treatments_compliance WHERE StartDate!='".$_GET['start']."' AND ((EndDate>'".$start."' AND EndDate<='".$enddate."') OR  (StartDate<='".$start."' AND EndDate>='".$enddate."') OR (StartDate<'".$enddate."' AND EndDate>='".$enddate."')) AND PatientCode=".$_GET['code'];
//echo $sql;
$result = execute_query($sql);
if (mysql_num_rows($result) > 0)
{
	$temp_row = mysql_fetch_assoc($result);
	$eschema = $temp_row['Schema'];
	$start2 = $temp_row['StartDate'];
	$end2 = $temp_row['EndDate'];
	echo "<div class='img-shadow'>";
	echo "<p style='display: block; border: 1px solid red'>";
	echo "<BR> <b>Πρόβλημα</b> στην καταχώρηση <b>".$schema."</b><BR>";
	echo "Υπάρχει ήδη εγγραφή των φαρμάκων <b>$eschema</b> με ημερομηνία έναρξης ".$start2;
	if ($end2 == '3000-01-01')
	{
		echo " και ανοιχτή ημερομηνία λήξης";
	}
	else
	{
		echo " και ημερομηνία λήξης ".$end2;
	}
	echo "<BR> και θέλετε να καταχωρήσετε <b>$schema</b> με ημερομηνία έναρξης ".$start;
	if ($enddate == '3000-01-01')
	{
		echo " και ανοιχτή ημερομηνία λήξης";
	}
	else
	{
		echo " και ημερομηνία λήξης ".$enddate;
	}
	echo "</div></p>";

	echo "<br><br><br><br><br><br>";
	echo "<div class='img-shadow'>";
	show_errormsg("");
	echo "</div>";
}
mysql_free_result($result);

$sql  = "UPDATE antiretro_treatments_compliance SET Compliance='".$_GET['Compliance']."', Reason1='".$_GET['Reason1']."', Reason2='".$_GET['Reason2']."', Notes='".$_GET['Notes']."', EndDate='$enddate', StartDate='".join_date($_GET, 'StartDate')."' ";
$sql .= "WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."'";
execute_query($sql);

execute_query("UPDATE antiretro_treatments SET EndDate='$enddate', StartDate='".join_date($_GET, 'StartDate')."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."'");

perform_post_insert_actions("","show_antiretro_data?code=".$_GET['code'],"");

mysql_close($dbconnection);
?>
</BODY></HTML>
