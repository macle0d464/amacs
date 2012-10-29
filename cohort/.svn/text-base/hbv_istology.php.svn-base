<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

$istology_list_query = "SELECT * FROM hcv_istology_list";
$list_result = execute_query($istology_list_query);
$istology_list = array();
for ($i=0; $i<mysql_num_rows($list_result); $i++)
{
	$result = mysql_fetch_assoc($list_result);
	if ($result['AA'] != "0")
	{
		$istology_list[$i]['index'] = $result['AA'];
		$istology_list[$i]['System'] = $result['System'];
		$istology_list[$i]['FibrossisStart'] = $result['FibrossisStart'];
		$istology_list[$i]['FibrossisEnd'] = $result['FibrossisEnd'];
		$istology_list[$i]['ActivityStart'] = $result['ActivityStart'];
		$istology_list[$i]['ActivityEnd'] = $result['ActivityEnd'];
	}
}
?>

<HTML><HEAD>
<TITLE>Καταχώρηση Ιστολογίας 'Ηπατος ασθενούς με HCV συνλοίμωξη</TITLE>
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
	Print_PatientCode_form("hbv_istology.php");
	die();
}
else
{
	check_patient($_GET['code']);
	check_hbv_coinfection($_GET['code']);
}
?>

<FORM id="hbv_istology_form" name="hbv_istology_form" action="hcv_istology_insert.php" method="GET" onsubmit="return check_data()">
<input type="hidden" name=table value=hbv_istology>
<? show_patient_data($_GET['code']); ?>

<P> <b>'Εχει κάνει ο ασθενής βιοψία;</b> &nbsp;
<select name="Biopsy" onchange="show_extra(this.value);">
<option value=0 selected>'Οχι</option>
<option value=1>Ναι</option>
</select></P>

<div id=extra style="display: none;">
<p> Ημερομηνία
    Ημέρα: <select name=ExamDate_day>
    <option value=""></option>
    <? print_options(31); ?>
	</select>&nbsp;
    Μήνας: <select name=ExamDate_month>
    <option value=""></option>
    <? print_options(12); ?>
	</select>&nbsp;
	Έτος: <select name=ExamDate_year>
	<option value=""></option>
    <? print_years(); ?>
	</select> </p>
<p>
Δραστηριότητα νόσου &nbsp;&nbsp;&nbsp; 
<select name=Activity>
<option value=0> - </option>
<option value=1>'Ηπια XH</option>
<option value=2>Μέτρια XH</option>
<option value=3>Σοβαρή XH</option>
</select>
</p>
<p>Σύστημα Βαθμολόγησης 
    <select name=System onchange="show_extra2(this.value);">
    <option value=""> - Επιλέξτε Σύστημα - </option>
<?
	for ($i=0; $i<count($istology_list); $i++)
	{
		echo "<option value=\"".$istology_list[$i]['index']."\">".$istology_list[$i]['System']."</option>\n";
	}
?>    
    </select>
    </p>
<p><u>Σκορ νεκροφλεγμονώδους δραστηριότητας:</u> &nbsp;&nbsp;
	<select name=Grade1>
    <option value=""> - Επιλέξτε Σύστημα - </option>
    </select>    

<!--
	<select name=Grade1_1>
    <option value=""></option>
    <option value="0">0</option>
    <? print_options2(4); ?>
    </select>    
    <select name=Grade1_2 style="display: none">
    <option value=""></option>
    <option value="0">0</option>
    <? print_options2(18); ?>
    </select>
-->
</p>
<p>
<u>Ινωση-Στάδιο νόσου:</u> &nbsp;&nbsp;
    <select name=Grade2>
    <option value=""> - Επιλέξτε Σύστημα - </option>
	<option value="90">Not Applicable</option>
    </select>    
<!--
	<select name=Grade2_1>
    <option value=""></option>
    <option value="0">0</option>
    <? print_options2(4); ?>
    </select>    
    <select name=Grade2_2 style="display: none">
    <option value=""></option>
    <option value="0">0</option>
    <? print_options2(6); ?> 
    </select>
