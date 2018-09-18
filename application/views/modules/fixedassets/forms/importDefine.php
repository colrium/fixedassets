
<link rel="stylesheet" type="text/css" href="<?php echo CENUM_ASSETS_DIR; ?>elasticprogress/css/main.css" />
<script src="<?php echo CENUM_ASSETS_DIR; ?>elasticprogress/js/TweenMax.min.js"></script>
<script src="<?php echo CENUM_ASSETS_DIR; ?>elasticprogress/js/elastic-progress.js"></script>
<?php
$allRecs = $records;
// Get header column

$tableCols = '<table class="mdl-data-table mdl-js-data-table">';
$tableCols .='<tr class="teal white-text">
							<td class="mdl-data-table__cell--non-numeric">Source Field Name</td>
							<td class="mdl-data-table__cell--non-numeric">Destination Field Name</td>
				</tr>';

foreach ($csv_headers as $key => $value) {
	
	$headersSelect = '<select class="chosen full-width" name="targetFields[]">';
	foreach ($fields as $field) {
			if (strtolower($value) == strtolower($field['name'])) {
				$headersSelect .= '<option value="'.$field['value'].'" SELECTED>'.$field['name'].'</option>';
			}
			else{
				$headersSelect .= '<option value="'.$field['value'].'">'.$field['name'].'</option>';
			}
		}
	$headersSelect .= '</select>';
	$tableCols .= 	'<tr class="hover">
						<td class="mdl-data-table__cell--non-numeric half-width">'.$value.'</td>
						<td class="mdl-data-table__cell--non-numeric">'.$headersSelect.'</td>
					</tr>';
}

$tableCols .= '</table>';





?>

<div class="row">
	<div class="col s12"> 
		<?php  echo (form_open('#', 'id="importDef"')); ?>
			<table class="mdl-data-table mdl-js-data-table full-width" >
				<tr>
					<td  class="mdl-data-table__cell--non-numeric" colspan="2"><h3>You Are About to Import <?php echo $allRecs; ?> Records to <b><?php echo $destination; ?></b></h3></td>
				</tr>			

				<tr>
					<td  class="mdl-data-table__cell--non-numeric" colspan="2">
						<?php echo $tableCols; ?><br>
						<input type="hidden" name="importFile" value="<?php echo $filename; ?>">
						<input type="hidden" name="entity" value="<?php echo $entity; ?>">
					</td>
				</tr>


				<tr style="background:#FFFFFF; border:1px solid transparent; height:200px;">
					<td  class="mdl-data-table__cell--non-numeric" colspan="2" style="background:transparent; verticle-align:middle; padding:10px; border:1px solid transparent; text-align:center; color:#07A978; font-size:12px;" id="import-status" valign="middle">
						<?php
						$importinfo = "<i class='fa fa-thumb-tack fa-2x'></i> </br>If a CSV record has the same ".$this->fieldnames->getFieldName('assetCode').", That record's selected destination fields will be updated with their corresponding Source fields.</br>
								Otherwise, new records will be created according to your data preferences.</br>
								Click the button below to start import.";
						echo $importinfo;
						?>
						
					</td>
				</tr>

				

				<tr style ="background:#B4B4B4; border:0px;">
					<td  class="mdl-data-table__cell--non-numeric centertxt" colspan="2" style ="background:transparent; vertical-align: middle; border:0px;" >
						<div class="col s12">

										<div class="box box--centered" id="progress-wrapper">
											<div class="Download" id="elasticProgress" tabindex="0" aria-label="Download"  data-progressbar-label="Importing Records"></div>
										</div>

						</div>
						<div class="col s12 text-center" id="actionButtons">

						</div>
						
					</td>
				</tr>
			</table>


		</br>

			

		</form>


		
<?php echo mdltooltip('progress-wrapper', 'Click white circular button to start the import process'); ?>
	</div>
