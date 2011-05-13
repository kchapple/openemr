<?php
class NFQ_0038_Numerator3 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 3";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( Immunizations::checkMmr( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
