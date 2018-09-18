<?php
echo mdldivstrt('row paddless');
	echo mdldivstrt('col s12 data-card step-up-max');
		echo mdldivstrt('cardheader fullheader primarydark');
			echo headerTxt(2, maticon('dashboard', 'spaced-text').' Utilities', 'class="full-width center-align inverse-text"');
		echo mdldivend();
		echo mdldivstrt('cardbody white dash-window mdscrollbar');
			echo mdldivstrt('row padded');
				echo anchor(ASSISTANT_PREFIX.'content/Filemanager', maticon('folder', 'xl-text onviewanimated').' </br> File Manager', 'class="col l6 s6 amber-text text-accent-4  padded center-align transition-a-2ms"');
				echo anchor(ASSISTANT_PREFIX.'content/Recyclebin', maticon('delete', 'xl-text onviewanimated').' </br> Recycle bin', 'class="col l6 s6  red-text  padded center-align transition-a-2ms"');
			echo mdldivend();

			echo mdldivstrt('row padded');				
				echo anchor(ASSISTANT_PREFIX.'content/Tasks', maticon('assignment', 'xl-text onviewanimated').' </br> Tasks', 'class="col l6 s6 deep-purple-text text-darken-4 padded center-align transition-a-2ms"');
				echo anchor(ASSISTANT_PREFIX.'content/Todos', maticon('event', 'xl-text onviewanimated').' </br> To dos', 'class="col l6 s6 light-blue-text  padded center-align transition-a-2ms"');
			echo mdldivend();

			echo mdldivstrt('row padded');
				echo anchor(ASSISTANT_PREFIX.'content/Reminders', maticon('alarm', 'xl-text onviewanimated').' </br> Reminders', 'class="col l6 s6 indigo-text  padded center-align transition-a-2ms"');
				echo anchor(ASSISTANT_PREFIX.'content/Spinner', maticon('chrome_reader_mode', 'xl-text onviewanimated').' </br> Article Spinner', 'class="col l6 s6 blue-grey-text padded center-align transition-a-2ms"');			
			echo mdldivend();
		echo mdldivend();
	echo mdldivend();

echo mdldivend();

