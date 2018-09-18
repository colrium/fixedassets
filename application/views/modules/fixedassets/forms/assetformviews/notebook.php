<?php
$notebookCosts = 0;
echo  mdldivstrt('col s9 rounded-5px data-card step-up-max', 'notebooktab');
	echo mdldivstrt('cardheader fullheader primarydark');
		echo button('class="action  large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));			
		echo headertxt('2', maticon('book', 'spaced-text').' Notebook', 'class="full-width center-align inverse-text"');
	echo mdldivend();

	echo mdldivstrt('cardbody white dash-window mdscrollbar');
		echo mdldivstrt('col s12');
			$actionlogfields = dbtablefields('actions_log');
						echo mdldivstrt('row');
							echo mdldivstrt('col s12');
								echo materializetablestart('', maticon('book', 'spaced-text').' Notebook');
									echo tableheadstart();
										echo tablerowstart();
											if (isdebugger(FALSE)) {
												echo tablerowcell('');
											}
											foreach ($actionlogfields as $actionlogfield) {
												if (!$actionlogfield->isPK && $actionlogfield->isDashShown) {
													echo tablerowcell($actionlogfield->setName);
												}
											}
										echo tablerowend();
									echo tableheadend();

									echo tablebodystart();
										$notebookCosts = 0;
										if (is_array($notebookItems) && sizeof($notebookItems) > 0) {
											foreach ($notebookItems as $notebookItem) {
												$notebookCosts = $notebookCosts+$notebookItem->cost;
												echo tablerowstart();	
													if (isdebugger(FALSE)) {
														echo tablerowcell(anchor('utilities/Database/deleterecord/actions_log/'.$notebookItem->id, maticon('delete', 'spaced-text'), 'class="avatar-char red-text"'));
													}	
													
													foreach ($actionlogfields as $actionlogfield) {
														$initialName = $actionlogfield->initialName;

														if (!$actionlogfield->isPK && $actionlogfield->isDashShown) {
															$ntbkcellvalue = '';
															if ($actionlogfield->dataType == 'date') {
																$ntbkcellvalue = formatmoduledate($notebookItem->$initialName, 'fixedassets');
															}
															else if ($actionlogfield->dataType == 'datetime') {
																$ntbkcellvalue = formatmoduledatetimeformat($notebookItem->$initialName, 'fixedassets');
															}
															else if ($actionlogfield->isMonetary) {
																$ntbkcellvalue = monetaryformat($notebookItem->$initialName);

															}
															else {
																$ntbkcellvalue = $notebookItem->$initialName;
															}
															echo tablerowcell($ntbkcellvalue);
														}
													}
												echo tablerowend();
											}
										}
									echo tablebodyend();

										
								echo materializetableend();
							echo mdldivend();
			echo mdldivend();

			if (haspriveledge('add', 'fixedassets') && haspriveledge('notebook', 'fixedassets')) {
				echo mdldivstrt('fixed-action-btn');
					echo mdllink('href="#notebookmodal" class="btn-floating waves-effect waves-dark primary inverse-text modal-trigger"', maticon('add', 'spaced-text'));
				echo mdldivend();
			}

		echo mdldivend();

		echo mdldivstrt('col s12');
			echo $this->formfieldinput->generateFieldInput("comments", ($recId == 0 ? set_value('comments') : (set_value('comments')!=''? set_value('comments') : $details->comments)));
		echo mdldivend();
	echo mdldivend();
echo mdldivend();

?>

