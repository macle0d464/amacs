<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$methods_query = "SELECT * FROM hbv_iologikes_methods";
	$methods_result = execute_query($methods_query);
	$methods = mysql_num_rows($methods_result);
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ιολογικής Παρακολούθησης στο Κέντρο ασθενούς με HBV συνλοίμωξη</TITLE>
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
	Print_PatientCode_form("hcv_iolog_observe.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hcv_coinfection($_GET['code']);
}
?>

<FORM id="hcv_orolog_observe_form" name="hcv_orolog_observe_form" action="hcv_iologikes_insert.php" method="GET">
<? show_patient_data($_GET['code']); ?>

    <TABLE width=500>
	<TR>
    <TD>Ημερομηνία Εξέτασης
    </TD>
    <TD>Ημέρα: <select name=ExamDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=ExamDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=ExamDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>HCV-RNA</TD>
    <TD>
    <INPUT type=radio name=Result value='1' onclick="show_operator(1);"> Θετικό &nbsp; 
    <INPUT type=radio name=Result value='-1' onclick="show_operator(2);"> Αρνητικό <!--(μη ανιχνεύσιμο)--></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Επίπεδα ορού</TD>
    <TD>
    <select name=Operator1 style="display: none">
    <option value="<" selected>&lt;</option>
    </select>
    <select name=Operator2 style="display: none">
    <option value="=">=</option>
	<option value=">">&gt;</option>
    </select>
    <INPUT class=input name=Value onkeypress="return numbersonly(event);"> &nbsp; 
    <select name=units>
    <option>copies/ml</option>
    </select></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Μέθοδος</TD>
    <TD>
    <select name=Method><option value="" selected> - Επιλέξτε - </option>
    <? for ($i=0; $i<$methods; $i++)
    {
    	$row = mysql_fetch_array($methods_result);
    	echo "<option value='".$row[0]."'>".$row[1]."</option>";
    } ?>
    </select>
    </TR>
    <tr><td>&nbsp;</td><td></td></tr>
    </TABLE>

<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<hr>
<h3><a name="view">Καταχωρημένες Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT hcv_iologikes.ExamDate, hcv_iologikes.Result, hcv_iologikes.Operator, hcv_iologikes.Value, hcv_iologikes_methods.Method FROM hcv_iologikes, hcv_iologikes_methods WHERE hcv_iologikes_methods.ID=hcv_iologikes.Method AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_exams.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=hcv_iologikes>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Αποτέλεσμα </th>";
    echo "<th class=result> Πρόσημο </th>";
    echo "<th class=result> Επίπεδα Ορού </th>";
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
            for ($i=0; $i < 5; $i++)
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
</HTML>
<? 	mysql_close($dbconnection); ?>