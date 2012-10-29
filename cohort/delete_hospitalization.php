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
if (isset($_GET['count']))
{
	for ($i=0; $i < $_GET['count']; $i++)
	{
		if (isset($_GET['del_exam_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `hospitalization` ";
			$sql .= " WHERE PatientCode=". $_GET['code'];
			$sql .= " AND EntryDate='". $_GET['del_start_'.$i]."'";
			$sql .= " AND ExitDate='". $_GET['del_end_'.$i]."'";
			$sql .= " AND Diagnosis='". $_GET['del_diag_'.$i]."'";
			$sql .= " AND Ekbasi='". $_GET['del_ekb_'.$i]."'";			
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
			if ($what_happened == 1)
    		{
//    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
//    			echo "<P>$what_happened</P>";
			}
 		}
 	}
}
echo mysql_error();
mysql_close($dbconnection);
perform_post_insert_actions("", "hospitalization.php?code=".$_GET['code'], "");
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>