</div>
		<div class="modal" id="sample-data">
			<div class="modal-content">
				<div class="table-responsive">
							<table class="mdl-data-table mdl-js-data-table">
								<?php
								//header 
								echo '<tr class="teal"> 
										<td class="mdl-data-table__cell--non-numeric" colspan="'.sizeof($csv_headers).'"><h2 class="white-text">Sample Data From File</h3></td>
									</tr>';
								echo '<tr class="mdl-data-table__cell--non-numeric teal">';
									foreach ($csv_headers as $key => $value) {
										echo '<td class="mdl-data-table__cell--non-numeric white-text">'.$value.'</td>';
									}
								echo '</tr>';
								//body
									if (sizeof($records)>2) {
										for ($k=0; $k <= 2; $k++) { 
											echo '<tr class="hover">';
											foreach ($records[$k] as $key => $value) {
												echo '<td class="mdl-data-table__cell--non-numeric">'.$value.'</td>';

											}

											echo '</tr>';
										}
									}
										
								?>

							</table>
				</div>
			</div>
			<div class="modal-footer">
		      <a href="#" class="modal-action modal-close waves-effect waves-red red-text btn-flat">Close</a>
		    </div>


		</div>


<div class="row">
	<div class="col s6 offset-s3">
		<center><a class="btn waves-effect waves-light orange darken-4 white-text modal-trigger" id="demodatabtn" href="#sample-data"> Demo Data</a></center>
		<?php echo mdltooltip('demodatabtn', 'Click to view demo data from your .csv file'); ?>
	</div>

</div>


