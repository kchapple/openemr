<?php
require_once( dirname(__FILE__)."/../../../../clinical_rules.php" );

abstract class AbstractCqmReport
{
    protected $_cqmPopulation;

    protected $_resultsArray = array();

    protected $_rowRule;
    protected $_ruleId;
    protected $_beginMeasurement;
    protected $_endMeasurement;

    public function __construct( array $rowRule, array $patientIdArray, $dateTarget )
    {
        // require all .php files in the report's sub-folder
        $className = get_class( $this );
        foreach ( glob( dirname(__FILE__)."/../reports/".$className."/*.php" ) as $filename ) {
            require_once( $filename );
        }
        // require common .php files
        foreach ( glob( dirname(__FILE__)."/../reports/common/*.php" ) as $filename ) {
            require_once( $filename );
        }
        // require clinical types
        foreach ( glob( dirname(__FILE__)."/../../../ClinicalTypes/*.php" ) as $filename ) {
            require_once( $filename );
        }

        $this->_cqmPopulation = new CqmPopulation( $patientIdArray );
        $this->_rowRule = $rowRule;
        $this->_ruleId = isset( $rowRule['id'] ) ? $rowRule['id'] : '';
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
        if ( !is_array( $populationCriterias ) ) {
            $tmpPopulationCriterias = array();
            $tmpPopulationCriterias[]= $populationCriterias;
            $populationCriterias = $tmpPopulationCriterias;
        }

        foreach ( $populationCriterias as $populationCriteria )
        {
            if ( $populationCriteria instanceof CqmPopulationCrtiteriaFactory )
            {
                $initialPatientPopulationFilter = $populationCriteria->createInitialPatientPopulation();
                $denominator = $populationCriteria->createDenominator();
                $numerators = $populationCriteria->createNumerators();
                $exclusion = $populationCriteria->createExclusion();

                $totalPatients = count( $this->_cqmPopulation );
                $initialPatientPopulation = 0;
                $denominatorPatientPopulation = 0;
                $numeratorPatientPopulations = array();
                $exclusionsPatientPopulations = array();
                foreach ( $this->_cqmPopulation as $patient ) {

                    if ( $initialPatientPopulationFilter instanceof CqmFilterIF ) {
                        if ( $initialPatientPopulationFilter->test( $patient, $this->_beginMeasurement, $this->_endMeasurement ) ) {
                            $initialPatientPopulation++;
                            if ( $denominator instanceof CqmFilterIF ) {
                                if ( $denominator->test( $patient, $this->_beginMeasurement, $this->_endMeasurement ) ) {
                                    $denominatorPatientPopulation++;
                                }
                            } else {
                                throw new Exception( "Denominator must be an instance of CqmFilterIF" );
                            }
                        }
                    } else {
                        throw new Exception( "InitialPatientPopulation must be an instance of CqmFilterIF" );
                    }
                    
                    if ( is_array( $numerators ) ) {
                        foreach ( $numerators as $numerator ) {
                            $this->testNumerator( $patient, $numerator, $numeratorPatientPopulations, $exclusion, $exclusionsPatientPopulations );
                        }
                    } else {
                        $this->testNumerator( $patient, $numerators, $numeratorPatientPopulations, $exclusion, $exclusionsPatientPopulations );
                    }
                }

                // tally results, run exclusion filter on each numerator
                $pass_filt = $denominatorPatientPopulation;
                $titles = array_keys( $numeratorPatientPopulations );
                foreach ( $titles as $title ) {
                    $pass_targ = $numeratorPatientPopulations[$title];
                    $exclude_filt = $exclusionsPatientPopulations[$title];
                    $percentage = calculate_percentage( $pass_filt, $exclude_filt, $pass_targ );
                    $this->_resultsArray[]= new CqmResult( $this->_rowRule, $title, $populationCriteria->getTitle(),
                    $totalPatients, $pass_filt, $exclude_filt, $pass_targ, $percentage );
                }
            }
        }

        return $this->_resultsArray;
    }

    private function testNumerator( $patient, $numerator, &$numeratorPatientPopulations, $exclusion, &$exclusionsPatientPopulations )
    {
        if ( $numerator instanceof CqmFilterIF && $exclusion instanceof CqmFilterIF ) {
            if ( $numerator->test( $patient, $this->_beginMeasurement, $this->_endMeasurement ) ) {
                if ( !isset( $numeratorPatientPopulations[$numerator->getTitle()] ) ) {
                    $numeratorPatientPopulations[$numerator->getTitle()] = 0;
                }
                $numeratorPatientPopulations[$numerator->getTitle()]++;
            }

            if ( $exclusion->test( $patient, $this->_beginMeasurement, $this->_endMeasurement ) ) {
                if ( !isset( $exclusionsPatientPopulations[$numerator->getTitle()] ) ) {
                    $exclusionsPatientPopulations[$numerator->getTitle()] = 0;
                }
                $exclusionsPatientPopulations[$numerator->getTitle()]++;
            }

        } else {
            throw new Exception( "Numerator must be an instance of CqmFilterIF" );
        }
    }
}