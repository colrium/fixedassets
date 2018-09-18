<?php
	$layout = mdldivstrt('row margin-top-x2');
		$layout .= mdldivstrt('col l6 offset-l3 m6 offset-m3 s12 white rounded-5px half-screen-height valign-wrapper');
			$layout .= mdldivstrt('white padded-x2 valign center-align full-width');
				$layout .= mdldivstrt('col s12');
					$layout .= maticon('email', 'medium grey-text').'</br>';
				$layout .= mdldivend();

				$layout .= form_open('Login/forgotpassword');
					$layout .= headertxt('3', 'Enter your email address below', 'class="grey-text"');
					$layout .= paragraph('A temporary reset password code will be sent to your email.', 'class="grey-text full-width center-align"');
					$layout .= mdldivstrt('row margin-top-x2');
						$layout .= mdldivstrt('col s12');
							$layout .= mdlinputtxt('', 'useremail', maticon('contact_mail', 'spaced-text').' Email Address').'</br>';
						$layout .= mdldivend();

						$layout .= mdldivstrt('col s12');
							$layout .= mdlsubmitbtn('send', 'Proceed', 'sendforgot');
						$layout .= mdldivend();




					$layout .= mdldivend();


				$layout .= form_close();
			$layout .= mdldivend();
		$layout .= mdldivend();
	$layout .= mdldivend();

echo $layout;