<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Στοιχείων Ατομικού Αναμνηστικού Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css"></HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//form_data2table($_GET);
check_patient($_GET['code']);
if (isset($_GET['xronia']))
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	if ($_GET['table'] == "hbv_clinical_status")
	{
		$sql .= " SET XroniaHBV='0'";
	}
	else
	{
		$sql .= " SET XroniaHCV='0'";
	}
	$sql .= " WHERE PatientCode=". $_GET['code'];
//	echo "<BR>".$sql."<BR><BR>";
	$what_happened = execute_query($sql);
/*	if ($what_happened == 1)
	{
		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
	}
	else
	{
		echo "<P>$what_happened</P>";
	} */
}
if ($_GET['anosia'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Anosia='0'";
		$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['emboliasmos'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Emboliasmos='0'";
		$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['kirosi'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET KirosiDate=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
//	echo "<BR>".$sql."<BR><BR>";
	$what_happened = execute_query($sql);
/*	if ($what_happened == 1)
	{
		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
	}
	else
	{
		echo "<P>$what_happened</P>";
	} */
}
if ($_GET['nonkirosi'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET NonKirosiDate=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
//	echo "<BR>".$sql."<BR><BR>";
	$what_happened = execute_query($sql);
/*	if ($what_happened == 1)
	{
		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
	}
	else
	{
		echo "<P>$what_happened</P>";
	} */
}
if ($_GET['askitis'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Askitis=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['kirsoi'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Kirsoi=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['egkefalopatheia'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Egkefalopatheia=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['nefriki'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Nefriki=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['peritonitis'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET Peritonitis=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
	$what_happened = execute_query($sql);
}
if ($_GET['hkk'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET HKKDate=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
//	echo "<BR>".$sql."<BR><BR>";
	$what_happened = execute_query($sql);
/*	if ($what_happened == 1)
	{
		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
	}
	else
	{
		echo "<P>$what_happened</P>";
	} */
}
if ($_GET['transplant'] == "on")
{
	$sql="";
	$sql .= " UPDATE `".$_GET['table']."` ";
	$sql .= " SET TransplantDate=NULL";
	$sql .= " WHERE PatientCode=". $_GET['code'];
//	echo "<BR>".$sql."<BR><BR>";
	$what_happened = execute_query($sql);
/*	if ($what_happened == 1)
	{
		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
	}
	else
	{
		echo "<P>$what_happened</P>";
	} */
}

$entry = mysql_fetch_assoc(execute_query("SELECT * FROM `".$_GET['table']."` WHERE PatientCode='".$_GET['code']."'"));
if ($_GET['table'] == "hbv_clinical_status")
{
	if ($entry['XroniaHBV'] == 0 && $entry['KirosiDate'] ==NULL && $entry['HKKDate'] ==NULL && $entry['TransplantDate'] ==NULL && $entry['NonKirosiDate'] ==NULL && $entry['Askitis'] ==NULL && $entry['Kirsoi'] ==NULL && $entry['Egkefalopatheia'] ==NULL && $entry['Nefriki'] ==NULL && $entry['Peritonitis'] ==NULL && $entry['Anosia'] =="0" && $entry['Emboliasmos'] == "0")
	{
		$no_entry = 1;
	}
	else
	{
		$no_entry = 0;
	}
}
else
{
	if ($entry['XroniaHCV'] == 0 && $entry['KirosiDate'] ==NULL && $entry['HKKDate'] ==NULL && $entry['TransplantDate'] ==NULL)
	{
		$no_entry = 1;
	}
	else
	{
		$no_entry = 0;
	}
}
if ($no_entry)
{
	$sql="";
	$sql .= " DELETE FROM `".$_GET['table']."` ";
	$sql .= " WHERE PatientCode=". $_GET['code'];
//	echo "<BR>".$sql."<BR><BR>";
	$what_happened = execute_query($sql);
	if ($what_happened == 1)
	{
		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
	}
	else
	{
		echo "<P>$what_happened</P>";
	}
	
}
mysql_close($dbconnection);
perform_post_insert_actions("", $_GET['table'].".php?code=".$_GET['code'], "");
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>