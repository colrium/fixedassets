<?php
echo mdldivstrt('col s9 rounded-5px data-card step-up-max', 'attachmentstab');
	echo mdldivstrt('cardheader fullheader primarydark');
		echo headertxt('2', maticon('attachment', 'normal-text').' Attachments', 'class="full-width center-align inverse-text"');
		echo button('class="action onviewanimated large waves-effect waves-dark accent inverse-text" type="submit"', maticon('save', 'spaced-text'));
	echo mdldivend();

	echo mdldivstrt('cardbody white dash-window mdscrollbar');
		echo mdldivstrt('col s12');
			echo dragdropattachmentfiler('newrecordattachments', $recId, 'fixedassets_assetlist', 'cloud_upload', 'dragdroperfiler', 'Drop file/s here to attach');
		echo mdldivend();


		echo mdldivstrt('col s12');
					
						if (sizeof($attachments)>0 && is_array($attachments)) {
							echo '<ul class="collection borderless">';
							foreach ($attachments as $attachment) {
								
								if ($attachment->extension =='jpg' || $attachment->extension =='jpeg' || $attachment->extension =='png' || $attachment->extension =='gif' || $attachment->extension =='tiff' || $attachment->extension =='ico') {
									echo '<li class="collection-item avatar">';
										echo img(site_url('files/Files/outputimage/'.$attachment->attId), 'alt="" class="circle grey lighten-2"');
										echo '<span class="title grey-text text-darken-3">'.$attachment->name.'</span>';
										echo paragraph(maticon('event', 'spaced-text').' '.formatmoduledatetimeformat($attachment->gmtinsertdate, 'fixedassets').breaker().maticon('data_usage', 'spaced-text').' '.$attachment->filesize, 'class="grey-text"');
										echo anchor('files/Files/delete/'.$attachment->attId, maticon('delete', 'spaced-text'), 'class="secondary-content red-text"');
										echo anchor('files/Files/download/'.$attachment->attId, maticon('cloud_download', 'spaced-text'), 'class="secondary-content grey-text"');
									echo '</li>';
									
								}
								else if ($attachment->extension =='mp4' || $attachment->extension =='avi') {
									echo '<li class="collection-item avatar">';
										echo maticon('movie', 'circle purple');
										echo '<span class="title grey-text text-darken-3">'.$attachment->name.'</span>';
										echo paragraph(maticon('event', 'spaced-text').' '.formatmoduledatetimeformat($attachment->gmtinsertdate, 'fixedassets').breaker().maticon('data_usage', 'spaced-text').' '.$attachment->filesize, 'class="grey-text"');
										echo anchor('files/Files/delete/'.$attachment->attId, maticon('delete', 'spaced-text'), 'class="secondary-content red-text"');
										echo anchor('files/Files/download/'.$attachment->attId, maticon('cloud_download', 'spaced-text'), 'class="secondary-content grey-text"');
									echo '</li>';
								}
								else if ($attachment->extension =='mp3' || $attachment->extension =='wma') {
									echo '<li class="collection-item avatar">';
										echo maticon('volume_up', 'circle purple');
										echo '<span class="title grey-text text-darken-3">'.$attachment->name.'</span>';
										echo paragraph(maticon('event', 'spaced-text').' '.formatmoduledatetimeformat($attachment->gmtinsertdate, 'fixedassets').breaker().maticon('data_usage', 'spaced-text').' '.$attachment->filesize, 'class="grey-text"');
										echo anchor('files/Files/delete/'.$attachment->attId, maticon('delete', 'spaced-text'), 'class="secondary-content red-text"');
										echo anchor('files/Files/download/'.$attachment->attId, maticon('cloud_download', 'spaced-text'), 'class="secondary-content grey-text"');
									echo '</li>';
									
								}
								else if ($attachment->extension =='pdf' || $attachment->extension =='doc' || $attachment->extension =='docx' || $attachment->extension =='xls') {
									echo '<li class="collection-item avatar">';
										echo maticon('insert_drive_file', 'circle purple');
										echo '<span class="title grey-text text-darken-3">'.$attachment->name.'</span>';
										echo paragraph(maticon('event', 'spaced-text').' '.formatmoduledatetimeformat($attachment->gmtinsertdate, 'fixedassets').breaker().maticon('data_usage', 'spaced-text').' '.$attachment->filesize, 'class="grey-text"');
										echo anchor('files/Files/delete/'.$attachment->attId, maticon('delete', 'spaced-text'), 'class="secondary-content red-text"');
										echo anchor('files/Files/download/'.$attachment->attId, maticon('cloud_download', 'spaced-text'), 'class="secondary-content grey-text"');
									echo '</li>';
									
								}
								else{
									echo '<li class="collection-item avatar">';
										echo maticon('insert_drive_file', 'circle grey lighten-2 black-text');
										echo '<span class="title grey-text text-darken-3">'.$attachment->name.'</span>';
										echo paragraph(maticon('event', 'spaced-text').' '.formatmoduledatetimeformat($attachment->gmtinsertdate, 'fixedassets').breaker().maticon('data_usage', 'spaced-text').' '.$attachment->filesize, 'class="grey-text"');
										echo anchor('files/Files/delete/'.$attachment->attId, maticon('delete', 'spaced-text'), 'class="secondary-content red-text"');
										echo anchor('files/Files/download/'.$attachment->attId, maticon('cloud_download', 'spaced-text'), 'class="secondary-content grey-text"');

									echo '</li>';
								}

								
							}
							echo '</ul>';
						}
						else{
							echo headertxt('3', maticon('folder_open', 'normal-text').' No attachments yet', 'class="full-width center-align grey-text"');
						}
		echo mdldivend();

	
		
	echo mdldivend();
echo mdldivend();

?>

