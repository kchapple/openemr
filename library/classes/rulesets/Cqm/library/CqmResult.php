<?php
class CqmResult
{
    public $groupLabel; // Label of element
    public $numeratorLabel;
    public $populationLabel;
   
    public $totalPatients; // Total number of patients considered
    public $patientsInPopulation; // Number of patients that pass filter
    public $patientsExcluded; // Number of patients that are excluded
    public $patientsIncluded; // Number of patients that pass target
    public $percentage; // Calculated percentage
    
    public function __construct( $groupLabel, $numeratorLabel, $populationLabel, $totalPatients, $patientsInPopulation, $patientsExcluded, $patientsIncluded, $percentage )
    {
        $this->groupLabel = $groupLabel;
        $this->numeratorLabel = $numeratorLabel;
        $this->populationLabel = $populationLabel;
        $this->totalPatients = $totalPatients;
        $this->patientsInPopulation = $patientsInPopulation;
        $this->patientsExcluded = $patientsExcluded;
        $this->patientsIncluded = $patientsIncluded;
        $this->percentage = $percentage;        
    }
}