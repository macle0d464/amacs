<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$clinics_query = "SELECT * FROM clinics";
?>

<HTML><HEAD>
<TITLE>Εγκατάσταση</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>


<FORM id="bioximikes_form" name="bioximikes_form" action="setup_insert.php" method="GET">

<P>
Επιλέξτε την κλινική στην οποία έχετε εγκαταστήσει την βάση δεδομένων:
<SELECT name=Clinic>
        <OPTION value="" selected>- Επιλέξτε -</OPTION>
<?php
	$results = execute_query($clinics_query);		
	$num_clinics = mysql_num_rows($results);
	for ($i = 0; $i < $num_clinics; $i++)
	{
		$row = mysql_fetch_assoc($results);
		$value = $row['ClinicName'];
		$j=$i+1;
		echo "<OPTION value='$j'> $value </OPTION>";
	}
	mysql_free_result($results);
?>              
        </SELECT>
</P>
<?
$result = execute_query("SELECT * FROM setup");
if (mysql_num_rows($result)>0)
{
	$row = mysql_fetch_array($result);
	$clinic = $row[1];
	echo "<script>document.all.Clinic.value='$clinic';</script>";
}
?>
<hr>
<P>
Δώστε τα Normal Ranges και τις μονάδες για τις παρακάτω βιοχημικές εξετάσεις
</P>

<TABLE width=1350>
    <TR>
    <TD></TD><TD></TD>
    <TD></TD>
    </TR>
