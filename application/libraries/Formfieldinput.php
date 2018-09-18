<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Formfieldinput{
	public $sqlWhereExtra;
	public function __construct(){
		$this->load->model('mstart', 'clsStrt');
		$this->load->helper('form');
	}
public function __get($var){
	return get_instance()->$var;
  }

public function getFormFields($entity="fixedassets_assetlist"){
	$data = $this->clsStrt->getFormFields($entity);
	return $data;
}

public function getAppFormFields($entity="fixedassets_assetlist"){
	$data = $this->clsStrt->getAppFormFields($entity);
	return $data;
}

public function getFormField($fieldName="", $table="fixedassets_assetlist"){
	if ($fieldName !="") {
		$data = $this->clsStrt->getFormField($fieldName, $table);
	}
	else{
		$data = "";
	}
	
	return $data;
}


public function generateFieldInput($fieldName="", $value="", $table="fixedassets_assetlist"){
	$data = "";
	if (sizeof($this->getFormField($fieldName, $table))>0) {
		foreach ($this->getFormField($fieldName, $table) as $field) {
			if ($field->dataType=="int") {
				if ($field->isFK=="1") {
					$data = $this->generateSingleSelect($fieldName, $value, $table);
				}
				else{
					$data = $this->generateNumberField($field, $value);
				}
				
			}
			elseif ($field->dataType=="varchar") {
				if ($field->isFK=="1") {
					$data = $this->generateSingleSelectField($field, $value);
				}
				else{
					$data = $this->generateVarcharField($field, $value);
				}
			}
			elseif ($field->dataType=="password") {
				$data = $this->generatePasswordField($field, $value);
			}
			elseif ($field->dataType=="date" || $field->dataType=="datetime") {
				$data = $this->generateDateField($field, $value);
			}
			elseif ($field->dataType=="time") {
				$data = $this->generateTimeField($field, $value);
			}
			elseif ($field->dataType=="text") {
				$data = $this->generateTextField($field, $value);
			}
			elseif ($field->dataType=="decimal") {
				$data = $this->generateDecimalField($field, $value);
			}
			else if ($field->dataType=="boolean"){
				$data = $this->generateCheckBox($field, $value);
			}
			else if ($field->dataType=="rating"){
				$data = $this->generateRating($field, $value);
			}
			else if ($field->dataType=="color"){
				$data = $this->generateColor($field, $value);
			}
			else if ($field->dataType=="icon"){
				$data = $this->generateIcon($field, $value);
			}

		}
	}
	
	return $data;

}
public function generateSingleSelect($fieldName="", $value="", $table="fixedassets_assetlist"){
	$data = "";
	if (sizeof($this->getFormField($fieldName, $table))>0) {
		foreach ($this->getFormField($fieldName, $table) as $field) {
			$data = $this->generateSingleSelectField($field, $value);
		}
	}

	return $data;
}

public function generateSingleSelectField($field, $value){
	$selectData = dbtablerecords($field->tableFKname, array(), FALSE, TRUE);
	if (!is_array($selectData)) {
		$selectData = array();
	}
	$countriesflags = FALSE;
	if ($field->tableFKname=='countries') {
		$countriesflags = FALSE;
	}
	$disabled = FALSE;
	$required = FALSE;
	$multiple = FALSE;
	$name = $field->initialName;
	$label = $field->setName;
	$options = array();

	if (is_array($selectData) && sizeof($selectData)>0) {
		$recPkField  = $field->fkTableRecPK;
		$recNameFieldarr = explode(',', $field->fkTableRecName);
		$options['0'] = 'Select '.$field->setName;	
		foreach ($selectData as $optionData) {
			$datavalue = '';
			foreach ($recNameFieldarr as $key => $fieldvalue) {
				$fieldvalue = trim($fieldvalue);
				$datavalue .= $optionData->$fieldvalue;
				if ($key < (sizeof($recNameFieldarr)-1)) {
					$datavalue .= ' ';
				}
			}
			$options[$optionData->$recPkField] = $datavalue;
		}

	}
	

	if ($field->isDis || $field->isdebDis) {
		$disabled = TRUE;
	}
	if ($field->isSubmitArray) {
		$multiple = TRUE;
	}


	
	if ($field->tableFKname!='none') {	
		$inputField	= materializeiconselect($name, $options, $value, $label, 'list', $name, $multiple, $disabled, FALSE);
	}
	else if ($field->tableFKname=='none'){
		$inputField ='<i>Select Not generatable</i>';
	}

	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}

	return $inputField;
}




public function generateMultiSelect($fieldName="", $value="", $entity='fixedassets_assetlist'){
	$data = "";
	if (sizeof($this->getFormField($fieldName, $entity))>0) {
		foreach ($this->getFormField($fieldName, $entity) as $field) {
			$data = $this->generateMultiSelectField($field, $value);
		}
	}

	return $data;
}


