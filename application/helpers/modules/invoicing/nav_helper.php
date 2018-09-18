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
                            '.invoicingfileMenu().'
                            '.systemmodulesdatabase('invoicing').'
                          </div>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('people', 'spaced-text').' Clients</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.invoicingclientsnav().'                            
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder_special', 'spaced-text').' Quotes</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.invoicingquotesnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('card_membership', 'spaced-text').' Invoices</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.invoicinginvoicesnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('payment', 'spaced-text').' Payments</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.invoicingpaymentsnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('poll', 'spaced-text').' Reports</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.invoicingreportsnav().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Invoicing Settings</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.invoicingsettingsnav().'
                          </div>
                        </div>
                    </li>
            </ul>';
    return $navData;
 }


function invoicingfileMenu(){
    $CI = & get_instance();
    $strOut = '<a href="#invoicingimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger '.getcolorclass(8).' padded-left">'.maticon('assignment_returned', 'spaced-text').' Import Spreadsheet</a>';
    return $strOut;
 }

function invoicingclientsnav(){
    $CI = & get_instance();
    $strOut = anchor(INVOICING_PREFIX.'forms/FormHandler/addeditclient/0', maticon('person_add', 'spaced-text').' Add Client', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'clients/activeclients', maticon('people', 'spaced-text').' Clients', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');

    return $strOut;
}

function invoicingquotesnav(){
    $CI = & get_instance();
    $strOut = anchor(INVOICING_PREFIX.'forms/FormHandler/addeditquote/0', maticon('add_circle', 'spaced-text').' Add Quote', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'quotes/viewall', maticon('list', 'spaced-text').' Quotes', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}
function invoicinginvoicesnav(){
    $strOut = '';
    $strOut .= anchor(INVOICING_PREFIX.'forms/FormHandler/addeditinvoice/0', maticon('add_circle', 'spaced-text').' Create Invoice', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'invoices/view/all', maticon('list', 'spaced-text').' Invoices', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'invoices/view/recurring', maticon('update', 'spaced-text').' Recurring Invoices', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}

function invoicingpaymentsnav(){
    $CI = & get_instance();
    $strOut = anchor(INVOICING_PREFIX.'forms/FormHandler/addeditpayment/0', maticon('add_circle', 'spaced-text').' Add Payment', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'payments/view/all', maticon('payment', 'spaced-text').' Payments', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');

    return $strOut;
}

function invoicingreportsnav(){
    $CI = & get_instance();
    $strOut = anchor(INVOICING_PREFIX.'reports/generate/aging', maticon('poll', 'spaced-text').' Invoice Aging', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'reports/generate/paymenthistory', maticon('poll', 'spaced-text').' Payment History', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'reports/generate/salesbyclient', maticon('poll', 'spaced-text').' Sales by Client', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}

function invoicingsettingsnav(){
    $CI = & get_instance();
    $strOut = anchor(INVOICING_PREFIX.'preferences/customfields', maticon('settings', 'spaced-text').' Custom Fields', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'preferences/emailtemplates', maticon('settings', 'spaced-text').' Email Templates', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'preferences/invoicegroups', maticon('settings', 'spaced-text').' Invoice Groups', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'preferences/itemlookups', maticon('settings', 'spaced-text').' Item Lookups', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'preferences/paymentmethods', maticon('settings', 'spaced-text').' Payment Methods', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'preferences/taxrates', maticon('settings', 'spaced-text').' Tax Rates', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    $strOut .= anchor(INVOICING_PREFIX.'preferences/module', maticon('settings', 'spaced-text').' System Settings', 'class="main-link collection-item borderless full-width waves-effect waves-dark  '.getcolorclass(8).' padded-left"');
    return $strOut;
}