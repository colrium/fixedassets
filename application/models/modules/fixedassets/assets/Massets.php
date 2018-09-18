<?php
class Massets extends CI_Model{

 public function __construct()
        {
                parent::__construct();
        }




public function loadAssets($criteria){
	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function loadAllAssets(){
	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}

public function deleteRetired(){
$sqlStr ="DELETE FROM fixedassets_assetlist WHERE bRetired;";
	      $query = $this->db->query($sqlStr);
	 return true;

}

public function loadUsers(){
	$sqlStr ="SELECT * FROM users WHERE active;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}


public function loadAsset($recId){
	$sqlStr ="SELECT * FROM fixedassets_assetlist
				WHERE assetID = $recId LIMIT 0,1;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();	
}


public function loadPriLoc(){
	$sqlStr ="SELECT * FROM fixedassets_primaryloc WHERE NOT bRetired;";
	$query = $this->db->query($sqlStr);
	 return $query->result();

}

public function loadCategories(){
	$sqlStr ="SELECT * FROM fixedassets_categories WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}
public function loadBrands(){
	$sqlStr ="SELECT * FROM fixedassets_brands WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}
public function loadManufacturers(){
	$sqlStr ="SELECT * FROM fixedassets_manufacturers WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}

public function loadConditions(){
	$sqlStr ="SELECT * FROM fixedassets_conditions WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}
public function loadSections(){
	$sqlStr ="SELECT * FROM fixedassets_sections WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}


public function loadEmployees(){
	$sqlStr ="SELECT * FROM employeelist WHERE NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}

public function loadassetactions($recId){
	$sqlStr ="SELECT * FROM fixedassets_assetactions WHERE actionAssetId = $recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}
public function loadSecLoc($primId){
	$sqlStr ="SELECT * FROM fixedassets_secondaryloc WHERE primLocId = $primId AND NOT bRetired;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();

}

public function getActions($recId){
	$sqlStr ="SELECT 
	`fixedassets_assetactions`.`actionId` AS `actionId`,
	`fixedassets_asset_action_types`.`typeName` AS `actionType`,
	`fixedassets_assetactions`.`actionDate` AS `actionDate`,
	`users`.`last_name` AS `last_name`

	FROM 
	`fixedassets_assetactions` AS `fixedassets_assetactions`,
	`users` AS `users`,
	`fixedassets_asset_action_types` AS `fixedassets_asset_action_types` 

	WHERE 
	`users`.`id` = `fixedassets_assetactions`.`actionUser`
	AND 
	`fixedassets_asset_action_types`.`typeId` = `fixedassets_assetactions`.`actionType`
	 AND 
	 `fixedassets_assetactions`.`actionAssetId` = $recId;";
	      $query = $this->db->query($sqlStr);
	 return $query->result();
}

public function disposeAsset($recId){
	$disposalDate = $this->input->post('dteDisposed');
	$disposalReason = $this->input->post('reasonDispose');
	$disposalmethod = $this->input->post('methodDispose');
	$sqlStr ="UPDATE fixedassets_assetlist SET isDisposed=1, assetPrimLoc=2, dteDisposed='$disposalDate', disposeReason = '$disposalReason', disposalMethod = '$disposalmethod'  WHERE assetID=$recId ;";
	$query = $this->db->query($sqlStr);
	//add addaction
					$actionArray = array();
					$actionArray['actionType'] = '12';
					$actionArray['actionAssetId'] = $recId;
					$actionArray['actionUser'] = USERID;
					$actionArray['actionDate'] = date('Y-m-d');
					$this->datalib->autoaddassetaction($recId, $actionArray);
		 return true;

}

public function cloneAsset($recId){
	foreach ($this->loadAsset($recId) as $asset) {
 	
	 	$sqlStr ="INSERT INTO  fixedassets_assetlist 
	 				SET 

		 				assetValue		= '$asset->assetValue',
		 				replCost 		= '$asset->replCost',
		 				acCode 			= '$asset->acCode',
		 				assetMnfctr 	= '$asset->assetMnfctr',
		 				assetCode 		= '$asset->assetCode',
		 				assetItem 		= '$asset->assetItem',
		 				assetDesc 		= '$asset->assetDesc',
		 				assetCat 		= '$asset->assetCat',
		 				assetSctn 		= '$asset->assetSctn',
		 				assetCost 		= '$asset->assetCost',
		 				assetCTax1 		= '$asset->assetCTax1',
		 				assetCTax2 		= '$asset->assetCTax2',
		 				totalCost 		= '$asset->totalCost',
		 				dtePurchased 	= '$asset->dtePurchased',
		 				lpoNumber 		= '$asset->lpoNumber',
		 				assetDealer 	= '$asset->assetDealer',
		 				serialNum 		= '$asset->serialNum',
		 				assetPrimLoc 	= '$asset->assetPrimLoc',
		 				assetSecLoc 	= '$asset->assetSecLoc',
		 				assetTerLoc 	= '$asset->assetTerLoc',
		 				quantity 		= '$asset->quantity',
		 				assignedTo 		= '$asset->assignedTo',
		 				assetCondition  = '$asset->assetCondition',
		 				dtePutIntoService = '$asset->dtePutIntoService',
		 				deprMethod 		= '$asset->deprMethod',
		 				salvageVal 		= '$asset->salvageVal',
		 				assetLYears 	= '$asset->assetLYears',
		 				assetStatus 	= '$asset->assetStatus',
		 				lasDteAudit 	= '$asset->lasDteAudit',
		 				auditStatus 	= '$asset->auditStatus',
		 				dteSold			= '$asset->dteSold',
		 				soldTo 			= '$asset->soldTo',
		 				askingPrice 	= '$asset->askingPrice',
		 				comments 		= '$asset->comments',
		 				numberMade 		= '$asset->numberMade',
		 				color 			= '$asset->color',
		 				madeOf 			= '$asset->madeOf',
		 				size 			= '$asset->size',
		 				shape 			= '$asset->shape',
		 				year 			= '$asset->year',
		 				assetImage 		= '$asset->assetImage',
		 				lastAuditedBy 	= '$asset->lastAuditedBy',
		 				insuredBy 		= '$asset->insuredBy',
		 				insurePolicy 	= '$asset->insurePolicy',
		 				insurancedteExp = '$asset->insurancedteExp',
		 				leaseBegin	= '$asset->leaseBegin',
		 				leaseEnd 	= '$asset->leaseEnd',
		 				leaseDesc 	= '$asset->leaseDesc',
		 				bizUse 		= '$asset->bizUse';";
	 	$query = $this->db->query($sqlStr);
	 	return true; 		
 	
	}


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
	//add addaction
					$actionArray = array();
					$actionArray['actionType'] = '13';
					$actionArray['actionAssetId'] = $recId;
					$actionArray['actionUser'] = USERID;
					$actionArray['actionDueDate'] = $dueDteCheckout;
					$actionArray['toRecordType'] = 'checkedOutTo';
					$actionArray['toRecordId'] = $checkedOutTo;
					$actionArray['actionDteCompleted'] = $dtecheckedOut;
					$actionArray['actionDate'] = date('Y-m-d');
					$this->datalib->autoaddassetaction($recId, $actionArray);
	return true;

}

public function checkin($recId, $checkindate){
	
	$sqlStr ="UPDATE fixedassets_assetlist SET 
	checkedOut=0, 
	checkedIn=1, 
	dteCheckedin='$checkindate'  
	WHERE assetID=$recId ;";
	$query = $this->db->query($sqlStr);
	//add addaction
					$actionArray = array();
					$actionArray['actionType'] = '14';
					$actionArray['actionAssetId'] = $recId;
					$actionArray['actionUser'] = USERID;
					$actionArray['actionDate'] = date('Y-m-d');
					$actionArray['actionDteCompleted'] = $checkindate;
					$this->datalib->autoaddassetaction($recId, $actionArray);	
		 return true;

}


public function deleteAsset($recId){

	$sqlStr ="UPDATE fixedassets_assetlist SET  assetPrimLoc=3, bRetired = 1  WHERE assetID=$recId ;";
	$query = $this->db->query($sqlStr);
	$this->addAssetAction($recId, 'delete', USERID);
		 return true;

}

public function addAssetAction($recId, $actionType, $actionUser){
	$sqlStr ="INSERT INTO  fixedassets_assetactions
	 				SET 
	 				actionType = '$actionType',
	 				assetId = $recId,
	 				actionUser = $actionUser,
	 				actionDate = CURDATE();";
	$query = $this->db->query($sqlStr);
	 return true;

}

public function getFormFields($entity){
	$sqlStr ="SELECT * FROM field_names WHERE parentTable = '$entity' ORDER BY setName ASC;";
 	$query = $this->db->query($sqlStr);
	return $query->result();
}

public function ajaxAssetsList($criteria, $criteriaId){
	if ($criteria == 'primarylocation') {
		$keyword = 'assetPrimLoc';
		if ($criteriaId ==3) {
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE $keyword=$criteriaId AND NOT bRetired;";
		}
		elseif ($criteriaId ==2) {
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE $keyword=$criteriaId AND NOT bRetired;";
		}
		else{
			$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE $keyword=$criteriaId AND NOT bRetired AND NOT isDisposed;";
		}

	}

	else if ($criteria == 'seclocation') {
		$keyword = 'assetSecLoc';
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE $keyword=$criteriaId AND assetPrimLoc != '2' AND assetPrimLoc != '3' AND NOT bRetired;";
	}

	else if ($criteria == 'category') {
		$keyword = 'assetCat';
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE $keyword=$criteriaId AND assetPrimLoc != '2' AND assetPrimLoc != '3' AND NOT bRetired;";
	}

	else if ($criteria == 'all') {
		$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE NOT bRetired AND assetPrimLoc!='2' AND assetPrimLoc!='3' AND NOT bRetired;";
	}

	else if ($criteria == 'search') {
		$sqlStr = "SELECT * FROM fixedassets_assetlist WHERE ";
		$i=0;
		foreach ($this->getFormFields('fixedassets_assetlist') as $field) {
			if ($i==0) {
				$sqlStr .= " ".$field->initialName." LIKE '%".$criteriaId."%' ";
			}
			else{
				$sqlStr .= " OR ".$field->initialName." LIKE '%".$criteriaId."%' ";
			}
			$i++;
			
		}
	}

	else if ($criteria != 'all' && $criteria != 'search' && $criteria != 'category' && $criteria != 'seclocation' && $criteria != 'primarylocation') {
		$sqlStr = "SELECT * FROM fixedassets_assetlist WHERE $criteria=$criteriaId AND NOT bRetired AND assetPrimLoc != '2' AND assetPrimLoc != '3';";
	}
	
	if ($sqlStr != '') {
		$query = $this->db->query($sqlStr);
		 return $query->result();
	}
	
	


}

public function ajaxAssetsListJSON($criteria, $criteriaId){
	$recordsfields = $this->fieldnames->getTableFields('fixedassets_assetlist');
	$extraWhereSQL = '';
	$extraFROMSQL = ' `fixedassets_assetlist` AS `fixedassets_assetlist` ';
	if ($criteria == 'primarylocation') {
		$keyword = 'assetPrimLoc';
		if ($criteriaId ==3) {
			$extraWhereSQL =" AND `fixedassets_assetlist`.`$keyword` = ".prepsqlstringvar($criteriaId)." ";
		}
		elseif ($criteriaId ==2) {
			$extraWhereSQL =" AND `fixedassets_assetlist`.`$keyword` = ".prepsqlstringvar($criteriaId)." ";
		}
		else{
			$extraWhereSQL =" AND `fixedassets_assetlist`.`$keyword` = ".prepsqlstringvar($criteriaId)." AND NOT `fixedassets_assetlist`.`isDisposed` ";
		}

	}

	else if ($criteria == 'seclocation') {
		$keyword = 'assetSecLoc';
		$extraWhereSQL =" AND `fixedassets_assetlist`.`$keyword` = ".prepsqlstringvar($criteriaId)." AND `fixedassets_assetlist`.`assetPrimLoc` != '2' AND `fixedassets_assetlist`.`assetPrimLoc` != '3' ";
	}

	else if ($criteria == 'category') {
		$keyword = 'assetCat';
		$extraWhereSQL =" AND `fixedassets_assetlist`.`$keyword` = ".prepsqlstringvar($criteriaId)." AND `fixedassets_assetlist`.`assetPrimLoc` != '2' AND `fixedassets_assetlist`.`assetPrimLoc` != '3' ";
	}

	else if ($criteria == 'all') {
		$keyword = $criteria;
		$extraWhereSQL =" AND assetPrimLoc!='2' AND assetPrimLoc!='3' ";
	}

	else if ($criteria == 'search') {
		$keyword = $criteria;
		$i=0;
		$last_index = sizeof($recordsfields)-1;
		foreach ($recordsfields as $key => $field) {
			if($field->isFK=='1'){
				if ($i == $last_index) {
					$extraFROMSQL = ' '.$value->parentTable.' AS '.$value->parentTable.' ';
				}
				else{
					$extraFROMSQL = ' '.$value->parentTable.' AS '.$value->parentTable.', ';
				}
				
			}
			else{
				if ($i==0) {
					$extraWhereSQL .= " AND `fixedassets_assetlist`.`".$field->initialName."` LIKE '%".$criteriaId."%' ";
				}
				else{
					$extraWhereSQL .= " OR `fixedassets_assetlist`.`".$field->initialName."` LIKE '%".$criteriaId."%' ";
				}
			}
				
			$i++;
			
		}
	}

	else if ($criteria != 'all' && $criteria != 'search' && $criteria != 'category' && $criteria != 'seclocation' && $criteria != 'primarylocation') {
		$keyword = $criteria;
		$extraWhereSQL =" AND `fixedassets_assetlist`.`$criteria` = ".prepsqlstringvar($criteriaId)." AND `fixedassets_assetlist`.`assetPrimLoc` != '2' AND `fixedassets_assetlist`.`assetPrimLoc` != '3' ";
	}

	
	
	$returnArr = array();

	$selectSQL = "`fixedassets_assetlist`.`assetPrimLoc` AS `existince_status`,

(CASE `fixedassets_assetlist`.`assetPrimLoc` 
	WHEN 
		`fixedassets_assetlist`.`assetPrimLoc` IN (2,3) 
		THEN (
			CASE `fixedassets_assetlist`.`assetPrimLoc` 
				WHEN `fixedassets_assetlist`.`assetPrimLoc` = 2 
					THEN 'disposed' 
					ELSE 'deleted' 
			END) 
		ELSE (
			CASE `fixedassets_assetlist`.`checkedOut` 
				WHEN `fixedassets_assetlist`.`checkedOut` = 1 
					THEN 'Checked_out' 
					ELSE 'existing' 
		END) 
END) AS `existince_status`, ";


	foreach ($recordsfields as $key => $value) {
			if ($key < (sizeof($recordsfields)-1)) {
				if ($value->isFK=='1') {
					if($keyword == $value->initialName){
						$selectSQL .= ' (CASE  `'.$value->parentTable.'`.`'.$value->initialName.'` WHEN  '.$criteriaId.' THEN (SELECT `'.$value->fkTableRecName.'` FROM `'.$value->tableFKname.'` WHERE `'.$value->fkTableRecPK.'` = `'.$value->parentTable.'`.`'.$value->initialName.'` LIMIT 0,1) END) AS `'.$value->initialName.'`,  ';
					}
					else{
						$selectSQL .= ' (CASE  `'.$value->parentTable.'`.`'.$value->initialName.'` WHEN `'.$value->parentTable.'`.`'.$value->initialName.'` > 0 THEN (SELECT `'.$value->fkTableRecName.'` FROM `'.$value->tableFKname.'` WHERE `'.$value->fkTableRecPK.'` = `'.$value->parentTable.'`.`'.$value->initialName.'` LIMIT 0,1) END) AS `'.$value->initialName.'`,  ';
					}
					
				}
				else{
					$selectSQL .= ' `fixedassets_assetlist`.`'.$value->initialName.'` AS `'.$value->initialName.'`, ';
				}

			}
			else{
				if ($value->isFK=='1') {
					if($keyword == $value->initialName){
						$selectSQL .= ' (CASE  `'.$value->parentTable.'`.`'.$value->initialName.'` WHEN '.$criteriaId.' THEN (SELECT `'.$value->fkTableRecName.'` FROM `'.$value->tableFKname.'` WHERE `'.$value->fkTableRecPK.'` = `'.$value->parentTable.'`.`'.$value->initialName.'` LIMIT 0,1) END) AS `'.$value->initialName.'` ';
					}
					else{
						$selectSQL .= ' (CASE  `'.$value->parentTable.'`.`'.$value->initialName.'` WHEN `'.$value->parentTable.'`.`'.$value->initialName.'` > 0 THEN (SELECT `'.$value->fkTableRecName.'` FROM `'.$value->tableFKname.'` WHERE `'.$value->fkTableRecPK.'` = `'.$value->parentTable.'`.`'.$value->initialName.'` LIMIT 0,1) END) AS `'.$value->initialName.'`  ';
					}
					
				}
				else{
					$selectSQL .= ' `fixedassets_assetlist`.`'.$value->initialName.'` AS `'.$value->initialName.'`  ';
				}				
			}
		
	}

	


	$sqlStr ="SELECT ".$selectSQL." FROM ".$extraFROMSQL." WHERE NOT `fixedassets_assetlist`.`bRetired` ".$extraWhereSQL.";";

	if ($sqlStr != '') {
		$query = $this->db->query($sqlStr);
		 return $query->result_array();
	}
}

 public function loadAssetImage($assetId){

 	$sqlStr ="SELECT assetImage FROM fixedassets_assetlist WHERE assetID=$assetId;";
 	$query = $this->db->query($sqlStr);
	 

	 foreach ($query->result() as $asset) {
	 	return $asset->assetImage;
	 }
 }

 public function ifExisting($assetCode){
 	$sqlStr ="SELECT * FROM fixedassets_assetlist WHERE assetCode = '$assetCode';";
 	$query = $this->db->query($sqlStr);
	 if (sizeof($query->result())>0) {
	 	return true;
	 }

	 elseif (sizeof($query->result())==0) {
	 	return false;
	 }	 
 }

 public function getfixedassets_assetlistFormFields(){
	$sqlStr ="SELECT * FROM field_names WHERE parentTable = 'fixedassets_assetlist' AND NOT isPK;";
 	$query = $this->db->query($sqlStr);
	return $query->result();

}

 public function saveUpdate($recId){
 	$extraSql = ' SET ';
 	$i=0;
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
	 	return $this->db->insert_id(); 		
 	}


 	elseif ($recId!=0) {
	 	$sqlStr ="UPDATE  fixedassets_assetlist 
	 				".$extraSql." WHERE 
	 					assetID = '".$recId."';";
	 				
	 	$query = $this->db->query($sqlStr);
	 	return $recId;
 	}



 }


 public function saveOthers($recordType, $recId){

		 	if ($recordType == "employee") {
		 		if ($recId>0) {
		 			# code...
		 		}
		 		else{
			 		$empTtle = $this->input->post('empTtle');
			 		$empLName = $this->input->post('empLName');
			 		$empMName = $this->input->post('empMName');
			 		$empFName = $this->input->post('empFName');
			 		$empPos = $this->input->post('empPos');
			 		$empNumber = $this->input->post('empNumber');
			 		$empEmail = $this->input->post('empEmail');
			 		$empAddress = $this->input->post('empAddress');
			 		$empPhone = $this->input->post('empPhone');

	               $sqlStr ="INSERT INTO  employeelist 
		 				SET 

			 				empTtle		= '$empTtle',
			 				empLName		= '$empLName',
			 				empMName		= '$empMName',
			 				empFName		= '$empFName',
			 				empPos		= '$empPos',
			 				empNumber		= '$empNumber',
			 				empEmail		= '$empEmail',
			 				empAddress		= '$empAddress',
			 				empPhone 		= '$empPhone';";


	              }
          		}

              elseif ($recordType == "category") {
              	$catName = $this->input->post('catName');
              	$sqlStr ="INSERT INTO  fixedassets_categories 
	 				SET 

		 				catName 		= '$catName';";

               
              }

              elseif ($recordType == "status") {
              	$statusName = $this->input->post('statusName');
              	$sqlStr ="INSERT INTO  fixedassets_statuses 
	 				SET 

		 				statusName 		= '$statusName';";

               
              }

              elseif ($recordType == "manufacturer") {
              	$manName = $this->input->post('manName');
              	$sqlStr ="INSERT INTO  fixedassets_manufacturers 
	 				SET 

		 				manName		= '$manName';";
               
              }

              elseif ($recordType == "dealer") {
              	$dealerName = $this->input->post('dealerName');
              	$sqlStr ="INSERT INTO  fixedassets_dealers 
	 				SET 

		 				dealerName		= '$dealerName';";
   
              }


              elseif ($recordType == "brand") {
              	$brandName = $this->input->post('brandName');
              	$sqlStr ="INSERT INTO  fixedassets_brands 
	 				SET 

		 				brandName		= '$brandName';";
                
              }

              elseif ($recordType == "section") {
              	$sectionName = $this->input->post('sectionName');
              	$sqlStr ="INSERT INTO  fixedassets_sections 
	 				SET 

		 				sectionName		= '$sectionName';";
                
              }

              elseif ($recordType == "department") {
              	$primLocId = $this->input->post('primLocId');
              	$seclocIdentifier = $this->input->post('seclocIdentifier');
              	$sqlStr ="INSERT INTO  fixedassets_secondaryloc 
	 				SET 

		 				seclocIdentifier		= '$seclocIdentifier',
		 				primLocId 				= '$primLocId';";
                
              }

              elseif ($recordType == "location") {
              	$primlocIdentifier = $this->input->post('primlocIdentifier');
              	$sqlStr ="INSERT INTO  fixedassets_primaryloc 
	 				SET 

		 				primlocIdentifier	= '$primlocIdentifier';";
                
              }


           $query = $this->db->query($sqlStr);
	 	return true;

 }

 
public function moveCopyAsset($recId){
	$actionUser = USERID;
	$toPrimLoc = $this->input->post('toprimaryLoc');
	$toSecLoc = $this->input->post('tosecondaryLoc');
	$copyAsset = $this->input->post('copyAsset');

	$assetdetails = $this->datalib->loadrecordfromtable('fixedassets_assetlist', 'assetID', $recId);

	$currentPrimLoc = $assetdetails->assetPrimLoc;
	$currentSecLoc = $assetdetails->assetSecLoc;
	

	if ($copyAsset == '1') {

		$assetfields = $this->formfieldinput->getFormFields("fixedassets_assetlist");
		$sqlSet = " ";
		foreach ($assetfields as $field) {
			$fieldname = $field->initialName;

			if ($fieldname == 'assetPrimLoc') {
				$sqlSet .= $fieldname." = '".$toPrimLoc."', ";
			}
			else if ($fieldname == 'assetSecLoc') {
				$sqlSet .= $fieldname." = '".$toSecLoc."', ";
			}
			else if ($fieldname != 'bRetired') {
				$sqlSet .= $fieldname." = '".$assetdetails->$fieldname."', ";
			}
		}

		$sqlSet .= " bRetired = '0' ";

		$sqlStrCopy ="INSERT INTO  fixedassets_assetlist SET ".$sqlSet." WHERE assetID = $recId;";
	 	$queryCopy = $this->db->query($sqlStrCopy);

	 	$newrecId = $this->db->insert_id();

	 	$actionArray = array();
					$actionArray['actionType'] = '11';
					$actionArray['actionAssetId'] = $recId;
					$actionArray['actionUser'] = USERID;
					$actionArray['actionDate'] = date('Y-m-d');
					$actionArray['actionDteCompleted'] = date('Y-m-d');

					//insert primary location change action
					$this->datalib->autoaddassetaction($recId, $actionArray);
	}
	else{
		$sqlStrMove ="UPDATE  fixedassets_assetlist 
	 				SET 
	 					assetPrimLoc = '$toPrimLoc',
	 					assetSecLoc = '$toSecLoc'
	 				WHERE 
	 					assetID = $recId;
	 				";
	 	$queryMove = $this->db->query($sqlStrMove);


	 				$actionArray = array();
					$actionArray['actionType'] = '8';
					$actionArray['actionAssetId'] = $recId;
					$actionArray['actionDescription'] = 'Moved from  '.$this->fieldnames->getForeignKeyValue('assetPrimLoc', $currentPrimLoc, 'fixedassets_assetlist').' to '.$this->fieldnames->getForeignKeyValue('assetPrimLoc', $toPrimLoc, 'fixedassets_assetlist');
					$actionArray['actionUser'] = USERID;
					$actionArray['actionDate'] = date('Y-m-d');
					$actionArray['actionDteCompleted'] = date('Y-m-d');
					$actionArray['parentRecordType'] = 'assetPrimLoc';
					$actionArray['parentRecordId'] = $currentPrimLoc;
					$actionArray['toRecordType'] = 'assetPrimLoc';
					$actionArray['toRecordId'] = $toPrimLoc;

					//insert primary location change action
					$this->datalib->autoaddassetaction($recId, $actionArray);


					if ($currentSecLoc != '' || $toSecLoc != '') {
						$actionArray = array();
						$actionArray['actionType'] = '8';
						$actionArray['actionAssetId'] = $recId;
						$actionArray['actionDescription'] = 'Moved from  '.$this->fieldnames->getForeignKeyValue('assetSecLoc', $currentSecLoc, 'fixedassets_assetlist').' to '.$this->fieldnames->getForeignKeyValue('assetSecLoc', $toSecLoc, 'fixedassets_assetlist');
						$actionArray['actionUser'] = USERID;
						$actionArray['actionDate'] = date('Y-m-d');
						$actionArray['actionDteCompleted'] = date('Y-m-d');
						$actionArray['parentRecordType'] = 'assetSecLoc';
						$actionArray['parentRecordId'] = $currentSecLoc;
						$actionArray['toRecordType'] = 'assetSecLoc';
						$actionArray['toRecordId'] = $toSecLoc;

						//insert primary location
						$this->datalib->autoaddassetaction($recId, $actionArray);
					}
							

	 return true;

	}

}

 
 public function addAssetImage($recId, $new_name, $ext){
 	$imageName = $new_name."".$ext;
 	$sqlStr ="UPDATE  fixedassets_assetlist 
	 				SET 
	 					assetImage = '$imageName'
	 				WHERE 
	 					assetID = $recId;
	 				";
	 	$query = $this->db->query($sqlStr);
	 	return true;
 }

 public function addOtherAssetImage($recId, $new_name, $ext){
 	$imageName = $new_name."".$ext;
 	$actionUser = USERID;
 	$sqlStr ="INSERT INTO attachments 
	 				SET 
	 					assetId = '$recId',
	 					isImage = '1',
	 					dteAdded = CURDATE(),
	 					file_name = '$new_name',
	 					file_ext = '$ext',
	 					file_dir = 'catalog/attachments/images'	 				
	 				";
	 	$query = $this->db->query($sqlStr);
	 	return true;
 }

 public function addOtherAssetAttchmnt($recId, $new_name, $ext){
 	$actionUser = USERID;
 	$sqlStr ="INSERT INTO attachments 
	 				SET 
	 					assetId = '$recId',
	 					isImage = '0',
	 					dteAdded = CURDATE(),
	 					file_name = '$new_name',
	 					file_ext = '$ext',
	 					file_dir = 'catalog/attachments/others',
	 					added_by = '$actionUser'	 				
	 				";
	 	$query = $this->db->query($sqlStr);
	 	return true;
 }

public function addAndroidAsset(){
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
	$lastAuditedBy  = 1;

	if ($this->ifExists('statuses', 'statusName', $assetStatus)==0) {
 		$assetStatus = $this->createNewsecRecord('statuses', 'statusName', $assetStatus);
	 }
	 else{
	 	$assetStatus = $this->ifExists('statuses', 'statusName', $assetStatus);
	 }

	 if ($this->ifExists('primaryloc', 'primlocIdentifier', $assetPrimLoc)==0) {
 		$assetPrimLoc = $this->createNewsecRecord('primaryloc', 'primlocIdentifier', $assetPrimLoc);
	 }
	 else{
	 	$assetPrimLoc = $this->ifExists('primaryloc', 'primlocIdentifier', $assetPrimLoc);
	 }

	 if ($this->ifExists('conditions', 'condName', $assetCondtn)==0) {
 		$assetCondtn = $this->createNewsecRecord('conditions', 'condName', $assetCondtn);
	 }
	 else{
	 	$assetCondtn = $this->ifExists('conditions', 'condName', $assetCondtn);
	 }

	 if ($this->ifExists('employeelist', 'empLName', $assignedTo)==0) {
 		$assignedTo = $this->createNewsecRecord('employeelist', 'empLName', $assignedTo);
	 }
	 else{
	 	$assignedTo = $this->ifExists('employeelist', 'empLName', $assignedTo);
	 }

	 if ($this->ifExists('categories', 'catName', $assetCat)==0) {
 		$assetCat = $this->createNewsecRecord('categories', 'catName', $assetCat);
	 }
	 else{
	 	$assetCat = $this->ifExists('categories', 'catName', $assetCat);
	 }

	 if ($this->ifSecLocExists('secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc)==0) {
 		$assetPrimLoc = $this->createNewsecRecord('secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc);
	 }
	 else{
	 	$assetPrimLoc = $this->ifSecLocExists('secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc);
	 }

	 	$sqlStr ="INSERT INTO  fixedassets_assetlist 
	 				SET 
		 				assetItem 		= '$assetItem',
		 				assetCode 		= '$assetCode',		 				
		 				assetDesc 		= '$assetDesc',
		 				assetCat 		= '$assetCat',
		 				serialNum 		= '$serialNum',
		 				assetPrimLoc 	= '$assetPrimLoc',
		 				assetSecLoc 	= '$assetSecLoc',
		 				assetTerLoc 	= '$assetTerLoc',
		 				assetCondtn 	= '$assetCondtn',
		 				assignedTo 		= '$assignedTo',
		 				assetStatus 	= '$assetStatus',
		 				lasDteAudit 	= CURDATE(),
		 				auditStatus 	= '$auditStatus',
		 				assetImg		= '$assetImg',
		 				lastAuditedBy 	= '$lastAuditedBy';";
	 	$query = $this->db->query($sqlStr);
	 	return $this->db->insert_id(); 		





}

public function updateAndroidAsset($assetCode){
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
	$lastAuditedBy  = $_POST['lastAuditedBy'];

	if ($this->ifExists('fixedassets_statuses', 'statusName', $assetStatus)==0) {
 		$assetStatus = $this->createNewsecRecord('fixedassets_statuses', 'statusName', $assetStatus);
	 }
	 else{
	 	$assetStatus = $this->ifExists('fixedassets_statuses', 'statusName', $assetStatus);
	 }

	 if ($this->ifExists('fixedassets_primaryloc', 'primlocIdentifier', $assetPrimLoc)==0) {
 		$assetPrimLoc = $this->createNewsecRecord('fixedassets_primaryloc', 'primlocIdentifier', $assetPrimLoc);
	 }
	 else{
	 	$assetPrimLoc = $this->ifExists('fixedassets_primaryloc', 'primlocIdentifier', $assetPrimLoc);
	 }

	 if ($this->ifExists('fixedassets_conditions', 'condName', $assetCondtn)==0) {
 		$assetCondtn = $this->createNewsecRecord('fixedassets_conditions', 'condName', $assetCondtn);
	 }
	 else{
	 	$assetCondtn = $this->ifExists('fixedassets_conditions', 'condName', $assetCondtn);
	 }

	 if ($this->ifExists('employeelist', 'empLName', $assignedTo)==0) {
 		$assignedTo = $this->createNewsecRecord('employeelist', 'empLName', $assignedTo);
	 }
	 else{
	 	$assignedTo = $this->ifExists('employeelist', 'empLName', $assignedTo);
	 }

	 if ($this->ifExists('fixedassets_categories', 'catName', $assetCat)==0) {
 		$assetCat = $this->createNewsecRecord('fixedassets_categories', 'catName', $assetCat);
	 }
	 else{
	 	$assetCat = $this->ifExists('fixedassets_categories', 'catName', $assetCat);
	 }

	 if ($this->ifSecLocExists('fixedassets_secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc)==0) {
 		$assetPrimLoc = $this->createNewseclocRecord('fixedassets_secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc);
	 }
	 else{
	 	$assetPrimLoc = $this->ifSecLocExists('fixedassets_secondaryloc', 'seclocIdentifier', $assetSecLoc, 'primLocId', $assetPrimLoc);
	 }

	 	$sqlStr ="UPDATE  fixedassets_assetlist 
	 				SET 
		 				assetItem 		= '$assetItem',
		 				assetCode 		= '$assetCode',		 				
		 				assetDesc 		= '$assetDesc',
		 				assetCat 		= '$assetCat',
		 				serialNum 		= '$serialNum',
		 				assetPrimLoc 	= '$assetPrimLoc',
		 				assetSecLoc 	= '$assetSecLoc',
		 				assetTerLoc 	= '$assetTerLoc',
		 				assetCondtn 	= '$assetCondtn',
		 				assignedTo 		= '$assignedTo',
		 				assetStatus 	= '$assetStatus',
		 				lasDteAudit 	= CURDATE(),
		 				auditStatus 	= '$auditStatus',
		 				assetImg		= '$assetImg',
		 				lastAuditedBy 	= '$lastAuditedBy'
		 			WHERE assetCode = '$assetCode';";
	 	$query = $this->db->query($sqlStr);
	 	return $this->db->insert_id();


}


public function ifExists($dbtable, $column, $dataRec){

		$sqlStr ="SELECT DISTINCT * FROM $dbtable WHERE $column = '$dataRec';";
	
	      $query = $this->db->query($sqlStr);

	 if (sizeof($query->result())>0) {
	 	foreach ($query->result() as $result) {
	 		if ($dbtable=='fixedassets_brands') {
	 			return $result->brandId;
	 		}
	 		elseif ($dbtable=='fixedassets_categories') {
	 			return $result->catId;
	 		}

	 		elseif ($dbtable=='fixedassets_conditions') {
	 			return $result->condId;
	 		}

	 		elseif ($dbtable=='fixedassets_employees') {
	 			return $result->empID;
	 		}

	 		elseif ($dbtable=='fixedassets_manufacturers') {
	 			return $result->manId;
	 		}

	 		elseif ($dbtable=='fixedassets_models') {
	 			return $result->modelId;
	 		}

	 		elseif ($dbtable=='fixedassets_sections') {
	 			return $result->sectionId;
	 		}
	 		elseif ($dbtable=='fixedassets_statuses') {
	 			return $result->statusId;
	 		}
	 		elseif ($dbtable=='fixedassets_primaryloc') {
	 			return $result->primlocID;
	 		}
	 		elseif ($dbtable=='fixedassets_secondaryloc') {
	 			return $result->seclocID;
	 		}

	 	}
	 }
	 else{
	 	return 0;
	 }


}


public function ifSecLocExists($dbtable, $column, $dataRec, $parentRecCol, $parentRecId){
	$sqlStr ="SELECT DISTINCT * FROM $dbtable WHERE $column='$dataRec' AND $parentRecCol=$parentRecId;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}

public function dashboardfields(){
	$sqlStr ="SELECT * FROM field_names WHERE parentTable = 'fixedassets_assetlist' AND isDashShown;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}

public function createNewsecRecord($dbtable, $column, $dataRec){
	$sqlStr ="INSERT INTO $dbtable SET $column='$dataRec';";
	$query = $this->db->query($sqlStr);
	return $this->db->insert_id();

}

public function createNewseclocRecord($dbtable, $column, $dataRec, $parentRecCol, $parentRecId){
	$sqlStr ="INSERT INTO $dbtable SET $column='$dataRec', $parentRecCol = $parentRecId;";
	$query = $this->db->query($sqlStr);
	return $this->db->insert_id();

}



public function deleteRecord($recType, $recId){

	return true;

}

public function loadAssetImages($recId){
	$sqlStr ="SELECT DISTINCT * FROM attachments WHERE assetId='$recId' AND isImage;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}

public function loadAssetAttachments($recId){
	$sqlStr ="SELECT * FROM attachments WHERE assetId='$recId' AND NOT isImage;";
	$query = $this->db->query($sqlStr);
	return $query->result();


}

public function ajaxloadstatuses(){
	$sqlStr ="SELECT * FROM statuses;";
	$query = $this->db->query($sqlStr);
	return $query->result();
}

public function loadAssignEmployees(){
	$sqlStr ="SELECT DISTINCT
	`employeelist`.`empID` AS `empID`,
	`employeelist`.`empName` AS `empName`
	

	FROM 
	`employeelist` AS `employeelist`,
	`fixedassets_assetlist` AS `fixedassets_assetlist` 

	WHERE 
	`fixedassets_assetlist`.`assignedTo` = `employeelist`.`empID`;";
	$query = $this->db->query($sqlStr);
	 return $query->result();

}








}
?>
