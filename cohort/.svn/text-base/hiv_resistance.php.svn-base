<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$methods_query = "SELECT * FROM iologikes_methods";
	$methods_result = execute_query($methods_query);		
	$methods = mysql_num_rows($methods_result);
//	$subtype_query = "SELECT HIVSubtype FROM hiv_subtype WHERE PatientCode=".$_GET['code'];
?>

<HTML><HEAD>
<TITLE>Υπότυπος και Αντοχή</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css" />
<script>
// insertAdjacentHTML(), insertAdjacentText() and insertAdjacentElement()
// for Netscape 6/Mozilla by Thor Larholm me@jscript.dk
// Usage: include this code segment at the beginning of your document
// before any other Javascript contents.

if(typeof HTMLElement!="undefined" && !
HTMLElement.prototype.insertAdjacentElement){
HTMLElement.prototype.insertAdjacentElement = function
(where,parsedNode)
{
switch (where){
case 'beforeBegin':
this.parentNode.insertBefore(parsedNode,this)
break;
case 'afterBegin':
this.insertBefore(parsedNode,this.firstChild);
break;
case 'beforeEnd':
this.appendChild(parsedNode);
break;
case 'afterEnd':
if (this.nextSibling)
this.parentNode.insertBefore(parsedNode,this.nextSibling);
else this.parentNode.appendChild(parsedNode);
break;
}
}

HTMLElement.prototype.insertAdjacentHTML = function
(where,htmlStr)
{
var r = this.ownerDocument.createRange();
r.setStartBefore(this);
var parsedHTML = r.createContextualFragment(htmlStr);
this.insertAdjacentElement(where,parsedHTML)
}


HTMLElement.prototype.insertAdjacentText = function
(where,txtStr)
{
var parsedText = document.createTextNode(txtStr)
this.insertAdjacentElement(where,parsedText)
}
}

</script>

<script>
function generate_mutation_fields(area, num)
{
	var html_output = "";
	for (i=1; i<=num; i++)
	{
		html_output += "<INPUT size=5 maxlength=5 name=" + area + "_" + i + "_1 onkeypress=\"return charsonly(event)\">\n \
				 	    <INPUT size=5 maxlength=5 name=" + area + "_" + i + "_2 onkeypress=\"return numbersonly(event)\">\n \
	    			    <INPUT size=5 maxlength=5 id=" + area + "_" + i + "_3 name=" + area + "_" + i + "_3 onkeypress=\"return charsonly(event)\"><BR>\n";
	}
//	html_output += "<span id="+area+"_"+num+"></span>\n <input type='hidden' id='pro_mutations' name='pro_mutations' value='" + num +"'/>\n ";
	html_output += "<input type='hidden' id='" + area + "_mutations' name='" + area + "_mutations' value='" + num +"'/>\n ";
		
	document.write(html_output);
//	document.writeln("<input type='hidden' id='pro_mutations' name='pro_mutations' value='" + num +"'/>");
}
	
function add_mutation_fields(area)
{
	var html_output = "";
	var num = document.getElementById(area + "_mutations").value;
	el_id=area + "_" + num + "_3";
//	alert(el_id);
	el = document.getElementById(el_id);
//	alert(el.innerHTML);
//	el.innerHTML = "<br>skata";
	num++;
	html_output = "<BR><INPUT size=5 maxlength=5 name=" + area + "_" + num + "_1 onkeypress=\"return charsonly(event)\">\n \
			 	   <INPUT size=5 maxlength=5 name=" + area + "_" + num + "_2 onkeypress=\"return numbersonly(event)\">\n \
    			   <INPUT size=5 maxlength=5 id=" + area + "_" + num + "_3 name=" + area + "_" + num + "_3 onkeypress=\"return charsonly(event)\">\n";
//	var r = el.ownerDocument.createRange();
//	r.setStartBefore(el);
//	var parsedHTML = r.createContextualFragment(html_output); 				   
//	el.parentNode.insertBefore(parsedHTML, el.nextSibling); 
    el.insertAdjacentHTML("afterEnd", html_output);
	document.getElementById(area + "_mutations").value++;
}	
</script>

