<?php
class NFQ_0421_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( $patient->calculateAgeOnDate( $beginDate ) > 65  ) {
            return true;
        }
        
        return false;
    }
}