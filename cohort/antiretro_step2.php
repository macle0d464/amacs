<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αντιρετροϊκών Θεραπείων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
<SCRIPT>
function show_unwanted(value, item_id)
{
	item = document.getElementById(item_id);
	if (value == 95)
	{
		item.style.display = "block";
	}
	else
	{
		item.style.display = "none";
	}
}

function show_unwanted_secondary(value, item_id)
{
	item = document.getElementById(item_id);
	if (value == 95)
	{
		item.style.display = "block";
	}
}
</SCRIPT>
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

	$reasons_query = "SELECT * FROM antiretro_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	$reasons_str = "";
	for ($r=0; $r<$reasons; $r++)
	{
    	if ($r <> 95)
    	{
			$row = mysql_fetch_array($reason_result);
    		$reasons_str .= "<option value='".$row[0]."'>".$row[0]."</option>\n";
    	}
    }
	mysql_free_result($reason_result);

//if ($_GET['code'] == "" || !is_numeric($_GET['code']))
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
check_patient($_GET['code']);
//form_data2table($_GET);



// Parse data from form

$medicine_query = "SELECT ID,Name,Category FROM medicines GROUP BY ID";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
$max_medicine_array = 1;
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$row['ID']]['id'] = $row['ID'];
	$medicine_array[$row['ID']]['name'] = $row['Name'];
	$medicine_array[$row['ID']]['category'] = $row['Category'];
	if ($row['ID'] > $max_medicine_array)
	{
		$max_medicine_array = $row['ID'];
	}
}

//print_r($medicine_array);


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
$entry = 0;
$j=0;
$jj=0;	
for ($i = 1; $i < $max_medicine_array+1; $i++)
{
	if ($_GET[$medicine_array[$i]['name']] != "")
	{
		$k=$_GET[$medicine_array[$i]['name']];
		if ($_GET['StartDate'.$k.'_year'] == "")
		{
			$special_end[$jj]['med'] = $medicine_array[$k]['name'];
			$special_end[$jj]['med_id'] = $k;
			$special_end[$jj]['end'] = join_date($_GET, 'EndDate'.$k);
			$jj++;
			$entry = 1;
		}
		else if ($_GET['EndDate'.$k.'_year'] == "")
		{
			$new_therapies[$j]['med'] = $medicine_array[$k]['name'];
			$new_therapies[$j]['med_id'] = $k;
			$new_therapies[$j]['start'] = join_date($_GET, 'StartDate'.$k);
			$new_therapies[$j]['end'] = "3000-01-01";
//			$new_therapies[$j]['reason'] = $_GET['Reason'.$k];
			$j++;
			$entry = 1;
		}
		else
		{
			if (!check_dates($_GET, 'StartDate'.$k, 'EndDate'.$k))
			{
				die("Η ημερομηνία έναρξης του φαρμάκου ". $medicine_array[$k]['name'] ." πρέπει να είναι τουλάχιστον μια μέρα πριν την ημερομηνία λήξης του");
			}
			$new_therapies[$j]['med'] = $medicine_array[$k]['name'];
			$new_therapies[$j]['med_id'] = $k;
			$new_therapies[$j]['start'] = join_date($_GET, 'StartDate'.$k);
			$new_therapies[$j]['end'] = join_date($_GET, 'EndDate'.$k);
//			$new_therapies[$j]['reason'] = $_GET['Reason'.$k];
			$j++;
			$entry = 1;			
		}
	}
}

if ($entry == 0)
{ die('Πρέπει να επιλέξετε τουλάχιστον ένα φάρμακο!'); }

