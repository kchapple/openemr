<?php
class NFQ_0038_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle()
    {
        return "Initial Patient Population";
    }

    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        // Rs_Patient characteristic: birth dateÓ (age) >=1 year and <2 years to capture all Rs_Patients who will reach 2 years during the Òmeasurement periodÓ;
        $age = $patient->calculateAgeOnDate( $beginDate );
        if ( $age >= 1 &&
            $age < 2 ) { 
            return true;        
        }
        
        return false;
    }
}
