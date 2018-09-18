<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
* Requirements: PHP5 or above
*
*/
class Mpesa extends CI_Controller {

	public $displayData = array();

	function __construct(){
		parent::__construct();
		$this->displayData['module'] = 'ngo';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($this->displayData['module']);
		$this->displayData['entitiesicons'] = dbmoduletableicons($this->displayData['module']);
		$this->displayData['entitiesnames'] = dbmoduletablenames($this->displayData['module']);
	}

	function c2bvalidate(){
		$response = array();
		$token = $this->input->get('token', TRUE);
		if ($token) {
			//ToDo validate

			

			//accept transaction
			$response['ResultCode'] = 0;
			$response['ResultDesc'] = 'Success';
			$response['ThirdPartyTransID'] = '1';
			$this->output->set_header('HTTP/1.0 200 OK')->set_header('HTTP/1.1 200 OK')->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($response, JSON_UNESCAPED_SLASHES))->_display();
			exit;
		}
		else{
			echo "Error. Token not set";
			exit();
		}
		
	}

	function c2bconfirm(){
		
	}

	





















}