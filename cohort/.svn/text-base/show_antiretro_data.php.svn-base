<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντιρετροϊκών Θεραπειών</TITLE>
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
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
check_patient($_GET['code']);
show_patient_data($_GET['code']);
//form_data2table($_GET);



// Parse data from form

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

//print_r($reasons);


//print_r($new_therapies);

//$query = "SELECT * FROM antiretro_treatments WHERE PatientCode='". $_GET['code'] ."' GROUP BY StartDate ASC";
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
	echo "<h2>Δεν υπάρχουν καταχωρημένες αντιρετροϊκές θεραπείες για τον ασθενή ".$_GET['code']."</h2>";
}
else
{
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
echo "<p><a href='antiretro.php?code=".$_GET['code']."'><b>Επιστροφή στην καταχώρηση θεραπειών</b></a></p><p>&nbsp;<p>";

$query = "SELECT * FROM antiretro_treatments_compliance WHERE PatientCode=".$_GET['code']." ORDER BY StartDate ASC";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);

echo "<P><B> Ήδη αποθηκευμένο φαρμακευτικό σχήμα </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Διαγραφή</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
	for ($i=0; $i<$num_rows; $i++)
	{
	$schema_row = mysql_fetch_assoc($result);
	echo "<TR>";
	echo "<TD align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_schema(\"".$schema_row['Schema']."\", \"".$schema_row['StartDate']."\", \"".$schema_row['EndDate']."\");'>";
	echo "<TD class=result>".$schema_row['Schema']."</TD>";
	echo "<TD class=result align=center> Από ".show_date($schema_row['StartDate']);
	if ($schema_row['EndDate'] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " εως ".show_date($schema_row['EndDate'])."</TD></TR>";
	}
}
echo "</TABLE>";

echo "<p>&nbsp;</p>";
echo "<P><B> Αποθηκευμένα Αντιρετροϊκά Φάρμακα </B></P>";
//$sql = "SELECT antiretro_treatments.medicine as medicineid, medicines.Name as Medicine, StartDate, EndDate, antiretro_treatments.Reason as reasonid, antiretro_reasons.description as Reason FROM antiretro_treatments, antiretro_reasons, medicines WHERE antiretro_treatments.Medicine = medicines.ID AND antiretro_treatments.Reason=antiretro_reasons.id AND PatientCode=".$_GET['code']." LIMIT 0, 100";
$sql = "SELECT antiretro_treatments.medicine as medicineid, medicines.Name as Medicine, StartDate, EndDate FROM antiretro_treatments, medicines WHERE antiretro_treatments.Medicine = medicines.ID AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
//    echo "<form method=get action='delete_antiretro_data.php'>";
    echo "<input type=hidden name=therapy_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
//        echo "<th class=result> Διαγραφή </th>";
    $i = 0;
/*    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        if ($field->name != "medicineid" && $field->name != "reasonid")
        {
        	echo "<th class=result>".$field->name . "</th>";
        }
        $i++;
    }
*/
	echo "<th class=result>Φάρμακο</th>";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
 //           echo "<td align=center> <input type=checkbox name='del_therapy_sw_".$j."'>";
 //          echo "<input type=hidden name='del_medicine_id_".$j."' value='".$resultrow['medicineid']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_reason_".$j."' value='".$resultrow['reasonid']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "medicineid" && $field->name != "reasonid")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
                		echo "<td class=result>";
                        if ($field->name == "EndDate" && $resultrow['EndDate'] == "3000-01-01")
            			{
            				echo " &nbsp;&nbsp;&nbsp; --------- ";
            			}
            			else 
            			{
            				echo show_date($resultrow[$field->name]);
            			}
                		echo "</td>";
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
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//        echo " <input type=submit value='Διαγραφή Φαρμάκου'></p>";
//        echo "</form>";
    }

}

echo "<p>&nbsp;</p>";

echo "<P><B> Συμμόρφωση Ασθενούς και Λόγοι Διακοπής Θεραπειών</B></P>";
$sql = "SELECT antiretro_treatments_compliance.Schema, antiretro_treatments_compliance.StartDate, antiretro_treatments_compliance.EndDate, antiretro_treatments_compliance.Compliance, antiretro_treatments_compliance.Reason1, antiretro_treatments_compliance.Reason2, antiretro_treatments_compliance.Notes FROM antiretro_treatments_compliance WHERE PatientCode=".$_GET['code']." GROUP BY antiretro_treatments_compliance.StartDate";
$result = execute_query($sql);
//    echo "<form method=get action='delete_antiretro_data.php'>";
    echo "<input type=hidden name=compliance_count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
	echo "<th class=result>Διαγραφή<br>Αλλαγή</th>";
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
            echo "<tr>\n";
            echo "<td align=center><img src='./images/b_drop.png' style='cursor: pointer' onclick='delete_schema(\"".$resultrow['Schema']."\", \"".$resultrow['StartDate']."\", \"".$resultrow['EndDate']."\");'> &nbsp; <img src='./images/b_edit.png' style='cursor: pointer' ";
            echo "onclick='location.href=\"edit_antiretro_extra.php?code=".$_GET['code']."&schema=".$resultrow['Schema']."&start=".$resultrow['StartDate']."&end=".$resultrow['EndDate']."\";'>";
            $k = 0;
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "PatientCode")
                {
                	if ($field->name == "StartDate" || $field->name == "EndDate")
                	{
                		echo "<td class=result>";
                        if ($field->name == "EndDate" && $resultrow['EndDate'] == "3000-01-01")
            			{
            				echo " &nbsp;&nbsp;&nbsp; --------- ";
            			}
            			else 
            			{
            				echo show_date($resultrow[$field->name]);
            			}
                		echo "</td>";
//                		echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                	}
                	else if ($field->name == "Schema")
                	{
                		echo "<td class=result style='width: 150px'>".$resultrow['Schema']."</td>";
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
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//        echo " <input type=submit value='Αλλαγή'></p>";
        echo "</form>";
    }

echo "<p>&nbsp;</p>";


mysql_close($dbconnection);
?>
<script>
function delete_schema(schema, start, end)
{
	ok = confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε το σχήμα " + schema +";");
	if (ok) {
		location.href = "hiv_delete_schema.php?table=show_antiretro_data.php&code=<? echo $_GET['code']?>&schema=" + schema + "&start=" + start + "&end=" + end;
	}
}
</script>
</BODY></HTML>
