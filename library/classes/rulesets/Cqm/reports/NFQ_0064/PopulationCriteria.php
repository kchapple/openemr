<?php
class NFQ_0064_PopulationCriteria implements CqmPopulationCrtiteriaFactory
{    
    public function getTitle()
    {
        return "Population Criteria";
    }
    
    public function createInitialPatientPopulation()
    {
        return new DiabetesInitialPatientPopulation();
    }
    
    public function createNumerators()
    {
        $numerators = array();
        $numerators []= new NFQ_0064_Numerator1();
        $numerators []= new NFQ_0064_Numerator2();
        return $numerators;
    }
    
    public function createDenominator()
    {
        return new DiabetesDenominator();
    }
    
    public function createExclusion()
    {
        return new DiabetesExclusions();
    }
}
