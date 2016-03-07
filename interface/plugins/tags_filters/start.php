<?php

//if ( $GLOBALS['tags_filters_enabled'] ) {


function tf_filter_patient_select( $args )
{
    $username = $args['username'];
    $where = $args['where'];

    return $where;
}
add_action( 'filter_patient_select', 'tf_filter_patient_select' );



//}