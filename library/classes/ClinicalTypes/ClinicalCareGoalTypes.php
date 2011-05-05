<?php
class ClinicalCareGoalTypes extends AbstractClinicalType
{
    public function getListId() {
        return 'Clinical_Rules_Care_Goal_Types';
    }
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null ) {
        return true;
    }
}