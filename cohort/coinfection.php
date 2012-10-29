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
//	$HBV_antihbs_positive = "SELECT * FROM exams_orologikes WHERE `Anti-HBs`='1' AND PatientCode=".$_GET['code'];
//	$HBV_antihbs_negative = "SELECT * FROM exams_orologikes WHERE `Anti-HBs`='-1' AND PatientCode=".$_GET['code'];
//	$HBV_others_positive = "SELECT * FROM exams_orologikes WHERE (HBsAg='1' OR `Anti-HBc`='1' OR HBeAg='1' OR `Anti-HBe`='1') AND PatientCode=".$_GET['code'];
	$HBsAg_positive = "SELECT * FROM exams_orologikes WHERE Type='HBsAg' AND Result='1' AND PatientCode=".$_GET['code'];
//	$HCV_antihcv_negative = "SELECT * FROM exams_orologikes WHERE `Anti-HCV`='-1' AND PatientCode=".$_GET['code'];
	$AntiHCV_positive = "SELECT * FROM exams_orologikes WHERE Type='Anti-HCV' AND Result='1' AND PatientCode=".$_GET['code'];	
?>
<HTML><HEAD>
<TITLE>���������� ������������ ������</TITLE>
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
	$HBsAg_positive_result = execute_query($HBsAg_positive);
	$AntiHCV_positive_result = execute_query($AntiHCV_positive);
	
//	if (mysql_num_rows($no_hbv_antihbs_result))
//	{
//		echo "<p><b>��� �������� �� ������������ HBV ���������� ��� ��� ������ <BR> ����� ������� ������������ ��������� ������� �� Anti-HBs ������</b></p>";
//	}
	if (mysql_num_rows($HBsAg_positive_result))
	{
?>
<P>'���� � ������� HBV ����������; 
<?
if ($row['HBV'] == "1")
{
	echo "<b>NAI</b>,&nbsp; ���������: ".$row['HBVGenotype']." ,&nbsp; ���������� ������ ���������: ".$row['HBVDate'];
	echo "<p> &nbsp;&nbsp; <input type=button value='������ ���������' onclick='change_hbv(".$_GET['code'].");'> &nbsp;&nbsp;&nbsp;";
	echo "<input type=button value='�������� �����������' onclick='delete_hbv(".$_GET['code'].");'></p>";
}
else
{
?>
<select name=HBV onchange="hbvchange(this.value)">
 <option value=0 selected>'���</option>
 <option value=1>���</option>
 </select>
  <div id=hbvextra style="display: none">
 ���������:
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
 &nbsp;&nbsp; <b>�</b> &nbsp;&nbsp; ���������������: <input name=HBVGenotype_combination>
 </p><p>
 ���������� ������ ��������� &nbsp;&nbsp;
 �����: <select name="HBVDate_day"><option value="" selected><? print_options(31); ?></option></select>
 �����: <select name="HBVDate_month"><option value="" selected><? print_options(12); ?></option></select>
 ����: <select name="HBVDate_year"><option value="" selected><? print_years(); ?></option></select>
 </div>
<?
}
	}
	else
	{
		echo "<p><b>��� �������� �� ������������ HBV ���������� ��� ��� ������ �����:</b></p>";
		echo "<UL>\n";
			echo "<LI>��� ������� ����������� ��� ������������ ��������� ������� �� <b>HBsAg ������</b></LI>";
		echo "</UL>\n";
		echo "<a href=orologikes.php?code=".$_GET['code'].">����� click ��� ��� �� ������������ ���������� ���������</a>";
		$no_hbv = 1;
	} 
	echo "<hr>";
	if (mysql_num_rows($AntiHCV_positive_result))
	{
?>
 </P>
<P>'���� � ������� HCV ����������; 
<?
if ($row['HCV'] == 1)
{
	echo "<b>NAI</b>,&nbsp; ���������: ".$row['HCVGenotype']." ,&nbsp; ���������� ������ ���������: ".$row['HCVDate'];
	echo "<p> &nbsp;&nbsp; <input type=button value='������ ���������' onclick='change_hcv(".$_GET['code'].");'> &nbsp;&nbsp;&nbsp;";
	echo "<input type=button value='�������� �����������' onclick=\"delete_hcv('".$_GET['code']."')\"></p>";
}
else
 {
?>
 <select name=HCV onchange="hcvchange(this.value)">
 <option value=0 selected>'���</option>
 <option value=1>���</option>
 </select>
 <div id=hcvextra style="display: none">
 ���������: 
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
 &nbsp;&nbsp; <b>�</b> &nbsp;&nbsp; ���������������: <input name=HCVGenotype_combination>
 </p><p>
 ���������� ������ ���������  &nbsp;&nbsp;
 �����: <select name="HCVDate_day"><option value="" selected><? print_options(31); ?></option></select>
 �����: <select name="HCVDate_month"><option value="" selected><? print_options(31); ?></option></select>
 ����: <select name="HCVDate_year"><option value="" selected><? print_years(); ?></option></select>
 </div>
<?
 }
 ?>
 </select></P>
<?
	}
	else
	{
		echo "<p><b>��� �������� �� ������������ HCV ���������� ��� ��� ������ ����� </b><p>";
		echo "<UL>\n";
		echo "<LI> ��� ������� ������������ ��������� ������� �� <b>Anti-HCV ������</b></LI>";
		echo "</UL>\n";
		echo "<a href=orologikes.php?code=".$_GET['code'].">����� click ��� ��� �� ������������ ���������� ���������</a>";
		$no_hcv = 1;
	}
