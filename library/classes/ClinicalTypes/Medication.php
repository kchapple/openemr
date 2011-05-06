<?php
require_once( 'ClinicalType.php' );

class Medication extends ClinicalType
{
    public function getListId() {
        return "Clinical_Rules_Med_Types";
    }   
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null, $options = null ) {
        return true;
    }
}