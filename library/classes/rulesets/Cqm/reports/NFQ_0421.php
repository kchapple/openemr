<?php
class NFQ_0421 extends AbstractCqmReport
{   
    public function createPopulationCriteria()
    {
         $populationCriteria = array();
         $populationCriteria[] = new PopulationCriteria1();
         $populationCriteria[] = new PopulationCriteria2();   
         return $populationCriteria;    
    }
}
