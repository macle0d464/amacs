<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
/*
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Κλινικής Κατάστασης Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
*/
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

//form_data2table($_GET);
/*
if (isset($_GET['Status']))
{
	$clinical_status_sql = "INSERT INTO `aids_clinical_status` (`PatientCode` , `Status`) VALUES ";
	$clinical_status_sql .= "( '" . $_GET['code'] . "', '" . $_GET['Status'] . "')";
	echo $clinical_status_sql;
	$what_happened = execute_query($clinical_status_sql);
	if ($what_happened == 1)
    	{
?>
       	<P>Η κλινική κατάσταση του ασθενή <? $_GET['code'] ?> καταχωρήθηκε με επιτυχία!</P>
<?
		header("Location: http://$server/$install_dir/clinical_status.php?code=".$_GET['code']."&showcat=".$_GET['Status'][0]);
    	}
	else
    	{
        	echo "<P>$what_happened</P>";
	    }	
}
*/

// -- Category A Routines

	if (isset($_GET['Asymptotic']) || isset($_GET['Lemfadenopatheia']) || isset($_GET['Protoloimoksi']))
	{
		if ($_GET['Asymptotic'] == "")
		{$asymptotic = 0;}
		else {$asymptotic = 1;}
		if ($_GET['Lemfadenopatheia'] == "")
		{$lemf = 0;}
		else {$lemf = 1;}
		if ($_GET['Protoloimoksi'] == "")
		{$proto = 0;}
		else {$proto = 1;}
		if ($_GET['hasentry'] == "1")
		{		
			$sql = "UPDATE `patients_category_a` SET `Asymptotic`='$asymptotic', `Lemfadenopatheia`='$lemf', `Protoloimoksi`='$proto' ";
			$sql .= " WHERE `PatientCode` ='".$_GET['code']."'";
		}
		else
		{
			$sql = "INSERT INTO `patients_category_a` (`PatientCode` , `Asymptotic`, `Lemfadenopatheia`, `Protoloimoksi`) VALUES ";
			$sql .= "( '" . $_GET['code'] . "', '" . $asymptotic . "', '" . $lemf . "', '" . $proto . "')";
		}
//		echo  $sql;
		$what_happened = execute_query($sql);
/*		if ($what_happened == 1)
    	{
?>
       		<P>Η κλινική κατάσταση του ασθενή <? $_GET['code'] ?> καταχωρήθηκε με επιτυχία!</P>
<?
  	  	}
		else
    	{
        	echo "<P>".mysql_error()."$what_happened</P>";
	    }	
*/
	}
	else
	{
		$sql = "DELETE FROM `patients_category_a` WHERE PatientCode=".$_GET['code'];
		$what_happened = execute_query($sql);
	}

// -- Category B Routines	
	if (isset($_GET['category_b']) && $_GET['category_b'] != "")
	{
		$sql = "";
		$sql .= " INSERT INTO `patients_category_b` ( `PatientCode` , `ClinicSymptom`, `ClinicSymptomDate` )";
		$symptom = $_GET['category_b'];
		$date = join_date($_GET, "BDate");
		$sql .= " VALUES ( '". $_GET['code'] ."' , '". $symptom ."', '". $date ."' );";
//		echo "<BR>".$sql."<BR><BR>";
		$what_happened = execute_query($sql);
/*		if ($what_happened == 1)
    	{
    		echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
		}
		else
    	{
    		echo "<P>".mysql_error()."</P>";
		} */
  	}
 		if (isset($_GET['sympt']))
 		{
 			for ($i=0; $i < $_GET['sympt']; $i++)
 			{
 				if (isset($_GET['del_sympt_sw_'.$i]))
 				{
 					$sql="";
					$sql .= " DELETE FROM `patients_category_b` ";
					$sql .= " WHERE PatientCode=". $_GET['code'] ." AND ClinicSymptom=". $_GET['del_sympt_id_'.$i];
					$sql .= " AND ClinicSymptomDate='". $_GET['del_sympt_date_'.$i] ."';";
//					echo "<BR>".$sql."<BR><BR>";
					$what_happened = execute_query($sql);
/*					if ($what_happened == 1)
    				{
        				echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
	    			}
					else
    				{
        				echo "<P>".mysql_error()."$what_happened</P>";
	    			}
*/	    			
 				}
 			}
 		}		
// -- Category C Routines
	if (isset($_GET['category_c']) && $_GET['category_c'] != "")
	{
		$sql = "";
		$sql .= " INSERT INTO `patients_category_c` ( `PatientCode` , `NososSyndrom`, `Diagnosis`, `NososSyndromDate` )";
		$symptom = $_GET['category_c'];
		$diagnosis = $_GET['Diagnosis'];
	 if ($diagnosis != "")
	 {
		
		$date = join_date($_GET, "CDate");
		$sql .= " VALUES ( '". $_GET['code'] ."' , '". $symptom ."', '". $diagnosis ."', '". $date ."' );";
//		echo "<BR>".$sql."<BR><BR>";
		$what_happened = execute_query($sql);
/*		if ($what_happened == 1)
    	{
    		echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
		}
		else
    	{
    		echo "<P>".mysql_error()."</P>";
		} */
	 }
  	}
 		if (isset($_GET['syndr']))
 		{
 			for ($i=0; $i < $_GET['syndr']; $i++)
 			{
 				if (isset($_GET['del_syndr_sw_'.$i]))
 				{
 					$sql="";
					$sql .= " DELETE FROM `patients_category_c` ";
					$sql .= " WHERE PatientCode=". $_GET['code'] ." AND NososSyndrom=". $_GET['del_syndr_id_'.$i];
					$sql .= " AND NososSyndromDate='". $_GET['del_syndr_date_'.$i] ."';";
					echo "<BR>".$sql."<BR><BR>";
					$what_happened = execute_query($sql);
/*					if ($what_happened == 1)
    				{
        				echo "<P>Τα δεδομένα καταχωρήθηκαν με επιτυχία!</P>";
	    			}
					else
    				{
        				echo "<P>".mysql_error()."$what_happened</P>";
	    			}
*/	    			
 				}
 			}
 		}		
	


mysql_close($dbconnection);
perform_post_insert_actions("aids_clinical_status", "clinical_status.php?code=".$_GET['code'], "");
?>
<!--
<p><a href='clinical_status.php?code=<? echo $_GET['code']; ?>'>Κάντε click εδώ για επιστροφή</a></p>
<p><a href='atomic.php?code=<? echo $_GET['code']; ?>'>Κάντε click εδώ για να καταχωρήσετε το ατομικό αναμνηστικό</a></p>

</BODY></HTML> -->
