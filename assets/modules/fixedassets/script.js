$(function(){

	var contextnamedom = $(".page-heading.loadcontext > span");
	var canedit = true, cancheckin = true, cancheckout = true, candispose = true, candelete = true;
	

	$.Velocity.RegisterEffect("loadanim.slideupin", {
		defaultDuration: 300,
		calls: [[{translateY : [0,100], opacity:0.5}, 0.50], [{opacity:1}, 1]]
	});

	$.fn.extend ({	
					renderdatacontent: function(element, datadom, data){
						var tabledom = $("<table/>",{id:"assetlistTable"});
						var theaddom = $("<thead/>");
						var tbodydom = $("<tbody/>");
						var rowdomtemplate = $("<tr/>");
						var celldomtemplate = $("<td/>");
						var cellsperrow = data.payloadfields.length;
						$(datadom).empty();
						$(datadom).append(tabledom);

						var headerrow = $("<tr/>");
						for (var i=0; i < data.payloadfields.length; i++) {
							var rowcell = $("<td/>",{
								html:data.payloadfields[i].setName
							});
							headerrow.append(rowcell);
						}
						theaddom.append(headerrow);

						for(var j=0; j < data.payload.length; j++){
							var rowdom = $("<tr/>",{
								class :"fassetcontexted",
								contexttype : "assetrecord",
								contextdataid : data.payload[j]["assetID"],
								contextname : data.payload[j]["assetCode"]
							});
							for (var i=0; i < data.payloadfields.length; i++) {
								var initialName = data.payloadfields[i].initialName;
								var rowcell = $("<td/>",{
									html:data.payload[j][initialName]
								});
								rowdom.append(rowcell);
							}
							if(data.payload[j]["assetPrimLoc"]==3){
								rowdom.addClass('deleted');
							}
							if(data.payload[j]["checkedOut"]==1){
								rowdom.addClass('checkedout');
							}
							if(data.payload[j]["isDisposed"]==1 || data.payload[j]["assetPrimLoc"]==2){
								rowdom.addClass('disposed');
							}
							tbodydom.append(rowdom);


						}


														

						tabledom.append(theaddom);
						tabledom.append(tbodydom);


						var factory = function($, DataTable) {
											/* Set the defaults for DataTables initialisation */
										$.extend(true, DataTable.defaults, {
											drawCallback: function(settings){
												$.fn.getuserpriveledges("fixedassets", function(permissions){
														var contextoptions = [];
														var checkedoutcontextoptions = [];
														var disposecontextoptions = [];
														var deletecontextoptions = [];


														if(permissions.edit){
															contextoptions.push({text:"Move/Copy", icon: "place", callback: function(event, contexttype, contextname, contextid){openassetmodal("movecopy", contextid, contextname);}});
															contextoptions.push({
																					text:"Edit", 
																					icon: "edit", 
																					callback: function(element, contexttype, contextname, contextid){
																						var editrecurl = $.fn.site_url("modules/fixedassets/forms/Formhandler/saveUpdateAsset")+"/"+contextid;
																						$.fn.loadpage(editrecurl, ".pagebody", true);
																					}
																				});
															contextoptions.push({
																					text:"Clone", 
																					icon: "content_copy", 
																					callback: function(element, contexttype, contextname, contextid){
																						var clonerecurl = $.fn.site_url("modules/fixedassets/forms/Formhandler/clone/")+"/"+contextid;
																					$.fn.loadpage(clonerecurl, ".pagebody", true);
																					}
																				});
														}
														if(permissions.checkin){
															checkedoutcontextoptions.push({
																text: "Checkin",
																icon: "arrow_downward",
																callback: function(element, contexttype, contextname, contextid){
																		openassetmodal("checkin", contextid, contextname);
																}
															});
														}

														if(permissions.checkout){
															contextoptions.push({
																text: "Checkout",
																icon: "arrow_upward",
																callback: function(element, contexttype, contextname, contextid){
																		openassetmodal("checkout", contextid, contextname);
																}
															});
														}
														if(permissions.dispose){
															contextoptions.push({
																text: "Dispose",
																icon: "remove_circle_outline",
																callback: function(element, contexttype, contextname, contextid){
																		openassetmodal("dispose", contextid, contextname);
																}
															});
														}
														if(permissions.delete){
															contextoptions.push({
																text: "Delete",
																icon: "delete",
																colorclass: "red-text",
																callback: function(element, contexttype, contextname, contextid){
																	$.fn.confirmdelete("fixedassets_assetlist", contextid, contextname, element);
																}
															});
														}

														$(".fassetcontexted:not(\".deleted, .checkedout, .disposed\")").contexted({
															menuoptions : contextoptions
														});
														$(".fassetcontexted.checkedout").contexted({
																menuoptions : $.extend({}, contextoptions, contextoptions)
														});  

													
												});
													
											}
										});
						}
						factory(jQuery, jQuery.fn.dataTable);
						tabledom.dataTable();
						
						var loadcontext = $(element).attr("contextname");
						var loadcontexticon = $(element).find(".material-icons.circle").textContent;
						$("#loadcontext").html("<span>"+loadcontext+"</span>");
						$('[contexttype = "assetrecord"]').click(function(){
								var recordid = $(this).attr("contextdataid");
								var recordname = $(this).attr("contextname");
								$.fn.recordmodal(recordid, recordname);
						});

					},
					recordmodal:function(recordid, recordname){

						var datafetchurl = $.fn.site_url("modules/fixedassets/Dashboard/record")+"/"+recordid;
						var editformurl = $.fn.site_url("modules/fixedassets/forms/Formhandler/saveUpdateAsset/")+"/"+recordid;
						var modaldom = $("<div/>",{
												class :"modal modal-fixed-footer modal-fixed-header",
												id : "fixedassets-record"
											});
						var modalheaderdom = $("<div/>",{class :"modal-header primary"});
						var modaltitledom = $("<h4/>",{class :"full-width center-align v-centered inverse-text", text : recordname});
						var modalbodydom = $("<div/>",{class :"modal-content grey lighten-4 paddless fixedassets-record-data"});
						var modalfooterdom = $("<div/>",{class :"modal-footer"});
						var modalclosebtndom = $("<a/>",{class :"modal-action modal-close waves-effect waves-red red-text btn-flat", html :"<i class=\"material-icons spaced-text\">cancel</i> Close"});
						var modalrefreshbtndom = $("<a/>",{class :"waves-effect waves-dark primary-text btn-flat", datadom: ".fixedassets-record-data", href : datafetchurl, html :"<i class=\"material-icons spaced-text\">autorenew</i> Refresh"});
						

						
						




						modalheaderdom.append(modaltitledom);
						modalfooterdom.append(modalrefreshbtndom, [modalclosebtndom]);
						modaldom.append(modalheaderdom, [modalbodydom, modalfooterdom]);

						$('body').find("#fixedassets-record").remove();
						modaldom.appendTo("body");
					 
						modaldom.openModal();

						modalrefreshbtndom.ajaxed({
							datatype: "JSON",
							progressbar: "header",
							progressbardom: modalbodydom,
							autoload: true,
							onload: function(element, datadom, data){
								var contentdom = $("<div/>",{class :"row paddless"});
								var tabscontainerdom = $("<div/>",{class :"col s12"});

								var tabsdom = $("<ul/>",{class :"tabs transparent"});
								var tabdetailsdom = $("<li/>",{class :"tab col s4 waves-effect", html : '<a href="#assetdetails-tab" class="active">Details</a>' });
								var tabdepreciationdom = $("<li/>",{class :"tab col s4 waves-effect", html : '<a href="#assetdepreciaction-tab">Depreciation</a>' });
								var tabnotebookdom = $("<li/>",{class :"tab col s4 waves-effect", html : '<a href="#assetnotebook-tab">Notebook</a>' });



								var tabdetailscontentdom = $("<div/>",{class :"col s12", id : "assetdetails-tab"});
								var tabdepreciationcontentdom = $("<div/>",{class :"col s12", id : "assetdepreciaction-tab"});
								var tabnotebookcontentdom = $("<div/>",{class :"col s12", id : "assetnotebook-tab"});



								var overviewdom = $("<div/>",{
																			class :"card horizontal", 
																			html : '<div class="card-image"><img src="'+data.image+'" style="height:200px; width:200px;"></div><div class="card-stacked"><div class="card-content"> <div class="row"><center>'+data.barcode+'</center> <h3 class="full-width center-align black-text">'+data.details.assetCode+'</h3> <h5 class="full-width black-text center-align"><span class="grey-text"><i class="material-icons spaced-text">label</i> '+data.fields.assetItem+'</span> <br/>'+data.details.assetItem+'</h5> <p class="black-text center-align"><span class="grey-text"><i class="material-icons spaced-text">subject</i> '+data.fields.assetDesc+'</span> <br/>'+data.details.assetDesc+'</p></div> </div></div>'
																		});

								var generalinfodom = $("<div/>",{
																			class :"col s6 data-card", 
																			html : '<div class="cardheader grey lighten-2"><h2 class="full-width center-align grey-text text-darken-3">Details</h2></div> <div class="cardbody white"><div class="row"><div class="col s4 grey-text">'+data.fields.assetID+'</div><div class="col s8">'+data.details.assetID+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetCat+'</div><div class="col s8">'+data.details.assetCat+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetPrimLoc+'</div><div class="col s8">'+data.details.assetPrimLoc+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetSecLoc+'</div><div class="col s8">'+data.details.assetSecLoc+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assignedTo+'</div><div class="col s8">'+data.details.assignedTo+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetStatus+'</div><div class="col s8">'+data.details.assetStatus+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetCondition+'</div><div class="col s8">'+data.details.assetCondition+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.auditStatus+'</div><div class="col s8">'+data.details.auditStatus+'</div></div><div class="row"><div class="col s4 grey-text">'+data.fields.rfidTag+'</div><div class="col s8">'+data.details.rfidTag+'</div></div></div>'
																		});

								var purchaseinfodom = $("<div/>",{
																			class :"col s6 data-card", 
																			html : '<div class="cardheader grey lighten-2"><h2 class="full-width center-align grey-text text-darken-3">Financial Information</h2></div> <div class="cardbody white"> <div class="row"><div class="col s4 grey-text">'+data.fields.lpoNumber+'</div><div class="col s8">'+data.details.lpoNumber+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.dtePurchased+'</div><div class="col s8">'+data.details.dtePurchased+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetDealer+'</div><div class="col s8">'+data.details.assetDealer+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetCost+'</div><div class="col s8">'+data.details.assetCost+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetCTax1+'</div><div class="col s8">'+data.details.assetCTax2+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.totalCost+'</div><div class="col s8">'+data.details.totalCost+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.replCost+'</div><div class="col s8">'+data.details.replCost+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetValue+'</div><div class="col s8">'+data.details.assetValue+'</div>  </div> </div>'
																		});


								tabdetailscontentdom.append(overviewdom, [generalinfodom,purchaseinfodom]);


								if (canedit=='1') {
										var editbtn = '<div class="fixed-action-btn"><a href="'+editformurl+'" class="btn-floating waves-effect waves-dark primary inverse-text"><i class="material-icons spaced-text">edit</i></a></div>';
										tabdetailscontentdom.append(editbtn);
								}


								var depreciationinfodom = $("<div/>",{
																			class :"col s12 data-card", 
																			html : '<div class="cardheader grey lighten-2"><h2 class="full-width center-align grey-text text-darken-3">Depreciation Variables</h2></div> <div class="cardbody white"> <div class="row"><div class="col s4 grey-text">Cost</div><div class="col s8">'+data.depreciation.variables.cost+'</div></div>  <div class="row"><div class="col s4 grey-text">Start Date</div><div class="col s8">'+data.depreciation.variables.date+'</div></div>  <div class="row"><div class="col s4 grey-text">P.A Rate (%)</div><div class="col s8">'+data.depreciation.variables.percentage+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.assetLYears+'</div><div class="col s8">'+data.depreciation.variables.life+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.deprMethod+'</div><div class="col s8">'+data.depreciation.variables.method+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.salvageVal+'</div><div class="col s8">'+data.depreciation.variables.salvagevalue+'</div></div>  <div class="row"><div class="col s4 grey-text">'+data.fields.bizUse+'</div><div class="col s8">'+data.depreciation.variables.use+'</div></div>   </div>'
																		});
								var depannualtabledom = $("<table/>",{
																						id:"assetannualdep",
																						class:"recordmodaltable",
																						html:'<thead><tr><td>From</td><td>To</td><td>Depreciation</td><td>Accumulated</td><td>Book Value</td></tr></thead>'
																				});

								var annualdeptablebody = $("<tbody/>");
								var annualdata = data.depreciation.annual;
								for (var i = 0; i < annualdata.length; i++) {
									var annualdatarow = '<tr><td>'+annualdata[i].from+'</td><td>'+annualdata[i].to+'</td><td>'+annualdata[i].depreciation+'</td><td>'+annualdata[i].accumulated+'</td><td>'+annualdata[i].bookvalue+'</td></tr>';
									annualdeptablebody.append(annualdatarow);
								}
								depannualtabledom.append(annualdeptablebody);


								var depmonthtabledom = $("<table/>",{
																						id:"assetmonthdep",
																						class:"recordmodaltable",
																						html:'<thead><tr><td>From</td><td>To</td><td>Depreciation</td><td>Accumulated</td><td>Book Value</td></tr></thead>'
																				});

								var monthdeptablebody = $("<tbody/>");
								var monthdepdata = data.depreciation.month;
								for (var i = 0; i < monthdepdata.length; i++) {
									var monthdatarow = '<tr><td>'+monthdepdata[i].from+'</td><td>'+monthdepdata[i].to+'</td><td>'+monthdepdata[i].depreciation+'</td><td>'+monthdepdata[i].accumulated+'</td><td>'+monthdepdata[i].bookvalue+'</td></tr>';
									monthdeptablebody.append(monthdatarow);
								}
								depmonthtabledom.append(monthdeptablebody);


								tabdepreciationcontentdom.append(depreciationinfodom, [depannualtabledom, depmonthtabledom]);





								var notebooktabledom = $("<table/>",{
																						id:"ntbktable",
																						class:"recordmodaltable",
																						html:'<thead><tr><td>'+data.notebook.fields.type+'</td><td>'+data.notebook.fields.description+'</td><td>'+data.notebook.fields.completion_date+'</td><td>'+data.notebook.fields.timestamp+'</td><td>'+data.notebook.fields.cost+'</td><td>'+data.notebook.fields.notes+'</td><td>'+data.notebook.fields.responsibility+'</td></tr></thead>'
																				});

								var notebooktablebody = $("<tbody/>");
								var notebookdata = data.notebook.entries;
								for (var i = 0; i < notebookdata.length; i++) {
									var notebookdatarow = '<tr><td>'+notebookdata[i].type+'</td><td>'+notebookdata[i].description.replace("\\n", "</br>")+'</td><td>'+notebookdata[i].completion_date+'</td><td>'+notebookdata[i].timestamp+'</td><td>'+notebookdata[i].cost+'</td><td>'+notebookdata[i].notes+'</td><td>'+notebookdata[i].responsibility+'</td></tr>';
									notebooktablebody.append(notebookdatarow);
								}
								notebooktabledom.append(notebooktablebody);

								tabnotebookcontentdom.append(notebooktabledom);
								




								$(datadom).empty();
								tabsdom.append(tabdetailsdom, [tabdepreciationdom, tabnotebookdom]);
								tabscontainerdom.append(tabsdom);
								contentdom.append(tabscontainerdom, [tabdetailscontentdom, tabdepreciationcontentdom, tabnotebookcontentdom]);
								$(datadom).append(contentdom);
								tabsdom.tabs();

								notebooktabledom.dataTable();
								depannualtabledom.dataTable();
								depmonthtabledom.dataTable();
								
								

							}
						});

					}

		});

	$(".datacriteria").ajaxed({
		doubleclick: false,
		datatype: "JSON",
		onload: function(element, datadom, data){
			var payload = data;
			var payloadsize = data.length;
			
			
			var criteria = $(element).data("criteria");
			var criterianame = $(element).data("criterianame");
			var criteriaid = $(element).data("criteriaid");
			var criteriapk = $(element).data("criteriapk");
			var criteriacontext = $(element).data("criteriacontext");
			var criteriaicon = $(element).data("criteriaicon");


			
			$(datadom).empty();
			var criteriadom = $('<ul />', {'class':'collection full-width no-border onviewanimated'});
			if (criteria != "none") {
				if (payloadsize > 0) {					
					for (var i= 0; i < payloadsize; i++) {
						var criteriahref = $.fn.site_url("modules/fixedassets/Dashboard/jsonassets/"+criteria+"/"+payload[i][criteriapk]);
						var criteriaentryname = payload[i][criteriaid];
						var criteriaentrydom = $('<li/>', {
													'class': 'collection-item avatarlink full-width borderless criterialoader contextedloader onviewanimated waves-effect waves-dark',
													'href' : criteriahref,
													'datadom' : '#assetList',
													'contextname' : criteriaentryname,
													'contexttype' : criteria,
													'contextdataid' : payload[i][criteriapk],
													'html' : '<i class="material-icons circle">'+criteriaicon+'</i><span class="title">'+payload[i][criteriaid]+'</span><span class="secondary-content">'+payload[i]["assetID_count"]+'</span>'
											});
						criteriadom.append(criteriaentrydom);

					}
					

				}
				else{
					criteriadom = $('<div />', {
						'class': 'full-width center-align no-border onviewanimated',
						'html': '<i class="material-icons onviewanimated large-text grey-text">folder_open</i><br><h5 class="grey-text full-width center-align onviewanimated"> No Existing '+criterianame+'</h5>'
					});
					
				}
			}
			else{
				var allcriteriaentrydom = $('<li/>', {
													'class': 'collection-item avatarlink full-width borderless criterialoader onviewanimated waves-effect waves-dark',
													'href' : $.fn.site_url("modules/fixedassets/Dashboard/jsonassets/all/all"),
													'datadom' : '#assetList',
													'contextname' : criteriaentryname,
													'contexttype' : criteria,
													'contextdataid' : 'all',
													'html' : '<i class="material-icons circle">'+criteriaicon+'</i><span class="title">All</span><span class="secondary-content">'+payload+'</span>'
											});
				var disposedcriteriaentrydom = $('<li/>', {
													'class': 'collection-item avatarlink full-width borderless criterialoader onviewanimated waves-effect waves-dark',
													'href' : $.fn.site_url("modules/fixedassets/Dashboard/jsonassets/isDisposed/1"),
													'datadom' : '#assetList',
													'contextname' : "Disposed",
													'contexttype' : "",
													'contextdataid' : '',
													'html' : '<i class="material-icons circle">folder_open</i><span class="title">Disposed</span><span class="secondary-content">0</span>'
											});
				criteriadom.append(allcriteriaentrydom, [disposedcriteriaentrydom]);
				$.get($.fn.site_url("api/Api/getrecordscount?entity=fixedassets_assetlist&filter=isDisposed&is=1"), function(disposeddata){
					disposedcriteriaentrydom.find(".secondary-content").text(disposeddata);
				});
				
					

			}

			$(datadom).append(criteriadom);
					criteriadom.velocity("loadanim.slideupin", {
						complete : function(elements){
							$(elements).removeClass("onviewanimated");	
						}
					});
					criteriadom.find(".onviewanimated").velocity("loadanim.slideupin", {
						stagger:100,
						complete : function(elements){

							$(elements).removeClass("onviewanimated");
							
						}
					});

					criteriadom.find(".criterialoader").ajaxed({
						doubleclick: false,
						datatype: "JSON",
						onload: function(element, datadom, data){
							var entrycontextname = $(element).attr("contextname");
							contextnamedom.text(entrycontextname);
							$.fn.renderdatacontent(element, datadom, data);
						}
					});

					$.fn.getuserpriveledges("fixedassets", function(permissions){
						var contextoptions = [];
						if(permissions.edit){							
							contextoptions.push({
								text:"Edit", 
								icon: "edit", 
								callback: function(event, contexttype, contextname, contextid){
									var editrecurl = $.fn.site_url("modules/fixedassets/forms/FormHandler/addeditsecondaryrecord/")+"/"+criteriacontext+"/"+contextid;
									$.fn.loadpage(editrecurl, ".pagebody", true);
								}
							});
						}
						if(permissions.delete){
							
							contextoptions.push({
								text:"Delete", 
								icon: "delete",
								colorclass:"red-text", 
								callback: function(element, contexttype, contextname, contextid){
									$.fn.confirmdelete(criteriacontext, contextid, contextname, element);
								}
							});
						}
						$(".contextedloader").contexted({
							menuoptions : contextoptions
						});  
					});
			
				
			var elementhtml =  $(element).html();
			$("#viewcriteriabtn").html(elementhtml);
		}
	});
});