<?php
$flashnotifacations = array();

$messageflashnotifacations = getflashnotifacation('message');
$infoflashnotifacations = getflashnotifacation('info');
$warningflashnotifacations = getflashnotifacation('warning');
$errorflashnotifacations = getflashnotifacation('error');




if (!is_null($messageflashnotifacations) && is_array($messageflashnotifacations)) {
	foreach ($messageflashnotifacations as $fnotifacationcursor => $fnotifacation) {
		$flashnotifacation = array();
		$flashnotifacation['type'] = 'success';
		$flashnotifacation['icon'] = 'thumb_up';
		$flashnotifacation['title'] = 'Done';
		$flashnotifacation['text'] = 'Action Successful';
		$flashnotifacation['imagesrc'] = false;
		$flashnotifacation['closewith'] = 'timeout';
		$flashnotifacation['timeout'] = 2000;
		if (is_array($fnotifacation)) {
			if (array_key_exists('icon', $fnotifacation)) {
				$flashnotifacation['icon'] = $fnotifacation['icon'];
			}			
			if (array_key_exists('title', $fnotifacation)) {
				$flashnotifacation['title'] = $fnotifacation['title'];
			}
			if (array_key_exists('alert', $fnotifacation)) {
				$flashnotifacation['text'] = $fnotifacation['alert'];
			}
			if (array_key_exists('imagesrc', $fnotifacation)) {
				$flashnotifacation['imagesrc'] = $fnotifacation['imagesrc'];
			}
		}
		else{
			$flashnotifacation['text'] = strip_tags($fnotifacation);
		}
		array_push($flashnotifacations, $flashnotifacation);			
	}
}
if (!is_null($infoflashnotifacations) && is_array($infoflashnotifacations)) {
	foreach ($infoflashnotifacations as $fnotifacationcursor => $fnotifacation) {
		$flashnotifacation = array();
		$flashnotifacation['type'] = 'info';
		$flashnotifacation['icon'] = 'info';
		$flashnotifacation['title'] = 'Good Ol\' Info';
		$flashnotifacation['text'] = 'There\'s Something Notable';
		$flashnotifacation['imagesrc'] = false;
		$flashnotifacation['closewith'] = 'timeout';
		$flashnotifacation['timeout'] = 2000;
		if (is_array($fnotifacation)) {
			if (array_key_exists('icon', $fnotifacation)) {
				$flashnotifacation['icon'] = $fnotifacation['icon'];
			}			
			if (array_key_exists('title', $fnotifacation)) {
				$flashnotifacation['title'] = $fnotifacation['title'];
			}
			if (array_key_exists('alert', $fnotifacation)) {
				$flashnotifacation['text'] = $fnotifacation['alert'];
			}
			if (array_key_exists('imagesrc', $fnotifacation)) {
				$flashnotifacation['imagesrc'] = $fnotifacation['imagesrc'];
			}
		}
		else{
			$flashnotifacation['text'] = strip_tags($fnotifacation);
		}
		array_push($flashnotifacations, $flashnotifacation);			
	}
}
if (!is_null($warningflashnotifacations) && is_array($warningflashnotifacations)) {
	foreach ($warningflashnotifacations as $fnotifacationcursor => $fnotifacation) {
		$flashnotifacation = array();
		$flashnotifacation['type'] = 'warning';
		$flashnotifacation['icon'] = 'warning';
		$flashnotifacation['title'] = 'Heads\'s Up!';
		$flashnotifacation['text'] = 'There\'s Something Notable';
		$flashnotifacation['imagesrc'] = false;
		$flashnotifacation['closewith'] = 'click';
		$flashnotifacation['timeout'] = 3000;
		if (is_array($fnotifacation)) {
			if (array_key_exists('icon', $fnotifacation)) {
				$flashnotifacation['icon'] = $fnotifacation['icon'];
			}			
			if (array_key_exists('title', $fnotifacation)) {
				$flashnotifacation['title'] = $fnotifacation['title'];
			}
			if (array_key_exists('alert', $fnotifacation)) {
				$flashnotifacation['text'] = $fnotifacation['alert'];
			}
			if (array_key_exists('imagesrc', $fnotifacation)) {
				$flashnotifacation['imagesrc'] = $fnotifacation['imagesrc'];
			}
		}
		else{
			$flashnotifacation['text'] = strip_tags($fnotifacation);
		}
		array_push($flashnotifacations, $flashnotifacation);			
	}
}

