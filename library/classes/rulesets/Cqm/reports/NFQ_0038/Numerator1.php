<?php
class NFQ_0038_Numerator1 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 1";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( Immunizations::checkDtap( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
