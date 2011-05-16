<?php
class NFQ_0059_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle()
    {
        return "Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        $age = $patient->calculateAgeOnDate( $beginDate );
        if ( $age >= 17 &&
            $age <= 74 ) {
            return true;
        }
        
        return false;
    }
}
