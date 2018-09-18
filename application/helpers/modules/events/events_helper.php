<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function getdateevents($date){
		$CI =& get_instance();

	}

	function getmonthevents($year, $month){
		$CI =& get_instance();
		$CI->load->model(EVENTS_PREFIX.'mdata', 'clsEvData');
		return $CI->clsEvData->getmonthevents($month, $year);
	}

	function getyearevents($year){
		$CI = & get_instance();
	}

	function generateticket($details=array()){

	}