<?php
interface CqmPopulationCrtiteriaFactory
{
    public function getTitle();
    public function createInitialPatientPopulation();
    public function createDenominator();
    public function createNumerators();
    public function createExclusion();
}