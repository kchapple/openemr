<?php
require_once( 'AmcFilterIF.php' );

abstract class AbstractAmcReport implements RsReportIF, AmcFilterIF
{
    protected $_amcPopulation;

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

        $this->_amcPopulation = new AmcPopulation( $patientIdArray );
        $this->_rowRule = $rowRule;
        $this->_ruleId = isset( $rowRule['id'] ) ? $rowRule['id'] : '';
        // Calculate measurement period
        $tempDateArray = explode( "-",$dateTarget );
        $tempYear = $tempDateArray[0];
        $this->_beginMeasurement = $tempDateArray[0] . "-01-01 00:00:00";
        $this->_endMeasurement = $tempDateArray[0] . "-12-31 23:59:59";
    }
        
    public function getResults() {
        return $this->_resultsArray;
    }

    public function execute()
    {
        $totalPatients = count( $this->_amcPopulation );
        $passPatients = 0;
        foreach ( $this->_amcPopulation as $patient ) 
        {
            if ( $this->test( $patient, $this->_beginMeasurement, $this->_endMeasurement ) ) {
                $passPatients++;
            }
        }
        
        // TODO calculate results
        $percentage = calculate_percentage( $totalPatients, 0, $passPatients );
        $result = new AmcResult( $this->_rowRule, $totalPatients, $totalPatients, 0, $passPatients, $percentage );
        $this->_resultsArray[]= $result;
    }
}
