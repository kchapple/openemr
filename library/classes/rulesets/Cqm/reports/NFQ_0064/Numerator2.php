<?php
class NFQ_0064_Numerator2 implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0064 Numerator 2";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        $range = new Range( Range::NEG_INF, 100 );
        $options = array( LabResult::OPTION_RANGE => $range );
        if ( Helper::checkLab( LabResult::LDL_TEST, $patient, $beginDate, $endDate, $options ) ) {
            return true;
        }
        return false;
    }
}
