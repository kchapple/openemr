<?php
interface CqmFilterIF
{
    public function test( CqmPatient $patient );
    public function getTitle();
}