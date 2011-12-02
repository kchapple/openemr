-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 02, 2011 at 10:46 AM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `openemr_temp`
--

-- --------------------------------------------------------

--
-- Table structure for table `layout_options`
--

CREATE TABLE `layout_options` (
  `form_id` varchar(31) NOT NULL DEFAULT '',
  `field_id` varchar(31) NOT NULL DEFAULT '',
  `group_name` varchar(31) NOT NULL DEFAULT '',
  `title` varchar(63) NOT NULL DEFAULT '',
  `seq` int(11) NOT NULL DEFAULT '0',
  `data_type` tinyint(3) NOT NULL DEFAULT '0',
  `uor` tinyint(1) NOT NULL DEFAULT '1',
  `fld_length` int(11) NOT NULL DEFAULT '15',
  `max_length` int(11) NOT NULL DEFAULT '0',
  `list_id` varchar(31) NOT NULL DEFAULT '',
  `titlecols` tinyint(3) NOT NULL DEFAULT '1',
  `datacols` tinyint(3) NOT NULL DEFAULT '1',
  `default_value` varchar(255) NOT NULL DEFAULT '',
  `edit_options` varchar(36) NOT NULL DEFAULT '',
  `description` text,
  PRIMARY KEY (`form_id`,`field_id`,`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `layout_options`
--

INSERT INTO `layout_options` VALUES('DEM', 'title', '1Who', 'Name', 1, 1, 1, 0, 0, 'titles', 1, 1, '', 'N', 'Title');
INSERT INTO `layout_options` VALUES('DEM', 'fname', '1Who', '', 2, 2, 2, 10, 63, '', 0, 0, '', 'CD', 'First Name');
INSERT INTO `layout_options` VALUES('DEM', 'mname', '1Who', '', 3, 2, 1, 2, 63, '', 0, 0, '', 'C', 'Middle Name');
INSERT INTO `layout_options` VALUES('DEM', 'lname', '1Who', '', 4, 2, 2, 10, 63, '', 0, 0, '', 'CD', 'Last Name');
INSERT INTO `layout_options` VALUES('DEM', 'pubpid', '1Who', 'External ID', 5, 2, 1, 10, 15, '', 1, 1, '', 'ND', 'External identifier');
INSERT INTO `layout_options` VALUES('DEM', 'DOB', '1Who', 'DOB', 6, 4, 2, 10, 10, '', 1, 1, '', 'D', 'Date of Birth');
INSERT INTO `layout_options` VALUES('DEM', 'sex', '1Who', 'Sex', 7, 1, 2, 0, 0, 'sex', 1, 1, '', 'N', 'Sex');
INSERT INTO `layout_options` VALUES('DEM', 'ss', '1Who', 'S.S.', 8, 2, 1, 11, 11, '', 1, 1, '', '', 'Social Security Number');
INSERT INTO `layout_options` VALUES('DEM', 'drivers_license', '1Who', 'License/ID', 9, 2, 1, 15, 63, '', 1, 1, '', '', 'Drivers License or State ID');
INSERT INTO `layout_options` VALUES('DEM', 'status', '1Who', 'Marital Status', 10, 1, 1, 0, 0, 'marital', 1, 3, '', '', 'Marital Status');
INSERT INTO `layout_options` VALUES('DEM', 'genericname1', '1Who', 'User Defined', 11, 2, 1, 15, 63, '', 1, 3, '', '', 'User Defined Field');
INSERT INTO `layout_options` VALUES('DEM', 'genericval1', '1Who', '', 12, 2, 1, 15, 63, '', 0, 0, '', '', 'User Defined Field');
INSERT INTO `layout_options` VALUES('DEM', 'genericname2', '1Who', '', 13, 2, 1, 15, 63, '', 0, 0, '', '', 'User Defined Field');
INSERT INTO `layout_options` VALUES('DEM', 'genericval2', '1Who', '', 14, 2, 1, 15, 63, '', 0, 0, '', '', 'User Defined Field');
INSERT INTO `layout_options` VALUES('DEM', 'squad', '1Who', 'Squad', 15, 13, 0, 0, 0, '', 1, 3, '', '', 'Squad Membership');
INSERT INTO `layout_options` VALUES('DEM', 'pricelevel', '1Who', 'Price Level', 16, 1, 0, 0, 0, 'pricelevel', 1, 1, '', '', 'Discount Level');
INSERT INTO `layout_options` VALUES('DEM', 'street', '2Contact', 'Address', 1, 2, 1, 25, 63, '', 1, 1, '', 'C', 'Street and Number');
INSERT INTO `layout_options` VALUES('DEM', 'city', '2Contact', 'City', 2, 2, 1, 15, 63, '', 1, 1, '', 'C', 'City Name');
INSERT INTO `layout_options` VALUES('DEM', 'state', '2Contact', 'State', 3, 26, 1, 0, 0, 'state', 1, 1, '', '', 'State/Locality');
INSERT INTO `layout_options` VALUES('DEM', 'postal_code', '2Contact', 'Postal Code', 4, 2, 1, 6, 63, '', 1, 1, '', '', 'Postal Code');
INSERT INTO `layout_options` VALUES('DEM', 'country_code', '2Contact', 'Country', 5, 26, 1, 0, 0, 'country', 1, 1, '', '', 'Country');
INSERT INTO `layout_options` VALUES('DEM', 'mothersname', '2Contact', 'Mother''s Name', 6, 2, 1, 20, 63, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('DEM', 'guardiansname', '2Contact', 'Guardian''s Name', 7, 2, 1, 20, 63, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('DEM', 'contact_relationship', '2Contact', 'Emergency Contact', 8, 2, 1, 10, 63, '', 1, 1, '', 'C', 'Emergency Contact Person');
INSERT INTO `layout_options` VALUES('DEM', 'phone_contact', '2Contact', 'Emergency Phone', 9, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Emergency Contact Phone Number');
INSERT INTO `layout_options` VALUES('DEM', 'phone_home', '2Contact', 'Home Phone', 10, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Home Phone Number');
INSERT INTO `layout_options` VALUES('DEM', 'phone_biz', '2Contact', 'Work Phone', 11, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Work Phone Number');
INSERT INTO `layout_options` VALUES('DEM', 'phone_cell', '2Contact', 'Mobile Phone', 12, 2, 1, 20, 63, '', 1, 1, '', 'P', 'Cell Phone Number');
INSERT INTO `layout_options` VALUES('DEM', 'email', '2Contact', 'Contact Email', 13, 2, 1, 30, 95, '', 1, 1, '', '', 'Contact Email Address');
INSERT INTO `layout_options` VALUES('DEM', 'providerID', '3Choices', 'Provider', 1, 11, 1, 0, 0, '', 1, 3, '', '', 'Referring Provider');
INSERT INTO `layout_options` VALUES('DEM', 'pharmacy_id', '3Choices', 'Pharmacy', 2, 12, 1, 0, 0, '', 1, 3, '', '', 'Preferred Pharmacy');
INSERT INTO `layout_options` VALUES('DEM', 'hipaa_notice', '3Choices', 'HIPAA Notice Received', 3, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Did you receive a copy of the HIPAA Notice?');
INSERT INTO `layout_options` VALUES('DEM', 'hipaa_voice', '3Choices', 'Allow Voice Message', 4, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow telephone messages?');
INSERT INTO `layout_options` VALUES('DEM', 'hipaa_message', '3Choices', 'Leave Message With', 5, 2, 1, 20, 63, '', 1, 1, '', '', 'With whom may we leave a message?');
INSERT INTO `layout_options` VALUES('DEM', 'hipaa_mail', '3Choices', 'Allow Mail Message', 6, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow email messages?');
INSERT INTO `layout_options` VALUES('DEM', 'hipaa_allowsms', '3Choices', 'Allow SMS', 7, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow SMS (text messages)?');
INSERT INTO `layout_options` VALUES('DEM', 'hipaa_allowemail', '3Choices', 'Allow Email', 8, 1, 1, 0, 0, 'yesno', 1, 1, '', '', 'Allow Email?');
INSERT INTO `layout_options` VALUES('DEM', 'allow_imm_reg_use', '3Choices', 'Allow Immunization Registry Use', 9, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('DEM', 'allow_imm_info_share', '3Choices', 'Allow Immunization Info Sharing', 10, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('DEM', 'allow_health_info_ex', '3Choices', 'Allow Health Information Exchange', 11, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('DEM', 'allow_patient_portal', '3Choices', 'Allow Patient Portal', 12, 1, 1, 0, 0, 'yesno', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('DEM', 'occupation', '4Employer', 'Occupation', 1, 2, 1, 20, 63, '', 1, 1, '', 'C', 'Occupation');
INSERT INTO `layout_options` VALUES('DEM', 'em_name', '4Employer', 'Employer Name', 2, 2, 1, 20, 63, '', 1, 1, '', 'C', 'Employer Name');
INSERT INTO `layout_options` VALUES('DEM', 'em_street', '4Employer', 'Employer Address', 3, 2, 1, 25, 63, '', 1, 1, '', 'C', 'Street and Number');
INSERT INTO `layout_options` VALUES('DEM', 'em_city', '4Employer', 'City', 4, 2, 1, 15, 63, '', 1, 1, '', 'C', 'City Name');
INSERT INTO `layout_options` VALUES('DEM', 'em_state', '4Employer', 'State', 5, 26, 1, 0, 0, 'state', 1, 1, '', '', 'State/Locality');
INSERT INTO `layout_options` VALUES('DEM', 'em_postal_code', '4Employer', 'Postal Code', 6, 2, 1, 6, 63, '', 1, 1, '', '', 'Postal Code');
INSERT INTO `layout_options` VALUES('DEM', 'em_country', '4Employer', 'Country', 7, 26, 1, 0, 0, 'country', 1, 1, '', '', 'Country');
INSERT INTO `layout_options` VALUES('DEM', 'language', '5Stats', 'Language', 1, 26, 1, 0, 0, 'language', 1, 1, '', '', 'Preferred Language');
INSERT INTO `layout_options` VALUES('DEM', 'ethnicity', '5Stats', 'Ethnicity', 2, 33, 1, 0, 0, 'ethnicity', 1, 1, '', '', 'Ethnicity');
INSERT INTO `layout_options` VALUES('DEM', 'race', '5Stats', 'Race', 3, 33, 1, 0, 0, 'race', 1, 1, '', '', 'Race');
INSERT INTO `layout_options` VALUES('DEM', 'financial_review', '5Stats', 'Financial Review Date', 4, 2, 1, 10, 10, '', 1, 1, '', 'D', 'Financial Review Date');
INSERT INTO `layout_options` VALUES('DEM', 'family_size', '5Stats', 'Family Size', 4, 2, 1, 20, 63, '', 1, 1, '', '', 'Family Size');
INSERT INTO `layout_options` VALUES('DEM', 'monthly_income', '5Stats', 'Monthly Income', 5, 2, 1, 20, 63, '', 1, 1, '', '', 'Monthly Income');
INSERT INTO `layout_options` VALUES('DEM', 'homeless', '5Stats', 'Homeless, etc.', 6, 2, 1, 20, 63, '', 1, 1, '', '', 'Homeless or similar?');
INSERT INTO `layout_options` VALUES('DEM', 'interpretter', '5Stats', 'Interpreter', 7, 2, 1, 20, 63, '', 1, 1, '', '', 'Interpreter needed?');
INSERT INTO `layout_options` VALUES('DEM', 'migrantseasonal', '5Stats', 'Migrant/Seasonal', 8, 2, 1, 20, 63, '', 1, 1, '', '', 'Migrant or seasonal worker?');
INSERT INTO `layout_options` VALUES('DEM', 'contrastart', '5Stats', 'Contraceptives Start', 9, 4, 0, 10, 10, '', 1, 1, '', '', 'Date contraceptive services initially provided');
INSERT INTO `layout_options` VALUES('DEM', 'referral_source', '5Stats', 'Referral Source', 10, 26, 1, 0, 0, 'refsource', 1, 1, '', '', 'How did they hear about us');
INSERT INTO `layout_options` VALUES('DEM', 'vfc', '5Stats', 'VFC', 12, 1, 1, 20, 0, 'eligibility', 1, 1, '', '', 'Eligibility status for Vaccine for Children supplied vaccine');
INSERT INTO `layout_options` VALUES('DEM', 'deceased_date', '6Misc', 'Date Deceased', 1, 4, 1, 20, 20, '', 1, 3, '', 'D', 'If person is deceased, then enter date of death.');
INSERT INTO `layout_options` VALUES('DEM', 'deceased_reason', '6Misc', 'Reason Deceased', 2, 2, 1, 30, 255, '', 1, 3, '', '', 'Reason for Death');
INSERT INTO `layout_options` VALUES('DEM', 'usertext1', '6Misc', 'User Defined Text 1', 3, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext2', '6Misc', 'User Defined Text 2', 4, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext3', '6Misc', 'User Defined Text 3', 5, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext4', '6Misc', 'User Defined Text 4', 6, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext5', '6Misc', 'User Defined Text 5', 7, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext6', '6Misc', 'User Defined Text 6', 8, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext7', '6Misc', 'User Defined Text 7', 9, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'usertext8', '6Misc', 'User Defined Text 8', 10, 2, 0, 10, 63, '', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist1', '6Misc', 'User Defined List 1', 11, 1, 0, 0, 0, 'userlist1', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist2', '6Misc', 'User Defined List 2', 12, 1, 0, 0, 0, 'userlist2', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist3', '6Misc', 'User Defined List 3', 13, 1, 0, 0, 0, 'userlist3', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist4', '6Misc', 'User Defined List 4', 14, 1, 0, 0, 0, 'userlist4', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist5', '6Misc', 'User Defined List 5', 15, 1, 0, 0, 0, 'userlist5', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist6', '6Misc', 'User Defined List 6', 16, 1, 0, 0, 0, 'userlist6', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'userlist7', '6Misc', 'User Defined List 7', 17, 1, 0, 0, 0, 'userlist7', 1, 1, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('DEM', 'regdate', '6Misc', 'Registration Date', 18, 4, 0, 10, 10, '', 1, 1, '', 'D', 'Start Date at This Clinic');
INSERT INTO `layout_options` VALUES('REF', 'refer_date', '1Referral', 'Referral Date', 1, 4, 2, 0, 0, '', 1, 1, 'C', 'D', 'Date of referral');
INSERT INTO `layout_options` VALUES('REF', 'refer_from', '1Referral', 'Refer By', 2, 10, 2, 0, 0, '', 1, 1, '', '', 'Referral By');
INSERT INTO `layout_options` VALUES('REF', 'refer_external', '1Referral', 'External Referral', 3, 1, 1, 0, 0, 'boolean', 1, 1, '', '', 'External referral?');
INSERT INTO `layout_options` VALUES('REF', 'refer_to', '1Referral', 'Refer To', 4, 14, 2, 0, 0, '', 1, 1, '', '', 'Referral To');
INSERT INTO `layout_options` VALUES('REF', 'body', '1Referral', 'Reason', 5, 3, 2, 30, 3, '', 1, 1, '', '', 'Reason for referral');
INSERT INTO `layout_options` VALUES('REF', 'refer_diag', '1Referral', 'Referrer Diagnosis', 6, 2, 1, 30, 255, '', 1, 1, '', 'X', 'Referrer diagnosis');
INSERT INTO `layout_options` VALUES('REF', 'refer_risk_level', '1Referral', 'Risk Level', 7, 1, 1, 0, 0, 'risklevel', 1, 1, '', '', 'Level of urgency');
INSERT INTO `layout_options` VALUES('REF', 'refer_vitals', '1Referral', 'Include Vitals', 8, 1, 1, 0, 0, 'boolean', 1, 1, '', '', 'Include vitals data?');
INSERT INTO `layout_options` VALUES('REF', 'refer_related_code', '1Referral', 'Requested Service', 9, 15, 1, 30, 255, '', 1, 1, '', '', 'Billing Code for Requested Service');
INSERT INTO `layout_options` VALUES('REF', 'reply_date', '2Counter-Referral', 'Reply Date', 10, 4, 1, 0, 0, '', 1, 1, '', 'D', 'Date of reply');
INSERT INTO `layout_options` VALUES('REF', 'reply_from', '2Counter-Referral', 'Reply From', 11, 2, 1, 30, 255, '', 1, 1, '', '', 'Who replied?');
INSERT INTO `layout_options` VALUES('REF', 'reply_init_diag', '2Counter-Referral', 'Presumed Diagnosis', 12, 2, 1, 30, 255, '', 1, 1, '', '', 'Presumed diagnosis by specialist');
INSERT INTO `layout_options` VALUES('REF', 'reply_final_diag', '2Counter-Referral', 'Final Diagnosis', 13, 2, 1, 30, 255, '', 1, 1, '', '', 'Final diagnosis by specialist');
INSERT INTO `layout_options` VALUES('REF', 'reply_documents', '2Counter-Referral', 'Documents', 14, 2, 1, 30, 255, '', 1, 1, '', '', 'Where may related scanned or paper documents be found?');
INSERT INTO `layout_options` VALUES('REF', 'reply_findings', '2Counter-Referral', 'Findings', 15, 3, 1, 30, 3, '', 1, 1, '', '', 'Findings by specialist');
INSERT INTO `layout_options` VALUES('REF', 'reply_services', '2Counter-Referral', 'Services Provided', 16, 3, 1, 30, 3, '', 1, 1, '', '', 'Service provided by specialist');
INSERT INTO `layout_options` VALUES('REF', 'reply_recommend', '2Counter-Referral', 'Recommendations', 17, 3, 1, 30, 3, '', 1, 1, '', '', 'Recommendations by specialist');
INSERT INTO `layout_options` VALUES('REF', 'reply_rx_refer', '2Counter-Referral', 'Prescriptions/Referrals', 18, 3, 1, 30, 3, '', 1, 1, '', '', 'Prescriptions and/or referrals by specialist');
INSERT INTO `layout_options` VALUES('HIS', 'usertext11', '1General', 'Risk Factors', 1, 21, 1, 0, 0, 'riskfactors', 1, 1, '', '', 'Risk Factors');
INSERT INTO `layout_options` VALUES('HIS', 'exams', '1General', 'Exams/Tests', 2, 23, 1, 0, 0, 'exams', 1, 1, '', '', 'Exam and test results');
INSERT INTO `layout_options` VALUES('HIS', 'history_father', '2Family History', 'Father', 1, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'history_mother', '2Family History', 'Mother', 2, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'history_siblings', '2Family History', 'Siblings', 3, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'history_spouse', '2Family History', 'Spouse', 4, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'history_offspring', '2Family History', 'Offspring', 5, 2, 1, 20, 255, '', 1, 3, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_cancer', '3Relatives', 'Cancer', 1, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_tuberculosis', '3Relatives', 'Tuberculosis', 2, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_diabetes', '3Relatives', 'Diabetes', 3, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_high_blood_pressure', '3Relatives', 'High Blood Pressure', 4, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_heart_problems', '3Relatives', 'Heart Problems', 5, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_stroke', '3Relatives', 'Stroke', 6, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_epilepsy', '3Relatives', 'Epilepsy', 7, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_mental_illness', '3Relatives', 'Mental Illness', 8, 2, 1, 20, 255, '', 1, 1, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'relatives_suicide', '3Relatives', 'Suicide', 9, 2, 1, 20, 255, '', 1, 3, '', '', '');
INSERT INTO `layout_options` VALUES('HIS', 'coffee', '4Lifestyle', 'Coffee', 2, 28, 1, 20, 255, '', 1, 3, '', '', 'Caffeine consumption');
INSERT INTO `layout_options` VALUES('HIS', 'tobacco', '4Lifestyle', 'Tobacco', 1, 32, 1, 0, 255, 'smoking_status', 1, 3, '', '', 'Tobacco use');
INSERT INTO `layout_options` VALUES('HIS', 'alcohol', '4Lifestyle', 'Alcohol', 3, 28, 1, 20, 255, '', 1, 3, '', '', 'Alcohol consumption');
INSERT INTO `layout_options` VALUES('HIS', 'recreational_drugs', '4Lifestyle', 'Recreational Drugs', 4, 28, 1, 20, 255, '', 1, 3, '', '', 'Recreational drug use');
INSERT INTO `layout_options` VALUES('HIS', 'counseling', '4Lifestyle', 'Counseling', 5, 28, 1, 20, 255, '', 1, 3, '', '', 'Counseling activities');
INSERT INTO `layout_options` VALUES('HIS', 'exercise_patterns', '4Lifestyle', 'Exercise Patterns', 6, 28, 1, 20, 255, '', 1, 3, '', '', 'Exercise patterns');
INSERT INTO `layout_options` VALUES('HIS', 'hazardous_activities', '4Lifestyle', 'Hazardous Activities', 7, 28, 1, 20, 255, '', 1, 3, '', '', 'Hazardous activities');
INSERT INTO `layout_options` VALUES('HIS', 'sleep_patterns', '4Lifestyle', 'Sleep Patterns', 8, 2, 1, 20, 255, '', 1, 3, '', '', 'Sleep patterns');
INSERT INTO `layout_options` VALUES('HIS', 'seatbelt_use', '4Lifestyle', 'Seatbelt Use', 9, 2, 1, 20, 255, '', 1, 3, '', '', 'Seatbelt use');
INSERT INTO `layout_options` VALUES('HIS', 'name_1', '5Other', 'Name/Value', 1, 2, 1, 10, 255, '', 1, 1, '', '', 'Name 1');
INSERT INTO `layout_options` VALUES('HIS', 'value_1', '5Other', '', 2, 2, 1, 10, 255, '', 0, 0, '', '', 'Value 1');
INSERT INTO `layout_options` VALUES('HIS', 'name_2', '5Other', 'Name/Value', 3, 2, 1, 10, 255, '', 1, 1, '', '', 'Name 2');
INSERT INTO `layout_options` VALUES('HIS', 'value_2', '5Other', '', 4, 2, 1, 10, 255, '', 0, 0, '', '', 'Value 2');
INSERT INTO `layout_options` VALUES('HIS', 'additional_history', '5Other', 'Additional History', 5, 3, 1, 30, 3, '', 1, 3, '', '', 'Additional history notes');
INSERT INTO `layout_options` VALUES('HIS', 'userarea11', '5Other', 'User Defined Area 11', 6, 3, 0, 30, 3, '', 1, 3, '', '', 'User Defined');
INSERT INTO `layout_options` VALUES('HIS', 'userarea12', '5Other', 'User Defined Area 12', 7, 3, 0, 30, 3, '', 1, 3, '', '', 'User Defined');
