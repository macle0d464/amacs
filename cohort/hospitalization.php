<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$state_query = "SELECT * FROM hospitalization WHERE PatientCode=".$_GET['code'];
	
	$entry_id = array();
	$entry_id["XX01"] = "Χημειοθεραπεία";
	$entry_id["XX02"] = "Προγραμματισμένος έλεγχος για εξετάσεις";
	$entry_id["XX03"] = "Πυρετός - Κόπωση";
	$entry_id["XX04"] = "Διάρροιες - 'Έμετοι";
	$entry_id["XX05"] = "Αστάθεια - Ζάλη";
	$entry_id["XX06"] = "Πνευμονία";
	$entry_id["XX07"] = "'Αλλη Λοίμωξη Αναπνευστικού";	

?>
<HTML><HEAD>
<TITLE>Εισαγωγή σε νοσοκομείο</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("hospitalization.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<DIV style="position:relative; left:30px;">

<FORM id="hospitalization_form" name="hospitalization_form_form" action="hospitalization_insert.php" method="GET" onsubmit="return check_data();">
<table>
<tr>
<td><? show_patient_data($_GET['code']); ?>
<a href="show_hospitalization.php?code=<?echo $_GET['code'];?>" target="_new">Προβολή Καταχωρήσεων</a></td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<table>
<tr>
<td>
Έχει εισαχθεί ο ασθενής σε νοσοκομείο: &nbsp;
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
Ημερομηνία εισαγωγής &nbsp;&nbsp;&nbsp;
</td>
<td>
Ημέρα:
    <select name=EntryDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EntryDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EntryDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
<tr>
<tr>
<td>
Ημερομηνία εξόδου
</td><td>
Ημέρα:
    <select name=ExitDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=ExitDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=ExitDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
<tr>
<td>
Διάγνωση:
</td><td>
<select name="Diagnosis">
<option value=""> - Επιλέξτε - </option>
<option value="XX01">Χημειοθεραπεία</option>
<option value="XX02">Προγραμματισμένος έλεγχος για εξετάσεις</option>
<option value="XX03">Πυρετός - Κόπωση</option>
<option value="XX04">Διάρροιες - 'Εμετοι</option>
<option value="XX05">Αστάθεια - Ζάλη</option>
<option value="XX06">Πνευμονία</option>
<option value="XX07">'Αλλη Λοίμωξη Αναπνευστικού</option>
<option value="XX99">Αλλο (από ICD-10)</option>
</select>
<input name="DiagnosisICD" size=5 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=DiagnosisICD', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');"
onkeypress="return no_typing(event);" onfocus="this.blur();">
</tr>
<tr>
<td>
Έκβαση:
</td><td>
<select name="Ekbasi">
<!--<option value="">- Επιλέξτε -</option>-->
<option value="1">Θάνατος</option>
<option value="2">'Ιαση / Βελτίωση</option>
<option value="3">Αμετάβλητη</option>
<option value="4" selected>'Αγνωστη</option>
</select>
</td>
</tr>
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
		if (document.all['ExitDate_year'].value == "")
		{
			alert("Πρέπει να επιλέξετε το έτος της εξόδου από το νοσοκομείο!");
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
</script>
</BODY>
<div>
<hr>
<h3>Καταχωρημένα Στοιχεία</h3>
<?
$sql = "SELECT * FROM hospitalization WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_hospitalization.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
		echo "<th class=result> Ημερομηνία Εισόδου </th>";
		echo "<th class=result> Ημερομηνία Εξόδου </th>";
		echo "<th class=result> Διάγνωση </th>";
		echo "<th class=result> Έκβαση </th>";
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_start_".$j."' value='".$resultrow['EntryDate']."'>";
            echo "<input type=hidden name='del_end_".$j."' value='".$resultrow['ExitDate']."'><input type=hidden name='del_diag_".$j."' value='".$resultrow['Diagnosis']."'><input type=hidden name='del_ekb_".$j."' value='".$resultrow['Ekbasi']."'></td>\n";
				echo "<td class=result>".show_date($resultrow['EntryDate'])."</td>";
                echo "<td class=result>".show_date($resultrow['ExitDate'])."</td>";
			if ((substr($resultrow['Diagnosis'], 0, 2) == "XX") && (substr($resultrow['Diagnosis'], 2, 2) != "99"))
			{
				echo "<td class=result> ".$entry_id[$resultrow['Diagnosis']]."</td>";
			}
			else
			{
				echo "<td class=result> ".$resultrow['Diagnosis']."&nbsp; <img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code=".$resultrow['Diagnosis']."', 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/></td>";
			}	
				if ($resultrow['Ekbasi'] == 1)
				{
					echo "<td class=result>Θάνατος</td>";
				}
				else if ($resultrow['Ekbasi'] == 2)
				{
					echo "<td class=result>'Ιαση / Βελτίωση</td>";
				}
				else if ($resultrow['Ekbasi'] == 3)
				{
					echo "<td class=result>Αμετάβλητη</td>";
				}
				else
				{
					echo "<td class=result>'Αγνωστη</td>";
				}
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή'></p>";
        echo "</form>";
    }
    
mysql_free_result($result);
?>
</div>
</HTML>
<? 	
mysql_close($dbconnection); ?>