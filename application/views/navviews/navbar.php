<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/


echo '<header class="mainheader inverse-text">';
 
 
 if (isloggedin(FALSE)) {
		$notifacations = array();
		$userhasimage = dbhasmainimage('users', USERID);
		
		echo '<div> <a class="avatar-char waves-effect waves-dark drawer-toggle actionloader" href="#">'.maticon('menu', 'spaced-text').'</a></div>';
		echo '<div class="hide-on-small-only">';
			echo mdldivstrt('searchbar inverse-text');
						echo '<button class="btn-closesearch"></button>'; 
						echo '<input type="search" placeholder="Search">';
						echo '<button class="btn-search"></button>';
			echo mdldivend();
		echo '</div>';




		echo mdldivstrt();
					
					if ($userhasimage) {
						echo '<img class="avatar-img dropdown-button right" src="'.site_url('files/Files/outputmainimage/users/'.USERID).'" data-activates="useractiondrpdwn"/>';                         
					}
					else{
						echo '<a class="avatar-char dropdown-button right" href="#" data-activates="useractiondrpdwn">'.maticon('person', 'spaced-text').'</a>';
					}


					echo mdldivstrt('dropdown-content', 'useractiondrpdwn'); 
							echo mdldivstrt('row padded-x1'); 
								echo mdldivstrt('col s12 center-align');
									if ($userhasimage) {
										echo '<img class="responsive-img medium circle" src="'.site_url('files/Files/outputmainimage/users/'.USERID).'" />';   
									}
									else{
										echo headerTxt(1, maticon('person', 'spaced-text'), 'class="full-width center-align primary-text"');
									}
								echo mdldivend();
									echo mdldivstrt('col s12'); 
										echo headerTxt(4, humanize(USERLNAME).' '.humanize(USERFNAME), 'class="full-width center-align"');
									echo mdldivend();
							echo mdldivend();

							echo mdldivstrt('row padded');
								echo mdldivstrt('col s3 center-align');
									echo anchor('users/User/profile', maticon('assignment_ind','spaced-text'), 'class="green-text avatar-char waves-effect waves-dark"');
								echo mdldivend();
								echo mdldivstrt('col s3 center-align');
									echo anchor('users/User/changepassword', maticon('vpn_key','spaced-text'), 'class="blue-text avatar-char waves-effect waves-dark"');
								echo mdldivend();
								echo mdldivstrt('col s3 center-align');
									echo anchor('Login/lock', maticon('lock_outline','spaced-text'), 'class="orange-text avatar-char waves-effect waves-dark ref-link"');
								echo mdldivend();
								echo mdldivstrt('col s3 center-align');
									echo anchor('Login/logout', maticon('exit_to_app','spaced-text'), 'class="red-text avatar-char waves-effect waves-dark ref-link"');
								echo mdldivend();
								 
							echo mdldivend();
					echo mdldivend();
				 
					 echo anchor('api/Api/getnotifacations', maticon('notifications', 'spaced-text'), 'class="avatar-char badged accent-badge right dropdown-button notifacation-btn ajaxed waves-effect waves-dark" data-activates="nbnotifacationsdropdwn" id="notifacations-badge" datadom="#notifacations-badge"');

					 echo mdldivstrt('dropdown-content', 'nbnotifacationsdropdwn'); 
							echo mdldivstrt('row padded');
								echo mdldivstrt('col s3'); 
									echo anchor(ASSISTANT_PREFIX.'notifacations/Notifacations/api/Api/togglenotifacations/off', maticon('notifications','spaced-text'), 'class="accent-text avatar-char waves-effect waves-dark"');
								echo mdldivend();
								echo mdldivstrt('col s6'); 
									echo anchor('User/preferences', 'Mark all as read', 'class="btn-flat waves-effect waves-dark"');
								echo mdldivend();
								echo mdldivstrt('col s3 center-align'); 
									echo anchor('User/preferences', maticon('settings','spaced-text'), 'class="primary-text avatar-char waves-effect waves-dark"');
								echo mdldivend();
							echo mdldivend();

							echo mdldivstrt('row');
								echo mdldivstrt('collection borderless', 'nbnotsdropdwncont');


								echo mdldivend();
							echo mdldivend();


							echo mdldivstrt('row');
								echo mdldivstrt('col s12 center-align'); 
									echo anchor(ASSISTANT_PREFIX.'notifacations/Notifacations/', 'View All', 'class="waves-effect waves-dark teal-text"');
								echo mdldivend();
							echo mdldivend();                    
					echo mdldivend();
					
					

		echo mdldivend();	
 }
 else{
	echo '<div><a class="btn-circle waves-effect waves-dark actionloader" href="#">'.maticon('lock', 'spaced-text').' </a></div>';
 }
 echo '</header>';
 ?>
 