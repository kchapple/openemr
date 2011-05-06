<?php
class NFQ_0421_Exclusion implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Exclusion";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        return false;
    }
}