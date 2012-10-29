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

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
//form_data2table($_GET);
check_patient($_GET['PatientCode']);
$has_entry = mysql_num_rows(execute_query("SELECT * FROM `coinfections` WHERE PatientCode=".$_GET['PatientCode']));
if (isset($_GET['HBV']))
{
	if ($_GET['HBV'] == 1)
	{
		if ($has_entry)
		{
			$sql="";
			$sql .= " UPDATE `coinfections` ";
			$sql .= "SET HBV='". $_GET['HBV']."', ";
			$sql .= "HBVDate='". join_date($_GET, 'HBVDate')."' ";
			if (($_GET['HBVGenotype1'] != "") || ($_GET['HBVGenotype2'] != "") || ($_GET['HBVGenotype_combination'] != ""))
			{
				if ($_GET['HBVGenotype_combination'] != "")
				{
					$sql .= ", HBVGenotype='". $_GET['HBVGenotype_combination']."' ";
				}
				else
				{
					$sql .= ", HBVGenotype='". $_GET['HBVGenotype1'];
					if ($_GET['HBVGenotype2'] != "")
					{
						$sql .= "/".$_GET['HBVGenotype2']."' ";
					}
					else
					{
						$sql .= "' ";
					}					
				}
			}
			$sql .= "WHERE PatientCode='". $_GET['PatientCode']."'";
		}
		else
		{
			$sql="";
			$sql .= " INSERT INTO `coinfections` ";
			$sql .= " ( `PatientCode`, `HBV`, `HBVDate`";
			if (($_GET['HBVGenotype1'] != "") || ($_GET['HBVGenotype2'] != "") || ($_GET['HBVGenotype_combination'] != ""))
			{
				$sql .= ", `HBVGenotype`";
			}
			$sql .= ") VALUES ('";
			$sql .=  $_GET['PatientCode'] . "', ";
			$sql .= "'". $_GET['HBV']."', ";
			$sql .= "'". join_date($_GET, 'HBVDate')."' ";
			if (($_GET['HBVGenotype1'] != "") || ($_GET['HBVGenotype2'] != "") || ($_GET['HBVGenotype_combination'] != ""))
			{
				if ($_GET['HBVGenotype_combination'] != "")
				{
					$sql .= ",'". $_GET['HBVGenotype_combination']."' ";
				}
				else
				{
					$sql .= ",'". $_GET['HBVGenotype1'];
					if ($_GET['HBVGenotype2'] != "")
					{
						$sql .= "/".$_GET['HBVGenotype2']."' ";
					}
					else
					{
						$sql .= "' ";
					}
				}
			}
			$sql .= ");";
		}
//		echo "<BR>".$sql."<BR><BR>";
		$what_happened = execute_query($sql);
		echo mysql_error();
		if ($what_happened == 1)
    	{
//	    	echo "<P>Τα δεδομένα αποθηκεύτηκαν με επιτυχία!</P>";
		}
		else
    	{	
//	    	echo "<P>$what_happened</P>";
		}
  	}
}
if (isset($_GET['HCV']))
{
	if ($_GET['HCV'] == 1)
	{
		if ($has_entry)
		{
			$sql="";
			$sql .= " UPDATE `coinfections` ";
			$sql .= "SET HCV='". $_GET['HCV']."', ";
			$sql .= "HCVDate='". join_date($_GET, 'HCVDate')."' ";
			if (($_GET['HCVGenotype1'] != "") || ($_GET['HCVGenotype2'] != "") || ($_GET['HCVGenotype_combination'] != ""))
			{
				if ($_GET['HCVGenotype_combination'] != "")
				{
					$sql .= ", HCVGenotype='". $_GET['HCVGenotype_combination']."' ";
				}
				else
				{
					$sql .= ", HCVGenotype='". $_GET['HCVGenotype1'];
					if ($_GET['HCVGenotype2'] != "")
					{
						$sql .= "/".$_GET['HCVGenotype2']."' ";
					}
					else
					{
						$sql .= "' ";
					}				
				}
			}
			$sql .= "WHERE PatientCode='". $_GET['PatientCode']."'";
		}
		else
		{
			$sql="";
			$sql .= " INSERT INTO `coinfections` ";
			$sql .= " ( `PatientCode`, `HCV`, `HCVDate`";
			if (($_GET['HCVGenotype1'] != "") || ($_GET['HCVGenotype2'] != "") || ($_GET['HCVGenotype_combination'] != ""))
			{
				$sql .= ", `HCVGenotype`";
			}
			$sql .= ") VALUES ('";
			$sql .=  $_GET['PatientCode'] . "', ";
			$sql .= "'". $_GET['HCV']."', ";
			$sql .= "'". join_date($_GET, 'HCVDate')."' ";
			if (($_GET['HCVGenotype1'] != "") || ($_GET['HCVGenotype2'] != "") || ($_GET['HCVGenotype_combination'] != ""))
			{
				if ($_GET['HCVGenotype_combination'] != "")
				{
					$sql .= ",'". $_GET['HCVGenotype_combination']."' ";
				}
				else
				{
					$sql .= ",'". $_GET['HCVGenotype1']."/".$_GET['HCVGenotype2']."' ";
				}
			}
			$sql .= ");";
		}
//		echo "<BR>".$sql."<BR><BR>";
		$what_happened = execute_query($sql);
		echo mysql_error();
		if ($what_happened == 1)
    	{
//	    	echo "<P>Τα δεδομένα αποθηκεύτηκαν με επιτυχία!</P>";
		}
		else
    	{	
//	    	echo "<P>$what_happened</P>";
		}
  	}
}

mysql_close($dbconnection);
perform_post_insert_actions("coinfections", "coinfection.php?code=".$_GET['PatientCode'], "");
?>

<p><a href="javascript:location.href = '<?echo getenv('HTTP_REFERER');?>';">Κάντε click εδώ για επιστροφή</a></p>


</BODY></HTML>