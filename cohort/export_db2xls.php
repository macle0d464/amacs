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
$export_dir = "xlsfiles";
$diagnosis = array();

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

// Export Patients

$sql = "SELECT * FROM patients";
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
AND d.ClinicDuringRecord=c.ClinicID ORDER BY PatientCode ASC";
$result = execute_query($sql);
query2xls($result, "$export_dir/demographic.xls");

// Export Exams

$sql = "SELECT PatientCode, ExamDate AS '����������', Aimatokritis AS '������������', Aimosfairini AS '������������', Leuka AS '�����', Aimopetalia AS '�����������' FROM exams_aimatologikes";
$result = execute_query($sql);
query2xls($result, "$export_dir/aimatologikes.xls");

$sql = "SELECT PatientCode, ExamDate AS '����������', AbsoluteLemf AS '�������� ������� �������������', AbsoluteCD4 AS '�������� ������� CD4', PercentCD4 AS '������� CD4', AbsoluteCD8 AS '�������� ������� CD8', PercentCD8 AS '������� CD8', AbsoluteCD4/AbsoluteCD8 AS '����� CD4/CD8' FROM exams_anosologikes";
$result = execute_query($sql);
query2xls($result, "$export_dir/anosologikes.xls");

// Export Biochemical exams to separate files
$sql = "SELECT DISTINCT `Code` FROM exams_bioximikes ORDER BY Code ASC";
$types_result = execute_query($sql);
for ($i=0; $i<mysql_num_rows($types_result); $i++) {
	$row = mysql_fetch_array($types_result);
	$type = $row[0];
	$sql = "SELECT PatientCode, exams_bioximikes.ExamDate AS '����������', laboratory_codes.Description AS '�������', exams_bioximikes.Value AS '����', exams_bioximikes.Lower AS 'Lower', exams_bioximikes.Upper AS 'Upper', units.Unit AS '�������' FROM exams_bioximikes, laboratory_codes, units WHERE laboratory_codes.Code=exams_bioximikes.Code AND exams_bioximikes.Unit=units.ID AND exams_bioximikes.Code='$type'";
	$result = execute_query($sql);
	query2xls($result, "$export_dir/bioximikes_$type.xls");
}

$sql = "SELECT PatientCode, exams_iologikes.ExamDate AS '����������', exams_iologikes.Result AS '����������', exams_iologikes.Operator AS '�������', exams_iologikes.Value AS '������� ����', units.Unit AS '�������', iologikes_methods.Method AS '�������' FROM exams_iologikes, iologikes_methods, units WHERE iologikes_methods.ID=exams_iologikes.Method AND units.ID=exams_iologikes.Units";
$result = execute_query($sql);
query2xls_iolog($result, "$export_dir/iologikes.xls");

$sql = "SELECT PatientCode, exams_orologikes.ExamDate AS '����������', orologikes_list.Description AS '�������', exams_orologikes.Result AS '����������' FROM exams_orologikes, orologikes_list WHERE orologikes_list.Code=exams_orologikes.Type";
$result = execute_query($sql);
query2xls_iolog($result, "$export_dir/orogikes.xls");

$sql = "SELECT PatientCode, ExamDate AS '����������', EB, Leukwma AS '�������', Leukwma_extra AS ' ', Puosfairia AS '����������', Eruthra AS '������', Kulindroi AS '���������' FROM exams_ourwn";
$result = execute_query($sql);
query2xls_ourwn($result, "$export_dir/exams_ouron.xls");

// Export Therapies

$sql = "SELECT a.PatientCode, b.Name AS '�������', a.StartDate AS '���������� \'�������', a.EndDate AS '���������� ��������' FROM antiretro_treatments a, medicines b WHERE a.Medicine=b.ID";
$result = execute_query($sql);
query2xls_therapy($result, "$export_dir/antiretro_medicines.xls");

$sql = "SELECT antiretro_treatments_compliance.PatientCode, antiretro_treatments_compliance.Schema AS '������������ �����', antiretro_treatments_compliance.StartDate AS '���������� \'�������', antiretro_treatments_compliance.EndDate AS '���������� ��������', antiretro_treatments_compliance.Compliance AS '����������', a1.description AS '����� �������� 1', a2.description AS '����� �������� 2', antiretro_treatments_compliance.Notes AS '����������' FROM antiretro_treatments_compliance, antiretro_reasons a1, antiretro_reasons a2 WHERE a1.id=antiretro_treatments_compliance.Reason1 AND a2.id=antiretro_treatments_compliance.Reason2";
$result = execute_query($sql);
query2xls_therapy($result, "$export_dir/antiretro_treatments.xls");

$sql = "SELECT PatientCode, prophylactic_therapies_list.Therapy AS '��������', Type AS '�����', StartDate AS '���������� \'�������', EndDate AS '���������� ��������', prophylactic_reasons.Reason as '����� ��������', Note AS '����������' FROM prophylactic_therapies,prophylactic_therapies_list, prophylactic_reasons WHERE prophylactic_therapies.Therapy = prophylactic_therapies_list.ID AND prophylactic_therapies.Reason = prophylactic_reasons.ID";
$result = execute_query($sql);
query2xls_therapy($result, "$export_dir/prophylactic_treatments.xls");

$sql = "SELECT PatientCode, other_treatments_list.Therapy AS '��������', other_treatments.StartDate AS '���������� \'�������', other_treatments.EndDate AS '���������� ��������' FROM other_treatments,other_treatments_list WHERE other_treatments.Therapy = other_treatments_list.ID";
$result = execute_query($sql);
query2xls_therapy($result, "$export_dir/alles_treatments.xls");

// Export Stadio Nosou

$sql = "SELECT PatientCode , COUNT( `PatientCode` ) FROM `patients_category_c` GROUP BY PatientCode  ORDER BY 'COUNT( `PatientCode` )' DESC LIMIT 0, 1";
$result = execute_query($sql);
$row = mysql_fetch_array($result);
$max_events = $row[1];

$sql = "SELECT PatientCode, nosos_sundrom_description.Description as syndrom, patients_category_c.Diagnosis as diagnosis, patients_category_c.NososSyndromDate as date FROM patients_category_c,nosos_sundrom_description WHERE patients_category_c.NososSyndrom = nosos_sundrom_description.ID ORDER BY PatientCode ASC";
$result = execute_query($sql);
$sql = "SELECT PatientCode FROM patients WHERE PatientCode NOT IN (SELECT PatientCode FROM patients_category_c)";
$result2 = execute_query($sql);
query2xls_stadionosou($result, "$export_dir/stadio_nosou.xls", $max_events, $result2);

// Export Others

export_table2xls("atomiko_anamnistiko");
export_table2xls("atomiko_anamnistiko_aee");
export_table2xls("atomiko_anamnistiko_emfragma");
export_table2xls("hiv_subtype");
export_table2xls("iris");
export_table2xls("patient_neoplasma");
export_table2xls("patient_other_clinical_state");
export_table2xls("clinic_visits");

shell_exec("create_exported_db_zip.bat");
flush();
?>

<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; H ���������� ��������
������������</p>
<? flush(); ?>

<script>
setTimeout('location.href = "xlsfiles/send_exported_file.php"', 500);
</script>