</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<BODY bgcolor="FFCCFF">

<? 
if (isset($_GET['error']))
{
	echo "<center><table><tr><td class='errormsg'>" . $_GET['error'] . "</td></tr></table></center><br>";
}
?>

<?
if (!isset($_GET['code']) || ($_GET['code'] == ""))
{
	Print_PatientCode_form("hiv_resistance.php");
	die();
}
else
{
	check_patient($_GET['code']);
}
?>

<TABLE width="900">
    <TR>
    <TD><? show_patient_data($_GET['code']); ?>
    <TD>
    </TD>
    <TD></TD><TD></TD>
    </TR></TABLE>

<h3> &nbsp; &nbsp; <u>Υπότυπος </u></h3>    
    
<form name="hiv_subtype_form" action="hiv_subtype_insert.php" method="GET">
<input type=hidden name=code value="<? echo $_GET['code'] ?>">

<p> Καταχώρηση Υποτύπου: 
 <select name="HIVSubtype">
 <option value=""></option>
 <option value="A">A</option>
 <option value="B">B</option>
 <option value="C">C</option>
 <option value="D">D</option>
 <option value="F">F</option>
 <option value="G">G</option>
 <option value="H">H</option>
 <option value="J">J</option>
 <option value="K">K</option>
 <option value="U">U</option>
 <!-- 
</select>
 <select name="HIVSubtype2">
 <option value=""></option>
 -->
 <option value="CRF01">CRF01</option>
 <option value="CRF02">CRF02</option>
 <option value="CRF03">CRF03</option>
 <option value="CRF04">CRF04</option>
 <option value="CRF05">CRF05</option>
 <option value="CRF06">CRF06</option>
 <option value="CRF07">CRF07</option>
 <option value="CRF08">CRF08</option>
 <option value="CRF09">CRF09</option>
 <option value="CRF10">CRF10</option>
 <option value="CRF11">CRF11</option>
 <option value="CRF12">CRF12</option>
 <option value="CRF13">CRF13</option>
 <option value="CRF14">CRF14</option>
 </select>
 &nbsp;&nbsp; <b>ή</b> &nbsp;&nbsp; ανασυνδυασμένος: <input name=HIVSubtype_combination>
</p>

<input type="submit" value="Αποθήκευση Υποτύπου">
</form>
<hr>
<h3>Καταχωρημένοι Υπότυποι</h3>
<?
$sql = "SELECT HIVSubtype FROM hiv_subtype WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=get action='delete_subtype.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
        echo "<th class=result>Υπότυπος</th>";
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_subtype_".$j."' value='".$resultrow['HIVSubtype']."'></td>\n";
                echo "<td class=result>".$resultrow['HIVSubtype']."</td>";

            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή'></p>";
        echo "</form>";    
mysql_free_result($result);
?>
<hr>

<h3> &nbsp; &nbsp; <u>Αντοχή </u></h3>   

<FORM id="resistance_form" name="resistance_form" action="resistance_insert.php" method="GET">
<input type=hidden name=PatientCode value="<? echo $_GET['code'] ?>">
    <TABLE width=1200>
    <TR>
    <TD>Κωδικός δείγματος</TD>
    <TD>
    <INPUT size=7 name=SampleID></TD>
    </TR>
    <tr><td></td><td></td></tr>
	<TR>
    <TD>Ημερομηνία λήψης δείγματος
    <BR>
    (<font color=red>ΟΧΙ</font> η ημερομηνία που έγινε το πείραμα)
    </TD>
    <TD>Ημέρα: <select name=SampleDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=SampleDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=SampleDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select></TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Ημερομηνία που έγινε το πείραμα</TD>
    <TD>
    Ημέρα: <select name=SeqDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=SeqDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=SeqDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select>
	</TD>
    </TR>
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Tύπος τέστ</TD>
    <TD>
    <select name=TestType>
    <option value="1">Genotype</option>
    <option value="2">Phenotype</oputtion>
    </select>
    </TD>
    </TR>	
    <TR>
    <TD>Εργαστήριο όπου έγινε ο έλεγχος αντοχής</TD>
    <TD>
    <INPUT class=input name=Lab></TD>
    </TR>    
    <tr><td></td><td></td></tr>
    <TR>
    <TD>Αλγοριθμος που χρησιμοποιήθηκε για<BR>να αναγνωρισθουν τα resistance mutations</TD>
    <TD>
    <INPUT class=input name=Algorithm></TD>
    </TR>
    <tr><td>&nbsp;</td><td></td></tr>
