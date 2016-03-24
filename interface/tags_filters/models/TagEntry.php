<?php

use Framework\DataTable\Column;
use Framework\DataTable\ColumnBehavior\ActiveStatic;
use Framework\DataTable\ColumnBehavior\ActiveListbox;
use Framework\DataTable\ColumnBehavior\DetailView;
use Framework\DataTable\ColumnBehavior\ColorElement;
use Framework\ListOptions;

class TagEntry extends Entry
{
    public function init()
    {
        $this->setColumns(array(
            new Column(array('width' => '120px', 'behavior' => new ActiveStatic(array('class' => 'created_at', 'name' => 'created_at')), 'title' => 'Created At', 'data' => 'T.created_at')),
            new Column(array('width' => '120px', 'behavior' => new ActiveStatic(array('name' => 'tag_name', 'class' => 'tag_name', 'url' => $GLOBALS['webroot'] . '/interface/crisisprep/index.php?action=dispatch!element_changed')), 'title' => 'Tag Name', 'data' => 'T.tag_name')),
            new Column( array( 'width => 120px', 'behavior' => new ActiveListbox( array( 'map' => $this->getColorOptions(), 'name' => 'tag_color', 'class' => 'color-picker', 'url' => $GLOBALS['webroot'].'/interface/tags_filters/index.php?action=tags!element_changed' ) ), 'title' => 'Tag Color', 'data' => 'T.tag_color' ) ),
            new Column(array('width' => '80px', 'behavior' => new ActiveStatic(array('class' => 'update-column', 'name' => 'last_updated', 'attributes' => array('id', 'updated_at'))), 'title' => 'Last Updated', 'data' => "CONCAT(T.updated_at,' by ',T.updated_by) AS last_updated" )),
        ));
    }

    public function getStatement()
    {
        $statement = "SELECT
            T.id,
            T.created_at,
            T.created_by,
            T.tag_name,
            T.tag_color
            FROM tf_tags T";
        return $statement;
    }

    public function getColorOptions()
    {
        $listOptions = new ListOptions( array( 'list' => 'ACLT_Tag_Colors' ) );
        $listOptions->init();
        $options = array();
        if ( count( $listOptions->getRows() ) > 0 ) {
            foreach ( $listOptions->getRows() as $row ) {
                $colors = json_decode( $row['notes'] );
                $options[]= array( 'value' => $row['option_id'], 'text' => $row['title'] );
            }
        }
        return $options;
    }

    public function getColorOptionsJson()
    {
        echo json_encode( $this->getColorOptions() );
    }
}