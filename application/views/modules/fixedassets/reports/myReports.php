<?php
	$layout = '';
	
		$layout .= $this->layoutgen->wideTableStart();
		$layout .= $this->layoutgen->tableHeaderStart();
		$layout .= $this->layoutgen->tableHeaderRowStart();
		$layout .= $this->layoutgen->tableHeaderCell('<h2  style="color:#FFFFFF;"> '.maticon('equalizer', 'normal-text').' Created Reports</h2>', '4');
		$layout .= $this->layoutgen->tableNormalRowEnd();
		$layout .= $this->layoutgen->tableHeaderRowStart();
		$layout .= $this->layoutgen->tableHeaderCell('<b>Reports</b>', '3');
		$layout .= $this->layoutgen->tableHeaderCell(anchor(FIXEDASSETS_PREFIX.'reports/createreport/createEditReport/0', maticon('add_circle_outline', 'normal-text').' Create New Report', 'class="btn white teal-text right"'), '1');
		$layout .= $this->layoutgen->tableNormalRowEnd();
		$layout .= $this->layoutgen->tableHeaderEnd();

		$layout .= $this->layoutgen->tableBodyStart();

		foreach ($reports as $report) {
			$layout .= $this->layoutgen->tableHoverRowStart();
			$layout .= $this->layoutgen->tableNormalCell('<h3>'.maticon('equalizer', 'normal-text').' '.$report->reportName.'</h3></br><b class="grey-text text-darken-3">'.$report->reportDesc.'</b><br><i class="grey-text">Created on: '.$report->dteCreated.' </i>', '4');
			$layout .= $this->layoutgen->tableHoverRowEnd();
			$layout .= $this->layoutgen->tableHoverRowStart();
			$layout .= $this->layoutgen->tableNormalCell(anchor(FIXEDASSETS_PREFIX.'reports/createreport/createEditReport/'.$report->reportId, maticon('edit', 'normal-text').' Edit Report', 'class="btn-flat teal-text"'));
			$layout .= $this->layoutgen->tableNormalCell(anchor(FIXEDASSETS_PREFIX.'reports/createreport/reportDefine/'.$report->reportId, maticon('filter_list', 'normal-text').' Select Fields', 'class="btn-flat teal-text"'));
			$layout .= $this->layoutgen->tableNormalCell(anchor(FIXEDASSETS_PREFIX.'reports/createreport/defineReportFields/'.$report->reportId, maticon('low_priority', 'normal-text').' Define Fields ', 'class="btn-flat teal-text"'));
			$layout .= $this->layoutgen->tableNormalCell(anchor(FIXEDASSETS_PREFIX.'reports/createreport/deleteReport/'.$report->reportId, maticon('delete', 'normal-text').' Delete Report ', 'class="btn-flat teal-text"'));
			$layout .= $this->layoutgen->tableHoverRowEnd();
		}


		$layout .= $this->layoutgen->tableBodyEnd();

		$layout .= $this->layoutgen->wideTableEnd();

	


echo $layout;