<!--
    <TR>
    <TD>Περιοχή αλληλουχίας</TD>
    <TD>
    <select name=SeqType>
    <option value=""></option>
    <option value="PRO">Περιοχή PRO</option>
    <option value="RT">Περιοχή RT</option>
    <option value="GP41">Περιοχή GP41</option>
    <option value="GP120">Περιοχή GP120</option>
    </select>
    </TD>
    </TR>
    <tr><td>&nbsp;</td><td></td></tr>
-->
    <TR>
    <TD>Μεταλλαγές (στην μορφή AA Position BB, π.χ. M 41 L)</TD>
    <TD>
		<table>
		<tr style="background-color: white">
			<td style='border: solid 1px' valign='top'><p align='center'><b>Περιοχή PRO</b></p>&nbsp;<br>
			<div id=area_PRO>
					<script>generate_mutation_fields("PRO", 5);</script><br>
					<center><span style="color: blue; cursor:pointer; cursor: hand;" onclick="add_mutation_fields('PRO');">Προσθηκη</span></center>
			</div>
			</td>
			<td style='border: solid 1px' valign='top'><p align='center'><b>Περιοχή RT</b></p>&nbsp;<br>
			<div id=area_RT>
					<script>generate_mutation_fields("RT", 5);</script><br>
					<center><span style="color: blue; cursor:pointer; cursor: hand;" onclick="add_mutation_fields('RT');">Προσθηκη</span></center>
			</div>
			</td>
			<td style='border: solid 1px' valign='top'><p align='center'><b>Περιοχή GP41</b></p>&nbsp;<br>
			<div id=area_GP41>
					<script>generate_mutation_fields("GP41", 5);</script><br>
					<center><span style="color: blue; cursor:pointer; cursor: hand;" onclick="add_mutation_fields('GP41');">Προσθηκη</span></center>
			</div>
			</td>
			<td style='border: solid 1px' valign='top'><p align='center'><b>Περιοχή GP120</b></p>&nbsp;<br>
			<div id=area_GP120>
					<script>generate_mutation_fields("GP120", 5);</script><br>
					<center><span style="color: blue; cursor:pointer; cursor: hand;" onclick="add_mutation_fields('GP120');">Προσθηκη</span></center>
			</div>
			</td>									
		</tr>
		<tr style="background-color: white">
			
		</tr>	
		</table>

    </TD>
	</TR>
    <tr><td>&nbsp;</td><td></td></tr>
    <TR>
    <td colspan="2"></td>
    <table><tr>
    <TD>Κωδικός αντιρετροϊκού φαρμάκου - Χαρακτηρισμός αντοχής</TD>
	</tr>
	<tr>
    <TD>
    	<table>
    		<tr>
    			<td>
<?
	$meds_sql = "SELECT m.*, b.Description AS CategoryName FROM medicines m, medicines_categories b WHERE b.ID=m.Category ORDER BY m.Category, m.Name";
	$result = execute_query($meds_sql);
	$previous_category = "0";
	$j=0;
	$medicines = array();
	$categories = array();
	for ($i=0; $i<mysql_num_rows($result); $i++)
	{
		$row = mysql_fetch_object($result);
		$category = $row->Category;
		if ($category != $previous_category)
		{
			$medicines[$category] = array();
			$categories[$category] = $row->CategoryName;
			$previous_category = $category;
			$j = 0;
		}
		$medicines[$category][$j] = array();
		$medicines[$category][$j]['ATCCode'] = $row->ATCCode;
		$medicines[$category][$j]['Medicine'] = $row->Name;
		$medicines[$category][$j]['Description'] = $row->Description;
		$j++;
	}
	mysql_free_result($result);
