<?php 
require_once('../include/basic_defines.inc.php');
require_once('../include/basic_functions.inc.php');
require_once('../include/db_name.php');

$dbconnection = cohortdb_connect($cohort_db_server, "root", "97103");

if (isset($_GET['setdb'])) {
	file_put_contents("../include/db_name.php", "<? \$cohort_db_name = \"".$_GET['setdb']."\"; ?>\n");
	$cohort_db_name = $_GET['setdb'];
}
?>
<HTML><HEAD>
<TITLE>Επιλογή Βάσης Δεδομένων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="../include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>

<?php 
?>

<h1>Επιλεγμένη βάση δεδομένων: <?php echo $cohort_db_name; ?></h1>
<h2>Επιλέξτε την βάση δεδομένων που θα χρησιμοποιηθεί</h2>
<table border="1">
<tr><th>Database</th><th>Patients</th><th>Alive</th><th>Dead</th><th>Lost to Follow Up</th></tr>
<?php 
$result = execute_query("SHOW DATABASES;");
for ($i=0; $i<mysql_num_rows($result); $i++) {
	$row = mysql_fetch_array($result);
	if (is_numeric(strpos($row[0], "cohort"))) {
//		$result2 = execute_query("SELECT COUNT(*) FROM `".$row[0]."`.`patients`");
//		$patients = mysql_fetch_array($result2);
//		mysql_free_result($result2);
		$result2 = execute_query("SELECT COUNT(*) AS 'all', COUNT(IF(LastState='1', 1, NULL)) AS 'alive', COUNT(IF(LastState='2', 1, NULL)) AS 'dead', COUNT(IF(LastState='3', 1, NULL)) AS 'ltfu' FROM `".$row[0]."`.`last_state`");		
		$laststate = mysql_fetch_assoc($result2);
		mysql_free_result($result2);
		echo "<tr>";
		echo "<td><h3> <a href=\"index.php?setdb=".$row[0]."\">".$row[0]."</a> </h3></td>";
		echo "<td><h3> ".$laststate['all']." </h3></td>";
		echo "<td><h3> ".$laststate['alive']." </h3></td>";
		echo "<td><h3> ".$laststate['dead']." </h3></td>";
		echo "<td><h3> ".$laststate['ltfu']." </h3></td>";
		echo "</tr>";
	}
}
?>
</table>
</BODY></HTML>