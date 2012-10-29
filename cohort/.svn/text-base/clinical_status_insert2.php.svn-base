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
$what_happened = insert_data("aids_clinical_status", $_GET);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }

$what_to_store = prepare_data("aids_clinical_status", $_GET);

if ($what_to_store['CategoryA'])
{
$what_happened = insert_data("patients_category_a", $_GET);
if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
else
    {
        echo "<P>$what_happened</P>";
    }
}

if ($what_to_store['CategoryB'])
{
 $data_array2 = prepare_data("patients_category_b", $_GET); 
 for ($i=0; $i < $_GET['symptoms']; $i++)
 {
  if ($data_array2['ClinicSymptom'.$i] != "")
  {
	$sql="";
	$sql .= " INSERT INTO `patients_category_b` ( `PatientCode` , `MELCode` , `ClinicSymptom`, `ClinicSymptomDate`, `ExtraSymptoms` )";
	$sql .= " VALUES ( '". $data_array2['PatientCode'] ."' , '". $data_array2['MELCode'] ."' , '". $data_array2['ClinicSymptom'.$i] ."', '". $data_array2['ClinicSymptomDate'.$i] ."', '". $data_array2['ExtraSymptoms']."' );";
	echo "<BR>".$sql."<BR><BR>";
	
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
 }
 if ($_GET['ExtraSymptoms'] == 1)
 {
  $data_array2 = prepare_data("patients_category_b_reappearances", $_GET);
  for ($i=0; $i < $_GET['num_syndrom_reappear']; $i++)
  {
	$sql="";
	$sql .= " INSERT INTO `patients_category_b_reappearances` ( `PatientCode` , `MELCode` , `ReccurenceSymptom`, `ReccurenceDate` )";
	$sql .= " VALUES ( '". $data_array2['PatientCode'] ."' , '". $data_array2['MELCode'] ."' , '". $data_array2['ReccurenceSymptom'.$i] ."', '". $data_array2['ReccurenceSymptom'.$i] ."' );";
	echo "<BR>".$sql."<BR><BR>";
	
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
}
}

if ($what_to_store['HasAIDS'])
{	
 	$what_happened = insert_data("patient_has_aids", $_GET);
 	if ($what_happened == 1)
    {
        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    }
	else
    {
        echo "<P>$what_happened</P>";
    }
 if ($_GET['HasReappearance'] == 1)
 {
  $data_array2 = prepare_data("patient_has_aids_reapperances", $_GET);
  for ($i=0; $i < $_GET['num_nosoi_reappear']; $i++)
  {
	$sql="";
	$sql .= " INSERT INTO `patient_has_aids_reapperances` ( `PatientCode` , `MELCode` , `NososSymptID`, `NososSymptDiagnosis`, `NososSymptDate` )";
	$sql .= " VALUES ( '". $data_array2['PatientCode'] ."' , '". $data_array2['MELCode'] ."' , '". $data_array2['NososSymptID'.$i] ."', '". $data_array2['NososSymptDiagnosis'.$i] ."', '". $data_array2['NososSymptDate'.$i] ."' );";
	echo "<BR>".$sql."<BR><BR>";
	
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
}
}
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Δημογραφικών Στοιχείων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style></HEAD>

<BODY bgcolor="FFCCFF">

<?php
//form_data2table($_GET);

mysql_close($dbconnection);
?>

</BODY></HTML>
