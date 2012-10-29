<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντι-ιικών Θεραπειών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

//if ($_GET['code'] == "" || !is_numeric($_GET['code']))
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
check_patient($_GET['code']);

	$reasons_query = "SELECT * FROM hbv_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	$reasons_str = "";
	$index = 1;
	for ($r=0; $r<$reasons; $r++)
	{
		$row = mysql_fetch_array($reason_result);
   		$reasons_str .= "<option value='".$row[0]."'>".$row[1]."</option>\n";
    }
	mysql_free_result($reason_result);

echo "<P><B> Βιοχημικές-Ιολογικές Ανταποκρίσεις και Λόγοι Διακοπής Θεραπειών</B></P>";
$sql = "SELECT * FROM hbv_antiiikes_treatments_antapokrisi WHERE StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."' AND PatientCode=".$_GET['code'];
$result_data = execute_query($sql);

//print_r($row);

echo "<TABLE style='width:1100px'><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF; width:100px;'>Φαρμακευτικό Σχήμα</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF; width:90px'>Χρονικό Διάστημα χορήγησης</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF;'>Ανταποκρίσεις</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'></TH>";
//echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF; width:80px'>Ολοκλήρωση Θεραπείας</TH>";
//echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Αιτία<BR>διακοπής</TH>";
//echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Σημειώσεις</TH>";
    echo "<form name='change_data_form' method=GET action='hbv_change_antiiikes_data.php' onsubmit='return check_data();'>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<input type=hidden name=start value=".$_GET['start'].">";
    echo "<input type=hidden name=end value=".$_GET['end'].">";
	$i="";
//    $dates[$i] = $_GET['start'];
//   $schema[$i] = $_GET['schema'];
//    $dates[$i+1] = $_GET['end'];
    echo "<tr>";
    echo "<td align='center' style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' valign='top'>".$_GET['schema']."</td>";
    echo "<td align='center' style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' valign='top'> Από <BR><BR>";
?>
		Ημέρα: <select name="StartDate_day">
		<option value=""></option>
		<? print_options(31); ?>
		</select><BR>
		Μήνας: <select name="StartDate_month">
		<option value=""></option>
		<? print_options(12); ?>
		</select><BR>
		Έτος: <select name="StartDate_year">
		<option value=""></option>
		<? print_years_no_unknown(); ?>
		<option value=""></option>
		</select>
		<BR><BR>εως<BR><BR>
		Ημέρα: <select name="EndDate_day">
		<option value=""></option>
		<? print_options(31); ?>
		</select><BR>
		Μήνας: <select name="EndDate_month">
		<option value=""></option>
		<? print_options(12); ?>
		</select><BR>
		Έτος: <select name="EndDate_year">
		<option value=""></option>
		<? print_years_no_unknown(); ?>
		<option value=""></option>
		</select>	</TD>

<?
//    
	
//	include_once('antapokrisi_insert_step2.php');


	$posotikes_methods_query = "SELECT * FROM hbv_posotikes_iologikes_methods";
    $methods_result = execute_query($posotikes_methods_query);		
	$methods = mysql_num_rows($methods_result);
    $strMethods = "";
	for ($m=0; $m<$methods; $m++)
    {
    	$row = mysql_fetch_array($methods_result);
    	$strMethods .= "<option value='".$row[0]."'>".$row[1]."</option>";
    }
	$poiotikes_methods_query = "SELECT * FROM hbv_poiotikes_iologikes_methods";
    $methods_result = execute_query($poiotikes_methods_query);		
	$methods = mysql_num_rows($methods_result);
    $strMethods_poiotikes = "";
	for ($m=0; $m<$methods; $m++)
    {
    	$row = mysql_fetch_array($methods_result);
    	$strMethods_poiotikes .= "<option value='".$row[0]."'>".$row[1]."</option>";
    }
    $HBeAg_positive_query = "SELECT Result FROM exams_orologikes WHERE Type='HBeAg' AND PatientCode=".$_GET['code'];
	$HBeAg_result = execute_query($HBeAg_positive_query);
	$HBeAg_result_row = mysql_fetch_row($HBeAg_result);
	$HBeAg_positive = $HBeAg_result_row[0];
