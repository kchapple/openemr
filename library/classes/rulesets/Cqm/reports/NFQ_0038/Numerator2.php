<?php
class NFQ_0038_Numerator2 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 2";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( Immunizations::checkIpv( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
