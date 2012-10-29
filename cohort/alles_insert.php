<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

?>

<HTML><HEAD>
<TITLE>Καταχώρηση 'Αλλων Θεραπείων</TITLE>
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

$therapies_query = "SELECT * FROM other_treatments_list";
$results = execute_query($therapies_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$list[$row['ID']] = $row['Therapy'];
}
mysql_free_result($results);

//form_data2table($_GET);
//$data_array2 = prepare_data("other_treatments", $_GET);
//$names = array_keys($data_array2);

$therapies = array();

$query = "SELECT * FROM other_treatments WHERE PatientCode=".$_GET['code'];
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

$i = 0;
for ($k = 0; $k < $_GET['therapies']; $k++)
{
	if (isset($_GET['Therapy'.$k])) 
	{
		$kk = $k;
		$new_therapies[$i]['therapy'] = $kk;
		$new_therapies[$i]['descr'] = $list[$kk];
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
		$i++;
	}
}

for ($i=0; $i< count($new_therapies); $i++)
{
 if ($new_therapies[$i]['start'] == "0000-00-00")
 {
	$start_query = "SELECT * FROM other_treatments WHERE PatientCode='".$_GET['code']."' AND EndDate='3000-01-01' AND Therapy='".$new_therapies[$i]['therapy']."'";
	$result = execute_query($start_query);
	$num_rows =	mysql_num_rows($result);
	if ($num_rows == 0)
	{
		die ("Για τον ασθενή ".$_GET['code']." δεν υπάρχει καταχωρημένη θεραπεία (για) ".$new_therapies[$i]['descr']." και ανοιχτή την ημερομηνία τέλους!");
	}
	else 
	{
		$row = mysql_fetch_assoc($result);
		$start_date = $row['StartDate'];
		if ($new_therapies[$i]['end'] >= $start_date)
		{
			$new_therapies[$i]['updatequery'] = "UPDATE other_treatments SET EndDate='". $new_therapies[$i]['end'] ."' WHERE PatientCode='".$_GET['code']."' AND Therapy='".$new_therapies[$i]['therapy']."' AND StartDate='". $start_date ."'";
		}
		else 
		{
			echo "<div class='img-shadow'>";
			echo "<p style='display: block; border: 1px solid red'>";
			echo "Η ημερομηνία διακοπής που δώσατε (".$new_therapies[$i]['end'].") της θεραπείας (για) ".$new_therapies[$i]['descr'];
			echo "<BR>δεν μπορεί να είναι πριν την ημερομηνία έναρξής της ".$start_date;
			echo "</div></p>";
			die();
		}
	}
 }
}

// Check Date Consistencies

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
					{/* echo "OK!"; */}
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
					{/* echo "OK!"; */}
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

for ($i=0; $i< count($new_therapies); $i++)
{
	if ($new_therapies[$i]['start'] == "0000-00-00")
	{
		execute_query($new_therapies[$i]['updatequery']);
	}
	else // if ($new_therapies[$i]['end'] == "3001-01-01")
	{
		$sql = "";
		$sql = "INSERT INTO `other_treatments` ( `PatientCode` , `Therapy` , `StartDate` , `EndDate` )";
		$sql .= " VALUES ('".$_GET['code']."', '".$new_therapies[$i]['therapy']."', '".$new_therapies[$i]['start'];
		$sql .="', '".$new_therapies[$i]['end']."');";
//		echo $sql;
		execute_query($sql);
	}
}

/*
for ($k = 0; $k < $_GET['therapies']; $k++)
{
	if (isset($_GET['Therapy1'.$k])) 
	{
		$sql = "";
		$sql = "INSERT INTO `other_treatments` ( `PatientCode` , `Therapy` , `StartDate` , `EndDate` )";
		$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['Therapy'.$k]."', '".$data_array2['StartDate'.$k];
		$sql .="', '".$data_array2['EndDate'.$k]."');";
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
	}
}
*/
mysql_close($dbconnection);
perform_post_insert_actions("other_treatments", "alles.php?code=".$_GET['code'], "");
?>

</BODY></HTML>
