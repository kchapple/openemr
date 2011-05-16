<?php
class Range
{
    const NEG_INF = -1E100000000;
    const POS_INF = INF;
    
    public $lowerBound;
    public $upperBound;
    
    public function __construct( $lowerBound, $upperBound )
    {
        $this->lowerBound = $lowerBound;
        $this->upperBound = $upperBound;
    }

    public function test( $val )
    {
        if ( $val > $this->lowerBound && 
            $val < $this->upperBound ) {
            return true;        
        }
        
        return false;
    }
}
