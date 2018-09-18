<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Filemanager extends CI_Controller {
	public $displayData = array();

	function __construct(){
		parent::__construct(); 
		isloggedin(TRUE);      
		$this->displayData['module'] = 'assistant';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($this->displayData['module']);
	}

	public function index(){
		$imagesparams = array();
		$imagesparams['where']['equalto'] = array('isimage'=>'1');
		$records = dbtablerecords('attachments', array(), FALSE, TRUE);
		$this->displayData['records'] = $records;
		$this->displayData['title']        = 'File Manager';
		$this->displayData['pageTitle']    = breadcrumb("File Manager");
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'/content/filemanager';
		renderpage($this->displayData);
	}

	public function files(){
		
	}



}