<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/


class Import extends CI_Controller {
	
	private $displayData, $importsdir, $importsdirready;

      function __construct(){
            parent::__construct();

            isloggedin(TRUE);

            $this->displayData = array();
            $this->importsdir = DATAIMPORTSFILES_DIR.'fixedassets';
            $this->importsdirready = FALSE;
            $this->displayData['module'] = 'fixedassets';
            $this->displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
            $this->load->model(FIXEDASSETS_PREFIX.'forms/mFormhandler', 'clsAssetsHndlr');
            $this->load->helper(FIXEDASSETS_PREFIX.'import');
            $this->load->model('data', 'clsData');
      }

      private function preparedir(){
            if (!file_exists($this->importsdir)) {
                  if (mkdir($this->importsdir)) {
                        $this->importsdirready = TRUE;
                  }
                  else{
                        $this->importsdirready = FALSE;
                  }
            }
            else{
                 $this->importsdirready = TRUE; 
            }
      }

      public function validatefile(){            
            $requestRefererer = reffererpage();
            if ($requestRefererer=='') {
                  $requestRefererer = FIXEDASSETS_PREFIX.'Dashboard';
            }
            $entity = $this->input->post('importtarget');
            $importfile = $this->input->post('filedbid');
   
            $fileExtension =  $this->input->post('extension');


            if ($importfile=="" || $importfile=="none") {
                  setflashnotifacation('error', "Please select a file to import and wait for the file to upload");  
                  preredirect($requestRefererer, 'refresh');           
            } 
            else {    
                  $totalrows = 0;
                  if ($fileExtension=='csv') {
                        $this->load->library('csvimport');
                        $totalrows = $this->csvimport->get_totalrows($importfile);
                  }
                  else if($fileExtension=='xls' || $fileExtension=='xlsx'){
                        $this->load->library('xlsimport');
                        $totalrows = $this->xlsimport->get_totalrows($importfile);
                  }
                  $this->displayData['strmessage'] =  maticon('line_weight', 'medium').'<br>File read successfully. <br>'.$fileExtension.' Contains: '.$totalrows.' Records';
                  $this->defineimport($importfile, $entity, $fileExtension);
            }
      }

      public function test(){
            $this->load->library('xlsimport');
            $totalrows = $this->xlsimport->get_array(37);
            print_r($totalrows);
      }


      public function defineimport($filename, $entity, $fileExtension){
            
            $destination = humanize($entity);
            $table = 'fixedassets_'.$entity;
            



            $file_path =  $filename;
            $file_column_headers = array();
            $sampleData = array();
            $numberofrecs = 0;

            if($fileExtension=='csv'){
                  //read file
                  $this->load->library('csvimport');                    
                  //read Csv File
                  $numberofrecs = $this->csvimport->get_totalrows($file_path);
                  $file_column_headers = $this->csvimport->get_column_headers($file_path);
                  $sampleData = $this->csvimport->get_samplerows($file_path);
            }
            else if($fileExtension=='xls' || $fileExtension=='xlsx'){
                  //read file
                  $this->load->library('xlsimport');
                  $numberofrecs = $this->xlsimport->get_totalrows($file_path);
                  $file_column_headers = $this->xlsimport->get_column_headers($file_path);
                  $sampleData = $this->xlsimport->get_samplerows($file_path);
                  $csvRecords = $this->xlsimport->get_array($file_path);
            }

            $fields = array();
            foreach ($this->fieldnames->getFormFields($table) as $fieldRec) {
                  if (!$fieldRec->isPK) {
                        $field = array('name' =>$fieldRec->setName, 'value'=>$fieldRec->initialName);
                        array_push($fields, $field);
                  }
            }


            $this->displayData['title']        = 'Import Spreadsheet';
            $this->displayData['filename']    = $filename;
            $this->displayData['samplerecords']    = $sampleData;
            $this->displayData['destination']    = $destination;
            $this->displayData['entity']    = $entity;
            $this->displayData['fields']    = $fields;
            $this->displayData['numberofrecords']    = $numberofrecs;
            $this->displayData['file_headers']    = $file_column_headers;
            $this->displayData['pageTitle']    = ' '.breadcrumb(' Import '.$filename);
            $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'import/assign_headers';    
            renderpage($this->displayData);
            

      }

