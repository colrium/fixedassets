<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/


class System extends CI_Controller {
	public $displayData;



	function __construct(){
		parent::__construct();
		isloggedin(TRUE);
		isdebugger(TRUE);
		$this->load->helper('file');
		$this->displayData = array();
		$this->displayData['module'] = 'system';
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($this->displayData['module']);
		$this->displayData['entitiesicons'] = dbmoduletableicons($this->displayData['module']);
		$this->displayData['entitiesnames'] = dbmoduletablenames($this->displayData['module']);
	}

	function preferences($module='system'){
		$table = 'preferences';
		$preferences = modulepreferences($module);
		$modules = $this->config->item('fortmodules');
		
		if ($module != 'system' && !array_key_exists($module, $modules)) {
			$module = 'system';
		}
		$modulename = modulename($module);

		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);

		if (sizeof($postedData)>0) {
			
			$params = array();
			$params['where']['equalto'] = array('module' => $module);
			$records = dbtablerecords($table, $params);
			$recId = $records[0]->id;
			$curpreferences = json_decode($records[0]->preferences);
			$curpreferences = objecttoarrayrecursivecast($curpreferences);
			$savepreferences = array_merge($curpreferences, $postedData);
			$savearr = array('module'=>$module, 'preferences'=>json_encode($savepreferences));
			$newrecId = addupdatedbtablerecord($table, $savearr, $recId, FALSE, FALSE);
			if (!array_key_exists('strerror', $this->displayData)) {
				setflashnotifacation('message', array('icon'=>'save', 'alert'=>'Changes Saved')); 
				preredirect('preferences/System/preferences/'.$module, 'refresh');
			}
		}
		
		$this->displayData['title']        = $modulename.' Preferences';
		$this->displayData['preferences']  = $preferences;
		$this->displayData['pageTitle']    = breadcrumb($modulename.' Preferences');
		$this->displayData['module'] = $module;
		$this->displayData['modulename'] = $modulename;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($this->displayData['module']);
		$this->displayData['entitiesicons'] = dbmoduletableicons($this->displayData['module']);
		$this->displayData['entitiesnames'] = dbmoduletablenames($this->displayData['module']);
		$this->displayData['mainTemplate'] = 'preferences/preferences';

