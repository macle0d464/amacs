<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
?>

<HTML><HEAD>
<TITLE>���������� ���������� ��������� ��������</TITLE>
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


$exams_sql = "SELECT * FROM laboratory_codes";
$result = execute_query($exams_sql);
$exams = array();
for ($i=0; $i<mysql_num_rows($result); $i++)
{
	$row = mysql_fetch_assoc($result);
	$exams[$i] = $row['Code'];
}
mysql_free_result($result);

for ($i=0; $i<count($exams); $i++)
{
		$sql  = "";
		$sql .= "UPDATE laboratory_codes SET `Upper1`='".$_GET[$exams[$i].'_Upper1']."', `Lower1`='".$_GET[$exams[$i].'_Lower1']."', ";
		$sql .= "`Upper2`='".$_GET[$exams[$i].'_Upper2']."', `Lower2`='".$_GET[$exams[$i].'_Lower2']."', ";
		$sql .= "`Upper3`='".$_GET[$exams[$i].'_Upper3']."', `Lower3`='".$_GET[$exams[$i].'_Lower3']."', ";
		$sql .= "`Upper4`='".$_GET[$exams[$i].'_Upper4']."', `Lower4`='".$_GET[$exams[$i].'_Lower4']."', ";
		$sql .= "`Upper5`='".$_GET[$exams[$i].'_Upper5']."', `Lower5`='".$_GET[$exams[$i].'_Lower5']."', ";						
		$sql .= "`Unit1`='".$_GET[$exams[$i].'_Unit1']."', `Unit2`='".$_GET[$exams[$i].'_Unit2']."', ";
		$sql .= "`Unit3`='".$_GET[$exams[$i].'_Unit3']."', `Unit4` ='".$_GET[$exams[$i].'_Unit4']."', ";
		$sql .= "`Unit5`='".$_GET[$exams[$i].'_Unit5']."' WHERE `Code`='".$exams[$i]."'";
//		echo $sql."<BR>";
		execute_query($sql);
//		echo mysql_error();
	
}
$result = execute_query("SELECT * FROM setup");
if (mysql_num_rows($result)>0)
{
	execute_query("UPDATE setup SET Value='".$_GET['Clinic']."' WHERE Setting='Clinic'");
}
else 
{
	execute_query("INSERT INTO setup VALUES('clinic', '".$_GET['Clinic']."')");
}

mysql_close($dbconnection);
perform_post_insert_actions("exams_bioximikes", "setup.php", "");
?>
</BODY></HTML>
