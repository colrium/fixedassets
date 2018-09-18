<?php
$dispform = form_open(FIXEDASSETS_PREFIX.'reports/Reports/genrepPurchases/');
		$dispform .='<table class="mdl-data-table mdl-js-data-table" id="formTble">';
		$dispform .=	'<tr class="teal white-text">
							<td colspan="2" class="input-cell"><h3 class="white-text">'.maticon('event','normal-text').' Purchases Report</h3></td>

						</tr>';

		


		$dispform .=	'<tr>
							<td class="input-cell" colspan="2">
								'.materializeradio('all', 'Show All', 'dateSel', 'alldates', '', true).'<br>
								'.materializeradio('year', 'This Year', 'dateSel', 'thisyeardates', '', false).'<br>
								'.materializeradio('month', 'This Month', 'dateSel', 'thismonthdates', '', false).'<br>
								'.materializeradio('selDates', 'Use date range', 'dateSel', 'rangedates', '', false).'<br>
								<div class="col s6">
									<br><br><br>
									'.jdatepicker(date('Y-m-d'), 'specDateStart', 'From', false, '','srtDte').'
								</div>

								<div class="col s6">
									<br><br><br>
									'.jdatepicker(date('Y-m-d'), 'specDateEnd', 'To', false, '','endDte').'
								</div>
								</div>


							</td>
							

						</tr>';

		

		$dispform .=	'<tr>
							<td class="input-cell" colspan="2">
								<br><br><br>
								'.mdlsubmitbtn('equalizer', 'Generate Report').'
								<br><br>
							</td>

						</tr>';








		$dispform .='</table></form>';


		echo $dispform;
?>

					<script>
							

								$('input[name="dateSel"]').change(function(){
									if($(this).attr("value")=="selDates"){
										$('#dateSelection').show();
									}
									else{
										$('#dateSelection').hide();
									}
								});
								
					</script>