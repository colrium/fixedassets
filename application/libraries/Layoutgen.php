<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layoutgen{
	public function __construct(){
   		$this->load->model('mstart', 'clsStrt');
	}


public function __get($var){
    return get_instance()->$var;
  }

public function divStart($class="", $id="", $style=""){
	$retData = '<div class="'.$class.'" id="'.$id.'" style="'.$style.'">';
	return $retData;
}

public function divEnd(){
	$retData = '</div>';
	return $retData;
}


public function normalTableStart(){
	$retData = '<div class="table-responsive"><table class="mdl-data-table mdl-js-data-table">';
	return $retData;
}

public function normalTableEnd(){
	$retData = '</table></div>';
	return $retData;
}

public function dataTableStart(){
	$retData 	=	'<script>

						$(document).ready(function(){
							$("#datatable").DataTable( {
                              responsive: false,
                              paging:false,
                              dom: "<\"row rounded-5px center-align no-padding no-margin\"<\"col s12 no-padding\"t><\"col s12 grey lighten-2 padded\"pB>>",
                              buttons: [
                              { extend: "colvis", className: "waves-effect waves-teal btn-flat" },
                              { extend: "excel", className: "waves-effect waves-teal btn-flat" },
                              { extend: "csv", className: "waves-effect waves-teal btn-flat" },
                              { extend: "copy", className: "waves-effect waves-teal btn-flat" },
                              { extend: "pdf", className: "waves-effect waves-teal btn-flat" },
                              { extend: "print", className: "waves-effect waves-teal btn-flat" }
                              ],
                              "scrollX": true,
                              scrollY: 430

                          });

							$("#datatable").animateCss("slideInUp");
							
						});
					</script>';

	$retData 	.= 	'<table class="striped highlight" id="datatable">';
	return $retData;
}

public function dataTableEnd(){
	$retData = '</table>';
	return $retData;
}


public function wideTableStart(){
	$retData = '<table class="striped">';
	return $retData;
}

public function wideTableEnd(){
	$retData = '</table>';
	return $retData;
}

public function stripedTableStart(){
	$retData = '<div class="table-responsive2"><table class="mdl-data-table mdl-js-data-table">';
	return $retData;

}

public function stripedTableEnd(){
	$retData = '</table></div>';
	return $retData;
}


public function tableHeaderStart(){
	$retData = '<thead>';
	return $retData;
}

public function tableHeaderEnd(){
	$retData = '</thead>';
	return $retData;
	
}

public function tableBodyStart(){
	$retData = '<tbody>';
	return $retData;
}

public function tableBodyEnd(){
	$retData = '</tbody>';
	return $retData;
}


public function tableHeaderCell($content="", $colspan="1"){
	$retData = '<td class="'.getcolorclass(9).' '.getcolorclass(5).'" colspan="'.$colspan.'">'.$content.'</td>';
	return $retData;
}


public function tableHeaderRowStart($class="", $id=""){
	$retData = '<tr class="'.($class==""? 'grey darken-1 white-text': $class).'" id="'.$id.'">';
	return $retData;

}

public function tableHoverRowStart($class="", $id="", $others=""){
	$retData = '<tr class="hover '.$class.'" id="'.$id.'" '.$others.'>';
	return $retData;

}

public function tableHoverRowEnd(){
	$retData = '</tr>';
	return $retData;
	
}

public function tableNormalRowStart($others=''){
	$retData = '<tr'.($others==''? '': ' '.$others).'>';
	return $retData;

}

public function tableNormalRowEnd(){
	$retData = '</tr>';
	return $retData;
	
}

public function pickerFAwesomeicon($id="", $selected="", $title=""){
	$dropDown = '<div class="full-width">
	                <a class="dropdown-button btn full-width white-text" id="'.$id.'button" href="#" data-activates="'.$id.'"><i class="fa '.$selected.'"></i></a>
	                <div class="dropdown-content" id="'.$id.'">

	                </div>
                </div>';
	if (!empty(trim($selected))) {
		$selectedIcon = 'selected: "'.$selected.'",';
		
		$input ='<input class="form-control" value="'.$selected.'" type="hidden" id="'.$id.'val" name="'.$id.'" />';
	}
	else{
		$selectedIcon = '';
		$input ='<input class="form-control"  type="hidden" id="'.$id.'val" name="'.$id.'" />';
	}
	$retData = '<script>
				$(document).ready(function(){ 
					$("#'.$id.'").iconpicker({
	                        title: "Select '.$title.' Icon",
	                        '.$selectedIcon.'
	                        animation: true,
	                        hideOnSelect: false,
	                        iconBaseClass: "fa", 
						    iconClassPrefix: "fa-",
	                        selectedCustomClass: "label label-success"
	                    });
					$("#'.$id.'").on("iconpickerSelected", function(e) {
						$("#'.$id.'val").val("fa-"+e.iconpickerValue);
						var btnElementId = "#'.$id.'button";
						var selectedIcon = "fa-"+e.iconpickerValue;
						setIconSelectorButtonIcon(btnElementId, selectedIcon);
						

					});
				});
			</script>';
	$retData .= $dropDown ;
	$retData .= $input ;
	return $retData;
	
}

public function tableNormalCell($content="", $colspan="1", $others='class="mdl-data-table__cell--non-numeric"'){
	$retData = '<td colspan="'.$colspan.'" '.$others.'>'.$content.'</td>';
	return $retData;
}

public function tableInputCell($content="", $colspan="1"){
	$retData = '<td class="input-cell" colspan="'.$colspan.'">'.$content.'</td>';
	return $retData;
}

public function fAwesomeIcon($icon="", $iconSize=""){
	$retData = '<i class="fa '.$icon.' '.$iconSize.'"></i> ';
	return $retData;
}


public function formStart($actionUrl="", $type=""){
	if ($type="normal") {
		$retData = form_open($actionUrl);
	}
	else if ($type="multipart"){
		$retData = form_open_multipart($actionUrl);
	}
	
	return $retData;
}

public function formEnd(){
	$retData = '</form>';
	return $retData;
}

public function headerText($size = "1", $text="", $style=""){
	$retData = '<h'.$size.' style="'.$style.'">'.$text.'</h'.$size.'>';
	return $retData;
}

public function ulStart($class = "", $id="", $others=""){
	$retData = '<ul class="'.$class.'" id="'.$id.'" '.$others.'>';
	return $retData;
}

public function ulEnd(){
	$retData = '</ul>';
	return $retData;
}

public function li($class = "",  $content="", $others="", $id=""){
	$retData = '<li class="'.$class.'" id="'.$id.'" '.$others.'>'.$content.'</li>';
	return $retData;
}


public function liStart($id="", $class = "", $others=""){
	$retData = '<li class="'.$class.'" id="'.$id.'" '.$others.'>';
	return $retData;
}
public function liEnd(){
	$retData = '</li>';
	return $retData;
}

public function link($attributes = "",  $content=""){
	$retData = '<a '.$attributes.'>'.$content.'</a>';
	return $retData;
}
public function linkStart($id="", $class = "", $others=""){
	$retData = '<a class="'.$class.'" id="'.$id.'" '.$others.'>';
	return $retData;
}

public function linkEnd(){
	$retData = '</a>';
	return $retData;
}

public function img($class = "",  $source="", $style=""){
	$retData = '<img scr="'.$source.'" class="'.$class.'" style="'.$style.'"/>';
	return $retData;
}


public function userDateFormart($date=""){
	if ($date != "") {
		$retData = date('M d Y', strtotime($date));
	}
	else{
		$retData = '';
	}
	
	return $retData;
}


public function button($class = "",  $id = "", $content="", $style="", $others=""){
	$retData = '<button class="'.$class.'" id="'.$id.'" style="'.$style.'" '.$others.'>'.$content.'</button>';
	return $retData;
}


public function accordion($id = "", $liarray){
	$retData ='<script>
		$("#'.$id.'").accordion();
		</script>';

	$retData .= '<nav>';
	$retData .= '<div id="'.$id.'" class="acco-menu">';
		$retData .= '<ul>';
			foreach ($liarray as $likey) {

					if (is_array($likey['content'])) {
						$elements = $likey['content'];
						$retData .= '<li id="'.$likey['liID'].'"> '.$elements['header'].'';
						$retData .= '<ul class="submenu">';
						$lis = $elements['lis'];
							foreach ($lis as $li) {
								$retData .= '<li id="'.$li['liID'].'"><a href="#">'.$li['content'].'</a></li>';

							}

						$retData .= '</ul>';
						$retData .= '</li>';
					}

					else{
						$retData .= '<li id="'.$likey['liID'].'"><a href="#">'.$likey['content'].'</a></li>';
						$retData .= $likey['liScript'];
					}

				
				$retData .= '<ul>';
			}
		$retData .= '</ul>';

	$retData .= '</div>';

	$retData .= '</nav>';
	return $retData;
}

public function matAccordionStart($id="", $class=""){
	$retData ='<script>
				$(document).ready(function(){
					$("#'.$id.'").accordion();
				});
		</script>';
	$retData .= '<div id="'.$id.'" class="white acco-menu '.$class.'">';
	$retData .= '<ul>';
	return $retData;
}

public function matAccordionEnd(){
	$retData = '</ul>';
	$retData .= '</div>';
	return $retData;
}

public function genModal($modalArray){
	$retData = '';
	if (is_array($modalArray)) {
		extract($modalArray);
		$retData .= '<div class="'.$class.'" id="'.$id.'" >
					      <div class="modal-content">
					      	<h4 class="teal-text">'.$header.'</h4>					        
					          '.$content.'					        
					      </div>
					      <div class="modal-footer">
						      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Dismiss</a>
						  </div>
					  </div>';
	}
			
	return $retData;
}


public function genRadio($name="", $class="", $value="", $title="", $checked=false){

	if ($checked) {
		$radio = '<input type="radio" name="'.$name.'" value="'.$value.'" checked> '.$title;
	}
	else{
		$radio = '<input type="radio" name="'.$name.'" value="'.$value.'"> '.$title;
	}
	$retData = $radio;

	return $retData;

}

public function genCheckbox($name="", $class="", $value="", $title="", $checked=false){
	if ($checked) {
		$radio = '<input type="checkbox" name="'.$name.'" value="'.$value.'" checked> '.$title;
	}
	else{
		$radio = '<input type="checkbox" name="'.$name.'" value="'.$value.'"> '.$title;
	}
	$retData = $radio;

	return $retData;

}

public function genMaterialRadio($name="", $class="", $value="", $title="", $checked=false){

	if ($checked) {
		$radio = '<input type="radio" name="'.$name.'" value="'.$value.'" checked>';
	}
	else{
		$radio = '<input type="radio" name="'.$name.'" value="'.$value.'">';
	}
	$retData = '<div class="radio">
				  <label>'.$radio.' '.$title.'</label>
				</div>';

	return $retData;

}

public function genMaterialCheckbox($name="", $class="", $value="", $title="", $checked=false){
	if ($checked) {
		$radio = '<input type="checkbox" name="'.$name.'" value="'.$value.'" checked>';
	}
	else{
		$radio = '<input type="checkbox" name="'.$name.'" value="'.$value.'">';
	}
	$retData = '<div class="checkbox">
				  <label>'.$radio.' '.$title.'</label>
				</div>';

	return $retData;

}




public function generateSubmit($text="Save"){
	$inputField = '<center><input type="submit" class="btn btn-success" value="'.$text.'" style="margin:auto;"></center>';
	return $inputField;

}


public function genLogo($page='login'){
	$logo = dbattachmentimages('systemlogo', 1, TRUE);
	$image ='';
	if ($logo!=false) {
		if ($page=='login') {
			$image ='<img class="img-responsive" src="data:'.$logo->type.'; base64, '.$logo->file.'" alt="logo" style="height:10vh; width:auto;">';
		}
		else{
			$image ='<img class="img-responsive" src="data:'.$logo->type.'; base64, '.$logo->file.'" alt="logo">';
		}
	}
	else{
		$image ='<img class="img-responsive" src="'.base_url('assets/images/logo/logo.png').'" alt="logo" style="height:10vh; width:auto;">';
	}

	return $image;

}

public function genFavIcon(){
	$logo = dbattachmentimages('systemlogo', 1, TRUE);
	$image ='';
	if ($logo != false) {		
		$image ='<!-- Favicon Icon -->
			    <link rel="shortcut icon" href="data:'.$logo->type.'; base64, '.$logo->file.'" >';
		
	}
	else{
		$image ='<!-- Favicon Icon -->
			    <link rel="shortcut icon" href="'.base_url('assets/images/logo/logo.png').'" >
			    <link rel="icon" href="'.base_url('assets/images/logo/logo.png').'" >';
	}

	return $image;
}

}