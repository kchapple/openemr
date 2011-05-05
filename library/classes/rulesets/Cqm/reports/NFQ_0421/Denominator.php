<?php
class NFQ_0421_Denominator implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Denominator";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        return true;
    }
}