<?php
class Mformhandler extends CI_Model{

function __construct(){
      parent::__construct();
     
   }


public function saveNewImportRec($data, $entity){
  $sqlSet = '';
    if (sizeof($data)>0) {
        foreach ($data as $key => $value) {
          $sqlSet .= " $key = '$value', ";
        }

        $sqlSet .= " bRetired = '0' ";

        $sqlStr ="INSERT INTO  $entity SET $sqlSet;";
        $query = $this->db->query($sqlStr);
        $recId = $this->db->insert_id();
        

        if ($entity=='fixedassets_assetlist') {
          $details  = array();
          $details['actionType'] = '11';
          $details['actionAssetId'] = $recId;
          $details['actionUser'] = USERID;
          $this->addAssetAction($details);
        }
    }
    else{

    }
    
    return true;




 }


public function getFormFields($entity){
	$sqlStr ="SELECT * FROM field_names WHERE parentTable = '$entity' ORDER BY setName ASC;";
 	$query = $this->db->query($sqlStr);
	return $query->result();
}


public function saveUpdateReport($recId){
 	$extraSql = ' SET ';
 	$i=0;

 	$fieldRecords = $this->getFormFields('fixedassets_reports');
 	foreach ($fieldRecords as $field) {
 		if ($field->isEditable) {
 			$fieldpostData = $this->input->post($field->initialName);
 			if ($fieldpostData!='' && $fieldpostData!='0000-00-00') {
 			
			 	$extraSql .= $field->initialName." = '".$fieldpostData."',";
			 		
		 	}
 		}
 		else if(!$field->isEditable && $field->initialName=='reportUser' && $recId==0){
 				$extraSql .= $field->initialName." = '".USERID."',";
 		}

 		else if(!$field->isEditable && $field->initialName=='dteCreated' && $recId==0){
 				$extraSql .= $field->initialName." = CURDATE(),";
 		}  		
 	$i++;
 	}
 	$extraSql .= "bRetired='0'";

 	if ($recId == '0') {
    $reportId = genrandomstrid(11);
    $extraSql .= ", reportId='$reportId'";
	 	$sqlStr ="INSERT INTO  fixedassets_reports  
	 				".$extraSql.";";
	 	$query = $this->db->query($sqlStr);
	 	return $reportId; 		
 	}


 	else if ($recId!= '0') {
	 	$sqlStr ="UPDATE  fixedassets_reports 
	 				".$extraSql." WHERE 
	 					reportId = '".$recId."';";
	 				
	 	$query = $this->db->query($sqlStr);
	 	return $recId;
 	}



 }

 public function getRecordDetails($parentTable, $pkCol, $recId){
 	$sqlStr ="SELECT * FROM $parentTable WHERE $pkCol = '$recId' LIMIT 0,1;";
 	$query = $this->db->query($sqlStr);
	return $query->result();
 }

  public function insertRemoveReportField($repId){
  	$sqlStr ="SELECT * FROM fixedassets_report_fields WHERE reportId = '$repId';";
 	$query = $this->db->query($sqlStr);
	$savedFields = $query->result_array();

    $selectedFields = array();
  	$selectedFields = $this->input->post('fieldId');
  	$newSavedArr  = array();

  	if (sizeof($savedFields) == 0) {
  		for ($n=0; $n < sizeof($selectedFields) ; $n++) {
  			$insertField =  $selectedFields[$n];
  			$sqlStr ="INSERT INTO fixedassets_report_fields SET reportId = '$repId',  fieldId = '$insertField';";
 			$query = $this->db->query($sqlStr);
  		}
  	}
  	else{
  		//build new array
  		
  		for ($k=0; $k < sizeof($savedFields); $k++) { 
  			$newSavedArr[$k] = $savedFields[$k]['fieldId'];
  		}


  		//compare selected fields to saved fields
  		for ($i=0; $i < sizeof($selectedFields); $i++) { 
  			if (in_array($selectedFields[$i], $newSavedArr)) {
  				//do nothing if saved field is in saved fields
  			}
  			else{
  				$insertField = $selectedFields[$i];
  				$sqlStr ="INSERT INTO fixedassets_report_fields SET reportId = '$repId', fieldId = '$insertField';";
 				$query = $this->db->query($sqlStr);
  			}
  		} 

  		//compare saved fields to selected fields
  		for ($m=0; $m < sizeof($newSavedArr); $m++) { 
  			if (in_array($newSavedArr[$m], $selectedFields)) {
  				//do nothing if saved field is in saved fields
  			}
  			else{
  				$deleteField = $newSavedArr[$m];
  				$sqlStr ="DELETE FROM fixedassets_report_fields WHERE reportId = '$repId' AND fieldId = '$deleteField';";
 				$query = $this->db->query($sqlStr);
  			}
  		} 


  	}  	

  	return true;
 	
 }

