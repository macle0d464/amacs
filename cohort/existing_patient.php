<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

?>

<HTML><HEAD>
<TITLE>������� �������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<form name=patient_select_form action=intermediate.php method="GET">
<p>����� ��� ������ ��� ������ ��� ����� �� ��������������: 
<input name=code size=10 maxlength="10">
<input type="submit" style="border: 1px outset;" value="�������">
</p>
</form>
<hr>
<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
 ������ ������� ������</h2>

<iframe src=find_patient.php frameborder="0" width=1000 height=485 />
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>