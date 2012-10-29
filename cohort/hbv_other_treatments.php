<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$medicine_before_art_query = "SELECT * FROM hbv_other_meds_before_art";
	$medicine_after_art_query = "SELECT * FROM hbv_other_meds_after_art";
	$reasons_query = "SELECT * FROM hbv_other_reasons";
	$reason_result = execute_query($reasons_query);		
	$reasons = mysql_num_rows($reason_result);
	for ($r=0; $r<$reasons; $r++)
	{
		$row = mysql_fetch_array($reason_result);
   		$reasons_arr[$row['ID']] = $row['Reason'];
    }
	mysql_free_result($reason_result);
	session_start();
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
	mysql_free_result($result);
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Θεραπείων για HBV εκτός αντιρετροϊκών</TITLE>
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
	Print_PatientCode_form("hbv_other_treatments.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hbv_coinfection($_GET['code']);
	session_start();
}
?>

<FORM id="hbv_other_treatments_form" name="hbv_other_treatments_form" action="hbv_other_insert.php" method="GET" onsubmit="return check_data();">
<input type="hidden" name=code value=<?echo $_GET['code']?>>
<input type="hidden" name=artdate value="<? echo $_SESSION['antiretro_startdate']; ?>">
<? show_patient_data($_GET['code']); ?>
<a name="top"></a><a href="#view">
Προβολή Καταχωρημένων Θεραπειών
</a>

<P><b>Υπάρχει θεραπεία για HBV πριν την έναρξη 1ης ART </b>
&nbsp; <select name="before_art" onchange="show_before_art(this.value);">
<option value="0">'Οχι</option>
<option value="1">Ναι</option>
</select>
(δηλαδή πριν την <b><? echo show_date($_SESSION['antiretro_startdate'])?></b> όπου αρχίζει η ART για τον ασθενή)
</P>

<div id=extra_before_art style="display: none">
    <TABLE width=1000>
    </TR>
    <TR>
    <TD class="show">Σχήμα</TD>
    <TD class="show" align="center">Ημερομηνία Έναρξης</TD>
    <TD class="show" align="center">Ημερομηνία Διακοπής </TD>
     <TD class="show" align="center">Αιτία<BR>διακοπής</TD>    
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
    <tr><td><table>
<?php
	$results = execute_query($medicine_before_art_query);		
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
 	<TD><b><? echo $name; ?></b><br><? echo $description; ?></TD><TD><input type="checkbox" name="<? echo $name; ?>_ba" value=<? echo $id; ?> /></TD>
 	</TR>
 	<?  }  ?>
	</table></td>
 	<TD align="center" valign="top">Ημέρα: <select name=StartDate_ba_day>
 	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate_ba_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name=StartDate_ba_year>
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select></TD>
    <TD align="center" valign="top">Ημέρα: <select name=EndDate_ba_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate_ba_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name=EndDate_ba_year onchange="show_one(this.value);">
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select></TD>
    <TD align="center" valign="top"><select name=Reason_ba>
    <option value="0" selected>0</option>
    <? print_opts($reasons); ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./hbv_other_reasons.php?field=Reason_ba', 'Λόγοι', 'width=450,height=300,status=yes');"/>
    </TD>
	</TR>
<?php 
	mysql_free_result($results); ?> 
</TABLE>

</div>


<P><b>Υπάρχει θεραπεία για HBV μετά την έναρξη 1ης ART</b>
&nbsp; <select name="after_art" onchange="show_after_art(this.value);">
<option value="0">'Οχι</option>
<option value="1">Ναι</option>
</select>
</P>

<div id=extra_after_art style="display: none">
<p><b>Καταγράψτε τα <font color=red> εκτός ART φάρμακα</font></b></p>

    <TABLE width=1000>
    </TR>
    <TR>
    <TD class="show">Σχήμα</TD>
    <TD class="show" align="center">Ημερομηνία Έναρξης</TD>
    <TD class="show" align="center">Ημερομηνία Διακοπής </TD>
     <TD class="show" align="center">Αιτία<BR>διακοπής</TD>    
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD></TR>
    <tr><td><table>
