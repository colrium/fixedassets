<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// ActionAid
// copyright (c) 2012-2015  Collins Riungu
//
// author: Mutugi Riungu

---------------------------------------------------------------------*/

class Mnav_brain_jar extends CI_Model{

   function __construct(){
      parent::__construct();
   }

   function navData(){
      global $gbAdmin, $gbVolLogin;
      if ($gbVolLogin){
         return(strTrimAllLines($this->navDataVolunteer()));
      }else {
         return(strTrimAllLines($this->navDataStandard()));
      }
   }


   

   private function navDataStandard(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbAdmin, $gbStandardUser, $gUserPerms, $gbDev;
      $navData = "\n".'
   
      <ul class="nav navbar-nav">';

         // custom navigation
      if (@$_SESSION[CS_NAMESPACE.'nav']->lCnt > 0){
         foreach ($_SESSION[CS_NAMESPACE.'nav']->navFiles as $strNav){
            $this->load->model('custom_navigation/'.$strNav, $strNav);
//            $navData .= $strNav::strNavigation();
            $navData .= $this->$strNav->strNavigation();
         }
      }

         //----------------------------
         // Reports/Exports
         //----------------------------
      if (bAllowAccess('showReports')){
         $navData .=
            '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bar-chart-o"></i> Reports <span class="caret"></span></a>
               '.$this->navMenu_Reports().'
             </li>';
      }

         //----------------------------
         // People
         //----------------------------
      if ($_SESSION[CS_NAMESPACE.'user']->allowPeople || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
         $navData .=
            '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-users"></i> People <span class="caret"></span></a>
               '.$this->navMenu_People().'
             </li>';
      }
      if ($_SESSION[CS_NAMESPACE.'user']->allowOrganisation || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
         $navData .=
            '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-building-o"></i> Organisation <span class="caret"></span></a>
               '.$this->navMenu_Biz().'
             </li>';
      }

            //----------------------------
            // Volunteers
            //----------------------------
      if ($_SESSION[CS_NAMESPACE.'user']->allowVolunteers || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
         $navData .=
            '<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-users"></i> Volunteers <span class="caret"></span></a>
               '.$this->navMenu_Vols().'
             </li>';
      }

         //----------------------------
         // Financials
         //----------------------------
      if ($_SESSION[CS_NAMESPACE.'user']->allowFinancials || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
         if ($gbDev){
            $navData .=
               '<li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-money"></i> Financials<span class="caret"></span></a>
                  '.$this->navMenu_Financials().'
                </li>';
         }else {
            $navData .=
               '<li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-money"></i> Financials <span class="caret"></span></a>
                  '.$this->navMenu_Financials().'
                </li>';
         }
      }

         //----------------------------
         // Clients
         //----------------------------
      

         //----------------------------
         // Sponsors
         //----------------------------
      if (bAllowAccess('showSponsors') || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
         $navData .=
            '<li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-users"></i> Sponsors <span class="caret"></span></a>
               '.$this->navMenu_Sponsors().'
             </li>';
      }

         //----------------------------
         // Admin
         //----------------------------
      if ($gbAdmin){
         $navData .=
            '<li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user-md"></i> Admin <span class="caret"></span></a>
               '.$this->navMenu_Admin().'
             </li>';
      }

         //----------------------------
         // More
         //----------------------------
      $navData .=
            '<li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bars"></i> More... <span class="caret"></span></a>
               '.$this->navMenu_More().'
             </li>';

      $navData .= '</ul>';
      return($navData);
   }

