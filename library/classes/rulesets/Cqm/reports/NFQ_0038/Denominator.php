<?php
class NFQ_0038_Denominator implements CqmFilterIF
{
    public function getTitle() {
        return "Denominator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        $oneEncounter = array( Encounter::OPTION_ENCOUNTER_COUNT => 1 );
        if ( Helper::check( ClinicalType::ENCOUNTER, Encounter::ENC_OUT_PCP_OBGYN, $patient, $beginDate, $endDate, $oneEncounter ) ) {
            return true;
        }
        
        return false;
    }
}
