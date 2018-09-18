<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userperms{

	public function __construct(){
    $this->load->model('data', 'clsData');
    $this->load->model('ion_auth_model', 'clsAuth');
	}


public function __get($var){
    return get_instance()->$var;
}

public function ispriveledged($priveledge, $module='fixedassets'){

}

public function userPerm($perm){
   $userCanAdd = false;
   $userCanEdit = false;
   $userCanDelete = false;
   $userCanCheckOut = false;
   $userCanCheckIn = false;
   $userCanDispose = false;
   $userCanReports = false;
   $userCanCreateReports = false;
   $allowed=false;
  if (isloggedin(FALSE)){
  $user = $this->ion_auth->user()->row(); 
  $this->load->model('mstart', 'clsStart');
          
          foreach ($this->clsStart->loaduserGroups($user->id) as $userGrp) {
            foreach ($this->clsStart->loadGroupPerm($userGrp->group_id) as $group) {
              if ($group->canAdd == 1) {
                $userCanAdd = true;
              }

              if ($group->canEdit == 1) {
                $userCanEdit = true;
              }

              if ($group->canDelete == 1) {
                $userCanDelete= true;
              }
              if ($group->canCheckOut == 1) {
                $userCanCheckOut= true;
              }
              if ($group->canCheckIn == 1) {
                $userCanCheckIn= true;
              }
              if ($group->canDispose == 1) {
                $userCanDispose= true;
              }
              if ($group->canViewReports == 1) {
                $userCanReports= true;
              }
              if ($group->canCreateReports == 1) {
                $userCanCreateReports= true;
              }

            }
          }
        if ($perm =="add") {
          $allowed=$userCanAdd;
        }
        elseif ($perm =="edit") {
          $allowed = $userCanEdit;
        }
        elseif ($perm =="checkout") {
          $allowed = $userCanCheckOut;
        }
        elseif ($perm =="checkin") {
          $allowed = $userCanCheckIn;
        }
        elseif ($perm =="dispose") {
          $allowed = $userCanDispose;
        }

        elseif ($perm =="reports") {
          $allowed = $userCanReports;
        }

        elseif ($perm =="createreports") {
          $allowed = $userCanCreateReports;
        }


        elseif ($perm =="delete") {
          $allowed = $userCanDelete;
        }

        return $allowed;
      }
  else{
    $allowed = false;
    return $allowed;
  }

}

public function markerchecker(){
  $authorised = false;
  $systemPrefs = $this->clsData->loadrecordfromtable('system_prefs', 'prefId', '1');

  if ($systemPrefs != false) {
    $markercheckered = false;    
    if ($systemPrefs->markerchecker == 1) {
      $markercheckered = true;
    }
    if ($markercheckered) {
      $markerid = $systemPrefs->marker;
      $checkerid = $systemPrefs->checker;
      $makerpassword = $this->input->post('makerpassword');
      $checkerpassword = $this->input->post('checkerpassword');

      $markersuccess = $this->clsAuth->hash_password_db($markerid, $makerpassword);
      $checkersuccess = $this->clsAuth->hash_password_db($checkerid, $checkerpassword);

      if ($markersuccess && $checkersuccess) {
        $authorised = true;
      }
      else{
        $authorised = false;
      }
      
    }
    else{
      $authorised = true;
    }
  }
  
  return $authorised;

}












}