<script>
$(document).ready(function() {
	var initialmsg = "";
	var targetEnt = '<?php echo $entity;?>';
	
    var recscursor;
	var progressWidth = $("#progress-wrapper").parent().width();
	$("#elasticProgress").ElasticProgress({
				align: "center",
				colorFg: "<?php echo getcolor(); ?>",
				colorBg: "#FFFFFF",
				highlightColor: "#FFFFFF",
				barHeight: 5,
				barStretch: 25,
				bleedTop: 120,
				bleedRight: 100,
				buttonSize: 60,
				fontFamily: "FontAwesome",
				width: progressWidth,
				labelHeight: 35,
				labelTilt: 100,
				background:"transparent",
				textFail: "Import Failed",
				textComplete: "Import Complete",
				arrowHangOnFail: true,
				onClick: function() {
						$(this).ElasticProgress("open");
						
				},
				onOpen: function() {
					$("#import-status").html('<h2 class="<?php echo getcolorclass(10); ?>">Taking Care of a few things...</h2>');
						var percentfloat, percentInt, csvrecords, totalcsvRecords,columnheaders, selectedoptions, progValue, erroroccured, errormessage;
						var postdata = $("#importDef").serializeArray();
						console.log(postdata);
						var $progressobj = $(this);
						$.ajax({
											 url : "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/saveUpdateImportAssets');?>",
											 type: "POST",
											 data : postdata,
											 dataType : "JSON",
											 success:function(data){
											 	if (data != null) {
											 		//response received
											 		erroroccured = data.erroroccured;
													 	if (erroroccured) {
													 		//close progress
													 		$progressobj.ElasticProgress("fail");

													 		
													 		

													 		errormessage = data.errormsg;
													 		
													 		$("#import-status").html('');
													 		var n = $("#import-status").noty({
											                          layout: "center",
											                          theme: "customnoty", 
											                          type: "error",
											                          modal: false,                          
											                          text: errormessage, 
											                          closeWith: ['click'],									                                                   
											                          animation: {
											                              	open  : "animated tada",
											                              	close : "animated zoomOut",
											                              	easing: "swing", 
											                              	speed: 1000 
											                          },
											                          callback: {
											                          		afterClose: function(){
											                          			$progressobj.ElasticProgress("close");
											                          			$("#import-status").html(initialmsg);
											                          		}
											                          }

											                      });
													 	}
													 	else{
													 		
													 		console.log("got first data");
													 		
													 		totalcsvRecords = data.totalcsvRecords;
													 		csvrecords = data.csvrecords;

															var startingRecord = 1;
															var lastRecord = totalcsvRecords-1;

															saveLoop(startingRecord, lastRecord, targetEnt, $progressobj, csvrecords);


													 	}
											 	}
											 	else{
											 		//no response received											 		
											 		$progressobj.ElasticProgress("fail");
													var noResponsefailMessage = '<div class="error-noty red"><center><?php echo maticon("error", "large white-text"); ?></br> Import failed. <br><i>No Response from server</i></center></br><i style="font-size:9px;"><?php echo maticon("cancel", "white-text spaced-text"); ?> Close</i></div>';
													//noty alert
													$("#import-status").html('');	
													var responsefail = $("#import-status").noty({
																		layout: "center",
																		theme: "customnoty", 
																		type: "error",
																		modal: false,                          
																		text: noResponsefailMessage, 
																		closeWith: ['click'],									                                                   
																		animation: {
																				open  : "animated tada",
																				close : "animated zoomOut",
																				easing: "swing", 
																				speed: 1000 
																		},
																		callback: {
																				afterClose: function(){
																				    $progressobj.ElasticProgress("close");
																				    $("#import-status").html(initialmsg);
																				}
																		}
															});
											 	}									
												
											 }
						});

				},
				onCancel: function() {
						$(this).ElasticProgress("close");
				},
				onComplete: function() {
					
						$(this).ElasticProgress("close");						
				}
				
		});


		function saveLoop(startrec, lastrec, targetEntity, $progressobj, importrecords){
				var index, url;				
				var recscursor, percentfloat, percentInt, progValue, paused;
				paused = false;
				url = "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/saveImportAssetRec');?>";


					index = 0;
					var formselectedoptions = $("#importDef").serializeArray();

					for (var i in importrecords) {
						recscursor = index+1;
						var postrecordData = [];
						postrecordData.push("key="+index);
						var arrayindex = 0;
						for (var j in importrecords[i]) {
							postrecordData.push("csv-record["+formselectedoptions[arrayindex].value+"]="+importrecords[i][j]);
							arrayindex++;
						}

						postdata = postrecordData.join("&");


						percentfloat = recscursor/lastrec*100;
						percentInt = Math.trunc(percentfloat);
						progValue = percentInt/100;



						var issavesuccess = postRecordData(url, postdata, $progressobj, progValue, recscursor,targetEntity);

						if (issavesuccess == 1) {
							$progressobj.ElasticProgress("onFail", function(){																		
							index = lastrec+1;																				
							var failMessage = '<div class="error-noty red"><center><?php echo maticon("cloud_download", "large white-text"); ?></br> Import failed on Record '+index+'</center></br></br><button ="btn-flat "><?php echo maticon("cancel", "white-text spaced-text"); ?> Close</button></br></div>';
							//noty alert
							
							var nfail = $("#import-status").noty({
										layout: "center",
										theme: "customnoty", // or 'relax'
										type: "error",
										modal: false,                          
										text: failMessage, 
										closeWith: ['click'],									                                                   
										animation: {
												open  : "animated tada",
												close : "animated zoomOut",
												easing: "swing",
												speed: 1000 
										},
										callback: {
												afterClose: function(){
														$progressobj.ElasticProgress("close");
														$("#import-status").html(initialmsg);
												}
										}

										});
							});
																						
																					
						}																
						else{									
							paused = true;
						}
						
						index++;
					};




		}

		


		function postRecord(postrecdata,$progressobj,progValue,importcursor,targetEntity, importrecord){
			
			var url;

				url = "<?php echo site_url(FIXEDASSETS_PREFIX.'forms/Formhandler/saveImportAssetRec');?>";
										
			
			var params = postrecdata;
			var http = new XMLHttpRequest();
			http.open("POST", url, true);
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.onreadystatechange = function() {
				if(http.readyState == 4 && http.status == 200) {
					var response=http.responseText;
					if (response == 1) {
						$("#import-status").html('<h2 style="color:#07A978">Importing Record: <i>'+importcursor+'</i></h2>');						
						$progressobj.ElasticProgress("setValue", progValue);
						if (progValue==1) {
							$("#import-status").html('<h2 style="color:#07A978"><i>'+importcursor+'</i> Records imported successfully</h2>');
						}

					}
					else{
						console.log(response);
						$progressobj.ElasticProgress("fail");

					}
					
				}
			}
			http.send(params);
			return 1;
			
		}


		function postRecordData(url, postrecdata, $progressobj, progValue, importcursor){
			var params = postrecdata;

			console.log(params);
			var http = new XMLHttpRequest();
			http.open("POST", url, true);
			http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			http.onreadystatechange = function() {
				if(http.readyState == 4 && http.status == 200) {
					var response=http.responseText;
					if (response == 1) {
						$("#import-status").html('<h2 style="color:#07A978">Importing Record: <i>'+importcursor+'</i></h2>');						
						$progressobj.ElasticProgress("setValue", progValue);
						if (progValue==1) {
							$("#import-status").html('<h2 style="color:#07A978"><i>'+importcursor+'</i> Records imported successfully</h2>');
						}

					}
					else{
						console.log(response);
						$progressobj.ElasticProgress("fail");

					}
					
				}
			}
			http.send(params);
			return 1;
		}

		
});
		


</script>

