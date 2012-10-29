<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντι-ιικών Θεραπειών</TITLE>
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

$reasons_query = "SELECT * FROM hcv_reasons";
$results = execute_query($reasons_query);		
$num = mysql_num_rows($results);
for ($i = 0; $i < $num; $i++)
{
	$row = mysql_fetch_assoc($results);
	$reasons[$row['ID']] = $row['Reason'];
}

	$reasons_query = "SELECT * FROM hcv_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	$reasons_str = "";
	for ($r=0; $r<$reasons; $r++)
	{
		$row = mysql_fetch_array($reason_result);
    	$reasons_str .= "<option value='".$row[0]."'>".$row[1]."</option>\n";
    }

echo "<P><B> Βιοχημικές-Ιολογικές Ανταποκρίσεις και Λόγοι Διακοπής Θεραπειών</B></P>";
$sql = "SELECT * FROM hcv_antiiikes_treatments_antapokrisi WHERE StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."' AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
$row = mysql_fetch_assoc($result);
echo mysql_error();
    echo "<form method=get action='hcv_change_antiiikes_data.php' onsubmit='return check_data();'>";
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
	echo "<th class=result>Βιοχημική<BR>Ανταπόκριση</th>";
	$today = getdate();
	$now_days = round(strtotime("now")/86400);
	$th_days = round(strtotime($_GET['start'])/86400);
	$th_days_end = round(strtotime($_GET['end'])/86400);
    echo "<td class=result>";
    echo "<table>";
    if ($now_days >= $th_days+28)
    {
    	echo "<tr><td>Πολύ πρώιμη<BR><i>(4 εβδομάδες)</i></td><td>&nbsp;&nbsp;<select name=Bioximiki_polu_prwimi>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }    
    if ($now_days >= $th_days+84)
    {
    	echo "<tr><td>Πρώιμη<BR><i>(12 εβδομάδες)</i></td><td>&nbsp;&nbsp;<select name=Bioximiki_prwimi>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }
    if ($now_days >= $th_days+168)
    {
    	echo "<tr><td>24 εβδoμάδες<BR><i>(12μηνη θεραπεία)</i></td><td>&nbsp;&nbsp;<select name=Bioximiki_24>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }
    if ($_GET['end'] != "3000-01-01")
    {
    	echo "<tr><td>Στο τέλος θεραπείας</td><td>&nbsp;&nbsp;<select name=Bioximiki_end>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    } 
    if (($_GET['end'] != "3000-01-01") && ($now_days >= $th_days_end+182))
    {
    	echo "<tr><td><b>Μακροχρόνια</b><i><BR>(6 μήνες μετά<BR>την διακοπή)</i></td><td>&nbsp;&nbsp;<select name=Bioximiki_longterm>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }    	           
    echo "</table>";
    echo "</td>";
    echo "</tr>\n";
	echo "<th class=result>Ιολογική<BR>Ανταπόκριση</th>";
    echo "<td class=result>";
    echo "<table>";
    if ($now_days >= $th_days+28)
    {
    	echo "<tr><td>Πολύ πρώιμη<BR><i>(4 εβδομάδες)</i></td><td>&nbsp;&nbsp;<select name=Iologiki_polu_prwimi>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }    
    if ($now_days >= $th_days+84)
    {
    	echo "<tr><td>Πρώιμη<BR><i>(12 εβδομάδες)</i></td><td>&nbsp;&nbsp;<select name=Iologiki_prwimi>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }
    if ($now_days >= $th_days+168)
    {
    	echo "<tr><td>24 εβδoμάδες<BR><i>(12μηνη θεραπεία)</i></td><td>&nbsp;&nbsp;<select name=Iologiki_24>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }
    if ($_GET['end'] != "3000-01-01")
    {
    	echo "<tr><td>Στο τέλος θεραπείας</td><td>&nbsp;&nbsp;<select name=Iologiki_end>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }
    if (($_GET['end'] != "3000-01-01") && ($now_days >= $th_days_end+182))
    {
    	echo "<tr><td><b>Μακροχρόνια</b><i><BR>(6 μήνες μετά<BR>την διακοπή)</i></td><td>&nbsp;&nbsp;<select name=Iologiki_longterm>";
    	echo "<option value='-1'>-</option>";
    	echo "<option value='0'>OXI</option>";
    	echo "<option value='1'>NAI</option>";
    	echo "<option value='2'>ΑΓΝΩΣΤΗ</option>";
    	echo "</td></tr>";
    }    	           
    echo "</table>";
    echo "</td>";
    echo "</tr>\n";
//    if ($_GET['end'] != "3000-01-01")
//    {    	
	echo "<th class=result>Ολοκλήρωση<BR>θεραπείας</th>";
	echo "<td class=result><select name=Info1>";
	echo "<option value=''> - </option>";
    echo "<option value=1>NAI</option><option value=2>OXI</option>";
    echo "</select>";
    echo "</td>";
	echo "</tr>\n";	
	echo "<th class=result>Αιτία<BR>Διακοπής</th>";
	echo "<td class=result><select name=Info2>";
	echo "<option value=''>-</option>";
    echo $reasons_str;
    echo "</select>";
    echo "</td>";
	echo "</tr>\n";	
/*
    }
    else
    {
	echo "<th class=result>Ολοκλήρωση<BR>θεραπείας</th>";
	echo "<td class=result><input type=hidden name=Info1 value=-1>";
    echo "</td>";
	echo "</tr>\n";	
	echo "<th class=result>Αιτία<BR>Διακοπής</th>";
	echo "<td class=result><input type=hidden name=Info2 value=-1>";
    echo "</td>";
	echo "</tr>\n";	    	
    }
*/
	echo "<th class=result>Σημειώσεις</th>";
	echo "<td class=result><textarea name=Notes STYLE=\"width: 540px; overflow:hidden\">".$resultrow['Notes']."</textarea></td>";
    echo "</tr>\n";
    echo "</table>";
    echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <input type=submit value='Αλλαγή Στοιχείων'></p>";
    echo "</form>";
    

echo "<p>&nbsp;</p>\n";
//print_r($resultrow);
?>
<script>
<?
if ($now_days >= $th_days+28)
{
echo "document.all.Bioximiki_polu_prwimi.value='".$row['Bioximiki_polu_prwimi']."';\n";
echo "document.all.Iologiki_polu_prwimi.value='".$row['Iologiki_polu_prwimi']."';\n";
}
if ($now_days >= $th_days+84)
{    
echo "document.all.Bioximiki_prwimi.value='".$row['Bioximiki_prwimi']."';\n";
echo "document.all.Iologiki_prwimi.value='".$row['Iologiki_prwimi']."';\n";
}
if ($now_days >= $th_days+168)
{
echo "document.all.Bioximiki_24.value='".$row['Bioximiki_24']."';\n";
echo "document.all.Iologiki_24.value='".$row['Iologiki_24']."';\n";
}
if ($_GET['end'] != "3000-01-01")
{    
echo "document.all.Bioximiki_end.value='".$row['Bioximiki_end']."';\n";
echo "document.all.Iologiki_end.value='".$row['Iologiki_end']."';\n";
}
if (($_GET['end'] != "3000-01-01") && ($now_days >= $th_days_end+182))
{   
echo "document.all.Bioximiki_longterm.value='".$row['Bioximiki_longterm']."';\n";
echo "document.all.Iologiki_longterm.value='".$row['Iologiki_longterm']."';\n";
}
echo "document.all.Notes.value='".$row['Notes']."';\n";
echo "document.all.Info1.value='".$row['Info1']."';\n";
echo "document.all.Info2.value='".$row['Info2']."';\n";
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
	
	if ((document.all.EndDate_year.value != "") && (document.all.Info1.value == ""))
	{
		alert("Πρέπει να συμπληρώσετε το πεδίο Ολοκλήρωση Θεραπείας!");
		return false;
	}
	if (document.all.EndDate_year.value == "")
	{
		document.all.Info1.value = "";
	}	

	if ((document.all.Info1.value == "2") && (document.all.Info2.value == ""))
	{
		alert("Πρέπει να συμπληρώσετε το πεδίο Αιτία Διακοπής!");
		return false;
	}	
	if ((document.all.Bioximiki_end.value == "0") && (document.all.Bioximiki_longterm.value == "1"))
	{
		ok_to_proceed = confirm("Προσοχή! 'Εχετε συμπληρώσει ότι ο ασθενής δεν έχει βιοχημική ανταπόκριση στο τέλος της θεραπείας αλλά έχει μακροχρόνια βιοχημική ανταπόκριση. Αποθήκευση Δεδομένων;");
		if (!ok_to_proceed)
		{
			return false;
		}		
	}
	if ((document.all.Iologiki_end.value == "0") && (document.all.Iologiki_longterm.value == "1"))
	{
		ok_to_proceed2 = confirm("Προσοχή! 'Εχετε συμπληρώσει ότι ο ασθενής δεν έχει ιολογική ανταπόκριση στο τέλος της θεραπείας αλλά έχει μακροχρόνια ιολογική ανταπόκριση. Αποθήκευση Δεδομένων;");
		if (!ok_to_proceed2)
		{
			return false;
		}		
	}	
}
</script>
<?
mysql_close($dbconnection);
?>
</BODY></HTML>
