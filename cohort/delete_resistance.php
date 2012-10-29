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
//form_data2table($_POST);
check_patient($_POST['code']);
if (isset($_POST['count']))
{
if ($_POST['table'] == "hiv_resistance")
{
	for ($i=0; $i < $_POST['count']; $i++)
	{
		if (isset($_POST['del_exam_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `hiv_resistance` ";
			$sql .= " WHERE PatientCode=". $_POST['code'];
			$sql .= " AND SampleID='". $_POST['del_id_'.$i]."'";
			$sql .= " AND SeqDate='". $_POST['del_date2_'.$i]."'";
			$sql .= " AND SampleDate='". $_POST['del_date1_'.$i]."'";
			$sql .= " AND Lab='". $_POST['del_lab_'.$i]."'";
			$sql .= " AND Algorithm='". $_POST['del_alg_'.$i]."'";					
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
			execute_query("DELETE FROM hiv_resistance_meds WHERE PatientCode=". $_POST['code']." AND SampleID='". $_POST['del_id_'.$i]."' AND SeqDate='". $_POST['del_date2_'.$i]."'");
			execute_query("DELETE FROM hiv_resistance_mutations WHERE PatientCode=". $_POST['code']." AND SampleID='". $_POST['del_id_'.$i]."' AND SeqDate='". $_POST['del_date2_'.$i]."'");
 		}
 	}
}
if ($_POST['table'] == "hiv_resistance_mutations")
{
	for ($i=0; $i < $_POST['count']; $i++)
	{
		if (isset($_POST['del_exam_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `hiv_resistance_mutations` ";
			$sql .= " WHERE PatientCode=". $_POST['code'];
			$sql .= " AND SampleID='". $_POST['del_id_'.$i]."'";
			$sql .= " AND SeqDate='". $_POST['del_date2_'.$i]."'";
			$sql .= " AND SeqType='". $_POST['del_seq_'.$i]."'";
			$sql .= " AND Mutation1='". $_POST['del_mut1_'.$i]."'";
			$sql .= " AND Mutation2='". $_POST['del_mut2_'.$i]."'";
			$sql .= " AND Mutation3='". $_POST['del_mut3_'.$i]."'";					
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
if ($_POST['table'] == "hiv_resistance_meds")
{
	for ($i=0; $i < $_POST['count']; $i++)
	{
		if (isset($_POST['del_exam_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `hiv_resistance_meds` ";
			$sql .= " WHERE PatientCode=". $_POST['code'];
			$sql .= " AND SampleID='". $_POST['del_id_'.$i]."'";
			$sql .= " AND SeqDate='". $_POST['del_date2_'.$i]."'";
			$sql .= " AND ARTCode='". $_POST['del_art_'.$i]."'";
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
//			echo mysql_error();
//			die;
 		}
 	}
}

}
echo mysql_error();
mysql_close($dbconnection);
perform_post_insert_actions("", "hiv_resistance.php?code=".$_POST['code'], "");
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>