<?php
class NFQ_0038_Numerator6 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 6";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( Immunizations::checkVzv( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        return false;
    }
}
