<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
* Added Awesomeness: Fridah Gacheri Mugambi
*
* Requirements: PHP5 or above
*
*/
class Datautility extends CI_Controller {

	public $displayData;

	function __construct(){
		parent::__construct();
		isloggedin(TRUE);
	}




	function deleterecord($table, $recId){
		$reffererpage =  reffererpage();
		if ($reffererpage == '') {
		 		$reffererpage = 'Dashboard';
		} 	
    	if (deletedbtablerecord($table, $recId)) {
    		if (isajaxrequest()) {
    			echo "1";
    		}
    		else{
    			setflashnotifacation('message', maticon('delete', 'medium').'</br> Record deleted');
    			
    		}
    	}
	}


	function permanentdelete($table, $recId){
    	
	}



}