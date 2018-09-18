<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Assistant extends CI_Controller {
	public $displayData = array();

	function __construct(){
      parent::__construct(); 
      isloggedin(TRUE);
      $this->load->helper(ASSISTANT_PREFIX.'spinner');
      $this->displayData['module'] = 'assistant';
      $this->displayData['nav'] = $this->mnav_brain_jar->navData('assistant');
	}

	public function index(){
	  $this->spinner();
	}

	public function addeditreminder($recId='0'){
		
		$this->displayData['title'] = ($recId > 0) ? 'Edit Reminder' : 'Add Reminder';
		$this->displayData['pageTitle'] = ($recId > 0) ? breadcrumb('Edit Reminder') : breadcrumb('Add Reminder');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'forms/addeditreminder';
		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			
		}
		renderpage($this->displayData);
	}



}