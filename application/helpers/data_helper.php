<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/



//data functions



//-------------------------------------------------------------------------
// Defence against the dark arts
//-------------------------------------------------------------------------
//generate Random Non Numeric ID
function genrandomstrid($length=11){
	$idstr = "";
	$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$idstr .= $characters[$rand];
	}
	return $idstr;
}
//escape mysql query vars to counter SQL Injection;
function prepsqlstringvar($myStr, $strQuote="'", $lMaxLen=null) {	
	//   return(xss_clean('\'' . addslashes($myStr) . '\''));
	   if (!is_null($lMaxLen)){
		  if (strlen($myStr) > $lMaxLen){
			 $myStr = substr($myStr, 0, $lMaxLen);
		  }
	   }
	   return($strQuote.addslashes($myStr).$strQuote);
}

function isallowedip($ip){
		$CI =& get_instance();
		$allowed_ips = $CI->config->item('allowed_ips');
		$allowed_ips = trim($allowed_ips);
		if (strlen($allowed_ips) > 0) {
			$allowed_ips_array = explode(',', $allowed_ips);

			if ($CI->input->valid_ip($ip)) {
				if (in_array($ip, $allowed_ips_array)) {
					return TRUE;
				}
				else{
					return FALSE;
				}
			}
			else{
				return FALSE;
			}			
		}
		else{
			return TRUE;
		}
}

function reffererpage(){
	if (array_key_exists('HTTP_REFERER', $_SERVER)) {
		$refererurl = $_SERVER["HTTP_REFERER"];
		$controllerurl = str_replace(site_url(), '', $refererurl);
		return $controllerurl;
	}	
	else{
		return 'Dashboard';
	}
}

function indevelopmentmode(){
	if (defined(ENVIRONMENT)) {
		if (ENVIRONMENT == 'production') {
			return FALSE;
		}
	}	
	return TRUE;
}

function isajaxrequest(){
	$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	return $isAjax;
}

function preredirect($url, $refresh=FALSE){
	if ($refresh==FALSE) {
		redirect($url, 'refresh');
	}
	if (isajaxrequest()) {
		echo site_url($url);		
	}
	else{
		redirect($url, $refresh);
	}
	
}

//check for internet connection by pinging good 'ol trusty google
function internetavailable(){
	return canconnectto('google.com');
}


function canconnectto($address, $port = 80){
	$connected = @fsockopen($address, $port); 
	//website, port  (try 80 or 443)
	if ($connected){
		$is_conn = TRUE; //action when connected
		fclose($connected);
	}else{
		$is_conn = FALSE; //action in connection failure
	}
	return $is_conn;
}

