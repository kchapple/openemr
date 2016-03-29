<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 3/9/16
 * Time: 2:07 PM
 */

use Framework\ListOptions;

class TagRepository
{
    public function fetchAll()
    {
        $sql = "SELECT T.id as tag_id, T.created_at, T.created_by, T.updated_at, T.updated_by, T.tag_name, T.tag_color
        FROM tf_tags T";
        $result = sqlStatement( $sql );
        $tags = array();
        while ( $row = sqlFetchArray( $result ) ) {
            $tags[]= new Tag( $row );
        }
        return $tags;
    }

    public function getColorOptions()
    {
        $listOptions = new ListOptions( array( 'list' => 'ACLT_Tag_Colors' ) );
        $listOptions->init();
        $options = array();
        if ( count( $listOptions->getRows() ) > 0 ) {
            foreach ( $listOptions->getRows() as $row ) {
                $color = $row['notes'];
                $options[]= array( 'value' => $row['option_id'], 'text' => $row['title'], 'color' => $color );
            }
        }
        return $options;
    }

    public function getColorOptionsJson()
    {
        echo json_encode( $this->getColorOptions() );
    }
}