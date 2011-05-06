<?php
require_once( 'ClinicalType.php' );

class Helper
{
    public static function check( $type, $subType, CqmPatient $patient, $beginMeasurement = null, $endMeasurement = null, $options = null )
    {
        $typeObj = new $type( $subType );
        if ( $typeObj instanceof ClinicalType ) {
            return $typeObj->doPatientCheck( $patient, $beginMeasurement, $endMeasurement, $options );
        } else {
            throw new Exception( "Type must be a subclass of AbstractClinicalType" );
        }
    }
    
    public static function fetchEncounterDates( $encounterType, CqmPatient $patient, $beginDate = null, $endDate = null )
    {
        $encounter = new Encounter( $encounterType );
        return $encounter->fetchDates( $patient, $beginDate, $endDate );
    }
}