<?php
class ClinicalEncounterType extends AbstractClinicalType
{
    const ENC_OUTPATIENT = 'enc_outpatient';
    const ENC_NURS_FAC = 'enc_nurs_fac';
    
    public function getListId() 
    {
        return "rule_enc_types";
    }
    
    public function doPatientCheck( CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null )
    {
        $encounters = getEncounters( $patient->id, $beginMeasurement, $endMeasurement, $this->getOptionId() );
        ( empty($encounters) ) ? $totalNumberAppt = 0 : $totalNumberAppt = count( $encounters );
        if ( $totalNumberAppt < $number ) {
            return false;
        }
        else {
            return true;
        }
    }
}