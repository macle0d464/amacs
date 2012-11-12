<?php
require_once('./include/basic_defines.inc.php');
require_once('./include/basic_functions.inc.php');

$dbconnection = cohortdb_connect($cohort_db_server, $cohort_db_username, $cohort_db_password);
$db_selected = mysql_select_db($cohort_db_name, $dbconnection);
if (!$db_selected) {
	die ('Can\'t use ' . $cohort_db_name . ' : ' . mysql_error());
}
?>

<HTML>
<HEAD>
<TITLE>������� ���������</TITLE>
<META http-equiv=Content-Type content="text/html; charset=windows-1253">
<link href="./include/cohort.css" rel="stylesheet" type="text/css">
</HEAD>
<? PrintTopMenu(); ?>

<P>&nbsp;</P>
<P>&nbsp;</P>
<P>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; �������� ���������� &nbsp;&nbsp;
<img src="./images/loading_animation_liferay.gif"></P>

<?
ob_flush();
flush();
sleep(2);
flush();

global $export_dir;
$export_dir = "xlsfiles/giorgos";
$diagnosis = array();

$clinic = $_GET['clinic'];
$year = $_GET['year'];

function export_table2xls($table)
{
	$sql_query = "SELECT * FROM ".$table;
	$results = execute_query($sql_query);
	query2xls($results, 'xlsfiles/'.$table.'.xls');
	//	echo "<P>Table $table exported <A HREF='export/$table.xls'>here</A><P>";
	//	ob_implicit_flush();
}

function query2xls_iolog($result, $method)
{
	if ($method == "download")
	{
		$workbook =& new Spreadsheet_Excel_Writer();
		$workbook->send("query.xls");
	}
	else
	{
		$workbook =& new Spreadsheet_Excel_Writer($method);
	}

	$sheet =& $workbook->addWorksheet('Query Result');

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

	// colors are calculated by subtracting 7 from the color table

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
				if ($field->name == "����������")
				{
					if ($resultrow[$field->name] == "1")
					{
						$sheet->write($j+1,$i,"������",$format_data);
					}
					elseif ($resultrow[$field->name] == "-1")
					{
						$sheet->write($j+1,$i,"��������",$format_data);
					}
				}
				elseif ($field->name == "�������")
				{
					$sheet->write($j+1,$i," ".$resultrow[$field->name]." ",$format_data);
				}
				else
				{
					$sheet->write($j+1,$i,$resultrow[$field->name],$format_data);
				}
				$i++;
			}
			echo "</tr>\n";
		}
	}
	$workbook->close();
}

function query2xls_ourwn($result, $method)
{
	if ($method == "download")
	{
		$workbook =& new Spreadsheet_Excel_Writer();
		$workbook->send("query.xls");
	}
	else
	{
		$workbook =& new Spreadsheet_Excel_Writer($method);
	}

	$sheet =& $workbook->addWorksheet('Query Result');

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
				if ($field->name == "�������")
				{
					if ($resultrow[$field->name] == "-1")
					{
						$sheet->write($j+1,$i,"�������",$format_data);
					}
					elseif ($resultrow[$field->name] == "1")
					{
						$sheet->write($j+1,$i,"�������",$format_data);
					}
					elseif ($resultrow[$field->name] == "2")
					{
						$sheet->write($j+1,$i,"����",$format_data);
					}
					elseif ($resultrow[$field->name] == "3")
					{
						$sheet->write($j+1,$i,"����������",$format_data);
					}
				}
				elseif ($field->name == "���������")
				{
					if ($resultrow[$field->name] == "-1")
					{
						$sheet->write($j+1,$i,"�������",$format_data);
					}
					elseif ($resultrow[$field->name] == "0")
					{
						$sheet->write($j+1,$i,"���",$format_data);
					}
					elseif ($resultrow[$field->name] == "1")
					{
						$sheet->write($j+1,$i,"���",$format_data);
					}
				}
				else
				{
					$sheet->write($j+1,$i,$resultrow[$field->name],$format_data);
				}
				$i++;
			}
			echo "</tr>\n";
		}
	}
	$workbook->close();
}

