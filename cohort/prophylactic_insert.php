<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Προφυλακτικών Θεραπείων</TITLE>
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
//form_data2table($_GET);

$therapies_query = "SELECT * FROM prophylactic_therapies_list";
$results = execute_query($therapies_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$list[$row['ID']] = $row['Therapy'];
}
mysql_free_result($results);

//$data_array2 = prepare_data("prophylactic_therapies", $_GET);
//$names = array_keys($data_array2);

$therapies = array();

$query = "SELECT * FROM prophylactic_therapies WHERE PatientCode=".$_GET['code'];
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $has_therapy = 0;
    }
    else
    {
    	$has_therapy = 1;
        for ($j=0; $j<$num_rows; $j++)
        {
            $row = mysql_fetch_assoc($result);
            $therapies[$j]['therapy'] = $row['Therapy'];
            $therapies[$j]['start'] = $row['StartDate'];
            $therapies[$j]['end'] = $row['EndDate'];
        }
    }
mysql_free_result($result);
    
// Parse data from FORM

$i = 0;
for ($k = 0; $k < $_GET['therapies']; $k++)
{
	if (isset($_GET['Therapy'.$k])) 
	{
		$kk = $k+1;
		$new_therapies[$i]['therapy'] = $kk;
		$new_therapies[$i]['descr'] = $list[$kk];
		$new_therapies[$i]['type'] = $_GET['Type'.$k];
		if ($_GET['StartDate'.$k.'_year'] == "")
		{
			$new_therapies[$i]['end'] = join_date($_GET, 'EndDate'.$k);
			$new_therapies[$i]['start'] = "0000-00-00";
		}
		else if ($_GET['EndDate'.$k.'_year'] == "")
		{
			$new_therapies[$i]['start'] = join_date($_GET, 'StartDate'.$k);
			$new_therapies[$i]['end'] = "3000-01-01";
		}
		else
		{
			if (!check_dates($_GET, 'StartDate'.$k, 'EndDate'.$k))
			{
				die("Η ημερομηνία έναρξης της θεραπείας για ". $new_therapies[$i]['descr'] ." πρέπει να είναι τουλάχιστον μια μέρα πριν την ημερομηνία λήξης της");
			}
			$new_therapies[$i]['start'] = join_date($_GET, 'StartDate'.$k);
			$new_therapies[$i]['end'] = join_date($_GET, 'EndDate'.$k);
		}		
		$new_therapies[$i]['reason'] = $_GET['Reason'.$k];
		$new_therapies[$i]['note'] = $_GET['Note'.$k];
		$i++;
	}
}

for ($i=0; $i< count($new_therapies); $i++)
{
 if ($new_therapies[$i]['start'] == "0000-00-00")
 {
	$start_query = "SELECT * FROM prophylactic_therapies WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Therapy='".$new_therapies[$i]['therapy']."'";
	$result = execute_query($start_query);
	$num_rows =	mysql_num_rows($result);
	if ($num_rows == 0)
	{
		die ("Για τον ασθενή ".$_GET['code']." δεν υπάρχει καταχωρημένη προφυλακτική θεραπεία για ".$new_therapies[$i]['descr']." και ανοιχτή την ημερομηνία τέλους!");
	}
	else 
	{
		$row = mysql_fetch_assoc($result);
		$start_date = $row['StartDate'];
		if ($new_therapies[$i]['end'] >= $start_date)
		{
			$new_therapies[$i]['updatequery'] = "UPDATE prophylactic_therapies SET EndDate='". $new_therapies[$i]['end'] ."', Reason='".$new_therapies[$i]['reason']."' WHERE PatientCode='".$_GET['code']."' AND Therapy='".$new_therapies[$i]['therapy']."' AND StartDate='". $start_date ."'";
		}
		else 
		{
			echo "<div class='img-shadow'>";
			echo "<p style='display: block; border: 1px solid red'>";
			echo "Η ημερομηνία διακοπής που δώσατε (".$new_therapies[$i]['end'].") της θεραπείας για ".$new_therapies[$i]['descr'];
			echo "<BR>δεν μπορεί να είναι πριν την ημερομηνία έναρξής της ".$start_date;
			echo "</div></p>";
			die();
		}

	}
 }
}


