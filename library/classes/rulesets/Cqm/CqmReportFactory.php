<?php
class CqmReportFactory
{
    public function __construct() 
    {
        foreach ( glob( "library/*.php" ) as $filename ) {
            require_once( $filename );
        }
    }
    
    public function createReport( $ruleId, $patientData, $dateTarget ) {
        $cqmReport = null;
        switch ( $ruleId ) {
            case "rule_htn_bp_measure_cqm":
                // Hypertension: Blood Pressure Measurement
                // NQF 0013
                
                break;
            case "rule_tob_use_assess_cqm":
                // Tobacco Use Assessment
                // NQF 0028a
                break;
            case "rule_tob_cess_inter_cqm":
                // Tobacco Cessation Intervention
                // NQF 0028b
                break;
            case "rule_adult_wt_screen_fu_cqm":
                // Adult Weight Screening and Follow-Up
                // NQF 0421
                // PQRI 128
                return new NFQ_0421( $ruleId, $patientData, $dateTarget );
        }
    }
}

$patientData = array( 5, 1, 4, 8, 41, 17, 18, 22, 30, 25, 26, 40, 34, 35 );
$factory = new CqmReportFactory();
$nfq = $factory->createReport( "rule_adult_wt_screen_fu_cqm", $patientData, date() );
