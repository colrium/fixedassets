// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
  alert('Material Icon picker requires jquery');
}
else{
	$.widget("collinslibs.importer", {
			window : $(window),
  			document : window.document,
  			$document : $(document),
			NAMESPACE : 'importer',
		    defaults: {
		    	entity: '',
		    	form: '',
		    	importfile: '',
		    	validateurl: '',
		    	fgcolor:'#ed7499',
		    	bgcolor: '#635c73',
		    	highlightColor: '#FFFFFF',
		    	pausecolorFg: "#ff9800",
		    	datapostname: 'record'
		    },
		    gaugeOptions : {
			    chart: {
			        type: 'solidgauge'
			    },
			    title: null,
			    pane: {
			        center: ['50%', '85%'],
			        size: '100%',
			        startAngle: -90,
			        endAngle: 90,
			        background: {
			            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
			            innerRadius: '60%',
			            outerRadius: '100%',
			            shape: 'arc'
			        }
			    },

			    tooltip: {
			        enabled: false
			    },

			    // the value axis
			    yAxis: {
			        stops: [
			            [0.1, '#f44336'], // red
			            [0.5, '#ff9800'], // orange
			            [0.9, '#4caf50'] // green
			        ],
			        lineWidth: 0,
			        minorTickInterval: null,
			        tickAmount: 2,
			        title: {
			            y: -70
			        },
			        labels: {
			            y: 16
			        }
			    },

			    plotOptions: {
			        solidgauge: {
			            dataLabels: {
			                y: 5,
			                borderWidth: 0,
			                useHTML: true
			            }
			        }
			    }
			},
		     _create: function(){		     	
		     	if (this.element.is('form')) {
		     		this._build();
		     	}		     	
			},
			

			_build: function(){
				var instance = this;

				instance.importerrors = [];
				instance.pagetitle = document.title;
				this.submitbtn = this.element.find('[type="submit"]');

				this.importers = $('body').find('.importer');
				this.importerinstanceid = this.importers.length + 1;
				this.importer_id = 'importer'+this.importerinstanceid;
				this.indicatorswrapper = $('<div />', {
											class: 'row importer',
											id: instance.importer_id+'-wrapper'
										});
				this.pbholder = $('<div />', {
									class: 'col s12 progressbar-wrapper'
								});

				this.pbelement = $('<div />', {
									class: 'col l12 m12 s12 progress-bar'
								});
				this.progressinfowrapper = $('<div />', {
									class: 'col s12  progress-info-wrapper'
								});
				this.cursorsinfowrapper = $('<div />', {
									class: 'col l3 m3 s12 cursors'
								});
				this.cursornametext = $('<h5 />', {
									class: 'grey-text full-width center-align cursorname'
								});
				this.progresstimenotifacationdom = $('<div />', {
									class: 'col l6 m6 s12 progress-time'
								});
				this.progresspercentagetext = $('<h3 />', {
									class: 'progress-percentage full-width center-align'
								});
				this.progresstimerdom = $('<div />', {
									class: 'progress-timer grey-text full-width center-align',
									id : 'progress-timer'
								});
				this.progressnotifacationsdom = $('<div />', {
									class: 'notifacation-holder full-width center-align'
								});
				this.cursorscounterwrapper = $('<div />', {
									class: 'col l3 m3 s12 cursors-counter'
								});
				this.cursorscountertext = $('<h5 />', {
									class: 'progress-counter grey-text full-width center-align'
								});
				this.importerbtnswrapper = $('<div />', {
									class: 'col s6 offset-s3 importer-btns-wrapper'
								});
				this.importerpausebtn = $('<a />', {
									class: 'btn importer-btn orange pause right',
									href: '#',
									text: ' Pause'
								});
				this.importercancelbtn = $('<a />', {
									class: 'btn importer-btn red cancel left',
									href: '#',
									text: ' Cancel'
								});
				this.importerpausebtnicon = $('<i />', {
												class: 'material-icons spaced-text pause-icon',
												text: 'pause_circle_outline'
											});
				this.importercancelbtnicon = $('<i />', {
												class: 'material-icons spaced-text cancel-icon',
												text: 'cancel'
											});
				//prepend icons to buttons
				this.importerpausebtn.prepend(this.importerpausebtnicon);
				this.importercancelbtn.prepend(this.importercancelbtnicon);

				//append buttons to buttons wrapper
				this.importerbtnswrapper.append(this.importerpausebtn, this.importercancelbtn);

				//append cursorcountertext to cursorcounter wrapper
				this.cursorscounterwrapper.append(this.cursorscountertext);

				//append progress, time and notifacation to progresstimenotifacationdom
				this.progresstimenotifacationdom.append(this.progresspercentagetext, this.progresstimerdom, this.progressnotifacationsdom);

				//append cursornametext to cursorsinfowrapper
				this.cursorsinfowrapper.append(this.cursornametext);

				//append info wrappers to info wrapper
				this.progressinfowrapper.append(this.cursorsinfowrapper, this.progresstimenotifacationdom, this.cursorscounterwrapper);

				//append progressdom to pbholder
				this.pbholder.append(this.pbelement);

				//append all wrappers  to indicatorswrapper
				this.indicatorswrapper.append(this.pbholder, this.progressinfowrapper, this.importerbtnswrapper);

				//insert importer after element
				this.element.append(this.indicatorswrapper);

				this.importerpausebtn.hide();
				this.importercancelbtn.hide();
	
				this._initialize();

			},

			_initialize: function(){
				var instance = this;
				this.importstarted = false;
				this.importcomplete = false;
				this.importing = false;
				this.paused = false;
				this.cancelled = false;
				this.defaults = $.extend({}, this.defaults, this.options);
				this.pbarwidth = this.pbelement.width();
				this.lastTimeStamp = Date.now();
				instance.starttime = Date.now();
                this.estRemainingTimeMillis = 0;
                              
				this.progressbar = new ElasticProgress(instance.pbelement, {
					colorFg: instance.defaults.fgcolor,
					colorBg: instance.defaults.bgcolor,
					highlightColor: instance.defaults.highlightColor,
					barHeight: 5,
					barStretch: 25,
					bleedTop: 120,
					width: instance.pbarwidth,
					bleedRight: 100,
					pausecolorFg : instance.pausecolorFg,
					buttonSize: 60,
					fontFamily: "Questrial",
					labelHeight: 35,
					labelTilt: 100,
					background:"transparent",
					textFail: "Import Failed",
					textComplete: "Import Complete",
					arrowHangOnFail: true
				});
				 

				this._on(this.element, {
					submit: function(e){
						e.preventDefault();
						instance.progressbar.open();
					}
				});

				this._on(instance.importerpausebtn, {
						click: function(e){
							e.preventDefault();
							if (instance.paused == false) {
								instance.element.trigger( "onpauseimport");
							}
							else{
								instance.element.trigger( "onresumeimport");
							}
							
						}
				});
				
				this._on(instance.importercancelbtn, {
						click: function(e){
							e.preventDefault();
							if (instance.cancelled == false) {
								instance.element.trigger( "oncancelimport");
							}
							else{
								instance.element.trigger( "oncancelimport");
							}
							
						}
				});

				//bind progress complete event
				this.element.bind('onimportcomplete', function(){
					instance.importstarted = true;
					instance.importcomplete = true;
					instance.importing = false;
					instance.paused = false;
					instance.cancelled = false;
					instance.importerpausebtn.hide();
					instance.importercancelbtn.hide();
					clearInterval(instance.timerinterval);
				});

				//bind progress start event
				this.element.bind('onimportstart', function(){
					instance.starttime = Date.now();
					instance.importstarted = true;
					instance.importerpausebtn.show();
					instance.importercancelbtn.show();
					// The speed gauge
					instance.speedChart = Highcharts.chart('progress-timer', Highcharts.merge(instance.gaugeOptions, {
					    yAxis: {
					        min: 0,
					        max: 0,
					        title: {
					            text: 'Import Speed'
					        }
					    },

					    credits: {
					        enabled: false
					    },
					    series: [{
					        name: 'Speed',
					        data: [0],
					        dataLabels: {
					            format: '<div style="text-align:center"><span style="font-size:25px;color:' +
					                ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
					                   '<span style="font-size:12px;color:silver">Recs/Sec</span></div>'
					        },
					        tooltip: {
					            valueSuffix: ' Recs/Sec'
					        }
					    }]

					}));
					
				});

				//bind progress pause event
				this.element.bind('onpauseimport', function(){
					instance.paused = true;
					instance.progressbar.pause();
						instance.importerpausebtn.removeClass('orange');
						instance.importerpausebtn.addClass('green');
						instance.importerpausebtnicon.text('play_circle_outline');
						instance.importerpausebtn.html('');
						instance.importerpausebtn.append(instance.importerpausebtnicon);
						instance.importerpausebtn.append(' Resume');
					instance.element.trigger("oncursorprogress", [instance.importcursor] );
				});

				//bind progress resume event
				this.element.bind('onresumeimport', function(){
					instance.paused = false;
					instance.progressbar.resumeprogress();
						instance.importerpausebtn.removeClass('green');
						instance.importerpausebtn.addClass('orange');
						instance.importerpausebtnicon.text('pause_circle_outline');
						instance.importerpausebtn.html('');
						instance.importerpausebtn.append(instance.importerpausebtnicon);
						instance.importerpausebtn.append(' Pause');

					instance.element.trigger("oncursorprogress", [instance.importcursor]);						
				});

				//bind progress resume event
				this.element.bind('oncancelimport', function(){
					instance.cancelled = true;
					instance.importstarted = true;
					instance.importcomplete = true;
					instance.importing = false;
					instance.paused = false;
					instance.progressbar.close();
					instance.importcursor = 0;
					instance.importerpausebtn.hide();
					instance.importercancelbtn.hide();
					clearInterval(instance.timerinterval);				
				});

				//bind progress update event
				this.element.bind('oncursorprogress', function(e, cursor){
					var nextcursor = cursor+1;
					var newTimeStamp = Date.now();
					var timeDifference = newTimeStamp-instance.lastTimeStamp;
						instance.estRemainingTimeMillis = timeDifference*(instance.lastimportcursor-(cursor+1));
						instance.timer();
						instance.lastTimeStamp = newTimeStamp;

					if (instance.paused != true && instance.cancelled != true && instance.importcomplete  != true) {
						if (nextcursor <= instance.lastimportcursor) {											
							instance.importcursor = cursor+1;
							instance.setProgress();
							instance.importloop();
						}
						if (nextcursor > instance.lastimportcursor ) {
							$(instance.element).trigger("onimportcomplete");							
						}
					}
					
						
				});



				//bind window unload event
				window.addEventListener("beforeunload", function(e) {
					if (instance.importstarted && !instance.importcomplete) {
						var notifacation =  noty({
			                            layout: "center",
			                            theme: "customnoty", 
			                            type: "alert",
			                            modal: true,                          
			                            text: 'Are you sure you want to leave?<br/> Your Import is not through yet',                                                                    
			                            animation: {
			                                open  : "animated bounceIn",
			                                close : "animated zoomOut",
			                                easing: "swing", 
			                                speed: 1000 
			                            },
			                            buttons: [
			                            	{
				                                addClass: 'waves-effect waves-light btn-flat red-text text-darken-4 white left', 
				                                text: '<i class="material-icons spaced-text">done</i> Close', 
				                                onClick: function($noty) {
				                                    $noty.close();
				                                    instance.progressbar.close();                                                     
				                                }
			                            	},
			                            	{
				                                addClass: 'waves-effect waves-light btn-flat green-text text-darken-4 white right', 
				                                text: '<i class="material-icons spaced-text">clear</i> Cancel', 
				                                onClick: function($noty) {
				                                    $noty.close();                                                      
				                                }
			                            	}
			                            ]

	                        });

						(e || window.event).returnValue = notifacation;
						return notifacation;
					}
				});


				this._on(window, { 
					resize: function(event){
						console.log(event); 
					}
				});

				instance.progressbar.onClick(function(){
					instance.progressbar.open();
				});

				this.progressbar.onOpen(function(){
					instance._postform();

				});

				this.progressbar.onComplete(function(){
					instance.progressbar.close();
				});



			},

			

			_postform: function(){
				var instance = this;
				
				var pb = this.progressbar;
				this.formdata = this.element.serializeArray();
				var ajaxerurl = this.defaults.validateurl;
				$.ajax({
					url : ajaxerurl,
					type: "POST",
					data : this.formdata,
					dataType : "JSON",
                    success:function(data){
     					if (data != null) {
                          //response received                          
                         	if (data.erroroccured == 0) {	                         	
								instance.assignedheaders = data.assignedheaders;
		                        instance.noofrecords = data.noofrecords;
		                        instance.records = data.records;
		                        instance.importurl = data.importurl;
		                        instance.entity = data.entity;                              
		                        instance.importcursor = 0;
		                        instance.importing = true;
								instance.paused = false;
								instance.lastimportcursor = data.noofrecords-1;
								instance.element.trigger('onimportstart');
								instance.importloop();
								                           
                            }
                            else{
                             //fail progress
                              instance.progressbar.fail();
                              var n = noty({
                                                layout: "center",
                                                theme: "customnoty", 
                                                type: "error",
                                                modal: false,                          
                                                text: data.errormsg,                                                                    
                                                animation: {
                                                      open  : "animated bounceIn",
                                                      close : "animated zoomOut",
                                                      easing: "swing", 
                                                      speed: 1000 
                                                },
                                                buttons: [{
                                                    addClass: 'waves-effect waves-light btn-flat red darken-4 white-text full-width', 
                                                    text: '<i class="material-icons spaced-text">refresh</i> Close and Retry', 
                                                    onClick: function($noty) {
                                                        $noty.close();
                                                        instance.element.trigger("oncancelimport");                                                                                                          
                                                    }
                                                  }]

                                            });
                              
                            }
                        }



                	},
                	error:function(e){
                        var phperror = e;
                        instance.progressbar.fail();
                        console.log(phperror);

                        
                      }
                });


			},

			importloop: function(){				
					var instance = this;
					var cursor = this.importcursor;
					var records = this.records;
					var cursorrecdata = [];
					var assignedheaders = this.assignedheaders;
					cursorrecdata.push({'name' : 'entity', 'value' : this.entity});
					var recordcursor = 0;
					for (var j in records[cursor]) {
				        if(recordcursor==0){
				          this.cursorname = records[cursor][j];
				        }
				        var recordcolname = instance.defaults.datapostname+"["+assignedheaders[recordcursor]+"]";
				        var recordcoldata = records[cursor][j];
				        cursorrecdata.push({'name' : recordcolname, 'value' : recordcoldata});
				        recordcursor++;
				    }
				    if (cursor == 0) {
				    	instance.element.trigger("onimportstart");
				    }
				    this.importrecord(cursorrecdata);


				
			},

			importrecord : function(recordpostdata){				
				var instance = this;				
				
				$.ajax({
					url : instance.importurl,
					type: "POST",
					data : recordpostdata,
					dataType : "JSON",
					success:function(data){						
						var cursor = instance.importcursor;
						$(instance.element).trigger( "oncursorprogress", [cursor] );
					},
					error:function(e){
						var phperror = e;
                        instance.progressbar.fail();
                        console.log(phperror);
					}
				});
			},

			setProgress: function(){
				var instance = this;
				var realcursor = this.importcursor+1;
				instance.percentageprogress = realcursor/instance.noofrecords*100;
				var progressbarvalue = instance.percentageprogress/100;
				instance.pbprogressvalue = progressbarvalue.toFixed(2);
				$(document).prop('title', '('+Math.round(instance.percentageprogress)+'%) '+instance.pagetitle);

				var percentage = instance.percentageprogress;
				instance.progressbar.setValue(instance.pbprogressvalue);
				instance.cursornametext.html(instance.cursorname);
				instance.progresspercentagetext.html(percentage.toFixed(2)+'%');
				instance.cursorscountertext.html(realcursor+'/'+instance.noofrecords);



			},
			onprogresschange : function(previous, next){
				
				var totalrecords = this.records.length;
				
				if (next < totalrecords) {
					while (this.importstarted && !this.paused && this.importing) {
						this.importcursor = next;
						this.importloop();
						
					}
				}
				else{
					this.importing = false;
				}
				
			},
			timer: function(){
				var instance = this;
				var currentTimeStamp = Date.now();
				var hours = Math.floor(instance.estRemainingTimeMillis / 36e5),
	            mins = Math.floor((instance.estRemainingTimeMillis % 36e5) / 6e4),
	            secs = Math.floor((instance.estRemainingTimeMillis % 6e4) / 1000);

	           instance.timetocompletion = "";
	           var secspassedfromstart = (currentTimeStamp - instance.starttime)/1000;

	           if(hours>0){
	              instance.timetocompletion = instance.timetocompletion+hours+' hrs ';
	           }
	           if(mins>0){
	              instance.timetocompletion = instance.timetocompletion+mins+' mins ';
	           }
	           
	           instance.timetocompletion = instance.timetocompletion+secs+' secs';

	           
	           if (instance.speedChart) {
	           		var point, newVal, inc;
	           		
	           		if (secspassedfromstart > 0) {
	           			instance.recordspersecond =  instance.importcursor/secspassedfromstart;
	           		}
	           		else{
	           			instance.recordspersecond = 1;
	           		}

	           		if (instance.toprecspersecspeed == undefined) {
	           			instance.toprecspersecspeed = instance.recordspersecond.toFixed(2);
	           		}
	           		else{
	           			if (instance.recordspersecond > instance.toprecspersecspeed) {
	           				instance.toprecspersecspeed = instance.recordspersecond.toFixed(2);
	           			}
	           		}
	           		instance.toprecspersecspeed = parseFloat(instance.toprecspersecspeed);


	           		instance.speedChart.yAxis[0].setExtremes(0, instance.toprecspersecspeed) ;
			        point = instance.speedChart.series[0].points[0];
			        newVal = instance.recordspersecond;

			        if (newVal > instance.lastimportcursor) {
			            newVal = instance.lastimportcursor;
			        }

			        newVal = newVal.toFixed(2);

			        point.update(parseFloat(newVal));
			    }


			},
			hexToRgb: function(hex, alpha){
				var c;
		        if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
		            c= hex.substring(1).split('');
		            if(c.length== 3){
		                c= [c[0], c[0], c[1], c[1], c[2], c[2]];
		            }
		            c= '0x'+c.join('');

		            if (alpha) {
		            	return 'rgba('+(c>>16)&255+','+(c>>8)&255+','+c&255+','+alpha+')';
		            }
		            else{
		            	return 'rgb('+(c>>16)&255+','+(c>>8)&255+','+c&255+')';
		            }
		        }
		        throw new Error('Bad Hex');
			}
			



	});
}

