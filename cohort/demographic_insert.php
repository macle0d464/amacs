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

validate_data('demographic_data', $_GET);
$data_array2 = prepare_data('demographic_data', $_GET);

if ($_GET['country'] > 0)
{
	$result = execute_query("SELECT Category FROM countries_list WHERE ID='".$_GET['country']."'");
	$row = mysql_fetch_array($result);
	$data_array2['Origin'] = $row[0];
}

if ($_GET['has_entry'] == 0)
{
    $query = "SELECT UPPER(LEFT(Name, ".$preferences['num_initials'].")), UPPER(LEFT(Surname, ".$preferences['num_initials'].")), BirthDate FROM patients WHERE PatientCode = ".$data_array2['PatientCode'];
	$result = execute_query($query);
	$row = mysql_fetch_array($result);       
    $data_array2['Name'] = $row[0];
    $data_array2['Surname'] = $row[1];
    $data_array2['BirthDate'] = $row[2];
    mysql_free_result($result);
	
    $names = array_keys($data_array2);
    
    $sql = "INSERT INTO `demographic_data` ( ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $sql .= "`" . $names[$i] . "` , ";
    }
    $sql .= "`" . $names[$i] . "` ) VALUES ( ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $sql .= "'" . $data_array2[$names[$i]] . "' , ";
    }
    $sql .= "'" . $data_array2[$names[$i]] . "' );";

//    echo $sql;
//echo "<BR><BR>";
  
$what_happened = execute_query($sql);
    
if ($what_happened == 1)
    {
//        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
//        echo "<P><a href='clinical_status.php?code=".$data_array2['PatientCode']."'>Κάντε click εδώ για να εισάγετε την κλινική κατάσταση του ασθενή</a></P>";
    }
else
{
	echo mysql_error();
}
}
else
{
    $names = array_keys($data_array2);
    
    $sql = "UPDATE `demographic_data` SET ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $sql .= "`" . $names[$i] . "` = '".$data_array2[$names[$i]]."', ";
    }
    $sql .= "`" . $names[$i] . "` = '".$data_array2[$names[$i]]."' ";
    if ($data_array2['PossibleSourceInfection'] != '6')
    {
    	$sql .= ", `TransfusionPlace`=NULL, `TransfusionDate`=NULL ";
    }
    if ($data_array2['PossibleSourceInfection'] != '7')
    {
    	$sql .= ", `Country`=NULL, `Sailor`=NULL, `PartnerCountry`=NULL, `PartnerDrugs`=NULL ";
    	$sql .= ", `PartnerBi`=NULL, `PartnerTransfusion`=NULL, `PartnerTransfusionAfter78`=NULL ";
    	$sql .= ", `PartnerHIVPlus`=NULL, `Undefined`=NULL ";    	
    }
    if ($data_array2['KnownDateOrometatropi'] == '0')
    {
    	$sql .= ", `LastNegativeSample`=NULL, `SeroconversionDate`=NULL ";    	
    }
    $sql .= "WHERE `PatientCode`='".$data_array2['PatientCode']."' LIMIT 1";

//    echo $sql;
//	  echo "<BR><BR>";
	
$what_happened = execute_query($sql);
    
if ($what_happened == 1)
    {
//        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
//        echo "<P><a href='clinical_status.php?code=".$data_array2['PatientCode']."'>Κάντε click εδώ για να εισάγετε την κλινική κατάσταση του ασθενή</a></P>";
    }
else
{
	echo mysql_error();
}
}
mysql_close($dbconnection);
perform_post_insert_actions("demographic_data", "demographic.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
