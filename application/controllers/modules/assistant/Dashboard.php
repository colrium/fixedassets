<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Dashboard extends CI_Controller {
	public $displayData = array();

	function __construct(){
      parent::__construct(); 
      isloggedin(TRUE);
      $this->displayData['module'] = 'assistant';
      $this->displayData['nav'] = $this->mnav_brain_jar->navData('assistant');
	}

	public function index(){
		$this->displayData['title']        = 'Assistant';
		$this->displayData['pageTitle']    = breadcrumb('Dashboard');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'dashboard';
		renderpage($this->displayData);
	}



}