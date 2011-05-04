<?php
class NFQ_0421_Numerator1 implements CqmComponentIF
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