// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
  alert('Material Icon picker requires jquery');
}
else{

	$.widget( "collinslibs.layoutbuilder", {
			window : $(window),
			document : window.document,
			$document : $(document),
			NAMESPACE : 'cllb',
			components: {
				'button' : $('<a />', {class : "waves-effect waves-dark btn", href:"#", text:'Button'}),
				'button_floating' : $('<a />', {class : "btn-floating btn-large waves-effect waves-light red", href:"#", text:'send'}),
				'breadcrumb' : $('<a />', {class : "breadcrumb", href:"#", text:'send'}),

				'card' : $('<div class="card blue-grey darken-1">\
								<div class="card-content white-text">\
								  <span class="card-title">Card Title</span>\
								  <p>I am a very simple card. I am good at containing small bits of information.\
								  I am convenient because I require little markup to use effectively.</p>\
								</div>\
								<div class="card-action">\
								  <a href="#">This is a link</a>\
								  <a href="#">This is a link</a>\
								</div>\
						  </div>'),

				'image card' : $('<div class="card">\
										<div class="card-image">\
										  <img src="'+base_url+'assets/materialize/images/fishcrocodile.jpg">\
										  <span class="card-title">Card Title</span>\
										</div>\
										<div class="card-content">\
										  <p>I am a very simple card. I am good at containing small bits of information.\
										  I am convenient because I require little markup to use effectively.</p>\
										</div>\
										<div class="card-action">\
										  <a href="#">This is a link</a>\
										</div>\
								  </div>'),

				'horizontal card' : $('<div class="card horizontal">\
										  <div class="card-image">\
											<img src="">\
										  </div>\
										  <div class="card-stacked">\
											<div class="card-content">\
											  <p>I am a very simple card. I am good at containing small bits of information.</p>\
											</div>\
											<div class="card-action">\
											  <a href="#">This is a link</a>\
											</div>\
										  </div>\
									  </div>'),

				'reveal card' : $('<div class="card">\
										<div class="card-image waves-effect waves-block waves-light">\
										  <img class="activator" src="">\
										</div>\
										<div class="card-content">\
										  <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span>\
										  <p><a href="#">This is a link</a></p>\
										</div>\
										<div class="card-reveal">\
										  <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>\
										  <p>Here is some more information about this product that is only revealed once clicked on.</p>\
										</div>\
								  </div>'),

				'panel card' : $('<div class="card-panel teal">\
									  <span class="white-text">I am a very simple card. I am good at containing small bits of information.\
									  I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.\
									  </span>\
								</div>'),

				'image chip' : $('<div class="chip">\
									<img src="" alt="Contact Person">\
									Jane Doe\
								  </div>'),

				'basic collection' : $('<ul class="collection">\
											<li class="collection-item">Alvin</li>\
											<li class="collection-item">Collins</li>\
											<li class="collection-item">Stephen</li>\
											 <li class="collection-item">Fridah</li>\
										</ul>'),

				'links collection' : $('<ul class="collection">\
											<a href="#" class="collection-item">Alvin</a>\
											<a href="#" class="collection-item active">Collins</a>\
											<a href="#" class="collection-item">Stephen</a>\
											<a href="#" class="collection-item">Fridah</a>\
										</ul>'),
				'input text' : $('<div class="input-field">\
									<input placeholder="Placeholder" id="first_name" type="text" class="validate">\
									<label for="first_name">First Name</label>\
								</div>'),

			},
			defaults: {
				selectorwidth: 320,
				gridindicator: $('<i />',{class:"material-icons col-icon", text:"aspect_ratio"}),
				gridboxedclass: 'container',
				boxed: true,
				gridnoofcolumns : 12,
				gridrowdom: $('<div />',{class:"row"}),
				griddomclass: 'col',
				griddomdevicesclasses: ["s", "m", "l"],
				tabs: ["containers", "components"],
				tabscontent: ["containers", "components"]
			},

			_create: function() {
			 var instance = this;
				this.elementwidth = this.element.width();		    	
				this._init();
				this._inittabs();
				this._initevents();
				$(".grid-container" ).draggable({
					revert: true,
					opacity: 0.35,
					scroll: true,
					zIndex: 999999999,
					start: function(event, ui) {
						var dragelement = $(this);
						instance.element.trigger("ondragstart", [event, ui, dragelement]);
					},
					stop: function(event, ui) {
						instance.element.trigger("ondragstop", [event, ui]);
					},
					drag: function(event, ui) {
						var dragelement = $(this);
						instance.element.trigger("ondrag", [event, ui, dragelement]);
					}
				});
				
			},

			_init: function() {
				var instance = this;
				this.isopen = false;
				this.defaults = $.extend({}, this.defaults, this.options);
				this.cllbs = $('body').find('.'+instance.NAMESPACE);
				this.cllbinstanceid = this.cllbs.length + 1;
				this.cllb_id = 'cllb'+this.cllbinstanceid;

				
				if (instance.element.is('div')) {
					$(instance.element).addClass('cllb');
					instance.element.attr('accept', 'any');
					instance.element.addClass('cllbdroppable');
				}
				
			},

			_inittabs: function() {
				var instance = this;
				var cllbtabs = this.defaults.tabs;
				this.cllbtabscontainer = $('<div />',{class: instance.NAMESPACE+"-tabs-container", id:instance.cllb_id});
				this.cllbtoggle = $('<a />',{href:"#", class: instance.NAMESPACE+"-tabs-toggle", text: "chevron_left"});
				this.cllbtabscontainer.append(instance.cllbtoggle);

				this.cllbtabsul = $('<ul />', {class:"tabs components-tabs"});
				this.cllbtabsdivs = [];
				for (var i = 0; i < cllbtabs.length; i++) {
					var tab = $('<li />', {class:"tab "+instance.NAMESPACE+"-tab"});
					tab.append($('<a />', {href:"#"+instance.NAMESPACE+"-tab-"+cllbtabs[i], text:cllbtabs[i]}));
					this.cllbtabsul.append(tab);
					this.cllbtabsdivs.push($('<div />', {class:"col s12 tab-content", id:instance.NAMESPACE+"-tab-"+cllbtabs[i]}));

				}
				this.cllbtabscontainer.append(instance.cllbtabsul);
				this._inittabscontent();
				$('body').append(instance.cllbtabscontainer);
			},
			 _inittabscontent: function() {
				var instance = this;
				for (var i = 0; i < instance.cllbtabsdivs.length; i++) {
					if (instance.defaults.tabs[i] == "containers") {
						instance.containersdom = instance.cllbtabsdivs[i];
						instance._initcontainers();
					}
					else if (instance.defaults.tabs[i] == "components"){
						instance.componentsdom = instance.cllbtabsdivs[i];
						instance._initcomponents();
					}
				}
			 },
			 _initevents: function() {
				var instance = this;
				instance._on(instance.cllbtoggle,{
					click: function(event){
						event.preventDefault();
						instance.toggle();


					}
				});

				instance.element.bind('ondrag', function(event, ui, dragelement){
					var dragposition = {'x': ui.clientX, 'y':ui.clientY};
					var isdragginggrid = false;
					if ($(dragelement).hasClass('grid-container')) {
						isdragginggrid = true;
					}

					instance.droppabledoms.each(function(index) {
						var dom = $(this);
						dom.removeClass('selected');
						if (isdragginggrid && dom.attr('accept')=='containers' || dom.attr('accept')=='any') {
							if(instance._isdraghover(dom, dragposition) == true){
								dom.addClass('selected');
							}
							
						}
					});
					

				});

				instance.element.bind('ondragstop', function(event, ui){
					var dragdom = $(ui.srcElement).clone();
					instance.droppabledoms.each(function(index) {
						var dom = $(this);
						var dragposition = {'x': ui.clientX, 'y':ui.clientY};
						var isdragginggrid = false;

						dom.removeClass('highlighted');

						if (dragdom.hasClass('grid-container')) {
							isdragginggrid = true;
						}

						if (isdragginggrid && dom.attr('accept')=='containers' || dom.attr('accept')=='any') {
							if(instance._isdraghover(dom, dragposition) == true){
								dragdom.removeAttr('style');
								dragdom.removeAttr('title');
								dragdom.addClass('sortable');
								$(dom).append(dragdom);
							}
							
						}
					});

				});

				instance.element.bind('ondragstart', function(event, ui, dragelement){
					instance.droppabledoms = $('body').find('.cllbdroppable');
					var isdragginggrid = false;
					if ($(dragelement).hasClass('grid-container')) {
						isdragginggrid = true;
					}

					instance.droppabledoms.each(function(index) {
						var dom = $(this);
						dom.removeClass('highlighted');
						if (isdragginggrid && dom.attr('accept')=='grid' || dom.attr('accept')=='any') {
							dom.addClass('highlighted');
						}
					});
				});


			 },
			 _initcontainers:function(){
				var instance = this;
				this.gridvariations = 	[{title: "1 column", doms: 1, domssizes:[12]},
										{title: "2 columns (50% - 50%)", doms: 2, domssizes:[6,6]},
										{title: "2 columns (33% - 67%)", doms: 2, domssizes:[4,8]},
										{title: "2 columns (67% - 33%)", doms: 2, domssizes:[8,4]},
										{title: "3 columns (33% - 33% - 33%)", doms: 3, domssizes:[4,4,4]},
										{title: "3 columns (25% - 50% - 35%)", doms: 3, domssizes:[3,6,3]},
										{title: "4 columns (25% - 25% - 25% - 25%)", doms: 4, domssizes:[3,3,3,3]}];

				var containercontenttemplate = $('<div />');
					containercontenttemplate.append(instance.defaults.gridindicator);
				for (var i = 0; i < this.gridvariations.length; i++) {
					var variation = instance.gridvariations[i];
					var variationdom = $('<div />', {class:"row grid-container", title:instance.gridvariations[i].title});
					
					for (var j in variation.domssizes) {
						var collength = variation.domssizes[j];
						var contentdom = $('<div />', {class:"col s"+collength+" grid-column", text:"crop_landscape"});
						variationdom.append(contentdom);
					}
					instance.containersdom.append(variationdom);
				}

				this.cllbtabscontainer.append(instance.containersdom);
				

			 },

			 _initcomponents:function(){
				var instance = this;
				var components = instance.components;

				for (var component in components) {
					var holderdom = $('<div />', {class:"row component-container", title:component.toUpperCase()});
					holderdom.append($(components[component]));
					instance.componentsdom.append(holderdom);
				}
				
				this.cllbtabscontainer.append(instance.componentsdom);
			 },



			 toggle:function(){
				var instance = this;
				var bodywidth = $("body").width();
				var elementovelapsize;
				var cllbright = instance.element.offset().left + instance.element.width();

				var cllbselectorsdomleft = instance.cllbtabscontainer.offset().left - instance.cllbtabscontainer.width();		     	
				var cllmarginright = bodywidth - cllbright;
				if (instance.isopen == false) {
					instance.cllbtabscontainer.css({"-webkit-transform" : "translateX(0%)", "transform" : "translateX(0%)", "width" : instance.defaults.selectorwidth+"px"});
					instance.cllbtoggle.text("chevron_right");
					instance.isopen = true;


				}
				else{
					instance.cllbtabscontainer.css({"-webkit-transform" : "translateX(100%)", "transform" : "translateX(100%)", "width" : 0});
					instance.cllbtoggle.text("chevron_left");
					instance.isopen = false;
				}
			 }, 
			 _isdraghover: function(dom, dragposition){
				var domoffsets = $(dom).offset();
				var domheight = $(dom).height();
				var domwidth = $(dom).width();
				var minX = domoffsets.left;
				var minY = domoffsets.top;
				var maxX = minX + domwidth;
				var maxY = minY + domheight;
				var draghover = false;
				var cllbtabscontainerleft = this.cllbtabscontainer.offset().left;


				if (dragposition.x >= minX && dragposition.x <= maxX && dragposition.y >= minY && dragposition.y <= maxY && dragposition.x < cllbtabscontainerleft) {
					draghover = true;
				}
				return draghover;

			 }









	});
}