<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>���������� ������������� ���������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//form_data2table($_POST);
//die;
$reasons_query = "SELECT * FROM antiretro_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons_num = mysql_num_rows($reason_result);
	$reasons_str = "";
	for ($r=0; $r<$reasons_num; $r++)
	{
    	$row = mysql_fetch_assoc($reason_result);
		if ($r <> 95)
    	{
    		$reasons_str .= "<option value='".$row['id']."'>".$row['id']."</option>\n";
    	}
    	$reasons[$row['id']] = $row['description'];
    }
	mysql_free_result($reason_result);

if (isset($_POST['special_end_set'])) 
{
//	echo "hello";
$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$_POST['code']." AND antiretro_treatments.Medicine=medicines.ID";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $therapies[0] = -1;
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies[$j]['med_id'] = $row['med_id'];
            $therapies[$j]['med'] = $row['med'];
            $therapies[$j]['start'] = $row['StartDate'];
            $therapies[$j]['end'] = $row['EndDate'];
        }
    }
mysql_free_result($result);


for ($i=0; $i< count($therapies); $i++)
{
	$old_dates[2*$i] = $therapies[$i]['start'];
	$old_dates[2*$i+1] = $therapies[$i]['end'];
}
$temp = array_unique($old_dates);
$old_dates = array_values($temp);
sort($old_dates);
reset($old_dates);
for ($i=0; $i < 2*count($therapies)-1; $i++)
{
	for ($j=0; $j < count($therapies); $j++)
	{
		if ($old_dates[$i] == $therapies[$j]['start'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}
		if ($old_dates[$i] > $therapies[$j]['start'] && $old_dates[$i] <= $therapies[$j]['end'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}		
		if ($old_dates[$i] >= $therapies[$j]['end'])
		{
			$old_schema[$i] = str_replace($therapies[$j]['med']. " / ", "", $old_schema[$i]);
		}
	}
	$old_schema[$i] = substr($old_schema[$i], 0, strlen($old_schema[$i])-3);
}

echo "<P><B> ������������ ����� ���� ��� �����������</B></P>";

$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_treatments_compliance.Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_treatments_compliance WHERE PatientCode=".$_POST['code']." GROUP BY antiretro_treatments_compliance.StartDate";
$result = execute_query($sql);
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_POST['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>������������<BR>�����</th>";
	echo "<th class=result>����������<BR>�������</th>";
	echo "<th class=result>����������<BR>��������</th>";
	echo "<th class=result>����������<BR>��������</th>";
	echo "<th class=result>�����<BR>�������� 1</th>";
	echo "<th class=result>�����<BR>�������� 2</th>";
	echo "<th class=result>����������</th>";
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; ��� �������� ������������ ��������!</p>";
    }
    else
    {
        $jj = 0;
    	for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            $extra[$j]['start'] = $resultrow['StartDate'];
            $extra[$j]['end'] = $resultrow['EndDate'];
            echo "<tr>\n";
            $k = 0;
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "PatientCode")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
                		echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                	}
                	else if ($field->name == "Schema")
                	{
                		if ($old_schema[$jj] == "")
                		{
                			$jj++;
                		}
                		echo "<td class=result style='width: 150px'>".$old_schema[$jj]."</td>";
                		$jj++;
                	}
                	else if ($field->name == "Compliance")
                	{
                		echo "<td class=result>";
                		if ($resultrow[$field->name] == "-1")
                		{
                			echo "'�������";
                		}
                		if ($resultrow[$field->name] == "1")
                		{
                			echo "����";
                		}
                		if ($resultrow[$field->name] == "2")
                		{
                			echo "������";
                		}
                		if ($resultrow[$field->name] == "3")
                		{
                			echo "����";
                		}
                		echo "</td>";
                	}
                	else if ($field->name == "Reason1" || $field->name == "Reason2")
                	{
                		echo "<td class=result>".$reasons[$resultrow[$field->name]]."</td>";
                	}
                	else 
                 	{
                		echo "<td class=result>".$resultrow[$field->name]."</td>";
                	}
                }
             	$i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
    }
	
