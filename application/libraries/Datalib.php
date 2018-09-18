<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datalib{
	public $method, $life, $salvagevalue, $startdate, $price, $percentageuse;
	public function __construct(){
   		$this->load->model('mstart', 'clsStrt');
   		$this->load->model('uploads/muploads', 'clsUpld');
	}


	public function __get($var){
	    return get_instance()->$var;
	}

	public function getDashboardEntityFields($entity="assetlist"){
		$data = $this->clsStrt->getDashboardEntityFields($entity);
		return $data;
	}

	public function loadrecordfromtable($table, $pkColumn, $recId){
		$record = $this->clsStrt->loadrecordfromtable($table, $pkColumn, $recId);
		return $record;
	}


	public function dataExists($dbtable="", $column="", $data="", $pkColumn = "", $create=false){
		$recId = $this->clsStrt->dataExists($dbtable, $column, $data, $pkColumn);	 
		if ($create && $recId == 0) {
			$recId = $this->createFkdata($dbtable, $column, $data);
		}
		return $recId;
	}





	public function dataExistsEmployee($details, $create = false){
		$parseArray = array();
		$recId = 0;
		if (sizeof($details) == 0) {
			//do nothing
		}
		else if (sizeof($details) == 1) {
			$parseArray['empLName'] = $details[0];
		}
		else if (sizeof($details) == 2) {
			$parseArray['empLName'] = $details[0];
			$parseArray['empFName'] = $details[1];
		}

		else if (sizeof($details) == 3) {
			$parseArray['empLName'] = $details[1];
			$parseArray['empFName'] = $details[2];
			$parseArray['empTtle'] = $details[0];
		}

		else if (sizeof($details) == 4) {
			$parseArray['empTtle'] = $details[0];
			$parseArray['empLName'] = $details[1];
			$parseArray['empMName'] = $details[2];
			$parseArray['empFName'] = $details[3];
		}

		else{
			$parseArray['empTtle'] = $details[0];
			$parseArray['empLName'] = $details[1];
			$parseArray['empMName'] = $details[2];
			$parseArray['empFName'] = $details[3];
		}


		if (sizeof($parseArray) != 0) {
			$recId = $this->clsStrt->dataExistsEmployee($parseArray);
			if ($create && $recId == 0) {
				$recId = $this->createEmployee($parseArray);
			}
		}
		
		return $recId;
	}


	public function dataExistsSecondaryLocation($primLocId="", $secLocName="", $create = false){
		$recId = 0;
		if ($primLocId != "" && $secLocName != "") {
			$recId = $this->clsStrt->dataExistsSecondaryLocation($primLocId, $secLocName);
			if ($create && $recId == 0) {
				$recId = $this->createSecondaryLocation($primLocId, $secLocName);
			}
		}
		
		return $recId;
	}


	public function createFkdata($dbtable, $column, $data){
		$recId = $this->clsStrt->createFKdata($dbtable, $column, $data);
		return $recId;
	}

	public function createEmployee($details){
		$recId = $this->clsStrt->fastcreateEmployee($details);
		return $recId;		
	}

	public function createSecondaryLocation($primLocId, $secLocName){
		$recId = $this->clsStrt->createSecondaryLocation($primLocId, $secLocName);
		return $recId;		
	}

	public function sanitizeString($string){
		$sanitizedString = preg_replace('/[^A-Za-z0-9\-]/',' ', $string);


		return $sanitizedString;

	}
	public function sanitizeDate($datestring){
		if ($datestring != '') {
			try {
				$rawDate = gmdate('Y-m-d', $datestring);
				$sanitizedDate = $rawDate;
			} catch (Exception $e) {
				$sanitizedDate = '';
			}
			
							
		}
		else{
			$sanitizedDate = '';
		}
			
		

		return $sanitizedDate;

	}
	public function sanitizeInt($integer){
		$sanitizedInteger = filter_var($integer, FILTER_SANITIZE_NUMBER_INT);


		return $sanitizedInteger;

	}
	public function sanitizeDecimal($decimal){
		$sanitizedDecimal = filter_var($decimal, FILTER_SANITIZE_NUMBER_FLOAT);


		return $sanitizedDecimal;

	}


	public function getFKFieldTable($fieldName="", $entity='fixedassets_assetlist'){
	$table = '';
	if ($fieldName !="") {
		$data = $this->clsStrt->getFormField($fieldName, $entity);
		foreach ($data as $field) {
			$table = $field->tableFKname;
		}
	}
	return $table;
	}

	public function getForeignKeyValue($fieldName="", $recId="", $table="fixedassets_assetlist"){
		if ($fieldName!="") {
			$data = $this->clsStrt->getForeignKeyValue($fieldName, $recId, $table);
		}
		else{
			$data = 'Missing Field Name';
		}	

		return $data;

	}


	public function getFieldTableColumnsOnFieldName($fieldName=""){
	$table = $this->getFKFieldTable($fieldName);
	$columns = $this->clsStrt->getTableColumns($table);
	return $columns;
	}

	public function isIconField($fieldName="", $table="fixedassets_assetlist"){
		$isIcon = false;

			if ($fieldName=="catIcon" || $fieldName=="locIcon") {
				$isIcon = true;
			}

	return $isIcon;
	}

	public function isFKField($fieldName="", $table="fixedassets_assetlist"){
		$isFK = false;
		$details = $this->clsStrt->getFormField($fieldName, $table);
		foreach ($details as $detail) {
			if ($detail->isFK) {
				$isFK = true;
			}
		}
	return $isFK;
	}

	public function getPKFieldinitialName($table="fixedassets_assetlist"){
		$initialName = $this->clsStrt->getPKFieldinitialName($table);

		return $initialName;
	}

	public function getFKIdentifierColumnName($fieldName="", $table="fixedassets_assetlist"){
		$identifierColumnName = $this->clsStrt->getFKIdentifierColumnName($fieldName, $table);

		return $identifierColumnName;
	}

	
	public function genvalidationrules($entity="", $fields=array()){
	$rules = array();
			foreach ($fields as $field) {
				$rule = 'trim';				
				if ($field->isFormReq) {
					$rule .= '|required';
				}
				
				$valrule = "'$field->initialName', '$field->setName', '$rule'";
				$this->form_validation->set_rules($field->initialName, $field->setName, $rule);
				array_push($rules, $valrule);
			}


		// if rules are set
		if (sizeof($rules) > 0) {
			return $rules;
		}
		else {
			return FALSE;
		}

	}


	public function mysqldateformat($date){
		$unixtime = strtotime($date);
		$mysqlDate = date('Y-m-d', $unixtime);
		return $mysqlDate;
		
	}




	public function changechildrenproperty($field='', $fromrecord='', $torecord='', $childid='none'){
		if ($this->clsStrt->changechildrenproperty($field, $fromrecord, $torecord, $childid)) {
			return true;
		}
		else{
			return false;
		}
	}


	public function probeforchangedfields($oldrecord=array(), $newrecord=array(), $table='fixedassets_assetlist'){
		$fields = $this->clsStrt->getFormFields($table);
		$changedfields = array();
		foreach ($fields as $field) {
			$fieldinitialName = $field->initialName;
			$oldvalue =  $oldrecord->$fieldinitialName;
			$newvalue =  $newrecord->$fieldinitialName;
			if ($oldvalue != $newvalue) {
				array_push($changedfields, $fieldinitialName);
			}
		}
		if (sizeof($changedfields) > 0) {
			return $changedfields;
		}
		else{
			return false;
		}
	}


	public function autoaddassetaction($recId, $details=array()){
		if (is_array($details) && $recId > 0) {
			$addAction = $this->clsStrt->autoaddassetaction($recId, $details);
			return $addAction;
		}
		else{
			return false;
		}
	}

	public function loadentityattachments($entitytype='', $recId=''){
		if ($entitytype !='' && $recId!='') {
			$attachments = $this->clsUpld->loadentityattachments($entitytype, $recId);
			return $attachments;
		}
		else{
			return false;
		}

	}

	public function loadentityimages($entitytype='', $recId=''){
		if ($entitytype !='' && $recId!='') {
			$attachments = $this->clsUpld->loadentityimages($entitytype, $recId);
			return $attachments;
		}
		else{
			return false;
		}

	}

	public function loadentitymainimage($entitytype='', $recId=''){
		if ($entitytype !='' && $recId!='') {
			$attachments = $this->clsUpld->loadentitymainimage($entitytype, $recId);
			return $attachments;
		}
		else{
			return false;
		}

	}

	
	public function getsystemprefs(){
		$preferences = $this->clsStrt->loadrecordfromtable('system_prefs', 'prefId', '1');
		return $preferences;
	}

	public function getuserprefs(){
		$preferences = $this->clsStrt->loadrecordfromtable('user_preferences', 'userId', USERID);
		return $preferences;
	}

	public function monetary($amount=""){
		$prefs = $this->getsystemprefs();
		$currency = $prefs->sys_currency;
		$retData = $currency.' '.$amount;
		return $retData;
	}

	public function userdateformat($date=""){
			$dateformat = userpreferences('system', 'dateformat');
			if ($date != "") {
				$retData = date($dateformat, strtotime($date));
			}
			else{
				$retData = $date;
			}

		
			
		
		return $retData;
	}

	public function getdepreciationinfo($recId){
		$returnarray = array();
		$method = '-1';
		$life = '-1';
		$salvagevalue = '-1';
		$startdate = '-1';
		$price = '-1';
		$percentageuse = '100';

		$assetDetails = $this->clsStrt->loadrecordfromtable('fixedassets_assetlist', 'assetID', $recId);

		if (sizeof($assetDetails)>0) {
			
			if ($assetDetails->deprMethod > 0 ) {
				$method = $assetDetails->deprMethod;
			}
				$life = $assetDetails->assetLYears;
				$salvagevalue = $assetDetails->salvageVal;
				$percentageuse = $assetDetails->bizUse;
				if ($assetDetails->dtePurchased != '') {
					$startdate = $assetDetails->dtePurchased;
				}
				
				if ($assetDetails->dtePutIntoService != '') {
					$startdate = $assetDetails->dtePutIntoService;
				}
				
				
				if ($assetDetails->assetCost>0) {
					$price = ($assetDetails->assetCost + $assetDetails->assetCTax1 + $assetDetails->assetCTax2);
				}
				if ($assetDetails->totalCost>0) {
					$price = $assetDetails->totalCost;
				}
			if ($assetDetails->assetCat > 0) {
					$categoryDetails = $this->clsStrt->loadrecordfromtable('fixedassets_categories', 'catId', $assetDetails->assetCat);

					if ($categoryDetails->catDepMethod > 0) {
						$method = $categoryDetails->catDepMethod;
					}
					if ($categoryDetails->catLifeInYears > 0) {
						$life = $categoryDetails->catLifeInYears;
						
					}
					if ($salvagevalue == '-1') {
						$salvagevalue = 0;
					}
					if ($price == '-1') {
						$price = 0;
					}
					if ($startdate == '-1') {
						$startdate = date('Y-m-d');
					}

			}
			
			
			$returnarray['method'] = $method;
			$returnarray['life'] = $life;
			$returnarray['salvagevalue'] = $salvagevalue;
			$returnarray['startdate'] = $startdate;
			$returnarray['price'] = $price;
			$returnarray['percentageuse'] = $percentageuse;

			return $returnarray;

		}
		else{
			return false;
		}

			

	}




	public function getmakers(){
		return $this->clsStrt->getmakers();
	}

	public function getcheckers(){
		return $this->clsStrt->getcheckers();
	}

	public function addmakers($markers=array()){
		return $this->clsStrt->addmakers($markers);
	}

	public function addcheckers($checkers=array()){
		return $this->clsStrt->addcheckers($checkers);
	}

	public function removemakers($markers=array()){
		return $this->clsStrt->removemakers($markers);
	}

	public function removecheckers($checkers=array()){
		return $this->clsStrt->removecheckers($checkers);
	}

	public function isMaker($id){
		return $this->clsStrt->markerexists($id);
	}

	public function isChecker($id){
		return $this->clsStrt->checkerexists($id);
	}









}//end of class