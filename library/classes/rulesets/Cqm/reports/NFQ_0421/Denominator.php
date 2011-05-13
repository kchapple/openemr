<?php
class NFQ_0421_Denominator implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Denominator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        $oneEncounter = array( Encounter::OPTION_ENCOUNTER_COUNT => 1 );
        if ( Helper::check( ClinicalType::ENCOUNTER, Encounter::ENC_OUTPATIENT, $patient, $beginDate, $endDate, $oneEncounter ) ) {
            return true;
        }
        
        return false;
    }
}