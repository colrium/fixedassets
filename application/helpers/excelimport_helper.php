<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016	Collins Riungu
//
// author: Mutugi Riungu
---------------------------------------------------------------------*/

	function genexcelimportmodal($module='system'){
		$CI = & get_instance();
		$modules = $CI->config->item('fortmodules');
		$returndata = '';
		if (array_key_exists($module, $modules) || $module == 'system') {
			$moduleentities = dbmoduletables($module);
			$modalparams['name'] = 'excelimport';
			$modalparams['title'] = maticon('assignment_returned', 'spaced-text').' Spreadsheet Bulk Import';
			$modalparams['formurl'] = site_url('imports/Excelimport/validateimport/'.$module);
			$modalparams['options'] = array();
			if (is_array($moduleentities)) {
				foreach ($moduleentities as $key => $value) {
					$modalparams['options'][$value->parentTable] = $value->parentTableName;
				}
			}
				

			$returndata = excelimportmodal($modalparams);
		}

		return $returndata;
			
	}


	function importfixedassetrecord($details= array()){
		$CI = & get_instance();
		$fieldData = "";
		$success= "0";
		$saveArray = array();
			foreach ($details as $key => $value) {
				$value = trim($value);
				$fielddetails = $CI->fieldnames->getFormField($key, "fixedassets_assetlist");
				$field = $fielddetails;
				if ($field->isFK) {
					if ($key != 'assetSecLoc') {						
							if ($value != "") {
								$celldata = sanitizeString($value);
								$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, $celldata, $field->fkTableRecPK,  true);
							}
							else{																		
								if ($key == 'assetPrimLoc') {
									$fieldData = $CI->datalib->dataExists('fixedassets_primaryloc', 'primlocIdentifier', "No Location", 'primlocID', false);
								}																		
								else{
									$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, 'None', $field->fkTableRecPK, true);
								}																		
																			
							}
					}
					elseif ($key == 'assetSecLoc') {
						if ($value != "") {
							$parentRecord="";
							if (array_key_exists('assetPrimLoc', $details)) {
								$parentRecord = $details['assetPrimLoc'];
							}

							if ($parentRecord == "") {
								$parentId = $CI->datalib->dataExists('fixedassets_primaryloc', 'primlocIdentifier', "No Location", 'primlocID', false);
							}
							else{
								$parentId = $CI->datalib->dataExists('fixedassets_primaryloc', 'primlocIdentifier', $parentRecord, 'primlocID', true);
							}

							$fieldData = $CI->datalib->dataExistsSecondaryLocation($parentId, $value, true);

						}
						else {
							$parentRecord="";
							if (array_key_exists('assetPrimLoc', $details)) {
								$parentRecord = $details['assetPrimLoc'];
							}

							if ($parentRecord == "") {
								$parentId = $CI->datalib->dataExists('fixedassets_primaryloc', 'primlocIdentifier', "No Location", 'primlocID', false);
							}
							else{
								$parentId = $CI->datalib->dataExists('fixedassets_primaryloc', 'primlocIdentifier', $parentRecord, 'primlocID', true);
							}
							$fieldData = $CI->datalib->dataExistsSecondaryLocation($parentId, 'None', true);
						}
					}

				}
				else{
					if (strlen($value)>0) {	
						if($key == 'assetCode'){
							$fieldData = $value;
						}
						else{
							if ($field->dataType=="date") {
								$fieldData = strPrepDate($value);
							}
							else if ($field->dataType=="varchar") {
								$fieldData =  $CI->datalib->sanitizeString($value);
							}
							else if ($field->dataType=="int") {
								$fieldData =  $CI->datalib->sanitizeInt($value);
							}
							else if ($field->dataType=="decimal") {
								$fieldData =  $CI->datalib->sanitizeDecimal($value);
							}
							else{
								$fieldData =  $CI->datalib->sanitizeString($value);
							}
						}			
							
					}
					else{
						if ($key == 'assetCode') {
							$fieldData = rand(10000,999999);
						}
						else{
							$fieldData = '';
						}
					}
				}
				if ($fieldData != '' && $fieldData != 'NULL') {
					$saveArray[$key] = $fieldData;
				}
			}
			$newRecId = $CI->clsAssetsHndlr->saveUpdateImportRec($saveArray, "fixedassets_assetlist");
			if ($newRecId>0) {					
				$success= "1";
			}

			return $success;
}