<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
use PhpOffice\PhpSpreadsheet\IOFactory;

class Spreadsheets {
	public $reader;
	public $spreadsheet;
	public $initialized;

	public function __construct(){
		$this->initialized = FALSE;
	}


	public function __get($var){
	    return get_instance()->$var;
	}

	
	public function workbook($filepath){
		$returndata = FALSE;
		if(file_exists($filepath)){
			$fileext = ucfirst(fileExtension($filepath));
	        //read file from path
			$this->reader = IOFactory::createReader($fileext);
			$this->reader->setReadDataOnly(true);
			$this->spreadsheet = $this->reader->load($filepath);
			$this->initialized = TRUE;
	        $returndata = TRUE;
		}
		return $returndata;
	}

	public function workbookdata($headerindexes=TRUE){
		$returndata = array();
		if($this->initialized){
			$spreadsheetdata = $this->spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	        $returndata = $spreadsheetdata;
	        if ($headerindexes) {
	        	$returndata = $this->headerindexesdata($spreadsheetdata);
	        }
		}
		return $returndata;
	}

	public function worksheetdimension(){
		$returndata = array('start'=>'A1', 'end'=>'A1');
		if($this->initialized){
			$spreadsheetdimension = $this->spreadsheet->getActiveSheet()->calculateWorksheetDimension();
			$spreadsheetdimension = strtoupper($spreadsheetdimension);
			$colon = strrpos($spreadsheetdimension, ':');
			$returndata['start'] = ($colon === FALSE)? 'A1': substr($spreadsheetdimension, 0, $colon);
			$returndata['end'] = ($colon === FALSE)? 'A1': substr($spreadsheetdimension, $colon + 1);
		}
			
		return $returndata;
	}

	public function worksheetcolumndimension(){
		$returndata = array();
		$dimension = $this->worksheetdimension();
		$returndata['start'] = str_replace(range(0,9), '', $dimension['start']);
		$returndata['end'] = str_replace(range(0,9), '', $dimension['end']);
		return $returndata;
	}

	public function worksheetrowdimension(){
		$returndata = array();
		$dimension = $this->worksheetdimension();
		$returndata['start'] = str_replace(range('A','Z'), '', $dimension['start']);
		$returndata['end'] = str_replace(range('A','Z'), '', $dimension['end']);
		return $returndata;
	}


	public function dataheaders($numericindexes = TRUE){
		$returndata = array();
		if($this->initialized){
			$rowsdimension = $this->worksheetrowdimension();			
			$spreadsheetdata = $this->spreadsheet->getActiveSheet()->toArray(null, true, true, true);
			$headerrow = $spreadsheetdata[$rowsdimension['start']];
			if (is_array($headerrow)) {
				$returndata = $headerrow;
				if ($numericindexes) {
					$returndata = array();
					foreach ($headerrow as $key => $value) {
						array_push($returndata, $value);
					}
				}
			}
				
			
		}
		return $returndata;
	}

	public function workbooksheets(){
		$returndata = array();
		if($this->initialized){
	        $returndata = $this->spreadsheet->getSheetNames();
		}
		return $returndata;		
	}

	public function databysheetname($sheetname, $headerindexes=TRUE){
		$returndata = array();
		if($this->initialized){
	        $spreadsheetdata = $this->spreadsheet->getSheetByName($sheetname)->toArray(null, true, true, true);
	        $returndata = $spreadsheetdata;
	        if ($headerindexes) {
	        	$returndata = $this->headerindexesdata($spreadsheetdata);
	        }
		}
		return $returndata;
	}

	public function databysheetindex($sheetindex, $headerindexes=TRUE){
		$returndata = array();
		if(file_exists($filepath)){
	        $spreadsheetdata = $this->spreadsheet->getSheet($sheetindex)->toArray(null, true, true, true);
	        $returndata = $spreadsheetdata;
	        if ($headerindexes) {
	        	$returndata = $this->headerindexesdata($spreadsheetdata);
	        }
		}
		return $returndata;
	}

	public function headerindexesdata($data, $headerindex=1){
		$lastindex = sizeof($data);
		$firstindex = $headerindex+1;
		$headerscolumns = $data[$headerindex];
		$returndata = array();
		for ($i=$firstindex; $i <= $lastindex; $i++) {
			$row = array();
			foreach ($data[$i] as $cell => $value) {
				$row[$headerscolumns[$cell]] = $value;
			}
			array_push($returndata, $row);
		}
		return $returndata;
	}
} 

?>