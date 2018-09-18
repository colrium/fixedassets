<?php
$spinnedtext = '';
if (isset($spuntext)) {
	$spinnedtext = $spuntext;
}
echo mdldivstrt('row paddless');
	echo form_open(ASSISTANT_PREFIX.'content/Spinner/spinner', 'class="col s12 data-card step-up-max"');
		echo mdldivstrt('cardheader fullheader primarydark');
			echo headerTxt(2, maticon('autorenew', 'spaced-text').' Spinner', 'class="full-width center-align inverse-text"');
			echo button('class="action large waves-effect waves-dark accent inverse-text" type="submit"', maticon('autorenew', 'spaced-text'));
		echo mdldivend();
		echo mdldivstrt('cardbody white dash-window mdscrollbar');
				echo mdldivstrt('col s12 padded');
					echo '<textarea name="spintext" class="spinnertext full-width" id="spinnertext">'.$spinnedtext.'</textarea>';
				echo mdldivend();

				echo mdldivstrt('col s12 padded');
					echo materializechkbox('1', 'Word options', 'wordoptions', 'wordoptions');
				echo mdldivend();


				if (isset($spuntext)) {
					echo mdldivstrt('col s12 padded');
						echo headerTxt('3', 'Spun Text');
						echo paragraph($spuntext);
					echo mdldivend();
				}

				if (isset($originaltext)) {
					echo mdldivstrt('col s12 padded');
						echo headerTxt('3', 'Original Text', 'class="grey-text"');
						echo paragraph($originaltext, 'class="grey-text"');
					echo mdldivend();
				}

		echo mdldivend();
	echo form_close();

echo mdldivend();