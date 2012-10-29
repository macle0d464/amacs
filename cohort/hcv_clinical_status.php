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
<TITLE>Καταχώρηση Κλινικής Κατάστασης Ασθενή με Συνλοίμωξη HCV</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("hcv_clinical_status.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hcv_coinfection($_GET['code']);
	$result = execute_query("SELECT * FROM hcv_clinical_status WHERE PatientCode=".$_GET['code']);
	$has_entry = mysql_num_rows($result);
}
?>

<DIV style="position: absolute; left:50px;">

<FORM id="hcv_clinical_status" name="hcv_clinical_status" action="hcv_clinical_status_insert.php" method="GET" onsubmit="return check_data();">
 <? show_patient_data($_GET['code']); 
echo "<input type=hidden name=has_entry value=".$has_entry.">";
if ($has_entry)
{
	$entry = mysql_fetch_assoc($result);
}
else
{
	$entry = -1;
}
mysql_free_result($result);
 ?>
	<TABLE>
<?
if (($entry == -1) || ($entry['XroniaHCV'] == 0) || ($entry['KirosiDate'] == NULL) || ($entry['NonKirosiDate'] == NULL) || ($entry['HKKDate'] == NULL) || ($entry['TransplantDate'] == NULL))
{
?>  
	<TR>
    <TD>Κλινική κατάσταση του ασθενούς</TD>
    <TD>
    <select name=State onchange="status_change(this.value);">    
    <option value="" selected> - Επιλέξτε - </option>
<?
} 
if (($entry == -1) || ($entry['XroniaHCV'] == 0))
{
?>    
    <option value="1">Χρόνια HCV λοίμωξη</option>
<?
} 
if (($entry == -1) || ($entry['KirosiDate'] == NULL))
{
?>
    <option value="2">Αντιρροπούμενη κίρρωση</option>
<?
}
if (($entry == -1) || ($entry['NonKirosiDate'] == NULL))
{
?>
    <option value="3">Μη αντιρροπούμενη κίρρωση</option>
<?
}  
if (($entry == -1) || ($entry['HKKDate'] == NULL))
{
?>
    <option value="4">HKK</option>
<?
} 
if (($entry == -1) || ($entry['TransplantDate'] == NULL))
{
?>
    <option value="5">Μεταμόσχευση ήπατος</option>
<?
} 
if (($entry == -1) || ($entry['XroniaHCV'] == 0) || ($entry['KirosiDate'] == NULL) || ($entry['NonKirosiDate'] == NULL) || ($entry['HKKDate'] == NULL) || ($entry['TransplantDate'] == NULL))
{
?> 
	</select>
	</TD>
    </TR>
<? 
} ?>    
    </table>
    <table id="extra0" style="display: none">
    <tr>
    <td>Ημερομηνία πρωτοδιάγνωσης αντιρροπούμενης κίρρωσης&nbsp;&nbsp;&nbsp;</td>
    <td>Ημέρα: 
    <select name=KirosiDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=KirosiDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=KirosiDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
    <table id="extra1" style="display: none">
    <tr>
    <td>Ημερομηνία πρωτοδιάγνωσης μη αντιρροπούμενης κίρρωσης&nbsp;&nbsp;&nbsp;</td>
    <td>Ημέρα: 
    <select name=NonKirosiDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=NonKirosiDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=NonKirosiDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
    <table id="extra2" style="display: none">
    <tr>
    <td>Ημερομηνία πρωτοδιάγνωσης ΗΚΚ&nbsp;&nbsp;&nbsp;</td>
    <td>Ημέρα: 
    <select name=ΗΚΚDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=HKKDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=HKKDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
    <table id="extra3" style="display: none">
    <tr>
    <td>Ημερομηνία διενέργειας μεταμόσχευσης ήπατος&nbsp;&nbsp;&nbsp;</td>
    <td>Ημέρα: 
    <select name=TransplantDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=TransplantDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=TransplantDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
