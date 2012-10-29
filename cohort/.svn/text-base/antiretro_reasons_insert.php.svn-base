<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προσθήκη αιτιών διακοπής αντιρετροϊκών θεραπείων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMinMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
//require_once 'Text/Highlighter.php';

	$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
	$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
	if (!$db_selected) {
   		die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
	}
	if (isset($_POST['query']))
	{
		$sql_query = "INSERT INTO antiretro_reasons VALUES('".$_POST['next_id']."', '".$_POST['query']."')";
		$results = execute_query($sql_query);
		echo $sql_query;
	}
	$table_query = "SELECT * FROM antiretro_reasons";
	$table_results = execute_query($table_query);


//	print_r($results);
//	echo "<BR><BR>";
	

		query2table($table_results);
		$result = execute_query("SELECT * FROM setup");
		$row = mysql_fetch_assoc($result);
		$clinic = $row['Value'];
		$sql = "SELECT MAX(Right( id, 1 )) +1 FROM `antiretro_reasons` WHERE id LIKE \"".$clinic."x%\"";
		$result = execute_query($sql);
		if (mysql_num_rows($result)>0)
		{
			$row = mysql_fetch_array($result);
			if ($row[0] !=NULL)
			{
				$next_id = $clinic."x".$row[0];
			}
			else 
			{
				$next_id = $clinic."x1";
			}
		}
		else
		{
			$next_id = $clinic."x1";
		}
	    echo mysql_error();
	
	mysql_close($dbconnection);
?>

<p>Προσθήκη στοιχείου<p>
<FORM METHOD=POST action="antiretro_reasons_insert.php">
<input type="hidden" name="next_id" value="<? echo $next_id; ?>">
<input type="text" id="query" style="font-family: courier new" name="query"/>
<p>
<input type="submit" value="Προσθήκη" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/></p>
</form>


</BODY></HTML>

<?php

?>