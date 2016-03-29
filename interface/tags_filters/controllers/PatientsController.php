<?php
use Framework\AbstractController;
use Framework\DataTable\DataTable;

require_once(__DIR__."/../../../library/pid.inc");
require_once(__DIR__."/../../../library/formatting.inc.php");
require_once(__DIR__."/../../../library/patient.inc");

class PatientsController extends AbstractController
{
    protected $entry = null;

    public function getTitle()
    {
        return xl("Patients Tags");
    }


    public function buildDataTable()
    {
        $entry = new PatientTagEntry();
        $this->entry = $entry;
        $dataTable = new DataTable(
            $entry,
            'patients-tags-table',
            $this->getBaseUrl()."/index.php?action=patients!results",
            null,
            $this->getBaseUrl()."/index.php?action=patients!setpid" );
        return $dataTable;
    }

    public function _action_view_tags()
    {
        $pid = $this->request->getParam('pid');
        $repo = new PatientTagRepository();
        $this->view->tags = $repo->fetchTagsForPatient( $pid );
        $this->setViewScript( 'views/patients_tags.php' );
    }

    public function _action_save_tags()
    {
        $pid = $this->request->getParam('pid');
        $repo = new PatientTagRepository();
        $this->view->tags = $repo->fetchTagsForPatient( $pid );
        $this->setViewScript( 'views/patients_tags.php' );
    }

    /*
     * Display edit view for editing a patient's tags
     */
    public function _action_edit()
    {
        $pid = $this->request->getParam('pid');
        $repo = new PatientTagRepository();
        $this->view->tags = $repo->fetchTagsForPatient( $pid );
        $tagRepo = new TagRepository();
        $this->view->tagColors = $tagRepo->getColorOptions();
        $this->view->tagsJson = json_encode( $tagRepo->fetchAll() );
        $this->setViewScript( 'forms/patients_tags_form.php' );
    }

    public function _action_index()
    {
        $this->view->dataTable = $this->buildDataTable();
        $this->view->title = $this->getTitle();
        $this->view->navbar = "";
        $this->view->modal = "";
        $this->setViewScript( 'lists/patients_tags_list.php' );
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
        $this->setViewScript('details/patients_tags.php');
    }
}