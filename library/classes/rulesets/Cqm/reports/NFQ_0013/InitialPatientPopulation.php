<?php
class NFQ_0013_InitialPatientPopulation implements CqmFilterIF
{
    public function getTitle() 
    {
        return "Initial Patient Population";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        $diagnosisHypertension = new ClinicalDiagnosisType( ClinicalDiagnosisType::DIAG_HYPERTENSION );
        if ( $diagnosisHypertension->doPatientCheck( $patient, $dateBegin, $dateEnd ) ) {
            return true;
        } 
        
        return false;
    }
}