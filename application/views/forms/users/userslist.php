<?php
$layout = mdldivstrt('row paddless');
	$layout .= mdldivstrt('col s12 data-card step-up-max');
						$layout .= mdldivstrt('cardheader primarydark fullheader');
								$layout .= headerTxt('3',maticon('people', 'spaced-text').' Users', 'class="full-width center-align inverse-text"');
								if (isadmin(FALSE)) {
									 $layout .= anchor('users/Users/addedituser/0', maticon('person_add', 'spaced-text'), 'class="action waves-effect waves-dark accent"');
								}
						$layout .= mdldivend();

						$layout .= mdldivstrt('cardbody white paddless', 'accountsaggregates');
						$layout .= '<script type="text/javascript">
													$(".ugroupschips").material_chip({
														placeholder: "Add to group",
															secondaryPlaceholder: "+Group"
													});
													$(".urolesschips").material_chip({
														placeholder: "Add Role",
															secondaryPlaceholder: "+Role"
													});
													$(function(){
														"use strict";
														var dtfactory = function($, DataTable) {
																$.extend(true, DataTable.defaults, {
																	drawCallback: function(settings){
																		$(".userslistrecord").contexted({
																			title : false,
																			menuoptions : [
																											{
																												text: "Edit",
																												icon: "edit",
																												callback: function(event, contexttype, contextname, contextid){
																													var pageurl = "'.site_url('users/Users/addedituser').'"+"/"+contextid;
																													$.fn.loadpage(pageurl, ".pagebody", true);
																												}
																											},
																											{
																												text: "Delete",
																												icon: "delete",
																												colorclass: "red-text",
																												callback: function(event, contexttype, contextname, contextid){
																													var pageurl = "'.site_url('users/Users/deleteuser').'"+"/"+contextid;
																													$.fn.loadpage(pageurl, ".pagebody", true);
																												}
																											}
																										]
																		});
																								 
																	}

																});
															};

																//simply initialise as normal, stopping multiple evaluation
																dtfactory($, $.fn.dataTable);
															});
														


												</script>';

							$layout .= datatable_open("highlight", "userslist");
						$layout .= tableheadstart();//table header columns
								$layout .= headerrowstart();
									$layout .= tablerowcell('Username');
									$layout .= tablerowcell('Email');
									$layout .= tablerowcell('Name');
									$layout .= tablerowcell('User\'s Groups');
									$layout .= tablerowcell('Roles');
									$layout .= tablerowcell('Status');
								$layout .= headerrowend();
						$layout .= tableheadend();//head end

						$layout .= tablebodystart();//body start
							
							foreach ($users as $user) {
								$rolechipslayout = '';
								$grpschipslayout = '';
								$statuslayout = '';
								if (!isdebugger(FALSE) && isdebugger(FALSE, $user->id)) {
									continue;
								}
								if (isdebugger(FALSE, $user->id)) {
									$rolechipslayout .= mdlsmalldiv(maticon('developer_mode', 'spaced-text').' Debugger '.maticon('close', 'close'), 'class="chip" groupid="'.$user->id.'"');
								}
								if (isadmin(FALSE, $user->id)) {
									$rolechipslayout .= mdlsmalldiv(maticon('developer_mode', 'spaced-text').' Admin '.maticon('close', 'close'), 'class="chip" groupid="'.$user->id.'"');
								}
								if (ismaker($user->id)) {
									$rolechipslayout .= mdlsmalldiv(maticon('thumb_up', 'grey-text spaced-text').' Marker '.maticon('close', 'close'), 'class="chip" groupid="'.$user->id.'"');
								}
								if (ischecker($user->id)) {
									$rolechipslayout .= mdlsmalldiv(maticon('thumbs_up_down', 'grey-text spaced-text').' Checker '.maticon('close', 'close'), 'class="chip" groupid="'.$user->id.'"');
									
								}
								if (isadmin(FALSE) && USERID != $user->id) {
									$statuslayout .= ($user->active) ? anchor("Auth/deactivate/".$user->id, maticon('power_settings_new', 'spaced-text red-text'), 'class="waves-effect waves-teal avatar-char red-text"').' Active' : anchor("Auth/activate/". $user->id, maticon('power_settings_new', 'spaced-text green-text'), 'class="waves-effect waves-teal avatar-char green-text"').' Inactive';
								}
								else{
									$statuslayout .= ($user->active) ? '<a class="waves-effect waves-teal avatar-char grey-text" href="#">'.maticon('power_settings_new', 'spaced-text').'</a> Active' : '<a class="waves-effect waves-teal avatar-char grey-text" href="#">'.maticon('power_settings_new', 'spaced-text').'</a> Inactive';
								}

								$layout .= tablerowstart('class="userslistrecord" id="userslistrecord'.$user->id.'" contexttype="userslistrecord" contextdataid="'.$user->id.'"');
									$layout .= tablerowcell($user->username);
									$layout .= tablerowcell(emaillink($user->email, $user->email));
									$layout .= tablerowcell($user->last_name.' '.$user->first_name);
									$layout .= tablerowcell(mdlsmalldiv($grpschipslayout, 'class="chips chips-initial chips-placeholder ugroupschips" id="ugroupschips-'.$user->id.'"'));
									$layout .= tablerowcell(mdlsmalldiv($rolechipslayout, 'class="chips chips-initial chips-placeholder ugroupschips" id="ugroupschips-'.$user->id.'"'));
									$layout .= tablerowcell($statuslayout);
									$layout .= tablerowend();
							}	        				
							$layout .= tablebodyend();//body End
						$layout .= datatable_close();//data table end

						$layout .= mdldivend();
		$layout .= mdldivend();
$layout .= mdldivend();




echo $layout;










?>
