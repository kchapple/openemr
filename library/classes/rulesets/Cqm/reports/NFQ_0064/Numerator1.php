<?php
class NFQ_0064_Numerator1 implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0064 Numerator 1";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        if ( Helper::checkLab( LabResult::LDL_TEST, $patient, $beginDate, $endDate ) ) {
            return true;
        }
        return false;
    }
}