<?php
	$results = execute_query($medicine_after_art_query);		
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
 	<TD><b><? echo $name; ?></b><br><? echo $description; ?></TD><TD><input type="checkbox" name="<? echo $name; ?>_aa" value=<? echo $id; ?> /></TD>
 	</TR>
 	<?  }  ?>
	</table></td>
 	<TD align="center" valign="top">Ημέρα: <select name=StartDate_aa_day>
 	<option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=StartDate_aa_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name=StartDate_aa_year>
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select></TD>
    <TD align="center" valign="top">Ημέρα: <select name=EndDate_aa_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=EndDate_aa_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
    Έτος: <select name=EndDate_aa_year onchange="show_two(this.value);">
    <option value=""></option>
    <? print_years2(); ?>
    <option value=""></option>
	</select></TD>
    <TD align="center" valign="top"><select name=Reason_aa>
    <option value="0" selected>0</option>
    <? print_opts($reasons); ?>
    </select>
    <img src="./images/b_help.png" style="cursor: pointer" onclick="window.open('./hbv_other_reasons.php?field=Reason_aa', 'Λόγοι', 'width=450,height=300,status=yes');"/>
    </TD>
	</TR>
<?php 
	mysql_free_result($results); ?> 
</TABLE>
</div>



<p><INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων"></p>
</FORM>
<hr>
<a name="view"><h3>Καταχωρημένες Θεραπείες (πριν την έναρξη 1ης ART) &nbsp; <a href="#top"><small>Επιστροφή</small></a> </h3></a>
<div>
<?php
$sql = "SELECT Schema, StartDate, EndDate, Reason FROM hbv_other_treatments_before_art WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_hbv_other_treatments.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=hbv_other_treatments_before_art>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result>Θεραπευτικό Σχήμα</th>";
   	echo "<th class=result>Ημερομηνία Έναρξης</th>";
   	echo "<th class=result>Ημερομηνία Διακοπής</th>";
   	echo "<th class=result>Αιτία Διακοπής</th>";
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
            echo "<input type=hidden name='del_therapy_id_".$j."' value='".$resultrow['Schema']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";

            for ($i = 0; $i < 4; $i++)
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "Reason")
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
                else
                {
                	echo "<td class=result>".$reasons_arr[$resultrow[$field->name]]."</td>";
                }
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
<hr>
<a name="view"><h3>Καταχωρημένες Θεραπείες (μετά την έναρξη 1ης ART) &nbsp; <a href="#top"><small>Επιστροφή</small></a> </h3></a>
<div>
<?php
$sql = "SELECT Schema, StartDate, EndDate, Reason FROM hbv_other_treatments_after_art WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_hbv_other_treatments.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=hbv_other_treatments_after_art>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
    echo "<th class=result>Θεραπευτικό Σχήμα</th>";
   	echo "<th class=result>Ημερομηνία Έναρξης</th>";
   	echo "<th class=result>Ημερομηνία Διακοπής</th>";
   	echo "<th class=result>Αιτία Διακοπής</th>";
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
            echo "<input type=hidden name='del_therapy_id_".$j."' value='".$resultrow['Schema']."'></td>\n";
            echo "<input type=hidden name='del_therapy_startdate_".$j."' value='".$resultrow['StartDate']."'></td>\n";
            echo "<input type=hidden name='del_therapy_enddate_".$j."' value='".$resultrow['EndDate']."'></td>\n";

            for ($i = 0; $i < 4; $i++)
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name != "Reason")
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
                else
                {
                	echo "<td class=result>".$reasons_arr[$resultrow[$field->name]]."</td>";
                }                
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
</BODY>
<script>
function show_before_art(value)
{
	if (value == 1)
	{
		document.all['extra_before_art'].style.display = "";
	}
	if (value == 0)
	{
		document.all['extra_before_art'].style.display = "none";
	}
}
function show_after_art(value)
{
	if (value == 1)
	{
		document.all['extra_after_art'].style.display = "";
	}
	if (value == 0)
	{
		document.all['extra_after_art'].style.display = "none";
	}
}

function doc(el)
{
	return document.all[el].value;
}

function check_data()
{
	if ((doc("StartDate_ba_year") != "") && (doc("StartDate_ba_month") != "") && (doc("StartDate_ba_day") != ""))
	{
		start_date = doc("StartDate_ba_year") + "-" + doc("StartDate_ba_month") + "-" + doc("StartDate_ba_day");
		art_date = document.all['artdate'].value;
		if (start_date > art_date)
		{
			alert("Η ημερομηνία έναρξης θεραπείας πριν την 1η ART δεν μπορεί να είναι μετά από τις " + $_SESSION['antiretro_startdate'] + "!");
			return false;
		}
	}
}
</script>
</HTML>
<? 	mysql_close($dbconnection); ?>