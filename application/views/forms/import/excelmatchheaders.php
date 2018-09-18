<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>highcharts/highcharts.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>highcharts/modules/data.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR;?>highcharts/modules/drilldown.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR; ?>highcharts/highcharts-more.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR; ?>highcharts/modules/solid-gauge.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR; ?>elasticprogress/js/TweenMax.min.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR; ?>elasticprogress/js/elastic-progress.js"></script>
<script type="text/javascript" src="<?php echo CENUM_ASSETS_DIR; ?>importer/importer.js"></script>
<?php


echo mdldivstrt('row');
	echo mdldivstrt('col l3 m4 s12');		
		echo headertxt(3, maticon('system_update_alt', 'spaced-text').breaker().' You Are About to Import '.$numberofrecords.' Records to <b>'.$destination.'</b>', 'class="full-width center-align brown-text text-darken-2"');
		echo breaker(2);
		echo headertxt(4, maticon('swap_horiz', 'spaced-text').' Please Match your file\'s header columns to corresponding db columns', 'class="full-width center-align grey-text text-darken-4"');
		echo headertxt(5, maticon('fiber_manual_record', 'spaced-text').' If a CSV record is determined to be existing, that record\'s data will be updated or incremented depending on the record\'s file data.<br />  Otherwise, a new record will be created according to your data preferences ', 'class="full-width center-align grey-text text-darken-1"');
	echo mdldivend();




	echo mdldivstrt('col l9 m8 s12 data-card step-up-max');
		echo mdldivstrt('cardheader fullheader primarydark');
			echo '<a class="action waves-effect waves-light accent inverse-text modal-trigger" id="demodatabtn" href="#sample-data">'.maticon('line_style', 'spaced-text').'</a>'; 
			echo headertxt(2, maticon('description', 'spaced-text').' '.$filedetails->name, 'class="full-width center-align inverse-text"');			
		echo mdldivend();

		echo mdldivstrt('cardbody white');
			echo form_open('#', 'id="importDef"');			
				foreach ($file_headers as $key => $value) { 
                	echo mdldivstrt('row');
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
                        echo mdldivstrt('col s6 padded-left');
                            echo $value;
                        echo mdldivend();

                        echo mdldivstrt('col s6 padded-left');
                            echo $headersSelect;
                        echo mdldivend();

                	echo mdldivend();
            	}
	            echo mdldivstrt('row');
	            	echo mdldivstrt('col s12');
	                    echo '<input type="hidden" name="importFile" value="'.$filedbid.'" />';
	                    echo '<input type="hidden" name="entity" value="'.$entity.'" />';
	                    echo mdlsubmitbtn('file_download', 'Import', 'import-submit');
	                echo mdldivend();
	            echo mdldivend();


	            echo mdldivstrt('row');


	            echo mdldivend();
	        echo form_close();
		echo mdldivend();
	echo mdldivend();
echo mdldivend();

echo '<script type="text/javascript">
					$("#importDef").importer({
							fgcolor: "'.getcolor().'",
					    	bgcolor: "#e0e0e0",
					    	highlightColor: "#FFFFFF",
					    	validateurl : "'.site_url('imports/Excelimport/validatecolumnsassignment').'"
					});	
			</script>';

echo mdldivstrt('row');//modal row

        echo mdldivstrt('modal modal-fixed-footer modal-fixed-header', 'sample-data');//sampledata modal
            //modal header
            echo mdldivstrt('modal-header center-v-align');
                echo headertxt('4', 'Sample Data From <i>'.$filedetails->name.'</i>', 'class="full-width center-align"');
            echo mdldivend();

            //modal body
            echo mdldivstrt('modal-content pscrollbar grey lighten-3');
                echo mdldivstrt('row');
                    echo mdldivstrt('col s12');

                        if(sizeof($samplerecords) > 0 && is_array($samplerecords)){
                            echo datatable_open('class="highlight"', "sampleimportdata");
                            	echo tableheadstart();//table header columns
	                                echo headerrowstart();
	                                    foreach ($file_headers as $key => $value) {
	                                        echo tablerowcell($value);    
	                                    }
	                                echo headerrowend();
                                echo tableheadend();//head end
                                echo tablebodystart();//body start
	                                foreach ($samplerecords as $key => $value) {
	                                    echo tablerowstart();
	                                        foreach ($value as $valuekey => $valuevalue) {
	                                            echo tablerowcell($valuevalue);
	                                        }
	                                    echo tablerowend();
	                                }
                                echo tablebodyend();//body End


                            echo datatable_close();//data table end
                        }
                    echo mdldivend();
                echo mdldivend();
            echo mdldivend();

            //modal footer
            echo mdldivstrt('modal-footer');
                echo mdllink('href="#" class="modal-action modal-close waves-effect waves-red red-text btn-flat"', maticon('cancel', 'spaced-text').' Dismiss');
            echo mdldivend();

        echo mdldivend();//end of sampledata modal
echo mdldivend();//end of modal row
echo '<script>
                                $(function(){
                                    $("#demodatabtn").leanModal({
                                        ready: function() { 
                                                $.fn.dataTable.tables( { visible: true, api: true } ).columns.adjust();
                                            }
                                    });
                                });
                            </script>'; 


?>





	





