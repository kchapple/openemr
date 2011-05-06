<?php
require_once( 'ClinicalType.php' );

class Communication extends ClinicalType
{   
    const DIET_CNSLT = 'comm_diet_cnslt'; // communication provider to provider: dietary consultation order
    
    public function getListId() {
        return 'Clinical_Rules_Comm_Types';
    }
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null, $options = null ) {
        return true;
    }
    
}