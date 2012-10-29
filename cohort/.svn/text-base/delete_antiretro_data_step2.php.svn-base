<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αντιρετροϊκών Θεραπείων</TITLE>
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
$sql="";

// INSERT Medicine Schemas with Compliance and Unwanted Sideeffects
for ($i=0; $i< $_POST['comp_number']; $i++)
{
 if ($_POST['comp'.$i] != "")
 {
	$sql = stripslashes($_POST['comp_query_'.$i]);
	$sql .= "'".$_POST['comp'.$i]."', '".$_POST['Reason1_'.$i]."', '".$_POST['Reason2_'.$i]."', ";
	$sql .= "'".$_POST['Note'.$i]."');";
//	echo $sql."<BR>";
	$what_happened = execute_query($sql);
	if ($what_happened == 1)
    {
//        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
	else
    {
//        echo "<P>$what_happened</P>";
    }
 }
}

	session_start();
	session_unregister("antiretro_startdate");
	$sql = "SELECT StartDate FROM antiretro_treatments WHERE PatientCode=".$_GET['code']." GROUP BY StartDate";
	$result = execute_query($sql);
	if (mysql_num_rows($result) == 0)
	{
		$_SESSION['antiretro_startdate'] = "3000-01-01";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		$_SESSION['antiretro_startdate'] = $row['StartDate'];
	}
	mysql_free_result($result);

mysql_close($dbconnection);
perform_post_insert_actions("", "fix_antiretro.php?code=".$_POST['code'], "");
//perform_post_insert_actions("", "antiretro.php?code=".$_POST['code'], "");
?>
<p><a href="javascript:location.href = 'antiretro.php?code=<?echo $_POST['code']?>';">Καντε click εδώ για να εισάγετε και άλλα δεδομένα αντιρετροϊκών θεραπειών </a></p>
</BODY></HTML>
