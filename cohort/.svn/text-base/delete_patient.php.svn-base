<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
?>

<HTML><HEAD>
<TITLE>Διαγραφή Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<P>&nbsp;</P><P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{

}
else
{
	check_patient($_GET['code']);
	
	for ($i=0; $i<count($cohort_data_tables); $i++)
	{
		execute_query("DELETE FROM `".$cohort_data_tables[$i]."` WHERE PatientCode=".$_GET['code']);
	}
/*	
	$patient_query = "DELETE FROM patients WHERE PatientCode=".$_GET['code'];
	$what_happened = execute_query($patient_query);
	delete_from_table($_GET['code'], "antiretro_treatments");
	delete_from_table($_GET['code'], "antiretro_treatments_compliance");
	delete_from_table($_GET['code'], "atomiko_anamnistiko");
	delete_from_table($_GET['code'], "atomiko_anamnistiko_aee");
	delete_from_table($_GET['code'], "atomiko_anamnistiko_emfragma");
	delete_from_table($_GET['code'], "coinfections");
	delete_from_table($_GET['code'], "clinic_visits");
	delete_from_table($_GET['code'], "demographic_data");
	delete_from_table($_GET['code'], "exams_aimatologikes");
	delete_from_table($_GET['code'], "exams_anosologikes");
	delete_from_table($_GET['code'], "exams_bioximikes");
	delete_from_table($_GET['code'], "exams_iologikes");
	delete_from_table($_GET['code'], "exams_orologikes");
	delete_from_table($_GET['code'], "exams_ourwn");
	delete_from_table($_GET['code'], "exams_other");
		delete_from_table($_GET['code'], "hbv_clinical_status");
		delete_from_table($_GET['code'], "hbv_iologikes");
		delete_from_table($_GET['code'], "hbv_istology");
		delete_from_table($_GET['code'], "hbv_other_treatments_before_art");
		delete_from_table($_GET['code'], "hbv_other_treatments_after_art");
		delete_from_table($_GET['code'], "hcv_clinical_status");
		delete_from_table($_GET['code'], "hcv_iologikes");
		delete_from_table($_GET['code'], "hcv_istology");
		delete_from_table($_GET['code'], "hcv_other_treatments");			
	delete_from_table($_GET['code'], "hiv_resistance");
	delete_from_table($_GET['code'], "hiv_subtype");
	delete_from_table($_GET['code'], "hospitalization");
	delete_from_table($_GET['code'], "iris");
	delete_from_table($_GET['code'], "last_state");
	delete_from_table($_GET['code'], "other_treatments");
	delete_from_table($_GET['code'], "patient_neoplasma");
	delete_from_table($_GET['code'], "patient_other_clinical_state");
	delete_from_table($_GET['code'], "patients_category_a");
	delete_from_table($_GET['code'], "patients_category_b");
	delete_from_table($_GET['code'], "patients_category_c");
	delete_from_table($_GET['code'], "prophylactic_therapies");
*/
if ($what_happened == 1)
    {
        echo "<script>alert('Ο ασθενής έχει διαγραφεί από την βάση δεδομένων!')</script>\n";
        //echo $data_array['PatientCode'];
//        echo "<p><a href='newpatient.php'>Κάντε click εδώ για να εισάγετε νέο ασθενή</a></p>";
    }
//else 
//	{
//		echo "<script>alert('Τα δεδομένα ΔΕΝ τροποποιήθηκαν!')</script>\n";
//		handle_query_results("patients", mysql_error(), $data_array);
//	}
}

?>
<form name=patient_select_form action=delete_patient.php method="GET" onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε τον ασθενή;');">
<p>Δώστε τον κωδικό του ασθενή τον οποίο θα διαγράψετε: 
<input name=code size=10 maxlength="10">
<input type="submit" style="border: 1px outset;" value="Επιλογή">
</p>
</form>
<hr>
<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
 Εύρεση Κωδικού Ασθενή</h2>

<iframe src=find_patient.php frameborder="0" width=1000 height=485 />
<?
mysql_close($dbconnection); 
?>