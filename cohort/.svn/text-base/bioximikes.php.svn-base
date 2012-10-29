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
<TITLE>Καταχώρηση Βιοχημικών Εξετάσεων Ασθενούς</TITLE>
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
	Print_PatientCode_form("bioximikes.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="bioximikes_form" name="bioximikes_form" action="bioximikes_insert.php" method="GET">
<input type="hidden" name="exams" value="1<?// echo $_GET['exams'] ?>">

<P> Βιοχημικές εξετάσεις </P><a name="top"></a>
<P>
Καταγράψτε τα αποτελέσματα των βιοχημικών εξετάσεων από
1/1/1996 εως σήμερα.    
</P>

<TABLE>
    <TR>
    <TD><? show_patient_data($_GET['code']); ?>
    <a href="#view">Προβολή Εξετάσεων Ασθενή</a></TD><TD></TD>
    <TD></TD>
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
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημέρα: <select name=ExamDate<?echo $k?>_day>
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
    </TABLE>
    <TABLE>
    <TR>
    <TD><b><u>'Εξέταση</u></b><BR>&nbsp;</TD>
    <TD align="center"><b><u>Τιμή</u>&nbsp; &nbsp; &nbsp; &nbsp;<u>Μονάδες</u></b><BR>&nbsp;</TD>
    <TD><b><u>Normal Ranges</u></b>&nbsp;&nbsp;<BR>Lower &nbsp;-&nbsp; Upper</TD>
    <TD align="center"><b><u>Ratio</u></b><BR>(Value/Upper Normal Limit)</TD>
    </TR>
    <?
    $exams_sql = "SELECT * FROM laboratory_codes";
	$units_sql = "SELECT * FROM units";
	$result = execute_query($units_sql);
	$units = array();
	for ($i=0; $i<mysql_num_rows($result); $i++)
	{
		$row = mysql_fetch_assoc($result);
		$units[$row['ID']]=$row['Unit'];
	}
	mysql_free_result($result);
//	$exams_sql = "SELECT laboratory_codes.Code, laboratory_codes.Description, laboratory_codes.Measurement, laboratory_codes.Upper, laboratory_codes.Lower, units.ID, units.Unit FROM laboratory_codes, units WHERE units.ID=laboratory_codes.Unit1";
    $lab_result = execute_query($exams_sql);
    for ($i=0; $i<mysql_num_rows($lab_result); $i++)
    {
    	$row = mysql_fetch_assoc($lab_result);
    ?>
    <TR>
    <TD><? echo $row['Description'] ?></TD>
    <TD><INPUT size=8 name=<?echo $row['Code']?> onchange="document.all['<? echo $row['Code'];?>_Ratio'].innerHTML = this.value/document.all['<? echo $row['Code']?>_Upper'].value;">&nbsp; 
    <select name='<? echo $row['Code']?>_Unit' onchange="SetNormalValues('<? echo $row['Code']?>', this.value);">
    <option value="<? echo $row['Unit1']; ?>"><? echo $units[$row['Unit1']]; ?></option>
<?
	for ($j=2; $j<6; $j++)
	{
		if ($row['Unit'.$j] != "0")
		{
			?>
	<option value="<? echo $row['Unit'.$j]; ?>"><? echo $units[$row['Unit'.$j]]; ?></option>
			<?
		}
	}
?>
    </select>&nbsp; &nbsp;
    </TD>
    <TD align="center">
    <input id="<?echo $row['Code'] ?>_Lower" name="<?echo $row['Code'] ?>_Lower" value="<? echo $row['Lower1']?>" size=4>
     - 
	<input id="<?echo $row['Code'] ?>_Upper" name="<?echo $row['Code'] ?>_Upper" value="<? echo $row['Upper1']?>" size=4 onchange="document.all['<? echo $row['Code'];?>_Ratio'].innerHTML = document.all['<? echo $row['Code']?>'].value/this.value;">     
    <?// echo $row['Lower']." - ".$row['Upper']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD align=center>
    <SPAN id="<? echo $row['Code']; ?>_Ratio"></SPAN>
    </TD>
    </TR>
    <?
    }
    mysql_free_result($lab_result);
	?>

<?php 
}
 ?>          
</TABLE>
<SCRIPT>
var lab_codes = new Array;

<?
    $lab_result = execute_query($exams_sql);
    for ($i=0; $i<mysql_num_rows($lab_result); $i++)
    {
    	$row = mysql_fetch_assoc($lab_result);
?>
lab_codes['<?echo $row['Code'];?>'] = new Array;
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit1'];?>] = new Array;
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit1'];?>]['Lower'] = '<?echo $row['Lower1'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit1'];?>]['Upper'] = '<?echo $row['Upper1'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit2'];?>] = new Array;
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit2'];?>]['Lower'] = '<?echo $row['Lower2'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit2'];?>]['Upper'] = '<?echo $row['Upper2'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit3'];?>] = new Array;
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit3'];?>]['Lower'] = '<?echo $row['Lower3'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit3'];?>]['Upper'] = '<?echo $row['Upper3'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit4'];?>] = new Array;
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit4'];?>]['Lower'] = '<?echo $row['Lower4'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit4'];?>]['Upper'] = '<?echo $row['Upper4'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit5'];?>] = new Array;
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit5'];?>]['Lower'] = '<?echo $row['Lower5'];?>';
lab_codes['<?echo $row['Code'];?>'][<? echo $row['Unit5'];?>]['Upper'] = '<?echo $row['Upper5'];?>';
<?
	}
?>
	
function SetNormalValues(code, unit)
{
	document.getElementById(code+"_Lower").value = lab_codes[code][unit]['Lower'];
	document.getElementById(code+"_Upper").value = lab_codes[code][unit]['Upper'];
}	
</SCRIPT>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<hr>
<h3><a name="view">Καταχωρημένες Βιοχημικές Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT exams_bioximikes.ExamDate, laboratory_codes.Description, exams_bioximikes.Value, exams_bioximikes.Lower, exams_bioximikes.Upper, units.Unit, exams_bioximikes.Code FROM exams_bioximikes, laboratory_codes, units WHERE laboratory_codes.Code=exams_bioximikes.Code AND exams_bioximikes.Unit=units.ID AND exams_bioximikes.PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=post action='delete_bio_exams.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_bioximikes>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Εξέταση </th>";
    echo "<th class=result> Τιμή </th>";
    echo "<th class=result> Lower </th>";
    echo "<th class=result> Upper </th>";
    echo "<th class=result> Μονάδες </th>";            
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
            for ($i=0; $i < 6; $i++)
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
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>