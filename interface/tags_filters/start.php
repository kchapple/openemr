<?php

require_once __DIR__ . '/vendor/autoload.php';

//if ( $GLOBALS['tags_filters_enabled'] ) {


function tf_filter_patient_select( $args )
{
    $username = $args['username'];
    $where = $args['where'];

    $patientsToHide = array();

    // Get all my ACL Groups


    // Get all filters associated with this user

    // Fetch all the group filters
    $repo = new FilterRepository();
    $patientsToHide = $repo->fetchPatientsToHideForUser( $username );
    if ( count( $patientsToHide ) ) {
        $pidString = implode(",", $patientsToHide);
        $where .= " WHERE patient_data.pid NOT IN ( $pidString ) ";
    }

    return $where;
}
add_action( 'filter_patient_select', 'tf_filter_patient_select' );

function add_tags_filters_navigation()
{
    include __DIR__."/views/tags_filters_left_nav.php";
}
add_action('left_nav_before_html_end', 'add_tags_filters_navigation');

function add_tags_demographics()
{
    include __DIR__."/views/tags_demographics.php";
}
add_action( 'demographics_before_first_table_row', 'add_tags_demographics' );


//}