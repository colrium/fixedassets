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
                            '.communicationfilesubmenu().'
                            '.systemmodulesdatabase('communication').'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('email', 'spaced-text').' Mail</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.communicationemailsmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark"><div>'.maticon('textsms', 'spaced-text').' SMS</div></div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.communicationsmsmenu().'
                          </div>
                        </div>
                    </li>

                    

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.communicationreportsmenu().'
                            '.customreportsmenu('communication').'
                          </div>
                        </div>
                    </li>

                    

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('phonelink_setup', 'spaced-text').' Settings</div>
                        <div class="collapsible-body padded-left">
                          <div class="collection">
                            '.communicationprefsmenu().'
                          </div>
                        </div>
                    </li>
            </ul>

            ';
   return $navData;
}

function communicationfilesubmenu(){
    $CI = & get_instance();
    $strOut = '';    
    $strOut .= '<a href="#excelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger padded-left">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
    return $strOut;
}

function communicationemailsmenu(){
    $strOut = '';
    $strOut .= anchor(COMMUNICATION_PREFIX.'emails/Emails/sendNew', maticon('create', 'spaced-text').' Compose', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'emails/Emails/sent', maticon('move_to_inbox', 'spaced-text').' Inbox', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'emails/Emails/outbox', maticon('inbox', 'spaced-text').' Sent', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    
    $strOut .= anchor(COMMUNICATION_PREFIX.'forms/Formhandler/addeditemailtemplate/0', maticon('add', 'spaced-text').' Add Template', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'forms/Formhandler/addeditmailaccount/0', maticon('add', 'spaced-text').' Add Account', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'emails/Emails/templates', maticon('mail_outline', 'spaced-text').' Templates', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');

    $strOut .= anchor(COMMUNICATION_PREFIX.'emails/Emails/accounts', maticon('contact_mail', 'spaced-text').' Accounts', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');

    return $strOut;

}

function communicationsmsmenu(){
    $strOut = '';
    $strOut .= anchor(COMMUNICATION_PREFIX.'sms/Sms/sendNew', maticon('send', 'spaced-text').' Send New', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'sms/Sms/sent', maticon('inbox', 'spaced-text').' Sent', 'class="main-link collection-item borderless full-width waves-effect waves-dark  padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'sms/Sms/outbox', maticon('inbox', 'spaced-text').' Outbox', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'sms/Sms/accounts', maticon('contact_phone', 'spaced-text').' Accounts', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');

    return $strOut;
}


function communicationreportsmenu(){
    $strOut = '';
    

    return $strOut;

}

function communicationprefsmenu(){
    $strOut = '';
    $strOut .= anchor(COMMUNICATION_PREFIX.'preferences/Preferences/smsAPIs', maticon('network_cell', 'spaced-text').' SMS API SETTING', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'preferences/Preferences/emailHosts', maticon('router', 'spaced-text').' Email Hosts', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    $strOut .= anchor(COMMUNICATION_PREFIX.'preferences/Preferences/Users', maticon('people', 'spaced-text').' Users', 'class="main-link collection-item borderless full-width waves-effect waves-dark   padded-left"');
    return $strOut;

}