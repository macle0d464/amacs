<?php
header('Content-Type: text/html; charset=utf-8');

require_once('../include/excel_reader2.php');
require_once('../include/basic_defines.inc.php');
require_once('../include/basic_functions.inc.php');


function clean_cell($cell) {
	if (strpos($cell, "ΑΡΝΗΤΙΚΗ")) {
		$cell = -1;
	}
	if (strpos($cell, "ΘΕΤΙΚΗ")) {
		$cell = 1;
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
	return $cell;
}

function writexls($exceldata, $filename, $originalname)
{ 
    // $workbook =& new Spreadsheet_Excel_Writer();
    // $workbook->send($filename);
    $workbook =& new Spreadsheet_Excel_Writer($filename);
    $sheet =& $workbook->addWorksheet($originalname.' Cleaned');
 
    $format_header_row =& $workbook->addFormat();
    // $format_header_row->setTop(1);
    // $format_header_row->setLeft(1);
    // $format_header_row->setBottom(1);
    // $format_header_row->setPattern(1);
    $format_header_row->setBorderColor('black');
    // $format_header_row->setFgColor(31);
    $format_header_row->setBold();
    $format_header_row->setShadow();
	$format_header_row->setAlign('center');	

    $format_data =& $workbook->addFormat();
    $format_data->setAlign('center');

	for ($i=1; $i <= $exceldata->sheets[0]['numRows']; $i++) {
		for ($j=1; $j <= $exceldata->sheets[0]['numCols']; $j++) {
			$cell = $exceldata->val($i, $j);
			$cell = str_replace("&nbsp;", "", $cell);
			$cell = str_replace("</a>", "", $cell);
			$temp = "";
			$ok_to_copy = true;
			for ($c=0; $c<strlen($cell); $c++) {
				if (substr($cell, 0, 3) == "<a ") {
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
			$cell = iconv("UTF-8", "ISO-8859-7", $cell);
			if ($i == 1 || $j == 1) {
				$sheet->write($i-1,$j-1,$cell, $format_header_row);
			} else {
				$sheet->write($i-1,$j-1,$cell, $format_data);
			}
		}				
	}
    $workbook->close();
}


?>

<?php

if (isset($_FILES['filename']['name'])) { //$_POST['filename']) && ($_POST['filename'] != "")) {

// unlink("for_import.xls");
$xlsfile = basename( $_FILES['filename']['name']);
move_uploaded_file($_FILES['filename']['tmp_name'], "./for_import.xls"); // . $xlsfile);
while(!file_exists("./for_import.xls")) {
	sleep(1);
}

$excel = new Spreadsheet_Excel_Reader("./for_import.xls", 'WINDOWS-1253');

echo "<table border='1' cellpadding='1' cellspacing='1'>";
for ($i=1; $i <= $excel->sheets[0]['numRows']; $i++) {
	echo "<tr>";
	for ($j=1; $j <= $excel->sheets[0]['numCols']; $j++) {
		$cell = $excel->val($i, $j);
		//$cell = iconv("ISO-8859-7", "UTF-8", $cell); // Epeidi kapoies eggrafes einai ISO-8859-7 !!!	
		$cell = clean_cell($cell);
		echo "<td> $cell </td>";
		// echo htmlentities($cell)."<td>";
	}
	echo "</tr>";
	// echo "<br>";
}
echo "<table>";

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

		$exceldata[$k]['index'] = "($i , $j)";
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

echo "<pre>";
print_r($exceldata);

die;

		


$filename = "cleaned_up.xls";
// $filename = str_replace(" ", "_", substr($xlsfile, 0, strpos($xlsfile, "."))) . "_cleaned.xls";
// echo $filename;
// die;
writexls($exceldata, $filename, $xlsfile);
//unlink("for_import.xls");

// header('Content-type: application/excel');
header("Content-type: application/octet-stream");
header("Content-Transfer-Encoding: binary");
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Length: ' . filesize(realpath("./".$filename)));
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
    
/*
$file = fopen($filename,"rb");
if ($file) {
  while(!feof($file)) {
    print(fread($file, 1024*8));
    // flush();
    if (connection_status()!=0) {
      fclose($file);
      die();
    }
  }
  fclose($file);
}
*/
ob_clean();
flush();

readfile($filename);
exit;

// $exceldata->dump(true, true);
/*
echo "<table border='1' cellpadding='1' cellspacing='1'>";
for ($i=1; $i <= $exceldata->sheets[0]['numRows']; $i++) {
	echo "<tr>";
	for ($j=1; $j <= $exceldata->sheets[0]['numCols']; $j++) {
		$cell = $exceldata->val($i, $j);
		//$cell = iconv("ISO-8859-7", "UTF-8", $cell); // Epeidi kapoies eggrafes einai ISO-8859-7 !!!	
		$cell = str_replace("&nbsp;", "", $cell);
		$cell = str_replace("</a>", "", $cell);
		$temp = "";
		$ok_to_copy = true;
		for ($c=0; $c<strlen($cell); $c++) {
			if ($cell[$c] == "<") {
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
		// echo mb_detect_encoding($cell, 'UTF-8', true)." ";
		echo "<td> $cell <td>";
		// echo htmlentities($cell)."<td>";
	}
	echo "</tr>";
	// echo "<br>";
}
echo "<table>";

*/
	
} else {
?>

<HTML>
<HEAD>
<TITLE>ΞΞ±ΞΈΞ±ΟΞΉΟΞΌΟΟ Ξ±ΟΟΞ΅Ξ―ΞΏΟ Excel</TITLE>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="./include/cohort.css" rel="stylesheet" type="text/css">

</HEAD>
<BODY>

<FORM ACTION="clean_xlsfile.php" enctype="multipart/form-data" METHOD="POST">
<h2>ΞΟΟΞ΅Ξ―ΞΏ Excel ΟΞΏΟ ΞΈΞ± ΟΟΞ·ΟΞΉΞΌΞΏΟΞΏΞΉΞ·ΞΈΞ΅Ξ―:</h2> <INPUT TYPE="FILE" NAME="filename">
<BR>
<INPUT TYPE="SUBMIT" VALUE="ΞΟΞΏΟΟΞΏΞ»Ξ� Ξ±ΟΟΞ΅Ξ―ΞΏΟ">
</FORM>	
		
</BODY>
</HTML>

<?
}
?>