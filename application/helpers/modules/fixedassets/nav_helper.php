<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2016  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

function modulenav(){
	$CI = & get_instance(); 
	$CI->load->helper('modules/modulesnav');
    $navData = '                
                <ul class="collapsible flat-ui borderless" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder', 'spaced-text').' File</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.fixedassetsfileMenu().'
                            '.systemmodulesdatabase('fixedassets').'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('add_circle', 'spaced-text').' Add New</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.fixedassetsactionMenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.fixedassetsreportMenu().'
                            '.customreportsmenu('fixedassets').'
                          </div>
                        </div>
                    </li>


                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.fixedassetsprefMenu().'
                          </div>
                        </div>
                    </li>
            </ul>

            ';
    $navData .= '';
    return($navData);
 }


function fixedassetsfileMenu(){
	$CI = & get_instance();
    $strOut = '';    
    $strOut .= '<a href="#excelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger padded-left">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
    return $strOut;
}

function fixedassetsactionMenu(){
	$CI = & get_instance();
    $strOut = '';
    if (haspriveledge('add', 'fixedassets')) {
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/saveUpdateAsset/0', maticon('add_circle', 'spaced-text').' Add Items', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/employeelist/0', maticon('person_add', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist','assignedTo'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_categories/0', maticon('star', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetCat'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_statuses/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetStatus'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_manufacturers/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetMnfctr'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_dealers/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetDealer'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_brands/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetBrand'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_sections/0', maticon('label', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetSctn'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_primaryloc/0', maticon('add_location', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetPrimLoc'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'forms/FormHandler/addeditsecondaryrecord/fixedassets_secondaryloc/0', maticon('folder', 'spaced-text').' Add '.dbfieldsetname('fixedassets_assetlist', 'assetSecLoc'), 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
    }

      

      
      return($strOut);
 }


function fixedassetsreportMenu(){
	$CI = & get_instance();
    $strOut = '';
    if (haspriveledge('reports', 'fixedassets')) {
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/listOfAssets', 'List Of Assets', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/listOfAssets', 'List Of Assets (Scanner)', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/listOfAssetsFinancial', 'List Of Assets (Financial)', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/assetsGroupBy', 'Assets Grouped By', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/checkedOutAssets', 'Checkedout Assets', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/betweenDates', 'Report Between Dates', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/depreciation', 'Depreciation', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/genReport/purchases', 'Purchases', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
     
    }
      return($strOut);
 }


function fixedassetsprefMenu(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor('preferences/User/preferences/fixedassets', maticon('settings','spaced-text').' My Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
    
    if (isadmin(FALSE)) {
            $strOut .= anchor('preferences/System/tablepreferences/fixedassets', maticon('settings','spaced-text').' System Table Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
            $strOut .= anchor('Preferences/System/inputpreferences/fixedassets', maticon('build', 'spaced-text').' Input Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
      }
   
   return($strOut);
}


function fixedassetscustomReports(){
	$CI = & get_instance();

    if (isloggedin(FALSE)) {
      $userId   =   USERID;
      $sqlStr   = "SELECT * FROM  fixedassets_reports WHERE reportUser = '$userId' OR NOT isPrivate;";
      $query    = $CI->db->query($sqlStr);
      $reports  = $query->result();
      $strOut = '';
      if (haspriveledge('customreports', 'fixedassets')) {
        $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Createreport/createeditreport/0', maticon('add', 'spaced-text').' New Report Wizard..', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
        $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/mycustomreports', maticon('list', 'spaced-text').'Directory', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      }
      foreach ($reports as $report) {
          $strOut .= anchor(FIXEDASSETS_PREFIX.'reports/Reports/generatereport/'.$report->reportId, maticon('equalizer', 'spaced-text').' '.$report->reportName, 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
      }
      
 
        
    }
    else{
      $strOut = '';
    }

    return $strOut;
    
 }