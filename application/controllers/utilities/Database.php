<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Database extends CI_Controller {
	function __construct(){
		parent::__construct();
		isloggedin(TRUE);
		$displayData = array();
		$this->load->model('data', 'clsData');
		$this->load->model('utilities/mdatabase', 'clsDB');
	}



	function index(){
		backupdb();		
	}

	function backupdb($module='fixedassets'){
		$displayData['title']        = 'Backup Database';
		$displayData['pageTitle']    = breadcrumb('Backup Database');
		//check if any data has been posted
		$posteduserData = $this->input->post(NULL, FALSE);

		//if data has been posted
		if (sizeof($posteduserData)>0) {
			$filename = $this->input->post('filename');
			$filetype = $this->input->post('filetype');

			$backup = $this->clsDB->backupdatabase($module);
			if ($backup != FALSE) {
				if ($filetype=='txt') {
					$filename = $filename;
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
			$displayData['mainTemplate'] = 'utilities/backupdb';
			$displayData['nav'] = $this->mnav_brain_jar->navData('modules');		      
			renderpage($displayData);
			
	}

	function emptyDatabase($module='fixedassets'){
		$refererpage = reffererpage();
		$requestingUrl = 'Dashboard';
		if ($refererpage != '') {
			$requestingUrl = $refererpage;
		}

		if (emptymoduledb($module)) {
			$viewSelection = array('loadcriteria'=>"all", 'loadcriteriaid'=>"all");
			$this->session->set_userdata($viewSelection);
			setflashnotifacation('message', array('icon'=>'delete_sweep', 'alert'=>'Database Emptied.')); 
			preredirect($requestingUrl); 
		}

		else{
			setflashnotifacation('message', array('icon'=>'delete_sweep', 'alert'=>'Database Empty Error.'));
			preredirect($requestingUrl);
		}


	}

	function deleterecord($table, $recId){
		$refererpage = reffererpage();
		$requestingUrl = 'Dashboard';
		if ($refererpage != '') {
			$requestingUrl = $refererpage;
		}
		$tablename = dbmoduletablename($table);
		if (deletedbtablerecord($table, $recId)) {
			setflashnotifacation('message', array('icon'=>'delete_sweep', 'alert'=>$tablename.' Record Deleted'));
			preredirect($requestingUrl); 
		}

		else{
			setflashnotifacation('error', array('icon'=>'error', 'alert'=>$tablename.' Record Delete Failed'));
			preredirect($requestingUrl);
		}


	}

	function restoredb(){
		$posteduserData = $this->input->post(NULL, FALSE);
		if (sizeof($posteduserData)>0) {
			$filename = $this->input->post('selected-restoresqlfile');
			$restoredb = $this->clsDB->restoredbfromsqlfile($filename);
			if ($restoredb) {
				setflashnotifacation('message', array('icon'=>'check_circle', 'alert'=>'Database Restored Successfully.'));
				preredirect('Dashboard'); 
			}

			else{
				setflashnotifacation('error', array('icon'=>'check_circle', 'alert'=>'Database Restore Failed.'));
				preredirect('Dashboard');
			}
		}
		
	}

	function optimizedb(){
		if ($this->clsDB->optimizedb()) {
			setflashnotifacation('message', array('icon'=>'check_circle', 'alert'=>'Database Optimized Successfully.'));
			preredirect('Dashboard'); 
		}

		else{
			setflashnotifacation('error', array('icon'=>'error', 'alert'=>'Database Optimization failed Failed.'));
			preredirect('Dashboard');
		}
	}

}