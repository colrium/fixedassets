<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/


function importrecord($table, $data= array()){
	$success= "0";
	$newRecId = importrecordtodbtable($table, $data);
	if ($newRecId>0) {					
			$success= "1";
	}
	return $success;
}