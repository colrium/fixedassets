<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Editor extends CI_Controller {

	function __construct(){
        parent::__construct();	
		$this->load->helper('url');
		$this->load->helper('file');

	}
	
	function index(){
		$this->filesanddirectories();
		    
	}

	function filesanddirectories(){
		$displayData['title']        = 'Editor';
		$displayData['pageTitle']    = '<span class="mdl-chip waves-effect modules-chip"><span class="mdl-chip__contact '.getcolorclass(10).'"></span><span class="mdl-chip__text">Editor</span> </span>'.' '.mdlmediachip(maticon('folder_open', getcolorclass(5).' normal-text'), '<small class="'.getcolorclass(5).'"> '.date('l, FdS Y H:i').'</small>', 'class="mdl-chip waves-effect waves-light '.getcolorclass().'"');
		$displayData['mainTemplate'] = 'utilities/editor';
		$displayData['nav'] = '';		      
		renderpage($displayData);
	}

	function editfile($file){
		$displayData['title']        = 'Editor';
		$displayData['pageTitle']    = '<span class="mdl-chip waves-effect modules-chip"><span class="mdl-chip__contact '.getcolorclass(10).'"></span><span class="mdl-chip__text">Editor</span> </span>'.' '.mdlmediachip(maticon('folder_open', getcolorclass(5).' normal-text'), '<small class="'.getcolorclass(5).'"> '.date('l, FdS Y H:i').'</small>', 'class="mdl-chip waves-effect waves-light '.getcolorclass().'"');
		$displayData['mainTemplate'] = 'utilities/editor';
		$displayData['nav'] = '';		      
		renderpage($displayData);
	}































}