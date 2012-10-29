<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αιματολογικών Εξετάσεων Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
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

check_patient($_GET['PatientCode']);
$data_array2 = prepare_data("exams_ourwn", $_GET);
$names = array_keys($data_array2);
//print_r($_GET);
//print_r($data_array2);

$sql = "";
for ($k = 0; $k < $_GET['exams']; $k++)
{  
$sql = "INSERT INTO `exams_ourwn` ( `PatientCode` , `ExamDate` , `EB` , `Leukwma` , `Leukwma_extra` , `Puosfairia`, `Eruthra`, `Kulindroi`)";
$sql .= " VALUES ('".$data_array2['PatientCode']."', '".$data_array2['ExamDate'.$k];
$sql .="', '".$data_array2['EB'.$k]."', '".$data_array2['Leukwma'.$k]."', '".$data_array2['Leukwma_extra'.$k]."', '".$data_array2['Puosfairia'.$k];
$sql .="', '".$data_array2['Eruthra'.$k]."', '".$data_array2['Kulindroi'.$k]."');";
echo $sql;
$sql = replace2null($sql);
echo $sql;
$what_happened = execute_query($sql);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }
}
echo mysql_error();
//form_data2table($_GET);
mysql_close($dbconnection);
perform_post_insert_actions("ourwn", "ourwn.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
