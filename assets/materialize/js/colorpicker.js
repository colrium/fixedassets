// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
  alert('Material Icon picker requires jquery');
}
else{

	$.widget( "collinslibs.materializecolorpicker", {
			window : $(window),
			document : window.document,
			$document : $(document),
			NAMESPACE : 'mcp',

			options: {
				materializecolors : {
					"red" 		: {"red lighten-5" : "#ffebee", "red lighten-4" : "#ffcdd2", "red lighten-3" : "#ef9a9a", "red lighten-2" : "#e57373", "red lighten-1" : "#ef5350", "red":"#f44336", "red darken-1":"#e53935", "red darken-2":"#d32f2f", "red darken-3":"#c62828", "red darken-4":"#b71c1c", "red accent-1":"#ff8a80", "red accent-2":"#ff5252", "red accent-3":"#ff1744", "red accent-4":"#d50000"},
					"pink" 		: {"pink lighten-5" : "#fce4ec", "pink lighten-4" : "#f8bbd0", "pink lighten-3" : "#f48fb1", "pink lighten-2" : "#f06292", "pink lighten-1" : "#ec407a", "pink" : "#e91e63", "pink darken-1":"#d81b60", "pink darken-2":"#c2185b", "pink darken-3":"#ad1457", "pink darken-4":"#880e4f", "pink accent-1":"#ff80ab", "pink accent-2":"#ff4081", "pink accent-3":"#f50057", "pink accent-4":"#c51162"},
					"purple"	: {"purple lighten-5" : "#f3e5f5", "purple lighten-4" : "#e1bee7", "purple lighten-3" : "#ce93d8", "purple lighten-2" : "#ba68c8", "purple lighten-1" : "#ab47bc", "purple" : "#9c27b0", "purple darken-1" : "#8e24aa", "purple darken-2" : "#7b1fa2", "purple darken-3" : "#6a1b9a", "purple darken-4" : "#4a148c", "purple accent-1" : "#ea80fc", "purple accent-2" : "#e040fb", "purple accent-3" : "#d500f9", "purple accent-4" : "#aa00ff", "deep-purple lighten-5" : "#ede7f6", "deep-purple lighten-4" : "#d1c4e9", "deep-purple lighten-3" : "#b39ddb", "deep-purple lighten-2" : "#9575cd", "deep-purple lighten-1" : "#7e57c2", "deep-purple" : "#673ab7", "deep-purple darken-1" : "#5e35b1", "deep-purple darken-2" : "#512da8", "deep-purple darken-3" : "#4527a0", "deep-purple darken-4" : "#311b92", "deep-purple accent-1" : "#b388ff", "deep-purple accent-2" : "#7c4dff", "deep-purple accent-3" : "#651fff", "deep-purple accent-4" : "#6200ea"},
					"indigo"	: {"indigo lighten-5" : "#e8eaf6", "indigo lighten-4" : "#c5cae9", "indigo lighten-3" : "#9fa8da", "indigo lighten-2" : "#7986cb", "indigo lighten-1" : "#5c6bc0", "indigo" : "#3f51b5", "indigo darken-1" : "#3949ab", "indigo darken-2" : "#303f9f", "indigo darken-3" : "#283593", "indigo darken-4" : "#1a237e", "indigo accent-1" : "#8c9eff", "indigo accent-2" : "#536dfe", "indigo accent-3" : "#3d5afe", "indigo accent-4" : "#304ffe"},
					"blue"		: {"blue lighten-5" : "#e3f2fd", "blue lighten-4" : "#bbdefb", "blue lighten-3" : "#90caf9", "blue lighten-2" : "#64b5f6", "blue lighten-1" : "#42a5f5", "blue" : "#2196f3", "blue darken-1" : "#1e88e5", "blue darken-2" : "#1976d2", "blue darken-3" : "#1565c0", "blue darken-4" : "#0d47a1", "blue accent-1" : "#82b1ff", "blue accent-2" : "#448aff", "blue accent-3" : "#2979ff", "blue accent-4" : "#2962ff", "light-blue lighten-5" : "#e1f5fe", "light-blue lighten-4" : "#b3e5fc", "light-blue lighten-3" : "#81d4fa", "light-blue lighten-2" : "#4fc3f7", "light-blue lighten-1" : "#29b6f6", "light-blue" : "#03a9f4", "light-blue darken-1" : "#039be5", "light-blue darken-2" : "#0288d1", "light-blue darken-3" : "#0277bd", "light-blue darken-4" : "#01579b", "light-blue accent-1" : "#80d8ff", "light-blue accent-2" : "#40c4ff", "light-blue accent-3" : "#00b0ff", "light-blue accent-4" : "#0091ea"},
					"cyan"		: {"cyan lighten-5" : "#e0f7fa", "cyan lighten-4" : "#b2ebf2", "cyan lighten-3" : "#80deea", "cyan lighten-2" : "#4dd0e1", "cyan lighten-1" : "#26c6da", "cyan" : "#00bcd4", "cyan darken-1" : "#00acc1", "cyan darken-2" : "#0097a7", "cyan darken-3" : "#00838f", "cyan darken-4" : "#006064", "cyan accent-1" : "#84ffff", "cyan accent-2" : "#18ffff", "cyan accent-3" : "#00e5ff", "cyan accent-4" : "#00b8d4"},
					"teal"		: {"teal lighten-5" : "#e0f2f1", "teal lighten-4" : "#b2dfdb", "teal lighten-3" : "#80cbc4", "teal lighten-2" : "#4db6ac", "teal lighten-1" : "#26a69a", "teal" : "#009688", "teal darken-1" : "#00897b", "teal darken-2" : "#00796b", "teal darken-3" : "#00695c", "teal darken-4" : "#004d40", "teal accent-1" : "#a7ffeb", "teal accent-2" : "#64ffda", "teal accent-3" : "#1de9b6", "teal accent-4" : "#00bfa5"},
					"green"		: {"green lighten-5" : "#e8f5e9", "green lighten-4" : "#c8e6c9", "green lighten-3" : "#a5d6a7", "green lighten-2" : "#81c784", "green lighten-1" : "#66bb6a", "green" : "#4caf50", "green darken-1" : "#43a047", "green darken-2" : "#388e3c", "green darken-3" : "#2e7d32", "green darken-4" : "#1b5e20", "green accent-1" : "#b9f6ca", "green accent-2" : "#69f0ae", "green accent-3" : "#00e676", "green accent-4" : "#00c853", "light-green lighten-5" : "#f1f8e9", "light-green lighten-4" : "#dcedc8", "light-green lighten-3" : "#c5e1a5", "light-green lighten-2" : "#aed581", "light-green lighten-1" : "#9ccc65", "light-green" : "#8bc34a", "light-green darken-1" : "#7cb342", "light-green darken-2" : "#689f38", "light-green darken-3" : "#558b2f", "light-green darken-4" : "#33691e", "light-green accent-1" : "#ccff90", "light-green accent-2" : "#b2ff59", "light-green accent-3" : "#76ff03", "light-green accent-4" : "#64dd17"},
					"lime"		: {"lime lighten-5" : "#f9fbe7", "lime lighten-4" : "#f0f4c3", "lime lighten-3" : "#e6ee9c", "lime lighten-2" : "#dce775", "lime lighten-1" : "#d4e157", "lime" : "#cddc39", "lime darken-1" : "#c0ca33", "lime darken-2" : "#afb42b", "lime darken-3" : "#9e9d24", "lime darken-4" : "#827717", "lime accent-1" : "#f4ff81", "lime accent-2" : "#eeff41", "lime accent-3" : "#c6ff00", "lime accent-4" : "#aeea00"},
					"yellow"	: {"yellow lighten-5" : "#fffde7", "yellow lighten-4" : "#fff9c4", "yellow lighten-3" : "#fff59d", "yellow lighten-2" : "#fff176", "yellow lighten-1" : "#ffee58", "yellow" : "#ffeb3b", "yellow darken-1" : "#fdd835", "yellow darken-2" : "#fbc02d", "yellow darken-3" : "#f9a825", "yellow darken-4" : "#f57f17", "yellow accent-1" : "#ffff8d", "yellow accent-2" : "#ffff00", "yellow accent-3" : "#ffea00", "yellow accent-4" : "#ffd600"},
					"amber"		: {"amber lighten-5" : "#fff8e1", "amber lighten-4" : "#ffecb3", "amber lighten-3" : "#ffe082", "amber lighten-2" : "#ffd54f", "amber lighten-1" : "#ffca28", "amber" : "#ffc107", "amber darken-1" : "#ffb300", "amber darken-2" : "#ffa000", "amber darken-3" : "#ff8f00", "amber darken-4" : "#ff6f00", "amber accent-1" : "#ffe57f", "amber accent-2" : "#ffd740", "amber accent-3" : "#ffc400", "amber accent-4" : "#ffab00"},
					"orange"	: {"orange lighten-5" : "#fff3e0", "orange lighten-4" : "#ffe0b2", "orange lighten-3" : "#ffcc80", "orange lighten-2" : "#ffb74d", "orange lighten-1" : "#ffa726", "orange" : "#ff9800", "orange darken-1" : "#fb8c00", "orange darken-2" : "#f57c00", "orange darken-3" : "#ef6c00", "orange darken-4" : "#e65100", "orange accent-1" : "#ffd180", "orange accent-2" : "#ffab40", "orange accent-3" : "#ff9100", "orange accent-4" : "#ff6d00", "deep-orange lighten-5" : "#fbe9e7", "deep-orange lighten-4" : "#ffccbc", "deep-orange lighten-3" : "#ffab91", "deep-orange lighten-2" : "#ff8a65", "deep-orange lighten-1" : "#ff7043", "deep-orange" : "#ff5722", "deep-orange darken-1" : "#f4511e", "deep-orange darken-2" : "#e64a19", "deep-orange darken-3" : "#d84315", "deep-orange darken-4" : "#bf360c", "deep-orange accent-1" : "#ff9e80", "deep-orange accent-2" : "#ff6e40", "deep-orange accent-3" : "#ff3d00", "deep-orange accent-4" : "#dd2c00"},
					"brown"		: {"brown lighten-5" : "#efebe9", "brown lighten-4" : "#d7ccc8", "brown lighten-3" : "#bcaaa4", "brown lighten-2" : "#a1887f", "brown lighten-1" : "#8d6e63", "brown" : "#795548", "brown darken-1" : "#6d4c41", "brown darken-2" : "#5d4037", "brown darken-3" : "#4e342e", "brown darken-4" : "#3e2723"},
					"grey"		: {"white" : "#ffffff", "grey lighten-5" : "#fafafa","grey lighten-4" : "#f5f5f5", "grey lighten-3" : "#eeeeee", "grey lighten-2" : "#e0e0e0", "grey lighten-1" : "#bdbdbd", "grey" : "#9e9e9e", "grey darken-1" : "#757575", "grey darken-2" : "#616161", "grey darken-3" : "#424242", "grey darken-4" : "#212121", "blue-grey lighten-5" : "#eceff1", "blue-grey lighten-4" : "#cfd8dc", "blue-grey lighten-3" : "#b0bec5", "blue-grey lighten-2" : "#90a4ae", "blue-grey lighten-1" : "#78909c", "blue-grey" : "#607d8b", "blue-grey darken-1" : "#546e7a", "blue-grey darken-2" : "#455a64", "blue-grey darken-3" : "#37474f", "blue-grey darken-4" : "#263238", "black" : "#000000"}
				},

				template : 	'<div class="mcp-container">\
										<div class="row mcp-wrapper">\
											<div class="col s12 mcp-head center-align">\
												<span class="mcp-head-title center-align"><i class="material-icons spaced-text">color_lens</i> Pallete</a></span>\
											</div>\
											<div class="col s12 mcp-pallete" id="mcp-pallete">\
												<div class="row">\
													<div class="col s12 mcp-active-color"><h2 class="full-width center-align mcp-active-color-name"></h2></div>\
													<div class="col s12 mcp-colors-wrapper"></div>\
												</div>\
											</div>\
										</div>\
								</div>',

				defaultcolor : '#FFFFFF',
				colorpickertemplate: '<div class="colorpicker">' +
							  '<div class="colorpicker-saturation"><i><b></b></i></div>' +
							  '<div class="colorpicker-hue"><i></i></div>' +
							  '<div class="colorpicker-alpha"><i></i></div>' +
							  '<div class="colorpicker-color"><div /></div>' +
							  '<div class="colorpicker-selectors"></div>' +
						  '</div>',
				showoninit: false,
				datatype: 'hex',
				width : 300,
				zIndex: 99999999999,
				offset: 10

			},

			 _create: function() {
				this.CLASS_INLINE  = this.NAMESPACE + '-inline',
				this.CLASS_DROPDOWN = this.NAMESPACE + '-dropdown',
				this.CLASS_TOP = this.NAMESPACE+'-top',
				this.CLASS_BOTTOM = this.NAMESPACE+'-bottom',
				this.CLASS_PLACEMENTS = [this.CLASS_TOP, this.CLASS_BOTTOM].join(' '),
				this.createPicker();
			},

			createPicker: function(){
				this.othermcps = $('body').find('.mcp-container');
				this.mcp_id = this.othermcps.length + 1;
				this.mcp_width = this.element.width();
				this.min_mcp_width = this.options.width;
				this.mcp_container = $(this.options.template);
				this.mcp_container.attr('id', 'mcp-'+this.mcp_id);

				this.mcpwrapper = $(this.mcp_container.find('.mcp-wrapper'));
				this.mcpcolorswrapper = $(this.mcp_container.find('.mcp-colors-wrapper'));
				this.mpchead = $(this.mcpwrapper.find('.mcp-head'));
				this.mcpheadtitle = $(this.mpchead.find('.mcp-head-title'));

				if (this.element.attr('value').length > 0) {
						
				}

				if ($(this.element).attr('colordatatype') === 'undefined') {
					this.datatype = this.options.datatype;
				}
				else{
					this.datatype = this.element.attr('colordatatype');
				}


				this.isshowing = false;

				var allcolors = this.options.materializecolors;

				for(colorgrp in allcolors){
					var colorgrpsection = $('<div />', {
												class:'row'
											});
					var grpcolors = allcolors[colorgrp];
						if(allcolors.hasOwnProperty(colorgrp)) {
							for(colorindex in grpcolors){
								var colorelement = $('<a />', {
														class: 'mcp_color  '+colorindex,
														colorhex: grpcolors[colorindex],
														colorname: colorindex,
														text: ''
													});
								colorelement.css('border-color', grpcolors[colorindex]);
								
								colorgrpsection.append(colorelement);
							}
						}
					this.mcpcolorswrapper.append(colorgrpsection);

				}
				this.colordoms = this.mcpcolorswrapper.find('mcp_color');
				
				this.mcp_container.insertAfter(this.element);
				

				this._initialize();	

				this._place();


			}, 
			_initialize:function(){
				if (this.element.is('input')) {
					if (this.element.attr('value').length > 0) {
						this.setCurrentColor(this.element.attr('value'));
					}

					this._on(this.element, {
						click: function(event){							
							this.showpicker();
						}, 
						focus: function(event){							
							this.showpicker();
						}
					});
				}
					

				this._on('.mcp_color', {
					mouseenter: function(event){
						var colorname = $(event.target).attr('colorname');
						var colorhex = $(event.target).attr('colorhex');
						var rgb = this.hexToRgb(colorhex);
						$(event.target).css('color', this._inversecolorhex(colorhex));
						
					},
					mouseleave: function(event){
						var colorname = $(event.target).attr('colorname');
						
					}
				});

				this._on(document, {
					click: function(event){
						var clickeddom = event.target;
						if (!$(clickeddom).is(this.element) && !$(clickeddom).is(this.mcp_container) && this.mcp_container.has(event.target).length === 0) {
							this.hidepicker();
						}
						else if($(clickeddom).hasClass('mcp_color')){							
							var clickedcolor;	
							if (this.datatype == 'hex') {
								clickedcolor = $(clickeddom).attr('colorhex');
							}
							else if(this.datatype == 'name'){
								clickedcolor = $(clickeddom).attr('colorname');
							}						
							
							this.setCurrentColor(clickedcolor);
						}
					}
				});

				this._on(this.element, {
					click: function(event){
						
					}
				});
			},

			hexToRgb: function(hex){
				var c;
				if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
					c= hex.substring(1).split('');
					if(c.length== 3){
						c= [c[0], c[0], c[1], c[1], c[2], c[2]];
					}
					c= '0x'+c.join('');
					return [(c>>16)&255, (c>>8)&255, c&255].join(',');
				}
				throw new Error('Bad Hex');
			},

			setCurrentColor: function(color){
				var colorDoms = $(this.mcpcolorswrapper.find('.mcp_color'));
				if (this.datatype == 'hex') {
					this.currentcolor = color;
					this.currentcolorname = this.namecolor(this.currentcolor);
					for(var i = 0; i < colorDoms.length; i++){
					
						if ($(colorDoms[i]).attr('colorhex') == color) {
							if (!$(colorDoms[i]).hasClass('active')) {
								$(colorDoms[i]).addClass('active');
							}
						}
						else{
							$(colorDoms[i]).removeClass('active');
						}
					}

					this.mpchead.css('background', this.currentcolor);
					this.mcp_container.css('background', this.currentcolor);
					this.mcp_container.css('border-color', this.currentcolor);
					this.mcpheadtitle.css('color', this._inversecolorhex(this.currentcolor));
					this.mcpheadtitle.text(this.currentcolorname);
					this._updateelement();
				}
				else if(this.datatype == 'name'){
					this.currentcolor = this.hexcolor(color);
					this.currentcolorname = color;

					for(var i = 0; i < colorDoms.length; i++){					
						if ($(colorDoms[i]).attr('colorname') == color) {
							if (!$(colorDoms[i]).hasClass('active')) {
								$(colorDoms[i]).addClass('active');
							}
						}
						else{
							$(colorDoms[i]).removeClass('active');
						}
					}

					this.mpchead.css('background', this.currentcolor);
					this.mcp_container.css('background', this.currentcolor);
					this.mcp_container.css('border-color', this.currentcolor);
					this.mcpheadtitle.css('color', this._inversecolorhex(this.currentcolor));
					this.mcpheadtitle.text(this.currentcolorname);
					this._updateelement();
				}

			},

			namecolor: function(hex){
				var name;
				name = '';
				var allcolors = this.options.materializecolors;
				for(colorgroup in allcolors){						
					for(colorname in allcolors[colorgroup]){
						if (allcolors[colorgroup][colorname] == hex) {
							name = colorname;
						}
					}
				}
				return name;
			},
			hexcolor: function(name){
				var hex;
				hex = '';
				var allcolors = this.options.materializecolors;
				for(colorgroup in allcolors){						
						for(colorname in allcolors[colorgroup]){							
							if (colorname == name) {
								hex = allcolors[colorgroup][colorname];
							}
						}
				}
				return hex;
			},


			_updateelement: function(){				
				if (this.element.is('input')) {
					if (this.datatype == 'name') {
						this.element.attr('value', this.currentcolorname);
					}
					else if (this.datatype == 'hex'){
						this.element.val(this.currentcolor);
					}
					if (this.element.attr('type') == 'text') {

						var elementLabel = this.element.siblings('label[for="'+this.element.attr('id')+'"]');
						var labeltext = elementLabel.text();
						elementLabel.css({'color': this.currentcolor});
						this.element.css({'color': this.currentcolor});
					}
				}
			},

			_place: function () {
				var options = this.options;
				var $element = this.element;
				var $picker = this.mcp_container;
				var containerWidth = this.$document.outerWidth();
				var containerHeight = this.$document.outerHeight();
				var elementWidth = $element.outerWidth();
				var elementHeight = $element.outerHeight();
				var width = $picker.width();
				var height = $picker.height();
				var offsets = $element.offset();
				var left = offsets.left;
				var top = offsets.top;
				var bottom = offsets.bottom;
				var offset = parseFloat(options.offset) || 15;
				var placement = this.CLASS_TOP;
				var postop = offset;

				if (top > height && top + elementHeight + height > containerHeight) {
				  postop = elementHeight + offset;
				  placement = this.CLASS_BOTTOM;
				}
				else if (containerHeight > (top + elementHeight + height)) {
				  postop = elementHeight + offset;
				  placement = this.CLASS_BOTTOM;
				}		 
				else {
				  postop = -height-offset;
				}
				
				$picker.removeClass(this.CLASS_PLACEMENTS).addClass(placement).css({
				  top: postop,
				  left: offset,
				  zIndex: parseInt(options.zIndex, 10)
				});
			},			

			showpicker:function(){
				if (!this.isshowing) {
					this.mcp_container.removeClass('hidden');
					this.mcp_container.addClass('open');
					this.isshowing = true;
				}
			},



			hidepicker:function(){
				if (this.isshowing) {
					this.mcp_container.removeClass('open');
					this.mcp_container.addClass('hidden');
					this.isshowing = false;
				}
			},
			_inversecolorhex: function(color){
				if (color.indexOf('#') === 0) {
					color = color.slice(1);
				}
				// convert 3-digit hex to 6-digits.
				if (color.length === 3) {
					color = color[0] + color[0] + color[1] + color[1] + color[2] + hex[2];
				}
				if (color.length !== 6) {
					throw new Error('Invalid HEX color.');
				}
				// invert color components
				var r = (255 - parseInt(color.slice(0, 2), 16)).toString(16),
					g = (255 - parseInt(color.slice(2, 4), 16)).toString(16),
					b = (255 - parseInt(color.slice(4, 6), 16)).toString(16);
				// pad each with zeros and return
				return '#' + this._padZero(r) + this._padZero(g) + this._padZero(b);

			},
			_inversecolorrgb: function(color){
				if (color.indexOf('#') === 0) {
					color = hex.slice(1);
				}
				// convert 3-digit hex to 6-digits.
				if (color.length === 3) {
					color = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
				}
				if (color.length !== 6) {
					throw new Error('Invalid HEX color.');
				}
				// invert color components
				var r = (255 - parseInt(hex.slice(0, 2), 16)).toString(16),
					g = (255 - parseInt(hex.slice(2, 4), 16)).toString(16),
					b = (255 - parseInt(hex.slice(4, 6), 16)).toString(16);
				return [r,g,b];    

			},
			_padZero: function(str, len){
				len = len || 2;
				var zeros = new Array(len).join('0');
				return (zeros + str).slice(-len);
			},

			typeOf: function(obj) {
				return toString.call(obj).slice(8, -1).toLowerCase();
			},

			isString: function(str) {
				return typeof str === 'string';
			},

			isNumber: function(num) {
				return typeof num === 'number' && !isNaN(num);
			},

			isUndefined: function(obj) {
				return typeof obj === 'undefined';
			}































	});
}