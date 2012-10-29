<?php

function clean_cell($cell) {
/* 
	if (strpos($cell, "ΑΡΝΗΤΙΚΗ")) {
		$cell = -1;
	}
	if (strpos($cell, "ΘΕΤΙΚΗ")) {
		$cell = 1;
	}
	if (strpos($cell, ",  Ε.Σ")) {
		$cell = ">35";
	}
	$cell = str_replace("&nbsp;", "", $cell);
	$cell = str_replace("</a>", "", $cell);
	$cell = str_replace(" cps", "", $cell);
	$cell = str_replace("[Εκκρ.]", "", $cell);
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

    if ($cell == "[Εκκρ.]" || $cell == "[Παραγγ.]") {
        $cell = "";
    }

 */ 
    $cell = str_replace("[Εκκρ.]", "", $cell);
    $cell = str_replace("[Παραγγ.]", "", $cell);
    $cell = str_replace(",", ".", $cell);
    if ($cell == "<40:χαμηλή >60:υψηλή") {
        $cell = "40 - 60";
    }
	return $cell;
}

// Transformations for Biochemical Exams

$transformation_array_bio = array();
$transformation_array_bio['Γλυκόζη - νηστείας (Glu)'] = "GLUC";
$transformation_array_bio['Ουρία (Urea)'] = "UREA";
$transformation_array_bio['Κρεατινίνη (Crea)'] = "CRE";
$transformation_array_bio['Ουρικό οξύ (U.A)'] = "UACID";
$transformation_array_bio['Ολική Χολερυθρίνη (TBil)'] = "BIL";
$transformation_array_bio['Άμεσος Χολερυθρίνη (dBil)'] = "DBIL";
// 5 unidentified
$transformation_array_bio['AMS (Αμυλάση)'] = "AMY";
$transformation_array_bio['ALP (Αλκαλική φωσφατάση)'] = "APT";
$transformation_array_bio['AST (SGOT)'] = "AST";
$transformation_array_bio['ALT (SGPT)'] = "ALT";
$transformation_array_bio['γ-GT'] = "gGT";
// 10 unidentified
$transformation_array_bio['Τριγλυκερίδια-νηστείας (Tg)'] = "TRIG";
$transformation_array_bio['Χοληστερόλη ολική (Chol)'] = "CHOL";
$transformation_array_bio['H.D.L-Chol.'] = "HDL";
$transformation_array_bio['L.D.L-Chol.'] = "LDL";
$transformation_array_bio['Αλβουμίνη (Alb)'] = "ALB";

//$transformation_array_bio['T3 - Τριϊωδοθυρονίνη'] = "T3";
//$transformation_array_bio['Τ4 - Ολική Θυροξίνη'] = "T4";
//$transformation_array_bio['TSH - Θυρεοειδοτρόπος ορμόνη'] = "TSH";

$units_transform_bio = array();

$units_transform_bio['mg/dl']['id'] = "1"; // AMACS Unit: mg/dl
$units_transform_bio['mg/dl']['fix'] = "1"; // Perfect Match

$units_transform_bio['g/dl']['id'] = "3"; // AMACS Unit: gr/dl
$units_transform_bio['g/dl']['fix'] = "1"; // Perfect Match

$units_transform_bio['U/L']['id'] = "2"; // AMACS Unit: IU/L
$units_transform_bio['U/L']['fix'] = "1"; // Perfect Match

function get_bio_data($excel) {
	$exceldata = array();
	$k = 0;
	for ($i=1; $i <= $excel->sheets[0]['numRows']; $i++) {
		for ($j=4; $j <= $excel->sheets[0]['numCols']; $j++) {
			$exceldata[$k] = array();
			$exceldata[$k]['exam_cell'] = $excel->val($i, 1);
			$lower_upper_cell = clean_cell($excel->val($i, 2));
			$lower_upper_cell = str_replace("-", " - ", $lower_upper_cell);
			$lower_upper_cell = str_replace("<", "< ", $lower_upper_cell);
			$lower_upper_cell = str_replace(">", "> ", $lower_upper_cell);
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
			$exceldata[$k]['limits'] = $lower_upper_cell;
			$exceldata[$k]['lower'] = $limits[0];
			$exceldata[$k]['upper'] = $limits[1]; 
			$units_cell = $excel->val($i, 3);
			if (mb_detect_encoding($units_cell, 'UTF-8', true) != 'UTF-8') {
				$units_cell = iconv("ISO-8859-7", "UTF-8", $units_cell); // Epeidi kapoies eggrafes einai ISO-8859-7 !!!
			}	
			$exceldata[$k]['units_cell'] = $units_cell;
			$exceldata[$k]['units_encoding'] = "";
	
			$exceldata[$k]['index'] = "($i, $j)";
			$exceldata[$k]['date_cell'] = $excel->val(1, $j);
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
$transformation_array_aim['HGb - Αιμοσφαιρίνη'] = "Aimosfairini";
$transformation_array_aim['HCT - Αιματοκρίτης'] = "Aimatokritis";
$transformation_array_aim['PLT - Αιμοπετάλια (Αίμα )'] = "Aimopetalia";
$transformation_array_aim['WBC-Λευκά αιμοσφαίρια'] = "Leuka";

$units_transform_aim = array();

$units_transform_aim['g/dl']['id'] = "gr/dl"; // AMACS Unit: gr/dl
$units_transform_aim['g/dl']['fix'] = "1"; // Perfect Match

$units_transform_aim['K/μl']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: x 10^3 cells/μl
$units_transform_aim['K/μl']['fix'] = "1"; // Perfect Match

$units_transform_aim['Κ/μl']['id'] = "x 10<sup>3</sup> cells/μl"; // AMACS Unit: x 10^3 cells/μl
$units_transform_aim['Κ/μl']['fix'] = "1"; // Perfect Match

$units_transform_aim['%']['id'] = "%"; // AMACS Unit: %
$units_transform_aim['%']['fix'] = "1"; // Perfect Match

function get_aim_data($excel) {
    $exceldata = array();
    $k = 0;
    for ($i=1; $i <= $excel->sheets[0]['numRows']; $i++) {
        for ($j=4; $j <= $excel->sheets[0]['numCols']; $j++) {
            $exceldata[$k] = array();
            $exceldata[$k]['exam_cell'] = $excel->val($i, 1);
            $lower_upper_cell = clean_cell($excel->val($i, 2));
            $lower_upper_cell = str_replace("-", " - ", $lower_upper_cell);
            $lower_upper_cell = str_replace("<", "< ", $lower_upper_cell);
            $lower_upper_cell = str_replace(">", "> ", $lower_upper_cell);
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
            $exceldata[$k]['limits'] = $lower_upper_cell;
            $exceldata[$k]['lower'] = $limits[0];
            $exceldata[$k]['upper'] = $limits[1]; 
            $units_cell = $excel->val($i, 3);
            if (mb_detect_encoding($units_cell, 'UTF-8', true) != 'UTF-8') {
                $units_cell = iconv("ISO-8859-7", "UTF-8", $units_cell); // Epeidi kapoies eggrafes einai ISO-8859-7 !!!
            }   
            $exceldata[$k]['units_cell'] = $units_cell;
            $exceldata[$k]['units_encoding'] = "";
    
            $exceldata[$k]['index'] = "($i, $j)";
            $exceldata[$k]['date_cell'] = $excel->val(1, $j);
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


?>