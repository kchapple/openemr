<?php
/**
 * Created by PhpStorm.
 * User: kchapple
 * Date: 3/9/16
 * Time: 2:07 PM
 */

class PatientTagRepository
{
    public function fetchTagsForPatient( $pid )
    {
        $entry = new PatientTagEntry();
        $sql = $entry->getStatement()." WHERE P.pid = ?";
        $result = sqlStatement( $sql, array ( $pid ) );
        $tags = array();
        while ( $row = sqlFetchArray( $result ) ) {
            $tags[]= new Tag( $row );
        }
        return $tags;
    }



}