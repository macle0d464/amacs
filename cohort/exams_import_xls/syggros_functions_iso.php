<?php

function clean_cell($cell) {
	if (strpos($cell, "��������")) {
		$cell = -1;
	}
	if (strpos($cell, "������")) {
		$cell = 1;
	}
	$cell = str_replace("&nbsp;", "", $cell);
	$cell = str_replace("</a>", "", $cell);
	$cell = str_replace(" cps", "", $cell);
	$cell = str_replace("[����.]", "", $cell);
	$temp = "";
	$ok_to_copy = true;
	for ($c=0; $c<strlen($cell); $c++) {
		if ((substr($cell, $c, 2) == "<a") || (substr($cell, $c, 4) == "<img")) {
			$ok_to_copy = false;
		}
		if ($cell[$c] == ">") {
			$ok_to_copy = true;
			continue;
		}
		if ($ok_to_copy) {
			$temp .= $cell[$c];
		}
	}
	$cell = $temp;
	if (strpos($cell, ":")) {
		// Cell contains date, strip the time details
		$temp = explode(" ", $cell);
		$cell = $temp[0];
	}
	$cell = trim(str_replace(",", ".", $cell));
//	$cell = iconv("UTF-8", "ISO-8859-7", $cell);
	return $cell;
}

// Transformations for Biochemical Exams

$transformation_array_bio = array();
$transformation_array_bio['�������'] = "GLUC";
$transformation_array_bio['�����'] = "UREA";
$transformation_array_bio['����������'] = "CRE";
$transformation_array_bio['������ ���'] = "UACID";
$transformation_array_bio['����������� �����'] = "BIL";
$transformation_array_bio['����������� �����'] = "DBIL";
// 5 unidentified
$transformation_array_bio['������� ����'] = "AMY";
$transformation_array_bio['�������� ���������'] = "APT";
$transformation_array_bio['SGOT (AST)'] = "AST";
$transformation_array_bio['SGPT (ALT)'] = "ALT";
$transformation_array_bio['�-GT'] = "gGT";
// 10 unidentified
$transformation_array_bio['�������������'] = "TRIG";
$transformation_array_bio['�����������'] = "CHOL";
//$transformation_array_bio['HDL �����������'] = "HDL";
//$transformation_array_bio['LDL �����������'] = "LDL";
//$transformation_array_bio['T3 - ���������������'] = "T3";
//$transformation_array_bio['�4 - ����� ��������'] = "T4";
//$transformation_array_bio['TSH - ��������������� ������'] = "TSH";
//$transformation_array_bio['���������  (ALB)'] = "ALB";

$units_transform_bio = array();

$units_transform_bio['mg/dL']['id'] = "1"; // AMACS Unit: mg/dl
$units_transform_bio['mg/dL']['fix'] = "1"; // Perfect Match

$units_transform_bio['mIU/mL']['id'] = "2"; // AMACS Unit: IU/L
$units_transform_bio['mIU/mL']['fix'] = "1"; // Perfect Match

$units_transform_bio['g/dl']['id'] = "3"; // AMACS Unit: gr/dl
$units_transform_bio['g/dl']['fix'] = "1"; // Perfect Match

$units_transform_bio['IU/ml']['id'] = "11"; // AMACS Unit: IU/ml
$units_transform_bio['IU/ml']['fix'] = "1"; // Perfect Match

$units_transform_bio['mmol/L']['id'] = "8"; // AMACS Unit: mmol/L
$units_transform_bio['mmol/L']['fix'] = "1"; // Perfect Match

$units_transform_bio['ng/dL']['id'] = "9"; // AMACS Unit: ng/dl
$units_transform_bio['ng/dL']['fix'] = "1"; // Perfect Match

$units_transform_bio['ng/mL']['id'] = "17"; // AMACS Unit: ng/ml
$units_transform_bio['ng/mL']['fix'] = "1"; // Perfect Match

$units_transform_bio['U/L']['id'] = "2"; // AMACS Unit: IU/L
$units_transform_bio['U/L']['fix'] = "1"; // Perfect Match

$units_transform_bio['�IU/ml']['id'] = "14"; // AMACS Unit: �IU/mL
$units_transform_bio['�IU/ml']['fix'] = "1"; // Perfect Match

$units_transform_bio['�g/dL']['id'] = "1"; // AMACS Unit: mg/dL
$units_transform_bio['�g/dL']['fix'] = "1"; // CHECK EPEIDI ENAS APO TOUS 2 KANEI LATHOS !!!

