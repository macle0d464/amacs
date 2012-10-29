<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>
<!--
<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντιρετροϊκών Θεραπειών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
-->
<?php
$dbconnection = cohortdb_connect($cohort_db_server, "root", "97103");
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

//if ($_GET['code'] == "" || !is_numeric($_GET['code']))
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
//check_patient($_GET['code']);
//form_data2table($_GET);



// Parse data from form

$medicine_query = "SELECT ID,Name,Category FROM medicines";
$results = execute_query($medicine_query);		
$num = mysql_num_rows($results);
$medicines = array();
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$medicine_array[$i]['name'] = $row['Name'];
	$medicine_array[$i]['id'] = $row['ID'];
	$medicine_array[$i]['category'] = $row['Category'];
	$medicines[$row['Name']] = $row['ID'];
}

$patients = array();
$result = execute_query("SELECT PatientCode FROM `patients`");
for ($i=0; $i<mysql_num_rows($result); $i++)
{
	$patients[$i] = mysql_fetch_array($result);
	$patients[$i] = $patients[$i][0];
}

echo "<pre>";

$sql = "CREATE TABLE `cohort`.`antiretro_treatments_old` (
`PatientCode` mediumint( 8 ) unsigned NOT NULL default '0',
`Medicine` smallint( 6 ) NOT NULL default '1',
`StartDate` date NOT NULL default '0000-00-00',
`EndDate` date NOT NULL default '0000-00-00',
UNIQUE KEY `treatment` ( `PatientCode` , `Medicine` , `StartDate` , `EndDate` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8;";
execute_query($sql);

$sql = "INSERT INTO `cohort`.`antiretro_treatments_old`
SELECT *
FROM `cohort`.`antiretro_treatments` ;";
execute_query($sql);

$sql = "TRUNCATE TABLE `antiretro_treatments` ;";
execute_query($sql);


foreach($patients as $patient_code) 
{

$query = "SELECT * FROM antiretro_treatments_compliance WHERE PatientCode=".$patient_code." ORDER BY StartDate ASC;";
$result = execute_query($query);
$num_rows = mysql_num_rows($result);
        for ($j=0; $j<$num_rows; $j++)
        {
        	$row = mysql_fetch_assoc($result);
			$meds = array();
			$meds = explode(" / ", $row['Schema']);
			print_r($meds);
			for ($m=0; $m<count($meds); $m++)
			{
				$sql = "INSERT INTO antiretro_treatments VALUES('".$patient_code."', '".$medicines[$meds[$m]]."', '".$row['StartDate']."', '".$row['EndDate']."');\n";
				echo $sql;
				execute_query($sql);
			}
        }
		
}

$sql = "DROP TABLE antiretro_treatments_old ;";
execute_query($sql);
echo mysql_error();

mysql_close($dbconnection);
?>