?>
	<table>
		<tr style="background-color: white">
<?
	for ($j=1; $j<count($categories)+1; $j++)
	{
		echo "<td style='border: solid 1px' valign='top'><p align='center'><b>".$categories[$j]."</b></p>&nbsp;<br><table>";
		$k = $j-1;
		for ($i=0; $i<count($medicines[$j]); $i++)
		{
?>
			<tr valign="top" width="100%"><td>
<?
			echo "<u>".$medicines[$j][$i]['Medicine']. "</u> &nbsp; &nbsp; &nbsp; ";
			if ($categories[$j] == "Αναστολείς πρωτεάσης (PI)")
			{
				echo "<input type=checkbox name='Boosting_".$medicines[$j][$i]['ATCCode']."'/> (*/R) &nbsp; &nbsp; &nbsp; ";
			}
?>			
			<br>
<?
			echo "<code>".$medicines[$j][$i]['Description']."</code>";
?>			
			</td><td><select name=Score_<? echo $medicines[$j][$i]['ATCCode']; ?>>
	 		<option value="-">-</option>
			<option value="R">R</option>
			<option value="I">I</option>
			<option value="S">S</option>			
			</select><td></tr>
<?
		}
		echo "</table></td>";
		if (fmod($j, 4) == 0 && $j <> 0)
		{
			echo "</tr><tr style='background-color: white'>";
		}
	}
?>    				
	</tr>
	</table>
				</td>
    		</tr>
    	</table>
	<p><b><u>Επεξήγηση:</u></b><br>
	R: Ισχυρή αντοχή ή στη διαδικασία ανάπτυξης ισχυρής αντοχής<br>
	I: Να χρησιμοποιηθεί μόνο αν δεν υπάρχουν άλλα φάρμακα διαθέσιμα στα οποία ο ιός είναι ευαίσθητος<br>
	S: Ευαισθησία<br>
	(*/R): Ενίσχυση φαρμάκου με RITONAVIR (Boosting)
	</p>
    </TD>
    </tr>
	</table>
    </td>
    </TR>
    <tr><td>&nbsp;</td><td></td></tr>            
    <tr><td>&nbsp;</td><td></td></tr>    
    </TABLE>
<br>	
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>


<script>
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
	else if ((("ABCDEFGHIJKLMNOPQRSTUVWXYZ/").indexOf(keychar) > -1))
	{
		return true;
	}
	else
	{
	return false;
	}
}
</script>
<hr>
<h3>Καταχωρημένα Στοιχεία Αντοχής</h3>
<?
$sql = "SELECT * FROM hiv_resistance WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=post action='delete_resistance.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	    echo "<input type=hidden name=table value='hiv_resistance'>";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
        echo "<th class=result>Κωδικός<BR>Δείγματος</th>";
        echo "<th class=result>Ημερομηνία<BR>Λήψης</th>";
        echo "<th class=result>Ημερομηνία<BR>Πειράματος</th>";
        echo "<th class=result>Εργαστήριο</th>";
        echo "<th class=result>Αλγόριθμος</th>";
//        echo "<th class=result>Περιοχή</th>";
//        echo "<th class=result colspan=3>Μεταλλαγές</th>";
//        echo "<th class=result>Κωδικός<BR>ART Φαρμάκου</th>";
//        echo "<th class=result>Χαρακτηρισμός<BR>Αντοχής</th>";
        echo "<th class=result>Τύπος<BR>Τέστ</th>";
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
            $i = 1;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_id_".$j."' value='".$resultrow['SampleID']."'>";
            echo "<input type=hidden name='del_date1_".$j."' value='".$resultrow['SampleDate']."'><input type=hidden name='del_date2_".$j."' value='".$resultrow['SeqDate']."'>";
            echo "<input type=hidden name='del_lab_".$j."' value='".$resultrow['Lab']."'><input type=hidden name='del_alg_".$j."' value='".$resultrow['Algorithm']."'></td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name == "TestType")
                {
                	if ($resultrow[$field->name] == 1)
                	{
                		echo "<td class=result>Genotype</td>";
                	}
                	else
                	{
                		echo "<td class=result>Phenotype</td>";
                	}
                }
                else if ($field->name == "SampleDate")
                {
                	echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                }
                else if ($field->name == "SeqDate")
                {
                	echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                }
                else
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή'></p>";
        echo "</form>";
    }
    