<?
if (($entry == -1) || ($entry['XroniaHCV'] == 0) || ($entry['KirosiDate'] == NULL) || ($entry['NonKirosiDate'] == NULL) || ($entry['HKKDate'] == NULL) || ($entry['TransplantDate'] == NULL))
{
?>      
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
<?
} ?>
</FORM>
<?
if ($has_entry)
{
?>
<form method="GET" action="clinical_status_delete.php">
<input type=hidden name='code' value='<? echo $_GET['code'] ?>' />
<input type=hidden name='table' value='hcv_clinical_status' />
<h3>'Ηδη αποθηκευμένες κλινικές καταστάσεις</h3>
<table>
<th>Διαγραφή</th><th>Κλινική Κατάσταση</th><th>Ημερομηνία πρωτοδιάγνωσης</th>
<? 
if ($entry['XroniaHCV'] == 1)
{
?>
<tr>
<td align=center><input type="checkbox" name="xronia"></td><td>&nbsp;&nbsp; Χρόνια HCV Λοίμωξη &nbsp;&nbsp;</td><td align=center></td>
</tr>
<?
} 
if ($entry['KirosiDate'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="kirosi"></td><td>&nbsp;&nbsp; Αντιρροπούμενη κίρρωση &nbsp;&nbsp;</td><td align=center><? echo $entry['KirosiDate'] ?></td>
</tr>
<?
} 
if ($entry['NonKirosiDate'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="nonkirosi"></td><td>&nbsp;&nbsp; Μη αντιρροπούμενη κίρρωση &nbsp;&nbsp;</td><td align=center><? echo $entry['NonKirosiDate'] ?></td>
</tr>
<?
} 
if ($entry['HKKDate'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="hkk"></td><td>&nbsp;&nbsp; HKK &nbsp;&nbsp;</td><td align=center><? echo $entry['HKKDate'] ?></td>
</tr>
<?
} 
if ($entry['TransplantDate'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="transplant"></td><td>&nbsp;&nbsp; Μεταμόσχευση ήπατος &nbsp;&nbsp;</td><td align=center><? echo $entry['TransplantDate'] ?></td>
</tr>
<?
} ?>
</table>
<br>
<INPUT TYPE="SUBMIT" VALUE="Διαγραφή Δεδομένων">
</form>
<?
} ?>
</DIV>

<SCRIPT>
function status_change(value)
{
	if (value == 1)
	{
		document.all.extra0.style.display = 'none';
		document.all.extra1.style.display = 'none';
		document.all.extra2.style.display = 'none';
		document.all.extra3.style.display = 'none';
	}
	if (value == 2)
	{
		document.all.extra0.style.display = '';
		document.all.extra1.style.display = 'none';
		document.all.extra2.style.display = 'none';
		document.all.extra3.style.display = 'none';
	}
	if (value == 3)
	{
		document.all.extra0.style.display = 'none';
		document.all.extra1.style.display = '';
		document.all.extra2.style.display = 'none';
		document.all.extra3.style.display = 'none';
	}
	if (value == 4)
	{
		document.all.extra0.style.display = 'none';
		document.all.extra1.style.display = 'none';
		document.all.extra2.style.display = '';
		document.all.extra3.style.display = 'none';
	}
	if (value == 5)
	{
		document.all.extra0.style.display = 'none';
		document.all.extra1.style.display = 'none';
		document.all.extra2.style.display = 'none';
		document.all.extra3.style.display = '';
	}			
}

function check_data()
{
	if (document.all.State.value == "")
	{
		alert("Πρέπει να επιλέξετε μια κλινική κατάσταση για τον ασθενή!");
		return false;
	}
	else if ((document.all.State.value == "2") && (document.all.KirosiDate_year.value == ""))
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο έτος στην ημερομηνία πρωτοδιάγνωσης αντιρροπούμενης κίρρωσης!");
		return false;		
	}
	else if ((document.all.State.value == "3") && (document.all.NonKirosiDate_year.value == ""))
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο έτος στην ημερομηνία πρωτοδιάγνωσης μη αντιρροπούμενης κίρρωσης!");
		return false;		
	}	
	else if ((document.all.State.value == "4") && (document.all.HKKDate_year.value == ""))
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο έτος στην ημερομηνία πρωτοδιάγνωσης ΗΚΚ!");
		return false;		
	}
	else if ((document.all.State.value == "5") && (document.all.TransplantDate_year.value == ""))
	{
		alert("Πρέπει να δώσετε μια τιμή στο πεδίο έτος στην ημερομηνία διενέργειας μεταμόσχευσης ήπατος!");
		return false;		
	}
<?
if ($entry['KirosiDate'] == 1)
{
?>
	
<?
}
?>	
}
</SCRIPT>

</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>