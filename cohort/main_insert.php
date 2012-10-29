<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

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

$sql = "INSERT INTO `clinic_visits` ";
$sql .= "VALUES ( '" . $_GET['PatientCode'] . "' , '" . $_GET['Clinic'] . "', ";
if ($_GET['OtherClinic'] !='')
{
	$sql .= " '" . $_GET['OtherClinic'] . "',";
}
else
{
	$sql .= " '',";
}
$sql .= " '" . join_date($_GET, 'DateOfVisit') . "',";
if (is_numeric($_GET['weight']))
{
	$sql .= " '" . $_GET['weight'] . "', ";
}
else 
{
	$sql .= " NULL, ";
}
if (is_numeric($_GET['height']))
{
	$sql .= "'" . $_GET['height'] . "', ";
}
else 
{
	$sql .= " NULL, ";
}
if (isset($_GET['habit'])) {
	if ($_GET['habit'] =='1')
	{
		$sql .= " '" . $_GET['Smoking'] . "',";
	}
	else
	{
		$sql .= " NULL, ";
	}
}
else
{
	$sql .= " '" . $_GET['Smoking'] . "',";
}
$sql .= " '" . $_GET['Alcohol'] . "', ";
$sql .= " '" . $_GET['DrugUser'] . "',  '" . $_GET['heroin'] . "',  '" . $_GET['hash'] . "',  '" . $_GET['cocain'] . "', ";
$sql .= " '" . $_GET['other_drug_name'] . "',  '" . $_GET['otherdrug'] . "', ";
if (($lipoatrofia != 0) && (join_date($_GET, 'DateOfVisit') > $lipoatrofia))
{
	$sql .="'" . $_GET['Lipoatrofia'] . "', ";
}
else
{
	$sql .= "NULL, ";
}
if (($enapothesi != 0) && (join_date($_GET, 'DateOfVisit') > $enapothesi))
{
	$sql .="'" . $_GET['Enapothesi'] . "', ";
}
else
{
	$sql .= "NULL, ";
}
$sql .= " '" . $_GET['sad'] . "',  '" . $_GET['dap'] . "');";
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
//	echo mysql_error();
}

mysql_close($dbconnection);
perform_post_insert_actions("clinic_visits", "main.php?code=".$_GET['PatientCode'], "");
?>
