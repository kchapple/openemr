<?php
interface CqmFilterIF
{
    public function test( CqmPatient $patient, $dateBegin, $dateEnd );
    public function getTitle();
}