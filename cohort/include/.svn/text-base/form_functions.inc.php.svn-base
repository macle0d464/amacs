<?php

function show_patient_data($code)
{
	$query = "SELECT * FROM patients WHERE PatientCode = ".$code;
	$result = execute_query($query);
	$row = mysql_fetch_array($result);        
    mysql_free_result($result);
    echo "<input type=hidden name='PatientCode' value='".$row['PatientCode']."' />";
    echo "<table>";
    echo "<tr><td><b>Κωδικός Ασθενή: ".$row['PatientCode']."</b> &nbsp;&nbsp;&nbsp; </td>";
    if ($row['MELCode'] != "-1")
    {echo "<td><b>Κωδικός ΜΕΛ: ".$row['MELCode']."</b></td></tr>";}
    else {echo "<td></td></tr>";}
    echo "<tr><td><b>'Oνομα: ".$row['Name']."</b> </td><td><b>Eπώνυμο: ".$row['Surname']."</b></td></tr>";
    echo "<tr><td colspan=2><b>Ημερομηνία Γέννησης:&nbsp; ".show_date($row['BirthDate'])."</b></td></tr>";
    echo "<tr><td colspan=2><a href='alter_patient.php?code=".$row['PatientCode']."'><small><b>Αλλαγή Ονόματος & Ημερομηνίας Γέννησης</b></small></a></td></tr>";
    echo "<tr><td></td><td></td></tr>";
    echo "</table>";
}

function check_patient($code)
{
	$query = "SELECT * FROM patients WHERE PatientCode = ".$code;
	$result = execute_query($query);
	$row = mysql_fetch_array($result);        
	$num_rows = mysql_num_rows($result);
    mysql_free_result($result);
	if ($num_rows <> 1)
	{
		show_errormsg("Δεν υπάρχει στη βάση καταχώρηση ασθενή με κωδικό ασθενή ".$code.". Καταχωρήστε πρώτα τον νέο ασθενή στη βάση.");
	}     	
}

function check_hbv_coinfection($code)
{
	$query = "SELECT * FROM coinfections WHERE HBV='1' AND PatientCode = ".$code;
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);
    mysql_free_result($result);
	if ($num_rows <> 1)
	{
		show_errormsg("Δεν υπάρχει στη βάση καταχώρηση με συλλοίμωξη HBV και κωδικό ασθενή ".$code.". <a href='coinfection.php?code=$code'>Καταχωρήστε πρώτα την συνλοίμωξη στη βάση.</a>");
	}     	
}

function check_hcv_coinfection($code)
{
	$query = "SELECT * FROM coinfections WHERE HCV='1' AND PatientCode = ".$code;
	$result = execute_query($query);
	$row = mysql_fetch_array($result);
	$num_rows = mysql_num_rows($result);
    mysql_free_result($result);
	if ($num_rows <> 1)
	{
		show_errormsg("Δεν υπάρχει στη βάση καταχώρηση με συλλοίμωξη HCV και κωδικό ασθενή ".$code.". <a href='coinfection.php?code=$code'>Καταχωρήστε πρώτα την συνλοίμωξη στη βάση.</a>");
	}     	
}

