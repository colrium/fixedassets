<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017	Collins Riungu
//
// author: Mutugi Riungu
---------------------------------------------------------------------*/

function generatemails($templateid, $records){
	$mails = array();
	$templatedetails = dbtablerecord($templateid, 'comm_mailtemplates');
	$entity = $templatedetails->entity;
	$entityfields = dbtablefields($entity);
	$shortcodes = array();
	foreach ($entityfields as $entityfield) {
		array_push($shortcodes, $entityfield->setName);
	}
	foreach ($records as $record) {
		$values = array();
		foreach ($entityfields as $entityfield) {
			$initialName = $entityfield->initialName;
			$values[$entityfield->setName] = $record->$initialName;
		}
		$custommailmessage = resolveshortcodes($templatedetails->template_body, $shortcodes, $values);
		array_push($mails, $custommailmessage);

	}
	return $mails;
}

function generatemail($templateid, $record){
	$mails = array();
	$templatedetails = dbtablerecord($templateid, 'comm_mailtemplates');
	$entity = $templatedetails->entity;
	$entityfields = dbtablefields($entity);
	$shortcodes = array();
	foreach ($entityfields as $entityfield) {
		array_push($shortcodes, $entityfield->setName);
	}
	$values = array();
	foreach ($entityfields as $entityfield) {
		$initialName = $entityfield->initialName;
		$values[$entityfield->setName] = $record->$initialName;
	}
	$custommailmessage = resolveshortcodes($templatedetails->template_body, $shortcodes, $values);
	return $custommailmessage;
}