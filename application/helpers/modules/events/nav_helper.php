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
                            '.eventsfilemenu().'
                            '.systemmodulesdatabase('invoicing').'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('event', 'spaced-text').' Events</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventseventsmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('book', 'spaced-text').' Bookings</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventsbookingsmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('attach_money', 'spaced-text').' Payments</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventspaymentsmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('place', 'spaced-text').' Venues</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventsvenuesmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventsreportsmenu().'
                          </div>
                        </div>
                    </li>


                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('adjust', 'spaced-text').' Others</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventsothersmenu().'
                          </div>
                        </div>
                    </li>

                    <li>
                        <div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
                        <div class="collapsible-body">
                          <div class="collection">
                            '.eventspreferencesmenu().'
                          </div>
                        </div>
                    </li>
            	</ul>';
    return $navData;
 }



function eventsfrontendnav(){  
  $CI = & get_instance();
  $params = array();
  $params['where']['equalto'] = array('entity' => 'events', 'parent' => '0');
    $pages = dbtablerecords('frontend_pages', $params, FALSE);

    $navData = '';

    foreach ($pages as $key => $value) {
      $navData .= '<li>'.anchor('Events/page/'.$value->name, maticon($value->icon, 'spaced-text').' '.humanize($value->title), 'class="waves-effect waves-dark"').'</li>';
    }
    

    return $navData;
 }






 function eventsfilemenu(){
 	$CI = & get_instance();
    $strOut = '<a href="#eventsexcelimport-modal"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger '.getcolorclass(8).' padded-left">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
    return $strOut;
 }

function eventseventsmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'forms/Formhandler/addeditevent/0', maticon('add_circle', 'spaced-text').' New Event', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'records/Records/viewall/events', maticon('list', 'spaced-text').' All Events', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
 }


function eventsbookingsmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'forms/Formhandler/addeditbooking/0', maticon('add_circle', 'spaced-text').' New Booking', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'records/Records/viewall/bookings', maticon('list', 'spaced-text').' All Bookings', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
}

function eventspaymentsmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'forms/Formhandler/addeditpayment/0', maticon('add_circle', 'spaced-text').' New Payments', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'records/Records/viewall/payments', maticon('list', 'spaced-text').' All Payments', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
}

function eventsvenuesmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'forms/Formhandler/addeditvenue/0', maticon('add_circle', 'spaced-text').' New Venue', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'records/Records/viewall/venues', maticon('list', 'spaced-text').' All Venues', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
}

function eventsreportsmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'reports/Reports/timeline', maticon('timeline', 'spaced-text').' Timeline Infographic', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'reports/Reports/eventattendance', maticon('equalizer', 'spaced-text').' Event Attendance', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'reports/Reports/eventpopularity', maticon('equalizer', 'spaced-text').' Events Popularity', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'reports/Reports/realizedincome', maticon('equalizer', 'spaced-text').' Realized Income', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'reports/Reports/venuepopularity', maticon('equalizer', 'spaced-text').' Venue Popularity', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'reports/Reports/newreport', maticon('equalizer', 'spaced-text').' New Report Wizard', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
}

function eventsothersmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'forms/Formhandler/addeditvehicle/0', maticon('add_circle', 'spaced-text').' New Venue', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'records/Records/viewall/vehicles', maticon('list', 'spaced-text').' All Vehicles', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
}

function eventspreferencesmenu(){
  $CI = & get_instance();
    $strOut = '';
    $strOut .= anchor(EVENTS_PREFIX.'preferences/Preferences', maticon('settings', 'spaced-text').' Events Preferences', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    $strOut .= anchor(EVENTS_PREFIX.'preferences/Frontend', maticon('extension', 'spaced-text').' Frontend', 'class="main-link collection-item borderless full-width '.getcolorclass(8).'  waves-effect waves-dark padded-left"');
    return $strOut;
}