<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$state_query = "SELECT * FROM last_state WHERE PatientCode=".$_GET['code'];
	$result = execute_query($state_query);
	$has_entry = mysql_num_rows($result);
	$resultrow = mysql_fetch_assoc($result);
?>

<HTML><HEAD>
<TITLE>Υπάρχων Ασθενής</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<DIV style="position: absolute; left:30px;">

<FORM id="last_state_form" name="last_state_form" action="last_state_insert.php" method="GET" onsubmit="return check_data();">
<? show_patient_data($_GET['code']); ?>
<?	session_start();
	$_SESSION['PatientCode'] = $_GET['code'];
?>
	
<h2><font color=red>Για τον ασθενή <?echo $_GET['code']?> δεν έχει γίνει ενημέρωση των κλινικών επισκέψεων εδώ και 1 χρόνο<BR>
Παρακαλώ καταχωρήστε την τελευταία κατάσταση του ασθενούς.</font></h2>

<table>
<tr>
<td>
Κατάσταση ατόμου: &nbsp;
<select name="LastState" onchange="show_extra(this.value);">
<option value="" selected>- Επιλέξτε -</option>
<option value="1">Εν ζωή</option>
<option value="2">Απεβίωσε</option>
<option value="3">Lost to Follow Up</option>
</select>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>
<div id="death_extra" style="display: none">
<table>
<tr>
<td>
Ημερομηνία θανάτου &nbsp;
</td>
<td>
Ημέρα:
    <select name=DeathDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=DeathDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=DeathDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
