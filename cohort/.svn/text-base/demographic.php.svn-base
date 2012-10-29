<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$race_query = "SELECT * FROM races";
	$clinics_query = "SELECT * FROM clinics";
?>
<HTML><HEAD>
<TITLE>Καταχώρηση Δημογραφικών Στοιχείων Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("demographic.php");
	die();
}
else
{
	check_patient($_GET['code']);
	session_start();
	$_SESSION['PatientCode'] = $_GET['code'];
	$sql = "SELECT StartDate FROM antiretro_treatments WHERE PatientCode=".$_GET['code']." GROUP BY StartDate";
	$result = execute_query($sql);
	if (mysql_num_rows($result) == 0)
	{
		$_SESSION['antiretro_startdate'] = "3000-01-01";
	}
	else
	{
		$row = mysql_fetch_assoc($result);
		$_SESSION['antiretro_startdate'] = $row['StartDate'];
	}	
}
?>

<DIV style="position: absolute; left:30px;">

<FORM id="demographic_form" name="demographic_form" action="demographic_insert.php" method="GET" onsubmit="return check_data();">
<TABLE width=910>
    <TR>
    <TD><b> <? show_patient_data($_GET['code']); ?></b> </TD>
    <TD></TD>
    </TR>
	<TR>
    <TD>Ημερομηνία εγγραφής του ασθενούς στο COHORT</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ημέρα:
    <select name=EnrollDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EnrollDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EnrollDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select></TD>
    </TR>    
    <TR>
    <TD>Ημερομηνία πρώτης επίσκεψης του ασθενούς στην κλινική</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ημέρα:
    <select name=FirstVisit_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=FirstVisit_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=FirstVisit_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR>
    <TD>Φυλή: <SELECT name=Race> 
    <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
	$results = execute_query($race_query);		
	$num_races = mysql_num_rows($results);
	for ($i = 0; $i < $num_races; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['RaceDescription'];
		$j = $i+1;
		echo "<OPTION value='" . $j . "'>" . $value . "</OPTION>";
	}
	mysql_free_result($results);
?> </SELECT> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Φύλο: <SELECT name=Sex> 
    <OPTION value="" selected>- Επιλέξτε -</OPTION>
    <OPTION value=1>Αρρεν</OPTION>
    <OPTION value=2>Θήλυ</OPTION>
    <OPTION value=3>Αλλαγή φύλου</OPTION></SELECT>
    </TD>
    <TD></TD>
    </TR>
    <TR><td colspan=3>
    <!--
    <TABLE>
    <TD>Πρόσφατη μέτρηση βάρους (κιλά) <TD><INPUT maxLength=3 size=3 name=RecentWeight onkeypress="return numbersonly(event);"></TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ημερομηνία μέτρησης</TD>
    <TD>&nbsp;&nbsp;
    Ημέρα: <select name=RecentWeightDate_day>
    <? print_options(31); ?>
    <option value="" selected></option>
	</select>&nbsp;
    Μήνας: <select name=RecentWeightDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=RecentWeightDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <TR>
    <TD>Πρόσφατη μέτρηση ύψους (cm) <TD><INPUT class=input maxLength=3 size=3 
      name=RecentHeight onkeypress="return numbersonly(event);"></TD>  <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ημερομηνία μέτρησης</TD>
    <TD>&nbsp;&nbsp; Ημέρα: <select name=RecentHeightDate_day>
    <? print_options(31); ?>
    <option value="" selected></option>
	</select>&nbsp;
    Μήνας: <select name=RecentHeightDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=RecentHeightDate_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    </TABLE>
    -->
    </td>
    <TR>
    <TD>Μορφωτικό Επίπεδο &nbsp;&nbsp; <select name=Education>
    <option value="" selected>- Επιλέξτε -</option>
    <option value="0">'Αγνωστο</option>
    <option value="1">Αναλφάβητος</option>
    <option value="2">Μερικές τάξεις Δημοτικού</option>
    <option value="3">Απόφοιτος Δημοτικού</option>
    <option value="4">Απόφοιτος Γ' Γυμνασίου</option>
    <option value="5">Απόφοιτος Λυκείου</option>
    <option value="6">Απόφοιτος Ι.Ε.Κ.</option>
    <option value="7">Απόφοιτος Τ.Ε.Ι.</option>
    <option value="8">Απόφοιτος Α.Ε.Ι.</option>
    <option value="9">Μεταπτυχιακό</option>
    </select></TD>
    <TD></TD>
    <TD></TD>
    </TR>
    <TR>
    <TD colspan=3>Προέλευση &nbsp;&nbsp; <select name=Origin>
    <option value="" selected>- Επιλέξτε -</option>
    <option value="10">Africa</option>
    <option value="11">Northern Africa</option>
    <option value="12">Sub-Saharan Africa</option>
    <option value="20">Asia</option>
    <option value="30">Oceania (not Australia)</option>
    <option value="40">Australia & New Zealand</option>
    <option value="50">Americas</option>
    <option value="517">North America</option>
    <option value="52">Central & South America</option>   
    <option value="60">Middle East</option>
    <option value="70">Europe (Greek)</option>
    <option value="71">Western Europe</option>
    <option value="72">Eastern Europe</option>
    <option value="99">Unknown</option>    
    </select> &nbsp;&nbsp; ή επιλέξτε από την ακόλουθη λίστα &nbsp;&nbsp;
	<select name=country>
    <option value="0"> - Επιλέξτε - </option>
