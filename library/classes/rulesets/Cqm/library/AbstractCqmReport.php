<?php
//require_once( dirname(__FILE__) . "/../../../clinical_rules.php" );

abstract class AbstractCqmReport
{
    protected $_cqmPopulation;
    
    protected $_resultsArray = array();

    protected $_ruleId;
    protected $_beginMeasurement;
    protected $_endMeasurement;

    public function __construct( $ruleId, array $patientIdArray, $dateTarget )
    {
        // require all .php files in the base library folder
        $className = get_class( $this );
        foreach ( glob( $className."/*.php" ) as $filename ) {
            require_once( $filename );
        }
        
        $this->_cqmPopulation = new CqmPopulation( $patientIdArray );
        $this->_ruleId = $ruleId;
        // Calculate measurement period
        $tempDateArray = explode( "-",$dateTarget );
        $tempYear = $tempDateArray[0];
        $this->_beginMeasurement = $tempDateArray[0] . "-01-01 00:00:00";
        $this->_endMeasurement = $tempDateArray[0] . "-12-31 23:59:59";
    }
    
    public abstract function createPopulationCriteria();
    
    public function getBeginMeasurement() {
        return $this->_beginMeasurement;
    }
    
    public function getEndMeasurement() {
        return $this->_endMeasurement;
    }

    public function execute()
    {
        $populationCriterias = $this->createPopulationCriteria();
        foreach ( $populationCriterias as $populationCriteria ) 
        {
            if ( $populationCriteria instanceof CqmPopulationCrtiteriaFactory ) 
            {
                $totalPatients = count( $this->_cqmPopulation );
                $initialPatientPopulationFilter = $populationCriteria->createInitialPatientPopulation();
                $initialPatientPopulation = null;
                if ( $initialPatientPopulationFilter instanceof CqmComponentIF ) {
                    $initialPatientPopulation = $initialPatientPopulationFilter->executeFilter( $this->_cqmPopulation );
                } else {
                    throw new Exception( "InitialPatientPopulation must be an instance of CqmComponentIF" );
                }
                
                $denominator = $populationCriteria->createDenominator();
                $denominatorPatientPopulation = null;
                if ( $denominator instanceof CqmComponentIF ) {
                    $denominatorPatientPopulation = $denominator->executeFilter( $initialPatientPopulation );
                } else {
                        throw new Exception( "Denominator must be an instance of CqmComponentIF" );
                    }
                
                $numerators = $populationCriteria->createNumerators();
                foreach ( $numerators as $numerator ) 
                {
                    $numeratorPatientPopulations = array();
                    if ( $numerator instanceof CqmComponentIF ) {
                        $numeratorPatientPopulations[$numerator->getTitle()] = $numerator->executeFilter( $denominatorPatientPopulation );
                    } else {
                        throw new Exception( "Numerator must be an instance of CqmComponentIF" );
                    }
                }
               
                // tally results
                $pass_filt = count( $denominatorPatientPopulation );
                $exclusion = $populationCriteria->createExclusion();
                if ( !$exclusion instanceof CqmComponentIF ) throw new Exception( "Exclusion must be an instance of CqmComponentIF" );
                $excludedPatientPopulation = null;    
                foreach ( $numeratorPatientPopulations as $numeratorTitle => $passTargetPopulation ) {
                    $pass_targ = count( $passTargetPopulation );
                    $excludedPatientPopulation = $exclusion->executeFilter( $passTargetPopulation );
                    $exclude_filt = count( $excludedPatientPopulation );
                    $percentage = calculate_percentage( $pass_filt, $exlude_filt, $pass_targ );
                    $this->_resultsArray[]= new CqmResult( $this->_ruleId, $numeratorTitle, $populationCriteria->getTitle(),
                        $totalPatients, $pass_filt, $exclude_filt, $pass_targ, $percentage );
                }
            }  
        }
        
        return $this->_resultsArray;
    }
}