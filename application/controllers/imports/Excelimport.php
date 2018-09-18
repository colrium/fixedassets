<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class Excelimport extends CI_Controller {
	public $displayData = array();
      public $spreadsheetdata = array();
      public $spreadsheetdatasize;
      public $spreadsheetheaders  = array();
	function __construct(){		
            parent::__construct();
            isloggedin(TRUE);
            $this->load->library('spreadsheets');
      }


      public function validateimport($module='system'){
            $requestRefererer = reffererpage();
            if ($requestRefererer=='') {
                  $requestRefererer = 'Dashboard';
            }
            $entity = $this->input->post('importtarget');
            $importfile = $this->input->post('filedbid');   
            $fileExtension =  $this->input->post('extension');

            if ($importfile=="" || $importfile=="none") {
                  setflashnotifacation('error', array('icon'=>'error_outline', 'alert'=>'Please select a file to import and wait for the file to upload'));
                  preredirect($requestRefererer, 'refresh');           
            } 
            else {    
                  $totalrows = 0;                  
                  $filedetails = dbtablerecord($importfile, 'attachments');
                  $workbookinitialized = $this->spreadsheets->workbook($filedetails->file_dir);
                  if ($workbookinitialized) {
                        $rowsdim = $this->spreadsheets->worksheetrowdimension();
                        $totalrows = $rowsdim['end'] - 1;
                        $this->spreadsheetdata = $this->spreadsheets->workbookdata(TRUE);
                        $this->spreadsheetheaders = $this->spreadsheets->dataheaders(TRUE);
                  }
                  $this->spreadsheetdatasize = $totalrows;
                  setflashnotifacation('message', array('icon'=>'line_weight', 'alert'=>'File read successfully. <br>'.$fileExtension.' Contains: '.$totalrows.' Records'));
                  $this->defineimport($importfile, $module, $entity, $fileExtension);
            }
      }


      public function defineimport($filedbid, $module, $entity, $fileExtension){            
            $destination = dbmoduletablename($entity);
            $file_column_headers = $this->spreadsheetheaders;
            $sampleData = $this->spreadsheetdata;
            $numberofrecs = $this->spreadsheetdatasize;



            $fields = array();
            foreach (dbtablefields($entity) as $fieldRec) {
                  if (!$fieldRec->isPK) {
                        $field = array('name' =>$fieldRec->setName, 'value'=>$fieldRec->initialName);
                        array_push($fields, $field);
                  }
            }

            $filedetails = dbtablerecord($filedbid, 'attachments');
            $this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
            $this->displayData['module'] = $module;      
            
            $this->displayData['title']        = 'Import '.$filedetails->name;
            $this->displayData['filedetails'] = $filedetails;
            $this->displayData['samplerecords']    = $sampleData;
            $this->displayData['destination']    = $destination;
            $this->displayData['entity']    = $entity;
            $this->displayData['fields']    = $fields;
            $this->displayData['numberofrecords']    = $numberofrecs;
            $this->displayData['file_headers']    = $file_column_headers;
            $this->displayData['filedbid']    = $filedbid;
            $this->displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb(' Match <i>'.$filedetails->name.'</i> Columns');
            $this->displayData['mainTemplate'] = 'forms/import/excelmatchheaders';    
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
            $table = $entity;
            $importurl = site_url('imports/Excelimport/saveimportrecord');
            $tablefields = dbtablefields($entity);

            $retArray['importurl'] = $importurl;

            //check for Repetations in assignment
            $mcvalidation = 0;

            foreach ($tablefields as $field) {
                  if ($field->makercheckered) {
                        if ($mcvalidation == 0) {
                              $mcvalidation = 1;
                        }
                  }                        
            }

            $retArray['mcvalidation'] = $mcvalidation;


            foreach ($countFields as $key => $value) {
                  if ($value > 1) {
                        $repeatedSelections[$key] = $value;
                  }
            }


            if (sizeof($repeatedSelections)==0) {

                  $requiredFieldsAssignment = dbtablefields($table, 'isFormReq', '1');
                  $missingFieldAssignments = array();
                  if (is_array($requiredFieldsAssignment)) {
                        foreach ($requiredFieldsAssignment as $reqField) {
                              if (!in_array($reqField->initialName, $tfields)) {
                                    array_push($missingFieldAssignments, $reqField->initialName);
                              }
                        }
                  }
                  
                  
                  if (sizeof($missingFieldAssignments) == 0) {
                        $imported=0;
                              if ($filename != "" && $entity != "") {
                                $filepath = $filename;
                                $attachment = dbtablerecord($filepath, 'attachments');
                                $column_headers = FALSE;
                                $records = FALSE;
                                if($attachment != FALSE){
                                    //read File
                                    $workbookinitialized = $this->spreadsheets->workbook($attachment->file_dir);
                                    if ($workbookinitialized) {
                                          $rowsdim = $this->spreadsheets->worksheetrowdimension();
                                          $totalrows = $rowsdim['end'] - 1;
                                          $records = $this->spreadsheets->workbookdata(TRUE);
                                          $column_headers = $this->spreadsheets->dataheaders(TRUE);
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
                              $notyTxt .= maticon('chevron_right', 'spaced-text').' '.dbfieldsetname($table, $missingvalue).' ';
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
                        $notyTxt .= maticon('chevron_right', 'spaced-text').'<i>'.dbfieldsetname($table, $key).'</i> has been assigned to more than one ('.$value.' fields) field';
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

            $newrecId = importrecordtodbtable($entity, $record);
            if ($newrecId != '0') {
               $success="1";
            }
            $returnarr['entity'] = $entity;
            $returnarr['recId'] = $newrecId;
            $returnarr['record'] = $record;
            $returnarr['status'] = $success;
                                                                  
            echo json_encode($returnarr);                         

   }









































}