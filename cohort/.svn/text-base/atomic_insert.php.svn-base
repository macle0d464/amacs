<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Στοιχείων Ατομικού Αναμνηστικού Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css"></HEAD>
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
//validate_data("atomiko_anamnistiko", $_GET);
check_patient($_GET['code']);
$data_array2 = prepare_data("atomiko_anamnistiko", $_GET);

if ($_GET['NeoplasmaID0'] == "Z99")
{
	$data_array2['NeoplasmaID0'] = $_GET['NeoplasmaICD0'];
	$_GET['NeoplasmaID0'] = $_GET['NeoplasmaICD0'];
}

$names = array_keys($data_array2);

$has_entry_query = "SELECT * FROM atomiko_anamnistiko WHERE PatientCode=".$_GET['code'];
$result = execute_query($has_entry_query);
$has_entry = mysql_num_rows($result);
mysql_free_result($result);

if ($has_entry)
{
	$atomic_sql = "UPDATE `atomiko_anamnistiko` SET ";
    for ($i=1; $i<count($data_array2)-1; $i++)
    {
        $atomic_sql .= "`" . $names[$i] . "`='".$data_array2[$names[$i]]."' , ";
    }
	$atomic_sql .= "`" . $names[$i] . "`='".$data_array2[$names[$i]]."' ";
	$atomic_sql .= "WHERE PatientCode='".$_GET['code']."'";
//	echo $atomic_sql;
	$what_happened = execute_query($atomic_sql);
/*	if ($what_happened == 1)
    	{
        	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    	}
	else
    	{
	        die("<P>$what_happened</P>");
    	}	*/
//echo mysql_error();
//die;
}
else 
{
	$atomic_sql = "INSERT INTO `atomiko_anamnistiko` ( ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $atomic_sql .= "`" . $names[$i] . "` , ";
    }
    $atomic_sql .= "`" . $names[$i] . "` ) VALUES ( ";
    for ($i=0; $i<count($data_array2)-1; $i++)
    {
        $atomic_sql .= "'" . $data_array2[$names[$i]] . "' , ";
    }
    $atomic_sql .= "'" . $data_array2[$names[$i]] . "' );";

//	echo ($atomic_sql);    
	$what_happened = execute_query($atomic_sql);
/*	if ($what_happened == 1)
    	{
        	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    	}
	else
    	{
	        die("<P>$what_happened</P>");
    	} */
}    

if ($_GET['Emfragma'] == '1')
{
	$emfragma_sql  = "INSERT INTO `atomiko_anamnistiko_emfragma` (`PatientCode`, `EmfragmaDate`) ";
	$date = join_date($_GET, 'EmfragmaDate');
	$emfragma_sql .= "VALUES ('".$_GET['code']."', '".$date."')";
//	echo $emfragma_sql;
	$what_happened = execute_query($emfragma_sql);
/*	if ($what_happened == 1)
    	{
        	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    	}   	*/
}

