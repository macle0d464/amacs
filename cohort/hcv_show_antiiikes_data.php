<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
require_once('Date/Calc.php');
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

check_patient($_GET['code']);
show_patient_data($_GET['code']);

// Parse data from form

$medicine_query = "SELECT ID,Name,Category FROM hcv_medicines";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$i]['id'] = $row['ID'];
	$medicine_array[$i]['name'] = $row['Name'];
	$medicine_array[$i]['category'] = $row['Category'];
}

$reasons_query = "SELECT * FROM hcv_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['ID']] = $row['Reason'];
}

echo "<p><a href='hcv_antiiikes.php?code=".$_GET['code']."'><b>��������� ���� ���������� ���������</b></a></p><p>&nbsp;<p>";

$query = "SELECT * FROM hcv_antiiikes_treatments_antapokrisi WHERE PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
if ($num_rows == 0)
{
	$therapies[0] = -1;
}
if ($therapies[0] == -1 && !$previous_med)
{
	echo "<h2>��� �������� ������������� ����-����� ��������� ��� ��� ������ ".$_GET['code']."</h2>";
}
else
{
	echo "<P><B> ��� ������������ ������������ ����� </B></P>";
	echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>��������</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>������������ �����</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>������� �������� ���������</TH>";
	for ($i=0; $i<$num_previous_med; $i++)
	{
		$row = mysql_fetch_array($result_temp);	
		echo "<TR><TD align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_previous_med(\"".$row[0]."\");'></TD><TD class=result>".$row[0]."</TD><TD class=result align=center> <i>(��� ��������)</i></TD></TR>";
	}
	for ($i=0; $i<$num_rows; $i++)
	{
	$schema_row = mysql_fetch_assoc($result);
	echo "<TR>";
	echo "<TD align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_schema(\"".$schema_row['Schema']."\", \"".$schema_row['StartDate']."\", \"".$schema_row['EndDate']."\");'>";
	echo "<TD class=result>".$schema_row['Schema']."</TD>";
	echo "<TD class=result align=center> ��� ".show_date($schema_row['StartDate']);
	if ($schema_row['EndDate'] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " ��� ".show_date($schema_row['EndDate'])."</TD></TR>";
	}
}
echo "</TABLE>";


echo "<p>&nbsp;</p>";
echo "<P><B> ������������ ����-���� ������� </B></P>";
$sql = "SELECT hcv_antiiikes_treatments.medicine as medicineid, hcv_medicines.Name as Medicine, StartDate, EndDate FROM hcv_antiiikes_treatments, hcv_medicines WHERE hcv_antiiikes_treatments.Medicine = hcv_medicines.ID AND PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($sql);
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>�������</th>";
	echo "<th class=result>����������<BR>�������</th>";
	echo "<th class=result>����������<BR>��������</th>";
	echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; ��� �������� ������������ ��������!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "medicineid" && $field->name != "reasonid")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
						if ($resultrow[$field->name] == "3000-01-01")
						{
							echo "<td class=result  style='cursor: pointer'></td>";
						}
						else
						{
                			echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
						}                		
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
}

echo "<p>&nbsp;</p>";

echo "<P><B> ������������� ������ �������� </B></P>";
$sql = "SELECT Medicine, Dosage1, Dosage1Type, Dosage2Type, StartDate, EndDate, link_id FROM hcv_antiiikes_treatments_dosages WHERE PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($sql);
    echo "<input type=hidden name=therapy_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    echo "<th class=result> �������� </th>";
    echo "<th class=result> ������ </th>";
	echo "<th class=result>�������</th>";
	echo "<th class=result>����</th>";
	echo "<th class=result>����������<BR>�������</th>";
	echo "<th class=result>����������<BR>��������</th>";
	echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; ��� �������� ������������ ��������!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
			echo "<td align=center> <img src='./images/b_edit.png' ";
            echo "onclick='location.href=\"hcv_add_dosage.php?code=".$_GET['code']."&Medicine=".$resultrow['Medicine']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."&link_id=".$resultrow['link_id']."\";' style='cursor:pointer;'>";            
            echo "<td align=center> <img src='./images/b_edit.png' ";
            echo "onclick='location.href=\"hcv_edit_dosage.php?code=".$_GET['code']."&Medicine=".$resultrow['Medicine']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."&link_id=".$resultrow['link_id']."\";' style='cursor:pointer;'>";
			echo "<td class=result>".$resultrow['Medicine']."</td>";
			echo "<td class=result>";
			echo show_dec($resultrow['Dosage1'])." ".$resultrow['Dosage1Type'];
			if ($resultrow['Dosage1'] != "")
			{
				echo " ~ ";
			}
			else 
			{
				echo " - ";
			}
			switch ($resultrow['Dosage2Type'])
			{
				case '1':
					echo "1 ���� ��� ��������";
					break;
				case '2':
					echo "2 ����� ��� ��������";
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
			echo "</td>";
            echo "<td class=result>".show_date($resultrow['StartDate'])."</td>";
            if ($resultrow['EndDate'] == "3000-01-01")
            {
            		echo "<td class=result> - </td>";
            }
            else
            {
            	echo "<td class=result>".show_date($resultrow['EndDate'])."</td>";
            }
            echo "</tr>\n";
        }
        echo "</table>";
    }



