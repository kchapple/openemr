<?php
class ClinicalDiagnosisType extends AbstractClinicalType
{
    public function getListType() {
        return 'medical_problem';
    }
    
    public function getListColumn() {
        return 'diagnosis';
    }
    
    public function getListId() {
        return 'Clinical_Rules_Diagnosis_Types';
    }
    
    /*
     * Check if the patient has this diagnosis
     * 
     * @param (CqmPatient) $patient
     * @param (date) $beginMeasurement
     * @param (date) $endMeasurement
     * 
     * @return true if patient meets criteria, false ow
     */
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null ) {
        $notes = $type->getNotes();
        $data = json_decode( $notes );
        $type = $this->getListType();
        foreach( $data as $codeType => $codes ) {
            foreach ( $codes as $code ) {
                if ( exist_lists_item( $patient->id, $type, $codeType.':'.$code, $endMeasurement ) ) {
                    return true;
                }
            }
        }
        return false;
    }
}