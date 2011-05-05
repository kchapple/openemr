<?php
class NFQ_0421_Exclusion implements CqmComponentIF
{
    public function getTitle() 
    {
        return "Exclusion";
    }
    
    public function executeFilter( CqmPopulation $population )
    {
        return $population;
    }
}