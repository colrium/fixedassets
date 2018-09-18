<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

require_once APPPATH."/third_party/PHPExcel.php";

class Xlsimport extends PHPExcel{


	public function __construct(){
   		parent::__construct();
	}


	public function __get($var){
	    return get_instance()->$var;
	}

	public function getworkbooksheets($filepath){
		$returndata = array();
		if(file_exists($filepath)){
	        //read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($filepath);
			//extract to a PHP readable array format
			$returndata = $objPHPExcel->getSheetNames();
		}
		return $returndata;
		
	}

	public function get_array($filepath, $dbfile = TRUE){
		$att_id = $filepath;
		// If file exists, set filepath
		if ($dbfile) {
			$attachment = dbtablerecord($filepath, 'attachments');
			$file = fopen($attachment->file_dir, 'w');
			fwrite($file, base64_decode($attachment->file));
			fclose($file);
			$filepath = $attachment->file_dir;
		}
        if(file_exists($filepath)){
        	$returndata = array();
        	//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($filepath);
			//extract to a PHP readable array format
			$filedata = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
			$headers = $this->get_column_headers($filepath, $dbfile);

			foreach ($filedata as $key => $value) {
				$rowData = array();
				if ($key > 0) {
					foreach ($value as $cellkey => $cellvalue) {
						$rowData[$headers[$cellkey]] = $cellvalue;
					}
					array_push($returndata, $rowData);
				}					
				
			}
			return $returndata;
        }
        else{
        	return FALSE;
        }
	}

	public function get_cell_headers($filepath, $dbfile = TRUE){
		$att_id = $filepath;
		if ($dbfile) {

			$attachment = dbtablerecord($filepath, 'attachments');
			$file = fopen($attachment->file_dir, 'w');
			fwrite($file, base64_decode($attachment->file));
			fclose($file);
			$filepath = $attachment->file_dir;
		}
		// If file exists, set filepath
        if(file_exists($filepath)){
        	$headers =array();
        	//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($filepath);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			//extract to a PHP readable array format
			foreach ($cell_collection as $cell) {
			    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
			    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
			    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
			    //header will/should be in row 1 only. of course this can be modified to suit your need.
			    if ($row == 1) {
			    	$headers[$column] = $data_value;
			    } else {
			        break;
			    }
			}
			return $headers;
        }
        else{
        	return FALSE;
        }
	}

	public function get_column_headers($filepath, $dbfile = TRUE){
		if ($dbfile) {
			$attachment = dbtablerecord($filepath, 'attachments');
			$file = fopen($attachment->file_dir, 'w');
			fwrite($file, base64_decode($attachment->file));
			fclose($file);
			$filepath = $attachment->file_dir;
		}
		// If file exists, set filepath
        if(file_exists($filepath)){
        	$headers =array();
        	//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($filepath);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			$filedata = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
			$headers = $filedata[0];
			
			return $headers;
        }
        else{
        	return FALSE;
        }
	}

	public function get_totalrows($filepath, $dbfile = TRUE){
		if ($dbfile) {
			$attachment = dbtablerecord($filepath, 'attachments');
			$file = fopen($attachment->file_dir, 'w');
			fwrite($file, base64_decode($attachment->file));
			fclose($file);
			$filepath = $attachment->file_dir;
		}
		// If file exists, set filepath
        if(file_exists($filepath)){
        	//read file from path
			$objPHPExcel = PHPExcel_IOFactory::load($filepath);
			//get only the Cell Collection
			$cell_collection = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			return sizeof($cell_collection)-1;
        }
        else{
        	return 0;
        }
	}


	public function get_samplerows($filepath, $dbfile = TRUE){

		$total = $this->get_totalrows($filepath);
		$headers = $this->get_column_headers($filepath);
        $sampleSize = 10;
        $sampleData = array();
        if ($total > 10) {
            $sampleSize = floor(0.1*$total);
        }
        else{
            $sampleSize = $total;
        }
        
        if ($dbfile) {
        	$data = $this->get_array($filepath);
        	$index = 0;
        	foreach ($data as $key => $value) {
        		if ($index < $sampleSize) {
        			$sampleData[$key] = $value;
        		}
        		else{
        			break;
        		}
        		$index++;
        	}

        	return $sampleData;
        }
        else{
        	// If file exists, set filepath
	        if(file_exists($filepath)){
	        	$data = $this->get_array($filepath);
	        	$index = 0;
	        	foreach ($data as $key => $value) {
	        		if ($index < $sampleSize) {

	        			$sampleData[$key] = $value;
	        		}
	        		else{
	        			break;
	        		}
	        		$index++;
	        	}

	        	return $sampleData;
	        }
	        else{
	        	return array();
	        }
        }
			

	}





















}