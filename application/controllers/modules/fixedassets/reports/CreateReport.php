<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CreateReport extends CI_Controller {

  function __construct(){
      parent::__construct();
      $this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      $this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');
      $this->load->model(FIXEDASSETS_PREFIX.'reports/mreports','clsRep');
      $this->load->library('fieldnames');
      $this->load->model(FIXEDASSETS_PREFIX.'forms/mFormhandler', 'clsHndlr');
      $displayData = array();   

    }

public function createEditReport($repId){
  $displayData['title']        = 'Create Report';
  $details    = array();
  if ($repId==0) {
      $displayData['pageTitle']    = ' '.breadcrumb('Create Custom Report');
      
      $details['reportId'] = NULL;
      $details['reportName']   = NULL;
      $details['reportDesc'] = NULL;
      $details['reportUser'] = NULL;
      $details['isPrivate'] = NULL;
      $details['dteCreated'] = NULL;
      $details['bRetired'] = NULL;
      $displayData['details']    = $details;
  }
  else{

    $displayData['pageTitle']    = ' '.breadcrumb('Edit Custom Report');
    $details    = array();
    foreach ($this->clsHndlr->getRecordDetails('fixedassets_reports', 'reportId', $repId) as $detail) {
      $details['reportId'] = $detail->reportId;
      $details['reportName']   = $detail->reportName;
      $details['reportDesc'] = $detail->reportDesc;
      $details['reportUser'] = $detail->reportUser;
      $details['isPrivate'] = $detail->isPrivate;
      $details['dteCreated'] = $detail->dteCreated;
      $details['bRetired'] = $detail->bRetired;
      
    }
    $displayData['details']    = $details;
    
  }
  $displayData['repId']        = $repId;
  $displayData['fields']    = $this->formfieldinput->getFormFields("fixedassets_reports");
  $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/createCustomReport';
    $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
$displayData['module'] = 'fixedassets';
    renderpage($displayData);
    
}

public function reportDefine($repId){
  $displayData['title']        = 'Report Define';
  $displayData['pageTitle']    = ' '.breadcrumb('Report Define');
  $displayData['details']      = $this->clsHndlr->getRecordDetails('fixedassets_reports', 'reportId', $repId);
  $displayData['repId']        = $repId;
  $displayData['fields']        = dbtablefields('fixedassets_assetlist');
  $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/defineCustomReport';
  $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
  $displayData['module'] = 'fixedassets';
  renderpage($displayData);
  

}

public function defineReportFields($repId){
  $displayData['title']        = 'Report Fields';
  $displayData['pageTitle']    = ' '.breadcrumb(' Define Report Fields');
  $displayData['details']      = $this->clsHndlr->getRecordDetails('fixedassets_reports', 'reportId', $repId);
  $displayData['repId']        = $repId;
  $displayData['fields']        = $this->clsHndlr->getCustomReportFields($repId);
  $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'reports/defineReportFields';
  $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
$displayData['module'] = 'fixedassets';
  renderpage($displayData);
  

}
public function deleteReport($repId){
  if ($this->clsHndlr->deleteReport($repId)) {
    setflashnotifacation('message', 'Report Deleted'); 
      preredirect(FIXEDASSETS_PREFIX.'reports/Reports/mycustomreports');   
  }
}
























}