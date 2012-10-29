<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$medicine_query = "SELECT * FROM hbv_other_meds";
	$reasons_query = "SELECT * FROM hbv_other_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	mysql_free_result($reason_result);
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Εργαστηριακής Εικόνας ασθενούς με HBV συνλοίμωξη</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<? 
if (isset($_GET['error']))
{
	echo "<center><table><tr><td class='errormsg'>" . $_GET['error'] . "</td></tr></table></center><br>";
}
?>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("hbv_lab.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hbv_coinfection($_GET['code']);
}
?>

<FORM id="hbv_lab_form" name="hbv_lab_form" action="hbv_lab_insert.php" method="GET" onsubmit="return check_data();">
<? show_patient_data($_GET['code']); ?>
<a href="show_lab.php?type=hbv&code=<?echo $_GET['code'];?>" target="_new">Προβολή Καταχωρήσεων Ασθενή</a>

    <TABLE width=500>
	<TR>
    <TD>Ημερομηνία Εξέτασης
    </TD>
    <TD>Ημέρα: <select name=ExamDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=ExamDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=ExamDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>ALT (IU/L)</TD>
    <TD>
    <INPUT class=input name=ALT></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>ΑST (IU/L)</TD>
    <TD>
    <INPUT class=input name=AST></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>γGT (IU/L)</TD>
    <TD>
    <INPUT class=input name=gammaGT></TD>
    </TR>
    <tr><td>&nbsp;</td><td></td></tr>
    </TABLE>

<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<script>
function _d(id)
{
	return document.getElementById(id);
}
//alert(_d("ALT").value);
function check_data()
{
	if (document.all('ExamDate_year').value == "")
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο έτος στην ημερομηνία εξέτασης!");
		return false;		
	}
	if (document.all('ExamDate_month').value == "")
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο μήνας στην ημερομηνία εξέτασης!");
		return false;		
	}
	if (document.all('ExamDate_day').value == "")
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο ημέρα στην ημερομηνία εξέτασης!");
		return false;		
	}
}
</script>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>