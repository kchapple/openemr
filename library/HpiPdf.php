<?php
	//require_once("../interface/globals.php");
	//include_once("{$GLOBALS['srcdir']}/sql.inc");
	
	function printHPIReport($pdf,$encounter,$pid){
		//$encounter = 6351;
		$fres = sqlStatement("SELECT * FROM forms WHERE encounter = ".$encounter." and formdir in ('LBF006','LBF007','LBF012','LBF013','vitals')");
		$allForms = array();
		$formids = "";
		while ($frow = sqlFetchArray($fres)){
			array_push($allForms,$frow);
			$formids .= $frow['form_id'];
			$formids .= ",";
		}

		if($formids != ""){
			$formids = substr($formids,0,-1);
		}else{
			return;
		}
		$fieldVals = array();
		$fres = sqlStatement("SELECT field_id, field_value,form_id FROM lbf_data WHERE form_id in (".$formids.")");
		while ($frow = sqlFetchArray($fres)){
			array_push($fieldVals,$frow);
		}
		
		$layoutOptions = array();
		$fres = sqlStatement("SELECT * FROM layout_options WHERE form_id = 'LBF006' OR form_id = 'LBF007' OR form_id = 'LBF012' OR form_id = 'LBF013' OR form_id = 'vitals'");
		while ($frow = sqlFetchArray($fres)){
			array_push($layoutOptions,$frow);
		}
		
		/* form ids*/
		$officeNote = getFormId(array("Office Note","Office Note/HPI"),$allForms);
		$ros = getFormId(array("Review of Systems","Review of Systems/HPI"),$allForms);
		$vitals = getFormId(array("Vitals"),$allForms);
		$pe = getFormId(array("Physical Exam"),$allForms);
		$hpi = getFormId(array("HPI"),$allForms);
		printIntro($pdf);
		printEvaluation($layoutOptions,$officeNote,$fieldVals,$pdf);
		printHPISection($hpi,$layoutOptions,$fieldVals,$pdf);
		printProblemList($pdf,$pid);
		printMedicalHistory($officeNote,$layoutOptions,$fieldVals,$pdf);
		printSurgicalHistory($officeNote,$layoutOptions,$fieldVals,$pdf);
		printHistory($officeNote,$layoutOptions,$fieldVals,$pdf);
		printFamilyHistory($officeNote,$layoutOptions,$fieldVals,$pdf);
		printAllergies($officeNote,$layoutOptions,$fieldVals,$pdf);
		printCurrentMedications($officeNote,$fieldVals,$pdf,$pid);
		printReviewOfSystems($ros,$layoutOptions,$fieldVals,$pdf);
		printVitals($vitals,$pdf);
        printPE($pe,$layoutOptions,$fieldVals,$pdf);
		//printPhysicalExam($pe,$layoutOptions,$fieldVals,$pdf);
		printImpressionPlan($officeNote,$layoutOptions,$fieldVals,$pdf);
		printFollowup($officeNote,$layoutOptions,$fieldVals,$pdf);
        //$val = getFieldValueHPI("e_sig",$officeNote,$fieldVals);
        //$val = explode("-",$val);
        $pdf->SetY($pdf->GetY() + 3);
        $pdf->Row(array("Vitals obtained by ".getFieldValueHPI("vital_capture",$officeNote,$fieldVals)." and reviewed by physician."));
        $pdf->Row(array("HPI and Review of Systems obtained by ".getFieldValueHPI("Review_Capture",$officeNote,$fieldVals)." and reviewed by physician."));
        //$pdf->Row(array("The document was electronically signed on ".$val[1]."-".$val[2]."-".$val[0]));
        //$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','GE_Sign',"");
		$allergy2 = getFieldValueHPI("timestorage",$officeNote,$fieldVals);
		/*foreach($options as $option){
            if($option['field_id'] == "timestorage"){
    			$allergy2 = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
    			$allergy2 = generate_display_field_HPI($option, $allergy2);
            }
		}*/
        $pdf->Row(array("The document was electronically signed on ".$allergy2));
		//$pdf->Output();
	}
	
	function printProblemList($pdf,$pid){
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Active Problem List"));
		$pdf->setSizes(array("arial,,12","arial,,12"));
		$fres = sqlStatement("SELECT * FROM lists WHERE pid = ".$pid." and type='medical_problem' ORDER BY type, begdate");
		while ($frow = sqlFetchArray($fres)){
			$title = $frow['title'];
			$diagnosis = $frow['diagnosis'];
			$diag = "";
			/*if($diagnosis){
				$diag .= " [ ";
				$dcodes = explode(";", $diagnosis);
                foreach ($dcodes as $dcode) {
                    $diag .= lookup_code_descriptions($dcode)." ";
                }
                $diag .= " ]";
			}*/
			$pdf->Row(array($diag." ".$frow['title']));
		}			
	}
	
    function eliminateBrackets($str,$eliminateText = true){
        $start = strpos($str,"[");
        if($start){
            $str = substr($str,0,$start);
        }
        return $str;
    }
    
	function getDrugAttributes($id,$value){
		$res = sqlStatement("SELECT * FROM list_options WHERE list_id = '$id' ORDER BY seq");
    	while ($row = sqlFetchArray($res)){
    		if($row['option_id'] == $value){
    			return xl_list_label($row['title']);
    		}
    	}
    	return ""; 
	}
	
	function printCurrentMedications($formid,$fieldVals,$pdf,$pid){
		if ( $formid ) {
		   $fres = sqlStatement("SELECT * FROM forms where form_id = ".$formid);
			while ($frow = sqlFetchArray($fres)){
	            $fdate = $frow['date'];
	            $fdateArr = explode(" ",$fdate);
	        }
	        $dateArr = explode("-",$fdateArr[0]);
		}
	   $val = getFieldValueHPI("CM_1",$formid,$fieldVals);
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Current Medications"));
        $pdf->setSizes(array("arial,B,12"));
       if($val == 1){
            $pdf->Row(array("Outpatient encounter prescriptions as of ".$dateArr[1]."-".$dateArr[2]."-".$dateArr[0]));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,B,12","arial,B,12"));
    		$pdf->SetWidths(array(10,35,30,100));
    		$pdf->Row(array("","Medication","Dose","Sig"));
    		$pdf->setSizes(array("arial,,12","arial,,12","arial,,12","arial,,12"));
    		$fres = sqlStatement("SELECT * FROM prescriptions WHERE patient_id = ".$pid);
    		while ($frow = sqlFetchArray($fres)){
    			$pdf->Row(array("",$frow['drug'],$frow['size']." ".getDrugAttributes("drug_units", $frow['unit']),$frow['dosage']." in ". getDrugAttributes("drug_form", $frow['form'])." ".getDrugAttributes("drug_interval", $frow['interval'])));	
    		}
        }else{
            $pdf->Row(array("No outpatient encounter prescriptions on file as of ".$dateArr[1]."-".$dateArr[2]."-".$dateArr[0]));
        }
	}

    function displayNoteText($nfld,$formid,$fieldVals){
        $displayString = "";
        $note = getFieldValueHPI($nfld,$formid,$fieldVals);
        if(strlen($note) > 0){
            $displayString .= " (".$note.")";
        }
        $displayString .= ".  ";
        return $displayString;
    }
    
	function printHPISection($formid,$layoutOptions,$fieldVals,$pdf){
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(100));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("HPI"));
		$pdf->setSizes(array("arial,,12"));
		
		$pdf->SetWidths(array(180));
		$displayString = "";
		$ccName = "1CHEST PAIN";
		$cc = "chest pain";
		$val = getFieldValueHPI("CP_001",$formid,$fieldVals);
		$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","CP_001");
		$dispVal = generate_display_field_HPI($options[0], $val);
		if($dispVal == "Yes"){
			$displayString .= "The patient reports ".$cc;
            $displayString .= displayNoteText("CP_004",$formid,$fieldVals);
			//$displayString .= getFieldValueHPI("CP_004",$formid,$fieldVals);
			$val = getFieldValueHPI("CP_003",$formid,$fieldVals);
			$displayString .= " The onset of ".$cc." was ".getFieldValueHPI("CP_002",$formid,$fieldVals)." ".getDrugAttributes("CP_DAYS", $val)." ago. ";
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","CP_005");	
			$displayString .= hpiHelp($options,"CP_005", " The patient describes ".$cc." as ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","CP_006");	
			$displayString .= hpiHelp($options,"CP_006", " The location of the ".$cc." is ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","CP_007");	
			$displayString .= hpiHelp($options,"CP_007", "The ".$cc." radiates to the ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","CP_008");	
			$displayString .= hpiHelp($options,"CP_008", "The ".$cc." is precipitated by ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","CP_009");	
			$displayString .= hpiHelp($options,"CP_009", " Associated symptoms with the ".$cc." include ",$formid,$fieldVals);
		}else{
			$displayString .= "The patient denies ".$cc.". ";
		}
		$displayString .= "\n";
		//$pdf->Row(array($displayString));

		//$pdf->Row(array(""));
		//$displayString = "";
		$ccName = "2SHORTNESS OF BREATH";
		$cc = "shortness of breath";
		$val = getFieldValueHPI("SOB_001",$formid,$fieldVals);
		$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","SOB_001");
		$dispVal = generate_display_field_HPI($options[0], $val);
		if($dispVal == "Yes"){
			$displayString .= "The patient reports ".$cc;
            $displayString .= displayNoteText("SOB_007",$formid,$fieldVals);
			//$displayString .= getFieldValueHPI("SOB_007",$formid,$fieldVals);
			$val = getFieldValueHPI("SOB_005",$formid,$fieldVals);
			$displayString .= " The onset of ".$cc." was ".getFieldValueHPI("SOB_003",$formid,$fieldVals)." ".getDrugAttributes("CP_DAYS", $val)." ago.";
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","SOB_020");	
			$displayString .= hpiHelp($options,"SOB_020", " The ".$cc." is precipitated by ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","SOB_18");	
			$displayString .= hpiHelp($options,"SOB_18", " Associated symptoms with the ".$cc." include ",$formid,$fieldVals);
			
		}else{
			$displayString .= "The patient denies ".$cc.". ";
		}
		//$pdf->Row(array($displayString));
		$displayString .= "\n";
		/*$pdf->Row(array(""));
		$displayString = "";*/
		$ccName = "4HYPERTENSION";
		$cc = "hypertension";
		$val = getFieldValueHPI("HYP_001",$formid,$fieldVals);
		$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","HYP_001");
		$dispVal = generate_display_field_HPI($options[0], $val);
		if($dispVal == "Yes"){
			$displayString .= "The patient reports ".$cc;
            $displayString .= displayNoteText("HYP_006",$formid,$fieldVals);
			//$displayString .= getFieldValueHPI("HYP_006",$formid,$fieldVals);
			$val = getFieldValueHPI("HYP_005",$formid,$fieldVals);
			$displayString .= " The onset of ".$cc." was ".getFieldValueHPI("HYP_003",$formid,$fieldVals)." ".getDrugAttributes("CP_DAYS", $val)." ago.";
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","HYP_008");	
			$displayString .= hpiHelp($options,"HYP_008", " The ".$cc." is precipitated by ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","HYP_010");	
			$displayString .= hpiHelp($options,"HYP_010", " Associated symptoms with the ".$cc." include ",$formid,$fieldVals);
			
		}else{
			$displayString .= "The patient denies ".$cc.". ";
		}
		/*$pdf->Row(array($displayString));
		$pdf->Row(array(""));
		$displayString = "";*/
		$displayString .= "\n";
		$ccName = "5PALPITATIONS";
		$cc = "palpitations";
		$val = getFieldValueHPI("PAL_001",$formid,$fieldVals);
		$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","PAL_001");
		$dispVal = generate_display_field_HPI($options[0], $val);
		if($dispVal == "Yes"){
			$displayString .= "The patient reports ".$cc;
            $displayString .= displayNoteText("PAL_007",$formid,$fieldVals);
			//$displayString .= getFieldValueHPI("PAL_007",$formid,$fieldVals);
			$val = getFieldValueHPI("PAL_005",$formid,$fieldVals);
			$displayString .= " The onset of ".$cc." was ".getFieldValueHPI("PAL_003",$formid,$fieldVals)." ".getDrugAttributes("CP_DAYS", $val)." ago.";
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","PAL_015");	
			$displayString .= hpiHelp($options,"PAL_015", " The patient describes ".$cc." as ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","PAL_011");	
			$displayString .= hpiHelp($options,"PAL_011", " The ".$cc." is precipitated by ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","PAL_013");	
			$displayString .= hpiHelp($options,"PAL_013", " Associated symptoms with the ".$cc." include ",$formid,$fieldVals);
			
		}else{
			$displayString .= "The patient denies ".$cc.". ";
		}
		//$pdf->Row(array($displayString));

		/*$pdf->Row(array(""));
		$displayString = "";*/
		$displayString .= "\n";
		$ccName = "6SYNCOPE";
		$cc = "syncope";
		$val = getFieldValueHPI("SYN_001",$formid,$fieldVals);
		$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","SYN_001");
		$dispVal = generate_display_field_HPI($options[0], $val);
		if($dispVal == "Yes"){
			$displayString .= " The patient reports ".$cc;
            $displayString .= displayNoteText("SYN_007",$formid,$fieldVals);
			//$displayString .= getFieldValueHPI("SYN_007",$formid,$fieldVals);
			$val = getFieldValueHPI("SYN_005",$formid,$fieldVals);
			$displayString .= " The onset of ".$cc." was ".getFieldValueHPI("SYN_003",$formid,$fieldVals)." ".getDrugAttributes("CP_DAYS", $val)." ago.";
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","SYN_011");	
			$displayString .= hpiHelp($options,"SYN_011", " The ".$cc." is precipitated by ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","SYN_013");	
			$displayString .= hpiHelp($options,"SYN_013", " Associated symptoms with the ".$cc." include ",$formid,$fieldVals);
			
		}else{
			$displayString .= "The patient denies ".$cc.". ";
		}
		/*$pdf->Row(array($displayString));
		$pdf->Row(array(""));		
		
		$displayString = "";*/
		$displayString .= "\n";
		$ccName = "3LEG PAIN";
		$cc = "leg pain";
		$val = getFieldValueHPI("LG_001",$formid,$fieldVals);
		$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","LG_001");
		$dispVal = generate_display_field_HPI($options[0], $val);
		if($dispVal == "Yes"){
			$displayString .= "The patient reports ".$cc;
            $displayString .= displayNoteText("LG_007",$formid,$fieldVals);
			//$displayString .= getFieldValueHPI("LG_007",$formid,$fieldVals);
			$val = getFieldValueHPI("LG_005",$formid,$fieldVals);
			$displayString .= " The onset of ".$cc." was ".getFieldValueHPI("LG_003",$formid,$fieldVals)." ".getDrugAttributes("CP_DAYS", $val)." ago.";
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","LG_011");	
			$displayString .= hpiHelp($options,"LG_011", " The patient describes ".$cc." as ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","LG_009");	
			$displayString .= hpiHelp($options,"LG_009", " The location of the ".$cc." is ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","LG_014");	
			$displayString .= hpiHelp($options,"LG_014", " The ".$cc." is precipitated by ",$formid,$fieldVals);
			
			$options = getLayoutOptionsForGroup($layoutOptions,"LBF013",$ccName,"","LG_016");	
			$displayString .= hpiHelp($options,"LG_016", " Associated symptoms with the ".$cc." include ",$formid,$fieldVals);
			
		}else{
			$displayString .= "The patient denies ".$cc.". ";
		}
		$pdf->Row(array($displayString));		
	}
	
	
	function hpiHelp($options,$fid,$str,$formid,$fieldVals){
		$val = generate_display_field_HPI($options[0], getFieldValueHPI($fid,$formid,$fieldVals));
		$displayString = "";
		if(sizeof($val) > 0){
			$displayString = $str;
			if(sizeof($val) == 1){
				$arr = $val[0];
				if(is_array($arr)){
					$displayString .= strtolower($arr[0]).". ";	
				}else{
					$displayString .= strtolower($arr).". ";
				}
				
			}else{
				$i = 1;
				foreach($val as $entry){
					if($i == sizeof($val)){
						$displayString .= " and ";
					}
					$displayString .= strtolower($entry[0]);
					if($i < (sizeof($val) - 1)){
						$displayString .= ",";
					}
					if($i == sizeof($val)){
						$displayString .= ". ";
					}
					$i++;	
				}
			}
		}
        $displayString = str_replace("(r)","right",$displayString);
        $displayString = str_replace("(l)","left",$displayString);
        $displayString = str_replace("(R)","right",$displayString);
        $displayString = str_replace("(L)","left",$displayString);        
		return $displayString;
	}
	
	function printImpressionPlan($formid,$layoutOptions,$fieldVals,$pdf){
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Impression Plan"));
		$pdf->setSizes(array("arial,,12"));
		$pdf->Row(array(getFieldValueHPI("IPN_B09",$formid,$fieldVals)));
        $pdf->SetWidths(array(5,170));
		$pdf->setSizes(array("arial,,12","arial,,12"));
        $pdf->Row(array("",getFieldValueHPI("IPN_B09N",$formid,$fieldVals)));
        $pdf->SetWidths(array(5,30,150));
		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
        $pdf->Row(array("","Medications",getFieldValueHPI("IPN_B15",$formid,$fieldVals)." ".getFieldValueHPI("IPN_B15N",$formid,$fieldVals)));
		$labs = getFieldValueHPI("IPN_A11",$formid,$fieldVals);
		$labs = explode("|",$labs);
		$labstr = "";
		foreach($labs as $lab){
			$labstr .= getDrugAttributes("IP_Labs",$lab);
			$labstr .= "\n";
		}
		$pdf->SetWidths(array(5,30,120));
		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
		$pdf->Row(array("","Labs",$labstr));

		$labs = getFieldValueHPI("IPN_A13",$formid,$fieldVals);
		$labs = explode("|",$labs);
		$labstr = "";
		foreach($labs as $lab){
			$labstr .= getDrugAttributes("IP_Proceedures",$lab);
			$labstr .= "\n";
		}
		$pdf->SetWidths(array(5,30,150));
		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
		$pdf->Row(array("","Procedures",$labstr));
        
        $nextImp = getFieldValueHPI("PLA_5",$formid,$fieldVals);
        if($nextImp != ""){
            $pdf->SetWidths(array(150));
    		$pdf->setSizes(array("arial,,12"));
    		$pdf->Row(array(trim($nextImp)));
            $pdf->SetWidths(array(5,170));
    		$pdf->setSizes(array("arial,,12","arial,,12"));
            $pdf->Row(array("",getFieldValueHPI("PLA_5N",$formid,$fieldVals)));
            $pdf->SetWidths(array(5,30,150));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));            
            $pdf->Row(array("","Medications",getFieldValueHPI("PLA_13",$formid,$fieldVals)." ".getFieldValueHPI("PLA_13N",$formid,$fieldVals)));
    		$labs = getFieldValueHPI("PLA_7",$formid,$fieldVals);
    		$labs = explode("|",$labs);
    		$labstr = "";
    		foreach($labs as $lab){
    			$labstr .= getDrugAttributes("IP_Labs",$lab);
    			$labstr .= "\n";
    		}
    		$pdf->SetWidths(array(5,30,120));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
    		$pdf->Row(array("","Labs",$labstr));
    
    		$labs = getFieldValueHPI("PLA_17",$formid,$fieldVals);
    		$labs = explode("|",$labs);
    		$labstr = "";
    		foreach($labs as $lab){
    			$labstr .= getDrugAttributes("IP_Proceedures",$lab);
    			$labstr .= "\n";
    		}
    		$pdf->SetWidths(array(5,30,150));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
    		$pdf->Row(array("","Procedures",$labstr));            
        }
        
        $nextImp = getFieldValueHPI("PLB_5",$formid,$fieldVals);
        if($nextImp != ""){
            $pdf->SetWidths(array(150));
    		$pdf->setSizes(array("arial,,12"));
    		$pdf->Row(array(trim($nextImp)));
            $pdf->SetWidths(array(5,170));
    		$pdf->setSizes(array("arial,,12","arial,,12"));
            $pdf->Row(array("",getFieldValueHPI("PLB_5N",$formid,$fieldVals)));
            $pdf->SetWidths(array(5,30,150));
        	$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
            $pdf->Row(array("","Medications",getFieldValueHPI("PLB_13",$formid,$fieldVals)." ".getFieldValueHPI("PLB_13N",$formid,$fieldVals)));
    		$labs = getFieldValueHPI("PLB_7",$formid,$fieldVals);
    		$labs = explode("|",$labs);
    		$labstr = "";
    		foreach($labs as $lab){
    			$labstr .= getDrugAttributes("IP_Labs",$lab);
    			$labstr .= "\n";
    		}
    		$pdf->SetWidths(array(5,30,120));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
    		$pdf->Row(array("","Labs",$labstr));
    
    		$labs = getFieldValueHPI("PLB_17",$formid,$fieldVals);
    		$labs = explode("|",$labs);
    		$labstr = "";
    		foreach($labs as $lab){
    			$labstr .= getDrugAttributes("IP_Proceedures",$lab);
    			$labstr .= "\n";
    		}
    		$pdf->SetWidths(array(5,30,120));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
    		$pdf->Row(array("","Procedures",$labstr));            
        }         

        $nextImp = getFieldValueHPI("PLC_5",$formid,$fieldVals);
        if($nextImp != ""){
            $pdf->SetWidths(array(150));
    		$pdf->setSizes(array("arial,,12"));
    		$pdf->Row(array(trim($nextImp)));
            $pdf->SetWidths(array(5,170));
    		$pdf->setSizes(array("arial,,12","arial,,12"));
            $pdf->Row(array("",getFieldValueHPI("PLC_5N",$formid,$fieldVals)));
        $pdf->SetWidths(array(5,30,150));
		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));            
            $pdf->Row(array("","Medications",getFieldValueHPI("PLC_13",$formid,$fieldVals)." ".getFieldValueHPI("PLC_13N",$formid,$fieldVals)));
    		$labs = getFieldValueHPI("PLC_7",$formid,$fieldVals);
    		$labs = explode("|",$labs);
    		$labstr = "";
    		foreach($labs as $lab){
    			$labstr .= getDrugAttributes("IP_Labs",$lab);
    			$labstr .= "\n";
    		}
    		$pdf->SetWidths(array(5,30,120));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
    		$pdf->Row(array("","Labs",$labstr));
    
    		$labs = getFieldValueHPI("PLC_17",$formid,$fieldVals);
    		$labs = explode("|",$labs);
    		$labstr = "";
    		foreach($labs as $lab){
    			$labstr .= getDrugAttributes("IP_Proceedures",$lab);
    			$labstr .= "\n";
    		}
    		$pdf->SetWidths(array(5,30,120));
    		$pdf->setSizes(array("arial,,12","arial,B,12","arial,,12"));
    		$pdf->Row(array("","Procedures",$labstr));            
        }
	}
	
	function printFollowup($formid,$layoutOptions,$fieldVals,$pdf){
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(100));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Follow Up"));
		$pdf->SetWidths(array(180));
		$pdf->setSizes(array("arial,,12"));
		$dmy = getFieldValueHPI("FOL_002",$formid,$fieldVals);
		$pdf->Row(array(getFieldValueHPI("FOL_001",$formid,$fieldVals)." ".getDrugAttributes("DMY", $dmy)." Patient is to follow up with appointment in the office ".getFieldValueHPI("FOL_003",$formid,$fieldVals)));			
	}
	
	function printIntro($pdf){
		$pdf->SetXY(10, $pdf->getY()+ 10);
        $pdf->setSizes(array("arial,,14"));
		$pdf->Row(array("Office Note Info"));
        $pdf->setSizes(array("arial,,12","arial,,12","arial,,12","arial,,12"));
		$pdf->Line(10,$pdf->GetY(),200,$pdf->GetY());
		$pdf->SetWidths(array(40,40,40,50));
		$pdf->Row(array("Author","Note Signed","Last Update User","Last Update Date/Time"));
		$pdf->Row(array("Mark A East, MD","Signed","Mark A East, MD",""));
	}
	
	function printEvaluation($layoutOptions,$formid,$fieldVals,$pdf){
		$rfe = getFieldValueHPI("RFE_1",$formid,$fieldVals);//reason for evaluation
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(55,5,130));
		$pdf->setSizes(array("arial,B,12","","arial,,12"));
		$pdf->Row(array("Reason for Evaluation","",$rfe));
		
        $options = getLayoutOptionsForGroup($layoutOptions,'LBF006','1REFERING PHYSICIANS',"","REF_3");
		$rp = getFieldValueHPI("REF_3",$formid,$fieldVals);//referring physiscian
        foreach($options as $option){
            $rp = generate_display_field_HPI($option, $rp);
        }
        //$rp = generate_display_field_HPI();
        
        
		$pdf->Row(array("Referring Physician","",$rp));
		$pcp = getFieldValueHPI("RFE_3",$formid,$fieldVals);//primary care physiscian
		$pdf->Row(array("Primary Care Physician","",$pcp));
	}
		
	function printMedicalHistory($formid,$layoutOptions,$fieldVals,$pdf){
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','3PAST MEDICAL HISTORY');
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Medical History"));
		foreach($options as $option){
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$curval = generate_display_field_HPI($option, $curval);
            $curval = eliminateBrackets($curval);
			if($curval != ""){
				$pdf->SetWidths(array(160));
				$pdf->setSizes(array("arial,,12","arial,,12"));
				//$pdf->Row(array($option['title'],$curval));
				$pdf->Row(array($curval));
			}
		}
	}
	
	function printSurgicalHistory($formid,$layoutOptions,$fieldVals,$pdf){
		//$formid = 411;
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Surgical History"));
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','4PAST SURGICAL HISTORY');
		$pdf->setSizes(array("arial,B,12"));
		$pdf->Row(array("Surgeries"));
		foreach($options as $option){
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$lines = generate_display_field_HPI($option, $curval);
			$pdf->setSizes(array("arial,,12"));
			if(sizeof($lines) > 0){
				foreach($lines as $line){
				    $pdf->SetX(20);
					//$pdf->Row(array($line[0]."  [ ".$line[1]." ]"));
                    $pdf->Row(array($line[0]));
				}
			}else{
				$pdf->SetX(20);
				$pdf->Row(array("None"));
			}
		}
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','5PROCEDURES _TESTS');

		foreach($options as $option){
			$pdf->SetX(10);
			$pdf->setSizes(array("arial,B,12"));
			if($option['list_id'] == "PROCEDURES_HPI"){
				$pdf->Row(array("Procedure"));
			}
			if($option['list_id'] == "Lab_HPI"){
				$pdf->Row(array("Lab Results"));
			}	
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$lines = generate_display_field_HPI($option, $curval);
			$pdf->setSizes(array("arial,,12"));
			if(sizeof($lines) > 0){
				foreach($lines as $line){
					$pdf->SetX(20);
					//$pdf->Row(array($line[0]."  [ ".$line[1]." ]"));
                    $pdf->Row(array($line[0]));
				}
			}else{
				$pdf->SetX(20);
				$pdf->Row(array("None"));
			}
		}		
	}
	
	function printHistory($formid,$layoutOptions,$fieldVals,$pdf){
		//$formid = 411;
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("History"));
		
		$pdf->setSizes(array("arial,B,12"));
		$pdf->Row(array("Social History"));
		
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','6SOCIAL HISTORY',"Living Situation");
		foreach($options as $option){
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$curval = generate_display_field_HPI($option, $curval);
			$pdf->SetWidths(array(35,130));
			$pdf->setSizes(array("arial,,12","arial,,12"));
			$pdf->SetX(20);
			$pdf->Row(array("Marital Status : ",$curval));
		}
		/*$pdf->SetX(25);
		$pdf->SetWidths(array(30,130));
		$pdf->Row(array("Spouse Name : ",""));
		$pdf->SetX(25);
		$pdf->SetWidths(array(30,130));
		$pdf->Row(array("Number of Children : ",""));
		$pdf->SetX(20);
		$pdf->SetWidths(array(35,130));
		$pdf->Row(array("Years of Education : ","xyz"));*/
		
		$pdf->SetX(10);
		$pdf->setSizes(array("arial,B,12"));
		$pdf->SetWidths(array(80));
		$pdf->Row(array("Social History Main Topics"));
		
		$pdf->SetWidths(array(35,130));
		$pdf->setSizes(array("arial,,12","arial,,12"));
		/*$pdf->SetX(20);
		$pdf->Row(array("Tobacco Use : ",""));*/
			
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','6SOCIAL HISTORY',"Alcohol Use");
		foreach($options as $option){
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$curval = generate_display_field_HPI($option, $curval);
			$pdf->SetWidths(array(35,150));
			$pdf->setSizes(array("arial,,12","arial,,12"));
			$pdf->SetX(20);
			$pdf->Row(array("Alcohol Use : ",$curval));
		}

		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','6SOCIAL HISTORY',"Drug Use");
		foreach($options as $option){
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$curval = generate_display_field_HPI($option, $curval);
			$pdf->SetWidths(array(35,150));
			$pdf->setSizes(array("arial,,12","arial,,12"));
			$pdf->SetX(20);
			$pdf->Row(array("Drug Use : ",$curval));
		}		

		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','6SOCIAL HISTORY',"Sexual Activity");
		foreach($options as $option){
			$curval = "";
			$curval = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$curval = generate_display_field_HPI($option, $curval);
			$pdf->SetWidths(array(35,150));
			$pdf->setSizes(array("arial,,12","arial,,12","arial,,12"));
			$pdf->SetX(20);
            $sexNote = getFieldValueHPI("SHN_1",$formid,$fieldVals);
            if($sexNote != ""){
                $sexNote = " [".$sexNote."]";
            }
			$pdf->Row(array("Sexual Activity : ",$curval.$sexNote));
		}		
		
		/*$pdf->setSizes(array("arial,B,8"));
		$pdf->Row(array("Other Topics"));
		$pdf->SetX(20);
		$pdf->setSizes(array("arial,,8"));
		$pdf->SetWidths(array(130));
		$pdf->Row(array("Where will I get this from?"));
		
		$pdf->SetWidths(array(50));
		$pdf->setSizes(array("arial,B,8"));
		$pdf->Row(array("Social History Narrative"));
		$pdf->SetX(20);
		$pdf->setSizes(array("arial,,8"));
		$pdf->SetWidths(array(130));
		$pdf->Row(array("Where will I get this from?"));*/
	}
	
	function printFamilyHistory($formid,$layoutOptions,$fieldVals,$pdf){
		//$formid = 411;
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(100));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Family History"));
		$pdf->setSizes(array("arial,,12","arial,,12","arial,,12","arial,,12"));
		$pdf->SetWidths(array(40,25,35,90));
		$pdf->Row(array("Problem","Relation","Age of Onset","Comment"));
		
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','8FAMILY HISTORY',"Heart Disease");
		$value = "";
		foreach($options as $option){
			$value = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$value = generate_display_field_HPI($option, $value);
		}
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','8FAMILY HISTORY',"Relation");
		$relation = "";
		foreach($options as $option){
			$relation = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$relation = generate_display_field_HPI($option, $relation);
		}
        $onsetAges = "";
		$ageOfOnsetMother = getFieldValueHPI("FH_4",$formid,$fieldVals);
        if($ageOfOnsetMother != "" && $ageOfOnsetMother != 0){
            $onsetAges .= $ageOfOnsetMother."\n";
        }
		$ageOfOnsetFather = getFieldValueHPI("FH_5",$formid,$fieldVals);
        if($ageOfOnsetFather != "" && $ageOfOnsetFather != 0){
            $onsetAges .= $ageOfOnsetFather."\n";
        }
		$ageOfOnsetSister = getFieldValueHPI("FH_6",$formid,$fieldVals);
        if($ageOfOnsetSister != "" && $ageOfOnsetSister != 0){
            $onsetAges .= $ageOfOnsetSister."\n";
        }
		$ageOfOnsetBrother = getFieldValueHPI("FH_7",$formid,$fieldVals);
        if($ageOfOnsetBrother != "" && $ageOfOnsetBrother != 0){
            $onsetAges .= $ageOfOnsetBrother;
        }                        
		$comment = getFieldValueHPI("FH_2",$formid,$fieldVals);
		$pdf->Row(array("Heart Disease : ".$value,$relation,$onsetAges,$comment));
	}
	
	function printAllergies($formid,$layoutOptions,$fieldVals,$pdf){
		//$formid = 411;
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Allergies"));
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','9ALLERGIES',"ALLERGY 1");
		$allergy1 = "";
		foreach($options as $option){
			$allergy1 = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$allergy1 = generate_display_field_HPI($option, $allergy1);
		}
		$options = getLayoutOptionsForGroup($layoutOptions,'LBF006','9ALLERGIES',"ALLERGY 2");
		$allergy2 = "";
		foreach($options as $option){
			$allergy2 = getFieldValueHPI($option['field_id'],$formid,$fieldVals);
			$allergy2 = generate_display_field_HPI($option, $allergy2);
		}
		$notes = getFieldValueHPI("AL_4",$formid,$fieldVals);
		$pdf->SetX(20);
		$pdf->setSizes(array("arial,,12"));
		$pdf->Row(array($allergy1));
		$pdf->SetX(20);
		$pdf->setSizes(array("arial,,12"));
		$pdf->Row(array($allergy2));
		$pdf->SetX(20);
		$pdf->setSizes(array("arial,,12"));
		$pdf->SetWidths(array(150));
		$pdf->Row(array($notes));
	}
	
	function printReviewOfSystems($formid,$layoutOptions,$fieldVals,$pdf){
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(150));
		$pdf->setSizes(array("arial,B,14"));
		$pdf->Row(array("Review of Systems"));
		$groups = getEntriesForFormType($layoutOptions,"LBF007");
		$groups = groupArrayByFieldHPI($groups,"group_name");
		foreach($groups as $group){
			$heading = substr($group['keyfield'],1);
			//$pdf->Row(array($heading));
			$negArr = array();
			$posArr = array();
			$strange = "";
			foreach($group['group'] as $line){
				$val = getFieldValueHPI($line['field_id'],$formid,$fieldVals);
				$val = generate_display_field_HPI($line,$val);
				if($val == "no" || $val == "No"){
					array_push($negArr,$line['title']);
				}else{
					if($val == ""){
						$strange = $line['title'];
					}else{
						array_push($posArr,$line['title']);
					}
				}
			}
			$pdf->setSizes(array("arial,B,12","arial,,12"));
			$pdf->SetWidths(array(40,150));
			$pdf->Row(array($heading." : ",getDescStr($negArr,$posArr,$strange)));
		}
	}

	function printVitals($id,$pdf){
		//$encounter = 6351;
		if($id != ""){
			//writeSubHeading("Physical Examination",$pdf);
            $pdf->SetXY(10, $pdf->getY()+ 5);
			$pdf->setSizes(array("arial,B,14"));
			$pdf->SetWidths(array(150));
			$pdf->Row(array("Physical Examination"));
            $pdf->Row(array(""));            
			$fres = sqlStatement("select * from form_vitals where id = ".$id);
	
			while ($frow = sqlFetchArray($fres)){
				$vital = $frow;
			}
			$vitals = "Left BP (".$vital['bps']."/".$vital['bpd'].")  |  ";
            $vitals .= "Right BP (".$vital['bpsr']."/".$vital['bpdr'].")  |  ";
			$vitals .= "Pulse (".$vital['pulse'].")  |  ";
			$vitals .= "Resp (".$vital['respiration'].") per min  |  ";
			$vitals .= "Ht (".$vital['height'].") in  |  ";
			$vitals .= "Wt (".$vital['weight'].") lb  |  ";
			
			$vitals .= "Temp (".$vital['temperature'].") F  |  ";
			$vitals .= "Oxygen Stats (".$vital['oxygen_saturation'].")  |  ";
			$vitals .= "BMI (".$vital['BMI'].") Kg/m^2  |  ";
			$vitals .= "BMI Status (".$vital['BMI_status'].")  |  ";
			$vitals .= "Other Notes (".$vital['note'].")    ";		
			$pdf->setSizes(array("arial,,12"));
			$pdf->SetWidths(array(140));
			$pdf->Row(array($vitals));
            $pdf->Row(array(""));
		}
	}
	
    function printPE($formid,$layoutOptions,$fieldVals,$pdf){
        $pdf->setSizes(array("arial,B,12","arial,,12"));
		$pdf->SetWidths(array(50,140));
        $heading = "Constitutional";
        $content = "";
        $val = getFieldValueHPI("CPHE_1",$formid,$fieldVals);
        if($val == 1){
            $content .= " Well Nourished";
            $content .= ",";
        }
        $val = getFieldValueHPI("CPHE_2",$formid,$fieldVals);
        if($val == 1){
            $content .= " Well Developed";
            $content .= ",";
        }
        $val = getFieldValueHPI("CPHE_3",$formid,$fieldVals);
        if($val == 1){
            $content .= " acute distressed";
            $content .= ",";
        }
        $val = getFieldValueHPI("CPHE_5",$formid,$fieldVals);
        $note = trim($val);
        if(strlen($note) > 0){
            $content .= " (".$note.")";
            $content .= ",";
        }              
        $content = trim($content);
        if(strlen($content) > 0){
            $content = substr($content,0,-1);
        }
		$pdf->Row(array($heading." : ",$content));

        $heading = "Head";
        $param1 = "";
        if(getFieldValueHPI("HE_1",$formid,$fieldVals) == 0){
            $param1 = "Not ";
        }
        $param2 = "";
        if(getFieldValueHPI("HE_2",$formid,$fieldVals) == 0){
            $param2 = "Not ";
        }
        $content = $param1."Normocephalic and ".$param2."Atraumatic";
		$pdf->Row(array($heading." : ",$content));

        $heading = "Eyes";
        $param1 = "";
        if(getFieldValueHPI("EY_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $content = $param1."xanthalasma";
        $pdf->Row(array($heading." : ",$content));

        $heading = "Ent";
        $param1 = "";
        if(getFieldValueHPI("ENT_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $param2 = "";
        if(getFieldValueHPI("ENT_2",$formid,$fieldVals) == 0){
            $param2 = "No ";
        }
        $content = $param1."cyanosis and ".$param2."clear oropharynx";
		$pdf->Row(array($heading." : ",$content));

        $heading = "Neck";
        $param1 = "";
        if(getFieldValueHPI("NE_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $param2 = "";
        if(getFieldValueHPI("NE_2",$formid,$fieldVals) == 0){
            $param2 = "No ";
        }
        $param3 = "";
        if(getFieldValueHPI("NE_3",$formid,$fieldVals) == 0){
            $param3 = "No ";
        }        
        $content = $param1."thyromegaly, ".$param2."JVD and ".$param3."carotid bruit";
		$pdf->Row(array($heading." : ",$content));        
        
        $heading = "Extremities";
        $param1 = "";
        if(getFieldValueHPI("EXT_001",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $param2 = "";
        if(getFieldValueHPI("EXT_003",$formid,$fieldVals) == 0){
            $param2 = "No ";
        }
        $param3 = "No Edema";
        if(getFieldValueHPI("EXT_005",$formid,$fieldVals) == 1){
            $murmurType = getDrugAttributes("Edema_1",getFieldValueHPI("EXT_006",$formid,$fieldVals));
            $murmurLocation = getDrugAttributes("Edema_2",getFieldValueHPI("EXT_007",$formid,$fieldVals));
            $param3 = $murmurType." - ".$murmurLocation;
        }
        $note1 = trim(getFieldValueHPI("EXT_002",$formid,$fieldVals));
        $note2 = trim(getFieldValueHPI("EXT_004",$formid,$fieldVals));
        $note3 = trim(getFieldValueHPI("EXT_008",$formid,$fieldVals));
        if(strlen($note1) > 0){
            $note1 = "(".$note1.")";
        }
        if(strlen($note2) > 0){
            $note2 = "(".$note2.")";
        }
        if(strlen($note3) > 0){
            $note3 = "(".$note3.")";
        }                
        $content = $param1."clubbing ".$note1.", ".$param2."cyanosis ".$note2." and ".$param3." ".$note3;
		$pdf->Row(array($heading." : ",$content));
        
        $heading = "Chest";
        $param1 = "";
        if(getFieldValueHPI("CHE_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $param2 = "";
        if(getFieldValueHPI("CHE_2",$formid,$fieldVals) == 0){
            $param2 = "No ";
        }
        $param3 = "";
        if(getFieldValueHPI("CHE_3",$formid,$fieldVals) == 0){
            $param3 = "No ";
        }        
        $content = $param1."wheezing, ".$param2."ronchi and ".$param3."rales";
		$pdf->Row(array($heading." : ",$content));

        $heading = "Cardiovascular";
        $param1 = "Normal ";
        if(getFieldValueHPI("CAR_1",$formid,$fieldVals) == 0){
            $param1 = "Abnormal ";
        }
        $param2 = "No murmur";
        if(getFieldValueHPI("CAR_2",$formid,$fieldVals) == 1){
            $murmurType = getDrugAttributes("CAR_MUR",getFieldValueHPI("TYPMUR",$formid,$fieldVals));
            $murmurLocation = getDrugAttributes("CAR_MUR_TYP",getFieldValueHPI("MURLOC",$formid,$fieldVals));
            $param2 = $murmurType." - ".$murmurLocation;
        }
        $param3 = "No rub";
        if(getFieldValueHPI("CAR_3",$formid,$fieldVals) == 1){
            $murmurType = getDrugAttributes("RUB_OPT",getFieldValueHPI("RUB_OPT",$formid,$fieldVals));
            $param3 = "Rub ".$murmurType;
        }
        $param4 = "No gallop";
        if(getFieldValueHPI("CAR_4",$formid,$fieldVals) == 1){
            $param4 = getDrugAttributes("GAL_OPT",getFieldValueHPI("GAL_OPT",$formid,$fieldVals));
        }
        $param5 = "No PARASTERNAL LIFT or HEAVE";
        if(getFieldValueHPI("CAR_5",$formid,$fieldVals) == 1){
            $lift = getDrugAttributes("PLH",getFieldValueHPI("CAR_15",$formid,$fieldVals));
            $param5 = "PARASTERNAL LIFT or HEAVE ".$lift;
        }
        $note4 = getFieldValueHPI("CAR_6",$formid,$fieldVals);
        if(strlen($note4) > 0){
            $note4 = "(".$note4.")";
        }
        $content = $param1."SI and S2, ".$param2.", ".$param3.", ".$param4.", ".$param5." ".$note4;
		$pdf->Row(array($heading." : ",$content));
        
        $heading = "Abdominal";
        $param1 = "";
        if(getFieldValueHPI("AB_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $param2 = "";
        if(getFieldValueHPI("AB_2",$formid,$fieldVals) == 0){
            $param2 = "No ";
        }
        $param3 = "";
        if(getFieldValueHPI("AB_3",$formid,$fieldVals) == 0){
            $param3 = "No ";
        }        
        $content = $param1."hepatospenomegaly, ".$param2."palpable mass and ".$param3."abdominal bruit";
		$pdf->Row(array($heading." : ",$content));

        $heading = "Musculoskeletal";
        $param1 = "";
        if(getFieldValueHPI("MUS_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $content = $param1."muscle tenderness";
		$pdf->Row(array($heading." : ",$content));        

        $heading = "Skin";
        $param1 = "";
        if(getFieldValueHPI("SK_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $content = $param1."rashes";
		$pdf->Row(array($heading." : ",$content));

        $heading = "Neurological";
        $param1 = "";
        if(getFieldValueHPI("NEU_1",$formid,$fieldVals) == 0){
            $param1 = "Not ";
        }
        $param2 = "";
        if(getFieldValueHPI("NEU_2",$formid,$fieldVals) == 0){
            $param2 = "No ";
        }
        $param3 = "";
        if(getFieldValueHPI("NEU_3",$formid,$fieldVals) == 0){
            $param3 = "No ";
        }        
        $content = $param1."Alert and oriented to person, place, and time, ".$param2."motor deficit and ".$param3."focal sensory deficit";
		$pdf->Row(array($heading." : ",$content));
                
        $heading = "Psychiatric";
        $param1 = "";
        if(getFieldValueHPI("PSY_1",$formid,$fieldVals) == 0){
            $param1 = "No ";
        }
        $content = $param1."memory deficit";
		$pdf->Row(array($heading." : ",$content));
        
        /*
        EXTREMITIES : CLUBBING : , CLOBBING NOTE : , CYANOSIS : , CYANOSIS NOTE : ,
        EDEMA : , SUVERITY - I : , SUVERITY - II : , EDEMA NOTE :
        CARDIOVASCULAR : Normal SI and S2 : , Type : , MURMUR : No, RUB : No, GALLOP : No,
        PARASTERNAL LIFT or HEAVE : No, NOTES : , : , : , : , Type : , Murmur
        Location : , Type : , Murmur Type :
        MUSCULOSKELETAL : muscle tenderness : No
        SKIN : RASHES : Yes
        PSYCHIATRIC : memory deficit : No*/
    }
	function printPhysicalExam($formid,$layoutOptions,$fieldVals,$pdf){
		$groups = getEntriesForFormType($layoutOptions,"LBF012");
		$groups = groupArrayByFieldHPI($groups,"group_name");
		foreach($groups as $group){
			$content = "";
			$heading = substr($group['keyfield'],1);
			$arr = $group['group'];
			$arr = sortArrayByString($arr,"field_id");
			foreach($arr as $line){
				$val = getFieldValueHPI($line['field_id'],$formid,$fieldVals);
				//$val = $line['field_id'];
				$val = generate_display_field_HPI($line,$val);
				$content .= " ".$line['title']." : ".$val.",";
			}
			$content = substr($content,0,-1);
			$pdf->setSizes(array("arial,B,8","arial,,8"));
			$pdf->SetWidths(array(35,100));
			$pdf->Row(array($heading." : ",$content));
		}
	}
	
	function writeSubHeading($heading,$pdf){
		$pdf->SetXY(10, $pdf->getY()+ 5);
		$pdf->SetWidths(array(120));
		$pdf->setSizes(array("arial,B,12"));
		$pdf->Row(array($heading));
	}
	
	function getDescStr($negArr,$posArr,$strange){
		if($strange != ""){
			return $strange;
		}
		$str = "";
		if(sizeof($negArr) > 0){
			$str .= "Negative for ";
			for($i=1; $i <= sizeof($negArr); $i++){
				$str .= $negArr[$i-1];
				if($i < sizeof($negArr)){
					$str .= ",";
				}else{
					$str .= ". ";
				}
			}
		}
		if(sizeof($posArr) > 0){
			$str .= "Positive for ";
			for($i=1; $i <= sizeof($posArr); $i++){
				$str .= $posArr[$i-1];
				if($i < sizeof($posArr)){
					$str .= ",";
				}else{
					$str .= ".";
				}
			}
		}
		return $str;
	}
	
	function getEntriesForFormType($layoutOptions,$formtype){
		$options = array();
		foreach($layoutOptions as $lop){
			if($lop['form_id'] == $formtype){
				array_push($options,$lop);
			}
		}
		return $options;
	}

	function groupArrayByFieldHPI($arr,$grpfld){
		$grpKeys = array();
		foreach($arr as $key){
			array_push($grpKeys,$key[$grpfld]);
		}
		$grpKeys = array_unique($grpKeys);
		$finalArray = array();
		foreach($grpKeys as $grpKey){
			$group = array();
			foreach($arr as $key){
				if($key[$grpfld] == $grpKey){
					array_push($group,$key);
				}
			}
			$element = array();
			$element['keyfield'] = $grpKey;
			$element['group'] = $group;
			array_push($finalArray,$element);
		}
		return $finalArray;
	}
		
	function generate_display_field_HPI($frow, $currvalue) {
		$data_type  = $frow['data_type'];
		$field_id   = $frow['field_id'];
		$list_id    = $frow['list_id'];
		$s = '';

		// generic selection list or the generic selection list with add on the fly
		// feature, or radio buttons
		if ($data_type == 1 || $data_type == 26 || $data_type == 27) {
			$lrow = sqlQuery("SELECT title FROM list_options " .
      			"WHERE list_id = '$list_id' AND option_id = '$currvalue'");
			$s = xl_list_label($lrow['title']);
		}
		
		// simple text field
		else if ($data_type == 2) {
			$s = htmlspecialchars($currvalue);
		}
		
		// long or multi-line text field
		else if ($data_type == 3) {
			$s = nl2br($currvalue);
		}

else if ($data_type == 10 || $data_type == 11) {
    $tmp = '';
    if ($currvalue) {
      $urow = sqlQuery("SELECT fname, lname, specialty FROM users " .
        "WHERE id = ?", array($currvalue) );
      //$tmp = ucwords($urow['fname'] . " " . $urow['lname']);ucfirst
      $tmp = "Dr. ".ucfirst(strtolower($urow['fname'])) . " " . ucfirst(strtolower($urow['lname'])); 
      if (empty($tmp)) $tmp = "($currvalue)";
    }
    /*****************************************************************
    echo "<input type='text'" .
      " size='$fld_length'" .
      " value='$tmp'" .
      " class='under'" .
      " />";
    *****************************************************************/
    if ($tmp === '') { $tmp = '&nbsp;'; }
    else { $tmp = htmlspecialchars( $tmp, ENT_QUOTES); }
    $s = $tmp;
  }
	  // a set of labeled checkboxes
  else if ($data_type == 21) {
    $avalue = explode('|', $currvalue);
    $lres = sqlStatement("SELECT * FROM list_options " .
      "WHERE list_id = '$list_id' ORDER BY seq, title");
    $count = 0;
    while ($lrow = sqlFetchArray($lres)) {
      $option_id = $lrow['option_id'];
      if (in_array($option_id, $avalue)) {
        if ($count++){
       		$s .= "\n";
        }
	  
	// Added 5-09 by BM - Translate label if applicable
        $s .= xl_list_label($lrow['title']);
	    
      }
    }
  }		
		else if ($data_type == 25) {
			$tmp = explode('|', $currvalue);
			$avalue = array();
			foreach ($tmp as $value) {
				if (preg_match('/^([^:]+):(.*)$/', $value, $matches)) {
					$avalue[$matches[1]] = $matches[2];
				}
			}
			$lres = sqlStatement("SELECT * FROM list_options " .
      		"WHERE list_id = '$list_id' ORDER BY seq, title");
			$s = array();
			while ($lrow = sqlFetchArray($lres)) {
				$option_id = $lrow['option_id'];
				$restype = substr($avalue[$option_id], 0, 1);
				$resnote = substr($avalue[$option_id], 2);
				if (empty($restype) && empty($resnote)) continue;
				$arr = array(xl_list_label($lrow['title']),$resnote);
				array_push($s,$arr);
			}
		}
  		return $s;
	}
		
	function getLayoutOptionsForGroup($layoutOptions,$formname,$groupName,$title="",$id=""){
		$options = array();
		foreach($layoutOptions as $layoutOption){
			if($layoutOption['form_id'] == $formname && $layoutOption['group_name'] == $groupName){
				if($title == "" || $layoutOption['title'] == $title){
					if($id == "" || $layoutOption['field_id'] == $id){
						array_push($options,$layoutOption);						
					}	
				}
			}
		}
		return $options;
	}
	
	function getFormId($formnames,$allForms){
		foreach($formnames as $fname){
			foreach($allForms as $form){
				if($form['form_name'] == $fname){
					return $form['form_id'];
				}
			}
		}
	}
	
	function getFieldValueHPI($fieldId,$formid,$fieldVals){
		$value = "";
		foreach($fieldVals as $val){
			if($val['field_id'] == $fieldId && $val['form_id'] == $formid){
				return $val['field_value'];
			}
		}
		return $value;
	}
	
	function sortArrayByString($arr,$field,$datatype="string"){
		if(sizeof($arr) < 2){
			return $arr;
		}
		$keyArray = array();
		foreach($arr as $member){
			if($datatype == "string"){
				array_push($keyArray,strtolower($member[$field]));	
			}
			if($datatype == "date"){
				array_push($keyArray,strtotime($member[$field]));	
			}
		}
		asort($keyArray);
		$keyArray = array_unique($keyArray);
		$sortedArray = array();
		
		foreach($keyArray as $keey){
			foreach($arr as $member){
				if(strtolower($member[$field]) == $keey){
					array_push($sortedArray,$member);
				}
			}
		}
		return $sortedArray;
	}
	
	//printHPIReport();
?>