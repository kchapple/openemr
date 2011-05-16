<?php
require_once( 'ClinicalType.php' );

class LabResult extends ClinicalType
{   
    const OPTION_RANGE = 'range';
    
    const HB1AC_TEST = 'lab_hb1ac_test';
    
    public function getListId() 
    {
        return 'Clinical_Rules_Lab_Res_Types';
    }
    
    public function doPatientCheck( RsPatient $patient, $beginDate = null, $endDate = null, $options = null )
    {
        // TODO where to check for lab result ???
        if ( isset( $options[self::OPTION_RANGE] ) ) {
            $range = $options[self::OPTION_RANGE];
            if ( is_a( $range, 'Range' ) ) {
                // search through vitals to find the most recent lab result in the date range
                // if the result value is within range using Range->test(val), return true
            }
        }
        
        return false;
    }
}
