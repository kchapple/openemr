<?php
class NFQ_0041_Exclusions implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0041 Exclusions";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        // TODO check logic
        $encDates = Helper::fetchEncounterDates( Encounter::ENC_INFLUENZA, $patient );
        foreach ( $encDates as $encDate ) {
            if ( Helper::checkAllergy( Allergy::EGGS, $patient, $encDate, $encDate ) ||
                Helper::checkAllergy( Allergy::INFLUENZA_IMMUN, $patient, $encDate, $encDate ) ||
                Helper::checkMed( Medication::ADVERSE_EVT_FLU_IMMUN, $patient, $encDate, $encDate ) ||
                Helper::checkMed( Medication::INTOLERANCE_FLU_IMMUN, $patient, $encDate, $encDate ) ||
                Helper::checkMed( Medication::NO_INFLUENZA_CONTRADICTION, $patient, $encDate, $encDate ) || 
                Helper::checkMed( Medication::NO_INFLUENZA_DECLINED, $patient, $encDate, $encDate ) ||
                Helper::checkMed( Medication::NO_INFLUENZA_PATIENT, $patient, $encDate, $encDate ) ||
                Helper::checkMed( Medication::NO_INFLUENZA_MEDICAL, $patient, $encDate, $encDate ) ||
                Helper::checkMed( Medication::NO_INFLUENZA_SYSTEM, $patient, $encDate, $encDate ) ||
                Helper::checkDiagActive( Diagnosis::INFLUENZA_IMMUN_CONTRADICT, $patient, $encDate, $encDate ) ) {
                return true;
            }
        }
        
        return false;
    }
}
