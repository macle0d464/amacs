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
//validate_data("exams_bioximikes", $_GET);
//$data_array2 = prepare_data("exams_bioximikes", $_GET);
//$names = array_keys($data_array2);
/*
$sql = "";
for ($k = 0; $k < $_GET['exams']; $k++)
{  
$sql = "INSERT INTO `exams_bioximikes` ( `PatientCode` , `ExamDate` , `Sakxaro` , `Xolusterini` , `HDL` , `LDL` , `Triglukeridia`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['ExamDate'.$k]."', '".$data_array2['Sakxaro'.$k];
$sql .="', '".$data_array2['Xolusterini'.$k]."', '".$data_array2['HDL'.$k]."', '".$data_array2['LDL'.$k]."', '".$data_array2['Triglukeridia'.$k]."');";
//echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }
}
*/
//form_data2table($_GET);

$exams_sql = "SELECT * FROM other_exams_list";
$result = execute_query($exams_sql);
$exams = array();
for ($i=0; $i<mysql_num_rows($result); $i++)
{
	$row = mysql_fetch_assoc($result);
	$exams[$i]['Code'] = $row['Code'];
	$exams[$i]['Unit1'] = $row['Unit1'];
	$exams[$i]['Upper1'] = $row['Upper1'];
	$exams[$i]['Lower1'] = $row['Lower1'];
	$exams[$i]['Unit2'] = $row['Unit2'];
	$exams[$i]['Upper2'] = $row['Upper2'];
	$exams[$i]['Lower2'] = $row['Lower2'];
	$exams[$i]['Unit3'] = $row['Unit3'];
	$exams[$i]['Upper3'] = $row['Upper3'];
	$exams[$i]['Lower3'] = $row['Lower3'];
	$exams[$i]['Unit4'] = $row['Unit4'];
	$exams[$i]['Upper4'] = $row['Upper4'];
	$exams[$i]['Lower4'] = $row['Lower4'];
	$exams[$i]['Unit5'] = $row['Unit5'];
	$exams[$i]['Upper5'] = $row['Upper5'];
	$exams[$i]['Lower5'] = $row['Lower5'];
}
mysql_free_result($result);

for ($i=0; $i<count($exams); $i++)
{
	if ($_GET[$exams[$i]['Code']] != "")
	{
		$sql  = "";
		$sql .= "INSERT INTO exams_other VALUES (";
		$sql .= "'".$_GET['PatientCode']."', '".join_date($_GET, 'ExamDate0')."', '".$exams[$i]['Code']."', ";
		$sql .= "'".replacecomma($_GET[$exams[$i]['Code']])."', '".replacecomma($_GET[$exams[$i]['Code'].'_Lower'])."', '".replacecomma($_GET[$exams[$i]['Code'].'_Upper'])."', '".$_GET[$exams[$i]['Code'].'_Unit']."'";
		if ($exams[$i]['Code'] == "FIBRO")
		{
			$sql .= " , 'IQR', '".replacecomma($_GET['IQR'])."'";
		}
		else
		{
			$sql .= " , NULL, NULL ";
		}
		$sql .= ");";
//		echo $sql."<BR>";
		execute_query($sql);

		$j=0;
		if ($_GET[$exams[$i]['Code'].'_Unit'] == $exams[$i]['Unit1'])
		{
			$j=1;
		}
		if ($_GET[$exams[$i]['Code'].'_Unit'] == $exams[$i]['Unit2'])
		{
			$j=2;
		}
		if ($_GET[$exams[$i]['Code'].'_Unit'] == $exams[$i]['Unit3'])
		{
			$j=3;
		}
		if ($_GET[$exams[$i]['Code'].'_Unit'] == $exams[$i]['Unit4'])
		{
			$j=4;
		}
		if ($_GET[$exams[$i]['Code'].'_Unit'] == $exams[$i]['Unit5'])
		{
			$j=5;
		}

		if ((replacecomma($_GET[$exams[$i]['Code'].'_Lower']) != $exams[$i]['Lower'.$j]) || (replacecomma($_GET[$exams[$i]['Code'].'_Upper']) != $exams[$i]['Upper'.$j]))
		{
//			echo "<BR>".$_GET[$exams[$i]['Code'].'_Lower']." != ".$exams[$i]['Lower']."<BR>".$_GET[$exams[$i]['Code'].'_Upper']." != ".$exams[$i]['Upper']."<BR>";
			$sql = "UPDATE `other_exams_list` SET Lower".$j."='".replacecomma($_GET[$exams[$i]['Code'].'_Lower'])."', Upper".$j."='".replacecomma($_GET[$exams[$i]['Code'].'_Upper'])."' WHERE Code='".$exams[$i]['Code']."'";
//			echo "<BR>$sql<BR>";
			execute_query($sql);
//			echo mysql_error();
		}
	}
}

mysql_close($dbconnection);
perform_post_insert_actions("exams_other", "other_exams.php?code=".$_GET['PatientCode'], "");
?>
</BODY></HTML>
