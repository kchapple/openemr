<?php
class NFQ_0421_Numerator2 implements CqmComponentIF
{  
    public function getTitle() 
    {
        return "Numerator 2";
    }
      
    public function executeFilter( CqmPopulation $population )
    {
        $filteredPopulation = new CqmPopulation();
        foreach ( $population as $patient ) {
            
        }
        
        return $filteredPopulation;
    }   
}