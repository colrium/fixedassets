<?php
	$layout = '';
	

	foreach ($details as $detail) {
		$layout .= $this->layoutgen->formStart(FIXEDASSETS_PREFIX.'forms/Formhandler/addRemoveReportFields/'.$repId, 'normal');
		$layout .= $this->layoutgen->wideTableStart();
		$layout .= $this->layoutgen->tableHeaderStart();

		$layout .= $this->layoutgen->tableHeaderRowStart();

		$layout .= $this->layoutgen->tableHeaderCell('<h3  class="inverse-text"> '.maticon('list').' Select Fields to include in '.$detail->reportName.' Report</h3>', '2');	

		$layout .= $this->layoutgen->tableHoverRowEnd();

		$layout .= $this->layoutgen->tableHeaderEnd();

		$layout .= $this->layoutgen->tableBodyStart();

		$layout .= $this->layoutgen->tableHoverRowStart();

		$layout .= $this->layoutgen->tableNormalCell($this->formfieldinput->generateMultiSelect('fieldId', (set_value('fieldId')!=''? set_value('fieldId') :''), 'fixedassets_report_fields'));

		$layout .= $this->layoutgen->tableHoverRowEnd();
		

		$layout .= $this->layoutgen->tableNormalRowStart();

		$layout .= $this->layoutgen->tableInputCell($this->formfieldinput->generateSubmit('Save Fields'), 2);

		$layout .= $this->layoutgen->tableNormalRowEnd();

		$layout .= $this->layoutgen->tableBodyEnd();

		$layout .= $this->layoutgen->wideTableEnd();

		$layout .= $this->layoutgen->formEnd();
	}

	


echo $layout;