function query2xls_therapy($result, $method)
{
	if ($method == "download")
	{
		$workbook =& new Spreadsheet_Excel_Writer();
		$workbook->send("query.xls");
	}
	else
	{
		$workbook =& new Spreadsheet_Excel_Writer($method);
	}

	$sheet =& $workbook->addWorksheet('Query Result');

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
				if ($field->name == "����������")
				{
					if ($resultrow[$field->name] == "-1")
					{
						$sheet->write($j+1,$i,"�������",$format_data);
					}
					elseif ($resultrow[$field->name] == "1")
					{
						$sheet->write($j+1,$i,"����",$format_data);
					}
					elseif ($resultrow[$field->name] == "2")
					{
						$sheet->write($j+1,$i,"������",$format_data);
					}
					elseif ($resultrow[$field->name] == "3")
					{
						$sheet->write($j+1,$i,"����",$format_data);
					}
				}
				elseif ($field->name == "���������� ��������")
				{
					if ($resultrow[$field->name] == "3000-01-01")
					{
						$sheet->write($j+1,$i," - ",$format_data);
					}
					else
					{
						$sheet->write($j+1,$i,$resultrow[$field->name],$format_data);
					}
				}
				else
				{
					$sheet->write($j+1,$i,$resultrow[$field->name],$format_data);
				}
				$i++;
			}
			echo "</tr>\n";
		}
	}
	$workbook->close();
}

function query2xls_stadionosou($result, $method, $max_events, $result2)
{
	if ($method == "download")
	{
		$workbook =& new Spreadsheet_Excel_Writer();
		$workbook->send("query.xls");
	}
	else
	{
		$workbook =& new Spreadsheet_Excel_Writer($method);
	}

	$sheet =& $workbook->addWorksheet('Query Result');

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
	$sheet->write(0,$i,"PatientCode", $format_header_row);
	$i++;
	$sheet->write(0,$i,"AIDS", $format_header_row);
	$i++;
	for ($j=0; $j<$max_events; $j++)
	{
		$k=$j+1;
		$sheet->write(0,$i,"�����/�������� $k", $format_header_row);
		$i++;
		$sheet->write(0,$i,"�������� �����/��������� $k", $format_header_row);
		$i++;
		$sheet->write(0,$i,"���������� �����/��������� $k", $format_header_row);
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
		$previous_code="";
		$i = 0;
		$j = 0;
		for ($k=0; $k<$num_rows; $k++)
		{
			$resultrow = mysql_fetch_assoc($result);
			$code = $resultrow['PatientCode'];
			if ($code == $previous_code)
			{
				$sheet->write($j,$i,$resultrow['syndrom'],$format_data);
				$i++;
				if ($resultrow['diagnosis'] = "1")
				{
					$sheet->write($j,$i,"�����������",$format_data);
				}
				elseif ($resultrow['diagnosis'] = "2")
				{
					$sheet->write($j,$i,"���������������",$format_data);
				}
				elseif ($resultrow['diagnosis'] = "3")
				{
					$sheet->write($j,$i,"��� ���������",$format_data);
				}
				$i++;
				$sheet->write($j,$i,$resultrow['date'],$format_data);
				$i++;
			}
			else
			{
				$previous_code = $code;
				$j++;
				$i=0;
				$sheet->write($j,$i,$code,$format_data);
				$i++;
				$sheet->write($j,$i,"NAI",$format_data);
				$i++;
				$sheet->write($j,$i,$resultrow['syndrom'],$format_data);
				$i++;
				if ($resultrow['diagnosis'] = "1")
				{
					$sheet->write($j,$i,"�����������",$format_data);
				}
				elseif ($resultrow['diagnosis'] = "2")
				{
					$sheet->write($j,$i,"���������������",$format_data);
				}
				elseif ($resultrow['diagnosis'] = "3")
				{
					$sheet->write($j,$i,"��� ���������",$format_data);
				}
				$i++;
				$sheet->write($j,$i,$resultrow['date'],$format_data);
				$i++;
			}
		}
		$j++;
		$num_rows = mysql_num_rows($result2);
		for ($k=0; $k<$num_rows; $k++)
		{
			$resultrow = mysql_fetch_assoc($result2);
			$code = $resultrow['PatientCode'];
			$i=0;
			$sheet->write($j,$i,$code,$format_data);
			$i++;
			$sheet->write($j,$i,"OXI",$format_data);
			$j++;
		}
	}
	$workbook->close();
}

// Delete Previous

shell_exec("delete_all_xls.bat");


// Create TEMP Table with target Patients

$sql = "CREATE VIEW `giorgos_patients` AS SELECT * FROM clinic_visits WHERE Clinic='$clinic' GROUP BY PatientCode HAVING MIN(YEAR(DateofVisit)) >= $year";
$result = execute_query($sql);

$filter = "PatientCode IN (SELECT PatientCode FROM giorgos_patients)";

// Export Patients

$sql = "SELECT * FROM patients WHERE $filter";
$result = execute_query($sql);
query2xls($result, "$export_dir/patients.xls");


// Export Demographic Data

