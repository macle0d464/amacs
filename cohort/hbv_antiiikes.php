<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$medicine_query = "SELECT * FROM hbv_medicines";
	
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Θεραπειών για HBV εκτός αντιρετροϊκών</TITLE>
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
	Print_PatientCode_form("hbv_antiiikes.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hbv_coinfection($_GET['code']);
}
?>

<FORM id="antiiikes_form" name="antiiikes_form" action="hbv_antiiikes_insert.php" method="GET" onsubmit="return check_data();">
<? show_patient_data($_GET['code']); ?>
<a href="hbv_show_antiiikes_data.php?code=<? echo $_GET['code']; ?>">
Προβολή Καταχωρημένων Θεραπειών
</a>
<?echo "<input type=hidden name='code' value='".$_GET['code']."' />"; ?>
<P> Συμπληρώστε όλα τα φάρμακα που έχει λάβει ο ασθενής
</P>

<TABLE  width=1050>
<TR>
<TD style="border: 1px solid; background-color: white" valign=top>
	<TABLE>
    <TR>
    <TD class="show" align="center" colspan="2">Φάρμακο</TD>
    <TD class="show" align="center">Δόση φαρμάκου</TD>  
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?php
	$results = execute_query($medicine_query);		
	$num = mysql_num_rows($results);
	for ($i = 0; $i < $num; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$id = $row['ID'];
		$name = $row['Name'];
		$description = $row['Description'];
		$j = $i+1;
?>
	<TR>
 	<TD><b><? echo $name; ?></b><BR><i><u><? echo $description; ?></u></i></TD><TD><input type="checkbox" name="<? echo $name; ?>" value="<? echo $id; ?>"
    onclick="check_meds(this.name);" /></TD>
 	<TD>&nbsp;&nbsp;
 	<input name="dosage1<?echo $id?>" size=2> 
 	<select name="dosage1type<?echo $id?>">
 	<?
 	if ($name == "IFNα") 
 	{
 	?>
    <option value="MU">MU</option>
	<option value="mg">mg</option>
    <?
	}
	else if ($name == "PEG-IFNα-2α")
 	{
 	?>
 	<option value="μg">μg</option>
    <?
	}
	else if ($name == "PEG-IFNα-2b")
 	{
 	?> 	
 	<option value="μg">μg</option>
 	<option value="μg/kg">μg/Kg</option>
    <?
	}
	else
	{
	?>
 	<option value="mg">mg</option>
	<?
	}
 	?> 	
 	</select>
 	/ 
 	<select name="dosage2type<?echo $id?>">
 	<option value="1">1 φορά / εβδ.</option>
 	<option value="2">2 φορές / εβδ.</option>
 	<option value="3">3 φορές / εβδ.</option>
 	<option value="4">4 φορές / εβδ.</option>
 	<option value="5">5 φορές / εβδ.</option>
 	<option value="6">6 φορές / εβδ.</option>
 	<option value="7">Καθημερινά</option>
 	</select>
 	</TD>
	</TR>
<?php }
	mysql_free_result($results); 
?> 
</TABLE>
</TD>
<TD valign=top>
	<TABLE>
		<TR>
			<TD style="border: 1px solid; background-color: white">
				<TABLE>
			    <TR>
 				<TD class="show" align="center">Ημερομηνία Έναρξης</TD>
 				</TR>
				<TR><TD></TD></TR>
				<TR><TD></TD></TR>
				<TR>
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
			    <? print_years_no_unknown(); ?>
			    <option value=""></option>
				</select>
				</TD>
				</TR>
				</TABLE>
			</TD>
			<TD style="border: 1px solid; background-color: white">
				<TABLE>
				<TR>
			    <TD class="show" align="center">Ημερομηνία Διακοπής </TD>
				</TR>
				<TR><TD></TD></TR>
				<TR><TD></TD></TR>
				<TR>
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
			    <? print_years_no_unknown(); ?>
			    <option value=""></option>
				</select> </TD>
				</TR>
				</TABLE>
			</TD>
		</TR>
		<TR>
			<TD align=center style="border: 1px solid; background-color: white" colspan=2>
			<?
				$i=0;
				$dates[$i] = "now";
				include('antapokriseis_insert.php');
			?>
			</TD>
		</TR>
		<TR>
			<TD colspan=2 style="border: 1px solid; background-color: white">
				<TABLE>
				<TR>
				<TD>
				<b>Ολοκλήρωση Θεραπείας: &nbsp; </b>
			    </TD>
				<TD>
				<select name=Info1>
			    <option value="" selected>-</option>
			    <option value="1">ΝΑΙ</option>
			    <option value="2">ΟΧΙ</option>
			    </select>
				</TD>
				</TR>
				<TR>
				<TD>
				<b>Αιτία διακοπής: </b>
			    </TD>
				<TD>
			    <select name=Info2>
			    <option value="" selected>-</option>
				<?
					$reasons_query = "SELECT * FROM hbv_reasons";
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
				</TD>
				</TR>
				<TR>
				<TD>
				<b>Σημειώσεις: </b>
				</TD>
				<TD>
				<textarea name=Note STYLE="overflow:hidden; width:450px; height: 50px"></textarea>
				</TD>
				</TR>
				</TABLE>
			</TD>
		</TR>

	</TABLE>
