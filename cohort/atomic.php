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
	
	$neoplasma_array = array();
	$neoplasma_array["Z01"] = "Κακοήθεια αναπνευστικού συστήματος (πνεύμονας)";
	$neoplasma_array["Z02"] = "Κακοήθεια αναπνευστικού συστήματος (αυτιά/μύτη/λαιμός)";
	$neoplasma_array["Z03"] = "Κακοήθεια αναπνευστικού συστήματος (υπεζωκότας)";	
	$neoplasma_array["Z04"] = "Ηπατοκαρκίνωμα";
	$neoplasma_array["Z05"] = "Κακοήθεια πεπτικού συστήματος (πάγκρεας)";
	$neoplasma_array["Z06"] = "Κακοήθεια πεπτικού συστήματος (έντερο)";	
	$neoplasma_array["Z07"] = "Κακοήθεια πεπτικού συστήματος (στομάχι)";	
	$neoplasma_array["Z08"] = "Κακοήθεια πεπτικού συστήματος (οισοφάγος)";
	$neoplasma_array["Z09"] = "Καρκίνωμα πρωκτού";
	$neoplasma_array["Z10"] = "Καρκίνωμα μαστού";
	$neoplasma_array["Z11"] = "Κακοήθεια Κεντρικού Νευρικού Συστήματος";
	$neoplasma_array["Z12"] = "Hodgkin λέμφωμα";
	$neoplasma_array["Z13"] = "Μη-Hodgkin λέμφωμα (εφόσον δεν ανήκει σε AIDS def. events)";
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Κλινικής Κατάστασης Ασθενούς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
<style type="text/css">

td.errormsg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold; background-color: white; color: red
}
td.show {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
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
	Print_PatientCode_form("atomic.php");
	die();
}
else
{
	check_patient($_GET['code']);
	$fixed_query = "SELECT * FROM atomiko_anamnistiko WHERE PatientCode=".$_GET['code'];
	$dynamic_query = "SELECT * FROM atomiko_anamnistiko_dynamic WHERE PatientCode=".$_GET['code'];
}
?>

<DIV style="position: relative; width: 1000px">

<FORM id="atomic_form" name="atomic_form" action="atomic_insert.php" method="GET" onsubmit="return check_data();">
<input type="hidden" name="num_neoplasmata" value="1">
<input type="hidden" name="num_states" value="1">
<input type="hidden" name="code" value="<? echo $_GET['code'] ?>">
<TABLE>
    <TR>
    <TD> <? show_patient_data($_GET['code']); ?> </TD><TD></TD><TD></TD>
    <TD>
    </TD>
    </TR>
<?php
	$has_neo_query = "SELECT PatientCode FROM patient_neoplasma WHERE PatientCode=".$_GET['code'];
	$temp_result = execute_query($has_neo_query);
	$num = mysql_num_rows($temp_result);
	mysql_free_result($temp_result);
?>     
    <TR>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Εχει ο ασθενής εμφανίσει νεόπλασμα που <BR> δεν χαρακτηρίζει το AIDS; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <INPUT type=radio name=HasNeoplasma value=1 <? if ($num == 1) {echo "checked";} ?>> Ναι &nbsp;&nbsp;
    <INPUT type=radio name=HasNeoplasma value=0 <? if ($num == 0) {echo "checked";} ?>> 'Οχι</TD><TD></TD><TD></TD>
    </TR>
<?php
echo "<input type='hidden' name='HasNeoplasma' value='1'>";
 
