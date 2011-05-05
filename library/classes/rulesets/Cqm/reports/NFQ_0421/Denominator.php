<?php
class NFQ_0421_Denominator implements CqmComponentIF
{
    public function getTitle() 
    {
        return "Denominator";
    }
    
    public function executeFilter( CqmPopulation $population )
    {
        return $population;
    }
}