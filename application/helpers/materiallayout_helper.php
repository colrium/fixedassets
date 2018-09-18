<?php
//primariry uses material design lite(MDL Framework), Materialize framework and jquery

if ( ! function_exists('breadcrumb')){
	function breadcrumb($text='', $url = '', $others='class="breadcrumb onviewanimated waves-effect waves-dark"'){
		$returnData = '';
		if ($url != '') {
			$returnData = anchor($url, '<div class="chip">'.$text.'</div>', $others!=''? ' '.$others : ' class="breadcrumb waves-effect waves-dark"');
		}
		else{
			$returnData = '<div'.($others!=''? ' '.$others : ' class="breadcrumb onviewanimated waves-effect waves-dark"').'><div class="chip primarydark">'.$text.'</div></div>';
		}
			
		return $returnData;
	}	
}
if ( ! function_exists('definecolorstyle')){
	function definecolorstyle(){
		$CI = & get_instance();
		$CI->config->load('colors');
		$primaryColor = $CI->config->item('primary_color');
		$primaryDarkColor = $CI->config->item('primary_dark_color');
		$accentColor = $CI->config->item('accent_color');
		$highlightColor = $CI->config->item('highlight_color');
		$textColor = $CI->config->item('text_color');
		$linktextColor = $CI->config->item('link_text_color');
		$inverseTextColor = $CI->config->item('inverse_text_color');
		$primaryColorRgb = $CI->config->item('primary_color_rgb');
		$submitColor = $CI->config->item('submit_btn_color');
		$returnData = 	'<style>
							:root{
								--fontsize : 13px;
								--primaryColor: '.$primaryColor.';
								--primaryDarkColor: '.$primaryDarkColor.';
								--accentColor: '.$accentColor.';
								--highlightColor: '.$highlightColor.';
								--textColor: '.$textColor.';
								--inverseTextColor: '.$inverseTextColor.';
								--submitColor: '.$submitColor.';
								--primaryColorRgb: '.$primaryColorRgb.';
								--accentColorRgb: '.hextorgb($accentColor).';
							}
							#primaryColor{
								background: var(--primaryColor);
							}
						</style>';	
		return $returnData;
	}	
}

if (!function_exists('definejsvars')){
	function definejsvars(){
		$CI = & get_instance();
		$CI->config->load('colors');
		$primaryColor = $CI->config->item('primary_color');
		$primaryDarkColor = $CI->config->item('primary_dark_color');
		$accentColor = $CI->config->item('accent_color');
		$highlightColor = $CI->config->item('highlight_color');
		$textColor = $CI->config->item('text_color');
		$linktextColor = $CI->config->item('link_text_color');
		$inverseTextColor = $CI->config->item('inverse_text_color');
		$primaryColorRgb = $CI->config->item('primary_color_rgb');
		$submitColor = $CI->config->item('submit_btn_color');
		$returnData = 	'<script type="text/javascript">
								var fontsize = 13;							
								var primaryColor = "'.$primaryColor.'";
								var primaryDarkColor = "'.$primaryDarkColor.'";
								var accentColor = "'.$accentColor.'";
								var highlightColor = "'.$highlightColor.'";
								var textColor = "'.$textColor.'";
								var inverseTextColor = "'.$inverseTextColor.'";
								var submitColor = "'.$submitColor.'";
								var primaryColorRgb = "'.$primaryColorRgb.'";
								var accentColorRgb = "'.hextorgb($accentColor).'";
						</script>';	
		return $returnData;
	}	
}





if ( ! function_exists('getcolorclass')){
	function getcolorclass($cid=0){
		$CI = & get_instance();
		$CI->config->load('colors');
		$primaryColorClass = $CI->config->item('primary_color_class');
		$primaryDarkColorClass = $CI->config->item('primary_dark_color_class');
		$accentColorClass = $CI->config->item('accent_color_class');
		$highlightColorClass = $CI->config->item('highlight_color_class');
		$textColorClass = $CI->config->item('text_color_class');
		$inverseTextColorClass = $CI->config->item('inverse_text_color_class');
		$submitBtnColorClass = $CI->config->item('submit_btn_color_class');
		$actionBtnColorClass = $CI->config->item('action_btn_color_class');
		$linkTextColorClass = $CI->config->item('link_text_color_class');
		$tableHeadBgColorClass = $CI->config->item('table_head_bg_color_class');
		$primaryColorTextColorClass = $CI->config->item('primary_color_text_class');

		$colorclassesarray = array($primaryColorClass, $primaryDarkColorClass, $accentColorClass, $highlightColorClass, $textColorClass, $inverseTextColorClass, $submitBtnColorClass, $actionBtnColorClass, $linkTextColorClass, $tableHeadBgColorClass, $primaryColorTextColorClass);
		$returnData = '';

		if ($cid<sizeof($colorclassesarray)) {
			$returnData = $colorclassesarray[$cid];
		}
		return $returnData;
	}	
}
if ( ! function_exists('getcolor')){
	function getcolor($cid=0){
		$CI = & get_instance();
		$CI->config->load('colors');
		$primaryColor = $CI->config->item('primary_color');
		$primaryDarkColor = $CI->config->item('primary_dark_color');
		$accentColor = $CI->config->item('accent_color');
		$highlightColor = $CI->config->item('highlight_color');
		$textColor = $CI->config->item('text_color');
		$inverseTextColor = $CI->config->item('inverse_text_color');
		$primaryColorRgb = $CI->config->item('primary_color_rgb');
		$submitColor = $CI->config->item('submit_btn_color');
		$colorclassesarray = array($primaryColor, $primaryDarkColor, $accentColor, $highlightColor, $textColor, $inverseTextColor, $primaryColorRgb, $submitColor);
		$returnData = '';

		if ($cid<sizeof($colorclassesarray)) {
			$returnData = $colorclassesarray[$cid];
		}
		return $returnData;
	}	
}

if ( ! function_exists('moduletextcolorclass')){
	function moduletextcolorclass($module){
		$textcolorclass = '';
		$CI = & get_instance();
		$modulescolors = $CI->config->item('modulescolorclasses');
		$modulecolor = getcolorclass(1);
		if (array_key_exists($module, $modulescolors)) {
			$modulecolor = $modulescolors[$module];
		}
		$modulecolor = trim($modulecolor);
		$textcolorclass = $modulecolor;
		$iscomplexcolor = strpos($modulecolor, " ");
					
		if ($iscomplexcolor !== FALSE) {
			$textcolorclass = str_replace(" ", "-text text-", $modulecolor);
		}
		else{
			$textcolorclass .= '-text';
		}
		return $textcolorclass;
	}	
}

if ( ! function_exists('javascriptvariables')){
	function javascriptvariables(){
		$returnData = 	'
		<script type="text/javascript">
				window.base_url = "'.base_url().'";
		</script>';	
		return $returnData;
	}	
}


if ( ! function_exists('hextorgb')){
	function hextorgb($hex='#000', $alpha = false){
	   $hex      = str_replace('#', '', $hex);
	   $length   = strlen($hex);
	   $r = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
	   $g = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
	   $b = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
	   if ( $alpha ) {
		  $a = $alpha;
		  return "$r, $g, $b, $a";
	   }
	   else{
		 return "$r, $g, $b";
	   }
	   
	}	
}

if ( ! function_exists('inverseHexColor')){
	function inverseHexColor($hex){
		$hex      = str_replace('#', '', $hex);
		$length   = strlen($hex);
		$r = 255 - hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
		$g = 255 - hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
		$b = 255 - hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

		$hexr = dechex($r);
		$hexg = dechex($g);
		$hexb = dechex($b);

		strlen($hexr) == 1 ? ($hexr = str_repeat($hexr, 2)) : ($hexr = $hexr); 
		strlen($hexg) == 1 ? ($hexg = str_repeat($hexg, 2)) : ($hexg = $hexg); 
		strlen($hexb) == 1 ? ($hexb = str_repeat($hexb, 2)) : ($hexb = $hexb); 


		return '#'.$hexr.''.$hexg.''.$hexb;
	}
}

if ( ! function_exists('darkerHexColor')){
	function darkerHexColor($hex){
		$hex      = str_replace('#', '', $hex);
		$length   = strlen($hex);
		$r = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
		$g = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
		$b = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

		$r = ceil($r-($r*0.5));

		$g = ceil($g-($g*0.5));
		$b = ceil($b-($b*0.5));

		$hexr = dechex($r);
		$hexg = dechex($g);
		$hexb = dechex($b);

		strlen($hexr) == 1 ? ($hexr = str_repeat($hexr, 2)) : ($hexr = $hexr); 
		strlen($hexg) == 1 ? ($hexg = str_repeat($hexg, 2)) : ($hexg = $hexg); 
		strlen($hexb) == 1 ? ($hexb = str_repeat($hexb, 2)) : ($hexb = $hexb); 


		return '#'.$hexr.''.$hexg.''.$hexb;
	}
}
if ( ! function_exists('defineglobals')){
	function defineglobals(){
		//-----------------------------
		// Link Chips
		//-----------------------------

		$CI = & get_instance();
		$modules = $CI->config->item('fortmodules');
		$modulesicons = $CI->config->item('fortmodulesicons');
		$modulesanchorprefixes = $CI->config->item('modulesanchorprefixes');
		$modulescolorclasses = $CI->config->item('modulescolorclasses');
		
		foreach ($modules as $modulekey => $modulevalue) {
			$prefixname = $modulekey.'_prefix';
			$prefixname = strtoupper($prefixname);
			$dashboardchipname = $modulekey.'_dashboard_chip';
			$dashboardchipname = strtoupper($dashboardchipname);
			define("$prefixname", 'modules/'.$modulekey.'/');
			define("$dashboardchipname",  breadcrumb('<i class="material-icons chipicon">'.$modulesicons[$modulekey].'</i>'.$modules[$modulekey], 'modules/'.$modulekey.'/Dashboard', 'class="breadcrumb waves-effect waves-dark"'));
		}

		

		define('CENUM_CHIP_POINTER',  '');	
	}	
}

defineglobals();

