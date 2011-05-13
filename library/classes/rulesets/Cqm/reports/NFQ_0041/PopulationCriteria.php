<?php
class NFQ_0041_PopulationCriteria implements CqmPopulationCrtiteriaFactory
{    
    public function getTitle()
    {
        return "Population Criteria";
    }
    
    public function createInitialPatientPopulation()
    {
        return new NFQ_0041_InitialPatientPopulation();
    }
    
    public function createNumerators()
    {
        return new NFQ_0041_Numerator();
    }
    
    public function createDenominator()
    {
        return new NFQ_0041_Denominator();
    }
    
    public function createExclusion()
    {
        return new NFQ_0041_Exclusions();
    }
}