function clientip(){
		$ipaddress = '';
		if (defined($_SERVER['HTTP_CLIENT_IP'])){
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		}
			
		else if(defined($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
			
		else if(defined($_SERVER['HTTP_X_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		}
			
		else if(defined($_SERVER['HTTP_FORWARDED_FOR'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		}
			
		else if(defined($_SERVER['HTTP_FORWARDED'])){
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		}
			
		else if(defined($_SERVER['REMOTE_ADDR'])){
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		}
			
		else{
			$ipaddress = '';
		}
			
		echo $ipaddress ;
	 }

function passwordvalidate($user,$pass, $minlength=6) {
		$word_file = './assets/files/words';
		
		$lc_pass = strtolower($pass);
		// also check password with numbers or punctuation subbed for letters
		$denum_pass = strtr($lc_pass,'5301!','seoll');
		$lc_user = strtolower($user);

		// the password must be at least six characters
		if (strlen($pass) < $minlength) {
			return 'The password is too short.';
		}

		// the password can't be the username (or reversed username) 
		if (($lc_pass == $lc_user) || ($lc_pass == strrev($lc_user)) ||
			($denum_pass == $lc_user) || ($denum_pass == strrev($lc_user))) {
			return 'The password is based on the username.';
		}

		// count how many lowercase, uppercase, and digits are in the password 
		$uc = 0; $lc = 0; $num = 0; $other = 0;
		for ($i = 0, $j = strlen($pass); $i < $j; $i++) {
			$c = substr($pass,$i,1);
			if (preg_match('/^[[:upper:]]$/',$c)) {
				$uc++;
			} elseif (preg_match('/^[[:lower:]]$/',$c)) {
				$lc++;
			} elseif (preg_match('/^[[:digit:]]$/',$c)) {
				$num++;
			} else {
				$other++;
			}
		}

		// the password must have more than two characters of at least 
		// two different kinds 
		$max = $j - 2;
		if ($uc > $max) {
			return "The password has too many upper case characters.";
		}
		if ($lc > $max) {
			return "The password has too many lower case characters.";
		}
		if ($num > $max) {
			return "The password has too many numeral characters.";
		}
		if ($other > $max) {
			return "The password has too many special characters.";
		}

		// the password must not contain a dictionary word 
		if (is_readable($word_file)) {
			if ($fh = fopen($word_file,'r')) {
				$found = false;
				while (! ($found || feof($fh))) {
					$word = preg_quote(trim(strtolower(fgets($fh,1024))),'/');
					if (preg_match("/$word/",$lc_pass) ||
						preg_match("/$word/",$denum_pass)) {
						$found = true;
					}
				}
				fclose($fh);
				if ($found) {
					return 'The password is based on a dictionary word.';
				}
			}
		}

		return false;
	}

	function is_validdate($datestring){
		return (bool)strtotime($datestring);
	}

	function sanitizeString($string){
		$sanitizedString = preg_replace('/[^A-Za-z0-9\-]/',' ', $string);


		return $sanitizedString;

	}
	function sanitizeDate($datestring){
		if ($datestring != '') {
			try {
				$rawDate = gmdate('Y-m-d', $datestring);
				$sanitizedDate = $rawDate;
			} catch (Exception $e) {
				$sanitizedDate = '';
			}
			
							
		}
		else{
			$sanitizedDate = '';
		}
		return $sanitizedDate;

	}
	function sanitizeInt($integer){
		$sanitizedInteger = filter_var($integer, FILTER_SANITIZE_NUMBER_INT);
		return $sanitizedInteger;
	}
	function sanitizeDecimal($decimal){		
		$sanitizedDecimal = filter_var($decimal, FILTER_SANITIZE_NUMBER_FLOAT);
		return $sanitizedDecimal;
	}



	function objecttoarrayrecursivecast($array){
		if(is_object($array)) {
			$array = get_object_vars($array);
		}
		if(is_array($array)) {
			return array_map(__FUNCTION__, $array); // recursive
		} 
		else {
			return $array;
		}
	}

	function arraytoobjectrecursivecast($a){		
		if (is_array($a) ) {
			foreach($a as $k => $v) {
				if (is_integer($k)) {
					// only need this if you want to keep the array indexes separate
					// from the object notation: eg. $o->{1}
					$a['index'][$k] = arraytoobjectrecursivecast($v);
				}
				else {
					$a[$k] = arraytoobjectrecursivecast($v);
				}
			}

			return (object) $a;
		}

		// else maintain the type of $a
		return $a; 
	}
	
	function isassociativearray($arr){
		foreach(array_keys($arr) as $key){
			if (!is_int($key)) {
				return TRUE;
			}
		}
		return FALSE;
	}

	function strstartsWith($haystack, $needle){
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function strendsWith($haystack, $needle){
		$length = strlen($needle);

		return $length === 0 || 
		(substr($haystack, -$length) === $needle);
	}	

	function depluralize($word){
		// Here is the list of rules. To add a scenario,
		// Add the plural ending as the key and the singular
		// ending as the value for that key. This could be
		// turned into a preg_replace and probably will be
		// eventually, but for now, this is what it is.
		//
		// Note: The first rule has a value of false since
		// we don't want to mess with words that end with
		// double 's'. We normally wouldn't have to create
		// rules for words we don't want to mess with, but
		// the last rule (s) would catch double (ss) words
		// if we didn't stop before it got to that rule. 
		$rules = array('ss' => false, 'os' => 'o', 'ies' => 'y', 'xes' => 'x', 'oes' => 'o', 'ies' => 'y', 'ves' => 'f', 's' => '');
		// Loop through all the rules and do the replacement. 
		foreach(array_keys($rules) as $key){
			// If the end of the word doesn't match the key,
			// it's not a candidate for replacement. Move on
			// to the next plural ending. 
			if(substr($word, (strlen($key) * -1)) != $key) 
				continue;
			// If the value of the key is false, stop looping
			// and return the original version of the word. 
			if($key === false) 
				return $word;
			// We've made it this far, so we can do the
			// replacement. 
			return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key]; 
		}
		return $word;
	}


	function createdirectory($dir, $srtseparator=true){
		$created = TRUE;
		$dir = str_replace(DIRECTORY_SEPARATOR, '/', $dir);
		$dir = str_replace('//', '/', $dir);


		if (strstartsWith($dir, '/')) {
			$dir = substr($dir, 1);
		}
		if (strstartsWith($dir, './')) {
			$dir = substr($dir, 2);
		}
		$dirarr = explode('/', $dir);

		if ($srtseparator && sizeof($dirarr)>0) {
			$dirarr[0] = './'.$dirarr[0];
		}
		$currdir = $dir;
		if (sizeof($dirarr)>0) {
			$currdir = $dirarr[0];
		}
		for ($i=1; $i < sizeof($dirarr); $i++) { 
			$currdir .= '/'.$dirarr[$i];
			if (!file_exists($currdir)) {
				if (!mkdir($currdir)) {
					$created = FALSE;
					break;
				}
			}
			else{
				continue;
			}
		}
		return $created;
	}







	function hex_2_bin($strHex){
	//-------------------------------------------------------------------------
	//
	//-------------------------------------------------------------------------
	   $strOut = '';

	   for ($idx=0; $idx<strlen($strHex); $idx+=2 ) {
		  $strOut .= chr(hexdec(substr($strHex, $idx, 2)));
	   }
	   return($strOut);
	}

	function strPrepDecimal($decimal) {
		return round($decimal, 2);
	}

	function strPrepDateTime($lTimeStamp) {
	//-------------------------------------------------------------------------
	//  return the specified date/time in mySQL format
	//-------------------------------------------------------------------------
	   if (is_null($lTimeStamp)) {
		  return('NULL');
	   }else {
		  return(date('Y-m-d H:i:s', $lTimeStamp));
	   }
	}

	function strPrepDate($lTimeStamp) {
	//-------------------------------------------------------------------------
	//  return the specified date only in mySQL format
	//-------------------------------------------------------------------------
	   if (is_null($lTimeStamp)) {
		  return('NULL');
	   }
	   else {
			$sanitizedDate = false;
			$rawDate = str_replace(' ', '', $lTimeStamp);
			$rawDate = str_replace('/', '-', $lTimeStamp);
			$rawDate = str_replace('.', '-', $lTimeStamp);
			$rawDate = strtotime($rawDate);
			if ($rawDate != false) {
				$sanitizedDate =  date('Y-m-d', $rawDate);
			}
			if ($sanitizedDate != false) {
				return $sanitizedDate;
			}
			else{
				return('NULL');
			}
		  
	   }
	}

	

	function strPrepTime($lTimeStamp) {
	//-------------------------------------------------------------------------
	//  return the specified time in mySQL format
	//-------------------------------------------------------------------------
	   if (is_null($lTimeStamp)) {
		  return('NULL');
	   }else {
		  return(prepsqlstringvar(date('H:i:s', $lTimeStamp)));
	   }
	}

	function strXlateCurrency($enumCurrency){
	//------------------------------------------------------------------
	//
	//------------------------------------------------------------------
	   switch ($enumCurrency){
		  case 'dollar': return('$');       break;
		  case 'euro'  : return('&#128;');  break;
		  case 'pound' : return('&pound;'); break;
		  case 'yen'   : return('&yen;');   break;
		  case 'rupee' : return('&#8360;'); break;
		  default      : return('#err#');   break;
	   }
	}




	function sanitizeForJSON($str){

		if (!is_null($str)) {
				// Strip all slashes:
				$str = stripslashes($str);
				// Only escape backslashes:
				$str = str_replace('"', '\"', $str);
				
			return $str;		    
		}
		return $str;
			
	}




	/**
	 * Alternative to json_encode() to handle big arrays
	 * Regular json_encode would return NULL due to memory issues.
	 * @param $arr
	 * @return string
	*/
	function jsonEncode($arr = array()) {
		$str = '{';
		$count = count($arr);
		$current = 0;
		if (sizeof($arr)>0) {
			$lastindex = $count-1;
		}
		else{
			$lastindex = 0;
		}
		foreach ($arr as $key => $value) {;
			if (is_numeric($key)) {
				$str .= $key.':';
			}
			else{
				$str .= '"'.sanitizeForJSON($key).'":';
			}
			

			if (is_array($value)) {
				$lastindex2 = sizeof($value)-1;
				$current2 = 0;
				$str .= '[';
				foreach ($value as $key2 => $val) {
						if (is_numeric($key2)) {
							$str .= $key2.':';
						}
						else{
							$str .= '"'.sanitizeForJSON($key2).'":';
						}
						
					
					

					if (is_array($val)) {

						$str .= jsonEncode($val);
					}
					else{
						$str .= '"'.sanitizeForJSON($val).'"';
						
					}
					$current2++;

					if ($current2 <= $lastindex2) {
						$str .= ',';
					}

				}
				$str .= '}';

			} 
			else {
				if (strlen($value)>0) {
					if (is_integer($value) || is_float($value) || is_long($value)) {
						$str .= $value;
					}
					else if (is_bool($value)) {
						if ($value) {
							$str .= 1;
						}
						else{
							$str .= 0;
						}
					}
					else{
						$str .= '"'.sanitizeForJSON($value).'"';
					}
				}
				else{
					$str .= '""';
				}
				
					
				
			}

			$current ++;
			if ($current <= $lastindex) {
				$str .= ',';
			}
		}

		$str.= '}';

		return $str;
	}

	function jsonDecode($json){ 
		$comment = false; 
		$out = '$x='; 
		
		for ($i=0; $i < strlen($json); $i++) 
		{ 
			if (!$comment) 
			{ 
				if ($json[$i] == '{')        $out .= ' array('; 
				else if ($json[$i] == '}')    $out .= ')'; 
				else if ($json[$i] == ':')    $out .= '=>'; 
				else                         $out .= $json[$i];            
			} 
			else $out .= $json[$i]; 
			if ($json[$i] == '"')    $comment = !$comment; 
		}
		eval($out . ';'); 
		return $x; 
	}


	function fileExtension($filename){
		  return (($dot = strrpos($filename, '.')) === FALSE)? '': substr($filename, $dot + 1);
	}

	function formatfileSize($bytes){
		if ($bytes >= 1073741824){
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		else if ($bytes >= 1048576){
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		else if ($bytes > 0){
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		else{
			$bytes = '0 bytes';
		}

		return $bytes;
	}
	if(!function_exists('mime_content_type')) {
		function mime_content_type($filename) {
			$mime_types = array(
				'txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',

				// images
				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',

				// archives
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',

				// audio/video
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',

				// adobe
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',

				// ms office
				'doc' => 'application/msword',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',

				// open office
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			);

			$ext = strtolower(fileExtension($filename));
			if (array_key_exists($ext, $mime_types)) {
				return $mime_types[$ext];
			}
			elseif (function_exists('finfo_open')) {
				$finfo = finfo_open(FILEINFO_MIME);
				$mimetype = finfo_file($finfo, $filename);
				finfo_close($finfo);
				return $mimetype;
			}
			else {
				return 'application/octet-stream';
			}
		}
	}

	function generateBarcode($code, $datatype="html", $totalHeight = 60, $color = 'black', $widthFactor = 2, $type="C39"){
		$CI = & get_instance();
		$CI->load->library('barcode');
		$barcode = FALSE;
		$datatype = strtolower($datatype);

		if ($datatype=='html') {
			$barcode = $CI->barcode->barcodehtml($code, $type, $widthFactor, $totalHeight, $color);
		}
		else if ($datatype=='png') {
			$barcode = $CI->barcode->barcodepng($code, $type, $widthFactor, $totalHeight);
		}
		else if ($datatype=='jpg' || $datatype=='jpeg') {
			$barcode = $CI->barcode->barcodepng($code, $type, $widthFactor, $totalHeight);
		}
		else if ($datatype=='svg') {
			$barcode = $CI->barcode->barcodesvg($code, $type, $widthFactor, $totalHeight, $color);
		}
		return $barcode;
	}

	function generateQRcode($data, $datatype="png", $size=10, $level='L'){
		$CI = & get_instance();
		$CI->load->library('ciqrcode');

		$params['data'] = $data;
		$params['level'] = $level;
		$params['size'] = $size;
		$qrcode = $CI->ciqrcode->generate($params);		
		return base64_encode($qrcode);
	}

	function nextdate($date = FALSE, $intervalmode='months', $intervalnum=1){
		$CI = & get_instance();
		if ($date == FALSE || is_null($date) ) {
			$date = date('Y-m-d');
		}
		$leapyear = FALSE;
		$returndata = FALSE;

		if (is_object($date)) {
			$dateobject = $date;
		}
		else if (is_string($date)) {
			if (is_validdate($date)) {
				$dateobject = date_create($date);
			}
		}


		$datedefaultformat = date_format($dateobject, 'Y-m-d');
		
		if ($intervalmode=='months') {
			$nextyears = $intervalnum/12;
			$nextyearsmonth = $intervalnum % 12;
		}

		$day = intval(date_format($dateobject, 'd'));
		$month = intval(date_format($dateobject, 'm'));
		$year = intval(date_format($dateobject, 'Y'));

		$monthlastdate = cal_days_in_month(CAL_GREGORIAN, $month, $year);




		$nextdateobject = date_add($dateobject, date_interval_create_from_date_string($intervalnum.' '.$intervalmode));

		if ($day == $monthlastdate && $intervalmode=='months' && ($intervalnum - intval($intervalnum)) == 0 ) {
			$nextday = intval(date_format($nextdateobject, 'd'));;
			$nextmonth = intval(date_format($nextdateobject, 'm'));
			$nextyear = intval(date_format($nextdateobject, 'Y'));

			if ($nextday != $day) {
				if ($nextmonth == 1) {
					$nextmonth = 12;
					$nextyear = $nextyear-1;
				}
				else{
					$nextmonth = $nextmonth-1;
				}
			}
							
				$newmonthlastdate = cal_days_in_month(CAL_GREGORIAN, $nextmonth, $nextyear);
				$endmonthdate = date_create($nextyear.'-'.$nextmonth.'-'.$newmonthlastdate);
				$nextdateobject = $endmonthdate;
		}

		$returndata = date_format($nextdateobject, 'Y-m-d');

		return $returndata;
		
	}

   

   function dirfilesucfirst($dir, $ext='php', $classname=FALSE){
		$dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
		if (strrpos($dir, DIRECTORY_SEPARATOR) != (strlen($dir)-1)) {
			$dir = $dir.DIRECTORY_SEPARATOR;
		}
		$log = array();
		$log['successes'] = array();
		$log['fails'] = array();
		$log['subdirs'] = array();
		$CI = & get_instance();

		$CI->load->helper('file');
		$CI->load->helper('directory');
		$dirfiles = directory_map($dir);
		foreach ($dirfiles as $key => $value) {
			if (is_array($value) && sizeof($value)>0) {
				$log['subdirs'][str_replace(DIRECTORY_SEPARATOR, '', $key)] = dirfilesucfirst($dir.$key, $ext, $classname);
			}
			else{
				$fileExtension = fileExtension($value);
				if ($fileExtension == $ext) {
					$oldname = $dir.$value;
					$newname = $dir.ucfirst($value);
					if (rename($oldname, $newname)) {
						array_push($log['successes'], $value);
						if ($classname) {
							$currentcontent = file_get_contents($newname);   							

							$currentclassname = 'class '.strtolower(str_replace('.'.$fileExtension, '', $value));
							$newclassname = 'class '.ucfirst(str_replace('.'.$fileExtension, '', $value));

							

							$hasclassname = strpos($currentclassname, $currentcontent);

								$currentcontent = str_replace($currentclassname, $newclassname, $currentcontent);

								$writefile = file_put_contents($newname, $currentcontent);
							
						}
					}
					else{
						array_push($log['fails'], $value);
					}
				}
			}
		}

		return $log;
   }



function resolveshortcodes($text, array $shortcodes, array $values) {
   $result = $text;
   foreach ($shortcodes as $shortcode) {
		$value = '';
		if (array_key_exists($shortcode, $values)) {
			$value = $values[$shortcode];
		}
		$result = str_replace('{{'.$shortcode.'}}', $value, $result);
   }
   return $result;
}

function arrayCopy( array $array ) {
//---------------------------------------------------------------------
// thanks to kolkabes at googlemail dot com
// http://php.net/manual/en/ref.array.php
//---------------------------------------------------------------------
   $result = array();
   foreach( $array as $key => $val ) {
	  if( is_array( $val ) ) {
		  $result[$key] = arrayCopy( $val );
	  } elseif ( is_object( $val ) ) {
		  $result[$key] = clone $val;
	  } else {
		  $result[$key] = $val;
	  }
   }
   return $result;
}

function make_seed() {
//-------------------------------------------------------------------------
// seed with microseconds - from the php manual
// example: mt_srand(make_seed());
//-------------------------------------------------------------------------
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}

function phpversionvalidate(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
	  $MinVersion = explode('.',  PHP_MIN_DL_VERSION);
	  $lMinVersion = $MinVersion[0] * 10000 + $MinVersion[1] * 100 + $MinVersion[2];

		 // http://php.net/phpversion
	  if (!defined('PHP_VERSION_ID')) {
		  $version = explode('.', PHP_VERSION);
		  define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
	  }
	  if (PHP_VERSION_ID < $lMinVersion){
		 echoT('****** PHP Version Error *******<br>
				ActionAid CRM requires php version '.PHP_MIN_DL_VERSION.' or greater.<br><br>
				It appears that you are running version '.PHP_VERSION);
		 die;
	  }
   }


   function operatingsystem(){	
		if (PHP_OS === 'WINNT') {
			return 'windows';
		} 
		else if (PHP_OS === 'Linux') {
			return 'linux';
		} 
		else {
			return PHP_OS;
		}
	}

?>
