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
$results = execute_query("SELECT * FROM hbv_medicines");		
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

$sql = "SELECT * FROM hbv_antiiikes_treatments_antapokrisi WHERE ((EndDate>'".$start."' AND EndDate<='".$enddate."') OR  (StartDate<='".$start."' AND EndDate>='".$enddate."') OR (StartDate<'".$enddate."' AND EndDate>='".$enddate."')) AND PatientCode=".$_GET['PatientCode'];
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
	$sql = "INSERT INTO hbv_antiiikes_treatments VALUES('".$_GET['PatientCode']."', '".$meds[$i]['id']."', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$link_id."')";
	echo $sql."<BR>";
	$what_happened = execute_query($sql);
	if ($_GET['dosage1'.$meds[$i]['id']] == '')
	{
		$sql = "INSERT INTO hbv_antiiikes_treatments_dosages VALUES('".$_GET['PatientCode']."', '".$meds[$i]['name']."', NULL, NULL, '0', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$link_id."')";		
	}
	else
	{
		$sql = "INSERT INTO hbv_antiiikes_treatments_dosages VALUES('".$_GET['PatientCode']."', '".$meds[$i]['name']."', '".replacecomma($_GET['dosage1'.$meds[$i]['id']])."', '".$_GET['dosage1type'.$meds[$i]['id']]."', '".$_GET['dosage2type'.$meds[$i]['id']]."', '".join_date($_GET, 'StartDate')."', '".$enddate."', '".$link_id."')";
	}
	echo $sql."<BR>";
	$what_happened = execute_query($sql);	
	$link_id++;
}

// INSERT Medicine Schemas 

 	if ($_GET['io_arxiki'] == "posotiki")
	{
		$Iologiki_arxiki_value = $_GET['Iologiki_arxiki_Operator'] . $_GET['Iologiki_arxiki_value_posotiki'];
		$Iologiki_arxiki_method = $_GET['Iologiki_arxiki_method_posotiki'];
		$Iologiki_arxikiUnits = $_GET['Iologiki_arxikiUnits_posotiki'];
	}
	else
	{
		$Iologiki_arxiki_value = $_GET['Iologiki_arxiki_value_poiotiki'];
		$Iologiki_arxiki_method = $_GET['Iologiki_arxiki_method_poiotiki'];
		$Iologiki_arxikiUnits = "NULL";
	}
 	if ($_GET['io_diafugi'] == "posotiki")
	{
		$Iologiki_diafugi_value = $_GET['Iologiki_diafugi_Operator'] . $_GET['Iologiki_diafugi_value_posotiki'];
		$Iologiki_diafugi_method = $_GET['Iologiki_diafugi_method_posotiki'];
		$Iologiki_diafugiUnits = $_GET['Iologiki_diafugiUnits_posotiki'];
	}
	else
	{
		$Iologiki_diafugi_value = $_GET['Iologiki_diafugi_value_poiotiki'];
		$Iologiki_diafugi_method = $_GET['Iologiki_diafugi_method_poiotiki'];
		$Iologiki_diafugiUnits = "NULL";
	}
 	if ($_GET['io_end'] == "posotiki")
	{
		$Iologiki_end_value = $_GET['Iologiki_end_Operator'] . $_GET['Iologiki_end_value_posotiki'];
		$Iologiki_end_method = $_GET['Iologiki_end_method_posotiki'];
		$Iologiki_endUnits = $_GET['Iologiki_endUnits_posotiki'];
	}
	else
	{
		$Iologiki_end_value = $_GET['Iologiki_end_value_poiotiki'];
		$Iologiki_end_method = $_GET['Iologiki_end_method_poiotiki'];
		$Iologiki_endUnits = "NULL";
	} 	
 	if ($_GET['io_longterm'] == "posotiki")
	{
		$Iologiki_longterm_value = $_GET['Iologiki_longterm_Operator'] . $_GET['Iologiki_longterm_value_posotiki'];
		$Iologiki_longterm_method = $_GET['Iologiki_longterm_method_posotiki'];
		$Iologiki_longtermUnits = $_GET['Iologiki_longtermUnits_posotiki'];
	}
	else
	{
		$Iologiki_longterm_value = $_GET['Iologiki_longterm_value_poiotiki'];
		$Iologiki_longterm_method = $_GET['Iologiki_longterm_method_poiotiki'];
		$Iologiki_longtermUnits = "NULL";
	}	
	
