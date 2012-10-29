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


// Create Medicines Table

$schema = "";
$meds = array();
$m = 0;
$results = execute_query("SELECT * FROM medicines");		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	if ($_GET[$row['Name']] == $row['ID'])
	{
		$meds[$m] = array();
		$meds[$m]['id'] = $row['ID'];
		$meds[$m]['name'] = $row['Name'];
		$schema .= $row['Name'] . ' / ';
		$m++;
	}
}
$schema = substr($schema, 0, strlen($schema)-3);


	
//print_r($meds);
//echo $schema;


if ($_GET['EndDate_year'] == '')
{
	$enddate = "3000-01-01";
}
else
{
	$enddate = join_date($_GET, 'EndDate');
}

$start = join_date($_GET, 'StartDate');

// Check for overlaps

$sql = "SELECT * FROM antiretro_treatments_compliance WHERE ((EndDate>'".$start."' AND EndDate<='".$enddate."') OR  (StartDate<='".$start."' AND EndDate>='".$enddate."') OR (StartDate<'".$enddate."' AND EndDate>='".$enddate."')) AND PatientCode=".$_GET['PatientCode'];
//echo $sql;
$result = execute_query($sql);
if (mysql_num_rows($result) > 0)
{
	$temp_row = mysql_fetch_assoc($result);
	$eschema = $temp_row['Schema'];
	$start2 = $temp_row['StartDate'];
	$end2 = $temp_row['EndDate'];
	echo "<div class='img-shadow'>";
	echo "<p style='display: block; border: 1px solid red'>";
	echo "<BR> <b>Πρόβλημα</b> στην καταχώρηση <b>".$schema."</b><BR>";
	echo "Υπάρχει ήδη εγγραφή των φαρμάκων <b>$eschema</b> με ημερομηνία έναρξης ".$start2;
	if ($end2 == '3000-01-01')
	{
		echo " και ανοιχτή ημερομηνία λήξης";
	}
	else
	{
		echo " και ημερομηνία λήξης ".$end2;
	}
	echo "<BR> και θέλετε να καταχωρήσετε <b>$schema</b> με ημερομηνία έναρξης ".$start;
	if ($enddate == '3000-01-01')
	{
		echo " και ανοιχτή ημερομηνία λήξης";
	}
	else
	{
		echo " και ημερομηνία λήξης ".$enddate;
	}
	echo "</div></p>";

	echo "<br><br><br><br><br><br>";
	echo "<div class='img-shadow'>";
	show_errormsg("");
	echo "</div>";
}
mysql_free_result($result);

// Insert Medicines

$sql = "";
for ($i=0; $i<count($meds); $i++)
{
	$sql = "INSERT INTO antiretro_treatments VALUES('".$_GET['PatientCode']."', '".$meds[$i]['id']."', '".join_date($_GET, 'StartDate')."', '".$enddate."')";
//	echo $sql."<BR>";
	$what_happened = execute_query($sql);
}

// Insert Compliance, Discontinuation Reasons and Notes

$sql = "INSERT INTO antiretro_treatments_compliance VALUES('".$_GET['PatientCode']."', '".$schema."', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$_GET['comp']."', '".$_GET['Reason1']."', '".$_GET['Reason2']."', '".$_GET['Notes']."')";
execute_query($sql);


mysql_close($dbconnection);
perform_post_insert_actions("", "antiretro.php?code=".$_GET['PatientCode'], "");
?>

