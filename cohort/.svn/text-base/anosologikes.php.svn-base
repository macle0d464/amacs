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
<TITLE>Καταχώρηση Ανοσολογικών Εξετάσεων Ασθενούς</TITLE>
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
	Print_PatientCode_form("cd48.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="anosologikes_form" name="anosologikes_form" action="anosologikes_insert.php" method="GET" onsubmit="return check_data();">
<input type="hidden" name="exams" value="1<?// echo $_GET['exams'] ?>">

<P>Ανοσολογικές εργαστηριακές εξετάσεις (από 1/1/1996 μέχρι και την σημερινή ημερομηνία)</P>

<TABLE>
    <TR>
    <TD> <? show_patient_data($_GET['code']); ?>
    <a href="show_anosologikes.php?code=<?echo $_GET['code'];?>" target="_new">Προβολή Εξετάσεων Ασθενή</a>
    </TD><TD></TD>
    <TD <? if ($_GET['errnum'] == 2) {echo "class='show'";} ?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    </TR>
<?php

for ($k=0; $k< 1; $k++)
{ 
	$i=$k+1
	?>
    <TR><TD class="show"><!--&nbsp;&nbsp;&nbsp;<?//echo $i?>η Εξέταση--></TD><TD></TD></TR>
	<TR>
    <TD class="show">Ημερομηνία Εξέτασης
    </TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Ημέρα: 
    <select name=ExamDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=ExamDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=ExamDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR>
    <TD>Απόλυτος αριθμός λεμφοκυττάρων</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT class=input name=AbsoluteLemf<?echo $k?>></TD>
    </TR>    
    <TR>
    <TD>Απόλυτος αριθμός CD4 (κύτταρα/μl)</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT class=input name=AbsoluteCD4<?echo $k?>></TD>
    </TR>
    <TR>
    <TD>Ποσοστό CD4 (%)</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT class=input name=PercentCD4<?echo $k?>></TD>
    </TR>
    <TR>
    <TD>Απόλυτος αριθμός CD8 (κύτταρα/μl)</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT class=input name=AbsoluteCD8<?echo $k?>></TD>
    </TR>
    <TR>
    <TD>Ποσοστό CD8 (%) </TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT class=input name=PercentCD8<?echo $k?>></TD>
    </TR>
<?php } ?>          
</TABLE>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<script>
function check_data()
{
	if (document.all['AbsoluteCD40'].value == "")
	{
		alert("Πρέπει να δώσετε μια τιμή για τον απόλυτο αριθμό CD4!");
		return false;
	}
	if (document.all['ExamDate0_year'].value == "")
	{
		alert("Πρέπει να δώσετε το έτος της εξέτασης!");
		return false;
	}
	if (document.all['ExamDate0_month'].value == "")
	{
		alert("Πρέπει να δώσετε τον μήνα της εξέτασης!");
		return false;
	}
	if (document.all['ExamDate0_day'].value == "")
	{
		alert("Πρέπει να δώσετε την ημέρα της εξέτασης!");
		return false;
	}	
}
</script>
</BODY>

<hr>
<h3><a name="view">Καταχωρημένες Αιματολογικές Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT ExamDate, AbsoluteLemf, AbsoluteCD4, PercentCD4, AbsoluteCD8, PercentCD8, AbsoluteCD4/AbsoluteCD8 FROM exams_anosologikes WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_exams.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_anosologikes>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Απόλυτος αριθμός λεμφοκυττάρων </th>";
    echo "<th class=result> Απόλυτος αριθμός CD4</th>";
    echo "<th class=result> Ποσοστό CD4</th>";   
    echo "<th class=result> Απόλυτος αριθμός CD8</th>";    
    echo "<th class=result> Ποσοστό CD8</th>"; 
    echo "<th class=result> Λόγος CD4/CD8</th>";       
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ExamDate']."'><input type=hidden name='del_exam_code_".$j."' value='".$resultrow['Code']."'></td>\n";
            for ($i=0; $i < 7; $i++)
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>".$resultrow[$field->name]."</td>";
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

</HTML>
<? 	mysql_close($dbconnection); ?>