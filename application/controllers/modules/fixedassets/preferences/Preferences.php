<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Preferences extends CI_Controller {
  public $displayData;

  function __construct(){
      parent::__construct();
      isloggedin(TRUE);

      $this->displayData = array();
      $this->displayData['nav'] = $this->mnav_brain_jar->navData('fixedassets');
      $this->displayData['module'] = 'fixedassets';

    }


    public function userpreferences($userid=FALSE){
      if ($userid==FALSE) {
        $userid = USERID;
      }
      
      $params = array();
      $params['where']['equalto'] = array('user'=>$userid);
      $userpreferences = dbtablerecords('fixedassets_userpreferences', $params, FALSE, FALSE);
      if ($userpreferences==FALSE) {
        addupdatedbtablerecord('fixedassets_userpreferences', array('user'=>$userid), 0);
        $userpreferences = dbtablerecords('fixedassets_userpreferences', $params, FALSE, FALSE);
      }
      
      $userpreferences = $userpreferences[0];

      //check if any data has been posted
      $postdata = $this->input->post(NULL, FALSE);
      if (sizeof($postdata)>0) {
        //create data validation
        if (dbfieldsformvalidation('fixedassets_userpreferences', 1) != FALSE) {
          if (addupdatedbtablerecord('fixedassets_userpreferences', $postdata, $userpreferences->id)) {
            setflashnotifacation('message', maticon('thumb_up', 'spaced-text').'</br> Preferences Updated');           
          }
          else{
            setflashnotifacation('error', maticon('error', 'spaced-text').'</br> Preferences Update Error');
          }
          preredirect(FIXEDASSETS_PREFIX.'preferences/Preferences/userpreferences/'.$userid, 'refresh');
        }
      }

    	$this->displayData['title']        = 'User Preferences';
	    $this->displayData['details']  = $userpreferences;
      $this->displayData['datefields']  = $this->fieldnames->getdateFields('fixedassets_assetlist');
      $this->displayData['userid']    = $userid;
      $this->displayData['recId']    = $userid;
      $this->displayData['pageTitle']    = ' '.breadcrumb('User Preferences');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'preferences/userpreferences';
      renderpage($this->displayData);
      
    }

    public function preferences(){
      isadmin(TRUE);
      $params = array();
      $params['where']['equalto'] = array('id'=>1);
      $preferences = dbtablerecords('fixedassets_preferences', $params, FALSE, FALSE);
      if ($preferences==FALSE) {
        addupdatedbtablerecord('fixedassets_preferences', array('id'=>1), 0);
        $preferences = dbtablerecords('fixedassets_preferences', $params, FALSE, FALSE);
      }
      $preferences = $preferences[0];

      //check if any data has been posted
      $postdata = $this->input->post(NULL, FALSE);
      if (sizeof($postdata)>0) {
        //create data validation
        if (dbfieldsformvalidation('fixedassets_preferences', 1) != FALSE) {
          if (addupdatedbtablerecord('fixedassets_preferences', $postdata, 1)) {
            setflashnotifacation('message', maticon('thumb_up', 'spaced-text').'</br> Preferences Updated');           
          }
          else{
            setflashnotifacation('error', maticon('error', 'spaced-text').'</br> Preferences Update Error');
          }
          preredirect(FIXEDASSETS_PREFIX.'preferences/Preferences/preferences', 'refresh');
        }
      }


      $this->displayData['title']        = 'System Preferences';
      $this->displayData['details']  = $preferences;
      $this->displayData['pageTitle']    = ' '.breadcrumb('Fixed Assets Preferences');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'preferences/preferences';
      renderpage($this->displayData);


    }


    public function inputpreferences(){
      $this->load->model('utilities/mdbdata', 'clsDBData');
      isadmin(TRUE);
      $table = 'fixedassets_assetlist';

      //check if any data has been posted
      $postdata = $this->input->post(NULL, FALSE);
      if (sizeof($postdata)>0) {
        
        if ($this->clsDBData->savefieldnames('fixedassets')) {
          preredirect(FIXEDASSETS_PREFIX.'preferences/Preferences/inputpreferences', 'refresh');
        }


      }
      $this->displayData['title']        = 'System Fields';
      $this->displayData['fields']        = dbtablefields($table);
      $this->displayData['pageTitle']    = ' '.breadcrumb('System Fields');
      $this->displayData['mainTemplate'] = FIXEDASSETS_PREFIX.'preferences/inputpreferences';
      renderpage($this->displayData);
            

    }




    






}