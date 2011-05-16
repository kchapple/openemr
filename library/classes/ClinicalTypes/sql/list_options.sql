-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2011 at 08:59 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `openemr`
--

-- --------------------------------------------------------

/*
INSERT INTO `list_options` VALUES('lists', 'rule_enc_types', 'Clinical Rules Encounter Types', 3, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_pre_med_ser_18_older', 'encounter preventive medicine services 18 and older', 70, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_pre_ind_counsel', 'encounter preventive medicine - individual counseling', 80, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_pre_med_group_counsel', 'encounter preventive medicine group counseling', 90, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_pre_med_other_serv', 'encounter preventive medicine other services', 100, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_out_pcp_obgyn', 'encounter outpatient w/PCP & obgyn', 110, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_pregnancy', 'encounter pregnancy', 120, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_acute_inp_or_ed', 'encounter acute inpatient or ED', 130, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_outpatient', 'encounter outpatient', 10, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_nurs_fac', 'encounter nursing facility', 20, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_off_vis', 'encounter office visit', 30, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_hea_and_beh', 'encounter health and behavior assessment', 40, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_occ_ther', 'encounter occupational therapy', 50, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_psych_and_psych', 'encounter psychiatric & psychologic', 60, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_nurs_discharge', 'encounter nursing discharge', 130, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_nonac_inp_out_or_opth', 'Encounter: encounter non-acute inpt, outpatient, or ophthalmology', 140, 0, 0, '', '');
*/

INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Allergy_Types', 'Clinical Rules Allergy Types', 67, 1, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Diagnosis_Types', 'Clinical Rules Diagnosis Types', 68, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_encephalopathy', 'encephalopathy', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_not_done_flu_vac_pat_reas', 'Medication not done: influenza vaccine for patient reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_not_done_flu_vac_med_reas', 'Medication not done: influenza vaccine for medical reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_not_done_flu_immun_declined', 'Medication not done: influenza immunization declined', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_not_done_flu_immun_contradi', 'Medication not done: influenza immunization contraindication', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Med_Types', 'Clinical Rules Med Types', 66, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Exception_Types', 'exc_no_phys_exm_system', 'physical rationale physical exam not done: system reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Exception_Types', 'exc_no_phys_exm_medical', 'physical exam not done: medical reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Comm_Types', 'Clinical Rules Comm Types', 63, 1, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Care_Goal_Types', 'Clinical Rules Care Goal Types', 62, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Care_Goal_Types', 'cg_flwup_bmi_mgmt', 'care goal: follow-up plan BMI management', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Comm_Types', 'comm_diet_cnslt', 'communication provider to provider: dietary consultation order', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Exception_Types', 'Clinical Rules Exception Types', 65, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Exception_Types', 'exc_no_phys_exm_patient', 'physical exam not done: patient reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_intolerance_flu_immun', 'Medication intolerance: influenza immunization', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_adverse_evt_flu_immun', 'Medication adverse event: influenza immunization', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_vzv', 'medication administered: VZV', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_rotavirus_vac', 'medication administered: rotavirus vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_cancer_lypmh_hist', 'cancer of lymphoreticular or histiocytic tiss', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_diabetes', 'diabetes', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Char_Types', 'Clinical Rules Char Types', 69, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Char_Types', 'char_terminal_illness', 'patient characteristic: terminal illness', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Char_Types', 'char_tobacco_user', 'atient characteristic: tobacco user', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Char_Types', 'char_tobacco_non_user', 'patient characteristic: tobacco non-user', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_hep_b', 'hepatitis B', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_rubella_vac', 'Medication allergy: rubella vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_streptomycin', 'Medication allergy: streptomycin', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Phys_Exm_Type', 'Clinical Rules Phys Exm Type', 70, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Phys_Exm_Type', 'phys_exm_finding_bmi', 'physical exam finding: BMI', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Phys_Exm_Type', 'phys_exm_not_done_system', 'physical rationale physical exam not done: system reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Phys_Exm_Type', 'phys_exm_not_done_patient', 'physical exam not done: patient reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Phys_Exm_Type', 'phys_exm_finding_bmi_perc', 'physical exam finding: BMI percentile', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Phys_Exm_Type', 'phys_exm_not_done_medical', 'physical exam not done: medical reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Comm_Types', 'comm_couns_nutrition', 'communication to patient: counseling for nutrition', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Comm_Types', 'comm_couns_phys_activity', 'communication to patient: counseling for physical activity', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_rotavirus_vac', 'Medication allergy: rotavirus vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_polymyxin', 'Medication allergy: polymyxin', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_pneum_vac', 'Medication allergy: pneumococcal vaccination', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_mumps_vac', 'medication administered: mumps vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_pneumococcal_vac', 'medication administered: pneumococcal vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_mult_myeloma', 'multiple myeloma', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_mumps', 'mumps', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_hypertension', 'hypertension', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_immunodef', 'immunodeficiency', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_lukemia', 'leukemia', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_measles', 'measles', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_influenza_immun_contradict', 'influenza immunization contraindication', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_neomycin', 'Medication allergy: neomycin', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_mumps_vac', 'Medication allergy: mumps vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_mmr', 'Medication allergy: MMR', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_measles_vac', 'Medication allergy: measles vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_dtap_vac', 'Medication allergy: DTaP vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_hep_a_vac', 'Medication allergy: hepatitis A vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_hep_b_vac', 'Medication allergy: hepatitis B vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_hib', 'Medication allergy: HiB', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_ipv', 'Medication allergy: IPV', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_not_done_flu_vac_sys_reas', 'Medication not done: influenza vaccine for system reason', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_nonac_inp_out_or_opth', 'encounter non-acute inpt, outpatient, or ophthalmology', 140, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_influenza', 'encounter influenza', 150, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_acute_inp_or_ed', 'encounter acute inpatient or ED', 130, 0, 0, '', '');
INSERT INTO `list_options` VALUES('rule_enc_types', 'enc_nurs_discharge', 'encounter nursing discharge', 130, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_mmr', 'medication administered: MMR', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_meas_vac', 'medication administered: measles vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_dtap_vac', 'medication administered: DTaP vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_hep_a_vac', 'medication administered: hepatitis A vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_hep_b_vac', 'medication administered: hepatitis B vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_hib', 'medication administered: HiB', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_influenza_vac', 'Medication administered: influenza vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_ipv', 'medication administered: IPV', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_vzv', 'Medication allergy: VZV', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'subst_allergy_bakers_yeast', 'Substance allergy: Baker’s yeast', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'med_allergy_flu_immun', 'Medication allergy: influenza immunization', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Allergy_Types', 'subst_allergy_eggs', 'Substance allergy: allergy to eggs', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_admin_rubella_vac', 'medication administered: rubella vaccine', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_pregnancy', 'pregnancy', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_prog_neuro_disorder', 'progressive neurological disorder', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_rubella', 'rubella', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_vzv', 'VZV', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_asymptomatic_hiv', 'asymptomatic HIV', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_polycystic_ovaries', 'polycystic ovaries', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_gestational_diabetes', 'gestational diabetes', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Diagnosis_Types', 'diag_steroid_induced_diabetes', 'steroid induced diabetes', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_disp_diabetes', 'Medication dispensed: medications indicative of diabetes', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_order_diabetes', 'Medication order: medications indicative of diabetes', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Med_Types', 'med_active_diabetes', 'Medication active: medications indicative of diabetes', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('lists', 'Clinical_Rules_Lab_Res_Types', 'Clinical Rules Lab Res Types', 71, 1, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Lab_Res_Types', 'lab_ldl_test', 'Laboratory test result: LDL test', 0, 0, 0, '', '');
INSERT INTO `list_options` VALUES('Clinical_Rules_Lab_Res_Types', 'lab_hb1ac_test', 'Laboratory test result: HbA1c test', 0, 0, 0, '', '');