<?php

$layout = mdldivstrt('row padded white rounded-5px');
	$layout .= mdldivstrt('row');	
		$layout .= form_open('#', 'id="importDef"');
			$layout .= mdldivstrt('row padded grey lighten-1');
				$layout .= mdldivstrt('col s12');
					$layout .= headertxt(3, 'You Are About to Import '.$numberofrecords.' Records to <b>'.$destination.'</b>', 'class="full-width center-align"');
					$layout .= headertxt(5, maticon('announcement', 'spaced-text').'<br /> <i>If a CSV record is determined to be existing, that record\'s data will be updated or incremented depending on the record\'s file data.<br />	Otherwise, a new record will be created according to your data preferences </i>', 'class="full-width center-align grey-text text-darken-3"');
				$layout .= mdldivend();
			$layout .= mdldivend();


			$layout .= mdldivstrt('row '.getcolorclass(9).' '.getcolorclass(5));
				$layout .= mdldivstrt('col s6 padded-left');
					$layout .= headertxt(3, $filename.' Column', 'class="'.getcolorclass(5).'"');
				$layout .= mdldivend();
				$layout .= mdldivstrt('col s6');
					$layout .= headertxt(3, 'Database Column', 'class="'.getcolorclass(5).'"');
				$layout .= mdldivend();
			$layout .= mdldivend();


			
				foreach ($file_headers as $key => $value) {	
					$layout .= mdldivstrt('row');
						$headersSelect = '<select class="chosen full-width" name="targetFields[]">';
						$headerassigned = FALSE;
						foreach ($fields as $field) {
								if (strtolower($value) == strtolower($field['name'])) {
									$headerassigned = TRUE;
									$headersSelect .= '<option value="'.$field['value'].'" SELECTED>'.$field['name'].'</option>';
								}
								else if (strpos(strtolower($field['name']), strtolower($value)) !== FALSE && $headerassigned !== TRUE) {
									$headersSelect .= '<option value="'.$field['value'].'" SELECTED>'.$field['name'].'</option>';
								}
								else{							
									$headersSelect .= '<option value="'.$field['value'].'">'.$field['name'].'</option>';
								}
						}
						$headersSelect .= '</select>';
						$layout .= mdldivstrt('col s6 padded-left');
							$layout .= $value;
						$layout .= mdldivend();

						$layout .= mdldivstrt('col s6 padded-left');
							$layout .= $headersSelect;
						$layout .= mdldivend();

					$layout .= mdldivend();
				}

			$layout .= mdldivstrt('row');
				$layout .= mdldivstrt('col s12');
					$layout .= '<input type="hidden" name="importFile" value="'.$filename.'" />';
					$layout .= '<input type="hidden" name="entity" value="'.$entity.'" />';
					$layout .= mdlsubmitbtn('file_download', 'Import', 'import-submit');
				$layout .= mdldivend();
			$layout .= mdldivend();


			

		$layout .= form_close();
	$layout .= mdldivend();



	$layout .= mdldivstrt('row');//modal row
		$layout .= mdldivstrt('col s12');
			$layout .= '<center><a class="btn-flat waves-effect waves-dark grey lighten-3 blue-grey-text modal-trigger" id="demodatabtn" href="#sample-data">View sample file Data</a></center>';			
		$layout .= mdldivend();

		$layout .= mdldivstrt('modal modal-fixed-footer modal-fixed-header', 'sample-data');//sampledata modal
			//modal header
			$layout .= mdldivstrt('modal-header center-v-align');
				$layout .= headertxt('4', 'Sample Data From <i>'.$filename.'</i>', 'class="full-width center-align '.getcolorclass(5).'"');
			$layout .= mdldivend();

			//modal body
			$layout .= mdldivstrt('modal-content pscrollbar');
				$layout .= mdldivstrt('row');
					$layout .= mdldivstrt('col s12');

						if(sizeof($samplerecords) > 0 && is_array($samplerecords)){
							$layout .= materializetablestart();
								$layout .= headerrowstart();
									foreach ($file_headers as $key => $value) {
										$layout .= tablerowcell($value, 'class="'.getcolorclass(5).'"');	
									}
								$layout .= headerrowend();

								foreach ($samplerecords as $key => $value) {
									$layout .= tablerowstart();
										foreach ($value as $valuekey => $valuevalue) {
											$layout .= tablerowcell($valuevalue);
										}
									$layout .= tablerowend();
								}



							$layout .= materializetableend();
						}
					$layout .= mdldivend();
				$layout .= mdldivend();
			$layout .= mdldivend();

			//modal footer
			$layout .= mdldivstrt('modal-footer');
				$layout .= mdllink('href="#" class="modal-action modal-close waves-effect waves-red red-text btn-flat"', maticon('cancel', 'spaced-text').' Dismiss');
			$layout .= mdldivend();

		$layout .= mdldivend();//end of sampledata modal
	$layout .= mdldivend();//end of modal row





$layout .= mdldivend();

$layout .= '<script type="text/javascript">
					$("#importDef").importer({
							fgcolor: "'.getcolor().'",
					    	bgcolor: "#e0e0e0",
					    	highlightColor: "#FFFFFF",
					    	validateurl : "'.site_url(FIXEDASSETS_PREFIX.'import/Import/validatecolumnsassignment').'"
					});	
			</script>';

echo $layout;

?>





	





