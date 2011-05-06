<?php
require_once( 'ClinicalType.php' );

class Allergy extends ClinicalType
{
    public function getType() {
        return 'allergy';
    }
    
    public function getListId() {
        return 'Clinical_Rules_Allergy_Types';
    }
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null, $options = null ) {
        return true;
    }
    
}