for ($i=0; $i< count($special_end); $i++)
{
	$start_query = "SELECT * FROM antiretro_treatments WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Medicine='". $special_end[$i]['med'] ."'";
	$result = execute_query($start_query);
	$num_rows =	mysql_num_rows($result);
	if ($num_rows == 0)
	{
		die ("Για τον ασθενή ".$_GET['code']." δεν υπάρχει καταχωρημένη θεραπεία με το φάρμακο ". $special_end[$i]['med'] ." και ανοιχτή την ημερομηνία τέλους!");
	}
	else 
	{
		$row = mysql_fetch_assoc($result);
		$start_date = $row['StartDate'];
		$special_end[$i]['updatequery1'] = "DELETE FORM `antiretro_treatments_compliance` WHERE EndDate='3000-01-01' AND Schema='".$special_end[$i]['med']."' AND PatientCode='".$_GET['code']."' AND StartDate='". $start_date ."'";
		$special_end[$i]['updatequery2'] = "UPDATE antiretro_treatments SET EndDate='". $special_end[$i]['end'] ."' WHERE PatientCode='".$_GET['code']."' AND Medicine='". $special_end[$i]['med_id'] ."' AND StartDate='". $start_date ."'";

	}
}
/*
	for ($i=0; $i< count($new_therapies); $i++)
{
	$dates[2*$i] = $new_therapies[$i]['start'];
	$dates[2*$i+1] = $new_therapies[$i]['end'];
}


$temp = array_unique($dates);
$dates = array_values($temp);

sort($dates);
reset($dates);

for ($i=0; $i < 2*count($new_therapies)-1; $i++)
{

	for ($j=0; $j < count($new_therapies); $j++)
	{
		if ($dates[$i] == $new_therapies[$j]['start'])
		{
			$schema[$i] .= $new_therapies[$j]['med'] . " / ";
		}
		if ($dates[$i] > $new_therapies[$j]['start'] && $dates[$i] <= $new_therapies[$j]['end'])
		{
			$schema[$i] .= $new_therapies[$j]['med'] . " / ";
		}		
		if ($dates[$i] >= $new_therapies[$j]['end'])
		{
			$schema[$i] = str_replace($new_therapies[$j]['med']. " / ", "", $schema[$i]);
		}
	}
	$schema[$i] = substr($schema[$i], 0, strlen($schema[$i])-3); // . "|";
}

echo "<P><b>Φαρμακευτικό σχήμα που θα αποθηκευτεί</b></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
for ($i=0; $i< count($dates)-1; $i++)
{
	echo "<TR><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".$schema[$i]."</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".$dates[$i];
	if ($dates[$i+1] == "3000-01-01")
	{
		echo "</TD></TR>";
	}
	else
	{
	echo " εως ".$dates[$i+1]."</TD></TR>";
	}
}
echo "</TABLE>";
?>
<FORM action=antiretro_step3.php method="post">
<? 
for ($i=0; $i< count($new_therapies); $i++)
{
	echo "\n<input type=hidden name='query$i' value=\"";
	echo "INSERT INTO antiretro_treatments VALUES('".$_GET['code']."', '".$new_therapies[$i]['med_id']."', '".$new_therapies[$i]['start']."', '".$new_therapies[$i]['end']."', '".$new_therapies[$i]['reason']."')";
	echo "\" >\n";
}
?>
<br>
<input type="hidden" name=number value=<? echo $i; ?>>
<input type="submit" value="Αποθήκευση Δεδομένων" />
</form>
<?
*/
}
else
{
$entry = 0;
$j=0;
$jj=0;	
for ($i = 1; $i < $max_medicine_array+1; $i++)
{
	if ($_GET[$medicine_array[$i]['name']] != "")
	{
		$k=$_GET[$medicine_array[$i]['name']];
		if ($_GET['StartDate'.$k.'_year'] == "")
		{
			$special_end[$jj]['med'] = $medicine_array[$k]['name'];
			$special_end[$jj]['med_id'] = $k;
			$special_end[$jj]['end'] = join_date($_GET, 'EndDate'.$k);
			$jj++;
			$entry = 1;
		}
		else if ($_GET['EndDate'.$k.'_year'] == "")
		{
			$new_therapies[$j]['med'] = $medicine_array[$k]['name'];
			$new_therapies[$j]['med_id'] = $k;
			$new_therapies[$j]['start'] = join_date($_GET, 'StartDate'.$k);
			$new_therapies[$j]['end'] = "3000-01-01";
//			$new_therapies[$j]['reason'] = $_GET['Reason'.$k];
			$j++;
			$entry = 1;
		}
		else
		{
			if (!check_dates($_GET, 'StartDate'.$k, 'EndDate'.$k))
			{
				die("Η ημερομηνία έναρξης του φαρμάκου ". $medicine_array[$k]['name'] ." πρέπει να είναι τουλάχιστον μια μέρα πριν την ημερομηνία λήξης του");
			}
			$new_therapies[$j]['med'] = $medicine_array[$k]['name'];
			$new_therapies[$j]['med_id'] = $k;
			$new_therapies[$j]['start'] = join_date($_GET, 'StartDate'.$k);
			$new_therapies[$j]['end'] = join_date($_GET, 'EndDate'.$k);
//			$new_therapies[$j]['reason'] = $_GET['Reason'.$k];
			$j++;
			$entry = 1;			
		}
	}
}

if ($entry == 0)
{ die('Πρέπει να επιλέξετε τουλάχιστον ένα φάρμακο!'); }

//print_r($new_therapies);
//echo "<BR>";
//print_r($therapies);	
$trouble=0;	
for ($i=0; $i < count($new_therapies); $i++)
{
	for ($j=0; $j < count($therapies); $j++)
	{
		if ($new_therapies[$i]['med_id'] == $therapies[$j]['med_id'])
		{
			if ($new_therapies[$i]['start'] <= $therapies[$j]['start'])
			{
				if ($new_therapies[$i]['end'] <= $therapies[$j]['start'])
				{/* echo "OK!"; */}
				else
				{ 
					echo "<BR> <b>Πρόβλημα</b> στην καταχώρηση του φαρμάκου <b>".$new_therapies[$i]['med']."</b><BR>";
					echo "Υπάρχει ήδη εγγραφή με ημερομηνία έναρξης ".$therapies[$j]['start'];
					echo "<BR> και θέλετε να καταχωρήσετε εγγραφή με ημερομηνία έναρξης ".$new_therapies[$j]['start'];
					if ($new_therapies[$j]['end'] == '3000-01-01')
					{
						echo " και ανοιχτή ημερομηνία λήξης";
					}
					else
					{
						echo " και ημερομηνία λήξης ".$new_therapies[$j]['end'];
					}
					$trouble = 1;
				}
			}
			else
			{
				if ($new_therapies[$i]['start'] >= $therapies[$j]['end'])
				{/* echo "OK!"; */}
				else
				{ 
					echo "<BR><b>Πρόβλημα</b> στην καταχώρηση του φαρμάκου <b>".$new_therapies[$i]['med']."</b><BR>";
					echo "Υπάρχει ήδη εγγραφή με ημερομηνία έναρξης ".$therapies[$j]['start'];
					if ($therapies[$j]['end'] == "3000-01-01")
					{
						echo " και ανοιχτή ημερομηνία λήξης";
					}
					else
					{
						echo " και ημερομηνία λήξης ".$therapies[$j]['end'];
					}
					echo "<BR> και θέλετε να καταχωρήσετε εγγραφή με ημερομηνία έναρξης ".$new_therapies[$i]['start'];
					echo " και ημερομηνία λήξης ".$new_therapies[$i]['end']."<BR><BR>";
					$trouble = 1;
				}

			}
		}
	}
}

if ($trouble == 1)
{die();}

for ($i=0; $i< count($special_end); $i++)
{
	$start_query = "SELECT * FROM antiretro_treatments WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Medicine='". $special_end[$i]['med_id'] ."'";
	$result = execute_query($start_query);
	$num_rows =	mysql_num_rows($result);
	if ($num_rows <> 1)
	{
		die ("Δεν υπάρχει θεραπεία με το φάρμακο ". $special_end[$i]['med'] ." και ανοιχτή την ημερομηνία τέλους!");
	}
	else 
	{
		$row = mysql_fetch_assoc($result);
		$start_date = $row['StartDate'];
		$special_end[$i]['updatequery1'] = "DELETE FORM `antiretro_treatments_compliance` WHERE EndDate='3000-01-01' AND Schema='".$special_end[$i]['med']."' AND PatientCode='".$_GET['code']."' AND StartDate='". $start_date ."'";
		$special_end[$i]['updatequery2'] = "UPDATE antiretro_treatments SET EndDate='". $special_end[$i]['end'] ."' WHERE PatientCode='".$_GET['code']."' AND Medicine='". $special_end[$i]['med_id'] ."' AND StartDate='". $start_date ."'";
	}
}

}

