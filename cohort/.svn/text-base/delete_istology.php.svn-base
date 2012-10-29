<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE></TITLE>
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
			$sql .= " DELETE FROM `".$_GET['examtable']."` ";
			$sql .= " WHERE PatientCode=". $_GET['code'];
			$sql .= " AND ExamDate='". $_GET['del_exam_date_'.$i]."'";
			$sql .= " AND System1='". $_GET['del_exam_system1_'.$i]."'";				
			$sql .= " AND System2='". $_GET['del_exam_system2_'.$i]."'";	
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
 		}
 	}
}

mysql_close($dbconnection);
perform_post_insert_actions("", getenv('HTTP_REFERER'), "");
?>

</BODY></HTML>