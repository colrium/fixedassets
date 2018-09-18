<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function showsystemerror($errorcode, $others=array()){
	$displayData = array();
	$CI =& get_instance();
	$errormessage ='';
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red lighten-3';
	   if ($errorcode==1) {
		   $bgcolorclass = 'red darken-4';
		   $errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">UNAUTHORISED ACCESS</h1> <br><small class="white-text"><i>Sorry!! You must be in the least an administrator to access this element</i></small>';
		}
		else if ($errorcode==2){
		    $errormessage = maticon('block', 'large red-text').'<br> <h3 class="white-text"><i>Sorry!! You dont have access Rights for this element. Contact your system administrator for access rights.</i></h3>';
		    $bgcolorclass = 'red lighten-2';
		}

		else if ($errorcode==3){
		    $errormessage = maticon('block', 'large red-text').'<br> <h3 class="red-text"><i>Sorry!! That Record Does not Exist.</i></h3>';
		    $bgcolorclass = 'white';
		}

	   if (sizeof($others)>0) {
		   if (array_key_exists('background-color', $others)) {
		   		$bgcolorclass = $others['background-color'];
		   }
		   if (array_key_exists('message', $others)) {
		   		$errormessage = $others['message'];
		   }
		   if (array_key_exists('breadcrumb', $others)) {
		   		$breadcrumb = $others['breadcrumb'];
		   }
	   }
	   

	   $displayData['title']        = 'Error';
	   $displayData['bgcolorclass'] = $bgcolorclass;
	   $displayData['pageTitle']    = $breadcrumb;
	   $displayData['errormessage'] = $errormessage;
	   $displayData['mainTemplate'] = 'errors/system/viewerror';
	   $displayData['nav'] = $CI->mnav_brain_jar->navData();
	   $CI->load->vars($displayData);
	   $CI->load->view('template');
}


function showdatabaseerror($heading, $details=array()){
	$displayData = array();
	$CI = &get_instance();
	$errormessage = '<p>'.(is_array($details) ? implode('</p><p>', $details) : $details).'</p>';;
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Database Error');
	$bgcolorclass = 'red lighten-3';
	   $displayData['title']        = 'Error';
	   $displayData['bgcolorclass'] = $bgcolorclass;
	   $displayData['pageTitle']    = $breadcrumb;
	   $displayData['errormessage'] = $errormessage;
	   $displayData['mainTemplate'] = 'errors/database/databaseerror';
	   $displayData['nav'] = '';
	   $CI->load->vars($displayData);
	   $CI->load->view('template');
}


function unsavedcontenterror(){
	return '<div class="col s12 center-align">'.maticon('save', 'large red-text').'</br>'.headertxt(5, 'Save this new record first for this function to be available', 'class="full-width center-align red-text text-lighten-2"').'</div>';
}

function invalid_character_error($message) {
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Invalid Character</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}

function barcode_exception($message) {
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Barcode Exception</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}


function invalidcheckdigit_exception($message) {
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Invalid Check Date Exception</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}

function invalidformat_exception($message) {
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Invalid Check Date Exception</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}


function invalidlength_exception($message) {
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Invalid Check Date Exception</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}

function unknowntype_exception($message) {
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Invalid Check Date Exception</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}

function nonexistingrecord($message){
	$CI =& get_instance();
	$breadcrumb = CENUM_DASHBOARD_CHIP.' '.CENUM_CHIP_POINTER.' '.mdlchip('Error');
	$bgcolorclass = 'red darken-4';
	$errormessage = maticon('sentiment_very_dissatisfied', 'large white-text').'<br> <h1 class="white-text">Record Does not Exist</h1> <br><small class="white-text"><i>'.$message.'</i></small>';
	$displayData['title']        = 'Error';
	$displayData['bgcolorclass'] = $bgcolorclass;
	$displayData['pageTitle']    = $breadcrumb;
	$displayData['errormessage'] = $errormessage;
	$displayData['mainTemplate'] = 'errors/system/viewerror';
	$displayData['nav'] = $CI->mnav_brain_jar->navData();
	$CI->load->vars($displayData);
	$CI->load->view('template');
}