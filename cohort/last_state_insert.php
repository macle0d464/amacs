<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
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

if ($_GET['LastState'] == "")
{
	perform_post_insert_actions("","last_state.php?code=".$_GET['PatientCode'],"");	
}

//form_data2table($_GET);

if ($_GET['LastState'] == 1)
{
	// State ALIVE
	$sql = "INSERT INTO clinic_visits (`PatientCode`, `Clinic`, `DateOfVisit`) ";
	$sql .= "VALUES ('".$_GET['PatientCode']."', '".$_GET['Clinic']."', '".join_date($_GET, 'DateOfVisit')."')";
	execute_query($sql);
	$sql = "UPDATE last_state SET LastState='1', Lost2FollowUp=NULL, LastKnownToBeAlive=NULL, DeathDate=NULL, DateDeathKnown=NULL, WithdrawalDate=NULL, Immediate=NULL, Contributing1=NULL, Contributing2=NULL, Contributing3=NULL, Contributing4=NULL, Underlying=NULL, Notes=NULL  WHERE PatientCode='".$_GET['PatientCode']."'";
	execute_query($sql);
//	echo $sql;
//	echo mysql_error();
}

if ($_GET['LastState'] == 2)
{
	// Delete previous entry
	execute_query("DELETE FROM last_state WHERE PatientCode=".$_GET['PatientCode']);	
	
	// State DEAD
	$deaths_result = execute_query("SELECT * FROM deaths_list");
	$death_codes_list = array();
	for ($i=0; $i<mysql_num_rows($deaths_result); $i++)
	{
		$row = mysql_fetch_object($deaths_result);
		if ($row->ICD10_extra == "")
		{
			$death_codes_list[$row->Code] = "no_extra";
		}
		else
		{
			$death_codes_list[$row->Code] = "has_extra";
		}
	}
	mysql_free_result($deaths_result);
	
	$sql = "INSERT INTO last_state VALUES (";
	$sql .= "'".$_GET['PatientCode']."', '2', NULL, NULL, NULL, ";
	if ($_GET['deathdatetype'] == "1")
	{
		$sql .= " '".join_date($_GET, 'DeathDate')."', NULL, NULL, ";
	}
	else
	{
		$sql .= " NULL, '".join_date($_GET, 'DateDeathKnown')."', NULL, ";
	}
	// Immediate Cause of Death
	if ($_GET['Immediate'] != "90")
	{
		if ($death_codes_list[$_GET['Immediate']] == "has_extra" && $_GET['othercause1'] != "") {
            $sql .= "'".$_GET['Immediate']." - ".$_GET['othercause1']."', ";
        } else if (isset($_GET['immediate_2']))
		{
			if ($death_codes_list[$_GET['immediate_2']] == "has_extra" && $_GET['othercause1'] != "")
			{
				$sql .= "'".$_GET['immediate_2']." - ".$_GET['othercause1']."', ";
			}
			else
			{
				$sql .= "'".$_GET['immediate_2']."', ";
			}
		}
		else
		{
			$sql .= "'".$_GET['Immediate']."', ";
		}
	}
	else
	{
		$sql .= "'90 - ".$_GET['othercause1']."', ";
	}
	
	// Contributing1 Cause of Death
	if ($_GET['Contributing1'] != "90")
	{
        if ($death_codes_list[$_GET['Contributing1']] == "has_extra" && $_GET['othercause2'] != "") {
            $sql .= "'".$_GET['Contributing1']." - ".$_GET['othercause2']."', ";
        } else if (isset($_GET['contributing1_2']))
		{
			if ($death_codes_list[$_GET['contributing1_2']] == "has_extra" && $_GET['othercause2'] != "")
			{
				$sql .= "'".$_GET['contributing1_2']." - ".$_GET['othercause2']."', ";
			}
			else
			{
				$sql .= "'".$_GET['contributing1_2']."', ";
			}
		}
		else
		{
			$sql .= "'".$_GET['Contributing1']."', ";
		}
	}
	else 
	{
		$sql .= "'90 - ".$_GET['othercause2']."', ";
	}


	// Contributing2 Cause of Death
	if ($_GET['Contributing2'] != "90")
	{
		if ($death_codes_list[$_GET['Contributing2']] == "has_extra" && $_GET['othercause3'] != "") {
            $sql .= "'".$_GET['Contributing2']." - ".$_GET['othercause3']."', ";
        } else if (isset($_GET['contributing2_2']))
		{
			if ($death_codes_list[$_GET['contributing2_2']] == "has_extra" && $_GET['othercause3'] != "")
			{
				$sql .= "'".$_GET['contributing2_2']." - ".$_GET['othercause3']."', ";
			}
			else
			{
				$sql .= "'".$_GET['contributing2_2']."', ";
			}
		}
		else
		{
			$sql .= "'".$_GET['Contributing2']."', ";
		}
	}
	else 
	{
		$sql .= "'90 - ".$_GET['othercause3']."', ";
	}

	// Contributing3 Cause of Death
	if ($_GET['Contributing3'] != "90")
	{
		if ($death_codes_list[$_GET['Contributing3']] == "has_extra" && $_GET['othercause4'] != "") {
            $sql .= "'".$_GET['Contributing3']." - ".$_GET['othercause4']."', ";
        } else if (isset($_GET['contributing3_2']))
		{
			if ($death_codes_list[$_GET['contributing3_2']] == "has_extra" && $_GET['othercause4'] != "")
			{
				$sql .= "'".$_GET['contributing3_2']." - ".$_GET['othercause4']."', ";
			}
			else
			{
				$sql .= "'".$_GET['contributing3_2']."', ";
			}
		}
		else
		{
			$sql .= "'".$_GET['Contributing3']."', ";
		}
	}
	else 
	{
		$sql .= "'90 - ".$_GET['othercause4']."', ";
	}

	// Contributing4 Cause of Death
	if ($_GET['Contributing4'] != "90")
	{
		if ($death_codes_list[$_GET['Contributing4']] == "has_extra" && $_GET['othercause5'] != "") {
            $sql .= "'".$_GET['Contributing4']." - ".$_GET['othercause5']."', ";
        } else if (isset($_GET['contributing4_2']))
		{
			if ($death_codes_list[$_GET['contributing4_2']] == "has_extra" && $_GET['othercause5'] != "")
			{
				$sql .= "'".$_GET['contributing4_2']." - ".$_GET['othercause5']."', ";
			}
			else
			{
				$sql .= "'".$_GET['contributing4_2']."', ";
			}
		}
		else
		{
			$sql .= "'".$_GET['Contributing4']."', ";
		}
	}
	else 
	{
		$sql .= "'90 - ".$_GET['othercause5']."', ";
	}

	// Underlying Cause of Death
	if ($_GET['Underlying'] != "90")
	{
		if ($death_codes_list[$_GET['Underlying']] == "has_extra" && $_GET['othercause6'] != "") {
            $sql .= "'".$_GET['Underlying']." - ".$_GET['othercause6']."', ";
        } else if (isset($_GET['Underlying_2']))
		{
			if ($death_codes_list[$_GET['Underlying_2']] == "has_extra" && $_GET['othercause6'] != "")
			{
				$sql .= "'".$_GET['Underlying_2']." - ".$_GET['othercause6']."', ";
			}
			else
			{
				$sql .= "'".$_GET['Underlying_2']."', ";
			}
		}
		else
		{
			$sql .= "'".$_GET['Underlying']."', ";
		}
	}
	else 
	{
		$sql .= "'90 - ".$_GET['othercause6']."', ";
	}

	$sql .= "'".$_GET['Notes_death']."')";
//	echo $sql;
	execute_query($sql);
	echo mysql_error();
}
/*
if (($_GET['LastState'] == 2) & ($_GET['has_entry'] == 1))
{
	$sql = "UPDATE last_state SET LastState='2', Lost2FollowUp=NULL, LastKnownToBeAlive=NULL, NewClinic=NULL, DeathDate='".join_date($_GET, 'DeathDate')."', ";
	$sql .= "`Immediate`=";
	if ($_GET['Immediate'] != "90")
	{
		$sql .= "'".$_GET['Immediate']."', ";
	}
	else
	{
		$sql .= "'".$_GET['othercause1']."', ";
	}
	$sql .= "`Contributing1`=";
	if ($_GET['Contributing1'] != "90" && $_GET['Contributing1'] != "")
	{
		$sql .= "'".$_GET['Contributing1']."', ";
	}
	else if ($_GET['Contributing1'] == "90")
	{
		$sql .= "'".$_GET['othercause2']."', ";
	}
	else
	{
		$sql .= "NULL, ";
	}
	$sql .= "`Contributing2`=";
	if ($_GET['Contributing2'] != "90" && $_GET['Contributing2'] != "")
	{
		$sql .= "'".$_GET['Contributing2']."', ";
	}
	else if ($_GET['Contributing2'] == "90")
	{
		$sql .= "'".$_GET['othercause3']."', ";
	}
	else
	{
		$sql .= "NULL, ";
	}
	$sql .= "`Contributing3`=";
	if ($_GET['Contributing3'] != "90" && $_GET['Contributing3'] != "")
	{
		$sql .= "'".$_GET['Contributing3']."', ";
	}
	else if ($_GET['Contributing3'] == "90")
	{
		$sql .= "'".$_GET['othercause4']."', ";
	}
	else
	{
		$sql .= "NULL, ";
	}
	$sql .= "`Contributing4`=";
	if ($_GET['Contributing4'] != "90" && $_GET['Contributing4'] != "")
	{
		$sql .= "'".$_GET['Contributing4']."', ";
	}
	else if ($_GET['Contributing4'] == "90")
	{
		$sql .= "'".$_GET['othercause5']."', ";
	}
	else
	{
		$sql .= "NULL, ";
	}
	$sql .= "`Underlying`=";
	if ($_GET['Underlying'] != "90")
	{
		$sql .= "'".$_GET['Underlying']."', ";
	}
	else
	{
		$sql .= "'".$_GET['othercause6']."', ";
	}	
	$sql .= "Notes='".$_GET['Notes_death']."' WHERE `PatientCode`='".$_GET['PatientCode']."'";
//	echo $sql;
	execute_query($sql);
	echo mysql_error();
}

*/