 public function getRecords($table, $tableColumn="", $uniqueData=""){
 	if ($tableColumn!="") {
 		$sqlStr ="SELECT * FROM $table WHERE $tableColumn = '$uniqueData';";
	 	$query = $this->db->query($sqlStr);
		return $query->result();
 	}
 }

 public function getCustomReportFields($reportId){
  
    $sqlStr ="SELECT 
                `fixedassets_reports`.`reportName` AS `reportName`,
                `fixedassets_reports`.`reportDesc` AS `reportDesc`,
                `fixedassets_report_fields`.`recId` AS `recId`,
                `fixedassets_report_fields`.`reportId` AS `reportId`,
                `fixedassets_report_fields`.`fieldId` AS `fieldId`,
                `fixedassets_report_fields`.`paramId` AS `paramId`,
                `fixedassets_report_fields`.`paramData` AS `paramData`,
                `fixedassets_report_fields`.`includeTotals` AS `includeTotals`,
                `field_names`.`initialName` AS `initialName`,
                `field_names`.`setName` AS `setName`,
                `field_names`.`dataType` AS `dataType`,
                `field_names`.`dataLength` AS `dataLength`,
                `field_names`.`isPK` AS `isPK`,
                `field_names`.`isFK` AS `isFK`,
                `field_names`.`tableFKname` AS `tableFKname`,
                `field_names`.`fkTableRecPK` AS `fkTableRecPK`,
                `field_names`.`fkTableRecName` AS `fkTableRecName`

               FROM 
                 `fixedassets_report_fields` AS `fixedassets_report_fields`,
                 `field_names` AS `field_names`,
                 `fixedassets_reports` AS `fixedassets_reports`


               WHERE
                  `fixedassets_report_fields`.`fieldId` = `field_names`.`fieldId`
                AND
                  `fixedassets_reports`.`reportId`  = `fixedassets_report_fields`.`reportId`
                AND 
                  `fixedassets_report_fields`.`reportId` = $reportId
                  ORDER BY `fixedassets_report_fields`.`recId`;";
    $query = $this->db->query($sqlStr);
    return $query->result();
  
 }


