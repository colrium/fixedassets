<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function checkforupdate(){
	//load codeigniter instance
	$CI = & get_instance();

	$updateavailable = FALSE;

	$CI->load->library('xmlrpc');
	$this->xmlrpc->server('http://localhost/fortmodules', 80);



	return $updateavailable;
}


function updatesystem(){
	$CI = & get_instance();
	$CI->config->load('mod_config');
}

