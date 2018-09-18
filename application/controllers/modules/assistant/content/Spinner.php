<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Spinner extends CI_Controller {
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

	public function spinner(){
		$this->displayData['title']        = 'Assistant';
		$this->displayData['pageTitle']    = breadcrumb("Article Spinner");
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'/content/spinner';
		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			$spintext = $this->input->post('spintext');
			$wordoptions = $this->input->post('wordoptions');

			if ($wordoptions == '1') {
				$this->displayData['spuntext'] = addenglishtextalternatives($spintext, TRUE);
			}
			else{
				$optionedspintext = addenglishtextalternatives($spintext, FALSE);
				$this->displayData['spuntext'] = spinenglishtext($optionedspintext);
			}

			$this->displayData['originaltext'] = $spintext;

		}
		renderpage($this->displayData);
	}



}