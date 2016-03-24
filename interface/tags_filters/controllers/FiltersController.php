<?php
use Framework\AbstractController;
use Framework\DataTable\DataTable;

require_once(__DIR__."/../../../library/pid.inc");
require_once(__DIR__."/../../../library/formatting.inc.php");
require_once(__DIR__."/../../../library/patient.inc");

class FiltersController extends AbstractController
{
    public function getTitle()
    {
        return xl("Filters");
    }

    public function getEntry()
    {
        return new FilterEntry();
    }

    public function buildDataTable()
    {
        $entry = $this->getEntry();
        $dataTable = new DataTable(
            $entry,
            'filters-table',
            $this->getBaseUrl()."/index.php?action=filters!results",
            null,
            $this->getBaseUrl()."/index.php?action=filters!setpid" );
        return $dataTable;
    }

    public function _action_index()
    {
        $this->view->dataTable = $this->buildDataTable();
        $this->view->title = $this->getTitle();
        $this->view->tags = TagRepository::fetchAll();
        $this->setViewScript( 'list.php', 'layouts/filters_layout.php' );
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