for ($k=0; $k<1; /*$_GET['numneo']*/ $k++)
{ ?>
    <TR>
    <TD colspan=3> 
<!--	<SELECT name=NeoplasmaID<?echo $k?>> 
    <OPTION value="" checked>- Επιλέξτε -</OPTION>
<?php
/*	$results = execute_query($neoplasmata_query);		
	$num = mysql_num_rows($results);
	for ($i = 0; $i < $num; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['Description'];
		$j = $i+1;
		echo "<OPTION value='" . $j . "'>" . $value . "</OPTION>\n";
	}
	mysql_free_result($results); */
?> 
	</SELECT>
	<input name=NeoplasmaID<?echo $k?> onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=NeoplasmaID<?echo $k?>', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');" -->
	<select name=NeoplasmaID<?echo $k ;?>>
	<option value=""> - Επιλέξτε - </option>
	<option value="Z01">Κακοήθεια αναπνευστικού συστήματος (πνεύμονας)</option>
	<option value="Z02">Κακοήθεια αναπνευστικού συστήματος (αυτιά/μύτη/λαιμός)</option>
	<option value="Z03">Κακοήθεια αναπνευστικού συστήματος (υπεζωκότας)</option>
	<option value="Z04">Ηπατοκαρκίνωμα</option>
	<option value="Z05">Κακοήθεια πεπτικού συστήματος (πάγκρεας)</option>
	<option value="Z06">Κακοήθεια πεπτικού συστήματος (έντερο)</option>
	<option value="Z07">Κακοήθεια πεπτικού συστήματος (στομάχι)</option>
	<option value="Z08">Κακοήθεια πεπτικού συστήματος (οισοφάγος)</option>
	<option value="Z09">Καρκίνωμα πρωκτού</option>
	<option value="Z10">Καρκίνωμα μαστού</option>
	<option value="Z11">Κακοήθεια Κεντρικού Νευρικού Συστήματος</option>
	<option value="Z12">Hodgkin λέμφωμα</option>
	<option value="Z13">Μη-Hodgkin λέμφωμα (εφόσον δεν ανήκει σε AIDS def. events)</option>
	<option value="Z99">Αλλο (από ICD-10)</option>
	</select>
	<input size=5 name=NeoplasmaICD<?echo $k?> onclick="window.open('./icd-10/showpage.php?page=neoplasms.htm&field=NeoplasmaICD<?echo $k?>', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');"
	onkeypress="return no_typing(event);" onfocus="this.blur();">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=NeoplasmaDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=NeoplasmaDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=NeoplasmaDate<?echo $k?>_year>
    <option value=""></option>
	<? print_years(); ?>
	</select></TD>
	</TR>
<?php }
	echo "</TABLE>"; 
	$extra_neoplasma_query = "SELECT patient_neoplasma.NeoplasmaID as neoplasma, patient_neoplasma.NeoplasmaDate as date FROM patient_neoplasma WHERE PatientCode=".$_GET['code'];
	$results = execute_query($extra_neoplasma_query);
	$num = mysql_num_rows($results);
	if ($num <> 0)
	{
		echo "<input type=hidden name='neoplasma' value='".$num."'>";
		echo "<table>\n";
		echo "<th align=center>Διαγραφή &nbsp;&nbsp;</th><th align=center>Καταχωρημένα Νεοπλάσματα</th><th align=center>&nbsp;Ημερομηνία</th>";
		for ($i=0; $i< $num; $i++)
		{
			$row = mysql_fetch_assoc($results);
			echo "<tr>\n";
			echo "<td align=center> <input type=checkbox name='del_neoplasma_sw_".$i."'><input type=hidden name='del_neoplasma_id_".$i."' value='".$row['neoplasma']."'></td>\n";
			if (($row['neoplasma'][0] == "Z") && (substr($row['neoplasma'], 1, 2) != "99"))
			{
				echo "<td>".$neoplasma_array[$row['neoplasma']]." &nbsp; ";
			}
			else
			{
				echo "<td>".$row['neoplasma']." &nbsp; ";
			}
			echo "<img src=\"./images/b_help.png\" style=\"cursor: hand\" onclick=\"window.open('./icd-10/findcode.php?code=".$row['neoplasma']."', 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
			echo "</td>\n";
			echo "<td>&nbsp;&nbsp;".$row['date']."<input type=hidden name='del_neoplasma_date_".$i."' value='".$row['date']."'></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	mysql_free_result($results);
?>
	<TABLE>

    <TR>
    <TD <? if ($_GET['errnum'] == 4) {echo "class='show'";} ?>>Πάσχει ο ασθενής απο υπέρταση; </TD><TD>
    <INPUT type=radio value=1 name=Hypertension id=hyper> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 
      name=Hypertension checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 5) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=HypertensionDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=HypertensionDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=HypertensionDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR>
    <TD <? if ($_GET['errnum'] == 6) {echo "class='show'";} ?>>Πάσχει ο ασθενής απο στεφανιαία νόσο; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Stefaniaia id=stef> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Stefaniaia checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 7) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα:
    <option value=""></option> 
    <select name=StefaniaiaDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StefaniaiaDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StefaniaiaDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR>
    <TD <? if ($_GET['errnum'] == 10) {echo "class='show'";} ?>>Πάσχει ο ασθενής απο σακχαρώδη διαβήτη; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Diabitis id=diab> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Diabitis checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 11) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=DiabitisDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=DiabitisDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=DiabitisDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>    
    <TR>
    <TD <? if ($_GET['errnum'] == 10) {echo "class='show'";} ?>>Πάσχει ο ασθενής απο υπερλιπιδαιμία; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Yperlipidaimia id=yper> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Yperlipidaimia checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 11) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=YperlipidaimiaDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=YperlipidaimiaDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=YperlipidaimiaDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>       
    <TR>
    <TR>
    <TD <? if ($_GET['errnum'] == 10) {echo "class='show'";} ?>>'Εχει παρουσιάσει ο ασθενής λιποατροφία; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Lipoatrofia id=lipo> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Lipoatrofia checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 11) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=LipoatrofiaDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=LipoatrofiaDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=LipoatrofiaDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>       
    <TR>
    <TR>
    <TD <? if ($_GET['errnum'] == 10) {echo "class='show'";} ?>>'Εχει παρουσιάσει ο ασθενής εναπόθεση λίπους; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Enapothesi id=enapo> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Enapothesi checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 11) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=EnapothesiDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EnapothesiDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EnapothesiDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>       
    <TR>
    <TD <? if ($_GET['errnum'] == 8) {echo "class='show'";} ?>>'Εχει υποστεί ο ασθενής έμφραγμα; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Emfragma id=emfr> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Emfragma checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 9) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα:
	<select name=EmfragmaDate_day>
	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EmfragmaDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EmfragmaDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR><TD>