<?
	$result = execute_query("SELECT * FROM countries_list");
	$num = mysql_num_rows($result);
	for ($i=0; $i<$num; $i++)
	{
		$row = mysql_fetch_array($result);
		echo "<option value=".$row[0].">".$row[1]."</option>";
	}
?>	
	</select>
	</TD>
    </TR>    
    <TR>
    <TD>Κλινική παρακολούθησης κατά την καταγραφή:</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <SELECT name=ClinicDuringRecord>
        <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
?>              
        </SELECT> </TD>
</TD>
    </TR>
    <!--
    <TR>
    <TD>Προηγούμενη κλινική παρακολούθησης:</TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <SELECT name=PreviousClinic>
        <OPTION value="0" selected>Καμία</OPTION> 
 <?php
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
?>   
        </SELECT></TD>
    </TR>
    -->
</TABLE>

<P> Πιθανή πηγή μόλυνσης: &nbsp;&nbsp;&nbsp;
    <SELECT onchange="show_extra();" name=PossibleSourceInfection> 
        <OPTION value="" selected>- Επιλέξτε -</OPTION>
        <OPTION value=1>Ομοφυλόφυλος-η / Αμφιφυλόφιλος-η</OPTION>
        <OPTION value=2>Χρήστης ενδοφλέβιων εξαρτησιογόνων ουσιών</OPTION>
        <OPTION value=3>Ομοφυλόφιλος/Αμφιφυλόφιλος άνδρας, Χρήστης ενδοφλέβιων 
        εξαρτησιογόνων ουσιών</OPTION>
        <OPTION value=4>Πολυμεταγγιζόμενο άτομο με αίμα</OPTION>
        <OPTION value=5>Πολυμεταγγιζόμενο άτομο με παράγωγα 
        αίματος/πλάσματος</OPTION>
        <OPTION value=6>Περιστασιακή μετάγγιση αίματος ή παραγώγων αίματος μετά
        το 1978 [*]</OPTION>
        <OPTION value=7>Ετεροφυλοφιλικές σεξουαλικές σχέσεις [**]</OPTION>
        <OPTION value=8>Αδιευκρίνιστη από το ιστορικό πηγή μόλυνσης</OPTION>
        <OPTION value=9>Κάθετη Μετάδοση</OPTION></SELECT>
      </P>
<DIV id=extra1 style="display: none">
Τόπος Μετάγγισης <INPUT class=input maxLength=255 size=30 
      name=TransfusionPlace> &nbsp;&nbsp;&nbsp; Ημερομηνία μετάγγισης Ημέρα: 
	 <select name=TransfusionDate_day>
	 <option value="" selected></option>
     <? print_options(31); ?>
	 </select>&nbsp;
     Μήνας: <select name=TransfusionDate_month>
     <option value="" selected></option>
     <? print_options(12); ?>
	 </select>&nbsp;
	 Έτος: <select name=TransfusionDate_year>
	 <option value="" selected></option>
     <? print_years(); ?>
	 </select> </DIV>
<DIV id=extra2 style="display: none">Συγκεκριμένα: <BR>
<UL>
    <LI><INPUT class=input type=checkbox
 value=1 name=Country>
    Ο ασθενής προέρχεται από χώρα όπου η επιδημία οφείλεται κυρίως σε ετεροφυλοφιλική
μετάδοση (Κ. Αφρική, Καραϊβική κ.λ.π.)</LI>
    <LI><INPUT class=input type=checkbox
 value=1 name=Sailor>
    Ναυτικός ή ταξιδιώτης σε χώρες όπου η επιδημία οφείλεται κυρίως σε ετεροφυλοφιλική
