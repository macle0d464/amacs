<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$methods_query = "SELECT * FROM iologikes_methods";
	$methods_result = execute_query($methods_query);		
	$methods = mysql_num_rows($methods_result);
	$subtype_query = "SELECT HIVSubtype FROM hiv_subtype WHERE PatientCode=".$_GET['code'];
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ιολογικών Εξετάσεων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<BODY bgcolor="FFCCFF">

<? 
if (isset($_GET['error']))
{
	echo "<center><table><tr><td class='errormsg'>" . $_GET['error'] . "</td></tr></table></center><br>";
}
?>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("iologikes.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="iologikes_form" name="iologikes_form" action="iologikes_insert.php" method="GET">

<P>18. Μέτρηση ιϊκού φορτίου HIV-RNA (copies/ml) (από 1/1/1996)
</P>

<input type="hidden" name="exams" value="1<?// echo $_GET['exams']; ?>">

<TABLE width="900">
    <TR>
    <TD><? show_patient_data($_GET['code']); ?>
<a href="#view">Προβολή Εξετάσεων Ασθενή</a>
<a name="top"></a>    
    </TD><TD></TD>
    <TD>
    </TD>
    <TD></TD><TD></TD>
    </TR></TABLE>
    <TABLE>
    </TR>
    <TR>
    <TD></TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     Ημερομηνία</TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Αποτέλεσμα </TD>
    <TD class="show" align="center">Τιμή</TD>
    <TD class="show" align="center">Μονάδες</TD>
    <TD class="show" align="center">Μέθοδος </TD> 
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?php
for ($k=0; $k< 1; $k++)
{ 
	$i=$k+1;
	?>
	<TR>
 	<TD class="show"><?echo $i?>η</TD>
 	<TD>&nbsp;&nbsp;
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
    <? print_years(); ?></TD>
    <TD> &nbsp;&nbsp; <INPUT TYPE="radio" value="1" name=Result<?echo $k?> onclick="show_operator(1);"> Θετικό 
    <INPUT TYPE="radio" value="-1" name=Result<?echo $k?> onclick="show_operator(2);"> Αρνητικό</TD>
    <TD>&nbsp;&nbsp; 
    <select name=Operator1 style="display: none">
    <option value="<" selected>&lt;</option>
    </select>
    <select name=Operator2 style="display: none">
    <option value="=">=</option>
	<option value=">">&gt;</option>
    </select>
     <INPUT TYPE="text" size=20 name=Value<?echo $k?> onkeypress="return numbersonly(event);"></TD>
     <TD>&nbsp; <select name=Units>
     <option value=10>copies/ml</option>
     <option value=11>IU/ml</option>
     <option value=12>geq/ml</option>
     </select></TD>
    <TD>&nbsp; <select name=Method<?echo $k?>><option value="" selected> - Επιλέξτε - </option>
    <? for ($i=0; $i<$methods; $i++)
    {
    	$row = mysql_fetch_array($methods_result);
    	echo "<option value='".$row[0]."'>".$row[1]."</option>";
    } ?>
    </select>
    <img src="./images/b_help.png" style="cursor: hand" onclick="window.open('./iolog_method.php?field=Method<?echo $k?>', '', 'width=450,height=300,status=yes');"/>
    </TD>
	</TR>
<?php } ?> 
</TABLE>
<script>
function show_operator(id)
{
	if (id == 2)
	{
		document.all['Operator1'].style.display = "";
		document.all['Operator2'].style.display = "none";
	}
	if (id == 1)
	{
		document.all['Operator1'].style.display = "none";
		document.all['Operator2'].style.display = "";
	}
}
function numbersonly(e)
{
	var key;
	var keychar;
	if (window.event)
	{
		key = window.event.keyCode;
	}
	else if (e)
	{
		key = e.which;
	}
	else
	{
		return true;
	}
	keychar = String.fromCharCode(key);
	// control keys
	if ((key==null) || (key==0) || (key==8) || (key==9) || (key==13) || (key==27))
	{
		return true;
	}
	// numbers
	else if ((("0123456789").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}
</script>
<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Εξετάσεων"></p>
</FORM>

<!--
<?
$result = execute_query($subtype_query);
$row = mysql_fetch_assoc($result);
mysql_free_result($result);
if ($row['HIVSubtype'] == "")
{
?>
<form name="hiv_subtype_form" action="hiv_subtype_insert" method="GET">
<input type=hidden name=PatientCode value="<? echo $_GET['code'] ?>">
<p>&nbsp;</p>
<p>Γνωρίζετε τον HIV υπότυπο του ασθενή; &nbsp;
<select name="know" onchange="toggle(this.value);">
<option value="0">'Οχι</option>
<option value="1">Ναι</option>
</select>
</p>
<div id="extra" style="display: none">
<p> Υπότυπος: 
 <select name="HIVSubtype">
 <option value=""></option>
 <option value="A">A</option>
 <option value="B">B</option>
 <option value="C">C</option>
 <option value="D">D</option>
 <option value="F">F</option>
 <option value="G">G</option>
 <option value="H">H</option>
 <option value="J">J</option>
 <option value="K">K</option>
 <option value="U">U</option>
 <option value="CRF01">CRF01</option>
 <option value="CRF02">CRF02</option>
 <option value="CRF03">CRF03</option>
 <option value="CRF04">CRF04</option>
 <option value="CRF05">CRF05</option>
 <option value="CRF06">CRF06</option>
 <option value="CRF07">CRF07</option>
 <option value="CRF08">CRF08</option>
 <option value="CRF09">CRF09</option>
 <option value="CRF10">CRF10</option>
 <option value="CRF11">CRF11</option>
 <option value="CRF12">CRF12</option>
 <option value="CRF13">CRF13</option>
 <option value="CRF14">CRF14</option>
 </select>
 &nbsp;&nbsp; <b>ή</b> &nbsp;&nbsp; Συνδυασμός: <input name=HIVSubtype_combination>
</p></div>
<script>
function toggle(id)
{
	if (id == 1)
	{
		document.all['extra'].style.display = "";
	}
	else
	{
		document.all['extra'].style.display = "none";
	}
}
</script>
<input type="submit" value="Αποθήκευση Υποτύπου">
</form>
<?
}
?>
-->

<hr>
<h3><a name="view">Καταχωρημένες Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT exams_iologikes.ExamDate, exams_iologikes.Result, exams_iologikes.Operator, exams_iologikes.Value, units.Unit, iologikes_methods.Method, exams_iologikes.Units FROM exams_iologikes, iologikes_methods, units WHERE iologikes_methods.ID=exams_iologikes.Method AND units.ID=exams_iologikes.Units AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_exams.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=exams_iologikes>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Αποτέλεσμα </th>";
    echo "<th class=result> Πρόσημο </th>";
    echo "<th class=result> Επίπεδα Ορού </th>";
    echo "<th class=result> Μονάδες </th>";
    echo "<th class=result> Μέθοδος </th>";            
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ExamDate']."'></td>\n";
            for ($i=0; $i < 6; $i++)
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name == "Result")
                {
                	if ($resultrow[$field->name] == -1)
                	{
                		echo "<td class=result>Αρνητικό</td>";
                	}
                	else
                	{
                		echo "<td class=result>Θετικό</td>";
                	}
                }
                else 
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
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