<tr>
<td>
'Αμεση (Immediate) Αιτία θανάτου: &nbsp;&nbsp;
</td><td>
<select name="Immediate" onchange="show_other(this.value, 'othercause1');">
<option value=""> - Επιλέξτε -</option>
<option value="01">01 AIDS (ongoing active disease)</option>
<option value="01.1">01.1 Infection</option>
<option value="01.2">01.2 Malignancy</option>
<option value="02">02 Infection (other than 01.1)</option>
<option value="02.1">02.1 Bacterial</option>
<option value="02.1.1">02.1.1 Bacterial with sepsis</option>
<option value="02.2">02.2 Others</option>
<option value="02.2.1">02.2.1 Other with sepsis</option>
<option value="02.3">02.3 Unknown aetiology</option>
<option value="02.3.1">02.3.1 Unknown with sepsis</option>
<option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
<option value="03.1">03.1 HCV</option>
<option value="03.1.1">03.1.1 HCV with cirrhosis</option>
<option value="03.1.2">03.1.2 HCV with liver failure</option>
<option value="03.2">03.2 HBV</option>
<option value="03.2.1">03.2.1 HBV with cirrhosis</option>
<option value="03.2.2">03.2.2 HBV with liver failure</option>
<option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
<option value="05">05 Diabetes Mellitus (complication to)</option>
<option value="06">06 Pancreatitis</option>
<option value="07">07 Lactic acidosis</option>
<option value="08">08 MI or other ischemic heart disease</option>
<option value="09">09 Stroke</option>
<option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
<option value="11">11 Primary pulmonary hypertension</option>
<option value="12">12 Lung embolus</option>
<option value="13">13 Chronic obstructive lung disease</option>
<option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
<option value="15">15 Renal failure</option>
<option value="16">16 Accident or other violent death (not suicide)</option>
<option value="17">17 Suicide</option>
<option value="18">18 Euthanasia</option>
<option value="19">19 Substance abuse (active)</option>
<option value="19.1">19.1 Chronic Alcohol abuse</option>
<option value="19.2">19.2 Chronic intravenous drug-use</option>
<option value="19.3">19.3 Acute intoxication (indicate agent)</option>
<option value="20">20 Haematological disease (other causes)</option>
<option value="21">21 Endocrine disease (other causes)</option>
<option value="22">22 Psychiatric disease (other causes)</option>
<option value="23">23 CNS disease (other causes)</option>
<option value="24">24 Heart or vascular (other causes)</option>
<option value="25">25 Respiratory disease (other causes)</option>
<option value="26">26 Digestive system disease (other causes)</option>
<option value="27">27 Skin and motor system disease (other causes)</option>
<option value="28">28 Urogenital disease (other causes)</option>
<option value="29">29 Obstetric complications</option>
<option value="30">30 Congenital disorders</option>
<option value="90">90 Other causes</option>
<option value="91">91 Unclassifiable causes</option>
<option value="92">92 Unknown</option>
</select>
<BR>
'Αλλη αιτία:
<input name=othercause1 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=othercause1', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause1.value, 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
?>
</td>
</tr>
<tr><td>&nbsp;</td></td><td></tr>
<tr>
<td>
Contributing Αιτία θανάτου:
</td><td>
<select name="Contributing1" onchange="show_other(this.value, 'othercause1');">
<option value=""> - Επιλέξτε -</option>
<option value="01">01 AIDS (ongoing active disease)</option>
<option value="01.1">01.1 Infection</option>
<option value="01.2">01.2 Malignancy</option>
<option value="02">02 Infection (other than 01.1)</option>
<option value="02.1">02.1 Bacterial</option>
<option value="02.1.1">02.1.1 Bacterial with sepsis</option>
<option value="02.2">02.2 Others</option>
<option value="02.2.1">02.2.1 Other with sepsis</option>
<option value="02.3">02.3 Unknown aetiology</option>
<option value="02.3.1">02.3.1 Unknown with sepsis</option>
<option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
<option value="03.1">03.1 HCV</option>
<option value="03.1.1">03.1.1 HCV with cirrhosis</option>
<option value="03.1.2">03.1.2 HCV with liver failure</option>
<option value="03.2">03.2 HBV</option>
<option value="03.2.1">03.2.1 HBV with cirrhosis</option>
<option value="03.2.2">03.2.2 HBV with liver failure</option>
<option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
<option value="05">05 Diabetes Mellitus (complication to)</option>
<option value="06">06 Pancreatitis</option>
<option value="07">07 Lactic acidosis</option>
<option value="08">08 MI or other ischemic heart disease</option>
<option value="09">09 Stroke</option>
<option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
<option value="11">11 Primary pulmonary hypertension</option>
<option value="12">12 Lung embolus</option>
<option value="13">13 Chronic obstructive lung disease</option>
<option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
<option value="15">15 Renal failure</option>
<option value="16">16 Accident or other violent death (not suicide)</option>
<option value="17">17 Suicide</option>
<option value="18">18 Euthanasia</option>
<option value="19">19 Substance abuse (active)</option>
<option value="19.1">19.1 Chronic Alcohol abuse</option>
<option value="19.2">19.2 Chronic intravenous drug-use</option>
<option value="19.3">19.3 Acute intoxication (indicate agent)</option>
<option value="20">20 Haematological disease (other causes)</option>
<option value="21">21 Endocrine disease (other causes)</option>
<option value="22">22 Psychiatric disease (other causes)</option>
<option value="23">23 CNS disease (other causes)</option>
<option value="24">24 Heart or vascular (other causes)</option>
<option value="25">25 Respiratory disease (other causes)</option>
<option value="26">26 Digestive system disease (other causes)</option>
<option value="27">27 Skin and motor system disease (other causes)</option>
<option value="28">28 Urogenital disease (other causes)</option>
<option value="29">29 Obstetric complications</option>
<option value="30">30 Congenital disorders</option>
<option value="90">90 Other causes</option>
<option value="91">91 Unclassifiable causes</option>
<option value="92">92 Unknown</option>
</select>
<BR>
'Αλλη αιτία:
<input name=othercause2 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=othercause2', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause2.value, 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
?>
</td>
</tr>
<tr><td>&nbsp;</td></td><td></tr>
<tr>
<td>
Contributing Αιτία θανάτου:
</td><td>
<select name="Contributing2" onchange="show_other(this.value, 'othercause1');">
<option value=""> - Επιλέξτε -</option>
<option value="01">01 AIDS (ongoing active disease)</option>
<option value="01.1">01.1 Infection</option>
<option value="01.2">01.2 Malignancy</option>
<option value="02">02 Infection (other than 01.1)</option>
<option value="02.1">02.1 Bacterial</option>
<option value="02.1.1">02.1.1 Bacterial with sepsis</option>
<option value="02.2">02.2 Others</option>
<option value="02.2.1">02.2.1 Other with sepsis</option>
<option value="02.3">02.3 Unknown aetiology</option>
<option value="02.3.1">02.3.1 Unknown with sepsis</option>
<option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
<option value="03.1">03.1 HCV</option>
<option value="03.1.1">03.1.1 HCV with cirrhosis</option>
<option value="03.1.2">03.1.2 HCV with liver failure</option>
<option value="03.2">03.2 HBV</option>
<option value="03.2.1">03.2.1 HBV with cirrhosis</option>
<option value="03.2.2">03.2.2 HBV with liver failure</option>
<option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
<option value="05">05 Diabetes Mellitus (complication to)</option>
<option value="06">06 Pancreatitis</option>
<option value="07">07 Lactic acidosis</option>
<option value="08">08 MI or other ischemic heart disease</option>
<option value="09">09 Stroke</option>
<option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
<option value="11">11 Primary pulmonary hypertension</option>
<option value="12">12 Lung embolus</option>
<option value="13">13 Chronic obstructive lung disease</option>
<option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
<option value="15">15 Renal failure</option>
<option value="16">16 Accident or other violent death (not suicide)</option>
<option value="17">17 Suicide</option>
<option value="18">18 Euthanasia</option>
<option value="19">19 Substance abuse (active)</option>
<option value="19.1">19.1 Chronic Alcohol abuse</option>
<option value="19.2">19.2 Chronic intravenous drug-use</option>
<option value="19.3">19.3 Acute intoxication (indicate agent)</option>
<option value="20">20 Haematological disease (other causes)</option>
<option value="21">21 Endocrine disease (other causes)</option>
<option value="22">22 Psychiatric disease (other causes)</option>
<option value="23">23 CNS disease (other causes)</option>
<option value="24">24 Heart or vascular (other causes)</option>
<option value="25">25 Respiratory disease (other causes)</option>
<option value="26">26 Digestive system disease (other causes)</option>
<option value="27">27 Skin and motor system disease (other causes)</option>
<option value="28">28 Urogenital disease (other causes)</option>
<option value="29">29 Obstetric complications</option>
<option value="30">30 Congenital disorders</option>
<option value="90">90 Other causes</option>
<option value="91">91 Unclassifiable causes</option>
<option value="92">92 Unknown</option>
</select>
<BR>
'Αλλη αιτία:
<input name=othercause3 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=othercause3', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause3.value, 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
?>
</td>
</tr>
<tr><td>&nbsp;</td></td><td></tr>
<tr>
<td>
Contributing Αιτία θανάτου:
</td><td>
<select name="Contributing3" onchange="show_other(this.value, 'othercause1');">
<option value=""> - Επιλέξτε -</option>
<option value="01">01 AIDS (ongoing active disease)</option>
<option value="01.1">01.1 Infection</option>
<option value="01.2">01.2 Malignancy</option>
<option value="02">02 Infection (other than 01.1)</option>
<option value="02.1">02.1 Bacterial</option>
<option value="02.1.1">02.1.1 Bacterial with sepsis</option>
<option value="02.2">02.2 Others</option>
<option value="02.2.1">02.2.1 Other with sepsis</option>
<option value="02.3">02.3 Unknown aetiology</option>
<option value="02.3.1">02.3.1 Unknown with sepsis</option>
<option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
<option value="03.1">03.1 HCV</option>
<option value="03.1.1">03.1.1 HCV with cirrhosis</option>
<option value="03.1.2">03.1.2 HCV with liver failure</option>
<option value="03.2">03.2 HBV</option>
<option value="03.2.1">03.2.1 HBV with cirrhosis</option>
<option value="03.2.2">03.2.2 HBV with liver failure</option>
<option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
<option value="05">05 Diabetes Mellitus (complication to)</option>
<option value="06">06 Pancreatitis</option>
<option value="07">07 Lactic acidosis</option>
<option value="08">08 MI or other ischemic heart disease</option>
<option value="09">09 Stroke</option>
<option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
<option value="11">11 Primary pulmonary hypertension</option>
<option value="12">12 Lung embolus</option>
<option value="13">13 Chronic obstructive lung disease</option>
<option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
<option value="15">15 Renal failure</option>
<option value="16">16 Accident or other violent death (not suicide)</option>
<option value="17">17 Suicide</option>
<option value="18">18 Euthanasia</option>
<option value="19">19 Substance abuse (active)</option>
<option value="19.1">19.1 Chronic Alcohol abuse</option>
<option value="19.2">19.2 Chronic intravenous drug-use</option>
<option value="19.3">19.3 Acute intoxication (indicate agent)</option>
<option value="20">20 Haematological disease (other causes)</option>
<option value="21">21 Endocrine disease (other causes)</option>
<option value="22">22 Psychiatric disease (other causes)</option>
<option value="23">23 CNS disease (other causes)</option>
<option value="24">24 Heart or vascular (other causes)</option>
<option value="25">25 Respiratory disease (other causes)</option>
<option value="26">26 Digestive system disease (other causes)</option>
<option value="27">27 Skin and motor system disease (other causes)</option>
<option value="28">28 Urogenital disease (other causes)</option>
<option value="29">29 Obstetric complications</option>
<option value="30">30 Congenital disorders</option>
<option value="90">90 Other causes</option>
<option value="91">91 Unclassifiable causes</option>
<option value="92">92 Unknown</option>
</select>
<BR>
'Αλλη αιτία:
<input name=othercause4 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=othercause4', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause4.value, 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
?>
</td>
</tr>
<tr><td>&nbsp;</td></td><td></tr>
<tr>
<td>
Contributing Αιτία θανάτου:
</td><td>
<select name="Contributing4" onchange="show_other(this.value, 'othercause1');">
<option value=""> - Επιλέξτε -</option>
<option value="01">01 AIDS (ongoing active disease)</option>
<option value="01.1">01.1 Infection</option>
<option value="01.2">01.2 Malignancy</option>
<option value="02">02 Infection (other than 01.1)</option>
<option value="02.1">02.1 Bacterial</option>
<option value="02.1.1">02.1.1 Bacterial with sepsis</option>
<option value="02.2">02.2 Others</option>
<option value="02.2.1">02.2.1 Other with sepsis</option>
<option value="02.3">02.3 Unknown aetiology</option>
<option value="02.3.1">02.3.1 Unknown with sepsis</option>
<option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
<option value="03.1">03.1 HCV</option>
<option value="03.1.1">03.1.1 HCV with cirrhosis</option>
<option value="03.1.2">03.1.2 HCV with liver failure</option>
<option value="03.2">03.2 HBV</option>
<option value="03.2.1">03.2.1 HBV with cirrhosis</option>
<option value="03.2.2">03.2.2 HBV with liver failure</option>
<option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
<option value="05">05 Diabetes Mellitus (complication to)</option>
<option value="06">06 Pancreatitis</option>
<option value="07">07 Lactic acidosis</option>
<option value="08">08 MI or other ischemic heart disease</option>
<option value="09">09 Stroke</option>
<option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
<option value="11">11 Primary pulmonary hypertension</option>
<option value="12">12 Lung embolus</option>
<option value="13">13 Chronic obstructive lung disease</option>
<option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
<option value="15">15 Renal failure</option>
<option value="16">16 Accident or other violent death (not suicide)</option>
<option value="17">17 Suicide</option>
<option value="18">18 Euthanasia</option>
<option value="19">19 Substance abuse (active)</option>
<option value="19.1">19.1 Chronic Alcohol abuse</option>
<option value="19.2">19.2 Chronic intravenous drug-use</option>
<option value="19.3">19.3 Acute intoxication (indicate agent)</option>
<option value="20">20 Haematological disease (other causes)</option>
<option value="21">21 Endocrine disease (other causes)</option>
<option value="22">22 Psychiatric disease (other causes)</option>
<option value="23">23 CNS disease (other causes)</option>
<option value="24">24 Heart or vascular (other causes)</option>
<option value="25">25 Respiratory disease (other causes)</option>
<option value="26">26 Digestive system disease (other causes)</option>
<option value="27">27 Skin and motor system disease (other causes)</option>
<option value="28">28 Urogenital disease (other causes)</option>
<option value="29">29 Obstetric complications</option>
<option value="30">30 Congenital disorders</option>
<option value="90">90 Other causes</option>
<option value="91">91 Unclassifiable causes</option>
<option value="92">92 Unknown</option>
</select>
<BR>
'Αλλη αιτία:
<input name=othercause5 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=othercause5', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause5.value, 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
?>
</td>
</tr>
<tr><td>&nbsp;</td></td><td></tr>
<tr>
<td>
Underlying Αιτία θανάτου:
</td><td>
<select name="Underlying" onchange="show_other(this.value, 'othercause1');">
<option value=""> - Επιλέξτε -</option>
<option value="01">01 AIDS (ongoing active disease)</option>
<option value="01.1">01.1 Infection</option>
<option value="01.2">01.2 Malignancy</option>
<option value="02">02 Infection (other than 01.1)</option>
<option value="02.1">02.1 Bacterial</option>
<option value="02.1.1">02.1.1 Bacterial with sepsis</option>
<option value="02.2">02.2 Others</option>
<option value="02.2.1">02.2.1 Other with sepsis</option>
<option value="02.3">02.3 Unknown aetiology</option>
<option value="02.3.1">02.3.1 Unknown with sepsis</option>
<option value="03">03 Chronic viral hepatitis (progression of / complication to)</option>
<option value="03.1">03.1 HCV</option>
<option value="03.1.1">03.1.1 HCV with cirrhosis</option>
<option value="03.1.2">03.1.2 HCV with liver failure</option>
<option value="03.2">03.2 HBV</option>
<option value="03.2.1">03.2.1 HBV with cirrhosis</option>
<option value="03.2.2">03.2.2 HBV with liver failure</option>
<option value="04">04 Malignancy (other than 01.2 and 03, 03.1, 03.2)</option>
<option value="05">05 Diabetes Mellitus (complication to)</option>
<option value="06">06 Pancreatitis</option>
<option value="07">07 Lactic acidosis</option>
<option value="08">08 MI or other ischemic heart disease</option>
<option value="09">09 Stroke</option>
<option value="10">10 Gastro-intestinal haemorrhage (if chosen, specify underlying cause)</option>
<option value="11">11 Primary pulmonary hypertension</option>
<option value="12">12 Lung embolus</option>
<option value="13">13 Chronic obstructive lung disease</option>
<option value="14">14 Liver failure (other than 03, 03.1, 03.2)</option>
<option value="15">15 Renal failure</option>
<option value="16">16 Accident or other violent death (not suicide)</option>
<option value="17">17 Suicide</option>
<option value="18">18 Euthanasia</option>
<option value="19">19 Substance abuse (active)</option>
<option value="19.1">19.1 Chronic Alcohol abuse</option>
<option value="19.2">19.2 Chronic intravenous drug-use</option>
<option value="19.3">19.3 Acute intoxication (indicate agent)</option>
<option value="20">20 Haematological disease (other causes)</option>
<option value="21">21 Endocrine disease (other causes)</option>
<option value="22">22 Psychiatric disease (other causes)</option>
<option value="23">23 CNS disease (other causes)</option>
<option value="24">24 Heart or vascular (other causes)</option>
<option value="25">25 Respiratory disease (other causes)</option>
<option value="26">26 Digestive system disease (other causes)</option>
<option value="27">27 Skin and motor system disease (other causes)</option>
<option value="28">28 Urogenital disease (other causes)</option>
<option value="29">29 Obstetric complications</option>
<option value="30">30 Congenital disorders</option>
<option value="90">90 Other causes</option>
<option value="91">91 Unclassifiable causes</option>
<option value="92">92 Unknown</option>
</select>
<BR>
'Αλλη αιτία:
<input name=othercause6 onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=othercause6', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" onfocus="this.blur();">
<?
echo "<img src=\"./images/b_help.png\" style=\"cursor: pointer\" onclick=\"window.open('./icd-10/findcode.php?code='+document.all.othercause6.value, 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
?>
</td>
</tr>
<tr>
<td>Σημειώσεις:</td>
<td><textarea name=Notes_death style="width: 480px; height: 83px"></textarea></td>

