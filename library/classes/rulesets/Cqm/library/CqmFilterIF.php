<?php
interface CqmFilterIF extends RsFilterIF
{
    public function test( CqmPatient $patient, $beginDate, $endDate );
}
