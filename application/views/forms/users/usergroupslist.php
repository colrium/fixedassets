<?php
$layout = mdldivstrt('row paddless rounded-5px');
	$layout .= mdldivstrt('col s12 data-card step-up-max');
		$layout .= mdldivstrt('cardheader primarydark fullheader');
			$layout .= headertxt('2', maticon('group', 'spaced-text').' User Groups', 'class="full-width center-align inverse-text"');
			if (isadmin(FALSE)) {
				$layout .= anchor('users/Users/addeditgroup/0', maticon('group_add', 'spaced-text'), 'class="action waves-effect waves-dark accent"');
			}
		$layout .= mdldivend();	

		$layout .= mdldivstrt('cardbody white paddless');
			$layout .= mdldivstrt('col s12');
				$layout .= datatable_open("highlight", "usergroupslist");
					$layout .= tableheadstart();
						$layout .= headerrowstart();
							foreach ($dbfields as $dbfield) {
								$layout .= tablerowcell(humanize($dbfield->initialName));
							}
						$layout .= headerrowend();
					$layout .= tableheadend();


					$layout .= tablebodystart();

						foreach ($usergroups as $usergroup) {
							$layout .= tablerowstart();
								foreach ($dbfields as $dbfield) {
									$initialName = $dbfield->initialName;
									$content = '';
									if ($dbfield->isPK=='1') {									
										if ($usergroup->name == $debbugersgroup || $usergroup->name == $adminsgroup) {
											if (isdebugger(FALSE)) {
												$content = '<a class="btn-icon waves-effect waves-red disabled" href="#">'.maticon('edit', 'spaced-text').'</a> ';
												$content .= '<a class="btn-icon waves-effect waves-red disabled" href="#">'.maticon('delete', 'spaced-text').'</a>';
											}
										}
										else{
											if (isadmin(FALSE)) {
												$content = anchor('users/Users/addeditgroup/'.$usergroup->$initialName, maticon('edit', 'spaced-text'), 'class="waves-effect waves-dark btn-icon"').' ';
												$content .= anchor('users/Users/deletegroup/'.$usergroup->$initialName, maticon('delete', 'spaced-text'), 'class="waves-effect waves-red btn-icon red-text"');
											}
												
										}
									}
									else{
										$content = $usergroup->$initialName;
									}
									$layout .= tablerowcell($content);
									
								}
							$layout .= tablerowend();
						}						
					$layout .= tablebodyend();


				$layout .= datatable_close();
			$layout .= mdldivend();
		$layout .= mdldivend();
	$layout .= mdldivend();

$layout .= mdldivend();

echo $layout;