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

$sql = "SELECT * FROM hbv_antiiikes_treatments_antapokrisi WHERE StartDate!='".$_GET['start']."' AND ((EndDate>'".$start."' AND EndDate<='".$enddate."') OR  (StartDate<='".$start."' AND EndDate>='".$enddate."') OR (StartDate<'".$enddate."' AND EndDate>='".$enddate."')) AND PatientCode=".$_GET['code'];
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

$i = "";

$sql  = "UPDATE hbv_antiiikes_treatments_antapokrisi SET Info1='".$_GET['Info1']."' ";
if (1) //(isset($_GET['Bioximiki_arxiki']))
{
	$sql .= ", Bioximiki_arxiki='".$_GET['Bioximiki_arxiki']."'";
}
if (1) //(isset($_GET['Bioximiki_arxikiDate']))
{
	$sql .= ", Bioximiki_arxiki_date='".join_date($_GET, 'Bioximiki_arxikiDate')."'";
}
if (1) //(isset($_GET['Bioximiki_diafugi']))
{
	$sql .= ", Bioximiki_diafugi='".$_GET['Bioximiki_diafugi']."'";
}
if (1) //(isset($_GET['Bioximiki_diafugiDate']))
{
	$sql .= ", Bioximiki_diafugi_date='".join_date($_GET, 'Bioximiki_diafugiDate')."'";
}
if (1) //(isset($_GET['Bioximiki_end']))
{
	$sql .= ", Bioximiki_end='".$_GET['Bioximiki_end']."'";
}
if (1) //(isset($_GET['Bioximiki_endDate']))
{
	$sql .= ", Bioximiki_end_date='".join_date($_GET, 'Bioximiki_endDate')."'";
}
if (1) //(isset($_GET['Bioximiki_longterm']))
{
	$sql .= ", Bioximiki_longterm='".$_GET['Bioximiki_longterm']."'";
}
if (1) //(isset($_GET['Bioximiki_longtermDate']))
{
	$sql .= ", Bioximiki_longterm_date='".join_date($_GET, 'Bioximiki_longtermDate')."'";
}

$sql .= ", ";

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
	
	if ($Iologiki_arxiki_value != "")
	{
		$sql .= "Iologiki_arxiki_value='".$Iologiki_arxiki_value."', Iologiki_arxiki_units='".$Iologiki_arxikiUnits."', Iologiki_arxiki_method='".$Iologiki_arxiki_method."', Iologiki_arxiki_date='".join_date($_GET, 'Iologiki_arxikiDate')."', ";
	}
	else 
	{
		$sql .= "Iologiki_arxiki_value=NULL, Iologiki_arxiki_units=NULL, Iologiki_arxiki_method=NULL, Iologiki_arxiki_date=NULL, ";
	}
	if ($Iologiki_diafugi_value != "")
	{
		$sql .= "Iologiki_diafugi_value='".$Iologiki_diafugi_value."', Iologiki_diafugi_units='".$Iologiki_diafugiUnits."', Iologiki_diafugi_method='".$Iologiki_diafugi_method."', Iologiki_diafugi_date='".join_date($_GET, 'Iologiki_diafugiDate')."', ";
	}
	else 
	{
		$sql .= "Iologiki_diafugi_value=NULL, Iologiki_diafugi_units=NULL, Iologiki_diafugi_method=NULL, Iologiki_diafugi_date=NULL, ";
	}
	if ($Iologiki_end_value != "")
	{	
		$sql .= "Iologiki_end_value='".$Iologiki_end_value."', Iologiki_end_units='".$Iologiki_endUnits."', Iologiki_end_method='".$Iologiki_end_method."', Iologiki_end_date='".join_date($_GET, 'Iologiki_endDate')."', ";
	}
	else 
	{
		$sql .= "Iologiki_end_value=NULL, Iologiki_end_units=NULL, Iologiki_end_method=NULL, Iologiki_end_date=NULL, ";
	}
	if ($Iologiki_longterm_value != "")
	{	
		$sql .= "Iologiki_longterm_value='".$Iologiki_longterm_value."', Iologiki_longterm_units='".$Iologiki_longtermUnits."', Iologiki_longterm_method='".$Iologiki_longterm_method."', Iologiki_longterm_date='".join_date($_GET, 'Iologiki_longtermDate')."', ";
	}
	else 
	{
		$sql .= "Iologiki_longterm_value=NULL, Iologiki_longterm_units=NULL, Iologiki_longterm_method=NULL, Iologiki_longterm_date=NULL, ";
	}
	
if ($_GET['Orologiki_end'.$i] != "")
{
	$sql .= "Orologiki_end='".$_GET['Orologiki_end'.$i]."', ";
}
else 
{
	$sql .= "Orologiki_end='-1', ";
}
if ($_GET['Orologiki_longterm'.$i] != "")
{
	$sql .= "Orologiki_longterm='".$_GET['Orologiki_longterm'.$i]."', ";
}
else 
{
	$sql .= "Orologiki_longterm='-1', ";
}
if ($_GET['Info1'] == 1)
{
	$sql .= "Info2=NULL, ";
}
else 
{
	$sql .= "Info2='".$_GET['Info2']."', ";
}

$sql .= " Notes='".$_GET['Notes']."', StartDate='".join_date($_GET, 'StartDate')."'";
//if ((isset($_GET['EndDate_year'])) && ($_GET['EndDate_year'] != ''))
//{
	$sql .= ", EndDate='$enddate' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."'";	
//}
//else
//{
//	$sql .= " WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."'";
//}

$sql = replace2null($sql);
// form_data2table($_GET); 
// echo "<pre>";
// echo $sql;
execute_query($sql);
// echo mysql_error();
// die;

execute_query("UPDATE hbv_antiiikes_treatments SET EndDate='$enddate', StartDate='".join_date($_GET, 'StartDate')."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."'");
// UPDATE StartDate Change in Dosages
execute_query("UPDATE hbv_antiiikes_treatments_dosages SET StartDate='".join_date($_GET, 'StartDate')."' WHERE PatientCode='".$_GET['code']."' AND StartDate='".$_GET['start']."'");
// UPDATE EndDate Change in Dosages
execute_query("UPDATE hbv_antiiikes_treatments_dosages SET EndDate='$enddate' WHERE PatientCode='".$_GET['code']."' AND EndDate='".$_GET['end']."'");


perform_post_insert_actions("","hbv_show_antiiikes_data.php?code=".$_GET['code'],"");

mysql_close($dbconnection);
?>
</BODY></HTML>
