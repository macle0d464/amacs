<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

?>

<HTML><HEAD>
<TITLE>Εισαγωγή Στοιχείων από Excel</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<body>

<?php 

if (!isset($_REQUEST['table']))
{
?>

<FORM enctype="multipart/form-data" METHOD=POST action="insert_exams_from_excel.php">
Πίνακας στον οποίο θα γίνει η εισαγωγή των δεδομένων: <select name="table">
<option value=""> - </option>
<option value="exams_aimatologikes">exams_aimatologikes</option>
<option value="exams_iologikes">exams_iologikes</option>
<option value="exams_bioximikes">exams_bioximikes</option>
<option value="exams_anosologikes">exams_anosologikes</option>
</select><br>
Excel αρχείο που περιέχει τα δεδομένα: 
<input type="file" name="xlsfile" /><br><br>
<input type="submit" style="font-family: courier new"/>
</form>

<?php
} else {

require_once 'Excel/reader.php';
$data = new Spreadsheet_Excel_Reader();

$data->read($_FILES['xlsfile']['tmp_name']);
echo "Table to insert: ".$_REQUEST['table']."<br>";
echo "Table Columns: ".$data->sheets[0]['numCols'].", ";
echo "Table Rows: ".$data->sheets[0]['numRows']."<br><br>";

switch ($_REQUEST['table']) {
	case "exams_bioximikes": $columns = 7; break;
	case "exams_iologikes": $columns = 7; break;
	case "exams_aimatologikes": $columns = 6; break;
	case "exams_anosologikes": $columns = 7; break;
}

error_reporting(E_ALL ^ E_NOTICE);
echo "<table border='0'>";
echo "<tr><th class=result>a/a</th>";
for ($j = 1; $j <= $columns; $j++) {
	echo "<th class=result>".$data->sheets[0]['cells'][1][$j]."</th>";
}
echo "<th class=result>Error</th><th class=result>SQL</th></tr>";

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
	echo "<tr><td class=result>".$i."</td>";
	$sql = "INSERT INTO `".$_REQUEST['table']."` VALUES (";
	for ($j = 1; $j <= $columns; $j++) {
		echo "<td class=result>".$data->sheets[0]['cells'][$i][$j]."</td>";
		if ($data->sheets[0]['cells'][$i][$j] == "NULL") {
			$sql .= "NULL, ";
		} else {
			$sql .= "'".replacecomma($data->sheets[0]['cells'][$i][$j])."', ";
		}
	}
	$sql = substr($sql, 0, strlen($sql)-2);
	$sql .= ");";
	if (is_numeric($data->sheets[0]['cells'][$i][1])) { 
		execute_query($sql);
		echo "<td class=result>".mysql_error()."</td>";
		echo "<td class=result>".$sql."</td>";
	} else	{
		echo "<td class=result></td>";
		echo "<td class=result></td>";
	}
	echo "</tr>\n";
}

echo "</table>";


}
?>

</body>
</HTML>