--
--  Comment Meta Language for sql upgrades:
--
--  Each section within an upgrade sql file is enveloped with an #If*/#EndIf block.  At first glance, these appear to be standard mysql
--  comments meant to be cryptic hints to -other developers about the sql goodness contained therein.  However, were you to rely on such basic premises,
--  you would find yourself grossly decieved.  Indeed, without the knowledge that these comments are, in fact a sneakily embedded meta langauge derived
--  for a purpose none-other than to aid in the protection of the database during upgrades,  you would no doubt be subject to much ridicule and public
--  beratement at the hands of the very developers who envisioned such a crafty use of comments. -jwallace
--
--  While these lines are as enigmatic as they are functional, there is a method to the madness.  Let's take a moment to briefly go over proper comment meta language use.
--
--  The #If* sections have the behavior of functions and come complete with arguments supplied command-line style
--
--  Your Comment meta language lines cannot contain any other comment styles such as the nefarious double dashes "--" lest your lines be skipped and
--  the blocks automatcially executed with out regard to the existing database state.
--
--  Comment Meta Language Constructs:
--
--  #IfNotTable
--    argument: table_name
--    behavior: if the table_name does not exist,  the block will be executed

--  #IfTable
--    argument: table_name
--    behavior: if the table_name does exist, the block will be executed

--  #IfMissingColumn
--    arguments: table_name colname
--    behavior:  if the colname in the table_name table does not exist,  the block will be executed

--  #IfNotColumnType
--    arguments: table_name colname value
--    behavior:  If the table table_name does not have a column colname with a data type equal to value, then the block will be executed

--  #IfNotRow
--    arguments: table_name colname value
--    behavior:  If the table table_name does not have a row where colname = value, the block will be executed.

--  #IfNotRow2D
--    arguments: table_name colname value colname2 value2
--    behavior:  If the table table_name does not have a row where colname = value AND colname2 = value2, the block will be executed.

--  #IfNotRow3D
--    arguments: table_name colname value colname2 value2 colname3 value3
--    behavior:  If the table table_name does not have a row where colname = value AND colname2 = value2 AND colname3 = value3, the block will be executed.

--  #IfNotRow4D
--    arguments: table_name colname value colname2 value2 colname3 value3 colname4 value4
--    behavior:  If the table table_name does not have a row where colname = value AND colname2 = value2 AND colname3 = value3 AND colname4 = value4, the block will be executed.

--  #IfNotRow2Dx2
--    desc:      This is a very specialized function to allow adding items to the list_options table to avoid both redundant option_id and title in each element.
--    arguments: table_name colname value colname2 value2 colname3 value3
--    behavior:  The block will be executed if both statements below are true:
--               1) The table table_name does not have a row where colname = value AND colname2 = value2.
--               2) The table table_name does not have a row where colname = value AND colname3 = value3.

--  #EndIf
--    all blocks are terminated with and #EndIf statement.

#IfNotRow2D list_options list_id lists option_id MSP_Categories
-- MSP Categories
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '15', 'Workers’ Compensation', 40, 0, 0, '', 'Insurance that employers are required to provide to cover employees who become sick or are injured on the job. Note: This type has no age restrictions.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '16', 'Federal Agency (Public Health)', 50, 0, 0, '', 'Services that are the direct obligation of another federal, state or local governmental entity.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '41', 'Federal Black Lung', 60, 0, 0, '', 'Coverage due to black lung disease and other respiratory conditions caused by coal mining, where a Medicare beneficiary may be entitled to have services reimbursed by the United States Department of Labor');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '14', 'Automobile/No-Fault', 30, 0, 0, '', 'Insurance coverage (including a self-insured plan) that pays for medical expenses for injuries sustained on the property or premises of the insured, or in the use, occupancy or operation of an automobile regardless of who may have been responsible for cau');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '13', 'End Stage Renal Disease (ESRD)', 20, 0, 0, '', 'Beneficiaries enrolled with Medicare solely due to renal failure and are insured through their own, or through a family member’s former or current employment. Note: This type has no age restrictions.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '12', 'Working Aged', 10, 0, 0, '', 'Beneficiaries age 65 or older who are insured through their or their spouses’ current employment. Employer’s group plan has 20 or more employees. Note: This type must only be used for beneficiaries who are 65 years old or older on the date the service was');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '42', 'Veterans Affairs', 70, 0, 0, '', 'Veterans who are Medicare-eligible may elect whether Medicare or VA benefits will handle their claims. Note: This type has no age restrictions.');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '43', 'Disability', 80, 0, 0, '', 'Beneficiaries under the age of 65, who are disabled and insured through their current employment or through the current employment of a family member. The plan has 100 or more employees. Note: If the basis of disability is ESRD, the ESRD type should be us');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('MSP_Categories', '47', 'Other Liability', 90, 0, 0, '', 'Insurance (including self-insured plans) that provides payment based on legal liability for injury, illness or damage to property. It includes, but is not limited to, automobile liability insurance, uninsured motorist insurance, underinsured motorist insu');
INSERT INTO `list_options` (`list_id`, `option_id`, `title`, `seq`, `is_default`, `option_value`, `mapping`, `notes`) VALUES ('lists', 'MSP_Categories', 'MSP Categories', 222, 1, 0, '', '');
#EndIf

#IfMissingColumn insurance_data msp_category
ALTER TABLE insurance_data ADD COLUMN msp_category int(11) DEFAULT NULL COMMENT 'references option_id in MSP_Categories list';
#EndIf
