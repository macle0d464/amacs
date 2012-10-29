<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$birth_year_query = "SELECT LEFT(BirthDate, 4) FROM patients WHERE PatientCode=".$_GET['code'];
	$entry_query = "SELECT Height FROM clinic_visits WHERE Height!=NULL AND PatientCode=".$_GET['code'];	
?>
<HTML><HEAD>
<TITLE>Καταχώρηση Επίσκεψης Ασθενή σε Κλινική</TITLE>
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
	mysql_free_result($result);
}
?>

<DIV style="position: absolute; left:30px;">

<FORM id="clinics_form" name="clinics_form" action="main_insert.php" method="GET" onsubmit="return check_data();">
<table>
<tr>
<td>
<? 
show_patient_data($_GET['code']); 
?>
<a href="#view">Προβολή Καταχωρήσεων</a>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<table width="900">
<tr>
<td>
Έχει επισκεφθεί ο ασθενής κλινική: &nbsp;&nbsp;&nbsp;
<select name="visit" onchange="show_form(this.value);">
<option value="1">Ναι</option>
<option value="0" selected>'Οχι</option>
</select>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
</table>

<table id="extra_form" style="display: none">
<tr>
<td>
Ημερομηνία Επίσκεψης &nbsp;&nbsp;
</td>
<td>
Ημέρα:
    <select name=DateOfVisit_day>
    <option value="" selected></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=DateOfVisit_month>
    <option value="" selected></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=DateOfVisit_year>
	<option value="" selected></option>
    <? print_years(); ?>
	</select>
</td>
</tr>
<tr>
    <TD>Κλινική: </TD>
    <TD>
        <SELECT name=Clinic onchange="show_other_clinic(this.value);">
        <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
	$clinics_query = "SELECT * FROM clinics";
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
?>
		<OPTION value='<? echo $j ; ?>'> <? echo $value ;?> </OPTION>";
<?
	}
	mysql_free_result($results);
?>
		<option value="99"> 'Αλλη Κλινική (παρακαλώ συμπληρώστε) </option>              
        </SELECT> 
		<input name=OtherClinic id=OtherClinic size=50 style="visibility: hidden" />
		<script type="text/javascript" charset="utf-8">
			function show_other_clinic(v) {
			    if (v == 99) {
			        document.getElementById('OtherClinic').style.visibility='';
			    } else {
			        document.getElementById('OtherClinic').style.visibility='hidden';
			    }
			}
		</script>
		</TD>
</tr>
<tr>
<td>
Βάρος:
</td><td>
<input name=weight size=2 maxlength=3 onkeypress="return numbersonly(event);"> (kg)
</tr>
<?
$result = execute_query($birth_year_query);
$row = mysql_fetch_array($result);
$birth_year = $row[0];
mysql_free_result($result);
$result = execute_query($entry_query);
if (mysql_num_rows($result) >0)
{
	$has_entry = 1;
}
else
{
	$has_entry = 0;
}
mysql_free_result($result);
$todays_date = getdate();
$year = $todays_date['year'];
if ((($year - $birth_year) <= 21) || !$has_entry)
{
?>
<tr>
<td>
'Υψος:
</td><td>
<input name=height size=2 maxlength=3 onkeypress="return numbersonly(event);"> (cm)
</td>
</tr>
<? 
} ?>
<tr>
<td>
Κάπνισμα
</td>
<?
	$result = execute_query("SELECT * FROM clinic_visits WHERE Smoking != '-1' AND PatientCode=".$_GET['code']);
	if (mysql_num_rows($result) == 0) {
?>
<td>
<select name="Smoking" id="Smoking">
<option value="-1" selected> 'Αγνωστο </option>
<option value="0">'Οχι - Ποτέ καπνιστής</option>
<option value="1">Πρώην καπνιστής (όχι το τελευταίο 6μηνο)</option>
<option value="2">Ενεργός καπνιστής</option>
</select>
</td>
<?
	}
	else {
?>
<td>
'Εχουν αλλάξει οι καπνιστικές συνήθειες του ασθενούς: 
<select name=habit>
<option value=0 onclick="document.getElementById('Smoking').style.visibility='hidden';"> OXI </option>
<option value=1 onclick="document.getElementById('Smoking').style.visibility='';"> NAI </option>
</select>
<select name="Smoking" id="Smoking" style="visibility: hidden">
<option value="3">'Εναρξη καπνίσματος</option>
<option value="4">Διακοπή καπνίσματος</option>
</select>
</td>
<?
	}
	mysql_free_result($result);
