<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$reasons_query = "SELECT * FROM hbv_other_reasons GROUP BY ID";
?>

<HTML><HEAD>
<TITLE>Λόγοι Διακοπής Θεραπείων HBV</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
<script>
function returnReason(number)
{
window.opener.document.all.<? echo $_GET['field'] ?>.value = number;
}
</script>
</HEAD>

<TABLE>
<?
$result = execute_query($reasons_query);
$num = mysql_num_rows($result);
for ($i=0; $i<$num; $i++)
{
	$row = mysql_fetch_assoc($result);
	echo "<tr>\n";
	echo "<td>".$row['ID'].". </td>\n";
	echo "<td><a href='#' onclick='javascript:returnReason(".$row['ID'].")'>".$row['Reason']."</a></td>\n";
	echo "</tr>\n";
}
mysql_free_result($result);
?>
</TABLE>
<p align=center><input type=button value="Κλείσιμο Παραθύρου" onclick="window.close();"></p>
</BODY></HTML>