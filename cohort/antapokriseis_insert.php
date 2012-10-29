<?
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



<?
//echo date("z")."<BR>";
//echo date("z", strtotime($dates[$i]))."<BR>";
//echo $now_days."<BR>";
//echo $th_days;
$i="";
?>

<center><u><b>Βιοχημική Ανταπόκριση:</b></u></center>
<table>
<?
$today = getdate();
$now_days = round(strtotime("now")/86400);
//$th_days = round(strtotime($dates[$i])/86400);
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
//$th_days = round(strtotime($dates[$i])/86400);
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
