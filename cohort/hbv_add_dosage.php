<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>�������-������ ����-����� ���������</TITLE>
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
//{ die('������ �� ������ ��� ����� ������ ������!'); }
check_patient($_GET['code']);

echo "<P><B> �������� ����� ��� �� ������� ".$_GET['Medicine']."</B></P>";
$sql = "SELECT * FROM hbv_antiiikes_treatments_dosages WHERE StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."' AND Medicine='".$_GET['Medicine']."' AND link_id='".$_GET['link_id']."' AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
$row = mysql_fetch_assoc($result);
echo mysql_error();
    echo "<form method=get action='hbv_add_dosage_insert.php' onsubmit='return check_data();'>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<input type=hidden name=start1 value=".$_GET['start'].">";
    echo "<input type=hidden name=end2 value=".$_GET['end'].">";
    echo "<input type=hidden name=link_id value=".$_GET['link_id'].">";
    echo "<input type=hidden name=Medicine value=".$_GET['Medicine'].">";
    echo "<b>1� ����:</b>";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>�������</th>";
	echo "<td class=result>".$_GET['Medicine']."</td>";
	echo "</tr>\n";
	echo "<th class=result>����������<BR>�������</th>";
	echo "<td class=result>".show_date($row['StartDate'])."</td>";
	echo "</tr>\n";	
	echo "<th class=result>����������<BR>��������</th>";
	echo "<td class=result>";
?>
	�����: <select name="EndDate1_day" onchange="document.all.StartDate2_day.value=this.value">
 	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    �����: <select name="EndDate1_month" onchange="document.all.StartDate2_month.value=this.value">
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    ����: <select name="EndDate1_year" onchange="document.all.StartDate2_year.value=this.value">
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select>
<?	
	echo "</td></tr><tr>";
	echo "<th class=result>����</th>";
	echo "<td class=result>";
	echo $row['Dosage1']." ".$row['Dosage1Type'];
	echo " ~ ";
	switch ($row['Dosage2Type'])
	{
		case '1':
			echo "1 ���� ��� ��������";
			break;
		case '2':
			echo "1 ����� ��� ��������";
			break;
		case '3':
			echo "3 ����� ��� ��������";
			break;
		case '4':
			echo "4 ����� ��� ��������";
			break;
		case '5':
			echo "5 ����� ��� ��������";
			break;
		case '6':
			echo "6 ����� ��� ��������";
			break;
		case '7':
			echo "����������";
			break;
	}	
	echo "<td>";
	echo "</tr></table>";
    echo "<b>2� ����:</b>";
	echo "<table>";
	echo "<th class=result>�������</th>";
	echo "<td class=result>".$_GET['Medicine']."</td>";
	echo "</tr>\n";
	echo "<th class=result>����������<BR>�������</th>";
	echo "<td class=result>";
?>
	�����: <input name="StartDate2_day" onfocus="blur();" size=2>&nbsp;
    �����: <input name="StartDate2_month" onfocus="blur();" size=2>&nbsp;
    ����: <input name="StartDate2_year" onfocus="blur();" size=4>
<?	
	echo "<tr><th class=result>����������<BR>�����</th>";
	echo "<td class=result>".show_date($row['EndDate'])."</td>";
	echo "</tr>\n";	
	echo "<th class=result>����</th>";
	echo "<td class=result>";
	$name = $_GET['Medicine'];
?>	
	<input name="dosage1<?echo $id?>" size=2> 
 	<select name="dosage1type<?echo $id?>">
 	<?
 	if ($name == "IFN�") 
 	{
 	?>
    <option value="MU">MU</option>
	<option value="mg">mg</option>
    <?
	}
	else if ($name == "PEG-IFN�-2�")
 	{
 	?>
 	<option value="�g">�g</option>

    <?
	}
	else if ($name == "PEG-IFN�-2b")
 	{
 	?> 	
 	<option value="�g">�g</option>
 	<option value="�g/kg">�g/Kg</option>
    <?
	}
	else
	{
	?>
 	<option value="mg">mg</option>
	<?
	}
 	?> 	
 	</select>
 	/ 
 	<select name="dosage2type<?echo $id?>">
 	<option value="1">1 ���� / ���.</option>
 	<option value="2">2 ����� / ���.</option>
	<?
//	if ($name != "Amantadine")
// 	{
 	?> 	 	
 	<option value="3">3 ����� / ���.</option>
 	<option value="4">4 ����� / ���.</option>
 	<option value="5">5 ����� / ���.</option>
 	<option value="6">6 ����� / ���.</option>
 	<option value="7">����������</option>
 	<?
 //	}
	echo "</td>";
    echo "</tr>\n";
    echo "</table>";
    echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <input type=submit value='�������� �����'></p>";
    echo "</form>";
    

echo "<p>&nbsp;</p>\n";
//print_r($resultrow);
?>
<script>
function check_data()
{
	if (document.all.StartDate2_year.value == "")
	{
		alert("������ �� ������������ �� ���� ��� �����!");
		return false;
	}
	if (document.all.StartDate2_month.value == "")
	{
		temp = document.all.StartDate2_year.value + "-07-01";
	}
	else
	{
		if (document.all.StartDate2_day.value == "")
		{
			temp = document.all.StartDate2_year.value + "-" + document.all.StartDate2_month.value +"-15";
		}
		else
		{
			temp = document.all.StartDate2_year.value + "-" + document.all.StartDate2_month.value +"-" + document.all.StartDate2_day.value;
		}
	}
	if (temp < "<?echo $row['StartDate']?>")
	{
		alert("� ���������� ��� ������ ��� ����� ������� ���� ���� ��� �� ����� ��� �����!");
		return false;
	}
	if (temp > "<?echo $row['EndDate']?>")
	{
		alert("� ���������� ��� ������ ��� ����� ������� ���� ���� ��� �� ����� ��� �����!");
		return false;
	}

}
</script>
<?
mysql_close($dbconnection);
?>
</BODY></HTML>
