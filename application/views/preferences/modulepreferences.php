<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2018  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

$datapresentationoptions=array('datatables'=>'Datatables', 'infographics'=>'Infographics');
$dateformatsoptions=array();
$dateformats = dbtablerecords('dateformats', array(), FALSE);
foreach ($dateformats as $dateformat) {
	$dateformatsoptions[$dateformat->id] = $dateformat->name;
}


echo mdldivstrt('row');
	echo mdldivstrt('col s12 paddless rounded-5px data-card step-up-max');
		echo mdldivstrt('cardheader primarydark fullheader');
			echo headerTxt(2, maticon('settings', 'spaced-text').' '.$modulename, 'class="inverse-text"');
		echo mdldivend();

		echo mdldivstrt('cardbody white dash-window');
			echo form_open('preferences/System/preferences/'.$module);
				echo mdldivstrt('row');
					//load view
					$this->load->view('preferences/preferencesviews/'.$module);
				echo mdldivend();

				echo mdldivstrt('row');
					echo mdldivstrt('col s12');
						echo mdlsubmitbtn('save', 'Save Preferences');
					echo mdldivend();
				echo mdldivend();
			echo form_close();
		echo mdldivend();
	echo mdldivend();
echo mdldivend();	