      function validatecolumnsassignment(){
            $this->load->helper('data');
            $retArray = array();
            $notyTxt = '';
            $errorOccured = FALSE;
            $errorMessage = '';
            $tfields = $this->input->post('targetFields');
            $filename = $this->input->post('importFile');
            $entity = $this->input->post('entity');
            $repeatedSelections = array();
            $countFields = array_count_values($tfields);
            $table = 'fixedassets_'.$entity;
            $importurl = site_url(FIXEDASSETS_PREFIX.'import/Import/saveimportrecord');
            

            $retArray['importurl'] = $importurl;

            //check for Repetations in assignment

            foreach ($countFields as $key => $value) {
                  if ($value > 1) {
                        $repeatedSelections[$key] = $value;
                  }
            }


            if (sizeof($repeatedSelections)==0) {

                  $requiredFieldsAssignment = $this->fieldnames->getRequiredImportFields($table);
                  $missingFieldAssignments = array();
                  foreach ($requiredFieldsAssignment as $reqField) {
                        if (!in_array($reqField->initialName, $tfields)) {
                              array_push($missingFieldAssignments, $reqField->initialName);
                        }
                  }
                  
                  if (sizeof($missingFieldAssignments) == 0) {
                        $imported=0;
                              if ($filename != "" && $entity != "") {
                                $filepath = $filename;
                                $attachment = dbtablerecord($filepath, 'attachments');
                                if($attachment != FALSE){
                                      //read File
                                      $fileExtension = $attachment->extension;

                                      if($fileExtension == 'csv'){
                                          $this->load->library('csvimport');
                                          $column_headers = $this->csvimport->get_column_headers($filepath);
                                          $records = $this->csvimport->get_array($filepath);
                                      }
                                      else if($fileExtension == 'xls' || $fileExtension == 'xlsx'){
                                          $this->load->library('xlsimport');
                                          $column_headers = $this->xlsimport->get_column_headers($filepath);
                                          $records = $this->xlsimport->get_array($filepath);
                                      }
                                      
                                      if ($records == FALSE || $column_headers == FALSE) {
                                          //csv read error
                                                $errorOccured = TRUE;
                                                      $notyTxt = '<div class="error-noty red"><center>'.maticon('bookmark_border', 'large').'</br>Your file appears to be empty</center></br></div>';
                                                      $errorMessage = $notyTxt;
                                                      $retArray['erroroccured'] = $errorOccured;
                                                      $retArray['errormsg'] = $errorMessage;


                                      }
                                      else{           
                                          $retArray['importurl'] = $importurl;
                                          $errorOccured = 0;
                                          $errorMessage = '';
                                          $retArray['assignedheaders'] = $tfields;
                                          $retArray['column_headers'] = $column_headers;
                                          $retArray['records'] = $records;
                                          $retArray['entity'] = $entity;
                                          $retArray['noofrecords'] = sizeof($records);
                                          $retArray['erroroccured'] = $errorOccured;
                                          $retArray['errormsg'] = $errorMessage;
                                                
                                            
                                      }                             
                                      

                                }
                                else{
                                    $errorOccured = TRUE;
                                    $notyTxt = '<div class="error-noty red"><center>'.maticon('folder_open', 'large').'</br> '.$filename.' could not be found.</center></br></div>';
                                          $errorMessage = $notyTxt;
                                          $retArray['erroroccured'] = $errorOccured;
                                          $retArray['errormsg'] = $errorMessage;

                                }
                        }
                        else{
                                    if ($filename=="" && $entity=="") {
                                          $errorOccured = TRUE;
                                          $notyTxt = '<div class="error-noty red"><center>'.maticon('cloud_off', 'large').'</br>The File name and destination Entity cannot be blank</center></br></div>';

                                          $errorMessage = $notyTxt;
                                          $retArray['erroroccured'] = $errorOccured;
                                          $retArray['errormsg'] = $errorMessage;

                                    }
                                    else if ($filename!="" && $entity=="") {
                                          $errorOccured = TRUE;
                                          $notyTxt = '<div class="error-noty red"><center>'.maticon('cloud_off', 'large').'</br>Destination Entity cannot be blank</center></br></div>';
                                          $errorMessage = $notyTxt;
                                          $retArray['erroroccured'] = $errorOccured;
                                          $retArray['errormsg'] = $errorMessage;

                                    }
                                    else if ($filename=="" && $entity!="") {
                                          $errorOccured = TRUE;
                                          $notyTxt = '<div class="error-noty red"><center>'.maticon('cloud_off', 'large').'</br>The File name cannot be blank</center></br></div>';
                                          $errorMessage = $notyTxt;
                                          $retArray['erroroccured'] = $errorOccured;
                                          $retArray['errormsg'] = $errorMessage;

                                    }
                        }
                                                      
                    
                  }

                  else{
                        //Missing required fields
                        $errorOccured = TRUE;
                        $notyTxt = '<div class="error-noty"></br>'.maticon('link', 'large').'</br>';
                        $notyTxt .= '<i>';
                        $totalmissingfields = sizeof($missingFieldAssignments);
                        $missingFieldsindex = 1;
                        foreach ($missingFieldAssignments as $missingkey => $missingvalue) {
                              $notyTxt .= maticon('chevron_right', 'spaced-text').' '.$this->fieldnames->getFieldName($missingvalue).' ';
                              if ($missingFieldsindex < $totalmissingfields) {
                                    $notyTxt .= ' , ';
                              }
                              $missingFieldsindex++;
                        }
                        $notyTxt .= '</i> needs to be assigned to a column of the import file for import to be possible. </br></div>';
                        $errorMessage = $notyTxt; 
                        $retArray['erroroccured'] = $errorOccured;
                        $retArray['errormsg'] = $errorMessage;

                  }



                              
            }
            else{
                  $errorOccured = TRUE;
                  $notyTxt = '<div class="error-noty"><center>'.maticon('repeat', 'large').'</br>';
                  $repeatedindex = 1;
                  $totalrepitations = sizeof($repeatedSelections);
                  foreach ($repeatedSelections as $key => $value) {
                        $notyTxt .= maticon('chevron_right', 'spaced-text').'<i>'.$this->fieldnames->getFieldName($key, $table).'</i> has been assigned to more than one ('.$value.' fields) field';
                        if($repeatedindex < $totalrepitations){
                              $notyTxt .= '</br>';
                        }
                        $repeatedindex++;
                  }
                  $notyTxt .= '</center></div>';
                  $errorMessage = $notyTxt;
                  $retArray['erroroccured'] = $errorOccured;
                  $retArray['errormsg'] = $errorMessage; 

            }

            echo json_encode($retArray, 0, 20000000);
      }


      public function saveimportrecord(){  
                     
            $record = $this->input->post('record');
            $entity = $this->input->post('entity');
            $success="0";
            $returnarr = array();
            if($entity == 'assetlist'){
                  $success = importfixedassetrecord($record);

            }

            $returnarr['entity'] = $entity;
            $returnarr['record'] = $record;
            $returnarr['status'] = $success;
                                                                  
            echo json_encode($returnarr);                         

   }

















}