public function generateMultiSelectField($field, $value){
	$selectData = dbtablerecords($field->tableFKname, array(), FALSE, TRUE);
	if (!is_array($selectData)) {
		$selectData = array();
	}
	if ($field->tableFKname!='none') {
				$inputField			= 	$this->generateInputLabel($field->setName, $field->isFormReq);
					
				$inputField		.= '<select id="'.$field->initialName.'" name="'.$field->initialName.'[]"  multiple="multiple"  >';
					
				
				
				$recPkField  = $field->fkTableRecPK;
				$recNameField = $field->fkTableRecName;
				if (is_array($selectData) && sizeof($selectData)>0) {
					if ($value=='') {
						
						foreach ($selectData as $optionData) {
									$inputField		.= '<option value="'.$optionData->$recPkField.'">'.$optionData->$recNameField.'</option>';
							
							}
					}

					else {
						foreach ($selectData as $optionData) {

								if ($field->fkTableRecPK == $value) {
									$inputField		.= '<option value="'.$optionData->$recPkField.'">'.$optionData->$recNameField.'</option>';
								}
								else{
									$inputField		.= '<option value="'.$optionData->$recPkField.'">'.$optionData->$recNameField.'</option>';
								}
							}
					}
						
				}
				else{
					$inputField		.= '<option SELECTED disabled> No existing '.$field->setName.'</option>';
				}


				$inputField		.= '</select></br>';
	}
	else if ($field->tableFKname=='none'){
		$inputField ='<b class="orange-text">'.maticon('warning', 'spaced-text').' Select not generatable</i>';
	}

	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}
	
	return $inputField;
}

public function generateInputLabel($label="Label", $required=FALSE){
	$inputLabel	= '<label class="active">'.$label.' '.($required!=FALSE? '<b class="red-text">*</b>': '').'</label>';

	return $inputLabel;
}

public function generateNumberField($field, $value){
	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField	= materializeinputiconnum($value, $field->initialName, $field->setName, 'looks_3', TRUE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputiconnum($value, $field->initialName, $field->setName, 'looks_3', TRUE, '', $field->initialName, TRUE);
			}
	}
	else{
		if ($field->isSubmitArray) {
			$inputField	= materializeinputiconnum($value, $field->initialName.'[]', $field->setName, 'looks_3', FALSE, '', $field->initialName, FALSE);

			if($field->isFormReq){
				$inputField	= 	materializeinputiconnum($value, $field->initialName.'[]', $field->setName, 'looks_3', FALSE, '', '', TRUE);
			}

		}
		else{

			$inputField	= materializeinputiconnum($value, $field->initialName, $field->setName, 'looks_3', FALSE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputiconnum($value, $field->initialName, $field->setName, 'looks_3', FALSE, '', $field->initialName, TRUE);
			}		

		}
		
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}

	return $inputField;

}

public function generateDecimalField($field, $value){
	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField	= materializeinputicondecimal($value, $field->initialName, $field->setName, 'looks_3', TRUE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputicondecimal($value, $field->initialName, $field->setName, 'looks_3', TRUE, '', $field->initialName, TRUE);
			}
	}
	else{
		if ($field->isSubmitArray) {
			$inputField	= materializeinputicondecimal($value, $field->initialName.'[]', $field->setName, 'looks_3', FALSE, '', $field->initialName, FALSE);

			if($field->isFormReq){
				$inputField	= 	materializeinputicondecimal($value, $field->initialName.'[]', $field->setName, 'looks_3', FALSE, '', '', TRUE);
			}

		}
		else{

			$inputField	= materializeinputicondecimal($value, $field->initialName, $field->setName, 'looks_3', FALSE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputicondecimal($value, $field->initialName, $field->setName, 'looks_3', FALSE, '', $field->initialName, TRUE);
			}		

		}
		
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}


	return $inputField;

}


public function generateVarcharField($field, $value){
	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField	= materializeinputicontxt($value, $field->initialName, $field->setName, 'text_fields', TRUE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputicontxt($value, $field->initialName, $field->setName, 'text_fields', TRUE, '', $field->initialName, TRUE);
			}
	}
	else{
		if ($field->isSubmitArray) {
			$inputField	= materializeinputicontxt($value, $field->initialName.'[]', $field->setName, 'text_fields', FALSE, '', $field->initialName, FALSE);

			if($field->isFormReq){
				$inputField	= 	materializeinputicontxt($value, $field->initialName.'[]', $field->setName, 'text_fields', FALSE, '', '', TRUE);
			}

		}
		else{

			$inputField	= materializeinputicontxt($value, $field->initialName, $field->setName, 'text_fields', FALSE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputicontxt($value, $field->initialName, $field->setName, 'text_fields', FALSE, '', $field->initialName, TRUE);
			}		

		}
		
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}



	return $inputField;

}

public function generatePasswordField($field, $value){
	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField	= materializeinputiconpass($value, $field->initialName, $field->setName, 'vpn_key', TRUE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputiconpass($value, $field->initialName, $field->setName, 'vpn_key', TRUE, '', $field->initialName, TRUE);
			}
	}
	else{
		if ($field->isSubmitArray) {
			$inputField	= materializeinputiconpass($value, $field->initialName.'[]', $field->setName, 'vpn_key', FALSE, '', $field->initialName, FALSE);

			if($field->isFormReq){
				$inputField	= 	materializeinputiconpass($value, $field->initialName.'[]', $field->setName, 'vpn_key', FALSE, '', '', TRUE);
			}

		}
		else{

			$inputField	= materializeinputiconpass($value, $field->initialName, $field->setName, 'vpn_key', FALSE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputiconpass($value, $field->initialName, $field->setName, 'vpn_key', FALSE, '', $field->initialName, TRUE);
			}		

		}
		
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}

	return $inputField;

}

