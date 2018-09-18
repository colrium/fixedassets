<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mail extends CI_Controller {

	function __construct(){
		parent::__construct();	
		$this->load->helper('file');
	}
	
	function index(){
		$this->filesanddirectories();
			
	}

	function responsive(){
		$templatetext = read_file('./catalog/templates/mail/responsive.html');
		$colorprimary = getcolor(0);
		$coloraccent = getcolor(0);
		$templatetext = str_replace("#3498db", $colorprimary, $templatetext);
		$templatetext = str_replace("#3498DB", $colorprimary, $templatetext);

		echo $templatetext;
	}

	function cerberusfluid(){
		$templatetext = read_file('./catalog/templates/mail/cerberusfluid.html');
		$colorprimary = getcolor(0);
		$coloraccent = getcolor(0);
		$templatetext = str_replace("#709f2b", $colorprimary, $templatetext);

		echo $templatetext;
	}

	function editfile($file){
		$displayData['title']        = 'Editor';
		$displayData['pageTitle']    = '<span class="mdl-chip waves-effect modules-chip"><span class="mdl-chip__contact '.getcolorclass(10).'"></span><span class="mdl-chip__text">Editor</span> </span>'.' '.mdlmediachip(maticon('folder_open', getcolorclass(5).' normal-text'), '<small class="'.getcolorclass(5).'"> '.date('l, FdS Y H:i').'</small>', 'class="mdl-chip waves-effect waves-light '.getcolorclass().'"');
		$displayData['mainTemplate'] = 'utilities/editor';
		$displayData['nav'] = '';		      
		renderpage($displayData);
	}































}