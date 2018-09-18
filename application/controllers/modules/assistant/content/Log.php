<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Log extends CI_Controller {
	public $displayData = array();

	function __construct(){
      parent::__construct(); 
      isloggedin(TRUE);
      $this->displayData['module'] = 'assistant';
      $this->displayData['nav'] = $this->mnav_brain_jar->navData('assistant');
	}

	public function index(){
		$this->view();
	}

	public function actions(){
		$table = 'actions_log';		
		$records = dbtablerecords($table, $params, FALSE, TRUE);
		$this->displayData['records'] = $records;
		$this->displayData['tablefields'] = dbtablefields($table);
		$this->displayData['title']        = 'Actions';
		$this->displayData['pageTitle']    = breadcrumb('Recyclebin');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'content/recyclebin';

		renderpage($this->displayData);
	}
	public function recordactionslog($entity, $recId){
		setflashnotifacation('message', array('icon'=>'history', 'alert'=>'Record Restored'));
        preredirect(ASSISTANT_PREFIX.'content/Recyclebin');
	}
	




}