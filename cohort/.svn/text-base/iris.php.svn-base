<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
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
	$what[1] = "Εκδήλωση";
	$what[2] = "Επιδείνωση προϋπάρχουσας";
?>

<HTML><HEAD>
<TITLE>Immune Reconstitution Inflammatory Syndrome (IRIS)</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<? 
if (isset($_GET['error']))
{
	echo "<center><table><tr><td class='errormsg'>" . $_GET['error'] . "</td></tr></table></center><br>";
}
?>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("anosologikes.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="aimatologikes_form" name="aimatologikes_form" action="iris_insert.php" method="GET" onsubmit="return check_data();">
<input type="hidden" name="exams" value="1<?// echo $_GET['exams'] ?>">

<? show_patient_data($_GET['code']); ?>
    <a href="#view">Προβολή Εξετάσεων Ασθενή</a>
    <a name="top"></a>
    <h3>Immune Reconstitution Inflammatory Syndrome (IRIS)</h3>
<TABLE>
	<TR>
    <TD>Ημερομηνία Εμφάνισης
    </TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Ημέρα: 
    <select name=StartDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
	<TR>
    <TD>Ημερομηνία Υποχώρησης
    </TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	</select></TD>
    </TR>    
    <TR>
    <TD>Είδος</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select name=What>
    <option value="1">Εκδήλωση</option>
    <option value="2">Επιδείνωση προϋπάρχουσας</option>
    </select>
    <select name=Type>
	<? echo $types_str; ?>
    </select>
    </TD>
    </TR>    
    <TR>
    <TD>Αντιμετώπιση</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select name=Antimetopisi>
	<? echo $ant_str; ?>
    </select>
    </TD>
    </TR>                
</TABLE>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>

<script>
function check_data()
{
/*	if (document.all['AbsoluteCD40'].value == "")
	{
		alert("Πρέπει να δώσετε μια τιμή για τον απόλυτο αριθμό CD4!");
		return false;
	} */
	if (document.all['StartDate_year'].value == "")
	{
		alert("Πρέπει να δώσετε το έτος της ημερομηνίας εμφάνισης!");
		return false;
	}
	if (document.all['StartDate_month'].value == "")
	{
		alert("Πρέπει να δώσετε τον μήνα της ημερομηνίας εμφάνισης!");
		return false;
	}
	if (document.all['StartDate_day'].value == "")
	{
		alert("Πρέπει να δώσετε την ημέρα της ημερομηνίας εμφάνισης!");
		return false;
	}	
}
function show(t)
{
	if (t == 3)
	{
		document.all['extra'].style.display = "";
	}
	else
	{
		document.all['extra'].style.display = "none";
	}
}
</script>

<hr>
<h3><a name="view">Καταχωρημένα Δεδομένα</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT * FROM iris WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_iris.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=iris>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    
    echo "<th class=result> Ημερομηνία<BR>Εμφάνισης</th>";
    echo "<th class=result> Ημερομηνία<BR>Υποχώρησης </th>";
    echo "<th class=result> Είδος </th>";
    echo "<th class=result> Αντιμετώπιση </th>";          
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν υπάρχουν καταχωρημένα στοιχεία!</p>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
    	$resultrow = mysql_fetch_assoc($result);
    	echo "<tr>\n";
        echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_startdate_".$j."' value='".$resultrow['StartDate']."'><input type=hidden name='del_exam_enddate_".$j."' value='".$resultrow['EndDate']."'>";
        echo "<input type=hidden name='del_exam_what_".$j."' value='".$resultrow['What']."'><input type=hidden name='del_exam_type_".$j."' value='".$resultrow['Type']."'><input type=hidden name='del_exam_ant_".$j."' value='".$resultrow['Antimetopisi']."'></td>\n";
        echo "<td class=result>".$resultrow['StartDate']."</td>";
        if ($resultrow['EndDate'] == "0000-00-00")
        {
        	echo "<td class=result style='cursor: pointer' onclick='location.href=\"edit_iris.php?code=".$_GET['code']."&what=".$resultrow['What']."&start=".$resultrow['StartDate']."&type=".$resultrow['Type']."&ant=".$resultrow['Antimetopisi']."\";'>";
        	echo " <font color='blue'>Προσθήκη</font> <img src='./images/b_edit.png'> </td>";
        }
        else
        {
        	echo "<td class=result>".$resultrow['EndDate']."</td>";
        }
        echo "<td class=result>".$what[$resultrow['What']]." - ".$types_arr[$resultrow['Type']]." </td>";
        echo "<td class=result>".$ant_arr[$resultrow['Antimetopisi']]." </td>";
        echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή'></p>";
        echo "</form>";
    }


mysql_free_result($result);
?>

</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>