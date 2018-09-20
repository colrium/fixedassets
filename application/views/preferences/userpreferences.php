<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2018  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

$datapresentationoptions=array('datatables'=>'Datatables', 'infographics'=>'Infographics');
$dateformatsoptions=array();
$dateformats = dbtablerecords('dateformats', array(), FALSE);
foreach ($dateformats as $dateformat) {
	$dateformatsoptions[$dateformat->id] = $dateformat->name;
}


echo mdldivstrt('row');
	echo form_open('preferences/User/preferences/'.$module, 'class="col s12 paddless rounded-5px data-card step-up-max"');
		echo mdldivstrt('cardheader primarydark fullheader');
			echo headerTxt(2, $preferencesname, 'class="inverse-text"');
			echo button('class="action large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
		echo mdldivend();

		echo mdldivstrt('cardbody white dash-window');
			
				echo mdldivstrt('row');
					echo mdldivstrt('col s12');
						echo mdldivstrt('col s12 padded');
							echo headerTxt(3, maticon('alarm', 'spaced-text').' Notifacations', 'class="grey-text"');
							echo horizontaldivider();
						echo mdldivend();


						echo mdldivstrt('col l6 m12 s12 padded');
							echo materializeswitch('1', '', 'Desktop Alerts', 'desktopalerts', 'desktopalertschkbx', ($preferences->desktopalerts==0? (set_checkbox('desktopalerts')=='checked'? true : false) : true));
						echo mdldivend();

						echo mdldivstrt('col l6 m12 s12 padded');
							echo materializeswitch('1', '', 'Email Alerts', 'emailalerts', 'emailalertschkbx', ($preferences->emailalerts==0? (set_checkbox('emailalerts')=='checked'? true : false) : true));
						echo mdldivend();

						echo mdldivstrt('col l6 m12 s12 padded');
							echo materializeinputicondecimal(set_value('dayspredatealert', $preferences->dayspredatealert), 'dayspredatealert', 'No. of Pre-Alert Days', 'update');
						echo mdldivend();

						echo mdldivstrt('col l6 m12 s12 padded');
							echo materializeinputicondecimal(set_value('dayspostdatealert', $preferences->dayspostdatealert), 'dayspostdatealert', 'No. of Post-Alert Days', 'history');
						echo mdldivend();

						echo mdldivstrt('col s12 padded');
							echo materializeinputicontxt(set_value('alertemailaddress', $preferences->alertemailaddress), 'alertemailaddress', 'Email Alerts Address', 'mail_outline');
						echo mdldivend();
					echo mdldivend();



					echo mdldivstrt('col s12');
						echo mdldivstrt('col s12 padded');
							echo headerTxt(3, maticon('view_quilt', 'spaced-text').' Layout', 'class="grey-text"');
							echo horizontaldivider();
						echo mdldivend();


						echo mdldivstrt('col s12 padded');
							echo chosenselect('dateformat', $dateformatsoptions, $preferences->dateformat, 'Date Format', 'dateformat');
						echo mdldivend();

						echo mdldivstrt('col s12 padded');
							echo chosenselect('datapresentationview', $datapresentationoptions, $preferences->datapresentationview, 'Data Display Mode', 'datapresentationview');
						echo mdldivend();

						if ($module=='fixedassets') {
							$entities = array('none'=>'None');
							$moduleentities = dbmoduletablenames('fixedassets');
							if (is_array($moduleentities)) {
								foreach ($moduleentities as $moduleentitykey=>$moduleentity) {
									$entities[$moduleentitykey] = $moduleentity;
								}
							}
							

							echo mdldivstrt('col s12 padded');							
								echo materializeiconselect('defaultcriteria', $entities, (array_key_exists('defaultcriteria', get_object_vars($preferences))?$preferences->defaultcriteria : 'none'), 'Default Load Criteria', 'folder_open', 'defaultcriteria', FALSE);
							echo mdldivend();
						}
					echo mdldivend();
				echo mdldivend();
		echo mdldivend();
	echo form_close();


echo mdldivend();	