function get_bio_data($excel) {
	$exceldata = array();
	$k = 0;
	for ($i=3; $i <= $excel->sheets[0]['numRows']; $i++) {
		for ($j=4; $j <= $excel->sheets[0]['numCols']; $j++) {
			$exceldata[$k] = array();
			$exceldata[$k]['exam_cell'] = clean_cell($excel->val($i, 1));
			$lower_upper_cell = clean_cell($excel->val($i, 2));
			if (substr($lower_upper_cell, 0, 1) == "<") {
				$limits = array();
				$limits[0] = trim(substr($lower_upper_cell, 2));
				$limits[1] = "";
			} elseif (substr($lower_upper_cell, 0, 1) == ">") {
				$limits = array();
				$limits[0] = "";
				$limits[1] = trim(substr($lower_upper_cell, 2));
			} else {
				$limits = explode(" - ", $lower_upper_cell);
			}
			$exceldata[$k]['lower'] = $limits[0];
			$exceldata[$k]['upper'] = $limits[1]; 
			$units_cell = $excel->val($i, 3);
			if (mb_detect_encoding($units_cell, 'UTF-8', true) != 'UTF-8') {
				$units_cell = iconv("ISO-8859-7", "UTF-8", $units_cell); // Epeidi kapoies eggrafes einai ISO-8859-7 !!!
			}	
			$exceldata[$k]['units_cell'] = $units_cell;
			$exceldata[$k]['units_encoding'] = "";
	
			$exceldata[$k]['index'] = "($i, $j)";
			$exceldata[$k]['date_cell'] = clean_cell($excel->val(1, $j));
			$dateparts = explode("/", $exceldata[$k]['date_cell']);
			if ( $dateparts[2] < 50) {
				$dateparts[2] = 2000 + $dateparts[2];
			} else {
				$dateparts[2] = 1900 + $dateparts[2];
			}
			$exceldata[$k]['mysql_date'] = $dateparts[0]."-".$dateparts[1]."-".$dateparts[2];
			$exceldata[$k]['value_cell'] = clean_cell($excel->val($i, $j));
			if ($exceldata[$k]['value_cell'] != "") {
				// Value exists so add the element to the array
				$k++;
			}
		}
	}
	return $exceldata;
}

// Transformations for Aimatologikes Exams

$transformation_array_aim = array();
$transformation_array_aim['������������'] = "Aimosfairini";
$transformation_array_aim['������������'] = "Aimatokritis";
$transformation_array_aim['�����������'] = "Aimopetalia";
$transformation_array_aim['������� �������������'] = "Leuka";
$transformation_array_aim['������� ������'] = "Leuka";

$units_transform_aim = array();

$units_transform_aim['g/dL']['id'] = "gr/dl"; // AMACS Unit: gr/dl
$units_transform_aim['g/dL']['fix'] = "1"; // Perfect Match

$units_transform_aim['gr/dl']['id'] = "gr/dl"; // AMACS Unit: gr/dl
$units_transform_aim['gr/dl']['fix'] = "1"; // Perfect Match

$units_transform_aim['K/�l']['id'] = "x 10<sup>3</sup> cells/�l"; // AMACS Unit: x 10^3 cells/�l
$units_transform_aim['K/�l']['fix'] = "1"; // Perfect Match

$units_transform_aim['x 10�']['id'] = "x 10<sup>3</sup> cells/�l"; // AMACS Unit: x 10^3 cells/�l
$units_transform_aim['x 10�']['fix'] = "1"; // Perfect Match

$units_transform_aim['x 10�/']['id'] = "x 10<sup>3</sup> cells/�l"; // AMACS Unit: x 10^3 cells/�l
$units_transform_aim['x 10�/']['fix'] = "1"; // Perfect Match

$units_transform_aim['x10�/�']['id'] = "x 10<sup>3</sup> cells/�l"; // AMACS Unit: x 10^3 cells/�l
$units_transform_aim['x10�/�']['fix'] = "1"; // Perfect Match

$units_transform_aim['%']['id'] = "%"; // AMACS Unit: %
$units_transform_aim['%']['fix'] = "1"; // Perfect Match

function get_aim_data($excel) {
	$i=0; $x=8;
	$exceldata = array();
	while ($x <= $excel->sheets[0]['numRows']) {
		$exceldata[$i] = array();
		$exceldata[$i]['index'] = $x;
		$exceldata[$i]['date_raw'] = $excel->raw($x, 3);
		$exceldata[$i]['date_cell'] = $excel->val($x, 3);
		$exceldata[$i]['mysql_date'] = xls2mysql_date($exceldata[$i]['date_raw']);
		$exceldata[$i]['exam_cell'] = $excel->val($x, 5);
		$value_cell_orig = $excel->val($x, 8);
		$exceldata[$i]['value_cell'] = str_replace(">", "", $value_cell_orig);
//		$lower_upper_cell = $excel->val($x, 11);
//		$limits = explode(" - ", $lower_upper_cell);
//		$exceldata[$i]['lower'] = $limits[0];
//		$exceldata[$i]['upper'] = $limits[1]; 
		$units_cell = $excel->val($x, 9);
		if (mb_detect_encoding($units_cell, 'UTF-8', true) != 'UTF-8') {
			$units_cell = iconv("ISO-8859-7", "UTF-8", $units_cell); // Epeidi kapoies eggrafes einai ISO-8859-7 !!!
		}
		$exceldata[$i]['units_cell'] = $units_cell;
		$exceldata[$i]['units_encoding'] = "";
		$x++; $i++;
	}
	return $exceldata;
}


?>