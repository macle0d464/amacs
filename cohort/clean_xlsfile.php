<?php
header('Content-Type: text/html; charset=utf-8');

require_once('./include/excel_reader2.php');
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');


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

$exceldata = new Spreadsheet_Excel_Reader("./for_import.xls", 'WINDOWS-1253');
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
<TITLE>Καθαρισμός αρχείου Excel</TITLE>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="./include/cohort.css" rel="stylesheet" type="text/css">

</HEAD>
<BODY>

<FORM ACTION="clean_xlsfile.php" enctype="multipart/form-data" METHOD="POST">
<h2>Αρχείο Excel που θα χρησιμοποιηθεί:</h2> <INPUT TYPE="FILE" NAME="filename">
<BR>
<INPUT TYPE="SUBMIT" VALUE="Αποστολή αρχείου">
</FORM>	
		
</BODY>
</HTML>

<?
}
?>