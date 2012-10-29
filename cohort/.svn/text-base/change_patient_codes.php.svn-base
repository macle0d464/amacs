<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, "root", "97103");
$db_selected = mysql_select_db("cohort", $dbconnection);
if (!$db_selected) {
	die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

// Need to do this at the beginning (ALL TABLES MUST STORE UNSIGNED PatientCodes)

for ($i=0; $i<count($cohort_data_tables); $i++)
{
	execute_query("ALTER TABLE `".$cohort_data_tables[$i]."` CHANGE `PatientCode` `PatientCode` MEDIUMINT( 9 ) UNSIGNED NOT NULL DEFAULT '0' ;");
}


$result = execute_query("SELECT `Value` FROM setup WHERE Setting='clinic';");
$row = mysql_fetch_array($result);
$clinic = $row[0];
if (($clinic == '') || ($clinic == ' '))
{
	$file = fopen("no_clinic.txt", "w");
	fwrite($file, "NO_CLINIC");
	fclose($file);
}

execute_query("ALTER TABLE `patients` ADD `CodeType` VARCHAR( 255 ) NOT NULL;");

// Identify KEEL Codes

execute_query("UPDATE `patients` SET CodeType='FROMKEEL' WHERE MELCode='-1';");

// 1. UPDATE CASCADE (GH) Codes

if ($clinic == 5)
{
	execute_query("UPDATE `patients` SET CodeType='CASCADE (GH)' WHERE PatientCode LIKE '555%' AND SUBSTRING(PatientCode, 4, CHAR_LENGTH(PatientCode))=MELCode;");
}

// 2. Update HIVLOAD PatientCodes

execute_query("UPDATE `patients` SET CodeType='HIVLOAD' WHERE PatientCode LIKE '999%';");

// Backup Patients Table
execute_query("ALTER TABLE `patients` DROP PRIMARY KEY ; ");
execute_query("ALTER TABLE `patients` ADD `AA` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ;");

execute_query("CREATE TABLE `cohort`.`patients_oldcodes` (
`AA` mediumint( 8 ) unsigned NOT NULL AUTO_INCREMENT ,
`PatientCode` mediumint( 8 ) unsigned NOT NULL default '0',
`MELCode` mediumint( 9 ) NOT NULL default '-1',
`Name` varchar( 50 ) NOT NULL default '',
`Surname` varchar( 100 ) NOT NULL default '',
`BirthDate` date NOT NULL default '0000-00-00',
`CodeType` varchar( 255 ) NOT NULL default '',
PRIMARY KEY ( `AA` ) ,
UNIQUE KEY `Name` ( `Name` , `Surname` , `BirthDate` )
) DEFAULT CHARSET = utf8;");

execute_query("INSERT INTO `cohort`.`patients_oldcodes`
SELECT *
FROM `cohort`.`patients` ;");

// 3. Update PatientCodes of patients that have neither KEEL code nor MELCode

for ($i=0; $i<count($cohort_data_tables); $i++)
{
	if ($cohort_data_tables[$i] != 'patients')
	{
		execute_query("UPDATE `".$cohort_data_tables[$i]."` SET PatientCode=CONCAT('12', SUBSTRING(PatientCode, 3, 2), '0', SUBSTRING(PatientCode, 5, 3)) WHERE PatientCode LIKE '11_____'");
	}
}
execute_query("UPDATE `patients` SET CodeType='NOMELNOKEELCODE', PatientCode=CONCAT('12', SUBSTRING(PatientCode, 3, 2), '0', SUBSTRING(PatientCode, 5, 3)) WHERE PatientCode LIKE '11_____'");

// 4. Update PatientCodes of patients that don't have KEEL code (i.e. PatientCode=MELCode)

for ($i=0; $i<count($cohort_data_tables); $i++)
{
	if ($clinic == "9")
	{
		if ($cohort_data_tables[$i] == 'patients')
		{
			$sql = "UPDATE `".$cohort_data_tables[$i]."` SET CodeType='NOKEELCODE', PatientCode = PatientCode - 99000 +  9*100000 WHERE PatientCode LIKE '99___'";				
			execute_query($sql);
			$sql = "UPDATE `".$cohort_data_tables[$i]."` SET CodeType='NOKEELCODE', PatientCode = PatientCode - 9900 +  9*100000 WHERE PatientCode LIKE '99__'";				
			execute_query($sql);
		}
		else
		{
			$sql = "UPDATE `".$cohort_data_tables[$i]."` SET PatientCode = PatientCode - 99000 +  9*100000 WHERE PatientCode LIKE '99___'";				
			execute_query($sql);
			$sql = "UPDATE `".$cohort_data_tables[$i]."` SET PatientCode = PatientCode - 9900 +  9*100000 WHERE PatientCode LIKE '99__'";				
			execute_query($sql);		
		}
	}
	else
	{
		if ($cohort_data_tables[$i] == 'patients')
		{
			$sql = "UPDATE `".$cohort_data_tables[$i]."` SET CodeType='NOKEELCODE', PatientCode = PatientCode + ".$clinic."*100000 WHERE PatientCode IN (SELECT PatientCode FROM patients_oldcodes WHERE PatientCode=MELCode)";		
			execute_query($sql);
		}
		else
		{
			$sql = "UPDATE `".$cohort_data_tables[$i]."` SET PatientCode = PatientCode + ".$clinic."*100000 WHERE PatientCode IN (SELECT PatientCode FROM patients_oldcodes WHERE PatientCode=MELCode)";		
			execute_query($sql);
		}	
	}
}

// 5. The rest are also KEEL codes

execute_query("UPDATE `patients` SET CodeType='FROMKEEL' WHERE CodeType=' ';");

$result = execute_query("SELECT b.PatientCode AS OLD_PatientCode, a.PatientCode AS NEW_PatientCode, a.MELCode, a.Name, a.Surname, a.BirthDate, a.CodeType FROM patients a, patients_oldcodes b WHERE a.AA=b.AA AND a.PatientCode!=b.PatientCode ;");
query2xls($result, "C:\changed_patientcodes.xls");

execute_query("ALTER TABLE `patients` DROP `AA` ;");
execute_query("ALTER TABLE `patients` ADD PRIMARY KEY ( `PatientCode` ) ;");

// Other fixes (LAST MINUTE)

execute_query("UPDATE clinic_visits SET DrugUser=NULL");

mysql_close($dbconnection); 
?>