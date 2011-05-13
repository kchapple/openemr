<?php
class NFQ_0038_Numerator8 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 8";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    { 
        if ( Immunizations::checkHepA( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        return false;
    }
}