 public function saveUpdateDefinedReportFields($repId){
  $fields = $this->getCustomReportFields($repId);

  
  $params = $this->input->post('paramId');
  $paramsData = $this->input->post('paramData');

  $newArray = array();
  $newfieldsArray = array();
  $counter = 0;
  foreach ($fields as $field) {
    $fId = $field->fieldId;    
    $tIcludes = $this->input->post('includeTotals-'.$field->initialName);
    $sqlStr ="UPDATE fixedassets_report_fields SET paramId = '$params[$counter]', paramData = '$paramsData[$counter]', includeTotals = '$tIcludes' WHERE  fieldId= '$fId' AND reportId=$repId;";
      $query = $this->db->query($sqlStr);
    $counter++;
  }


  return true;

 }

public function getReportFields($repId){

  $sqlStr = "SELECT 
              `field_names`.`initialName` AS `initialName`,
              `field_names`.`dataType` AS `dataType`,
              `fixedassets_report_fields`.`paramData` AS `paramData`,
              `fixedassets_report_fields`.`includeTotals` AS `includeTotals`,
              `fixedassets_reports_data_params`.`paramName` AS `paramName`,
              `fixedassets_reports_data_params`.`paramSymbol` AS `paramSymbol`
              FROM 
              `field_names` AS `field_names`,
              `fixedassets_report_fields` AS  `fixedassets_report_fields`,
              `fixedassets_reports_data_params` AS  `fixedassets_reports_data_params`
              WHERE 
               `fixedassets_report_fields`.`reportId` = $repId
              AND
                `fixedassets_report_fields`.`fieldId` = `field_names`.`fieldId`
              AND 
                `fixedassets_report_fields`.`paramId` =  `fixedassets_reports_data_params`.`paramId`;";
  $query = $this->db->query($sqlStr);
  return $query->result();
}


public function deleteReport($repId){
  $sqlStr = "DELETE FROM fixedassets_reports WHERE reportId=$repId;";
  $query = $this->db->query($sqlStr);

  $sqlStr = "DELETE FROM fixedassets_report_fields WHERE reportId=$repId;";
  $query = $this->db->query($sqlStr);

  return true;


}

public function getfixedassets_assetlistFormFields(){
  $sqlStr ="SELECT * FROM field_names WHERE parentTable = 'fixedassets_assetlist' AND NOT isPK;";
  $query = $this->db->query($sqlStr);
  return $query->result();

}
public function getfixedassets_assetlistAppFormFields(){
  $sqlStr ="SELECT * FROM field_names WHERE parentTable = 'fixedassets_assetlist' AND isAppData AND NOT isPK;";
  $query = $this->db->query($sqlStr);
  return $query->result();

}

public function saveUpdateAsset($recId){
  $extraSql = ' SET ';
  $i=0;
  $newRecId = $recId;
  $oldRecord = array();
  $newRecord = array();
  $fieldRecords = $this->getfixedassets_assetlistFormFields();
  foreach ($fieldRecords as $field) {
    $fieldpostData = $this->input->post($field->initialName);

    if ($fieldpostData!='' && $fieldpostData!='0000-00-00') {      
      $extraSql .= $field->initialName." = '".$fieldpostData."',";      
    }    
    
  $i++;
  }

  $extraSql .= "bRetired='0'";


  if ($recId==0) {
    $sqlStr ="INSERT INTO  fixedassets_assetlist  
          ".$extraSql.";";
    $query = $this->db->query($sqlStr);
    $newRecId = $this->db->insert_id();   
  }
  else if ($recId!=0) {

    $existingRecDetails = $this->getRecords('fixedassets_assetlist', 'assetID', $recId); 

        foreach ($existingRecDetails as $existingRecDetail) {
          foreach ($fieldRecords as $field) {
            $column = $field->initialName;
            $oldRecord[$column] = $existingRecDetail->$column;
          }
        }

        
        $sqlStr ="UPDATE  fixedassets_assetlist 
              ".$extraSql." WHERE 
                assetID = '".$recId."';";
        $query = $this->db->query($sqlStr);


        $newRecDetails = $this->getRecords('fixedassets_assetlist', 'assetID', $recId);

        foreach ($newRecDetails as $newRecDetail) {
          foreach ($fieldRecords as $field) {
            $column = $field->initialName;
            $newRecord[$column] = $newRecDetail->$column;
          }
        }

        $this->probeRecordAssetChanges($recId, $oldRecord, $newRecord, $fieldRecords);

  }

  return $newRecId;

 }

public function probeRecordAssetChanges($recId, $oldRecord, $newRecord, $fieldRecords){
  $fieldsChanged = array();
  $n = 0;
  // loop through all asset data fields
  foreach ($fieldRecords as $field) {
    //define array comparator key name
    $fieldInitialName = $field->initialName;

    //compare field values in probe arrays
    if ($newRecord[$fieldInitialName] == $oldRecord[$fieldInitialName]) {
      //do nothing if fields are equal
    }
    else {
      //else if different values in probe arrays, register in changed fields
      $fieldsChanged[$fieldInitialName] = $field->fieldId;
    }

    //increment n
    $n++;
  }


  foreach ($fieldsChanged as $key => $value) { 
    foreach ($fieldRecords as $field) {
      $fieldInitialName = $field->initialName;
      if ($field->fieldId == $value) {
          if ($key == 'assignedTo') {
              $actionArr = array();
              $actionArr['actionType'] = '7';
              $actionArr['actionAssetId'] = $recId;              
              $actionArr['actionUser'] = USERID;
              $actionArr['parentRecordType'] = 'assignedTo';
              $actionArr['parentRecordId'] = $oldRecord[$fieldInitialName];
              $actionArr['toRecordType'] = 'assignedTo';
              $actionArr['toRecordId'] = $newRecord[$fieldInitialName];
              $this->addAssetAction($actionArr);
          }
          else if($field->initialName == 'assetPrimLoc'){
              $actionArr = array();
              $actionArr['actionType'] = '8';
              $actionArr['actionAssetId'] = $recId;              
              $actionArr['actionUser'] = USERID;
              $actionArr['parentRecordType'] = 'assetPrimLoc';
              $actionArr['parentRecordId'] = $oldRecord[$fieldInitialName];
              $actionArr['toRecordType'] = 'assetPrimLoc';
              $actionArr['toRecordId'] = $newRecord[$fieldInitialName];
              $this->addAssetAction($actionArr);

          }

          else if($field->initialName == 'assetSecLoc'){
              $actionArr = array();
              $actionArr['actionType'] = '8';
              $actionArr['actionAssetId'] = $recId;              
              $actionArr['actionUser'] = USERID;
              $actionArr['parentRecordType'] = 'assetSecLoc';
              $actionArr['parentRecordId'] = $oldRecord[$fieldInitialName];
              $actionArr['toRecordType'] = 'assetSecLoc';
              $actionArr['toRecordId'] = $newRecord[$fieldInitialName];
              $this->addAssetAction($actionArr);

          }

          else if($field->initialName == 'assetStatus'){
            $actionArr = array();
              $actionArr['actionType'] = '4';
              $actionArr['actionAssetId'] = $recId;              
              $actionArr['actionUser'] = USERID;
              $actionArr['parentRecordType'] = 'assetStatus';
              $actionArr['parentRecordId'] = $oldRecord[$fieldInitialName];
              $actionArr['toRecordType'] = 'assetStatus';
              $actionArr['toRecordId'] = $newRecord[$fieldInitialName];
              $this->addAssetAction($actionArr);
          }
      }
    }
  }

return true;

}

public function checkout($recId){
  $dtecheckedOut = $this->input->post('dtecheckedOut');
  $dueDteCheckout = $this->input->post('dueDteCheckout');
  $checkoutReason = $this->input->post('checkoutReason');
  $checkedOutTo = $this->input->post('checkedOutTo');
  $sqlStr ="UPDATE fixedassets_assetlist SET 
  checkedOut=1, 
  dtecheckedOut='$dtecheckedOut', 
  dueDteCheckout='$dueDteCheckout', 
  checkoutReason = '$checkoutReason', 
  checkedOutTo = '$checkedOutTo'  
  WHERE assetID=$recId ;";
  $query = $this->db->query($sqlStr);
   $actionArr = array();
              $actionArr['actionType'] = '10';
              $actionArr['actionAssetId'] = $recId;              
              $actionArr['actionUser'] = USERID;
              $actionArr['toRecordType'] = 'employeelist';
              $actionArr['toRecordId'] = $checkedOutTo;
              $actionArr['toRecordDataCol'] = 'empID';
   $this->addAssetAction($actionArr);
  
     return true;
}




public function addAssetAction($details){
  $setSQL = '';
  $lastIndex = sizeof($details)-1;
  $seclastIndex = sizeof($details)-2;
  $i = 0;
  $setSQL .= 'actionDate = CURDATE(),';
  foreach ($details as $key => $value) {
    if ($i < $lastIndex) {
      $setSQL .= $key.' = "'.$value.'",';
    }
    else if ($i = $lastIndex){
      $setSQL .= $key.' = "'.$value.'"';
    }
    $i++;
  }

  $sqlStr = "INSERT INTO fixedassets_assetactions  SET $setSQL;";
  $query = $this->db->query($sqlStr);

  return true;

}


public function androidSaveUpdateAsset($recId){
  $extraSql = ' SET ';
  $i=0;
  $newRecId = $recId;
  $oldRecord = array();
  $newRecord = array();
  $fieldRecords = $this->getfixedassets_assetlistAppFormFields();


  foreach ($fieldRecords as $field) {
    $fieldpostData = $this->input->post($field->initialName, true);
    $fieldpostData = trim($fieldpostData);
    if (strlen($fieldpostData)>0) {
      if ($field->isFK) {
        if ($field->initialName != 'assignedTo' && $field->initialName != 'assetSecLoc') {
          if ($fieldpostData!='' && $fieldpostData!='0000-00-00') { 
            $dataId = $this->datalib->dataExists($field->tableFKname, $field->fkTableRecName, $fieldpostData, $field->fkTableRecPK,  true);            
            $extraSql .= $field->initialName." = '".$dataId."',";      
          }  
        }
        else{
          if ($field->initialName == 'assignedTo') {
            if (trim($fieldpostData)!='' && $fieldpostData!='0000-00-00') { 
              $empDetails = trim($fieldpostData);
              $parseArray = explode(" ", $empDetails);
              $dataId = $this->datalib->dataExistsEmployee($parseArray, true);
              $extraSql .= $field->initialName." = '".$dataId."',"; 
            }
          }
          else{
            if (trim($fieldpostData)!='' && $fieldpostData!='0000-00-00') {
              $parentId = $this->datalib->dataExists('primaryloc', 'primlocIdentifier', $_POST['assetPrimLoc'], 'primlocID', true);
              $childId = $this->datalib->dataExistsSecondaryLocation($parentId, $fieldpostData, true);
              $extraSql .= $field->initialName." = '".$childId."',"; 
            }

          }
        }
      }
      else{
        if ($fieldpostData!='' && $fieldpostData!='0000-00-00') {      
          $extraSql .= $field->initialName." = '".$fieldpostData."',";      
        }   
      }
    }
      
     
    
  $i++;
  }

  $extraSql .= "bRetired='0'";


  if ($recId==0) {
    $sqlStr ="INSERT INTO  fixedassets_assetlist  
          ".$extraSql.";";
    $query = $this->db->query($sqlStr);
    $newRecId = $this->db->insert_id();
    $actionArray = array();
          $actionArray['actionType'] = '11';
          $actionArray['actionAssetId'] = $newRecId;
          $actionArray['actionUser'] = '1';
          $actionArray['actionDate'] = date('Y-m-d');
          $actionArray['actionDteCompleted'] = date('Y-m-d');

          //insert primary location change action
          $this->datalib->autoaddassetaction($newRecId, $actionArray);   
  }
  else if ($recId!=0) {

    $existingRecDetails = $this->getRecords('fixedassets_assetlist', 'assetID', $recId); 

        foreach ($existingRecDetails as $existingRecDetail) {
          foreach ($fieldRecords as $field) {
            $column = $field->initialName;
            $oldRecord[$column] = $existingRecDetail->$column;
          }
        }

        
        $sqlStr ="UPDATE  fixedassets_assetlist 
              ".$extraSql." WHERE 
                assetID = '".$recId."';";
        $query = $this->db->query($sqlStr);


        $newRecDetails = $this->getRecords('fixedassets_assetlist', 'assetID', $recId);

        foreach ($newRecDetails as $newRecDetail) {
          foreach ($fieldRecords as $field) {
            $column = $field->initialName;
            $newRecord[$column] = $newRecDetail->$column;
          }
        }

        $this->probeRecordAssetChanges($recId, $oldRecord, $newRecord, $fieldRecords);

  }

  return $newRecId;

 }