if ( ! function_exists('mdlsmalldiv')){
	function mdlsmalldiv($content='', $attributes=''){
		$returnData = '<div '.$attributes.'>'.$content.'</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdldivstrt')){
	function mdldivstrt($class='', $id='', $others=''){
		if (strpos($class, 'cardheader')!==FALSE || strpos($class, 'cardbody')!==FALSE) {
			$class .= ' onviewanimated zoomin';
		}
		$returnData = '<div class="'.$class.'" '.($id==''? '':'id="'.$id.'"').' '.$others.'>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdldivend')){
	function mdldivend(){
		$returnData = '</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('headertxt')){
	function headertxt($size='1', $text='', $others=''){
		$returnData = '<h'.$size.''.($others==''? '':' '.$others).'>'.$text.'</h'.$size.'>';	
		return $returnData;
	}	
}

if ( ! function_exists('italictxt')){
	function italictxt($text='', $others=''){
		$returnData = '<i'.($others==''? '':' '.$others).'>'.$text.'</i>';	
		return $returnData;
	}	
}

if ( ! function_exists('paragraph')){
	function paragraph($text='', $others=''){
		$returnData = '<p'.($others==''? '':' '.$others).'>'.$text.'</p>';	
		return $returnData;
	}	
}

if ( ! function_exists('smalltxt')){
	function smalltxt($text='', $others=''){
		$returnData = '<small'.($others==''? '':' '.$others).'>'.$text.'</small>';	
		return $returnData;
	}	
}

if ( ! function_exists('boldtxt')){
	function boldtxt($text='', $others=''){
		$returnData = '<b'.($others==''? '':' '.$others).'>'.$text.'</b>';	
		return $returnData;
	}	
}

if ( ! function_exists('centereddom')){
	function centereddom($text=''){
		$returnData = '<center>'.$text.'</center>';	
		return $returnData;
	}	
}

if ( ! function_exists('img')){
	function img($source='', $others=''){
		$returnData = '<img src="'.$source.'" '.($others==''? '':' '.$others).'/>';	
		return $returnData;
	}	
}


if ( ! function_exists('horizontaldivider')){
	function horizontaldivider($num =1){
		$returnData = repeater('<hr class="style5" />', $num);	
		return $returnData;
	}	
}



if ( ! function_exists('breaker')){
	function breaker($num =1){
		$returnData = repeater('</br>', $num);	
		return $returnData;
	}	
}

if ( ! function_exists('spacer')){
	function spacer($num=1){
		$returnData = str_repeat('<span class="spacer"></span>', $num);	
		return $returnData;
	}	
}
if ( ! function_exists('spanned')){
	function spanned($content='', $attributes=''){
		$returnData = '<span'.(strlen($attributes) > 0? ' '.$attributes : '').'>'.$content.'</span>';	
		return $returnData;
	}	
}

if ( ! function_exists('button')){
	function button($attributes='', $content=''){
		$returnData = '<button '.$attributes.'>'.$content.'</button>';	
		return $returnData;
	}	
}


//tables
if ( ! function_exists('mdltablestart')){
	function mdltablestart($others='class="mdl-data-table mdl-js-data-table"'){
		$returnData = '<table'.($others==''? '':' '.$others).'>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializetablestart')){
	function materializetablestart($others='class="bordered striped responsive-table"', $title=''){
		$returnData = '<div class="row rounded-5px white material-table">
							<div class="table-header">
								<span class="table-title">'.$title.'</span>
							</div>

							<table'.($others==''? '':' '.$others).'>';	
		return $returnData;
	}	
}



if ( ! function_exists('datatable_open')){
	function datatable_open($class="highlight full-width", $id="datatable", $title='', $scrollheight='350'){


		$retData 	= 	'<table class="'.$class.'" id="'.$id.'">';
		$retData 	.=	'<script>
							$(function(){
								$("#'.$id.'").DataTable();
								$("#'.$id.'").animateCss("slideInUp");
								
							});
						</script>';
		return $retData;
	}
}

if ( ! function_exists('datatable_close')){
	function datatable_close(){
		$returnData = '</table>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdltableend')){
	function mdltableend(){
		$returnData = '</table>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializetableend')){
	function materializetableend(){
		$returnData = '</table>
						</div>';	
		return $returnData;
	}	
}



if ( ! function_exists('mdlheaderrowstart')){
	function mdlheaderrowstart($others=''){
		$returnData = '<tr'.($others==''? '':' '.$others).'>';	
		return $returnData;
	}	
}
if ( ! function_exists('mdlheaderrowend')){
	function mdlheaderrowend(){
		$returnData = '<tr class="'.getcolorclass(9).' white-text">';	
		return $returnData;
	}	
}

if ( ! function_exists('headerrowstart')){
	function headerrowstart($attributes=''){
		$returnData = '<tr'.($attributes==''? '':' '.$attributes).'>';	
		return $returnData;
	}	
}
if ( ! function_exists('headerrowend')){
	function headerrowend(){
		$returnData = '</tr>';	
		return $returnData;
	}	
}
if ( ! function_exists('tableheadstart')){
	function tableheadstart(){
		$returnData = '<thead>';	
		return $returnData;
	}	
}
if ( ! function_exists('tableheadend')){
	function tableheadend(){
		$returnData = '</thead>';	
		return $returnData;
	}	
}

if ( ! function_exists('tablebodystart')){
	function tablebodystart($attributes=''){
		$returnData = '<tbody'.($attributes==''? '':' '.$attributes).'>';	
		return $returnData;
	}	
}
if ( ! function_exists('tablebodyend')){
	function tablebodyend(){
		$returnData = '</tbody>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlnormalrowstart')){
	function mdlnormalrowstart($attributes=""){
		$returnData = '<tr'.($attributes==""? '': ' '.$attributes).'>';	
		return $returnData;
	}	
}

if ( ! function_exists('tablerowstart')){
	function tablerowstart($attributes=""){
		$returnData = '<tr'.($attributes==""? '': ' '.$attributes).'>';	
		return $returnData;
	}	
}

if ( ! function_exists('tablerowend')){
	function tablerowend(){
		$returnData = '</tr>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlrowend')){
	function mdlrowend(){
		$returnData = '</tr>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdltablecell')){
	function mdltablecell($content="", $others=""){
		$returnData = '<td'.($others==""? '': ' '.$others).'>'.$content.'</td>';	
		return $returnData;
	}	
}

if ( ! function_exists('tablerowcell')){
	function tablerowcell($content="", $others=""){
		$returnData = '<td'.($others==""? '': ' '.$others).'>'.$content.'</td>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdltablecellstrt')){
	function mdltablecellstrt($others=""){
		$returnData = '<td'.($others==""? '': ' '.$others).'>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdltablecellend')){
	function mdltablecellend(){
		$returnData = '</td>';	
		return $returnData;
	}	
}



//others

if ( ! function_exists('mdlchip')){
	function mdlchip($text='', $others='class="mdl-chip waves-effect"', $secondothers = 'class="mdl-chip__text"'){
		$returnData = '<span'.($others==""? '': ' '.$others).'><span'.($secondothers==""? '': ' '.$secondothers).'>'.$text.'</span></span>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlmediachip')){
	function mdlmediachip($media='', $text='', $others='class="mdl-chip waves-effect waves-light"'){
		$returnData = '<span '.$others.'><span class="mdl-chip__contact '.getcolorclass(4).'">'.$media.'</span><span class="mdl-chip__text">'.$text.'</span> </span>';	
		return $returnData;
	}	
}



if ( ! function_exists('materializechip')){
	function materializechip($text='', $others=''){
		$returnData = '<div class="chip" '.($others==""? '': ' '.$others).'>'.$text.'</div>';	
		return $returnData;
	}	
}



if ( ! function_exists('mdltooltip')){
	function mdltooltip($for='', $text='', $class='mdl-tooltip--top'){
		$returnData = '<span for="'.$for.'" class="mdl-tooltip '.$class.'">'.$text.'</span>';	
		return $returnData;
	}	
}

if ( ! function_exists('importexcelmodal')){
	function excelimportmodal($details=array()){
		$radios = '';
		$radiooptions = array();
		$upload_url = 'uploads/Uploads/uploadimportfile/'.$details['name'].'-filer';
		if (array_key_exists('options', $details)) {
			$index = 0;
			$radiooptions = $details['options'];
			if(sizeof($radiooptions) > 0){
				foreach ($radiooptions as $key => $value) {
					$radios .= mdldivstrt('col s4');
						if($index==0){

							$radios .= materializeradio($key, ' '.$value, 'importtarget', 'target-'.$key, '', true);
						}
						else{
							$radios .= materializeradio($key, ' '.$value, 'importtarget', 'target-'.$key, '', false);
						}
					$radios .= mdldivend();
					$index++;
				}
			}			
		}

		$returnData = '<div id="'.$details['name'].'-modal" class="modal modal-fixed-footer modal-fixed-header">
						  <div class="modal-header primary">
							  '.headertxt('4', $details['title'], 'class="full-width center-align v-centered inverse-text"').'
						  </div>
						  <div class="modal-content styled-scroll-bar">
							<div class="row">
							  <div class="col s12">
								  '.form_open_multipart($details['formurl'], 'id="'.$details['name'].'-form" name="'.$details['name'].'-form"').'
									'.dragdropimportexcelfiler($details['name'].'-filer', $details['name'].'-filer-id', $upload_url).'
									<hr class="style14"></br>
									<div class="row">
										'.$radios.'
									</div>
									<div class="row">
										<div class="col s6">
											<input type="hidden" name="filedbid" value="" />
										</div>
										<div class="col s6">							              
										  <input type="hidden" name="extension" value="" />
										</div>
									</div>
									</br>
								  <hr class="style14"></br>
								  '.mdlsubmitbtn('cloud_queue', 'Proceed', $details['name'].'-form-submit').'
								  '.form_close().'
							  </div>
							</div>

							<script>
								$("#'.$details['name'].'-form").submit(function(event){				
									var filedbid = $("input[name=\"filedbid\"]").val();
									if (filedbid != "0") {
										
									}
									else{
										event.preventDefault();
										$.toast({
											closewith: "click",
											title: "Error",
											text:"Please Select Upload File",
											icon:"sentiment_very_satisfied",
											type:"error"                      
										  });
									}									
								});

							</script>


								
							</div>
							<div class="modal-footer">
							  <a href="#" class="modal-action modal-close waves-effect waves-red red-text btn-flat">'.maticon('cancel', 'spaced-text').' Dismiss</a>
							</div>
						</div>';

		return $returnData;
	}	
}

if ( ! function_exists('mdllink')){
	function mdllink($attributes='', $text=''){
		$returnData = '<a '.$attributes.'>'.$text.'</a>';	
		return $returnData;
	}	
}

if ( ! function_exists('emaillink')){
	function emaillink($email='', $title='', $attributes=''){
		$returnData = mailto($email, $title, $attributes);	
		return $returnData;
	}	
}

if ( ! function_exists('phonelink')){
	function phonelink($title='', $attributes=''){
		$returnData = anchor('#', $title, $attributes);	
		return $returnData;
	}	
}

if(!function_exists('mdlli')){
	function mdlli($text='', $attributes=''){
		$returnData = '<li '.$attributes.'>'.$text.'</li>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdllistart')){
	function mdllistart($attributes=''){
		$returnData = '<li '.$attributes.'>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlliend')){
	function mdlliend(){
		$returnData = '</li>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdllinkstart')){
	function mdllinkstart($attributes=''){
		$returnData = '<a '.$attributes.'>';	
		return $returnData;
	}	
}


if ( ! function_exists('mdllinkend')){
	function mdllinkend(){
		$returnData = '</a>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlulstart')){
	function mdlulstart($attributes=''){
		$returnData = '<ul '.$attributes.'>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlulend')){
	function mdlulend(){
		$returnData = '</ul>';	
		return $returnData;
	}	
}



//buttons

if ( ! function_exists('mdlfabbutton')){
	function mdlfabbutton($icon='', $class='', $id='', $disabled=FALSE){
		$returnData = '<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').'>'.$icon.'</button>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlminifabbutton')){
	function mdlminifabbutton($icon='', $class='', $id='', $disabled=FALSE){
		$returnData = '<button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').'>'.$icon.'</button>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlraisedbutton')){
	function mdlraisedbutton($text='', $class='', $id='', $disabled=FALSE){
		$returnData = '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').' '.($disabled? 'disabled': '').'>'.$text.'</button>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlflatbutton')){
	function mdlflatbutton($text='', $class='', $id='', $disabled=FALSE){
		$returnData = '<button class="mdl-button mdl-js-button mdl-js-ripple-effect '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').' '.($disabled? 'disabled': '').'>'.$text.'</button>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdliconbutton')){
	function mdliconbutton($text='', $class='', $id='', $disabled=FALSE){
		$returnData = '<button class="mdl-button mdl-js-button mdl-button--icon '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').' '.($disabled? 'disabled': '').'>'.$text.'</button>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdliconlink')){
	function mdliconlink($href = '#', $text='', $class='', $id='', $disabled=FALSE){
		$returnData = '<a href="'.$href.'" class="mdl-button mdl-js-button mdl-button--icon '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').' '.($disabled? 'disabled': '').'>'.$text.'</a>';	
		return $returnData;
	}	
}

if ( ! function_exists('switchbutton')){
	function switchbutton($text='', $link = '#', $class='', $id='', $disabled=FALSE){
		$returnData = 	'<div class="switch-wrap">
						  <a href="'.$link.'" class="switch-button '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' '.($disabled? 'disabled': '').' '.($disabled? 'disabled': '').'>'.$text.'</a>
						</div>';	
		return $returnData;
	}	
}


//icons

if ( ! function_exists('maticon')){
	function maticon($icon='', $class='spaced-text', $id=''){
		$returnData = '<i class="material-icons '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').'>'.$icon.'</i>';	
		return $returnData;
	}	
}


if ( ! function_exists('maticonjs')){
	function maticonjs($icon='', $class='', $id=''){
		$returnData = '<i class=\"material-icons '.($class == '' ? '' : $class).'\" '.($id == '' ? '' : ' id=\"'.$id.'\"').'>'.$icon.'</i>';	
		return $returnData;
	}	
}

if ( ! function_exists('jfiicon')){
	function jfiicon($icon='', $class='', $id=''){
		$returnData = '<i class="icon-jfi-'.$icon.' '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').'></i>';	
		return $returnData;
	}	
}

if ( ! function_exists('fileicon')){
	function fileicon($filetype='', $ext='', $size='', $attrs=''){
		$fileicon = maticon('insert_drive_file');
		$fileclass = '';
		if ($filetype=="image") {
			$fileicon = maticon('insert_drive_file');
			$fileclass = 'f-image';
		}
		else if ($filetype=="video") {
			$fileicon = maticon('insert_drive_file');
			$fileclass = 'f-video';
		}
		else if ($filetype=="audio") {
			$fileicon = maticon('insert_drive_file');
			$fileclass = 'f-audio';
		}
		else if ($filetype=="document") {
			$fileicon = maticon('insert_drive_file');
			$fileclass = 'f-document';
		}
		else if ($filetype=="other") {
			$fileicon = maticon('insert_drive_file');
			$fileclass = 'f-file';
		}

		$returnData = '<span class="file-icon '.$fileclass.'"'.($attrs == '' ? '' : ' '.$attrs).'>';
		$returnData .= $ext;
		if ($size != '') {
			$returnData .= breaker().smalltxt($size);
		}
		$returnData .= '</span>';

		return $returnData;
	}	
}

if ( ! function_exists('coloricon')){
	function coloricon($icon='', $class='', $id=''){
		$iconsarray = array(''=>'');
		$returnData = '';	
		
		return $returnData;
	}	
}


if ( ! function_exists('coloriconjs')){
	function coloriconjs($icon='', $class='', $id=''){
		$returnData = '<i class=\"flat-color-icons '.($class == '' ? '' : $class).'\" '.($id == '' ? '' : ' id=\"'.$id.'\"').'>'.$icon.'</i>';	
		return $returnData;
	}	
}


//badges

if ( ! function_exists('mdlbadge')){
	function mdlbadge($badgedata='', $text='', $class='', $id=''){
		$returnData = '<span class="mdl-badge  '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').'  data-badge="'.$badgedata.'">'.$text.'</span>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlroundedbadge')){
	function mdlroundedbadge($badgedata='', $text='', $class='', $id=''){
		$returnData = '<span class="mdl-badge mdl-badge--no-background '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').'  data-badge="'.$badgedata.'">'.$text.'</span>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdliconbadge')){
	function mdliconbadge($badgedata='', $icon='', $class='', $id=''){
		$returnData = '<div class="material-icons mdl-badge mdl-badge--overlap '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' data-badge="'.$badgedata.'">'.$icon.'</div>';	
		return $returnData;
	}	
}


if ( ! function_exists('mdliconbadge')){
	function mdliconbadge($badgedata='', $icon='', $class='', $id=''){
		$returnData = '<div class="material-icons mdl-badge mdl-badge--overlap '.($class == '' ? '' : $class).'" '.($id == '' ? '' : ' id="'.$id.'"').' data-badge="'.$badgedata.'">'.$icon.'</div>';	
		return $returnData;
	}	
}



//inputs
if ( ! function_exists('mdlinputtxt')){
	function mdlinputtxt($value='', $name='', $label='', $readonly=false, $class='', $id='', $required=FALSE){
		$returnData ='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-width '.($readonly==true? 'grey-text':'').'">';
		$returnData .= '<input class="mdl-textfield__input full-width" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="text" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .='<label class="mdl-textfield__label" for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label></div>';	
		return $returnData;
	}	
}

//inputs
if ( ! function_exists('materializeinputtxt')){
	function materializeinputtxt($value='', $name='', $label='', $readonly=false, $class='', $id='', $required=FALSE){
		$id==''? $id=$name : $id=$id;
		$returnData =	'<div class="input-field onviewanimated full-width">
							<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>
							<input class="full-width validate'.($class!=''? ' '.$class:'').'" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="text" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >
						</div>';

		return $returnData;
	}	
}

if ( ! function_exists('materializeinputicontxt')){
	function materializeinputicontxt($value='', $name='', $label='', $icon='edit', $readonly=false, $class='', $id='', $required=FALSE){
		$id==''? $id=$name : $id=$id;
		$returnData ='<div class="input-field onviewanimated full-width">
							<i class="material-icons prefix">'.$icon.'</i>
							<label for="'.($id==''? $name : $id).'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>						
							<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="text" id="'.($id==''? $name : $id).'" '.($readonly? 'readonly="readonly"' : '').' >
					</div>';

		return $returnData;
	}	
}

if ( ! function_exists('mdlinputhidden')){
	function mdlinputhidden($value='', $name='', $id=''){
		$id==''? $id=$name : $id=$id;
		$returnData = '<input  name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="hidden" id="'.$id.'" >';	
		return $returnData;
	}	
}


if ( ! function_exists('mdlinputpass')){
	function mdlinputpass($value='', $name='', $label='', $disabled=false, $class='', $id='', $required=FALSE){
		$id==''? $id=$name : $id=$id;
		$returnData ='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-width">';
		$returnData .= '<input class="mdl-textfield__input full-width" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="password" id="'.$id.'" '.($disabled? 'readonly="readonly"' : '').' >';
		$returnData .='<label class="mdl-textfield__label" for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label></div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputiconpass')){
	function materializeinputiconpass($value='', $name='', $label='', $icon='vpn_key', $readonly=false, $class='', $id='', $required=FALSE){
		$id==''? $id=$name : $id=$id;
		$returnData ='<div class="input-field onviewanimated full-width">
						<i class="material-icons prefix">'.$icon.'</i>';
		$returnData .= '<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="password" id="'.($id==''? $name : $id).'" '.($readonly? 'readonly="readonly"' : '').' ><i class="material-icons suffix passwordviewer" for="'.$id.'">visibility</i>
						<label for="'.($id==''? $name : $id).'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputpass')){
	function materializeinputpass($value='', $name='', $label='', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="password" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlinputnum')){
	function mdlinputnum($value='', $name='', $label='', $disabled=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-width">';
		$returnData .= '<input class="mdl-textfield__input full-width" name="'.$name.'" value="'.$value.'" type="number" id="'.$id.'" '.($disabled? 'readonly="readonly"' : '').' >';
		$returnData .='<label class="mdl-textfield__label" for="'.$id.'">'.maticon('looks_5', 'spaced-text').' '.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label></div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputnum')){
	function materializeinputnum($value='', $name='', $label='', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="number" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputiconnum')){
	function materializeinputiconnum($value='', $name='', $label='', $icon='looks_3', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<i class="material-icons prefix">'.$icon.'</i>
						<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="number" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlinputdecimal')){
	function mdlinputdecimal($value='', $name='', $label='', $disabled=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-width">';
		$returnData .= '<input class="mdl-textfield__input full-width" name="'.$name.'" value="'.$value.'" type="number" step="any" id="'.$id.'" '.($disabled? 'readonly="readonly"' : '').'>';
		$returnData .='<label class="mdl-textfield__label" for="'.$id.'">'.maticon('looks_5', 'spaced-text').' '.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label></div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputdecimal')){
	function materializeinputdecimal($value='', $name='', $label='', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="number" step="any" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputicondecimal')){
	function materializeinputicondecimal($value='', $name='', $label='', $icon='looks_3', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<i class="material-icons prefix">'.$icon.'</i>
						<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width validate" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="number" step="any" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('mdlinputdate')){
	function mdlinputdate($value='', $name='', $label='', $disabled=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<label>'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label><br>';
		$returnData .= '<input type="date" class="datepicker full-width" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').'  '.($label == ''? ' ': 'placeholder="'.$label.'"').' id="'.$id.'" '.($disabled? 'readonly="readonly"' : '').' >';
		$returnData .= '<script>$("#'.$id.'").pickadate({selectMonths: true,selectYears: 200});</script>';
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputdate')){
	function materializeinputdate($value='', $name='', $label='', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<label for="'.$id.'">'.maticon('event', 'spaced-text').' '.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width jdatepicker" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="text" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .= '<script>$("#'.$id.'").datepicker({autoHide: true, format: "yyyy-mm-dd"});</script>';
		$returnData .='</div>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeinputicondate')){
	function materializeinputicondate($value='', $name='', $label='', $icon='event', $readonly=false, $class='', $id='', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width">
						<i class="material-icons prefix">'.$icon.'</i>
						<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<input class="full-width" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').' type="text" id="'.$id.'" '.($readonly? 'readonly="readonly"' : '').' >';
		$returnData .= '<script>$("#'.$id.'").datepicker({autoHide: true, format: "yyyy-mm-dd"});</script>';
		$returnData .='</div>';	
		return $returnData;
	}	
}




if ( ! function_exists('materializeinputtime')){
		function materializeinputtime($value='', $name='', $label='', $readonly=false, $class='', $id='timepicker', $required=FALSE){
			if ($id=='') {
				$id = $name;
			}
			$returnData ='<div class="input-field onviewanimated full-width">
							<label for="'.$id.'">'.maticon('schedule', 'spaced-text').' '.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
			$returnData .='<input type="text" name="'.$name.'" class="full-width" id="'.$id.'"  '.($value==''? ' ' : 'value="'.$value.'"').'  '.($readonly? 'readonly="readonly"' : '').' />';		
			
			$returnData .= '</div>';

			return $returnData;
		}	
}

if ( ! function_exists('materializeinputicontime')){
		function materializeinputicontime($value='', $name='', $label='', $icon='access_time', $readonly=false, $class='', $id='timepicker', $required=FALSE){
			if ($id=='') {
			$id = $name;
		}
			$returnData ='<div class="input-field onviewanimated full-width">
							<i class="material-icons prefix">'.$icon.'</i>
							<label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
			$returnData .='<input type="text" name="'.$name.'" class="full-width" id="'.$id.'"  '.($value==''? ' ' : 'value="'.$value.'"').'  '.($readonly? 'readonly="readonly"' : '').' />';		
		
			$returnData .= '</div>';

			return $returnData;
		}	
}

if ( ! function_exists('modaldatepicker')){
	function modaldatepicker($value='', $name='', $label='', $disabled=false, $class='', $id=''){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<label class="'.getcolorclass(10).'">'.maticon('event', 'spaced-text').' '.$label.' </label><br>';
		$returnData .= '<input type="button" class="btn-flat grey lighten-2 '.getcolorclass(10).' rounded-5px full-width center-align" data-toggle="datepicker" data-select="datepicker"  name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').'   id="'.$id.'" '.($disabled? 'readonly' : '').'>';
		return $returnData;
	}	
}

if ( ! function_exists('jdatepicker')){
	function jdatepicker($value='', $name='', $label='', $disabled=false, $class='', $id='datepicker'){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<label class="'.getcolorclass(10).'">'.maticon('event', 'spaced-text').' '.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').' </label><br>';
		$returnData .= '<input type="text" class="full-width jdatepicker" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').'   id="'.$id.'" '.($disabled? 'readonly="readonly"' : '').'>';

		return $returnData;
	}	
}


if ( ! function_exists('mdltextarea')){
	function mdltextarea($value='', $name='', $label='', $disabled=false, $class='', $id='', $rows='4'){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<label class="'.getcolorclass(10).'">'.$label.'</label>';
		$returnData .= '<textarea class="fullborder-input full-width"  name="'.$name.'" rows="'.$rows.'"  id="'.$id.'" '.($disabled? 'readonly' : '').'>'.$value.'</textarea>';
		return $returnData;
	}	
}

if ( ! function_exists('materializetextarea')){
	function materializetextarea($value='', $name='', $label='', $disabled=false, $class='', $id='', $rows='4', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<div class="input-field onviewanimated full-width"><label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label><textarea class="materialize-textarea full-width"  name="'.$name.'" rows="'.$rows.'"  id="'.$id.'" '.($disabled? 'readonly' : '').'>'.$value.'</textarea></div>';
		return $returnData;
	}	
} 
if ( ! function_exists('materializeicontextarea')){
	function materializeicontextarea($value='', $name='', $label='', $icon='subject', $disabled=false, $class='', $id='', $rows='4', $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<div class="input-field onviewanimated full-width"><i class="material-icons prefix">'.$icon.'</i><label for="'.$id.'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label><textarea class="materialize-textarea full-width"  name="'.$name.'" rows="'.$rows.'"  id="'.$id.'" '.($disabled? 'readonly' : '').'>'.$value.'</textarea></div>';
		return $returnData;
	}	
} 

if ( ! function_exists('chosenselect')){
	function chosenselect($name='', $options=array(), $value='', $label='', $id='', $multiple=false, $disabled=false, $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<div class="input-field onviewanimated full-width">
		<label class="active">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>'.breaker();
		$returnData .= '<select '.($multiple? 'name="'.$name.'[]" multiple ':' name="'.$name.'"').' class="full-width chosen" '.($id==''? 'id="'.$name.'"' : 'id="'.$id.'"').' >';
		foreach ($options as $key => $valueopt) {
			if (is_array($valueopt)) {
				$returnData .= '<option value="'.$key.'"';
				if (array_key_exists('class', $valueopt)) {
					$returnData .= ' class="'.$valueopt['class'].'"';
				}
				if (array_key_exists('href', $valueopt)) {
					$returnData .= ' href="'.$valueopt['href'].'"';
				}
				if (array_key_exists('datadom', $valueopt)) {
					$returnData .= ' datadom="'.$valueopt['datadom'].'"';
				}
				if ($value==$key) {
					$returnData .= ' SELECTED>'.$valueopt['name'].'</option>';
				}
				else {
					$returnData .= '>'.$valueopt['name'].'</option>';
				}
			}
			else{
				if ($value==$key) {
					$returnData .= '<option value="'.$key.'" SELECTED>'.$valueopt.'</option>';
				}
				else{
					$returnData .= '<option value="'.$key.'">'.$valueopt.'</option>';
				}
			}							
		}
		$returnData .= '</select></div>';
		
		return $returnData;
	}	
} 

if ( ! function_exists('materializeselect')){
	function materializeselect($name='', $options=array(), $value='', $label='', $id='', $multiple=false, $disabled=false, $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<div class="input-field onviewanimated full-width"><label class="'.($disabled? 'active grey-text' : 'active').'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';
		$returnData .= '<select '.($multiple? 'name="'.$name.'[]" multiple ':' name="'.$name.'"').' class="full-width" '.($id==''? 'id="'.$name.'"' : 'id="'.$id.'"').' '.($disabled? 'disabled' : '').'>';
		foreach ($options as $key => $valueopt) {
			if (is_array($valueopt)) {
				$returnData .= '<option value="'.$key.'"';
				if (array_key_exists('class', $valueopt)) {
					$returnData .= ' class="'.$valueopt['class'].'"';
				}
				if (array_key_exists('href', $valueopt)) {
					$returnData .= ' href="'.$valueopt['href'].'"';
				}
				if (array_key_exists('datadom', $valueopt)) {
					$returnData .= ' datadom="'.$valueopt['datadom'].'"';
				}
				if ($value==$key) {
					$returnData .= ' SELECTED>'.$valueopt['name'].'</option>';
				}
				else {
					$returnData .= '>'.$valueopt['name'].'</option>';
				}
			}
			else{
				if ($value==$key) {
					$returnData .= '<option value="'.$key.'" SELECTED>'.$valueopt.'</option>';
				}
				else{
					$returnData .= '<option value="'.$key.'">'.$valueopt.'</option>';
				}
			}							
		}
		$returnData .= '</select></div>';
		
		return $returnData;
	}	
} 

if ( ! function_exists('materializeiconselect')){
	function materializeiconselect($name='', $options=array(), $value='', $label='', $icon='list', $id='', $multiple=false, $disabled=false, $required=FALSE){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<div class="input-field onviewanimated full-width"><i class="material-icons prefix">'.$icon.'</i>';
		if ($label != '') {
			$returnData .= '<label class="'.($disabled? 'active grey-text' : 'active').'">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>'.($multiple ? '</br>': '');
		}
		
		$returnData .= '<select '.($multiple? 'name="'.$name.'[]" multiple ':' name="'.$name.'"').' class="full-width" '.($id==''? 'id="'.$name.'"' : 'id="'.$id.'"').'>';
		if (sizeof($options) > 0) {
			foreach ($options as $key => $valueopt) {
				if (is_array($valueopt)) {					
					$returnData .= '<option value="'.$key.'"';
					if (array_key_exists('class', $valueopt)) {
						$returnData .= ' class="'.$valueopt['class'].'"';
					}
					if (array_key_exists('href', $valueopt)) {
						$returnData .= ' href="'.$valueopt['href'].'"';
					}
					if (array_key_exists('datadom', $valueopt)) {
						$returnData .= ' datadom="'.$valueopt['datadom'].'"';
					}
					if ($value==$key) {
						$returnData .= ' SELECTED>'.$valueopt['name'].'</option>';
					}
					else {
						$returnData .= '>'.$valueopt['name'].'</option>';
					}
				}
				else{
					if (!is_array($value)) {
						if ($value==$key) {
							$returnData .= '<option value="'.$key.'" SELECTED>'.$valueopt.'</option>';
						}
						else{
							$returnData .= '<option value="'.$key.'">'.$valueopt.'</option>';
						}
					}
					else{
						if (in_array($key, $value)) {
							$returnData .= '<option value="'.$key.'" SELECTED>'.$valueopt.'</option>';
						}
						else{
							$returnData .= '<option value="'.$key.'">'.$valueopt.'</option>';
						}
					}							
				}
			}
		}
		else{
			$returnData .= '<option value="" SELECTED>No '.$label.' Available</option>';
		}
			
		$returnData .= '</select>';
		$returnData .= '</div>';
		
		return $returnData;
		
	}	
} 


if ( ! function_exists('mdlinputchkbox')){
	function mdlinputchkbox($value='', $label='', $name='', $id='', $class='', $checked=false){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect '.($class == '' ? '' : $class).'" for="'.$id.'">';
		$returnData .= '<input type="checkbox" id="'.$id.'" value="'.$value.'" class="mdl-checkbox__input" '.($checked? 'checked' : '').'>';
		$returnData .= '<span class="mdl-checkbox__label">'.$label.'</span></label>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializechkbox')){
	function materializechkbox($value='', $label='', $name='', $id='', $class='', $checked=false, $disabled=false){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<input type="checkbox" value="'.$value.'" '.($class!=''? 'class="'.$class.'"' : '').' id="'.$id.'" name="'.$name.'" '.($disabled? 'readonly' : '').' '.($checked? 'checked="checked"' : '').'/> <label for="'.$id.'" >'.$label.'</label>';
		return $returnData;
	}	
}

if ( ! function_exists('mdlinputswitch')){
	function mdlinputswitch($value='', $label='', $name='', $id='', $class='', $checked=false){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect '.($class == '' ? '' : $class).'" for="'.$id.'">';
		$returnData .= '<input type="checkbox" id="'.$id.'" value="'.$value.'" class="mdl-switch__input" '.($checked? 'checked' : '').'>';
		$returnData .= '<span class="mdl-switch__label">'.$label.'</span></label>';	
		return $returnData;
	}	
}

if ( ! function_exists('materializeswitch')){
	function materializeswitch($value='', $leftlabel='',  $rightlabel='', $name='', $id='', $checked=false, $class=''){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="switch"><label>'.$leftlabel.'<input type="checkbox" '.($class!=''? 'class="'.$class.'"' : '').' value="'.$value.'" '.($id!=''? 'id="'.$id.'"' : '').' name="'.$name.'" '.($checked? 'checked' : '').'><span class="lever"></span>'.$rightlabel.'</label></div>';
		return $returnData;
	}	
}

if ( ! function_exists('mdlradio')){
	function mdlradio($value='', $label='', $name='', $id='', $class='', $checked=false){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect '.($class == '' ? '' : $class).'" for="'.$id.'">';
		$returnData .= '<input type="radio" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="mdl-radio__button" '.($checked? 'checked' : '').'>';
		$returnData .= '<span class="mdl-radio__label '.($checked? ' '.getcolorclass(10).' ' : '').'" id="'.$id.'span">'.$label.'</span></label>';	
		return $returnData;
	}	
}
if ( ! function_exists('materializeradio')){
	function materializeradio($value='', $label='', $name='', $id='', $class='', $checked=false){
		if ($id=='') {
			$id = $name;
		}
		$returnData =	'<input type="radio" name="'.$name.'" value="'.$value.'" '.($class==''? ' ':' class="'.$class.'" ').'  id="'.$id.'" '.($checked? 'checked="checked"' : '').'/>
						<label for="'.$id.'">'.$label.'</label>';
		return $returnData;
	}	
}

if ( ! function_exists('mdliconcheckbox')){
	function mdliconcheckbox($value='', $name='', $id='', $icon='', $class='', $checked=false){
		$returnData ='<label class="mdl-icon-toggle mdl-js-icon-toggle mdl-js-ripple-effect" for="'.$id.'">';
		$returnData .= '<input type="radio" id="'.$id.'" name="'.$name.'" value="'.$value.'" class="mdl-icon-toggle__input" '.($checked? 'checked' : '').' />';
		$returnData .= '<i class="mdl-icon-toggle__label material-icons '.($class == '' ? '' : $class).'">'.$icon.'</i></label>';	
		return $returnData;
	}	
}

if ( ! function_exists('materialdesignsvg')){
	function materialdesignsvg($class='', $id='', $colorPrimary='var(--primaryColor)', $colorPrimaryDark='var(--primaryDarkColor)', $colorAccent='var(--accentColor)'){
		$returnData ='<svg width="100%" height="100%" viewBox="0 0 1000 500">
						<defs>
							<linearGradient id="mdsvgdropshadow" gradientTransform="rotate(39.5)">
								<stop offset="67%"  stop-color="#000000" stop-opacity="1"/>
								<stop offset="75%" stop-color="rgba(0,0,0,0)" stop-opacity="1"/>
							</linearGradient>
						</defs>
						<symbol id="mdsvgbg">
							<polygon class="primaryDark" fill="#00838f" points="700,0 1000,0 1000,500 200,500 700,0" style="fill: '.$colorPrimaryDark.'"/>
							<polygon class="accentShadow"  points="700,0 800,0 300,500 200,500 700,0" fill="url(#mdsvgdropshadow)"/>
							<polygon class="accent"  fill="#ff0000" points="550,0 750,0 250,500 50,500 550,0" style="fill: '.$colorAccent.'"/>
							<polygon class="grey" fill="#424242" points="0,0 200,0 1000,500 0,500 0,0"/>
							<polygon class="primaryShadow" points="550,0 650,0 150,500 50,500 550,0"  fill="url(#mdsvgdropshadow)"/>
							<polygon class="primary" fill="#00bcd4" points="0,0 600,0 100,500 0,500 0,0" style="fill: '.$colorPrimary.'"/>
						</symbol>
						<use '.($class==''? '':'class="'.$class.'"').' '.($id==''? '':'id="'.$id.'"').' xlink:href="#mdsvgbg"></use>

					</svg>';
		return $returnData;
	}	
}





if ( ! function_exists('googlemap')){
	function googlemap($id='', $latitudelongitude=array(), $class=''){
		$returnData ='<iframe
						  width="600"
						  height="450"
						  frameborder="0" style="border:0"
						  src="https://www.google.com/maps/embed/v1/place?key=YOUR_API_KEY
							&q=Space+Needle,Seattle+WA" allowfullscreen>
						</iframe>';
		return $returnData;
	}	
}
if ( ! function_exists('inputcolorpicker')){
	function inputcolorpicker($name='colrpicker', $id='colrpicker', $color=false, $datatype=false){
		if ($id=='') {
			$id = $name;
		}
		if($datatype == false){
			$extraConfig 	= 'useDefaultColorClasses:true,
								selectorsOnly:true,  
								';
		}
		else{
			$extraConfig 	= 'useDefaultColorClasses:false,
								selectorsOnly:false,
								format: "'.$datatype.'", 
								';
		}
		if($color != false){
			$extraConfig .= 'color:"'.$color.'",';
		}
		

		$returnData ='<div id="'.$id.'" class="full-width">
							<input type="text" class="dropdown-button btn btn-flat colorpickerval full-width" id="'.$id.'-component" data-activates="'.$id.'-drop-down" data-beloworigin="true" name="'.$name.'" value="'.$color.'"/>
	
						</div>';
		$returnData .= '<script type="text/javascript">
							$("#'.$id.'").colorpicker({
								'.$extraConfig.'
								component: "#'.$id.'-component",
								horizontal: true,
								inline:true,
								template: "<ul class=\"dropdown-content\" id=\"'.$id.'-drop-down\"><li class=\"colorpicker-saturation\"><i><b></b></i></li><li class=\"colorpicker-hue\"><i></i></li><li class=\"colorpicker-alpha\"><i></i></li><li class=\"colorpicker-color\"><div /></li><li class=\"colorpicker-selectors\"></li></ul>"
							});
					</script>';
		return $returnData;
	}	
}

if ( ! function_exists('materializecolorpicker')){
	function materializecolorpicker($value='', $name='', $label='', $id='mcp', $others='colordatatype="hex"', $disabled=false){
		if ($id=='') {
			$id = $name;
		}
		$returnData ='<div class="input-field onviewanimated full-width"><label for="'.$id.'">'.$label.'</label>';
		$returnData .= '<input type="text" class="full-width" name="'.$name.'" '.($value==''? ' ' : 'value="'.$value.'"').'  '.($label == ''? ' ': 'placeholder="'.$label.'"').' id="'.$id.'" '.($disabled? 'readonly="readonly"' : '').' '.$others.' ></div>';
		$returnData .= '<script>$("#'.$id.'").materializecolorpicker();</script>';
		return $returnData;
	}	
}
if ( ! function_exists('mdlinputrating')){
	function mdlinputrating($value='0', $label='', $name='', $id=''){
		if ($id=='') {
			$id = $name;
		}
		$returnData = '<div class="full-width">'.$label.'</br>';
		$returnData .=  maticon('star', 'rating '.$id.'rating ', $id.'1rt').' '.maticon('star', 'rating '.$name.'rating', $id.'2rt').' '.maticon('star', 'rating  '.$name.'rating', $id.'3rt').' '.maticon('star', 'rating  '.$name.'rating', $id.'4rt').' '.maticon('star', 'rating '.$name.'rating', $id.'5rt');
		$returnData .=	'<script>
							$(document).ready(function() {
								var rating = $("#'.$id.'rating").val();
								if (rating == 0){
									$(".'.$id.'rating").removeClass("rated");
									$(".'.$id.'rating").addClass("rating");
								}
								else if (rating == 1){
									$(".'.$id.'rating").removeClass("rated");
									$(".'.$id.'rating").removeClass("rating");
									$("#'.$id.'1rt").addClass("rated");
								}
								else if (rating == 2){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
								}
								else if (rating == 3){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'3rt").addClass("rated");
								}
								else if (rating == 4){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'3rt").addClass("rated");
									$("#'.$id.'4rt").addClass("rated");
								}
								else if (rating == 5){
									$(".'.$id.'rating").removeClass("'.getcolorclass(10).'");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'3rt").addClass("rated");
									$("#'.$id.'4rt").addClass("rated");
									$("#'.$id.'5rt").addClass("rated");
								}

								$("#'.$id.'1rt").click(function(){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'rating").val("1");
								});
								
								$("#'.$id.'2rt").click(function(){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'rating").val("2");
								});
								
								$("#'.$id.'3rt").click(function(){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'3rt").addClass("rated");
									$("#'.$id.'rating").val("3");
								});
								$("#'.$id.'4rt").click(function(){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'3rt").addClass("rated");
									$("#'.$id.'4rt").addClass("rated");
									$("#'.$id.'rating").val("4");
								});
								
								$("#'.$id.'5rt").click(function(){
									$(".'.$id.'rating").removeClass("rated");
									$("#'.$id.'1rt").addClass("rated");
									$("#'.$id.'2rt").addClass("rated");
									$("#'.$id.'3rt").addClass("rated");
									$("#'.$id.'4rt").addClass("rated");
									$("#'.$id.'5rt").addClass("rated");
									$("#'.$id.'rating").val("5");
								});

							});
						</script>';

		$returnData .= '<input type="hidden" id="'.$id.'rating" '.($value==''? ' ': 'value="'.$value.'"').'  name="'.$name.'">';
		$returnData .= '</div>';
		return $returnData;
	}	
}

if ( ! function_exists('mdlrating')){
	function mdlrating($value='0'){
			$returnData = '';
			$unratedStar = maticon('star', 'grey-text');
			$ratedStar = maticon('star', ' '.getcolorclass(10).' ');
			if ($value == 0) {
				$returnData = str_repeat($unratedStar, 5);
			}
			elseif ($value == 1) {

				$returnData = str_repeat($ratedStar, 1).''.str_repeat($unratedStar, 4);
			}
			elseif ($value == 2) {
				$returnData = str_repeat($ratedStar, 2).''.str_repeat($unratedStar, 3);
			}
			elseif ($value == 3) {
				$returnData = str_repeat($ratedStar, 3).''.str_repeat($unratedStar, 2);
			}
			elseif ($value == 4) {
				$returnData = str_repeat($ratedStar, 4).''.str_repeat($unratedStar, 1);
			}
			elseif ($value == 5) {
				$returnData = str_repeat($ratedStar, 5);
			}

			elseif ($value > 5) {
				$returnData = str_repeat($ratedStar, 5);
			}
			else{
				$returnData = str_repeat($unratedStar, 5);
			}


			return $returnData;
		}		
}

if ( ! function_exists('mdlsubmitbtn')){
			function mdlsubmitbtn($icon='', $value='', $id='', $class=''){
				$returnData ='<center><button type="submit" class="btn '.($class==''? '': $class).'" '.($id==''? '': 'id="'.$id.'"').'>'.($icon==''? '': maticon($icon, 'spaced-text')).' '.$value.'</button></center>';
				return $returnData;
			}	
}

if ( ! function_exists('materializeiconpicker')){
	function materializeiconpicker($value='', $name='', $label='', $readonly=false, $class='', $id=''){
			if ($id=='') {
				$id = $name;
			}
			$iconpickerlayout = materializeinputtxt($value, $name, $label, $readonly, $class, $id);			
			$iconpickerlayout .= '<script>
									$(function(){
										$("#'.$id.'").materialiconpicker();										
									});
									
								</script>';
			$returnData = $iconpickerlayout;
			return $returnData;
	}	
}

	if ( ! function_exists('dragdropimportexcelfiler')){
			function dragdropimportexcelfiler($name='files', $id='draguploader', $uploadurl='uploads/Uploads/uploadimportfile', $icon='cloud_upload', $class='dragdroperfiler', $filechoosertxt='Drop CSV or XLS or XLSX file here to Upload'){
				$extentions ='["csv", "xls", "xlsx"]';
				$limit ='limit: 1,';
				$nooffiles = 1;

				$extrasuccessjs = '$("#'.$name.'-form-submit").submit(function(event){
										event.preventDefault();
										console.log($(this).serialize());
									});';
				


				$uploadtargeturl = site_url($uploadurl);
				$uploadremoveurl = site_url("uploads/Uploads/removefiles");

				
				
				$returnData  = '<input type="file" name="'.$name.'"  id="'.$id.'" '.($class==''? '': ' class="'.$class.'"').' accept=".xls, .xlsx, .csv"/>';
				$returnData .= '<script>
									var importpostdata = [];
									$("#'.$id.'").filepicker({
										filestype : "excel",
										caption : "'.$filechoosertxt.'",
										uploadurl : "'.site_url($uploadurl).'",
										removeurl : "'.site_url('uploads/Uploads/ajaxremoveattachment/').'",
										onSuccess : function(event, data){

											var filedetails = data.filesdetails;
											$("input[name=\"filedbid\"]").val(filedetails.databaseid);
											$("input[name=\"extension\"]").val(filedetails.extension);
											console.log(data);
										}
									});

									
									
									

								</script>';
				
				return $returnData;
			}
	}



	if ( ! function_exists('dragdropattachmentfiler')){
			function dragdropattachmentfiler($name='files', $recId = '0', $entity='fixedassets_assetlist', $icon='cloud_upload', $class='dragdroperfiler', $filechoosertxt='Drop file here to Upload'){
				
				$uploadurl = 'uploads/Uploads/uploadattachments/'.$name.'/'.$recId.'/'.$entity;
				$returnData  = '<input type="file" name="'.$name.'"  id="'.$name.$recId.'" '.($class==''? '': ' class="'.$class.'"').'/>';
				$returnData .= '<script>
									var importpostdata = [];
									$("#'.$name.$recId.'").filepicker({
										caption : "'.$filechoosertxt.'",
										uploadurl : "'.site_url($uploadurl).'",
										removeurl : "'.site_url('uploads/Uploads/ajaxremoveattachment/').'",
										onSuccess : function(event, data){
											var filedetails = data.filesdetails;
											$("input[name=\"filedbid\"]").val(filedetails.databaseid);
											$("input[name=\"extension\"]").val(filedetails.extension);
											console.log(data);
										}
									});

									
									
									

								</script>';
				
				return $returnData;
			}
	}//end of if function exists dragdropfilechooserdocready


	if ( ! function_exists('dragdropfilechooserdocready')){
			function dragdropfilechooserdocready($name='files', $id='draguploader', $uploadurl='uploads/Uploads', $icon='cloud_upload', $class='dragdroperfiler', $filechoosertxt='Drop file here to Upload', $filetypes = array('*')){
				$extentions ='';
				$limit ='';
				$nooffiles = 0;
				$extrasuccessjs ='';
				$extraremovejs = '';

				if ($name=='newassetimages') {
					$extentions ='extensions: ["jpg", "png", "gif"],';
					$limit ='limit: 10,';
					$filechoosertxt = 'Drop Image file here to upload';
				}
				else if ($name=='restoresqlfile') {
					$extentions ='extensions: "sql",';
					$limit ='limit: 1,';
					$nooffiles = 1;
					$filechoosertxt = 'Drop SQL file here to upload';
				}

				if ($nooffiles==1) {
					$extrasuccessjs .=' $("#selected-'.$name.'").attr("value", new_file_name); ';
					$extraremovejs .=' $("#selected-'.$name.'").attr("value", "none"); ';
				}

				if ($name=='importcsvfile') {
					$extrasuccessjs .= ' if ($("#'.$name.'-form-submit").hasClass("disabled")){
											$("#'.$name.'-form-submit").removeClass("disabled");
										} ';
					$extraremovejs .= ' if (!$("#'.$name.'-form-submit").hasClass("disabled")){
											$("#'.$name.'-form-submit").addClass("disabled");
										} ';
				}

				if ($name=='restoresqlfile') {
					$extrasuccessjs .= ' if ($("#'.$name.'-form-submit").hasClass("disabled")){
											$("#'.$name.'-form-submit").removeClass("disabled");
										} ';
					$extraremovejs .= ' if (!$("#'.$name.'-form-submit").hasClass("disabled")){
											$("#'.$name.'-form-submit").addClass("disabled");
										} ';
				}

				$uploadtargeturl = site_url($uploadurl);
				$uploadremoveurl = site_url("uploads/Uploads/removefiles");

				$returnData = '';
				$returnData .= '<script>
									$(function(){
											$("#'.$id.'").fileuploader({
												changeInput: "<div class=\"fileuploader-input\">" +
																  "<div class=\"fileuploader-input-inner center-align\">" +
																	  "<h1 class=\"full-width center-align\">'.maticonjs($icon, 'medium').'</h1>" +
																	  "<h3 class=\"fileuploader-input-caption full-width center-align\"><span>'.$filechoosertxt.'</span></h3>" +
																	  "<p class=\"full-width center-align\">or</p>" +
																	  "<div class=\"fileuploader-input-button waves-effect waves-light\"><span>Browse Files</span></div>" +
																  "</div>" +
															  "</div>",
												theme: "dragdrop",
												upload: {
													url: "'.$uploadtargeturl.'",
													data: null,
													type: "POST",
													enctype: "multipart/form-data",
													start: true,
													synchron: true,
													beforeSend: null,
													onSuccess: function(result, item) {
														console.log(result);
														var data = JSON.parse(result);
														
														if(data.isSuccess && data.files[0]) {
															item.name = data.files[0].name;
														}
														
														item.html.find(".column-actions").append("<a class=\"fileuploader-action fileuploader-action-remove fileuploader-action-success\" title=\"Remove\"><i></i></a>");
														setTimeout(function() {
															item.html.find(".progress-bar2").fadeOut(400);
														}, 400);
													},
													onError: function(item) {
														console.log(item);
														var progressBar = item.html.find(".progress-bar2");
														
														if(progressBar.length > 0) {
															progressBar.find("span").html(0 + "%");
															progressBar.find(".fileuploader-progressbar .bar").width(0 + "%");
															item.html.find(".progress-bar2").fadeOut(400);
														}
														
														item.upload.status != "cancelled" && item.html.find(".fileuploader-action-retry").length == 0 ? item.html.find(".column-actions").prepend(
															"<a class=\"fileuploader-action fileuploader-action-retry\" title=\"Retry\"><i></i></a>"
														) : null;
													},
													onProgress: function(data, item) {
														var progressBar = item.html.find(".progress-bar2");
														
														if(progressBar.length > 0) {
															progressBar.show();
															progressBar.find("span").html(data.percentage + "%");
															progressBar.find(".fileuploader-progressbar .bar").width(data.percentage + "%");
														}
													},
													onComplete: null,
												},
												onRemove: function(item) {
													$.post("'.$uploadremoveurl.'", {
														file: item.name
													});
												},
												captions: {
													feedback: "'.$filechoosertxt.'",
													feedback2: "'.$filechoosertxt.'",
													drop: "'.$filechoosertxt.'"
												}
											});
										});
								</script>';
				$returnData .= '<input type="file" name="'.$name.'"  id="'.$id.'" '.($class==''? '': ' class="'.$class.'"').'/>';
				return $returnData;
			}
	}//end of if function exists dragdropfilechooserdocready


	if ( ! function_exists('dragdropfilechooser')){
			function dragdropfilechooser($name='files', $id='draguploader', $uploadurl='uploads/Uploads', $icon='cloud_upload', $class='dragdroperfiler', $filechoosertxt='Drop file here to Upload', $filetypes = array('*')){
				$uploadtargeturl = site_url($uploadurl);
				$uploadremoveurl = site_url("uploads/Uploads/removefiles");

				$returnData = '';
				$returnData .= '<script>
									$(function(){
											$("#'.$id.'").fileuploader({
												changeInput: "<div class=\"fileuploader-input\">" +
																  "<div class=\"fileuploader-input-inner center-align\">" +
																	  "<h1 class=\"full-width center-align\">'.maticonjs($icon, 'medium').'</h1>" +
																	  "<h3 class=\"fileuploader-input-caption full-width center-align\"><span>'.$filechoosertxt.'</span></h3>" +
																	  "<p class=\"full-width center-align\">or</p>" +
																	  "<div class=\"fileuploader-input-button waves-effect waves-light\"><span>Browse Files</span></div>" +
																  "</div>" +
															  "</div>",
												theme: "dragdrop",
												upload: {
													url: "'.$uploadtargeturl.'",
													data: null,
													type: "POST",
													enctype: "multipart/form-data",
													start: true,
													synchron: true,
													beforeSend: null,
													onSuccess: function(result, item) {
														console.log(result);
														var data = JSON.parse(result);
														
														if(data.isSuccess && data.files[0]) {
															item.name = data.files[0].name;
														}
														
														item.html.find(".column-actions").append("<a class=\"fileuploader-action fileuploader-action-remove fileuploader-action-success\" title=\"Remove\"><i></i></a>");
														setTimeout(function() {
															item.html.find(".progress-bar2").fadeOut(400);
														}, 400);
													},
													onError: function(item) {
														console.log(item);
														var progressBar = item.html.find(".progress-bar2");
														
														if(progressBar.length > 0) {
															progressBar.find("span").html(0 + "%");
															progressBar.find(".fileuploader-progressbar .bar").width(0 + "%");
															item.html.find(".progress-bar2").fadeOut(400);
														}
														
														item.upload.status != "cancelled" && item.html.find(".fileuploader-action-retry").length == 0 ? item.html.find(".column-actions").prepend(
															"<a class=\"fileuploader-action fileuploader-action-retry\" title=\"Retry\"><i></i></a>"
														) : null;
													},
													onProgress: function(data, item) {
														var progressBar = item.html.find(".progress-bar2");
														
														if(progressBar.length > 0) {
															progressBar.show();
															progressBar.find("span").html(data.percentage + "%");
															progressBar.find(".fileuploader-progressbar .bar").width(data.percentage + "%");
														}
													},
													onComplete: null,
												},
												onRemove: function(item) {
													$.post("'.$uploadremoveurl.'", {
														file: item.name
													});
												},
												captions: {
													feedback: "'.$filechoosertxt.'",
													feedback2: "'.$filechoosertxt.'",
													drop: "'.$filechoosertxt.'"
												}
											});
										});
								</script>';
				$returnData .= '<div id="'.$id.'" '.($class==''? '': ' class="'.$class.'"').' > </div>';
				return $returnData;
			}
	}//end of if function exists dragdropfilechooser


	if ( ! function_exists('imageuploader')){
			function imageuploader($name='files', $id='draguploader', $entity='fixedassets_assetlist', $recId='0', $class='dragdroperfiler', $filechoosertxt='Drag & Drop Images here'){
				$uploadurl = 'uploads/Uploads/uploadattachments/'.$name.'/'.$recId.'/'.$entity.'/1/1';
				$returnData  = '<input type="file" name="'.$name.'"  id="'.$name.$recId.'" '.($class==''? '': ' class="'.$class.'"').'/>';
				$returnData .= '<script>
									var importpostdata = [];
									$("#'.$name.$recId.'").filepicker({
										caption : "'.$filechoosertxt.'",
										filestype: "images",
										uploadurl : "'.site_url($uploadurl).'",
										removeurl : "'.site_url('uploads/Uploads/ajaxremoveattachment/').'",
										onSuccess : function(event, data){
											var filedetails = data.filesdetails;
											$("input[name=\"filedbid\"]").val(filedetails.databaseid);
											$("input[name=\"extension\"]").val(filedetails.extension);
											console.log(data);
										}
									});

									
									
									

								</script>';
				
				return $returnData;
			}
	}//end of if function exists image uploader

	if ( ! function_exists('filesuploader')){
			function filesuploader($name='files', $id='draguploader', $entity='fixedassets_assetlist', $recId='0', $class='dragdroperfiler', $filechoosertxt='Drag & Drop Files here'){
				$uploadurl = 'uploads/Uploads/uploadattachments/'.$name.'/'.$recId.'/'.$entity;
				$returnData  = '<input type="file" name="'.$name.'"  id="'.$name.$recId.'" '.($class==''? '': ' class="'.$class.'"').'/>';
				$returnData .= '<script>
									var importpostdata = [];
									$("#'.$name.$recId.'").filepicker({
										caption : "'.$filechoosertxt.'",
										uploadurl : "'.site_url($uploadurl).'",
										removeurl : "'.site_url('uploads/Uploads/ajaxremoveattachment/').'",
										onSuccess : function(event, data){
											var filedetails = data.filesdetails;
											$("input[name=\"filedbid\"]").val(filedetails.databaseid);
											$("input[name=\"extension\"]").val(filedetails.extension);
											console.log(data);
										}
									});

									
									
									

								</script>';
				
				return $returnData;
			}
	}//end of if function exists image uploader

	if ( ! function_exists('makercheckervalidation')){
		function makercheckervalidation($fieldId='none', $fieldName=''){	
			$returnData ='<script>
								$("label[for=\"'.$fieldId.'\"]").prepend("<a class=\"makercheckerbtn waves-effect waves-dark\" id=\"mcmodaltrigger'.$fieldId.'\" href=\"#\">lock</a>");
								var '.$fieldId.'mcfield = $("#'.$fieldId.'");
								
								if ('.$fieldId.'mcfield.is("input")) {
									if('.$fieldId.'mcfield.attr("type") != "checkbox" && '.$fieldId.'mcfield.attr("type") != "radio"){
										'.$fieldId.'mcfield.attr("readonly", "readonly");
									}

									
								}
								
								$("#mcmodaltrigger'.$fieldId.'").click(function(){
									openMakercheckerModal("'.$fieldId.'", "'.$fieldName.'");
								});
								
							</script>';
			return $returnData;
		}	
	}

	if ( ! function_exists('materialcolors')){
		function materialcolors($colorname='', $dataobject='array'){
			$primaryclasses = array('red'=>'#f44336', 'pink'=>'#e91e63', 'purple'=>'#9c27b0', 'deep-purple'=>'#673ab7', 'indigo'=>'#3f51b5', 'blue'=>'#2196f3', 'light-blue'=>'#03a9f4', 'cyan'=>'#00bcd4', 'teal'=>'#009688', 'green'=>'#4caf50', 'light-green'=>'#8bc34a', 'lime' => '#cddc39', 'yellow'=>'#ffeb3b', 'amber'=>'#ffc107', 'orange'=>'#ff9800', 'deep-orange'=>'#ff5722', 'brown'=>'#795548', 'grey'=>'#9e9e9e', 'blue-grey'=>'#607d8b');
			$secondarycolors = array(
								'red'=>array('lighten-5' => '#ffebee',  'lighten-4' => '#ffcdd2',  'lighten-3' => '#ef9a9a',  'lighten-2' => '#e57373',  'lighten-1' => '#ef5350',  'darken-1' => '#e53935',  'darken-2' => '#d32f2f',  'darken-3' => '#c62828',  'darken-4' => '#b71c1c',  'accent-1' => '#ff8a80',  'accent-2' => '#ff5252',  'accent-3' => '#ff1744',  'accent-4' => '#d50000'), 
								'pink'=>array('lighten-5' => '#fce4ec', 'lighten-4' => '#f8bbd0', 'lighten-3' => '#f48fb1', 'lighten-2' => '#f06292', 'lighten-1' => '#ec407a', 'darken-1' => '#d81b60', 'darken-2' => '#c2185b', 'darken-3' => '#ad1457', 'darken-4' => '#880e4f', 'accent-1' => '#ff80ab', 'accent-2' => '#ff4081', 'accent-3' => '#f50057', 'accent-4' => '#c51162'), 
								'purple'=>array('lighten-5' => '#f3e5f5', 'lighten-4' => '#e1bee7', 'lighten-3' => '#ce93d8', 'lighten-2' => '#ba68c8', 'lighten-1' => '#ab47bc', 'darken-1' => '#8e24aa', 'darken-2' => '#7b1fa2', 'darken-3' => '#6a1b9a', 'darken-4' => '#4a148c', 'accent-1' => '#ea80fc', 'accent-2' => '#e040fb', 'accent-3' => '#d500f9', 'accent-4' => '#aa00ff'), 
								'deep-purple'=>array('lighten-5' => '#ede7f6', 'lighten-4' => '#d1c4e9', 'lighten-3' => '#b39ddb', 'lighten-2' => '#9575cd', 'lighten-1' => '#7e57c2', 'darken-1' => '#5e35b1', 'darken-2' => '#512da8', 'darken-3' => '#4527a0', 'darken-4' => '#311b92', 'accent-1' => '#b388ff', 'accent-2' => '#7c4dff', 'accent-3' => '#651fff', 'accent-4' => '#6200ea'), 
								'indigo'=>array('lighten-5' => '#e8eaf6', 'lighten-4' => '#c5cae9', 'lighten-3' => '#9fa8da', 'lighten-2' => '#7986cb', 'lighten-1' => '#5c6bc0', 'darken-1' => '#3949ab', 'darken-2' => '#303f9f', 'darken-3' => '#283593', 'darken-4' => '#1a237e', 'accent-1' => '#8c9eff', 'accent-2' => '#536dfe', 'accent-3' => '#3d5afe', 'accent-4' => '#304ffe'), 
								'blue'=>array('lighten-5' => '#e3f2fd', 'lighten-4' => '#bbdefb', 'lighten-3' => '#90caf9', 'lighten-2' => '#64b5f6', 'lighten-1' => '#42a5f5', 'darken-1' => '#1e88e5', 'darken-2' => '#1976d2', 'darken-3' => '#1565c0', 'darken-4' => '#0d47a1', 'accent-1' => '#82b1ff', 'accent-2' => '#448aff', 'accent-3' => '#2979ff', 'accent-4' => '#2962ff'),
								'light-blue'=>array('lighten-5' => '#e1f5fe', 'lighten-4' => '#b3e5fc', 'lighten-3' => '#81d4fa', 'lighten-2' => '#4fc3f7', 'lighten-1' => '#29b6f6', 'darken-1' => '#039be5', 'darken-2' => '#0288d1', 'darken-3' => '#0277bd', 'darken-4' => '#01579b', 'accent-1' => '#80d8ff', 'accent-2' => '#40c4ff', 'accent-3' => '#00b0ff', 'accent-4' => '#0091ea'), 
								'cyan'=>array('lighten-5' => '#e0f7fa', 'lighten-4' => '#b2ebf2', 'lighten-3' => '#80deea', 'lighten-2' => '#4dd0e1', 'lighten-1' => '#26c6da', 'darken-1' => '#00acc1', 'darken-2' => '#0097a7', 'darken-3' => '#00838f', 'darken-4' => '#006064', 'accent-1' => '#84ffff', 'accent-2' => '#18ffff', 'accent-3' => '#00e5ff', 'accent-4' => '#00b8d4'), 
								'teal'=>array('lighten-5' => '#e0f2f1', 'lighten-4' => '#b2dfdb', 'lighten-3' => '#80cbc4', 'lighten-2' => '#4db6ac', 'lighten-1' => '#26a69a', 'darken-1' => '#00897b', 'darken-2' => '#00796b', 'darken-3' => '#00695c', 'darken-4' => '#004d40', 'accent-1' => '#a7ffeb', 'accent-2' => '#64ffda', 'accent-3' => '#1de9b6', 'accent-4' => '#00bfa5'), 
								'green'=>array('lighten-5' => '#e8f5e9', 'lighten-4' => '#c8e6c9', 'lighten-3' => '#a5d6a7', 'lighten-2' => '#81c784', 'lighten-1' => '#66bb6a', 'darken-1' => '#43a047', 'darken-2' => '#388e3c', 'darken-3' => '#2e7d32', 'darken-4' => '#1b5e20', 'accent-1' => '#b9f6ca', 'accent-2' => '#69f0ae', 'accent-3' => '#00e676', 'accent-4' => '#00c853'), 
								'light-green'=>array('lighten-5' => '#f1f8e9', 'lighten-4' => '#dcedc8', 'lighten-3' => '#c5e1a5', 'lighten-2' => '#aed581', 'lighten-1' => '#9ccc65', 'darken-1' => '#7cb342', 'darken-2' => '#689f38', 'darken-3' => '#558b2f', 'darken-4' => '#33691e', 'accent-1' => '#ccff90', 'accent-2' => '#b2ff59', 'accent-3' => '#76ff03', 'accent-4' => '#64dd17'), 
								'lime' => array('lighten-5' => '#f9fbe7', 'lighten-4' => '#f0f4c3', 'lighten-3' => '#e6ee9c', 'lighten-2' => '#dce775', 'lighten-1' => '#d4e157', 'darken-1' => '#c0ca33', 'darken-2' => '#afb42b', 'darken-3' => '#9e9d24', 'darken-4' => '#827717', 'accent-1' => '#f4ff81', 'accent-2' => '#eeff41', 'accent-3' => '#c6ff00', 'accent-4' => '#aeea00'), 
								'yellow'=>array('lighten-5' => '#fffde7', 'lighten-4' => '#fff9c4', 'lighten-3' => '#fff59d', 'lighten-2' => '#fff176', 'lighten-1' => '#ffee58', 'darken-1' => '#fdd835', 'darken-2' => '#fbc02d', 'darken-3' => '#f9a825', 'darken-4' => '#f57f17', 'accent-1' => '#ffff8d', 'accent-2' => '#ffff00', 'accent-3' => '#ffea00', 'accent-4' => '#ffd600'), 
								'amber'=>array('lighten-5' => '#fff8e1', 'lighten-4' => '#ffecb3', 'lighten-3' => '#ffe082', 'lighten-2' => '#ffd54f', 'lighten-1' => '#ffca28', 'darken-1' => '#ffb300', 'darken-2' => '#ffa000', 'darken-3' => '#ff8f00', 'darken-4' => '#ff6f00', 'accent-1' => '#ffe57f', 'accent-2' => '#ffd740', 'accent-3' => '#ffc400', 'accent-4' => '#ffab00'), 
								'orange'=>array('lighten-5' => '#fff3e0', 'lighten-4' => '#ffe0b2', 'lighten-3' => '#ffcc80', 'lighten-2' => '#ffb74d', 'lighten-1' => '#ffa726', 'darken-1' => '#fb8c00', 'darken-2' => '#f57c00', 'darken-3' => '#ef6c00', 'darken-4' => '#e65100', 'accent-1' => '#ffd180', 'accent-2' => '#ffab40', 'accent-3' => '#ff9100', 'accent-4' => '#ff6d00'), 
								'deep-orange'=>array('lighten-5' => '#fbe9e7', 'lighten-4' => '#ffccbc', 'lighten-3' => '#ffab91', 'lighten-2' => '#ff8a65', 'lighten-1' => '#ff7043', 'darken-1' => '#f4511e', 'darken-2' => '#e64a19', 'darken-3' => '#d84315', 'darken-4' => '#bf360c', 'accent-1' => '#ff9e80', 'accent-2' => '#ff6e40', 'accent-3' => '#ff3d00', 'accent-4' => '#dd2c00'), 
								'brown'=>array('lighten-5' => '#efebe9', 'lighten-4' => '#d7ccc8', 'lighten-3' => '#bcaaa4', 'lighten-2' => '#a1887f', 'lighten-1' => '#8d6e63', 'darken-1' => '#6d4c41', 'darken-2' => '#5d4037', 'darken-3' => '#4e342e', 'darken-4' => '#3e2723'), 
								'grey'=>array('lighten-5' => '#fafafa', 'lighten-4' => '#f5f5f5', 'lighten-3' => '#eeeeee', 'lighten-2' => '#e0e0e0', 'lighten-1' => '#bdbdbd', 'darken-1' => '#757575', 'darken-2' => '#616161', 'darken-3' => '#424242', 'darken-4' => '#212121'), 
								'blue-grey'=>array('lighten-5' => '#eceff1', 'lighten-4' => '#cfd8dc', 'lighten-3' => '#b0bec5', 'lighten-2' => '#90a4ae', 'lighten-1' => '#78909c', 'darken-1' => '#546e7a', 'darken-2' => '#455a64', 'darken-3' => '#37474f', 'darken-4' => '#263238')
							);
			$colorname = trim($colorname);

			

			$returndata = FALSE;

			if (strlen($colorname) > 0) {
				$namearray = explode(' ', $colorname);

				if (sizeof($namearray) == 1) {
					if (array_key_exists($namearray[0], $primaryclasses)) {
						if ($dataobject == 'string') {
							$returndata = $primaryclasses[$namearray[0]];
						}
						else if ($dataobject == 'array'){
							$predata = array();
							foreach ($secondarycolors[$namearray[0]] as $key => $value) {
								array_push($predata, $value);
							}
							$returndata = $predata;
						}
						else if ($dataobject == 'object'){
							$returndata = $secondarycolors[$namearray[0]];
						}
						else if ($dataobject == 'jsonarray'){
							$prejsondata = array();
							foreach ($secondarycolors[$namearray[0]] as $secondarycolorkey => $secondarycolorvalue) {
								array_push($prejsondata, $secondarycolorvalue);
							}
							$returndata = json_encode($prejsondata);
						}
						else if ($dataobject == 'jsonobject'){
							$returndata = json_encode($secondarycolors[$namearray[0]]);
						}
					}
				}

				else if (sizeof($namearray) == 2){
					if (array_key_exists($namearray[0], $secondarycolors)) {
						if (array_key_exists($namearray[1], $secondarycolors[$namearray[0]])) {
							$returndata = $secondarycolors[$namearray[0]][$namearray[1]];
						}
					}
				}
			}
			else{
						if ($dataobject == 'array'){
							$returndata = $primaryclasses;
						}
						
						else if ($dataobject == 'jsonarray'){
							$predata = array();
							foreach ($primaryclasses as $key => $value) {
								array_push($predata, $value);
							}
							$returndata = json_encode($predata);
						}
						else if ($dataobject == 'jsonobject'){
							$returndata = json_encode($primaryclasses);
						}
			
			}

			return $returndata;
		}
	}



	if ( ! function_exists('allcolorclasses')){
		function allcolorclasses($colorindex='', $returndata='array'){

			$json = "{
					  'red lighten-5': '#ffebee',
					  'red lighten-4': '#ffcdd2',
					  'red lighten-3': '#ef9a9a',
					  'red lighten-2': '#e57373',
					  'red lighten-1': '#ef5350',
					  'red': '#f44336',
					  'red darken-1': '#e53935',
					  'red darken-2': '#d32f2f',
					  'red darken-3': '#c62828',
					  'red darken-4': '#b71c1c',
					  'red accent-1': '#ff8a80',
					  'red accent-2': '#ff5252',
					  'red accent-3': '#ff1744',
					  'red accent-4': '#d50000',
					  'pink lighten-5': '#fce4ec',
					  'pink lighten-4': '#f8bbd0',
					  'pink lighten-3': '#f48fb1',
					  'pink lighten-2': '#f06292',
					  'pink lighten-1': '#ec407a',
					  'pink': '#e91e63',
					  'pink darken-1': '#d81b60',
					  'pink darken-2': '#c2185b',
					  'pink darken-3': '#ad1457',
					  'pink darken-4': '#880e4f',
					  'pink accent-1': '#ff80ab',
					  'pink accent-2': '#ff4081',
					  'pink accent-3': '#f50057',
					  'pink accent-4': '#c51162',
					  'purple lighten-5': '#f3e5f5',
					  'purple lighten-4': '#e1bee7',
					  'purple lighten-3': '#ce93d8',
					  'purple lighten-2': '#ba68c8',
					  'purple lighten-1': '#ab47bc',
					  'purple': '#9c27b0',
					  'purple darken-1': '#8e24aa',
					  'purple darken-2': '#7b1fa2',
					  'purple darken-3': '#6a1b9a',
					  'purple darken-4': '#4a148c',
					  'purple accent-1': '#ea80fc',
					  'purple accent-2': '#e040fb',
					  'purple accent-3': '#d500f9',
					  'purple accent-4': '#aa00ff',
					  'deep-purple lighten-5': '#ede7f6',
					  'deep-purple lighten-4': '#d1c4e9',
					  'deep-purple lighten-3': '#b39ddb',
					  'deep-purple lighten-2': '#9575cd',
					  'deep-purple lighten-1': '#7e57c2',
					  'deep-purple': '#673ab7',
					  'deep-purple darken-1': '#5e35b1',
					  'deep-purple darken-2': '#512da8',
					  'deep-purple darken-3': '#4527a0',
					  'deep-purple darken-4': '#311b92',
					  'deep-purple accent-1': '#b388ff',
					  'deep-purple accent-2': '#7c4dff',
					  'deep-purple accent-3': '#651fff',
					  'deep-purple accent-4': '#6200ea',
					  'indigo lighten-5': '#e8eaf6',
					  'indigo lighten-4': '#c5cae9',
					  'indigo lighten-3': '#9fa8da',
					  'indigo lighten-2': '#7986cb',
					  'indigo lighten-1': '#5c6bc0',
					  'indigo': '#3f51b5',
					  'indigo darken-1': '#3949ab',
					  'indigo darken-2': '#303f9f',
					  'indigo darken-3': '#283593',
					  'indigo darken-4': '#1a237e',
					  'indigo accent-1': '#8c9eff',
					  'indigo accent-2': '#536dfe',
					  'indigo accent-3': '#3d5afe',
					  'indigo accent-4': '#304ffe',
					  'blue lighten-5': '#e3f2fd',
					  'blue lighten-4': '#bbdefb',
					  'blue lighten-3': '#90caf9',
					  'blue lighten-2': '#64b5f6',
					  'blue lighten-1': '#42a5f5',
					  'blue': '#2196f3',
					  'blue darken-1': '#1e88e5',
					  'blue darken-2': '#1976d2',
					  'blue darken-3': '#1565c0',
					  'blue darken-4': '#0d47a1',
					  'blue accent-1': '#82b1ff',
					  'blue accent-2': '#448aff',
					  'blue accent-3': '#2979ff',
					  'blue accent-4': '#2962ff',
					  'light-blue lighten-5': '#e1f5fe',
					  'light-blue lighten-4': '#b3e5fc',
					  'light-blue lighten-3': '#81d4fa',
					  'light-blue lighten-2': '#4fc3f7',
					  'light-blue lighten-1': '#29b6f6',
					  'light-blue': '#03a9f4',
					  'light-blue darken-1': '#039be5',
					  'light-blue darken-2': '#0288d1',
					  'light-blue darken-3': '#0277bd',
					  'light-blue darken-4': '#01579b',
					  'light-blue accent-1': '#80d8ff',
					  'light-blue accent-2': '#40c4ff',
					  'light-blue accent-3': '#00b0ff',
					  'light-blue accent-4': '#0091ea',
					  'cyan lighten-5': '#e0f7fa',
					  'cyan lighten-4': '#b2ebf2',
					  'cyan lighten-3': '#80deea',
					  'cyan lighten-2': '#4dd0e1',
					  'cyan lighten-1': '#26c6da',
					  'cyan': '#00bcd4',
					  'cyan darken-1': '#00acc1',
					  'cyan darken-2': '#0097a7',
					  'cyan darken-3': '#00838f',
					  'cyan darken-4': '#006064',
					  'cyan accent-1': '#84ffff',
					  'cyan accent-2': '#18ffff',
					  'cyan accent-3': '#00e5ff',
					  'cyan accent-4': '#00b8d4',
					  'teal lighten-5': '#e0f2f1',
					  'teal lighten-4': '#b2dfdb',
					  'teal lighten-3': '#80cbc4',
					  'teal lighten-2': '#4db6ac',
					  'teal lighten-1': '#26a69a',
					  'teal': '#009688',
					  'teal darken-1': '#00897b',
					  'teal darken-2': '#00796b',
					  'teal darken-3': '#00695c',
					  'teal darken-4': '#004d40',
					  'teal accent-1': '#a7ffeb',
					  'teal accent-2': '#64ffda',
					  'teal accent-3': '#1de9b6',
					  'teal accent-4': '#00bfa5',
					  'green lighten-5': '#e8f5e9',
					  'green lighten-4': '#c8e6c9',
					  'green lighten-3': '#a5d6a7',
					  'green lighten-2': '#81c784',
					  'green lighten-1': '#66bb6a',
					  'green': '#4caf50',
					  'green darken-1': '#43a047',
					  'green darken-2': '#388e3c',
					  'green darken-3': '#2e7d32',
					  'green darken-4': '#1b5e20',
					  'green accent-1': '#b9f6ca',
					  'green accent-2': '#69f0ae',
					  'green accent-3': '#00e676',
					  'green accent-4': '#00c853',
					  'light-green lighten-5': '#f1f8e9',
					  'light-green lighten-4': '#dcedc8',
					  'light-green lighten-3': '#c5e1a5',
					  'light-green lighten-2': '#aed581',
					  'light-green lighten-1': '#9ccc65',
					  'light-green': '#8bc34a',
					  'light-green darken-1': '#7cb342',
					  'light-green darken-2': '#689f38',
					  'light-green darken-3': '#558b2f',
					  'light-green darken-4': '#33691e',
					  'light-green accent-1': '#ccff90',
					  'light-green accent-2': '#b2ff59',
					  'light-green accent-3': '#76ff03',
					  'light-green accent-4': '#64dd17',
					  'lime lighten-5': '#f9fbe7',
					  'lime lighten-4': '#f0f4c3',
					  'lime lighten-3': '#e6ee9c',
					  'lime lighten-2': '#dce775',
					  'lime lighten-1': '#d4e157',
					  'lime': '#cddc39',
					  'lime darken-1': '#c0ca33',
					  'lime darken-2': '#afb42b',
					  'lime darken-3': '#9e9d24',
					  'lime darken-4': '#827717',
					  'lime accent-1': '#f4ff81',
					  'lime accent-2': '#eeff41',
					  'lime accent-3': '#c6ff00',
					  'lime accent-4': '#aeea00',
					  'yellow lighten-5': '#fffde7',
					  'yellow lighten-4': '#fff9c4',
					  'yellow lighten-3': '#fff59d',
					  'yellow lighten-2': '#fff176',
					  'yellow lighten-1': '#ffee58',
					  'yellow': '#ffeb3b',
					  'yellow darken-1': '#fdd835',
					  'yellow darken-2': '#fbc02d',
					  'yellow darken-3': '#f9a825',
					  'yellow darken-4': '#f57f17',
					  'yellow accent-1': '#ffff8d',
					  'yellow accent-2': '#ffff00',
					  'yellow accent-3': '#ffea00',
					  'yellow accent-4': '#ffd600',
					  'amber lighten-5': '#fff8e1',
					  'amber lighten-4': '#ffecb3',
					  'amber lighten-3': '#ffe082',
					  'amber lighten-2': '#ffd54f',
					  'amber lighten-1': '#ffca28',
					  'amber': '#ffc107',
					  'amber darken-1': '#ffb300',
					  'amber darken-2': '#ffa000',
					  'amber darken-3': '#ff8f00',
					  'amber darken-4': '#ff6f00',
					  'amber accent-1': '#ffe57f',
					  'amber accent-2': '#ffd740',
					  'amber accent-3': '#ffc400',
					  'amber accent-4': '#ffab00',
					  'orange lighten-5': '#fff3e0',
					  'orange lighten-4': '#ffe0b2',
					  'orange lighten-3': '#ffcc80',
					  'orange lighten-2': '#ffb74d',
					  'orange lighten-1': '#ffa726',
					  'orange': '#ff9800',
					  'orange darken-1': '#fb8c00',
					  'orange darken-2': '#f57c00',
					  'orange darken-3': '#ef6c00',
					  'orange darken-4': '#e65100',
					  'orange accent-1': '#ffd180',
					  'orange accent-2': '#ffab40',
					  'orange accent-3': '#ff9100',
					  'orange accent-4': '#ff6d00',
					  'deep-orange lighten-5': '#fbe9e7',
					  'deep-orange lighten-4': '#ffccbc',
					  'deep-orange lighten-3': '#ffab91',
					  'deep-orange lighten-2': '#ff8a65',
					  'deep-orange lighten-1': '#ff7043',
					  'deep-orange': '#ff5722',
					  'deep-orange darken-1': '#f4511e',
					  'deep-orange darken-2': '#e64a19',
					  'deep-orange darken-3': '#d84315',
					  'deep-orange darken-4': '#bf360c',
					  'deep-orange accent-1': '#ff9e80',
					  'deep-orange accent-2': '#ff6e40',
					  'deep-orange accent-3': '#ff3d00',
					  'deep-orange accent-4': '#dd2c00',
					  'brown lighten-5': '#efebe9',
					  'brown lighten-4': '#d7ccc8',
					  'brown lighten-3': '#bcaaa4',
					  'brown lighten-2': '#a1887f',
					  'brown lighten-1': '#8d6e63',
					  'brown': '#795548',
					  'brown darken-1': '#6d4c41',
					  'brown darken-2': '#5d4037',
					  'brown darken-3': '#4e342e',
					  'brown darken-4': '#3e2723',
					  'grey lighten-5': '#fafafa',
					  'grey lighten-4': '#f5f5f5',
					  'grey lighten-3': '#eeeeee',
					  'grey lighten-2': '#e0e0e0',
					  'grey lighten-1': '#bdbdbd',
					  'grey': '#9e9e9e',
					  'grey darken-1': '#757575',
					  'grey darken-2': '#616161',
					  'grey darken-3': '#424242',
					  'grey darken-4': '#212121',
					  'blue-grey lighten-5': '#eceff1',
					  'blue-grey lighten-4': '#cfd8dc',
					  'blue-grey lighten-3': '#b0bec5',
					  'blue-grey lighten-2': '#90a4ae',
					  'blue-grey lighten-1': '#78909c',
					  'blue-grey': '#607d8b',
					  'blue-grey darken-1': '#546e7a',
					  'blue-grey darken-2': '#455a64',
					  'blue-grey darken-3': '#37474f',
					  'blue-grey darken-4': '#263238',
					  'black': '#000000',
					  'white': '#ffffff' }";

			$colorsarray = jsonDecode($json);

			if ($colorindex!='') {
				return $colorsarray[$colorindex];
			}
			if ($returndata=='array') {
				return $colorsarray;
			}
			else {
				return $json;
			}

		}	
	}

	if ( ! function_exists('renderpage')){
			function renderpage($displaydata = array(), $pageview = TRUE){
				$CI = & get_instance();	
				if ($pageview) {
					if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
						$CI->load->vars($displaydata);
						$CI->load->view('pagetemplate');

					}
					else{
						$CI->load->vars($displaydata);
						$CI->load->view('template');
					}
				}
				else{
					if (array_key_exists('mainTemplate', $displaydata)) {
						$template = $displaydata['mainTemplate'];
						if (!array_key_exists('preview', $displaydata)) {
							$displaydata['preview'] = TRUE;
						}
						
						$CI->load->vars($displaydata);
						$CI->load->view($template);
					}
					else{
						if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
							$CI->load->vars($displaydata);
							$CI->load->view('pagetemplate');

						}
						else{
							$CI->load->vars($displaydata);
							$CI->load->view('template');
						}
					}
					
				}
					

					
				
			}	
	}

	if ( ! function_exists('generatematerialtable')){
			function generatematerialtable($data = array(), $datatable = FALSE, $classes = array()){
				$CI = & get_instance();
				$table = '';
				$tabletitle = '';
				$tableclasses = '';
				$rowclasses = '';
				$headers = array();
				if (array_key_exists('title', $data)) {
					$tabletitle = $data['title'];
				}				
				if (array_key_exists('table', $classes)) {
					$tableclasses = 'class="'.$classes['table'].'"';
					if ($datatable) {
						$tableclasses = $classes['table'];
					}
				}
				if (array_key_exists('row', $classes)) {
					$rowclasses = 'class="'.$classes['row'].'"';
				}
				$tablestart = materializetablestart($tableclasses, $tabletitle);
				$tableend = materializetableend();
				if ($datatable) {
					$tablestart = datatable_open($tableclasses, "datatable", $tabletitle);
					$tableend = datatable_close();
				}
				$table .= $tablestart;
					if (array_key_exists('headers', $data)) {
						
						if (is_object($data['headers'])) {
							$headers = objecttoarrayrecursivecast($data['headers']);
						}
						else if (is_array($data['headers'])) {
							$headers = $data['headers'];
						}
						$table .= tableheadstart();
							$table .= headerrowstart();
							foreach ($headers as $headerkey => $headervalue) {
								$table .= tablerowcell($headervalue);
							}
							$table .= headerrowend();
						$table .= tableheadend();
					}

					if (array_key_exists('rows', $data)) {
						$table .= tablebodystart();
							if (sizeof($headers)>0) {
								foreach ($data['rows'] as $rowkey => $rowvalue) {
									$table .= tablerowstart($rowclasses);
										foreach ($headers as $headerkey => $headervalue) {
											if (is_object($rowvalue)) {
												$table .= tablerowcell($rowvalue->$headerkey);
											}
											else{
												$table .= tablerowcell($rowvalue[$headerkey]);
											}
										}
									$table .= tablerowend();
								}
							}						

						$table .= tablebodyend();
					}

				$table .= $tableend;
				return $table;
			}	
	}

