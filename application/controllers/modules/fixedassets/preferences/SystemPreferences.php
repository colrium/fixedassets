<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SystemPreferences extends CI_Controller {

  function __construct(){
      parent::__construct();
      $this->load->model(FIXEDASSETS_PREFIX.'assets/massets','clsAssets');
      $this->load->model(FIXEDASSETS_PREFIX.'prefs/mprefs','clsPrefs');
      $this->load->model(FIXEDASSETS_PREFIX.'functions/mfunctions','clsFunc');
      $displayData = array();   
      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
    }


    public function sysPreference(){
      if (!$this->ion_auth->is_admin()) {
            setflashnotifacation('error', 'Sorry! You Dont have the Rights to View or Edit System Preferences'); 
            preredirect(FIXEDASSETS_PREFIX.'Dashboard');
      }
      else{
            $displayData['title']        = 'System Preferences';
            $displayData['prefs']        = $this->clsPrefs->loadSysPrefs();
            $displayData['pageTitle']    = ' '.breadcrumb(' System Preferences');
            $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'prefs/sysprefs';
            $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
            $displayData['module'] = 'fixedassets';
            renderpage($displayData);
            
      }
    }



    public function saveSysPrefs(){
      if ($this->clsPrefs->saveSysPrefs()) {
        setflashnotifacation('message', maticon('save','medium').' <br> System Prefences Saved Successfully'); 
        preredirect(FIXEDASSETS_PREFIX.'preferences/Systempreferences/sysPreference');
      }

      else{
        setflashnotifacation('error', maticon('block', 'medium').'<br>System Prefences Not Saved'); 
        preredirect(FIXEDASSETS_PREFIX.'preferences/Systempreferences/sysPreference');
      }

    }

    public function fieldNames(){
      if (!$this->ion_auth->is_admin()) {
            setflashnotifacation('error', maticon('block', 'medium').'<br>Sorry! You Dont have the Rights to View or Edit System Fields'); 
            preredirect(FIXEDASSETS_PREFIX.'Dashboard');
      }
      else{
            $displayData['title']        = 'System Fields';
            $displayData['fields']        = $this->clsPrefs->loadSysFields();
            $displayData['pageTitle']    = ' '.breadcrumb('System Fields');
            $displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'prefs/sysfields';
            $displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
            $displayData['module'] = 'fixedassets';
            renderpage($displayData);
            
      }
    }

    public function saveFldForm(){
      if ($this->clsPrefs->saveFldForm()) {
        setflashnotifacation('message', maticon('settings', 'medium').'<br>Fields Updated'); 
        preredirect(FIXEDASSETS_PREFIX.'preferences/Systempreferences/fieldNames');
      }
      else{
        setflashnotifacation('error', maticon('block', 'medium').'<br>Fields Not Updated'); 
        preredirect(FIXEDASSETS_PREFIX.'preferences/Systempreferences/fieldNames');
      }

    }


}