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
		$data_array = prepare_data('patients', $_GET);
		$sql = "UPDATE `patients` SET `MELCode`='".$data_array['MELCode']."', ";
		$sql .= " `Name`='".$data_array['Name']."', ";
		$sql .= " `Surname`='".$data_array['Surname']."', ";
		$sql .= " `BirthDate`='".$data_array['BirthDate']."'";
		$sql .= " WHERE `PatientCode`='".$data_array['PatientCode']."'";
//		echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<script>alert('Τα δεδομένα τροποποιήθηκαν με επιτυχία!')</script>\n";
        //echo $data_array['PatientCode'];
//        echo "<p><a href='demographic.php?code=".$data_array['PatientCode']."'>Κάντε click εδώ για να εισάγετε τα δημογραφικά δεδομένα του ασθενή</a></p>";
    }
else 
	{
		echo "<script>alert('Τα δεδομένα ΔΕΝ τροποποιήθηκαν!')</script>\n";
		handle_query_results("patients", mysql_error(), $data_array);
	}
    
mysql_close($dbconnection);
perform_post_insert_actions("", "main.php?code=".$data_array['PatientCode'], "");
?>

</BODY></HTML>
