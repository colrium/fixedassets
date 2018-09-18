// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
  alert('Contexted requires jquery');
}
else{

	$.widget( "collinslibs.contexted", {
			window : $(window),
  			document : window.document,
  			$document : $(document),
			NAMESPACE : 'contexted',
		    DEFAULTS: {
		    	width : 200,
				highlightclass: "highlighted",
				menuoptions : [],
				title: true,
				keyboard : true,
		    	onshow: null
		    },

		    _create: function(){
		    	var instance = this;
		    	instance.DEFAULTS = $.extend({}, instance.DEFAULTS, instance.options);
		    	instance.contextmenuopen = false;
		    	instance._build();
		    	instance._initoptions();
		    	instance._initevents();
		    },
		    _build: function(){
		    	var instance = this;
		    	instance.menuelement = $('<ul />', {
				   class: "contextmenu"
				});
				instance.optionelement = $('<li />');
		    	var contexttype = instance.element.attr('contexttype');
		    	var contextname = instance.element.attr('contextname');
		    	var contextdataid = instance.element.attr('contextdataid');
		    	if (typeof contexttype === 'undefined') {
		    		contexttype = 'none';
		    	}
		    	if (typeof contextname === 'undefined') {
		    		contextname = '';
		    	}
		    	if (typeof contextdataid === 'undefined') {
		    		contextdataid = '';
		    	}
		    	instance.contexttype = contexttype;	
		    	instance.contextname = contextname;
		    	instance.contextdataid = contextdataid;
		    	
		    	 	
		    },
		    _initoptions: function(){
		    	var instance = this;
		    	instance.menuoptions = instance.DEFAULTS.menuoptions;
		    	
		    },
		    _initevents: function(){
		    	var instance = this;

		    	

		    	instance._on(instance.element, {
		    		click: function(event){
		    			if (!instance.element.hasClass(instance.DEFAULTS.highlightclass)) {
		    				instance.element.addClass(instance.DEFAULTS.highlightclass);
		    			}
		    			instance.hide();

		    		},
		    		contextmenu: function(event) {
		    			event.preventDefault();
		    			instance.menuelement.css({"position": "fixed", "top":event.clientY, "left":event.clientX, "width":instance.DEFAULTS.width});
		    			instance.hide();
		    			instance.show();
			    	}

		    	});
		    		    	

		    },
		    show: function(){
		    	var instance = this;
		    	instance.contextmenuopen = true;
		    	instance.callbacks = {};
		    	instance.element.siblings().removeClass(instance.DEFAULTS.highlightclass);
		    	instance.element.addClass(instance.DEFAULTS.highlightclass);
		    	var menupositionclass = 'open bottom-right';
		    	instance.menuelement.addClass(menupositionclass);
		    			    			
		    	if (instance.DEFAULTS.title) {
		    		var titledom = $('<li/>', {class:'title', html:instance.contextname});
				    instance.menuelement.append(titledom);
				}
		    			var optionid = 0;
		    			for (var menuoption in instance.menuoptions) {
		    				var option = instance.menuoptions[menuoption];
				    		var optiontext = '';
				    		var optiondomid = 'option'+optionid;
				    		var optiondom = $('<li />');
				    		
				    		if (option.hasOwnProperty('icon')) {
				    			optiontext = optiontext+'<i class="material-icons spaced-text">'+option.icon+'</i> ';
				    		}
				    		if (option.hasOwnProperty('text')) {
				    			optiontext = optiontext+option.text;		    			
				    		}
				    		if (option.hasOwnProperty('colorclass')) {
				    			optiondom.addClass(option.colorclass);		    			
				    		}
				    		if (option.hasOwnProperty('callback')) {
				    			instance.callbacks[optionid] = option.callback;				    						
				    		}

				    		optiontext = optiontext+'';

				    		optiondom.append(optiontext);
				    		optiondom.attr('callback', optionid);
				    		

				    		instance.menuelement.append(optiondom);	
				    		 
							
  							optionid++;
				    		
				    	}
				    	
				instance.menuelement.find('li').each(function(index){
					var clickcallbackindex = $(this).attr("callback");
					if (typeof clickcallbackindex != "undefined") {
						clickcallbackindex = parseInt(clickcallbackindex);
						var callback = instance.callbacks[clickcallbackindex];
						$(this).click(function(e){
							e.preventDefault();
							callback.call($(this), instance.element, instance.contexttype, instance.contextname, instance.contextdataid);
							instance.hide();
						});
						

					}
					
				});

				$('body').append(instance.menuelement);	

				instance.menuelement.velocity('slideDown', {
						easing: [0.4, 0.0, 0.2, 1], 
						duration: 200,
						complete: function() {
							
						}
					});

				instance._on(document, {
					click: function(event){
						if (!$(event.target).is(instance.element) && !$(event.target).is(instance.menuelement) && instance.menuelement.has(event.target).length === 0) {
							instance.hide();
						}
					},
					scroll: function(event){						
						instance.hide();
					}

				});
				    	
		    },
		    hide: function(){
		    	var instance = this;
		    	instance.element.removeClass(instance.DEFAULTS.highlightclass);
		    	instance.menuelement.removeClass('open');
		    	instance.contextmenuopen = false;
		    	instance.menuelement.find('li').unbind();
		    	$(instance.menuelement).empty();
		    	$('ul.contextmenu').remove();
		    }


	});
}