 public function saveUpdateImportRec($data, $entity){
    $oldRecord = array();
    $newRecord = array();
    if (sizeof($data)>0) {
      $recId = $this->datalib->dataExists('fixedassets_assetlist', 'assetCode', $data['assetCode'], 'assetID', false);
      if ($recId == 0) {
        $this->db->set($data);
        $this->db->insert($entity);
        if ($entity=='fixedassets_assetlist') {
          $newId = $this->db->insert_id();
          $actionArray = array();
          $actionArray['actionType'] = '11';
          $actionArray['actionAssetId'] = $newId;
          $actionArray['actionUser'] = USERID;
          $actionArray['actionDate'] = date('Y-m-d');
          $this->datalib->autoaddassetaction($newId, $actionArray);
        }
      }
      else{
        $existingRecDetails = $this->getRecords('fixedassets_assetlist', 'assetID', $recId); 
        $fieldRecords = $this->getfixedassets_assetlistFormFields();
        foreach ($existingRecDetails as $existingRecDetail) {
          foreach ($fieldRecords as $field) {
            $column = $field->initialName;
            $oldRecord[$column] = $existingRecDetail->$column;
          }
        }
        $this->db->where('assetID', $recId);
        $this->db->update('fixedassets_assetlist',$data);

        $newRecDetails = $this->getRecords('fixedassets_assetlist', 'assetID', $recId);

        foreach ($newRecDetails as $newRecDetail) {
          foreach ($fieldRecords as $field) {
            $column = $field->initialName;
            $newRecord[$column] = $newRecDetail->$column;
          }
        }
        $this->probeRecordAssetChanges($recId, $oldRecord, $newRecord, $fieldRecords);
      }
      
    }
    
    
    return true;
 }