if (($row['HBV']==1 && $row['HCV']==1) || ($no_hbv && $no_hcv))
{}
else {
?> 
<br>
<INPUT TYPE="SUBMIT" VALUE="���������� ���������">
<? } ?>
</FORM>
<script>
function hbvchange(value)
{
	if (value==1) { document.all.hbvextra.style.display = ""; }
	else { document.all.hbvextra.style.display = "none"; }
}
function hcvchange(value)
{
	if (value==1) { document.all.hcvextra.style.display = ""; }
	else { document.all.hcvextra.style.display = "none"; }
}
function checkdata()
{
	if (document.all.HCV.value == 1)
	{
		if ((document.all.HCVGenotype1.value == "") && (document.all.HCVGenotype2.value != ""))
		{
			alert("� ��������� ��� HCV ��� ���� ����������� �����!");
			return false;
		}
	}
	
<? if ($row['HBV'] != "1") {?>	
	if (document.all.HBV.value == 1)
	{
		if (document.all.HBVDate_year.value == "")
		{
			alert("������ �� ������ ��� ���� ��� �� ���� ���� ���������� ������ ��������� HBV");
			return false;
		}
		if ((!document.all.hbvgono1.checked) && (!document.all.hbvgono2.checked))
		{
			alert("������ �� ��������� ��� �������� ��� HBV!");
			return false;
		}
	}
<? }
if ($row['HCV'] != "1") { ?>
	if (document.all.HCV.value == 1)
	{
		if (document.all.HCVDate_year.value == "")
		{
			alert("������ �� ������ ���������� ��� �� ���� ���� ���������� ������ ��������� HCV");
			return false;
		}
	}
<? } ?>
}

function delete_hbv(code)
{
	msg =  "����� �������� ��� ������ �� ������� ��� ���������� HBV ��� ������ ";
	msg += code + " ��� ��� ���� ���������; ���� �� �������� ��� ���� �� ����� ������������� ����������� ";
	msg += "��� ����������� �� ��� HBV ���������� ��� ������ " + code + " (���� �.�. ������� ��������� HBV �����������)"
	confirmed = confirm(msg);
	if (confirmed)
	{
		window.location.href = "delete_coinfection.php?type=hbv&code="+code;
	}
}
function change_hbv(code)
{
	window.location.href = "edit_coinfection.php?type=hbv&code="+code;	
}
function delete_hcv(code)
{
	msg =  "����� �������� ��� ������ �� ������� ��� ���������� HCV ��� ������ ";
	msg += code + " ��� ��� ���� ���������; ���� �� �������� ��� ���� �� ����� ������������� ����������� ";
	msg += "��� ����������� �� ��� HCV ���������� ��� ������ " + code + " (���� �.�. ������� ��������� HCV �����������)"
	confirmed = confirm(msg);
	if (confirmed)
	{
		window.location.href = "delete_coinfection.php?type=hcv&code="+code;
	}
}
function change_hcv(code)
{
	window.location.href = "edit_coinfection.php?type=hcv&code="+code;	
}
</script>
</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>