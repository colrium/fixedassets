<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------------------------------------------------------------
// copyright (c) 2017	Collins Riungu
//
// author: Mutugi Riungu
---------------------------------------------------------------------*/

function modulenav(){
	$CI = & get_instance(); 
	$CI->load->helper('modules/modulesnav');
	$entitiesicons = dbmoduletableicons('ngo');
	$entitiesnames = dbmoduletablenames('ngo');
	$navData ='<ul class="collapsible flat-ui borderless" data-collapsible="accordion">';
					$navData .= '<li>
										<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('folder', 'spaced-text').' File</div>
										<div class="collapsible-body padded-left">
											<div class="collection">
												'.ngofileMenu($entitiesnames, $entitiesicons).'
												'.systemmodulesdatabase('ngo').'
											</div>
										</div>
								</li>';
				
				if (haspriveledge('donors', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon($entitiesicons['ngo_donors'], 'spaced-text').' '.$entitiesnames['ngo_donors'].'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngodonorsMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}

				if (haspriveledge('leads', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon($entitiesicons['ngo_leads'], 'spaced-text').' '.$entitiesnames['ngo_leads'].'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngoleadsMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}

				

				if (haspriveledge('fundraisinglog', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon($entitiesicons['ngo_fundraising_log'], 'spaced-text').' '.$entitiesnames['ngo_fundraising_log'].'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngofundraisinglogMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}

				


				if (haspriveledge('volunteers', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon($entitiesicons['ngo_volunteers'], 'spaced-text').' '.$entitiesnames['ngo_volunteers'].'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngovolunteersMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}

				if (haspriveledge('financials', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('attach_money', 'spaced-text').' Financials</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngofinancialsMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}


				if (haspriveledge('communication', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('label', 'spaced-text').' Communication'.'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngocommunicationMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}

				if (haspriveledge('sponsors', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon($entitiesicons['ngo_sponsor'], 'spaced-text').' '.$entitiesnames['ngo_sponsor'].'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngosponsorsMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}

				if (haspriveledge('clients', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon($entitiesicons['ngo_client_records'], 'spaced-text').' '.$entitiesnames['ngo_client_records'].'</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngoclientsMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}
				if (isadmin(FALSE)) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('list', 'spaced-text').' Others</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngoothersMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
									</li>';
				}  

				if (haspriveledge('reports', 'ngo')) {
						$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('equalizer', 'spaced-text').' Reports</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngoreportsMenu($entitiesnames, $entitiesicons).'
													'.customreportsmenu('ngo').'
												</div>
											</div>
									</li>';
				}


				$navData .= '<li>
											<div class="collapsible-header borderless waves-effect waves-dark">'.maticon('settings', 'spaced-text').' Preferences</div>
											<div class="collapsible-body padded-left">
												<div class="collection">
													'.ngopreferencesMenu($entitiesnames, $entitiesicons).'
												</div>
											</div>
										</li>';

		$navData .= '</ul>';
		return($navData);
 }


function ngofileMenu($entitiesnames, $entitiesicons){
	$CI = & get_instance();
		$strOut = '';
		$strOut .= '<a href="#excelimport-modal" id="importbtn"  class="main-link collection-item borderless full-width waves-effect waves-dark modal-trigger">'.maticon('assignment_returned', 'spaced-text').' Import From Spreadsheet</a>';
		return $strOut;
}


function ngoleadsMenu($entitiesnames, $entitiesicons){
	$strOut = '';
	if (haspriveledge('leads', 'ngo')) {
		if (haspriveledge('add', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditlead/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_leads']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_lead_activities/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_lead_activities']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_leadcategories/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_leadcategories']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_lead_priorities/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_lead_priorities']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_lead_sources/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_lead_sources']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_lead_stages/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_lead_stages']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_leadgroups/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_leadgroups']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/leads', maticon($entitiesicons['ngo_leads'], 'spaced-text').' '.$entitiesnames['ngo_leads'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_lead_activities', maticon($entitiesicons['ngo_lead_activities'], 'spaced-text').' '.$entitiesnames['ngo_lead_activities'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');    
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_leadcategories', maticon($entitiesicons['ngo_leadcategories'], 'spaced-text').' '.$entitiesnames['ngo_leadcategories'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');    
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_lead_priorities', maticon($entitiesicons['ngo_lead_priorities'], 'spaced-text').' '.$entitiesnames['ngo_lead_priorities'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');    
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_lead_sources', maticon($entitiesicons['ngo_lead_sources'], 'spaced-text').' '.$entitiesnames['ngo_lead_sources'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');    
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_lead_stages', maticon($entitiesicons['ngo_lead_stages'], 'spaced-text').' '.$entitiesnames['ngo_lead_stages'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');

	}
	return $strOut;

}

function ngofundraisinglogMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		if (haspriveledge('fundraisinglog', 'ngo')) {
			if (haspriveledge('add', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditfundraisinglog/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_fundraising_log']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/fundraisinglogs', maticon($entitiesicons['ngo_fundraising_log'], 'spaced-text').' '.$entitiesnames['ngo_fundraising_log'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'reports/Reports/fundraisinglogsummary', maticon('pie_chart', 'spaced-text').' '.$entitiesnames['ngo_fundraising_log'].' Summary', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}
		
		return $strOut;
}

function ngoothersMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_expected_amounts', maticon($entitiesicons['ngo_expected_amounts'], 'spaced-text').' '.$entitiesnames['ngo_expected_amounts'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_gifts_auctions', maticon($entitiesicons['ngo_gifts_auctions'], 'spaced-text').' '.$entitiesnames['ngo_gifts_auctions'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_gifts_auctions_bidsheets', maticon($entitiesicons['ngo_gifts_auctions_bidsheets'], 'spaced-text').' '.$entitiesnames['ngo_gifts_auctions_bidsheets'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_gifts_auctions_items', maticon($entitiesicons['ngo_gifts_auctions_items'], 'spaced-text').' '.$entitiesnames['ngo_gifts_auctions_items'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_contacts', maticon($entitiesicons['ngo_contacts'], 'spaced-text').' '.$entitiesnames['ngo_contacts'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		return $strOut;
}

function ngoreportsMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		
		

		return $strOut;
}


function ngodonorsMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		
			if (haspriveledge('add', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditdonor/0', maticon('add', 'spaced-text').' New '.depluralize($entitiesnames['ngo_donors']), 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				
				 
				 $strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_fin_proj_data/0', maticon('add', 'spaced-text').' New Financial Projection', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				 $strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_contacts/0', maticon('add', 'spaced-text').' New Contact', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				 $strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_donor_relationships/0', maticon('add', 'spaced-text').' New Relationship', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			if (haspriveledge('donors', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'directories/Directories/donors', maticon($entitiesicons['ngo_donors'], 'spaced-text').' '.$entitiesnames['ngo_donors'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_donortypes', maticon($entitiesicons['ngo_donortypes'], 'spaced-text').' '.$entitiesnames['ngo_donortypes'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_fin_proj_data', maticon('label', 'spaced-text').' Financial Projection', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_donor_relationships', maticon('label', 'spaced-text').' Relationships', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_contacts', maticon('label', 'spaced-text').' Contacts', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');      
		
		
		return $strOut;
}


function ngovolunteersMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		if (haspriveledge('volunteers', 'ngo')) {
			if (haspriveledge('add', 'ngo')) {
					$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditvolunteer/0/0', maticon('add', 'spaced-text').' New Volunteer', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/volunteers', maticon('label', 'spaced-text').' Volunteers', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}
		return $strOut;
}

function ngofinancialsMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		if (haspriveledge('financials', 'ngo')) {
			if (haspriveledge('add', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditdonation/0/0', maticon('add', 'spaced-text').' New Donation', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditpledge/0/0', maticon('add', 'spaced-text').' New Pledge', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditaccount/0', maticon('add', 'spaced-text').' New Account', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditcampaign/0', maticon('add', 'spaced-text').' New Campaign', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_expenses/0', maticon('add', 'spaced-text').' New Expense', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_deposit_log/0', maticon('add', 'spaced-text').' New Deposit', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/donations', maticon('label', 'spaced-text').' Donations', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/pledges', maticon('label', 'spaced-text').' Pledges', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_gifts_pledge_schedule', maticon('label', 'spaced-text').' Pledge Schedules', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/accounts', maticon('label', 'spaced-text').' Accounts', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/campaigns', maticon('label', 'spaced-text').' Campaigns', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_expenses', maticon('label', 'spaced-text').' Expenses', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_deposit_log', maticon('label', 'spaced-text').' Deposit Logs', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_gift_categories', maticon('label', 'spaced-text').' Donation Categories', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			
		}

		

			return $strOut;
}

function ngocommunicationMenu($entitiesnames, $entitiesicons){
		$strOut = '';		
		$strOut .= anchor(NGO_PREFIX.'communication/Acknowledgements/sendacknowledgements', maticon('send', 'spaced-text').' Send '.$entitiesnames['ngo_acknowledgements'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		$strOut .= anchor(NGO_PREFIX.'communication/Acknowledgements/all', maticon($entitiesicons['ngo_acknowledgements'], 'spaced-text').' '.$entitiesnames['ngo_acknowledgements'], 'class="main-link collection-item borderless full-width waves-effect waves-dark"');

		

			return $strOut;
}

function ngosponsorsMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		if (haspriveledge('sponsors', 'ngo')) {
			if (haspriveledge('add', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_sponsor/0', maticon('add', 'spaced-text').' New Sponsor', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor(NGO_PREFIX.'sponsors/auto_charge/applyChargesOpts',   maticon('label', 'spaced-text').' Apply Charges', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'sponsors/batch_payments/batchSelectOpts', maticon('label', 'spaced-text').' Batch Payments', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_sponsor', maticon('label', 'spaced-text').' Sponsors', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}

			return $strOut;
}

function ngoclientsMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		if (haspriveledge('sponsors', 'ngo')) {
			if (haspriveledge('add', 'ngo')) {
				$strOut .= anchor(NGO_PREFIX.'forms/Formhandler/addeditsecondaryrecord/ngo_client_records/0', maticon('add', 'spaced-text').' New Client', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			}
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_client_records', maticon('label', 'spaced-text').' Clients', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_client_location', maticon('label', 'spaced-text').' Locations', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_client_status', maticon('label', 'spaced-text').' Statuses', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_client_xfers', maticon('label', 'spaced-text').' Transfers', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
			$strOut .= anchor(NGO_PREFIX.'directories/Directories/secondaryrecords/ngo_cprograms', maticon('label', 'spaced-text').' Client Programs', 'class="main-link collection-item borderless full-width waves-effect waves-dark"');
		}

			return $strOut;
}



function ngopreferencesMenu($entitiesnames, $entitiesicons){
		$strOut = '';
		$strOut .= anchor('preferences/User/preferences/ngo', maticon('settings','spaced-text').' My Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
		if (isadmin(FALSE)) {
			$strOut .= anchor('preferences/System/tablepreferences/ngo', maticon('settings','spaced-text').' Table Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark padded-left"');
			$strOut .= anchor(NGO_PREFIX.'admin/alists/showLists', maticon('label', 'spaced-text').' Lists', 'class="main-link collection-item borderless full-width waves-effect waves-dark" id="mb_ad_lists"');
			
			$strOut .= anchor('Preferences/System/inputpreferences/ngo', maticon('build', 'spaced-text').' Input Preferences', 'class="main-link collection-item borderless full-width waves-effect waves-dark" id="mb_ad_dev01"');
		}

			return $strOut;
}
