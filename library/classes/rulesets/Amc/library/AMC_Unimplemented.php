<?php
require_once( 'AbstractAmcReport.php' );

class AMC_Unimplemented extends AbstractAmcReport implements RsUnimplementedIF
{   
    public function __construct()
    {
        parent::__construct( array(), array(), null );
    }
    
    public function test( AmcPatient $patient, $dateBegin, $dateEnd ) 
    {
        
    }
    
    public function getTitle() 
    {
        
    }
}
