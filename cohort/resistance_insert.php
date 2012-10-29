<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ιολογικών Εξετάσεων</TITLE>
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

	$meds_sql = "SELECT ATCCode FROM medicines m";
	$result = execute_query($meds_sql);
	$atccodes = array();
	for ($i=0; $i<mysql_num_rows($result); $i++)
	{
		$row = mysql_fetch_object($result);
		$atccodes[$i] = $row->ATCCode;
	}
	mysql_free_result($result);

// INSERT Mutations

for ($i=1; $i<$_GET['PRO_mutations']+1; $i++)
{
	$sql = "INSERT INTO `hiv_resistance_mutations` VALUES('".$_GET['PatientCode']."', '".$_GET['SampleID']."', ";
	$sql .= "'".join_date($_GET, 'SeqDate')."', 'PRO', ";
	$sql .= "'".$_GET['PRO_'.$i.'_1']."', '".$_GET['PRO_'.$i.'_2']."', '".$_GET['PRO_'.$i.'_3']."')";
	if ($_GET['PRO_'.$i.'_1'] != "")
	{
		execute_query($sql);	
	}
}

for ($i=1; $i<$_GET['RT_mutations']+1; $i++)
{
	$sql = "INSERT INTO `hiv_resistance_mutations` VALUES('".$_GET['PatientCode']."', '".$_GET['SampleID']."', ";
	$sql .= "'".join_date($_GET, 'SeqDate')."', 'RT', ";
	$sql .= "'".$_GET['RT_'.$i.'_1']."', '".$_GET['RT_'.$i.'_2']."', '".$_GET['RT_'.$i.'_3']."')";
	if ($_GET['RT_'.$i.'_1'] != "")
	{
		execute_query($sql);	
	}
}

for ($i=1; $i<$_GET['GP41_mutations']+1; $i++)
{
	$sql = "INSERT INTO `hiv_resistance_mutations` VALUES('".$_GET['PatientCode']."', '".$_GET['SampleID']."', ";
	$sql .= "'".join_date($_GET, 'SeqDate')."', 'GP41', ";
	$sql .= "'".$_GET['GP41_'.$i.'_1']."', '".$_GET['GP41_'.$i.'_2']."', '".$_GET['GP41_'.$i.'_3']."')";
	if ($_GET['GP41_'.$i.'_1'] != "")
	{
		execute_query($sql);	
	}
}

for ($i=1; $i<$_GET['GP120_mutations']+1; $i++)
{
	$sql = "INSERT INTO `hiv_resistance_mutations` VALUES('".$_GET['PatientCode']."', '".$_GET['SampleID']."', ";
	$sql .= "'".join_date($_GET, 'SeqDate')."', 'GP120', ";
	$sql .= "'".$_GET['GP120_'.$i.'_1']."', '".$_GET['GP120_'.$i.'_2']."', '".$_GET['GP120_'.$i.'_3']."')";
	if ($_GET['GP120_'.$i.'_1'] != "")
	{
		execute_query($sql);	
	}
}

// INSERT Medicine Resistance

for ($i=0; $i<count($atccodes); $i++)
{
	if ($_GET['Score_'.$atccodes[$i]] != "-")
	{
		$score = $_GET['Score_'.$atccodes[$i]];
		if (isset($_GET['Boosting_'.$atccodes[$i]]) && $_GET['Boosting_'.$atccodes[$i]] == "on")
		{
			$boosting = '1';
		}
		else
		{
			$boosting = '0';
		}
		$sql = "INSERT INTO `hiv_resistance_meds` VALUES('".$_GET['PatientCode']."', '".$_GET['SampleID']."', ";
		$sql .= "'".join_date($_GET, 'SeqDate')."', '".$atccodes[$i]."', '".$boosting."', '".$_GET['Score_'.$atccodes[$i]]."')";
		execute_query($sql);	
	}
}

// INSERT Extra Data

$sql = "INSERT INTO `hiv_resistance` VALUES('".$_GET['PatientCode']."', '".$_GET['SampleID']."', ";
$sql .= "'".join_date($_GET, 'SampleDate')."', '".join_date($_GET, 'SeqDate')."', '".$_GET['Lab']."', '".$_GET['Algorithm']."',  ";
$sql .= "'".$_GET['TestType']."')";
//echo $sql;
$what_happened = execute_query($sql);
echo mysql_error();



mysql_close($dbconnection);
perform_post_insert_actions("hiv_subtype", "hiv_resistance.php?code=".$_GET['PatientCode'], "");

?>

</BODY></HTML>
