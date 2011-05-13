<?php
class NFQ_0024_InitialPatientPopulation3 implements CqmFilterIF
{
    public function getTitle()
    {
        return "Initial Patient Population 3";
    }

    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        // filter for Patient characteristic: birth dateÓ (age) >=2 and <=16 years
        // utilize the convertDobtoAgeYearDecimal() function from library/clinical_rules.php
        $age = $patient->calculateAgeOnDate( $beginDate );
        if ( $age >= 11 &&
            $age <= 16 ) { 
            return true;        
        }
        
        return false;
    }
}
