<?php

	$modalvars = array();
	$modalvars['id'] = 'addremindermodal';
	$modalvars['title'] = ' Add Reminder';
	$modalvars['contentclass'] = '';

	$modalcontent = '';
		$modalcontent .= form_open(ASSISTANT_PREFIX.'notifacations/Notifacations/adddbrecordreminder', 'id="addreminderform"');
			$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12', 'reminderrecordidentity');
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= materializeinputicontxt('', 'subject', 'Subject', 'label', false, '', 'remindersubject', TRUE);
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= materializeicontextarea('', 'description', 'Description', 'subject', false, '', 'reminderdescription', '4', TRUE);
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s12');
					$notifylist = array('all'=>'All Users');
					$modalcontent .= materializeiconselect('notifylist', $notifylist, 'all', 'Notify', 'people', 'remindernotifylist', true);
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= materializeinputicondate(date('Y-m-d'), 'date', 'Date', 'event', false, '', 'reminderdate', FALSE);
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= materializechkbox('recurring', 'Recurring', 'recurring', 'reminderrecurring', 'filled-in', false);
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12 padded', 'remrecurvarsdom');
					$modalcontent .= mdldivstrt('data-card');
						$modalcontent .= mdldivstrt('cardheader grey lighten-2');
							$modalcontent .= headerTxt(2, maticon('schedule', 'spaced-text').' Recurrence Options');
						$modalcontent .= mdldivend();

						$modalcontent .= mdldivstrt('cardbody grey lighten-3');
							$modalcontent .= mdldivstrt('col s12');
								$modalcontent .= materializeinputiconnum('1', 'count', 'Recurrence Count', 'forward_30', false, '', 'recurcount', FALSE);
							$modalcontent .= mdldivend();

							$modalcontent .= mdldivstrt('row');
								$modalcontent .= mdldivstrt('col s12');
									$modalcontent .= materializeradio('daily', 'Daily', 'frequency', 'recurfreqdaily', '', TRUE);
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s11 offset-s1');
									$modalcontent .= materializechkbox('weekdaysonly', 'Weekdays Only', 'frequencydef', 'rfoweekdaysonly');
								$modalcontent .= mdldivend();
							$modalcontent .= mdldivend();

							
							
							$modalcontent .= mdldivstrt('row');
								$modalcontent .= mdldivstrt('col s12');
									$modalcontent .= materializeradio('weekly', 'Weekly', 'frequency', 'recurfreqweekly', '', FALSE);
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2 offset-s1');
									$modalcontent .= materializechkbox('sun', 'Sun', 'frequencydef[]', 'rfoweeklysun', 'filled-in');
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2');
									$modalcontent .= materializechkbox('mon', 'Mon', 'frequencydef[]', 'rfoweeklymon');
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2');
									$modalcontent .= materializechkbox('tue', 'Tue', 'frequencydef[]', 'rfoweeklytue');
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2');
									$modalcontent .= materializechkbox('wed', 'Wed', 'frequencydef[]', 'rfoweeklywed');
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2');
									$modalcontent .= materializechkbox('thur', 'Thur', 'frequencydef[]', 'rfoweeklythur');
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2 offset-s1');
									$modalcontent .= materializechkbox('fri', 'Fri', 'frequencydef[]', 'rfoweeklyfri');
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s2');
									$modalcontent .= materializechkbox('sat', 'Sat', 'frequencydef[]', 'rfoweeklysat', 'filled-in');
								$modalcontent .= mdldivend();
							$modalcontent .= mdldivend();


							$modalcontent .= mdldivstrt('row');
								$modalcontent .= mdldivstrt('col s12');
									$modalcontent .= materializeradio('monthly', 'Monthly', 'frequency', 'reminderrecurfrequencym', '', FALSE);
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s11  offset-s1');
									$modalcontent .= materializeradio('1', 'Fixed date', 'recurfrequencyoptionmonthlyfd', 'recurfrequencyoptionmonthlyfd', '', FALSE);
								$modalcontent .= mdldivend();
								$modalcontent .= mdldivstrt('col s11  offset-s1');
									$modalcontent .= materializeinputiconnum(date('d'), 'recurfrequencyoption', 'Month Date', 'event', false, '', 'rfomonthlydate', FALSE);
								$modalcontent .= mdldivend();
							$modalcontent .= mdldivend();

						$modalcontent .= mdldivend();
					$modalcontent .= mdldivend();
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12 padded');
					$modalcontent .= mdlsubmitbtn('add_alert', 'Add Reminder', 'addremindersubmit');
				$modalcontent .= mdldivend();

			$modalcontent .= mdldivend();
		$modalcontent .= form_close();


	



	$modalvars['content'] = $modalcontent;

	echo mdmodal($modalvars);