<?php
for ($k=0; $k< 1; $k++)
{ 
	$i=$k+1
	?>
    <TR>
    <TD><b><u>'Εξέταση</u></b></TD>
    <TD><b><u>Lower1<u></b></TD>
    <TD align="center"><b><u>Upper1</u> </b><BR></TD>
    <TD align="center"><b><u>1η Μονάδα</u></b><BR></TD>
    <TD align="center"><b>&nbsp;&nbsp;&nbsp;</b><BR></TD>
    <TD><b><u>Lower2<u></b></TD>
    <TD align="center"><b><u>Upper2</u> </b><BR></TD>
    <TD align="center"><b><u>2η Μονάδα</u></b><BR></TD>
    <TD align="center"><b>&nbsp;&nbsp;&nbsp;</b><BR></TD>
    <TD><b><u>Lower3<u></b></TD>
    <TD align="center"><b><u>Upper3</u> </b><BR></TD>
    <TD align="center"><b><u>3η Μονάδα</u></b><BR></TD>
    <TD align="center"><b>&nbsp;&nbsp;&nbsp;</b><BR></TD>
    <TD><b><u>Lower4<u></b></TD>
    <TD align="center"><b><u>Upper4</u> </b><BR></TD>
    <TD align="center"><b><u>4η Μονάδα</u></b><BR></TD>
    <TD align="center"><b>&nbsp;&nbsp;&nbsp;</b><BR></TD>
    <TD><b><u>Lower5<u></b></TD>
    <TD align="center"><b><u>Upper5</u> </b><BR></TD>
    <TD align="center"><b><u>5η Μονάδα</u></b><BR></TD>
    </TR>
    <?
    $exams_sql = "SELECT * FROM laboratory_codes";
	$units_sql = "SELECT * FROM units";
	$result = execute_query($units_sql);
	$units = array();
	$str_units = "";
	for ($i=0; $i<mysql_num_rows($result); $i++)
	{
		$row = mysql_fetch_assoc($result);
		$units[$row['ID']]=$row['Unit'];
		$str_units .= "<option value='".$row['ID']."'>".$row['Unit']."</option>";
	}
	mysql_free_result($result);
//	$exams_sql = "SELECT laboratory_codes.Code, laboratory_codes.Description, laboratory_codes.Measurement, laboratory_codes.Upper, laboratory_codes.Lower, units.ID, units.Unit FROM laboratory_codes, units WHERE units.ID=laboratory_codes.Unit1";
    $lab_result = execute_query($exams_sql);
    for ($i=0; $i<mysql_num_rows($lab_result); $i++)
    {
    	$row = mysql_fetch_assoc($lab_result);
    ?>
    <TR>
    <TD><? echo $row['Description'] ?><input type="hidden" name=Code value="<?echo $row['Code'];?>"></TD>
    <TD align="center"><input size=3 name="<?echo $row['Code']?>_Lower1" value="<? echo $row['Lower1']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD align=center><input size=3 name="<?echo $row['Code']?>_Upper1" value="<? echo $row['Upper1']?>">
    </TD>
    <TD align="center">
    <select name='<? echo $row['Code']?>_Unit1'>&nbsp;&nbsp;
    <? echo $str_units ?>
    </select>
    <script>
    document.all.<? echo $row['Code']?>_Unit1.value=
    <?
    if ($row['Unit1']!=NULL)
    {
    	echo $row['Unit1'];
    }
    else
    {
    	echo 0;
    }
    ?>
    </script>
    </TD>
	<td></td>
    <TD align="center"><input size=3 name="<?echo $row['Code']?>_Lower2" value="<? echo $row['Lower2']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD align=center><input size=3 name="<?echo $row['Code']?>_Upper2" value="<? echo $row['Upper2']?>">
    </TD>
    <TD align="center">
    <select name='<? echo $row['Code']?>_Unit2'>&nbsp;&nbsp;
    <? echo $str_units ?>
    </select>
    <script>
    document.all.<? echo $row['Code']?>_Unit2.value=
    <?
    if ($row['Unit2']!=NULL)
    {
    	echo $row['Unit2'];
    }
    else
    {
    	echo 0;
    }
    ?>
    </script>    
    </TD>
	<td></td>
    <TD align="center"><input size=3 name="<?echo $row['Code']?>_Lower3" value="<? echo $row['Lower3']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD align=center><input size=3 name="<?echo $row['Code']?>_Upper3" value="<? echo $row['Upper3']?>">
    </TD>
    <TD align="center">
    <select name='<? echo $row['Code']?>_Unit3'>&nbsp;&nbsp;
    <? echo $str_units ?>
    </select>
    <script>
    document.all.<? echo $row['Code']?>_Unit3.value=
    <?
    if ($row['Unit3']!=NULL)
    {
    	echo $row['Unit3'];
    }
    else
    {
    	echo 0;
    }
    ?>
    </script>    
    </TD>
	<td></td>
    <TD align="center"><input size=3 name="<?echo $row['Code']?>_Lower4" value="<? echo $row['Lower4']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD align=center><input size=3 name="<?echo $row['Code']?>_Upper4" value="<? echo $row['Upper4']?>">
    </TD>
    <TD align="center">
    <select name='<? echo $row['Code']?>_Unit4'>&nbsp;&nbsp;
    <? echo $str_units ?>
    </select>
    <script>
    document.all.<? echo $row['Code']?>_Unit4.value=
    <?
    if ($row['Unit4']!=NULL)
    {
    	echo $row['Unit4'];
    }
    else
    {
    	echo 0;
    }
    ?>
    </script>    
    </TD>
	<td></td>
    <TD align="center"><input size=3 name="<?echo $row['Code']?>_Lower5" value="<? echo $row['Lower5']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </TD>
    <TD align=center><input size=3 name="<?echo $row['Code']?>_Upper5" value="<? echo $row['Upper5']?>">
    </TD>
    <TD align="center">
    <select name='<? echo $row['Code']?>_Unit5'>&nbsp;&nbsp;
    <? echo $str_units ?>
    </select>
    <script>
    document.all.<? echo $row['Code']?>_Unit5.value=
    <?
    if ($row['Unit5']!=NULL)
    {
    	echo $row['Unit5'];
    }
    else
    {
    	echo 0;
    }
    ?>
    </script>    
    </TD>
    </TR>
    <?
    }
    mysql_free_result($lab_result);
	?>

<?php 
}
 ?>          
</TABLE>
<INPUT TYPE="SUBMIT" VALUE="Αποθήκευση Δεδομένων">
</FORM>

</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>