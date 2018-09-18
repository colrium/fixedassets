<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

function modulenav(){
	$CI = & get_instance(); 
	$CI->load->helper('modules/modulesnav');
	$user = $CI->ion_auth->user()->row();
    $navData ='';
    $navData .= '                
                <ul class="collapsible flat-ui borderless" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder', 'spaced-text').' File</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.trackerfilesubmenu().'
                            '.systemmodulesdatabase('tracker').'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('add_circle', 'spaced-text').' Add New</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.trackeractionsubmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.trackerreportssubmenu().'
                            '.customreportsmenu('tracker').'
                          </div>
                        </div>
                    </li>

                   

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.trackerpreferencessubmenu().'
                          </div>
                        </div>
                    </li>
            </ul>

            ';
    $navData .= '';
    return($navData);
 }


function trackerfilesubmenu(){
	$CI = & get_instance();
    $strOut = '';    
    $strOut .= '<a href="#excelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger padded-left">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
    return $strOut;
}

function trackeractionsubmenu(){
	$CI = & get_instance();
  $fields = dbmoduletablenames('tracker');
    $strOut = '';
    if (haspriveledge('add', 'tracker')) {
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/checkpoint/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_checkpoints'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/checkpointstatus/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_checkpointstatuses'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/device/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_devices'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/targetbatch/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_targetbatches'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/targetclass/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_targetclasses'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/target/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_targets'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'forms/Formhandler/track/0', maticon('add_circle', 'spaced-text').' New '.$fields['tracker_tracks'], 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
    }

      

      
      return($strOut);
 }


function trackerreportssubmenu(){
	$CI = & get_instance();
    $strOut = '';
    if (haspriveledge('reports', 'assistant')) {
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/listOfAssets', 'List Of Assets', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/listOfAssets', 'List Of Assets (Scanner)', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/listOfAssetsFinancial', 'List Of Assets (Financial)', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/assetsGroupBy', 'Assets Grouped By', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/checkedOutAssets', 'Checkedout Assets', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/betweenDates', 'Report Between Dates', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/depreciation', 'Depreciation', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/genReport/purchases', 'Purchases', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
     
    }
      return($strOut);
 }


function trackerpreferencessubmenu(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor('preferences/User/preferences/tracker', maticon('settings','spaced-text').' My Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
    
    if (isadmin(FALSE)) {
            $strOut .= anchor('preferences/System/tablepreferences/tracker', maticon('settings','spaced-text').' System Table Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
            $strOut .= anchor('Preferences/System/inputpreferences/tracker', maticon('build', 'spaced-text').' Input Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
      }
   
   return($strOut);
}


function trackercustomreportssubmenu(){
	$CI = & get_instance();

    if (isloggedin(FALSE)) {
      $strOut = '';
      if (haspriveledge('customreports', 'tracker')) {
        $strOut .= anchor(TRACKER_PREFIX.'reports/Createreport/createeditreport/0', maticon('add', 'spaced-text').' New Report Wizard..', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
        $strOut .= anchor(TRACKER_PREFIX.'reports/Reports/mycustomreports', maticon('list', 'spaced-text').'Directory', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      }
    }
    else{
      $strOut = '';
    }

    return $strOut;
    
 }