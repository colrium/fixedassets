<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$settable = '';

$layout = mdldivstrt('row paddless rounded-5px');
	$layout .= mdldivstrt('col s12 data-card');
			$layout .= mdldivstrt('cardheader primarydark');
				$layout .= headertxt('3', $recId == 0 ? maticon('add', 'spaced-text').' Add Priveledge' : maticon('edit', 'spaced-text').' Edit Priveledge', 'class="full-width center-align inverse-text"');
			$layout .= mdldivend();
			$layout .= mdldivstrt('cardbody white');
				$layout .= form_open('preferences/System/addedditpriveledge/'.$module.'/'.$recId);
					$layout .= mdldivstrt('row');
						

						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12');
								$layout .= $this->formfieldinput->generateFieldInput('includeadmins', ($recId == 0 ? set_value('includeadmins') : (set_value('includeadmins')!=''? set_value('includeadmins') : $details->includeadmins)), $priveledgestable);
							$layout .= mdldivend();
						$layout .= mdldivend();


						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12');
								$layout .= '<input value="data" id="type" type="text" name="type" readonly="readonly">
          										<label for="type" class="active">Type</label>';	
							$layout .= mdldivend();
						$layout .= mdldivend();


						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12', 'priveledgename');
									
							$layout .= mdldivend();
						$layout .= mdldivend();




						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12 padded');
								$layout .= '<select name="datatable" class="full-width chosen" id="datatableselect">';
									foreach ($tables as $key => $value) {
										if ($recId == 0) {
											if (set_value('datatable') == $value->parentTable) {
												$layout .= '<option value="'.$value->parentTable.'" SELECTED>'.$value->parentTableName.'</option>';
												$settable = $value->parentTable;
											}
											else{
												if ($key==0) {
													$layout .= '<option value="'.$value->parentTable.'" SELECTED>'.$value->parentTableName.'</option>';
													$settable = $value->parentTable;
												}
												else{
													$layout .= '<option value="'.$value->parentTable.'">'.$value->parentTableName.'</option>';
												}
												
											}
										}
										else{
											if (sizeof($details) > 0) {
												if ($details->datatable == $value->parentTable) {
													$layout .= '<option value="'.$value->parentTable.'" SELECTED>'.$value->parentTableName.'</option>';
													$settable = $value->parentTable;
												}
												else{
													$layout .= '<option value="'.$value->parentTable.'">'.$value->parentTableName.'</option>';
												}
											}
											else{
												$layout .= '<option value="'.$value->parentTable.'">'.$value->parentTableName.'</option>';
											}
										}
										
									}
								$layout .= '</select>';
							$layout .= mdldivend();
						$layout .= mdldivend();


						


						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12', 'seldatacolumn');
									
							$layout .= mdldivend();
						$layout .= mdldivend();

						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12 input-field');
								$layout .= '<input value="'.$module.'" id="entity" type="text" name="entity" readonly="readonly">
          										<label for="entity" class="active">Module</label>';	
							$layout .= mdldivend();
						$layout .= mdldivend();

						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12');
								$layout .= mdlsubmitbtn($recId == 0 ? 'add' : 'save', $recId == 0 ? 'Add Priveledge' : 'Update Priveledge');
							$layout .= mdldivend();
						$layout .= mdldivend();

					$layout .= mdldivend();
				$layout .= form_close();
			$layout .= mdldivend();	
		
	$layout .= mdldivend();

$layout .= mdldivend();
	$layout .= '<script type="text/javascript">
					$(function() {';
		if (strlen($settable)>0) {
			$layout .= 'var initialdatatable = "'.$settable.'";
							$.ajax({
								url: "'.site_url('preferences/System/priveledgename/'.$module).'" + "/" +initialdatatable,
								dataType: "html",
									success: function(html){																									             
										$("#priveledgename").html(html);
										$.ajax({
										url: "'.site_url('preferences/System/tablefields').'" + "/" +initialdatatable,
										dataType: "html",
											success: function(html){																									             
												$("#seldatacolumn").html(html);
												$("select").chosen();
											}
										});
									}
							});';
		}
	$layout .= '$("#datatableselect").change(function(){
						$("#seldatacolumn").empty();
							var datatable = $(this).val();
								$.ajax({
								url: "'.site_url('preferences/System/priveledgename/'.$module).'" + "/" +datatable,
								dataType: "html",
									success: function(html){																									             
										$("#priveledgename").html(html);
										$.ajax({
										url: "'.site_url('preferences/System/tablefields').'" + "/" +datatable,
										dataType: "html",
											success: function(html){																									             
												$("#seldatacolumn").html(html);
												$("select").chosen();
											}
										});
									}
								});
					});
				});
				</script>';
echo $layout;

?>