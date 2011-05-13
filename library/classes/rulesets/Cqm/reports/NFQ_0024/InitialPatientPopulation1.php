<?php
class NFQ_0024_InitialPatientPopulation1 implements CqmFilterIF
{
    public function getTitle()
    {
        return "Initial Patient Population 1";
    }

    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        // filter for Patient characteristic: birth date� (age) >=2 and <=16 years
        // utilize the convertDobtoAgeYearDecimal() function from library/clinical_rules.php
        $age = $patient->calculateAgeOnDate( $beginDate );
        if ( $age >= 2 &&
            $age <= 18 ) { 
            return true;        
        }
        
        return false;
    }
}
