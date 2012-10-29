<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντιρετροϊκών Θεραπειών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

//if ($_GET['code'] == "" || !is_numeric($_GET['code']))
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
check_patient($_GET['code']);

$reasons_query = "SELECT * FROM antiretro_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['id']] = $row['description'];
}

	$reasons_query = "SELECT * FROM antiretro_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	$reasons_str = "";
	for ($r=0; $r<$reasons; $r++)
	{
    	if ($r <> 95)
    	{
			$row = mysql_fetch_array($reason_result);
    		$reasons_str .= "<option value='".$row[0]."'>".$row[1]."</option>\n";
    	}
    }

echo "<P><B> Συμμόρφωση Ασθενούς και Λόγοι Διακοπής Θεραπειών</B></P>";
$sql = "SELECT * FROM antiretro_treatments_compliance WHERE StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."' AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
$row = mysql_fetch_assoc($result);
echo mysql_error();
    echo "<form method=get action='change_antiretro_data.php' onsubmit='return check_data();'>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<input type=hidden name=start value=".$_GET['start'].">";
    echo "<input type=hidden name=end value=".$_GET['end'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>Σχήμα</th>";
	echo "<td class=result>".$_GET['schema']."</td>";
	echo "</tr>\n";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<td class=result>";
?>
		Ημέρα: <select name="StartDate_day">
		<option value=""></option>
		<? print_options(31); ?>
		</select>&nbsp;
		Μήνας: <select name="StartDate_month">
		<option value=""></option>
		<? print_options(12); ?>
		</select>&nbsp;
		Έτος: <select name="StartDate_year">
		<option value=""></option>
		<? print_years_no_unknown(); ?>
		<option value=""></option>
		</select>
<?		
	echo "</td>";
	echo "</tr>\n";	
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
?>		
		<td class=result>
		Ημέρα: <select name="EndDate_day">
		<option value=""></option>
		<? print_options(31); ?>
		</select>&nbsp;
		Μήνας: <select name="EndDate_month">
		<option value=""></option>
		<? print_options(12); ?>
		</select>&nbsp;
		Έτος: <select name="EndDate_year">
		<option value=""></option>
		<? print_years_no_unknown(); ?>
		<option value=""></option>
		</select>		
		</td>
<?	
	echo "</tr>\n";	
	echo "<th class=result>Συμμόρφωση<BR>Ασθενούς</th>";
    echo "<td class=result>";
    echo "<select name=Compliance>";
    echo "<option value='-1'>Αγνωστη</option>";
    echo "<option value='1'>Κακή</option>";
    echo "<option value='2'>Μέτρια</option>";
    echo "<option value='3'>Καλή</option>";
    echo "</td>";
    echo "</tr>\n";	
	echo "<th class=result>Αιτία<BR>Διακοπής 1</th>";
	echo "<td class=result><select name=Reason1><option value=''> - </option>";
    echo $reasons_str;
    echo "</select>";
    echo "</td>";
	echo "</tr>\n";	
	echo "<th class=result>Αιτία<BR>Διακοπής 2</th>";
	echo "<td class=result><select name=Reason2><option value=''> - </option>";
    echo $reasons_str;
    echo "</select>";
    echo "</td>";
	echo "</tr>\n";	
	echo "<th class=result>Σημειώσεις</th>";
	echo "<td class=result><textarea name=Notes STYLE=\"width: 540px; overflow:hidden\">".$resultrow['Notes']."</textarea></td>";
    echo "</tr>\n";
    echo "</table>";
    echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <input type=submit value='Αλλαγή Στοιχείων'></p>";
    echo "</form>";
    

echo "<p>&nbsp;</p>\n";
print_r($resultrow);
?>
<script>
<?
echo "document.all.Compliance.value='".$row['Compliance']."';\n";
echo "document.all.Reason1.value='".$row['Reason1']."';\n";
echo "document.all.Reason2.value='".$row['Reason2']."';\n";
echo "document.all.Notes.value='".$row['Notes']."';\n";
print_stored_date("StartDate", $row);
if ($row['EndDate'] != '3000-01-01')
{
	print_stored_date("EndDate", $row);
}
?>

function check_data()
{

	if (document.all.EndDate_month.value == "")
	{
		temp = document.all.EndDate_year.value + "-07-01";
	}
	else
	{
		if (document.all.EndDate_day.value == "")
		{
			temp = document.all.EndDate_year.value + "-" + document.all.EndDate_month.value +"-15";
		}
		else
		{
			temp = document.all.EndDate_year.value + "-" + document.all.EndDate_month.value +"-" + document.all.EndDate_day.value;
		}
	}
	if ((document.all.EndDate_year.value != "") && (temp <= "<?echo $_GET['start']?>"))
	{
		alert("Η ημερομηνία διακοπής πρέπει να είναι μετά την ημερομηνία έναρξης του σχήματος!");
		return false;
	}
	
	if (document.all.StartDate_month.value == "")
	{
		tempstart = document.all.StartDate_year.value + "-07-01";
	}
	else
	{
		if (document.all.StartDate_day.value == "")
		{
			tempstart = document.all.StartDate_year.value + "-" + document.all.StartDate_month.value +"-15";
		}
		else
		{
			tempstart = document.all.StartDate_year.value + "-" + document.all.StartDate_month.value +"-" + document.all.StartDate_day.value;
		}
	}	

	if ((document.all.EndDate_year.value != "") && (tempstart >= temp))
	{
		alert("Η ημερομηνία διακοπής πρέπει να είναι μετά την ημερομηνία έναρξης του σχήματος!");
		return false;
	}	
	
	if (document.all.EndDate_year.value == "")
	{
		document.all.Reason1.value = "";
		document.all.Reason2.value = "";
	}	

	if ((document.all.EndDate_year.value != "") && (document.all.Reason1.value == ""))
	{
		alert("Πρέπει να συμπληρώσετε μια Αιτία Διακοπής!");
		return false;
	}	
}
</script>
<?
mysql_close($dbconnection);
?>
</BODY></HTML>
