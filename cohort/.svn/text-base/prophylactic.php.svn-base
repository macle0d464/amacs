<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$reasons_query = "SELECT * FROM prophylactic_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Προφυλακτικών Θεραπείων</TITLE>
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
	Print_PatientCode_form("prophylactic.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<FORM id="prophylactic_form" name="prophylactic_form" action="prophylactic_insert.php" method="GET">
<input type="hidden" name=code value=<?echo $_GET['code']?> >

<a name="top"></a>
<P>Συμπληρώστε τα παρακάτω πεδία αν ο ασθενής δέχεται προφυλακτική θεραπεια για τα παρακάτω νοσήματα</P>

<TABLE width=1000>
    <TR>
    <TD colspan=4><? show_patient_data($_GET['code']); ?>
    <a href="#view">Προβολή Θεραπειών Ασθενή</a></TD>
    <TR><TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
    </TR>
    <TR>
    <TD class="showc" colspan=2>Προφυλακτική<BR>Θεραπεία για</TD>
    <TD class="showc">Τύπος<font color="Red">*</font></TD>
    <TD class="showc">
     Ημερομηνία Έναρξης</TD>
    <TD class="showc">Ημερομηνία Διακοπής</TD>
     <TD class="showc">Αιτία<BR>Διακοπής</TD>
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?
	$therapies_query = "SELECT * FROM prophylactic_therapies_list";
	$result = execute_query($therapies_query);
	for ($k=0; $k<mysql_num_rows($result); $k++)
	{
		$row = mysql_fetch_assoc($result);
?>	
	<TR>
    <TD align="center"><INPUT type="checkbox" name=Therapy<?echo $k?>></td><td>
    <? echo $row['Therapy']; ?>
    </TD>
    <TD align="center">
    <SELECT name=Type<?echo $k?>>
<!--    <option value=""> - </option> -->
    <? print_options(2); ?>
    </SELECT> &nbsp;&nbsp;&nbsp;
    </TD>
    <TD <? if ($_GET['errnum'] == 3) {echo "class='show'";} ?>>
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
    <TD align="center">
    <SELECT name=Reason<?echo $k?>>
    <option value="4" selected> 4 </option>
    <? print_opts($reasons); ?>
    </SELECT>
    <img src="./images/b_help.png" style="cursor: default" onclick="window.open('./prophylactic_reasons.php?field=Reason<?echo $k?>&Note=extra_notes_<?echo $k;?>', 'Λόγοι', 'width=450,height=300,status=yes');"/>
    </TD>
	</TR>
	<TR id="extra_notes_<? echo $k; ?>" style="display: none;">
	<TD></TD><TD></TD>
	<TD colspan=4><b>Σημειώσεις για <?echo $row['Therapy'];?>:</b> <INPUT NAME="Note<? echo $k; ?>" size="100" maxlength="255"></TD>  
	</TR>
<? } ?>
	<input type="hidden" name="therapies" value="<? echo mysql_num_rows($result); ?>">
	</TABLE>
<hr>
<table>
<tr>
<td colspan=2><b>Φάρμακα που έχει λάβει ο ασθενής</b></td>
</tr>
<?
	$results = execute_query("SELECT * FROM prophylactic_meds");
	$num = mysql_num_rows($results);
	for ($i = 0; $i < $num; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$id = $row['ID'];
		$name = $row['Med'];
		$description = $row['Description'];
		$j = $i+1;
?>
	<tr>
	<td valign=top><input type="checkbox" name="<? echo $name ?>"> </td>
	<td> <? echo $description ?></td>
	</tr>
<?
	}
?>
</table>
<hr>
	
<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων"></p>
<p>&nbsp;</p>
<p>(<font color="Red">*</font>) Τύπος: 1. Πρωτογενής, 2. Δευτερογενής</p>
</FORM>
<hr>
<a name="view"><h3>Καταχωρημένες Προφυλακτικές Θεραπείες &nbsp; <a href="#top"><small>Επιστροφή</small></a> </h3></a>
<div>
<?php
$sql = "SELECT prophylactic_therapies.Therapy as therapyid, prophylactic_therapies_list.Therapy, Type, StartDate, EndDate, prophylactic_reasons.Reason as reason, prophylactic_therapies.Reason as reason2, Meds Note FROM prophylactic_therapies,prophylactic_therapies_list, prophylactic_reasons WHERE prophylactic_therapies.Therapy = prophylactic_therapies_list.ID AND prophylactic_therapies.Reason = prophylactic_reasons.ID AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_therapies.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=prophylactic_therapies>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result>Θεραπεία</th>";
    echo "<th class=result>Τύπος</th>";
   	echo "<th class=result>Ημερομηνία Έναρξης</th>";
   	echo "<th class=result>Ημερομηνία Διακοπής</th>";
   	echo "<th class=result>Αιτία Διακοπής</th>";
   	echo "<th class=result>Φάρμακα</th>";
//   	echo "<th class=result>Σημειώσεις</th>";
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
            echo "<input type=hidden name='del_therapy_type_".$j."' value='".$resultrow['Type']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_reason_".$j."' value='".$resultrow['reason2']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "id" && $field->name != "therapyid" && $field->name != "reason2")
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