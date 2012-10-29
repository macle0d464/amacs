<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Εκτέλεση QUERY</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
//require_once 'Text/Highlighter.php';

if (isset($_POST['query']))
{
	$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
	$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
	if (!$db_selected) {
   		die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
	}
	$sql_query = stripslashes($_POST['query']);
//	$highlightSQL =& Text_Highlighter::factory('SQL',array('numbers'=>true));
//	echo "Executed QUERY : ";
//	echo $highlightSQL->highlight($sql_query);
	highlight_string("Executed QUERY : " . $sql_query);
	
	echo "<BR><BR>";
	$results = execute_query($sql_query);

//	print_r($results);
//	echo "<BR><BR>";
	
	if ($results == "1")
	{
		echo "<table><tr><td>Query Successful!</td></tr></table>";
	}
	else
	{
		query2table($results);
		$result2 = execute_query($sql_query);
		query2xls($result2, 'query.xls');
		$result3 = execute_query($sql_query);
		query2csv($result3, 'query.csv');
?>
<P><A HREF="query.xls">Αποτελέσματα σε Excel</A></P>
<P><A HREF="query.csv">Αποτελέσματα σε CSV</A></P>
<?
	}
	
	mysql_close($dbconnection);
}
else 
{
?>

<FORM METHOD=POST action="query.php">
<input type="text" id="query" style="font-family: courier new" size="120" name="query" value="SELECT * FROM "/>
<input type="submit" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/>
</form>

<table>
<tr>
<td><a href="#" onclick="document.all.query.value+='SELECT * FROM ';">Επιλογή όλων των στοιχείων πίνακα</a></td>
<td><a href="#" onclick="document.all.query.value+='patients ';">Επιλογή πίνακα ασθενών</a></td>
<td><a href="#" onclick="document.all.query.value+='demographic_data ';">Επιλογή πίνακα δημογραφικών στοιχείων</a></td>
</tr><tr>
<td><a href="#" onclick="document.all.query.value+='aids_clinical_status ';">Επιλογή πίνακα κλινικής κατάστασης ασθενών</a></td>
<td><a href="#" onclick="document.all.query.value='SELECT DISTINCT * FROM atomiko_anamnistiko, patient_neoplasma, patient_other_clinical_state WHERE atomiko_anamnistiko.MELCode = patient_neoplasma.MELCode AND atomiko_anamnistiko.MELCode = patient_other_clinical_state.MELCode';">
Επιλογή πίνακα ατομικού αναμνηστικού ασθενών</a></td>
<td><a href="#" onclick="document.all.query.value+='aids_clinical_status ';">Επιλογή πίνακα ανοσολογικών εξετάσεων ασθενών</a></td>
</tr>
</table>

</BODY></HTML>

<?php
}
?>