if (!is_null($errorflashnotifacations) && is_array($errorflashnotifacations)) {
	foreach ($errorflashnotifacations as $fnotifacationcursor => $fnotifacation) {
		$flashnotifacation = array();
		$flashnotifacation['type'] = 'error';
		$flashnotifacation['icon'] = 'error';
		$flashnotifacation['title'] = 'Something\'s Wrong!';
		$flashnotifacation['text'] = 'Something didn\'t go right. <br /> It\'s Nobodys Fault';
		$flashnotifacation['imagesrc'] = false;
		$flashnotifacation['closewith'] = 'click';
		$flashnotifacation['timeout'] = 5000;
		if (is_array($fnotifacation)) {
			if (array_key_exists('icon', $fnotifacation)) {
				$flashnotifacation['icon'] = $fnotifacation['icon'];
			}			
			if (array_key_exists('title', $fnotifacation)) {
				$flashnotifacation['title'] = $fnotifacation['title'];
			}
			if (array_key_exists('alert', $fnotifacation)) {
				$flashnotifacation['text'] = $fnotifacation['alert'];
			}
			if (array_key_exists('imagesrc', $fnotifacation)) {
				$flashnotifacation['imagesrc'] = $fnotifacation['imagesrc'];
			}
		}
		else{
			$flashnotifacation['text'] = strip_tags($fnotifacation);
		}
		array_push($flashnotifacations, $flashnotifacation);			
	}
}

if (isset($error)) {
	$errornotifacation = array();
	$errornotifacation['type'] = 'error';
	$errornotifacation['icon'] = 'error';
	$errornotifacation['title'] = 'Something\'s Wrong!';
	$errornotifacation['text'] = 'Something didn\'t go right.';
	$errornotifacation['imagesrc'] = false;
	$errornotifacation['closewith'] = 'timeout';
	$errornotifacation['timeout'] = 5000;

	if (is_array($error)) {
		if (array_key_exists('icon', $error)) {
			$errornotifacation['icon'] = $error['icon'];
		}			
		if (array_key_exists('title', $error)) {
			$errornotifacation['title'] = $error['title'];
		}
		if (array_key_exists('alert', $error)) {
			$errornotifacation['text'] = $error['alert'];
		}
		if (array_key_exists('imagesrc', $error)) {
			$errornotifacation['imagesrc'] = $error['imagesrc'];
		}
	
	}
	else{
		$errornotifacation['text'] = strip_tags($error);
	}
	array_push($flashnotifacations, $errornotifacation);
}

if (isset($strerror)) {
	$strerrornotifacation = array();
	$strerrornotifacation['type'] = 'error';
	$strerrornotifacation['icon'] = 'error';
	$strerrornotifacation['title'] = 'Something\'s Wrong!';
	$strerrornotifacation['text'] = 'Something didn\'t go right.';
	$strerrornotifacation['imagesrc'] = false;
	$strerrornotifacation['closewith'] = 'click';
	$strerrornotifacation['timeout'] = 10000;

	if (is_array($strerror)) {
		if (array_key_exists('icon', $strerror)) {
			$strerrornotifacation['icon'] = $strerror['icon'];
		}			
		if (array_key_exists('title', $strerror)) {
			$strerrornotifacation['title'] = $strerror['title'];
		}
		if (array_key_exists('alert', $strerror)) {
			$strerrornotifacation['text'] = $strerror['alert'];
		}
		if (array_key_exists('imagesrc', $strerror)) {
			$strerrornotifacation['imagesrc'] = $strerror['imagesrc'];
		}		
	}
	else{
		$strerrornotifacation['text'] = strip_tags($strerror);
	}
	array_push($flashnotifacations, $strerrornotifacation);
}

