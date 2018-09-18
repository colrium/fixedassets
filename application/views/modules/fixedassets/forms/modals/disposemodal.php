<?php	

	$modalvars = array();
	$modalvars['id'] = 'disposalModal';
	$modalvars['title'] = maticon('cloud_queue', 'spaced-text').' Dispose';
	$modalvars['contentclass'] = '';

	$modalcontent = '';

	if (haspriveledge('dispose', 'fixedassets')) {
		$modalcontent .= form_open(FIXEDASSETS_PREFIX.'forms/Formhandler/dispose/', 'id="disposeform"');
			$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= headerTxt(3, 'Dispose ', 'id="disposalmodalTitle" class="grey-text full-width center-align"');
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= $this->formfieldinput->generateFieldInput("dteDisposed", date('Y-m-d'));
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= $this->formfieldinput->generateSingleSelect("disposalMethod");
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= $this->formfieldinput->generateFieldInput("disposeReason");
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= mdlsubmitbtn('event_busy', 'Dispose', 'disposesubmit');
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




?>





