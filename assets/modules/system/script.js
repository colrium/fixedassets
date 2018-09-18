$.userpriveledges={};
$.fn.extend ({
	toggledrawer : function(selector){
		
	},	
	loadpage : function(pageurl, renderdom, addtohistory=false) {			
			var instance = this;
			var redirecturl = false;
			var progressbar = $("<div />", {
				class:"progressbar"
			});
			
			if ($("header").find(".progressbar").length==0) {
				$("header").append(progressbar);
			}
			

			$(renderdom).bind('onloadpagesuccess', function(event, data){
				var datastring = String(data);
				if (datastring.startsWith($.fn.site_url())) {
					$.fn.loadpage(datastring, renderdom, true);
				}
				else{
					if (typeof(data) != "undefined") {
					$(renderdom).html(data);
						if (addtohistory) {
							window.history.pushState("", window.document.title, pageurl);  
						}
					}					
				}
				$.fn.initanimations();
				$(renderdom).unbind('onloadpagesuccess');
			});

			var ajaxpageloader = $.ajax({
					url : pageurl, 
					dataType: "html",
					beforeSend : function(jqXHR){                                    
						$(renderdom).css({"cursor":"wait !important"});
						$(".mdtoast").remove();
					},
					progress: function (){
						console.log("progress");
					},
					success: function(data, status, jqXHR){
						$(renderdom).trigger("onloadpagesuccess", [data]);
					},
					error:function(e){
						var errortext = e.responseText;
						var errorcode = e.status;
						
						if (errorcode != 200){
							$.fn.httperror(e);
							$(renderdom).trigger("onloadpagesuccess");
						}
						else{
							$(renderdom).trigger("onloadpagesuccess", [errortext]);
						}

						
					},

					complete: function(e){                               
						$('body').removeClass('page-is-changing');
						$(renderdom).css({"cursor":"auto !important"});
						$('.offcanvas-backdrop').remove();
						$("header").find(".progressbar").remove();
					}
				});
	},
	getuserpriveledges : function(priveledgemodule, callback) {
		var priviledges;
		var getpriviledgesurl = $.fn.site_url("api/Api/userpriveledges");
			$.userpriveledges[priveledgemodule] = {};
			$.ajax({
				url : getpriviledgesurl,
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				data : { "module": priveledgemodule},
				success: function(data){
					for (var key in data) {
						var allowed = false;
						if (data[key]["allowed"] == "1") {
							allowed = true;
						}
						$.userpriveledges[priveledgemodule][key] = allowed;					
					}
					if ($.isFunction(callback)) {					
						callback.call(this, $.userpriveledges[priveledgemodule]);
					}				
				},
				error:function(e){
					var errorcode = e.status;
					if (errorcode == 200){
						var data = {};
						try {
							data = JSON.parse(e.responseText);
							for (var key in data) {
								var allowed = false;
								if (data[key]["allowed"] == "1") {
									allowed = true;
								}
								$.userpriveledges[priveledgemodule][key] = allowed;					
							}
						}
						catch(err) {
							console.log(error);
						}
						finally {
							if ($.isFunction(callback)) {
								callback.call(this, $.userpriveledges[priveledgemodule]);
							}
						} 							
					}
					else{
						$.fn.httperror(e);
					}	
				}
			});
			

	},
	userhaspriveledge : function(priveledgemodule, priviledge, callback) {
		var haspriveledge = false;		
		$.fn.getuserpriveledges(priveledgemodule, function(data){
				if ($.userpriveledges.hasOwnProperty(priveledgemodule)){
					if ($.userpriveledges[priveledgemodule].hasOwnProperty(priviledge)) {
						haspriveledge = $.userpriveledges[priveledgemodule][priviledge];
					}
				}
				if ($.isFunction(callback)) {
					callback.call(this, haspriveledge);
				}
				
		});
		
	},	
	confirmdelete : function(entity, recordid, name, element) {
		var deleteurl = $.fn.site_url("utilities/Datautility/deleterecord/"+entity+"/"+recordid);
		var successful = false;
		
		var n = noty({
			layout: 'center',
			theme: 'customnoty', 
			type: 'error',
			timeout: 5000,
			modal: true, 
			text: '<i class="material-icons medium white-text">delete</i><br> Are you sure you want to delete : '+name+'<br>',                     
			animation: {
			open  : 'animated fadeIn',
			close : 'animated fadeOut',
			easing: 'swing', // easing
			speed: 500 // opening & closing animation speed
			},
			buttons: [
			{
				addClass: 'btn-flat white teal-text', 
				text: 'Delete', 
				onClick: function($noty) {
					$noty.close();
					$.ajax({
					url : deleteurl, 
					dataType: "html",
					beforeSend : function(){
						if (element.is('tr')) {

						}
						else{
					element.prepend('<div class="full-width"><div class="progress"><div class="indeterminate"></div></div></div>');
						}                                      
					},
					success: function(data, status, jqXHR){                             
					Materialize.toast(name+' Deleted', 2000);
					successful = true;
					element.remove();
					},
					complete:function(e){
						
					}

					});                              
				}
				},
				{
					addClass: 'btn-flat white red-text spacer', 
					text: 'Cancel', 
					onClick: function($noty) {
				$noty.close();
						
					}
				}
			]
		});
		return successful;


	},     
	initplugins : function() {
		  
		       
			$('.dropdown-button').dropdown();
			$('select').materialselect();
			$('a[href="#""]').click(function(e){
				e.preventDefault();
			});

			$('button[href="#""]').click(function(e){
				e.preventDefault();
			});
			$('.ajaxed').ajaxed();

			$('ul.tabs').tabs();
			$('.collapsible').collapsible();
			$(".iconpicker").materialiconpicker(); 
			$('.contexted').contexted();
			

			$("a").not('.ref-link').click(function(event) {                
				event.preventDefault();
				var rippler = $('.page-ripple');
				var loadurl = '#';
				var elem = $(event.currentTarget);        
				var currentfunction = event.handleObj.handler;
				if (!$.data(this, "plugin_ajaxed") ) {
					if (elem.attr('href') !== 'undefined') {
						loadurl = elem.attr('href');
					}
					if (typeof loadurl != 'undefined') {
						if (!loadurl.includes('#')) {               
					$.fn.loadpage(loadurl, '.pagebody', true);
						}              
					}
				}
				else{
					console.log(elem);
				}
			
			});

			

			

			$(".btn-search").click(function(){
					var container = $(this).parent(".searchbar");
					if(!container.hasClass("active")){
				container.addClass("active");
					}
				});
			$(".btn-closesearch").click(function(){
				var container = $(this).parent(".searchbar");
				if(container.hasClass("active")){
					container.removeClass("active");
				}
			});  



	},
	initanimations : function() {
			$.Velocity.RegisterEffect("vel.bouncein", {
				defaultDuration: 250,
				calls: [
					[{opacity: 0.1, scale: [0.3,0.3,0.3]}, 0], 
					[{scale: [1.1,1.1,1.1]}, 0.2],
					[{scale: [0.9,0.9,0.9]}, 0.4], 
					[{opacity: 1, scale: [1.03,1.03,1.03]}, 0.6], 
					[{scale: [0.97,0.97,0.97]}, 0.8],
					[{opacity: 1, scale: [1,1,1]}, 1]
				],
				reset: {scale:[1,1,0], opacity: 1}
			});

			$.Velocity.RegisterEffect("vel.zoomin", {
				defaultDuration: 250,
				calls: [[{scale:0.1, opacity:0.1}, 0], [{scale:1, opacity:1}, 1]]
			});
			$.Velocity.RegisterEffect("callout.slidedownin", {
			defaultDuration: 300,
			calls: [[{translateY : [0,-100], opacity:1 }, 1]]
			});
			$.Velocity.RegisterEffect("callout.slideupin", {
				defaultDuration: 300,
				calls: [[{translateY : [0,100], opacity:0.5}, 0.50], [{opacity:1}, 1]]
			});

			$.Velocity.RegisterEffect("callout.fadein", {
				defaultDuration: 300,
				calls: [[{opacity:0.1}, 0], [{opacity:1}, 1]]
			});
			
			$(".breadcrumb").velocity("vel.zoomin", {stagger:50});
			$(".slidedownin").velocity("callout.slidedownin");
			$(".slideupin").velocity("callout.slideupin", {delay:200});
			$(".bouncein").velocity("vel.zoomin", {delay:300});
			
			$(".btn-circle").not(".breadcrumb").velocity("vel.zoomin", {stagger:100});            
			$("i.material-icons.onviewanimated").velocity("vel.zoomin", {stagger:100});			
			$(".zoomin").velocity("vel.zoomin", {complete : function(elements){
				$(elements).removeClass("onviewanimated");
				$(elements).attr("style", "");			
			}});
			$(".input-field.onviewanimated").velocity("vel.zoomin", {delay:300, complete : function(elements){
				$(elements).removeClass("onviewanimated");
				$(elements).attr("style", "");			
			}});
			$(".action").velocity("vel.bouncein", {delay:50});
		
	},
	addreminder : function(entity, recordid) {
		var remindermodal = $('#addremindermodal');
		var formposturl = $.fn.site_url("modules/assistant/notifacations/Notifacations/adddbrecordreminder/"+entity+"/"+recordid);
		var remrecgetdataurl = $.fn.site_url("modules/assistant/notifacations/Notifacations/reminderrecorddetails/"+entity+"/"+recordid);
		var remrecimageurl = $.fn.site_url("files/Files/outputmainimage/"+entity+"/"+recordid);
		remindermodal.openModal();
		

		$.get(remrecgetdataurl, function(recdata){
			if (recdata.erroroccured) {
		$.toast({
				closewith: "click",
				title: "Error",
				text: recdata.message.alert,
				icon: recdata.message.icon,
				type:"error"                      
		});
			}
			else{
		remindermodal.find('#addreminderform').attr("action", formposturl);
		remindermodal.find('#reminderrecordidentity').html('<center><img src="'+remrecimageurl+'" class="xlarge circle transparent"></center><h3 class="full-width center-align grey-text" id="remrecordname">'+recdata.recordname+'</h3>');
		var notifylistselect = remindermodal.find('select#remindernotifylist');
		var usersoptions = [];
		for (var i = 0; i <= recdata.users.length - 1; i++) {
			var useroption = {
						 "value" : recdata.users[i].id,
						 "text" : recdata.users[i].username
					}
			usersoptions.push(useroption);              
		}
		$(notifylistselect).materialselect();
		if (usersoptions.length > 0) {
			$(notifylistselect).trigger("addselectoptions", [usersoptions]);
		}
		
		console.log('notifylistselect', notifylistselect);
		
			}
		}, 'json');
		Materialize.updateTextFields();
	},

	httperror : function(e) {
		var errortext = e.responseText;
		var errorcode = e.status;
		var notifytitle = "Error Code "+errorcode;
		var notifytext = "An Error Occured. Please refer to console for more details";
		var notifyicon = "error";
		var trueerror = false;
									
		if (errorcode == 404){
			errortext = "Page does not exist";
			notifytext = "Page does not exist";
			notifyicon = "link";
		}
		else if (errorcode == 401) {
			errortext = "Unauthorized";
			notifytext = "Unauthorized access. Request denied";
			notifyicon = "lock";
		}
		else if (errorcode == 423) {
			errortext = "Account Locked";
			notifytext = "Unauthorized access. Account locked. Request denied";
			notifyicon = "lock";			
		}
		else if (errorcode == 403) {
			errortext = "Forbiden";
			notifytext = "Forbidden request. Request denied";
			notifyicon = "block";
		}
		else if (errorcode == 408) {
			errortext = "Timeout";
			notifytext = "Request timed out";
			notifyicon = "access_time";
		}
		else if (errorcode == 500) {
			errortext = "Internal server error";
			notifytext = "Internal Server Error. Please refer to console for more details";
			notifyicon = "error_outline";
		}
		else if (errorcode == 503) {
			errortext = "Service Unavailable";
			notifytext = "Server could not be reached. Ensure you still have connection";
			notifyicon = "cloud_off";
		}
		else if (errorcode == 504 || errorcode == 408) {
			errortext = "Gateway Timeout";
			notifytext = "Server timed out. Ensure you still have connection";
			notifyicon = "cloud_off";
		}
		else if (errorcode == 503) {
			errortext = "Service Unavailable";
			notifytext = "Server could not be reached. Ensure you still have connection";
			notifyicon = "cloud_off";
		}
		console.log("Error", errortext);
		console.log("Response", e);
		$.notify({
			title: notifytitle,
			text: notifytext,
			icon: notifyicon,
			type: "error",
			onshow: function(){
				if (errorcode == 401) {
					var pageurl = $.fn.site_url("Login/login");
					$.fn.loadpage(pageurl);
				}
				else if (errorcode == 423) {
					var pageurl = $.fn.site_url("Login/unlock");
					$.fn.loadpage(pageurl);
				}
			},
			notifacations : ["app"],
			closewith: "click",
			timeout: 3000
		});
	}
});
$(function(){
	$.fn.initanimations();	
	window.onpopstate = function(e){
		if (window.history.state != null){ // This means it's page load
			var newurl = location.href;
			$.fn.loadpage(newurl, '.pagebody');
		}          
	}
});