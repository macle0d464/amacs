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
<? PrintTopMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
validate_data('patients', $_GET);
$data_array = prepare_data('patients', $_GET);

if (($_GET['PatientCode'] == "") && ($_GET['MELCode'] == "1111111"))
{
	$codetype = "NOMELNOKEELCODE";
	$data_array['PatientCode'] = $_GET['next_nonmelkeelcode'];
}
elseif (($_GET['PatientCode'] == "") && ($_GET['MELCode'] != ""))
{
	$codetype = "NOKEELCODE";
	$data_array['PatientCode'] = $_GET['clinic']*100000 + $data_array['MELCode'];
}
else
{
	$codetype = "FROMKEEL";
}

$sql = "INSERT INTO `patients` (`PatientCode`, `MELCode`, `Name`, `Surname`, `BirthDate`, `CodeType`) ";
$sql .= "VALUES ( '" . $data_array['PatientCode'] . "' , '" . $data_array['MELCode'] . "' , '" . $data_array['Name'] . "' , '" . $data_array['Surname'] . "' , '" . $data_array['BirthDate']  . "', '".$codetype."') ";
//echo $sql;

$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<script>alert('Τα δεδομένα καταχωρήθηκαν με επιτυχία!')</script>\n";
//        echo $data_array['PatientCode'];
//        echo "<p><a href='demographic.php?code=".$data_array['PatientCode']."'>Κάντε click εδώ για να εισάγετε τα δημογραφικά δεδομένα του ασθενή</a></p>";
    	$sql = "INSERT INTO last_state (`PatientCode`, `LastState`) VALUES ('".$data_array['PatientCode']."', '1')";
    	execute_query($sql);
		perform_post_insert_actions("patients", "demographic.php?code=".$data_array['PatientCode'], "");
    }
else 
	{
		handle_query_results("patients", mysql_error(), $data_array);
		echo "<script>alert('Τα δεδομένα ΔΕΝ καταχωρήθηκαν!')</script>\n";
		
	}
mysql_close($dbconnection);
?>

</BODY></HTML>