μετάδοση (Κ. Αφρική, Καραϊβική κ.λ.π.) </LI>
    <LI><INPUT class=input type=checkbox o
nchange=DirtyRecord(); value=1 name=PartnerCountry>
    Σύντροφος που προέρχεται από χώρα όπου η επιδημία οφείλεται κυρίως σε ετεροφυλοφιλική
μετάδοση (Κ. Αφρική, Καραϊβική κ.λ.π.) </LI>
    <LI><INPUT class=input type=checkbox
 value=1 name=PartnerDrugs>
    Σύντροφος χρήστης ενδοφλέβιων εξαρτησιογόνων ουσιών </LI>
    <LI> <INPUT class=input type=checkbox
 value=1 name=PartnerBi>
    Σύντροφος αμφιφυλόφιλος (μόνο για γυναίκες) </LI>
    <LI><INPUT class=input type=checkbox
 value=1 name=PartnerTransfusion>
    Σύντροφος πολυμεταγγιζόμενος με παράγωγα αίματος </LI>
    <LI><INPUT class=input type=checkbox
 value=1 name=PartnerTransfusionAfter78>
    Σύντροφος μεταγγισμένος μετά το 1978 </LI>
    <LI><INPUT class=input type=checkbox  value=1
name=PartnerHIVPlus>
    Σύντροφος HIV+ που δεν ανήκει σε μία από τις παραπάνω κατηγορίες</LI>
    <LI><INPUT class=input type=checkbox  value=1 
      name=Undefined>
    Πιθανή μόλυνση μέσω ετεροσεξουαλικής επαφής,μή περαιτέρω προσδιορίσιμη</LI>
</UL> </DIV>
<P>'Εχει ο ασθενής γνωστή ημερομηνία ορομετατροπής 
      (γνωστή ημερομηνία τελευταίου αρνητικού και πρώτου θετικού δείγματος): 
    <SELECT onchange="show_oro();" name=KnownDateOrometatropi > 
    <OPTION value=1>Ναί</OPTION>
    <OPTION value=0 selected>Οχι</OPTION></SELECT></P>
<DIV id=orodate style="display: none">
<P>Η ημερομηνία ορομετατροπής είναι γνωστή από την <b>Ημερομηνία τελευταίου αρνητικού δείγματος</b>&nbsp;
Ημέρα: <select name=LastNegativeSample_day>
<option value="" selected></option>
     <? print_options(31); ?>
	 </select>&nbsp;
     Μήνας: <select name=LastNegativeSample_month>
     <option value="" selected></option>
     <? print_options(12); ?>
	 </select>&nbsp;
	 Έτος: <select name=LastNegativeSample_year>
	 <option value="" selected></option>
     <? print_years(); ?>
	 </select></P>
<p> <b>ή</b> από άλλη μέθοδο <b>Ημερομηνία ορομετατροπής</b>&nbsp;
Ημέρα: <select name=SeroconversionDate_day>
<option value="" selected></option>
     <? print_options(31); ?>
	 </select>&nbsp;
     Μήνας: <select name=SeroconversionDate_month>
     <option value="" selected></option>
     <? print_options(12); ?>
	 </select>&nbsp;
	 Έτος: <select name=SeroconversionDate_year>
	 <option value="" selected></option>
     <? print_years(); ?>
	 </select></P>
</DIV>
<P>Ημερομηνία πρώτου θετικού δείγματος <BR>
Ημέρα: <select name=FirstPositiveSample_day>
<option value="" selected></option>
     <? print_options(31); ?>
	 </select>&nbsp;
     Μήνας: <select name=FirstPositiveSample_month>
     <option value="" selected></option>
     <? print_options(12); ?>
	 </select>&nbsp;
	 Έτος: <select name=FirstPositiveSample_year>
	 <option value="" selected></option>
     <? print_years(); ?>
	 </select></P> 
	 <!--
<P>Ημερομηνία πρώτης προσέλευσης στην Κλινική <BR>
Ημέρα: <select name=FirstEntryAtClinic_day>
<option value="" selected></option>
     <? print_options(31); ?>
	 </select>&nbsp;
     Μήνας: <select name=FirstEntryAtClinic_month>
     <option value="" selected></option>
     <? print_options(12); ?>
	 </select>&nbsp;
	 Έτος: <select name=FirstEntryAtClinic_year>
	 <option value="" selected></option>
     <? print_years(); ?>
	 </select></P>
	 -->
	 <input type='hidden' name='has_entry' value='0' />
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>

