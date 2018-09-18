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
                            '.chamafileMenu().'
                            '.systemmodulesdatabase('chama').'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('add_circle', 'spaced-text').' Add New</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.chamaactionMenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.chamareportMenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Custom Reports</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.chamacustomReports().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.chamaprefMenu().'
                          </div>
                        </div>
                    </li>
            </ul>

            ';
    $navData .= '';
    return($navData);
 }


function chamafileMenu(){
	$CI = & get_instance();
    $strOut = '';    
    $strOut .= '<a href="#excelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger padded-left">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
    return $strOut;
}

function chamaactionMenu(){
	$CI = & get_instance();
    $strOut = '';
    if (haspriveledge('add', 'chama')) {
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/saveUpdateAsset/0', maticon('add_circle', 'spaced-text').' Add Items', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/employeelist/0', maticon('person_add', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist','assignedTo'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_categories/0', maticon('star', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetCat'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_statuses/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetStatus'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_manufacturers/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetMnfctr'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_dealers/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetDealer'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_brands/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetBrand'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_sections/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetSctn'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_primaryloc/0', maticon('add_location', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetPrimLoc'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'forms/FormHandler/addeditsecondaryrecord/chama_secondaryloc/0', maticon('folder', 'spaced-text').' Add '.dbfieldsetname('chama_assetlist', 'assetSecLoc'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
    }

      

      
      return($strOut);
 }


function chamareportMenu(){
	$CI = & get_instance();
    $strOut = '';
    if (haspriveledge('reports', 'chama')) {
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/listOfAssets', 'List Of Assets', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/listOfAssets', 'List Of Assets (Scanner)', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/listOfAssetsFinancial', 'List Of Assets (Financial)', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/assetsGroupBy', 'Assets Grouped By', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/checkedOutAssets', 'Checkedout Assets', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/betweenDates', 'Report Between Dates', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/depreciation', 'Depreciation', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/genReport/purchases', 'Purchases', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
     
    }
      return($strOut);
 }


function chamaprefMenu(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor('preferences/User/preferences/chama', maticon('settings','spaced-text').' My Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
    
    if (isadmin(FALSE)) {
            $strOut .= anchor('preferences/System/tablepreferences/chama', maticon('settings','spaced-text').' System Table Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
            $strOut .= anchor('Preferences/System/inputpreferences/chama', maticon('build', 'spaced-text').' Input Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
      }
   
   return($strOut);
}


function chamacustomReports(){
	$CI = & get_instance();

    if (isloggedin(FALSE)) {
      $strOut = '';
      if (haspriveledge('customreports', 'chama')) {
        $strOut .= anchor(CHAMA_PREFIX.'reports/Createreport/createeditreport/0', maticon('add', 'spaced-text').' New Report Wizard..', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
        $strOut .= anchor(CHAMA_PREFIX.'reports/Reports/mycustomreports', maticon('list', 'spaced-text').'Directory', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      }
      
      
 
        
    }
    else{
      $strOut = '';
    }

    return $strOut;
    
 }