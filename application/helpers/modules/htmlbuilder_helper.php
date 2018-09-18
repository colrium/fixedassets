<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  html_builder
*
* Version: 1.0
*
* Author: Collins Mutugi Riungu
*		  colrium@gmail.com
*         @mutugiriungu
*
* Added Awesomeness: Fridah Gacheri Mugambi
*
* Requirements: PHP5 or above
*
*/
if (!function_exists('html_builder')) {
	function html_builder($params=array()){
		$CI = &get_instance();
		$title = 'Layout Builder';
		$builderdomid = 'layoutbuilder';

			$displaydata = array();
			$displaydata['title']        = $title;
			$displaydata['pageTitle'] 	= CENUM_DASHBOARD_CHIP.''.CENUM_CHIP_POINTER.''.mdlchip($title);
			$displaydata['builderdomid'] = $builderdomid; 
			$displaydata['mainTemplate'] = 'utilities/layoutbuilder';
			$displaydata['nav'] = $CI->mnav_brain_jar->navData('modules');
			$CI->load->vars($displaydata);
			$CI->load->view('template');		
		return $layout;
	}
}
