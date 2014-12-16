<?php
class AmcObject
{
    protected $patient = null;
    protected $args = array();
    
    public function __construct( AmcPatient $patient, $args ) 
    {
        $this->patient = $patient;
        $this->args = $args;
    }
    
    public function getPatient()
    {
        return $this->patient;
    }
    
    public function get( $key )
    {
        return $this->args[$key];
    }
}
