<?php
class NFQ_0059_Numerator implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0059 Numerator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate ) 
    {
        $range = new Range( 9, Range::POS_INF );
        $options = array( LabResult::OPTION_RANGE => $range );
        if ( Helper::checkLab( LabResult::HB1AC_TEST, $patient, $beginDate, $endDate, $options ) ) {
            return true;
        }
        return false;
    }
}
