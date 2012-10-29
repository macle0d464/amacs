<body bgcolor=CCFFCC>
<? //UPDATE `patient_other_clinical_state` SET `ClinicalStatusID` = '4' WHERE `MELCode` =891 AND `ClinicalStatusID` =3 AND `ClinicalStatusDate` = '2005-01-01' LIMIT 1 ;
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');
PrintMenu2();
?>
&nbsp;
<table>
<tr>
<td>Δώστε την κλινική κατάσταση του ασθενή </td>
<td> &nbsp;
<SELECT name=Status>
<OPTION VALUE="A1">A1: CD4 >= 500/μL</OPTION>
<OPTION VALUE="A2">A2: CD4 200-499 μL</OPTION>
<OPTION VALUE="A3">A3: CD4 < 200 μL</OPTION>
<OPTION VALUE="B1">B1: CD4 >= 500/μL</OPTION>
<OPTION VALUE="B2">B2: CD4 200-499 μL</OPTION>
<OPTION VALUE="B3">B3: CD4 < 200 μL</OPTION>
<OPTION VALUE="C1">C1: CD4 >= 500/μL</OPTION>
<OPTION VALUE="C2">C2: CD4 200-499 μL</OPTION>
<OPTION VALUE="C3">C3: CD4 < 200 μL</OPTION>
</SELECT>
</td>
<tr>
</table>

<P>'Οπου:</P>
<UL>
<LI>Κατηγορία Α: &nbsp; Ασυμπτωτική, οξεία (προτωγενής) HIV λοίμωξη ή Επιμένουσα Γενικευμένη Λεμφαδενοπάθεια</LI>
<LI>Κατηγορία B: &nbsp; Συμπτωματική HIV λοίμωξη</LI>
<LI>Κατηγορία C: &nbsp; Καθοριστικοί Νόσοι AIDS</LI>
</UL>

<P class="show">12. Εχει ο ασθενής αναπτύξει AIDS (CDC-C)? (Παράρτημα A):
<INPUT type="radio" name="HasAIDS" value="1" onclick="document.all.catc.style.display=''; document.all.catb.style.display=''; document.all.cata.style.display=''; document.all.CategoryB.value=1;"> Ναι
<INPUT type="radio" name="HasAIDS" value="0" onclick="document.all.catc.style.display='none';"> 'Οχι
</P>

<b>'Επανεμφάνιση ήδη δηλωμένου κλινικού συμπτώματος</b>
     
	<BR>
	<SELECT name=ReccurenceSymptom0> 
    <OPTION value="" selected>- Επιλέξτε -</OPTION>
<OPTION value='1'>Βακτηριακή αγγειωμάτωση</OPTION>
<OPTION value='2'>Καντιντίαση στόματος-φάρυγγος</OPTION>

