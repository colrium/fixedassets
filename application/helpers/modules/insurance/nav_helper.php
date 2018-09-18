<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

function modulenav(){
  $CI = & get_instance(); 
  $CI->load->helper('modules/modulesnav');

  $navData = '<ul class="collapsible flat-ui borderless" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder', 'spaced-text').' File</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.insurancefileMenu().'
                            '.systemmodulesdatabase('insurance').'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('add_circle', 'spaced-text').' Add Records</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.insuranceactionMenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('event', 'spaced-text').' Calendar</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.insuranceactionMenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.customreportsmenu('insurance').'
                          </div>
                        </div>
                    </li>

                    
                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            
                          </div>
                        </div>
                    </li>
            </ul>';
    return $navData;
 }


function insurancefileMenu(){
  $CI = & get_instance();
  $strOut = '<a href="#insuranceexcelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger '.getcolorclass(8).' padded-left">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';  
  return $strOut;
}

 

function insuranceactionMenu(){
    $CI = & get_instance();
    $strOut = '';
    if ($CI->userperms->userPerm('add') || $CI->ion_auth->is_admin()) {
      $strOut .= anchor(INSURANCE_PREFIX.'forms/FormHandler/saveUpdate/insurer/0', maticon('add_circle', 'spaced-text').' Add Insurer', 'class="main-link collection-item borderless full-width waves-effect waves-dark '.getcolorclass(8).' padded-left"');
      $strOut .= anchor(INSURANCE_PREFIX.'forms/FormHandler/saveUpdate/client/0', maticon('add_circle', 'spaced-text').' Add Client', 'class="main-link collection-item borderless full-width waves-effect waves-dark '.getcolorclass(8).' padded-left"');
      $strOut .= anchor(INSURANCE_PREFIX.'forms/FormHandler/saveUpdate/claim/0', maticon('add_circle', 'spaced-text').' Add Claim', 'class="main-link collection-item borderless full-width waves-effect waves-dark '.getcolorclass(8).' padded-left"');
      $strOut .= anchor(INSURANCE_PREFIX.'forms/FormHandler/saveUpdate/policy/0', maticon('add_circle', 'spaced-text').' Add Policy', 'class="main-link collection-item borderless full-width waves-effect waves-dark '.getcolorclass(8).' padded-left"');
      $strOut .= anchor(INSURANCE_PREFIX.'forms/FormHandler/saveUpdate/cover/0', maticon('add_circle', 'spaced-text').' Add Cover', 'class="main-link collection-item borderless full-width waves-effect waves-dark '.getcolorclass(8).' padded-left"');
    }
    $strOut .= anchor(INSURANCE_PREFIX.'calendar/Calendaring', maticon('event', 'spaced-text').' Calendar ', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');    
    $strOut .= anchor(INSURANCE_PREFIX.'reports/Reports', maticon('equalizer', 'spaced-text').' Reports ', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INSURANCE_PREFIX.'payments/Payments', maticon('equalizer', 'spaced-text').' Payments ', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INSURANCE_PREFIX.'recyclebin/Recyclebin', maticon('delete_sweep', 'spaced-text').' Recycle bin ', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');  
    
    return $strOut;
 }