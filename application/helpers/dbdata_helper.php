<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/


//get all table records
if ( ! function_exists('dbtablerecords')){
	function dbtablerecords($table, $params=array(), $includeheaders = FALSE, $fkvalues=TRUE, $visiblecolumnsonly=FALSE, $appcolumnsonly=FALSE){
		$CI = & get_instance();
		
		$records = $CI->mdbdata->dbtablerecords($table, $params, $includeheaders, $fkvalues, $visiblecolumnsonly, $appcolumnsonly);
		
		return $records;
	}
}
//get table record
if ( ! function_exists('dbtablerecord')){
	function dbtablerecord($recId, $table, $fkvalues=TRUE, $params=array()){
		$CI = & get_instance();		
		$record = $CI->mdbdata->dbtablerecord($recId, $table, $fkvalues, $params);
		return $record;
	}
}




//get all table records total
if ( ! function_exists('dbtablerecordscount')){
	function dbtablerecordscount($table, $params=array()){
		$CI = & get_instance();
		
		$records = $CI->mdbdata->dbtablerecordscount($table, $params);
		return $records;		
	}
}



//table record exists
if ( ! function_exists('dbtablerecordexists')){
	function dbtablerecordexists($recId, $table){
		$record = dbtablerecord($recId, $table);
		if ($record == FALSE) {
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
}

//FK record exists
if ( ! function_exists('dbfkrecordexists')){
	function dbfkrecordexists($table, $fieldname, $value, $create=FALSE){
		$CI = & get_instance();		
		$record = $CI->mdbdata->dbfkrecordexists($table, $fieldname, $value, $create);
		return $record;
	}
}

//table data record exists
if ( ! function_exists('dbtabledatarecordexists')){
	function dbtabledatarecordexists($table, $column, $value, $createnew=FALSE, $returnid=FALSE){
		$params = array();
		if (is_array($column)) {
			if (is_array($value)) {
				
			}
			foreach ($column as $columnkey => $columnvalue) {
				if ($columnkey < sizeof($value)) {
					$params['where']['equalto'] = array($columnvalue=>$value[$columnkey]);
				}				
			}			
		}
		else{
			$params['where']['equalto'] = array($column => $value);
		}
		
		$records = dbtablerecords($table, $params, FALSE);
		if ($records == FALSE) {
			if ($returnid) {
				return '0';
			}
			return FALSE;
			
		}
		else{
			if ($returnid) {
				$tablecolumnpk = dbtablepkcolumn($table)->initialName;
				return $records[0]->$tablecolumnpk;
			}
			return TRUE;
		}
	}
}

//module tables
if ( !function_exists('dbmoduletables')){
	function dbmoduletables($module){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->dbmoduletables($module);
		return $fields;
	}
}
//table module 
if ( !function_exists('dbtablemodule')){
	function dbtablemodule($table){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->dbtablemodule($table);
		return $fields;
	}
}


//module tablename
if ( !function_exists('dbmoduletablename')){
	function dbmoduletablename($table){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->dbmoduletablename($table);
		return $fields;
	}
}

//module tablenames
if ( !function_exists('dbmoduletablenames')){
	function dbmoduletablenames($module){
		$fields = array();
		foreach (dbmoduletables($module) as $field) {
			$fields[$field->parentTable] = $field->parentTableName;
		}
		
		return $fields;
	}
}

//module tableicons
if ( !function_exists('dbmoduletableicons')){
	function dbmoduletableicons($module){
		$icons = array();
		foreach (dbmoduletables($module) as $field) {
			$icons[$field->parentTable] = $field->parentTableIcon;
		}
		
		return $icons;
	}
}
//table fields
if ( !function_exists('dbtablefields')){
	function dbtablefields($table, $filtercolumn=FALSE, $filtervalue=FALSE){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->tablefields($table, $filtercolumn, $filtervalue);
		return $fields;
	}
}


//dependant table fields
if ( !function_exists('dbtabledependantfields')){
	function dbtabledependantfields($table){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->dbtabledependantfields($table);
		return $fields;
	}
}
//field name
if ( !function_exists('dbfieldsetname')){
	function dbfieldsetname($table, $fieldname){
		$CI = & get_instance();
		
		$setName = $CI->mdbdata->dbfieldsetname($table, $fieldname);
		return $setName;
	}
}

//module fields
if ( !function_exists('dbmodulefields')){
	function dbmodulefields($module){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->dbmodulefields($module);
		return $fields;
	}
}
//module name
if ( !function_exists('modulename')){
	function modulename($module){
		$CI = & get_instance();
		$modules = $CI->config->item('fortmodules');
		$modulename = $CI->config->item('version_name');
		if (array_key_exists($module, $modules)) {
			$modulename = $modules[$module];
		}
		return $modulename;
	}
}
//module icon
if ( !function_exists('moduleicon')){
	function moduleicon($module){
		$CI = & get_instance();
		$modulesicons = $CI->config->item('fortmodulesicons');
		$moduleicon = 'build';
		if (array_key_exists($module, $modulesicons)) {
			$moduleicon = $modulesicons[$module];
		}
		return $moduleicon;
	}
}
//module fields update
if ( !function_exists('updateinputfields')){
	function updateinputfields($module){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->updateinputfields($module);
		return $fields;
	}
}




//table fields form validation
if ( ! function_exists('dbfieldsformvalidation')){
	function dbfieldsformvalidation($table, $data=array(), $recId=0){
		$CI = & get_instance();
		$rules = array();
		$setNames = array();
		$validitypassed = FALSE;
		$validationerrors = array();
		$pkinitialName = '';
		$fields  = dbtablefields($table);
			foreach ($fields as $field) {
				if ($field->isPK != 1) {
					$rule = array();			
					if ($field->isFormReq) {
						array_push($rule, 'required');
					}
					if ($field->isUnique=='1' && $field->isPK!='1') {
						array_push($rule, 'unique');
					}
					if (sizeof($rule) > 0) {
						$setNames[$field->initialName] = $field->setName;
						$rules[$field->initialName] = $rule;
					}
					
				}
				else{
					$pkinitialName = $field->initialName;
				}
			}

			foreach ($rules as $rulekey => $rulevalue) {
				if (in_array('required', $rulevalue)) {
					if (array_key_exists($rulekey, $data)) {
						$datavalue = trim($data[$rulekey]);
						if (strlen($datavalue) == 0) {
							array_push($validationerrors, $setNames[$rulekey].' is required.');
						}
					}
					else{
						array_push($validationerrors, $setNames[$rulekey].' is required.');
					}
				}
				if (in_array('unique', $rulevalue)) {
					if (array_key_exists($rulekey, $data)) {
						$datavalue = trim($data[$rulekey]);
						if (strlen($datavalue) > 0) {
							$uniquenessparams = array();
							$uniquenessparams['where']['equalto'] = array($rulekey=>$datavalue);

							$existingrecords = dbtablerecords($table, $uniquenessparams, FALSE);
							if ($recId=='0') {
								if ($existingrecords != FALSE || (is_array($existingrecords) && sizeof($existingrecords)>0)) {
									array_push($validationerrors, $setNames[$rulekey].' ('.$datavalue.') already exists.');
								}
							}
							else{
								$recIds = array();
								if ($pkinitialName != '') {
									foreach ($existingrecords as $existingrecord) {
										array_push($recIds, $existingrecord->$pkinitialName);
									}
									if (!in_array($recId, $recIds)) {
										array_push($validationerrors, $setNames[$rulekey].' ('.$datavalue.') already exists.');
									}
								}
								
							}
							
							
						}
					}
				}
			}

			if (sizeof($validationerrors) > 0) {
				return $validationerrors;
			}
			else{
				return TRUE;
			}

		

	}
}

function isuniquedata($data, $fieldname, $table='fixedassets_assetlist'){
	$CI = & get_instance();

	$params = array();
	$params['where']['equalto'] = array($fieldname=>$data);

	$existingrecords = dbtablerecords($table, $params, FALSE);

	if ($existingrecords != FALSE || !is_array($existingrecords)) {
		$CI->form_validation->set_message('isunique_data', 'The {field} field must be unique');
		return FALSE;
	}

	return TRUE;
				
}

//table id columns
if ( !function_exists('tableidcolumns')){
	function tableidcolumns($table){
		$idcolumn = FALSE;
		$fields = dbtablefields($table);
		if ($fields != FALSE) {
			$idcolumn = $fields[0]->parentTableIdColumns;
		}

		return $idcolumn;

	}
}

//get table record name
if ( ! function_exists('dbtablerecordname')){
	function dbtablerecordname($table, $recId){
		$details = dbtablerecord($recId, $table, TRUE);
		$idcolumnsstr = tableidcolumns($table);
		$idcolumnsarr = explode(',', $idcolumnsstr);
		$recordname = '';
		$lastindex = sizeof($idcolumnsarr) - 1;

		if (is_object($details)) {
			foreach ($idcolumnsarr as $key => $value) {
				$recordname .= $details->$value;
				if ($key < $lastindex) {
					$recordname .= ' ';
				}
			}
		}

		return $recordname;
	}
}


//table add update record
if ( !function_exists('addupdatedbtablerecord')){
	function addupdatedbtablerecord($table, $data, $recId, $validatedata=TRUE, $logaction=TRUE){
		$CI = & get_instance();
		
		$fields  = dbtablefields($table);
		$newrecId = FALSE;
		$oldid = $recId;
		$currentrecord = array();
		$acionlogdetails = array();
		$incompatibledata = TRUE;
		$validationfailed = FALSE;

		if ($recId != '0') {
			$currentrecord = dbtablerecord($recId, $table);
		}
		$newrecord = $currentrecord;

		if ($fields != FALSE) {			
			foreach ($fields as $field) {
				if ($field->isPK != '1') {
					if (!array_key_exists($field->initialName, $data)) {						
						if ($field->dataType == 'boolean') {
							$data[$field->initialName] = 0;
						}
					}
					else{
						if ($incompatibledata) {
							$incompatibledata = FALSE;
						}
					}
				}
			}
			
		}
		if ($incompatibledata) {
			$validationfailed= TRUE;
			$CI->displayData['strerror'] = array('icon'=>'error_outline', 'alert'=>'Incompatible data supplied');
			return $recId;
		}
		if ($validatedata) {
			$datavalid = dbfieldsformvalidation($table, $data, $recId);
			if (!is_array($datavalid)) {
				$newrecId = $CI->mdbdata->addupdatedbtablerecord($table, $data, $recId);
			}
			else{
				$validationfailed= TRUE;
				$CI->displayData['strerror'] = array('icon'=>'error_outline', 'alert'=>implode('\n', $datavalid));
				$newrecId = $recId;
			}
		}
		else{
			$newrecId = $CI->mdbdata->addupdatedbtablerecord($table, $data, $recId);
		}

		if (($newrecId == FALSE || $newrecId == '0') && !$validationfailed) {
			$CI->displayData['strerror'] =  array('icon'=>'error', 'alert'=>'Database save error');
			$newrecId = $recId;
		}
		else{			
			if ($logaction) {
				if (isloggedin(FALSE)) {
					$user = $CI->ion_auth->user()->row();
					$acionlogdetails['responsibility'] = $user->id;

				}
				if ($oldid == '0') {
					$newrecord = dbtablerecord($newrecId, $table);
					$acionlogdetails['type'] = 'Add';
					$acionlogdetails['entity'] = $table;
					$acionlogdetails['description'] = 'Created';
					$acionlogdetails['record'] = $newrecId;
					$acionlogdetails['timestamp'] = date('Y-m-d H:i:s');
					$acionlogdetails['completion_date'] = date('Y-m-d H:i:s');
					$acionlogdetails['initialdata'] = json_encode($newrecord);

					addupdatedbtablerecord('actions_log', $acionlogdetails, '0', FALSE, FALSE);
				}
				else{
					$newrecord = dbtablerecord($newrecId, $table);
					$currentrecordArr = objecttoarrayrecursivecast($currentrecord);
					$newrecordArr = objecttoarrayrecursivecast($newrecord);
					$changes = array_diff($newrecordArr, $currentrecordArr);
					$tablefieldnames = array();
					foreach ($fields as $field) {
						$tablefieldnames[$field->initialName] = $field->setName;
					}
					if (sizeof($changes) > 0) {
						$description = '';
						foreach ($changes as $changekey => $changevalue) {
							if (strlen($description) > 0) {
								$description .= ' \n ';
							}

							if (array_key_exists($changekey, $currentrecordArr) && array_key_exists($changekey, $newrecordArr)) {
								$currentrecordArr[$changekey] = trim($currentrecordArr[$changekey]);
								$newrecordArr[$changekey] = trim($newrecordArr[$changekey]);
								if (strlen($currentrecordArr[$changekey]) > 0 && strlen($newrecordArr[$changekey]) > 0) {
									$description .= 'Changed '.$tablefieldnames[$changekey].' From '.$currentrecordArr[$changekey].' To '.$newrecordArr[$changekey];
								}
								else if (strlen($currentrecordArr[$changekey]) == 0) {
									$description .= 'Set '.$tablefieldnames[$changekey].' To '.$newrecordArr[$changekey];
								}
								else{
									$description .= 'Unset '.$tablefieldnames[$changekey].' From '.$currentrecordArr[$changekey];
								}
							}
							else if (array_key_exists($changekey, $currentrecordArr) && !array_key_exists($changekey, $newrecordArr)) {
								$description .= 'Unset '.$tablefieldnames[$changekey].' From '.$currentrecordArr[$changekey];
							}
							else if (!array_key_exists($changekey, $currentrecordArr) && array_key_exists($changekey, $newrecordArr)) {
								$description .= 'Set '.$tablefieldnames[$changekey].' From '.$newrecordArr[$changekey];
							}
							
						}
						$acionlogdetails['description'] = $description;
						$acionlogdetails['type'] = 'Update';
						$acionlogdetails['entity'] = $table;
						$acionlogdetails['record'] = $newrecId;
						$acionlogdetails['timestamp'] = date('Y-m-d H:i:s');
						$acionlogdetails['initialdata'] = json_encode($currentrecordArr);
						$acionlogdetails['datachanges'] = json_encode($changes);
						$acionlogdetails['completion_date'] = date('Y-m-d');
						addupdatedbtablerecord('actions_log', $acionlogdetails, '0', FALSE, FALSE);
					}

				}
			}
				
		}
			
		return $newrecId;
	}
}
//table add update record
if ( !function_exists('importrecordtodbtable')){
	function importrecordtodbtable($table, $data){
		$CI = & get_instance();
		
		$fields  = dbtablefields($table);
		$recId = '0';
		$pkColumn = 'id';
		$tablesFKrecords = array();
		$dataidcols = explode(',', tableidcolumns($table));
		if ($fields != FALSE) {
			foreach ($fields as $field) {
				if ($field->isPK != 1) {
					if ($field->isFK && array_key_exists($field->initialName, $data)) {
						$fkval = trim($data[$field->initialName]);
						if (strlen($fkval)>0) {
							$fkId = dbfkrecordexists($table, $field->initialName, $data[$field->initialName], TRUE);
							$data[$field->initialName] = $fkId;
							if (!array_key_exists($field->tableFKname, $tablesFKrecords)) {
								$tablesFKrecords[$field->tableFKname] = $fkId;
							}
							

							$fkTableFKfields = dbtablefields($field->tableFKname, 'isFK', '1');
							if (is_array($fkTableFKfields)) {
								$fkRecsaveupdateArr = array();
								foreach ($fkTableFKfields as $fkTableFKfield) {
									if (array_key_exists($fkTableFKfield->tableFKname, $tablesFKrecords)) {										
										$fkRecsaveupdateArr[$fkTableFKfield->initialName] = $tablesFKrecords[$fkTableFKfield->tableFKname];
									}
								}
								if (sizeof($fkRecsaveupdateArr)>0) {
									addupdatedbtablerecord($field->tableFKname, $fkRecsaveupdateArr, $fkId, FALSE, FALSE);
								}
							}

						}
						else{
							$data[$field->initialName] = '0';
						}

					}
					if ($field->dataType == 'date' && array_key_exists($field->initialName, $data)) {
						$data[$field->initialName] = strPrepDate($data[$field->initialName]);
					}
					else if ($field->dataType == 'datetime' && array_key_exists($field->initialName, $data)) {
						$data[$field->initialName] = strPrepDateTime($data[$field->initialName]);
					}
					else if ($field->dataType == 'decimal' && array_key_exists($field->initialName, $data)) {
						$data[$field->initialName] = strPrepDecimal($data[$field->initialName]);
					}					
					else if ($field->dataType == 'boolean') {
						if (!array_key_exists($field->initialName, $data)) {
							$data[$field->initialName] = 0;
						}
					}

				}
				else{
					$pkColumn = $field->initialName;
				}
			}
		}
		$newrecordvaulues = array();
		foreach ($dataidcols as $key => $value) {
			if (array_key_exists($value, $data)) {
				array_push($newrecordvaulues, $data[$value]);
			}
		}
		if (sizeof($newrecordvaulues) > 0) {
			$recId = dbtabledatarecordexists($table, $dataidcols, $newrecordvaulues, FALSE, TRUE);
		}

		$newrecId = addupdatedbtablerecord($table, $data, $recId, FALSE, TRUE);
			if ($newrecId == FALSE) {
				$newrecId = $recId;
			}

				

		return $newrecId;
	}
}




//table pk column
if ( !function_exists('dbtablepkcolumn')){
	function dbtablepkcolumn($table){
		$CI = & get_instance();
		
		$pkfield = $CI->mdbdata->dbtablepkcolumn($table);
		return $pkfield;
	}
}

//table delete records
if ( !function_exists('deletedbtablerecords')){
	function deletedbtablerecords($table, $filters, $permanent=FALSE){
		$CI = & get_instance();		
		$action = $CI->mdbdata->deletedbtablerecords($table, $filters, $permanent);
		return $action;
	}
}

//table delete record
if ( !function_exists('deletedbtablerecord')){
	function deletedbtablerecord($table, $recId, $permanent=FALSE){		
		$pkColumn = dbtablepkcolumn($table);		
		$action = deletedbtablerecords($table, array($pkColumn->initialName => $recId), $permanent);
		$dependantfields = dbtabledependantfields($table);
		if (is_array($dependantfields) && sizeof($dependantfields) > 0) {
			foreach ($dependantfields as $dependantfield) {
				$dependenttablepk = dbtablepkcolumn($dependantfield->parentTable);
				$dependentrecordsparams = array();
				$dependentrecordsparams['where']['equalto'] = array($dependantfield->initialName => $recId);
				$dependentrecords = dbtablerecords($dependantfield->parentTable, $dependentrecordsparams, FALSE, FALSE);
				foreach ($dependentrecords as $dependentrecord) {
					$contextcolumninitialname = $dependantfield->initialName;
					$dependenttablepkname = $dependenttablepk->initialName; 
					$dependentrecordarr = objecttoarrayrecursivecast($dependentrecord);
					$dependentrecordarr[$contextcolumninitialname] = 0;
					$dependencyrecId = $dependentrecordarr[$dependenttablepkname];
					$updatedrecorddata = array();
					foreach ($dependentrecordarr as $dependentrecordkey => $dependentrecordvalue) {
						if ($dependentrecordkey != $dependenttablepkname) {
							$updatedrecorddata[$dependentrecordkey] = $dependentrecordvalue;
						}
					}
					$updateddependency = addupdatedbtablerecord($dependantfield->parentTable, $updatedrecorddata, $dependencyrecId, FALSE);
				}
				
			}
		}
		return $action;
	}
}


//table empty
if ( !function_exists('emptymoduledb')){
	function emptymoduledb($module){
		$CI = & get_instance();
		
		$function = $CI->mdbdata->emptymoduledb($module);
		return $function;
	}
}

//table empty
if ( !function_exists('emptydbtable')){
	function emptydbtable($table){
		$CI = & get_instance();
		
		$fields = $CI->mdbdata->emptydbtable($table);
		return $fields;
	}
}
//table empty
if ( !function_exists('recyclebinrestore')){
	function recyclebinrestore($recId){
		$CI = & get_instance();
		
		$restore = $CI->mdbdata->recyclebinrestore($recId);
		return $restore;
	}
}


//add user action log
if ( !function_exists('adduseractionlog')){
	function adduseractionlog($data=array()){		
		$CI = & get_instance();
		
		$table = 'actions_log';
		$recId = '0';
		$fields = $CI->mdbdata->addupdatedbtablerecord($table, $data, $recId,FALSE);
		return $fields;
	}
}



//add attachment to attachments action log
if ( !function_exists('dbaddattachmentlog')){
	function dbaddattachmentlog($metas, $savefiletodb=FALSE){
		$CI = & get_instance();
		
		$recordid = $CI->mdbdata->dbaddattachmentlog($metas, $savefiletodb);
		
		return $recordid;
	}
}

//get attachment file from db
if ( !function_exists('dbattachmentfile')){
	function dbattachmentfile($attachmentid){
		$attachment = dbtablerecord($attachmentid, 'attachments');
		$CI = & get_instance();
		ob_start();
			  $CI->output->set_status_header(200)->set_header('Content-Disposition: inline; filename="'.$attachment->name.'"')->set_content_type($attachment->type)->set_output(base64_decode($attachment->file))->_display();
	}
}

//get attachment file from db
if ( !function_exists('dbattachmentimages')){
	function dbattachmentimages($entity, $recordid, $mainimage=FALSE){
		$returndata = FALSE;
		$params = array();
		$params['where']['equalto'] = array('isimage'=>'1', 'entity'=>$entity, 'record'=>$recordid);
		if ($mainimage != FALSE) {
			$params['where']['equalto']['ismainimage'] = '1';
		}
		$images = dbtablerecords('attachments', $params, FALSE, FALSE);
		$returndata = $images;
		if ($images != FALSE && $mainimage != FALSE) {
			$returndata = $images[0];
		}
		return $returndata;

	}
}

//get has image file from db
if ( !function_exists('dbhasmainimage')){
	function dbhasmainimage($entity, $recordid){
		$returndata = FALSE;
		$params = array();
		$params['where']['equalto'] = array('isimage'=>'1', 'entity'=>$entity, 'record'=>$recordid);
		$hasmainimage = dbtablerecordscount('attachments', $params);

		if ($hasmainimage > 0) {
			$returndata = TRUE;
		}
		return $returndata;

	}
}

//set main image file in db
if ( !function_exists('dbsetmainimage')){
	function dbsetmainimage($attId){
		$returndata = FALSE;
		$table = 'attachments';

		$contextimage = dbtablerecord($attId, $table, FALSE);
		if (is_object($contextimage)) {
			$data = array('isimage'=>'1', 'ismainimage'=>'1');
			$newrecId = addupdatedbtablerecord($table, $data, $contextimage->attId, FALSE, FALSE);
			if ($newrecId != FALSE) {
				$returndata = TRUE;
			}
		}
		
		return $returndata;

	}
}

//unset main images
if ( !function_exists('dbunsetmainimages')){
	function dbunsetmainimages($entity, $recId){
		$returndata = FALSE;
		$table = 'attachments';

		$params = array();
		$params['where']['equalto'] = array('isimage'=>'1', 'entity'=>$entity, 'record'=>$recId);
		$mainimages = dbtablerecords($table, $params, FALSE, FALSE, FALSE);
		if (is_array($mainimages)) {
			foreach ($mainimages as $mainimage) {
				$data = array('isimage'=>'1', 'ismainimage'=>'0');
				$newrecId = addupdatedbtablerecord($table, $data, $mainimage->attId, FALSE, FALSE);
				if ($newrecId != FALSE) {
					$returndata = TRUE;
				}
				
			}
		}		
		return $returndata;

	}
}


//get attachments file from db
if ( !function_exists('dbattachments')){
	function dbattachments($entity, $recordid, $images=FALSE, $mainimage=FALSE){
		$returndata = FALSE;
		$params = array();
		$params['where']['equalto'] = array('isimage'=>'1', 'entity'=>$entity, 'record'=>$recordid);
		if ($images == FALSE) {
			$params['where']['equalto']['isimage'] = '0';
		}
		else{
			$params['where']['equalto']['isimage'] = '1';
		}
		if ($mainimage != FALSE) {
			$params['where']['equalto']['ismainimage'] = '1';
		}
		$images = dbtablerecords('attachments', $params, FALSE, FALSE);
		$returndata = $images;
		if ($images != FALSE && $mainimage != FALSE) {
			$returndata = $images[0];
		}
		return $returndata;

	}
}


//get attachment file from db
if ( !function_exists('dbattachmentfilestream')){
	function dbattachmentfilestream($attachmentid){
		$attachment = dbtablerecord($attachmentid, 'attachments');
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header('Content-Description: File Transfer');
		header("Content-type: ".$attachment->type."");
		header("Content-Disposition: attachment; filename=".$attachment->name."");
		header("Expires: 0");
		header("Pragma: public");
		print base64_decode($attachment->file);
	}
}
if ( !function_exists('getmysqlglobalvariable')){
	function getmysqlglobalvariable($variable='max_allowed_packet'){
		$CI = & get_instance();
		
		$variable = $CI->mdbdata->getmysqlglobalvariable($variable);
		return $variable;
	}
}
if ( !function_exists('setmysqlglobalvariable')){
	function setmysqlglobalvariable($variable='max_allowed_packet', $value=1073741824){
		$CI = & get_instance();
		
		$variable = $CI->mdbdata->setmysqlglobalvariable($variable, $value);
		return $variable;
	}
}

if ( !function_exists('dbrefreshfieldnames')){
	function dbrefreshfieldnames($module=FALSE){
		$CI = & get_instance();
		$CI->load->library('spreadsheets');
		
		$workbookinit = $CI->spreadsheets->workbook('./catalog/database/field_names.xlsx');
		$fields = array();
		if ($workbookinit) {   			
			$workbooksheets = $CI->spreadsheets->workbooksheets();
			if ($module == FALSE || $module == 'system' || $module == 'all') {
				$modules = $CI->config->item('fortmodules');
				$modules = array_merge(array('system'=>'System'), $modules);
				foreach ($modules as $key => $value) {
					if (in_array($key, $workbooksheets)) {
						$modulefields = $CI->spreadsheets->databysheetname($key, TRUE);
						$fields = array_merge($fields, $modulefields);
					}   					
				}
				
			}
			else{
				if (in_array($module, $workbooksheets)) {
					$modulefields = $CI->spreadsheets->databysheetname($module, TRUE);
					$fields = array_merge($fields, $modulefields);
				}
			}
			
		}

		$lastfieldsindex = sizeof($fields)-1;
		for ($i=0; $i <= $lastfieldsindex; $i++) {
			if (array_key_exists('fieldId', $fields[$i])) {
				$fields[$i]['fieldId'] = $i+1;
			}
			foreach ($fields[$i] as $key => $value) {
				if (is_null($value)) {
					$fields[$i][$key] = '0';
				}
			}

		}
		$refreshed = $CI->mdbdata->dbrefreshfieldnames($fields);
		
		
		return $fields;
	}
}
if ( !function_exists('dbexceltojsonfieldnames')){
	function dbexceltojsonfieldnames($module=FALSE){
		$CI = & get_instance();
		$CI->load->library('spreadsheets');
		
		$workbookinit = $CI->spreadsheets->workbook('./catalog/database/field_names.xlsx');
		$fields = array();
		if ($workbookinit) {   			
			$workbooksheets = $CI->spreadsheets->workbooksheets();
			if ($module == FALSE || $module == 'system' || $module == 'all') {
				$modules = $CI->config->item('fortmodules');
				$modules = array_merge(array('system'=>'System'), $modules);
				foreach ($modules as $key => $value) {
					if (in_array($key, $workbooksheets)) {
						$modulefields = $CI->spreadsheets->databysheetname($key, TRUE);
						$fields = array_merge($fields, $modulefields);
					}   					
				}
				
			}
			else{
				if (in_array($module, $workbooksheets)) {
					$modulefields = $CI->spreadsheets->databysheetname($module, TRUE);
					$fields = array_merge($fields, $modulefields);
				}
			}
			
		}

		$lastfieldsindex = sizeof($fields)-1;
		for ($i=0; $i <= $lastfieldsindex; $i++) { 
			if (array_key_exists('fieldId', $fields[$i])) {
				$fields[$i]['fieldId'] = $i+1;
			}
		}
		$refreshed = $CI->mdbdata->dbrefreshfieldnames($fields);
		
		
		return $refreshed;
	}
}

if ( !function_exists('dbcreateroutinessql')){
	function dbcreateroutinessql(){
		$CI = & get_instance();
		$sql = "DELIMITER $$
					CREATE FUNCTION `GENERATE_ID`(length SMALLINT(3)) RETURNS varchar(100) CHARSET utf8
					BEGIN 
					  SET @returnStr = '';
						SET @allowedChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
						SET @i = 0;
						WHILE (@i < length) DO
							SET @returnStr = CONCAT(@returnStr, substring(@allowedChars, FLOOR(RAND() * LENGTH(@allowedChars) + 1), 1));
							SET @i = @i + 1;
						END WHILE;

						RETURN @returnStr;
					END$$
				DELIMITER;";
		return $sql;
	}
}

if ( !function_exists('dbcreatetriggerssql')){
	function dbcreatetriggerssql($module='system'){
		$CI = & get_instance();
		$tables = dbmoduletables($module);
		$sql = "";
		if (is_array($tables)) {
			foreach ($tables as $table) {
				$sql .= '
					DROP TRIGGER IF EXISTS preinsert_'.$table->parentTable.';'.breaker().'
					DELIMITER $$ '.breaker().'					
					CREATE TRIGGER preinsert_'.$table->parentTable.''.breaker().'
						BEFORE INSERT ON '.prepsqlstringvar($table->parentTable, '`').''.breaker().'
						FOR EACH ROW'.breaker().'
							BEGIN'.breaker().'
								SET @id = GENERATE_ID(11);'.breaker().'
								SET @existing = (SELECT COUNT('.$table->PKinitialName.') FROM '.prepsqlstringvar($table->parentTable, '`').' WHERE '.prepsqlstringvar($table->PKinitialName, '`').' =@id);'.breaker().'
								SET @id = (CASE @existing WHEN 0 THEN @id ELSE GENERATE_ID(11) END);'.breaker().'
								SET NEW.'.$table->PKinitialName.' = @id;'.breaker().'
								SET @@LAST_INSERT_GUID = @id;'.breaker().'
							END;$$'.breaker().'
					DELIMITER ;'.breaker(2);
			}
		}
			
		
		return $sql;
	}
}

if ( !function_exists('refreshfieldnames')){
	function refreshfieldnames($data=array('your value')){
		$CI = & get_instance();
		$CI->load->helper('file');
		$filepath = APPPATH.'config/fieldnames.php';
		$fieldnamesfile = fopen($filepath, "w+") or die("Unable to open file!");
		$writedata = '<?php ';
		$writedata .= "\n";
		$writedata .= '$config["fieldnames"] = array(';
		$dbfieldnames = array();
		$modules = $CI->config->item('fortmodules');
		foreach ($modules as $modulekey => $modulevalue) {
			$modulefields = dbmodulefields($modulekey);
			if (is_array($modulefields)) {
				foreach ($modulefields as $modulefield) {
					array_push($dbfieldnames, $modulefield);
				}				
			}
			
		}
		$dbfieldnames = objecttoarrayrecursivecast($dbfieldnames);



		$lastfieldsindex = sizeof($dbfieldnames)-1;
		$fieldsindex = 0;

		foreach ($dbfieldnames as $fieldkey => $details) {
			$lastdetailsindex = sizeof($details)-1;
			$detailsindex = 0;
			$writedata .= "\n\t (object) array(";
			foreach ($details as $key => $value) {
				$writedata .= '"'.$key.'" => "'.$value.'"';
				if ($detailsindex < $lastdetailsindex) {
					$writedata .= ', ';
				}
				$detailsindex++;
			}
			$writedata .= ")";
			if ($fieldsindex < $lastfieldsindex) {
				$writedata .= ", \n";
			}
			$fieldsindex++;
		}
		$writedata .= "\n);";

		fwrite($fieldnamesfile, $writedata);
		fclose($fieldnamesfile);
		
		return $dbfieldnames;
	}
}


if ( !function_exists('dbaddentityfield')){
	function dbaddentityfield($data=array()){
		$CI = & get_instance();
		
	}
}

if ( !function_exists('dbaddscheduledtask')){
	function dbaddscheduledtask($data=array()){
		$CI = & get_instance();
		$path = FCPATH;
		$path = str_replace('/', '\\', $path);
		$path .= $data['url'];
		$cmd = 'schtasks.exe /CREATE /SC '.$data['reccurence'].' /TN "'.$data['name'].'" /TR "php.exe  '.$path.'" /RU System';
		exec($cmd, $response);
		return $response;
		
	}
}