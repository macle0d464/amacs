<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Εκτέλεση QUERY</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
//require_once 'Text/Highlighter.php';

	$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
	$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
	if (!$db_selected) {
   		die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
	}
	$sql_query = stripslashes($_GET['query']);
//	$highlightSQL =& Text_Highlighter::factory('SQL',array('numbers'=>true));
//	echo "Executed QUERY : ";
//	echo $sql_query;
	$sql_query = replace2quote($sql_query);
	$sql_query = str_replace("gr-day=''", "gr-day IS NULL", $sql_query);
	$sql_query = str_replace("StartDate=''", "StartDate IS NULL", $sql_query);
	$sql_query = str_replace("EndDate=''", "EndDate IS NULL", $sql_query);
	$sql_query = str_replace("OtherNosima=''", "OtherNosima IS NULL", $sql_query);
//	echo $sql_query;
	
//	echo "<BR><BR>";
	$results = execute_query($sql_query);
//	echo mysql_error();
//	print_r($results);
//	echo "<BR><BR>";
/*	
	if ($results == "1")
	{
		echo "<table><tr><td>Query Successful!</td></tr></table>";
	}
	else
	{
		query2table($results);
		$result2 = execute_query($sql_query);
		query2xls($result2, 'query.xls');
		$result3 = execute_query($sql_query);
		query2csv($result3, 'query.csv');
?>
<P><A HREF="query.xls">Αποτελέσματα σε Excel</A></P>
<P><A HREF="query.csv">Αποτελέσματα σε CSV</A></P>
<?
	}
*/	
	perform_post_insert_actions("", $_GET['table']."?code=".$_GET['code'], "");
	mysql_close($dbconnection);
?>
