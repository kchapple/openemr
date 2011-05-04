<?php
class NFQ_0421_PopulationCriteria1 implements CqmPopulationCrtiteriaFactory
{
    public function getTitle()
    {
        return "population criteria 1";
    }
    
    public function createInitialPatientPopulation()
    {
        return new InitialPatientPopulation();
    }
    
    public function createNumerators()
    {
        return new Numerator1();
    }
    
    public function createDenominator()
    {
        
    }
    
    public function createExclusion()
    {
        
    }
}