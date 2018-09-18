<?php

echo mdldivstrt('row');
	echo  form_open('preferences/System/preferences/'.$module, 'class="col s12 rounded-5px data-card step-up-max"');
		echo mdldivstrt('cardheader fullheader primarydark');
			echo headerTxt(2, maticon('settings', 'spaced-text').' '.$modulename.' Preferences', 'class="full-width center-align inverse-text"');
			echo button('class="action large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
		echo  mdldivend();
		echo mdldivstrt('cardbody white dash-window');
			$this->load->view('preferences/modules/'.$module);
		echo mdldivend();	

			
	echo  form_close();
echo  mdldivend();





?>