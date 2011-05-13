<?php
class NFQ_0043_Numerator implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0041 Numerator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        if ( Helper::checkMed( Medication::PNEUMOCOCCAL_VAC, $patient, $patient->dob, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