</DIV>

<SCRIPT>
function show_extra()
{
	if (document.all.PossibleSourceInfection.value == "6" )
	{
		document.all.extra2.style.display = "none";
		document.all.extra1.style.display = "";
		document.all['Country'].checked = false;
		document.all['Sailor'].checked = false;
		document.all['PartnerCountry'].checked = false;
		document.all['PartnerDrugs'].checked = false;
		document.all['PartnerBi'].checked = false;
		document.all['PartnerTransfusion'].checked = false;
		document.all['PartnerTransfusionAfter78'].checked = false;
		document.all['PartnerHIVPlus'].checked = false;
		document.all['Undefined'].checked = false;
	}
	else if (document.all.PossibleSourceInfection.value == "7" )
	{
		document.all.extra1.style.display = "none";
		document.all.extra2.style.display = "";
		document.all['TransfusionPlace'].value = "";
		document.all['TransfusionDate_day'].value = "";
		document.all['TransfusionDate_month'].value = "";
		document.all['TransfusionDate_year'].value = "";
	}
	else
	{
		document.all.extra1.style.display = "none";
		document.all.extra2.style.display = "none";
		document.all['TransfusionPlace'].value = "";
		document.all['TransfusionDate_day'].value = "";
		document.all['TransfusionDate_month'].value = "";
		document.all['TransfusionDate_year'].value = "";
		document.all['Country'].checked = false;
		document.all['Sailor'].checked = false;
		document.all['PartnerCountry'].checked = false;
		document.all['PartnerDrugs'].checked = false;
		document.all['PartnerBi'].checked = false;
		document.all['PartnerTransfusion'].checked = false;
		document.all['PartnerTransfusionAfter78'].checked = false;
		document.all['PartnerHIVPlus'].checked = false;
		document.all['Undefined'].checked = false;		
	}
}
function show_oro()
{
	if (document.all.KnownDateOrometatropi.value == "1" )
	{
		document.all.orodate.style.display = "";
	}
	else
	{
		document.all.orodate.style.display = "none";
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

function check_data()
{
	if (document.all['EnrollDate_year'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία εγγραφής του ασθενούς στο COHORT!");
		return false;
	}
	if (document.all['FirstVisit_year'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία πρώτης επίσκεψης του ασθενούς στην κλινική!");
		return false;
	}
	if (document.all['Origin'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε την προέλευση του ασθενούς!");
		return false;
	}		
	if (document.all['Race'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε την φυλή του ασθενούς!");
		return false;
	}
	if (document.all['Sex'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το φύλο του ασθενούς!");
		return false;
	}
//	if ((document.all['RecentWeight'].value != "") && (document.all['RecentWeightDate_year'].value == ""))
//	{
//		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία πρόσφατης μέτρησης βάρους του ασθενούς!");
//		return false;
//	}
//	if ((document.all['RecentHeight'].value != "") && (document.all['RecentHeightDate_year'].value == ""))
//	{
//		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία πρόσφατης μέτρησης ύψους του ασθενούς!");
//		return false;
//	}
	if (document.all['Education'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το μορφωτικό επίπεδο του ασθενούς!");
		return false;
	}
	if (document.all['ClinicDuringRecord'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε την κλινική παρακολούθησης κατά την καταγραφή!");
		return false;
	}
	if (document.all['PreviousClinic'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε την προηγούμενη κλινική παρακολούθησης!");
		return false;
	}
	if (document.all['PossibleSourceInfection'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε την πιθανή πηγή μόλυνσης!");
		return false;
	}
	if (document.all['PossibleSourceInfection'].value == "6")
	{
		if (document.all['TransfusionPlace'].value == "")
		{
			alert("Πρέπει να συμπληρώσετε τον τόπο μετάγγισης!");
			return false;
		}
		if (document.all['TransfusionDate_year'].value == "")
		{
			alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία μετάγγισης!");
			return false;
		}		
	}
	if (document.all['LastNegativeSample_year'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία τελευταίου αρνητικού δείγματος!");
		return false;
	}	
	if ((document.all['KnownDateOrometatropi'].value == "1") && (document.all['FirstPositiveSample_year'].value == ""))
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία πρώτου θετικού δείγματος!");
		return false;
	}	
//	if (document.all['FirstEntryAtClinic_year'].value == "")
//	{
//		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία πρώτης προσέλευσης στην Κλινική!");
//		return false;
//	}		
				
}

function fill_data()
{
<?
	$query = "SELECT * FROM demographic_data WHERE PatientCode=".$_GET['code'];
	$result = execute_query($query);
	$has_entry = mysql_num_rows($result);
	if ($has_entry)
	{
		$row = mysql_fetch_assoc($result);
		mysql_free_result($result);
?>	
	document.all['has_entry'].value='1';
	document.all['Origin'].value = <? echo $row['Origin']; ?>;
	document.all['Race'].value = <? echo $row['Race']; ?>;
	document.all['Sex'].value = <? echo $row['Sex']; ?>;
	document.all['PossibleSourceInfection'].value = <? echo $row['PossibleSourceInfection']; ?>;
	if (document.all['PossibleSourceInfection'].value == 6)
	{
		document.all.extra1.style.display = "";
		document.all['TransfusionPlace'].value = '<? echo $row['TransfusionPlace']; ?>';
		document.all['TransfusionDate_year'].value = '<? echo retyear($row['TransfusionDate']); ?>';
		document.all['TransfusionDate_month'].value = '<? echo retmonth($row['TransfusionDate']); ?>';
		document.all['TransfusionDate_day'].value = '<? echo retday($row['TransfusionDate']); ?>';
	}
	if (document.all['PossibleSourceInfection'].value == 7)
	{
		document.all.extra2.style.display = "";
		<? print_stored_check('Country', $row); ?>
		<? print_stored_check('Sailor', $row); ?>
		<? print_stored_check('PartnerCountry', $row); ?>
		<? print_stored_check('PartnerDrugs', $row); ?>
		<? print_stored_check('PartnerBi', $row); ?>
		<? print_stored_check('PartnerTransfusion', $row); ?>
		<? print_stored_check('PartnerTransfusionAfter78', $row); ?>
		<? print_stored_check('PartnerHIVPlus', $row); ?>
		<? print_stored_check('Undefined', $row); ?>
	}
	document.all['KnownDateOrometatropi'].value = '<? echo $row['KnownDateOrometatropi']; ?>';
	if (document.all['KnownDateOrometatropi'].value == 1)
	{
		document.all.orodate.style.display = "";
		<? print_stored_date('LastNegativeSample', $row); ?>
		<? print_stored_date('SeroconversionDate', $row); ?>
	}
	document.all['Education'].value = '<? echo $row['Education']; ?>';
	<? if ($row['RecentWeight'] > 0)
	{ ?> 
//	document.all['RecentWeight'].value = '<? echo $row['RecentWeight']; ?>';
 <? }
 	   if ($row['RecentHeight'] > 0)
	{ ?> 
//	document.all['RecentHeight'].value = '<? echo $row['RecentHeight']; ?>';
<?  } ?>
	document.all['ClinicDuringRecord'].value = '<? echo $row['ClinicDuringRecord']; ?>';
//	document.all['PreviousClinic'].value = '<? echo $row['PreviousClinic']; ?>';
	document.all['TransfusionDate_year'].value = '<? echo retyear($row['TransfusionDate']); ?>';
	document.all['TransfusionDate_month'].value = '<? echo retmonth($row['TransfusionDate']); ?>';
	document.all['TransfusionDate_day'].value = '<? echo retday($row['TransfusionDate']); ?>';
	document.all['TransfusionDate_year'].value = '<? echo retyear($row['TransfusionDate']); ?>';
	document.all['TransfusionDate_month'].value = '<? echo retmonth($row['TransfusionDate']); ?>';
	document.all['TransfusionDate_day'].value = '<? echo retday($row['TransfusionDate']); ?>';
//	document.all['FirstEntryAtClinic_year'].value = '<? echo retyear($row['FirstEntryAtClinic']); ?>';
//	document.all['FirstEntryAtClinic_month'].value = '<? echo retmonth($row['FirstEntryAtClinic']); ?>';
//	document.all['FirstEntryAtClinic_day'].value = '<? echo retday($row['FirstEntryAtClinic']); ?>';	
<?
	print_stored_date('FirstVisit', $row);
	print_stored_date('EnrollDate', $row);
//	print_stored_date('RecentWeightDate', $row);
//	print_stored_date('RecentHeightDate', $row);
	print_stored_date('FirstPositiveSample', $row);
	} 
?>
}

document.body.onload = fill_data();
</SCRIPT>

</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>