<OPTION value='3'>Καντιντίαση αιδοιοκολπική (επιμένουσα, συχνή ή μη ανταποκρινόμενη σε θεραπεία)</OPTION>
<OPTION value='4'>Δυσπλασία τραχήλου της μήτρας (μέση η βαρεία) / in situ καρκίνωμα του τραχήλου της μήτρας</OPTION>
<OPTION value='5'>Μή ειδικά συμπτώματα, όπως πυρετός (38,5 &#186;C)  ή διάρροια για περισσότερο απο 1 μήνα</OPTION>
<OPTION value='6'>Στοματική λευκοπλακία</OPTION>
<OPTION value='7'>Ερπης ζωστήρ, με δύο τουλάχιστον διαφορετικά επεισόδια ή καταλαμβάνων περισσότερα από ένα δερμοτόμια</OPTION>
<OPTION value='8'>Ιδιοπαθής θρομβοπενική πορφύρα</OPTION>
<OPTION value='9'>Λιστερίωση</OPTION>
<OPTION value='10'>Φλεγμονώδης νόσος της πυέλου</OPTION>

<OPTION value='11'>Περιφερική νευροπάθεια</OPTION>
</SELECT>     
    &nbsp;&nbsp; Ημέρα: 
    <select name=ReccurenceDate0_day>
    <OPTION VALUE='1'>1</OPTION><OPTION VALUE='2'>2</OPTION><OPTION VALUE='3'>3</OPTION><OPTION VALUE='4'>4</OPTION><OPTION VALUE='5'>5</OPTION><OPTION VALUE='6'>6</OPTION><OPTION VALUE='7'>7</OPTION><OPTION VALUE='8'>8</OPTION><OPTION VALUE='9'>9</OPTION><OPTION VALUE='10'>10</OPTION><OPTION VALUE='11'>11</OPTION><OPTION VALUE='12'>12</OPTION><OPTION VALUE='13'>13</OPTION><OPTION VALUE='14'>14</OPTION><OPTION VALUE='15'>15</OPTION><OPTION VALUE='16'>16</OPTION><OPTION VALUE='17'>17</OPTION><OPTION VALUE='18'>18</OPTION><OPTION VALUE='19'>19</OPTION><OPTION VALUE='20'>20</OPTION><OPTION VALUE='21'>21</OPTION><OPTION VALUE='22'>22</OPTION><OPTION VALUE='23'>23</OPTION><OPTION VALUE='24'>24</OPTION><OPTION VALUE='25'>25</OPTION><OPTION VALUE='26'>26</OPTION><OPTION VALUE='27'>27</OPTION><OPTION VALUE='28'>28</OPTION><OPTION VALUE='29'>29</OPTION><OPTION VALUE='30'>30</OPTION><OPTION VALUE='31'>31</OPTION>	</select>&nbsp;

    Μήνας: <select name=ReccurenceDate0_month>
    <OPTION VALUE='1'>1</OPTION><OPTION VALUE='2'>2</OPTION><OPTION VALUE='3'>3</OPTION><OPTION VALUE='4'>4</OPTION><OPTION VALUE='5'>5</OPTION><OPTION VALUE='6'>6</OPTION><OPTION VALUE='7'>7</OPTION><OPTION VALUE='8'>8</OPTION><OPTION VALUE='9'>9</OPTION><OPTION VALUE='10'>10</OPTION><OPTION VALUE='11'>11</OPTION><OPTION VALUE='12'>12</OPTION>	</select>&nbsp;

	Έτος: <select name=ReccurenceDate0_year>
    <OPTION VALUE='2005'>2005</OPTION><OPTION VALUE='2004'>2004</OPTION><OPTION VALUE='2003'>2003</OPTION><OPTION VALUE='2002'>2002</OPTION><OPTION VALUE='2001'>2001</OPTION><OPTION VALUE='2000'>2000</OPTION><OPTION VALUE='1999'>1999</OPTION><OPTION VALUE='1998'>1998</OPTION><OPTION VALUE='1997'>1997</OPTION><OPTION VALUE='1996'>1996</OPTION><OPTION VALUE='1995'>1995</OPTION><OPTION VALUE='1994'>1994</OPTION><OPTION VALUE='1993'>1993</OPTION><OPTION VALUE='1992'>1992</OPTION><OPTION VALUE='1991'>1991</OPTION><OPTION VALUE='1990'>1990</OPTION><OPTION VALUE='1989'>1989</OPTION><OPTION VALUE='1988'>1988</OPTION><OPTION VALUE='1987'>1987</OPTION><OPTION VALUE='1986'>1986</OPTION><OPTION VALUE='1985'>1985</OPTION><OPTION VALUE='1984'>1984</OPTION><OPTION VALUE='1983'>1983</OPTION><OPTION VALUE='1982'>1982</OPTION><OPTION VALUE='1981'>1981</OPTION><OPTION VALUE='1980'>1980</OPTION><OPTION VALUE='1979'>1979</OPTION><OPTION VALUE='1978'>1978</OPTION><OPTION VALUE='1977'>1977</OPTION><OPTION VALUE='1976'>1976</OPTION><OPTION VALUE='1975'>1975</OPTION><OPTION VALUE='1974'>1974</OPTION><OPTION VALUE='1973'>1973</OPTION><OPTION VALUE='1972'>1972</OPTION><OPTION VALUE='1971'>1971</OPTION><OPTION VALUE='1970'>1970</OPTION>	</select>
<?
$dbconnection = cohortdb_connect("localhost", "root", "97103");
$db2 = mysql_select_db("νίκος");
echo mysql_error();
?>