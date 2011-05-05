<?php
class NFQ_0013_Numerator implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Numerator";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        return true;
    }
}