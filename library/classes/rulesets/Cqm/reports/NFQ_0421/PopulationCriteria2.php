<?php
class NFQ_0421_PopulationCriteria2 implements CqmPopulationCrtiteriaFactory
{
    public function getTitle()
    {
        return "population criteria 2";
    }
    
    public function createInitialPatientPopulation()
    {
        return new InitialPatientPopulation();
    }
    
    public function createNumerators()
    {
        return new Numerator2();
    }
    
    public function createDenominator()
    {
        
    }
    
    public function createExclusion()
    {
        
    }
}