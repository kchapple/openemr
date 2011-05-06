<?php
class NFQ_0028a_Numerator implements CqmFilterIF
{
    public function getTitle()
    {
        return "Numerator";
    }

    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        // See if user has been a tobacco user before or simultaneosly to the encounter within two years (24 months)
        // TODO check agianst encounter
        $begin_24_months_before_time = strtotime( '-24 month' , strtotime ( $dateBegin ) );
        $begin_24_months_before = date( 'Y-m-d 00:00:00' , $begin_24_months_before_time );
        $tobaccoHistory = getHistoryData( $patient->id, "tobacco", $begin_24_months_before, $dateEnd );
        if ( isset( $tobaccoHistory['tobacco'] ) ) {
            return true;
        }
        return false;
    }
}