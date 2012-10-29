<?php
require_once('../include/basic_defines.inc.php');
require_once('../include/basic_functions.inc.php');
require_once('../include/form_functions.inc.php');
require_once('../include/data_functions.inc.php');

//require_once('./Spreadsheet/Excel/Reader.php');
require_once('./Spreadsheet/excel_reader2.php');


$transformation_array = array();
$transformation_array['������� (GLUC)'] = "GLUC";
$transformation_array['�����  (UREA)'] = "UREA";
$transformation_array['����������  (CREA)'] = "CRE";
$transformation_array['������ ���  (UA)'] = "UACID";
$transformation_array['������������� ������������  (A'] = "ALT";
$transformation_array['��������� ������������  (AST/S'] = "AST";
$transformation_array['�������� ��������� (ALP)'] = "APT";
$transformation_array['�-���������������������  (�-GT'] = "gGT";
$transformation_array['����� �����������  (TBIL)'] = "BIL";
$transformation_array['������ �����������  (DBIL)'] = "DBIL";
$transformation_array['���������  (ALB)'] = "ALB";
$transformation_array['����� ����������� (CHOL)'] = "CHOL";
$transformation_array['HDL �����������'] = "HDL";
$transformation_array['LDL �����������'] = "LDL";
$transformation_array['�������������  (TRIG)'] = "TRIG";
$transformation_array['�������  (AMY)'] = "AMY";
$transformation_array['T3 - ���������������'] = "T3";
$transformation_array['�4 - ����� ��������'] = "T4";
$transformation_array['TSH - ��������������� ������'] = "TSH";
?>

<HTML><HEAD>
<TITLE>�������� ���������� ��������� ��� Excel</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="../include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>

<?php

$xlsfile = basename( $_FILES['xlsfile']['name']);

move_uploaded_file($_FILES['xlsfile']['tmp_name'], "for_import.xls"); // . $xlsfile);
$excel = new Spreadsheet_Excel_Reader("./for_import.xls");//, 'WINDOWS-1253');
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

echo "<table border=1 cellspacing=1>\n";
echo "<th class=result>Excel A/A</th><th class=result>����������</th><th class=result>�������</th>";
echo "<th class=result>����</th><th class=result>Lower</th><th class=result>Upper</th><th class=result>�������</th>";

$x=8;
$converted_records=0;
 
while ($x <= $excel->sheets[0]['numRows']) {
//	$date_cell = $excel->sheets[0]['cells'][$x][3];
	$date_cell = $excel->val($x, 3);
//	$exam_cell = $excel->sheets[0]['cells'][$x][5];
	$exam_cell = $excel->val($x, 5);
//	$value_cell = $excel->sheets[0]['cells'][$x][8];
	$value_cell = $excel->val($x, 8);
//	$lower_upper_cell = $excel->sheets[0]['cells'][$x][11];
	$lower_upper_cell = $excel->val($x, 11);
//	$units_cell = $excel->sheets[0]['cells'][$x][9];
	$units_cell = $excel->val($x, 9);
	
//if 	($transformation_array[$exam_cell] != "") {	
	
	echo "<tr><td class=result align=center>$x</td>";
	
	//Print Date
	$date_parts = explode("/", $date_cell);
//	echo "<td class=result>".$date_parts[2]."-".$date_parts[1]."-".$date_parts[0]."</td>";
	echo "<td class=result> $date_cell </td>";
	//Print Exam
//	echo "<td class=result>".$transformation_array[$exam_cell]."</td>";
	echo "<td class=result>".$exam_cell."</td>";
	//Print Value
	echo "<td class=result>$value_cell</td>";
	//Print Lower
	$limits = explode(" - ", $lower_upper_cell);
	echo "<td class=result>". $limits[0] ."</td>";
	//Print Date
	echo "<td class=result>". $limits[1] ."</td>";
	//Print Units
	echo "<td class=result>$units_cell</td>";
	
	echo "</tr>";
	$converted_records++;
//}
	
	$x++;
}

echo "�������� ��� �������� ��������� ���� ������ �� ������: <input name='patientcode' size=5> <input type=button value=��������><br>";
echo "������� ��������� ��� ����� ������������: $converted_records<br><br>";
?>