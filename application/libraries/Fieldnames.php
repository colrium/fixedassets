<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fieldnames{
	public function __construct(){
   		$this->load->model('mstart', 'clsStrt');
	}


public function __get($var){
    return get_instance()->$var;
  }

public function getFieldName($fieldName="", $entity="fixedassets_assetlist"){
	$name = '';
	if ($fieldName !="") {
		$data = $this->clsStrt->getFormField($fieldName, $entity);
		foreach ($data as $field) {
			$name = $field->setName;
		}
	}

	return $name;
}

public function getFormField($fieldName="", $entity="fixedassets_assetlist"){
	$data = $this->clsStrt->getFormField($fieldName, $entity);
	if (sizeof($data) > 0) {
		return $data[0];
	}
	else{
		return array();
	}
	
}

public function getFormFields($entity="fixedassets_assetlist"){
	$data = $this->clsStrt->getFormFields($entity);
	
	return $data;	
}

public function getFieldNameOnId($fieldId=""){
	$name = '';
	if ($fieldName !="") {
		$data = $this->clsStrt->getFieldNameOnId($fieldId);
		foreach ($data as $field) {
			$name = $field->setName;
		}
	}

	return $name;
}


public function getTableFields($table){
	return $this->clsStrt->getTableFields($table);
}


public function getRequiredFormFields($form=""){

	if ($form!="") {
		$fields = $this->clsStrt->getRequiredFormFields($form);
	}
	else{
		$fields = "";
	}

	return $fields;
}

public function getRequiredImportFields($form=""){

	if ($form!="") {
		$fields = $this->clsStrt->getRequiredImportFields($form);
	}
	else{
		$fields = "";
	}

	return $fields;
}

public function getdateFields($form=""){

	if ($form!="") {
		$fields = $this->clsStrt->getdateFields($form);
	}
	else{
		$fields = array();
	}

	return $fields;
}

public function getForeignKeyValue($fieldName="", $recId="", $table="fixedassets_assetlist"){

	if ($fieldName!="") {
		if ($this->isemployeefield($fieldName, $table)) {
			$data = $this->getEmployeeName($recId);
		}
		else{
			$data = $this->clsStrt->getForeignKeyValue($fieldName, $recId, $table);
		}
		
	}
	else{
		$data = '<i class="grey-text">None</i>';
	}	

	return $data;

}


public function getTableColumnValue($table="", $column="", $recId=""){
	
	$data = $this->clsStrt->getTableColumnValue($table, $column, $recId);
	
	return $data;

}

public function isemployeefield($fieldname="", $table="fixedassets_assetlist"){
	$isEmployee = false;
	$data = $this->clsStrt->getFieldOnName($fieldname, $table);
	if ($data != false) {
		if ($data->tableFKname == 'employeelist') {
			$isEmployee = true;
		}
	}
	return $isEmployee;

}

public function getTableColumnValueOnId($table="", $retcolumn="", $pkColumn="", $recId=""){
	
	$data = $this->clsStrt->getTableColumnValueOnId($table, $retcolumn, $pkColumn, $recId);
	
	return $data;

}


public function getEmployeeName($recId=""){
	if ($recId!="" && $recId!='0') {
		$details = $this->clsStrt->getEmployeeDetailsOnId($recId);
		foreach ($details as $detail) {
			$retdata = $detail->empName;
		}
	}
	else{
		$retdata = '';
	}	

	return $retdata;

}

public function getforeignkeys($fieldname='', $parentTable=''){
	return $this->clsStrt->getforeignkeys($fieldname, $parentTable);
}

public function getFksData($fieldName=''){
	$retdata  = $this->clsStrt->getFksData($fieldName);
	return $retdata;
}

public function getFks($entity=''){
	$retdata  = $this->clsStrt->getFks($entity);
	return $retdata;
}

public function getChildFksData($fieldName='', $parentCol="", $parentId=""){
	$retdata  = $this->clsStrt->getChildFksData($fieldName, $parentCol, $parentId);
	return $retdata;
}

public function getTotalRecordsOfFk($fieldName='', $recId='', $table='fixedassets_assetlist'){
	$params = array();
	
	$nonincludedlocs = array('assetPrimLoc' => '3', 'assetPrimLoc' => '2');
	if ($table == 'fixedassets_assetlist' ) {
		if ($fieldName != 'all') {
			$params['where']['equalto'] = array($fieldName => $recId);
		}
		if ($fieldName=='assetPrimLoc' && in_array($recId, $nonincludedlocs)) {
			
		}
		else{
			$params['where']['notequalto'] = $nonincludedlocs;
		}
	}
	
	$retdata  = dbtablerecordscount($table, $params);
	return $retdata;
}










}