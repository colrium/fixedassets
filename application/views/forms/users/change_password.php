<?php
	$layout = mdldivstrt('row margin-top-x2');
			$layout .= mdldivstrt('col s12 white rounded-5px half-screen-height valign-wrapper');
				$layout .= mdldivstrt('col l6 offset-l3 m6 offset-m3 s12 white padded-x2 valign center-align full-width');
					$layout .= mdldivstrt('col s12');
						$layout .= maticon('vpn_key', 'medium grey-text').'</br>';
					$layout .= mdldivend();

					$layout .= form_open('users/Users/changepassword');
						$layout .= headertxt('3', 'Change your password below', 'class="grey-text"');
						$layout .= paragraph('All fields are required', 'class="grey-text full-width center-align"');
						$layout .= mdldivstrt('row margin-top-x2');
							$layout .= mdldivstrt('col s12');
								$layout .= mdlinputpass('', 'oldpassword', maticon('vpn_key', 'spaced-text').' Current Password').'</br>';
								$layout .= mdlinputpass('', 'newpassword', maticon('vpn_key', 'spaced-text').' New Password (At least '.$min_password_length.' characters long)').'</br>';
								$layout .= mdlinputpass('', 'repeatnewpassword', maticon('vpn_key', 'spaced-text').' Repeat New Password').'</br>';
							$layout .= mdldivend();

							$layout .= mdldivstrt('col s12 margin-top-x2');
								$layout .= mdlsubmitbtn('vpn_key', 'Change Password', 'sendforgot');
							$layout .= mdldivend();




						$layout .= mdldivend();


					$layout .= form_close();
				$layout .= mdldivend();
			$layout .= mdldivend();
	$layout .= mdldivend();

echo $layout;