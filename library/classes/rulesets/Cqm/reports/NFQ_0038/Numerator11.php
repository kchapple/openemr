<?php
class NFQ_0038_Numerator11 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 11";
    }
    
    public function test( CqmPatient $patient, $beginDate, $endDate )
    {
        if ( Immunizations::checkDtap( $patient, $beginDate, $endDate ) &&
             Immunizations::checkIpv( $patient, $beginDate, $endDate ) &&
             ( Immunizations::checkMmr( $patient, $beginDate, $endDate ) &&
               !Helper::checkAllergy( Allergy::POLYMYXIN, $patient, $patient->dob, $endDate ) ) &&
             Immunizations::checkVzv( $patient, $beginDate, $endDate ) &&
             Immunizations::checkHepB( $patient, $beginDate, $endDate ) ) {
            return true;
        }
        return false;
    }   
}
