<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση 'Αλλων Θεραπειών HBV</TITLE>
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
check_patient($_GET['PatientCode']);
//form_data2table($_GET);


// Parse data from form

$medicine_query = "SELECT ID,Name,Description FROM hbv_other_meds_before_art";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$med_ba[$row['ID']] = $row['Name'];
}

$medicine_query = "SELECT ID,Name,Description FROM hbv_other_meds_after_art";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$med_aa[$row['ID']] = $row['Name'];
}

//print_r($med_ba);


//print_r($new_therapies);

$i = 0;
if ($_GET['before_art'] == 1)
{
	for ($k = 1; $k < count($med_ba)+1; $k++)
	{
		if ($_GET[$med_ba[$k]."_ba"] != "")
		{
			$new_therapy_ba['med'][$i] = $med_ba[$k];
			$new_therapy_ba['meds_id'][$i] = $_GET[$med_ba[$k]."_ba"];
			$i++;
		}
	}
		$newschema = "";
		for ($i=0; $i<count($new_therapy_ba['med']); $i++)
		{
			$newschema .= $new_therapy_ba['med'][$i] . " / ";
		}
		$newschema = substr($newschema, 0, strlen($newschema)-3);	
	$new_therapy_ba['schema'] = $newschema;
	if ($_GET['StartDate_ba_year'] == "")
	{
		$new_therapy_ba['end'] = join_date($_GET, 'EndDate_ba');
		$new_therapy_ba['start'] = "0000-00-00";
	}
	else if ($_GET['EndDate_ba_year'] == "")
	{
		$new_therapy_ba['start'] = join_date($_GET, 'StartDate_ba');
		$new_therapy_ba['end'] = "3000-01-01";
	}
	else
	{
		if (!check_dates($_GET, 'StartDate_ba', 'EndDate_ba'))
		{
			die("Η ημερομηνία έναρξης του σχήματος πρέπει να είναι τουλάχιστον μια μέρα πριν την ημερομηνία λήξης του");
		}
		$new_therapy_ba['start'] = join_date($_GET, 'StartDate_ba');
		$new_therapy_ba['end'] = join_date($_GET, 'EndDate_ba');
	}			
	$new_therapy_ba['reason'] = $_GET['Reason_ba'];
//	print_r($new_therapy_ba);
	if ($new_therapy_ba['schema'] == "")
	{
		perform_post_insert_actions("", "hbv_other_treatments.php?code=".$_GET['PatientCode'], "");
	}
	if (($new_therapy_ba['start'] > $_GET['artdate']) || (($new_therapy_ba['end'] > $_GET['artdate']) && ($new_therapy_ba['end'] != "3000-01-01")))
	{
		show_errormsg("<div class='img-shadow'><p style='display: block; border: 1px solid red'>Οι ημερομηνίες έναρξης και διακοπής της θεραπείας για HBV<BR>πριν την έναρξη 1ης ART πρέπει να είναι πριν την ".$_GET['artdate']."!</p></div>");
	}
	$query = "SELECT Schema, StartDate, EndDate FROM hbv_other_treatments_before_art WHERE PatientCode=".$_GET['code'];
	$result = execute_query($query);
	$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $has_therapy_ba = 0;
    }
    else
    {
        $has_therapy_ba = 1;
    	for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies_ba[$j]['schema'] = $row['Schema'];
            $therapies_ba[$j]['start'] = $row['StartDate'];
            $therapies_ba[$j]['end'] = $row['EndDate'];
        }
    }
	mysql_free_result($result);	