//echo "<BR><BR>";
//print_r($special_end);
for ($i=0; $i< count($therapies); $i++)
{
	$old_dates[2*$i] = $therapies[$i]['start'];
	$old_dates[2*$i+1] = $therapies[$i]['end'];
}
//echo "OLD DATES ";
$temp = array_unique($old_dates);
$old_dates = array_values($temp);
//print_r($old_dates);
sort($old_dates);
reset($old_dates);
//echo " OLD DATES - SORTED ";
//print_r($old_dates);
for ($i=0; $i < 2*count($therapies)-1; $i++)
{
//	$schema[$i] = "|";
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
	$old_schema[$i] = substr($old_schema[$i], 0, strlen($old_schema[$i])-3); // . "|";
}
echo "<P><B> Ήδη αποθηκευμένο φαρμακευτικό σχήμα </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
for ($i=0; $i< count($old_dates)-1; $i++)
{
	echo "<TR><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
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
?>
<FORM action=antiretro_step3.php method="POST">
<?
if (isset($new_therapies))
{
for ($i=0; $i< count($new_therapies); $i++)
{
	$dates[2*$i] = $new_therapies[$i]['start'];
	$dates[2*$i+1] = $new_therapies[$i]['end'];
}

$temp = array_unique($dates);
$dates = array_values($temp);
sort($dates);
reset($dates);

for ($i=0; $i < 2*count($new_therapies)-1; $i++)
{
	for ($j=0; $j < count($new_therapies); $j++)
	{
		if ($dates[$i] == $new_therapies[$j]['start'])
		{
			$schema[$i] .= $new_therapies[$j]['med'] . " / ";
		}
		if ($dates[$i] > $new_therapies[$j]['start'] && $dates[$i] <= $new_therapies[$j]['end'])
		{
			$schema[$i] .= $new_therapies[$j]['med'] . " / ";
		}		
		if ($dates[$i] >= $new_therapies[$j]['end'])
		{
			$schema[$i] = str_replace($new_therapies[$j]['med']. " / ", "", $schema[$i]);
		}
	}
	$schema[$i] = substr($schema[$i], 0, strlen($schema[$i])-3); // . "|";
}

echo "</TABLE>";
?>
<? 
echo "<P><B> Νέο φαρμακευτικό σχήμα που θέλετε να αποθηκευτεί </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φαρμακευτικό Σχήμα</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Χρονικό Διάστημα χορήγησης</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Συμμόρφωση Ασθενούς</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Αιτία<BR>διακοπής 1</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Αιτία<BR>διακοπής 2</TH>";
echo "<TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Σημειώσεις</TH>";
for ($i=0; $i< count($dates)-1; $i++)
{
	echo "<TR><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".$schema[$i]."</TD><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>Από ".show_date($dates[$i]);
	if ($dates[$i+1] == "3000-01-01")
	{
		echo "</TD>";
	}
	else
	{
		echo " εως ".show_date($dates[$i+1])."</TD>";
	}
	if ($dates[$i+1] != "3000-01-01")
	{
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
		echo "<input type=radio name='comp".$i."' value='-1' checked> 'Αγνωστη <input type=radio name='comp".$i."' value='1'> Κακή <input type=radio name='comp".$i."' value='2'> Μέτρια <input type=radio name='comp".$i."' value='3'> Καλή</TD>";
?>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <select name=Reason1_<?echo $i?>>
    <option value="99" selected>99</option>
    <? echo $reasons_str; ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./antiretro_reasons.php?field=Reason1_<?echo $i?>', 'Λόγοι', 'width=500,height=600,status=yes');"/>
    </TD>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <select name=Reason2_<?echo $i?>>
    <option value="99" selected>99</option>
    <? echo $reasons_str; ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./antiretro_reasons.php?field=Reason2_<?echo $i?>', 'Λόγοι', 'width=500,height=600,status=yes');"/>
    </TD>
    <TD align="center" style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>
    <textarea name=Note<?echo $i?> STYLE="overflow:hidden"></textarea>
    </TD>
    
<?	
	}
	else
	{
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>";
		echo "<input type=radio name='comp".$i."' value='-1' checked> 'Αγνωστη <input type=radio name='comp".$i."' value='1'> Κακή <input type=radio name='comp".$i."' value='2'> Μέτρια <input type=radio name='comp".$i."' value='3'> Καλή</TD>";
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center><input type=hidden name=Reason1_$i value=''> - </TD>";
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center><input type=hidden name=Reason1_$i value=''> - </TD>";
		echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF' align=center>";
		?>
		<textarea name=Note<?echo $i?> STYLE="overflow:hidden"></textarea>
		<?
		echo "</TD>";
	}
	echo "</TR>";
}
echo "</TABLE>";
}

if (isset($special_end))
{
echo "<input type=hidden name=special_end_set value=1>";
echo "<P><B> Φάρμακα στα οποία θα προστεθεί ημερομηνία λήξης </B></P>";
echo "<TABLE><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Φάρμακο</TH><TH style='font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #000000; background-color: #99FFFF'>Ημερομηνία Λήξης</TH>";
for ($i=0; $i< count($special_end); $i++)
{
	echo "<TR><TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".$special_end[$i]['med']."</TD>";
	echo "<TD style='font-family: Verdana, Arial, Helvetica, sans-serif; background-color: #FFFFFF'>".show_date($special_end[$i]['end'])."</TD></TR>";
}
echo "</TABLE>";
}

$schemas = count($dates)-1;
echo "<input type=hidden name=schemas value=".$schemas.">";
?>

<? 
for ($i=0; $i< count($new_therapies); $i++)
{
	echo "\n<input type=hidden name='query$i' value=\"";
	echo "INSERT INTO antiretro_treatments VALUES('".$_GET['code']."', '".$new_therapies[$i]['med_id']."', '".$new_therapies[$i]['start']."', '".$new_therapies[$i]['end']."')"; // , '".$new_therapies[$i]['reason']."')";
	echo "\" >\n";
}
for ($j=0; $j< count($special_end); $j++)
{
	echo "\n<input type=hidden name='query$i' value=\"";
	echo $special_end[$j]['updatequery1'];
	echo "\" >\n";
	$i++;
	echo "\n<input type=hidden name='query$i' value=\"";
	echo $special_end[$j]['updatequery2'];
	echo "\" >\n";
	$i++;
}
for ($j=0; $j< $schemas; $j++)
{
	echo "\n<input type=hidden name='comp_query_$j' value=\"";
	echo "INSERT INTO antiretro_treatments_compliance VALUES('".$_GET['code']."', '".$schema[$j]."', '".$dates[$j]."', '".$dates[$j+1]."', ";
	echo "\" >\n";
}

?>
<br>
<input type="hidden" name=code value=<? echo $_GET['PatientCode']; ?>>
<input type="hidden" name=number value=<? echo $i; ?>>
<input type="hidden" name="comp_number" value=<? echo $j; ?>>
<input type="submit" value="Αποθήκευση Δεδομένων" />
</form>
<?
//}

mysql_close($dbconnection);
?>

</BODY></HTML>
