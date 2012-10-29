<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
?>

<HTML><HEAD>
<TITLE>Προβολή-Αλλαγή Αντι-ιικών Θεραπειών</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?php
$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

//if ($_GET['code'] == "" || !is_numeric($_GET['code']))
//{ die('Πρέπει να δωσετε ένα σωστό Κωδικό Ασθενή!'); }
check_patient($_GET['code']);

echo "<P><B> Αλλαγή Δόσης για το φάρμακο ".$_GET['Medicine']."</B></P>";
$sql = "SELECT * FROM hbv_antiiikes_treatments_dosages WHERE StartDate='".$_GET['start']."' AND EndDate='".$_GET['end']."' AND Medicine='".$_GET['Medicine']."' AND link_id='".$_GET['link_id']."' AND PatientCode=".$_GET['code'];
$result = execute_query($sql);
$row = mysql_fetch_assoc($result);
echo mysql_error();
    echo "<form method=get action='hbv_edit_dosage_insert.php' onsubmit='return check_data();'>";
    echo "<input type=hidden name=code value=".$_GET['code'].">";
    echo "<input type=hidden name=start value=".$_GET['start'].">";
    echo "<input type=hidden name=end value=".$_GET['end'].">";
    echo "<input type=hidden name=link_id value=".$_GET['link_id'].">";
    echo "<input type=hidden name=Medicine value=".$_GET['Medicine'].">";
    echo "<b>1η Δόση:</b>";
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    echo "<tr>\n";
    $i = 0;
	echo "<th class=result>Φάρμακο</th>";
	echo "<td class=result>".$_GET['Medicine']."</td>";
	echo "</tr>\n";
	echo "<th class=result>Ημερομηνία<BR>Έναρξης</th>";
	echo "<td class=result>".show_date($row['StartDate'])."</td>";
	echo "</tr>\n";	
	echo "<th class=result>Ημερομηνία<BR>Διακοπής</th>";
	echo "<td class=result>".show_date($row['EndDate'])."</td>";
	echo "<tr>";
	echo "<th class=result>Δόση</th>";
	echo "<td class=result>";
	$name = $_GET['Medicine'];
?>	
	<input name="dosage1<?echo $id?>" size=6 value="<?echo $row['Dosage1']?>"> 
 	<select name="dosage1type<?echo $id?>">
 	<?
 	if ($name == "IFNα") 
 	{
 	?>
    <option value="MU">MU</option>
	<option value="mg">mg</option>
    <?
	}
	else if ($name == "PEG-IFNα-2α")
 	{
 	?>
 	<option value="μg">μg</option>
    <?
	}
	else if ($name == "PEG-IFNα-2b")
 	{
 	?> 	
 	<option value="μg">μg</option>
 	<option value="μg/kg">μg/Kg</option>
    <?
	}
	else
	{
	?>
 	<option value="mg">mg</option>
	<?
	}
 	?> 	
 	</select>
 	/ 
 	<select name="dosage2type<?echo $id?>">
 	<option value="1">1 φορά / εβδ.</option>
 	<option value="2">2 φορές / εβδ.</option>
	<?
//	if ($name != "Amantadine")
// 	{
 	?> 	 	
 	<option value="3">3 φορές / εβδ.</option>
 	<option value="4">4 φορές / εβδ.</option>
 	<option value="5">5 φορές / εβδ.</option>
 	<option value="6">6 φορές / εβδ.</option>
 	<option value="7">Καθημερινά</option>
 	<?
 //	}
 	echo "</select>";	
	echo "<td>";
	echo "</tr></table>";
    echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo " <input type=submit value='Αλλαγή Δόσης'></p>";
    echo "</form>";
    

echo "<p>&nbsp;</p>\n";
//print_r($resultrow);
?>
<script>
document.all.dosage1type.value = "<?echo $row['Dosage1Type'];?>";
document.all.dosage2type.value = "<?echo $row['Dosage2Type'];?>";
</script>
<?
mysql_close($dbconnection);
?>
</BODY></HTML>