if ( ! function_exists('mdmodal')){
	function mdmodal($modalvars = array()){

		$modalid = (array_key_exists('id', $modalvars)) ? $modalvars['id'] : uniqid('mdmodal');
		$modalclass = (array_key_exists('class', $modalvars)) ? 'modal modal-fixed-footer modal-fixed-header '.$modalvars['class'] : 'modal modal-fixed-footer modal-fixed-header';
		$modalheaderid = $modalid.'-header';
		$modalheaderclass = (array_key_exists('headerclass', $modalvars)) ? 'modal-header '.$modalvars['headerclass'] : 'modal-header  primary inverse-text';
		$modaltitleid = $modalid.'-title';
		$modaltitle = (array_key_exists('title', $modalvars)) ? $modalvars['title'] : $modalid.' Title';
		$modalcontentclass = (array_key_exists('contentclass', $modalvars)) ? 'modal-content '.$modalvars['contentclass'] : 'modal-content';
		$modalcontentid = $modalid.'-content';
		$modalcontent = (array_key_exists('content', $modalvars)) ? $modalvars['content'] : $modalid.' Content';
		$modalfooterid = $modalid.'-footer';
		$modalfooterclass = (array_key_exists('footerclass', $modalvars)) ? 'modal-footer '.$modalvars['footerclass'] : 'modal-footer';




		$mdmodallayout = mdldivstrt($modalclass, $modalid);
			$mdmodallayout .= mdldivstrt($modalheaderclass, $modalheaderid);
				$mdmodallayout .= headertxt('4', $modaltitle, 'class="full-width vh-centered" id="'.$modaltitleid.'"');
			$mdmodallayout .= mdldivend();



			$mdmodallayout .= mdldivstrt($modalcontentclass, $modalcontentid);
				$mdmodallayout .= $modalcontent;
			$mdmodallayout .= mdldivend();



			$mdmodallayout .= mdldivstrt($modalfooterclass, $modalfooterid);
				$mdmodallayout .= mdllink('href="#" class="modal-action modal-close waves-effect waves-red red-text btn-flat"', maticon('cancel', 'spaced-text').' Dismiss');
			$mdmodallayout .= mdldivend();



		$mdmodallayout .= mdldivend();

		return $mdmodallayout;

	}
}

function datatohtmltablerows($rows = array(), $idcolumn=FALSE, $identitycolumn=FALSE, $ajaxed=FALSE, $contexted=FALSE){	
		$htmlrows = '';
		array_walk($rows, function($row){
			echo '<tr>'.json_encode($row).'</tr></br>\n';
		});
		return $htmlrows;
}
