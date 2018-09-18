<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$layout = mdldivstrt('row white padded rounded-5px');
	$layout .= mdldivstrt('col s12');
		$layout .= mdldivstrt('row');
			$layout .= mdldivstrt('col s12');
				$layout .= headertxt('2', maticon('settings', 'spaced-text').' Field Preferences', 'class="full-width center-align "');
			$layout .= mdldivend();	
		$layout .= mdldivend();

		$layout .= horizontaldivider();

		$layout .= mdldivstrt('row');
			$layout .= mdldivstrt('col s12');
				$layout .= form_open(FIXEDASSETS_PREFIX.'preferences/Preferences/inputpreferences');
					$layout .= mdldivstrt('row');
						

						$layout .= mdldivstrt('row');

							$layout .= materializetablestart('', set_value('developer_board').' System Input Fields');
								$layout .= tableheadstart();
									$layout .= tablerowstart();
										$layout .= tablerowcell('Field Name', 'class="inputcell"');
										$layout .= tablerowcell('Visible on Dashboard', 'class="inputcell"');
										$layout .= tablerowcell('Unique Data', 'class="inputcell"');
										$layout .= tablerowcell('Disabled On Form', 'class="inputcell"');
										$layout .= tablerowcell('MakerCheckered', 'class="inputcell"');	
									$layout .= tablerowend();
								$layout .= tableheadend();

								$layout .= tablebodystart();
									foreach ($fields as $field) {
										$layout .= tablerowstart();
											$layout .= tablerowcell(materializeinputtxt($field->setName, 'setName['.$field->fieldId.']', 'Field Name', false, '', 'field'.$field->fieldId), 'class="inputcell"');
											$layout .= tablerowcell(materializeswitch('1', 'Not visible',  'Visible', 'isDashShown['.$field->fieldId.']', 'dash'.$field->fieldId, ($field->isDashShown == '1' ? true : false)), 'class="inputcell"');
											$layout .= tablerowcell(materializechkbox('1', 'Unique', 'isUnique['.$field->fieldId.']', 'unique'.$field->fieldId, '', ($field->isUnique == '1' ? true : false)), 'class="inputcell"');
											$layout .= tablerowcell(materializechkbox('1', 'Disabled', 'isDis['.$field->fieldId.']', 'dis'.$field->fieldId, '', ($field->isDis == '1' ? true : false)), 'class="inputcell"');
											$layout .= tablerowcell(materializechkbox('1', 'MakerCheckered', 'makercheckered['.$field->fieldId.']', 'makercheckered'.$field->fieldId, '', ($field->makercheckered == '1' ? true : false)), 'class="inputcell"');
										$layout .= tablerowend();
									}
								$layout .= tablebodyend();

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
