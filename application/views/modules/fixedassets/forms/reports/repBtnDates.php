<?php
$layout = mdldivstrt('row');
	$layout .= mdldivstrt('col s12 data-card step-up-max');
		$layout .= mdldivstrt('cardheader fullheader primarydark');
			$layout .= headerTxt(2, maticon('event','spaced-text').' Report Between Dates', 'class="full-width center-align inverse-text"');
		$layout .= mdldivend();

		$layout .= mdldivstrt('cardbody white dash-window');	
			$layout .= form_open(FIXEDASSETS_PREFIX.'reports/Reports/genrepBtnDates/');
				$layout .= mdldivstrt('row padded');
					$layout .= mdldivstrt('col s12');
						$layout .= headerTxt(4, 'Report Type', 'class="grey-text"');
					$layout .= mdldivend();
					$layout .= mdldivstrt('col s12');
						$layout .= materializeradio('assets', 'Fixed Assets Report', 'repType', 'assetsdate', '', true);
					$layout .= mdldivend();
					$layout .= mdldivstrt('col s12');
						$layout .= materializeradio('audit', 'Notebook Report', 'repType', 'notebookdate', '', false);
					$layout .= mdldivend();
				$layout .= mdldivend();



				$layout .= mdldivstrt('row padded');
					$layout .= mdldivstrt('col s12');
						$layout .= headerTxt(4, 'Date Field', 'class="grey-text"');
					$layout .= mdldivend();
					$layout .= mdldivstrt('col s12', 'assetDte');
						$assetsdatefields = dbtablefields('fixedassets_assetlist', 'dataType', 'date');
						$assetsoptions = array();
						if (is_array($assetsdatefields)) {
							foreach ($assetsdatefields as $assetsdatefield) {
								$assetsoptions[$assetsdatefield->initialName] = $assetsdatefield->setName;
							}
						}
						$layout .= materializeiconselect('dteFieldAsset', $assetsoptions, set_value('dteFieldAsset'), 'Fixed Assets Date Field', 'event');
					$layout .= mdldivend();

					$layout .= mdldivstrt('col s12', 'auditDte');
						$notebookdatefields = dbtablefields('actions_log', 'dataType', 'date');
						$notebookdatetimefields = dbtablefields('actions_log', 'dataType', 'datetime');
						$notebookoptions = array();
						if (is_array($notebookdatefields)) {
							foreach ($notebookdatefields as $notebookdatefield) {
								$notebookoptions[$notebookdatefield->initialName] = $notebookdatefield->setName;
							}
						}
						if (is_array($notebookdatetimefields)) {
							foreach ($notebookdatetimefields as $notebookdatetimefield) {
								$notebookoptions[$notebookdatetimefield->initialName] = $notebookdatetimefield->setName;
							}
						}
						$layout .= materializeiconselect('dteFieldAudit', $notebookoptions, set_value('dteFieldAudit'), 'Notebook Date Field', 'event');
					$layout .= mdldivend();
				$layout .= mdldivend();





				$layout .= mdldivstrt('row padded');
					$layout .= mdldivstrt('col s12');
						$layout .= headerTxt(4, 'Period', 'class="grey-text"');
					$layout .= mdldivend();
					$layout .= mdldivstrt('col l3 s12');
						$layout .= materializeradio('all', 'Show All', 'dateSel', 'alldates', '', true);
					$layout .= mdldivend();
					$layout .= mdldivstrt('col l3 s12');
						$layout .= materializeradio('year', 'This Year', 'dateSel', 'thisyeardates', '', false);
					$layout .= mdldivend();
					$layout .= mdldivstrt('col l3 s12');
						$layout .= materializeradio('month', 'This Month', 'dateSel', 'thismonthdates', '', false);
					$layout .= mdldivend();
					$layout .= mdldivstrt('col l3 s12');
						$layout .= materializeradio('selDates', 'Use date range', 'dateSel', 'rangedates', '', false);
					$layout .= mdldivend();
				$layout .= mdldivend();


				$layout .= mdldivstrt('row padded', 'dateSelection');
					$layout .= mdldivstrt('col s12');
						$layout .= headerTxt(4, 'Period Interval', 'class="grey-text"');
					$layout .= mdldivend();
					$layout .= mdldivstrt('col l6 s12');
						$layout .= materializeinputicondate(date('Y-m-d'), 'specDateStart', 'From', 'event', false, '', 'srtDte');
					$layout .= mdldivend();
					$layout .= mdldivstrt('col l6 s12');
						$layout .= materializeinputicondate(date('Y-m-d'), 'specDateEnd', 'To', 'event', false, '', 'endDte');
					$layout .= mdldivend();
				$layout .= mdldivend();



				$layout .= mdldivstrt('row padded');
					$layout .= mdldivstrt('col s12');
						$layout .= mdlsubmitbtn('equalizer', 'Generate Report');
					$layout .= mdldivend();
				$layout .= mdldivend();
			$layout .= form_close();
		$layout .= mdldivend();

	$layout .= mdldivend();
$layout .= mdldivend();
$layout .= '<script>

                if($("input[name=\"repType\"]").attr("value")=="assets"){
                    $("#assetDte").show();
                    $("#auditDte").hide();
                  }
                  else if($("input[name=\"repType\"]").attr("value")=="audit"){
                    $("#auditDte").show();
                    $("#assetDte").hide();
                  }

                $("input[name=\"repType\"]").change(function(){
                  if($(this).attr("value")=="assets"){
                    $("#assetDte").show();
                    $("#auditDte").hide();
                  }
                  else if($(this).attr("value")=="audit"){
                    $("#auditDte").show();
                    $("#assetDte").hide();
                  }
                });

                if($("input[name=\"dateSel\"]").attr("value")!="selDates"){
                    $("#dateSelection").hide();
                  }
                $("input[name=\"dateSel\"]").change(function(){
                  if($(this).attr("value")=="selDates"){
                    $("#dateSelection").show();
                  }
                  else{
                    $("#dateSelection").hide();
                  }
                });
                
          </script>';


echo $layout;














