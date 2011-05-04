<?php
class NFQ_0421_InitialPatientPopulation implements CqmComponentIF
{
    public function getTitle() 
    {
        return "Numerator 1";
    }
    
    public function executeFilter( CqmPopulation $population )
    {

        return $population;
    }
}