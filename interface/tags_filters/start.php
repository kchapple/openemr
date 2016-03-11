<?php

//if ( $GLOBALS['tags_filters_enabled'] ) {


function tf_filter_patient_select( $args )
{
    $username = $args['username'];
    $where = $args['where'];

//    // Get all my ACL Groups
//    $myGroups = acl_get_group_titles( $username );
//
//    // Get all filters associated with this ACL group
//
//    // Fetch all the patient filters
//    $repo = new TagRepository();
//    $repo->fetchAll( 'filter_patient_select' );
//
//    // Get the PIDs of the patients to hide via groups
//    $sql = "SELECT T.pid
//    FROM filters F
//    JOIN filters_users FU ON F.id = FU.filter_id
//    JOIN patients_tags PT ON PT.tag_type = F.tag_type
//    JOIN tag_type TT ON TT.id = PT.tag_type
//    WHERE FU.user_id = ?";
//
//
//
//    $where .= "patient_data.id NOT IN ()";

    return $where;
}
add_action( 'filter_patient_select', 'tf_filter_patient_select' );

function add_tags_filters_navigation()
{
    include __DIR__."/views/tags_filters_left_nav.php";
}
add_action('left_nav_before_html_end', 'add_tags_filters_navigation');


//}