</TD>
</TR>
</TABLE>

<?php
	$result = execute_query("SELECT MAX(link_id) FROM `hbv_antiiikes_treatments`");
	$row = mysql_fetch_array($result);
	$link_id = $row[0];
	echo "<input type='hidden' name='link_id' value='$link_id'>";
	mysql_free_result($result); 
?>
<BR>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
<INPUT TYPE="reset" VALUE="Καθαρισμός">
</FORM>
<script>
function check_meds(med)
{
	if (med == "IFNα")
	{
		document.all['PEG-IFNα-2α'].checked = false;
		document.all['PEG-IFNα-2b'].checked = false;
	}
	else if (med == "PEG-IFNα-2α")
	{
		document.all['IFNα'].checked = false;
		document.all['PEG-IFNα-2b'].checked = false;
	}
	else if (med == "PEG-IFNα-2b")
	{
		document.all['PEG-IFNα-2α'].checked = false;
		document.all['IFNα'].checked = false;		
	}
	
}
</script>
<script>
function check_data()
{
	if ((document.all.Bioximiki_end.value == "0") && (document.all.Bioximiki_longterm.value == "1"))
	{
		ok_to_proceed = confirm("Προσοχή! 'Εχετε συμπληρώσει ότι ο ασθενής δεν έχει βιοχημική ανταπόκριση στο τέλος της θεραπείας αλλά έχει μακροχρόνια βιοχημική ανταπόκριση. Αποθήκευση Δεδομένων;");
		if (!ok_to_proceed)
		{
			return false;
		}		
	}
/*	if ((document.all.Iologiki_end.value == "0") && (document.all.Iologiki_longterm.value == "1"))
	{
		ok_to_proceed2 = confirm("Προσοχή! 'Εχετε συμπληρώσει ότι ο ασθενής δεν έχει ιολογική ανταπόκριση στο τέλος της θεραπείας αλλά έχει μακροχρόνια ιολογική ανταπόκριση. Αποθήκευση Δεδομένων;");
		if (!ok_to_proceed2)
		{
			return false;
		}		
	} */
	if ((document.all.Info1.value == "") && (document.all.EndDate_year.value != ""))
	{
		alert("Πρέπει να συμπληρώσετε το πεδίο Ολοκλήρωση Θεραπείας!");
		return false;
	}	
	if ((document.all.Info1.value == "2") && (document.all.Info2.value == ""))
	{
		alert("Πρέπει να συμπληρώσετε το πεδίο Αιτία Διακοπής!");
		return false;
	}
	if (document.all.EndDate_year.value != "")
	{
		var EndDate=new Date();
		if (document.all.EndDate_month.value == "")
		{
			EndDate.setFullYear(document.all.EndDate_year.value, 06, 01);
		}
		else
		{
			if (document.all.EndDate_day.value == "")
			{
				EndDate.setFullYear(document.all.EndDate_year.value, document.all.EndDate_month.value-1, 15);
			}
			else
			{
				EndDate.setFullYear(document.all.EndDate_year.value, document.all.EndDate_month.value-1, document.all.EndDate_day.value);
			}
		}
		EndDate.setDate(EndDate.getDate() + 365);
		Today = new Date();
		if (Today > EndDate)
		{
			if (document.all.Bioximiki_longterm.value == "-1")
			{
				alert("Πρέπει να συμπληρώσετε το πεδίο Μακροχρόνια Βιοχημική Ανταπόκριση!");
				return false;
			}
			if (document.all.io_longterm.value == "")
			{
				alert("Πρέπει να συμπληρώσετε το πεδίο Μακροχρόνια Ιολογική Ανταπόκριση!");
				return false;
			}
		}
	}

}
</script>
<script>
document.all.dosage2type1.value = 3;
document.all.dosage2type2.value = 7;
document.all.dosage2type5.value = 7;
</script>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>