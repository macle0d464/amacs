<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Βιοχημικών Εξετάσεων Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
*/
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

$exams_sql = "SELECT * FROM orologikes_list";
$result = execute_query($exams_sql);
$exams = array();
for ($i=0; $i<mysql_num_rows($result); $i++)
{
	$row = mysql_fetch_assoc($result);
	$exams[$i] = $row['Code'];
}
mysql_free_result($result);

$jump2conifection = 0;

for ($i=0; $i<count($exams); $i++)
{
	if ($_GET[$exams[$i]] != "0")
	{
		$sql  = "";
		$sql .= "INSERT INTO exams_orologikes VALUES (";
		$sql .= "'".$_GET['PatientCode']."', '".join_date($_GET, $exams[$i].'Date')."', '".$exams[$i]."', ";
		$sql .= "'".$_GET[$exams[$i]]."');";
//		echo $sql."<BR>";
		execute_query($sql);
		if ((($exams[$i] == 'HBsAg') || ($exams[$i] == 'Anti-HCV')) && $_GET[$exams[$i]] == 1) 
		{
			$jump2conifection = 1;
		}
	}
}

mysql_close($dbconnection);
if ($jump2conifection)
{
	perform_post_insert_actions("exams_orologikes", "coinfection.php?code=".$_GET['PatientCode'], "");
}
else
{
	perform_post_insert_actions("exams_orologikes", "orologikes.php?code=".$_GET['PatientCode'], "");	
}
?>
</BODY></HTML>
