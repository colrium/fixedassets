<?php
echo mdldivstrt('row paddless');
		echo mdldivstrt('col l3 m3 s12 paddless step-up-2');
			echo mdldivstrt('page-heading');
				echo '<span>'.modulename($module).'</span>';
			echo mdldivend();
			echo mdldivstrt('col s12 padded center-align');
				echo maticon(moduleicon($module), 'grey-text xxxl-text').breaker();
				echo headerTxt(1, ' Step <strong class="accent-text">'.$step.'</strong> of <strong class="black-text">3</strong>', 'class="full-width center-align grey-text text-darken-2"');
			echo mdldivend();
		echo mdldivend();

		echo mdldivstrt('col l9 m9 s12 data-card step-up-max');
			echo mdldivstrt('cardheader fullheader primarydark');
				echo headerTxt(2, $stepdescription, 'class="full-width center-align inverse-text"');
				
			echo mdldivend();
			echo mdldivstrt('cardbody white dash-window');
				$nextstep = $step+1;
				echo form_open('reports/Reports/addeditreport/'.$recId.'/'.$module.'/'.$nextstep);
						if ($step == 1) {
							echo mdldivstrt('col s12 padded');
								$entityoptions = array();
								foreach ($tables as $value) {
									$entityoptions[$value->parentTable] = $value->parentTableName;
								}
								echo materializeiconselect('entity', $entityoptions, ($recId == '0' ? set_value('entity') : set_value('entity', $details->entity)), dbfieldsetname($table, 'entity'), 'folder', 'reportentity');
							echo mdldivend();

							echo mdldivstrt('col s12 padded');
								echo $this->formfieldinput->generateFieldInput('name', ($recId == '0' ? set_value('name') : set_value('name', $details->name)), $table);
							echo mdldivend();

							echo mdldivstrt('col s12 padded');
								echo $this->formfieldinput->generateFieldInput('description', ($recId == '0' ? set_value('description') : set_value('description', $details->description)), $table);
							echo mdldivend();

							

							echo mdldivstrt('col s12 padded');
								echo $this->formfieldinput->generateFieldInput('icon', ($recId == '0' ? set_value('icon') : set_value('icon', $details->icon)), $table);
							echo mdldivend();

							echo mdldivstrt('col s12 padded');
								echo $this->formfieldinput->generateFieldInput('private', ($recId == '0' ? set_value('private') : set_value('private', $details->private)), $table);
							echo mdldivend();
						}
						else if ($step == 2) {							
							echo mdldivstrt('col s12 padded');
								$fields = dbtablefields($details->entity);
								$fieldsoptions = array();
								foreach ($fields as $field) {
									$fieldsoptions[$field->initialName] = $field->setName;
								}
								echo materializeiconselect('fields', $fieldsoptions, '', dbfieldsetname($table, 'fields'), 'extension', 'reportfieldssel', true);
							echo mdldivend();
						}
						else if ($step == 3) {
							$fields = dbtablefields($details->entity);
							$reportfields = json_decode($details->fields);
							$filteroptions = array('0'=>'No Filter', 'lessthan'=>'Less Than', 'equalto'=>'Equal To', 'greaterthan'=>'Greater Than', 'notequalto'=>'Unequal To');
							$filters = new stdClass;
							if ($details->filters == '') {
								foreach ($reportfields as $reportfield) {
									$filters->$reportfield =  new stdClass;
									$filters->$reportfield->filter = '0';
									$filters->$reportfield->filtervalue = '';
									$filters->$reportfield->totals = 0;
								}
							}
							else{
								$filters = json_decode($details->filters);
							}


							foreach ($fields as $field) {
								if (in_array($field->initialName, $reportfields)) {
									$initialName = $field->initialName;
									echo mdldivstrt('row');
										echo mdldivstrt('col s3');
											echo headerTxt(5, $field->setName);											
									    echo mdldivend();


									    echo mdldivstrt('col s3');
											echo materializeiconselect('filters['.$initialName.']', $filteroptions, $filters->$initialName->filter, 'Filter', 'filter_list', $initialName.'filter');
									    echo mdldivend();

									    echo mdldivstrt('col s4');
											echo materializeinputicontxt($filters->$initialName->filtervalue, 'filtervalues['.$initialName.']', 'Filter Value', 'label_outline', FALSE, '', $initialName.'filtervalue', FALSE);
									    echo mdldivend();

									    if ($field->dataType == 'int' || $field->dataType == 'decimal') {
									    	echo mdldivstrt('col s2');
												echo materializechkbox('1', 'Totals?', 'totals['.$initialName.']', $initialName.'totals', '', $filters->$initialName->totals);
										    echo mdldivend();
									    }
										    
								    echo mdldivend();
								}
									
							}						
							

						}
							

						echo mdldivstrt('col s12');
							echo mdlsubmitbtn(($step < 3? 'arrow_forward':'check'), $step < 3? 'Save and Proceed':'Finish');
						echo mdldivend();
				echo form_close();
			echo mdldivend();
		echo mdldivend();

echo mdldivend();
?>

