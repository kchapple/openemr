<?php
interface AmcFilterIF extends RsFilterIF
{
    public function test( AmcPatient $patient, $beginDate, $endDate );
}