if (isset($message)) {
	$messagenotifacation = array();
	$messagenotifacation['type'] = 'success';
	$messagenotifacation['icon'] = 'thumb_up';
	$messagenotifacation['title'] = 'Thumbs up!';
	$messagenotifacation['text'] = 'Action Successful';
	$messagenotifacation['imagesrc'] = false;
	$messagenotifacation['closewith'] = 'timeout';
	$messagenotifacation['timeout'] = 5000;

	if (is_array($message)) {
		if (array_key_exists('icon', $message)) {
			$messagenotifacation['icon'] = $message['icon'];
		}			
		if (array_key_exists('title', $message)) {
			$messagenotifacation['title'] = $message['title'];
		}
		if (array_key_exists('alert', $message)) {
			$messagenotifacation['text'] = $message['alert'];
		}
		if (array_key_exists('imagesrc', $message)) {
			$messagenotifacation['imagesrc'] = $message['imagesrc'];
		}		
	}
	else{
		$messagenotifacation['text'] = strip_tags($message);
	}
	array_push($flashnotifacations, $messagenotifacation);
}

if (isset($strmessage)) {
	$messagenotifacation['type'] = 'info';
	$messagenotifacation['icon'] = 'thumb_up';
	$messagenotifacation['title'] = 'Heads Up!';
	$messagenotifacation['text'] = 'Action Successful';
	$messagenotifacation['imagesrc'] = false;
	$messagenotifacation['closewith'] = 'timeout';
	$messagenotifacation['timeout'] = 5000;

	if (is_array($strmessage)) {
		if (array_key_exists('icon', $strmessage)) {
			$strmessagenotifacation['icon'] = $strmessage['icon'];
		}			
		if (array_key_exists('title', $strmessage)) {
			$strmessagenotifacation['title'] = $strmessage['title'];
		}
		if (array_key_exists('alert', $strmessage)) {
			$strmessagenotifacation['text'] = $strmessage['alert'];
		}
		if (array_key_exists('imagesrc', $strmessage)) {
			$strmessagenotifacation['imagesrc'] = $strmessage['imagesrc'];
		}		
	}
	else{
		$strmessagenotifacation['text'] = strip_tags($strmessage);
	}
	array_push($flashnotifacations, $strmessagenotifacation);
}
if (isset($strinfo)) {
	$strinfonotifacation['type'] = 'info';
	$strinfonotifacation['icon'] = 'thumb_up';
	$strinfonotifacation['title'] = 'Heads Up!';
	$strinfonotifacation['text'] = 'Action Successful';
	$strinfonotifacation['imagesrc'] = false;
	$strinfonotifacation['closewith'] = 'timeout';
	$strinfonotifacation['timeout'] = 5000;

	if (is_array($strinfo)) {
		if (array_key_exists('icon', $strinfo)) {
			$strinfonotifacation['icon'] = $strinfo['icon'];
		}			
		if (array_key_exists('title', $strinfo)) {
			$strinfonotifacation['title'] = $strinfo['title'];
		}
		if (array_key_exists('alert', $strinfo)) {
			$strinfonotifacation['text'] = $strinfo['alert'];
		}
		if (array_key_exists('imagesrc', $strinfo)) {
			$strinfonotifacation['imagesrc'] = $strinfo['imagesrc'];
		}		
	}
	else{
		$strinfonotifacation['text'] = strip_tags($strinfo);
	}
	array_push($flashnotifacations, $strinfonotifacation);
}

if (sizeof($flashnotifacations) > 0) {
	$notifacationscript = '<script type="text/javascript"> $(function() { ';

	foreach ($flashnotifacations as $flashnotifacation) {
		$notifacationscript .= '$.notify({									
									title: "'.$flashnotifacation['title'].'",
									text:"'.$flashnotifacation['text'].'",
									'.($flashnotifacation['imagesrc'] != false? 'imagesrc : "'.$flashnotifacation['imagesrc'].'",' : '').'
									icon:"'.$flashnotifacation['icon'].'",
									type:"'.$flashnotifacation['type'].'",
									notifacations : ["app"],
									closewith: "'.$flashnotifacation['closewith'].'"                      
								});';
	}

	$notifacationscript .= '}); </script>';
	echo $notifacationscript;
}