?>


<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' valign="top">
<?
//echo date("z")."<BR>";
//echo date("z", strtotime($dates[$i]))."<BR>";
//echo $now_days."<BR>";
//echo $th_days;
?>

<center><u><b>Βιοχημική Ανταπόκριση:</b></u></center>
<table>
<?
$today = getdate();
$now_days = round(strtotime("now")/86400);
$th_days = round(strtotime("now")/86400);
?>
<tr><td>
Αρχική<BR><i>(φυσιολογική ALT)</i></td><td>
 &nbsp;&nbsp;<select name="Bioximiki_arxiki<? echo $i;?>">
<option value=-1> - </option>
<option value=0>OXI</option>
<option value=1>NAI</option>
<option value=2>ΑΓΝΩΣΤΗ</option>
</select>
&nbsp;&nbsp;
    Ημέρα: <select name=Bioximiki_arxiki<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Bioximiki_arxiki<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Bioximiki_arxiki<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr>
<tr><td>
Διαφυγή υπό θεραπεία<BR><i></i></td><td>
 &nbsp;&nbsp;<select name="Bioximiki_diafugi<? echo $i;?>">
<option value=-1> - </option>
<option value=0>OXI</option>
<option value=1>NAI</option>
<option value=2>ΑΓΝΩΣΤΗ</option>
</select>
&nbsp;&nbsp;
    Ημέρα: <select name=Bioximiki_diafugi<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Bioximiki_diafugi<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Bioximiki_diafugi<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr>
<tr><td>
Τέλος σχήματος</td><td>
 &nbsp;&nbsp;<select name="Bioximiki_end<? echo $i;?>">
<option value=-1> - </option>
<option value=0>OXI</option>
<option value=1>NAI</option>
<option value=2>ΑΓΝΩΣΤΗ</option>
</select>
&nbsp;&nbsp;
    Ημέρα: <select name=Bioximiki_end<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Bioximiki_end<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Bioximiki_end<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr>
<tr><td>
<b>Μακροχρόνια</b><i><BR>(>12 μήνες μετά την<BR>διακοπή κάθε θεραπείας)</i></td><td valign="top">
 &nbsp;&nbsp;<select name="Bioximiki_longterm<? echo $i;?>" onchange="ajax_prepare(this, 'bioximiki', '<? echo $dates[$i] ?>', '<? echo $dates[$i+1] ?>');">
<option value=-1> - </option>
<option value=0>OXI</option>
<option value=1>NAI</option>
<option value=2>ΑΓΝΩΣΤΗ</option>
</select>
&nbsp;&nbsp;
    Ημέρα: <select name=Bioximiki_longterm<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Bioximiki_longterm<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Bioximiki_longterm<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr>
</table>
<center><u><b>Ιολογική Ανταπόκριση:</b></u></center>
<table>
<?
$today = getdate();
$now_days = round(strtotime("now")/86400);
$th_days = round(strtotime("now")/86400);
?>
<tr><td valign="center" align="center" style="border: 1px solid; border-color: orange">
Αρχική<BR><i>(ελάχιστα επίπεδα<BR>εντός πρώτου έτος)</i></td><td style="border: 1px solid; border-color: orange">
<table><tr><td>
<p align=center>
<input type="radio" id="io_arxiki_pos" name="io_arxiki" value="poiotiki" onclick="io_arxiki_toggle(this, '<? echo $i ?>')"> Ποιοτική
&nbsp; 
<input type="radio" id="io_arxiki_neg" name="io_arxiki" value="posotiki" onclick="io_arxiki_toggle(this, '<? echo $i ?>')"> Ποσοτική
</p>
<div id="iologiki_arxiki_posotiki" style="display:none">
					&nbsp;<select name="Iologiki_arxiki_Operator">
					<option value="<">&lt;</option>
					<option value="=" selected>=</option>
					<option value=">">&gt;</option>
					</select>
					<input name="Iologiki_arxiki_value_posotiki" size=14>
    				<select name="Iologiki_arxikiUnits_posotiki">
    				<option value=""> - Μονάδες -</option>
    				<option value="1">copies/ml</option>
    				<option value="2">Eq/ml</option>
    				<option value="3">Pg/ml</option>
    				<option value="4">Meg/ml</option>
    				<option value="5">IU/ml</option>
    				</select>
					<select name="Iologiki_arxiki_method_posotiki">
					<option value="">- Μέθοδος -</option>
					<?
					echo $strMethods;
					?>
					</select>
