<?php

	$modalvars = array();
	$modalvars['id'] = 'checkoutModal';
	$modalvars['title'] = maticon('swap_horiz', 'spaced-text').' Checkout';
	$modalvars['contentclass'] = '';




	$modalcontent = '';

	if (haspriveledge('checkout', 'fixedassets')) {
		$modalcontent .= form_open(FIXEDASSETS_PREFIX.'forms/Formhandler/checkout/', 'id="checkoutform"');
			$modalcontent .= mdldivstrt('row');
				$modalcontent .= mdldivstrt('col s12');
					$modalcontent .= headerTxt(2, 'Checkout ', 'id="checkoutmodalTitle" class="grey-text full-width center-align"');
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s6');
					$modalcontent .= $this->formfieldinput->generateFieldInput("dtecheckedOut", date('Y-m-d'));
				$modalcontent .= mdldivend();

				$modalcontent .= mdldivstrt('col s6');
					$modalcontent .= $this->formfieldinput->generateFieldInput("dueDteCheckout", date('Y-m-d'));
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12 padded');
					$modalcontent .= $this->formfieldinput->generateSingleSelect("checkedOutTo", '');
				$modalcontent .= mdldivend();


				$modalcontent .= mdldivstrt('col s12 padded');
					$modalcontent .= mdlsubmitbtn('arrow_upward', 'Checkout', 'checkoutsubmit');
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
