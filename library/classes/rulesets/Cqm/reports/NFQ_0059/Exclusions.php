<?php
class NFQ_0059_Exclusions implements CqmFilterIF
{
    public function getTitle()
    {
        return "Exclusions";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        $beginMinus2Years = strtotime( '-2 year' , strtotime( $beginDate ) );
        if ( ( Helper::checkDiagActive( Diagnosis::POLYCYSTIC_OVARIES, $patient, $patient->dob, $endDate ) &&
              !( Helper::checkDiagActive( Diagnosis::DIABETES, $patient, $beginMinus2Years, $endDate ) &&
                 ( Helper::checkEncounter( Encounter::ENC_ACUTE_INP_OR_ED, $patient, $beginMinus2Years, $endDate ) ||
                   Helper::checkEncounter( Encounter::ENC_NONAC_INP_OUT_OR_OPTH, $patient, $beginMinus2Years, $endDate ) ) ) ) ||
             ( ( Helper::checkDiagActive( Diagnosis::GESTATIONAL_DIABETES, $patient, $beginMinus2Years, $endDate ) ||
                 Helper::checkDiagActive( Diagnosis::STEROID_INDUCED_DIABETES,$patient, $beginMinus2Years, $endDate ) ) && 
               ( Helper::checkMed( Medication::DISP_DIABETES, $patient, $beginMinus2Years, $endDate ) ||
                 Helper::checkMed( Medication::ORDER_DIABETES, $patient, $beginMinus2Years, $endDate ) ||
                 Helper::checkMed( Medication::ACTIVE_DIABETES, $patient, $beginMinus2Years, $endDate ) ) && 
              !( Helper::checkDiagActive( Diagnosis::DIABETES, $patient, $beginMinus2Years, $endDate ) && 
                 ( Helper::checkEncounter( Encounter::ENC_ACUTE_INP_OR_ED, $patient, $beginMinus2Years, $endDate ) ||
                   Helper::checkEncounter( Encounter::ENC_NONAC_INP_OUT_OR_OPTH, $patient, $beginMinus2Years, $endDate ) ) ) ) ) {
            return true;          
        }
        
        return false;
    }
}