</tr>
<tr><td>&nbsp;</td></tr>
</table>

<p>'Οπου:</p>
<UL>
<LI>Immediate cause of death: The disease(s) or injury directly leading to death.</li>
<li>Contributing cause of death: The disease(s) or injury, which contributed to a fatal outcome.</li>
<li>Underlying cause of death: The disease or injury, which initiated the train of morbid events leading directly <br>or indirectly to death, or the circumstance of the accident or violence, which produced the fatal injury.</li>
</UL>
</div>

<div id=enzoi style="display: none">
<table>
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
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
?>              
        </SELECT> </TD>
</tr>
</table>
<p></p>
</div>

<div id=lost style="display: none">
<table>
<tr>
<td>
Αιτία:
</td><td> 
<select name=Lost2FollowUp onchange="show_date(this.value)">
<option value=""> - Επιλέξτε - </option>
<option value="1">Ο ασθενής δεν έχει εμφανιστεί τον τελευταίο χρόνο</option> 
<option value="2">Ο ασθενής μετακόμισε</option>
<option value="3">Ο ασθενής παρακολουθείται σε άλλο κέντρο</option>
<option value="4">Απόφαση Ασθενούς</option>
<option value="5">Απόσυρση Συναίνεσης</option>
<option value="6">'Aλλη αιτία (διευκρινίστε στις σημειώσεις)</option>
</select>
<td>
<tr id=last_date style="display: none">
<td>Τελευταία γνωστή ημερομηνία&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<BR>
που ο ασθενής είναι εν ζωή: &nbsp;&nbsp;&nbsp;</td>
<td>
	Ημέρα:
    <select name=LastKnownToBeAlive_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=LastKnownToBeAlive_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=LastKnownToBeAlive_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