</div>
<div id="iologiki_arxiki_poiotiki" style="display:none">
&nbsp;<INPUT type=radio id="arxiki_pos" name="Iologiki_arxiki_value_poiotiki" value="Θετικό"> Θετικό 
&nbsp; <INPUT type=radio id="arxiki_neg" name="Iologiki_arxiki_value_poiotiki" value="Αρνητικό"> Αρνητικό 
&nbsp; <select name="Iologiki_arxiki_method_poiotiki">
<option value="">- Μέθοδος -</option>
<? echo $strMethods_poiotikes;	?>
</select>
</div>
<script type="text/javascript">
function io_arxiki_toggle(e, num)
{		
	if (e.value == "posotiki")
	{
		el = document.getElementById("iologiki_arxiki_posotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_arxiki_poiotiki");
		el.style.display = "none";		
	}
	else if (e.value == "poiotiki")
	{
		el = document.getElementById("iologiki_arxiki_poiotiki");
		el.style.display = "";	
		el = document.getElementById("iologiki_arxiki_posotiki");
		el.style.display = "none";		
	} 
}
</script>    
</td></tr>
<tr>
<td align=left>
    &nbsp;Ημέρα: <select name=Iologiki_arxiki<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Iologiki_arxiki<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Iologiki_arxiki<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr></table>
</td>
</tr>
<tr><td valign="center" align="center" style="border: 1px solid; border-color: orange">
Διαφυγή υπό θεραπεία<BR><i>(αύξηση >= 1log<SUB>10</SUB>)</i></td><td style="border: 1px solid; border-color: orange">
<table><tr><td>
<p align=center>
<input type="radio" id="io_diafugi_pos" name="io_diafugi" value="poiotiki" onclick="io_diafugi_toggle(this, '<? echo $i ?>')"> Ποιοτική
&nbsp; 
<input type="radio" id="io_diafugi_neg" name="io_diafugi" value="posotiki" onclick="io_diafugi_toggle(this, '<? echo $i ?>')"> Ποσοτική
</p>
<div id="iologiki_diafugi_posotiki" style="display:none">
					&nbsp;<select name='Iologiki_diafugi_Operator'>
					<option value="<">&lt;</option>
					<option value="=" selected>=</option>
					<option value=">">&gt;</option>
					</select>
					<input name="Iologiki_diafugi_value_posotiki" size=14>
    				<select name="Iologiki_diafugiUnits_posotiki">
    				<option value=""> - Μονάδες -</option>
    				<option value="1">copies/ml</option>
    				<option value="2">Eq/ml</option>
    				<option value="3">Pg/ml</option>
    				<option value="4">Meg/ml</option>
    				<option value="5">IU/ml</option>
    				</select>
					<select name="Iologiki_diafugi_method_posotiki">
					<option value="">- Μέθοδος -</option>
					<?
					echo $strMethods;
					?>
					</select>
