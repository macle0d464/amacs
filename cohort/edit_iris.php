<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Αλλαγή IRIS</TITLE>
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

	$types_query = "SELECT * FROM iris_type";
	$types_result = execute_query($types_query);		
	$types = mysql_num_rows($types_result);
	$types_str = "";
	for ($r=0; $r<$types; $r++)
	{
		$row = mysql_fetch_array($types_result);
    	$types_str .= "<option value='".$row[0]."'>".$row[1]."</option>\n";
    	$types_arr[$row[0]] = $row[1];
    }
	mysql_free_result($types_result);
	$ant_query = "SELECT * FROM iris_antimetopisi";
	$ant_result = execute_query($ant_query);		
	$ant = mysql_num_rows($ant_result);
	$ant_str = "";
	for ($r=0; $r<$ant; $r++)
	{
		$row = mysql_fetch_array($ant_result);
    	$ant_str .= "<option value='".$row[0]."'>".$row[1]."</option>\n";
    	$ant_arr[$row[0]] = $row[1];
    }
	mysql_free_result($ant_result);	
	$what['1'] = "Εκδήλωση";
	$what['2'] = "Επιδείνωση προϋπάρχουσας";

$sql = "SELECT * FROM iris WHERE StartDate='".$_GET['start']."' AND Type='".$_GET['type']."' AND PatientCode=".$_GET['code']." AND What=".$_GET['what']." AND Antimetopisi=".$_GET['ant'];
$result = execute_query($sql);
$row = mysql_fetch_assoc($result);
echo mysql_error();
    echo "<form method=get action='change_iris_data.php' onsubmit='return check_data();'>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<input type=hidden name=start value=".$_GET['start'].">";
    echo "<input type=hidden name=type value=".$_GET['type'].">";
    echo "<input type=hidden name=what value=".$_GET['what'].">";
    echo "<input type=hidden name=ant value=".$_GET['ant'].">";      
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
	echo "<th class=result>Ημερομηνία<BR>Εμφάνισης</th>";
	echo "<td class=result>".$_GET['start']."</td>";
	echo "</tr>\n";	
	echo "<th class=result>Ημερομηνία<BR>Υποχώρησης</th>";
	echo "<td class=result>";
?>	
	Ημέρα: 
    <select name=EndDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select>
<?	
	echo "</td>";
	echo "</tr>\n";	
	echo "<th class=result>Είδος</th>";
    echo "<td class=result>";
    echo $types_arr[$_GET['type']];
    echo "</td>";
    echo "</tr>\n";	
	echo "<th class=result>Αντιμετώπιση</th>";
	echo "<td class=result>";
    echo $ant_arr[$_GET['ant']];
    echo "</select>";
    echo "</td>";
	echo "</tr>\n";	
    echo "</table>";
    echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <input type=submit value='Αλλαγή Στοιχείων'></p>";
    echo "</form>";
    

echo "<p>&nbsp;</p>\n";

mysql_close($dbconnection);
?>
<script>
function check_data()
{
	if (document.all['EndDate_year'].value == "")
	{
		alert("Πρέπει να δώσετε το έτος της ημερομηνίας υποχώρησης!");
		return false;
	}
	if (document.all['EndDate_month'].value == "")
	{
		alert("Πρέπει να δώσετε τον μήνα της ημερομηνίας υποχώρησης!");
		return false;
	}
	if (document.all['EndDate_day'].value == "")
	{
		alert("Πρέπει να δώσετε την ημέρα της ημερομηνίας υποχώρησης!");
		return false;
	}		
	end_date = document.all['EndDate_year'].value + "-" + document.all['EndDate_month'].value + "-" + document.all['EndDate_day'].value;
	start_date = document.all['start'].value;
//	alert(start_date);
	if (start_date > end_date)
	{
		alert("H ημερομηνία υποχώρησης πρέπει να είναι μετά την ημερομηνία εμφάνισης!");
		return false;
	}
}
</script>
</BODY></HTML>
