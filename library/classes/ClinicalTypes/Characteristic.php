<?php
require_once( 'ClinicalType.php' );

class Characteristic extends ClinicalType
{   
    const TERMINAL_ILLNESS = 'terminal_illness';
    
    public function getListId() {
        return 'Clinical_Rules_Char_Types';
    }
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null, $options = null ) {
        return true;
    }
    
}