/*	
 	if (isset($_GET['Iologiki_arxiki_Operator']))
	{
		$_GET['Iologiki_arxiki_value'] = $_GET['Iologiki_arxiki_Operator'] . $_GET['Iologiki_arxiki_value'];
	}
 	if (isset($_GET['Iologiki_diafugi_Operator']))
	{
		$_GET['Iologiki_diafugi_value'] = $_GET['Iologiki_diafugi_Operator'] . $_GET['Iologiki_diafugi_value'];
	}
 	if (isset($_GET['Iologiki_end_Operator']))
	{
		$_GET['Iologiki_end_value'] = $_GET['Iologiki_end_Operator'] . $_GET['Iologiki_end_value'];
	}
 	if (isset($_GET['Iologiki_longterm_Operator']))
	{
		$_GET['Iologiki_longterm_value'] = $_GET['Iologiki_longterm_Operator'] . $_GET['Iologiki_longterm_value'];
	}
*/	

	$today = getdate();
	$now_days = round(strtotime("now")/86400);
	$th_days = round(strtotime($enddate)/86400);
	if ($enddate == "3000-01-01")
	{
		$_GET['Bioximiki_end'] = '-1';
		$Iologiki_end_value = '';	
		$_GET['Info1'] = '';
		$_GET['Info2'] = '';	
	}
	if (($enddate == "3000-01-01") || ($now_days < $th_days_end+360))
	{
		$_GET['Bioximiki_longterm'] = '-1';
		$Iologiki_longterm_value = '';		
	}

 	$sql = "INSERT INTO hbv_antiiikes_treatments_antapokrisi VALUES('".$_GET['PatientCode']."', '".$schema."', '".join_date($_GET, 'StartDate')."', '".$enddate."', ";

	$sql .= "'".$_GET['Bioximiki_arxiki']."', '".join_date($_GET, 'Bioximiki_arxikiDate')."', ";
	$sql .= "'".$_GET['Bioximiki_diafugi']."', '".join_date($_GET, 'Bioximiki_diafugiDate')."', ";
	$sql .= "'".$_GET['Bioximiki_end']."', '".join_date($_GET, 'Bioximiki_endDate')."', ";
	$sql .= "'".$_GET['Bioximiki_longterm']."', '".join_date($_GET, 'Bioximiki_longtermDate')."', ";


	if ($Iologiki_arxiki_value != "")
	{
		$sql .= "'".$Iologiki_arxiki_value."', '".$Iologiki_arxikiUnits."', '".$Iologiki_arxiki_method."', '".join_date($_GET, 'Iologiki_arxikiDate')."', ";
	}
	else 
	{
		$sql .= "NULL, NULL, NULL, NULL, ";
	}
	if ($Iologiki_diafugi_value != "")
	{
	$sql .= "'".$Iologiki_diafugi_value."', '".$Iologiki_diafugiUnits."', '".$Iologiki_diafugi_method."', '".join_date($_GET, 'Iologiki_diafugiDate')."', ";
		}
	else 
	{
		$sql .= "NULL, NULL, NULL, NULL, ";
	}
	if ($Iologiki_end_value != "")
	{	
	$sql .= "'".$Iologiki_end_value."', '".$Iologiki_endUnits."', '".$Iologiki_end_method."', '".join_date($_GET, 'Iologiki_endDate')."', ";
		}
	else 
	{
		$sql .= "NULL, NULL, NULL, NULL, ";
	}
	if ($Iologiki_longterm_value != "")
	{	
	$sql .= "'".$Iologiki_longterm_value."', '".$Iologiki_longtermUnits."', '".$Iologiki_longterm_method."', '".join_date($_GET ,'Iologiki_longtermDate')."', ";
	}
	else 
	{
		$sql .= "NULL, NULL, NULL, NULL, ";
	}
	if ($_GET['Orologiki_end'] != "")
	{
		$sql .= "'".$_GET['Orologiki_end']."', ";
	}
	else 
	{
		$sql .= "'-1', ";
	}
	if ($_GET['Orologiki_longterm'] != "")
	{
		$sql .= "'".$_GET['Orologiki_longterm']."', ";
	}
	else 
	{
		$sql .= "'-1', ";
	}	
	$sql .= " '".$_GET['Info1']."', ";
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
//	echo $sql."\n";
	$what_happened = execute_query($sql);
echo mysql_error();
mysql_close($dbconnection);

perform_post_insert_actions("antiiikes_treatments", "hbv_antiiikes.php?code=".$_GET['code'], "");
?>
</BODY>
</HTML>
