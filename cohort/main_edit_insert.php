<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/* 
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Δημογραφικών Στοιχείων Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
*/
//form_data2table($_GET);
$dbconnection = mysql_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}  

$result = execute_query("SELECT Lipoatrofia, Enapothesi, LipoatrofiaDate, EnapothesiDate FROM atomiko_anamnistiko WHERE PatientCode=".$_GET['PatientCode']);
echo mysql_error();
if (mysql_num_rows($result) == 0)
{
	$lipoatrofia = 0;
	$enapothesi = 0;
}
else 
{
	$row = mysql_fetch_array($result);
	if  ($row[0] == 1)
	{
		$lipoatrofia = $row[2];
	}
	else 
	{
		$lipoatrofia = 0;
	}
	if  ($row[1] == 1)
	{	
		$enapothesi = $row[3];
	}
	else
	{
		$enapothesi = 0;
	}
}
mysql_free_result($result);

$sql = "UPDATE `clinic_visits` ";
$sql .= " SET Clinic='" . $_GET['Clinic'] . "', DateOfVisit='".join_date($_GET, 'DateOfVisit')."', ";
if ($_GET['OtherClinic'] !='')
{
	$sql .= " OtherClinic='" . $_GET['OtherClinic'] . "', ";
}
else
{
	$sql .= " ";
}
if (is_numeric($_GET['weight']))
{
	$sql .= " Weight='" . $_GET['weight'] . "', ";
}
else 
{
	$sql .= " Weight=NULL, ";
}
if (is_numeric($_GET['height']))
{
	$sql .= " Height='" . $_GET['height'] . "', ";
}
else 
{
	$sql .= " Height=NULL, ";
}
if ($_GET['habit'] =='1')
{
	$sql .= " Smoking='" . $_GET['Smoking'] . "',";
}
else
{
	$sql .= " Smoking=NULL, ";
}
$sql .= " Alcohol='" . $_GET['Alcohol'] . "', ";
$sql .= " DrugUser='" . $_GET['DrugUser'] . "', ";
if ($_GET['DrugUser'] == '1')
{
	$sql .= " Heroin='" . $_GET['heroin'] . "',  Hash='" . $_GET['hash'] . "',  Cocaine='" . $_GET['cocain'] . "', ";
	$sql .= " OtherDrugName='" . $_GET['other_drug_name'] . "',  OtherDrugValue='" . $_GET['otherdrug'] . "', ";
}
else
{
	$sql .= " Heroin='-1',  Hash='-1',  Cocaine='-1', ";
	$sql .= " OtherDrugName='',  OtherDrugValue='-1', ";
}
if (($lipoatrofia != 0) && (join_date($_GET, 'DateOfVisit') > $lipoatrofia))
{
	$sql .=" Lipoatrofia='" . $_GET['Lipoatrofia'] . "', ";
}
else
{
	$sql .= " Lipoatrofia=NULL, ";
}
if (($enapothesi != 0) && (join_date($_GET, 'DateOfVisit') > $enapothesi))
{
	$sql .=" Enapothesi='" . $_GET['Enapothesi'] . "', ";
}
else
{
	$sql .= " Enapothesi=NULL, ";
}
$sql .= " PressureSystolic='" . $_GET['sad'] . "',  PressureDiastolic='" . $_GET['dap'] . "' ";
$sql .= " WHERE PatientCode='".$_GET['PatientCode']."' AND Clinic='".$_GET['clinicid']."' AND DateofVisit='".$_GET['visitdate']."';";
//    echo $sql;
    
//echo "<BR><BR>";
  
$what_happened = execute_query($sql);
    
if ($what_happened == 1)
    {
//        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
//       echo "<P><a href='clinical_status.php?code=".$data_array2['PatientCode']."'>Κάντε click εδώ για να εισάγετε την κλινική κατάσταση του ασθενή</a></P>";
    }
else
{
	echo mysql_error();
}

mysql_close($dbconnection);
perform_post_insert_actions("clinic_visits", "main.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
