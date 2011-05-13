<?php
class NFQ_0041_Numerator implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0041 Numerator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        // TODO check logic
        $encDates = Helper::fetchEncounterDates( Encounter::ENC_INFLUENZA, $patient );
        foreach ( $encDates as $encDate ) {
            if ( Helper::checkMed( Medication::INFLUENZA_VAC, $patient, $encDate, $encDate ) ) {
                return true;
            }
        }
        
        return false;
    }
}
