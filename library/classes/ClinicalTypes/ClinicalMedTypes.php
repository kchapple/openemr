<?php
class ClinicalMedTypes extends AbstractClinicalType
{
    public function getListId() {
        return "Clinical_Rules_Med_Types";
    }   
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null ) {
        return true;
    }
}