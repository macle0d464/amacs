<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$categories_query = "SELECT * FROM medicines_categories";
	$medicine_query = "SELECT medicines.ID,medicines.Name,medicines.Description as Description, medicines_categories.Description as desc2 FROM ";
	$medicine_query .= "medicines,medicines_categories WHERE medicines.Category=medicines_categories.ID ORDER BY medicines.Category, medicines.ATCCode ASC";
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Αντιρετροϊκών Θεραπείων</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
<script>
function disable(element)
{
	element += "_year";
	alert(element);
	document.all.StartDate1_year.value=2000;
}
</script>
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
	Print_PatientCode_form("antiretro.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="antiretro_form" name="antiretro_form" action="antiretro_insert.php" method="GET" onsubmit="return checkdata();">
<? show_patient_data($_GET['code']); ?>
<a href="show_antiretro_data.php?code=<? echo $_GET['code']; ?>">
Προβολή Καταχωρημένων Θεραπειών
</a>
<?echo "<input type=hidden name='code' value='".$_GET['code']."' />"; ?>
<P> Συμπληρώστε όλα τα φάρμακα που έχει λάβει ο ασθενής
</P>

    <TABLE width=1000>
<!--    <TR>
    <TD class="show" colspan="2"></TD>
    <TD class="show" align="center">Ημερομηνία Έναρξης</TD>
    <TD class="show" align="center">Ημερομηνία Διακοπής </TD>
     <TD class="show" align="center"></TD>   --> 
    <TR>
	<td>
	<table border=1>
<!--    <TR><TD class="show" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>Νουκλεοσιδικά ανάλογα (NRTI)</u></TD><TD></TD><TD></TD></TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR> -->
<?php
	$results = execute_query($medicine_query);		
	$num = mysql_num_rows($results);
	$description2 = "";
	for ($i = 0; $i < $num; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$id = $row['ID'];
		$name = $row['Name'];
		$description = $row['Description'];
		$description3 = $row['desc2'];
//		print_r($row); die;
		$j = $i+1;
  		if ($description2 != $description3)
		{
			$description2 = $description3
?>
    <TR><TD class="show" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u><? echo $description2; ?></u></TD><TD></TD><TD></TD></TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?
		}
		
/*
  		if ($i == 14)
		{
?>
    <TR><TD class="show" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>Μη νουκλεοσιδικά ανάλογα (ΝNRTI)</u></TD><TD></TD><TD></TD></TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?
		}
		if ($i == 19)
		{
?>
    <TR><TD class="show" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>Αναστολείς πρωτεάσης (PI)</u></TD><TD></TD><TD></TD></TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?
		}		
		if ($i == 30)
		{
?>
    <TR><TD class="show" colspan="2"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>'Αλλη κατηγορία</u></TD><TD></TD><TD></TD></TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?
		}			
*/
?>
<TR>
 	<TD><b><? echo $name; ?></b><BR><i><u><? echo $description; ?></u></i></TD><TD><input type="checkbox" name="<? echo $name; ?>" value="<? echo $id; ?>" /></TD>
</tr>
<?php }
	mysql_free_result($results); ?> 
</table>
</td>
<td valign=top>
<table>
	<tr>
	<td><b>Ημερομηνία 'Εναρξης</b></td>
	</tr>
	<tr>
	<td><b></b></td>
	</tr>	
	<tr>
 	<TD align="center">Ημέρα: <select name="StartDate_day">
 	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name="StartDate_month">
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name="StartDate_year">
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select>
	</TD>
	</tr>
	<tr>
	<td><b>&nbsp;</b></td>
	</tr>	
	<tr>
	<td><b>Ημερομηνία Διακοπής</b></td>
	</tr>
	<tr>
	<td><b></b></td>
	</tr>	
	<tr>	
    <TD align="center">Ημέρα: <select name="EndDate_day">
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name="EndDate_month">
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name="EndDate_year">
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select> </TD>
	</TR>
	<tr>
	<td><b>&nbsp;</b></td>
	</tr>	
	<tr>
	<td><b>Συμμόρφωση</b></td>
	</tr>
	<tr>
	<td><b></b></td>
	</tr>	
	<tr>
    <td>
	<input type=radio name='comp' value='-1' checked> 'Αγνωστη 
	<input type=radio name='comp' value='1'> Κακή 
	<input type=radio name='comp' value='2'> Μέτρια 
	<input type=radio name='comp' value='3'> Καλή
	</TD>		
	</tr>
	<tr>
	<td><b>&nbsp;</b></td>
	</tr>	
	<tr>
	<td><b>Αιτία διακοπής 1</b></td>
	</tr>
	<tr>
	<td><b></b></td>
	</tr>	
	<tr>
	<td>
    <select name=Reason1>
	<option value="" selected>- Επιλέξτε -</option>
				<?
					$reasons_query = "SELECT * FROM antiretro_reasons";
					$reason_result = execute_query($reasons_query);		
					$reasons = mysql_num_rows($reason_result);
					for ($r=0; $r<$reasons; $r++)
					{
						$row = mysql_fetch_array($reason_result);
			    		echo "<option value='".$row[0]."'>".$row[1]."</option>\n";
				    }
					mysql_free_result($reason_result);
				?>
	</select>		
	</td>
	</tr>	
	<tr>
	<td><b>&nbsp;</b></td>
	</tr>	
	<tr>
	<td><b>Αιτία διακοπής 2</b></td>
	</tr>
	<tr>
	<td>
    <select name=Reason2>
	<option value="" selected>- Επιλέξτε -</option>
				<?
					$reasons_query = "SELECT * FROM antiretro_reasons";
					$reason_result = execute_query($reasons_query);		
					$reasons = mysql_num_rows($reason_result);
					for ($r=0; $r<$reasons; $r++)
					{
						$row = mysql_fetch_array($reason_result);
			    		echo "<option value='".$row[0]."'>".$row[1]."</option>\n";
				    }
					mysql_free_result($reason_result);
				?>
	</select>		
	</td>
	<tr>
	<td><b>&nbsp;</b></td>
	</tr>	
	<tr>
	<td><b>Σημειώσεις</b></td>
	</tr>
	<tr>
	<td><b></b></td>
	</tr>	
	<tr><td><textarea name=Notes STYLE="overflow:hidden; width:450px; height: 100px"></textarea></td></tr>	
</TABLE>
</td>
</tr>
</table>

<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
<INPUT TYPE="reset" VALUE="Καθαρισμός">
</FORM>
<script>
function checkdata()
{
	if ((document.all['EndDate_year'].value != "") && (document.all['Reason1'].value == ""))
	{
		alert("Πρέπει να δώσετε τουλάχιστον μια αιτία διακοπής!");
		return false;
	}
}	
	
function start_date_toggle(id)
{
	if (document.all['StartDate'+id+'_year'].disabled)
	{
		document.all['StartDate'+id+'_year'].disabled = false;
		document.all['StartDate'+id+'_year'].value = "";
	}
	else
	{
		document.all['StartDate'+id+'_year'].value="";
		document.all['StartDate'+id+'_year'].disabled = true;
	}
}

function end_date_toggle(id)
{
	if (document.all['EndDate'+id+'_year'].disabled)
	{
		document.all['EndDate'+id+'_year'].disabled = false;
		document.all['EndDate'+id+'_year'].value = "";
	}
	else if (document.all['EndDate'+id+'_year'].disabled)
	{
		document.all['EndDate'+id+'_year'].value="";
		document.all['EndDate'+id+'_year'].disabled = true;
	}
}
</script>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>