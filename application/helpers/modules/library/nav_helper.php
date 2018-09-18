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
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('people', 'spaced-text').' Members</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.librarymembersnav().'                            
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('book', 'spaced-text').' Books</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.librarybooksnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Fees And Deposits</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.libraryfeesdepositsnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Manage Deposits</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.librarymanagedepositsnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Transactions</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.librarytransactionsnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Library Settings</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.librarysettingsnav().'
                            '.modulesdatabase('library').'
                          </div>
                        </div>
                    </li>
            </ul>';
    return($navData);
 }





function librarymembersnav(){
	$CI = & get_instance();
    $strOut = '';
      $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/addmember/0', maticon('person_add', 'spaced-text').' Add Member', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
      $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/activemembers', maticon('people', 'spaced-text').' Members', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');

    return $strOut;
}

function librarybooksnav(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/addbook/0', maticon('add_circle', 'spaced-text').' Add Book', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/addnovel/0', maticon('add_circle', 'spaced-text').' Add Novel', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/addmagazine/0', maticon('add_circle', 'spaced-text').' Add Magazine', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/books', maticon('book', 'spaced-text').' Books List', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}
function libraryfeesdepositsnav(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/addfees/0', maticon('add_circle', 'spaced-text').' Add Fees', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/activefeehistory', maticon('history', 'spaced-text').' Active Fee History', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/deadfeehistory', maticon('history', 'spaced-text').' Dead Fee History', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}

function librarymanagedepositsnav(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/adddeposit/0', maticon('add_circle', 'spaced-text').' Add Deposit', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/activedeposithistory', maticon('history', 'spaced-text').' Active Deposit History', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/returnedhistory', maticon('history', 'spaced-text').' Returned History', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}

function librarytransactionsnav(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/issuebook', maticon('file_upload', 'spaced-text').' Issue Book', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/returnbook', maticon('file_download', 'spaced-text').' Return Book', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(LIBRARY_PREFIX.'datatables/Datatables/transactionhistory', maticon('history', 'spaced-text').' Transaction History', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}

function librarysettingsnav(){
	$CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(LIBRARY_PREFIX.'forms/FormHandler/settings', maticon('settings', 'spaced-text').' Library Settings', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}