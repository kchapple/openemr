<?php
class ProblemList_Denominator implements AmcFilterIF
{
    public function getTitle()
    {
        return "Problem List Denominator";
    }
    
    public function test( AmcPatient $patient, $dateBegin, $dateEnd ) 
    {
        // TODO seen by the EP or admitted to the eligible hospital�s or CAH�s inpatient or emergency department (POS 21 or 23)   
        return false;
    }
}