for ($i=0; $i< $_POST['number']; $i++)
{
	$sql = stripslashes($_POST['query'.$i]);
//	echo $sql."<BR>";
$what_happened = execute_query($sql);
}
for ($i=0; $i< $_POST['comp_number']; $i++)
{
	$sql = stripslashes($_POST['comp_query_'.$i]);
	$sql .= "'".$_POST['comp'.$i]."', '".$_POST['Reason1_'.$i]."', '".$_POST['Reason2_'.$i]."', ";
	$sql .= "'".$_POST['Note'.$i]."');";
//	echo $sql."<BR>";
	$what_happened = execute_query($sql);
}    

$therapies = array();
$old_dates = array();
$old_schema = array();

$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$_POST['code']." AND antiretro_treatments.Medicine=medicines.ID";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $therapies[0] = -1;
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies[$j]['med_id'] = $row['med_id'];
            $therapies[$j]['med'] = $row['med'];
            $therapies[$j]['start'] = $row['StartDate'];
            $therapies[$j]['end'] = $row['EndDate'];
        }
    }
mysql_free_result($result);

if ($therapies[0] == -1)
{
	$delete_all = 1;
	$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_reasons.description as Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_reasons, antiretro_treatments_compliance WHERE antiretro_reasons.id=antiretro_treatments_compliance.Reason1 AND PatientCode=".$_POST['code']." GROUP BY antiretro_treatments_compliance.StartDate";
	$result = execute_query($sql);
	$num_rows = mysql_num_rows($result);
	for ($j=0; $j<$num_rows; $j++)
	{
		
		$resultrow = mysql_fetch_assoc($result);
		$extra[$j]['start'] = $resultrow['StartDate'];
        $extra[$j]['end'] = $resultrow['EndDate'];
		$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_POST['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";	
		execute_query($sql);
//		echo "<p>$sql</p>";
//		echo "<p>".mysql_error()."</p>";
	}
	perform_post_insert_actions("delete_all_antiretro", "antiretro.php?code=".$_POST['code'], "");	
}
else
{
$delete_all = 0;
for ($i=0; $i< count($therapies); $i++)
{
	$old_dates[2*$i] = $therapies[$i]['start'];
	$old_dates[2*$i+1] = $therapies[$i]['end'];
}
$temp = array_unique($old_dates);
$old_dates = array_values($temp);
sort($old_dates);
reset($old_dates);
for ($i=0; $i < 2*count($therapies)-1; $i++)
{
	for ($j=0; $j < count($therapies); $j++)
	{
		if ($old_dates[$i] == $therapies[$j]['start'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}
		if ($old_dates[$i] > $therapies[$j]['start'] && $old_dates[$i] <= $therapies[$j]['end'])
		{
			$old_schema[$i] .= $therapies[$j]['med'] . " / ";
		}		
		if ($old_dates[$i] >= $therapies[$j]['end'])
		{
			$old_schema[$i] = str_replace($therapies[$j]['med']. " / ", "", $old_schema[$i]);
		}
	}
	$old_schema[$i] = substr($old_schema[$i], 0, strlen($old_schema[$i])-3);
}
echo "<P><B> ������������ ����� ���� ��� �����������</B></P>";

	$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_reasons.description as Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_reasons, antiretro_treatments_compliance WHERE antiretro_reasons.id=antiretro_treatments_compliance.Reason1 AND PatientCode=".$_POST['code']." GROUP BY antiretro_treatments_compliance.StartDate";
	$result = execute_query($sql);
	$num_rows = mysql_num_rows($result);
	for ($j=0; $j<$num_rows; $j++)
	{
		
		$resultrow = mysql_fetch_assoc($result);
		$extra[$j]['start'] = $resultrow['StartDate'];
        $extra[$j]['end'] = $resultrow['EndDate'];
		$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_POST['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";	
		execute_query($sql);
//		echo "<p>$sql</p>";
//		echo "<p>".mysql_error()."</p>";
	}	

?>
<FORM action=delete_antiretro_data_step2.php method="POST">
<? 
echo "<P><B> ������ �� ������������ ����� ������, ����� ��� ���������� ��� ��� ������ �������� ��� �� ��� ������������ ����� </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>������������ �����</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>������� �������� ���������</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>���������� ��������</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>�����<BR>�������� 1</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>�����<BR>�������� 2</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>����������</TH>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
 if ($old_schema[$i] != "")
 {	
	echo "<TR><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".$old_schema[$i]."</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>��� ".show_date($old_dates[$i]);
	if ($old_dates[$i+1] == "3000-01-01")
	{
		echo "</TD>";
	}
	else
	{
		echo " ��� ".show_date($old_dates[$i+1])."</TD>";
	}
	if ($old_dates[$i+1] != "3000-01-01")
	{
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
		echo "<input type=radio name='comp".$i."' value='-1' checked> '������� <input type=radio name='comp".$i."' value='1'> ���� <input type=radio name='comp".$i."' value='2'> ������ <input type=radio name='comp".$i."' value='3'> ����</TD>";
?>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <select name=Reason1_<?echo $i?>>
    <option value="99" selected>99</option>
    <? echo $reasons_str; ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./antiretro_reasons.php?field=Reason1_<?echo $i?>', '�����', 'width=500,height=500,status=yes');"/>
    </TD>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <select name=Reason2_<?echo $i?>>
    <option value="99" selected>99</option>
    <? echo $reasons_str; ?>
    </select>
    <img src="./images/b_help.png" style="cursor: default" onclick="window.open('./antiretro_reasons.php?field=Reason2_<?echo $i?>', '�����', 'width=500,height=500,status=yes');"/>
    </TD>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <textarea name=Note<?echo $i?> STYLE="overflow:hidden"></textarea>
    </TD>
    
<?	
	}
	else
	{
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center> - </TD>";
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center> - </TD>";
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center> - </TD>";
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center><BR><BR></TD>";
	}
	echo "</TR>";
 }
}
echo "</TABLE>";
}

$schemas = count($old_dates)-1;
echo "<input type=hidden name=schemas value=".$schemas.">";
?>

<? 

for ($j=0; $j< $schemas; $j++)
{
	echo "\n<input type=hidden name='comp_query_$j' value=\"";
	echo "INSERT INTO antiretro_treatments_compliance VALUES('".$_POST['code']."', '".$old_schema[$j]."', '".$old_dates[$j]."', '".$old_dates[$j+1]."', ";
	echo "\" >\n";
}

?>
<br>
<input type="hidden" name=code value=<? echo $_POST['code']; ?>>
<input type="hidden" name=number value=<? echo $i; ?>>
<input type="hidden" name="comp_number" value=<? echo $j; ?>>
<input type="submit" value="���������� ���������" />
</form>
<?	
    
}
else
{

$sql="";
// INSERT Medicines in table antiretro_treatments
for ($i=0; $i< $_POST['number']; $i++)
{
	$sql = stripslashes($_POST['query'.$i]);
//	echo $sql."<BR>";
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
//        echo "<P>�� �������� ������������� �� ��������!</P>";
    }
else
    {
//        echo "<P>$what_happened</P>";
    }
}
//form_data2table($_POST);
// INSERT Medicine Schemas with Compliance and Unwanted Sideeffects
for ($i=0; $i< $_POST['comp_number']; $i++)
{
	$sql = stripslashes($_POST['comp_query_'.$i]);
	$sql .= "'".$_POST['comp'.$i]."', '".$_POST['Reason1_'.$i]."', '".$_POST['Reason2_'.$i]."', ";
	$sql .= "'".$_POST['Note'.$i]."');";
//	echo $sql."<BR>";
	$what_happened = execute_query($sql);
	if ($what_happened == 1)
    {
//        echo "<P>�� �������� ������������� �� ��������!</P>";
    }
	else
    {
//        echo "<P>$what_happened</P>";
    }
}
perform_post_insert_actions("", "fix_antiretro.php?code=".$_POST['code'], "");

}
mysql_close($dbconnection);

//perform_post_insert_actions("antiretro_treatments", "antiretro.php?code=".$_POST['code'], "");
?>
<!--
<p><a href="javascript:location.href = 'antiretro.php?code=<?echo $_POST['code']?>';">����� click ��� ��� �� �������� ��� ���� �������� ������������� ��������� </a></p>
-->
</BODY></HTML>
