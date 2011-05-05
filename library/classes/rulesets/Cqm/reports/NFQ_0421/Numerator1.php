<?php
class NFQ_0421_Numerator1 implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Numerator 1";
    }
    
    public function test( CqmPatient $patient )
    {
        return true;
    }
}