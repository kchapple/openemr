<?php
class NFQ_0038_Numerator10 implements CqmFilterIF 
{
    public function getTitle() {
        return "Numerator 10";
    }
    
    public function test( CqmPatient $patient, $dateBegin, $dateEnd )
    {
        return false;
    }
}