 public function saveUpdateProperties($datatype, $recId){
  if ($datatype=='category') {
    $catCodeNum = $this->input->post('catCodeNum');
    $catDescription = $this->input->post('catDescription');
    $catDepMethod = $this->input->post('catDepMethod');
    $catLifeInYears = $this->input->post('catLifeInYears');
    $sqlStr ="UPDATE fixedassets_categories SET 
     catCodeNum = '$catCodeNum',
     catDescription = '$catDescription',
     catDepMethod = '$catDepMethod',
     catLifeInYears = '$catLifeInYears'

    WHERE catId = '$recId';";
    $query = $this->db->query($sqlStr);

    $sqlStr2 ="UPDATE fixedassets_assetlist SET 
     deprMethod = '$catDepMethod',
     assetLYears = '$catLifeInYears'

    WHERE assetCat = '$recId';";
    $query2 = $this->db->query($sqlStr2);
    return true;
  }




 }


 public function saveUpdateSecondaryRec($data, $recId='0', $table, $pkColumn){
    $sqlExtra = '';
    $index = 0;
    $datasize = sizeof($data);
    $lastindex = $datasize - 1;
    foreach ($data as $key => $value) {
      if ($index < $lastindex) {
        $sqlExtra .= " ".$key." = '".$value."', ";
      }
      else{
        $sqlExtra .= " ".$key." = '".$value."' ";
      }
      $index++;
    }



    if ($recId=='0') {
      $sqlStr ="INSERT INTO $table SET $sqlExtra;";
      $query = $this->db->query($sqlStr);
      $recordId = $this->db->insert_id();

    }
    else{
      $sqlStr ="UPDATE $table SET $sqlExtra WHERE $pkColumn = $recId;";
      $query = $this->db->query($sqlStr);
      $recordId = $recId;
    }
    return $recordId;


 }