//	if (!$has_therapy_ba)
//	{
//		$sql = "INSERT INTO hbv_other_treatments_before_art ";
//		$sql .= "VALUES ('".$_GET['code']."', '".$new_therapy_ba['schema']."', '".$new_therapy_ba['start']."', '".$new_therapy_ba['end']."', '".$new_therapy_ba['reason']."')";
//		execute_query($sql);
//		echo "<p>$sql</p>";
//	}
	if ($new_therapy_ba['start'] == "0000-00-00")
 	{
		$start_query = "SELECT * FROM hbv_other_treatments_before_art WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Schema='".$new_therapy_ba['schema']."'";
//		echo $start_query;
		$result = execute_query($start_query);
		$num_rows =	mysql_num_rows($result);
		if ($num_rows == 0)
		{
			die ("<div class='img-shadow'><p style='display: block; border: 1px solid red'>Για τον ασθενή ".$_GET['code']." δεν υπάρχει καταχωρημένο φαρμακευτικό σχήμα <b>".$new_therapy_ba['schema']."</b> και ανοιχτή την ημερομηνία τέλους!</p></div>");
		}
		else 
		{
			$row = mysql_fetch_assoc($result);
			$start_date = $row['StartDate'];
			if ($new_therapy_ba['end'] >= $start_date)
			{
				$new_therapy_ba['updatequery'] = "UPDATE hbv_other_treatments_before_art SET EndDate='". $new_therapy_ba['end'] ."', Reason='".$new_therapy_ba['reason']."' WHERE PatientCode='".$_GET['code']."' AND Schema='".$new_therapy_ba['schema']."' AND StartDate='". $start_date ."'";
			}
			else 
			{
				echo "<div class='img-shadow'>";
				echo "<p style='display: block; border: 1px solid red'>";
				echo "Η ημερομηνία διακοπής που δώσατε (".$new_therapy_ba['end'].") του σχήματος $newschema";
				echo "<BR>δεν μπορεί να είναι πριν την ημερομηνία έναρξής του ".$start_date;
				echo "</div></p>";
				die();
			}	
		}
 	}
		// Convert Schemata to Separate Meds

		$old_therapies_ba = array();
		$j=0;
 		for ($i=0; $i<count($therapies_ba); $i++)
 		{
 			for ($k = 1; $k < count($med_ba)+1; $k++)
 			{
 				if (strpos($therapies_ba[$i]['schema'], $med_ba[$k]) !== false)
 				{
 					$old_therapies_ba[$j]['med'] = $med_ba[$k];
 					$old_therapies_ba[$j]['start'] = $therapies_ba[$i]['start'];
 					$old_therapies_ba[$j]['end'] = $therapies_ba[$i]['end'];
 					$j++;
 				}
 			}
 		}

 		// Check Date Consistencies
		
		$trouble=0;
		for ($i=0; $i<count($new_therapy_ba['med']) ; $i++)
		{	
			for ($j=0; $j < count($old_therapies_ba); $j++)
			{
			 if ($new_therapy_ba['start'] != "0000-00-00")
			 {
			 	if ($new_therapy_ba['med'][$i] == $old_therapies_ba[$j]['med'])
			 	{					
				 	if ($new_therapy_ba['start'] <= $old_therapies_ba[$j]['start'])
					{
						if ($new_therapy_ba['end'] <= $old_therapies_ba[$j]['start'])
						{/* echo "OK!"; */}
						else
						{ 
							echo "<div class='img-shadow'>";
							echo "<p style='display: block; border: 1px solid red'>";
							echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>Πρόβλημα</b> στην καταχώρηση του φαρμάκου <b>".$new_therapy_ba['med'][$i]."</b><BR>";
							echo "Υπάρχει ήδη εγγραφή με ημερομηνία έναρξης ".$old_therapies_ba[$j]['start']." για το φάρμακο ".$old_therapies_ba[$j]['med'];
							echo "<BR> και θέλετε να καταχωρήσετε εγγραφή για το φάρμακο ".$new_therapy_ba['med'][$i]." με ημερομηνία έναρξης ".$new_therapy_ba['start'];
							if ($new_therapy_ba['end'] == '3000-01-01')
							{
								echo " και ανοιχτή ημερομηνία λήξης";
							}
							else
							{
								echo " και ημερομηνία λήξης ".$new_therapy_ba['end'];
							}
							$trouble = 1;
						}
						echo "</p></div>";
					}
					else
					{
						if ($new_therapy_ba['start'] >= $old_therapies_ba[$j]['end'])
						{/* echo "OK!"; */}
						else
						{ 
							echo "<div class='img-shadow'>";
							echo "<p style='display: block; border: 1px solid red'>";
							echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>Πρόβλημα</b> στην καταχώρηση του φαρμάκου <b>".$new_therapy_ba['med'][$i]."</b><BR>";
							echo "Υπάρχει ήδη εγγραφή με ημερομηνία έναρξης ".$old_therapies_ba[$j]['start']." για το φάρμακο ".$old_therapies_ba[$j]['med'];
							if ($old_therapies_ba[$j]['end'] == "3000-01-01")
							{	
								echo " και ανοιχτή ημερομηνία λήξης";
							}
							else
							{
								echo " και ημερομηνία λήξης ".$old_therapies_ba[$j]['end'];
							}
							echo "<BR> και θέλετε να καταχωρήσετε εγγραφή για το φάρμακο ".$new_therapy_ba['med'][$i]." με ημερομηνία έναρξης ".$new_therapy_ba['start'];
							echo " και ημερομηνία λήξης ".$new_therapy_ba['end']."<BR><BR>";
							$trouble = 1;
						}
						echo "</p></div>";
					}
			 
			 }
			}
		   }
		}

		if ($trouble == 1)
		{die();}
	if ($new_therapy_ba['start'] == "0000-00-00")
	{
		execute_query($new_therapy_ba['updatequery']);
	}
	else
	{
		$sql = "INSERT INTO hbv_other_treatments_before_art ";
		$sql .= "VALUES ('".$_GET['code']."', '".$new_therapy_ba['schema']."', '".$new_therapy_ba['start']."', '".$new_therapy_ba['end']."', '".$new_therapy_ba['reason']."')";
		execute_query($sql);
	}		
} 			

