<?php
class NFQ_0059_PopulationCriteria implements CqmPopulationCrtiteriaFactory
{    
    public function getTitle()
    {
        return "Population Criteria";
    }
    
    public function createInitialPatientPopulation()
    {
        return new NFQ_0059_InitialPatientPopulation();
    }
    
    public function createNumerators()
    {
        return new NFQ_0059_Numerator();
    }
    
    public function createDenominator()
    {
        return new NFQ_0059_Denominator();
    }
    
    public function createExclusion()
    {
        return new NFQ_0059_Exclusions();
    }
}
