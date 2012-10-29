<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
 
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

$patients = array();
$result = execute_query("SELECT PatientCode FROM `patients`");
for ($i=0; $i<mysql_num_rows($result); $i++)
{
	$patients[$i] = mysql_fetch_array($result);
	$patients[$i] = $patients[$i][0];
}

//print_r($patients);

foreach($patients as $patient_code) 
{
check_patient($patient_code);

$medicine_query = "SELECT ID,Name,Category FROM medicines";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$i]['id'] = $row['ID'];
	$medicine_array[$i]['name'] = $row['Name'];
	$medicine_array[$i]['category'] = $row['Category'];
}

$reasons_query = "SELECT * FROM antiretro_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['id']] = $row['description'];
}

// Load Saved Antiretroviral Medicines for Patient $patient_code

$query = "SELECT antiretro_treatments.Medicine as med_id,  medicines.name as med, antiretro_treatments.StartDate as StartDate, antiretro_treatments.EndDate as EndDate FROM antiretro_treatments,medicines WHERE antiretro_treatments.PatientCode=".$patient_code." AND antiretro_treatments.Medicine=medicines.ID";
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

// Convert Medicines to Schema

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
	$old_schema[$i] = "";
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

$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_treatments_compliance.Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_treatments_compliance WHERE PatientCode=".$patient_code." GROUP BY antiretro_treatments_compliance.StartDate";
$result = execute_query($sql);
    $extra_data = array();
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
    }
    else
    {
        $jj = 0;
    	for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            $k = 0;
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "PatientCode")
                {
                	if ($field->name == "StartDate")
                	{
                		$extra_data[$j]['start'] = $resultrow[$field->name];
                	}
                	else if ($field->name == "EndDate")
                	{
                		$extra_data[$j]['end'] = $resultrow[$field->name];
                	}
                	else if ($field->name == "Schema")
                	{
                		if ($old_schema[$jj] == "")
                		{
                			$jj++;
               			}
                		$jj++;
                	}
                	else if ($field->name == "Compliance")
                	{
                		$extra_data[$j]['compliance'] = $resultrow[$field->name];
                	}
                	else if ($field->name == "Reason1")
                	{
                		$extra_data[$j]['reason1'] = $resultrow[$field->name];
                	}
					else if ($field->name == "Reason2")
                	{
                		$extra_data[$j]['reason2'] = $resultrow[$field->name];
                	}
					else if ($field->name == "Notes")
                	{
                		$extra_data[$j]['notes'] = $resultrow[$field->name];
                	}                  	               	
                	else 
                 	{
//                		echo "<td class=result>".$resultrow[$field->name]."</td>";
                	}
                }
             	$i++;
            }
//            echo "</tr>\n";
        }
    }


$corrected = array();
$c=0;
//echo "<table>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
	
	if ($old_schema[$i] != "")
	{
		$corrected[$c]['schema'] = $old_schema[$i];
		$corrected[$c]['start'] = $old_dates[$i];
		$corrected[$c]['end'] = $old_dates[$i+1];
		$c++;
	}
}

for ($i=0; $i< count($corrected); $i++)
{
	$corrected2[$i]['schema'] = $corrected[$i]['schema'];
	$corrected2[$i]['start'] = $corrected[$i]['start'];
	$corrected2[$i]['end'] = $corrected[$i]['end'];
	$corrected2[$i]['reason1'] = $extra_data[$i]['reason1'];
	$corrected2[$i]['reason2'] = $extra_data[$i]['reason2'];
	$corrected2[$i]['compliance'] = $extra_data[$i]['compliance'];
	$corrected2[$i]['notes'] = $extra_data[$i]['notes'];
}

execute_query("DELETE FROM `antiretro_treatments_compliance` WHERE PatientCode='".$patient_code."'");
//echo "DELETE FROM `antiretro_treatments_compliance` WHERE PatientCode='".$patient_code."'";
for ($i=0; $i<count($corrected2); $i++)
{
	$sql = "INSERT INTO `antiretro_treatments_compliance` VALUES('".$patient_code."', '".$corrected2[$i]['schema']."', '".$corrected2[$i]['start']."', '".$corrected2[$i]['end']."', '".$corrected2[$i]['compliance']."', '".$corrected2[$i]['reason1']."', '".$corrected2[$i]['reason2']."', '".$corrected2[$i]['notes']."')";
	echo $sql."<BR>";
	execute_query($sql);
}

}
?>