<?php
class NFQ_0043_Denominator implements CqmFilterIF
{
    public function getTitle()
    {
        return "Denominator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        $endMinus1Year = date( 'Y-m-d 00:00:00', strtotime( '-1 year', strtotime( $endDate ) ) );
        if ( Helper::checkEncounter( Encounter::ENC_OUTPATIENT, $patient, $endMinus1Year, $endDate ) ) {
            return true;
        }
        
        return false;
    }
}