function prepare_data($table, $data_array)
{
	if ($table == 'patients')
    {
    	if ($data_array['PatientCode'] == "")
    	{
    		$corrected_data_array['PatientCode'] = $data_array['MELCode'];
    	}
    	else
    	{
    		$corrected_data_array['PatientCode'] = $data_array['PatientCode'];
    	}
    	if ($data_array['MELCode'] == "")
    	{
    	$corrected_data_array['MELCode'] = -1;
    	}
    	else
    	{
    		$corrected_data_array['MELCode'] = $data_array['MELCode'];
    	}
        $corrected_data_array['Name'] = $data_array['Name'];
        $corrected_data_array['Surname'] = $data_array['Surname'];
        $corrected_data_array['BirthDate'] = join_date($data_array ,'BirthDate');
    }
	if ($table == 'demographic_data')
    {
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
//		$dbconnection2 = cohortdb_connect2();
//		$dbselected2 = cohortdb_select($dbconnection2);
//		mysql_close($dbconnection2);     
		$corrected_data_array['FirstVisit'] = join_date($data_array, 'FirstVisit');
		$corrected_data_array['EnrollDate'] = join_date($data_array, 'EnrollDate');
        $corrected_data_array['Race'] = $data_array['Race'];
        $corrected_data_array['Sex'] = $data_array['Sex'];
        $corrected_data_array['BirthDate'] = join_date($data_array, 'BirthDate');
//        $corrected_data_array['RecentWeight'] = $data_array['RecentWeight'];
//        $corrected_data_array['RecentWeightDate'] = join_date($data_array, 'RecentWeightDate');
//        $corrected_data_array['RecentHeight'] = $data_array['RecentHeight'];
//        $corrected_data_array['RecentHeightDate'] = join_date($data_array, 'RecentHeightDate');
		$corrected_data_array['Origin'] = $data_array['Origin'];        
        $corrected_data_array['EnrollDate'] = join_date($data_array, 'EnrollDate');
        $corrected_data_array['Education'] = $data_array['Education'];
        $corrected_data_array['ClinicDuringRecord'] = $data_array['ClinicDuringRecord'];      
//        $corrected_data_array['PreviousClinic'] = $data_array['PreviousClinic'];      
        $corrected_data_array['PossibleSourceInfection'] = $data_array['PossibleSourceInfection'];
        if ($data_array['PossibleSourceInfection'] =="6")
        {   
        	$corrected_data_array['PossibleSourceExtradata'] = '1';
        	$corrected_data_array['TransfusionPlace'] = $data_array['TransfusionPlace'];
        	$corrected_data_array['TransfusionDate'] = join_date($data_array, 'TransfusionDate');
        	
        }
        else if ($data_array['PossibleSourceInfection'] =="7")
        {
        	$corrected_data_array['PossibleSourceExtradata'] = '1';
        	$corrected_data_array['Country'] = $data_array['Country'];
        	$corrected_data_array['Sailor'] = $data_array['Sailor'];
        	$corrected_data_array['PartnerCountry'] = $data_array['PartnerCountry'];        	        	
        	$corrected_data_array['PartnerDrugs'] = $data_array['PartnerDrugs'];
        	$corrected_data_array['PartnerBi'] = $data_array['PartnerBi'];
        	$corrected_data_array['PartnerTransfusion'] = $data_array['PartnerTransfusion'];        	        	
        	$corrected_data_array['PartnerTransfusionAfter78'] = $data_array['PartnerTransfusionAfter78'];
        	$corrected_data_array['PartnerHIVPlus'] = $data_array['PartnerHIVPlus'];
        	$corrected_data_array['Undefined'] = $data_array['Undefined'];        	        	
        	
        }
        else
        {      	
        	$corrected_data_array['PossibleSourceExtradata'] = '0';        	
        }      
        $corrected_data_array['KnownDateOrometatropi'] = $data_array['KnownDateOrometatropi'];
        $corrected_data_array['FirstPositiveSample'] = join_date($data_array, 'FirstPositiveSample');
        if ($data_array['KnownDateOrometatropi'] == "1")
        {
        	$corrected_data_array['LastNegativeSample'] = join_date($data_array, 'LastNegativeSample');
        	$corrected_data_array['SeroconversionDate'] = join_date($data_array, 'SeroconversionDate'); 
        }
        $corrected_data_array['FirstPositiveSample'] = join_date($data_array, 'FirstPositiveSample');
//        $corrected_data_array['FirstEntryAtClinic'] = join_date($data_array, 'FirstEntryAtClinic');
    }
    if ($table == 'atomiko_anamnistiko')
    {
        $corrected_data_array['PatientCode'] = $data_array['code'];
       	$corrected_data_array['Hypertension'] = $data_array['Hypertension'];
        if ($data_array['Hypertension'] == 1)
        {
        	$corrected_data_array['HypertensionDate'] = join_date($data_array, 'HypertensionDate');
        }
        $corrected_data_array['Stefaniaia'] = $data_array['Stefaniaia'];
        if ($data_array['Stefaniaia'] == 1)
        {
    	    $corrected_data_array['StefaniaiaDate'] = join_date($data_array, 'StefaniaiaDate');
        }
/*        if ($data_array['Emfragma'] == 1)
        {        
        $corrected_data_array['Emfragma'] = $data_array['Emfragma'];
        $corrected_data_array['EmfragmaDate'] = join_date($data_array, 'EmfragmaDate');     
        }   */
        $corrected_data_array['Diabitis'] = $data_array['Diabitis'];
        if ($data_array['Diabitis'] == 1)
        {  
	        $corrected_data_array['DiabitisDate'] = join_date($data_array, 'DiabitisDate');    
        }
		$corrected_data_array['Yperlipidaimia'] = $data_array['Yperlipidaimia'];
        if ($data_array['Yperlipidaimia'] == 1)
        {  
	        $corrected_data_array['YperlipidaimiaDate'] = join_date($data_array, 'YperlipidaimiaDate');    
        }  
        $corrected_data_array['Lipoatrofia'] = $data_array['Lipoatrofia'];    
	    if ($data_array['Lipoatrofia'] == 1)
        {  
	        $corrected_data_array['LipoatrofiaDate'] = join_date($data_array, 'LipoatrofiaDate');    
        }   
        $corrected_data_array['Enapothesi'] = $data_array['Enapothesi'];
        if ($data_array['Enapothesi'] == 1)
        {  
	        $corrected_data_array['EnapothesiDate'] = join_date($data_array, 'EnapothesiDate');    
        }                         
//        $corrected_data_array['Smoking'] = $data_array['Smoking'];
/*        if ($data_array['Smoking'] == 1)
        {
        	$corrected_data_array['AgeStart'] = $data_array['AgeStart'];
        	$corrected_data_array['AgeFullStart'] = $data_array['AgeFullStart'];
        	$corrected_data_array['CigarretesPerDay'] = $data_array['CigarretesPerDay'];
        	$corrected_data_array['CigarsPerDay'] = $data_array['CigarsPerDay'];
        	$corrected_data_array['KapnosPipasPerDay'] = $data_array['KapnosPipasPerDay'];
        	$corrected_data_array['AgeStop'] = $data_array['AgeStop'];
        }
        if ($data_array['Smoking'] == 2)
        {
        	$corrected_data_array['AgeStart'] = $data_array['AgeStart'];
        	$corrected_data_array['AgeFullStart'] = $data_array['AgeFullStart'];
        	$corrected_data_array['CigarretesPerDay'] = $data_array['CigarretesPerDay'];
        	$corrected_data_array['CigarsPerDay'] = $data_array['CigarsPerDay'];
        	$corrected_data_array['KapnosPipasPerDay'] = $data_array['KapnosPipasPerDay'];
        } */
    }
	if ($table == 'exams_orologikes')
	{
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];	
        check_patient($data_array['PatientCode']);        	
        $corrected_data_array['FTA'] = $data_array['FTA'];
        $corrected_data_array['FTADate'] = join_date($data_array, 'FTADate');
        $corrected_data_array['VDRL'] = $data_array['VDRL'];
        $corrected_data_array['VDRLDate'] = join_date($data_array, 'VDRLDate');
        $corrected_data_array['ToxoIgG'] = $data_array['ToxoIgG'];
        $corrected_data_array['ToxoIgGDate'] = join_date($data_array, 'ToxoIgGDate');
        $corrected_data_array['ToxoIgM'] = $data_array['ToxoIgM'];
        $corrected_data_array['ToxoIgMDate'] = join_date($data_array, 'ToxoIgMDate');
        $corrected_data_array['Anti-CMVIgG'] = $data_array['Anti-CMVIgG'];
        $corrected_data_array['Anti-CMVIgGDate'] = join_date($data_array, 'Anti-CMVIgGDate');        
        $corrected_data_array['Anti-CMVIgM'] = $data_array['Anti-CMVIgG'];
        $corrected_data_array['Anti-CMVIgMDate'] = join_date($data_array, 'Anti-CMVIgMDate'); 
        $corrected_data_array['HBsAg'] = $data_array['HBsAg'];
        $corrected_data_array['HBsAgDate'] = join_date($data_array, 'HBsAgDate');
        $corrected_data_array['Anti-HBs'] = $data_array['Anti-HBs'];
        $corrected_data_array['Anti-HBsDate'] = join_date($data_array, 'Anti-HBsDate');
        $corrected_data_array['Anti-HBc'] = $data_array['Anti-HBc'];
        $corrected_data_array['Anti-HBcDate'] = join_date($data_array, 'Anti-HBcDate');
        $corrected_data_array['HBeAg'] = $data_array['HBeAg'];
        $corrected_data_array['HBeAgDate'] = join_date($data_array, 'HBeAgDate');
        $corrected_data_array['Anti-HBe'] = $data_array['Anti-HBe'];
        $corrected_data_array['Anti-HBeDate'] = join_date($data_array, 'Anti-HBeDate');
        $corrected_data_array['Anti-HCV'] = $data_array['Anti-HCV'];
        $corrected_data_array['Anti-HCVDate'] = join_date($data_array, 'Anti-HCVDate');
        $corrected_data_array['Anti-HDV'] = $data_array['Anti-HDV'];
        $corrected_data_array['Anti-HDVDate'] = join_date($data_array, 'Anti-HDVDate');
        $corrected_data_array['Mantoux'] = $data_array['Mantoux'];
        $corrected_data_array['MantouxDate'] = join_date($data_array, 'MantouxDate');

	}
	if ($table == 'exams_bioximikes')
	{
    	$exams = $data_array['exams'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        check_patient($data_array['PatientCode']);
   		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
//	       $corrected_data_array['ExamNumber'.$i] = $j;
     	   $corrected_data_array['ExamDate'.$i] = join_date($data_array, 'ExamDate'.$i);
     	   $corrected_data_array['Sakxaro'.$i] = $data_array['Sakxaro'.$i];
	       $corrected_data_array['HDL'.$i] = $data_array['HDL'.$i];
	       $corrected_data_array['LDL'.$i] = $data_array['LDL'.$i];
	       $corrected_data_array['Xolusterini'.$i] = $data_array['Xolusterini'.$i];
	       $corrected_data_array['Triglukeridia'.$i] = $data_array['Triglukeridia'.$i];	       
		}
	}
	if ($table == 'prophylactic_therapies')
	{
    	$therapies = $data_array['therapies'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        check_patient($data_array['PatientCode']);        
   		for ($i=0; $i< $therapies; $i++) 
		{     	 	
     	   $j=$i+1;
//	       $corrected_data_array['ExamNumber'.$i] = $j;
		   if ($data_array['Therapy'.$i] == "on")
		   {
		   	$corrected_data_array['Therapy'.$i] = $i+1;
		   }
	       $corrected_data_array['Type'.$i] = $data_array['Type'.$i];
	       $corrected_data_array['Reason'.$i] = $data_array['Reason'.$i];
	       $corrected_data_array['EndDate'.$i] = join_date($data_array, 'EndDate'.$i);
     	   $corrected_data_array['StartDate'.$i] = join_date($data_array, 'StartDate'.$i);	       	       
		}
	}
	if ($table == 'exams_iologikes')
	{
    	$exams = $data_array['exams'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        check_patient($data_array['PatientCode']);
   		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
//	       $corrected_data_array['ExamNumber'.$i] = $j;
     	   $corrected_data_array['Result'.$i] = $data_array['Result'.$i];
     	   if ($data_array['Result'.$i] == "-1")
     	   {
     	   		$corrected_data_array['Operator'.$i] = $data_array['Operator1'];
     	   }
		   else
     	   {
     	   		$corrected_data_array['Operator'.$i] = $data_array['Operator2'];
     	   }		   
	       $corrected_data_array['Value'.$i] = $data_array['Value'.$i];
	       $corrected_data_array['Units'.$i] = $data_array['Units'];
	       $corrected_data_array['Method'.$i] = $data_array['Method'.$i];
	       $corrected_data_array['ExamDate'.$i] = join_date($data_array, 'ExamDate'.$i);
		}
	}
	if ($table == 'exams_iologikes_hep')
	{
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        check_patient($data_array['PatientCode']);
     	$corrected_data_array['Result'] = $data_array['Result'];
     	if ($data_array['Result'] == "-1")
     	{
     		$corrected_data_array['Operator'] = $data_array['Operator1'];
     	}
		else
     	{
     		$corrected_data_array['Operator'] = $data_array['Operator2'];
     	}		   
	    $corrected_data_array['Value'] = $data_array['Value'];
	    $corrected_data_array['Method'] = $data_array['Method'];
	    $corrected_data_array['ExamDate'] = join_date($data_array, 'ExamDate');
	}	
	if ($table == 'exams_anosologikes')
	{
    	$exams = $data_array['exams'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
   		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
//	       $corrected_data_array['ExamNumber'.$i] = $j;
	       $corrected_data_array['ExamDate'.$i] = join_date($data_array, 'ExamDate'.$i);
	       $corrected_data_array['AbsoluteLemf'.$i] = $data_array['AbsoluteLemf'.$i];
	       $corrected_data_array['AbsoluteCD4'.$i] = $data_array['AbsoluteCD4'.$i];
	       $corrected_data_array['PercentCD4'.$i] = $data_array['PercentCD4'.$i];
	       $corrected_data_array['AbsoluteCD8'.$i] = $data_array['AbsoluteCD8'.$i];
	       $corrected_data_array['PercentCD8'.$i] = $data_array['PercentCD8'.$i];
//	       $corrected_data_array['Ratio'.$i] = $data_array['Ratio'.$i];	       	       	       
		}
	}
	if ($table == 'exams_ourwn')
	{
    	$exams = $data_array['exams'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
   		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
	       $corrected_data_array['ExamDate'.$i] = join_date($data_array, 'ExamDate'.$i);
	       $corrected_data_array['EB'.$i] = $data_array['EB'.$i];
	       $corrected_data_array['Leukwma'.$i] = $data_array['Leukwma'.$i];
	       if ($corrected_data_array['Leukwma'.$i] == 3)
	       {
	       		$corrected_data_array['Leukwma_extra'.$i] = $data_array['extra'.$i];
	       }
	       else
	       {
	       		$corrected_data_array['Leukwma_extra'.$i] = null;
	       }
	       $corrected_data_array['Puosfairia'.$i] = $data_array['Puosfairia'.$i];
	       $corrected_data_array['Eruthra'.$i] = $data_array['Eruthra'.$i];
	       $corrected_data_array['Kulindroi'.$i] = $data_array['Kulindroi'.$i];	       	       	       
		}
	}	
	if ($table == 'exams_aimatologikes')
	{
    	$exams = $data_array['exams'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
   		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
	       $corrected_data_array['ExamDate'.$i] = join_date($data_array, 'ExamDate'.$i);
	       $corrected_data_array['AbsoluteLemf'.$i] = $data_array['AbsoluteLemf'.$i];	       
	       $corrected_data_array['Leuka'.$i] = $data_array['Leuka'.$i];
	       $corrected_data_array['Aimosfairini'.$i] = $data_array['Aimosfairini'.$i];
	       $corrected_data_array['Aimopetalia'.$i] = $data_array['Aimopetalia'.$i];
	       $corrected_data_array['Aimatokritis'.$i] = $data_array['Aimatokritis'.$i];	       
	       $corrected_data_array['WhiteType'.$i] = $data_array['WhiteType'.$i];
		}		
	}
	if ($table == 'antiretro_treatments')
	{
    	$exams = $data_array['exams'];
		$corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        $corrected_data_array['MELCode'] = $data_array['MELCode'];
        $corrected_data_array['OtherReason'] = $data_array['OtherReason'];
        $corrected_data_array['OtherUnwanted'] = $data_array['OtherUnwanted'];
   		for ($i=0; $i< $exams; $i++) 
		{     	 	
     	   $j=$i+1;
	       $corrected_data_array['Schema'.$i] = $data_array['Schema'.$i];
	       $corrected_data_array['StartDate'.$i] = join_date($data_array, 'StartDate'.$i);
	       $corrected_data_array['EndDate'.$i] = join_date($data_array, 'EndDate'.$i);	       
	       $corrected_data_array['Reason'.$i] = $data_array['Reason'.$i];
	       $corrected_data_array['Unwanted1_'.$i] = $data_array['Unwanted1_'.$i];
	       $corrected_data_array['Unwanted2_'.$i] = $data_array['Unwanted2_'.$i];
	       $corrected_data_array['Unwanted3_'.$i] = $data_array['Unwanted3_'.$i];
	       $corrected_data_array['Drugs1_'.$i] = $data_array['Drugs1_'.$i];
	       $corrected_data_array['Drugs2_'.$i] = $data_array['Drugs2_'.$i];       	       	       
		}
	}
	
	if ($table == 'aids_clinical_status')
	{
		$corrected_data_array['code'] = $data_array['code'];
		$corrected_data_array['HasAIDS'] = $data_array['HasAIDS'];
		$corrected_data_array['CategoryB'] = $data_array['CategoryB'];
		if ($data_array['Asymptotic'] == 1 || $data_array['Lemfadenopatheia'] == 1 || $data_array['Protoloimoksi'] == 1)
		{
			$corrected_data_array['CategoryA'] = 1;
		}
		else
		{
			$corrected_data_array['CategoryA'] = 0;
		}
	}
	if ($table == 'patients_category_a')
	{
		$corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        $corrected_data_array['code'] = $data_array['code'];
		if (isset($data_array['Asymptotic']))
		{
			$corrected_data_array['Asymptotic'] = $data_array['Asymptotic'];
		}
				if (isset($data_array['Lemfadenopatheia']))
		{
			$corrected_data_array['Lemfadenopatheia'] = $data_array['Lemfadenopatheia'];
		}
		if (isset($data_array['Protoloimoksi']))
		{
			$corrected_data_array['Protoloimoksi'] = $data_array['Protoloimoksi'];
		}
	}
	if ($table == 'patients_category_c_reappearances')
	{
    	$nosoi = $data_array['num_nosoi_reappear'];
        $corrected_data_array['code'] = $data_array['code'];	
		for ($i=0; $i< $nosoi; $i++) 
		{     	 	
     	   $j=$i+1;
	       $corrected_data_array['NososSymptDate'.$i] = join_date($data_array, 'NososSymptDate'.$i);
	       $corrected_data_array['NososSymptID'.$i] = $data_array['NososSymptID'.$i];
	       $corrected_data_array['NososSymptDiagnosis'.$i] = $data_array['NososSymptDiagnosis'.$i];  	       	       
		}
	}
	if ($table == 'patients_category_b_reappearances')
	{
    	$syndroms = $data_array['num_syndrom_reappear'];
        $corrected_data_array['code'] = $data_array['code'];		
   		for ($i=0; $i< $syndroms; $i++) 
		{     	 	
     	   $j=$i+1;
	       $corrected_data_array['ReccurenceDate'.$i] = join_date($data_array, 'ReccurenceDate'.$i);
	       $corrected_data_array['ReccurenceSymptom'.$i] = $data_array['ReccurenceSymptom'.$i];	       	       
		}
	}
	if ($table == 'patients_category_b')
	{
        $corrected_data_array['code'] = $data_array['code'];	
		
		for ($i=0; $i< $data_array['symptoms']; $i++)
		{
			if (isset($data_array['ClinicSymptom'.$i]))
			{
			$corrected_data_array['ClinicSymptomDate'.$i] = join_date($data_array, 'ClinicSymptomDate'.$i);
			$corrected_data_array['ClinicSymptom'.$i] = $data_array['ClinicSymptom'.$i];
			}
		}
	}
	if ($table == 'patients_category_c')
	{
        $corrected_data_array['PatientCode'] = $data_array['code'];	
//		$corrected_data_array['HasReappearance'] = $data_array['HasReappearance'];
		if ($data_array['Kantintiasi'] <> "")
		{
  		 $corrected_data_array['Kantintiasi'] = $data_array['Kantintiasi'];
		 $corrected_data_array['Kantintiasi'.'Date'] = join_date($data_array, 'Kantintiasi'.'Date');
		}
		if ($data_array['KantintiasiOiso'] <> "")
		{
  		 $corrected_data_array['KantintiasiOiso'] = $data_array['KantintiasiOiso'];
		 $corrected_data_array['KantintiasiOiso'.'Date'] = join_date($data_array, 'KantintiasiOiso'.'Date');
		}
		if ($data_array['Kokkidioeidomukosi'] <> "")
		{
  		 $corrected_data_array['Kokkidioeidomukosi'] = $data_array['Kokkidioeidomukosi'];
		 $corrected_data_array['Kokkidioeidomukosi'.'Date'] = join_date($data_array, 'Kokkidioeidomukosi'.'Date');
		}
		if ($data_array['Kryptokokkosi'] <> "")
		{
  		 $corrected_data_array['Kryptokokkosi'] = $data_array['Kryptokokkosi'];
		 $corrected_data_array['Kryptokokkosi'.'Date'] = join_date($data_array, 'Kryptokokkosi'.'Date');
		}
		if ($data_array['Kryptosporidiosi'] <> "")
		{
  		 $corrected_data_array['Kryptosporidiosi'] = $data_array['Kryptosporidiosi'];
		 $corrected_data_array['Kryptosporidiosi'.'Date'] = join_date($data_array, 'Kryptosporidiosi'.'Date');
		}
		if ($data_array['CMV'] <> "")
		{
  		 $corrected_data_array['CMV'] = $data_array['CMV'];
		 $corrected_data_array['CMV'.'Date'] = join_date($data_array, 'CMV'.'Date');
		}
		if ($data_array['Amfiblistro'] <> "")
		{
  		 $corrected_data_array['Amfiblistro'] = $data_array['Amfiblistro'];
		 $corrected_data_array['Amfiblistro'.'Date'] = join_date($data_array, 'Amfiblistro'.'Date');
		}
		if ($data_array['AplosErpis'] <> "")
		{
  		 $corrected_data_array['AplosErpis'] = $data_array['AplosErpis'];
		 $corrected_data_array['AplosErpis'.'Date'] = join_date($data_array, 'AplosErpis'.'Date');
		}
		if ($data_array['Istoplasmosi'] <> "")
		{
  		 $corrected_data_array['Istoplasmosi'] = $data_array['Istoplasmosi'];
		 $corrected_data_array['Istoplasmosi'.'Date'] = join_date($data_array, 'Istoplasmosi'.'Date');
		}
		if ($data_array['Isosporidiosi'] <> "")
		{
  		 $corrected_data_array['Isosporidiosi'] = $data_array['Isosporidiosi'];
		 $corrected_data_array['Isosporidiosi'.'Date'] = join_date($data_array, 'Isosporidiosi'.'Date');
		}
		if ($data_array['Avium'] <> "")
		{
  		 $corrected_data_array['Avium'] = $data_array['Avium'];
		 $corrected_data_array['Avium'.'Date'] = join_date($data_array, 'Avium'.'Date');
		}
		if ($data_array['Fumatiosi'] <> "")
		{
  		 $corrected_data_array['Fumatiosi'] = $data_array['Fumatiosi'];
		 $corrected_data_array['Fumatiosi'.'Date'] = join_date($data_array, 'Fumatiosi'.'Date');
		}
		if ($data_array['ExoFumatiosi'] <> "")
		{
  		 $corrected_data_array['ExoFumatiosi'] = $data_array['ExoFumatiosi'];
		 $corrected_data_array['ExoFumatiosi'.'Date'] = join_date($data_array, 'ExoFumatiosi'.'Date');
		}
		if ($data_array['Mukobacteria'] <> "")
		{
  		 $corrected_data_array['Mukobacteria'] = $data_array['Mukobacteria'];
		 $corrected_data_array['Mukobacteria'.'Date'] = join_date($data_array, 'Mukobacteria'.'Date');
		}
		if ($data_array['Carinii'] <> "")
		{
  		 $corrected_data_array['Carinii'] = $data_array['Carinii'];
		 $corrected_data_array['Carinii'.'Date'] = join_date($data_array, 'Carinii'.'Date');
		}
		if ($data_array['Pneumonia12'] <> "")
		{
  		 $corrected_data_array['Pneumonia12'] = $data_array['Pneumonia12'];
		 $corrected_data_array['Pneumonia12'.'Date'] = join_date($data_array, 'Pneumonia12'.'Date');
		}
		if ($data_array['Poluestiaki'] <> "")
		{
  		 $corrected_data_array['Poluestiaki'] = $data_array['Poluestiaki'];
		 $corrected_data_array['Poluestiaki'.'Date'] = join_date($data_array, 'Poluestiaki'.'Date');
		}
		if ($data_array['Salmonela'] <> "")
		{
  		 $corrected_data_array['Salmonela'] = $data_array['Salmonela'];
		 $corrected_data_array['Salmonela'.'Date'] = join_date($data_array, 'Salmonela'.'Date');
		}
		if ($data_array['Toksoplasmosi'] <> "")
		{
  		 $corrected_data_array['Toksoplasmosi'] = $data_array['Toksoplasmosi'];
		 $corrected_data_array['Toksoplasmosi'.'Date'] = join_date($data_array, 'Toksoplasmosi'.'Date');
		}
		if ($data_array['WombCancer'] <> "")
		{
  		 $corrected_data_array['WombCancer'] = $data_array['WombCancer'];
		 $corrected_data_array['WombCancer'.'Date'] = join_date($data_array, 'WombCancer'.'Date');
		}
		if ($data_array['Anoia'] <> "")
		{
  		 $corrected_data_array['Anoia'] = $data_array['Anoia'];
		 $corrected_data_array['Anoia'.'Date'] = join_date($data_array, 'Anoia'.'Date');
		}
		if ($data_array['Kaposi'] <> "")
		{
  		 $corrected_data_array['Kaposi'] = $data_array['Kaposi'];
		 $corrected_data_array['Kaposi'.'Date'] = join_date($data_array, 'Kaposi'.'Date');
		}
		if ($data_array['Burkitt'] <> "")
		{
  		 $corrected_data_array['Burkitt'] = $data_array['Burkitt'];
		 $corrected_data_array['Burkitt'.'Date'] = join_date($data_array, 'Burkitt'.'Date');
		}
		if ($data_array['Anosoblastiko'] <> "")
		{
  		 $corrected_data_array['Anosoblastiko'] = $data_array['Anosoblastiko'];
		 $corrected_data_array['Anosoblastiko'.'Date'] = join_date($data_array, 'Anosoblastiko'.'Date');
		}
		if ($data_array['Protopathes'] <> "")
		{
  		 $corrected_data_array['Protopathes'] = $data_array['Protopathes'];
		 $corrected_data_array['Protopathes'.'Date'] = join_date($data_array, 'Protopathes'.'Date');
		}
		if ($data_array['Apisxniasi'] <> "")
		{
  		 $corrected_data_array['Apisxniasi'] = $data_array['Apisxniasi'];
		 $corrected_data_array['Apisxniasi'.'Date'] = join_date($data_array, 'Apisxniasi'.'Date');
		}				
	}

	if ($table == 'other_treatments')
	{
    	$therapies = $data_array['therapies'];
        $corrected_data_array['PatientCode'] = $data_array['PatientCode'];
        check_patient($data_array['PatientCode']);        
   		for ($i=0; $i< $therapies; $i++) 
		{     	 	
     	   $j=$i+1;
		   if ($data_array['Therapy'.$i] == "on")
		   {
		   	$corrected_data_array['Therapy'.$i] = $i+1;
		   }
	       $corrected_data_array['EndDate'.$i] = join_date($data_array, 'EndDate'.$i);
     	   $corrected_data_array['StartDate'.$i] = join_date($data_array, 'StartDate'.$i);	       	       
		}
	}	
//    print_r($corrected_data_array);
    return $corrected_data_array;
}

