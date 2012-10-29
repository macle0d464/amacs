<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
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
*/
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//form_data2table($_GET);
check_patient($_POST['code']);
if (isset($_POST['count']))
{
	for ($i=0; $i < $_POST['count']; $i++)
	{
		if (isset($_POST['del_exam_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `".$_POST['examtable']."` ";
			$sql .= " WHERE PatientCode=". $_POST['code'];
			$sql .= " AND ExamDate='".$_POST['del_exam_date_'.$i]."'";
			$sql .= " AND Code='".$_POST['del_exam_code_'.$i]."'";
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
/*			if ($what_happened == 1)
    		{
    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
    			echo "<P>".mysql_error()."</P>";
			} */ 
 		}
 	}
}
perform_post_insert_actions("delete_exams_bio", getenv('HTTP_REFERER'));
mysql_close($dbconnection);
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>