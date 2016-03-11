<?php

use Framework\DataTable\Column;
use Framework\DataTable\ColumnBehavior\ActiveStatic;
use Framework\DataTable\ColumnBehavior\ActiveEncounter;
use Framework\DataTable\ColumnBehavior\DetailView;

class TagsEntry extends Entry
{
    public function init()
    {
        $this->setColumns(array(
            new Column(array('width' => '65px', 'behavior' => new ActiveStatic(array('class' => 'created_at', 'name' => 'created_at')), 'title' => 'Created At', 'data' => 'PT.created_at')),
            new Column(array('width' => '70px', 'behavior' => new ActiveEncounter(array('name' => 'patient_name')), 'title' => 'Patient Name', 'data' => 'CONCAT(P.fname," ",P.lname)')),
            new Column(array('width' => '70px', 'behavior' => new ActiveStatic(array('name' => 'tag_name', 'class' => 'tag_name', 'url' => $GLOBALS['webroot'] . '/interface/crisisprep/index.php?action=dispatch!element_changed')), 'title' => 'Tag Name', 'data' => 'T.tag_name')),
            new Column(array('width' => '70px', 'behavior' => new DetailView($GLOBALS['webroot'] . '/interface/tags_filters/index.php?action=tags!details', 'id'), 'class' => 'details-control', 'searchable' => false, 'orderable' => false, 'title' => 'Details', 'data' => '', 'defaultContent' => '')),
            new Column(array('width' => '70px', 'behavior' => new ActiveStatic(array('class' => 'update-column', 'name' => 'last_updated', 'attributes' => array('id', 'updated_at'))), 'title' => 'Last Updated', 'data' => "CONCAT(PT.updated_at,' by ',PT.updated_by) AS last_updated" )),
        ));
    }

    public function getStatement()
    {
        $statement = "SELECT
            PT.id,
            PT.created_at,
            PT.created_by,
            CONCAT(PT.updated_at,' by ',PT.updated_by) AS last_updated,
            CONCAT(P.fname,' ',P.lname) AS patient_name,
            P.fname, P.lname, P.DOB, P.DOB AS DOB2,
            T.tag_name
            FROM tf_patients_tags PT
            JOIN tf_tags T ON T.id = PT.tag_id
            JOIN patient_data P ON PT.pid = P.pid";
        return $statement;
    }
}