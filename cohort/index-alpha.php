<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
?>

<?php
 if (!isset($_SERVER['PHP_AUTH_USER'])) {
   header('WWW-Authenticate: Basic realm="Please Log-in"');
   header('HTTP/1.0 401 Unauthorized');
   echo 'Text to send if user hits Cancel button';
   exit;
 } else {
   echo "<div style='position: absolute; left 300px; top 100px'>";
   echo "<p>Hello {$_SERVER['PHP_AUTH_USER']}.</p>";
   echo "<p>You entered {$_SERVER['PHP_AUTH_PW']} as your password.</p></div>";
 }
?>

<HTML><HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<p>&nbsp; </p>
<p>&nbsp; </p>
<?
$query1 = "SELECT Count(PatientCode) FROM patients";
$query2 = "SELECT Count(PatientCode) FROM patients WHERE DATEDIFF(NOW(), LastEntry)>180";
$query3 = "SELECT PatientCode, Name, Surname FROM patients WHERE DATEDIFF(NOW(), LastEntry)>180";

$result = execute_query($query1);
$row = mysql_fetch_assoc($result);
$num = $row['Count(PatientCode)'];
echo "<P>Υπάρχουν $num καταχωρημένοι ασθενείς στη βάση δεδομένων</P>";
$result = execute_query($query2);
$row = mysql_fetch_array($result);
$num = $row[0];
echo "<P>Υπάρχουν $num καταχωρημένοι ασθενείς για τους οποίους <b>δεν έχει γίνει ενημέρωση εδώ και 6 μήνες</b><BR>";
echo "Κάντε click <a href='#' onclick='show();'>εδώ</a> για να τους δείτε</P>";
mysql_free_result($result);
$result = execute_query($query3);
?> <div id=data style="display: none" class="img-shadow"> 
<?
query2table($result);
mysql_close($dbconnection);
?>
</div>
<div class="img-shadow">
<p style="display: block; border: 1px solid #a9a9a9">
This is a test sentence with shadow
</p>
</div>
<p>
<?echo replace2null("Hello, ''"); ?>
</p>
<script>
function show()
{
	if (document.all.data.style.display == "none")
	{
		document.all.data.style.display = "";
	}
	else
	{
		document.all.data.style.display = "none";
	}
}
</script>
</BODY></HTML>