<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
?>

<HTML><HEAD>
<TITLE>Ασθενείς</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
<script>
function returnReason(number)
{
// window.opener.document.all.code.value = number; // OLD WAY
window.parent.document.all.code.value = number;
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

<?
if (!isset($_GET['show']) || ($_GET['show'] == ""))
{
?>
	<P>Δώστε όσα περισότερα στοιχεία από τα παρακάτω μπορείτε, ή <BR>
	<a href="find_patient.php?show=all">πατήστε εδώ για προβολή ΟΛΩΝ των ασθενών</a></P>
	<FORM action="find_patient.php" method="GET">
	<input type="hidden" value=some name=show>
	<TABLE>
    <TR>
    <TD> Κωδικός Ασθενή (ΚΕΕΛ)</TD><TD>
    <INPUT maxLength=7 onKeyPress="return numbersonly(event)" size=20 name="PatientCode">
	</TD>
	</TR><TR></TR><TR>
    <TD> Κωδικός ΜΕΛ &nbsp;&nbsp;&nbsp;</TD>
    <TD>
    <INPUT maxLength=7 onKeyPress="return numbersonly(event)" size=20 name="MELCode"></TD>
    </TR><TR></TR><TR>
	<TD> Αρχικά Ονόματος </TD>
	<TD> <INPUT maxLength=255 size=20 name="Name" onKeyPress="return charsonly(event)"/>
    </TD>
    </TR><TR></TR><TR>
    <TD> Αρχικά Επωνύμου </TD><TD>
    <INPUT maxLength=255 size=20 name="Surname" onKeyPress="return charsonly(event)">
    </TD>
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
    <TR><TD colspan="2" align="center"><INPUT TYPE="SUBMIT" VALUE="Εύρεση Ασθενή" style="border: 1px outset;"></TD></TR>
</TABLE>
	</FORM>

<?
	die();
}
else
{
  if ($_GET['show'] == "all")
  {
	$reasons_query = "SELECT PatientCode as `Κωδικός Ασθενή`, MELCode as `Κωδικός ΜΕΛ`, Name as `'Ονομα`, Surname as `Επώνυμο`, BirthDate as `Ημερομηνία Γέννησης` FROM patients";
  	$result = execute_query($reasons_query);
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν βρέθηκε ασθενής με τέτοια στοιχεία!</p>";
    	//        echo "<tr><td>".$num_rows." rows returned!</tr></td>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>";
                if ($field->name == "Κωδικός Ασθενή")
                {
                	echo "<a href='#' onclick='javascript:returnReason(".$resultrow[$field->name].")'>".$resultrow[$field->name]."</a>";
                }
                else if ($field->name == "Κωδικός ΜΕΛ")
                {
                	if ($resultrow[$field->name] == "-1")
                	{
                		echo "(δεν υπάρχει)";
                	}
                	else
                	{
                		echo $resultrow[$field->name];
                	}
                }
                else if ($field->name == "Ημερομηνία Γέννησης")
                {
                	echo show_date($resultrow[$field->name]);                	
                }
                else
                {
                	echo $resultrow[$field->name];
                }
                echo "</td>";
                $i++;
            }
            echo "</tr>\n";
        }
    }
    echo "</table>";
  }
  if ($_GET['show'] == "some")
  {
  	form_data2table($_GET);
  	$search_query = "SELECT PatientCode as `Κωδικός Ασθενή`, MELCode as `Κωδικός ΜΕΛ`, Name as `'Ονομα`, Surname as `Επώνυμο`, BirthDate as `Ημερομηνία Γέννησης` FROM patients WHERE ";
  	if ($_GET['PatientCode'] != "")
  	{
  		$search_query .= "`PatientCode` LIKE '%".$_GET['PatientCode']."%' AND ";
  	}
  	if ($_GET['MELCode'] != "")
  	{
  		$search_query .= "`MELCode` LIKE '%".$_GET['MELCode']."%' AND ";
  	}
  	if ($_GET['Name'] != "")
  	{
  		$search_query .= "`Name` LIKE '%".$_GET['Name']."%' AND ";
  	}
  	if ($_GET['Surname'] != "")
  	{
  		$search_query .= "`Surname` LIKE '%".$_GET['Surname']."%' AND ";
  	}
  	$date = "";
  	if ($_GET['BirthDate_year'] != "")
  	{
  		$date .= $_GET['BirthDate_year']."-";
  	}
  	if ($_GET['BirthDate_month'] != "")
  	{
  		$date .= $_GET['BirthDate_month']."-";
  	}
  	if ($_GET['BirthDate_day'] != "")
  	{
  		$date .= $_GET['BirthDate_day'];
  	}
  	if ($date != "")
  	{
  		$search_query .= "`BirthDate` LIKE '%".$date."%' AND ";
  	}
  	$search_query = substr($search_query, 0, strlen($search_query)-4);
  	//echo $search_query;
  	$result = execute_query($search_query);
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        echo "<th class=result>".$field->name . "</th>";
        $i++;
    }
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
		echo "</table><p> &nbsp; Δεν βρέθηκε ασθενής με τέτοια στοιχεία!</p>";
    	//        echo "<tr><td>".$num_rows." rows returned!</tr></td>";
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                echo "<td class=result>";
                if ($field->name == "Κωδικός Ασθενή")
                {
                	echo "<a href='#' onclick='javascript:returnReason(".$resultrow[$field->name].")'>".$resultrow[$field->name]."</a>";
                }
                else if ($field->name == "Κωδικός ΜΕΛ")
                {
                	if ($resultrow[$field->name] == "-1")
                	{
                		echo "(δεν υπάρχει)";
                	}
                	else
                	{
                		echo $resultrow[$field->name];
                	}
                }
                else if ($field->name == "Ημερομηνία Γέννησης")
                {
                	echo show_date($resultrow[$field->name]);                	
                }
                else
                {
                	echo $resultrow[$field->name];
                }
                echo "</td>";
                $i++;
            }
            echo "</tr>\n";
        }
    }
    echo "</table>";  	
  }
  mysql_free_result($result);
}
/*
$num = mysql_num_rows($result);
for ($i=0; $i<$num; $i++)
{
	$row = mysql_fetch_assoc($result);
	echo "<tr>\n";
	echo "<td>".$row['ID'].". </td>\n";
	echo "<td><a href='#' onclick='javascript:returnReason(".$row['ID'].")'>".$row['Reason']."</a></td>\n";
	echo "</tr>\n";
}*/
?>
</TABLE>
<!--
<p align=center><input type=button value="Κλείσιμο Παραθύρου" onclick="window.close();"></p>
-->
</BODY></HTML>