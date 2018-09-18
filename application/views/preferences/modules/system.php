<?php
$countries = dbtablerecords('countries', array(), FALSE);
$dateformats = dbtablerecords('dateformats', array(), FALSE);
echo mdldivstrt('row');
	echo mdldivstrt('col l3 m4 s12');
		echo mdlulstart('class="tabs transparent vertical" id="pref_tabs"');
			echo mdlli('<a href="#formgeneraltab" class="waves-effect waves-light active">'.maticon('star', 'spaced-text').' General</a>', 'class="tab"');
			echo mdlli('<a href="#formmailtab" class="waves-effect waves-light">'.maticon('mail', 'spaced-text').' Mail</a>', 'class="tab"');
			echo mdlli('<a href="#formsecuritytab" class="waves-effect waves-light">'.maticon('verified_user', 'spaced-text').' Security</a>', 'class="tab"');
			echo mdlli('<a href="#formupdatetab" class="waves-effect waves-light">'.maticon('cloud_download', 'spaced-text').' Updates</a>', 'class="tab"');

		echo mdlulend();

	echo mdldivend();

	echo mdldivstrt('col l9 m8 s12', 'formgeneraltab');
		echo  mdldivstrt('col s12 center-align padded');		
			echo  imageuploader('systemlogo', 'systemlogo', 'systemlogo', '1');
		echo  mdldivend();
		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->name, 'name', 'Name', 'edit', false, '', '', TRUE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeicontextarea($preferences->address, 'address', 'address');
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->defaultemail, 'defaultemail', 'Email', 'mail', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->defaultphone, 'defaultphone', 'Phone', 'phone', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			$localesarr = array();
			foreach ($countries as $country) {
				$localesarr[$country->id] = $country->name;
			}
			echo materializeiconselect('locale', $localesarr, $preferences->locale, 'Country', 'map', 'locale', FALSE);;
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			$dateformatsoptions=array();
			foreach ($dateformats as $dateformat) {
				$dateformatsoptions[$dateformat->id] = $dateformat->name;
			}
			echo materializeiconselect('dateformat', $dateformatsoptions, $preferences->dateformat, 'Default Date format', 'event', 'dateformat', FALSE);;
		echo  mdldivend();
	echo  mdldivend();



	echo mdldivstrt('col l9 m8 s12', 'formmailtab');
		echo mdldivstrt('col s12 padded');
			$mailtypeoptions=array('plaintext'=>'Plain Text', 'html'=>'HTML');			
			echo materializeiconselect('mailtype', $mailtypeoptions, $preferences->mailtype, 'Default Mail Type', 'label', 'mailtype', FALSE);;
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->smtphost, 'smtphost', 'SMTP Host', 'label', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconnum($preferences->smtphostport, 'smtphostport', 'SMTP Port', 'looks_3', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->smtpmailaddress, 'smtpmailaddress', 'Email Address', 'label', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconpass($preferences->smtpmailaddresspassword, 'smtpmailaddresspassword', 'Email Address Password');
		echo  mdldivend();
	echo  mdldivend();



	echo mdldivstrt('col l9 m8 s12', 'formsecuritytab');
		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Marker Checker Validation', 'markercheckervalidation', 'markercheckervalidation', '', $preferences->markercheckervalidation, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Suspend Access', 'suspendedaccess', 'suspendedaccess', '', $preferences->suspendedaccess, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'LAN IP Validation', 'lanipvalidation', 'lanipvalidation', '', $preferences->lanipvalidation, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'WAN IP Validation', 'wanipvalidation', 'wanipvalidation', '', $preferences->wanipvalidation, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->wanipwhitelist, 'wanipwhitelist', 'WAN IP Whitelist', 'label', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Enforce Password policy', 'passwordpolicy', 'passwordpolicy', '', $preferences->passwordpolicy, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Password Special Characters', 'passwordspecialchars', 'passwordspecialchars', '', $preferences->passwordspecialchars, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Password Numeric Characters', 'passwordspecialcharsnum', 'passwordspecialcharsnum', '', $preferences->passwordspecialcharsnum, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconnum($preferences->minpasswordlength, 'minpasswordlength', 'Minimum Password Length', 'looks_3', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Limit Login Attempts', 'limitloginattempts', 'limitloginattempts', '', $preferences->limitloginattempts, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconnum($preferences->maxloginattempts, 'maxloginattempts', 'Max Login Attempts', 'looks_3', false, '', '', FALSE);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputiconnum($preferences->passwordlife, 'passwordlife', 'Password Life (Days)', 'looks_3', false, '', '', FALSE);
		echo  mdldivend();
	echo  mdldivend();


	echo mdldivstrt('col l9 m8 s12', 'formupdatetab');
		echo mdldivstrt('col s12 padded');
			echo materializechkbox('1', 'Auto Update', 'autoupdate', 'autoupdate', '', $preferences->autoupdate, false);
		echo  mdldivend();

		echo mdldivstrt('col s12 padded');
			echo materializeinputicontxt($preferences->autoupdateurl, 'autoupdateurl', 'Update URL', 'label', false, '', '', FALSE);
		echo  mdldivend();
	echo  mdldivend();
echo  mdldivend();
