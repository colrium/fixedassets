<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Functions extends CI_Controller {

	function __construct(){

      parent::__construct();      
      $displayData = array();
      $this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      $this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');
      $this->load->model('mstart', 'clsStrt');
		
   }


public function importCsvForm(){
	error_reporting(E_ALL);
	$this->load->library('csvimport');
	$entity = $this->input->post('import-target');
	$importfile = $this->input->post('selected-assetscsv-filer');
    $uploaded_file_path = './catalog/imports/'.$importfile;      

        // If upload failed, display error
        if ($importfile=="none") {
            setflashnotifacation('error', "Please select a file to import and wait for the file to upload");  
            preredirect(FIXEDASSETS_PREFIX.'Dashboard');           
        } 
        else {
                $totalrows = $this->csvimport->get_totalrows($uploaded_file_path);
                setflashnotifacation('message', maticon('line_weight', 'medium').'<br>File read successfully. <br>CSV Contains: '.$totalrows.' Records');
                preredirect(FIXEDASSETS_PREFIX.'functions/Functions/defineImport/'.$importfile.'/assetlist');
                //echo "<pre>"; print_r($insert_data);
        }


}

public function defineImport($filename="", $entity=""){
	$this->session->unset_userdata('importProgress');
	$destination = "";
	$filename = str_replace('%20', ' ', $filename);
	if ($filename=="") {
		setflashnotifacation('error', 'Please Select a CSV File containing your list of assets');
                preredirect(FIXEDASSETS_PREFIX.'Dashboard');
	}
	else {

		if ($entity=="assetlist" || $entity=="employeelist") {
			if ($entity=="assetlist") {
				$destination = 'Fixed Assets Database';
			}
			elseif ($entity=="employeelist") {
				$destination = 'Employees Database';
			}
			$csv_array = array();
			//read file
			$this->load->library('csvimport');
			$file_path =  './catalog/imports/'.$filename;
			//read Csv File			
            $csv_column_headers = $this->csvimport->get_column_headers($file_path);
            $csv_array = $this->csvimport->get_totalrows($file_path);
			$fields = array();
			$field = array();

			foreach ($this->clsStrt->getFormFields('fixedassets_assetlist') as $fieldRec) {
				if ($fieldRec->initialName!='assetID') {
					$field = array('name' =>$fieldRec->setName, 'value'=>$fieldRec->initialName);
					array_push($fields, $field);
				}
				
			}

			

		 	  $csvRecords = $csv_array;
		 	  $displayData['title']        = 'Import Csv';
		 	  $displayData['pageTitle']    = ' '.breadcrumb(' Import '.$filename);
		      $displayData['filename']    = $filename;
		      $displayData['records']    = $csvRecords;
		      $displayData['destination']    = $destination;
		      $displayData['entity']    = $entity;
		      $displayData['fields']    = $fields;
		      $displayData['csv_headers']    = $csv_column_headers;
		      $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'forms/importDefine';
		      $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
			  $displayData['module'] = 'fixedassets';
		      
		      renderpage($displayData);
		      
		}
		// else not assetlist or employee list
		else{
			setflashnotifacation('error', 'Please Select Import Records destination');
            preredirect(FIXEDASSETS_PREFIX.'Dashboard');
		}
		
		   }
		
	}




function emptyDatabase(){	
	if ($this->clsFunc->emptyDatabase()) {
		$viewSelection = array('loadcriteria'=>"all", 'loadcriteriaid'=>"0", 'loadcriteriaName'=>"All Assets");
		$this->session->set_userdata($viewSelection);
		setflashnotifacation('message', maticon('delete_sweep', 'medium').'<br>Database Emptied'); 
                preredirect('Dashboard'); 
	}

	else{
		setflashnotifacation('error', maticon('delete_sweep', 'medium').'<br>Database Empty Error'); 
                preredirect('Dashboard'); 
	}
}

public function backupdatabase(){
	$displayData['title']        = 'Backup Database';
	$displayData['pageTitle']    = ' '.breadcrumb('Backup Database');
	//check if any data has been posted
	$posteduserData = $this->input->post(NULL, FALSE);

	//if data has been posted
	if (sizeof($posteduserData)>0) {
		$filename = $this->input->post('filename');
		$filetype = $this->input->post('filetype');

		$backup = $this->clsFunc->backupdatabase();
		if ($backup != FALSE) {
			if ($filetype=='txt') {
				$filename = $filename.'.sql';
			}
			else if ($filetype=='zip') {
				$filename = $filename.'.zip';
			}
			else{
				$filename = $filename.'.gz';
			}
			$displayData['strmessage'] = 'Database Backed Up Successfully';
			$this->load->helper('file');
			write_file('./catalog/dbbackups/'.$filename, $backup);

			// Load the download helper and send the file to your desktop
			$this->load->helper('download');
			force_download($filename, $backup);
		}

		else{
			$displayData['strerror'] = 'Database Backup Error';
		}
	}
		$displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'forms/backupdb';
		$displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
		$displayData['module'] = 'fixedassets';		      
		renderpage($displayData);
		
}







}
?>