$sql = "SELECT d.PatientCode, p.Name AS '�����', p.Surname AS '�������', p.BirthDate AS '���������� ��������',
d.EnrollDate AS '���������� �������� ��� COHORT', d.FirstVisit AS '���������� ������ ���������', r.RaceDescription AS '����', 
 d.Sex AS '����', d.Education AS '��������� �������', d.Origin AS '���������', c.ClinicName AS '������� ��������������',
 d.PossibleSourceInfection AS '������ ���� ��������', d.TransfusionPlace AS '����� ����������', d.TransfusionDate AS '��/��� ����������',
 d.Country, d.Sailor, d.PartnerCountry, d.PartnerDrugs, d.PartnerBi, d.PartnerTransfusion, d.PartnerTransfusionAfter78,
 d.PartnerHIVPlus, d.Undefined, d.SeroconversionDate AS '���������� �������������', d.LastNegativeSample AS 
 '��/��� ���������� ��������� ���������', d.FirstPositiveSample AS '��/��� ������ ������� ���������'
FROM demographic_data d, patients p, races r, clinics c WHERE d.PatientCode=p.PatientCode AND r.RaceID=d.Race
AND d.ClinicDuringRecord=c.ClinicID AND d.$filter ORDER BY PatientCode ASC";
$result = execute_query($sql);
query2xls($result, "$export_dir/demographic.xls");


// Export Exams

$sql = "SELECT PatientCode, ExamDate AS '����������', Aimatokritis AS '������������', Aimosfairini AS '������������', Leuka AS '�����', Aimopetalia AS '�����������' FROM exams_aimatologikes WHERE $filter";
$result = execute_query($sql);
query2xls($result, "$export_dir/aimatologikes.xls");

$sql = "SELECT PatientCode, ExamDate AS '����������', AbsoluteLemf AS '�������� ������� �������������', AbsoluteCD4 AS '�������� ������� CD4', PercentCD4 AS '������� CD4', AbsoluteCD8 AS '�������� ������� CD8', PercentCD8 AS '������� CD8', AbsoluteCD4/AbsoluteCD8 AS '����� CD4/CD8' FROM exams_anosologikes WHERE $filter";
$result = execute_query($sql);
query2xls($result, "$export_dir/anosologikes.xls");

// Export Biochemical exams to separate files
$sql = "SELECT DISTINCT `Code` FROM exams_bioximikes ORDER BY Code ASC";
$types_result = execute_query($sql);
for ($i=0; $i<mysql_num_rows($types_result); $i++) {
	$row = mysql_fetch_array($types_result);
	$type = $row[0];
	$sql = "SELECT PatientCode, exams_bioximikes.ExamDate AS '����������', laboratory_codes.Description AS '�������', exams_bioximikes.Value AS '����', exams_bioximikes.Lower AS 'Lower', exams_bioximikes.Upper AS 'Upper', units.Unit AS '�������' FROM exams_bioximikes, laboratory_codes, units WHERE laboratory_codes.Code=exams_bioximikes.Code AND exams_bioximikes.Unit=units.ID AND exams_bioximikes.Code='$type' AND $filter";
	$result = execute_query($sql);
	query2xls($result, "$export_dir/bioximikes_$type.xls");
}

$sql = "SELECT PatientCode, exams_iologikes.ExamDate AS '����������', exams_iologikes.Result AS '����������', exams_iologikes.Operator AS '�������', exams_iologikes.Value AS '������� ����', units.Unit AS '�������', iologikes_methods.Method AS '�������' FROM exams_iologikes, iologikes_methods, units WHERE iologikes_methods.ID=exams_iologikes.Method AND units.ID=exams_iologikes.Units AND $filter";
$result = execute_query($sql);
query2xls_iolog($result, "$export_dir/iologikes.xls");

$sql = "SELECT PatientCode, exams_orologikes.ExamDate AS '����������', orologikes_list.Description AS '�������', exams_orologikes.Result AS '����������' FROM exams_orologikes, orologikes_list WHERE orologikes_list.Code=exams_orologikes.Type AND $filter";
$result = execute_query($sql);
query2xls_iolog($result, "$export_dir/orogikes.xls");

$sql = "SELECT * FROM coinfections WHERE $filter";
$result = execute_query($sql);
query2xls($result, "$export_dir/coinfections.xls");


shell_exec("create_exported_db_zip.bat");
flush();

execute_query("DROP VIEW `giorgos_patients`");
?>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; H ���������� ��������
������������</p>
<? flush(); ?>

<script>
setTimeout('location.href = "xlsfiles/send_exported_file.php"', 500);
</script>