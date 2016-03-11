<?php

namespace Framework\DataTable\ColumnBehavior;


use Framework\DataTable\ColumnBehaviorIF;

require_once 'ActiveElement.php';

class DetailView implements ColumnBehaviorIF
{
    protected $action = ''; // Action URL to call
    protected $key = 'id'; // param key to pass
    
    public function __construct( $action, $key = null )
    {
        $this->action = $action;
        if ( $key !== null ) {
            $this->key = $key;
        }
    }
    
    public function getOutput( $data )
    {
        $encounter = $data['encounter'];
        $pid = $data['pid'];
        return "<a class='column_behavior_details' data-pid='$pid' data-encounter ='$encounter' href='$this->action&encounter=$encounter&pid=$pid'>Show</a>";
    }
}