if ($_GET['after_art'] == 1)
{
	for ($k = 1; $k < count($med_aa)+1; $k++)
	{
		if ($_GET[$med_aa[$k]."_aa"] != "")
		{
			$new_therapy_aa['med'][$i] = $med_aa[$k];
			$new_therapy_aa['meds_id'][$i] = $_GET[$med_aa[$k]."_aa"];
			$i++;
		}
	}
		$newschema = "";
		for ($i=0; $i<count($new_therapy_aa['med']); $i++)
		{
			$newschema .= $new_therapy_aa['med'][$i] . " / ";
		}
		$newschema = substr($newschema, 0, strlen($newschema)-3);	
	$new_therapy_aa['schema'] = $newschema;
	if ($_GET['StartDate_aa_year'] == "")
	{
		$new_therapy_aa['end'] = join_date($_GET, 'EndDate_aa');
		$new_therapy_aa['start'] = "0000-00-00";
	}
	else if ($_GET['EndDate_aa_year'] == "")
	{
		$new_therapy_aa['start'] = join_date($_GET, 'StartDate_aa');
		$new_therapy_aa['end'] = "3000-01-01";
	}
	else
	{
		if (!check_dates($_GET, 'StartDate_aa', 'EndDate_aa'))
		{
			die("Η ημερομηνία έναρξης του σχήματος πρέπει να είναι τουλάχιστον μια μέρα πριν την ημερομηνία λήξης του");
		}
		$new_therapy_aa['start'] = join_date($_GET, 'StartDate_aa');
		$new_therapy_aa['end'] = join_date($_GET, 'EndDate_aa');
	}			
	$new_therapy_aa['reason'] = $_GET['Reason_aa'];
//	print_r($new_therapy_aa);
	if ($newschema == "")
	{
		perform_post_insert_actions("", "hbv_other_treatments.php?code=".$_GET['PatientCode'], "");
	}

	$query = "SELECT Schema, StartDate, EndDate FROM hbv_other_treatments_after_art WHERE PatientCode=".$_GET['code'];
	$result = execute_query($query);
	$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $has_therapy_aa = 0;
    }
    else
    {
        $has_therapy_aa = 1;
    	for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies_aa[$j]['schema'] = $row['Schema'];
            $therapies_aa[$j]['start'] = $row['StartDate'];
            $therapies_aa[$j]['end'] = $row['EndDate'];
        }
    }
	mysql_free_result($result);	
