<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
// author: Mutugi Riungu
---------------------------------------------------------------------*/


class Tasks  extends CI_Controller {

	private $displayData;
	public $pageDetails;

	function __construct(){
		parent::__construct();				
		$this->displayData = array();
		isloggedin(TRUE);      
		$this->displayData['module'] = 'assistant';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($this->displayData['module']);
		$this->displayData['entitiesicons'] = dbmoduletableicons($this->displayData['module']);
		$this->displayData['entitiesnames'] = dbmoduletablenames($this->displayData['module']);


	}


	public function index(){
		$this->displayData['title']        = 'Tasks';
		$this->displayData['pageTitle']    = breadcrumb('Dashboard');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'content/tasks'; 
		renderpage($this->displayData);
	}

	public function page($page){

	}



}