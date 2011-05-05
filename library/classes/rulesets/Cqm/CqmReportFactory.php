<?php
class CqmReportFactory
{
    public function __construct() 
    {
        foreach ( glob( dirname(__FILE__)."/library/*.php" ) as $filename ) {
            require_once( $filename );
        }
        
        foreach ( glob( dirname(__FILE__)."/reports/*.php" ) as $filename ) {
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
