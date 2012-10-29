<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Στοιχείων Ατομικού Αναμνηστικού Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css"></HEAD>
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
//form_data2table($_GET);
check_patient($_GET['code']);

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

$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$_GET['code']." AND antiretro_treatments.Medicine=medicines.ID";
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

echo "<P><B> Φαρμακευτικό σχήμα πριν τη διαγραφή των φαρμάκων</B></P>";
/*
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
	echo "<TR>";
	echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
	echo $old_schema[$i];
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".show_date($old_dates[$i]);
	if ($old_dates[$i+1] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " εως ".show_date($old_dates[$i+1])."</TD></TR>";
	}
}
echo "</TABLE>";
*/

$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_reasons.description as Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_reasons, antiretro_treatments_compliance WHERE antiretro_reasons.id=antiretro_treatments_compliance.Reason1 AND PatientCode=".$_GET['code']." GROUP BY antiretro_treatments_compliance.StartDate";
$result = execute_query($sql);
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>Φαρμακευτικό<BR>Σχήμα</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "<th class=result>Συμμόρφωση<BR>Ασθενούς</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής 1</th>";
	echo "<th class=result>Αιτία<BR>Διακοπής 2</th>";
	echo "<th class=result>Σημειώσεις</th>";
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
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
                			echo "'Αγνωστη";
                		}
                		if ($resultrow[$field->name] == "1")
                		{
                			echo "Κακή";
                		}
                		if ($resultrow[$field->name] == "2")
                		{
                			echo "Μέτρια";
                		}
                		if ($resultrow[$field->name] == "3")
                		{
                			echo "Καλή";
                		}
                		echo "</td>";
                	}
                	else if ($field->name == "Reason2")
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

if (isset($_GET['therapy_count']))
{
	for ($i=0; $i < $_GET['therapy_count']; $i++)
	{
		if (isset($_GET['del_therapy_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `antiretro_treatments` ";
			$sql .= " WHERE PatientCode=". $_GET['code'];
			$sql .= " AND Medicine='". $_GET['del_medicine_id_'.$i]."'";
			$sql .= " AND StartDate='". $_GET['del_therapy_startdate_'.$i]."'";
			$sql .= " AND EndDate='". $_GET['del_therapy_enddate_'.$i]."'";
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
			if ($what_happened == 1)
    		{
//   			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
//    			echo "<P>$what_happened</P>";
			}
 		}
 	}
}

// Cleanup -- Start

$result_all = execute_query("SELECT * FROM `antiretro_treatments` WHERE PatientCode=". $_GET['code']);
$num_rows_all = mysql_num_rows($result_all);
if ($num_rows_all == 0)
{
    execute_query("DELETE FROM `antiretro_treatments_compliance` WHERE PatientCode=". $_GET['code']);
}
mysql_free_result($result_all);

//CleanUp -- Stop

$therapies = array();
$old_dates = array();
$old_schema = array();

$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$_GET['code']." AND antiretro_treatments.Medicine=medicines.ID";
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
	$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_reasons.description as Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_reasons, antiretro_treatments_compliance WHERE antiretro_reasons.id=antiretro_treatments_compliance.Reason1 AND PatientCode=".$_GET['code']." GROUP BY antiretro_treatments_compliance.StartDate";
	$result = execute_query($sql);
	$num_rows = mysql_num_rows($result);
	for ($j=0; $j<$num_rows; $j++)
	{
		
		$resultrow = mysql_fetch_assoc($result);
		$extra[$j]['start'] = $resultrow['StartDate'];
        $extra[$j]['end'] = $resultrow['EndDate'];
		$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";	
		execute_query($sql);
//		echo "<p>$sql</p>";
//		echo "<p>".mysql_error()."</p>";
	}
	perform_post_insert_actions("delete_all_antiretro", "antiretro.php?code=".$_GET['code'], "");	
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
echo "<P><B> Φαρμακευτικό σχήμα μετά τη διαγραφή των φαρμάκων</B></P>";
/*
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
	echo "<TR>";
	echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
	echo $old_schema[$i];
	echo "</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".show_date($old_dates[$i]);
	if ($old_dates[$i+1] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " εως ".show_date($old_dates[$i+1])."</TD></TR>";
	}
}
echo "</TABLE>";
}
*/
	$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_reasons.description as Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_reasons, antiretro_treatments_compliance WHERE antiretro_reasons.id=antiretro_treatments_compliance.Reason1 AND PatientCode=".$_GET['code']." GROUP BY antiretro_treatments_compliance.StartDate";
	$result = execute_query($sql);
	$num_rows = mysql_num_rows($result);
	for ($j=0; $j<$num_rows; $j++)
	{
		
		$resultrow = mysql_fetch_assoc($result);
		$extra[$j]['start'] = $resultrow['StartDate'];
        $extra[$j]['end'] = $resultrow['EndDate'];
		$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";	
		execute_query($sql);
//		echo "<p>$sql</p>";
//		echo "<p>".mysql_error()."</p>";
	}	

?>
<FORM action=delete_antiretro_data_step2.php method="POST">
<? 
echo "<P><B> Επειδή το φαρμακευτικό σχήμα άλλαξε, δώστε την συμμόρφωση και τις αιτίες διακοπής για το νέο φαρμακευτικό σχήμα </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Συμμόρφωση Ασθενούς</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Αιτία<BR>διακοπής 1</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Αιτία<BR>διακοπής 2</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Σημειώσεις</TH>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
 if ($old_schema[$i] != "")
 {	
	echo "<TR><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".$old_schema[$i]."</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".show_date($old_dates[$i]);
	if ($old_dates[$i+1] == "3000-01-01")
	{
		echo "</TD>";
	}
	else
	{
		echo " εως ".show_date($old_dates[$i+1])."</TD>";
	}
	if ($old_dates[$i+1] != "3000-01-01")
	{
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
		echo "<input type=radio name='comp".$i."' value='-1' checked> 'Αγνωστη <input type=radio name='comp".$i."' value='1'> Κακή <input type=radio name='comp".$i."' value='2'> Μέτρια <input type=radio name='comp".$i."' value='3'> Καλή</TD>";
?>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <select name=Reason1_<?echo $i?>>
    <option value="99" selected>99</option>
    <? echo $reasons_str; ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./antiretro_reasons.php?field=Reason1_<?echo $i?>', 'Λόγοι', 'width=500,height=500,status=yes');"/>
    </TD>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <select name=Reason2_<?echo $i?>>
    <option value="99" selected>99</option>
    <? echo $reasons_str; ?>
    </select>
    <img src="./images/b_help.png" style="cursor: default" onclick="window.open('./antiretro_reasons.php?field=Reason2_<?echo $i?>', 'Λόγοι', 'width=500,height=500,status=yes');"/>
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
	echo "INSERT INTO antiretro_treatments_compliance VALUES('".$_GET['code']."', '".$old_schema[$j]."', '".$old_dates[$j]."', '".$old_dates[$j+1]."', ";
	echo "\" >\n";
}

?>
<br>
<input type="hidden" name=code value=<? echo $_GET['code']; ?>>
<input type="hidden" name=number value=<? echo $i; ?>>
<input type="hidden" name="comp_number" value=<? echo $j; ?>>
<input type="submit" value="Αποθήκευση Δεδομένων" />
</form>
<?	
	



mysql_close($dbconnection);
?>
</BODY></HTML>