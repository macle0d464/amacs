<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
?>

<HTML><HEAD>
<TITLE>Τροποποίηση Ασθενή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
<script>
function CheckData()
{
	if (document.all.PatientCode.value == "")
	{
		if (document.all.MELCode.value == "")
		{
			alert("Πρέπει να συμπληρώσετε τουλάχιστον ένα από τα πεδία Κωδικός Ασθενή ή Κωδικός ΜΕΛ!");
			return false;
		}
	}
	if (document.all['BirthDate_year'].value == "")
	{
		alert("Πρέπει να συμπληρώσετε το έτος στην ημερομηνία γέννησης!");
		return false;
	}
	if (document.all.Name.value.length < 2)
	{
		alert("Πρέπει να δώσετε 2 χαρακτήρες στο πεδίο όνομα!");
		return false;		
	}
	if (document.all.Surname.value.length < 2)
	{
		alert("Πρέπει να δώσετε 2 χαρακτήρες στο πεδίο επώνυμο!");
		return false;		
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

function charsonly(e)
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
	else if ((("ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩABCDEFGHIJKLMNOPQRSTUVWXYZ").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}


</script>
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P><P>&nbsp;</P>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("alter_patient.php");
	die();
}
else
{
	check_patient($_GET['code']);
	$patient_query = "SELECT * FROM patients WHERE PatientCode=".$_GET['code'];
	$row = mysql_fetch_assoc(execute_query($patient_query));
}
?>

<FORM id="alter_patient_form" name="alter_patient_form" action="alter_patient_insert.php" method="GET" onsubmit="return CheckData();">
<DIV style="position: relative; left:50px;">
<TABLE>
    <TR>
    <TD> Κωδικός Ασθενή (ΚΕΕΛ)</TD><TD>
    <INPUT maxLength=7 onfocus="this.blur();" size=20 name="PatientCode" value="<? echo $row['PatientCode']?>" >
	</TD>
	</TR><TR></TR><TR>
    <TD> Κωδικός ΜΕΛ &nbsp;&nbsp;&nbsp;</TD>
    <TD>
    <INPUT maxLength=7 onKeyPress="return numbersonly(event)" size=20 name="MELCode"
<? if ($row['MELCode'] != "-1")
	{
		echo "value='".$row['MELCode']."'";
	}
?> 	
	></TD>
    </TR><TR></TR><TR>
	<TD> Αρχικά Ονόματος </TD>
	<TD> <INPUT maxLength=255 size=20 name="Name" onKeyPress="return charsonly(event)" value="<? echo $row['Name']?>"/>
     <font color="red">(με κεφαλαία γράμματα)</font></TD>
    </TR><TR></TR><TR>
    <TD> Αρχικά Επωνύμου </TD><TD>
    <INPUT maxLength=255 size=20 name="Surname" onKeyPress="return charsonly(event)" value="<? echo $row['Surname']?>">
     <font color="red">(με κεφαλαία γράμματα)</font></TD>
     <TR>
    <TD>Ημερομηνία Γέννησης </TD><TD>
    &nbsp;&nbsp;      Ημέρα: 
    <select name=BirthDate_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=BirthDate_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=BirthDate_year>
    <option value="" selected></option>	
    <? print_birth_years(); ?>
	</select>
    </TD>
    </TR>
    </TR><TR><TD>
    </TD><TD></TD></TR><TR></TR>
    <TR><TD colspan="2" align="center"><INPUT TYPE="SUBMIT" VALUE="Τροποποίηση"></TD></TR>
</TABLE>
<p>&nbsp;</p>
<!--
<TABLE width=450>
<TR>
<TD align="center"><b><u>ΠΡΟΣΟΧΗ!</u></b></TD></tr>
<tr>
<TD>Αν <b>ΔΕΝ έχει δωθεί</b> Κωδικός Ασθενή από το ΚΕΕΛ για τον ασθενή που θέλετε να καταχωρήσετε,
 συμπληρώστε <b>ΜΟΝΟ</b> το πεδίο Κωδικός ΜΕΛ</TD>
 </tr>
 <tr><td align="center"><font color="red"><b>αλλιώς</b></font></td></tr>
 <tr>
<TD>Αν  για τον ασθενή γνωρίζετε <u>και</u> τον Κωδικό Ασθενή που έχει δωθεί από το ΚΕΕΛ <u>και</u>
τον Κωδικό ΜΕΛ που έχει δωθεί από το νοσοκομείο, τότε συμπληρώστε <b>ΚΑΙ ΤΑ ΔΥΟ</b> πεδια 
(Κωδικός Ασθενή & ΜΕΛ)</TD>
 </tr>
</TABLE> -->
</DIV>
</FORM>
<script>
<? print_stored_date('BirthDate', $row); ?>
</script>
</BODY>
</HTML>
<? mysql_close($dbconnection); ?>