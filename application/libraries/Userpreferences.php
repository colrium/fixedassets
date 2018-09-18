<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userpreferences{

	public function __construct(){
    $this->load->model(FIXEDASSETS_PREFIX.'prefs/mprefs','clsPrefs');
    $this->load->model(FIXEDASSETS_PREFIX.'notifacations/mnotifacations','clsNots');
    $this->load->library('fieldnames');
	}


public function __get($var){
    return get_instance()->$var;
  }

public function userPrefs($userId, $func){   
   $allowed = false;
   
   $prefs = $this->clsPrefs->loadPrefs($userId);
      foreach ($prefs as $pref) {
            if ($pref->enableNotifacations==1) {
              if ($func=="notifacations") {
                  $allowed = true;
                }
            }
            

            if ($pref->enableEmails==1) {
              if ($func=="emails") {
                  $allowed = true;
                }
            }
      }
  return $allowed;
}

public function isAlertDateAllowed($userId, $dateField){
   
   $allowed = false;
   
   $prefs = $this->clsPrefs->loadPrefs($userId);
      foreach ($prefs as $pref) {
            if ($pref->$dateField==1) {
                  $allowed = true;
            }

            else{
              $allowed = false;
            }
           
      }
  return $allowed;
}

public function gendesktopAlert($dateField, $userId){
  $days = $this->notifacationDays($userId);
  $records = $this->clsNots->assetNotifacations($days, $dateField);

  $fieldName = $this->fieldnames->getFieldName($dateField);
  if (sizeof($records)>0) {
    foreach ($records as $record) {
      $mainimage=$this->datalib->loadentitymainimage('fixedassets_assetlist', $record->assetID);
      if ($mainimage != false) {
        $image  = base_url().''.$mainimage->file_dir;

      }
      
      else{
          $image = base_url().'images/assets/'.$record->assetImage;
      }
      $alert = ' <script>
                                    if (!("Notification" in window)) {
                                        alert("Sorry!! This browser does not support desktop notification");
                                    }
                                    else if (Notification.permission === "granted") {

                                        var options = {
                                            body: "'.$fieldName.' requires your attention \n  \n '.$record->assetDesc.' \n '.$fieldName.' : '.$record->$dateField.'",
                                            icon: "'.$image.'",
                                            dir : "ltr"
                                        };

                                      var notification = new Notification("Asset # '.$record->assetCode.' ('.$record->assetItem.')",options);

                                        notification.onclick = function(){
                                         window.open("'.site_url(FIXEDASSETS_PREFIX.'forms/FormHandler/saveUpdateAsset/'.$record->assetID).'"); 
                                        };
                                    }

                                  // Note, Chrome does not implement the permission static property
                                  // So we have to check for NOT "denied" instead of "default"
                                  else if (Notification.permission !== "denied") {
                                    Notification.requestPermission(function (permission) {
                                          // Whatever the user answers, we make sure we store the information
                                          if (!("permission" in Notification)) {
                                              Notification.permission = permission;
                                          }

                                      // If the user is okay, lets create a notification
                                      if (permission === "granted") {
                                          var options = {
                                              body: "'.$fieldName.' requires your attention \n  \n '.$record->assetDesc.' \n '.$fieldName.' : '.$record->$dateField.'",
                                              icon: "'.$image.'",
                                              dir : "ltr"
                                          };
                                      var notification = new Notification("Asset # '.$record->assetCode.' ('.$record->assetItem.')",options);
                                      notification.onclick = function(){
                                         window.open("'.site_url(FIXEDASSETS_PREFIX.'forms/FormHandler/saveUpdateAsset/'.$record->assetID).'"); 
                                        };
                                      }
                                    });
                                }



          </script>';
    }
    $noOfAssets = sizeof($records);
    
  }
  else{
    $alert = '';
  }
  
  return $alert;
}
public function notifacationDays($userId){
   $days = 0;

   $prefs = $this->clsPrefs->loadPrefs($userId);
      foreach ($prefs as $pref) {
            $days=$pref->daysToalert;
      }
  return $days;
}

public function prefEmail($userId){
  $email = "";

   $prefs = $this->clsPrefs->loadPrefs($userId);
      foreach ($prefs as $pref) {
            $email=$pref->prefEmail;
      }
  return $email;
}

public function prefDteFormat($userId){
  $format = "Y-M-d";

   $prefs = $this->clsPrefs->loadPrefs($userId);
      foreach ($prefs as $pref) {
            $format=$pref->dteFormat;
      }
  return $format;
}








}