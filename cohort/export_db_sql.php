<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');
require_once('./include/form_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
	die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
$neoplasmata_query = "SELECT * FROM neoplasmata_descriptions";
$clinicalstates_query = "SELECT * FROM clinical_states_descriptions";
?>

<HTML><HEAD>
<TITLE>Export to SQL with correct chars</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>

<P>&nbsp;</P>
<P>&nbsp;</P>

<?

function export_table2sql($result, $file)
{
    $handle = fopen($file.".sql", "wb");
    $data="";
    
    $i = 0;
    while ($i < mysql_num_fields($result)-1)
    {
        $field = mysql_fetch_field($result, $i);
        $data .= $field->name . ";";
        $i++;
    }
    $field = mysql_fetch_field($result, $i);
    $data .= $field->name . "\n";
//    fwrite($handle, $data);
    $data="";
    $num_rows = mysql_num_rows($result);
    if ($num_rows == 0)
    {
    }
    else
    {
		for ($j=0; $j<$num_rows; $j++)
        {
            $i = 0;
            $resultrow = mysql_fetch_assoc($result);
			fwrite($handle, "INSERT INTO $file VALUES (");
            while ($i < mysql_num_fields($result)-1)
            {
                $field = mysql_fetch_field($result, $i);
                $data .= "'". trim($resultrow[$field->name]) . "', ";
                $i++;
            }
            $field = mysql_fetch_field($result, $i);
            $data .= "'". trim($resultrow[$field->name]) . "');\n";
            fwrite($handle, $data);
            $data="";
        }
    }
    fclose($handle);
}

$table=$_GET['table'];

$result = execute_query("SELECT * FROM $table");
export_table2sql($result, $table);

?>