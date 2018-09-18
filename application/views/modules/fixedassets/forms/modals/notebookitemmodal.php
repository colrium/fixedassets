
			<?php
				$modalcontent  = mdldivstrt('modal modal-fixed-footer modal-fixed-header', 'notebookmodal');
					$modalcontent  .= mdldivstrt('modal-header');
						$modalcontent .= headertxt('4', maticon('add', 'spaced-text').'Add Notebook Item', 'class="full-width center-align '.getcolorclass(5).'"');
					$modalcontent .= mdldivend();
					if (isset($recId) && $recId != '0') {
						$modalcontent .= form_open(FIXEDASSETS_PREFIX.'forms/Formhandler/addeditnotebookitem/'.$recId.'/0', 'id="notebookitemform"');
					}
					$modalcontent  .= mdldivstrt('modal-content');

								if (isset($recId) && $recId != '0') {									
										$modalcontent .= mdldivstrt('row');

											$modalcontent .= mdldivstrt('col s12 padded');
												$modalcontent .= chosenselect('type', array('expense'=>'Expense' ,'maintainance'=>'Maintainance', 'license'=>'License', 'task'=>'Task'), 'maintainance', 'Type', 'type');
											$modalcontent .= mdldivend();


											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= $this->formfieldinput->generateFieldInput("timestamp", set_value('timestamp'), "actions_log");
											$modalcontent .= mdldivend();

											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= $this->formfieldinput->generateFieldInput("description", set_value('timestamp'), "actions_log");
											$modalcontent .= mdldivend();

											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= $this->formfieldinput->generateFieldInput("cost_currency", systempreferences('sys_currency', FALSE), "actions_log");
											$modalcontent .= mdldivend();

											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= $this->formfieldinput->generateFieldInput("cost", set_value('cost'), "actions_log");
											$modalcontent .= mdldivend();

											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= $this->formfieldinput->generateFieldInput("completion_date", set_value('completion_date'), "actions_log");
											$modalcontent .= mdldivend();

											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= $this->formfieldinput->generateFieldInput("notes", set_value('notes'), "actions_log");
											$modalcontent .= mdldivend();

											$modalcontent .= mdldivstrt('col s12 padded margin-top-x1');
												$modalcontent .= mdlsubmitbtn('book', 'Save Notebook', 'savenotebooksubmit');
											$modalcontent .= mdldivend();

										$modalcontent .= mdldivend();					
									
								}
								else{
									$modalcontent .= 	'<center>
															</br>'.maticon('save', 'large red-text text-lighten-1').'</br></br>
															<h5>Sorry!! Please Save New Asset Before adding notebok items</h5>
														
														</center>';
								}

					$modalcontent .= mdldivend();
					$modalcontent .= mdldivstrt('modal-footer');
						$modalcontent .= '<a href="#" class=" modal-action modal-close waves-effect waves-dark red-text btn-flat">Dismiss</a>';
					$modalcontent .= mdldivend();

					if (isset($recId) && $recId>0) {
						$modalcontent .= form_close();
					}

				$modalcontent .= mdldivend();

				echo $modalcontent;



			?>
