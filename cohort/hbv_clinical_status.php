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
<TITLE>���������� �������� ���������� ������ �� ���������� HBV</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("hbv_clinical_status.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hbv_coinfection($_GET['code']);
	$result = execute_query("SELECT * FROM hbv_clinical_status WHERE PatientCode=".$_GET['code']);
	$has_entry = mysql_num_rows($result);
}
?>

<DIV style="position: absolute; left:50px;">

<FORM id="hbv_clinical_status" name="hbv_clinical_status" action="hbv_clinical_status_insert.php" method="GET" onsubmit="return check_data();">
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
if (($entry == -1) || ($entry['XroniaHBV'] == 0) || ($entry['KirosiDate'] == NULL) || ($entry['NonKirosiDate'] == NULL) || ($entry['HKKDate'] == NULL) || ($entry['TransplantDate'] == NULL))
{
?>  
	<TR>
    <TD>������� ��������� ��� ��������</TD>
    <TD>
    <select name=State onchange="status_change(this.value);">    
    <option value="" selected> - �������� - </option>
<?
} 
if (($entry == -1) || ($entry['XroniaHBV'] == 0))
{
?>    
    <option value="1">������ HBV �������</option>
<?
} 
if (($entry == -1) || ($entry['KirosiDate'] == NULL))
{
?>
    <option value="2">�������������� �������</option>
<?
}
if (($entry == -1) || ($entry['NonKirosiDate'] == NULL))
{
?>
    <option value="3">�� �������������� �������</option>
<?
}
/* 
if (($entry == -1) || ($entry['Askitis'] == NULL))
{
?>
    <option value="8">�� �������������� ������� - �������</option>
<?
}
if (($entry == -1) || ($entry['Kirsoi'] == NULL))
{
?>
    <option value="9">�� �������������� ������� - ���������� ��� �������</option>
<?
}
if (($entry == -1) || ($entry['Egkefalopatheia'] == NULL))
{
?>
    <option value="10">�� �������������� ������� - �������������� �������</option>
<?
}
if (($entry == -1) || ($entry['Nefriki'] == NULL))
{
?>
    <option value="11">�� �������������� ������� - ������������ ��������</option>
<?
}
if (($entry == -1) || ($entry['Peritonitis'] == NULL))
{
?>
    <option value="12">�� �������������� ������� - �����������</option>
<?
}      
*/
if (($entry == -1) || ($entry['HKKDate'] == NULL))
{
?>
    <option value="4">HKK</option>
<?
} 
if (($entry == -1) || ($entry['TransplantDate'] == NULL))
{
?>
    <option value="5">������������ ������</option>
<?
} 
if (($entry == -1) || ($entry['XroniaHBV'] == 0) || ($entry['KirosiDate'] == NULL) || ($entry['NonKirosiDate'] == NULL) || ($entry['HKKDate'] == NULL) || ($entry['TransplantDate'] == NULL))
{
?> 
<!--	<option value="6">������ ������</option>
	<option value="7">���������� �����������</option>
	-->
	</select>
	</TD>
    </TR>
<? 
} ?>    
    </table>
    <table id="extra0" style="display: none">
    <tr>
    <td>���������� �������������� ��������������� ��������&nbsp;&nbsp;&nbsp;</td>
    <td>�����: 
    <select name=KirosiDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    �����: <select name=KirosiDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	����: <select name=KirosiDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>    
    <table id="extra1" style="display: none">
    <tr>
    <td>���������� �������������� �� ��������������� ��������&nbsp;&nbsp;&nbsp;</td>
    <td>�����: 
    <select name=NonKirosiDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    �����: <select name=NonKirosiDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	����: <select name=NonKirosiDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
    <table id="extra2" style="display: none">
    <tr>
    <td>���������� �������������� ���&nbsp;&nbsp;&nbsp;</td>
    <td>�����: 
    <select name=���Date_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    �����: <select name=HKKDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	����: <select name=HKKDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
    <table id="extra3" style="display: none">
    <tr>
    <td>���������� ����������� ������������� ������&nbsp;&nbsp;&nbsp;</td>
    <td>�����: 
    <select name=TransplantDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    �����: <select name=TransplantDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	����: <select name=TransplantDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
    </td>
    </tr>
    </table>
