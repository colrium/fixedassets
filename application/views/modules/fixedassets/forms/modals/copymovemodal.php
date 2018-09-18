<?php
	$params=array();
	$params['where']['notequalto']=array('primisProtected'=>'1');	
	$locations = dbtablerecords('fixedassets_primaryloc', $params, FALSE);


	$modalvars = array();
	$modalvars['id'] = 'movecpyModal';
	$modalvars['title'] = maticon('swap_horiz', 'spaced-text').' Move';
	$modalvars['contentclass'] = '';

	$modalcontent = '';

	if (haspriveledge('move', 'fixedassets')) {
		$modalcontent .= form_open(FIXEDASSETS_PREFIX.'assets/assets/moveCopyAsset/', 'id="movecpyform"');
			$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= headerTxt(3, 'Move ', 'id="movecpymodalTitle" class="grey-text full-width center-align"');
				$modalcontent .= mdldivend();
				
					if (is_array($locations)) {
						foreach ($locations as $location) {	
								$modalcontent .= mdldivstrt('col s12');
										$modalcontent .= materializeradio($location->primlocID, maticon($location->locIcon, 'spaced-text').' '.$location->primlocIdentifier, 'toprimaryLoc', 'locradio'.$location->primlocID);										
											
												$depparams=array();
												$depparams['where']['equalto']=array('primLocId'=>$location->primlocID);	
												$departments = dbtablerecords('fixedassets_secondaryloc', $depparams, FALSE);
												if (is_array($departments) && sizeof($departments)>0) {
													$modalcontent .= mdldivstrt('padded-left');
														foreach ($departments as $department) {
															$modalcontent .= materializeradio($department->seclocID, maticon($department->locIcon, 'spaced-text').' '.$department->seclocIdentifier, 'tosecondaryLoc', 'depradio'.$department->seclocID).'<br/>';
														}
													$modalcontent .= mdldivend();
												}
													

											
								$modalcontent .= mdldivend();
							
						}
					}
						
				$modalcontent .= mdldivstrt('col s12 padded');
					$modalcontent .= materializechkbox('1', 'Copy?', 'copyAsset', 'copyAsset', '', false);
				$modalcontent .= mdldivend();



				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= mdlsubmitbtn('check', 'Submit', 'movesubmit');
				$modalcontent .= mdldivend();

			$modalcontent .= mdldivend();
		$modalcontent .= form_close();

	}
	else{
		$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= headerTxt(3, 'Sorry you dont have access priveledges to this function', ' class="red-text full-width center-align"');
				$modalcontent .= mdldivend();
		$modalcontent .= mdldivend();
	}

	

	$modalvars['content'] = $modalcontent;

	echo mdmodal($modalvars);




?>


<script type="text/javascript">
	$(document).ready( function () {
		$('input[name="tosecondaryLoc"]').change(function(){
			var parentsprimLocs = $(this).parent().parent().parent().find('input[name="toprimaryLoc"]');
			var parentprimLoc = $(this).parent().parent().find('input[name="toprimaryLoc"]');
			parentsprimLocs.not(parentprimLoc).prop('checked', false);
			parentprimLoc.prop('checked', true);
		});

	});
</script>
