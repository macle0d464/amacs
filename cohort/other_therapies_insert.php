<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προσθήκη αιτιών διακοπής άλλων θεραπείων HCV</TITLE>
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
		$sql_query = "INSERT INTO other_treatments_list VALUES('".$_POST['next_id']."', '".$_POST['query']."')";
		$results = execute_query($sql_query);
	}
	echo "<h3>Θεραπείες</h3>";
	$table_query = "SELECT * FROM other_treatments_list WHERE id<100";
	$table_results = execute_query($table_query);
		query2table($table_results);
	mysql_free_result($table_results);
	echo "<h3>Aντιμικροβιακά</h3>";		
	$table_query = "SELECT * FROM other_treatments_list WHERE id>100 AND id<200";
	$table_results = execute_query($table_query);
		query2table($table_results);
	mysql_free_result($table_results);		
	echo "<h3>Αντιμυκοβακτηριδιακά</h3>";
	$table_query = "SELECT * FROM other_treatments_list WHERE id>200 AND id<300";
	$table_results = execute_query($table_query);
		query2table($table_results);
	mysql_free_result($table_results);
	echo "<h3>Αντιικά</h3>";		
	$table_query = "SELECT * FROM other_treatments_list WHERE id>300 AND id<400";
	$table_results = execute_query($table_query);
		query2table($table_results);
	mysql_free_result($table_results);						
	    echo mysql_error();
	echo "<h3>Αντιμυκητιασικά</h3>";		
	$table_query = "SELECT * FROM other_treatments_list WHERE id>400";
	$table_results = execute_query($table_query);
		query2table($table_results);
	mysql_free_result($table_results);
	    echo mysql_error();
	$query = "SELECT MAX(id)+1 FROM other_treatments_list WHERE id<100";
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$id = $row[0];	
	$query = "SELECT MAX(id)+1 FROM other_treatments_list WHERE id>100 AND id<200";
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$id2 = $row[0];
	$query = "SELECT MAX(id)+1 FROM other_treatments_list WHERE id>200 AND id<300";
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$id3 = $row[0];	
	$query = "SELECT MAX(id)+1 FROM other_treatments_list WHERE id>300 AND id<400";
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$id4 = $row[0];
	$query = "SELECT MAX(id)+1 FROM other_treatments_list WHERE id>400";
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$id5 = $row[0];					     
	mysql_close($dbconnection);
?>

<p>Προσθήκη θεραπείας της <b>1ης κατηγορίας</b><p>
<FORM METHOD=POST action="other_therapies_insert.php">
<input type="text" id="query" style="font-family: courier new" name="query"/>
<input type=hidden name=next_id value=<?echo $id;?>>
<p>
<input type="submit" value="Προσθήκη" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/></p>
</form>
<p>Προσθήκη θεραπείας στα <b>Aντιμικροβιακά</b><p>
<FORM METHOD=POST action="other_therapies_insert.php">
<input type="text" id="query" style="font-family: courier new" name="query"/>
<input type=hidden name=next_id value=<?echo $id2;?>>
<p>
<input type="submit" value="Προσθήκη" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/></p>
</form>
<p>Προσθήκη θεραπείας στα <b>Αντιμυκοβακτηριδιακά</b><p>
<FORM METHOD=POST action="other_therapies_insert.php">
<input type="text" id="query" style="font-family: courier new" name="query"/>
<input type=hidden name=next_id value=<?echo $id3;?>>
<p>
<input type="submit" value="Προσθήκη" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/></p>
</form>
<p>Προσθήκη θεραπείας στα <b>Αντιικά</b><p>
<FORM METHOD=POST action="other_therapies_insert.php">
<input type="text" id="query" style="font-family: courier new" name="query"/>
<input type=hidden name=next_id value=<?echo $id4;?>>
<p>
<input type="submit" value="Προσθήκη" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/></p>
</form>
<p>Προσθήκη θεραπείας στα <b>Αντιμυκητιασικά</b><p>
<FORM METHOD=POST action="other_therapies_insert.php">
<input type="text" id="query" style="font-family: courier new" name="query"/>
<input type=hidden name=next_id value=<?echo $id5;?>>
<p>
<input type="submit" value="Προσθήκη" style="font-family: courier new"/>
<input type="button" style="font-family: courier new" value="Καθαρισμός" onclick="document.all.query.value='';"/></p>
</form>


</BODY></HTML>

<?php

?>