<?php


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

function get_bio_data($excel) {
	$i=0; $x=8;
	$exceldata = array();
	while ($x <= $excel->sheets[0]['numRows']) {
		$exceldata[$i] = array();
		$exceldata[$i]['index'] = $x;
		$exceldata[$i]['date_raw'] = $excel->raw($x, 3);
		$exceldata[$i]['date_cell'] = $excel->val($x, 3);
		$exceldata[$i]['mysql_date'] = xls2mysql_date($exceldata[$i]['date_raw']);
		$exceldata[$i]['exam_cell'] = $excel->val($x, 5);
		$exceldata[$i]['value_cell'] = $excel->val($x, 8);
		$lower_upper_cell = $excel->val($x, 11);
		$limits = explode(" - ", $lower_upper_cell);
		$exceldata[$i]['lower'] = $limits[0];
		$exceldata[$i]['upper'] = $limits[1]; 
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

// Transformations for Aimatologikes Exams

$transformation_array_aim = array();
$transformation_array_aim['Αιμοσφαιρίνη'] = "Aimosfairini";
$transformation_array_aim['Αιματοκρίτης'] = "Aimatokritis";
$transformation_array_aim['Αιμοπετάλια'] = "Aimopetalia";
$transformation_array_aim['Αριθμός Λευκοκυττάρων'] = "Leuka";
$transformation_array_aim['Αριθμός Λευκών'] = "Leuka";

$units_transform_aim = array();

$units_transform_aim['g/dL']['id'] = "gr/dl"; // AMACS Unit: gr/dl
$units_transform_aim['g/dL']['fix'] = "1"; // Perfect Match

$units_transform_aim['gr/dl']['id'] = "gr/dl"; // AMACS Unit: gr/dl
$units_transform_aim['gr/dl']['fix'] = "1"; // Perfect Match

$units_transform_aim['K/μl']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: x 10^3 cells/μl
$units_transform_aim['K/μl']['fix'] = "1"; // Perfect Match

$units_transform_aim['x 10³']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: x 10^3 cells/μl
$units_transform_aim['x 10³']['fix'] = "1"; // Perfect Match

$units_transform_aim['x 10³/']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: x 10^3 cells/μl
$units_transform_aim['x 10³/']['fix'] = "1"; // Perfect Match

$units_transform_aim['x10³/μ']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: x 10^3 cells/μl
$units_transform_aim['x10³/μ']['fix'] = "1"; // Perfect Match

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
		$exceldata[$i]['value_cell_orig'] = $value_cell_orig;
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