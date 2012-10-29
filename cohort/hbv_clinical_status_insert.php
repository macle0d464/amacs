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
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Νέου Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css"></HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$patient_data_result = execute_query("SELECT * FROM hbv_clinical_status WHERE PatientCode=".$_GET['PatientCode']);
if (mysql_num_rows($patient_data_result) > 0)
{ 
	$patient_data = mysql_fetch_assoc($patient_data_result);
	$anti = $patient_data['KirosiDate'];
	$nonanti = $patient_data['NonKirosiDate'];
	$hkk = $patient_data['HKKDate'];
	$metamosx = $patient_data['TransplantDate'];	
}
else
{
	$anti = "";
	$nonanti = "";
	$hkk = "";
	$metamosx = "";
}

if ($_GET['KirosiDate_year'] != "")
{
	$date1 = join_date($_GET, 'KirosiDate');
	if ($nonanti != "")
	{
		if ($date1 > $nonanti)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι μετά την ημερομηνία πρωτοδιάγνωσης μη αντιρροπούμενης κίρρωσης '.$nonanti.'!');
			die;
		}
	}
	if ($hkk != "")
	{
		if ($date1 > $hkk)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι μετά την ημερομηνία πρωτοδιάγνωσης ΗΚΚ '.$hkk.'!');
			die;
		}
	}
	if ($metamosx != "")
	{
		if ($date1 > $metamosx)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι μετά την ημερομηνία διενέργειας μεταμόσχευσης ήπατος '.$metamosx.'!');
			die;
		}
	}	
}

if ($_GET['NonKirosiDate_year'] != "")
{
	$date1 = join_date($_GET, 'NonKirosiDate');
	if ($hkk != "")
	{
		if ($date1 > $hkk)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι μετά την ημερομηνία πρωτοδιάγνωσης ΗΚΚ '.$hkk.'!');
			die;
		}
	}
	if ($metamosx != "")
	{
		if ($date1 > $metamosx)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι μετά την ημερομηνία διενέργειας μεταμόσχευσης ήπατος '.$metamosx.'!');
			die;
		}
	}	
}

if ($_GET['HKKDate_year'] != "")
{
	$date1 = join_date($_GET, 'HKKDate');
	if ($nonanti != "")
	{
		if ($date1 < $nonanti)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι πριν την ημερομηνία πρωτοδιάγνωσης μη αντιρροπούμενης κίρρωσης '.$nonanti.'!');
			die;
		}
	}
	if ($anti != "")
	{
		if ($date1 < $anti)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι πριν την ημερομηνία πρωτοδιάγνωσης αντιρροπούμενης κίρρωσης '.$anti.'!');
			die;
		}
	}
	if ($hkk != "")
	{
		if ($date1 < $hkk)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι πριν την ημερομηνία πρωτοδιάγνωσης ΗΚΚ '.$hkk.'!');
			die;
		}
	}
}

if ($_GET['TransplantDate_year'] != "")
{
	$date1 = join_date($_GET, 'TransplantDate');
	if ($nonanti != "")
	{
		if ($date1 < $nonanti)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι πριν την ημερομηνία πρωτοδιάγνωσης μη αντιρροπούμενης κίρρωσης '.$nonanti.'!');
			die;
		}
	}
	if ($anti != "")
	{
		if ($date1 < $anti)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι πριν την ημερομηνία πρωτοδιάγνωσης αντιρροπούμενης κίρρωσης '.$anti.'!');
			die;
		}
	}
	if ($metamosx != "")
	{
		if ($date1 > $metamosx)
		{
			show_errormsg('Η ημερομηνία '.$date1.' που δώσατε για καταχώρηση είναι μετά την ημερομηνία διενέργειας μεταμόσχευσης ήπατος '.$metamosx.'!');
			die;
		}
	}	
}
?>

