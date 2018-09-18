<?php
	$modalvars = array();
	$modalvars['id'] = 'checkinModal';
	$modalvars['title'] = maticon('swap_horiz', 'spaced-text').' Checkin';
	$modalvars['contentclass'] = '';




	$modalcontent = '';

	if (haspriveledge('checkin', 'fixedassets')) {
		$modalcontent .= form_open(FIXEDASSETS_PREFIX.'forms/Formhandler/checkin/', 'id="checkinform"');
			$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= headerTxt(2, 'Checkin ', 'id="checkinmodalTitle" class="inverse-text full-width center-align"');
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= $this->formfieldinput->generateFieldInput("dteCheckedin", date('Y-m-d'));
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12 padded');
					$modalcontent .= mdlsubmitbtn('arrow_downward', 'Checkin', 'checkinsubmit');
				$modalcontent .= mdldivend();

			$modalcontent .= mdldivend();
		$modalcontent .= form_close();
	}
	else{
		$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= headerTxt(3, 'Sorry you dont have access priveledges to this function', ' class="red-text full-width center-align"');
				$modalcontent .= mdldivend();
		$modalcontent .= mdldivend();
	}



	$modalvars['content'] = $modalcontent;

	echo mdmodal($modalvars);