</tr>
<tr id=newcli style="display: none">
<td>Νέα κλινική παρακολούθησης: &nbsp;&nbsp;&nbsp;</td>
<td><select name=NewClinic>
        <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
?>    
	</select>
</td>
</tr>
<td>
Σημειώσεις:
</td><td>
<textarea name=Notes_lost style="width: 347px; height: 100px"></textarea>
</td>
</table>

</div>
<p></p>
<input type="submit" value="Αποθήκευση Δεδομένων">
<?
	echo "<input type=hidden name=has_entry value=$has_entry>";
	echo "<input type=hidden name=last_state value=".$resultrow['LastState'].">";
?>
<? $last_state = $resultrow['LastState'];
$death_date = $resultrow['DeathDate'];
if ($last_state == "1")
	{
		echo "<hr><h3>Ο ασθενής είναι εν ζωή</h3>";
	}
if ($last_state == "3")
	{
		echo "<script>";
		echo "document.all.LastState.value='3';\n";
		echo "document.all.Lost2FollowUp.value='".$resultrow['Lost2FollowUp']."';\n";
		if ($resultrow['Lost2FollowUp'] == "1")
		{
			echo "document.all['LastKnownToBeAlive_year'].value = '".retyear($resultrow['LastKnownToBeAlive'])."'; ";
			echo "document.all['LastKnownToBeAlive_month'].value = '".retmonth($resultrow['LastKnownToBeAlive'])."'; ";
			echo "document.all['LastKnownToBeAlive_day'].value = '".retday($resultrow['LastKnownToBeAlive'])."'; ";
			echo "document.all['last_date'].style.display = '';";
		}
		if ($resultrow['Lost2FollowUp'] == "3")
		{
			echo "document.all['NewClinic'].value = '".$resultrow['NewClinic']."'; ";
			echo "document.all['newcli'].style.display = '';";
		}		
		echo "document.all.Notes_lost.value='".$resultrow['Notes']."';\n";
		echo "document.all['lost'].style.display = '';";
		echo "</script>";  
	} 
