<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αντι-ιικών Θεραπείων</TITLE>
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

if ($_GET['link_id'] == "")
{
	$link_id = 1;
}
else
{
	$link_id = $_GET['link_id'] + 1;
}

// Create Medicines Table

$schema = "";
$meds = array();
$m = 0;
$results = execute_query("SELECT * FROM hcv_medicines");		
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

$sql = "SELECT * FROM hcv_antiiikes_treatments_antapokrisi WHERE ((EndDate>'".$start."' AND EndDate<='".$enddate."') OR  (StartDate<='".$start."' AND EndDate>='".$enddate."') OR (StartDate<'".$enddate."' AND EndDate>='".$enddate."')) AND PatientCode=".$_GET['PatientCode'];
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

// INSERT Medicines in table antiiikes_treatments and antiiikes_treatments_dosages

$sql = "";
for ($i=0; $i<count($meds); $i++)
{
	$sql = "INSERT INTO hcv_antiiikes_treatments VALUES('".$_GET['PatientCode']."', '".$meds[$i]['id']."', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$link_id."')";
	echo $sql."<BR>";
	$what_happened = execute_query($sql);
	if ($_GET['dosage1'.$meds[$i]['id']] == '')
	{
		$sql = "INSERT INTO hcv_antiiikes_treatments_dosages VALUES('".$_GET['PatientCode']."', '".$meds[$i]['name']."', NULL, NULL, '0', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$link_id."')";		
	}
	else
	{
		$sql = "INSERT INTO hcv_antiiikes_treatments_dosages VALUES('".$_GET['PatientCode']."', '".$meds[$i]['name']."', '".replacecomma($_GET['dosage1'.$meds[$i]['id']])."', '".$_GET['dosage1type'.$meds[$i]['id']]."', '".$_GET['dosage2type'.$meds[$i]['id']]."', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$link_id."')";
	}
	echo $sql."<BR>";
	$what_happened = execute_query($sql);	
	$link_id++;
}

// INSERT Medicine Schemas 

	$today = getdate();
	$now_days = round(strtotime("now")/86400);
	$th_days = round(strtotime($enddate)/86400);
	if ($now_days < $th_days+28)
	{
		$_GET['Bioximiki_polu_prwimi'] = '-1';
		$_GET['Iologiki_polu_prwimi'] = '-1';
	} 
	if ($now_days < $th_days+84)
	{
		$_GET['Bioximiki_prwimi'] = '-1';
		$_GET['Iologiki_prwimi'] = '-1';		
	} 
	if ($now_days < $th_days+168)
	{ 
		$_GET['Bioximiki_24'] = '-1';
		$_GET['Iologiki_24'] = '-1';	
	}
	if ($enddate == "3000-01-01")
	{
		$_GET['Bioximiki_end'] = '-1';
		$_GET['Iologiki_end'] = '-1';	
		$_GET['Info1'] = '';
		$_GET['Info2'] = '';	
	}
	if (($enddate == "3000-01-01") || ($now_days < $th_days_end+182))
	{
		$_GET['Bioximiki_longterm'] = '-1';
		$_GET['Iologiki_longterm'] = '-1';		
	}
	
 	$sql = "INSERT INTO hcv_antiiikes_treatments_antapokrisi VALUES('".$_GET['PatientCode']."', '".$schema."', '".join_date($_GET, 'StartDate')."', '".$enddate."', ";
	$sql .= "'".$_GET['Bioximiki_polu_prwimi']."', '".$_GET['Bioximiki_prwimi']."', '".$_GET['Bioximiki_24']."', '".$_GET['Bioximiki_end']."', '".$_GET['Bioximiki_longterm']."', ";
	$sql .= "'".$_GET['Iologiki_polu_prwimi']."', '".$_GET['Iologiki_prwimi']."', '".$_GET['Iologiki_24']."', '".$_GET['Iologiki_end']."', '".$_GET['Iologiki_longterm']."', '".$_GET['Info1']."', ";
	if ($_GET['Info1'] == 1)
	{
		$sql .= "NULL, ";
	}
	else 
	{
		$sql .= "'".$_GET['Info2']."', ";
	}
	$sql .= "'".$_GET['Note']."');";
	$sql = replace2null($sql); 
	echo $sql;
	$what_happened = execute_query($sql);
//	echo mysql_error();

mysql_close($dbconnection);

perform_post_insert_actions("hcv_antiiikes_treatments", "hcv_antiiikes.php?code=".$_GET['code'], "");
?>
</BODY>
</HTML>
