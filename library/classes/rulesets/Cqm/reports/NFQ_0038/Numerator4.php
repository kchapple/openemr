<?php
class NFQ_0038_Numerator4 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 4";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    { 
        if ( Immunizations::checkHib( $patient, $beginDate, $endDate )) {
            return true;
        }
        return false;
    }
}
