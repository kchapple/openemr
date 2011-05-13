<?php
class NFQ_0041_Denominator implements CqmFilterIF
{
    public function getTitle()
    {
        return "NFQ 0041 Denominator";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        // TODO check logic
        $periodPlus58Days = date( 'Y-m-d 00:00:00', strtotime( '+58 day', strtotime( $endDate ) ) );
        $periodMinus122Days = date( 'Y-m-d 00:00:00', strtotime( '-122 day', strtotime( $beginDate ) ) );
        if ( Helper::checkEncounter( Encounter::ENC_INFLUENZA, $patient, $periodMinus122Days, $periodPlus58Days ) ) {
            return true;
        }
        
        return false;
    }
}
