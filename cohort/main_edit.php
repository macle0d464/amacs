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
	$entry_query = "SELECT Height FROM clinic_visits WHERE Height!=NULL AND PatientCode=".$_GET['code'];	
?>
<HTML><HEAD>
<TITLE>Καταχώρηση Επίσκεψης Ασθενή σε Κλινική</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("demographic.php");
	die();
}
else
{
	check_patient($_GET['code']);
	session_start();
	$_SESSION['PatientCode'] = $_GET['code'];
	$sql = "SELECT StartDate FROM antiretro_treatments WHERE PatientCode=".$_GET['code']." GROUP BY StartDate";
	$result = execute_query($sql);
	if (mysql_num_rows($result) == 0)
	{
		$_SESSION['antiretro_startdate'] = "3000-01-01";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		$_SESSION['antiretro_startdate'] = $row['StartDate'];
	}
	mysql_free_result($result);
}
?>

<DIV style="position: absolute; left:30px;">

<FORM id="clinics_form" name="clinics_form" action="main_edit_insert.php" method="GET" onsubmit="return check_data();">
	<input name=PatientCode value="<? echo $_GET['code']; ?>" type=hidden />
	<input name=visitdate value="<? echo $_GET['dateofvisit']; ?>" type=hidden />
	<input name=clinicid value="<? echo $_GET['clinic']; ?>" type=hidden />
<table>
<tr>
<td>
<? 
show_patient_data($_GET['code']); 
?>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<?
	
	$sql = "SELECT * FROM clinic_visits WHERE PatientCode='".$_GET['code']."' AND Clinic='".$_GET['clinic']."' AND DateOfVisit='".$_GET['dateofvisit']."';";
	$result = execute_query($sql);
	echo mysql_error();
	$datarow = mysql_fetch_assoc($result);
	mysql_free_result($result);
?>

<table id="extra_form">
<tr>
<td>
Ημερομηνία Επίσκεψης &nbsp;&nbsp;
</td>
<td>
Ημέρα:
    <select name=DateOfVisit_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=DateOfVisit_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=DateOfVisit_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
</tr>
<tr>
    <TD>Κλινική: </TD>
    <TD>
        <SELECT name=Clinic>
        <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
	$clinics_query = "SELECT * FROM clinics";
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
?>
		<OPTION value='<? echo $j ; ?>' onclick="document.getElementById('OtherClinic').style.visibility='hidden';"> <? echo $value ;?> </OPTION>";
<?
	}
	mysql_free_result($results);
?>
		<option value="99" onclick="document.getElementById('OtherClinic').style.visibility='';"> 'Αλλη Κλινική (παρακαλώ συμπληρώστε) </option>              
        </SELECT> 
		<input name=OtherClinic id=OtherClinic size=50 style="visibility: hidden" />
		</TD>
