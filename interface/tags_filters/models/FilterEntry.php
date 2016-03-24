<?php

use Framework\DataTable\Column;
use Framework\DataTable\ColumnBehavior\ActiveStatic;
use Framework\DataTable\ColumnBehavior\ActiveEncounter;
use Framework\DataTable\ColumnBehavior\DetailView;

class FilterEntry extends Entry
{
    public function init()
    {
        $this->setColumns(array(
            new Column(array('width' => '65px', 'behavior' => new ActiveStatic(array('class' => 'created_at', 'name' => 'created_at')), 'title' => 'Created At', 'data' => 'F.created_at')),
            new Column(array('width' => '65px', 'behavior' => new ActiveStatic(array('class' => 'created_by', 'name' => 'created_by')), 'title' => 'Created By', 'data' => 'F.created_by')),
            new Column(array('width' => '70px', 'behavior' => new ActiveStatic(array('name' => 'filter_name', 'class' => 'filter_name', 'url' => $GLOBALS['webroot'] . '/interface/tags_filters/index.php?action=dispatch!element_changed')), 'title' => 'Filter Name', 'data' => 'F.filter_name')),
            new Column(array('width' => '70px', 'behavior' => new DetailView($GLOBALS['webroot'] . '/interface/tags_filters/index.php?action=tags!details', array( 'id' ) ), 'class' => 'details-control', 'searchable' => false, 'orderable' => false, 'title' => 'Details', 'data' => '', 'defaultContent' => '')),
            new Column(array('width' => '70px', 'behavior' => new ActiveStatic(array('class' => 'update-column', 'name' => 'last_updated', 'attributes' => array('id', 'updated_at'))), 'title' => 'Last Updated', 'data' => "CONCAT(F.updated_at,' by ',F.updated_by) AS last_updated" )),
        ));
    }

    public function getStatement()
    {
        $statement = "SELECT
            F.id,
            F.created_at,
            F.created_by,
            CONCAT(F.updated_at,' by ',F.updated_by) AS last_updated,
            F.filter_name
            FROM tf_filters F";
        return $statement;
    }
}