   private function navMenu_Reports(){
   //---------------------------------------------------------------------
   //class="dropdown"
   //---------------------------------------------------------------------
      global $gbAdmin, $gbDev, $glUserID;

      $strOut = '<ul class="dropdown-menu multi-level">';

      $strOut .= '<li>'.anchor('main/menu/reports', 'Reports: Home', 'id="mb_rpts_home"').'</li>';

         //-----------------
         // custom
         //-----------------
         //------------------------
         // Reports => Predefined
         //------------------------
      $strOut .=
        '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-clock-o"></i> Predefined
            <ul class="dropdown-menu pull-right">';

         //-----------------
         // admin
         //-----------------
      if ($gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Admin
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_admin/usageOpts',  '<i class="fa fa-users"></i> Usage Log', 'id="mb_rpts_ul"').'</li>
                     <li>'.anchor('reports/pre_admin/loginLog/0', '<i class="fa fa-user"></i> User Login History', 'id="mb_rpts_ulh"').'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // business
         //-----------------
      if ((bAllowAccess('showReports') && $_SESSION[CS_NAMESPACE.'user']->allowPeople) || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Business
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_groups/showOpts/'.CENUM_CONTEXT_BIZ, '<i class="fa fa-users"></i> Groups', 'id="mb_rpts_biz_grp"').'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // clients
         //-----------------
      if (bAllowAccess('showClients')){
         $strOut .=
              '';
      }

         //-----------------
         // donations
         //-----------------
      if ((bAllowAccess('showReports') && $_SESSION[CS_NAMESPACE.'user']->allowFinancials) || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Donations
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/fundraising_log',    'Fundraising Log' ).'</li>
                     <li>'.anchor('reports/pre_gifts/recentOpts',    'Recent donations',       'id="mb_rpts_d_recent"' ).'</li>
                     <li>'.anchor('reports/pre_gifts/yearEndOpts',   'Year-end Report',        'id="mb_rpts_d_ye"'     ).'</li>
                     <li>'.anchor('reports/pre_gifts/timeframeOpts', 'Donations by Timeframe', 'id="mb_rpts_d_tf"'     ).'</li>
					 <li>'.anchor('reports/donor_pipeline', 'Donor Pipeline' ).'</li>
                     <li>'.anchor('reports/pre_gifts/accountOpts',   'Donations by Account',   'id="mb_rpts_d_acct"'   ).'</li>
                     <li>'.anchor('reports/pre_gifts/campOpts',      'Donations by Campaign',  'id="mb_rpts_d_camp"'   ).'</li>

                     <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Aggregate
                        <ul class="dropdown-menu pull-right">
                           <li>'.anchor('reports/pre_gifts/agOpts',        'Donations',            'id="mb_rpts_d_agg"'  ).'</li>
                           <li>'.anchor('reports/pre_gifts/agSponOpts',    'Sponsorship Payments', 'id="mb_rpts_d_aggsp"').'</li>
                        </ul>
                     </li>
					 <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Pledges
                        <ul class="dropdown-menu pull-right">
                            <li>'.anchor('reports/pledge_reports/allPledges',      'All Pledges'   ).'</li>
                            <li>'.anchor('reports/pledge_reports/',      'Past Due Date Pledges'   ).'</li>
					             <li>'.anchor('reports/honored_pledges',      'Honored  Pledges'   ).'</li>
                            <li>'.anchor('reports/pledge_reports/duePledges',      'Due Pledges'   ).'</li>
                        </ul>
                     </li>

                     <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Acknowledgments
                        <ul class="dropdown-menu pull-right">
                           <li>'.anchor('reports/pre_gift_ack/showOpts/gifts', 'Gift Acknowledgments',       'id="mb_rpts_d_gack"').'</li>
                           <li>'.anchor('reports/pre_gift_ack/showOpts/hon',   'Honorarium Acknowledgments', 'id="mb_rpts_d_hon"').'</li>
                           <li>'.anchor('reports/pre_gift_ack/showOpts/mem',   'Memorial Acknowledgments',   'id="mb_rpts_d_mem"').'</li>
                        </ul>
                     </li>
                  </ul>
               </li>';
      }

         //-----------------
         // Images/Documents
         //-----------------
      if (bAllowAccess('showReports') || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Images/Documents
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/image_doc/id_overview/overview', 'Overview', 'id="mb_rpts_imgdoc"').'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // people
         //-----------------
      if ((bAllowAccess('showReports') && $_SESSION[CS_NAMESPACE.'user']->allowPeople) || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">People
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_groups/showOpts/'.CENUM_CONTEXT_PEOPLE, 'Groups', 'id="mb_rpts_p_grp"').'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // sponsorship
         //-----------------
      if (bAllowAccess('showSponsors') || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Sponsors
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_groups/showOpts/'.CENUM_CONTEXT_SPONSORSHIP, 'Groups',      'id="mb_rpts_sp_grp"')     .'</li>
                     <li>'.anchor('reports/pre_spon_income/showOpts',      'Income',                       'id="mb_rpts_sp_inc"')                      .'</li>
                     <li>'.anchor('reports/pre_spon_past_due/showOpts',    'Payment Past Due',             'id="mb_rpts_sp_pd"')            .'</li>
                     <li>'.anchor('reports/pre_spon_via_prog/showOptsLoc', 'Sponsors Via Client Location', 'id="mb_rpts_sp_loc"').'</li>
                     <li>'.anchor('reports/pre_spon_via_prog/showOpts',    'Sponsors Via Program',         'id="mb_rpts_sp_prog"')        .'</li>
                     <li>'.anchor('reports/pre_spon_wo_clients/rpt',       'Sponsors Without Clients',     'id="mb_rpts_sp_noc"')    .'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // Staff
         //-----------------
      if ((bAllowAccess('showReports') && bAllowAccess('timeSheetAdmin')) || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Staff
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_timesheets/showOpts', 'Time Sheet Reports', 'id="mb_rpts_st_ts"').'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // volunteers
         //-----------------
      if ((bAllowAccess('showReports') && bAllowAccess('showPeople')) || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Volunteers
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_groups/showOpts/'.CENUM_CONTEXT_VOLUNTEER, 'Groups',                                 'id="mb_rpts_vol_grp"').'</li>
                     <li>'.anchor('reports/pre_vol_job_skills/showOpts',                  'Job Skills',                             'id="mb_rpts_vol_js"').'</li>
                     <li>'.anchor('reports/pre_vol_hours/showOptsYear',                   'Volunteer Hours by Year',                'id="mb_rpts_vol_yrhrs"').'</li>
                     <li>'.anchor('reports/pre_vol_hours/showOpts',                       'Volunteer Hours (Scheduled)',            'id="mb_rpts_vol_sch"').'</li>
                     <li>'.anchor('reports/pre_vol_hours/showOptsPVA',                    'Volunteer Hours - Scheduled vs. Actual', 'id="mb_rpts_vol_sva"').'</li>
                     <li>'.anchor('reports/pre_vol_schedule/past',                        'Past Events',                            'id="mb_rpts_vol_pa"').'</li>
                     <li>'.anchor('reports/pre_vol_schedule/current',                     'Current and Future Events',              'id="mb_rpts_vol_cfe"').'</li>
                     <li>'.anchor('reports/pre_vol_jobcodes/showOpts',                    'Job Codes',                              'id="mb_rpts_vol_jcode"').'</li>
                  </ul>
               </li>';
      }

         //-----------------
         // miscellaneous
         //-----------------
      if (bAllowAccess('showReports') || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Miscellaneous
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('reports/pre_attrib/attrib',         'Attributed To',  'id="mb_rpts_misc_att"').'</li>
                     <li>'.anchor('reports/pre_log_search/searchOpts', 'Log Search',     'id="mb_rpts_misc_ls"').'</li>
                     <li>'.anchor('reports/pre_data_entry/daOpts',     'Data Entry Log', 'id="mb_rpts_misc_del"').'</li>
                  </ul>
               </li>';
      }
      $strOut .= '</ul>';

         //-----------------
         // exports
         //-----------------
      if (bAllowAccess('allowExports') || $gbAdmin){
         $strOut .=
              '<li>'.anchor('reports/exports/showTableOpts', 'Exports', 'id="mb_rpts_exp"').'</li>';
      }

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_People(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '<ul class="dropdown-menu multi-level">';

         //------------------------
         // People => Home
         //------------------------
      if (bAllowAccess('dataEntry') || $gbAdmin){
         $strOut .= '<li>'.anchor('main/menu/people', 'People: Home', 'id="mb_p_home"').'</li>';
      }

         //------------------------
         // People => Add New
         //------------------------
      if (bAllowAccess('dataEntry') || $gbAdmin){
         $strOut .= '<li>'.anchor('people/people_add_new/selCon', 'Add New', 'id="mb_p_an"').'</li>';
      }

         //------------------------
         // People => Directories
         //------------------------
      if (bAllowAccess('view') || $gbAdmin){
         $strOut .=
              '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Directories
                  <ul class="dropdown-menu pull-right">
                     <li>'.anchor('people/people_dir/view', 'All People', '') .'</li>
                     <li>'.anchor('people/people_dir/view/A', 'Directory by Last Name',        'id="mb_p_dir_ln"') .'</li>
                     <li>'.anchor('people/people_dir/relView/A', 'Relationship Directory',     'id="mb_p_dir_rel"').'</li>
                     <li>'.anchor('people/people_household_dir/view/A', 'Household Directory', 'id="mb_p_dir_hh"') .'</li>
                     <li>'.anchor('people/people_household_dir/view/A', 'Household Directory', 'id="mb_p_dir_hh"') .'</li>

                  </ul>
               </li>';
      }

         //-----------------------------------
         // Utilities:
         //   * consolodate duplicates
         //   * search
         //-----------------------------------
      
      if (bAllowAccess('edit') || bAllowAccess('view') || $gbAdmin){

         $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilities
               <ul class="dropdown-menu pull-right">';


         $strOut .= '<li>'.anchor('util/dup_records/opts/'.CENUM_CONTEXT_PEOPLE, 'Consolidate Duplicates', 'id="mb_p_condup"').'</li>';
     
         $strOut .= '<li>'.anchor('people/people_search/searchOpts', 'Search', 'id="mb_p_search"').'</li>';

         $strOut .= '
               </ul>
            </li>';
      }
      

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_Biz(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '<ul class="dropdown-menu multi-level">';

         //------------------------
         // Biz => Home
         //------------------------
      if (bAllowAccess('dataEntry') || $gbAdmin){
         $strOut .= '<li>'.anchor('main/menu/biz', 'Business/Org: Home', 'id="mb_b_home"').'</li>';

         //-------------------
         // add new
         //-------------------
      $strOut .=
           '<li>'.anchor('biz/biz_add_edit/addEditBiz/0', 'Add New', 'id="mb_b_ae"').'</li>';
      }

         

       

         //-----------------------------------
         // Utilities:
         //   * consolodate duplicates
         //   * search
         //-----------------------------------
      

      if (bAllowAccess('edit') || bAllowAccess('view') || $gbAdmin) {
           //-------------------
         // directories
         //-------------------
      $strOut .=
           '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Directories
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('biz/biz_directory/view/A',         'Business Directory',   'id="mb_b_dir"')  .'</li>
                  
               </ul>
            </li>';
         $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Utilities
               <ul class="dropdown-menu pull-right">';
         $strOut .= '<li>'.anchor('util/dup_records/opts/'.CENUM_CONTEXT_BIZ, 'Consolidate Duplicates', 'id="mb_b_cdup"').'</li>';

         $strOut .= '<li>'.anchor('biz/biz_search/searchOpts', 'Search', 'id="mb_b_search"').'</li>';

         $strOut .= '
               </ul>
            </li>';
      }
      

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_Vols(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '<ul class="dropdown-menu pull-right">';
         //------------------------
         // Vols => Home
         //------------------------
      if (bAllowAccess('dataEntryPeopleBizVol') || $gbAdmin){
         $strOut .= '<li>'.anchor('main/menu/vols', 'Volunteers: Home', 'id="mb_v_home"').'</li>';
      }

         //--------------------------------
         //   Volunteers => Add New
         //--------------------------------
      $strOut .= '<li>'.anchor('volunteers/vol_add_edit/addEditS1', 'Add New', 'id="mb_v_new"').'</li>';

         //--------------------------------
         //   Volunteers => Directory
         //--------------------------------
      $strOut .= '<li>'.anchor('volunteers/vol_directory/view/A', 'Directory', 'id="mb_v_dir"').'</li>';

         //------------------------
         // Volunteers => Events
         //------------------------
      $strOut .=
           '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Events
               <ul class="dropdown-menu pull-right">';

      if (bAllowAccess('edit') || $gbAdmin){
         $strOut .=
              '<li>'.anchor('volunteers/events_add_edit/addEditEvent/0', 'Add Event', 'id="mb_v_adde"').'</li>';
      }
      $strOut .=
              '<li>'.anchor('volunteers/events_cal/viewEventsCalendar/current', 'Event Calendar',        'id="mb_v_ecal"').'</li>
               <li>'.anchor('volunteers/events_schedule/viewEventsList',        'Event Schedule (list)', 'id="mb_v_elist"').'</li>
            </ul>
         </li>';

         //------------------------------
         // Volunteers => Registration
         //------------------------------
      $strOut .=
           '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Registration
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('volunteers/registration/view', 'Registration Forms', 'id="mb_v_reg"').'</li>
               </ul>
            </li>';

         //--------------------------------
         // Volunteers => Search
         //--------------------------------
      $strOut .= '<li>'.anchor('volunteers/vol_search/searchOpts', 'Search', 'id="mb_v_search"').'</li>';

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_Financials(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $gbDev;

      $strOut = '<ul class="dropdown-menu multi-level">';
         //------------------------
         // Financials => Home
         //------------------------
      if ($gbDev){
         $strOut .= '<li>'.anchor('main/menu/financials', 'Financials / Grants: Home', 'id="mb_f_home"').'</li>';
      }else {
         $strOut .= '<li>'.anchor('main/menu/financials', 'Financials: Home', 'id="mb_f_home1"').'</li>';
      }

      if (bAllowAccess('showFinancials') || $gbAdmin){
         $strOut .=
             '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Financials
                 <ul class="dropdown-menu pull-right">
                    
                     <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Expenses
                        <ul class="dropdown-menu">
                           <li>'.anchor('financials/expenses/addEdit/0', 'Add Expenses', '').'</li>
                           <li>'.anchor('financials/expenses/log',       'Expenses Log', '').'</li>
                        </ul>
                     </li>

                     <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Deposits
                        <ul class="dropdown-menu">
                           <li>'.anchor('financials/deposits_add_edit/addDeposit', 'Add Deposit', 'id="mb_f_addd"').'</li>
                           <li>'.anchor('financials/deposit_log/view',             'Deposit Log', 'id="mb_f_dlog"').'</li>
                        </ul>
                     </li>
                  </ul>
               </li>';
      }

if ($gbDev){
      if (bAllowAccess('showGrants')){
         $strOut .=
             '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Grants
                 <ul class="dropdown-menu pull-right">
                    <li>'.anchor('grants/provider_directory/viewProDirectory/true', 'Provider Directory', 'id="mb_fg_pdir"').'</li>
                    <li>'.anchor('grants/grants_calendar/viewCal',                  'Calendar',           'id="mb_fg_cal"') .'</li>
                 </ul>
              </li>';
      }
}

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_Clients(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '<ul class="dropdown-menu ">';
         //------------------------
         // Clients => Home
         //------------------------
      $strOut .= '<li>'.anchor('main/menu/client', 'Clients: Home', 'id="mb_cl_home"').'</li>';

         //---------------------------------------
         // Clients => Add New Client
         //---------------------------------------
      $strOut .=
           '<li>'.anchor('clients/client_rec_add_edit/addNewS1', 'Add New Client', 'id="mb_cl_new"').'</li>
            <li>Directories
               <ul>
                  <li>'.anchor('clients/client_dir/name/N/A', 'By Client Last Name',   'id="mb_cl_dirln"')  .'</li>
                  <li>'.anchor('clients/client_dir/view/0',   'By Location',            'id="mb_cl_dirloc"').'</li>
                  <li>'.anchor('clients/client_dir/sProg/0',  'By Sponsorship Program', 'id="mb_cl_dirsp"') .'</li>
               </ul>
            </li>
            <li>'.anchor('cprograms/cprog_dir/cprogList',    'Client Programs', 'id="mb_cl_sp"').'</li>
            <li>'.anchor('cpre_post_tests/pptests/overview', 'Pre/Post Tests',  'id="mb_cl_prepost"').'</li>
            <li>Utilities
               <ul>
                  <li>'.anchor('util/dup_records/opts/'.CENUM_CONTEXT_CLIENT, 'Consolidate Duplicates', 'id="mb_cl_dup"')   .'</li>
                  <li>'.anchor('clients/client_search/searchOpts', 'Search',                            'id="mb_cl_search"').'</li>
                  <li>'.anchor('clients/client_verify/status',     'Verify Status',                     'id="mb_cl_vstat"') .'</li>
               </ul>
            </li>';
      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_Sponsors(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      $strOut = '<ul class="dropdown-menu multi-level">';

      $strOut .= '<li>'.anchor('main/menu/sponsorship', 'Sponsors: Home').'</li>';

      if (bAllowAccess('showSponsorFinancials')){
         $strOut .=
           '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Accounting Features
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('sponsors/auto_charge/applyChargesOpts',   'Apply Charges').'</li>
                  <li>'.anchor('sponsors/batch_payments/batchSelectOpts', 'Batch Payments').'</li>
               </ul>
            </li>';
      }

         //---------------------------------------
         // Sponsorship => Directories
         //---------------------------------------
      $strOut .= '<li>'.anchor('sponsors/spon_directory/view/false/-1/A/0/50', 'Directory').'</li>';

         //---------------------------------------
         // Sponsorship => Searches
         //---------------------------------------
      $strOut .=
           '<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilities
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('sponsors/spon_search/opts',   'Search').'</li>
               </ul>
            </li>';


/*
//
//         //---------------------------------------
//         // Sponsorship => Add New Sponsorship
//         //---------------------------------------
//      $strLinks .=
//          '<a class="menuItem"
//              style="color: #cccccc; font-style:italic;"
//              href="../main/mainOpts.php'
//                   .'?type=sponsorships'
//                   .'&st=sponsor'
//                   .'&sst=addNew'
//               .'">Add New Sponsorship</a>';
//
//         //---------------------------------------
//         // Sponsorship => Communications
//         //---------------------------------------
//      $strLinks .=
//          '<a class="menuItem" href=""
//              style="color: #cccccc; font-style:italic;"
//              onclick="return false;"
//              onmouseover="menuItemMouseover(event, \'sponCom\');" >
//              <span class="menuItemText">Communications</span>
//              <span class="menuItemArrow">&#9654;</span></a>';
//
//
//         //--------------------------------------------------------------------
//         // Sponsorship => Audits => Report: Sponsors with / without audits
//         //--------------------------------------------------------------------
//      $strLinks .=
//          '<div id="sponCom" class="menu" onmouseover="menuMouseover(event)">';
//      $strLinks .=
//          '<a class="menuItem"
//              style="color: #cccccc; font-style:italic;"
//              href="../main/mainOpts.php'
//                     .'?type=sponsorships'
//                     .'&st=comm'
//                     .'&sst=mainLog'
//                .'">Log a Communication</a>';
//
//         //--------------------------------------------------------------------
//         // Sponsorship => Communications => Communication Inventory
//         //--------------------------------------------------------------------
//      $strLinks .=
//          '<a class="menuItem"
//              style="color: #cccccc; font-style:italic;"
//              href="../main/mainOpts.php'
//                     .'?type=sponsorships'
//                     .'&st=comm'
//                     .'&sst=inventory'
//                     .'&ssst=manage'
//                     .'&sssst=main'
//                .'">Communication Inventory</a>';
//      $strLinks .=
//          '</div>';
//
//
//         //----------------------------------
//         // Sub-Menu, sponsorship utilities
//         //----------------------------------
//      $strLinks .=
//          '<div id="sponsorUtil" class="menu">'
//         .'<a class="menuItem"
//              style="color: #cccccc; font-style:italic;"
//              href="../main/mainOpts.php'
//                        .'?type=sponsorships'
//                        .'&st=sponsor'
//                        .'&sst=utilS'
//                        .'&ssst=xferClient'
//                        .'&sssst=step1">'
//             .'TBD 1</a>'
//
//         .'<a class="menuItem"
//              style="color: #cccccc; font-style:italic;"
//              href="../main/mainOpts.php'
//                        .'?type=sponsorships'
//                        .'&st=sponsor'
//                        .'&sst=utilS'
//                        .'&ssst=refreshClientDefImg01'
//                        .'&sssst=step1">'
//             .'TBD 2</a>'
//
//         .'</div>';
//      return($strLinks);
*/
      $strOut .= '</ul>';
      return($strOut);
  }

   private function navMenu_Admin(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbDev;

      $strOut = '<ul class="dropdown-menu multi-level">';

         // Lists
      $strOut .= '
            <li>'.anchor('main/menu/admin',                'Admin: Home', 'id="mb_ad_home"') .'</li>
            <li>'.anchor('admin/alists/showLists',         'Lists',       'id="mb_ad_lists"').'</li>';

         // ActionAid Accounts
      $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> User Accounts
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('admin/accts/userAcctDir/A', 'Accounts Directory', 'id="mb_ad_adir"').'</li>
                  <li>'.anchor('admin/accts/userAccess',    'Users Via Access',   'id="mb_ad_ua"')
                .'</li>
               </ul>
            </li>';

         // Your Organization
//                  <li>'.anchor('admin/timesheets/ts_projects/viewTSProjects',    'Staff Time Sheet Projects').'</li>
      $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> Your Organization
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('admin/org/orgView',                              'Organization Record',      'id="mb_ad_org"')   .'</li>
                  <li>'.anchor('admin/timesheets/view_tst_record/viewTSTList', 'Staff Time Sheet Templates', 'id="mb_ad_tslist"').'</li>
               </ul>';

         // Personalization
      $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Personalization
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('admin/personalization/overview',     'Tables',          'id="mb_ad_tabs"').'</li>
               </ul>
            </li>';

    
         // Database Utilities
      $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Database Utilities
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('admin/db_zutil/opt',    'Optimize your database', 'id="mb_ad_dbopt"') .'</li>
                  <li>'.anchor('admin/db_zutil/backup', 'Backup your database',   'id="mb_ad_dbback"').'</li>';

      if ($gbDev){
         $strOut .= '
                  <li>'.anchor('admin/db_zutil/utables', 'DEV: Personalized Tables', 'id="mb_ad_dev01"')  .'</li>';
/*
         $strOut .= '
                  <li>'.anchor('admin/dev/schema_examples/test01', 'DEV: mschema - single table load')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test02', 'DEV: mschema - single tables via parent type')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test03', 'DEV: mschema - single table via name')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test04', 'DEV: mschema - field IDX')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test05', 'DEV: mschema - table field scalars')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test06', 'DEV: mschema - field IDX via Field ID')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test07', 'DEV: mschema - field essentials')  .'</li>
                  <li>'.anchor('admin/dev/schema_examples/test08', 'DEV: mschema - ddl')  .'</li>

                  ';
*/
      }

/*
      if ($gbDev){
         $strOut .= '
                  <li>'.anchor('admin/dev/patch_reroute/run', 'DEV: Patch ReRoute 6/1/14')  .'</li>';
      }
      if ($gbDev){
         $strOut .= '
                  <li>'.anchor('admin/dev/patch_cform_log/createCFormLog', 'DEV: Build Custom Form Log')  .'</li>';
      }
      if ($gbDev){
         $strOut .= '
                  <li>'.anchor('admin/dev/upgrade_dev_1007/upgrade', 'DEV: Upgrade UF Tables for 1.007')  .'</li>';
      }
*/



      $strOut .= '
               </ul>
            </li>';

         // Import
      $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Import
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('admin/import/'.CENUM_CONTEXT_PEOPLE,     'People Records',                'id="mb_ad_in_p"')  .'</li>
                  <li>'.anchor('leads/leads/importView',     'Lead Records')  .'</li>
                  <li>'.anchor('admin/import/'.CENUM_CONTEXT_BIZ,        'Biz/Org Records', 'id="mb_ad_in_b"')  .'</li>
                  <li>'.anchor('admin/import/'.CENUM_CONTEXT_GIFT,       'Gift/Pledge Records',                  'id="mb_ad_in_g"')  .'</li>
                   <li>'.anchor('admin/import/'.CENUM_CONTEXT_SPONSORPAY, 'Sponsor Payments',              'id="mb_ad_in_sp"') .'</li>
                  <li>'.anchor('admin/import/review',                    'Review/Analyze Import File',    'id="mb_ad_in_rev"').'</li>
                  <li>'.anchor('admin/import/log',                       'Import Log',                    'id="mb_ad_in_log"').'</li>
                  <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Import Templates
                  <ul class="dropdown-menu pull-right">
                  <li><a href="'.base_url().'catalog/templates/Leads.csv">Leads Template </a></li>
                  <li><a href="'.base_url().'catalog/templates/People.csv">People Template </a></li>
                  <li><a href="'.base_url().'catalog/templates/org.csv">Biz/Org Template </a></li>
                  <li><a href="'.base_url().'catalog/templates/gifts.csv">Gift Template </a></li>

                  </ul>
                  
                  </li>
               </ul>
            </li>';

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navMenu_More(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $glUserID, $gbDev, $gbAdmin, $gbStandardUser, $gUserPerms;

      $strOut = '<ul class="dropdown-menu multi-level">';
      $strOut .= '<li>'.anchor('main/menu/more', 'More: Home').'</li>';

   $strOut .=  '<li>'.anchor('reminders/reminder_record/viewViaUser/'.$glUserID, 'Your Reminders').'</li>';
      $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Your Account
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('more/user_acct/view/'.$glUserID,  'Your Profile and Preferences').'</li>
                  <li>'.anchor('more/user_acct/pw',               'Change Password')             .'</li>
               </ul>
            </li>';
      $strOut .= '
            <li>'.anchor('staff/timesheets/ts_log/viewLog', 'Time Sheets').'</li>';

      if (bAllowAccess('timeSheetAdmin')){
         $strOut .= '
                  <li>'.anchor('staff/timesheets/ts_admin/viewUsers', 'Time Sheet Administration').'</li>';
      }

      if (bAllowAccess('inventoryMgr')){
         $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Inventory Management
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('staff/inventory/icat/viewICats', 'Categories').'</li>
                  <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Items
                     <ul class="dropdown-menu">
                        <li>'.anchor('staff/inventory/icat/viewICatsRemOnly',    'Removed Items').'</li>
                        <li>'.anchor('staff/inventory/icat/viewICatsLostOnly',   'Lost Items').'</li>
                        <li>'.anchor('staff/inventory/icat/itemsCheckedOutList', 'Checked-Out Items').'</li>
                        <li>'.anchor('staff/inventory/icat/itemsAllList',        'All Items').'</li>
                     </ul>
               </ul>
            </li>';
//                  <li>'.anchor('staff/inventory/reports', 'Reports').'</li>
//                        <li>'.anchor('staff/inventory/itemsSearchOpts',     'Item Search').'</li>
      }

      if (bAllowAccess('showAuctions')){
         $strOut .= '
            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Silent Auctions
               <ul class="dropdown-menu pull-right">
                  <li>'.anchor('auctions/auctions/auctionEvents', 'Silent Auction Events').'</li>
                  <li>'.anchor('auctions/bid_templates/main',     'Bid Sheets')           .'</li>
               </ul>
            </li>';
      }

      $strOut .=
          '<li>'.anchor('more/about/aboutDL', 'About...').'</li>
          <li><a href="'.base_url().'catalog/manual/manual.pdf" target="_blank">User Manual</a></li>
           <li>'.anchor('login/signout',      'Sign Out').'</li>';

      $strOut .= '</ul>';
      return($strOut);
   }

   private function navDataVolunteer(){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gbAdmin, $gbVolLogin, $gVolPerms, $gstrSafeName;

      $navData = '&nbsp;&nbsp;<span style="vertical-align: center;">Volunteer Account: <b>'.$gstrSafeName.'</b></span>';
      $navData .= "\n".'<ul id="navDD" class="dropdown dropdown-horizontal">';

      if (bAllowAccess('edit')){
         $navData .= '<li>'.anchor('people/people_record/view', 'Contact Info', 'id="mb_vv_ci"').'</li>';
      }

      if (bAllowAccess('volResetPassword')){
         $navData .= '<li>'.anchor('more/user_acct/pw', 'Reset Password', 'id="mb_vv_rp"').'</li>';
      }

      if (bAllowAccess('volViewGiftHistory')){
         $navData .= '<li>'.anchor('vol_reg/gift_history/view', 'Donation History', 'id="mb_vv_dh"').'</li>';
      }

      if (bAllowAccess('volJobSkills')){
         $navData .= '<li>'.anchor('volunteers/vol_add_edit/editVolSkills', 'Skills', 'id="mb_vv_js"').'</li>';
      }

         //----------------------------
         // Scheduling Fetures
         //----------------------------
      $bAnyVolPerms = bAllowAccess('volFeatures');
      if ($bAnyVolPerms){
         $navData .=
            '<li>Scheduling Features
                <ul>';
         if (bAllowAccess('volViewHours')){
            $navData .= '<li>'.anchor('vol_reg/vol_hours/view',
                           'View '.(bAllowAccess('volEditHours') ? ' / edit / update' : '').' hours', 'id="mb_vv_hrs"').'</li>';
         }
         if (bAllowAccess('volShiftSignup')){
            $navData .= '<li>'.anchor('vol_reg/vol_hours/shifts',
                         'View / register for upcoming volunteer opportunities', 'id="mb_vv_shift"').'</li>';
         }
         $navData .= '<li>'.anchor('vol_reg/vol_hours/cal', 'Your upcoming volunteer calendar', 'id="mb_vv_cal"').'</li>';

         $navData .= '
                </ul>
             </li>';
      }

      $navData .= '<li>&nbsp;</li><li>'.anchor('login/signout', 'Sign Out', 'id="mb_vv_so"').'</li>';

      $navData .= '</ul>';
      return($navData);
   }



}