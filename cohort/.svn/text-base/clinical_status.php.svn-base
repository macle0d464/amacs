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
<TITLE>Στάδιο Νόσου Ασθενή</TITLE>
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

if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("clinical_status.php");
	die();
}
else
{
	check_patient($_GET['code']);
/*	$has_status = "SELECT LEFT(Status, 1), LEFT(StatusChange1, 1), LEFT(StatusChange2, 1) FROM aids_clinical_status WHERE Patientcode=".$_GET['code'];
	$status_result = execute_query($has_status);
	if (mysql_num_rows($status_result) == 0)
	{
?>

<FORM action="clinical_status_insert.php" method="GET">
<input type="hidden" name="code" value="<? echo $_GET['code'] ?>">
<table>
<th colspan=3 align=center>
Για τον ασθενή <? echo $_GET['code'] ?> δεν έχει υπάρχει καταχωρημένη κάποια κλινική κατάσταση
</th>
<tr><td></td></tr>
<tr>
<td>Δώστε την κλινική κατάσταση του ασθενή <? echo $_GET['code'] ?> </td>
<td> &nbsp;
<SELECT name=Status>
<OPTION VALUE="A">Κατάσταση A</OPTION>
<OPTION VALUE="B">Κατάσταση B</OPTION>
<OPTION VALUE="C">Κατάσταση C</OPTION>
</SELECT>
</td>
<td></td>
</tr>
<tr>
<td>Ημερομηνία εμφάνισης της παραπάνω κατάστασης</td>
<td> &nbsp;
    Ημέρα: 
    <select name=StatusDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StatusDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StatusDate_year>
	<option value=""></option>
    <? print_years();?>
	</select>

</td>
<td></td>
</tr>
<tr><td></td></tr>
<tr>
<td>Δώστε τo Ναδίρ των CD4 του ασθενή <? echo $_GET['code'] ?> (αν το γνωρίζετε)</td>
<td> &nbsp;
<!--
<SELECT name=CD4Status>
<OPTION VALUE="">'Αγνωστο</OPTION>
<OPTION VALUE="1">Κατάσταση 1 (CD4 >= 500 μL)</OPTION>
<OPTION VALUE="2">Κατάσταση 2 (200 =< CD4 < 500 μL)</OPTION>
<OPTION VALUE="3">Κατάσταση 3 (CD4 < 200 μL)</OPTION>
</SELECT>
-->
<input name=CD4Status size="9"> &nbsp; μL
</td>
<td></td>
</tr>
<tr>
<td>&nbsp; <input type=submit value="Καταχώρηση"></td>
<td></td><td></td>
</tr>
</table>
</FORM>

<P>'Οπου:</P>
<UL>
<LI>Κατηγορία Α: &nbsp; Ασυμπτωτική, οξεία (προτωγενής) HIV λοίμωξη ή Επιμένουσα Γενικευμένη Λεμφαδενοπάθεια</LI>
<LI>Κατηγορία B: &nbsp; Συμπτωματική HIV λοίμωξη</LI>
<LI>Κατηγορία C: &nbsp; Καθοριστικοί Νόσοι AIDS</LI>
</UL>

<? 		
	exit;
	}
	if (!isset($_GET['showcat']))
	{
		$status = mysql_fetch_array($status_result);
		if ($status[2] <> "")
		{ $category = $status[2]; }
		else if ($status[1] <> "")
		{ $category = $status[1]; }
		else
		{ $category = $status[0]; }
		mysql_free_result($status_result);
	}
	else { $category = $_GET['showcat']; }
?>

<? if ($category == "A" || $category == "B") 
	{ ?>
<form action="change_clinical_status.php">
<input type="hidden" name="code" value="<? echo $_GET['code'] ?>">
<input type="hidden" name="category" value="<? echo $category ?>">
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<b>Ασθενής: <? echo $_GET['code'] ?>, Κατάσταση: <? echo $category ?> 
&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value="Αλλαγή Κλινικής κατάστασης" />
</form> 
</b></p>
<? 	} 
   else
    { ?>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<b>Ασθενής: <? echo $_GET['code'] ?>, Κατάσταση: <? echo $category ?> 
</b></p>
<?    } */?>
<p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
<b>Ασθενής: <? echo $_GET['code'] ?>, Κατάσταση: <span id="status"></span> 
</b></p>
<BR>

<FORM id="clinical_status_form" name="clinical_status_form" action="clinical_status_insert.php" method="GET" onsubmit="return check_data();">
<input type="hidden" name="code" value="<? echo $_GET['code'] ?>">
<input type="hidden" name="category" value="<? echo $category ?>">
<input type="hidden" name="num_nosoi_reappear" value="1">
<input type="hidden" name="num_syndrom_reappear" value="1">

<DIV style="width: 1000px;">
<?php
	$c_entry_query = "SELECT nosos_sundrom_description.ID as id, nosos_sundrom_description.Description as syndrom, patients_category_c.Diagnosis as diagnosis, patients_category_c.NososSyndromDate as date FROM patients_category_c,nosos_sundrom_description WHERE patients_category_c.NososSyndrom = nosos_sundrom_description.ID AND PatientCode=".$_GET['code']; // ." GROUP BY clinical_symptoms_descriptions.ID";
	$results = execute_query($c_entry_query);
	$num = mysql_num_rows($results);
	if ($num <> 0)
	{
		echo "<input type=hidden name='syndr' value='".$num."'>";
		echo "<table width='100%'>\n";
		echo "<th align=center>Διαγραφή</th><th align=center>Νόσοι ή Σύνδρομα που προσδιορίζουν το AIDS <font color=red>(Κατάσταση C)</font></th><th align=center>Διάγνωση</th><th align=center>Ημερομηνία</th>";
		for ($i=0; $i< $num; $i++)
		{
			$row = mysql_fetch_assoc($results);
			echo "<tr>\n";
			echo "<td align=center><input type=checkbox name='del_syndr_sw_".$i."'><input type=hidden name='del_syndr_id_".$i."' value='".$row['id']."'></td>\n";
			echo "<td>".$row['syndrom']."</td>\n";
			if ($row['diagnosis'] == "1")
			{
				echo "<td align=center>Καθοριστική</td>\n";
			}
			elseif ($row['diagnosis'] == "2")
			{
				echo "<td align=center>Πιθανολογούμενη</td>\n";
			}
			elseif ($row['diagnosis'] == "3")
			{
				echo "<td align=center>Από Νεκροτομή</td>\n";
			}
//			else
//			{
//				echo "<td align=center>Από Μητρώο</td>\n";
//			}
			echo "<td align=center>".show_date($row['date'])."<input type=hidden name='del_syndr_date_".$i."' value='".$row['date']."'></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
		$is_c = true;
	}	
	mysql_free_result($results);

	$b_entry_query = "SELECT clinical_symptoms_descriptions.ID as id, clinical_symptoms_descriptions.Description as symptom, patients_category_b.ClinicSymptomDate as date FROM patients_category_b,clinical_symptoms_descriptions WHERE patients_category_b.ClinicSymptom = clinical_symptoms_descriptions.ID AND PatientCode=".$_GET['code']; // ." GROUP BY clinical_symptoms_descriptions.ID";
	$results = execute_query($b_entry_query);
	$num = mysql_num_rows($results);
	if ($num <> 0)
	{
		echo "<input type=hidden name='sympt' value='".$num."'>";
		echo "<table width='100%'>\n";
		echo "<th align=center>Διαγραφή</th><th align=center>Κλινικά Συμπτώματα <font color=red>(Κατάσταση Β)</font></th><th align=center>Ημερομηνία</th>";
		for ($i=0; $i< $num; $i++)
		{
			$row = mysql_fetch_assoc($results);
			echo "<tr>\n";
			echo "<td align=center><input type=checkbox name='del_sympt_sw_".$i."'><input type=hidden name='del_sympt_id_".$i."' value='".$row['id']."'></td>\n";
			echo "<td>".$row['symptom']."</td>\n";
			echo "<td align=center>".show_date($row['date'])."<input type=hidden name='del_sympt_date_".$i."' value='".$row['date']."'></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
		$is_b = true;
	}
	mysql_free_result($results);

?>
</DIV>
<? 
	$query = "SELECT * FROM patients_category_a WHERE PatientCode=".$_GET['code'];
	$result = execute_query($query);
	$has_entry = mysql_num_rows($result);
	$row = mysql_fetch_assoc($result);
	mysql_free_result($result);
	if ($has_entry) 
	{
		echo "<input type='hidden' name='hasentry' value='1'>";
	}
?>
<HR>
<TABLE width=1000>
    <TR>
    <TD colspan="3" class="show" align=center><u>
    Συμπληρώστε τις νόσους/σύνδρομα που έχει παρουσιάσει ο ασθενής <font color="red">(Κατάσταση C)</font>
    </u></TD>
    </TR>
    <TR>
    <TD class="show"> Νόσοι ή Σύνδρομα που προσδιορίζουν το AIDS
    </TD><TD>
    <select name="category_c">
    <option value=""> - Επιλέξτε - </option>
<?php    
    $category_c = "SELECT * FROM nosos_sundrom_description";
    $result = execute_query($category_c);
    echo mysql_error();
    for ($i = 0; $i < mysql_num_rows($result); $i++)
    {
    	$j = $i+1;
    	$row = mysql_fetch_array($result);
    	echo "<option value='{$row[0]}'>{$row[1]}</option>";
    }
?>
	</select>
    </TD>
    </tr>
    <tr>
    <td>
    <b>Διάγνωση:</b>
    </td><td>
    <INPUT type=radio name=Diagnosis value="1">	<b>Καθοριστική</b> &nbsp; <INPUT type=radio name=Diagnosis value="2">
 	<b>Πιθανολογούμενη</b> &nbsp; <INPUT type=radio name=Diagnosis value="3">	<b>Από Νεκροτομή</b>
 	&nbsp; <!-- <INPUT type=radio name=Diagnosis value="4">	<b>Από Μητρώο (from registry)</b>-->
	</td>
    </tr>
    <tr>
    <TD class="show">Ημερομηνία διάγνωσης
    </td><td>
    Ημέρα: 
    <select name=CDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=CDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=CDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select>
	</TD>
    </TR>
	</table>
<BR>
<HR>
<TABLE width=1000>
    <TR>
    <TD colspan="3" class="show" align=center><u>
    Συμπληρώστε τα κλινικά συμπτώματα που έχει περουσιάσει ο ασθενής <font color="red">(Κατάσταση Β)</font>
    </u></TD>
    </TR>
    <TR>
    <TD class="show"> Κλινικά Συμπτώματα
    </TD><TD>
    <select name="category_b">
    <option value=""> - Επιλέξτε - </option>
<?php    
    $category_b = "SELECT * FROM clinical_symptoms_descriptions";
    $result = execute_query($category_b);
    echo mysql_error();
    for ($i = 0; $i < mysql_num_rows($result); $i++)
    {
    	$j = $i+1;
    	$row = mysql_fetch_array($result);
    	echo "<option value='{$row[0]}'>{$row[1]}</option>";
    }
?>
	</select>
    </TD>
    </tr>
    <tr>
    <TD class="show">Ημερομηνία διάγνωσης
    </td><td>
        Ημέρα: 
    <select name=BDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=BDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=BDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select>
	</TD>
    </TR>
	</table>
<BR>
<HR>
<?
$query = "SELECT * FROM patients_category_a WHERE PatientCode=".$_GET['code'];
$result = execute_query($query);
$has_entry = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
mysql_free_result($result);
if ($has_entry) 
{
	echo "<input type='hidden' name='hasentry' value='1'>";
	$is_a = true;
}
?>


<TABLE width=1000>
    <TR>
    <TD colspan="3" class="show" align=center><u>
Σημειώστε όλες τις καταστάσεις που έχει παρουσιάσει ο ασθενής <font color="red">(Κατάσταση Α)</font>
   </u></TD>
    </TR>
    <TR>
    <TD>
<UL>
    <LI>
    <INPUT type=checkbox value=1 name=Asymptotic 
	<? if ($has_entry && $row['Asymptotic'] == 1) {echo "checked";} ?> >
    Ασυμπτωματική 
    </LI>
    <LI><INPUT type=checkbox value=1 name=Lemfadenopatheia
	<? if ($has_entry && $row['Lemfadenopatheia'] == 1) {echo "checked";} ?> >
    Επιμένουσα λεμφαδενοπάθεια</LI>
    <LI><INPUT type=checkbox value=1 name=Protoloimoksi
	<? if ($has_entry && $row['Protoloimoksi'] == 1) {echo "checked";} ?> >
    Πρωτολοίμωξη</LI>
</UL>
	</TD>
    </TR>
	</table>
	<HR>
<?
}
?>

<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων"></p>
</FORM>
<script>
<?
if ($is_c)
{
	echo "document.all.status.innerHTML='C';\n";
}
else if ($is_b)
{
	echo "document.all.status.innerHTML='B';\n";
}
else if ($is_a)
{
	echo "document.all.status.innerHTML='A';\n";
}
else
{
	echo "document.all.status.innerHTML='-';\n";
}
?>

function check_data()
{
//	alert(document.all['Diagnosis'].selected);
/*	if (document.all.category_c.value != "")
	{
		if (document.all['Diagnosis'].value != 1)
		{
			alert("Πρέπει να επιλέξετε μια διάγνωση!")
			return false;
		}
	}
	*/
} 
</script>

</BODY>
</HTML>
<?

mysql_close($dbconnection); ?>