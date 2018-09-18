<?php
	$layout = '';

	$layout .= $this->layoutgen->formStart(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateReport/'.$repId, 'normal');

	$layout .= $this->layoutgen->wideTableStart();

	$layout .= $this->layoutgen->tableHeaderStart();

	$layout .= $this->layoutgen->tableHeaderRowStart();

	if ($repId==0) {
		$layout .= $this->layoutgen->tableHeaderCell('<h3  style="color:#FFFFFF;"> '.maticon('add_circle').' Create Report Wizard</h3>', '2');
	}
	else{
		$layout .= $this->layoutgen->tableHeaderCell('<h3 style="color:#FFFFFF;">'.maticon('edit').' Edit Report Wizard</h3>', '2');
	}

	$layout .= $this->layoutgen->tableHoverRowEnd();

	$layout .= $this->layoutgen->tableHeaderEnd();

	$layout .= $this->layoutgen->tableBodyStart();

	foreach ($fields as $field) {
		
		
		if ($field->initialName != 'reportUser' && $field->initialName != 'dteCreated') {
			$layout .= $this->layoutgen->tableHoverRowStart();

			$layout .= $this->layoutgen->tableNormalCell($field->setName);
			if ($field->isFK) {
				if ($repId==0) {
					$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateSingleSelect($field->initialName, (set_value($field->initialName)!=''? set_value($field->initialName) : $details[$field->initialName]), $field->tableFKname));
				}
				else{
					$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateSingleSelect($field->initialName, (set_value($field->initialName)!=''? set_value($field->initialName) : $details[$field->initialName]), $field->tableFKname));
				}
				
			}

			else{
				if ($repId==0) {
					$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateFieldInput($field->initialName, (set_value($field->initialName)!=''? set_value($field->initialName) : $details[$field->initialName]), 'fixedassets_reports'));
				}
				else{
					$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateFieldInput($field->initialName, (set_value($field->initialName)!=''? set_value($field->initialName) : $details[$field->initialName]), 'fixedassets_reports'));
				}
				
			}
			$layout .= $this->layoutgen->tableHoverRowEnd();
		}
			

		

		
	}

	$layout .= $this->layoutgen->tableNormalRowStart();

	$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateSubmit(' Save And Proceed'), 2);

	$layout .= $this->layoutgen->tableNormalRowEnd();

	$layout .= $this->layoutgen->tableBodyEnd();

	$layout .= $this->layoutgen->wideTableEnd();

	$layout .= $this->layoutgen->formEnd();


echo $layout;




