<?php
require_once('../include/basic_defines.inc.php');
require_once('../include/basic_functions.inc.php');
require_once('../include/form_functions.inc.php');
require_once('../include/data_functions.inc.php');

//require_once('./Spreadsheet/Excel/Reader.php');
require_once('./Spreadsheet/excel_reader2.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

$units = array();
$result = execute_query("SELECT ID, Unit FROM units");
for ($r=0; $r<mysql_num_rows($result); $r++) {
	$row = mysql_fetch_assoc($result);
	$units[$row['ID']] = iconv("ISO-8859-7", "UTF-8", $row['Unit']);
}
mysql_free_result($result);
/*
$units = array();
$result = execute_query("SELECT PatientCode, Name, Surname FROM patients");
for ($r=0; $r<mysql_num_rows($result); $r++) {
	$row = mysql_fetch_assoc($result);
	$units[$row['PatientCode']] = iconv("ISO-8859-7", "UTF-8", $row['Name']." ".$row['Surname']);
}
echo "<pre>";
print_r($units);
echo "</pre>";
mysql_free_result($result);
*/

// Transformations for Biochemical Exams

$transformation_array_bio = array();
$transformation_array_bio['Γλυκόζη (GLUC)'] = "GLUC";
$transformation_array_bio['Ουρία  (UREA)'] = "UREA";
$transformation_array_bio['Κρεατινίνη  (CREA)'] = "CRE";
$transformation_array_bio['Ουρικό Οξύ  (UA)'] = "UACID";
$transformation_array_bio['Πυροσταφυλική Τρανσαμινάση  (A'] = "ALT";
$transformation_array_bio['Οξαλοξική Τρανσαμινάση  (AST/S'] = "AST";
$transformation_array_bio['Αλκαλική Φωσφατάση (ALP)'] = "APT";
$transformation_array_bio['γ-Γλουταμυλοτρανσφεράση  (γ-GT'] = "gGT";
$transformation_array_bio['Ολική Χολερυθρίνη  (TBIL)'] = "BIL";
$transformation_array_bio['Άμεσος Χολερυθρίνη  (DBIL)'] = "DBIL";
$transformation_array_bio['Αλβουμίνη  (ALB)'] = "ALB";
$transformation_array_bio['Ολική Χοληστερόλη (CHOL)'] = "CHOL";
$transformation_array_bio['HDL Χοληστερόλη'] = "HDL";
$transformation_array_bio['LDL Χοληστερόλη'] = "LDL";
$transformation_array_bio['Τριγλυκερίδια  (TRIG)'] = "TRIG";
$transformation_array_bio['Αμυλάση  (AMY)'] = "AMY";
$transformation_array_bio['T3 - Τριϊωδοθυρονίνη'] = "T3";
$transformation_array_bio['Τ4 - Ολική Θυροξίνη'] = "T4";
$transformation_array_bio['TSH - Θυρεοειδοτρόπος ορμόνη'] = "TSH";

$units_transform_bio = array();

$units_transform_bio['g/dL']['id'] = "3"; // AMACS Unit: gr/dl
$units_transform_bio['g/dL']['fix'] = "1"; // Perfect Match

$units_transform_bio['IU/ml']['id'] = "11"; // AMACS Unit: IU/ml 
$units_transform_bio['IU/ml']['fix'] = "1"; // Perfect Match 

$units_transform_bio['mg/dL']['id'] = "1"; // AMACS Unit: mg/dl
$units_transform_bio['mg/dL']['fix'] = "1"; // Perfect Match

$units_transform_bio['mmol/L']['id'] = "8"; // AMACS Unit: mmol/L
$units_transform_bio['mmol/L']['fix'] = "1"; // Perfect Match

$units_transform_bio['mIU/mL']['id'] = "2"; // AMACS Unit: IU/L
$units_transform_bio['mIU/mL']['fix'] = "1"; // Perfect Match

$units_transform_bio['ng/dL']['id'] = "9"; // AMACS Unit: ng/dl
$units_transform_bio['ng/dL']['fix'] = "1"; // Perfect Match

$units_transform_bio['ng/mL']['id'] = "17"; // AMACS Unit: ng/ml
$units_transform_bio['ng/mL']['fix'] = "1"; // Perfect Match

$units_transform_bio['U/L']['id'] = "2"; // AMACS Unit: IU/L
$units_transform_bio['U/L']['fix'] = "1"; // Perfect Match

$units_transform_bio['μIU/ml']['id'] = "14"; // AMACS Unit: μIU/mL
$units_transform_bio['μIU/ml']['fix'] = "1"; // Perfect Match

$units_transform_bio['μg/dL']['id'] = "1"; // AMACS Unit: mg/dL
$units_transform_bio['μg/dL']['fix'] = "1"; // CHECK EPEIDI ENAS APO TOUS 2 KANEI LATHOS !!!

// Transformations for Aimatologikes Exams

$transformation_array_aim = array();
$transformation_array_aim['Αιμοσφαιρίνη'] = "Aimosfairini";
$transformation_array_aim['Αιματοκρίτης'] = "Aimatokritis";
$transformation_array_aim['Αιμοπετάλια'] = "Aimopetalia";
$transformation_array_aim['Αριθμός Λευκοκυττάρων'] = "Leuka";

$units_transform_aim = array();

$units_transform_aim['g/dL']['id'] = "gr/dl"; // AMACS Unit: gr/dl
$units_transform_aim['g/dL']['fix'] = "1"; // Perfect Match

$units_transform_aim['K/μl']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: gr/dl
$units_transform_aim['K/μl']['fix'] = "1"; // Perfect Match

$units_transform_aim['%']['id'] = "%"; // AMACS Unit: gr/dl
$units_transform_aim['%']['fix'] = "1"; // Perfect Match

// Transformations for Exams Ourwn
 
//echo "<pre>";
//echo "Aimatologikes Exams\n\n";
//print_r($transformation_array_aim);
//print_r($units_transform_aim);
//echo "\n\nBioximikes Exams\n\n";
//print_r($transformation_array_bio);
//print_r($units_transform_bio);
//echo "\n\nAMACS Units\n\n";
//print_r($units);
//die;


?>

<HTML>
<HEAD>
	<TITLE>Εισαγωγή Εξετάσεων από Excel</TITLE>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<link href="../include/cohort.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="../include/js/jquery.js"></script>
	<script type="text/javascript" src="../include/js/jquery-ui-1.8.9.custom.min.js"></script>
	<script type="text/javascript" src="../include/js/jquery.dataTables.js"></script>
	<link type="text/css" rel="stylesheet" href="../css/dataTables.css">
	<link type="text/css" rel="stylesheet" href="../css/dataTables_jui.css">
	<link type="text/css" rel="stylesheet" href="../css/redmond/jquery-ui-1.8.9.redmond.css">
	<style>
		.roundederror {
     		border: 1px solid red;
     		background-color: white;
     		-moz-border-radius: 5px;
    		-webkit-border-radius: 5px;
    		-khtml-border-radius: 5px;
    		border-radius: 5px;
			-moz-box-shadow: 0px 0px 5px #888;
			-webkit-box-shadow: 0px 0px 5px #888;
			box-shadow: 0px 0px 5px #888;
			padding-top: 3px;
			padding-bottom: 3px;     		
		}
	</style>
</HEAD>

<?php

$xlsfile = basename( $_FILES['xlsfile']['name']);

//move_uploaded_file($_FILES['xlsfile']['tmp_name'], "./for_import.xls"); // . $xlsfile);
//$excel = new Spreadsheet_Excel_Reader("./for_import.xls");//, 'WINDOWS-1253');

move_uploaded_file($_FILES['xlsfile']['tmp_name'], $xlsfile);
$excel = new Spreadsheet_Excel_Reader($xlsfile); //, 'WINDOWS-1253');

//$excel->setUTFEncoder('iconv');
//$excel->setOutputEncoding('WINDOWS-1253');
// read spreadsheet data 
//$excel->read($xlsfile);
//$xsheets = sizeof($excel->sheets);

//$excel->dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel');
//echo $excel->val(10,9);
//die;

/*
echo "Number of sheets: " . sizeof($excel->sheets) . "<br>"; 
for ($x=0; $x<$xsheets; $x++) {
	echo "Number of rows in sheet " . ($x+1) . ": " . $excel->sheets[$x]["numRows"] . "<br>"; 
	echo "Number of columns in sheet " . ($x+1) . ": " . $excel->sheets[$x]["numCols"] . "<br>";
}
*/

$patient_raw_details = $excel->val(2, 3);
$patient_details = explode(" ", $patient_raw_details);

echo "<h4>Κωδικός ασθενούς: ".$patient_details[1].", Ονοματεπώνυμο ασθενούς: ".$patient_details[2]." ".$patient_details[3]."</h4>";
?>
<div id="tabs" style="width: 1010px">
<ul>
	<li><a href="#exams_bioximikes">Βιοχημικές Εξετάσεις</a></li>
	<li><a href="#exams_aimatologikes">Αιματολογικές Εξετάσεις</a></li>
	<li><a href="#exams_ourwn">Γενική Ούρων</a></li>
</ul>

<?php

echo "<div id='exams_bioximikes' style='width: 980px'>";
echo "<b>Αριθμός βιοχημικών εξετάσεων που έχουν αναγνωριστεί: <span id='records_bio'></span></b><br><br>";
echo "<table border=0 celspacing=0 cellpadding=0 id='exams_overview' class='display'><thead>\n";
echo "<th>Excel A/A</th><th>Ημερομηνία (Excel)</th><th>Ημερομηνία (AMACS)</th><th>Εξέταση (Excel)</th><th>Εξέταση (AMACS)</th>";
echo "<th>Τιμή - Μονάδες (Excel)</th><th>Τιμή - Μονάδες (AMACS)</th><th>Lower</th><th>Upper</th></thead><tbody>";

$x=8; $i=0;
$converted_records_bio=0;
 
while ($x <= $excel->sheets[0]['numRows']) {
//	$date_cell = $excel->sheets[0]['cells'][$x][3];
	$date_cell = ""; $exam_cell = ""; $value_cell = ""; $lower_upper_cell = ""; $units_cell = "";
	$date_cell = $excel->val($x, 3);
//	$exam_cell = $excel->sheets[0]['cells'][$x][5];
	$exam_cell = $excel->val($x, 5);
//	$value_cell = $excel->sheets[0]['cells'][$x][8];
	$value_cell = $excel->val($x, 8);
//	$lower_upper_cell = $excel->sheets[0]['cells'][$x][11];
	$lower_upper_cell = $excel->val($x, 11);
//	$units_cell = $excel->sheets[0]['cells'][$x][9];
	$units_cell = $excel->val($x, 9);

	$date_parts = explode("/", $date_cell);
	$limits = explode(" - ", $lower_upper_cell);
		
if 	($transformation_array_bio[$exam_cell] != "") {	
		
	$sql  = "";
	$sql  = "INSERT INTO exams_bioximikes VALUES ('".$patient_details[1]."', '".$date_parts[2]."-".$date_parts[1]."-".$date_parts[0]."', ";
	$sql .= "'".$transformation_array_bio[$exam_cell]."', '".$value_cell * $units_transform_bio[$units_cell]['fix']."', '".$limits[0]."', '".$limits[1]."', ";
	$sql .= "'".$units_transform_bio[$units_cell]['id']."');";
	
	echo "<tr><td align=center>$x <span id='bio_$x'></span><span id='biosql_$x' style='display:none'>".$sql."</span></td>";
	
	//Print Date
	echo "<td align=center> $date_cell </td>";
	echo "<td align=center>".$date_parts[2]."-".$date_parts[1]."-".$date_parts[0]."</td>";
	//Print Exam
	echo "<td align=center>".$exam_cell."</td>";
	echo "<td align=center>".$transformation_array_bio[$exam_cell]."</td>";
	//Print Value
	echo "<td align=center>$value_cell $units_cell</td>";
	echo "<td align=center>".$value_cell * $units_transform_bio[$units_cell]['fix']." ".$units[$units_transform_bio[$units_cell]['id']]."</td>";
	//Print Lower
	echo "<td align=center>". $limits[0] ."</td>";
	//Print Date
	echo "<td align=center>". $limits[1] ."</td>";
	//Print Units
	//echo "<td>$units_cell</td>";
	
	echo "</tr>";
	$converted_records_bio++;
}
	
	$x++;
}

echo "</tbody></table><br>\n";
echo "<input type=button id='storedata_bioximikes' value='Εισαγωγή Εξετάσεων στην AMACS'></div>\n";

echo "<div id='exams_aimatologikes' style='width: 980px'>";

echo "<b>Αριθμός ανοσολογικών εξετάσεων που έχουν αναγνωριστεί: <span id='records_aim'></span></b><br><br>";
echo "<table border=0 celspacing=0 cellpadding=0 id='exams_overview_aim' class='display'><thead>\n";
echo "<th>Excel A/A</th><th>Ημερομηνία (Excel)</th><th>Ημερομηνία (AMACS)</th><th>Εξέταση (Excel)</th><th>Εξέταση (AMACS)</th>";
echo "<th>Τιμή - Μονάδες (Excel)</th><th>Τιμή - Μονάδες (AMACS)</th></thead><tbody>";

$x=8;
$converted_records_aim=0;
$amacs_aimatologikes = array();
 
while ($x <= $excel->sheets[0]['numRows']) {
	$date_cell = ""; $exam_cell = ""; $value_cell = ""; $lower_upper_cell = ""; $units_cell = "";
	$date_cell = $excel->val($x, 3);
	$exam_cell = $excel->val($x, 5);
	$value_cell = $excel->val($x, 8);
	$units_cell = $excel->val($x, 9);

	$date_parts = explode("/", $date_cell);
	$limits = explode(" - ", $lower_upper_cell);	
		
if 	($transformation_array_aim[$exam_cell] != "") {	
		
	$amacs_aimatologikes[$date_parts[2]."-".$date_parts[1]."-".$date_parts[0]][$transformation_array_aim[$exam_cell]] = $value_cell * $units_transform_aim[$units_cell]['fix'];
	
	echo "<tr><td align=center>$x</td>";
	
	//Print Date
	echo "<td align=center> $date_cell </td>";
	echo "<td align=center>".$date_parts[2]."-".$date_parts[1]."-".$date_parts[0]."</td>";
	//Print Exam
	echo "<td align=center>".$exam_cell."</td>";
	echo "<td align=center>".$transformation_array_aim[$exam_cell]."</td>";
	//Print Value
	echo "<td align=center>$value_cell $units_cell</td>";
	echo "<td align=center>".$value_cell * $units_transform_aim[$units_cell]['fix']." ".$units_transform_aim[$units_cell]['id']."</td>";
	//Print Units
	//echo "<td>$units_cell</td>";
	
	echo "</tr>";
	$converted_records_aim++;
}
	
$x++;
}

echo "</tbody></table>\n";
echo "<br><b>Πίνακας δεδομένων που θα εισαχθεί στην AMACS</b><br><br>";
echo "<table border=0 celspacing=0 cellpadding=0 id='exams_aim_for_amacs' class='display'><thead>\n";
echo "<th>Αποτέλεσμα εισαγωγής</th><th>Ημερομηνία</th><th>Αιματοκρίτης</th><th>Αιμοσφαιρίνη</th><th>Λευκά</th><th>Αιμοπετάλια</th></thead><tbody>";
$i=1;
while ( $element = each( $amacs_aimatologikes ) ) {
	$date = $element['key'];
	$sql  = "INSERT INTO exams_aimatologikes VALUES ('".$patient_details[1]."', '$date', '".$amacs_aimatologikes[$date]['Aimatokritis']."', ";
	$sql .= "'".$amacs_aimatologikes[$date]['Aimosfairini']."', '".$amacs_aimatologikes[$date]['Leuka']."', ";
	$sql .= "'".$amacs_aimatologikes[$date]['Aimopetalia']."')";
	echo "<tr>";
	echo "<td align=center><span id='aim_$i'></span><span id='aimsql_$i' style='display:none'>$sql</span></td>";
	echo "<td align=center>$date</td>\n";
	echo "<td align=center>".$amacs_aimatologikes[$date]['Aimatokritis']."</td>\n";
	echo "<td align=center>".$amacs_aimatologikes[$date]['Aimosfairini']."</td>\n";
	echo "<td align=center>".$amacs_aimatologikes[$date]['Leuka']."</td>\n";
	echo "<td align=center>".$amacs_aimatologikes[$date]['Aimopetalia']."</td>\n";			
	echo "</tr>";
//	print_r($sql);
	$i++;
}
echo "</tbody></table><br>\n";
echo "<input type=button id='storedata_aimatologikes' value='Εισαγωγή Εξετάσεων στην AMACS'></div>\n";

echo "<div id='exams_ourwn' style='width: 980px'>";
echo "<input type=button id='storedata_ourwn' value='Εισαγωγή Εξετάσεων στην AMACS'></div>\n";

?>

</div>
<script type="text/javascript">
function store_data_bio(){
	$("[id^='bio_']").html("<img src='../images/ajax-loader.gif' width=16 />");
	$("[id^='biosql_']").each( function(){
		$(this).hide();
		var element_id = $(this).attr("id").replace("biosql_", "bio_");
		var strSQL = $(this).html();
		$.post("ajax_insert.php", { "from": "excel", "sql": strSQL, "id": element_id, "code": "<?php echo $patient_details[1]; ?>"},
				function(data) {
					if (data.msg == "Success!") {
						$("#" + data.id).html("<img src='../images/ok_checkmark.png' width=16 />");
					} else {
						$("#" + data.id).html("<div class='roundederror'><img src='../images/error.png' width=16 /> " + data.msg + "</div>");
					}
				}, 'json');
	});
}

function store_data_aim(){
	$("[id^='aim_']").html("<img src='../images/ajax-loader.gif' width=16 />");
	$("[id^='aimsql_']").each( function(){
		$(this).hide();
		var element_id = $(this).attr("id").replace("aimsql_", "aim_");
		var strSQL = $(this).html();
		$.post("ajax_insert.php", { "from": "excel", "sql": strSQL, "id": element_id, "code": "<?php echo $patient_details[1]; ?>"},
				function(data) {
					if (data.msg == "Success!") {
						$("#" + data.id).html("<img src='../images/ok_checkmark.png' width=16 />");
					} else {
						$("#" + data.id).html("<div class='roundederror'><img src='../images/error.png' width=16 /> " + data.msg + "</div>");
					}
				}, 'json');
	});
}

$(document).ready(function(){
	$("#exams_overview").dataTable({
		"bPaginate": false,
		"bInfo": false,
		"bAutoWidth": false,
		"bLengthChange": false, 
		"bJQueryUI": true,
		"aaSorting": [[ 1, "asc" ], [ 3, "asc" ]]
	});
	$("#exams_overview_aim").dataTable({
		"bPaginate": false,
		"bInfo": false,
		"bAutoWidth": false,
		"bLengthChange": false, 
		"bJQueryUI": true,
		"aaSorting": [[ 1, "asc" ], [ 3, "asc" ]]
	});	
	$("#tabs").tabs();
	$("#storedata_bioximikes").button();
	$("#storedata_aimatologikes").button();
	$("#storedata_ourwn").button();
	$("#records_bio").html("<? echo $converted_records_bio ?>");
	$("#records_aim").html("<? echo $converted_records_aim ?>");
	$("#storedata_bioximikes").click(function() { store_data_bio() });
	$("#storedata_aimatologikes").click(function() { store_data_aim() });
});

</script>

<?php

//unlink("for_import.xls");
unlink($xlsfile);

?>