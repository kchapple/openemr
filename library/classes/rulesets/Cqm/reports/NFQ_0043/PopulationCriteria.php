<?php
class NFQ_0043_PopulationCriteria implements CqmPopulationCrtiteriaFactory
{    
    public function getTitle()
    {
        return "Population Criteria";
    }
    
    public function createInitialPatientPopulation()
    {
        return new NFQ_0043_InitialPatientPopulation();
    }
    
    public function createNumerators()
    {
        return new NFQ_0043_Numerator();
    }
    
    public function createDenominator()
    {
        return new NFQ_0043_Denominator();
    }
    
    public function createExclusion()
    {
        return new ExclusionsNone();
    }
}
