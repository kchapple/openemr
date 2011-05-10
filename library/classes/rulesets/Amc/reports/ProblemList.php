<?php
class ProblemList extends AbstractAmcReport
{
    public function getTitle()
    {
        return "Problem List";
    }
    
    public function test( AmcPatient $patient, $dateBegin, $dateEnd ) 
    {
        // TODO More than 80% of all unique patients seen by the EP or admitted to the 
        // eligible hospitalÕs or CAHÕs inpatient or emergency department (POS 21 or 23) 
        // have at least one entry or an indication that no problems are known for the 
        // patient recorded as structured data   
        return false;
    }
}