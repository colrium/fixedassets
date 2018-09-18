<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$layout = mdldivstrt('row white padded rounded-5px');
	$layout .= mdldivstrt('col s12');
		$layout .= mdldivstrt('row');
			$layout .= mdldivstrt('col s12');
				$layout .= headertxt('2', maticon('settings', 'spaced-text').' User Preferences', 'class="full-width center-align "');
			$layout .= mdldivend();	
		$layout .= mdldivend();

		$layout .= horizontaldivider();

		$layout .= mdldivstrt('row');
			$layout .= mdldivstrt('col s12');
				$layout .= form_open(FIXEDASSETS_PREFIX.'preferences/Preferences/userpreferences/'.$userid);
					$layout .= mdldivstrt('row');
						

						$layout .= mdldivstrt('row');

							$layout .= materializetablestart('', maticon('notifications', 'spaced-text').' Alerts');
								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('desktopalerts', ($recId == 0 ? set_value('desktopalerts') : (set_value('desktopalerts')!=''? set_value('desktopalerts') : $details->desktopalerts)), 'fixedassets_userpreferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('emailalerts', ($recId == 0 ? set_value('emailalerts') : (set_value('emailalerts')!=''? set_value('emailalerts') : $details->emailalerts)), 'fixedassets_userpreferences'), 'class="inputcell"');		
								$layout .= tablerowend();


								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('dayspredatealert', ($recId == 0 ? set_value('dayspredatealert') : (set_value('dayspredatealert')!=''? set_value('dayspredatealert') : $details->dayspredatealert)), 'fixedassets_userpreferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('dayspostdatealert', ($recId == 0 ? set_value('dayspostdatealert') : (set_value('dayspostdatealert')!=''? set_value('dayspostdatealert') : $details->dayspostdatealert)), 'fixedassets_userpreferences'), 'class="inputcell"');		
								$layout .= tablerowend();


								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('alertemailaddress', ($recId == 0 ? set_value('alertemailaddress') : (set_value('alertemailaddress')!=''? set_value('alertemailaddress') : $details->alertemailaddress)), 'fixedassets_userpreferences'), 'class="inputcell" colspan="2"');
								$layout .= tablerowend();


							$layout .= materializetableend();

						$layout .= mdldivend();




						$layout .= mdldivstrt('row');

							$layout .= materializetablestart('', maticon('view_quilt', 'spaced-text').' Layout');
								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateSingleSelect("dateformat", ($recId == 0 ? set_value('dateformat') : (set_value('dateformat')!=''? set_value('dateformat') : $details->dateformat)), 'fixedassets_userpreferences'), 'class="inputcell"');
										
								$layout .= tablerowend();


								$layout .= tablerowstart();
									$layout .= tablerowcell(chosenselect('datapresentationview', array('datatables'=>'Data Tables', 'infographics' => 'Info Graphics'), ($recId == 0 ? set_value('datapresentationview') : (set_value('datapresentationview')!=''? set_value('datapresentationview') : $details->datapresentationview)), $this->fieldnames->getFieldName("datapresentationview", "fixedassets_userpreferences")), 'class="inputcell"');		
								$layout .= tablerowend();




							$layout .= materializetableend();
							

						$layout .= mdldivend();


						

						$layout .= mdldivstrt('row');
							$layout .= mdldivstrt('col s12 padded');
								$layout .= mdlsubmitbtn('settings', 'Update Preferences');
							$layout .= mdldivend();
						$layout .= mdldivend();

					$layout .= mdldivend();
				$layout .= form_close();
			$layout .= mdldivend();
		$layout .= mdldivend();		
		
	$layout .= mdldivend();

$layout .= mdldivend();

echo $layout;
?>
