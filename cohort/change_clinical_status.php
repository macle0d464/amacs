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
<TITLE>Καταχώρηση Κλινικής Κατάστασης Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$code = $_GET['code'];
$category = $_GET['category'];
if (isset($_GET['changeto']) && isset($_GET['changedate_year']))
{
	$changeto = $_GET['changeto'];
	$changedate = join_date($_GET, "changedate");
	if ($category == "A")
	{
		$sql = "UPDATE `aids_clinical_status` SET StatusChange1 = '$changeto', StatusChange1Date = '$changedate'";
		$sql .= " WHERE `PatientCode` = '$code' LIMIT 1";		
	}
	if ($category == "B")
	{
		$result = execute_query("SELECT StatusChange1 FROM aids_clinical_status WHERE PatientCode = '$code'");
		$row = mysql_fetch_array($result);
		if ($row[0] == "")
		{
			$sql = "UPDATE `aids_clinical_status` SET StatusChange1 = '$changeto', StatusChange1Date = '$changedate'";
			$sql .= " WHERE `PatientCode` = '$code' LIMIT 1";
		}
		else		
		{
			$sql = "UPDATE `aids_clinical_status` SET StatusChange2 = '$changeto', StatusChange2Date = '$changedate'";
			$sql .= " WHERE `PatientCode` = '$code' LIMIT 1";
		}
	}
	$what_happened = execute_query($sql);
	if ($what_happened == 1)
    {
    	echo "<P>Η αλλαγή της κλινικής κατάστασης καταχωρήθηκε με επιτυχία!</P>";
    	header("Location: http://$server/$install_dir/clinical_status.php?code=".$_GET['code']);
	}
	else
    {
    	echo "<P>$what_happened</P>";
	}
}
else
{ 
	if ($category == "A")
	{
?>
<form action="change_clinical_status.php" onsubmit="return check_data();">
<input type="hidden" name="code" value="<? echo $_GET['code'] ?>">
<input type="hidden" name="category" value="<? echo $category ?>">
<table>
<tr>
<td>Δώστε την νέα κλινική κατάσταση του ασθενή <? echo $_GET['code'] ?> </td>
<td align="center">
<SELECT name=changeto>
<OPTION VALUE="B">Κατηγορία B</OPTION>
<OPTION VALUE="C">Κατηγορία C</OPTION>
</SELECT>
</td></tr>
<tr>
<td>Δώστε την ημερομηνία αλλαγής της κλινικής<BR>κατάστασης του ασθενή</td>
<td>
Ημέρα: 
<select name=changedate_day>
<option value=""></option>
<? print_options(31); ?>
</select>&nbsp;
Μήνας:
<select name=changedate_month>
<option value=""></option>
<? print_options(12); ?>
</select>&nbsp;
Έτος: <select name=changedate_year>
<option value=""></option>
<? print_years(); ?>
</select>
</td></tr>
<tr>
<td colspan=2 align=center><input type=submit value="Αλλαγή Κλινικής κατάστασης"></td>
</tr>
</table>
<script>
function check_data()
{
	if (document.all['changedate_year'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία αλλαγής της κλινικής κατάστασης του ασθενούς!");
		return false;
	}
}
</script>
</form> 
<?
	}
	else
	{
?>
<form action="change_clinical_status.php" onsubmit="return check_data();">
<input type="hidden" name="code" value="<? echo $_GET['code'] ?>">
<input type="hidden" name="category" value="<? echo $category ?>">
<table>
<tr>
<td>Δώστε την νέα κλινική κατάσταση του ασθενή <? echo $_GET['code'] ?> </td>
<td align="center">
<SELECT name=changeto>
<OPTION VALUE="C">Κατηγορία C</OPTION>
</SELECT>
</td></tr>
<tr>
<td>Δώστε την ημερομηνία αλλαγής της κλινικής<BR>κατάστασης του ασθενή</td>
<td>
Ημέρα: 
<select name=changedate_day>
<option value=""></option>
<? print_options(31); ?>
</select>&nbsp;
Μήνας:
<select name=changedate_month>
<option value=""></option>
<? print_options(12); ?>
</select>&nbsp;
Έτος: <select name=changedate_year>
<option value=""></option>
<? print_years(); ?>
</select>
</td></tr>
<tr>
<td colspan=2 align=center><input type=submit value="Αλλαγή Κλινικής κατάστασης"></td>
</tr>
</table>
<script>
function check_data()
{
	if (document.all['changedate_year'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία αλλαγής της κλινικής κατάστασης του ασθενούς!");
		return false;
	}
}
</script>
</form>
<?
	}
}
?>