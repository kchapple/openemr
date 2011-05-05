<?php
class NFQ_0421_InitialPatientPopulation implements CqmFilterIF
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