 public function deletesecondaryrecord($table, $pkColumn, $recId){
    $sqlStr ="DELETE FROM $table  WHERE $pkColumn = $recId;";
    $query = $this->db->query($sqlStr);
    return true;
 }

 public function addeditnotebookitem($recId, $noteId, $data){
    $sqlExtra = '';
    $index = 0;
    $datasize = sizeof($data);
    $userid = USERID;
    $lastindex = $datasize - 1;
    foreach ($data as $key => $value) {
      if ($index < $lastindex) {
        $sqlExtra .= " ".$key." = '".$value."', ";
      }
      else{
        $sqlExtra .= " ".$key." = '".$value."', ";
      }
      $index++;
    }
    $sqlExtra .= " actionUser = $userid ";

    if ($noteId=='0') {
      $sqlStr ="INSERT INTO fixedassets_assetactions SET $sqlExtra ;";
      $query = $this->db->query($sqlStr);
      $recordId = $this->db->insert_id();

    }
    else{
      $sqlStr ="UPDATE fixedassets_assetactions SET $sqlExtra WHERE actionId = $noteId;";
      $query = $this->db->query($sqlStr);
      $recordId = $recId;
    }
    return $recordId;



 }

  public function deletenotebookitem($noteId){
    $sqlStr ="DELETE FROM  fixedassets_assetactions WHERE actionId = $noteId;";
    $query = $this->db->query($sqlStr);
    return true;

  }

