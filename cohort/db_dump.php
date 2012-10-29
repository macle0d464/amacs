<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');
require_once('./include/data_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
   die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}

function add_sheet($result, $table_name, $workbook)
{ 
    $sheet =& $workbook->addWorksheet($table_name);
 
    $format_header_row =& $workbook->addFormat();
    $format_header_row->setTop(1);
    $format_header_row->setLeft(1);
    $format_header_row->setBottom(1);
    $format_header_row->setPattern(1);
    $format_header_row->setBorderColor('black');
    $format_header_row->setFgColor(31);
    $format_header_row->setBold();
    $format_header_row->setShadow();

    $format_data =& $workbook->addFormat();
    $format_data->setAlign('center');
    
// colors are calculated by subtractring 7 from the color table
    
    $i = 0;
    while ($i < mysql_num_fields($result))
    {
        $field = mysql_fetch_field($result, $i);
        $sheet->write(0,$i,$field->name, $format_header_row);
        $i++;
    }
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
        $message = $num_rows . " rows returned!";
        $sheet->write(1,0,$message);
    }
    else
    {
        for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
            while ($i < mysql_num_fields($result))
            {
                $field = mysql_fetch_field($result, $i);
                $sheet->write($j+1,$i,$resultrow[$field->name],$format_data);
                $i++;
            }
        }
    }
}

?>

<HTML><HEAD>
<TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<p>&nbsp; </p>
<p>&nbsp; </p>


<?
$workbook =& new Spreadsheet_Excel_Writer();
$workbook->send("db_dump.xls");

$template_query = "DESCRIBE ";
$tables_result = execute_query("SHOW TABLES");
$num=mysql_num_rows($tables_result);
for ($i=0; $i<$num; $i++)
{
	$table = mysql_fetch_array($tables_result);
	$temp_result = execute_query($template_query . $table[0]);
	echo "<p>Table: ".$table[0]."</p>";
	query2table($temp_result);
	mysql_free_result($temp_result);	
//	$temp_result = execute_query($template_query . $table[0]);
//	add_sheet($temp_result, $table[0], $workbook);
//	mysql_free_result($temp_result);	
}

$workbook->close();
?>

</BODY></HTML>