-->
</p>
<p>
Κίρρωση &nbsp;&nbsp;&nbsp; 
<select name=Kirrosi>
<option value=-1> - </option>
<option value=0>OXI</option>
<option value=1>NAI</option>
</select>
</p>
<p>
Βαθμός Στεάτωσης &nbsp;&nbsp;&nbsp; 
<select name=Steatosi>
<option value=-1> - </option>
<option value=1>&lt;=5%</option>
<option value=2>&gt;5% και &lt;=33%</option>
<option value=3>&gt;33% και &lt;=66%</option>
<option value=4>&gt;66%</option>
</select>
</p>
<p><b>Παρακαλούμε να χρησιμοποιείτε την επιλογή «not-applicable» μόνο για τις βιοψίες,<BR>
οι οποίες έχουν γίνει πριν την υιοθέτηση συστήματος βαθμολόγησης της ίνωσης.<BR>
<font color="red">Στις περιπτώσεις αυτές, παρακαλούμε να συμπληρώνεται οπωσδήποτε η πληροφορία για την παρουσία κίρρωσης.
</font></b></p>
</div>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>
<hr>
<h3><a name="view">Καταχωρημένες Εξετάσεις</a> &nbsp;&nbsp;<small><a href="#top">Επιστροφή</a></small></h3>
<?php
$sql = "SELECT hbv_istology.ExamDate, hbv_istology.Activity, l1.System AS System1, hbv_istology.Score1, l2.System AS System2, hbv_istology.Score2, hbv_istology.Kirrosi, hbv_istology.Steatosi, hbv_istology.System1 AS system_id1, hbv_istology.System2 AS system_id2 FROM hbv_istology, hcv_istology_list l1, hcv_istology_list l2 WHERE hbv_istology.System1=l1.AA AND hbv_istology.System2=l2.AA AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
echo mysql_error();
    echo "<form method=get action='delete_istology.php'>";
    echo "<input type=hidden name=count value=".mysql_num_rows($result).">";
    echo "<input type=hidden name=examtable value=hbv_istology>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result> Διαγραφή </th>";
//    echo "<th class=result> Αλλαγή </th>";	
    echo "<th class=result> Ημερομηνία </th>";
    echo "<th class=result> Δραστηριότητα </th>";
    echo "<th class=result> Σκορ νεκροφλεγμονώδους δραστηριότητας </th>";
    echo "<th class=result> Ινωση-Στάδιο νόσου </th>";            
    echo "<th class=result> Κίρρωση </th>"; 
	echo "<th class=result> Βαθμός Στεάτωσης </th>"; 
    echo "</tr>\n";
    for ($j=0; $j<mysql_num_rows($result); $j++)
    {
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center> <input type=checkbox name='del_exam_sw_".$j."'><input type=hidden name='del_exam_date_".$j."' value='".$resultrow['ExamDate']."'><input type=hidden name='del_exam_system1_".$j."' value='".$resultrow['system_id1']."'><input type=hidden name='del_exam_system2_".$j."' value='".$resultrow['system_id2']."'></td>\n";
//			echo "<td align=center><a href='hcv_edit_istology.php?code=".$_GET['code']."&examdate=".$resultrow['ExamDate']."&system1=".$resultrow['system_id1']."&system2=".$resultrow['system_id2']."'><img src='./images/b_edit.png' style='cursor: pointer' border=0></a></td>";                     
            echo "<td class=result>".show_date($resultrow['ExamDate'])."</td>";
            $activity = "";
			switch ($resultrow['Activity'])
            {
            	case 1: 
            		$activity = "'Ηπια XH";
            		break;
            	case 2:
            	    $activity = "Μέτρια XH";
            		break;
            	case 3:
            	    $activity = "Σοβαρή XH";
            		break;
            }
            echo "<td class=result>".$activity."</td>";
            $system1 = $resultrow['System1'];
            $system2 = $resultrow['System2'];
            if ($resultrow['Score1'] != "")
            {
            	echo "<td class=result>Σύστημα: ".$system1.", Σκορ: ".$resultrow['Score1']."</td>";
            }
            else 
            {
            	echo "<td class=result></td>";
            }
            echo "<td class=result>Σύστημα: ".$system2.", Σκορ: ";
			if ($resultrow['Score2'] != "90" && $resultrow['Score2'] != "99")
			{				
				echo $resultrow['Score2'];
			}
			else
			{
				echo "-";
			}
            echo "<td class=result>";
            if ($resultrow['Kirrosi'] == "0")
            {
            	echo "OXI";
            }
            else if ($resultrow['Kirrosi'] == "1")
            {
            	echo "NAI";
            }
            echo "</td>";
            echo "<td class=result>";
            switch ($resultrow['Steatosi'])
            {
            	case -1: 
            		echo "-";
            		break;
            	case 1:
            	    echo "&lt;= 5%";
            		break;
            	case 2:
            	    echo "&gt;5% και &lt;=33%";
            		break;
            	case 3:
            	    echo "&gt;33% και &lt;=66%";
            		break;
            	case 4:
            	    echo "&gt;66%";
            		break;
            }			
			echo "</td>";
			echo "</tr>\n";
    }
        
        echo "</table>";
        echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo " <input type=submit value='Διαγραφή Εξετάσεων'></p>";
        echo "</form>";

