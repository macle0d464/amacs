<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
	$neoplasmata_query = "SELECT * FROM neoplasmata_descriptions";
	$clinicalstates_query = "SELECT * FROM clinical_states_descriptions";
?>

<HTML><HEAD>
<TITLE>���������� ������������� ���������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<style type="text/css">
<!--
body,td,th,input,select {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
td.errormsg {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold; background-color: white; color: red
}
td.show {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style></HEAD>

<BODY bgcolor="FFCCFF">

<? 
if (isset($_GET['error']))
{
	echo "<center><table><tr><td class='errormsg'>" . $_GET['error'] . "</td></tr></table></center><br>";
}
?>

<FORM id="antiretro_form" name="antiretro_form" action="antiretro_insert.php" method="GET">
<input type="hidden" name="exams" value="<? echo $_GET['exams'] ?>">

<P>20�. ����������� ��� �� ������� ��� ���� ����� � ������� ����� �� ���������� ����� ��� �������
</P>

<TABLE>
    <TR>
    <TD <? if ($_GET['errnum'] == 1) {echo "class='show'";} ?>> 1�. ������� ������ &nbsp;&nbsp;&nbsp;
    <INPUT maxLength=5 size=5 name="PatientCode"></TD><TD></TD>
    <TD <? if ($_GET['errnum'] == 2) {echo "class='show'";} ?>> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    1�. ������� ��� &nbsp;&nbsp;&nbsp;
    <INPUT maxLength=5 size=5 name="MELCode"></TD>
    <TD></TD><TD></TD>
    </TR></TABLE>
    <TABLE width=1100>
    </TR>
    <TR>
    <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp; �����������<BR>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbsp; �����</TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     ����������<BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     �������</TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     ����������<BR>
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     �������� </TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;�����<BR>��������</TD>
    <TD class="show">&nbsp;&nbsp;&nbsp;������������<BR>&nbsp;&nbsp;&nbsp;&nbsp;���������</TD>
     <TD class="show">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     �������������� �������</TD>     
    </TR>
    <TR><TD></TD><TD></TD><TD></TD><TD></TD><TD></TD></TR>
<?php
for ($k=0; $k< $_GET['exams']; $k++)
{ 
	$i=$k+1;
	?>
	<TR>
 	<TD><INPUT class=input size=20 name=Schema<?echo $k?> /></TD> <!-- onclick="window.open('http://localhost/cohort/medicines.php?where=Schema<?echo $k?>')" -->
 	<TD>&nbsp;&nbsp;
    �����: <INPUT class=input maxLength=2 onchange=DirtyRecord(); size=2 
    name=StartDate<?echo $k?>_day>&nbsp;
    �����: <INPUT class=input maxLength=2 onchange=DirtyRecord(); size=2
    name=StartDate<?echo $k?>_month>&nbsp;
    ����: <INPUT class=input maxLength=4 onchange=DirtyRecord(); size=4 
      name=StartDate<?echo $k?>_year></TD>
    <TD> &nbsp;&nbsp;
    �����: <INPUT class=input maxLength=2 onchange=DirtyRecord(); size=2 
    name=EndDate<?echo $k?>_day>&nbsp;
    �����: <INPUT class=input maxLength=2 onchange=DirtyRecord(); size=2
    name=EndDate<?echo $k?>_month>&nbsp;
    ����: <INPUT class=input maxLength=4 onchange=DirtyRecord(); size=4 
      name=EndDate<?echo $k?>_year></TD>
    <TD>&nbsp;&nbsp;&nbsp;&nbsp; <INPUT TYPE="text" size=1 maxlength="1" name=Reason<?echo $k?>></TD>
    <TD>&nbsp;&nbsp; <INPUT TYPE="text" size=1 maxlength="1" name=Unwanted1_<?echo $k?>>
    <INPUT TYPE="text" size=1 maxlength="1" name=Unwanted2_<?echo $k?>> 
    <INPUT TYPE="text" size=1 maxlength="1" name=Unwanted3_<?echo $k?>></TD>
    <TD>&nbsp;&nbsp;<INPUT TYPE="text" size=15 name=Drugs1_<?echo $k?>>
     <INPUT TYPE="text" size=15 name=Drugs2_<?echo $k?>></TD>
	</TR>
<?php } ?> 
</TABLE>

<P>'���� ����� �������� <INPUT TYPE="text" size=30 name=OtherReason>
&nbsp;&nbsp;&nbsp;&nbsp; '���� ����������� �������� <INPUT TYPE="text" size=30 name=OtherUnwanted></P>



<P>20�. ���������� ��������:<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 ���������� �� ���� ��� ������ ��� ����� � ������� ��� ��������� ��������: 
 <INPUT TYPE="text" name=LastWeekLostDosePercentile size=2 maxlength="3"> %
</P>

<INPUT TYPE="SUBMIT" VALUE="���������� ���������">
</FORM>
</BODY>
</HTML>
<? 	mysql_close($dbconnection); ?>