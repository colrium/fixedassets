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
      $this->displayData['nav'] = $this->mnav_brain_jar->navData('assistant');
	}

	public function index(){
		$this->files();
	}


	public function files(){
		$this->displayData['title']        = 'File Manager';
		$this->displayData['pageTitle']    = breadcrumb(maticon('folder', 'chipicon').' File Manager');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'/files/filemanager';
		renderpage($this->displayData);
	}

	public function entityfiles($entity='all', $recId='0'){
		$this->displayData['title']        = 'File Manager';
		$this->displayData['pageTitle']    = breadcrumb(maticon('folder', 'chipicon').' File Manager');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'/files/filemanager';
		renderpage($this->displayData);
	}




}