<?php
class NFQ_0059_PopulationCriteria implements CqmPopulationCrtiteriaFactory
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
        return new NFQ_0059_Numerator();
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
