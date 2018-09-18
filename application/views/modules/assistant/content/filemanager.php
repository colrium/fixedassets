<?php
echo mdldivstrt('row paddless');
	echo mdldivstrt('col l8 m9 s12 white step-up-max dash-window rounded-2px');
			echo mdldivstrt('col s12');
				echo mdlulstart('class="collection full-width no-border"');

					foreach ($records as $record) {
						echo mdllistart('class="collection-item avatar"');
							if ($record->isimage) {
								echo img(site_url('files/Files/outputimage/'.$record->attId), 'class="circle"');
							}
							else{
								echo maticon('insert_drive_file', 'circle grey lighten-3 grey-text text-darken-2');
							}
							echo spanned(str_replace('.'.$record->extension, '', $record->name), 'class="title"');
							echo paragraph($record->file_dir);	
							echo '<a href="#!" class="secondary-content grey-text"><i class="material-icons">more_vert</i></a>';
						echo mdlliend();
					}
				echo mdlulend();
			echo mdldivend();
	echo mdldivend();

	echo mdldivstrt('col l4 m3 s12 data-card step-up-2');
		echo mdldivstrt('cardheader fullheader primary');
			
		echo mdldivend();
		echo mdldivstrt('cardbody dash-window mdscrollbar');
			echo mdldivstrt('row padded');
				


			echo mdldivend();
		echo mdldivend();
	echo mdldivend();
echo mdldivend();