</tr>
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
$result = execute_query($entry_query);
if (mysql_num_rows($result) >0)
{
	$has_entry = 1;
}
else
{
	$has_entry = 0;
}
mysql_free_result($result);
$todays_date = getdate();
$year = $todays_date['year'];
if ((($year - $birth_year) <= 21) || !$has_entry)
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
<tr>
<td>
Κάπνισμα
</td>
<td>
'Εχουν αλλάξει οι καπνιστικές συνήθειες του ασθενούς: 
<select name=habit>
<option value=0 onclick="document.getElementById('Smoking').style.visibility='hidden';"> OXI </option>
<option value=1 onclick="document.getElementById('Smoking').style.visibility='';"> NAI </option>
</select>
<select name="Smoking" id="Smoking" style="visibility: hidden">
<option value="-1" selected> 'Αγνωστο </option>
<option value="0">'Οχι - Ποτέ καπνιστής</option>
<option value="1">Πρώην καπνιστής (όχι το τελευταίο 6μηνο)</option>
<option value="2">Ενεργός καπνιστής</option>
</select>
</td>
</tr>
<tr>
<td>
Κατάχρηση Αλκοόλ<BR><b>(>50 gr/ημέρα)</b> &nbsp;&nbsp;
</td>
<td>
<select name=Alcohol>
<option value="0">ΟΧΙ</option>
<option value="1">ΝΑΙ</option>
</select>
</td>
</tr>
<tr>
<td>
Αρτηριακή Πίεση
</td>
<td>
ΣΑΔ <input name=sad size=4 /> mmHg<br>
ΔΑΠ <input name=dap size=4 /> mmHg
</td>
</tr>
<tr>
<td>
Χρήστης Ουσιών &nbsp; <select name=DrugUser>
<option value="-1" onclick="document.getElementById('extra_drug').style.visibility='hidden';"> - </option>
<option value="0" onclick="document.getElementById('extra_drug').style.visibility='hidden';">ΟΧΙ</option>
<option value="1" onclick="document.getElementById('extra_drug').style.visibility='';">NAI</option>
</select> 
</td>
<td>
<span id=extra_drug style="visibility: hidden">
<table>
<tr>
<td>Ηρωίνη</td>
<td>
<select name=heroin>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
<tr>
<td>Χασίς</td>
<td>
<select name=hash>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
<tr>
<td>Κοκαΐνη</td>
<td>
<select name=cocain>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
<tr>
<td>'Αλλο: Όνομα <input name=other_drug_name size=10 /></td>
<td>
<select name=otherdrug>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
</table>
</span>
</td>
</tr>
<?
$result = execute_query("SELECT Lipoatrofia, Enapothesi FROM atomiko_anamnistiko WHERE PatientCode=".$_GET['code']);
if (mysql_num_rows($result) == 0)
{
	$lipoatrofia = 0;
	$enapothesi = 0;
}
else 
{
	$row = mysql_fetch_array($result);
	$lipoatrofia = $row[0];
	$enapothesi = $row[1];
}
mysql_free_result($result);
if ($lipoatrofia)
{
?>
<tr>
<td>
Λιποατροφία
</td>
<td>
<select name=Lipoatrofia>
<option value="1">Στασιμότητα</option>
<option value="2">Καλυτέρευση</option>
<option value="3">Επιδείνωση</option>
</select>
</td>
</tr>
<tr>
<?
}
if ($enapothesi)
{
?>
<td>
Εναπόθεση
</td>
<td>
<select name=Enapothesi>
<option value="1">Στασιμότητα</option>
<option value="2">Καλυτέρευση</option>
<option value="3">Επιδείνωση</option>
</select>
</td>
</tr>
<?
}
?>
<tr><td>&nbsp;</td></tr>
</table>
<input type="submit" value="Αποθήκευση Δεδομένων">
</form>

<script>
function toggle_entries()
{
	if (document.all.entries.style.display == "none")
	{
		document.all.entries.style.display == "";
	}
	else
	{
		document.all.entries.style.display == "none";
	}
}
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
function show_form(id)
{
	if (id == 1)
	{
		document.all['extra_form'].style.display = "";
	}
	else if (id == 0)
	{
		document.all['extra_form'].style.display = "none";
	}
}

function check_data()
{
	if (document.all['height'].value != "")
	{
		if (document.all['height'].value <10 || document.all['height'].value >250)
		{
			alert("Το ύψος πρέπει να είναι μεταξύ 10 και 250 cm!");
			return false;
		}
	}
	if (document.all['weight'].value != "")
	{	
		if (document.all['weight'].value >250)
		{
			alert("Το βάρος δεν μπορεί να είναι πάνω από 250 kg!");
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

<? 
print_stored_date('DateOfVisit', $datarow);
print_stored_data('Clinic', $datarow);
print_stored_data2('height', $datarow['Height']);
print_stored_data2('weight', $datarow['Weight']);
if ($datarow['Smoking'] != "")
{
?>
	document.getElementById('Smoking').style.visibility='';
<?
	print_stored_data('Smoking', $datarow);
}
print_stored_data('Alcohol', $datarow);
print_stored_data2('sad', $datarow['PressureSystolic']);
print_stored_data2('dap', $datarow['PressureDiastolic']);
print_stored_data2('DrugUser', $datarow['DrugUser']);
if ($datarow['DrugUser'] == '1')
{
?>
	document.getElementById('extra_drug').style.visibility='';
<?
}
print_stored_data2('heroin', $datarow['Heroin']);
print_stored_data2('cocain', $datarow['Cocaine']);
print_stored_data2('hash', $datarow['Hash']);	
print_stored_data2('other_drug_name', $datarow['OtherDrugName']);
print_stored_data2('otherdrug', $datarow['OtherDrugValue']);
if ($lipoatrofia)
{
	print_stored_data('Lipoatrofia', $datarow);
}
if ($enapothesi)
{
	print_stored_data('Enapothesi', $datarow);
}

?>


//		document.all['Clinic'].value = 5;

</script>

</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>