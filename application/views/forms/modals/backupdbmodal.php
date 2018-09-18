<?php	

	$modalvars = array();
	$modalvars['id'] = 'dbbackupmodal';
	$modalvars['title'] = maticon('cloud_queue', 'spaced-text').' Database Backup';
	$modalvars['contentclass'] = '';

	$modalcontent = form_open('utilities/Database/backupdb');
		$modalcontent .= '<div class="row">
							<div class="col s12" id="backup-db-notifacation">
								'.headertxt('5', ' Select backup file type', 'class="grey-text full-width center-align"').'
							</div>
						</div>
						<div class="row full-width">
							<div class="col s4 center-align">'.materializeradio('txt', ' .txt', 'filetype', 'txt', '', true).'</div>
							<div class="col s4 center-align">'.materializeradio('zip', ' .zip', 'filetype', 'zip', '', false).'</div>
							<div class="col s4 center-align">'.materializeradio('gzip', ' gzip', 'filetype', 'gzip', '', false).'</div>
						</div>
						<div class="row full-width">
							<div class="col s12 center-align">'.materializeinputtxt(date('d.m.Y H:i'), 'filename', 'File Name', false, 'half-width', 'bckpfilename').'</div>
						</div>

						<div class="row full-width">
							<div class="col s12">
								'.mdlsubmitbtn('cloud_done', 'Backup', 'backup-db-btn', 'waves-effect waves-dark').'
							</div>
						</div>';


	$modalcontent .= form_close();

	$modalvars['content'] = $modalcontent;

	echo mdmodal($modalvars);




?>