if ($last_state == "2")
	{
		echo "<script>";
		echo "document.all.LastState.value='2';\n";
		echo "document.all['DeathDate_year'].value = '".retyear($resultrow['DeathDate'])."'; ";
		echo "document.all['DeathDate_month'].value = '".retmonth($resultrow['DeathDate'])."'; ";
		echo "document.all['DeathDate_day'].value = '".retday($resultrow['DeathDate'])."'; ";
		echo "document.all.Notes_death.value='".$resultrow['Notes']."';\n";
		echo "document.all['death_extra'].style.display = '';";
		if (is_numeric($resultrow['Immediate'][0]))
		{
			echo "document.all.Immediate.value='".$resultrow['Immediate']."';\n";
		}
		else
		{
			echo "document.all.Immediate.value='90';\n";
			echo "document.all.othercause1.value='".$resultrow['Immediate']."';\n";
		}
		if (is_numeric($resultrow['Underlying'][0]))
		{
			echo "document.all.Underlying.value='".$resultrow['Underlying']."';\n";
		}
		else
		{
			echo "document.all.Underlying.value='90';\n";
			echo "document.all.othercause6.value='".$resultrow['Underlying']."';\n";
		}		
		if ((is_numeric($resultrow['Contributing1'][0])) && ($resultrow['Contributing1'] !=NULL))
		{
			echo "document.all.Contributing1.value='".$resultrow['Contributing1']."';\n";
		}
		else
		{
			echo "document.all.Contributing1.value='90';\n";
			echo "document.all.Contributing1.value='".$resultrow['Contributing1']."';\n";
		}
		if ((is_numeric($resultrow['Contributing2'][0])) && ($resultrow['Contributing2'] !=NULL))
		{
			echo "document.all.Contributing2.value='".$resultrow['Contributing2']."';\n";
		}
		else
		{
			echo "document.all.Contributing2.value='90';\n";
			echo "document.all.Contributing2.value='".$resultrow['Contributing2']."';\n";
		}	
		if ((is_numeric($resultrow['Contributing3'][0])) && ($resultrow['Contributing3'] !=NULL))
		{
			echo "document.all.Contributing3.value='".$resultrow['Contributing3']."';\n";
		}
		else
		{
			echo "document.all.Contributing3.value='90';\n";
			echo "document.all.Contributing3.value='".$resultrow['Contributing3']."';\n";
		}	
		if ((is_numeric($resultrow['Contributing4'][0])) && ($resultrow['Contributing4'] !=NULL))
		{
			echo "document.all.Contributing4.value='".$resultrow['Contributing4']."';\n";
		}
		else
		{
			echo "document.all.Contributing4.value='90';\n";
			echo "document.all.Contributing4.value='".$resultrow['Contributing4']."';\n";
		}				
		echo "</script>";  
	} 	
