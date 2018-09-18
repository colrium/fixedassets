<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {

  function __construct(){
      parent::__construct();
      $this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      $this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');
      $this->load->model(FIXEDASSETS_PREFIX.'forms/mFormhandler', 'clsHndlr');
      $displayData = array();   
      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
    }


    public function moveCopyAsset($recId){
      $this->form_validation->set_rules('toprimaryLoc', 'Destination', 'required');
        if ($this->form_validation->run() == FALSE){
          //set error message
                   
          $errorMessage = strip_tags(validation_errors());
            setflashnotifacation('message', array('icon'=>'edit', 'alert'=>$errorMessage)); 
          preredirect(FIXEDASSETS_PREFIX.'Dashboard');

        }
        //data validated success
        else{
          $toprimaryLoc = $this->input->post('toprimaryLoc');
          $tosecondaryLoc = $this->input->post('tosecondaryLoc');
          if ($tosecondaryLoc == '') {
            $tosecondaryLoc = 0;
          }

          $details = dbtablerecord($recId, 'fixedassets_assetlist', FALSE);
          if ($details != FALSE) {
            $savedata = array('assetPrimLoc'=>$toprimaryLoc, 'assetSecLoc'=>$tosecondaryLoc);
            $newrecId = addupdatedbtablerecord('fixedassets_assetlist', $savedata, $recId, FALSE);
            setflashnotifacation('message', array('icon'=>'save', 'alert'=>' Asset '.$recId.' Moved'));
            preredirect(FIXEDASSETS_PREFIX.'Dashboard');
          }
          
        }
    }



    

    public function deleteRecord($recType, $recId){
      if ($this->clsAssets->deleteRecord($recType, $recId)) {
        setflashnotifacation('message', array('icon'=>'delete', 'alert'=>'Record Deleted'));
                preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
      }
      

    }



    public function dispose($recId){
      if ($this->clsAssets->disposeAsset($recId)) {
        setflashnotifacation('message', array('icon'=>'check', 'alert'=>'Asset '.$recId.' Disposed'));
        preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
      }
  
    }


    public function checkout($recId){
      if ($this->clsAssets->checkout($recId)) {
        setflashnotifacation('message', array('icon'=>'check', 'alert'=>'Asset '.$recId.' Checked Out'));
                preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
      }

    }



    public function checkin($recId){
      $checkindate = $this->input->post('dteCheckedin');
      if ($this->clsAssets->checkin($recId, $checkindate)) {
        setflashnotifacation('message', array('icon'=>'check', 'alert'=>'Asset '.$recId.' Checked In'));
                preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
      }

    }

    public function deleteRetired(){
      if ($this->clsAssets->deleteRetired()) {
        setflashnotifacation('message', array('icon'=>'delete_sweep', 'alert'=>'Assets Recyclebin has been emptied'));
                preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
      }

    }

    public function delete($recId){
       if ($this->clsAssets->deleteAsset($recId)) {
        setflashnotifacation('message', array('icon'=>'delete', 'alert'=>'Asset '.$recId.' Deleted'));
        preredirect(FIXEDASSETS_PREFIX.'Dashboard'); 
      }

    }



    public function addOthers($recordType, $recordId=0, $parentId=0){
            $formData = '<div class="table-responsive">
                          <table class="mdl-data-table mdl-js-data-table">';
              if ($recordType == "employee") {
                if ($recordId>0) {
                  
                }
                else{
                  $formData .=  '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empTtle" placeholder="Title" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empLName" placeholder="Last Name" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empMName" placeholder="Middle Name" style="width:100%;"></td>
                                </tr>

                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empFName" placeholder="First Name" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empPos" placeholder="Position" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empNumber" placeholder="Employee Number" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="email" class="form-control floating-label" name="empEmail" placeholder="Email" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><textarea class="form-control2" name="empAddress" placeholder="Address" rows="4" style="width:100%;"></textarea></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="empPhone" placeholder="Phone" style="width:100%;"></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>
                                ';
                  }

              }

              elseif ($recordType == "category") {
                if ($recordId>0) {
                  
                }
                else{
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="catName" placeholder="Category Name" style="width:100%;"></td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>';  
                }        
              }
              elseif ($recordType == "status") {
                if ($recordId>0) {
                  
                }
                else{
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="statusName" placeholder="Status Name" style="width:100%;"></td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>';  
                }        
              }

              elseif ($recordType == "manufacturer") {
                if ($recordId>0) {
                  
                }
                else{
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="manName" placeholder="Manufacturer Name" style="width:100%;"></td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>';  
                }      
              }

              elseif ($recordType == "dealer") {
                if ($recordId>0) {
                  
                }
                else{
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="dealerName" placeholder="Dealer Name" style="width:100%;"></td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>'; 
                }      
              }


              elseif ($recordType == "brand") {
                if ($recordId>0) {
                  
                }
                else{
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="brandName" placeholder="Brand Name" style="width:100%;"></td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>';  
                }  
              }

              elseif ($recordType == "section") {
                if ($recordId>0) {
                  
                }
                else{
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="sectionName" placeholder="Section Name" style="width:100%;"></td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>';
                } 
              }

              elseif ($recordType == "department") {
                if ($recordId>0) {
                  
                }
                else{

                $locationSelect = '<label><i class="fa fa-fa-map-marker"></i> Location</label></br><select class="chosen" name="primLocId" style="width:100%">';
                  foreach ($this->clsAssets->loadPriLoc() as $location) {
                    if (!$location->primisProtected) {
                      if ($parentId>0) {
                            if ($location->primlocID==$parentId) {
                              $locationSelect .= '<option value="'.$location->primlocID.'" SELECTED>'.$location->primlocIdentifier.'</option>';
                            }
                          }
                          else{
                            $locationSelect .= '<option value="'.$location->primlocID.'">'.$location->primlocIdentifier.'</option>';
                          }
                      
                    }
                    
                  }
                $locationSelect .= '</select">';
                $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="seclocIdentifier" placeholder="Department Name" style="width:100%;"></td>
                                </tr>

                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric">'.$locationSelect.'</td>
                                </tr>
                                
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>'; 
                  }
              }


              elseif ($recordType == "location") {
                if ($recordId>0) {
                  
                  foreach ($this->clsFunc->loadAssetLocation($recordId) as $location) {
                    $locationName = $location->primlocIdentifier;
                  }
                    $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-pencil"> </i> Edit '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="primlocIdentifier" value="'.$locationName.'" placeholder="Location Name" style="width:100%;"></td>
                               </tr>                               
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>'; 
                }
                else{
                   $formData .= '<tr>
                                    <td class="mdl-data-table__cell--non-numeric"><h2><i class="fa fa-plus-circle"> </i> Add '.$recordType.'</h2></td>
                                </tr>
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric"><input type="text" class="form-control floating-label" name="primlocIdentifier" placeholder="Location Name" style="width:100%;"></td>
                               </tr>                               
                                <tr>
                                    <td class="mdl-data-table__cell--non-numeric centertxt"><input type="submit" class="btn btn-success" value="Save"></td>
                                </tr>'; 
                  }
              }


              elseif ($recordType == "vehicle") {
                $formData .= '';
              }
        $formData .='</table></div>';
      $displayData['title']        = 'Add Record';
      $displayData['pageTitle']    = ' '.breadcrumb('Add '.$recordType);
      $displayData['form']    = $formData;
      $displayData['recordId'] = $recordId;
      $displayData['recType']    = $recordType;
      $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'forms/addOthers';
      $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
$displayData['module'] = 'fixedassets';
      
      renderpage($displayData);
      
        
    }

    public function saveOthers($recordType, $recId){
      if ($this->clsAssets->saveOthers($recordType, $recId)) {
        setflashnotifacation('message', array('icon'=>'save', 'alert'=>$recordType.' Record Saved'));
                preredirect(FIXEDASSETS_PREFIX.'Dashboard');
      }
      else{
        setflashnotifacation('error', array('icon'=>'save', 'alert'=>'Record Not Saved')); 
        preredirect(FIXEDASSETS_PREFIX.'Dashboard');
      }
    }

    public function addAssetOthers($recordType){
      

    }

    



    public function calculateMonthlyDepreciation($years, $buyingPrice, $purchDte, $salvageVal, $depMethod, $percUsage){
      $dataDep = $this->clsFunc->calculateMonthlyDepreciation($years, $buyingPrice, $purchDte, $salvageVal, $depMethod, $percUsage);
      return $dataDep;
    }

    public function calculateAnnualDepreciation($years, $buyingPrice, $purchDte, $salvageVal, $depMethod, $percUsage){
      $dataDep =  $this->clsFunc->calculateAnnualDepreciation($years, $buyingPrice, $purchDte, $salvageVal, $depMethod, $percUsage);
      return $dataDep;
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

   $records = $this->clsAssets->loadAllAssets();
   if (sizeof($records)>0) {
    $response["assets"] = array();
      foreach ($records as $record) {
        $catName = "";
        $statusName = "";
        $employeeName = "";
        $condName = "";
        $locName = "";
        $departmentName = "";

        //display category
        foreach ($this->clsFunc->loadAssetCategory($record->assetCat) as $category) {
          $catName = $category->catName;
        }
        
        //display Status

        foreach ($this->clsFunc->loadAssetStatus($record->assetStatus) as $status) {
          $statusName = $status->statusName;
        }

        //display Assignde Employee

        foreach ($this->clsFunc->loadAssetAssignedEmployee($record->assignedTo) as $employee) {
          $employeeName = $employee->empLName.' '.$employee->empFName;
        }

        //display Condition

        foreach ($this->clsFunc->loadAssetCondition($record->assetCondition) as $condition) {
          $condName = $condition->condName;
        }

        foreach ($this->clsFunc->loadAssetLocation($record->assetPrimLoc) as $location) {
          $locName = $location->primlocIdentifier;
        }

        foreach ($this->clsFunc->loadAssetDepartment($record->assetSecLoc) as $department) {
          $departmentName = $department->seclocIdentifier;
        }

        //temporary asset array
        $asset = array();
        $asset["assetCode"] = $record->assetCode;
        $asset["assetDesc"] = $record->assetDesc;
        $asset["assetCondition"] = $condName;
        $asset["assetStatus"] = $statusName;
        $asset["assetItem"] = $record->assetItem;
        $asset["auditStatus"] = $record->auditStatus;
        $asset["serialNum"] = $record->serialNum;
        $asset["assetCat"] = $catName;
        $asset["assignedTo"] = $employeeName;
        $asset["assetPrimLoc"] = $locName;
        $asset["assetSecLoc"] = $departmentName;
        
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


public function importFromAndroid(){
$assetCode  = $_POST['assetCode'];
$assetItem  = $_POST['assetItem'];
$assetDesc  = $_POST['assetDesc'];
$serialNum  = $_POST['serialNum'];
$assetCondtn  = $_POST['assetCondtn'];
$assetStatus  = $_POST['assetStatus'];
$assetCat  = $_POST['assetCat'];
$assetPrimLoc  = $_POST['assetPrimLoc'];
$assetSecLoc  = $_POST['assetSecLoc'];
$assignedTo  = $_POST['assignedTo'];
$auditStatus  = $_POST['auditStatus'];
$assetImg  = $_POST['assetImg'];
if ($this->clsAssets->ifExisting($assetCode)) {
  $this->clsAssets->updateAndroidAsset($assetCode);
}
else{
  $this->clsAssets->addAndroidAsset();
}

              $response = array();
              $response["success"] = 1;
              $response["message"] = "Saved";
              // echoing JSON response
              echo json_encode($response);



}

public function uploadImgFromAndroid(){
  if (isset($_FILES['myFile'])) {
    // Example:
    move_uploaded_file($_FILES['myFile']['tmp_name'], base_url()."images/assets/" . $_FILES['myFile']['name']);
    echo 'successful';
  }

}
  

public function properties($dataType="", $recId=""){
  $form = $this->layoutgen->formStart(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateProperties/'.$dataType.'/'.$recId, 'normal');
  if ($dataType=='category') {
    $form .= $this->layoutgen->normalTableStart();
        $form .= $this->layoutgen->tableHeaderStart();

        $form .= $this->layoutgen->tableNormalRowStart();

        $form .= $this->layoutgen->tableHeaderCell($this->fieldnames->getTableColumnValue('categories', 'catName', $recId).' Properties', 2);

        $form .= $this->layoutgen->tableNormalRowEnd();

        $form .= $this->layoutgen->tableHeaderEnd();

        $form .= $this->layoutgen->tableNormalRowStart();
          $form .= $this->layoutgen->tableNormalCell('Code/Number');
          $form .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateFieldInput('catCodeNum', $this->fieldnames->getTableColumnValueOnId('categories', 'catCodeNum', 'catId', $recId)));
        $form .= $this->layoutgen->tableNormalRowEnd();


        $form .= $this->layoutgen->tableNormalRowStart();
          $form .= $this->layoutgen->tableNormalCell('Description');
          $form .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateFieldInput('catDescription', $this->fieldnames->getTableColumnValueOnId('categories', 'catDescription', 'catId', $recId)));
        $form .= $this->layoutgen->tableNormalRowEnd();

        $form .= $this->layoutgen->tableNormalRowStart();
          $form .= $this->layoutgen->tableNormalCell('Depreciation Method');
          $form .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateSingleSelect('catDepMethod', $this->fieldnames->getTableColumnValueOnId('categories', 'catDepMethod', 'catId', $recId)));
        $form .= $this->layoutgen->tableNormalRowEnd();


        $form .= $this->layoutgen->tableNormalRowStart();
          $form .= $this->layoutgen->tableNormalCell('Life In Years');
          $form .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateFieldInput('catLifeInYears', $this->fieldnames->getTableColumnValueOnId('categories', 'catLifeInYears', 'catId', $recId)));
        $form .= $this->layoutgen->tableNormalRowEnd();


        $form .= $this->layoutgen->tableNormalRowStart();
          $form .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateSubmit("Save"), 2);
        $form .= $this->layoutgen->tableNormalRowEnd();






    $form .= $this->layoutgen->normalTableEnd();
  }
  else{

  }

$form .= $this->layoutgen->formEnd();
      $displayData['title']        = $dataType.' Properties';
      $displayData['pageTitle']    = ' '.breadcrumb($dataType.' Properties');
      $displayData['form']    = $form;
      $displayData['recId'] = $recId;
      $displayData['dataType']    = $dataType;
      $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'forms/editRecordProperties';
      $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
$displayData['module'] = 'fixedassets';
      
      renderpage($displayData);
      

}    
 
    

    
















































}


