<?php

$layout = '';

$layout .= mdldivstrt('row', 'none');
	$layout .= mdldivstrt('col s12', 'backupdatabase');
		$layout .= $this->layoutgen->formStart('functions/Functions/backupdatabase', 'normal');

			$layout .= mdltablestart();

				$layout .= tablerowstart('class="teal white-text"');
						$layout .= mdltablecell(headertxt('2', maticon('archive','normal-text').' Backup Fixed Assets Database', 'class="white-text"'), 'colspan="2" class="mdl-data-table__cell--non-numeric"');	
				$layout .= mdlrowend();


				$layout .= tablerowstart();
					$layout .= mdltablecell(headertxt('5', ' Select backup file type', 'class="grey-text" full-width center-align'), 'colspan="2" class="input-cell"');
				$layout .= tablerowend();



				$layout .= tablerowstart();
					$layout .= mdltablecell(materializeradio('txt', ' .txt', 'filetype', 'txt', '', true), 'class="input-cell"');
					$layout .= mdltablecell('', 'class="input-cell"');
				$layout .= tablerowend();

				$layout .= tablerowstart();
					$layout .= mdltablecell(materializeradio('zip', ' .zip', 'filetype', 'zip', '', false), 'class="input-cell"');
					$layout .= mdltablecell('', 'class="input-cell"');
				$layout .= tablerowend();

				$layout .= tablerowstart();
					$layout .= mdltablecell(materializeradio('gzip', ' gzip', 'filetype', 'gzip', '', false), 'class="input-cell"');
					$layout .= mdltablecell('', 'class="input-cell"');
				$layout .= tablerowend();

				$layout .= tablerowstart();
					$layout .= mdltablecell(mdlinputtxt('', 'filename', 'File Name', false, 'half-width', 'bckpfilename'), 'class="input-cell padded center-align" colspan="2"');
				$layout .= tablerowend();














				$layout .= tablerowstart();
					$layout .= mdltablecell(mdlsubmitbtn('archive', 'Backup'), 'colspan="2" class="input-cell"');
				$layout .= tablerowend();

			$layout .= mdltableend();

		$layout .= $this->layoutgen->formEnd();

	$layout .= mdldivend();

$layout .= mdldivend();

echo $layout;


