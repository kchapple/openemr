<?php
class NFQ_0041_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle() 
    {
        return "NFQ 0041 Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        $twoCount = array( Encounter::OPTION_ENCOUNTER_COUNT => 2 );
        if ( $patient->calculateAgeOnDate( $beginDate ) >= 50 &&
            ( Helper::checkEncounter( Encounter::ENC_PRE_MED_SER_40_OLDER, $patient, $beginDate, $endDate, $twoCount ) ||
              Helper::checkEncounter( Encounter::ENC_PRE_MED_GROUP_COUNSEL, $patient, $beginDate, $endDate ) ||
              Helper::checkEncounter( Encounter::ENC_PRE_IND_COUNSEL, $patient, $beginDate, $endDate ) ||
              Helper::checkEncounter( Encounter::ENC_PRE_MED_OTHER_SERV, $patient, $beginDate, $endDate ) ||
              Helper::checkEncounter( Encounter::ENC_NURS_FAC, $patient, $beginDate, $endDate ) ||
              Helper::checkEncounter( Encounter::ENC_NURS_DISCHARGE, $patient, $beginDate, $endDate ) ) ) {
            return true;
        }
        
        return false;
    }
}