<?php
if ($_GET['has_entry'])
{
	$sql = "UPDATE `hbv_clinical_status` ";
	switch ($_GET['State']) {
	case 1:
		$sql .= "SET `XroniaHBV`='1' ";
		break;
	case 2:
		$sql .= "SET `KirosiDate`='".join_date($_GET, 'KirosiDate')."' ";
		break;
	case 3:
		$sql .= "SET `NonKirosiDate`='".join_date($_GET, 'NonKirosiDate')."' ";
		break;
	case 4:
		$sql .= "SET `HKKDate`='".join_date($_GET, 'HKKDate')."' ";
		break;
	case 5:
		$sql .= "SET `TransplantDate`='".join_date($_GET, 'TransplantDate')."' ";
		break;
	case 6:
		$sql .= "SET `Anosia`='1' ";
		break;
	case 7:
		$sql .= "SET `Emboliasmos`='1' ";
		break;	
	case 8:
		$sql .= "SET `Askitis`='".join_date($_GET, 'NonKirosiDate')."' ";
		break;
	case 9:
		$sql .= "SET `Kirsoi`='".join_date($_GET, 'NonKirosiDate')."' ";
		break;
	case 10:
		$sql .= "SET `Egkefalopatheia`='".join_date($_GET, 'NonKirosiDate')."' ";
		break;
	case 11:
		$sql .= "SET `Nefriki`='".join_date($_GET, 'NonKirosiDate')."' ";
		break;
	case 12:
		$sql .= "SET `Peritonitis`='".join_date($_GET, 'NonKirosiDate')."' ";
		break;										
	}			
	$sql .= "WHERE PatientCode='".$_GET['PatientCode']."'";
}
else
{
	$sql = "INSERT INTO `hbv_clinical_status` ";
	switch ($_GET['State']) {
	case 1:
		$sql .= "(`PatientCode`, `XroniaHBV`) VALUES ('".$_GET['PatientCode']."', '1')";
		break;
	case 2:
		$sql .= "(`PatientCode`, `KirosiDate`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'KirosiDate')."')";
		break;
	case 3:
		$sql .= "(`PatientCode`, `NonKirosiDate`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'NonKirosiDate')."')";
		break;										
	case 4:
		$sql .= "(`PatientCode`, `HKKDate`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'HKKDate')."')";
		break;
	case 5:
		$sql .= "(`PatientCode`, `TransplantDate`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'TransplantDate')."')";
		break;
	case 6:
		$sql .= "(`PatientCode`, `Anosia`) VALUES ('".$_GET['PatientCode']."', '1')";
		break;
	case 7:
		$sql .= "(`PatientCode`, `Emboliasmos`) VALUES ('".$_GET['PatientCode']."', '1')";
		break;
	case 8:
		$sql .= "(`PatientCode`, `Askitis`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'NonKirosiDate')."')";
		break;
	case 9:
		$sql .= "(`PatientCode`, `Kirsoi`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'NonKirosiDate')."')";
		break;
	case 10:
		$sql .= "(`PatientCode`, `Egkefalopatheia`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'NonKirosiDate')."')";
		break;
	case 11:
		$sql .= "(`PatientCode`, `Nefriki`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'NonKirosiDate')."')";
		break;
	case 12:
		$sql .= "(`PatientCode`, `Peritonitis`) VALUES ('".$_GET['PatientCode']."', '".join_date($_GET, 'NonKirosiDate')."')";
		break;		
	}
}
//echo $sql;
$what_happened = execute_query($sql);
/*
if ($what_happened == 1)
    {
        echo "<script>alert('Τα δεδομένα τροποποιήθηκαν με επιτυχία!')</script>\n";
        //echo $data_array['PatientCode'];
    }
else 
	{
		echo "<script>alert('Τα δεδομένα ΔΕΝ τροποποιήθηκαν!')</script>\n";
		echo mysql_error();
	}*/
//echo "<p><a href='hbv_clinical_status.php?code=".$_GET['PatientCode']."'>Κάντε click εδώ για να εισάγετε κι άλλη κλινική κατάσταση</a></p>";    
mysql_close($dbconnection);
perform_post_insert_actions("hbv_clinical_status", "hbv_clinical_status.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
