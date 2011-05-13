<?php
class NFQ_0013_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        $twoEncounters = array( Encounter::OPTION_ENCOUNTER_COUNT => 2 );
        if ( $patient->calculateAgeOnDate( $beginDate ) >= 18 &&
            Helper::check( ClinicalType::DIAGNOSIS, Diagnosis::HYPERTENSION, $patient, $beginDate, $endDate ) &&
            ( Helper::check( ClinicalType::ENCOUNTER, Encounter::ENC_OUTPATIENT, $patient, $beginDate, $endDate, $twoEncounters ) ||
              Helper::check( ClinicalType::ENCOUNTER, Encounter::ENC_NURS_FAC, $patient, $beginDate, $endDate, $twoEncounters ) ) ) {
            return true;
        } 
        
        return false;
    }
}