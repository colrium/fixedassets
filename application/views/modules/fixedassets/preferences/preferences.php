<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$layout = mdldivstrt('row white padded rounded-5px');
	$layout .= mdldivstrt('col s12');
		$layout .= mdldivstrt('row');
			$layout .= mdldivstrt('col s12');
				$layout .= headertxt('2', maticon('settings', 'spaced-text').' System Preferences', 'class="full-width center-align "');
			$layout .= mdldivend();	
		$layout .= mdldivend();

		$layout .= horizontaldivider();

		$layout .= mdldivstrt('row');
			$layout .= mdldivstrt('col s12');
				$layout .= form_open(FIXEDASSETS_PREFIX.'preferences/Preferences/preferences');
					$layout .= mdldivstrt('row');
						

						$layout .= mdldivstrt('row');

							$layout .= materializetablestart('', set_value('autoupdate').' Defaults');
								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateSingleSelect('currency', set_value('currency', $details->currency), 'fixedassets_preferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateSingleSelect('dateformat', set_value('dateformat', $details->dateformat), 'fixedassets_preferences'), 'class="inputcell"');		
								$layout .= tablerowend();


								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('autoupdate', (set_value('autoupdate')!=''? set_value('autoupdate') : $details->autoupdate), 'fixedassets_preferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('updateur', (set_value('updateur')!=''? set_value('updateur') : $details->updateur), 'fixedassets_preferences'), 'class="inputcell"');		
								$layout .= tablerowend();


							$layout .= materializetableend();

						$layout .= mdldivend();




						$layout .= mdldivstrt('row');

							$layout .= materializetablestart('', maticon('trending_down', 'spaced-text').' Depreciation');
								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateSingleSelect('defaultdepreciationmethod', (set_value('defaultdepreciationmethod')!=''? set_value('defaultdepreciationmethod') : $details->defaultdepreciationmethod), 'fixedassets_preferences'), 'class="inputcell", colspan="2"');										
								$layout .= tablerowend();


								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('fiscalyearstartdate', (set_value('fiscalyearstartdate')!=''? set_value('fiscalyearstartdate') : $details->fiscalyearstartdate), 'fixedassets_preferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('fiscalyearstartmonth', (set_value('fiscalyearstartmonth')!=''? set_value('fiscalyearstartmonth') : $details->fiscalyearstartmonth), 'fixedassets_preferences'), 'class="inputcell"');		
								$layout .= tablerowend();

								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('rounddepreciationstartmonth', (set_value('rounddepreciationstartmonth')!=''? set_value('rounddepreciationstartmonth') : $details->rounddepreciationstartmonth), 'fixedassets_preferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('rounddepreciationstartyear', (set_value('rounddepreciationstartyear')!=''? set_value('rounddepreciationstartyear') : $details->rounddepreciationstartyear), 'fixedassets_preferences'), 'class="inputcell"');		
								$layout .= tablerowend();


								$layout .= tablerowstart();
									$layout .= tablerowcell($this->formfieldinput->generateFieldInput('realtimedepreciation', (set_value('realtimedepreciation')!=''? set_value('realtimedepreciation') : $details->realtimedepreciation), 'fixedassets_preferences'), 'class="inputcell"');
									$layout .= tablerowcell($this->formfieldinput->generateSingleSelect('salvalueresolve', set_value('salvalueresolve', $details->salvalueresolve), 'fixedassets_preferences'), 'class="inputcell"');											
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
