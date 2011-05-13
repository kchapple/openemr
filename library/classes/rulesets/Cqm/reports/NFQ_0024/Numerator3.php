<?php
class NFQ_0024_Numerator3 implements CqmFilterIF
{
    public function getTitle() {
        return "Numerator 3";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        if ( Helper::check( ClinicalType::COMMUNICATION, Communication::COUNS_PHYS_ACTIVITY, $patient, $beginDate, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
