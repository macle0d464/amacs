<?
$value = "";
if (isset($_GET['ZDV']))
{
	$value .= "ZDV /";
}
if (isset($_GET['ddl']))
{
	$value .= "ddl /";
}
if (isset($_GET['ddC']))
{
	$value .= "ddC /";
}
if (isset($_GET['d4T']))
{
	$value .= "d4T /";
}
if (isset($_GET['3TC']))
{
	$value .= "3TC /";
}
if (isset($_GET['ABC']))
{
	$value .= "ABC /";
}
if (isset($_GET['Combivir']))
{
	$value .= "Combivir /";
}
if (isset($_GET['Trizivir']))
{
	$value .= "Trizivir /";
}
if (isset($_GET['NVP']))
{
	$value .= "NVP /";
}
if (isset($_GET['DLV']))
{
	$value .= "DLV /";
}
if (isset($_GET['EFV']))
{
	$value .= "EFV /";
}
if (isset($_GET['INV']))
{
	$value .= "INV /";
}
if (isset($_GET['FTV']))
{
	$value .= "FTV /";
}
if (isset($_GET['RNV1']))
{
	$value .= "RNV1 /";
}
if (isset($_GET['RNV2']))
{
	$value .= "RNV2 /";
}
if (isset($_GET['IND']))
{
	$value .= "IND /";
}
if (isset($_GET['NLF']))
{
	$value .= "NLF /";
}
if (isset($_GET['APV']))
{
	$value .= "APV /";
}
if (isset($_GET['KLR']))
{
	$value .= "KLR /";
}
if (isset($_GET['HU']))
{
	$value .= "HU /";
}
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αντιρετροϊκών Θεραπείων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<style type="text/css">
<!--
body,td,th,input,select {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
td.errormsg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold; background-color: white; color: red
}
td.show {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style></HEAD>


<BODY bgcolor="FFCCFF">
<form method=get action=medicines.php>
<p>Νουκλεοσιδικά ανάλογα (NRTI)</p>
<input type="checkbox" value=ZDV name=ZDV> ZDV <BR>
<input type="checkbox" value=ddl name=ddl> ddl <BR>
<input type="checkbox" value=ddC name=ddC> ddC <BR>
<input type="checkbox" value=d4T name=d4T> d4T <BR>
<input type="checkbox" value=3TC name=3TC> 3TC <BR>
<input type="checkbox" value=ABC name=ABC> ABC <BR>
<input type="checkbox" value=Combivir name=Combivir> Combivir <BR>
<input type="checkbox" value=Trizivir name=Trizivir> Trizivir <BR>

<p>Μη νουκλεοσιδικά ανάλογα (NNRTI)</p>
<input type="checkbox" value=NVP name=NVP> NVP <BR>
<input type="checkbox" value=DLV name=DLV> DLV <BR>
<input type="checkbox" value=EFV name=EFV> EFV <BR>

<p>Αναστολείς πρωτεάσης (PI)</p>
<input type="checkbox" value=INV name=INV> INV <BR>
<input type="checkbox" value=FTV name=FTV> FTV <BR>
<input type="checkbox" value=RNV1 name=RNV1> RNV1 <BR>
<input type="checkbox" value=RNV2 name=RNV2> RNV2 <BR>
<input type="checkbox" value=IND name=IND> IND <BR>
<input type="checkbox" value=NLF name=NLF> NLF <BR>
<input type="checkbox" value=APV name=APV> APV <BR>
<input type="checkbox" value=KLR name=KLR> KLR <BR>

<p>'Αλλη κατηγορία</p>
<input type="checkbox" value=HU name=HU> HU <BR>

<p> <input type="submit" onclick="send_data();" value="Send Data"> </p>
<input type="text" id=medicine />
</form>

<SCRIPT>
/*window.parent.document.all.<? echo $_GET['where']; ?>.value="<? echo $value; ?>";*/
document.all.medicine.value="<? echo $value; ?>";
</SCRIPT>


</BODY>
</HTML>