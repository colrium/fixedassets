<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
* Requirements: PHP5 or above
*
*/
class Notifacations extends CI_Controller{

	public $displayData, $socketserver;

	function __construct(){
		parent::__construct();
		$this->displayData['module'] = 'assistant';
    	$this->displayData['nav'] = $this->mnav_brain_jar->navData('assistant');
	
	}

	function index(){
		$msg = "Ping !";
	    $len = strlen($msg);

	}

	function notifacations(){
		isloggedin(TRUE);
		$this->displayData['records'] = ASSISTANT_PREFIX.'notifacations/notifacations';
		$this->displayData['title'] = 'Notifacations';
		$this->displayData['pageTitle'] = breadcrumb('Notifacations');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'notifacations/notifacations';
		renderpage($this->displayData);
	}

	function notifacation($recId){
		isloggedin(TRUE);
		$this->displayData['title'] = 'Notifacation';
		$this->displayData['pageTitle'] = breadcrumb('Notifacation');
		$this->displayData['mainTemplate'] = ASSISTANT_PREFIX.'notifacations/notifacation';
		renderpage($this->displayData);
	}

	function getnotifacations($module=FALSE, $notifyentity=FALSE, $notifyentityid=FALSE){
		$allnotifacations = array();
		if (isloggedin(FALSE)) {
			$allnotifacations["unseen"] = getnotifacations($module, $notifyentity, $notifyentityid, TRUE);
	    	$allnotifacations["seen"] = getnotifacations(FALSE);
		}	    	
    	$this->output->set_status_header(200)->set_content_type('application/json', 'utf-8')->set_output(json_encode($allnotifacations, JSON_UNESCAPED_SLASHES))->_display();
	}

    function addnotifacation(){
        
    }
    function markasinappnotified($recId){
    	$params =  array();
    	$params['where']['equalto'] = array('notifacation'=>$recId, 'notifacationseen'=>0, 'notifyentityid'=>USERID);
        $notifylist = dbtablerecords('notifacations_notifylist', $params, FALSE, FALSE);
        if (is_array($notifylist)) {
        	foreach ($notifylist as $notify) {
        		$notify->notifacationseen = 1;
        		$notify->desktopnotified = 1;
        		$notify->dateseen = date('Y-m-d H:i:s');
        		$detailsarr = objecttoarrayrecursivecast($notify);
        		$notifyid = addupdatedbtablerecord('notifacations_notifylist', $detailsarr, $notify->id, FALSE, FALSE);
        	}
        }
        echo "1";
    }
	function togglenotifacations(){
		passthru('msg * "Hey there!"');
		
	}

	function adddbrecordreminder($entity, $recId){
		$postedData = $this->input->post(NULL, FALSE);
	    if (sizeof($postedData) > 0) {
	    	print_r($postedData);
	    	$data =array();


	    }


	}

	function reminderrecorddetails($entity, $recId){
		$details = array();
		$tablefields = dbtablefields($entity);
		$tablepkcolumn = dbtablepkcolumn($entity);
		$details['erroroccured'] = false;
		$details['message'] = array('icon'=>'check', 'alert'=>'Success. Record fetched');
		
		if (is_object($tablepkcolumn)) {
			$details['dbidcolumn'] = $tablepkcolumn->initialName;
			$idcolumns = explode(',', $tablepkcolumn->initialName);
			if ($recId != '0') {
		         if (dbtablerecordexists($recId, $entity)) {	
		            $details['recordname'] = dbtablerecordname($entity, $recId);
		            $details['recorddata'] = dbtablerecord($recId, $entity);

		         }
		         else{
		         	$details['erroroccured'] = true;
					$details['message'] = array('icon'=>'link', 'alert'=>'Sorry! Record does not exist');
		         }
		    }
		    else{
		    	$details['erroroccured'] = true;
				$details['message'] = array('icon'=>'block', 'alert'=>'Sorry! Record Id Cannot be 0');
		    }
		    $details['users'] = dbtablerecords('users');
		}
		else{
			$details['erroroccured'] = true;
			$details['message'] = array('icon'=>'memory', 'alert'=>'Sorry! Could not get entity id column');
		}

		
			

	    echo json_encode($details);
	}




















}