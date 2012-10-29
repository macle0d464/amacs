<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$birth_year_query = "SELECT LEFT(BirthDate, 4) FROM patients WHERE PatientCode=".$_GET['code'];
?>
<HTML><HEAD>
<TITLE>Καταχώρηση Τελευταίας Κατάστασης Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<DIV style="position: absolute; left:30px;">

</DIV>
</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>