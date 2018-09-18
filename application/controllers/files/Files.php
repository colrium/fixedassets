<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Files extends CI_Controller {
	public $displayData;
	function __construct(){
		parent::__construct();
		$this->load->helper('file');
	}
	public function download($recId){
		$table = 'attachments';
		$details = dbtablerecord($recId, $table);
		// Set the default MIME type to send
		$mime = 'application/octet-stream';
		// Load the mime types
		$mimes =& get_mimes();
		// Only change the default MIME if we can find one
		if (isset($mimes[$details->extension])){
			$mime = is_array($mimes[$details->extension]) ? $mimes[$details->extension][0] : $mimes[$details->extension];
		}
		// Clean output buffer
		if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
			@ob_clean();
		}
		header('Content-Type: '.$mime);
		header('Content-Disposition: attachment; filename="'.$details->name.'"');
		header('Expires: 0');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.$details->filesizeinbytes);
		header('Cache-Control: private, no-transform, no-store, must-revalidate');
		// Flush data
		$outputfiledata = '';
		if ($details->location == 'filesystem') {
			$outputfiledata = read_file($details->file_dir);
		}
		else if($details->location == 'database'){
			$outputfiledata = base64_decode(stripslashes($details->file));
		}
		print($outputfiledata);		
		exit;        
	}
	public function delete($recId){
		$table = 'attachments';
		$refererpage = reffererpage();
		$requestingUrl = 'Dashboard';
		if ($refererpage != '') {
			$requestingUrl = $refererpage;
		}

		if (deletedbtablerecord($table, $recId)) {
			setflashnotifacation('message', array('icon'=>'delete', 'alert'=>'Attachment deleted successfully'));
			preredirect($requestingUrl);
		}
		else{
			setflashnotifacation('error', array('icon'=>'error_outline', 'alert'=>'Attachment delete error')); 
			preredirect($requestingUrl);              
		}
	}
	public function ajaxremoveattachment($attId){
		if ($this->clsUpld->deleteattachment($attId)) {
			echo "1";  
		}
		else{
			echo "0";  
		}
	}
	function outputmainimage($entity='systemlogo', $entityid='1'){
		$table = 'attachments';
		$params = array();
		$params['where']['equalto'] = array('entity'=>$entity, 'record'=>$entityid, 'isimage'=>'1', 'ismainimage'=>'1');
		$images = dbtablerecords($table, $params, FALSE, TRUE);
		if ($entity != 'systemlogo' && $entity != 'users') {
			isloggedin(TRUE);
		}
		if ($images != FALSE && is_array($images) && sizeof($images) > 0) {
			$image = $images[0];			
			$outputfiledata = '';
			if ($image->location == 'filesystem') {
				$outputfiledata = file_get_contents($image->file_dir);
			}
			else if($image->location == 'database'){
				$outputfiledata = base64_decode(stripslashes($image->file));
			}
			// Clean output buffer
			if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
				@ob_clean();
			}
			header("Cache-Control: private, no-transform, no-store, must-revalidate");
			header('Content-Description: File Transfer');			
			header('Content-Length: ' .$image->filesizeinbytes);
			header("Content-type: ".$image->type."");
			print $outputfiledata;
		}
		else{
			if ($entity=='systemlogo') {
				$defaultlogo = read_file('./catalog/images/logo.png');
				if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
					@ob_clean();
				}
				header("Cache-Control: private, no-transform, no-store, must-revalidate");
				header('Content-Description: File Transfer');
				header("Content-type: image/png");
				header("Expires: 0");
				print $defaultlogo;
			}
			else{
				$defaultimg = read_file('./catalog/system/imageplaceholder.svg');
				if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
					@ob_clean();
				}
				header("Cache-Control: private, no-transform, no-store, must-revalidate");
				header('Content-Description: File Transfer');
				header("Content-type: image/svg+xml");
				header("Expires: 0");
				print $defaultimg;
				
			}
		}
		exit;
	}

	function outputimage($attId='0'){
		isloggedin(TRUE);
		$table = 'attachments';
		$image = dbtablerecord($attId, $table);
		if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
				@ob_clean();
		}
		if ($image != FALSE) {
			header("Cache-Control: private, no-transform, no-store, must-revalidate");
			header('Content-Description: File Transfer');
			header("Content-type: ".$image->type."");
			header("Expires: 0");
			header("Pragma: public");
			$outputfiledata = '';
			if ($image->location == 'filesystem') {
				$image->file_dir = str_replace(DIRECTORY_SEPARATOR, '/', $image->file_dir);
				$outputfiledata = read_file($image->file_dir);
			}
			else if($image->location == 'database'){
				$outputfiledata = base64_decode(stripslashes($image->file));
			}

			print($outputfiledata);
		}
		else{
			$defaultimg = read_file('./catalog/system/imageplaceholder.svg');
			header("Cache-Control: private, no-transform, no-store, must-revalidate");
			header('Content-Description: File Transfer');
			header("Content-type: image/svg+xml");
			header("Expires: 0");
			print stripslashes($defaultimg);
		} 
	}

	function outputcountryflag($id='116'){
		$table = 'countries';
		$image = dbtablerecord($id, $table);
		if (ob_get_level() !== 0 && @ob_end_clean() === FALSE){
				@ob_clean();
		}
		if ($image != FALSE) {
			header("Cache-Control: private, no-transform, no-store, must-revalidate");
			header('Content-Description: File Transfer');
			header("Content-type: image/svg+xml");
			header("Expires: 0");
			header("Pragma: public");
			echo stripslashes($image->flag_svg);
		}
		else{
			$defaultimg = read_file('./catalog/images/defaultimage.png');
			header("Cache-Control: private, no-transform, no-store, must-revalidate");
			header('Content-Description: File Transfer');
			header("Content-type: image/png");
			header("Expires: 0");
			header("Pragma: public");
			echo $defaultimg;
		} 
	}

	function mdbg(){
		$returnData ='<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1000 500">
						<defs>
							<linearGradient id="mdsvgdropshadow" gradientTransform="rotate(39.5)">
								<stop offset="67%"  stop-color="#000000" stop-opacity="1"/>
								<stop offset="75%" stop-color="rgba(0,0,0,0)" stop-opacity="1"/>
							</linearGradient>
						</defs>

						<polygon class="primaryDark" fill="#00838f" points="700,0 1000,0 1000,500 200,500 700,0" style="fill: '.getcolor(1).'"/>
						<polygon class="accentShadow"  points="700,0 800,0 300,500 200,500 700,0" fill="url(#mdsvgdropshadow)"/>
						<polygon class="accent"  fill="#ff0000" points="550,0 750,0 250,500 50,500 550,0" style="fill: #424242"/>
						<polygon class="grey" fill="'.getcolor(2).'" points="0,0 200,0 1000,500 0,500 0,0"/>
						<polygon class="primaryShadow" points="550,0 650,0 150,500 50,500 550,0"  fill="url(#mdsvgdropshadow)"/>
						<polygon class="primary" fill="#00bcd4" points="0,0 600,0 100,500 0,500 0,0" style="fill: '.getcolor(0).'"/>

					</svg>';
		header("Cache-Control: private, no-transform, no-store, must-revalidate");
		header('Content-Description: File Transfer');
		header("Content-type: image/svg+xml");
		header("Expires: 0");
		header("Pragma: public");
		echo $returnData;
	}	


}	