</div>
<div id="iologiki_diafugi_poiotiki" style="display:none">
&nbsp;<INPUT type=radio id="diafugi_pos" name="Iologiki_diafugi_value_poiotiki" value="Θετικό"> Θετικό 
&nbsp; <INPUT type=radio id="diafugi_neg" name="Iologiki_diafugi_value_poiotiki" value="Αρνητικό"> Αρνητικό 
&nbsp; <select name="Iologiki_diafugi_method_poiotiki">
<option value="">- Μέθοδος -</option>
<? echo $strMethods_poiotikes;	?>
</select>
</div>
<script type="text/javascript">
function io_diafugi_toggle(e, num)
{		
	if (e.value == "posotiki")
	{
		el = document.getElementById("iologiki_diafugi_posotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_diafugi_poiotiki");
		el.style.display = "none";		
	}
	else if (e.value == "poiotiki")
	{
		el = document.getElementById("iologiki_diafugi_poiotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_diafugi_posotiki");
		el.style.display = "none";		
	} 
}
</script> 
</td></tr>
<tr>
<td align=left>
&nbsp;Ημέρα: <select name=Iologiki_diafugi<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Iologiki_diafugi<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Iologiki_diafugi<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr></table>
</td>
<tr><td valign="center" align="center" style="border: 1px solid; border-color: orange">
Στο τέλος θεραπείας</td><td style="border: 1px solid; border-color: orange">
<table><tr><td>
<p align=center>
<input type="radio" id="io_end_pos" name="io_end" value="poiotiki" onclick="io_end_toggle(this, '<? echo $i ?>')"> Ποιοτική
&nbsp; 
<input type="radio" id="io_end_neg" name="io_end" value="posotiki" onclick="io_end_toggle(this, '<? echo $i ?>')"> Ποσοτική
</p>
<div id="iologiki_end_posotiki" style="display:none">
					&nbsp;<select name='Iologiki_end_Operator'>
					<option value="<">&lt;</option>
					<option value="=" selected>=</option>
					<option value=">">&gt;</option>
					</select>
					<input name="Iologiki_end_value_posotiki" size=14>
    				<select name="Iologiki_endUnits_posotiki">
    				<option value=""> - Μονάδες -</option>
    				<option value="1">copies/ml</option>
    				<option value="2">Eq/ml</option>
    				<option value="3">Pg/ml</option>
    				<option value="4">Meg/ml</option>
    				<option value="5">IU/ml</option>
    				</select>
					<select name="Iologiki_end_method_posotiki">
					<option value="">- Μέθοδος -</option>
					<?
					echo $strMethods;
					?>
					</select>
</div>
<div id="iologiki_end_poiotiki" style="display:none">
&nbsp;<INPUT type=radio id="end_pos" name="Iologiki_end_value_poiotiki" value="Θετικό"> Θετικό 
&nbsp; <INPUT type=radio id="end_neg" name="Iologiki_end_value_poiotiki" value="Αρνητικό"> Αρνητικό 
&nbsp; <select name="Iologiki_end_method_poiotiki">
<option value="">- Μέθοδος -</option>
<? echo $strMethods_poiotikes;	?>
</select>
</div>
<script type="text/javascript">
function io_end_toggle(e, num)
{		
	if (e.value == "posotiki")
	{
		el = document.getElementById("iologiki_end_posotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_end_poiotiki");
		el.style.display = "none";		
	}
	else if (e.value == "poiotiki")
	{
		el = document.getElementById("iologiki_end_poiotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_end_posotiki");
		el.style.display = "none";		
	} 
}
</script> 
</td></tr>
<tr>
<td align=left>
&nbsp;Ημέρα: <select name=Iologiki_end<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Iologiki_end<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Iologiki_end<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr></table>	
</td>
</tr>
<tr><td valign="center" align="center" style="border: 1px solid; border-color: orange">
<b> Μακροχρόνια</b><BR><i>(>12 μήνες μετά την<BR>&nbsp; διακοπή κάθε θεραπείας) &nbsp;</i></td><td style="border: 1px solid; border-color: orange">
<table><tr><td>
<p align=center>
<input type="radio" id="io_longterm_pos" name="io_longterm" value="poiotiki" onclick="io_longterm_toggle(this, '<? echo $i ?>')"> Ποιοτική
&nbsp; 
<input type="radio" id="io_longterm_neg" name="io_longterm" value="posotiki" onclick="io_longterm_toggle(this, '<? echo $i ?>')"> Ποσοτική
</p>
<div id="iologiki_longterm_posotiki" style="display:none">
					&nbsp;<select name='Iologiki_longterm_Operator'>
					<option value="<">&lt;</option>
					<option value="=" selected>=</option>
					<option value=">">&gt;</option>
					</select>
					<input name="Iologiki_longterm_value_posotiki" size=14>
    				<select name="Iologiki_longtermUnits_posotiki">
    				<option value=""> - Μονάδες -</option>
    				<option value="1">copies/ml</option>
    				<option value="2">Eq/ml</option>
    				<option value="3">Pg/ml</option>
    				<option value="4">Meg/ml</option>
    				<option value="5">IU/ml</option>
    				</select>
					<select name="Iologiki_longterm_method_posotiki">
					<option value="">- Μέθοδος -</option>
					<?
					echo $strMethods;
					?>
					</select>
