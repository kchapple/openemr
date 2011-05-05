<?php
class NFQ_Unimplemented extends AbstractCqmReport
{   
    public function __construct() {
        parent::__construct( array(), array(), null );    
    }
    
    public function createPopulationCriteria()
    {
         return null;    
    }
}