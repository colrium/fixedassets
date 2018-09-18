<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  /*---------------------------------------------------------------------
  // Copyright (c) 2017 Mutugi Riungu
  // Author: Mutugi Riungu
  // Added Awesomeness: Gacheri Mugambi
  ---------------------------------------------------------------------*/


class Api extends CI_Controller {
	function __construct(){
    parent::__construct();
    $this->load->model('uploads/muploads', 'clsUpld');
  }


  public function saveupdate(){
    $response["success"] = 0;
    $response["message"] = "No data posted";
    $response["parentdbid"] = 0;
    $savearr = array();
    $assetCode = '';
    $username = '';
    $password = '';
    //check if any data has been posted
      $postedData = $this->input->post(NULL, TRUE);
      if (is_array($postedData) && sizeof($postedData) > 0) { 
        if (array_key_exists('username', $postedData)) {
          $username = $postedData['username'];
        }
        if (array_key_exists('password', $postedData)) {
          $password = $postedData['password'];
        }
        $recId = 0;


        foreach (dbtablefields('fixedassets_assetlist') as $field) {
          $initialName = $field->initialName;
          $fieldpostdata = $this->input->post($initialName);
          if (!is_null($fieldpostdata)) {
            if ($field->isFK) {
              $fieldpostdata = dbfkrecordexists('fixedassets_assetlist', $initialName, $fieldpostdata, TRUE);
            }
            else{
              if ($initialName=='assetCode') {
                  $assetCode = $fieldpostdata;
                  $recId = dbtabledatarecordexists('fixedassets_assetlist', 'assetCode', $fieldpostdata, FALSE, TRUE);
                  if ($recId == FALSE) {
                    $recId = 0;
                  }
              }
            }
              
            $savearr[$initialName] = $fieldpostdata;
          }
        }

        
        if (sizeof($savearr)>0) {
          if ($this->ion_auth->login($username, $password)) {
            $user = $this->ion_auth->user()->row();
              $recId = addupdatedbtablerecord('fixedassets_assetlist', $savearr, $recId, FALSE);
              $response["success"] = 1;
              $response["message"] = "$assetCode Saved with id $recId";
              $response["parentdbid"] = $recId;
          }
          else{
              $response["success"] = 0;
              $response["message"] = "Login Error";
              $response["parentdbid"] = $recId;
          }
          
          
        }
        else{
          $response["message"] = "Unrecognizable post data";
        }

      }
      else{
        $response["message"] = "No Data Posted";        
      }
      // echoing JSON response
      $this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($response))->_display();
      
        
      
      
  }
  

  public function addrecordimage($recId){
      $response["success"] = "0";
      $response["message"] = "Image Upload Error";
      $postedData = $this->input->post(NULL, FALSE);
      $attId = 0;

      if (sizeof($postedData) > 0) {
        if (array_key_exists('filesizeinbytes', $postedData)) {
          $postedData['filesize'] = formatfileSize($postedData['filesizeinbytes']);
        }
        if (array_key_exists('name', $postedData)) {
          $postedData['extension'] = fileExtension($postedData['name']);
          $postedData['type'] = mime_content_type($postedData['name']);
          $postedData['oldname'] = $postedData['name'];
          $attId = dbtabledatarecordexists('attachments', "name", $postedData['name'], FALSE, TRUE);
          $attachment = dbtablerecord($attId, 'attachments');
          if ($attachment->entity != 'fixedassets_assetlist' || $attachment->record != $recId) {
            $attId = 0;
          }
        }
        $postedData['entity'] = 'fixedassets_assetlist';
        $postedData['record'] = $recId;
        $postedData['isimage'] = 1;
        $postedData['date'] = date('Y-m-d');
        if ($attId > 0) {
          $postedData['replaced'] = '1';
        }
        $postedData['gmtinsertdate'] = date('r');
        $attId = addupdatedbtablerecord('attachments', $postedData, $attId, FALSE);
        $this->clsUpld->setmainimage($attId);
        $response["success"] = "1";
        $response["message"] = "Image Uploaded";
      }
      // echoing JSON response
      echo json_encode($response);
  }

  public function getrecordimage($recId){ 
     if ($recId > 0) {
        $assetImage = dbattachmentimages('fixedassets_assetlist', $recId, TRUE);
        if ($assetImage != false) {
          dbattachmentfilestream($assetImage->attId);
        }
        else{
          die("Error: No image file set.");          
        }       
     }
     else{
        die("Error: Record Does Not Exist");
     }
     
  }

  public function totalrecords(){
      $params['where']['notequalto'] = array('assetPrimLoc' => '3', 'assetPrimLoc' => '2');
      $total = dbtablerecordscount('fixedassets_assetlist', $params); 
      $response = array();
      if ($total>0) {
        $response["success"] = 1;
        $response["totalRecords"] = $total;
        $response["message"] = $total." Records found";
      echo json_encode($response);
      }

      else{
        $response["success"] = 0;
        $response["totalRecords"] = 0;
        $response["message"] = "No Records found";
        echo json_encode($response);
      }
    }





  public function getrecords($page='0'){
      $recordsperpage = $this->config->item('sync_records_per_page', 'cogs');
      $response = array();
      $params = array();
      $params['where']['notequalto'] = array('assetPrimLoc' => '3', 'assetPrimLoc' => '2');
      $records = dbtablerecords('fixedassets_assetlist', $params, FALSE); 
      $totalrecords = sizeof($records);

      $newRecords = array();

      //define pages
      if (sizeof($records)>0) {
              $datapages = $totalrecords / $recordsperpage;
              $pages = $datapages;
              if (is_float($pages)) {
                  $pages = ceil($pages);
              }
              if (!isset($page) || strlen($page) == 0 || $page == 0) {
                $page = 1;
              }
              if (!is_numeric($page)) {
                  $page = intval($page);
              }

              

              if ($page > $pages) {
                $page = $pages;
              }
              //set real data page      
              $dataPage = $page-1;
              

              

                //sort page data
                //first and last index
                $startRecord = $dataPage*$recordsperpage;
                $endRecord = (($dataPage*$recordsperpage)+$recordsperpage)-1;
                if ($startRecord >= $totalrecords) {
                  $startRecord =  (($dataPage-1)*$recordsperpage);
                }
                if ($endRecord >= $totalrecords) {
                  $endRecord = $totalrecords - 1;
                }
                for ($i=$startRecord; $i <=$endRecord ; $i++) { 
                  array_push($newRecords, $records[$i]);
                }

                $records = $newRecords;

              

              $fields = dbtablefields('fixedassets_assetlist');
          
              $response["assets"] = array();
                foreach ($records as $record) {
                  $asset = array();
                  foreach ($fields as $field) {
                    $column = $field->initialName;
                    //escape non app fields
                    if ($field->isAppData) {
                        $asset[$column] = $record->$column;
                    }
                    else{
                      //escape if nonAppData
                    }

                    
                  }

                    $assetImage = dbattachmentimages('fixedassets_assetlist', $record->assetID, TRUE);
                    if ($assetImage != false) {
                      $hasImage = 1;
                      $imageName = $assetImage->name;
                      $file_ext = $assetImage->extension;
                    }
                    else{
                      $hasImage = 0;
                      $imageName = 'none';
                      $file_ext = 'none';
                    }
                    $asset["hasImage"] = $hasImage;
                    $asset["imageName"] = $imageName;
                    $asset["fileExt"] = $file_ext;
                    
                  // push single asset into final response array
                  array_push($response["assets"], $asset);

                }

              

              

              // success
              $response["success"] = 1;
              // message
              $response["message"] = $totalrecords.' records in db. Current Page:  '.$page.' out of '.$pages.' Pages.';
              //total assets
              $response["totalRecords"] = $totalrecords;
              $response["recordsperpage"] = $recordsperpage;
              $response["currentpage"] = intval($page);
              $response["currentpagerecords"] = sizeof($newRecords);
              $response["pages"] = $pages;
              // echoing JSON response

         }
         else{
                $response["errorcode"] = 2;
                $response["success"] = 0;
                $response["message"] = "No Records Found";
                $response["totalRecords"] = $totalrecords;
                $response["recordsperpage"] = $recordsperpage;
                $response["currentpage"] = intval($page);
                $response["currentpagerecords"] = sizeof($newRecords);

                
         }

   echo json_encode($response, 0, 20000000);

      
  }



































}