?>
</tr>
<tr>
<td>
Κατάχρηση Αλκοόλ<BR><b>(>50 gr/ημέρα)</b> &nbsp;&nbsp;
</td>
<td>
<select name=Alcohol>
<option value="0">ΟΧΙ</option>
<option value="1">ΝΑΙ</option>
</select>
</td>
</tr>
<tr>
<td>
Αρτηριακή Πίεση
</td>
<td>
ΣΑΠ <input name=sad size=4 /> mmHg<br>
ΔΑΠ <input name=dap size=4 /> mmHg
</td>
</tr>
<tr>
<td>
Χρήστης Ουσιών &nbsp; <select name=DrugUser>
<option value="-1" onclick="document.getElementById('extra_drug').style.visibility='hidden';"> - </option>
<option value="0" onclick="document.getElementById('extra_drug').style.visibility='hidden';">ΟΧΙ</option>
<option value="1" onclick="document.getElementById('extra_drug').style.visibility='';">NAI</option>
</select> 
</td>
<td>
<span id=extra_drug style="visibility: hidden">
<table>
<tr>
<td>Ηρωίνη</td>
<td>
<select name=heroin>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
<tr>
<td>Χασίς</td>
<td>
<select name=hash>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
<tr>
<td>Κοκαΐνη</td>
<td>
<select name=cocain>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
<tr>
<td>'Αλλο: Όνομα <input name=other_drug_name size=10 /></td>
<td>
<select name=otherdrug>
<option value="-1"> - Επιλέξτε - </option>
<option value="0"> OXI </option>
<option value="1"> ΝΑΙ - Περιστασιακά </option>
<option value="2"> ΝΑΙ - Συστηματικά </option>
</select>
</td>
</tr>
</table>
</span>
</td>
</tr>
<?
$result = execute_query("SELECT Lipoatrofia, Enapothesi FROM atomiko_anamnistiko WHERE PatientCode=".$_GET['code']);
if (mysql_num_rows($result) == 0)
{
	$lipoatrofia = 0;
	$enapothesi = 0;
}
else 
{
	$row = mysql_fetch_array($result);
	$lipoatrofia = $row[0];
	$enapothesi = $row[1];
}
mysql_free_result($result);
if ($lipoatrofia)
{
?>
<tr>
<td>
Λιποατροφία
</td>
<td>
<select name=Lipoatrofia>
<option value="1">Στασιμότητα</option>
<option value="2">Καλυτέρευση</option>
<option value="3">Επιδείνωση</option>
</select>
</td>
</tr>
<tr>
<?
}
if ($enapothesi)
{
?>
<td>
Εναπόθεση
</td>
<td>
<select name=Enapothesi>
<option value="1">Στασιμότητα</option>
<option value="2">Καλυτέρευση</option>
<option value="3">Επιδείνωση</option>
</select>
</td>
</tr>
<?
}
?>
<tr><td>&nbsp;</td></tr>
</table>
<input type="submit" value="Αποθήκευση Δεδομένων">
</form>
<hr>
<a name="view"><h3>Καταχωρημένες Επισκέψεις &nbsp; <a href="#top"><small>Επιστροφή</small></a> </h3></a>
<?php
$sql = "SELECT clinic_visits.DateOfVisit, clinics.ClinicName, clinic_visits.Weight , clinic_visits.Height , clinic_visits.Smoking , clinic_visits.Alcohol , clinic_visits.DrugUser, clinic_visits.Heroin, clinic_visits.Hash, clinic_visits.Cocaine, clinic_visits.OtherDrugName, clinic_visits.OtherDrugValue, clinic_visits.Lipoatrofia, clinic_visits.Enapothesi, clinic_visits.PressureSystolic, clinic_visits.PressureDiastolic, clinic_visits.Clinic FROM clinic_visits, clinics WHERE clinic_visits.Clinic=clinics.ClinicID AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
	echo "<form id=delete_clinics_form method=get action='delete_clinical_visits.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<div id='entries'>";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\" width='950'>\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
	echo "<th class=result> Αλλαγή </th>";	
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Κλινική </th>";
    echo "<th class=result> Βάρος (kg) </th>";
    echo "<th class=result> 'Υψος (cm) </th>";
    echo "<th class=result> Κάπνισμα </th>";
    echo "<th class=result> Κατάχρηση<BR>Αλκοόλ </th>";
    echo "<th class=result> Πίεση<BR>ΣΑΔ </th>";	
    echo "<th class=result> Πιεση<BR>ΔΑΠ </th>";	
    echo "<th class=result> Χρήστης<BR>Ουσιών </th>";
    echo "<th class=result> Ηρωίνη </th>";
    echo "<th class=result> Χασίς </th>";
    echo "<th class=result> Κοκαΐνη </th>";
    echo "<th class=result> 'Αλλη<BR>Ουσία </th>";
    echo "<th class=result> Λιποατροφία </th>";
    echo "<th class=result> Εναπόθεση </th>";        
	
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
            echo "<td align=center> <input type=checkbox name='del_visit_sw_".$j."'><input type=hidden name='del_date_".$j."' value='".$resultrow['DateOfVisit']."'><input type=hidden name='del_clinic_".$j."' value='".$resultrow['Clinic']."'></td>\n";
			echo "<td align=center> <a href='main_edit.php?code=".$_GET['code']."&dateofvisit=".$resultrow['DateOfVisit']."&clinic=".$resultrow['Clinic']."'><img src='images/b_edit.png' border=0 /></a></td>\n";			

                    echo "<td class=result>".$resultrow["DateOfVisit"]."</td>";
                    echo "<td class=result>".$resultrow['ClinicName']."</td>";
                    echo "<td class=result>".$resultrow['Weight']."</td>";
                    echo "<td class=result>".$resultrow['Height']."</td>";
                	if ($resultrow['Smoking'] == "")
                	{
                		echo "<td class=result></td>";
                	}                	
                    elseif ($resultrow['Smoking'] == -1)
                	{
                		echo "<td class=result>'Αγνωστο</td>";
                	}
                	elseif ($resultrow['Smoking'] == 0)
                	{
                		echo "<td class=result>'Οχι - Ποτέ καπνιστής</td>";
                	}
                	elseif ($resultrow['Smoking'] == 1)
                	{
                		echo "<td class=result>Πρώην καπνιστής (όχι το τελευταίο 6μηνο)</td>";
                	}
                	elseif ($resultrow['Smoking'] == 2)
                	{
                		echo "<td class=result>Ενεργός καπνιστής</td>";
                	}
                	elseif ($resultrow['Smoking'] == 3)
                	{
                		echo "<td class=result>'Eναρξη καπνίσματος</td>";
                	}
                	elseif ($resultrow['Smoking'] == 4)
                	{
                		echo "<td class=result>Διακοπή καπνίσματος</td>";
                	}										
                	else 
                	{
                		echo "<td class=result></td>";
                	}	
                	if ($resultrow['Alcohol'] == "")
                	{
                		echo "<td class=result></td>";
                	}                	            
                	elseif ($resultrow['Alcohol'] == 1)
                	{
                		echo "<td class=result>NAI</td>";
                	}
                	else
                  	{
                		echo "<td class=result>OXI</td>";
                	}        
                    echo "<td class=result>".$resultrow["PressureSystolic"]."</td>";
                    echo "<td class=result>".$resultrow["PressureDiastolic"]."</td>";                	
					if ($resultrow['DrugUser'] == "")
                	{
                		echo "<td class=result></td>";
                	} 
                	elseif ($resultrow['DrugUser'] == -1)
                	{
                		echo "<td class=result> - </td>";
                	}
                	elseif ($resultrow['DrugUser'] == 0)
                	{
                		echo "<td class=result>ΟΧΙ</td>";
                	}
                	elseif ($resultrow['DrugUser'] == 1)
                	{
                		echo "<td class=result>ΝΑΙ</td>";
                	}			

                	if ($resultrow['Heroin'] == -1)
                	{
                		echo "<td class=result> - </td>";
                	}
                	elseif ($resultrow['Heroin'] == 0)
                	{
                		echo "<td class=result> ΟΧΙ </td>";
                	}
                	elseif ($resultrow['Heroin'] == 1)
                	{
                		echo "<td class=result> Περιστασιακά </td>";
                	}					
					elseif ($resultrow['Heroin'] == "2")
                	{
                		echo "<td class=result> Συστηματικά </td>";
                	}   		          	
                	 
                	if ($resultrow['Hash'] == -1)
                	{
                		echo "<td class=result> - </td>";
                	}
                	elseif ($resultrow['Hash'] == 0)
                	{
                		echo "<td class=result> ΟΧΙ </td>";
                	}
                	elseif ($resultrow['Hash'] == 1)
                	{
                		echo "<td class=result> Περιστασιακά </td>";
                	}					
					elseif ($resultrow['Hash'] == "2")
                	{
                		echo "<td class=result> Συστηματικά </td>";
                	} 					                	

                	if ($resultrow['Cocaine'] == -1)
                	{
                		echo "<td class=result> - </td>";
                	}
                	elseif ($resultrow['Cocaine'] == 0)
                	{
                		echo "<td class=result> ΟΧΙ </td>";
                	}
                	elseif ($resultrow['Cocaine'] == 1)
                	{
                		echo "<td class=result> Περιστασιακά </td>";
                	}					
					elseif ($resultrow['Cocaine'] == "2")
                	{
                		echo "<td class=result> Συστηματικά </td>";
                	}   

                	if ($resultrow['OtherDrugValue'] == -1)
                	{
                		echo "<td class=result>".$resultrow['OtherDrugName']." - </td>";
                	}
                	elseif ($resultrow['OtherDrugValue'] == 0)
                	{
                		echo "<td class=result>".$resultrow['OtherDrugName']." ΟΧΙ </td>";
                	}
                	elseif ($resultrow['OtherDrugValue'] == 1)
                	{
                		echo "<td class=result>".$resultrow['OtherDrugName']." Περιστασιακά </td>";
                	}					
					elseif ($resultrow['OtherDrugValue'] == "2")
                	{
                		echo "<td class=result>".$resultrow['OtherDrugName']." Συστηματικά </td>";
                	}   					

                	if ($resultrow['Lipoatrofia'] == 1)
                	{
                		echo "<td class=result>Στασιμότητα</td>";
                	}
                	elseif ($resultrow['Lipoatrofia'] == 2)
                	{
                		echo "<td class=result>Καλυτέρευση</td>";
                	}                	
                	elseif ($resultrow['Lipoatrofia'] == 3) 
                  	{
                		echo "<td class=result>Επιδείνωση</td>";
                	}
                	                	else 
                	{
                		echo "<td class=result></td>";
                	}	
                	
                	if ($resultrow['Enapothesi'] == 1)
                	{
                		echo "<td class=result>Στασιμότητα</td>";
                	}
                	elseif ($resultrow['Enapothesi'] == 2)
                	{
                		echo "<td class=result>Καλυτέρευση</td>";
                	}                	
                	elseif ($resultrow['Enapothesi'] == 3) 
                  	{
                		echo "<td class=result>Επιδείνωση</td>";
                	}
                	                	else 
                	{
                		echo "<td class=result></td>";
                	}	       
                //$i++;
            }
            echo "</tr>\n";
        }

        $sql = "SELECT * FROM clinic_visits WHERE Clinic='99' AND PatientCode=".$_GET['code'];
        $result = execute_query($sql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows == 0)
        {
        }
        else
        {
            for ($j=0; $j<$num_rows; $j++)
            {
                $i = 0;
                $resultrow = mysql_fetch_assoc($result);
                echo "<tr>\n";
                echo "<td align=center> <input type=checkbox name='del_visit_sw_".$j."'><input type=hidden name='del_date_".$j."' value='".$resultrow['DateOfVisit']."'><input type=hidden name='del_clinic_".$j."' value='".$resultrow['Clinic']."'></td>\n";
                echo "<td align=center> <a href='main_edit.php?code=".$_GET['code']."&dateofvisit=".$resultrow['DateOfVisit']."&clinic=".$resultrow['Clinic']."'><img src='images/b_edit.png' border=0 /></a></td>\n";          
    
                        echo "<td class=result>".$resultrow["DateOfVisit"]."</td>";
                        echo "<td class=result> 'Αλλη: ".$resultrow['OtherClinic']."</td>";
                        echo "<td class=result>".$resultrow['Weight']."</td>";
                        echo "<td class=result>".$resultrow['Height']."</td>";
                        if ($resultrow['Smoking'] == "")
                        {
                            echo "<td class=result></td>";
                        }                   
                        elseif ($resultrow['Smoking'] == -1)
                        {
                            echo "<td class=result>'Αγνωστο</td>";
                        }
                        elseif ($resultrow['Smoking'] == 0)
                        {
                            echo "<td class=result>'Οχι - Ποτέ καπνιστής</td>";
                        }
                        elseif ($resultrow['Smoking'] == 1)
                        {
                            echo "<td class=result>Πρώην καπνιστής (όχι το τελευταίο 6μηνο)</td>";
                        }
                        elseif ($resultrow['Smoking'] == 2)
                        {
                            echo "<td class=result>Ενεργός καπνιστής</td>";
                        }
                        elseif ($resultrow['Smoking'] == 3)
                        {
                            echo "<td class=result>'Eναρξη καπνίσματος</td>";
                        }
                        elseif ($resultrow['Smoking'] == 4)
                        {
                            echo "<td class=result>Διακοπή καπνίσματος</td>";
                        }                                       
                        else 
                        {
                            echo "<td class=result></td>";
                        }   
                        if ($resultrow['Alcohol'] == "")
                        {
                            echo "<td class=result></td>";
                        }                               
                        elseif ($resultrow['Alcohol'] == 1)
                        {
                            echo "<td class=result>NAI</td>";
                        }
                        else
                        {
                            echo "<td class=result>OXI</td>";
                        }        
                        echo "<td class=result>".$resultrow["PressureSystolic"]."</td>";
                        echo "<td class=result>".$resultrow["PressureDiastolic"]."</td>";                   
                        if ($resultrow['DrugUser'] == "")
                        {
                            echo "<td class=result></td>";
                        } 
                        elseif ($resultrow['DrugUser'] == -1)
                        {
                            echo "<td class=result> - </td>";
                        }
                        elseif ($resultrow['DrugUser'] == 0)
                        {
                            echo "<td class=result>ΟΧΙ</td>";
                        }
                        elseif ($resultrow['DrugUser'] == 1)
                        {
                            echo "<td class=result>ΝΑΙ</td>";
                        }           
    
                        if ($resultrow['Heroin'] == -1)
                        {
                            echo "<td class=result> - </td>";
                        }
                        elseif ($resultrow['Heroin'] == 0)
                        {
                            echo "<td class=result> ΟΧΙ </td>";
                        }
                        elseif ($resultrow['Heroin'] == 1)
                        {
                            echo "<td class=result> Περιστασιακά </td>";
                        }                   
                        elseif ($resultrow['Heroin'] == "2")
                        {
                            echo "<td class=result> Συστηματικά </td>";
                        }                       
                         
                        if ($resultrow['Hash'] == -1)
                        {
                            echo "<td class=result> - </td>";
                        }
                        elseif ($resultrow['Hash'] == 0)
                        {
                            echo "<td class=result> ΟΧΙ </td>";
                        }
                        elseif ($resultrow['Hash'] == 1)
                        {
                            echo "<td class=result> Περιστασιακά </td>";
                        }                   
                        elseif ($resultrow['Hash'] == "2")
                        {
                            echo "<td class=result> Συστηματικά </td>";
                        }                                       
    
                        if ($resultrow['Cocaine'] == -1)
                        {
                            echo "<td class=result> - </td>";
                        }
                        elseif ($resultrow['Cocaine'] == 0)
                        {
                            echo "<td class=result> ΟΧΙ </td>";
                        }
                        elseif ($resultrow['Cocaine'] == 1)
                        {
                            echo "<td class=result> Περιστασιακά </td>";
                        }                   
                        elseif ($resultrow['Cocaine'] == "2")
                        {
                            echo "<td class=result> Συστηματικά </td>";
                        }   
    
                        if ($resultrow['OtherDrugValue'] == -1)
                        {
                            echo "<td class=result>".$resultrow['OtherDrugName']." - </td>";
                        }
                        elseif ($resultrow['OtherDrugValue'] == 0)
                        {
                            echo "<td class=result>".$resultrow['OtherDrugName']." ΟΧΙ </td>";
                        }
                        elseif ($resultrow['OtherDrugValue'] == 1)
                        {
                            echo "<td class=result>".$resultrow['OtherDrugName']." Περιστασιακά </td>";
                        }                   
                        elseif ($resultrow['OtherDrugValue'] == "2")
                        {
                            echo "<td class=result>".$resultrow['OtherDrugName']." Συστηματικά </td>";
                        }                       
    
                        if ($resultrow['Lipoatrofia'] == 1)
                        {
                            echo "<td class=result>Στασιμότητα</td>";
                        }
                        elseif ($resultrow['Lipoatrofia'] == 2)
                        {
                            echo "<td class=result>Καλυτέρευση</td>";
                        }                   
                        elseif ($resultrow['Lipoatrofia'] == 3) 
                        {
                            echo "<td class=result>Επιδείνωση</td>";
                        }
                                            else 
                        {
                            echo "<td class=result></td>";
                        }   
                        
                        if ($resultrow['Enapothesi'] == 1)
                        {
                            echo "<td class=result>Στασιμότητα</td>";
                        }
                        elseif ($resultrow['Enapothesi'] == 2)
                        {
                            echo "<td class=result>Καλυτέρευση</td>";
                        }                   
                        elseif ($resultrow['Enapothesi'] == 3) 
                        {
                            echo "<td class=result>Επιδείνωση</td>";
                        }
                                            else 
                        {
                            echo "<td class=result></td>";
                        }   
                    //$i++;
            }
                echo "</tr>\n";
        }

        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Επίσκεψης'></p>";
    
        echo "</form>";    
?>
</div>
</div>
<script>
function toggle_entries()
{
	if (document.all.entries.style.display == "none")
	{
		document.all.entries.style.display == "";
	}
	else
	{
		document.all.entries.style.display == "none";
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
function show_form(id)
{
	if (id == 1)
	{
		document.all['extra_form'].style.display = "";
	}
	else if (id == 0)
	{
		document.all['extra_form'].style.display = "none";
	}
}

function check_data()
{
	if (document.all['height'].value != "")
	{
		if (document.all['height'].value <10 || document.all['height'].value >250)
		{
			alert("Το ύψος πρέπει να είναι μεταξύ 10 και 250 cm!");
			return false;
		}
	}
	if (document.all['weight'].value != "")
	{	
		if (document.all['weight'].value >250)
		{
			alert("Το βάρος δεν μπορεί να είναι πάνω από 250 kg!");
			return false;
		}
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

<?
$result = execute_query("SELECT * FROM setup");
if (mysql_num_rows($result)>0)
{
	$row = mysql_fetch_array($result);
	$clinic = $row[1];
	echo "document.all.Clinic.value='$clinic';";
}
?>
//		document.all['Clinic'].value = 5;
</script>
</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>