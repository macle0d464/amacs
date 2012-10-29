<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
function draw2_table($result)
{
    echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"1\">\n";
    echo "<tr>\n";
    echo "<th class=result>Κωδικός Ασθενή</th>";
	echo "<th class=result>'Ονομα</th>";
	echo "<th class=result>Επώνυμο</th>";	
	echo "<th class=result>Ημερομηνία<BR>Γέννησης</th>";
	echo "<th class=result>Τελευταία επίσκεψη<BR>στην κλινική</th>";	
	echo "<th class=result>Αιτία \"Lost to Follow Up\"</th>";	
    echo "</tr>\n";
    $num_rows = mysql_num_rows($result);
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            echo "<tr>\n";
            echo "<td align=center class=result>";
            echo "<a href='intermediate.php?code=".$resultrow['PatientCode']."'>".$resultrow['PatientCode']."</a>";
            echo "</td>";
            echo "<td align=center class=result>";
            echo $resultrow['Name'];
            echo "</td>";
            echo "<td align=center class=result>";
            echo $resultrow['Surname'];
            echo "</td>";
            echo "<td align=center class=result>";
            echo show_date($resultrow['BirthDate']);
            echo "</td>";
            echo "<td align=center class=result>";
            echo show_date($resultrow['MAX(DateOfVisit)']);
            echo "</td>";
            echo "<td align=center class=result>";
            if ($resultrow['Lost2FollowUp'] == 1)
            {
            	echo "Ο ασθενής δεν έχει εμφανιστεί τον τελευταίο χρόνο";
            }
            else if ($resultrow['Lost2FollowUp'] == 4)
            {
            	echo "Απόφαση Ασθενούς";
            }
            else 
            {
            	echo "'Aλλη αιτία";
            }
            echo "</td>";                                                              
            echo "</tr>\n";
        }
    echo "</table>";
}	

session_start();
session_unregister("PatientCode");

?>

<HTML><HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<p>&nbsp; </p>
<p>&nbsp; </p>
<?
$query1 = "SELECT Count(PatientCode) FROM patients";

$query2  = "SELECT clinic_visits.PatientCode, Name, Surname, BirthDate, MAX(DateOfVisit) ";
$query2 .= "FROM clinic_visits, patients,last_state ";
$query2 .= "WHERE patients.PatientCode=clinic_visits.PatientCode AND patients.PatientCode=last_state.PatientCode AND ";
$query2 .= "last_state.LastState=1 ";
$query2 .= "GROUP BY PatientCode ";
$query2 .= "HAVING DATEDIFF(NOW(), MAX(DateOfVisit))>180 AND DATEDIFF(NOW(), MAX(DateOfVisit))<365 ";

$query3  = "SELECT clinic_visits.PatientCode, Name, Surname, BirthDate, MAX(DateOfVisit) ";
$query3 .= "FROM clinic_visits, patients,last_state ";
$query3 .= "WHERE patients.PatientCode=clinic_visits.PatientCode AND patients.PatientCode=last_state.PatientCode AND ";
$query3 .= "last_state.LastState=1 ";
$query3 .= "GROUP BY PatientCode ";
$query3 .= "HAVING DATEDIFF(NOW(), MAX(DateOfVisit)) > 364";

$query4 =  "SELECT clinic_visits.PatientCode, Name, Surname, BirthDate, MAX(DateOfVisit), Lost2FollowUp ";
$query4 .= "FROM last_state, patients,clinic_visits ";
$query4 .= "WHERE patients.PatientCode=clinic_visits.PatientCode AND patients.PatientCode=last_state.PatientCode ";
$query4 .= "AND LastState=3 AND (Lost2FollowUp=1 OR Lost2FollowUp=4 OR Lost2FollowUp=6) ";
$query4 .= "GROUP BY PatientCode ";
$query4 .= "HAVING DATEDIFF(NOW(), MAX(DateOfVisit))>364 AND DATEDIFF(NOW(), MAX(DateOfVisit)) < 732 ";

$result = execute_query($query1);
$row = mysql_fetch_assoc($result);
$num = $row['Count(PatientCode)'];
echo "<P>Υπάρχουν $num καταχωρημένοι ασθενείς στη βάση δεδομένων</P><hr>";
$result = execute_query($query2);
//echo mysql_error();
$num = mysql_num_rows($result);
if ($num > 0)
{
	echo "<P>Υπάρχουν <b>$num</b> καταχωρημένοι ασθενείς για τους οποίους <b>δεν έχει γίνει ενημέρωση των κλινικών επισκέψεων εδώ και 6 μήνες</b><BR>";
	echo "Κάντε click <a href='#' onclick='show();'>εδώ</a> για να τους δείτε</P>";
?> 
<div id=data style="display: none">
<?
	draw_table($result);
?>
</div>
<?
}

$result = execute_query($query3);
//echo mysql_error();
$num2 = mysql_num_rows($result);
if ($num2 >0)
{
	echo "<hr><P>Υπάρχουν <b>$num2</b> καταχωρημένοι ασθενείς για τους οποίους <b>δεν έχει γίνει ενημέρωση των κλινικών επισκέψεων εδώ και 1 χρόνο</b> <i>(πιθανοί \"Lost to Follow Up\")</i><BR>";
	echo "Παρακαλώ <b><font color='red'>ενημερώστε</font> την τελευταία κατάστασή</b> τους</p>";	
	echo "Κάντε click <a href='#' onclick='show2();'>εδώ</a> για να τους δείτε</P>";
?> <div id=data2 style="display: none"> <?
	draw_table($result);
}
?>
</div>
<?
$result = execute_query($query4);
$num3 = mysql_num_rows($result);
?>
<hr>
<?
if ($num3 > 0)
{
?>
<p>Οι παρακάτω ασθενείς:</p>
<?
draw2_table($result);
?>
<p>
έχουν δηλωθεί ως "Lost to Follow Up". Παρακαλώ ελέγξτε αν υπάρχει αλλαγή στην κατάσταση τους.
</p>
<hr>
<?
}
?>

<script>
function show()
{
	if (document.all.data.style.display == "none")
	{
		document.all.data.style.display = "block";
	}
	else
	{
		document.all.data.style.display = "none";
	}
}
function show2()
{
	if (document.all.data2.style.display == "none")
	{
		document.all.data2.style.display = "block";
	}
	else
	{
		document.all.data2.style.display = "none";
	}
}
</script>

</BODY></HTML>

<?
mysql_close($dbconnection);
?>