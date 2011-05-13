<?php
class NFQ_0038_Numerator9 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 9";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( Immunizations::checkRotavirus( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