		renderpage($this->displayData);  
				 
	}

	function priveledges(){
		$this->displayData['title']        = 'Priveledges';
		$this->displayData['pageTitle']    = ''.CENUM_CHIP_POINTER.''.breadcrumb('System Priveledges');
		$this->displayData['mainTemplate'] = 'preferences/priveledges';		      
		renderpage($this->displayData);
		
	}


	function addedditpriveledge($module, $recId){
		$this->load->config('ion_auth', TRUE);
		$tables  = $this->config->item('tables', 'ion_auth');
		$modules  = $this->config->item('fortmodules');
		$table = $tables['priveledges'];
		
		

		$refererpage = reffererpage();
		if ($refererpage == '') {
			$refererpage = 'preferences/System/priveledges';
		}

		if ($recId > 0) {
			if (!dbtablerecordexists($recId, $table)) {
				setflashnotifacation('error', maticon('folder_open', 'medium').' <br> Sorry! That priveledge does not exist'); 
				preredirect($refererpage, 'refresh');
			}
		}
		if (!array_key_exists($module, $modules)) {
			setflashnotifacation('error', maticon('folder_open', 'medium').' <br> Sorry! That Module does not exist'); 
			preredirect($refererpage, 'refresh');
		}

		
		$this->displayData['recId']        = $recId;

		if ($recId == 0) {
			$this->displayData['title']        = 'Add Priveledge';
			$this->displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Add Priveledge');
			$this->displayData['details'] = array();
		}
		else {
			$this->displayData['title']        = 'Edit Priveledge';
			$this->displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Edit Priveledge');
			$this->displayData['details'] = dbtablerecord($recId, $table);	    	
		}
		$this->displayData['module'] = $module;
		$this->displayData['tables'] = dbmoduletables($module);

		$this->displayData['priveledgestable'] = $table;



		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData)>0) {
			if (dbfieldsformvalidation($table)) {
				$savearr = array();
				foreach ($postedData as $key => $value) {
					$savearr[$key] = $value;
				}


				$newrecId = addupdatedbtablerecord($table, $savearr, $recId);
				if ($newrecId != FALSE) {
					setflashnotifacation('message', maticon('save', 'medium').' <br> Priveledge Saved successfully');
					preredirect('preferences/System/addedditpriveledge/'.$module.'/'.$newrecId, 'refresh');
				}
				else{
					$this->displayData['strerror']  = maticon('error', 'medium').' <br> Priveledge Save Error';
				}
			}				
		}

		$this->displayData['mainTemplate'] = 'preferences/addedditpriveledge';    
		renderpage($this->displayData);
		
	}

	function tablefields($table){
		$fields = dbtablefields($table);
		$returnData = '<select name="datacolumn" class="full-width " id="datacolumn">';
			if (is_array($fields)) {				
					foreach ($fields as $key => $value) {
						$returnData .= '<option value="'.$value->initialName.'">'.$value->setName.'</option>';
					}				
			}
			else{
				$returnData .= '<option value="-1">No Existing Records</option>';
			}
		$returnData .= '</select>';	
		echo $returnData;		
		
	}

	function priveledgename($module, $table){
		$this->load->config('ion_auth', TRUE);
		$tables  = $this->config->item('tables', 'ion_auth');
		$modules  = $this->config->item('fortmodules');
		$priveledsgetable = $tables['priveledges'];
		$modulespriveledgenames  = $this->config->item('modulesdbtables');
		$name = $table;
		$idname = dbmoduletablename($table);

		$returnData = mdldivstrt('row');
			$returnData .= mdldivstrt('col s12');
				$returnData .=  mdldivstrt('input-field full-width');
					$returnData .= '<input value="'.$idname.'" id="identityname" type="text" name="identityname">
									<label for="identityname" class="active">'.dbfieldsetname('identityname', $priveledsgetable).'</label>';
				$returnData .= mdldivend();
			$returnData .= mdldivend();

			$returnData .= mdldivstrt('col s12');
				$returnData .=  mdldivstrt('input-field full-width');
					$returnData .= '<input value="'.$name.'" id="priveledgename" type="text" name="name" readonly="readonly">
							<label for="priveledgename" class="active">name</label>';
				$returnData .= mdldivend();
			$returnData .= mdldivend();

		$returnData .= mdldivend();
		echo $returnData;		
	}


	function inputpreferences($module='system'){
		$modules  = $this->config->item('fortmodules');
		$this->displayData['title']        = 'Input Fields';
		$this->displayData['pageTitle']    = breadcrumb('Input Fields');
		$this->displayData['module'] = $module;
		$this->displayData['fields'] = array();
		if ($module=='system' || array_key_exists($module, $modules)) {
			$this->displayData['tables'] = dbmoduletables($module);
			//check if any data has been posted
			$postedData = $this->input->post(NULL, FALSE);
			if (sizeof($postedData)>0) {
				if (updateinputfields($module)) {
					setflashnotifacation('message', array('icon'=>'color_lens', 'alert'=>'Input Settings updated successfully.'));
					preredirect('preferences/System/inputpreferences/'.$module);
				}
				else{
					setflashnotifacation('error', array('icon'=>'color_lens', 'alert'=>'Input Settings Update failed.'));
					preredirect('preferences/System/inputpreferences/'.$module);
				}			
			}
		}			

		$this->displayData['mainTemplate'] = 'preferences/inputfields';
		$this->displayData['module'] = $module;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module); 
		renderpage($this->displayData);
	}

	function refreshfieldnames($module='system'){
		$refreshed = dbrefreshfieldnames($module);
		if ($refreshed) {
			setflashnotifacation('message', array('icon'=>'build', 'alert'=>'Input Fields Refreshed successfully.'));
			preredirect('preferences/System/inputpreferences/'.$module);
		}
		else{
			setflashnotifacation('error', array('icon'=>'build', 'alert'=>'Input Fields Refresh failed.'));
			preredirect('preferences/System/inputpreferences/'.$module);
		}
	}



	function modulepreferences($module='system'){
		$modules = $this->config->item('fortmodules');
		$modulename = 'System';
		if (array_key_exists($module, $modules)) {
			$modulename = $modules[$module];
		}
		else{
			$module='system';
		}

		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData) > 0) {
						
		}
		print_r(modulepreferences($module));
		echo $module;

		$this->displayData['title']  = $modulename.' Preferences';
		$this->displayData['pageTitle'] = breadcrumb($modulename.' Preferences');
		$this->displayData['modulename'] = $modulename;
		$this->displayData['preferences'] = modulepreferences($module);
		$this->displayData['module'] = $module;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		

		$this->displayData['mainTemplate'] = 'preferences/modulepreferences'; 
		renderpage($this->displayData);
	}

	function tablepreferences($module='system'){
		$modules  = $this->config->item('fortmodules');
		$this->displayData['title']        = 'Table Preferences';
		$this->displayData['pageTitle']    = breadcrumb('Table Preferences');
		$this->displayData['module'] = $module;
		$this->displayData['fields'] = array();
		if ($module=='system' || array_key_exists($module, $modules)) {
			$this->displayData['tables'] = dbmoduletables($module);
		}
		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData) > 0) {
					
		}
		$this->displayData['module'] = $module;
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		$this->displayData['mainTemplate'] = 'preferences/tablepreferences'; 
		renderpage($this->displayData);
	}



	public function colorscheme(){
		$this->config->load('colors');
		if ($this->ion_auth->is_debugger()){
			$this->displayData['title']        = 'Color Scheme';
			$this->displayData['pageTitle']    = ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Color Scheme');

			//check if any data has been posted
			$posteddata = $this->input->post(NULL, FALSE);
			//if data has been posted
			if (sizeof($posteddata) > 0) {
				$primary_color_class = $this->input->post('primary_color_class');
				$primary_dark_color_class = $this->input->post('primary_dark_color_class');
				$accent_color_class = $this->input->post('accent_color_class');
				$highlight_color_class = $this->input->post('highlight_color_class');
				$text_color_class = $this->input->post('text_color_class');
				$inverse_text_color_class = $this->input->post('inverse_text_color_class');
				$submit_btn_color_class = $this->input->post('submit_btn_color_class');
				$action_btn_color_class = $this->input->post('action_btn_color_class');
				$link_text_color_class = $this->input->post('link_text_color_class');
				$table_head_bg_color_class = $this->input->post('table_head_bg_color_class');
				


				
				$data 			= read_file('./application/config/colors.php');
				//replace primary color class 
				$data 			= str_replace('$config["primary_color_class"] = "'.getcolorclass(0).'";',		'$config["primary_color_class"] = "'.$primary_color_class.'";',		$data);

				//replace primary color
				$data 			= str_replace('$config["primary_color"] = "'.getcolor(0).'";',		'$config["primary_color"] = "'.allcolorclasses($primary_color_class).'";',		$data);

				//replace primary color rgb
				$data 			= str_replace('$config["primary_color_rgb"] = "'.getcolor(6).'";',		'$config["primary_color_rgb"] = "'.hextorgb(getcolor(0)).'";',		$data);

				//replace primary dark color class
				$data 			= str_replace('$config["primary_dark_color_class"] = "'.getcolorclass(1).'";',		'$config["primary_dark_color_class"] = "'.$primary_dark_color_class.'";',		$data);

				//replace primary dark color
				$data 			= str_replace('$config["primary_dark_color"] = "'.getcolor(1).'";',		'$config["primary_dark_color"] = "'.allcolorclasses($primary_dark_color_class).'";',		$data);

				//replace accent color class
				$data 			= str_replace('$config["accent_color_class"] = "'.getcolorclass(2).'";',		'$config["accent_color_class"] = "'.$accent_color_class.'";',		$data);

				//replace accent color
				$data 			= str_replace('$config["accent_color"] = "'.getcolor(2).'";',		'$config["accent_color"] = "'.allcolorclasses($accent_color_class).'";',		$data);

				//replace highlight color class
				$data 			= str_replace('$config["highlight_color_class"] = "'.getcolorclass(3).'";',		'$config["highlight_color_class"] = "'.$highlight_color_class.'";',		$data);

				//replace highlight color
				$data 			= str_replace('$config["highlight_color"] = "'.getcolor(3).'";',		'$config["highlight_color"] = "'.allcolorclasses($highlight_color_class).'";',		$data);

				//replace submit btn color class
				$data 			= str_replace('$config["submit_btn_color_class"] = "'.getcolorclass(6).'";',		'$config["submit_btn_color_class"] = "'.$submit_btn_color_class.'";',		$data);

				//replace action btn color class
				$data 			= str_replace('$config["action_btn_color_class"] = "'.getcolorclass(7).'";',		'$config["action_btn_color_class"] = "'.$action_btn_color_class.'";',		$data);
				$data 			= str_replace('$config["action_btn_color"] = "'.getcolor(7).'";',		'$config["action_btn_color"] = "'.allcolorclasses($action_btn_color_class).'";',		$data);

				//replace table header bg color class
				$data 			= str_replace('$config["table_head_bg_color_class"] = "'.getcolorclass(9).'";',		'$config["table_head_bg_color_class"] = "'.$table_head_bg_color_class.'";',		$data);

				//replace link text color class
				$link_text_color_class = trim($link_text_color_class);
				$spacedlinkcolorclass = strpos($link_text_color_class, ' ');
				if ($spacedlinkcolorclass != FALSE) {
					$link_text_color_class = str_replace(' ', '-text text-', $link_text_color_class);
				}
				else{
					$link_text_color_class = $link_text_color_class.'-text';
				}
				$data 			= str_replace('$config["link_text_color_class"] = "'.getcolorclass(8).'";',		'$config["link_text_color_class"] = "'.$link_text_color_class.'";',		$data);


				//replace primary text color class
				$primary_text_color_class = trim($primary_color_class);
				$spacedprimarytxtcolorclass = strpos($primary_text_color_class, ' ');
				if ($spacedprimarytxtcolorclass != FALSE) {
					$primary_text_color_class = str_replace(' ', '-text text-', $primary_text_color_class);
				}
				else{
					$primary_text_color_class = $primary_text_color_class.'-text';
				}
				
				$data 			= str_replace('$config["primary_color_text_class"] = "'.getcolorclass(10).'";',		'$config["primary_color_text_class"] = "'.$primary_text_color_class.'";',		$data);


				//write changes and redirect				
				if (write_file('./application/config/colors.php', $data)) {
					setflashnotifacation('message', array('icon'=>'color_lens', 'alert'=>'User Interface Settings updated successfully.'));
					preredirect('preferences/System/colorscheme');
				}
				else{
					setflashnotifacation('error', array('icon'=>'error', 'alert'=>'User Interface Settings Update failed.'));
					preredirect('preferences/System/colorscheme');
				}

					
			}
			else{
				$this->displayData['mainTemplate'] = 'preferences/colorscheme';
				$this->displayData['nav'] = $this->mnav_brain_jar->navData('modules');		      
				renderpage($this->displayData);
				
			}
				
		}
		else{
			$details =array('background-color' => ' red darken-3', 'breadcrumb' => ' '.CENUM_CHIP_POINTER.' '.breadcrumb('Colors').' '.CENUM_CHIP_POINTER.' '.breadcrumb('Access Error'));
			showsystemerror(1, $details);
		 }
			
	}
	function addinputfield($module='system'){
		$modules = $this->config->item('fortmodules');
		$modulesicons = $this->config->item('fortmodulesicons');
		$moduleicon = 'public';
		$modulename = 'System';

		if (array_key_exists($module, $modules)) {
			$moduleicon = $modulesicons[$module];
			$modulename = $modules[$module];
		}
		else{
			$module = 'system';
		}
		//check if any data has been posted
		$postedData = $this->input->post(NULL, FALSE);
		if (sizeof($postedData) > 0) {
			
			
		}


		$this->displayData['title']        = 'Add Input Field';
		$this->displayData['pageTitle']    = breadcrumb('Add Input Field');
		$this->displayData['modulename'] = $modulename;
		$this->displayData['moduleicon'] = $moduleicon;
		$this->displayData['module'] = $module;
		$this->displayData['entities'] = dbmoduletablenames($module);
		$this->displayData['nav'] = $this->mnav_brain_jar->navData($module);
		$this->displayData['mainTemplate'] = 'preferences/addinputfield'; 
		renderpage($this->displayData);
	}

	function test2(){
		$this->load->library(COMMUNICATION_PREFIX.'emailing');
		$this->emailing->imap_init('imap.gmail.com', 'colrium@gmail.com', 'panda**99', 993, true);
		$this->emailing->imap_connect();
		$mailboxes = $this->emailing->imap_getMailboxes();
		$this->emailing->imap_setActiveMailbox('INBOX');
		$emails = $this->emailing->imap_getEmails();
		print_r($emails);
	}

















}