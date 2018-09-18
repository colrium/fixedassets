<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
// author: Mutugi Riungu
---------------------------------------------------------------------*/


class Events  extends CI_Controller {

	private $displayData;
	public $pageDetails;

	function __construct(){
		parent::__construct();				
		$this->displayData = array();
		$this->displayData['module'] = 'events';
		$this->load->model('data', 'clsData');


	}


	public function index(){
		$this->displayData['title']        = 'Module Dashboard';
		$this->displayData['pageTitle']    = ''.CENUM_CHIP_POINTER.''.breadcrumb('Dashboard');
		$this->displayData['mainTemplate'] = EVENTS_PREFIX.'frontend/modules/dashboard';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData('events_frontend');      
		renderpage($this->displayData);
		$this->load->view(EVENTS_PREFIX.'frontend/template');
	}

	public function page($page){

	}



}