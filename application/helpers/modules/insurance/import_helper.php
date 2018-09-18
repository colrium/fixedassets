<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

function importclientrecord($details= array()){
	$CI = & get_instance();
	$fieldData = "";
	$success= "0";
	$saveArray = array();
	$recId = 0;
		foreach ($details as $key => $value) {
			$value = trim($value);
			$fielddetails = $CI->fieldnames->getFormField($key, "insurance_clients");
			$field = $fielddetails;
			if ($field->isFK) {						
				if ($value != "") {
					$celldata = $CI->datalib->sanitizeString($value);
					$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, $celldata, $field->fkTableRecPK,  true);
				}
				else{
					$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, 'None', $field->fkTableRecPK, true);
				}
			}
			else{
				if (strlen($value)>0) {
					if ($key == 'clientName') {
						$recId = $CI->datalib->dataExists('insurance_clients', 'clientName', $value, 'clientId', false);
					}
					if($key == 'clientNationality'){
						if (!array_key_exists('clientCurrency', $details)) {
							$saveArray['clientCurrency'] = $CI->datalib->dataExists('countries', 'name', $value, 'id', false);
						}
					}
					if ($field->dataType=="date") {
						$fieldData = strPrepDate($value);
					}
					else if ($field->dataType=="int") {
						$fieldData =  $CI->datalib->sanitizeInt($value);
					}
					else if ($field->dataType=="decimal") {
						$fieldData =  $CI->datalib->sanitizeDecimal($value);
					}
					else{
						$fieldData =  $value;
					}
				}
				else{
					$fieldData = '';
				}
			}
			if ($fieldData != '' && $fieldData != 'NULL') {
				$saveArray[$key] = $fieldData;
			}
		}
		$newRecId = addupdatedbtablerecord('insurance_clients', $saveArray, $recId);
		if ($newRecId != FALSE) {					
			$success= "1";
		}

		return $newRecId;
}




function importinsurerrecord($details= array()){
	$CI = & get_instance();
	$fieldData = "";
	$success= "0";
	$saveArray = array();
	$recId = 0;
		foreach ($details as $key => $value) {
			$value = trim($value);
			$fielddetails = $CI->fieldnames->getFormField($key, "insurance_insurers");
			$field = $fielddetails;
			if ($field->isFK) {						
				if ($value != "") {
					$celldata = $CI->datalib->sanitizeString($value);
					$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, $celldata, $field->fkTableRecPK,  true);
				}
				else{
					$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, 'None', $field->fkTableRecPK, true);
				}
			}
			else{
				if (strlen($value)>0) {
					if ($key == 'clientName') {
						$recId = $CI->datalib->dataExists('insurance_insurers', 'clientName', $value, 'clientId', false);
					}
					if($key == 'clientNationality'){
						if (!array_key_exists('clientCurrency', $details)) {
							$saveArray['clientCurrency'] = $CI->datalib->dataExists('countries', 'name', $value, 'id', false);
						}
					}
					if ($field->dataType=="date") {
						$fieldData = strPrepDate($value);
					}
					else if ($field->dataType=="int") {
						$fieldData =  $CI->datalib->sanitizeInt($value);
					}
					else if ($field->dataType=="decimal") {
						$fieldData =  $CI->datalib->sanitizeDecimal($value);
					}
					else{
						$fieldData =  $value;
					}
				}
				else{
					$fieldData = '';
				}
			}
			if ($fieldData != '' && $fieldData != 'NULL') {
				$saveArray[$key] = $fieldData;
			}
		}

		$newRecId = $CI->clsImport->importclientrecord($saveArray, $recId);
		if ($newRecId>0) {					
			$success= "1";
		}

		return $success;
}

function importpolicyrecord($details= array()){
	$CI = & get_instance();
	$fieldData = "";
	$success= "0";
	$saveArray = array();
	$recId = 0;
		foreach ($details as $key => $value) {
			$value = trim($value);
			$fielddetails = $CI->fieldnames->getFormField($key, "insurance_policies");
			$field = $fielddetails;
			if ($field->isFK) {						
				if ($value != "") {
					$celldata = $CI->datalib->sanitizeString($value);
					$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, $celldata, $field->fkTableRecPK,  true);
				}
				else{
					$fieldData = $CI->datalib->dataExists($field->tableFKname, $field->fkTableRecName, 'None', $field->fkTableRecPK, true);
				}
			}
			else{
				if (strlen($value)>0) {
					if ($key == 'clientName') {
						$recId = $CI->datalib->dataExists('insurance_policies', 'clientName', $value, 'clientId', false);
					}
					if($key == 'clientNationality'){
						if (!array_key_exists('clientCurrency', $details)) {
							$saveArray['clientCurrency'] = $CI->datalib->dataExists('countries', 'name', $value, 'id', false);
						}
					}
					if ($field->dataType=="date") {
						$fieldData = strPrepDate($value);
					}
					else if ($field->dataType=="int") {
						$fieldData =  $CI->datalib->sanitizeInt($value);
					}
					else if ($field->dataType=="decimal") {
						$fieldData =  $CI->datalib->sanitizeDecimal($value);
					}
					else{
						$fieldData =  $value;
					}
				}
				else{
					$fieldData = '';
				}
			}
			if ($fieldData != '' && $fieldData != 'NULL') {
				$saveArray[$key] = $fieldData;
			}
		}

		$newRecId = $CI->clsImport->importclientrecord($saveArray, $recId);
		if ($newRecId>0) {					
			$success= "1";
		}

		return $success;
}