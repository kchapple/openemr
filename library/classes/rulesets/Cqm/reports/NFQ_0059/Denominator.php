<?php
class NFQ_0059_Denominator implements CqmFilterIF
{
    public function getTitle()
    {
        return "Denominator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        // TODO how to check for these medication types?
        $beginMinus2Years = strtotime( '-2 year' , strtotime( $beginDate ) );
        if ( Helper::checkMed( Medication::DISP_DIABETES, $patient, $beginMinus2Years, $endDate ) ||
            Helper::checkMed( Medication::ORDER_DIABETES, $patient, $beginMinus2Years, $endDate ) ||
            Helper::checkMed( Medication::ACTIVE_DIABETES, $patient, $beginMinus2Years, $endDate ) || 
            ( Helper::checkDiagActive( Diagnosis::DIABETES, $patient, $beginMinus2Years, $endDate ) &&
                ( Helper::checkEncounter( Encounter::ENC_ACUTE_INP_OR_ED, $patient, $beginDate, $endDate ) ||
                  Helper::checkEncounter( Encounter::ENC_NONAC_INP_OUT_OR_OPTH, $patient, $beginDate, $endDate, array( Encounter::OPTION_ENCOUNTER_COUNT => 2 ) ) ) ) ) {
                      return true;
        }
        
        return false;
    }
}