function join_date($table, $item)
{
	$ret_string = "<p style='font-family: verdana; font-size:12px'>Κάντε click <a href='javascript:(history.back(-1));'>εδώ</a> για να επιστρέψετε και να κάνετε διορθώσεις στην φόρμα</p>";
	if ($table[$item . '_year'] == "")
	{
	 	return "1911-11-11";
//		return "";
	}
	if ((($table[$item . '_year'] % 4) != 0) && ($table[$item . '_month'] == "2") && ($table[$item . '_day'] == "29"))
	{
		show_errormsg("Ο Φεβρουάριος της χρονιάς ".$table[$item . '_year']." δεν έχει ".$table[$item.'_day']." ημέρες!");
	}
	switch ($table[$item.'_month'])
	{
		case 02:
			if ($table[$item.'_day'] > 29)
			{
				show_errormsg("Ο Φεβρουάριος δεν έχει ".$table[$item.'_day']." ημέρες!");
			}
			break;
		case 04:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Απρίλιος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;
		case 06:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Ιούνιος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;
		case 09:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Σεπτέμβριος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;
		case 11:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Νοέμβριος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;														
	}
	$todays_date = getdate();
	$todays_date = $todays_date['year']*10000 + $todays_date['mon']*100 + $todays_date['mday'];
	if ($table[$item . '_month'] == "")
	{
		$compare_date = $table[$item . '_year']*10000 + 701;
		if ($compare_date <= $todays_date)
		{
			return $table[$item . '_year']."-07-01";
		}
		else 
		{
			show_errormsg('Η ημερομηνία '.$table[$item . '_year'].'-07-01 που δώσατε για καταχώρηση ανήκει στο μέλλον!');
		}
	}
	if ($table[$item . '_day'] == "")
	{
		$compare_date = $table[$item . '_year']*10000 + $table[$item . '_month']*100 + 15;
		if ($compare_date <= $todays_date)
		{
			return $table[$item . '_year']."-".$table[$item . '_month']."-15";
		}
		else 
		{
			show_errormsg('Η ημερομηνία '.$table[$item . '_year'].'-'.$table[$item . '_month'].'-15 που δώσατε για καταχώρηση ανήκει στο μέλλον!');
		}
	}

	$correct_date = $table[$item . '_year'] . "-" . $table[$item . '_month'] . "-" . $table[$item . '_day'];
	$compare_date = $table[$item . '_year']*10000 + $table[$item . '_month']*100 + $table[$item . '_day'];
//	echo $todays_date."<BR>";
//	echo $compare_date."<BR>";
	if ($compare_date <= $todays_date)
	{
		if ($table[$item . '_day'] == "")
		{
			return $table[$item . '_year'] . "-" . $table[$item . '_month'] . "-15";		
		}
		else
		{
			return $correct_date;
		}
	}
	else
	{
		show_errormsg('Η ημερομηνία '.$correct_date.' που δώσατε για καταχώρηση ανήκει στο μέλλον!');
	}
}