if (isset($_GET['emfragmata']))
{
	for ($i=0; $i < $_GET['emfragmata']; $i++)
	{
		if (isset($_GET['del_emfragma_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `atomiko_anamnistiko_emfragma` ";
			$sql .= " WHERE PatientCode='". $_GET['code'] ."' AND EmfragmaDate='". $_GET['del_emfragma_date_'.$i]."'";
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
/*			if ($what_happened == 1)
    		{
    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
    			echo "<P>$what_happened</P>";
			} */
 		}
 	}
}		

if ($_GET['AEE'] == '1')
{
	$aee_sql  = "INSERT INTO `atomiko_anamnistiko_aee` (`PatientCode`, `AEEDate`) ";
	$date = join_date($_GET, 'AEEDate');
	$aee_sql .= "VALUES ('".$_GET['code']."', '".$date."')";
//	echo $emfragma_sql;
	$what_happened = execute_query($aee_sql);
/*	if ($what_happened == 1)
    	{
        	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    	}   	*/
}

if (isset($_GET['aee_num']))
{
	for ($i=0; $i < $_GET['aee_num']; $i++)
	{
		if (isset($_GET['del_aee_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `atomiko_anamnistiko_aee` ";
			$sql .= " WHERE PatientCode='". $_GET['code'] ."' AND AEEDate='". $_GET['del_aee_date_'.$i]."'";
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
/*			if ($what_happened == 1)
    		{
    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
    			echo "<P>$what_happened</P>";
			} */
 		}
 	}
}		

if ($_GET['HasNeoplasma'] == 1)
{    
	for ($i = 0; $i < $_GET['num_neoplasmata']; $i++)
	{  
	  if ($_GET['NeoplasmaID'.$i] != "")
	  {	
		$neoplasma_sql = "";
		$neoplasma_sql .= " INSERT INTO `patient_neoplasma` ( `PatientCode` , `NeoplasmaID`, `NeoplasmaDate` )";
		$date = join_date($_GET, 'NeoplasmaDate'.$i);
		$neoplasma_sql .= " VALUES ( '". $_GET['PatientCode'] ."' , '". $_GET['NeoplasmaID'.$i] ."', '". $date ."' );";
//		echo ($neoplasma_sql);
		$what_happened = execute_query($neoplasma_sql);
/*		if ($what_happened == 1)
    	{
        	echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    	} */
	  }
	}
}

if (isset($_GET['neoplasma']))
{
	for ($i=0; $i < $_GET['neoplasma']; $i++)
	{
		if (isset($_GET['del_neoplasma_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `patient_neoplasma` ";
			$sql .= " WHERE PatientCode='". $_GET['code'] ."' AND NeoplasmaID='". $_GET['del_neoplasma_id_'.$i]."'";
			$sql .= " AND NeoplasmaDate='". $_GET['del_neoplasma_date_'.$i]."'";
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
/*			if ($what_happened == 1)
    		{
    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
    			echo "<P>$what_happened</P>";
			}   */
 		}
 	}
}

if ($_GET['HasOtherClinicalState'] == 1)
{  
	for ($i = 0; $i < $_GET['num_states']; $i++)
	{
	  if ($_GET['ClinicalStatusID'.$i] != "")
	  {  
		$clinic_state_sql = "";
		$clinic_state_sql .= " INSERT INTO `patient_other_clinical_state` ( `PatientCode` , `ClinicalStatusID`, `ClinicalStatusDate` )";
		$date = join_date($_GET, 'ClinicalStatusDate'.$i);
		$clinic_state_sql .= " VALUES ( '". $_GET['PatientCode'] ."' , '". $_GET['ClinicalStatusID'.$i] ."', '". $date ."' );";
//		echo $clinic_state_sql;
		$what_happened = execute_query($clinic_state_sql);
/*		if ($what_happened == 1)
    	{
	        echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
    	} */
	  }
	}
}

if (isset($_GET['state']))
{
	for ($i=0; $i < $_GET['state']; $i++)
	{
		if (isset($_GET['del_state_sw_'.$i]))
		{
			$sql="";
			$sql .= " DELETE FROM `patient_other_clinical_state` ";
			$sql .= " WHERE PatientCode='". $_GET['code'] ."' AND ClinicalStatusID='". $_GET['del_state_id_'.$i]."'";
			$sql .= " AND ClinicalStatusDate='". $_GET['del_state_date_'.$i]."'";
//			echo "<BR>".$sql."<BR><BR>";
			$what_happened = execute_query($sql);
/*			if ($what_happened == 1)
    		{
    			echo "<P>Τα δεδομένα διαγράφτηκαν με επιτυχία!</P>";
			}
			else
    		{
    			echo "<P>$what_happened</P>";
			} */
 		}
 	}
}

mysql_close($dbconnection);
perform_post_insert_actions("atomiko_anamnistiko", "atomic.php?code=".$_GET['code'], "");
?>
<!--
<p><a href='atomic.php?code=<? echo $_GET['code']; ?>'>Κάντε click εδώ για επιστροφή</a></p>
<p><a href='anosologikes.php?code=<? echo $_GET['code']; ?>'>Κάντε click εδώ για να καταχωρήσετε ανοσολογικές εξετάσεις</a></p>


</BODY></HTML>
-->