echo "<p>&nbsp;</p>";

echo "<P><B> ����������-��������� ������������� ��� ����� �������� ���������</B></P>";
$sql = "SELECT hcv_antiiikes_treatments_antapokrisi.Schema, hcv_antiiikes_treatments_antapokrisi.StartDate, hcv_antiiikes_treatments_antapokrisi.EndDate,";
$sql .= " hcv_antiiikes_treatments_antapokrisi.Bioximiki_polu_prwimi, hcv_antiiikes_treatments_antapokrisi.Bioximiki_prwimi, hcv_antiiikes_treatments_antapokrisi.Bioximiki_24, hcv_antiiikes_treatments_antapokrisi.Bioximiki_end, hcv_antiiikes_treatments_antapokrisi.Bioximiki_longterm,";
$sql .= " hcv_antiiikes_treatments_antapokrisi.Iologiki_polu_prwimi, hcv_antiiikes_treatments_antapokrisi.Iologiki_prwimi, hcv_antiiikes_treatments_antapokrisi.Iologiki_24, hcv_antiiikes_treatments_antapokrisi.Iologiki_end, hcv_antiiikes_treatments_antapokrisi.Iologiki_longterm,";
$sql .=  " hcv_antiiikes_treatments_antapokrisi.Info1, hcv_antiiikes_treatments_antapokrisi.Info2, hcv_antiiikes_treatments_antapokrisi.Notes FROM hcv_antiiikes_treatments_antapokrisi WHERE PatientCode=".$_GET['code']." GROUP BY hcv_antiiikes_treatments_antapokrisi.StartDate";
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_antiiikes_data.php'>";
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
	echo "<th class=result>��������<br>������</th>";
	echo "<th class=result>�����</th>";
	echo "<th class=result>����������<BR>�������</th>";
	echo "<th class=result>����������<BR>��������</th>";
	echo "<th class=result>���������<BR>�����������</th>";
	echo "<th class=result>��������<BR>�����������</th>";
	echo "<th class=result>����������<BR>���������</th>";
	echo "<th class=result>�����<BR>��������</th>";
	echo "<th class=result>����������</th>";
    echo "</tr>\n";
    $i = 0;
	$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; ��� �������� ������������ ��������!</p>";
    }
    else
    {
		$today = getdate();
		$now_days = round(strtotime("now")/86400);
    	for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_schema(\"".$resultrow['Schema']."\", \"".$resultrow['StartDate']."\", \"".$resultrow['EndDate']."\");'><br><br><img src='./images/b_edit.png' style='cursor: pointer' ";
            echo "onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";'>";
            echo "<td class=result style='width: 150px'>".$resultrow['Schema']."</td>";
            echo "<td class=result>".show_date($resultrow['StartDate'])."</td>";
       		echo "<td class=result>";
       		if ($resultrow['EndDate'] != "3000-01-01")
       		{ 
       		echo show_date($resultrow['EndDate']);
        	}
        	else 
        	{
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
        	}
       		echo "</td>";                	
			echo "<td class=result>";
?>
			<center><u><b>�����������:</b></u></center>
			<table>
<?			
			$th_days = round(strtotime($resultrow['StartDate'])/86400);
			echo "<tr><td>���� ������:<BR><i>(4 ���������)</i>&nbsp;</td><td>";
			if ($resultrow['Bioximiki_polu_prwimi'] != -1)
			{
				if ($resultrow['Bioximiki_polu_prwimi'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Bioximiki_polu_prwimi'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}
			}
			elseif ($now_days >= $th_days+28)
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}			
			echo "<tr><td>������:<BR><i>(12 ���������)</i>&nbsp;</td><td>";
			if ($resultrow['Bioximiki_prwimi'] != -1)
			{
				if ($resultrow['Bioximiki_prwimi'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Bioximiki_prwimi'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}				
			}
			elseif ($now_days >= $th_days+84)
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}
			echo "<tr><td>24 ���o�����:<BR><i>(12���� ��������)</i>&nbsp;</td><td>";
			if ($resultrow['Bioximiki_24'] != -1)
			{
				if ($resultrow['Bioximiki_24'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Bioximiki_24'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}					
			}
			elseif ($now_days >= $th_days+168)
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}
			echo "<tr><td>��� ����� ���������:&nbsp;</td><td>";
			if ($resultrow['Bioximiki_end'] != -1)
			{
				if ($resultrow['Bioximiki_end'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Bioximiki_end'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}				
			}
			elseif ($resultrow['EndDate'] != "3000-01-01")
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}
			echo "<tr><td><b>�����������:</b>&nbsp;<i><BR>(6 ����� ����<BR>��� �������)</i></td><td>";
			$th_days_end = round(strtotime($resultrow['EndDate'])/86400);
			if ($resultrow['Bioximiki_longterm'] != -1)
			{
				if ($resultrow['Bioximiki_longterm'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Bioximiki_longterm'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}					
			}
			elseif (($resultrow['EndDate'] != "3000-01-01") && ($now_days >= $th_days_end+182))
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}			
?>
			</table>
<?			
			echo "</td>";                	
			echo "<td class=result>";
?>
			<center><u><b>�����������:</b></u></center>
			<table>
<?			
			$th_days = round(strtotime($resultrow['StartDate'])/86400);
			echo "<tr><td>���� ������:<BR><i>(4 ���������)</i>&nbsp;</td><td>";
			if ($resultrow['Iologiki_polu_prwimi'] != -1)
			{
				if ($resultrow['Iologiki_polu_prwimi'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Iologiki_polu_prwimi'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}
			}
			elseif ($now_days >= $th_days+28)
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}			
			echo "<tr><td>������:<BR><i>(12 ���������)</i>&nbsp;</td><td>";
			if ($resultrow['Iologiki_prwimi'] != -1)
			{
				if ($resultrow['Iologiki_prwimi'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Iologiki_prwimi'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}				
			}
			elseif ($now_days >= $th_days+84)
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}
			echo "<tr><td>24 ���o�����:<BR><i>(12���� ��������)</i>&nbsp;</td><td>";
			if ($resultrow['Iologiki_24'] != -1)
			{
				if ($resultrow['Iologiki_24'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Iologiki_24'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}					
			}
			elseif ($now_days >= $th_days+168)
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}
			echo "<tr><td>��� ����� ���������:&nbsp;</td><td>";
			if ($resultrow['Iologiki_end'] != -1)
			{
				if ($resultrow['Iologiki_end'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Iologiki_end'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}				
			}
			elseif ($resultrow['EndDate'] != "3000-01-01")
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}
			echo "<tr><td><b>�����������</b>:&nbsp;<i><BR>(6 ����� ����<BR>��� �������)</i></td><td>";
			$th_days_end = round(strtotime($resultrow['EndDate'])/86400);
			if ($resultrow['Iologiki_longterm'] != -1)
			{
				if ($resultrow['Iologiki_longterm'] == 1)
				{
					echo "<b>NAI</b></td></tr>";
				}
				else if ($resultrow['Iologiki_longterm'] == 0)
				{
					echo "<b>OXI</b></td></tr>";
				}
				else
				{
					echo "<b>�������</b></td></tr>";
				}					
			}
			elseif (($resultrow['EndDate'] != "3000-01-01") && ($now_days >= $th_days_end+182))
			{ 
				echo "<div onclick='location.href=\"hcv_edit_antiiikes_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";' style='cursor:pointer; background-color:#ffb1b1'>";
				echo "<font color='blue'>��������</font> <img src='./images/b_edit.png'></div>";
			}
			else
			{
				echo "-</td></tr>";
			}			
?>
			</table>
<?			
			echo "</td>";                	

            echo "<td class=result align=center>";
            if ($resultrow['Info1'] == 1)
            {
            	echo "NAI";
            }
            else if ($resultrow['Info1'] == 2)
            {
            	echo "OXI";
            }
            echo "</td>";
            echo "<td class=result>".$reasons[$resultrow['Info2']]."</td>";
            echo "<td class=result>".$resultrow['Notes']."</td>";
            $i++;
        }
            echo "</tr>\n";
    }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//        echo " <input type=submit value='������'></p>";
        echo "</form>";
    

echo "<p>&nbsp;</p>";

mysql_close($dbconnection);
?>

<script>
function delete_entry(link)
{
	location.href = "delete_with_query.php?table=hcv_show_antiiikes_data.php&code=<? echo $_GET['code']?>&query=" + link;
}

function delete_schema(schema, start, end)
{
	ok = confirm("����� �������� ��� ������ �� ���������� �� ����� " + schema +";");
	if (ok) {
		location.href = "hcv_delete_schema.php?table=hcv_show_antiiikes_data.php&code=<? echo $_GET['code']?>&schema=" + schema + "&start=" + start + "&end=" + end;
	}
}

function delete_previous_med(med)
{
	ok = confirm("����� �������� ��� ������ �� ���������� �� ������� " + med +";");
	if (ok) {
		query = "DELETE FROM extra_meds WHERE PatientCode=,<? echo $_GET['code']?>, AND Medicine=," + med + ",";
		location.href = "delete_with_query.php?table=hcv_show_antiiikes_data.php&code=<? echo $_GET['code']?>&query=" + query;
	}
}

</script>
</BODY></HTML>
