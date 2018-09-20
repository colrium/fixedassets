<?php

$config['version'] = 3.0;
$config['version_name'] = 'TSC';

$config['auto_update'] = FALSE;
$config['update_url'] = FALSE;
$config['updates_dir'] = 'catalog/updates';
$config['last_update_date'] = FALSE;


$config['GoogleMapsEmbedAPI'] = 'AIzaSyDZKILzcc6wGhjImYky1xpb5Wx8r5Q700s';
$config['defaultmaplocation'] = array('latitude' => '1.2921° S', 'longitude' => '36.8219° E');


$config['fortmodules'] = array(
								'fixedassets' => 'Fixed Assets',
								'assistant' => 'Assistant'
							);
$config['fortmodulesicons'] = array(
									'fixedassets' => 'weekend',
									'assistant' => 'headset_mic'
								);
$config['modulesanchorprefixes'] = array(
										'fixedassets' => 'modules/fixedassets/',
										'assistant' => 'modules/assistant/'
									);



$config['modulescolorclasses'] = array(
										'fixedassets' => 'brown',
										'assistant' => 'grey darken-1'
									);
$config['defaultmodule'] = '';





$config['modulespreferences'] = array(
										'system' => 		array(
																'name'=> 'Fort Technologies', 
																'address'=> '001 Nairobi', 
																'defaultemail'=> 'info@forttec.co.ke', 
																'defaultphone'=> '', 
																'locale'=> 116, 
																'dateformat'=> 1,
																'mailtype'=> 'html',
																'smtphost'=> 'mail.google.com',
																'smtphostport'=> 465, 
																'smtpmailaddress'=> 'noreply@gmail.com',
																'smtpmailaddresspassword'=> 'noreply123', 
																'autoupdate'=> 0,
																'autoupdateurl'=> 'http://update.forttech.co.ke',
																'autoupdatefrequency'=> 'weekly',
																'lightrendercontent'=> 1, 
																'markercheckervalidation'=> 1, 
																'suspendedaccess'=> 0,
																'lanipvalidation'=> 0, 
																'wanipvalidation'=> 0, 
																'wanipwhitelist'=> '',																
																'passwordpolicy'=> 1,
																'passwordspecialchars'=> 1,
																'passwordspecialcharsnum'=> 1, 
																'minpasswordlength'=> 8,
																'limitloginattempts'=> 0, 
																'maxloginattempts'=>3,
																'passwordlife'=> 30
															),
										'fixedassets' => 	array(
																'currency'=> 116, 
																'dateformat'=> 1, 
																'depreciation'=> 1,
																'roundoffdepreciationstartmonth'=> 0, 
																'roundoffdepreciationstartyear'=> 0,
																'realtimedepreciation'=> 1, 
																'fiscalyearstartmonth'=> 12, 
																'fiscalyearstartmonthdate'=> 31, 
																'salvagevalueconflictresolvemethod'=> 1
															), 
										'communication' => 	array(
																'maxmailboxesperrecord'=> -1, 
																'downloadmailattachments'=> 0
															),
										'ngo' => array(),
										'chama' => array(),  
										'insurance' => array(), 
										'tracker' => array(),
										'library' => array(), 
										'invoicing' => array(), 
										'events' => array(), 
										'assistant' => array()
									);









