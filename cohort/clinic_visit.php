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

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("clinic_visit.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>
<DIV style="position: absolute; left:30px;">

<FORM id="hospitalization_form" name="hospitalization_form_form" action="hospitalization_insert.php" method="GET" onsubmit="return check_data();">
<table>
<tr>
<td><? show_patient_data($_GET['code']); ?>
<a href="show_clinic_visits.php?code=<?echo $_GET['code'];?>" target="_new">Προβολή Καταχωρήσεων</a></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<table>
<tr>
<td>
Έχει επισκεφθεί ο ασθενής κλινική: &nbsp;
<select name="Hospitalization" onchange="show_hospital(this.value);">
<option value="1">Ναι</option>
<option value="0" selected>'Οχι</option>
</select>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<table id="extra_hospital" style="display: none">
<tr>
<td>
Ημερομηνία<BR>Επίσκεψης &nbsp;&nbsp;&nbsp;
</td>
<td>
Ημέρα:
    <select name=VisitDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=VisitDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=VisitDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
<tr>
<td>
Βάρος:
</td><td>
<input name=weight size=2 maxlength=3 onkeypress="return numbersonly(event);"> (kg)
</tr>
<?
$result = execute_query($birth_year_query);
$row = mysql_fetch_array($result);
$birth_year = $row[0];
mysql_free_result($result);
$todays_date = getdate();
$year = $todays_date['year'];
if (($year - $birth_year) <= 21)
{
?>
<tr>
<td>
'Υψος:
</td><td>
<input name=height size=2 maxlength=3 onkeypress="return numbersonly(event);"> (cm)
</td>
</tr>
<? 
} ?>
<tr><td>&nbsp;</td></tr>
</table>
<input type="submit" value="Αποθήκευση Δεδομένων">
</form>
</div>

<script>
function no_typing(e)
{
	var key;
	var keychar;
	if (window.event)
	{
		key = window.event.keyCode;
	}
	else if (e)
	{
		key = e.which;
	}
	else
	{
		return true;
	}
	keychar = String.fromCharCode(key);
	// control keys
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27))
	{
		return true;
	}
	// nothing accepted
	else if ((("").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}
function show_hospital(id)
{
	if (id == 1)
	{
		document.all['extra_hospital'].style.display = "";
	}
	else if (id == 0)
	{
		document.all['extra_hospital'].style.display = "none";
	}
}

function check_data()
{
	if (document.all['Hospitalization'].value == 1)
	{
		if (document.all['EntryDate_year'].value == "")
		{
			alert("Πρέπει να επιλέξετε το έτος της εισαγωγής στο νοσοκομείο!");
			return false;
		}
		if (document.all['Diagnosis'].value == "")
		{
			alert("Πρέπει να δώσετε μια τιμή για τη διάγνωση!");
			return false;
		}		
		if (document.all['ExitDate_year'].value != "" && document.all['Ekbasi'].value == "")
		{
			alert("Πρέπει να επιλέξετε την έκβαση της εισαγωγής!");
			return false;
		}
		
	}
}

function numbersonly(e)
{
	var key;
	var keychar;
	if (window.event)
	{
		key = window.event.keyCode;
	}
	else if (e)
	{
		key = e.which;
	}
	else
	{
		return true;
	}
	keychar = String.fromCharCode(key);
	// control keys
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27))
	{
		return true;
	}
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}
</script>
</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>