public function generateTextField($field, $value){
	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField	= materializetextarea($value, $field->initialName, $field->setName, TRUE, '', $field->initialName, FALSE);
			if($field->isFormReq){				
				$inputField	= materializeicontextarea($value, $field->initialName, $field->setName, 'edit', TRUE, '', $field->initialName, '4', TRUE);
			}
	}
	else{
		if ($field->isSubmitArray) {
			$inputField	= materializeicontextarea($value, $field->initialName.'[]', $field->setName, 'edit', false, '', $field->initialName, '4', FALSE);

			if($field->isFormReq){
				$inputField	= materializeicontextarea($value, $field->initialName.'[]', $field->setName, 'edit', false, '', $field->initialName, '4', TRUE);
			}

		}
		else{
			$inputField	= materializeicontextarea($value, $field->initialName, $field->setName, 'edit', FALSE, '', $field->initialName, '4', FALSE);
			if($field->isFormReq){
				$inputField	= materializeicontextarea($value, $field->initialName, $field->setName, 'edit', FALSE, '', $field->initialName, '4', TRUE);
			}	

		}
		
	}

	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}

	return $inputField;

}

public function generateDateField($field, $value){
	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField	= materializeinputicondate($value, $field->initialName, $field->setName, 'event', TRUE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputicondate($value, $field->initialName, $field->setName, 'event', TRUE, '', $field->initialName, TRUE);
			}
	}
	else{
		if ($field->isSubmitArray) {
			$inputField	= materializeinputicondate($value, $field->initialName.'[]', $field->setName, 'event', FALSE, '', $field->initialName, FALSE);

			if($field->isFormReq){
				$inputField	= 	materializeinputicondate($value, $field->initialName.'[]', $field->setName, 'event', FALSE, '', '', TRUE);
			}

		}
		else{

			$inputField	= materializeinputicondate($value, $field->initialName, $field->setName, 'event', FALSE, '', $field->initialName, FALSE);
			if($field->isFormReq){
				$inputField	= 	materializeinputicondate($value, $field->initialName, $field->setName, 'event', FALSE, '', $field->initialName, TRUE);
			}		

		}
		
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}

	return $inputField;
}

public function generateTimeField($field, $value){

	$inputField		= 	'';
	if ($field->isDis || $field->isdebDis) {
		$inputField		= 	materializeinputtime($value, $field->initialName, $field->setName, true, '', $field->initialName);
		
	}
	else{
		$inputField		= 	materializeinputtime($value, $field->initialName, $field->setName, false, '', $field->initialName);

	}

	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}

	return $inputField;

}


public function generateRating($field, $value){
	if ($value=='') {
		$rating = '0';
	}
	else{
		$rating = $value;
	}
	if ($field->isSubmitArray) {		
		$inputField = mdlinputrating($rating, $field->setName, $field->initialName.'[]', $field->initialName);
	}
	else{
		$inputField = mdlinputrating($rating, $field->setName, $field->initialName, $field->initialName);
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}
	return $inputField;

}

public function generateColor($field, $value){
	if ($value=='') {
		$rating = '0';
	}
	else{
		$rating = $value;
	}
	if ($field->isSubmitArray) {		
		$inputField = materializecolorpicker($value, $field->initialName.'[]', $field->setName, $field->initialName, 'colordatatype="name"');
	}
	else{
		$inputField = materializecolorpicker($value, $field->initialName, $field->setName, $field->initialName, 'colordatatype="name"');
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}
	return $inputField;

}

public function generateIcon($field, $value){
	if ($value=='') {
		$rating = '0';
	}
	else{
		$rating = $value;
	}
	if ($field->isSubmitArray) {		
		$inputField = materializeiconpicker($value, $field->initialName.'[]', $field->setName, $field->isDis);
	}
	else{
		$inputField = materializeiconpicker($value, $field->initialName, $field->setName, $field->isDis);
	}
	
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}
	return $inputField;

}


public function generateCheckBox($field, $value){
	$checked = false;
	if ($value == 1) {
		$checked = true;
	}
	if ($field->isSubmitArray) {
		$inputField = materializechkbox(1, $field->setName, $field->initialName.'[]', $field->initialName, '', $checked);

	}
	else{
		$inputField = materializechkbox(1, $field->setName, $field->initialName, $field->initialName, '', $checked);
	}
	if ($field->makercheckered=='1') {
		$inputField .= makercheckervalidation($field->initialName, $field->setName);

	}
	
	return $inputField;

}
public function generateSubmit($text="Save"){
	$inputField = '<center><input type="submit" class="btn btn-success" value="'.$text.'" style="margin:auto;"></center>';
	return $inputField;

}











}





