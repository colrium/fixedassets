<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Recyclebin extends CI_Controller {
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

	public function view(){
		$table = 'recyclebin';
		$params = array();
		$params['select'] = array('field_names'=>array('module', 'parentTable', 'parentTableName', 'parentTableIdColumns'));
		$params['joins'] = array('field_names'=>array('entity'=>'parentTable'));
		if (!isadmin(FALSE)) {
			$params['where']['equalto'] = array('user'=>USERID);
		}
		$params['orderby'] = $table.'.timestamp ASC';
		$records = dbtablerecords($table, $params, FALSE, TRUE);
		$this->displayData['records'] = $records;
		$this->displayData['tablefields'] = dbtablefields($table);
		$this->displayData['title']        = 'Recyclebin';
		$this->displayData['pageTitle']    = breadcrumb('Recyclebin');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'content/recyclebin';

		renderpage($this->displayData);
	}
	public function restore($recId){
		$restored = recyclebinrestore($recId);
		setflashnotifacation('message', array('icon'=>'history', 'alert'=>'Record Restored'));
        preredirect(ASSISTANT_PREFIX.'content/Recyclebin');
	}
	public function deletepermanently($recId){
		$table = 'recyclebin';
		$deleted = deletedbtablerecord($table, $recId, TRUE);
		setflashnotifacation('message', array('icon'=>'delete', 'alert'=>' Record Deleted permanently'));
        preredirect(ASSISTANT_PREFIX.'content/Recyclebin');
	}




}