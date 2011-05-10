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

    public function createReport( $rowRule, $patients, $dateTarget ) {
        $ruleId = $rowRule['id'];
        $patientData = array();
        foreach( $patients as $patient ) {
            $patientData []= $patient['pid'];
        }

        switch ( $ruleId ) {
            case "rule_htn_bp_measure_cqm":
                // Hypertension: Blood Pressure Measurement
                // NQF 0013
                return new NFQ_0013( $rowRule, $patientData, $dateTarget );
            case "rule_tob_use_assess_cqm":
                // Tobacco Use Assessment
                // NQF 0028a
                return new NFQ_0028a( $rowRule, $patientData, $dateTarget );
            case "rule_tob_cess_inter_cqm":
                // Tobacco Cessation Intervention
                // NQF 0028b
                return new NFQ_Unimplemented();
            case "rule_adult_wt_screen_fu_cqm":
                // Adult Weight Screening and Follow-Up
                // NQF 0421
                // PQRI 128
                return new NFQ_0421( $rowRule, $patientData, $dateTarget );
            case "rule_wt_assess_couns_child_cqm":
                // Weight Assessment and Counseling for Children and Adolescents
                // NQF 0024
                return new NFQ_0024( $rowRule, $patientData, $dateTarget );
            case "rule_influenza_ge_50_cqm":
                // Influenza Immunization for Patients >= 50 Years Old
                // NQF 0041
                // PQRI 110
                return new NFQ_Unimplemented();
            case "rule_child_immun_stat_cqm":
                // Childhood immunization Status
                // NQF 0038
                return new NFQ_Unimplemented();
            case "rule_pneumovacc_ge_65_cqm":
                // Pneumonia Vaccination Status for Older Adults
                // NQF 0043
                // PQRI 111
                return new NFQ_Unimplemented();
            case "rule_dm_eye_cqm":
                // Diabetes: Eye Exam
                // NQF 0055
                // PQRI 117
                return new NFQ_Unimplemented();
            case "rule_dm_foot_cqm":
                // Diabetes: Foot Exam
                // NQF 0056
                // PQRI 163
                return new NFQ_Unimplemented();
            case "rule_dm_bp_control_cqm":
                // Diabetes: Blood Pressure Management
                // NQF 0061
                // PQRI 3
                return new NFQ_Unimplemented();
            case "rule_dm_a1c_cqm":
                // Diabetes: Hemoglobin A1C >9.0%
                // NQF 0059
                return new NFQ_Unimplemented();
            case "problem_list_amc":
                // Maintain an up-to-date problem list of current and active diagnoses.
                // 170.302(c)
                return new NFQ_Unimplemented();
            case "med_list_amc":
                // Maintain active medication list.
                // 170.302(d)
                return new NFQ_Unimplemented();
            case "med_allergy_list_amc":
                // Maintain active medication allergy list.
                // 170.302(e)
                return new NFQ_Unimplemented();
            case "record_vitals_amc":
                // Record and chart changes in vital signs.
                // 170.302(f)
                return new NFQ_Unimplemented();
            case "record_smoke_amc":
                // Record smoking status for patients 13 years old or older.
                // 170.302(g)
                return new NFQ_Unimplemented();
            case "lab_result_amc":
                // Incorporate clinical lab-test results into certified EHR technology as structured data.
                // 170.302(h)
                return new NFQ_Unimplemented();
            case "med_reconc_amc":
                // The EP, eligible hospital or CAH who receives a patient from another setting of care or provider of care or believes an encounter is relevant should perform medication reconciliation.
                // 170.302(j)
                return new NFQ_Unimplemented();
            case "patient_edu_amc":
                // Use certified EHR technology to identify patient-specific education resources and provide those resources to the patient if appropriate.
                // 170.302(m)
                return new NFQ_Unimplemented();
            case "cpoe_med_amc":
                // Use CPOE for medication orders directly entered by any licensed healthcare professional who can enter orders into the medical record per state, local and professional guidelines.
                // 170.304(a)
                return new NFQ_Unimplemented();
            case "e_prescribe_amc":
                // Generate and transmit permissible prescriptions electronically.
                // 170.304(b)
                return new NFQ_Unimplemented();
            case "record_dem_amc":
                // Record demographics.
                // 170.304(c)
                return new NFQ_Unimplemented();
            case "send_reminder_amc":
                // Send reminders to patients per patient preference for preventive/follow up care.
                // 170.304(d)
                return new NFQ_Unimplemented();
            case "provide_rec_pat_amc":
                // Provide patients with an electronic copy of their health information (including diagnostic test results, problem list, medication lists, medication allergies), upon request.
                // 170.304(f)
                return new NFQ_Unimplemented();
            case "timely_access_amc":
                // Provide patients with timely electronic access to their health information (including lab results, problem list, medication lists, medication allergies) within four business days of the information being available to the EP.
                // 170.304(g)
                return new NFQ_Unimplemented();
            case "provide_sum_pat_amc":
                // Provide clinical summaries for patients for each office visit.
                // 170.304(h)
                return new NFQ_Unimplemented();
            case "send_sum_amc":
                // The EP, eligible hospital or CAH who transitions their patient to another setting of care or provider of care or refers their patient to another provider of care should provide summary of care record for each transition of care or referral.
                // 170.304(i)
                return new NFQ_Unimplemented();
            default:
                return new NFQ_Unimplemented();
        }
    }
}
