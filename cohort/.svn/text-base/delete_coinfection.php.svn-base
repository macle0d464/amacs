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
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//form_data2table($_GET);
check_patient($_GET['code']);
if (isset($_GET['type']))
{
	if ($_GET['type'] == "hbv")
	{
		$sql="";
		$sql .= " UPDATE `coinfections` ";
		$sql .= "SET HBV='0', HBVDate=NULL, HBVGenotype=''";
		$sql .= " WHERE PatientCode='".$_GET['code']."'";
//		echo "<BR>".$sql."<BR><BR>";
		$what_happened = execute_query($sql);
		if ($what_happened == 1)
    	{
//    		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
		}
		else
    	{
//    		echo "<P>$what_happened</P>";
		}
		// Delete Data from other tables
		delete_from_table($_GET['code'], "hbv_clinical_status");
		delete_from_table($_GET['code'], "hbv_iologikes");
		delete_from_table($_GET['code'], "hbv_istology");
		delete_from_table($_GET['code'], "hbv_other_treatments_before_art");
		delete_from_table($_GET['code'], "hbv_other_treatments_after_art");
  	}
	if ($_GET['type'] == "hcv")
	{
		$sql="";
		$sql .= " UPDATE `coinfections` ";
		$sql .= "SET HCV='0', HCVDate=NULL, HCVGenotype=''";
		$sql .= " WHERE PatientCode='".$_GET['code']."'";
//		echo "<BR>".$sql."<BR><BR>";
		$what_happened = execute_query($sql);
		if ($what_happened == 1)
    	{
 //   		echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
		}
		else
    	{
//    		echo "<P>$what_happened</P>";
		}
		delete_from_table($_GET['code'], "hcv_clinical_status");
		delete_from_table($_GET['code'], "hcv_iologikes");
		delete_from_table($_GET['code'], "hcv_istology");
		delete_from_table($_GET['code'], "hcv_other_treatments");
  	}
}

mysql_close($dbconnection);
perform_post_insert_actions("", "coinfection.php?code=".$_GET['code'], "");
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>