mysql_free_result($result);

$sql = "SELECT * FROM hiv_resistance_mutations WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=post action='delete_resistance.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<input type=hidden name=table value='hiv_resistance_mutations'>";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
        echo "<th class=result>Κωδικός<BR>Δείγματος</th>";
        echo "<th class=result>Ημερομηνία<BR>Πειράματος</th>";
        echo "<th class=result>Περιοχή</th>";
        echo "<th class=result colspan=3>Μεταλλαγή</th>";
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
            $i = 1;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_id_".$j."' value='".$resultrow['SampleID']."'>";
            echo "<input type=hidden name='del_date2_".$j."' value='".$resultrow['SeqDate']."'>";
            echo "<input type=hidden name='del_mut1_".$j."' value='".$resultrow['Mutation1']."'>";
            echo "<input type=hidden name='del_mut2_".$j."' value='".$resultrow['Mutation2']."'>";
            echo "<input type=hidden name='del_mut3_".$j."' value='".$resultrow['Mutation3']."'>";
            echo "<input type=hidden name='del_seq_".$j."' value='".$resultrow['SeqType']."'>";												
            echo "</td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name == "Mutation1")
                {
               		echo "<td class=result> ".$resultrow[$field->name];
                }
                else if ($field->name == "Mutation2")
                {
               		echo "&nbsp; ".$resultrow[$field->name];
                }
                else if ($field->name == "Mutation3")
                {
               		echo "&nbsp; ".$resultrow[$field->name]."</td>";;
                }
                else if ($field->name == "SeqDate")
                {
                	echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                }
                else
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή'></p>";
        echo "</form>";
    }
    
mysql_free_result($result);

$sql = "SELECT * FROM hiv_resistance_meds WHERE PatientCode=".$_GET['code'];
$result = execute_query($sql);
    echo "<form method=post action='delete_resistance.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	    echo "<input type=hidden name=table value='hiv_resistance_meds'>";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
        echo "<th class=result> Διαγραφή </th>";
        echo "<th class=result>Κωδικός<BR>Δείγματος</th>";
        echo "<th class=result>Ημερομηνία<BR>Πειράματος</th>";
        echo "<th class=result>Κωδικός<BR>ART Φαρμάκου</th>";
        echo "<th class=result>Boosting</th>";		
        echo "<th class=result>Χαρακτηρισμός<BR>Αντοχής</th>";
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
            $i = 1;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_id_".$j."' value='".$resultrow['SampleID']."'>";
            echo "<input type=hidden name='del_date2_".$j."' value='".$resultrow['SeqDate']."'>";
            echo "<input type=hidden name='del_art_".$j."' value='".$resultrow['ARTCode']."'>";				
            echo "</td>\n";
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                if ($field->name == "Boosting")
                {
                	if ($resultrow[$field->name] == '1')
                	{
                		echo "<td class=result>NAI</td>";
                	}
                	else
                	{
                		echo "<td class=result>OXI</td>";
                	}
                }
                else if ($field->name == "SeqDate")
                {
                	echo "<td class=result>".show_date($resultrow[$field->name])."</td>";
                }
                else
                {
                	echo "<td class=result>".$resultrow[$field->name]."</td>";
                }
                $i++;
            }
            echo "</tr>\n";
        }
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή'></p>";
        echo "</form>";
    }
    
mysql_free_result($result);
?>
</BODY>
</HTML>
<? 	
mysql_close($dbconnection); ?>