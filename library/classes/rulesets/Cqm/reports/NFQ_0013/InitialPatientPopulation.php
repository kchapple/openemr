<?php
class NFQ_0013_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        if ( convertDobtoAgeYearDecimal( $patient->dob, $dateBegin ) >= 18 ) {
            $diagnosisHypertension = new ClinicalDiagnosisType( ClinicalDiagnosisType::DIAG_HYPERTENSION );
            if ( $diagnosisHypertension->doPatientCheck( $patient, $dateBegin, $dateEnd ) ) {
                $encounterOupatient = new ClinicalEncounterType( ClinicalEncounterType::ENC_OUTPATIENT );
                if ( $encounterOupatient->doPatientCheck( $patient, $dateBegin, $dateEnd ) ) {
                    $encounterNursing = new ClinicalEncounterType( ClinicalEncounterType::ENC_NURS_FAC );
                   if ( $encounterNursing->doPatientCheck( $patient, $dateBegin, $dateEnd ) ) {
                       return true;
                   } 
                }
            }
        } 
        
        return false;
    }
}