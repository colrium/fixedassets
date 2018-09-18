<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	function validatebrowser(){
		$CI = & get_instance();
		$CI->load->library('user_agent');
		$supported = FALSE;
		if ($CI->agent->is_browser()){
		        $agent = $CI->agent->browser().' '.$CI->agent->version();
		        $supported = TRUE;
		}
		elseif ($CI->agent->is_robot()){
		        $agent = $CI->agent->robot();
		        $supported = TRUE;
		}
		elseif ($CI->agent->is_mobile()){
		        $agent = $CI->agent->mobile();
		        $supported = FALSE;
		}
		else{
		        $agent = 'Unidentified User Agent';
		}
		echo $agent;
	}