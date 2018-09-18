	<div class="row">
		<div class="col s12 data-card rounded-5px step-up-max">
			<div class="cardheader primarydark fullheader">
				<h2 class="full-width center-align inverse-text"><?php echo $recId=='0'?  maticon('person_add', 'normal-text').' Add User' :  maticon('person', 'normal-text').' Edit User'; ?></h2>

			</div>
			<div class="cardbody white">
			<?php
				$formLayout = form_open('users/Users/addedituser/'.$recId);
				$formLayout .='<div class="row">';
					$formLayout .= mdltablestart();
						

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('username', 'users'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("username", ($recId == '0' ? set_value('username') : (set_value('username')!=''? set_value('username') : $details->username)), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('email', 'users'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("email", ($recId == '0' ? set_value('email') : (set_value('email')!=''? set_value('email') : $details->email)), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('password', 'users').''.($recId=='0'? '' : ' <br><i class="grey-text text-darken-1">Leave blank if you dont want to change password</i>'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("password", ($recId == '0' ? set_value('password') : (set_value('password')!=''? set_value('password') : '')), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('repeat_password', 'users'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("repeat_password", ($recId == '0' ? set_value('repeat_password') : (set_value('repeat_password')!=''? set_value('repeat_password') : '')), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('first_name', 'users'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("first_name", ($recId == '0' ? set_value('first_name') : (set_value('first_name')!=''? set_value('first_name') : $details->first_name)), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('last_name', 'users'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("last_name", ($recId == '0' ? set_value('last_name') : (set_value('last_name')!=''? set_value('last_name') : $details->last_name)), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell($this->fieldnames->getFieldName('phone', 'users'), 'class="inputcell"');
							$formLayout .= mdltablecell($this->formfieldinput->generateFieldInput("phone", ($recId == '0' ? set_value('phone') : (set_value('phone')!=''? set_value('phone') : $details->phone)), 'users'), 'class="inputcell"');
						$formLayout .= mdlrowend();

						$formLayout .= mdlnormalrowstart('class="grey darken-1"');
							$formLayout .= mdltablecell('<center> <h4 class="white-text">Assign user to a group </h4></center>', 'class="inputcell" colspan="2"');
						$formLayout .= mdlrowend();

						foreach ($groups as $group) {							
							$formLayout .= mdlnormalrowstart();
							if (!isdebugger(FALSE) && isdebuggergroup($group->name)) {
								continue;
							}
							if ($recId!='0') {
									if (in_array($group->id, $usergroups)) {
										$formLayout .= mdltablecell(materializechkbox($group->id, $group->name, 'usergroup[]', 'group'.$group->id, '', true), 'class="inputcell" colspan="2"');
									}
									else{
										$formLayout .= mdltablecell(materializechkbox($group->id, $group->name, 'usergroup[]', 'group'.$group->id, '', false), 'class="inputcell" colspan="2"');
									}

							}
							else{
								$formLayout .= mdltablecell(materializechkbox($group->id, $group->name, 'usergroup[]', 'group'.$group->id, '', false), 'class="inputcell" colspan="2"');
							}							
								
							$formLayout .= mdlrowend();
						}

						$formLayout .= mdlnormalrowstart();
							$formLayout .= mdltablecell(mdlsubmitbtn(($recId == '0' ? 'person_add' : 'save'), ($recId == '0' ? 'Add User' : 'Update User')), 'class="inputcell" colspan="2"');
						$formLayout .= mdlrowend();

					$formLayout .= mdltableend();
				$formLayout .='</div>';//end of row
				$formLayout .= '</form>';
				echo $formLayout;
			?>
	</div>
	</div>
</div>
