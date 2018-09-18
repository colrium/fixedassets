<?php


function importFixedAssetRecord($details= array()){
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
							$celldata = $CI->datalib->sanitizeString($value);
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

function importInsuranceClientRecord($details= array()){


}

function importInsuranceInsurerRecord($details= array()){


}

function importInsuranceCoversRecord($details= array()){


}

function importInsurancePaymentsRecord($details= array()){


}