</div>
<div id="iologiki_longterm_poiotiki" style="display:none">
&nbsp;<INPUT type=radio id="longterm_pos" name="Iologiki_longterm_value_poiotiki" value="Θετικό"> Θετικό 
&nbsp; <INPUT type=radio id="longterm_neg" name="Iologiki_longterm_value_poiotiki" value="Αρνητικό"> Αρνητικό 
&nbsp; <select name="Iologiki_longterm_method_poiotiki">
<option value="">- Μέθοδος -</option>
<? echo $strMethods_poiotikes;	?>
</select>
</div>
<script type="text/javascript">
function io_longterm_toggle(e, num)
{		
	if (e.value == "posotiki")
	{
		el = document.getElementById("iologiki_longterm_posotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_longterm_poiotiki");
		el.style.display = "none";		
	}
	else if (e.value == "poiotiki")
	{
		el = document.getElementById("iologiki_longterm_poiotiki");
		el.style.display = "";		
		el = document.getElementById("iologiki_longterm_posotiki");
		el.style.display = "none";		
	} 
}
</script></td></tr>
<tr>
<td align=left>
&nbsp;Ημέρα: <select name=Iologiki_longterm<? echo $i;?>Date_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=Iologiki_longterm<? echo $i;?>Date_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=Iologiki_longterm<? echo $i;?>Date_year>
	<option value=""></option><? print_years(); ?></select>
</td></tr></table>	
</td>
</tr>
</table>
<center><u><b>Ορολογική Ανταπόκριση:</b></u></center>
<?
if ($HBeAg_positive == "1")
{
?>
<table>
<tr><td align="center">
Υπό/Τέλος Θεραπείας
</td>
<td>
&nbsp;
<select name="Orologiki_end<? echo $i;?>">
<option value="" selected> - Επιλέξτε - </option>
<option value="1">HBeAg(+)</option>
<option value="2">HBeAg(-)/anti-HBe(-)</option>
<option value="3">HBeAg(-)/anti-HBe(+)</option>
</select><BR>
</td>
</tr>
<tr><td align="center">
<b> Μακροχρόνια</b><BR><i>(>12 μήνες μετά την διακοπή κάθε θεραπείας) </i></td>
<td>
&nbsp;
<select name="Orologiki_longterm<? echo $i;?>" onchange="ajax_prepare(this, 'iologiki', '<? echo $dates[$i] ?>', '<? echo $dates[$i+1] ?>');">
<option value="" selected> - Επιλέξτε - </option>
<option value="1">HBeAg(+)</option>
<option value="2">HBeAg(-)/anti-HBe(-)</option>
<option value="3">HBeAg(-)/anti-HBe(+)</option>
</select><BR>
</td>
</tr>
</table>
<?
}
else
{
?>
<center>
<font color=red>
Δεν μπορείτε να καταχωρήσετε ορολογική ανταπόκριση<BR>
γιατί δεν έχετε δηλώσει <STRONG>HBeAg θετική XHB</STRONG> για τον ασθενή
</font>
</center>
<?	
}
?>
</TD>	
<?    
//	
	echo "<td align='center' style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' valign='top'>";
//    if ($_GET['end'] != "3000-01-01")
//	{    
?>
   	<b>Ολοκλήρωση Θεραπείας:</b> 
	<select name=Info1>
    <option value="" selected>-</option>
    <option value="1">ΝΑΙ</option>
    <option value="2">ΟΧΙ</option>
    </select><br><br>
<?
/*	}
	else 
	{
		echo "-";
	}
   echo "</td>";
   echo "<td align='center' style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' valign='top'>";
    if ($_GET['end'] != "3000-01-01")
	{
*/    
?>    
	<b>Αιτία διακοπής:</b><br>
    <select name=Info2>
    <option value="" selected>-</option>
    <? echo $reasons_str; ?>
    </select><br><br>
