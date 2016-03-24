<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 3/9/16
 * Time: 2:07 PM
 */

class TagRepository
{
    public function fetchAll()
    {
        $sql = "SELECT * FROM tf_tags";
        $result = sqlStatement( $sql );
        $tags = array();
        while ( $row = sqlFetchArray( $result ) ) {
            $tags[]= new Tag( $row );
        }
        return $tags;
    }


}