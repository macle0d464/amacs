<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$posotikes_methods_query = "SELECT * FROM hbv_iologikes_methods WHERE Type=2";
	$poiotikes_methods_query = "SELECT * FROM hbv_iologikes_methods WHERE Type=1";
	$posotikes_methods_result = execute_query($posotikes_methods_query);		
	$posotikes_methods = mysql_num_rows($posotikes_methods_result);
	$poiotikes_methods_result = execute_query($poiotikes_methods_query);		
	$poiotikes_methods = mysql_num_rows($poiotikes_methods_result);	
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ιολογικής Παρακολούθησης στο Κέντρο ασθενούς με HBV συνλοίμωξη</TITLE>
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
	Print_PatientCode_form("hbv_iolog_observe.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hbv_coinfection($_GET['code']);
}
?>

<FORM id="iologikes_form" name="iologikes_form" action="hbv_iologikes_insert.php" method="GET" onsubmit="return check_data(1);">
<? show_patient_data($_GET['code']); ?>
<P>Iολογική εικόνα HBV-DNA
</P>


<input type="hidden" name="exams" value="1<?// echo $_GET['exams']; ?>">

<HR>
<P> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> Ποιοτικός 'Ελεγχος </b></P>

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
    <TD>HBV-DNA</TD>
    <TD>
    <INPUT type=radio name=Result value='' style="display: none" checked>
    <INPUT type=radio name=Result value='1'> Θετικό &nbsp; 
    <INPUT type=radio name=Result value='-1'> Αρνητικό <!--(μη ανιχνεύσιμο)--></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Μέθοδος</TD>
    <TD>
    <select name=Method id=method1><option value="" selected> - Επιλέξτε - </option>
    <? for ($i=0; $i<$poiotikes_methods; $i++)
    {
    	$row = mysql_fetch_array($poiotikes_methods_result);
    	echo "<option value='".$row[0]."'>".$row[1]."</option>";
    } ?>
    </select>
    </TR>
    <tr><td>&nbsp;</td><td></td></tr>
    </TABLE>
<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Εξετάσεων (Ποιοτικού Ελέγχου)"></p>    
    </FORM>

<HR>
<P> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> Ποσοτικός 'Ελεγχος </b></P>    
<FORM id="iologikes_form" name="iologikes_form" action="hbv_iologikes_insert.php" method="GET" onsubmit="return check_data(2);">   
<input type="hidden" name=PatientCode value="<?echo $_GET['code'];?>">
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
    <TD>HBV-DNA</TD>
    <TD>
    <INPUT type=radio name=Result value='' style="display: none" checked>
    <INPUT type=radio name=Result value='1' onclick="show_operator(1);"> Ανιχνεύσιμο &nbsp; 
    <INPUT type=radio name=Result value='-1' onclick="show_operator(2);"> Μη Ανιχνεύσιμο <!--(μη ανιχνεύσιμο)--></TD>
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
    <select name=Units>
    <option value=""> - Επιλέξτε μονάδες -</option>
    <option value="1">copies/ml</option>
    <option value="2">Eq/ml</option>
    <option value="3">Pg/ml</option>
    <option value="4">Meg/ml</option>
    <option value="5">IU/ml</option>
    </select></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Μέθοδος</TD>
    <TD>
    <select name=Method id=method2><option value="" selected> - Επιλέξτε - </option>
    <? 
    $methods_result = execute_query($posotikes_methods_query);		
	$methods = mysql_num_rows($posotikes_methods_result);
    for ($i=0; $i<$methods; $i++)
    {
    	$row = mysql_fetch_array($methods_result);
    	echo "<option value='".$row[0]."'>".$row[1]."</option>";
    } ?>
    </select>
    <tr><td>&nbsp;</td><td></td></tr>
    </TABLE>
<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Εξετάσεων (Ποσοτικού Ελέγχου)"></p>
</FORM>



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
	else if ((("0123456789,.").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}
function numbersonlyfloat(e)
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
	else if ((("0123456789.").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}

function check_data(e)
{
	if (e==1)
	{
		if (document.all['method1'].value == "")
		{
			alert("Πρέπει να επιλέξετε μια μέθοδο!");
			return false;
		}
	}
	else
	{
		if (document.all['Units'].value == "")
		{
			alert("Πρέπει να επιλέξετε τις μονάδες και την μέθοδο!");
			return false;
		}	
		if (document.all['Result'].value == "0")
		{
			alert("Πρέπει να επιλέξετε μια μέθοδο!");
			return false;
		}	
		if (document.all['Value'].value == "")
		{
			alert("Πρέπει να δώσετε μια τιμή για τα επίπεδα ορού!");
			return false;
		}					
		if (document.all['method2'].value == "")
		{
			alert("Πρέπει να επιλέξετε μια μέθοδο!");
			return false;
		}
	}
}
</script>



<hr>
<h3><a name="view">Καταχωρημένες Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT hbv_iologikes.ExamDate, hbv_iologikes.Result, hbv_iologikes.Operator, hbv_iologikes.Value, hbv_iologikes.Units, hbv_iologikes_methods.Method, hbv_iologikes.Method AS method_id FROM hbv_iologikes, hbv_iologikes_methods WHERE hbv_iologikes_methods.ID=hbv_iologikes.Method AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_exams_io.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=hbv_iologikes>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Αποτέλεσμα </th>";
//    echo "<th class=result> Πρόσημο </th>";
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
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ExamDate']."'><input type=hidden name='del_exam_method_".$j."' value='".$resultrow['method_id']."'></td>\n";
			echo "<td class=result>".show_date($resultrow['ExamDate'])."</td>";
			if ($resultrow['Units'] != "")
			{
				if ($resultrow['Result'] == -1)
                {
                	echo "<td class=result>Μη Ανιχνεύσιμο</td>";
                }
                else
                {
                	echo "<td class=result>Ανιχνεύσιμο</td>";
                }				
			}
			else 
			{
				if ($resultrow['Result'] == -1)
                {
                	echo "<td class=result>Αρνητικό</td>";
                }
                else
                {
                	echo "<td class=result>Θετικό</td>";
                }
			}
			echo "<td class=result align=center>&nbsp;".$resultrow['Operator']." ";//."</td>";
			//echo "<td class=result>".
			echo show_dec($resultrow['Value'])."</td>";
            if ($resultrow['Units'] == 1)
            {
            	echo "<td class=result>copies/ml</td>";
            }
            elseif ($resultrow['Units'] == 2)
            {
            	echo "<td class=result>Eq/ml</td>";
            }
            elseif ($resultrow['Units'] == 3)
            {
            	echo "<td class=result>Pg/ml</td>";
            }
            elseif ($resultrow['Units'] == 4)
            {
            	echo "<td class=result>Meg/ml</td>";
            }
            elseif ($resultrow['Units'] == 5)
            {
            	echo "<td class=result>IU/ml</td>";
            }
            else
            {			
				echo "<td class=result>".$resultrow['Units']."</td>";
            }
            echo "<td class=result>".$resultrow['Method']."</td>";
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
