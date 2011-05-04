<?php
class ClinicalEncounterTypes extends AbstractClinicalType
{
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