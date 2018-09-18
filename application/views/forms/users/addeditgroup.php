<?php
$modules = $this->config->item('fortmodules');
$moduleicons = $this->config->item('fortmodulesicons');
$dbfields = dbtablefields('systempriveledgedefs');

$layout = mdldivstrt('row  paddless rounded-5px');
	$layout .= mdldivstrt('col s12 data-card step-up-max');
		$layout .= mdldivstrt('cardheader primarydark fullheader');
			$layout .= headertxt('2', $recId == '0' ? maticon('group_add', 'spaced-text').' Add Group' : maticon('group', 'spaced-text').' Edit Group' , 'class="full-width center-align "');
		$layout .= mdldivend();	

		$layout .= mdldivstrt('cardbody');

			$layout .= form_open('users/Users/addeditgroup/'.$recId);
				$layout .= mdldivstrt('col s12');
					$layout .= materializetablestart('', $recId == '0' ? maticon('add', 'spaced-text') : maticon('edit', 'spaced-text'));
						$layout .= tablerowstart();
							$layout .= tablerowcell($this->formfieldinput->generateFieldInput("name", ($recId == '0' ? set_value('name') : (set_value('name')!=''? set_value('name') : $details->name)), 'groups'), 'class="inputcell"');
						$layout .= tablerowend();


						$layout .= tablerowstart();
							$layout .= tablerowcell($this->formfieldinput->generateFieldInput("description", ($recId == '0' ? set_value('description') : (set_value('description')!=''? set_value('description') : $details->description)), 'groups'), 'class="inputcell"');
						$layout .= tablerowend();
					$layout .= materializetableend();
				$layout .= mdldivend();

				foreach ($modules as $modulekey => $modulevalue) {
					$params = array();
					$params['where']['equalto'] = array('entity' => $modulekey);
					$modulepriveledges = dbtablerecords($priveledgestable, $params, FALSE);

					

					if (is_array($modulepriveledges) && sizeof($modulepriveledges)) {
						$layout .= mdldivstrt('col s12');
							$layout .= materializetablestart('class="bordered"', maticon($moduleicons[$modulekey], 'spaced-text').' '.$modulevalue);
								foreach ($modulepriveledges as $priveledgekey => $priveledge) {
									$priveledgechecked = false;
									$priveledgedatavalue = '';
									if ($recId != '0') {
										$privparams = array();
										$privparams['where']['equalto'] = array('target' => 'group', 'targetid' => $recId, 'priveledgeid' => $priveledge->id);
										$priveledgevalues = dbtablerecords($priveledgesallocstable, $privparams, FALSE);
										if (is_array($priveledgevalues) && sizeof($priveledgevalues)>0) {
											$priveledgedata = $priveledgevalues[0];
											$priveledgedatavalue = $priveledgedata->datavalue;
											if ($priveledgedata->value == '1') {
												$priveledgechecked = true;
											}
										}
									}

									$layout .= tablerowstart();
										if ($priveledge->type == 'access') {
											$layout .= tablerowcell(materializechkbox('1', $priveledge->identityname, 'priveledgevalue['.$priveledge->name.']', $priveledge->id, '', $priveledgechecked), 'class="inputcell" colspan="2"');
										}
										else if ($priveledge->type == 'data'){
											$layout .= tablerowcell(materializechkbox('1', $priveledge->identityname, 'priveledgevalue['.$priveledge->name.']', $priveledge->id, '', $priveledgechecked), 'class="inputcell"');
											$layout .= tablerowcell(materializetextarea($priveledgedatavalue, 'datavalue['.$priveledge->name.']', dbfieldsetname($priveledge->id, $priveledge->datacolumn).' Data Values <i>separated by a comma(eg: 1,2,3)</i>'), 'class="inputcell"');
										}
									$layout .= tablerowend();
								}


							$layout .= materializetableend();
						$layout .= mdldivend();
					}
						
				}



				$layout .= mdldivstrt('col s12');
					$layout .= mdlsubmitbtn($recId == '0' ? 'group_add' : 'save', $recId == '0' ? 'Add Group' : 'Update Group');
				$layout .= mdldivend();

			$layout .= form_close();
		$layout .= mdldivend();
	$layout .= mdldivend();

$layout .= mdldivend();

echo $layout;