<?
if (($entry == -1) || ($entry['XroniaHBV'] == 0) || ($entry['KirosiDate'] == NULL) || ($entry['NonKirosiDate'] == NULL) || ($entry['HKKDate'] == NULL) || ($entry['TransplantDate'] == NULL))
{
?>      
<INPUT TYPE="SUBMIT" VALUE="���������� ���������">
<?
} ?>
</FORM>
<?
if ($has_entry)
{
?>
<form method="GET" action="clinical_status_delete.php">
<input type=hidden name='code' value='<? echo $_GET['code'] ?>' />
<input type=hidden name='table' value='hbv_clinical_status' />
<h3>'��� ������������� �������� �����������</h3>
<table>
<th>��������</th><th>������� ���������</th><th>���������� ��������������</th>
<? 
if ($entry['XroniaHBV'] == 1)
{
?>
<tr>
<td align=center><input type="checkbox" name="xronia"></td><td>&nbsp;&nbsp; ������ HBV ������� &nbsp;&nbsp;</td><td align=center></td>
</tr>
<?
} 
if ($entry['KirosiDate'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="kirosi"></td><td>&nbsp;&nbsp; �������������� ������� &nbsp;&nbsp;</td><td align=center><? echo $entry['KirosiDate'] ?></td>
</tr>
<?
}
if ($entry['NonKirosiDate'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="nonkirosi"></td><td>&nbsp;&nbsp; �� �������������� ������� &nbsp;&nbsp;</td><td align=center><? echo $entry['NonKirosiDate'] ?></td>
</tr>
<?
}  
if ($entry['Askitis'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="askitis"></td><td>&nbsp;&nbsp; �� �������������� ������� - ������� &nbsp;&nbsp;</td><td align=center><? echo $entry['Askitis'] ?></td>
</tr>
<?
}
if ($entry['Kirsoi'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="kirsoi"></td><td>&nbsp;&nbsp; �� �������������� ������� - ���������� ��� ������� &nbsp;&nbsp;</td><td align=center><? echo $entry['Kirsoi'] ?></td>
</tr>
<?
}    
if ($entry['Egkefalopatheia'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="egkefalopatheia"></td><td>&nbsp;&nbsp; �� �������������� ������� - �������������� ������� &nbsp;&nbsp;</td><td align=center><? echo $entry['Egkefalopatheia'] ?></td>
</tr>
<?
}  
if ($entry['Nefriki'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="nefriki"></td><td>&nbsp;&nbsp; �� �������������� ������� - ������������ �������� &nbsp;&nbsp;</td><td align=center><? echo $entry['Nefriki'] ?></td>
</tr>
<?
}  
if ($entry['Peritonitis'] != NULL)
{
?>
<tr>
<td align=center><input type="checkbox" name="peritonitis"></td><td>&nbsp;&nbsp; �� �������������� ������� - ����������� &nbsp;&nbsp;</td><td align=center><? echo $entry['Peritonitis'] ?></td>
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
<td align=center><input type="checkbox" name="transplant"></td><td>&nbsp;&nbsp; ������������ ������ &nbsp;&nbsp;</td><td align=center><? echo $entry['TransplantDate'] ?></td>
</tr>
<?
} 
if ($entry['Anosia'] == 1)
{
?>
<tr>
<td align=center><input type="checkbox" name="anosia"></td><td>&nbsp;&nbsp; ������ ������ &nbsp;&nbsp;</td><td align=center></td>
</tr>
<?
} 
if ($entry['Emboliasmos'] == 1)
{
?>
<tr>
<td align=center><input type="checkbox" name="emboliasmos"></td><td>&nbsp;&nbsp; ���������� ����������� &nbsp;&nbsp;</td><td align=center></td>
</tr>
<?
} ?>
</table>
<br>
<INPUT TYPE="SUBMIT" VALUE="�������� ���������">
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
	if ((value == 3) || (value == 8) || (value == 9) || (value == 10) || (value == 11) || (value == 12))
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
		alert("������ �� ��������� ��� ������� ��������� ��� ��� ������!");
		return false;
	}
	else if ((document.all.State.value == "2") && (document.all.KirosiDate_year.value == ""))
	{
		alert("������ �� ������ ��� ���� ��� ����� ���� ���� ���������� �������������� ��������������� ��������!");
		return false;		
	}
	else if (((document.all.State.value == "3") || (document.all.State.value == "8") || (document.all.State.value == "9") || (document.all.State.value == "10") || (document.all.State.value == "11") || (document.all.State.value == "12")) && (document.all.NonKirosiDate_year.value == ""))
	{
		alert("������ �� ������ ��� ���� ��� ����� ���� ���� ���������� �������������� �� ��������������� ��������!");
		return false;		
	}	
	else if ((document.all.State.value == "4") && (document.all.HKKDate_year.value == ""))
	{
		alert("������ �� ������ ��� ���� ��� ����� ���� ���� ���������� �������������� ���!");
		return false;		
	}
	else if ((document.all.State.value == "5") && (document.all.TransplantDate_year.value == ""))
	{
		alert("������ �� ������ ��� ���� ��� ����� ���� ���� ���������� ����������� ������������� ������!");
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