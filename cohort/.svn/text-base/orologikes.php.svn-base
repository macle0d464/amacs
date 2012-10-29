<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$neoplasmata_query = "SELECT * FROM neoplasmata_descriptions";
	$clinicalstates_query = "SELECT * FROM clinical_states_descriptions";
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ορολογικών Εξετάσεων Ασθενούς</TITLE>
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
	Print_PatientCode_form("orologikes.php");
	die();
}
else
{
	check_patient($_GET['code']);	
}
?>

<FORM id="orologikes_form" name="orologikes_form" action="orologikes_insert.php" method="GET">
<? show_patient_data($_GET['code']); ?>
<a href="#view">Προβολή Εξετάσεων Ασθενή</a>
<a name="top"></a>

<P><b>Ορολογικές Εξετάσεις</b></P>

<TABLE>
    <TR><TD></TD><TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Ημερομηνία Εξέτασης</TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Αποτέλεσμα</TD></TR>
	<TR>
<?
    $exams_sql = "SELECT * FROM orologikes_list";
    $exams_result = execute_query($exams_sql);
    for ($i=0; $i<mysql_num_rows($exams_result); $i++)
    {
    	$row = mysql_fetch_assoc($exams_result);
		if ($row['Description'] == "Mantoux")
		{
?>
    <tr><td> </td><td> </td><td> </td></tr>
	<TR><TD class="show">'Αλλες Εξετάσεις</TD><TD></TD><TD class="show">
    </TD></TR>
    <tr><td> </td><td> </td><td> </td></tr>
<?
		}
?>
	<TR>
	<TD><? echo $row['Description']; ?> &nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=<? echo $row['Code']; ?>Date_day onchange="change_day(this.value);">
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=<? echo $row['Code']; ?>Date_month onchange="change_month(this.value);">
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=<? echo $row['Code']; ?>Date_year onchange="change_year(this.value);">
	<option value=""></option>
    <? print_years(); ?></TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT type="radio" name=<? echo $row['Code']; ?> value="1">&nbsp; Θετικό
    <INPUT type="radio" name=<? echo $row['Code']; ?> value="-1">&nbsp; Αρνητικό
    <INPUT type="radio" name=<? echo $row['Code']; ?> value="0" checked>&nbsp; Δεν έγινε
    </TD>
    </TR>
<?
    }
    echo mysql_error();
?>

</TABLE>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<hr>
<h3><a name="view">Καταχωρημένες Ορολογικές Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT exams_orologikes.ExamDate, orologikes_list.Description, exams_orologikes.Result, exams_orologikes.Type FROM exams_orologikes, orologikes_list WHERE orologikes_list.Code=exams_orologikes.Type AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_oro_exams.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_orologikes>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Εξέταση </th>";
    echo "<th class=result> Αποτέλεσμα </th>";          
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
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ExamDate']."'><input type=hidden name='del_exam_code_".$j."' value='".$resultrow['Type']."'></td>\n";
    		echo "<td class=result>".show_date($resultrow['ExamDate'])."</th>";                  
    		echo "<td class=result>".$resultrow['Description']."</th>";  
        	if ($resultrow['Result'] == 1)
        	{
    			echo "<td class=result> Θετικό </th>";  
        	}
        	else
        	{
        		echo "<td class=result> Αρνητικό </th>";
        	}
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }


mysql_free_result($result);
?>
<input name=year_change type="hidden" value='1'>
<input name=month_change type="hidden" value='1'>
<input name=day_change type="hidden" value='1'>
<script>
function change_year(value)
{
	if (document.all['year_change'].value != "0")
	{
<?
    	$exams_sql = "SELECT Code FROM orologikes_list";
    	$exams_result = execute_query($exams_sql);
    	for ($i=0; $i<mysql_num_rows($exams_result); $i++)
    	{
    		$row = mysql_fetch_assoc($exams_result);
			echo "document.all['".$row['Code']."Date_year'].value = value;\n";
    	}		
?>
		document.all['year_change'].value = '0';
	}
}

function change_month(value)
{
	if (document.all['month_change'].value != "0")
	{
<?
    	$exams_sql = "SELECT Code FROM orologikes_list";
    	$exams_result = execute_query($exams_sql);
    	for ($i=0; $i<mysql_num_rows($exams_result); $i++)
    	{
    		$row = mysql_fetch_assoc($exams_result);
			echo "document.all['".$row['Code']."Date_month'].value = value;\n";
    	}		
?>
		document.all['month_change'].value = '0';
	}
}

function change_day(value)
{
	if (document.all['day_change'].value != "0")
	{
<?
    	$exams_sql = "SELECT Code FROM orologikes_list";
    	$exams_result = execute_query($exams_sql);
    	for ($i=0; $i<mysql_num_rows($exams_result); $i++)
    	{
    		$row = mysql_fetch_assoc($exams_result);
			echo "document.all['".$row['Code']."Date_day'].value = value;\n";
    	}		
?>
		document.all['day_change'].value = '0';
	}
}
</script>


</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>