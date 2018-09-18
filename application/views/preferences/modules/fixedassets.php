<?php
$countries = dbtablerecords('countries', array(), FALSE);
$dateformats = dbtablerecords('dateformats', array(), FALSE);
echo mdldivstrt('row');
	echo mdldivstrt('col l3 m4 s12');
		echo mdlulstart('class="tabs transparent vertical" id="pref_tabs"');
			echo mdlli('<a href="#formgeneraltab" class="waves-effect waves-light active">'.maticon('star', 'spaced-text').' General</a>', 'class="tab"');
		echo mdlulend();

	echo mdldivend();

	echo mdldivstrt('col l9 m8 s12', 'formgeneraltab');
		echo mdldivstrt('col s12 padded');
			$curencyarr = array();
			foreach ($countries as $country) {
				$curencyarr[$country->id] = $country->currency_symbol;
			}
			echo materializeiconselect('currency', $curencyarr, $preferences->currency, 'Currency', 'label', 'currency', FALSE);;
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			$dateformatsoptions=array();
			foreach ($dateformats as $dateformat) {
				$dateformatsoptions[$dateformat->id] = $dateformat->name;
			}
			echo materializeiconselect('dateformat', $dateformatsoptions, $preferences->dateformat, 'Default Date format', 'event', 'dateformat', FALSE);;
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Round Depreciation Start Month', 'roundoffdepreciationstartmonth', 'roundoffdepreciationstartmonth', '', $preferences->roundoffdepreciationstartmonth, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Round Depreciation Start Year', 'roundoffdepreciationstartyear', 'roundoffdepreciationstartyear', '', $preferences->roundoffdepreciationstartyear, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Realtime Depreciation', 'realtimedepreciation', 'realtimedepreciation', '', $preferences->realtimedepreciation, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconnum($preferences->fiscalyearstartmonth, 'fiscalyearstartmonth', 'Fiscal Year Start Month', 'looks_3', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconnum($preferences->fiscalyearstartmonthdate, 'fiscalyearstartmonthdate', 'Fiscal Year Start Month Date', 'looks_3', false, '', '', FALSE);
		echo  mdldivend();

		
	echo  mdldivend();


echo  mdldivend();