//print_r($new_therapies);

// Check Date Consistencies
/*
if ($has_therapy)
{
	$trouble=0;	
	for ($i=0; $i < count($new_therapies); $i++)
	{
		for ($j=0; $j < count($therapies); $j++)
		{
//			echo $new_therapies[$i]['therapy']. "==" .$therapies[$j]['therapy']."<BR><BR>";
			if ($new_therapies[$i]['therapy'] == $therapies[$j]['therapy'])
			{
			 if ($new_therapies[$i]['start'] != "0000-00-00")
			 {
				if ($new_therapies[$i]['start'] <= $therapies[$j]['start'])
				{
					if ($new_therapies[$i]['end'] <= $therapies[$j]['start'])
					{ }
					else
					{ 
						echo "<div class='img-shadow'>";
						echo "<p style='display: block; border: 1px solid red'>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>Πρόβλημα</b> στην καταχώρηση θεραπείας για <b>".$new_therapies[$i]['descr']."</b><BR>";
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
					echo "</p></div>";
				}
				else
				{
					if ($new_therapies[$i]['start'] >= $therapies[$j]['end'])
					{ }
					else
					{ 
						echo "<div class='img-shadow'>";
						echo "<p style='display: block; border: 1px solid red'>";
						echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>Πρόβλημα</b> στην καταχώρηση θεραπείας για <b>".$new_therapies[$i]['descr']."</b><BR>";
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
					echo "</p></div>";
				}
			 }
			}
		}
	}

	if ($trouble == 1)
	{die();}
}
*/

// Insert data into table

for ($i=0; $i< count($new_therapies); $i++)
{
	if ($new_therapies[$i]['start'] == "0000-00-00")
	{
		execute_query($new_therapies[$i]['updatequery']);
	}
	else // if ($new_therapies[$i]['end'] == "3001-01-01")
	{

// Join medicines

$meds = "";
$results = execute_query("SELECT * FROM prophylactic_meds");		
$num = mysql_num_rows($results);
for ($j = 0; $j < $num; $j++)
{
	$row = mysql_fetch_assoc($results);
	if ($_GET[$row['Med']] == true)
	{
		$meds .= $row['Med'] . " / ";
	}
}
$meds = substr($meds, 0, strlen($meds)-3);

		$sql = "";
		$sql = "INSERT INTO `prophylactic_therapies` ";
		$sql .= " VALUES ('".$_GET['code']."', '".$new_therapies[$i]['therapy']."', '".$new_therapies[$i]['type']."', '".$new_therapies[$i]['start'];
		$sql .="', '".$new_therapies[$i]['end']."', '".$new_therapies[$i]['reason']."', '".$meds."', '".$new_therapies[$i]['note']."');";
		echo $sql;
		execute_query($sql);
	}
}

/*
		$sql = "";
		$sql = "INSERT INTO `prophylactic_therapies` ( `PatientCode` , `Therapy` , `Type` , `StartDate` , `EndDate` , `Reason`)";
		$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['Therapy'.$k]."', '".$data_array2['Type'.$k]."', '".$data_array2['StartDate'.$k];
		$sql .="', '".$data_array2['EndDate'.$k]."', '".$data_array2['Reason'.$k]."');";
		echo $sql;
		$what_happened = execute_query($sql);
		if ($what_happened == 1)
    	{
        	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
	    }
		else
    	{
        	echo "<P>$what_happened</P>";
    	}
*/
mysql_close($dbconnection);
perform_post_insert_actions("prophylactic_therapies", "prophylactic.php?code=".$_GET['code'], "");
?>

</BODY></HTML>
