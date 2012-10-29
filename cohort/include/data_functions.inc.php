<?php
function show_error($form, $errornumber, $error, $extra)
{
	$url = "http://localhost/cohort/" . $form . "?" . "error=" . $error. "&errnum=" . $errornumber . "&" . $extra;
//	echo("<script language=\"JavaScript\" type=\"text/JavaScript\">\n");
//	echo'window.location = "' . $url . '";';
//	echo("</script>\n");
	header("Location: " . $url);
//	echo $url; <A HREF='' onClick='history.go(-2);'>Go Back</A>
	exit;
}

function check_month($value)
{
	if (($value < 1) || ($value > 12))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function check_day($value)
{
	if (($value < 1) || ($value > 31))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function check_dates($table, $date1, $date2)
{
//	return $table[$item . '_year'] . "-" . $table[$item . '_month'] . "-" . $table[$item . '_day'];
	if ($table[$date1 . '_year'] < $table[$date2 . '_year'])
	{
		return 1;
	}
	if ($table[$date1 . '_year'] > $table[$date2 . '_year'])
	{
		return 0;
	}
	if ($table[$date1 . '_year'] = $table[$date2 . '_year'])
	{
		if ($table[$date1 . '_month'] < $table[$date2 . '_month'])
		{
			return 1;
		}
		if ($table[$date1 . '_month'] > $table[$date2 . '_month'])
		{
			return 0;
		}
		if ($table[$date1 . '_month'] = $table[$date2 . '_month'])
		{
			if ($table[$date1 . '_day'] < $table[$date2 . '_day'])
			{
				return 1;
			}
		}
	}
	return 0;
}

function check_dates_simple($date1, $date2)
{
//	return $table[$item . '_year'] . "-" . $table[$item . '_month'] . "-" . $table[$item . '_day'];
	if ($table[$date1 . '_year'] < $table[$date2 . '_year'])
	{
		return 1;
	}
	if ($table[$date1 . '_year'] > $table[$date2 . '_year'])
	{
		return 0;
	}
	if ($table[$date1 . '_year'] = $table[$date2 . '_year'])
	{
		if ($table[$date1 . '_month'] < $table[$date2 . '_month'])
		{
			return 1;
		}
		if ($table[$date1 . '_month'] > $table[$date2 . '_month'])
		{
			return 0;
		}
		if ($table[$date1 . '_month'] = $table[$date2 . '_month'])
		{
			if ($table[$date1 . '_day'] < $table[$date2 . '_day'])
			{
				return 1;
			}
		}
	}
	return 0;
}

function validate_data($table, $data_array)
{
    if ($table == 'patients')
    {
    	if (!is_numeric($data_array['PatientCode']))
    	{
    		if (!is_numeric($data_array['MELCode']))
    		{ 
    			show_errormsg('������ �� ������������ ����������� ��� ��� �� ����� ������� ������ � ������� ���');
    		}
    	}
    	if ($data_array['Name'] == "" || $data_array['Surname'] == "")
    	{
    		show_errormsg('������ �� ������������ ����� �� ������������� ��� ������');
    	}
    	if ($data_array['BirthDate_year'] == "")
    	{
    		show_errormsg('������ �� ������������ ��� ���������� �������� ��� ������');
    	}
    }
	if ($table == 'demographic_data')
    {
       if ($data_array['Race'] == "")
       { show_errormsg('������ �� ��������� ��� ���� ��� ��� ������');}
       if ($data_array['Sex'] == "")
       { show_errormsg('������ �� ��������� ���� ��� ��� ������');}
       if ($data_array['KnownDateOrometatropi'] == "")
       { show_errormsg('������ �� ��������� �� � ������� ���� ������ ���������� �������������');}
       if ($data_array['ClinicDuringRecord'] == "")
       { show_errormsg('������ �� ��������� ��� ������� �������������� ���� ��� ���������');}
//       if ($data_array['PreviousClinic'] == "")
//       { show_errormsg('������ �� ��������� ��� ����������� ������� ��������������');}
       if ($data_array['PossibleSourceInfection'] == "")
       { show_errormsg('������ �� ��������� ��� ������ ���� ��������');}       
       if ($data_array['PossibleSourceInfection'] == "6")
       {
       	if ($data_array['TransfusionPlace'] == "")
       	{show_errormsg('������ �� ������ ��� ���� ��� ����� ����� ����������');}
       }       
     }
     if ($table == 'atomiko_anamnistiko')
     {
/*     	if ($data_array['num_neoplasmata'] > 0)
     	{
     		for ($i=0; $i<$data_array['num_neoplasmata']; $i++)
     		{
     			$j=$i+1;
     			if ($data_array['NeoplasmaID'.$i] == "")
     			{ show_error('atomic.php' , '3' ,'������ �� ��������� ��� ���� ������������ ��� ���� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
     			if (check_month($data_array['NeoplasmaDate'.$i.'_month']))
     			{ show_error('atomic.php' , '3' ,'� ����� ��� ������������ '.$j.' ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
     			if (check_day($data_array['NeoplasmaDate'.$i.'_day']))
     			{ show_error('atomic.php' , '3' ,'� ����� ��� ������������ '.$j.' ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
     		}
			if (!isset($data_array['Hypertension']))
			{ show_error('atomic.php' , '4' ,'������ �� ��������� ��� ���� ��� ��� ��������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']); }
  			if (check_month($data_array['HypertensionDate_month']))
   			{ show_error('atomic.php' , '5' ,'� ����� ��� ��������� ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
   			if (check_day($data_array['HypertensionDate_day']))
   			{ show_error('atomic.php' , '5' ,'� ����� ��� ��������� ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}

   			if (!isset($data_array['Stefaniaia']))
			{ show_error('atomic.php' , '6' ,'������ �� ��������� ��� ���� ��� ��� ���������� ����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']); }
  			if (check_month($data_array['StefaniaiaDate_month']))
   			{ show_error('atomic.php' , '7' ,'� ����� ��� ����������� ����� ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
   			if (check_day($data_array['StefaniaiaDate_day']))
   			{ show_error('atomic.php' , '7' ,'� ����� ��� ����������� ����� ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}

   			if (!isset($data_array['Emfragma']))
			{ show_error('atomic.php' , '8' ,'������ �� ��������� ��� ���� ��� �� �� � ������� ���� ������� ��������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']); }
  			if (check_month($data_array['EmfragmaDate_month']))
   			{ show_error('atomic.php' , '9' ,'� ����� ��� ����������� ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
   			if (check_day($data_array['EmfragmaDate_day']))
   			{ show_error('atomic.php' , '9' ,'� ����� ��� ����������� ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}

			if (!isset($data_array['Diabitis']))
			{ show_error('atomic.php' , '10' ,'������ �� ��������� ��� ���� ��� �� �� ������ � ������� ��� ��������� �������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']); }
  			if (check_month($data_array['DiabitisDate_month']))
   			{ show_error('atomic.php' , '11' ,'� ����� ��� ������� ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
   			if (check_day($data_array['DiabitisDate_day']))
   			{ show_error('atomic.php' , '11' ,'� ����� ��� ������� ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}

			if (!isset($data_array['Fat']))
			{ show_error('atomic.php' , '12' ,'������ �� ��������� ��� ���� ��� �� �� � ������� ���� ����������� ����������/��������� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']); }
  			if (check_month($data_array['FatDate_month']))
   			{ show_error('atomic.php' , '13' ,'� ����� ��� �����������/���������� ������ ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
   			if (check_day($data_array['FatDate_day']))
   			{ show_error('atomic.php' , '13' ,'� ����� ��� �����������/���������� ������ ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}

			for ($i=0; $i<$data_array['num_states']; $i++)
     		{
     			$j=$i+1;
     			if ($data_array['ClinicalStatusID'.$i] == "")
     			{ show_error('atomic.php' , '14' ,'������ �� ��������� ��� ���� �������� ���������� ��� ���� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
     			if (check_month($data_array['ClinicalStatusDate'.$i.'_month']))
     			{ show_error('atomic.php' , '14' ,'� ����� ��� �������� ���������� '.$j.' ��� ����� ������!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
     			if (check_day($data_array['ClinicalStatusDate'.$i.'_day']))
     			{ show_error('atomic.php' , '14' ,'� ����� ��� �������� ���������� '.$j.' ��� ����� �����!', 'numsta='.$data_array['num_states'].'&numneo='.$data_array['num_neoplasmata']);}
     		}*/
     	}
     	if ($table ==  exams_orologikes)
     	{
/*			if (!isset($data_array['FTA']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� FTA!', '');}			
			if (!isset($data_array['VDRL']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� VDRL!', '');}			
			if (!isset($data_array['ToxoIgG']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� �������� ��� ���������� - IgG!', '');}			
			if (!isset($data_array['ToxoIgM']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� �������� ��� ���������� - IgM!', '');}			
			if (!isset($data_array['Anti-CMVIgG']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-CMV - IgG!', '');}			
			if (!isset($data_array['Anti-CMVIgM']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-CMV - IgM!', '');}			
     	if (!isset($data_array['HBsAg']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� HBsAg!', '');}			
			if (!isset($data_array['Anti-HBs']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-HBs!', '');}			
			if (!isset($data_array['Anti-HBc']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-HBc!', '');}			
			if (!isset($data_array['HBAg']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� HBAg!', '');}			
			if (!isset($data_array['Anti-HBe']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-HBe!', '');}			
			if (!isset($data_array['Anti-HCV']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-HCV!', '');}	
			if (!isset($data_array['Anti-HDV']))
     	{ show_error('orologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� Anti-HDV!', '');}	*/
     	}
     	if ($table ==  "exams_bioximikes")
     	{
     		$exams = $data_array['exams'];
     	 	if (!is_numeric($data_array['MELCode']))
     	{ show_error('bioximikes.php' , '' ,'� ������� ��� ������ �� ����� �������!', '&exams='.$exams);}
		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['Sakxaro'.$i] == "")
     		{ show_error('bioximikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� �������!', '&exams='.$exams);}
     	   if ($data_array['ALT'.$i] == "")
     		{ show_error('bioximikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� �LT!', '&exams='.$exams);}
     	   if ($data_array['AST'.$i] == "")
     		{ show_error('bioximikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� �ST!', '&exams='.$exams);}
     	   if ($data_array['Xolusterini'.$i] == "")
     		{ show_error('bioximikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� �����������!', '&exams='.$exams);}
     	   if ($data_array['Triglukeridia'.$i] == "")
     		{ show_error('bioximikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� �������������!', '&exams='.$exams);}
		}
     	}
     	if ($table ==  "prophylactic_therapies")
     	{
     		$therapies = $data_array['therapies'];
     	 	if (!is_numeric($data_array['MELCode']))
     	{ show_error('prophylactic.php' , '' ,'� ������� ��� ������ �� ����� �������!&exams='.$exams);}
		for ($i=0; $i< $therapies; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['Therapy'.$i] == "")
     		{ show_error('prophylactic.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ������������ ��������!', '&exams='.$exams);}
			if ($data_array['Type'.$i] == "")
     		{ show_error('prophylactic.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ����!', '&exams='.$exams);}
			if ($data_array['Reason'.$i] == "")
     		{ show_error('prophylactic.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ����� ��������!', '&exams='.$exams);}
			if ($data_array['Reason'.$i] == 4 && $data_array['OtherReason'.$i] == "")
     		{ show_error('prophylactic.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ���� ����� ��������!', '&exams='.$exams);}
     		if (!check_dates($data_array, 'TherapyDateStart'.$i , 'TherapyDateEnd'.$i))
	     	{show_error('prophylactic.php' , '' ,'�� ����������� ������� ��� �������� ��� ��� '.$j.'� �������� ��� ����� � ��� ���� ��� ����!', '&exams='.$exams);}

		}
     	}
     	if ($table ==  "exams_iologikes")
     	{
     		$exams = $data_array['exams'];
		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['Result'.$i] == "")
     		{ show_error('iologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� ����������!', '&exams='.$exams);}
			if ($data_array['Value'.$i] == "")
     		{ show_error('iologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ����!', '&exams='.$exams);}
			if ($data_array['Method'.$i] == "")
     		{ show_error('iologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ������!', '&exams='.$exams);}
			if ($data_array['Method'.$i] == 9 && $data_array['OtherMethod'.$i] == "")
     		{ show_error('iologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ���� ������!', '&exams='.$exams);}
		}
     	}
     	if ($table ==  "exams_anosologikes")
     	{
     		$exams = $data_array['exams'];
		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['Leuka'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� ����� �����������!', '&exams='.$exams);}
			if ($data_array['Aimosfairini'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ������������!', '&exams='.$exams);}
			if ($data_array['Aimopetalia'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� �����������!', '&exams='.$exams);}
			if ($data_array['AbsoluteCD4'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o� '.$j.'� ������� ������ CD4!', '&exams='.$exams);}
			if ($data_array['PercentCD4'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o '.$j.'� ������� CD4!', '&exams='.$exams);}
			if ($data_array['AbsoluteCD8'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o� '.$j.'� ������� ������ CD8!', '&exams='.$exams);}
			if ($data_array['PercentCD8'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o '.$j.'� ������� CD8!', '&exams='.$exams);}
			if ($data_array['Ratio'.$i] == "" || $data_array['Ratio'.$i] < 0 || $data_array['Ratio'.$i] > 100)
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ����� ���� ��� �o� '.$j.'� ���� CD4 (%) / CD8 (%)!', '&exams='.$exams);}
		}
     	}
     	if ($table ==  "antiretro_treatments")
     	{
     	 	if (!is_numeric($data_array['MELCode']))
     		{ show_error('antiretro.php' , '' ,'� ������� ��� ������ �� ����� �������!');}
     	 	if ($data_array['MELCode'] == "")
     		{ show_error('antiretro.php' , '' ,'������ �� ������ ������ ���!');}     		
		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['Leuka'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �� '.$j.'� ����� �����������!', '&exams='.$exams);}
			if ($data_array['Aimosfairini'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� ������������!', '&exams='.$exams);}
			if ($data_array['Aimopetalia'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� ��� '.$j.'� �����������!', '&exams='.$exams);}
			if ($data_array['AbsoluteCD4'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o� '.$j.'� ������� ������ CD4!', '&exams='.$exams);}
			if ($data_array['PercentCD4'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o '.$j.'� ������� CD4!', '&exams='.$exams);}
			if ($data_array['AbsoluteCD8'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o� '.$j.'� ������� ������ CD8!', '&exams='.$exams);}
			if ($data_array['PercentCD8'.$i] == "")
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ���� ��� �o '.$j.'� ������� CD8!', '&exams='.$exams);}
			if ($data_array['Ratio'.$i] == "" || $data_array['Ratio'.$i] < 0 || $data_array['Ratio'.$i] > 100)
     		{ show_error('anosologikes.php' , '' ,'������ �� ������ ��� ����� ���� ��� �o� '.$j.'� ���� CD4 (%) / CD8 (%)!', '&exams='.$exams);}
		}
     	}

     	if ($table ==  "aids_clinical_status")
     	{
     		$nosoi = $data_array['num_nosoi_reappear'];
     		$syndrom = $data_array['num_syndrom_reappear'];
     	 	if (!is_numeric($data_array['PatientCode']))
     		{ show_error('clinical_status.php' , '' ,'� ������� ������ ������ �� ����� �������!&nosoi='.$nosoi.'&syndrom'.$syndrom);}
		for ($i=0; $i< $nosoi; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['NososSymptID'.$i] == "")
     		{ show_error('clinical_status.php' , '' ,'������ �� ������ ��� ���� ��� �o '.$j.'� ������/�������� ��� ���������������!&nosoi='.$nosoi.'&syndrom'.$syndrom);}
			if ($data_array['NososSymptDiagnosis'.$i] == "")
     		{ show_error('clinical_status.php' , '' ,'������ �� ������ ��� �������� ��� �o '.$j.'� ������/�������� ��� ���������������!&nosoi='.$nosoi.'&syndrom'.$syndrom);}			
			if (check_month($data_array['NososSymptDate'.$i.'_month']) || check_day($data_array['NososSymptDate'.$i.'_day']))
     		{ show_error('clinical_status.php' , '' ,'������ �� ������ ��� ����� ���������� ��� �o '.$j.'� ������/�������� ��� ���������������!&nosoi='.$nosoi.'&syndrom'.$syndrom);}			
		}
		for ($i=0; $i< $syndrom; $i++) 
		{     	 	
     	   $j=$i+1;
			if ($data_array['ReccurenceSymptom'.$i] == "")
     		{ show_error('clinical_status.php' , '' ,'������ �� ������ ��� ���� ��� �o '.$j.'� ������� �������� ��� ���������������!&nosoi='.$nosoi.'&syndrom'.$syndrom);}
			if (check_month($data_array['ReccurenceDate'.$i.'_month']) || check_day($data_array['ReccurenceDate'.$i.'_day']))
     		{ show_error('clinical_status.php' , '' ,'������ �� ������ ��� ����� ���������� ��� �o '.$j.'� ������� �������� ��� ���������������!&nosoi='.$nosoi.'&syndrom'.$syndrom);}			
		}
     	}

     	
     	if ($table ==  "other_treatments")
     	{
     	 	if (!is_numeric($data_array['MELCode']))
     	{ show_error('alles.php' , '' ,'� ������� ��� ������ �� ����� �������!', '');}
     		if (!check_dates($data_array, 'InterleukiniDateStart' , 'InterleukiniDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� ��� ������������-2  ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'AuksitikoiDateStart' , 'AuksitikoiDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� ���� ��������� ���������� ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'InterferoniDateStart' , 'InterferoniDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� ��� �����������  ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'RibaviriniDateStart' , 'RibaviriniDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� ��� �����������  ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'YpolipidaimikiDateStart' , 'YpolipidaimikiDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� ��� �������������� �����  ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'AnabolicsDateStart' , 'AnabolicsDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� �� ��������� ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'AntifumatikiDateStart' , 'AntifumatikiDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� ��� ������������ ��������  ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'KuttarostatikaDateStart' , 'KuttarostatikaDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� �� �������������� ��� ����� � ��� ���� ��� ����!', '');}
     		if (!check_dates($data_array, 'DiabetesDateStart' , 'DiabetesDateEnd'))
     	{show_error('alles.php' , '' ,'�� ����������� ������� ��� �������� ��� �� ��������������  ��� ����� � ��� ���� ��� ����!', '');}
     	}
}
?> 