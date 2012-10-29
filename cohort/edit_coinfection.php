<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$coinfections = "SELECT * FROM coinfections WHERE PatientCode=".$_GET['code'];
?>
<HTML><HEAD>
<TITLE>Καταχώρηση Συλλοιμώξεων Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("coinfection.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<DIV style="position: absolute; left:50px;">

<FORM id="coinfection_form" name="coinfection_form" action="coinfection_insert.php" method="GET" onsubmit="return checkdata();">
<TABLE>
    <TR>
    <TD><b> <? show_patient_data($_GET['code']); ?></b> </TD>
    <TD></TD>
    </TR>
</TABLE>
<?
$result = execute_query($coinfections);
if (mysql_num_rows($result) <> 0)
{
$row = mysql_fetch_assoc($result);
}

	if ($_GET['type'] == 'hbv' && $row['HBV'] == '1')
	{
?>
<P>Αλλαγή στοιχείων HBV συλλοίμωξης: 
 <div id=hbvextra>
 <input type=hidden name="HBV" value="1">
 Γονότυπος:
  <select name="HBVGenotype1">
 <option value=""></option>
 <option value="A">A</option>
 <option value="B">B</option>
 <option value="C">C</option>
 <option value="D">D</option>
 <option value="E">E</option>
 <option value="F">F</option>
 <option value="G">G</option>
 <option value="H">H</option>
 </select>
 <select name="HBVGenotype2" style="display:none">
 <option value=""></option>
 </select>
 &nbsp;&nbsp; <b>ή</b> &nbsp;&nbsp; Ανασυνδυασμένος: <input name=HBVGenotype_combination>
 </p><p>
 Ημερομηνία πρώτης διάγνωσης &nbsp;&nbsp;
 Ημέρα: <select name="HBVDate_day"><option value="" selected><? print_options(31); ?></option></select>
 Μήνας: <select name="HBVDate_month"><option value="" selected><? print_options(12); ?></option></select>
 Έτος: <select name="HBVDate_year"><option value="" selected><? print_years(); ?></option></select>
 </div>
 </P>
<?
	}
//	if ($row['HBV'] == '1' && $row['HCV'] == '1')
//	{	
//		echo "<hr>";
//	}
	if ($_GET['type'] == 'hcv' && $row['HCV'] == '1')
	{
?>

<P>Αλλαγή στοιχείων HCV συλλοίμωξης: 
 <div id=hcvextra>
 <input type=hidden name="HCV" value="1">
 Γονότυπος: 
 <select name="HCVGenotype1">
 <option value=""></option>
 <option value="1">1</option>
 <option value="2">2</option>
 <option value="3">3</option>
 <option value="4">4</option>
 <option value="5">5</option>
 <option value="6">6</option>
 <option value="7">7</option>
 <option value="8">8</option>
 <option value="9">9</option>
 <option value="10">10</option>
 <option value="11">11</option>
 <? //print_options(11); ?>
 </select>
 <select name="HCVGenotype2">
 <option value=""></option>
 <option value="a">a</option>
 <option value="b">b</option>
 <option value="c">c</option>
 <option value="d">d</option>
 <option value="e">e</option>
 <option value="f">f</option>
 <option value="g">g</option>
 <option value="h">h</option>
 <option value="j">j</option>
 <option value="k">k</option>
 </select>
 &nbsp;&nbsp; <b>ή</b> &nbsp;&nbsp; Ανασυνδυασμένος: <input name=HCVGenotype_combination>
 </p><p>
 Ημερομηνία πρώτης διάγνωσης  &nbsp;&nbsp;
 Ημέρα: <select name="HCVDate_day"><option value="" selected><? print_options(31); ?></option></select>
 Μήνας: <select name="HCVDate_month"><option value="" selected><? print_options(31); ?></option></select>
 Έτος: <select name="HCVDate_year"><option value="" selected><? print_years(); ?></option></select>
 </div>
 </select></P>
<?
	}	
?>
<br>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<script>
function checkdata()
{
<? if ($_GET['type'] == 'hbv' && $row['HBV'] == "1") {?>	
//	if (document.all.HBV.value == 1)
//	{
		if (document.all.HBVDate_year.value == "")
		{
			alert("Πρέπει να δώσετε μια τιμή για το έτος στην ημερομηνία πρώτης διάγνωσης HBV");
			return false;
		}
		if ((!document.all.hbvgono1.checked) && (!document.all.hbvgono2.checked))
		{
			alert("Πρέπει να επιλέξετε τον γονότυπο της HBV!");
			return false;
		}
//	}
<? }
if ($_GET['type'] == 'hcv' && $row['HCV'] == "1") { ?>
//	if (document.all.HCV.value == 1)
//	{
		if (document.all.HCVDate_year.value == "")
		{
			alert("Πρέπει να δώσετε ημερομηνία για το έτος στην ημερομηνία πρώτης διάγνωσης HCV");
			return false;
		}
		if ((document.all.HCVGenotype1.value == "") && (document.all.HCVGenotype2.value != ""))
		{
			alert("Ο γονότυπος για HCV δεν έχει συμπληρωθεί σωστά!");
			return false;
		}		
//	}
<? } ?>
}
</script>
</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>