//	if (!$has_therapy_aa)
//	{
//		$sql = "INSERT INTO hbv_other_treatments_after_art ";
//		$sql .= "VALUES ('".$_GET['code']."', '".$new_therapy_aa['schema']."', '".$new_therapy_aa['start']."', '".$new_therapy_aa['end']."', '".$new_therapy_aa['reason']."')";
//		execute_query($sql);
//		echo "<p>$sql</p>";
//	}
	if ($new_therapy_aa['start'] == "0000-00-00")
 	{
		$start_query = "SELECT * FROM hbv_other_treatments_after_art WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Schema='".$new_therapy_aa['schema']."'";
//		echo $start_query;
		$result = execute_query($start_query);
		$num_rows =	mysql_num_rows($result);
		if ($num_rows == 0)
		{
			die ("<div class='img-shadow'><p style='display: block; border: 1px solid red'>Για τον ασθενή ".$_GET['code']." δεν υπάρχει καταχωρημένο φαρμακευτικό σχήμα <b>".$new_therapy_aa['schema']."</b> και ανοιχτή την ημερομηνία τέλους!</p></div>");
		}
		else 
		{
			$row = mysql_fetch_assoc($result);
			$start_date = $row['StartDate'];
			if ($new_therapy_aa['end'] >= $start_date)
			{
				$new_therapy_aa['updatequery'] = "UPDATE hbv_other_treatments_after_art SET EndDate='". $new_therapy_aa['end'] ."', Reason='".$new_therapy_aa['reason']."' WHERE PatientCode='".$_GET['code']."' AND Schema='".$new_therapy_aa['schema']."' AND StartDate='". $start_date ."'";
			}
			else 
			{
				echo "<div class='img-shadow'>";
				echo "<p style='display: block; border: 1px solid red'>";
				echo "Η ημερομηνία διακοπής που δώσατε (".$new_therapy_aa['end'].") του σχήματος $newschema";
				echo "<BR>δεν μπορεί να είναι πριν την ημερομηνία έναρξής του ".$start_date;
				echo "</div></p>";
				die();
			}	
		}
 	}
		// Convert Schemata to Separate Meds

		$old_therapies_aa = array();
		$j=0;
 		for ($i=0; $i<count($therapies_aa); $i++)
 		{
 			for ($k = 1; $k < count($med_aa)+1; $k++)
 			{
 				if (strpos($therapies_aa[$i]['schema'], $med_aa[$k]) !== false)
 				{
 					$old_therapies_aa[$j]['med'] = $med_aa[$k];
 					$old_therapies_aa[$j]['start'] = $therapies_aa[$i]['start'];
 					$old_therapies_aa[$j]['end'] = $therapies_aa[$i]['end'];
 					$j++;
 				}
 			}
 		}

 		// Check Date Consistencies
		
		$trouble=0;
		for ($i=0; $i<count($new_therapy_aa['med']) ; $i++)
		{	
			for ($j=0; $j < count($old_therapies_aa); $j++)
			{
			 if ($new_therapy_aa['start'] != "0000-00-00")
			 {
			 	if ($new_therapy_aa['med'][$i] == $old_therapies_aa[$j]['med'])
			 	{					
				 	if ($new_therapy_aa['start'] <= $old_therapies_aa[$j]['start'])
					{
						if ($new_therapy_aa['end'] <= $old_therapies_aa[$j]['start'])
						{/* echo "OK!"; */}
						else
						{ 
							echo "<div class='img-shadow'>";
							echo "<p style='display: block; border: 1px solid red'>";
							echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>Πρόβλημα</b> στην καταχώρηση του φαρμάκου <b>".$new_therapy_aa['med'][$i]."</b><BR>";
							echo "Υπάρχει ήδη εγγραφή με ημερομηνία έναρξης ".$old_therapies_aa[$j]['start']." για το φάρμακο ".$old_therapies_aa[$j]['med'];
							echo "<BR> και θέλετε να καταχωρήσετε εγγραφή για το φάρμακο ".$new_therapy_aa['med'][$i]." με ημερομηνία έναρξης ".$new_therapy_aa['start'];
							if ($new_therapy_aa['end'] == '3000-01-01')
							{
								echo " και ανοιχτή ημερομηνία λήξης";
							}
							else
							{
								echo " και ημερομηνία λήξης ".$new_therapy_aa['end'];
							}
							$trouble = 1;
						}
						echo "</p></div>";
					}
					else
					{
						if ($new_therapy_aa['start'] >= $old_therapies_aa[$j]['end'])
						{/* echo "OK!"; */}
						else
						{ 
							echo "<div class='img-shadow'>";
							echo "<p style='display: block; border: 1px solid red'>";
							echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>Πρόβλημα</b> στην καταχώρηση του φαρμάκου <b>".$new_therapy_aa['med'][$i]."</b><BR>";
							echo "Υπάρχει ήδη εγγραφή με ημερομηνία έναρξης ".$old_therapies_aa[$j]['start']." για το φάρμακο ".$old_therapies_aa[$j]['med'];
							if ($old_therapies_aa[$j]['end'] == "3000-01-01")
							{	
								echo " και ανοιχτή ημερομηνία λήξης";
							}
							else
							{
								echo " και ημερομηνία λήξης ".$old_therapies_aa[$j]['end'];
							}
							echo "<BR> και θέλετε να καταχωρήσετε εγγραφή για το φάρμακο ".$new_therapy_aa['med'][$i]." με ημερομηνία έναρξης ".$new_therapy_aa['start'];
							echo " και ημερομηνία λήξης ".$new_therapy_aa['end']."<BR><BR>";
							$trouble = 1;
						}
						echo "</p></div>";
					}
			 
			 }
			}
		   }
		}

		if ($trouble == 1)
		{die();}
	if ($new_therapy_aa['start'] == "0000-00-00")
	{
		execute_query($new_therapy_aa['updatequery']);
	}
	else
	{
		$sql = "INSERT INTO hbv_other_treatments_after_art ";
		$sql .= "VALUES ('".$_GET['code']."', '".$new_therapy_aa['schema']."', '".$new_therapy_aa['start']."', '".$new_therapy_aa['end']."', '".$new_therapy_aa['reason']."')";
		execute_query($sql);
	}		
}

mysql_close($dbconnection);
perform_post_insert_actions("hbv_other_treatments", "hbv_other_treatments?code=".$_GET['code'], "");
?>

</BODY></HTML>
