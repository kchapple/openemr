<?php
require_once(dirname(__FILE__) . "/../../clinical_rules.php");
require_once(dirname(__FILE__) . "/../../forms.inc");
require_once(dirname(__FILE__) . "/../../patient.inc");
require_once(dirname(__FILE__) . "/../../lists.inc");

abstract class AbstractClinicalType {
    
    private $_optionId;
    private $_title;
    private $_notes;
    
    public function __construct( $optionId ) {
        $this->_optionId = $optionId;
        $result = getListById( $optionId );
        $this->_title = $result['title'];
        $this->_notes = $result['notes'];
    }
    
    /*
     * Check if this clinical type applies to this patient.   
     * 
     * @param (CqmPatient) $patient
     * @param (date) $beginMeasurement
     * @param (date) $endMeasurement
     * 
     * @return true if type applies, false ow
     */
    public abstract function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null ); 

    public function getOptionId() {
        return $this->_optionId;
    }
    
    public function getNotes() {
        return json_decode( $this->_notes );
    }
    
    public function getListOptions() {
        return array();    
    }
    
    private function getListOptionById( $id )
    {
        $query = "SELECT * " .
                 "FROM `list_options` " .
                 "WHERE list_id = ?" .
                 "AND option_id = ?";
        $results = sqlStatement( $query, array( $this->getListId(), $id ) );
        return $results[0];    
    }
}