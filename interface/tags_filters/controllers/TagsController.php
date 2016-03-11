<?php
use Framework\AbstractController;
use Framework\DataTable\DataTable;
use Framework\DataTable\SearchFilter;
use Framework\ListOptions;

require_once(__DIR__."/../../../library/pid.inc");
require_once(__DIR__."/../../../library/formatting.inc.php");
require_once(__DIR__."/../../../library/patient.inc");

class TagsController extends AbstractController
{
    public function getTitle()
    {
        return xl("Tags");
    }

    public function getEntry()
    {
        return new TagsEntry();
    }

    public function buildDataTable()
    {
        $entry = $this->getEntry();
        $dataTable = new DataTable(
            $entry,
            'tags-table',
            $this->getBaseUrl()."/index.php?action=tags!results",
            null,
            $this->getBaseUrl()."/index.php?action=tags!setpid" );
        return $dataTable;
    }

    public function _action_index()
    {
        $this->view->dataTable = $this->buildDataTable();
        $this->view->title = $this->getTitle();
        $this->setViewScript( 'list.php' );
    }

    public function _action_results()
    {
        $dataTable = $this->buildDataTable();
        echo $dataTable->getResults( $this->getRequest() );
    }

    public function _action_details()
    {
        $encounterId = $this->request->getParam('id');
        $pid = $this->request->getParam('pid');
        $this->view->encounter = $encounterId;
        $this->view->pid = $pid;
        $this->setViewScript('details.php');
    }
}