<!--    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./hbv_reasons.php?field=Info2_<?echo $i?>', 'Λόγοι', 'width=500,height=600,status=yes');"/> -->
<?
/*	}
	else 
	{
		echo "-";
	}
    echo "</td>";
*/
?>
<!--    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' valign="top"> -->
	<b>Σημειώσεις:</b><br>
    <textarea name=Notes STYLE="overflow:hidden; width:200px; height: 410px"></textarea>
    </TD>  
<?    
    echo "</tr>";
    echo "</table>";
    echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <input type=submit value='Αλλαγή Στοιχείων'></p>";
    echo "</form>";
    

echo "<p>&nbsp;</p>\n";
//echo $row['Bioximiki_arxiki_date'];
//print_r($resultrow);
?>

<script>
temp_el = new Object();

<?
$row = mysql_fetch_assoc($result_data);

print_stored_date("StartDate", $row);
if ($row['EndDate'] != '3000-01-01')
{
	print_stored_date("EndDate", $row);
}

print_stored_data("Bioximiki_arxiki", $row);
print_stored_date2("Bioximiki_arxikiDate", $row['Bioximiki_arxiki_date']);
print_stored_data("Bioximiki_diafugi", $row);
print_stored_date2("Bioximiki_diafugiDate", $row['Bioximiki_diafugi_date']);
print_stored_data("Bioximiki_end", $row);
print_stored_date2("Bioximiki_endDate", $row['Bioximiki_end_date']);
print_stored_data("Bioximiki_longterm", $row);
print_stored_date2("Bioximiki_longtermDate", $row['Bioximiki_longterm_date']);

echo "document.all.Info1.value='".$row['Info1']."';\n";
echo "document.all.Info2.value='".$row['Info2']."';\n";
echo "document.all.Notes.value='".$row['Notes']."';\n";

if (($row['Iologiki_arxiki_value'] == "Θετικό") || ($row['Iologiki_arxiki_value'] == "Αρνητικό"))
{
	?>
    document.getElementById("io_arxiki_pos").checked = true;
	document.getElementById("iologiki_arxiki_poiotiki").style.display = "";
	<?
	print_stored_data2("Iologiki_arxiki_value_poiotiki", $row['Iologiki_arxiki_value']);
	if ($row['Iologiki_arxiki_value'] == "Θετικό")
	{
		?>
		document.getElementById("arxiki_pos").checked = true;
		<?
	}
	if ($row['Iologiki_arxiki_value'] == "Αρνητικό")
	{
		?>
		document.getElementById("arxiki_neg").checked = true;
		<?
	}	
	print_stored_date2("Iologiki_arxikiDate", $row['Iologiki_arxiki_date']);
	print_stored_data2("Iologiki_arxiki_method_poiotiki", $row['Iologiki_arxiki_method']);
}
elseif ($row['Iologiki_arxiki_value'] != "")
{ 
	?>
    document.getElementById("io_arxiki_neg").checked = true;
	document.getElementById("iologiki_arxiki_posotiki").style.display = "";
	<?
	echo "document.all['Iologiki_arxiki_value_posotiki'].value='".substr($row['Iologiki_arxiki_value'], 1)."';\n";
	echo "document.all['Iologiki_arxiki_Operator'].value='".substr($row['Iologiki_arxiki_value'], 0, 1)."';\n";
	print_stored_data2("Iologiki_arxikiUnits_posotiki", $row['Iologiki_arxiki_units']);
	print_stored_date2("Iologiki_arxikiDate", $row['Iologiki_arxiki_date']);
	print_stored_data2("Iologiki_arxiki_method_posotiki", $row['Iologiki_arxiki_method']);
}

