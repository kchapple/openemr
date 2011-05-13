<?php
class ExclusionsNone implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Exclusions: None";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        return false;
    }
}