<?  
  	$emfragma_query = "SELECT * FROM atomiko_anamnistiko_emfragma WHERE PatientCode=".$_GET['code'];
	$results = execute_query($emfragma_query);
	$num = mysql_num_rows($results);
	if ($num <> 0)
	{
		echo "<input type=hidden name='emfragmata' value='".$num."'>";
		echo "<table>\n";
		echo "<th align=center>Διαγραφή &nbsp;&nbsp;</th><th align=center>&nbsp;Ημερομηνία Εμφράγματος</th>";
		for ($i=0; $i< $num; $i++)
		{
			$row = mysql_fetch_assoc($results);
			echo "<tr>\n";
			echo "<td align=center> <input type=checkbox name='del_emfragma_sw_".$i."'></td>\n";
			echo "<td align=center>&nbsp;&nbsp;".$row['EmfragmaDate']."<input type=hidden name='del_emfragma_date_".$i."' value='".$row['EmfragmaDate']."'></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	mysql_free_result($results);
?>
	</TD></TR>
<!--<TR>
    <TD <? //if ($_GET['errnum'] == 12) {echo "class='show'";} ?>>15ζ. Εχει παρουσιάσει ο ασθενής λιποτροφία/εναπόθεση λίπους; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=Fat> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=Fat checked> 'Οχι</TD>
    <TD <? //if ($_GET['errnum'] == 13) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=FatDate_day checked>
    <? //print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=FatDate_month>
    <? //print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=FatDate_year>
    <? //print_years(); ?>
	</select></TD>
    </TR> -->
    <TR>
    <TD <? if ($_GET['errnum'] == 8) {echo "class='show'";} ?>>'Εχει υποστεί ο ασθενής ΑΕΕ; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=AEE> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=AEE checked> 'Οχι</TD>
    <TD <? if ($_GET['errnum'] == 9) {echo "class='show'";} ?>>&nbsp;&nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα:
	<select name=AEEDate_day>
	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=AEEDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=AEEDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR><TD colspan=2>
<?  
  	$aee_query = "SELECT * FROM atomiko_anamnistiko_aee WHERE PatientCode=".$_GET['code'];
	$results = execute_query($aee_query);
	$num = mysql_num_rows($results);
	if ($num <> 0)
	{
		echo "<input type=hidden name='aee_num' value='".$num."'>";
		echo "<table>\n";
		echo "<th align=center>Διαγραφή &nbsp;&nbsp;</th><th align=center>&nbsp;Ημερομηνία Αγγειακού Εγκεφαλικού Επισοδείου</th>";
		for ($i=0; $i< $num; $i++)
		{
			$row = mysql_fetch_assoc($results);
			echo "<tr>\n";
			echo "<td align=center> <input type=checkbox name='del_aee_sw_".$i."'></td>\n";
			echo "<td align=center>&nbsp;&nbsp;".$row['AEEDate']."<input type=hidden name='del_aee_date_".$i."' value='".$row['AEEDate']."'></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	mysql_free_result($results);
?>
	</TD></TR>
<?php
// if (isset($_GET['numsta'])) { ?>
    <TR>
    <TD <? if ($_GET['errnum'] == 14) {echo "class='show'";} ?>>
<?
	$has_other_query = "SELECT PatientCode FROM patient_other_clinical_state WHERE PatientCode=".$_GET['code'];
	$temp_result = execute_query($has_other_query);
	$num = mysql_num_rows($temp_result);
	mysql_free_result($temp_result);
?>
    Εχει παρουσιάσει ο ασθενής κάποια <BR> άλλη κλινική κατάσταση; &nbsp;&nbsp;</TD><TD>
    <INPUT type=radio value=1 name=HasOtherClinicalState <? if ($num == 1) {echo "checked";} ?>> Ναι &nbsp;&nbsp;
    <INPUT type=radio value=0 name=HasOtherClinicalState <? if ($num == 0) {echo "checked";} ?>> 'Οχι</TD><TD></TD>
    </TR>
<?php
/*}
else 
{ */
	echo "<input type='hidden' name='HasOtherClinicalState' value='1'>";
//} 
for ($k=0; $k<1; /* $_GET['numsta']*/ $k++)
{ ?>
    <TR>
    <TD colspan=3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--	<SELECT name=ClinicalStatusID<?echo $k?>> 
    <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
/*
	$results = execute_query($clinicalstates_query);		
	$num = mysql_num_rows($results);
	for ($i = 0; $i < $num; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['Description'];
		$j = $i+1;
		echo "<OPTION value='" . $j . "'>" . $value . "</OPTION>";
	}
	mysql_free_result($results);
	*/
?> 
	</SELECT> -->
	<input name=ClinicalStatusID<?echo $k?> onclick="window.open('./icd-10/showpage.php?page=navi.htm&field=ClinicalStatusID<?echo $k?>', 'Λόγοι', 'width=550,height=600,status=yes,scrollbars=yes,toolbar=yes');"
	onkeypress="return no_typing(event);" onfocus="this.blur();">
    &nbsp;&nbsp;&nbsp;
    Ημερομηνία Διάγνωσης &nbsp;&nbsp; Ημέρα: 
    <select name=ClinicalStatusDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=ClinicalStatusDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=ClinicalStatusDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
<?php }
	echo "</TABLE>";
	$extra_state_query = "SELECT patient_other_clinical_state.ClinicalStatusID as state, patient_other_clinical_state.ClinicalStatusDate as date FROM patient_other_clinical_state WHERE PatientCode=".$_GET['code'];
	$results = execute_query($extra_state_query);
	$num = mysql_num_rows($results);
	if ($num <> 0)
	{
		echo "<input type=hidden name='state' value='".$num."'>";
		echo "<table>\n";
		echo "<th align=center>Διαγραφή &nbsp;&nbsp;</th><th align=center>Καταχωρημένες Κλινικές Καταστάσεις</th><th align=center>&nbsp;Ημερομηνία</th>";
		for ($i=0; $i< $num; $i++)
		{
			$row = mysql_fetch_assoc($results);
			echo "<tr>\n";
			echo "<td align=center> <input type=checkbox name='del_state_sw_".$i."'><input type=hidden name='del_state_id_".$i."' value='".$row['state']."'></td>\n";
			echo "<td>".$row['state'] . "&nbsp;&nbsp;";
			echo "<img src=\"./images/b_help.png\" style=\"cursor: hand\" onclick=\"window.open('./icd-10/findcode.php?code=".$row['state']."', 'Εύρεση Κωδικού ICD-10', 'width=450,height=300,status=yes');\"/>";
			echo "</td>\n";
			echo "<td>&nbsp;&nbsp;".$row['date']."<input type=hidden name='del_state_date_".$i."' value='".$row['date']."'></td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
	}
	mysql_free_result($results);
?>            

<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
</DIV>
<script>
function show_extra_smoking(value)
{
	if (value == 0 || value == -1)
	{
		document.all.extrasmoke1.style.display = "none";
		document.all.extrasmoke2.style.display = "none";
	}
	else if (value == 1)
	{
		document.all.extrasmoke1.style.display = "";
		document.all.extrasmoke2.style.display = "";
	}
	else
	{
		document.all.extrasmoke1.style.display = "";
		document.all.extrasmoke2.style.display = "none";
	}
}

function check_data()
{
	if (document.all['hyper'].checked)
	{
		
		if (document.all['HypertensionDate_year'].value == "")
		{
			alert("Πρέπει να σημπληρώσετε το έτος όπου ο ασθενής εμφάνισε υπέρταση!");
			return false;
		}
	}
	if (document.all['stef'].checked)
	{
		if (document.all['StefaniaiaDate_year'].value == "")
		{
			alert("Πρέπει να σημπληρώσετε το έτος όπου ο ασθενής εμφάνισε στεφανιαία νόσο!");
			return false;
		}
	}
	if (document.all['diab'].checked)
	{
		if (document.all['DiabitisDate_year'].value == "")
		{
			alert("Πρέπει να σημπληρώσετε το έτος όπου ο ασθενής εμφάνισε διαβήτη!");
			return false;
		}
	}
	if (document.all['yper'].checked)
	{
		if (document.all['YperlipidaimiaDate_year'].value == "")
		{
			alert("Πρέπει να σημπληρώσετε το έτος όπου ο ασθενής εμφάνισε υπερλιπιδαιμία!");
			return false;
		}
	}	
	if (document.all['emfr'].checked)
	{
		if (document.all['EmfragmaDate_year'].value == "")
		{
			alert("Πρέπει να σημπληρώσετε το έτος όπου ο ασθενής εμφάνισε έμφραγμα!");
			return false;
		}
	}
	for (i=0; i<document.all['num_neoplasmata'].value; i++)
	{
		j=i+1;
		if (document.all['NeoplasmaID'+i].value > 0)
		{
			if (document.all['NeoplasmaDate'+i+'_year'].value == "")
			{
				alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία του "+j+"ου νεοπλάσματος!");
				return false;
			}
		}
	}
	if (document.all['Smoking'].value == "")
	{
		alert("Πρέπει να επιλέξετε μια τιμή για το κάπνισμα!");
		return false;
	}
	for (i=0; i<document.all['num_states'].value; i++)
	{
		j=i+1;
		if (document.all['ClinicalStatusID'+i].value > 0)
		{
			if (document.all['ClinicalStatusDate'+i+'_year'].value == "")
			{
				alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία της "+j+"ης κλινικής κατάστασης!");
				return false;
			}
		}
	}	
}

function no_typing(e)
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
	// nothing accepted
	else if ((("").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}

function fill_data()
{
<?
	$result = execute_query($fixed_query);
	$has_entry = mysql_num_rows($result);
	if ($has_entry)
	{
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
		if ($row['Hypertension'])
		{
			print_stored_date('HypertensionDate', $row);
			?>document.all['hyper'].checked = true;<?
		}
		if ($row['Stefaniaia'])
		{
			print_stored_date('StefaniaiaDate', $row);
			?>document.all['stef'].checked = true;<?
		}
		if ($row['Diabitis'])
		{
			print_stored_date('DiabitisDate', $row);
			?>document.all['diab'].checked = true;<?
		}
		if ($row['Yperlipidaimia'])
		{
			print_stored_date('YperlipidaimiaDate', $row);
			?>document.all['yper'].checked = true;<?
		}
		if ($row['Lipoatrofia'])
		{
			print_stored_date('LipoatrofiaDate', $row);
			?>document.all['lipo'].checked = true;<?
		}	
		if ($row['Enapothesi'])
		{
			print_stored_date('EnapothesiDate', $row);
			?>document.all['enapo'].checked = true;<?
		}							
		
		print_stored_data('Smoking', $row);
/*		if ($row['Smoking'] == '1')
		{
			print_stored_data('AgeStart', $row);
			print_stored_data('AgeFullStart', $row);
			print_stored_data('CigarretesPerDay', $row);
			print_stored_data('CigarsPerDay', $row);
			print_stored_data('KapnosPipasPerDay', $row);
		}
		if ($row['Smoking'] == '2')
		{
			print_stored_data('AgeStart', $row);
			print_stored_data('AgeFullStart', $row);
			print_stored_data('CigarretesPerDay', $row);
			print_stored_data('CigarsPerDay', $row);
			print_stored_data('KapnosPipasPerDay', $row);
			print_stored_data('AgeStop', $row);
		} */
	}
?>	
}

document.body.onload = fill_data();
</script>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>