if (($row['Iologiki_diafugi_value'] == "Θετικό") || ($row['Iologiki_diafugi_value'] == "Αρνητικό"))
{
	?>
    document.getElementById("io_diafugi_pos").checked = true;
	document.getElementById("iologiki_diafugi_poiotiki").style.display = "";
	<?
	print_stored_data2("Iologiki_diafugi_value_poiotiki", $row['Iologiki_diafugi_value']);
	if ($row['Iologiki_diafugi_value'] == "Θετικό")
	{
		?>
		document.getElementById("diafugi_pos").checked = true;
		<?
	}
	if ($row['Iologiki_diafugi_value'] == "Αρνητικό")
	{
		?>
		document.getElementById("diafugi_neg").checked = true;
		<?
	}	
	print_stored_date2("Iologiki_diafugiDate", $row['Iologiki_diafugi_date']);
	print_stored_data2("Iologiki_diafugi_method_poiotiki", $row['Iologiki_diafugi_method']);
}
elseif ($row['Iologiki_diafugi_value'] != "")
{ 
	?>
    document.getElementById("io_diafugi_neg").checked = true;
	document.getElementById("iologiki_diafugi_posotiki").style.display = "";
	<?
	echo "document.all['Iologiki_diafugi_value_posotiki'].value='".substr($row['Iologiki_diafugi_value'], 1)."';\n";
	echo "document.all['Iologiki_diafugi_Operator'].value='".substr($row['Iologiki_diafugi_value'], 0, 1)."';\n";
	print_stored_data2("Iologiki_diafugiUnits_posotiki", $row['Iologiki_diafugi_units']);
	print_stored_date2("Iologiki_diafugiDate", $row['Iologiki_diafugi_date']);
	print_stored_data2("Iologiki_diafugi_method_posotiki", $row['Iologiki_diafugi_method']);
}

if (($row['Iologiki_end_value'] == "Θετικό") || ($row['Iologiki_end_value'] == "Αρνητικό"))
{
	?>
    document.getElementById("io_end_pos").checked = true;
	document.getElementById("iologiki_end_poiotiki").style.display = "";
	<?
	print_stored_data2("Iologiki_end_value_poiotiki", $row['Iologiki_end_value']);
	if ($row['Iologiki_end_value'] == "Θετικό")
	{
		?>
		document.getElementById("end_pos").checked = true;
		<?
	}
	if ($row['Iologiki_end_value'] == "Αρνητικό")
	{
		?>
		document.getElementById("end_neg").checked = true;
		<?
	}	
	print_stored_date2("Iologiki_endDate", $row['Iologiki_end_date']);
	print_stored_data2("Iologiki_end_method_poiotiki", $row['Iologiki_end_method']);
}
elseif ($row['Iologiki_end_value'] != "")
{ 
	?>
    document.getElementById("io_end_neg").checked = true;
	document.getElementById("iologiki_end_posotiki").style.display = "";
	<?
	echo "document.all['Iologiki_end_value_posotiki'].value='".substr($row['Iologiki_end_value'], 1)."';\n";
	echo "document.all['Iologiki_end_Operator'].value='".substr($row['Iologiki_end_value'], 0, 1)."';\n";
	print_stored_data2("Iologiki_endUnits_posotiki", $row['Iologiki_end_units']);
	print_stored_date2("Iologiki_endDate", $row['Iologiki_end_date']);
	print_stored_data2("Iologiki_end_method_posotiki", $row['Iologiki_end_method']);
}

if (($row['Iologiki_longterm_value'] == "Θετικό") || ($row['Iologiki_longterm_value'] == "Αρνητικό"))
{
	?>
    document.getElementById("io_longterm_pos").checked = true;
	document.getElementById("iologiki_longterm_poiotiki").style.display = "";
	<?
	print_stored_data2("Iologiki_longterm_value_poiotiki", $row['Iologiki_longterm_value']);
	if ($row['Iologiki_longterm_value'] == "Θετικό")
	{
		?>
		document.getElementById("longterm_pos").checked = true;
		<?
	}
	if ($row['Iologiki_longterm_value'] == "Αρνητικό")
	{
		?>
		document.getElementById("longterm_neg").checked = true;
		<?
	}	
	print_stored_date2("Iologiki_longtermDate", $row['Iologiki_longterm_date']);
	print_stored_data2("Iologiki_longterm_method_poiotiki", $row['Iologiki_longterm_method']);
}
elseif ($row['Iologiki_longterm_value'] != "")
{ 
	?>
    document.getElementById("io_longterm_neg").checked = true;
	document.getElementById("iologiki_longterm_posotiki").style.display = "";
	<?
	echo "document.all['Iologiki_longterm_value_posotiki'].value='".substr($row['Iologiki_longterm_value'], 1)."';\n";
	echo "document.all['Iologiki_longterm_Operator'].value='".substr($row['Iologiki_longterm_value'], 0, 1)."';\n";
	print_stored_data2("Iologiki_longtermUnits_posotiki", $row['Iologiki_longterm_units']);
	print_stored_date2("Iologiki_longtermDate", $row['Iologiki_longterm_date']);
	print_stored_data2("Iologiki_longterm_method_posotiki", $row['Iologiki_longterm_method']);
}
?>
</script>

