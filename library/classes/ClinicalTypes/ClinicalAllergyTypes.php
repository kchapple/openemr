<?php
class ClinicalAllergyTypes extends AbstractClinicalType
{
    public function getType() {
        return 'allergy';
    }
    
    public function getListId() {
        return 'Clinical_Rules_Allergy_Types';
    }
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null ) {
        return true;
    }
    
}