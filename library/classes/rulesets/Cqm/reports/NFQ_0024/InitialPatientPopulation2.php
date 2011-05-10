<?php
class NFQ_0024_InitialPatientPopulation2 implements CqmFilterIF
{
    public function getTitle()
    {
        return "Initial Patient Population 2";
    }

    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        // filter for Patient characteristic: birth date� (age) >=2 and <=16 years
        // utilize the convertDobtoAgeYearDecimal() function from library/clinical_rules.php
        $age = convertDobtoAgeYearDecimal( $patient->dob, $dateBegin );
        if ( $age >= 2 &&
            $age <= 10 ) { 
            return true;        
        }
        
        return false;
    }
}
