<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
			
			class Actionaid_nav extends CI_Model{
			function __construct(){
			parent::__construct();
			}
			function strNavigation(){
			//---------------------------------------------------------------------
			// the function name must be "strNavigation" - it returns a string
			// with your custom navigation
			//---------------------------------------------------------------------
				$navData ='';
							if ($_SESSION[CS_NAMESPACE.'user']->allowCommunication || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
							$navData .=
							'<li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope"></i> Communications <span class="caret"></span></a> 
							
							<ul class="dropdown-menu multi-level">
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Emails
							<ul class="dropdown-menu pull-right">
							<li>'.anchor('emails/templates', 'Email Templates', 'class=""').'</li>
							<li>'.anchor('emails/emails/', 'Send new', 'class=""').'</li>
							<li>'.anchor('emails/emailpriority/', 'Mail Inbox', 'class=""').'</li>
							<li>'.anchor('emails/emails/sentMails', 'Sent', 'class=""').'</li>';

							 if (bAllowAccess('adminOnly')){

							$navData .='<li>'.anchor('emails/settings', 'Mail Settings', 'class=""').'</li>';
								}

							$navData .='</ul>
							</li>
							<li>
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">SMS
							<ul class="dropdown-menu pull-right">
							<li>'
							.anchor('sms/sms/', 'Send New').'</li>';

							if (bAllowAccess('adminOnly')){
							$navData .='<li>'
							.anchor('sms/smsconfig', 'SMS Settings').'</li>';
								}
							$navData .='</ul>
							<li>
							'
							.anchor('reminders/reminder_record/viewViaUser/'.$glUserID, 'Your Reminders').'
							</li>
							</li>
							
							</ul>
							</li>';
						}

						if ($_SESSION[CS_NAMESPACE.'user']->allowLeads || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
							$navData .='<li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-thumb-tack"></i> Leads <span class="caret"></span></a> 
							
							<ul class="dropdown-menu multi-level">
							<li>'.anchor('leads/leads/addEdit/0', 'Add New', 'class=""').'</li>
							<li>'.anchor('leads/leads/leadDirectory', 'Directory', 'class=""').'</li>
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Communication
							<ul class="dropdown-menu pull-right">
							<li>'.anchor('leads/leads/email', 'Send Email', 'class=""').'</li>
							
							

							</ul>
							</li>

							</li>
							
							</ul>
							</li>';

						}

						if ($_SESSION[CS_NAMESPACE.'user']->allowFundraisingLog || $_SESSION[CS_NAMESPACE.'user']->bAdmin){
							$navData .='<li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-money"></i> Fundraising Log <span class="caret"></span></a> 
							
							<ul class="dropdown-menu multi-level">
							<li>'.anchor('fundraising/fundraising_log/add_new', 'Add New', 'class=""').'</li>
							<li>'.anchor('fundraising/fundraising_log/logs', 'Directory', 'class=""').'</li>
							<li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Utilities
							<ul class="dropdown-menu pull-right">
							<li>'.anchor('reports/fundraising_log_summary', 'Summary', 'class=""').'</li>
							
							

							</ul>
							</li>
							
							</li>
							
							</ul>
							</li>';
						}

							return($navData);
							}
}