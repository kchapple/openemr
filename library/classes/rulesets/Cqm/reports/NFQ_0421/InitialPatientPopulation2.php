<?php
class NFQ_0421_InitialPatientPopulation2 implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Initial Patient Population 2";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        $age = $patient->calculateAgeOnDate( $beginDate );
        if (  $age >= 18 && $age <= 65  ) {
            return true;
        }
        
        return false;
    }
}