<script type="text/javascript">
function  check_data()
{
	if (document.all.StartDate_year.value == "")
	{
		alert("Πρέπει να δώσετε μια ημερομηνία έναρξης για το σχήμα!");
		return false;
	}
	if (document.all.EndDate_month.value == "")
	{
		temp = document.all.EndDate_year.value + "-07-01";
	}
	else
	{
		if (document.all.EndDate_day.value == "")
		{
			temp = document.all.EndDate_year.value + "-" + document.all.EndDate_month.value +"-15";
		}
		else
		{
			temp = document.all.EndDate_year.value + "-" + document.all.EndDate_month.value +"-" + document.all.EndDate_day.value;
		}
	}
	
	if (document.all.StartDate_month.value == "")
	{
		tempstart = document.all.StartDate_year.value + "-07-01";
	}
	else
	{
		if (document.all.StartDate_day.value == "")
		{
			tempstart = document.all.StartDate_year.value + "-" + document.all.StartDate_month.value +"-15";
		}
		else
		{
			tempstart = document.all.StartDate_year.value + "-" + document.all.StartDate_month.value +"-" + document.all.StartDate_day.value;
		}
	}
	
	if ((document.all.EndDate_year.value != "") && (tempstart >= temp))
	{
		alert("Η ημερομηνία διακοπής πρέπει να είναι μετά την ημερομηνία έναρξης του σχήματος!");
		return false;
	}
	if ((document.all.EndDate_year.value != "") && (document.all.Info1.value == ""))
	{
		alert("Πρέπει να συμπληρώσετε το πεδίο Ολοκλήρωση Θεραπείας!");
		return false;
	}
	if (document.all.EndDate_year.value == "")
	{
		document.all.Info1.value = "";
	}

	if ((document.all.Info1.value == "2") && (document.all.Info2.value == ""))
	{
		alert("Πρέπει να συμπληρώσετε το πεδίο Αιτία Διακοπής!");
		return false;
	}	
	
		if (Date_Compare('Bioximiki_arxiki<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία βιοχημικής ανταπόκρισης (αρχική) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}
		if (Date_Compare('Bioximiki_diafugi<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία βιοχημικής ανταπόκρισης (διαφυγή υπό θεραπεία) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}		
		if (Date_Compare('Bioximiki_end<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία βιοχημικής ανταπόκρισης (τέλος σχήματος) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}
		if (Date_Compare('Bioximiki_longterm<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία βιοχημικής ανταπόκρισης (μακροχρόνια) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}		
		if (Date_Compare('Iologiki_arxiki<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία ιολογικής ανταπόκρισης (αρχική) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}
		if (Date_Compare('Iologiki_diafugi<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία ιολογικής ανταπόκρισης (διαφυγή υπό θεραπεία) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}		
		if (Date_Compare('Iologiki_end<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία ιολογικής ανταπόκρισης (τέλος θεραπείας) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}
		if (Date_Compare('Iologiki_longterm<? echo $i; ?>Date', '<?echo $dates[$i];?>'))
		{
			alert("Στο σχήμα <? echo  $_GET['schema']; ?> η ημερομηνία ιολογικής ανταπόκρισης (μακροχρόνια) είναι πριν από την ημερομηνία χορήγησης του σχήματος!");
			return false;
		}			
return true;	

}
</script>
<?
mysql_close($dbconnection);
?>
</BODY></HTML>
