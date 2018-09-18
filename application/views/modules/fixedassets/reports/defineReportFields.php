<?php
	$layout = '';
	

	foreach ($details as $detail) {
		$layout .= $this->layoutgen->formStart(FIXEDASSETS_PREFIX.'forms/Formhandler/defineReportFields/'.$repId, 'normal');
		$layout .= $this->layoutgen->wideTableStart();
		$layout .= $this->layoutgen->tableHeaderStart();
		$layout .= $this->layoutgen->tableHeaderRowStart();
		$layout .= $this->layoutgen->tableHeaderCell('<h3  style="color:#FFFFFF;"> '.$this->layoutgen->fAwesomeIcon('fa-magic').' Define  '.$detail->reportName.' Report Fields</h3>', '4');
		$layout .= $this->layoutgen->tableNormalRowEnd();
		$layout .= $this->layoutgen->tableHeaderRowStart();
		$layout .= $this->layoutgen->tableHeaderCell('<b>Report Field</b>', '1');
		$layout .= $this->layoutgen->tableHeaderCell('<b>Data Filter</b>', '1');
		$layout .= $this->layoutgen->tableHeaderCell('<b>Filter Data</b>', '1');
		$layout .= $this->layoutgen->tableHeaderCell('<b>Include Totals?</b>', '1');
		$layout .= $this->layoutgen->tableNormalRowEnd();
		$layout .= $this->layoutgen->tableHeaderEnd();

		$layout .= $this->layoutgen->tableBodyStart();

		foreach ($fields as $field) {
			$layout .= $this->layoutgen->tableHoverRowStart();
			$layout .= $this->layoutgen->tableNormalCell('<b>'.$field->setName.'</b>');
			$layout .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateSingleSelect('paramId', (set_value('paramId')!=''? set_value('paramId') : $field->paramId), 'fixedassets_report_fields'));
			$layout .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateFieldInput('paramData', (set_value('paramData')!=''? set_value('paramData') : $field->paramData), 'fixedassets_report_fields'));
			if ($field->dataType == 'int' || $field->dataType == 'decimal') {
				if (!$field->isPK && !$field->isFK) {
					$layout .= $this->layoutgen->tableNormalCell(materializechkbox('1', 'Include Totals', 'includeTotals-'.$field->initialName, 'includeTotals-'.$field->initialName, '', ($field->includeTotals == '1'? true : false)));
				}
				else{
					$layout .= $this->layoutgen->tableNormalCell('<input type="hidden" name="includeTotals-'.$field->initialName.'" value="0"> Not Applicable');
				}
				
			}
			else{
				$layout .= $this->layoutgen->tableNormalCell('<input type="hidden" name="includeTotals-'.$field->initialName.'" value="0">Not Applicable');
			}
					
			$layout .= $this->layoutgen->tableHoverRowEnd();
		}

		

		$layout .= $this->layoutgen->tableNormalRowStart();

		$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateSubmit('Finish'), 4);

		$layout .= $this->layoutgen->tableNormalRowEnd();

		$layout .= $this->layoutgen->tableBodyEnd();

		$layout .= $this->layoutgen->wideTableEnd();

		$layout .= $this->layoutgen->formEnd();
	}

	


echo $layout;




