<?php
class NFQ_0038_Numerator7 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 7";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    { 
        if ( Immunizations::checkPheumococcal( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        return false;
    }
}
