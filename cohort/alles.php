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
<TITLE>Καταχώρηση 'Αλλων Θεραπείων</TITLE>
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
	Print_PatientCode_form("alles.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="alles_form" name="alles_form" action="alles_insert.php" method="GET">
<input type="hidden" name=code value="<?echo $_GET['code'];?>">

<a name="top"></a>
<P>'Αλλες Θεραπείες (δεν συμπεριλαμβάνονται θεραπείες ένταντι συλλοιμώξεων με ιούς HBV / HCV)</P>

 <? show_patient_data($_GET['code']); ?>
 <a href="#view">Προβολή Θεραπειών Ασθενή</a>
<BR><BR>
<TABLE width=1000>
    <TR>
    <TD colspan=2 class="show" align="center">Θεραπεία</TD>
    <TD class="show" align="center">Ημερομηνία Έναρξης</TD>
    <TD class="show" align="center">Ημερομηνία Διακοπής</TD>     
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?
	$therapies_query = "SELECT * FROM other_treatments_list";
	$result = execute_query($therapies_query);
	$alles = array();
	for ($k=0; $k<mysql_num_rows($result); $k++)
	{
		$row = mysql_fetch_assoc($result);
		$alles[$row['ID']]['Med']= $row['Therapy'];
		$alles[$row['ID']]['Description']= $row['Description'];
	}
	for ($k=0; $k<100; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
    <TR>
	<TD align="center"><INPUT type="checkbox" name=Therapy<?echo $k?>></td>
	<td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	}
	?>
	</table>
	<table style="width: 1000px"> 
	<tr>
	<td colspan=2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u><? echo $alles[$k]['Med']; ?></b></u>
	</td>
	</tr>	
	<?	 
	for ($k=101; $k<200; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
    <TR>
	<TD align="center"><INPUT type="checkbox" name=Therapy<?echo $k?>></td><td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	}
	?>
	</table>
	<table style="width: 1000px"> 
	<tr>
	<td colspan=2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u><? echo $alles[$k]['Med']; ?></b></u>
	</td>
	</tr>	
	<?  
	 	for ($k=201; $k<300; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
    <TR>
	<TD align="center"><INPUT type="checkbox" name=Therapy<?echo $k?>></td><td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	}
	?>
	</table>
	<table style="width: 1000px"> 
	<tr>
	<td colspan=2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u><? echo $alles[$k]['Med']; ?></b></u>
	</td>
	</tr>	
	<?  
	for ($k=301; $k<400; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
    <TR>
	<TD align="center">
	<INPUT type="checkbox" name=Therapy<?echo $k?>></td><td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	}
	?>
	</table>
	<table style="width: 1000px"> 
	<tr>
	<td colspan=2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u><? echo $alles[$k]['Med']; ?></b></u>
	</td>
	</tr>	
	<? 
	for ($k=401; $k<500; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
	<TR>
	<TD align="center">
	<INPUT type="checkbox" name=Therapy<?echo $k?>></td><td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	} 
	?>
	</table>
	<table style="width: 1000px"> 
	<tr>
	<td colspan=2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u><? echo $alles[$k]['Med']; ?></b></u>
	</td>
	</tr>	
	<? 
	for ($k=501; $k<600; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
	<TR>
	<TD align="center">
	<INPUT type="checkbox" name=Therapy<?echo $k?>></td><td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	} 
	?>
	</table>
	<table style="width: 1000px"> 
	<tr>
	<td colspan=2><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<u>'Αλλα</b></u>
	</td>
	</tr>	
	<? 
	for ($k=901; $k<1000; $k++)
	{
		if (isset($alles[$k]))
		{
?>	
	<TR>
	<TD align="center">
	<INPUT type="checkbox" name=Therapy<?echo $k?>></td><td style="width: 300px">
    <? echo $alles[$k]['Med']; ?><br><i><? echo $alles[$k]['Description']; ?></i>
    </TD>
    <TD>
    Ημέρα: <select name=StartDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=StartDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
    Ημέρα: <select name=EndDate<?echo $k?>_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate<?echo $k?>_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=EndDate<?echo $k?>_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </TD>
	</TR>
<? 
		}
	} 
	?>
	</table>
<input type="hidden" name="therapies" value="1000">
</TABLE>
<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων"></p>
</FORM>
<hr>
<a name="view"><h3>Καταχωρημένες Θεραπείες &nbsp; <a href="#top"><small>Επιστροφή</small></a> </h3></a>
<div>
<?
$sql = "SELECT other_treatments.Therapy as therapyid,other_treatments_list.Therapy, other_treatments.StartDate, other_treatments.EndDate FROM other_treatments,other_treatments_list WHERE other_treatments.Therapy = other_treatments_list.ID AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_therapies_other.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=other_therapies>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
       	echo "<th class=result> Θεραπεία </th>";
       	echo "<th class=result> Ημερομηνία 'Εναρξης</th>";
       	echo "<th class=result> Ημερομηνία Διακοπής</th>";
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
            echo "<td align=center> <input type=checkbox name='del_therapy_sw_".$j."'>";
            echo "<input type=hidden name='del_therapy_id_".$j."' value='".$resultrow['therapyid']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "therapyid")
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";
    }
    
mysql_free_result($result);
?>
</div>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>