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

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
$sql="";
echo "What the hell";
for ($i=0; $i< $_POST['comp_number']; $i++)
{
	$sql  = $_POST['comp_query_'.$i];
	$sql .= "'".$_POST['comp'.$i]."');";
	echo $sql."<BR>";
	execute_query($sql);
}

for ($i=0; $i< $_POST['number']; $i++)
{
	$sql = $_POST['query'.$i];
	echo $sql."<BR>";
	execute_query($sql);
}
echo $_POST['comp_number']."test";

mysql_close($dbconnection);
?>
<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>
</BODY></HTML>