function join_date_nc($table, $item)
{
	$ret_string = "<p style='font-family: verdana; font-size:12px'>Κάντε click <a href='javascript:(history.back(-1));'>εδώ</a> για να επιστρέψετε και να κάνετε διορθώσεις στην φόρμα</p>";
	if ($table[$item . '_year'] == "")
	{
	 	return "1911-11-11";
//		return "";
	}
	if ((($table[$item . '_year'] % 4) != 0) && ($table[$item . '_month'] == "2") && ($table[$item . '_day'] == "29"))
	{
		show_errormsg("Ο Φεβρουάριος της χρονιάς ".$table[$item . '_year']." δεν έχει ".$table[$item.'_day']." ημέρες!");
	}
	switch ($table[$item.'_month'])
	{
		case 02:
			if ($table[$item.'_day'] > 29)
			{
				show_errormsg("Ο Φεβρουάριος δεν έχει ".$table[$item.'_day']." ημέρες!");
			}
			break;
		case 04:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Απρίλιος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;
		case 06:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Ιούνιος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;
		case 09:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Σεπτέμβριος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;
		case 11:
			if ($table[$item.'_day'] > 30)
			{
				die("Ο Νοέμβριος δεν έχει 31 ημέρες!".$ret_string);
			}		
			break;														
	}
	$todays_date = getdate();
	$todays_date = $todays_date['year']*10000 + $todays_date['mon']*100 + $todays_date['mday'];
	if ($table[$item . '_month'] == "")
	{
		$compare_date = $table[$item . '_year']*10000 + 701;
		if ($compare_date <= $todays_date)
		{
			return $table[$item . '_year']."-07-01";
		}
		else 
		{
			show_errormsg('Η ημερομηνία '.$table[$item . '_year'].'-07-01 που δώσατε για καταχώρηση ανήκει στο μέλλον!');
		}
	}
	if ($table[$item . '_day'] == "")
	{
		$compare_date = $table[$item . '_year']*10000 + $table[$item . '_month']*100 + 15;
		if ($compare_date <= $todays_date)
		{
			return $table[$item . '_year']."-".$table[$item . '_month']."-15";
		}
		else 
		{
			show_errormsg('Η ημερομηνία '.$table[$item . '_year'].'-'.$table[$item . '_month'].'-15 που δώσατε για καταχώρηση ανήκει στο μέλλον!');
		}
	}

	$correct_date = $table[$item . '_year'] . "-" . $table[$item . '_month'] . "-" . $table[$item . '_day'];
	$compare_date = $table[$item . '_year']*10000 + $table[$item . '_month']*100 + $table[$item . '_day'];
//	echo $todays_date."<BR>";
//	echo $compare_date."<BR>";
	if ($compare_date <= $todays_date)
	{
		if ($table[$item . '_day'] == "")
		{
			return $table[$item . '_year'] . "-" . $table[$item . '_month'] . "-15";		
		}
		else
		{
			return $correct_date;
		}
	}
	else
	{
		show_errormsg('Η ημερομηνία '.$correct_date.' που δώσατε για καταχώρηση ανήκει στο μέλλον!');
	}
}
?>