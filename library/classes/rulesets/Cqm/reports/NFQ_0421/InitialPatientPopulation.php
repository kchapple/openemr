<?php
class NFQ_0421_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {

        return true;
    }
}