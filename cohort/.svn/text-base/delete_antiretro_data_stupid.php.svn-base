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
			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
			if ($what_happened == 1)
    		{
    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
    			echo "<P>$what_happened</P>";
			}
 		}
 	}
}

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
echo "<P><B> Ήδη αποθηκευμένο φαρμακευτικό σχήμα </B></P>";
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

$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_reasons.description as Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_reasons, antiretro_treatments_compliance WHERE antiretro_reasons.id=antiretro_treatments_compliance.Reason1 AND PatientCode=".$_GET['code']." GROUP BY antiretro_treatments_compliance.StartDate";
$result = execute_query($sql);
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
        echo "<th class=result> Αλλαγή </th>";
    $i = 0;
/*    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        if ($field->name != "PatientCode")
        {
        	echo "<th class=result>".$field->name . "</th>";
        }
        $i++;
    }
*/
	echo "<th class=result>Σχήμα</th>";
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
            echo "<td align=center> <img src='./images/b_edit.png' style='cursor: pointer' ";
            echo "onclick='location.href=\"edit_antiretro_extra.php?code=".$_GET['code']."&schema=".$old_schema[$j]."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";'>";
            echo "<input type=hidden name='del_schema_".$j."' value='".$resultrow['Schema']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_compliance_".$j."' value='".$resultrow['Compliance']."'></td>\n";
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

/*
$j_schema = 0;
$j_date = 0;    
for ($j=0; $j<$num_rows; $j++)
{
//	if (($old_dates[$i+1] != "3000-01-01") && ($old_schema[$jj] == ""))
	if ($extra[$j]['start'] == $old_dates[$j_date])
	{
		if ($extra[$j]['end'] == $old_dates[$j_date+1])
		{ 
			// OK! entry is valid
		}
		else if ($extra[$j]['end'] > $old_dates[$j_date+1])
		{
//			echo "<p>I need to UPDATE ".$extra[$j]['end']." with ".$old_dates[$j_date+1]."</p>";
			$sql = "UPDATE antiretro_treatments_compliance SET EndDate='".$old_dates[$j_date+1]."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
//			execute_query($sql);
//			echo $sql;
//			echo mysql_error();
		}
	}
	else if ($extra[$j]['start'] < $old_dates[$j_date])
	{
		if ($extra[$j]['end'] == $old_dates[$j_date+1])
		{
//			echo "<p>I need to UPDATE ".$extra[$j]['start']." with ".$old_dates[$j_date]."</p>";
			$sql = "UPDATE antiretro_treatments_compliance SET StartDate='".$old_dates[$j_date]."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
			execute_query($sql);
//			echo $sql;
//			echo mysql_error();			
		}
		else if ($extra[$j]['end'] < $old_dates[$j_date+1])
		{
//			echo "<p>I need to DELETE ".$extra[$j]['start']." and ".$extra[$j]['end']."</p>";
			$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
			execute_query($sql);
//			echo $sql;
//			echo mysql_error();			
			$j--;
		}
	}
	$j_date = $j_date + 2;
}
*/

if ($delete_all)
{
	for ($j=0; $j<$num_rows; $j++)
	{
		$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";	
		execute_query($sql);
	}	
}
//for ($j=0; $j<$num_rows; $j++)
//{
	$j=0;
	for ($i=0; $i<count($old_dates)-1; $i++)
	{
		if ($extra[$j]['start'] == "")
		{
			exit;
		}
		if ($extra[$j]['start'] < $old_dates[$i])
		{
			if ($extra[$j]['end'] <= $old_dates[$i])
			{
				if ($old_schema[$i] != "")
				{
					//We have to delete the entry from $extra[$j]['start'] to $extra[$j]['end']
					$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
					execute_query($sql);
					echo $sql;
					$j++;				
				}
			}
			else if ($extra[$j]['end'] > $old_dates[$i])
			{
				if ($extra[$j]['end'] <= $old_dates[$i+1])
				{
					if ($old_schema[$i] != "")
					{
						// We need to update $extra[$j]['end'] with $old_dates[$i+1]
						$sql = "UPDATE antiretro_treatments_compliance SET EndDate='".$old_dates[$i+1]."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
						execute_query($sql);
						echo $sql;
						$j++;				
					}
				}
				else if ($extra[$j]['end'] > $old_dates[$i+1])
				{
					if ($old_schema[$i] != "")
					{
						// We need to update $extra[$j]['end'] with $old_dates[$i+1] and $extra[$j]['start'] with $old_dates[$i]
						$sql = "UPDATE antiretro_treatments_compliance SET StartDate='".$old_dates[$i]."', EndDate='".$old_dates[$i+1]."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
						execute_query($sql);
						echo $sql;
						$j++;							
					}
				}
			}
		}
		if ($extra[$j]['start'] == $old_dates[$i])
		{
			if ($extra[$j]['end'] > $old_dates[$i+1])
			{
				if ($old_schema[$i] != "")
				{
					// We need to update $extra[$j]['end'] with $old_dates[$i+1]
					$sql = "UPDATE antiretro_treatments_compliance SET EndDate='".$old_dates[$i+1]."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
					execute_query($sql);
					echo $sql;
					$j++;				
				}				
			}
			else if ($extra[$j]['end'] == $old_dates[$i+1])
			{
				//Record is OK don't do anything
			}
		}
		if ($extra[$j]['start'] > $old_dates[$i])
		{
			if ($extra[$j]['end'] > $old_dates[$i])
			{
				//We have to delete the entry from $extra[$j]['start'] to $extra[$j]['end']
				$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
				execute_query($sql);
				echo $sql;
				$j++;				
			}
/*			else
			{
				if ($extra[$j]['end'] == $old_dates[$i+1])
				{
					// We need to update $extra[$j]['start'] with $old_dates[$i+1]
					$sql = "UPDATE antiretro_treatments_compliance SET EndDate='".$old_dates[$i+1]."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
					execute_query($sql);
					echo $sql;
					$j++;					
				}
			} */
		}
	}
//}

while ($j<$num_rows)
{
	$sql = "DELETE FROM antiretro_treatments_compliance WHERE PatientCode='".$_GET['code']."' AND StartDate='".$extra[$j]['start']."' AND EndDate='".$extra[$j]['end']."'";
	execute_query($sql);
	echo $sql;	
	$j++;
}

mysql_close($dbconnection);
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>