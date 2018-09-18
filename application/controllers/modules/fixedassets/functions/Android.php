<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Android extends CI_Controller {

	function __construct(){

      parent::__construct(); 
      
      $this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      $this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');
      $this->load->model('mstart', 'clsStrt');
      $this->load->model(FIXEDASSETS_PREFIX.'forms/mformhandler', 'clsHndlr');
      $this->load->library('debuglib');

   }

      public function defaultAction(){
      	$this->debuglib->defaultAction();
      }


      public function secondDefaultAction(){
      	$this->debuglib->secondDefaultAction();

      }

      public function debDes(){
        $this->debuglib->debDes();
        
      }

      public function debVal(){
        $this->debuglib->debVal();

      }
      public function debNegVal(){
        $this->debuglib->debNegVal();
        
      }

      public function saveFromAndroid(){
            $recId  = $_POST['assetID'];
            $assetCode  = $_POST['assetCode'];


            if ($recId == '0') {
              $recId = $this->datalib->dataExists('assetlist', 'assetCode', $assetCode, 'assetID', false);
              $recId = $this->clsHndlr->androidSaveUpdateAsset($recId);
              
            }
            else{
              $recId = $this->clsHndlr->androidSaveUpdateAsset($recId);
            }
            

                          $response = array();
                          $response["success"] = 1;
                          $response["message"] = "$assetCode Saved with id $recId";
                          // echoing JSON response
                          echo json_encode($response);
      }

      public function uploadAssetImgFromAndroid($assetId){
              if (isset($_FILES['myFile'])) {
                // Example:
                move_uploaded_file($_FILES['myFile']['tmp_name'], base_url()."images/assets/" . $_FILES['myFile']['name']);
                echo 'successful';
      }
    }

      public function downloadAssetImage($assetCode){


      }


  public function test(){
    $recId = $this->datalib->dataExistsSecondaryLocation('33', 'ICT', true);
    echo $recId;
  }


public function getTotalAssetsAndroid(){
      $total = sizeof($this->clsAssets->loadAllAssets()); 
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

public function loadAllAssetsAndroid(){
      $response = array();
      $records = $this->clsAssets->loadAllAssets();
      $fields = $this->formfieldinput->getAppFormFields('assetlist');
      if (sizeof($records)>0) {
          $response["assets"] = array();
            foreach ($records as $record) {
              $asset = array();
              foreach ($fields as $field) {
                $column = $field->initialName;
                //escape non app fields
                if ($field->isAppData) {
                    //check if its foreign data
                    if ($field->isFK) {
                        if ($column == 'assignedTo') {
                          $asset[$column] = $this->fieldnames->getEmployeeName($record->$column);
                        }
                        else{
                          $asset[$column] = $this->fieldnames->getForeignKeyValue($column, $record->$column);
                        }
                    }
                    else{
                      $asset[$column] = $record->$column;
                    }
                }
                else{
                  //escape if nonAppData
                }
                
              }
              // push single asset into final response array
              array_push($response["assets"], $asset);

            }

            // success
          $response["success"] = 1;
           // success
          $response["message"] = sizeof($records);
       
          // echoing JSON response
          echo json_encode($response);
     }
     else{
            $response["success"] = 0;
            $response["message"] = "No Assets Found";
            // echoing JSON response
            echo json_encode($response);
     }


}











 }