  public function tempdeleteassetrecord($recId){
    $sqlStr ="SELECT * FROM fixedassets_assetlist WHERE assetID = $recId;";
    $query = $this->db->query($sqlStr);
    $results = $query->result();
    if(sizeof($results)>0){
      $record = $results[0];
      if ($record->assetPrimLoc == '3') {
        $sqlStr ="UPDATE fixedassets_assetlist SET bRetired = '1' WHERE assetID = $recId;";
      }
      else{
        $sqlStr ="UPDATE fixedassets_assetlist SET assetPrimLoc = '3', assetSecLoc = NULL WHERE assetID = $recId;";
      }
      $query = $this->db->query($sqlStr);
    }
    
    
    return true;

  }


  public function getlinkchildren($recId){
    $sqlStr ="SELECT * FROM fixedassets_linkedassets WHERE parentId = $recId;";
    $query = $this->db->query($sqlStr);
    return $query->result();
  }

  public function getlinkparent($recId){
    $sqlStr ="SELECT * FROM fixedassets_linkedassets WHERE childId = $recId;";
    $query = $this->db->query($sqlStr);
    return $query->result();    
  }

  public function linkexists($linktype, $recId, $linkrecId){
    if ($linktype != '' && $recId != '' && $linkrecId != '') {
      if ($linktype == 'parent') {
            $sqlStr ="SELECT * FROM fixedassets_linkedassets WHERE childId = ".prepsqlstringvar($recId)." AND parentId = ".prepsqlstringvar($linkrecId).";";
        }
        else {
            $sqlStr ="SELECT * FROM fixedassets_linkedassets WHERE parentId = ".prepsqlstringvar($recId)." AND childId = ".prepsqlstringvar($linkrecId).";";
        }
      
        $query = $this->db->query($sqlStr);
        $existinglinks = $query->result();
        if (sizeof($existinglinks)>0) {
          return TRUE;
        }
        else{
          return FALSE;
        }
        
    }
    else{
      return FALSE;
    }
  }



  public function addlink($linktype, $recId, $linkrecId){
    if ($linktype != '' && $recId != '' && $linkrecId != '') {
      if ($linktype == 'parent') {
            $sqlStr ="INSERT INTO fixedassets_linkedassets SET childId = ".prepsqlstringvar($recId).", parentId = ".prepsqlstringvar($linkrecId).";";
        }
        else {
            $sqlStr ="INSERT INTO fixedassets_linkedassets SET parentId = ".prepsqlstringvar($recId).", childId = ".prepsqlstringvar($linkrecId).";";
        }
      
        $query = $this->db->query($sqlStr);
        return $this->db->insert_id();
    }
    else{
      return FALSE;
    }
  }

  public function removelink($linkId){
      $sqlStr ="DELETE FROM fixedassets_linkedassets WHERE linkId = ".prepsqlstringvar($linkId).";";
      $query = $this->db->query($sqlStr);
      return TRUE;

  }







}