?>
</form>
</div>
<script>
function show_extra(id)
{
	if (id == 1)
	{
		document.all['enzoi'].style.display = "";
		document.all['death_extra'].style.display = "none";
		document.all['lost'].style.display = "none";
	}
	else if (id == 2)
	{
		document.all['enzoi'].style.display = "none";
		document.all['death_extra'].style.display = "";
		document.all['lost'].style.display = "none";
	}
	else if (id == 3)
	{
		document.all['enzoi'].style.display = "none";
		document.all['death_extra'].style.display = "none";
		document.all['lost'].style.display = "";
	}	
}

function show_date(id)
{
	if (id == 1)
	{
		document.all['last_date'].style.display = "";
		document.all['newcli'].style.display = "none";
	}
	else if (id == 3)
	{
		document.all['last_date'].style.display = "none";
		document.all['newcli'].style.display = "";
	}
	else
	{
		document.all['last_date'].style.display = "none";
		document.all['newcli'].style.display = "none";		
	}
}

function doc(el)
{
	return document.all[el];
}

function check_data()
{
	
	if (doc("LastState").value == 1)
	{
		if (doc("Clinic").value == "")
		{
			alert("Πρέπει να επιλέξετε μια κλινική!");
			return false;
		}
		if (doc("DateOfVisit_year").value == "")
		{
			alert("Πρέπει να επιλέξετε το χρόνο της επίσκεψης στην κλινική!");
			return false;
		}
		if (doc("DateOfVisit_month").value == "")
		{
			alert("Πρέπει να επιλέξετε το μήνα της επίσκεψης στην κλινική!");
			return false;
		}
		if (doc("DateOfVisit_day").value == "")
		{
			alert("Πρέπει να επιλέξετε την ημέρα της επίσκεψης στην κλινική!");
			return false;
		}		
	}
	if (doc("LastState").value == 2)
	{
		if (doc("DeathDate_year").value == "")
		{
			alert("Πρέπει να επιλέξετε το χρόνο στην ημερομηνία θανάτου!");
			return false;
		}
		if (doc("DeathDate_month").value == "")
		{
			alert("Πρέπει να επιλέξετε το μήνα στην ημερομηνία θανάτου!");
			return false;
		}
		if (doc("DeathDate_day").value == "")
		{
			alert("Πρέπει να επιλέξετε την ημέρα στην ημερομηνία θανάτου!");
			return false;
		}
		if (doc("Immediate").value == "")
		{
			alert("Πρέπει να επιλέξετε την άμμεση ατία θανάτου!");
			return false;
		}
		if (doc("Immediate").value == "90")
		{
			if (doc("othercause1").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}		
		if (doc("Immediate").value == "")
		{
			alert("Πρέπει να επιλέξετε την άμμεση ατία θανάτου!");
			return false;
		}
		if (doc("Immediate").value == "90")
		{
			if (doc("othercause1").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}
		if (doc("Underlying").value == "")
		{
			alert("Πρέπει να επιλέξετε την underlying ατία θανάτου!");
			return false;
		}
		if (doc("Underlying").value == "90")
		{
			if (doc("othercause6").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}
		if (doc("Contributing1").value == "90")
		{
			if (doc("othercause2").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}
		if (doc("Contributing2").value == "90")
		{
			if (doc("othercause3").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}
		if (doc("Contributing3").value == "90")
		{
			if (doc("othercause4").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}
		if (doc("Contributing4").value == "90")
		{
			if (doc("othercause5").value == "")
			{
				alert("Πρέπει να διευκρινήσετε ποιά είναι η άλλη ατία θανάτου!");
				return false;
			}
		}
	}
	if (doc("LastState").value == 3)
	{
		if (doc("Lost2FollowUp").value == "")
		{
			alert("Πρέπει να επιλέξετε μια αιτία!");
			return false;
		}
		if (doc("Lost2FollowUp").value == "1")
		{		
			if (doc("LastKnownToBeAlive_year").value == "")
			{
				alert("Πρέπει να επιλέξετε το χρόνο στην ημερομηνία!");
				return false;
			}
			if (doc("LastKnownToBeAlive_month").value == "")
			{
				alert("Πρέπει να επιλέξετε το μήνα στην ημερομηνία!");
				return false;
			}
			if (doc("LastKnownToBeAlive_day").value == "")
			{
				alert("Πρέπει να επιλέξετε την ημέρα στην ημερομηνία!");
				return false;
			}
		}
		if (doc("Lost2FollowUp").value == "3")
		{		
			if (doc("NewClinic").value == "")
			{
				alert("Πρέπει να επιλέξετε την νέα κλινική παρακολούθησης!");
				return false;
			}
		}		
	}
//	return true;
}
</script>
</BODY>
</HTML>
<? 	
//mysql_free_result($resultrow);
mysql_close($dbconnection); 
?>