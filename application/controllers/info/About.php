<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct(){
      parent::__construct();
   }



public function index(){
	$displayData['title']        = 'About';
    $displayData['pageTitle']    = '<span class="mdl-chip"><span class="mdl-chip__text">Dashboard</span></span> '.maticon('trending_flat', 'normal-text').' <span class="mdl-chip"><span class="mdl-chip__text" id="viewing"></span></span>';
    $displayData['mainTemplate'] = 'info/about';
    $displayData['nav'] = $this->mnav_brain_jar->navData('dashboard');
      
    renderpage($displayData);
    

}














}