mysql_free_result($result);
?>
<script>
function show_extra(value)
{
	if (value == '1')
	{
		document.all.extra.style.display = "";
	}
	else
	{
		document.all.extra.style.display = "none";
	}
}

function show_extra2(value)
{
	var strGrade1_Options = "<option value=''> - Επιλέξτε - </option>\n";
	var strGrade2_Options = "<option value=''> - Επιλέξτε - </option>\n";
	
<?
	for ($i=0; $i<count($istology_list); $i++)
	{
?>
	if (value == <? echo $istology_list[$i]['index'] ?>)
	{
<?
		$start = $istology_list[$i]['ActivityStart'];
		$end = $istology_list[$i]['ActivityEnd'] + 1;
		for ($k=$start; $k<$end; $k++)
		{
?>			
			strGrade1_Options += "<option value='<? echo $k;?>'><? echo $k;?></option>\n";
<?			
		}
		$start = $istology_list[$i]['FibrossisStart'];
		$end = $istology_list[$i]['FibrossisEnd'] + 1;
		for ($k=$start; $k<$end; $k++)
		{
?>			
			strGrade2_Options += "<option value='<? echo $k;?>'><? echo $k;?></option>\n";
<?			
		}		
?>	
	}
<?
	}
?>	
	strGrade2_Options += "<option value='90'>Not Applicable</option>\n";
	document.all.Grade1.innerHTML = strGrade1_Options;
	document.all.Grade2.innerHTML = strGrade2_Options;
}

function check_data()
{
	if (document.all['ExamDate_year'].value == "")
	{
//		alert("Πρέπει να δώσετε το έτος της εξέτασης!");
//		return false;
	}
/*
	if (document.all['ExamDate_month'].value == "")
	{
		alert("Πρέπει να δώσετε τον μήνα της εξέτασης!");
		return false;
	}
	if (document.all['ExamDate_day'].value == "")
	{
		alert("Πρέπει να δώσετε την ημέρα της εξέτασης!");
		return false;
	} */
	if (document.all['System'].value == "")
	{
		if (document.all['Grade2'].value != "90")
		{
			alert("Πρέπει να δώσετε το σύστημα βαθμολόγησης και την ίνωση!");
			return false;
		}
	}	
//	else if (document.all['System'].value == "1")
//	{
//		if (document.all['Grade1'].value == "")
//		{
//			alert("Πρέπει να δώσετε τιμή για την ίνωση!");
//			return false;
//		}
//	}
	else
	{
		if (document.all['Grade2'].value == "")
		{
			alert("Πρέπει να δώσετε τιμή για την ίνωση!");
			return false;
		}
	}	
/*	if (document.all['System2'].value == "1")
	{
		if (document.all['Grade2_2'].value == "")
		alert("Πρέπει να δώσετε τιμή για το σκορ στο 2ο σύστημα βαθμολόγησης!");
		return false;
	}*/							
}
</script>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>