if ($_GET['LastState'] == 3)
{
	// Delete previous entry
	execute_query("DELETE FROM last_state WHERE PatientCode=".$_GET['PatientCode']);
	
	// Lost to Follow-Up State
	$sql = "INSERT INTO last_state (`PatientCode`, `LastState`, `Lost2FollowUp`, `LastKnownToBeAlive`, `WithdrawalDate`, `NewClinic`, `Notes`) VALUES (";
	$sql .= "'".$_GET['PatientCode']."', '3', '".$_GET['Lost2FollowUp']."', ";
	$sql .= "'".join_date($_GET, 'LastKnownToBeAlive')."', ";	
	if ($_GET['Lost2FollowUp'] == 5)	
	{
		$sql .= "'".join_date($_GET, 'WithdrawalDate')."', ";
	}
	else
	{
		$sql .= "NULL, ";
	}
	if ($_GET['Lost2FollowUp'] == 3)
	{
		$sql .= "'".$_GET['NewClinic']."', ";	
	}
	else
	{
		$sql .= "NULL, ";
	}	
	$sql .= "'".$_GET['Notes_lost']."')";
//	echo $sql;
	execute_query($sql);
	echo mysql_error();	
}

/*
if (($_GET['LastState'] == 3) & ($_GET['has_entry'] == 1))
{
	$sql = "UPDATE last_state  SET `LastState`='3', `Lost2FollowUp`='".$_GET['Lost2FollowUp']."', `LastKnownToBeAlive`=";
	if ($_GET['Lost2FollowUp'] == 1)
	{
		$sql .= "'".join_date($_GET, 'LastKnownToBeAlive')."', ";	
	}
	else
	{
		$sql .= "NULL, ";
	}
	$sql .= "`NewClinic`=";
	if ($_GET['Lost2FollowUp'] == 3)
	{
		$sql .= "'".$_GET['NewClinic']."', ";	
	}
	else
	{
		$sql .= "NULL, ";
	}	
	$sql .= "`Notes`='".$_GET['Notes_lost']."', ";
	$sql .= "DeathDate=NULL, Immediate=NULL, Contributing1=NULL, Contributing2=NULL, Contributing3=NULL, Contributing4=NULL, Underlying=NULL ";
	$sql .= " WHERE `PatientCode`='".$_GET['PatientCode']."'";
//	echo $sql;
	execute_query($sql);
	echo mysql_error();	
}

*/

?>

<?
echo mysql_error();
mysql_close($dbconnection);
perform_post_insert_actions("last_state", "last_state.php?code=".$_GET['PatientCode'], "");
?>

</BODY></HTML>
