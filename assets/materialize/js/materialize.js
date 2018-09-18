/*!
 * Materialize v0.97.7 (http://materializecss.com)
 * Copyright 2014-2015 Materialize
 * MIT License (https://raw.githubusercontent.com/Dogfalo/materialize/master/LICENSE)
 */
// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
var jQuery;
// Check if require is a defined function.
if (typeof(require) === 'function') {
	jQuery = $ = require('jquery');
// Else use the dollar sign alias.
} 
else {
	jQuery = $;
}
};
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing, {
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;if ((t/=d)==1) return b+c;if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;if ((t/=d)==1) return b+c;if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;if ((t/=d/2)==2) return b+c;if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	},
	easeInOutMaterial: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return c/4*((t-=2)*t*t + 2) + b;
	}
});

;(function(factory) {
	if (typeof define === 'function' && define.amd) {
		define(['jquery', 'hammerjs'], factory);
	} else if (typeof exports === 'object') {
		factory(require('jquery'), require('hammerjs'));
	} else {
		factory(jQuery, Hammer);
	}
}(function($, Hammer) {
	function hammerify(el, options) {
		var $el = $(el);
		if(!$el.data("hammer")) {
			$el.data("hammer", new Hammer($el[0], options));
		}
	}

	$.fn.hammer = function(options) {
		return this.each(function() {
			hammerify(this, options);
		});
	};

	// extend the emit method to also trigger jQuery events
	Hammer.Manager.prototype.emit = (function(originalEmit) {
		return function(type, data) {
			originalEmit.call(this, type, data);
			$(this.element).trigger({
				type: type,
				gesture: data
			});
		};
	})(Hammer.Manager.prototype.emit);
}));
;// Required for Meteor package, the use of window prevents export by Meteor
(function(window){
if(window.Package){
	Materialize = {};
} else {
	window.Materialize = {};
}
})(window);


// Unique ID
Materialize.guid = (function() {
function s4() {
	return Math.floor((1 + Math.random()) * 0x10000)
	.toString(16)
	.substring(1);
}
return function() {
	return s4() + s4() + s4() + s4() + s4() + s4();
};
})();

(function(){

	var ConvertBase = function (num) {
		return {
			from : function (baseFrom) {
				return {
					to : function (baseTo) {
						return parseInt(num, baseFrom).toString(baseTo);
					}
				};
			}
		};
	};
		
	// binary to decimal
	ConvertBase.bin2dec = function (num) {
		return ConvertBase(num).from(2).to(10);
	};
	
	// binary to hexadecimal
	ConvertBase.bin2hex = function (num) {
		return ConvertBase(num).from(2).to(16);
	};
	
	// decimal to binary
	ConvertBase.dec2bin = function (num) {
		return ConvertBase(num).from(10).to(2);
	};
	
	// decimal to hexadecimal
	ConvertBase.dec2hex = function (num) {
		return ConvertBase(num).from(10).to(16);
	};
	
	// hexadecimal to binary
	ConvertBase.hex2bin = function (num) {
		return ConvertBase(num).from(16).to(2);
	};
	
	// hexadecimal to decimal
	ConvertBase.hex2dec = function (num) {
		return ConvertBase(num).from(16).to(10);
	};
	
	this.ConvertBase = ConvertBase;
	
})(this);


// Colors
Materialize.colors = {
	hextorgb : function(hex) {
		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			return r + r + g + g + b + b;
		});
		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? parseInt(result[1], 16)+','+parseInt(result[2], 16)+','+parseInt(result[3], 16) : "0,0,0";
	},
	rgbtohex : function(r, g, b) {
		var hexr = Number(r).toString(16);
		var hexg = Number(g).toString(16);
		var hexb = Number(b).toString(16);
		if (hexr.length < 2) {
			hexr = "0" + hexr;
		}
		if (hexg.length < 2) {
			hexg = "0" + hexg;
		}
		if (hexb.length < 2) {
			hexb = "0" + hexb;
		}
		return "#" + hexr + hexg + hexb;
	},
	darken : function(color, amt) {
		amt = amt*16;
		color = this.hextorgb(color);
		color = color.split(",");
		

		var r = Math.round(parseInt(color[0]) - amt);
		if ( r > 255 ) r = 255;
		else if(r < 0) r = 0;

		var g = Math.round(parseInt(color[1]) - amt);
		if ( g > 255 ) g = 255;
		else if( g < 0 ) g = 0;

		var b = Math.round(parseInt(color[2]) - amt);

		if ( b > 255 ) b = 255;
		else if(b < 0) b = 0;

		return this.rgbtohex(r, g, b);

	},
	lighten : function(color, amt) {
		amt = amt*16;
		color = this.hextorgb(color);
		color = color.split(",");
		

		var r = Math.round(parseInt(color[0]) + amt);
		if ( r > 255 ) r = 255;
		else if(r < 0) r = 0;

		var g = Math.round(parseInt(color[1]) + amt);
		if ( g > 255 ) g = 255;
		else if( g < 0 ) g = 0;

		var b = Math.round(parseInt(color[2]) + amt);

		if ( b > 255 ) b = 255;
		else if(b < 0) b = 0;

		return this.rgbtohex(r, g, b);

	},
	intercept : function(a, b, intercept){
		var usePound = false;
		if (typeof intercept == "undefined") {
			intercept = 0.5;
		}
		if (a.startsWith("#")) {
			a = this.hextorgb(a);
			usePound = true;
		}
		if (b.startsWith("#")) {
			b = this.hextorgb(b);
			usePound = true;
		}
		if (a == null) {}
		a = a.split(",");
		b = b.split(",");
		for (var i = 0; i < a.length; i++) {
			a[i] = parseInt(a[i]);
			b[i] = parseInt(b[i]);
		}
		var c = new Array(3);
		c[0] = Math.round(a[0]+((b[0] - a[0])*intercept));
		c[1] = Math.round(a[1]+((b[1] - a[1])*intercept));
		c[2] = Math.round(a[2]+((b[2] - a[2])*intercept));

		
		var result = c[0]+','+c[1]+','+c[2];
		if(usePound) {
			result = this.rgbtohex(c[0],c[1],c[2]);
		}
		return result;
	}
}


Materialize.elementOrParentIsFixed = function(element) {
	var $element = $(element);
	var $checkElements = $element.add($element.parents());
	var isFixed = false;
	$checkElements.each(function(){
		if ($(this).css("position") === "fixed") {
			isFixed = true;
			return false;
		}
	});
	return isFixed;
};

// Velocity has conflicts when loaded with jQuery, this will check for it
var Vel;
if ($) {
Vel = $.Velocity;
} else if (jQuery) {
Vel = jQuery.Velocity;
} else {
Vel = Velocity;
}

	var screenwidth = $(window).width();
	var defaultribbonheight = fontsize*20;
	var cardbodyoffset = fontsize*9.5;
	var collapsingoffset = fontsize*10.5;
		if (screenwidth > 600) {
			$(".content-page > .cardbody").scroll(function(e) {
					
				var ribbonheight = defaultribbonheight;
				var firstelem = $(this).children().get(0);
				var yScrollOffset =  (($(firstelem).position().top - $(this).offset().top))-fontsize;
				if (yScrollOffset == 0) {
					ribbonheight = defaultribbonheight;
				}
				else{
					ribbonheight = cardbodyoffset + yScrollOffset;
				}	
				
				console.log("yScrollOffset", yScrollOffset);
				
				if (ribbonheight <= cardbodyoffset){
					ribbonheight = cardbodyoffset;				
				}
				else if (ribbonheight > defaultribbonheight){
					ribbonheight = defaultribbonheight;
				}
				
				$(".ribbon").css({"height": ribbonheight});
				$(".ribbon").trigger('resize');
			});
			
		}
			
	


;(function ($) {

$.fn.collapsible = function(options) {
	var defaults = {
		accordion: undefined
	};

	options = $.extend(defaults, options);


	return this.each(function() {

	var $this = $(this);

	var $panel_headers = $(this).find('> li > .collapsible-header');

	var collapsible_type = $this.data("collapsible");

	// Turn off any existing event handlers
	 $this.off('click.collapse', '> li > .collapsible-header');
	 $panel_headers.off('click.collapse');


	 /****************
	 Helper Functions
	 ****************/

	// Accordion Open
	function accordionOpen(object) {
		$panel_headers = $this.find('> li > .collapsible-header');
		if (object.hasClass('active')) {
			object.parent().addClass('active');
		}
		else {
			object.parent().removeClass('active');
		}
		if (object.parent().hasClass('active')){
			var staggeredlists = object.find('#staggered');
			if (staggeredlists.length > 0) {
				object.siblings('.collapsible-body').stop(true,false).slideDown({ 
					duration: 350, 
					easing: "easeInQuint", 
					queue: false, 
					start: function() { 
						Materialize.showStaggeredList('#staggered');
					}, 
					complete: function() {
					$(this).css('options', '');}});
			}
			else{
				object.siblings('.collapsible-body').stop(true,false).slideDown({ duration: 350, easing: "easeInQuint", queue: false, complete: function() {$(this).css('height', '');}});
				$panel_headers.find('.accordion-toggle').text('remove');
			}
		
		}
		else{
		object.siblings('.collapsible-body').stop(true,false).slideUp({ duration: 350, easing: "easeOutQuint", queue: false, complete: function() {$(this).css('height', '');}});
		$panel_headers.find('.accordion-toggle').text('add');
		}
		$panel_headers.not(object).find('.accordion-toggle').text('add');
		$panel_headers.not(object).removeClass('active').parent().removeClass('active');
		$panel_headers.not(object).parent().children('.collapsible-body').stop(true,false).slideUp(
		{
			duration: 350,
			easing: "easeOutQuint",
			queue: false,
			complete:function() {
				$(this).css('height', '');
			}
		});
	}
	

	// Expandable Open
	function expandableOpen(object) {
		if (object.hasClass('active')) {
			object.parent().addClass('active');
		}
		else {
			object.parent().removeClass('active');
		}
		if (object.parent().hasClass('active')){
		object.siblings('.collapsible-body').stop(true,false).slideDown({ duration: 350, easing: "easeOutQuart", queue: false, complete: function() {$(this).css('height', '');}});
		}
		else{
		object.siblings('.collapsible-body').stop(true,false).slideUp({ duration: 350, easing: "easeOutQuart", queue: false, complete: function() {$(this).css('height', '');}});
		}
	}

	/**
	 * Check if object is children of panel header
	 * @param{Object}object Jquery object
	 * @return {Boolean} true if it is children
	 */
	function isChildrenOfPanelHeader(object) {

		var panelHeader = getPanelHeader(object);

		return panelHeader.length > 0;
	}

	/**
	 * Get panel header from a children element
	 * @param{Object} object Jquery object
	 * @return {Object} panel header object
	 */
	function getPanelHeader(object) {

		return object.closest('li > .collapsible-header');
	}

	/*****End Helper Functions*****/



	// Add click handler to only direct collapsible header children
	$this.on('click.collapse', '> li > .collapsible-header', function(e) {
		var $header = $(this),
			element = $(e.target);

		if (isChildrenOfPanelHeader(element)) {
		element = getPanelHeader(element);
		}

		element.toggleClass('active');

		if (options.accordion || collapsible_type === "accordion" || collapsible_type === undefined) { // Handle Accordion
		accordionOpen(element);
		} else { // Handle Expandables
		expandableOpen(element);

		if ($header.hasClass('active')) {
			expandableOpen($header);
		}
		}
	});

	// Open first active
	var $panel_headers = $this.find('> li > .collapsible-header');
	if (options.accordion || collapsible_type === "accordion" || collapsible_type === undefined) { // Handle Accordion
		accordionOpen($panel_headers.filter('.active').first());
	}
	else { // Handle Expandables
		$panel_headers.filter('.active').each(function() {
		expandableOpen($(this));
		});
	}

	});
};

$(document).ready(function(){
	$('.collapsible').collapsible();
});
}( jQuery ));

;(function ($) {

// Add posibility to scroll to selected option
// usefull for select for example
$.fn.scrollTo = function(elem) {
	$(this).scrollTop($(this).scrollTop() - $(this).offset().top + $(elem).offset().top);
	return this;
};

$.fn.dropdown = function (options) {
	var defaults = {
	inDuration: 300,
	outDuration: 225,
	constrainWidth: false, // Constrains width of dropdown to the activator
	hover: false,
	gutter: 0, // Spacing from edge
	belowOrigin: false,
	alignment: 'left',
	stopPropagation: false,
	onopen: null,
	onclose: null
	};

	// Open dropdown.
	if (options === "open") {
	this.each(function () {
		$(this).trigger('open');
	});
	return false;
	}

	// Close dropdown.
	if (options === "close") {
	this.each(function () {
		$(this).trigger('close');
	});
	return false;
	}

	this.each(function () {
	var origin = $(this);
	var curr_options = $.extend({}, defaults, options);
	var isFocused = false;

	// Dropdown menu
	var activates = $("#" + origin.attr('data-activates'));

	function updateOptions() {
		if (origin.data('induration') !== undefined) curr_options.inDuration = origin.data('induration');
		if (origin.data('outduration') !== undefined) curr_options.outDuration = origin.data('outduration');
		if (origin.data('constrainwidth') !== undefined) curr_options.constrainWidth = origin.data('constrainwidth');
		if (origin.data('hover') !== undefined) curr_options.hover = origin.data('hover');
		if (origin.data('gutter') !== undefined) curr_options.gutter = origin.data('gutter');
		if (origin.data('beloworigin') !== undefined) curr_options.belowOrigin = origin.data('beloworigin');
		if (origin.data('alignment') !== undefined) curr_options.alignment = origin.data('alignment');
		if (origin.data('stoppropagation') !== undefined) curr_options.stopPropagation = origin.data('stoppropagation');
	}

	updateOptions();

	// Attach dropdown to its activator
	origin.after(activates);

	/*
		Helper function to position and resize dropdown.
		Used in hover and click handler.
	*/
	function placeDropdown(eventType) {
		// Check for simultaneous focus and click events.
		if (eventType === 'focus') {
		isFocused = true;
		}

		// Check html data attributes
		updateOptions();

		// Set Dropdown state
		activates.addClass('active');
		origin.addClass('active');

		var originWidth = origin[0].getBoundingClientRect().width;

		// Constrain width
		if (curr_options.constrainWidth === true) {
		activates.css('width', originWidth);
		} else {
		activates.css('white-space', 'nowrap');
		}

		// Offscreen detection
		var windowHeight = window.innerHeight;
		var originHeight = origin.innerHeight();
		var offsetLeft = origin.offset().left;
		var offsetTop = origin.offset().top - $(window).scrollTop();
		var currAlignment = curr_options.alignment;
		var gutterSpacing = 0;
		var leftPosition = 0;

		// Below Origin
		var verticalOffset = 0;
		if (curr_options.belowOrigin === true) {
		verticalOffset = originHeight;
		}

		// Check for scrolling positioned container.
		var scrollYOffset = 0;
		var scrollXOffset = 0;
		var wrapper = origin.parent();
		if (!wrapper.is('body')) {
		if (wrapper[0].scrollHeight > wrapper[0].clientHeight) {
			scrollYOffset = wrapper[0].scrollTop;
		}
		if (wrapper[0].scrollWidth > wrapper[0].clientWidth) {
			scrollXOffset = wrapper[0].scrollLeft;
		}
		}

		if (offsetLeft + activates.innerWidth() > $(window).width()) {
		// Dropdown goes past screen on right, force right alignment
		currAlignment = 'right';
		} else if (offsetLeft - activates.innerWidth() + origin.innerWidth() < 0) {
		// Dropdown goes past screen on left, force left alignment
		currAlignment = 'left';
		}
		// Vertical bottom offscreen detection
		if (offsetTop + activates.innerHeight() > windowHeight) {
		// If going upwards still goes offscreen, just crop height of dropdown.
		if (offsetTop + originHeight - activates.innerHeight() < 0) {
			var adjustedHeight = windowHeight - offsetTop - verticalOffset;
			activates.css('max-height', adjustedHeight);
		} else {
			// Flow upwards.
			if (!verticalOffset) {
			verticalOffset += originHeight;
			}
			verticalOffset -= activates.innerHeight();
		}
		}

		// Handle edge alignment
		if (currAlignment === 'left') {
		gutterSpacing = curr_options.gutter;
		leftPosition = origin.position().left + gutterSpacing;
		} else if (currAlignment === 'right') {
		// Material icons fix
		activates.stop(true, true).css({
			opacity: 0,
			left: 0
		});

		var offsetRight = origin.position().left + originWidth - activates.width();
		gutterSpacing = -curr_options.gutter;
		leftPosition = offsetRight + gutterSpacing;
		}

		// Position dropdown
		activates.css({
		position: 'absolute',
		top: origin.position().top + verticalOffset + scrollYOffset,
		left: leftPosition + scrollXOffset
		});

		// Show dropdown
		activates.slideDown({
		queue: false,
		duration: curr_options.inDuration,
		easing: 'easeOutCubic',
		complete: function () {
			$(this).css({'overflow':'auto', 'height' : ''});
			if ($.isFunction(curr_options.onopen)) {
				curr_options.onopen.call(this, activates);
			}
		}
		}).animate({ opacity: 1 }, { queue: false, duration: curr_options.inDuration, easing: 'easeOutSine' });

		// Add click close handler to document
		setTimeout(function () {
		$(document).on('click.' + activates.attr('id'), function (e) {
			hideDropdown();
			$(document).off('click.' + activates.attr('id'));
		});
		}, 0);
	}

	function hideDropdown() {
		// Check for simultaneous focus and click events.
		isFocused = false;
		activates.fadeOut(curr_options.outDuration);
		activates.removeClass('active');
		origin.removeClass('active');
		$(document).off('click.' + activates.attr('id'));
		setTimeout(function () {
		activates.css('max-height', '');
		if ($.isFunction(curr_options.onclose)) {
				curr_options.onclose.call(this, activates);
		}
		}, curr_options.outDuration);
	}

	// Hover
	if (curr_options.hover) {
		var open = false;
		origin.off('click.' + origin.attr('id'));
		// Hover handler to show dropdown
		origin.on('mouseenter', function (e) {
		// Mouse over
		if (open === false) {
			placeDropdown();
			open = true;
		}
		});
		origin.on('mouseleave', function (e) {
		// If hover on origin then to something other than dropdown content, then close
		var toEl = e.toElement || e.relatedTarget; // added browser compatibility for target element
		if (!$(toEl).closest('.dropdown-content').is(activates)) {
			activates.stop(true, true);
			hideDropdown();
			open = false;
		}
		});

		activates.on('mouseleave', function (e) {
		// Mouse out
		var toEl = e.toElement || e.relatedTarget;
		if (!$(toEl).closest('.dropdown-button').is(origin)) {
			activates.stop(true, true);
			hideDropdown();
			open = false;
		}
		});

		// Click
	} else {
		// Click handler to show dropdown
		origin.off('click.' + origin.attr('id'));
		origin.on('click.' + origin.attr('id'), function (e) {
		if (!isFocused) {
			if (origin[0] == e.currentTarget && !origin.hasClass('active') && $(e.target).closest('.dropdown-content').length === 0) {
			e.preventDefault(); // Prevents button click from moving window
			if (curr_options.stopPropagation) {
				e.stopPropagation();
			}
			placeDropdown('click');
			}
			// If origin is clicked and menu is open, close menu
			else if (origin.hasClass('active')) {
				hideDropdown();
				$(document).off('click.' + activates.attr('id'));
			}
		}
		});
	} // End else

	// Listen to open and close event - useful for select component
	origin.on('open', function (e, eventType) {
		placeDropdown(eventType);
	});
	origin.on('close', hideDropdown);
	});
}; // End dropdown plugin

$(document).ready(function(){
	$('.dropdown-button').dropdown();
});
}( jQuery ));
;(function($) {
	var _stack = 0,
	_lastID = 0,
	_generateID = function() {
	_lastID++;
	return 'materialize-lean-overlay-' + _lastID;
	};

$.fn.extend({
	openModal: function(options) {

	var $body = $('body');
	var oldWidth = $body.innerWidth();
	$body.css('overflow', 'hidden');
	$body.width(oldWidth);

	var defaults = {
		opacity: 0.5,
		in_duration: 350,
		out_duration: 250,
		ready: undefined,
		complete: undefined,
		dismissible: true,
		starting_top: '95%',
		ending_top: '10%'
	};
	var $modal = $(this);

	if ($modal.hasClass('open')) {
		return;
	}

	var overlayID = _generateID();
	var $overlay = $('<div class="lean-overlay"></div>');
	lStack = (++_stack);

	// Store a reference of the overlay
	$overlay.attr('id', overlayID).css('z-index', 1000 + lStack * 2);
	

	$("body").prepend($overlay);
	$modal.data('overlay-id', overlayID).css('z-index', 1000 + lStack * 2 + 1);
	$modal.addClass('open');

	// Override defaults
	options = $.extend(defaults, options);

	if (options.dismissible) {
		$overlay.click(function() {
		$modal.closeModal(options);
		});
		// Return on ESC
		$(document).on('keyup.leanModal' + overlayID, function(e) {
		if (e.keyCode === 27) { // ESC key
			$modal.closeModal(options);
		}
		});
	}

	$modal.find(".modal-close").on('click.close', function(e) {
		$modal.closeModal(options);
	});

	$overlay.css({ display : "block", opacity : 0 });

	$modal.css({
		display : "block",
		opacity: 0
	});

	$overlay.velocity({opacity: options.opacity}, {duration: options.in_duration, queue: false, ease: "easeOutCubic"});
	$modal.data('associated-overlay', $overlay[0]);

	// Define Bottom Sheet animation
	if ($modal.hasClass('bottom-sheet')) {
		$modal.velocity({bottom: "0", opacity: 1}, {
		duration: options.in_duration,
		queue: false,
		ease: "easeOutCubic",
		// Handle modal ready callback
		complete: function() {
			if (typeof(options.ready) === "function") {
			options.ready();
			}
		}
		});
	}
	else {
		$modal.css({ top: options.starting_top });
		$modal.velocity({top: options.ending_top, opacity: 1, scaleX: '1'}, {
		duration: options.in_duration,
		queue: false,
		ease: "easeOutCubic",
		// Handle modal ready callback
		complete: function() {
			if (typeof(options.ready) === "function") {
			options.ready();
			}
		}
		});
	}


	}
});

$.fn.extend({
	closeModal: function(options) {
	var defaults = {
		out_duration: 250,
		complete: undefined
	};
	var $modal = $(this);
	var overlayID = $modal.data('overlay-id');
	var $overlay = $('#' + overlayID);
	$modal.removeClass('open');

	options = $.extend(defaults, options);

	// Enable scrolling
	$('body').css({
		overflow: '',
		width: ''
	});

	$modal.find('.modal-close').off('click.close');
	$(document).off('keyup.leanModal' + overlayID);

	$overlay.velocity( { opacity: 0}, {duration: options.out_duration, queue: false, ease: "easeOutQuart"});


	// Define Bottom Sheet animation
	if ($modal.hasClass('bottom-sheet')) {
		$modal.velocity({bottom: "-100%", opacity: 0}, {
		duration: options.out_duration,
		queue: false,
		ease: "easeOutCubic",
		// Handle modal ready callback
		complete: function() {
			$overlay.css({display:"none"});

			// Call complete callback
			if (typeof(options.complete) === "function") {
			options.complete();
			}
			$overlay.remove();
			_stack--;
		}
		});
	}
	else {
		$modal.velocity(
		{ top: options.starting_top, opacity: 0, scaleX: 0.7}, {
		duration: options.out_duration,
		complete:
			function() {

			$(this).css('display', 'none');
			// Call complete callback
			if (typeof(options.complete) === "function") {
				options.complete();
			}
			$overlay.remove();
			_stack--;
			}
		}
		);
	}
	}
});

$.fn.extend({
	leanModal: function(option) {
	return this.each(function() {

		var defaults = {
		starting_top: '4%'
		},
		// Override defaults
		options = $.extend(defaults, option);

		// Close Handlers
		$(this).click(function(e) {
		options.starting_top = ($(this).offset().top - $(window).scrollTop()) /1.15;
		var modal_id = $(this).attr("href") || '#' + $(this).data('target');
		$(modal_id).openModal(options);
		e.preventDefault();
		}); // done set on click
	}); // done return
	}
});
})(jQuery);
;(function ($) {

$.fn.materialbox = function () {

	return this.each(function() {

	if ($(this).hasClass('initialized')) {
		return;
	}

	$(this).addClass('initialized');

	var overlayActive = false;
	var doneAnimating = true;
	var inDuration = 275;
	var outDuration = 200;
	var origin = $(this);
	var placeholder = $('<div></div>').addClass('material-placeholder');
	var originalWidth = 0;
	var originalHeight = 0;
	var ancestorsChanged;
	var ancestor;
	origin.wrap(placeholder);


	origin.on('click', function(){
		var placeholder = origin.parent('.material-placeholder');
		var windowWidth = window.innerWidth;
		var windowHeight = window.innerHeight;
		var originalWidth = origin.width();
		var originalHeight = origin.height();


		// If already modal, return to original
		if (doneAnimating === false) {
		returnToOriginal();
		return false;
		}
		else if (overlayActive && doneAnimating===true) {
		returnToOriginal();
		return false;
		}


		// Set states
		doneAnimating = false;
		origin.addClass('active');
		overlayActive = true;

		// Set positioning for placeholder
		placeholder.css({
		width: placeholder[0].getBoundingClientRect().width,
		height: placeholder[0].getBoundingClientRect().height,
		position: 'relative',
		top: 0,
		left: 0
		});

		// Find ancestor with overflow: hidden; and remove it
		ancestorsChanged = undefined;
		ancestor = placeholder[0].parentNode;
		var count = 0;
		while (ancestor !== null && !$(ancestor).is(document)) {
		var curr = $(ancestor);
		if (curr.css('overflow') !== 'visible') {
			curr.css('overflow', 'visible');
			if (ancestorsChanged === undefined) {
			ancestorsChanged = curr;
			}
			else {
			ancestorsChanged = ancestorsChanged.add(curr);
			}
		}
		ancestor = ancestor.parentNode;
		}

		// Set css on origin
		origin.css({position: 'absolute', 'z-index': 1000})
		.data('width', originalWidth)
		.data('height', originalHeight);

		// Add overlay
		var overlay = $('<div id="materialbox-overlay"></div>')
		.css({
			opacity: 0
		})
		.click(function(){
			if (doneAnimating === true)
			returnToOriginal();
		});
		// Animate Overlay
		// Put before in origin image to preserve z-index layering.
		origin.before(overlay);
		overlay.velocity({opacity: 0.5},
						 {duration: inDuration, queue: false, easing: 'easeOutQuad'} );

		// Add and animate caption if it exists
		if (origin.data('caption') !== "") {
		var $photo_caption = $('<div class="materialbox-caption"></div>');
		$photo_caption.text(origin.data('caption'));
		$('body').append($photo_caption);
		$photo_caption.css({ "display": "inline" });
		$photo_caption.velocity({opacity: 0.5}, {duration: inDuration, queue: false, easing: 'easeOutQuad'});
		}

		// Resize Image
		var ratio = 0;
		var widthPercent = originalWidth / windowWidth;
		var heightPercent = originalHeight / windowHeight;
		var newWidth = 0;
		var newHeight = 0;

		if (widthPercent > heightPercent) {
		ratio = originalHeight / originalWidth;
		newWidth = windowWidth * 0.9;
		newHeight = windowWidth * 0.9 * ratio;
		}
		else {
		ratio = originalWidth / originalHeight;
		newWidth = (windowHeight * 0.9) * ratio;
		newHeight = windowHeight * 0.9;
		}

		// Animate image + set z-index
		if(origin.hasClass('responsive-img')) {
		origin.velocity({'max-width': newWidth, 'width': originalWidth}, {duration: 0, queue: false,
			complete: function(){
			origin.css({left: 0, top: 0})
			.velocity(
				{
				height: newHeight,
				width: newWidth,
				left: $(document).scrollLeft() + windowWidth/2 - origin.parent('.material-placeholder').offset().left - newWidth/2,
				top: $(document).scrollTop() + windowHeight/2 - origin.parent('.material-placeholder').offset().top - newHeight/ 2
				},
				{
				duration: inDuration,
				queue: false,
				easing: 'easeOutQuad',
				complete: function(){doneAnimating = true;}
				}
			);
			} // End Complete
		}); // End Velocity
		}
		else {
		origin.css('left', 0)
		.css('top', 0)
		.velocity(
			{
			height: newHeight,
			width: newWidth,
			left: $(document).scrollLeft() + windowWidth/2 - origin.parent('.material-placeholder').offset().left - newWidth/2,
			top: $(document).scrollTop() + windowHeight/2 - origin.parent('.material-placeholder').offset().top - newHeight/ 2
			},
			{
			duration: inDuration,
			queue: false,
			easing: 'easeOutQuad',
			complete: function(){doneAnimating = true;}
			}
			); // End Velocity
		}

	}); // End origin on click


	// Return on scroll
	$(window).scroll(function() {
		if (overlayActive) {
		returnToOriginal();
		}
	});

	// Return on ESC
	$(document).keyup(function(e) {

		if (e.keyCode === 27 && doneAnimating === true) { // ESC key
		if (overlayActive) {
			returnToOriginal();
		}
		}
	});


	// This function returns the modaled image to the original spot
	function returnToOriginal() {

		doneAnimating = false;

		var placeholder = origin.parent('.material-placeholder');
		var windowWidth = window.innerWidth;
		var windowHeight = window.innerHeight;
		var originalWidth = origin.data('width');
		var originalHeight = origin.data('height');

		origin.velocity("stop", true);
		$('#materialbox-overlay').velocity("stop", true);
		$('.materialbox-caption').velocity("stop", true);


		$('#materialbox-overlay').velocity({opacity: 0}, {
			duration: outDuration, // Delay prevents animation overlapping
			queue: false, easing: 'easeOutQuad',
			complete: function(){
			// Remove Overlay
			overlayActive = false;
			$(this).remove();
			}
		});

		// Resize Image
		origin.velocity(
			{
			width: originalWidth,
			height: originalHeight,
			left: 0,
			top: 0
			},
			{
			duration: outDuration,
			queue: false, easing: 'easeOutQuad'
			}
		);

		// Remove Caption + reset css settings on image
		$('.materialbox-caption').velocity({opacity: 0}, {
			duration: outDuration, // Delay prevents animation overlapping
			queue: false, easing: 'easeOutQuad',
			complete: function(){
			placeholder.css({
				height: '',
				width: '',
				position: '',
				top: '',
				left: ''
			});

			origin.css({
				height: '',
				top: '',
				left: '',
				width: '',
				'max-width': '',
				position: '',
				'z-index': ''
			});

			// Remove class
			origin.removeClass('active');
			doneAnimating = true;
			$(this).remove();

			// Remove overflow overrides on ancestors
			if (ancestorsChanged) {
				ancestorsChanged.css('overflow', '');
			}
			}
		});

		}
		});
};

$(document).ready(function(){
$('.materialboxed').materialbox();
});

}( jQuery ));
;(function ($) {

	$.fn.parallax = function () {
	var window_width = $(window).width();
	// Parallax Scripts
	return this.each(function(i) {
		var $this = $(this);
		$this.addClass('parallax');

		function updateParallax(initial) {
		var container_height;
		if (window_width < 601) {
			container_height = ($this.height() > 0) ? $this.height() : $this.children("img").height();
		}
		else {
			container_height = ($this.height() > 0) ? $this.height() : 500;
		}
		var $img = $this.children("img").first();
		var img_height = $img.height();
		var parallax_dist = img_height - container_height;
		var bottom = $this.offset().top + container_height;
		var top = $this.offset().top;
		var scrollTop = $(window).scrollTop();
		var windowHeight = window.innerHeight;
		var windowBottom = scrollTop + windowHeight;
		var percentScrolled = (windowBottom - top) / (container_height + windowHeight);
		var parallax = Math.round((parallax_dist * percentScrolled));

		if (initial) {
			$img.css('display', 'block');
		}
		if ((bottom > scrollTop) && (top < (scrollTop + windowHeight))) {
			$img.css('transform', "translate3D(-50%," + parallax + "px, 0)");
		}

		}

		// Wait for image load
		$this.children("img").one("load", function() {
		updateParallax(true);
		}).each(function() {
		if(this.complete) $(this).load();
		});

		$(window).scroll(function() {
		window_width = $(window).width();
		updateParallax(false);
		});

		$(window).resize(function() {
		window_width = $(window).width();
		updateParallax(false);
		});

	});

	};
}( jQuery ));;(function ($) {

var methods = {
	init : function(options) {
	var defaults = {
		onShow: null
	};
	options = $.extend(defaults, options);

	return this.each(function() {

	// For each set of tabs, we want to keep track of
	// which tab is active and its associated content
	var $this = $(this),
		window_width = $(window).width();

	$this.width('100%');
	var $active, $content, $links = $this.find('li.tab a'),
		$tabs_width = $this.width(),
		$tabs_height = $this.height(),
		$tab_width = Math.max($tabs_width, $this[0].scrollWidth) / $links.length,
		$tab_height = Math.max($tabs_height, $this[0].scrollHeight) / $links.length,
		$index = 0;

	// If the location.hash matches one of the links, use that as the active tab.
	$active = $($links.filter('[href="'+location.hash+'"]'));

	// If no match is found, use the first link or any with class 'active' as the initial active tab.
	if ($active.length === 0) {
		$active = $(this).find('li.tab a.active').first();
	}
	if ($active.length === 0) {
		$active = $(this).find('li.tab a').first();
	}

	$active.addClass('active');
	$index = $links.index($active);
	if ($index < 0) {
		$index = 0;
	}

	if ($active[0] !== undefined) {
		$content = $($active[0].hash);
	}

	// append indicator then set indicator width to tab width
	$this.append('<div class="indicator"></div>');
	var $indicator = $this.find('.indicator');

	if ($this.hasClass('vertical')) {
		if ($this.is(":visible")) {
			$indicator.css({"bottom": $tabs_height - (($index + 1) * $tab_height)});
			$indicator.css({"top": $index * $tab_height});
			$indicator.css({"left": 0});
		}
	}
	else{
		if ($this.is(":visible")) {
			$indicator.css({"right": $tabs_width - (($index + 1) * $tab_width)});
			$indicator.css({"left": $index * $tab_width});
		}
	}
	
	
	
	$(window).resize(function () {
		$tabs_width = $this.width();
		$tab_width = Math.max($tabs_width, $this[0].scrollWidth) / $links.length;
		$tabs_height = $this.height();
		$tab_height = Math.max($tabs_height, $this[0].scrollHeight) / $links.length;
		if ($index < 0) {
		$index = 0;
		}
		if ($this.hasClass('vertical')) {
			if ($tab_height !== 0 && $tabs_height !== 0) {
			$indicator.css({"bottom": $tabs_height - (($index + 1) * $tab_height)});
			$indicator.css({"top": $index * $tab_height});
			$indicator.css({"left": 0});
			}
		}
		else{
			if ($tab_width !== 0 && $tabs_width !== 0) {
			$indicator.css({"right": $tabs_width - (($index + 1) * $tab_width)});
			$indicator.css({"left": $index * $tab_width});
			}
		}
	});

	// Hide the remaining content
	$links.not($active).each(function () {
		$(this.hash).hide();
	});


	// Bind the click event handler
	$this.on('click', 'a', function(e) {
		if ($(this).parent().hasClass('disabled')) {
		e.preventDefault();
		return;
		}

		// Act as regular link if target attribute is specified.
		if (!!$(this).attr("target")) {
		return;
		}

		$tabs_width = $this.width();
		$tab_width = Math.max($tabs_width, $this[0].scrollWidth) / $links.length;
		$tabs_height = $this.height();
		$tab_height = Math.max($tabs_height, $this[0].scrollHeight) / $links.length;

		// Make the old tab inactive.
		$active.removeClass('active');
		if ($content !== undefined) {
		$content.hide();
		}

		// Update the variables with the new link and content
		$active = $(this);
		$content = $(this.hash);
		$links = $this.find('li.tab a');

		// Make the tab active.
		$active.addClass('active');
		var $prev_index = $index;
		$index = $links.index($(this));
		if ($index < 0) {
		$index = 0;
		}
		// Change url to current tab
		// window.location.hash = $active.attr('href');

		if ($content !== undefined) {
		$content.show();

		if (typeof(options.onShow) === "function") {
			options.onShow.call(this, $content);
		}
		}

		// Update indicator
		if ($this.hasClass('vertical')) {
			if (($index - $prev_index) >= 0) {
			$indicator.velocity({"bottom": $tabs_height - (($index + 1) * $tab_height)}, { duration: 400, queue: false, easing: 'easeOutExpo'});
			$indicator.velocity({"top": $index * $tab_height}, {duration: 400, queue: false, easing: 'easeOutExpo', delay: 90});

			}
			else {
			$indicator.velocity({"top": $index * $tab_height}, { duration: 400, queue: false, easing: 'easeOutExpo'});
			$indicator.velocity({"bottom": $tabs_height - (($index + 1) * $tab_height)}, {duration: 400, queue: false, easing: 'easeOutExpo', delay: 90});
			}

		}
		else{
			if (($index - $prev_index) >= 0) {
			$indicator.velocity({"right": $tabs_width - (($index + 1) * $tab_width)}, { duration: 300, queue: false, easing: 'easeOutQuad'});
			$indicator.velocity({"left": $index * $tab_width}, {duration: 300, queue: false, easing: 'easeOutQuad', delay: 90});

			}
			else {
			$indicator.velocity({"left": $index * $tab_width}, { duration: 300, queue: false, easing: 'easeOutQuad'});
			$indicator.velocity({"right": $tabs_width - (($index + 1) * $tab_width)}, {duration: 300, queue: false, easing: 'easeOutQuad', delay: 90});
			}
		}
			

		// Prevent the anchor's default click action
		e.preventDefault();
	});
	});

	},
	select_tab : function( id ) {
	this.find('a[href="#' + id + '"]').trigger('click');
	}
};

$.fn.tabs = function(methodOrOptions) {
	if ( methods[methodOrOptions] ) {
	return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	} else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
	// Default to "init"
	return methods.init.apply( this, arguments );
	} else {
	$.error( 'Method ' +methodOrOptions + ' does not exist on jQuery.tooltip' );
	}
};

$(document).ready(function(){
	$('ul.tabs').tabs();
});
}( jQuery ));
;(function ($) {
	$.fn.tooltip = function (options) {
	var timeout = null,
	margin = 5;

	// Defaults
	var defaults = {
		delay: 350,
		tooltip: '',
		position: 'bottom',
		html: false
	};

	// Remove tooltip from the activator
	if (options === "remove") {
		this.each(function() {
		$('#' + $(this).attr('data-tooltip-id')).remove();
		$(this).off('mouseenter.tooltip mouseleave.tooltip');
		});
		return false;
	}

	options = $.extend(defaults, options);

	return this.each(function() {
		var tooltipId = Materialize.guid();
		var origin = $(this);
		origin.attr('data-tooltip-id', tooltipId);

		// Get attributes.
		var allowHtml,
			tooltipDelay,
			tooltipPosition,
			tooltipText,
			tooltipEl,
			backdrop;
		var setAttributes = function() {
		allowHtml = origin.attr('data-html') ? origin.attr('data-html') === 'true' : options.html;
		tooltipDelay = origin.attr('data-delay');
		tooltipDelay = (tooltipDelay === undefined || tooltipDelay === '') ?
			options.delay : tooltipDelay;
		tooltipPosition = origin.attr('data-position');
		tooltipPosition = (tooltipPosition === undefined || tooltipPosition === '') ?
			options.position : tooltipPosition;
		tooltipText = origin.attr('data-tooltip');
		tooltipText = (tooltipText === undefined || tooltipText === '') ?
			options.tooltip : tooltipText;
		};
		setAttributes();

		var renderTooltipEl = function() {
		var tooltip = $('<div class="material-tooltip"></div>');

		// Create Text span
		if (allowHtml) {
			tooltipText = $('<span></span>').html(tooltipText);
		} else{
			tooltipText = $('<span></span>').text(tooltipText);
		}

		// Create tooltip
		tooltip.append(tooltipText)
			.appendTo($('body'))
			.attr('id', tooltipId);

		// Create backdrop
		backdrop = $('<div class="backdrop"></div>');
		backdrop.appendTo(tooltip);
		return tooltip;
		};
		tooltipEl = renderTooltipEl();

		// Destroy previously binded events
		origin.off('mouseenter.tooltip mouseleave.tooltip');
		// Mouse In
		var started = false, timeoutRef;
		origin.on({'mouseenter.tooltip': function(e) {
		var showTooltip = function() {
			setAttributes();
			started = true;
			tooltipEl.velocity('stop');
			backdrop.velocity('stop');
			tooltipEl.css({ display: 'block', left: '0px', top: '0px' });

			// Tooltip positioning
			var originWidth = origin.outerWidth();
			var originHeight = origin.outerHeight();

			var tooltipHeight = tooltipEl.outerHeight();
			var tooltipWidth = tooltipEl.outerWidth();
			var tooltipVerticalMovement = '0px';
			var tooltipHorizontalMovement = '0px';
			var scaleXFactor = 8;
			var scaleYFactor = 8;
			var targetTop, targetLeft, newCoordinates;

			if (tooltipPosition === "top") {
			// Top Position
			targetTop = origin.offset().top - tooltipHeight - margin;
			targetLeft = origin.offset().left + originWidth/2 - tooltipWidth/2;
			newCoordinates = repositionWithinScreen(targetLeft, targetTop, tooltipWidth, tooltipHeight);

			tooltipVerticalMovement = '-10px';
			backdrop.css({
				bottom: 0,
				left: 0,
				borderRadius: '14px 14px 0 0',
				transformOrigin: '50% 100%',
				marginTop: tooltipHeight,
				marginLeft: (tooltipWidth/2) - (backdrop.width()/2)
			});
			}
			// Left Position
			else if (tooltipPosition === "left") {
			targetTop = origin.offset().top + originHeight/2 - tooltipHeight/2;
			targetLeft =origin.offset().left - tooltipWidth - margin;
			newCoordinates = repositionWithinScreen(targetLeft, targetTop, tooltipWidth, tooltipHeight);

			tooltipHorizontalMovement = '-10px';
			backdrop.css({
				top: '-7px',
				right: 0,
				width: '14px',
				height: '14px',
				borderRadius: '14px 0 0 14px',
				transformOrigin: '95% 50%',
				marginTop: tooltipHeight/2,
				marginLeft: tooltipWidth
			});
			}
			// Right Position
			else if (tooltipPosition === "right") {
			targetTop = origin.offset().top + originHeight/2 - tooltipHeight/2;
			targetLeft = origin.offset().left + originWidth + margin;
			newCoordinates = repositionWithinScreen(targetLeft, targetTop, tooltipWidth, tooltipHeight);

			tooltipHorizontalMovement = '+10px';
			backdrop.css({
				top: '-7px',
				left: 0,
				width: '14px',
				height: '14px',
				borderRadius: '0 14px 14px 0',
				transformOrigin: '5% 50%',
				marginTop: tooltipHeight/2,
				marginLeft: '0px'
			});
			}
			else {
			// Bottom Position
			targetTop = origin.offset().top + origin.outerHeight() + margin;
			targetLeft = origin.offset().left + originWidth/2 - tooltipWidth/2;
			newCoordinates = repositionWithinScreen(targetLeft, targetTop, tooltipWidth, tooltipHeight);
			tooltipVerticalMovement = '+10px';
			backdrop.css({
				top: 0,
				left: 0,
				marginLeft: (tooltipWidth/2) - (backdrop.width()/2)
			});
			}

			// Set tooptip css placement
			tooltipEl.css({
			top: newCoordinates.y,
			left: newCoordinates.x
			});

			// Calculate Scale to fill
			scaleXFactor = Math.SQRT2 * tooltipWidth / parseInt(backdrop.css('width'));
			scaleYFactor = Math.SQRT2 * tooltipHeight / parseInt(backdrop.css('height'));

			tooltipEl.velocity({ marginTop: tooltipVerticalMovement, marginLeft: tooltipHorizontalMovement}, { duration: 350, queue: false })
			.velocity({opacity: 1}, {duration: 300, delay: 50, queue: false});
			backdrop.css({ display: 'block' })
			.velocity({opacity:1},{duration: 55, delay: 0, queue: false})
			.velocity({scaleX: scaleXFactor, scaleY: scaleYFactor}, {duration: 300, delay: 0, queue: false, easing: 'easeInOutQuad'});
		};

		timeoutRef = setTimeout(showTooltip, tooltipDelay); // End Interval

		// Mouse Out
		},
		'mouseleave.tooltip': function(){
		// Reset State
		started = false;
		clearTimeout(timeoutRef);

		// Animate back
		setTimeout(function() {
			if (started !== true) {
			tooltipEl.velocity({
				opacity: 0, marginTop: 0, marginLeft: 0}, { duration: 225, queue: false});
			backdrop.velocity({opacity: 0, scaleX: 1, scaleY: 1}, {
				duration:225,
				queue: false,
				complete: function(){
				backdrop.css('display', 'none');
				tooltipEl.css('display', 'none');
				started = false;}
			});
			}
		},225);
		}
		});
	});
};

var repositionWithinScreen = function(x, y, width, height) {
	var newX = x;
	var newY = y;

	if (newX < 0) {
	newX = 4;
	} else if (newX + width > window.innerWidth) {
	newX -= newX + width - window.innerWidth;
	}

	if (newY < 0) {
	newY = 4;
	} else if (newY + height > window.innerHeight + $(window).scrollTop) {
	newY -= newY + height - window.innerHeight;
	}

	return {x: newX, y: newY};
};

$(document).ready(function(){
	 $('.tooltipped').tooltip();
 });
}( jQuery ));
;/*!
 * Waves v0.6.4
 * http://fian.my.id/Waves
 *
 * Copyright 2014 Alfiana E. Sibuea and other contributors
 * Released under the MIT license
 * https://github.com/fians/Waves/blob/master/LICENSE
 */

;(function(window) {
	'use strict';

	var Waves = Waves || {};
	var $$ = document.querySelectorAll.bind(document);

	// Find exact position of element
	function isWindow(obj) {
		return obj !== null && obj === obj.window;
	}

	function getWindow(elem) {
		return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
	}

	function offset(elem) {
		var docElem, win,
			box = {top: 0, left: 0},
			doc = elem && elem.ownerDocument;

		docElem = doc.documentElement;

		if (typeof elem.getBoundingClientRect !== typeof undefined) {
			box = elem.getBoundingClientRect();
		}
		win = getWindow(doc);
		return {
			top: box.top + win.pageYOffset - docElem.clientTop,
			left: box.left + win.pageXOffset - docElem.clientLeft
		};
	}

	function convertStyle(obj) {
		var style = '';

		for (var a in obj) {
			if (obj.hasOwnProperty(a)) {
				style += (a + ':' + obj[a] + ';');
			}
		}

		return style;
	}

	var Effect = {

		// Effect delay
		duration: 750,

		show: function(e, element) {

			// Disable right click
			if (e.button === 2) {
				return false;
			}

			var el = element || this;

			// Create ripple
			var ripple = document.createElement('div');
			ripple.className = 'waves-ripple';
			el.appendChild(ripple);

			// Get click coordinate and element witdh
			var pos = offset(el);
			var relativeY = (e.pageY - pos.top);
			var relativeX = (e.pageX - pos.left);
			var scale = 'scale('+((el.clientWidth / 100) * 10)+')';

			// Support for touch devices
			if ('touches' in e) {
			relativeY = (e.touches[0].pageY - pos.top);
			relativeX = (e.touches[0].pageX - pos.left);
			}

			// Attach data to element
			ripple.setAttribute('data-hold', Date.now());
			ripple.setAttribute('data-scale', scale);
			ripple.setAttribute('data-x', relativeX);
			ripple.setAttribute('data-y', relativeY);

			// Set ripple position
			var rippleStyle = {
				'top': relativeY+'px',
				'left': relativeX+'px'
			};

			ripple.className = ripple.className + ' waves-notransition';
			ripple.setAttribute('style', convertStyle(rippleStyle));
			ripple.className = ripple.className.replace('waves-notransition', '');

			// Scale the ripple
			rippleStyle['-webkit-transform'] = scale;
			rippleStyle['-moz-transform'] = scale;
			rippleStyle['-ms-transform'] = scale;
			rippleStyle['-o-transform'] = scale;
			rippleStyle.transform = scale;
			rippleStyle.opacity = '1';

			rippleStyle['-webkit-transition-duration'] = Effect.duration + 'ms';
			rippleStyle['-moz-transition-duration']= Effect.duration + 'ms';
			rippleStyle['-o-transition-duration']= Effect.duration + 'ms';
			rippleStyle['transition-duration'] = Effect.duration + 'ms';

			rippleStyle['-webkit-transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
			rippleStyle['-moz-transition-timing-function']= 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
			rippleStyle['-o-transition-timing-function']= 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
			rippleStyle['transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';

			ripple.setAttribute('style', convertStyle(rippleStyle));
		},

		hide: function(e) {
			TouchHandler.touchup(e);

			var el = this;
			var width = el.clientWidth * 1.4;

			// Get first ripple
			var ripple = null;
			var ripples = el.getElementsByClassName('waves-ripple');
			if (ripples.length > 0) {
				ripple = ripples[ripples.length - 1];
			} else {
				return false;
			}

			var relativeX = ripple.getAttribute('data-x');
			var relativeY = ripple.getAttribute('data-y');
			var scale = ripple.getAttribute('data-scale');

			// Get delay beetween mousedown and mouse leave
			var diff = Date.now() - Number(ripple.getAttribute('data-hold'));
			var delay = 350 - diff;

			if (delay < 0) {
				delay = 0;
			}

			// Fade out ripple after delay
			setTimeout(function() {
				var style = {
					'top': relativeY+'px',
					'left': relativeX+'px',
					'opacity': '0',

					// Duration
					'-webkit-transition-duration': Effect.duration + 'ms',
					'-moz-transition-duration': Effect.duration + 'ms',
					'-o-transition-duration': Effect.duration + 'ms',
					'transition-duration': Effect.duration + 'ms',
					'-webkit-transform': scale,
					'-moz-transform': scale,
					'-ms-transform': scale,
					'-o-transform': scale,
					'transform': scale,
				};

				ripple.setAttribute('style', convertStyle(style));

				setTimeout(function() {
					try {
						$(el).find('.waves-ripple').remove();
					} catch(e) {
						return false;
					}
				}, Effect.duration);
			}, delay);
		},

		// Little hack to make <input> can perform waves effect
		wrapInput: function(elements) {
			for (var a = 0; a < elements.length; a++) {
				var el = elements[a];

				if (el.tagName.toLowerCase() === 'input') {
					var parent = el.parentNode;

					// If input already have parent just pass through
					if (parent.tagName.toLowerCase() === 'i' && parent.className.indexOf('waves-effect') !== -1) {
						continue;
					}

					// Put element class and style to the specified parent
					var wrapper = document.createElement('i');
					wrapper.className = el.className + ' waves-input-wrapper';

					var elementStyle = el.getAttribute('style');

					if (!elementStyle) {
						elementStyle = '';
					}

					wrapper.setAttribute('style', elementStyle);

					el.className = 'waves-button-input';
					el.removeAttribute('style');

					// Put element as child
					parent.replaceChild(wrapper, el);
					wrapper.appendChild(el);
				}
			}
		}
	};


	/**
	 * Disable mousedown event for 500ms during and after touch
	 */
	var TouchHandler = {
		/* uses an integer rather than bool so there's no issues with
		 * needing to clear timeouts if another touch event occurred
		 * within the 500ms. Cannot mouseup between touchstart and
		 * touchend, nor in the 500ms after touchend. */
		touches: 0,
		allowEvent: function(e) {
			var allow = true;

			if (e.type === 'touchstart') {
				TouchHandler.touches += 1; //push
			} else if (e.type === 'touchend' || e.type === 'touchcancel') {
				setTimeout(function() {
					if (TouchHandler.touches > 0) {
						TouchHandler.touches -= 1; //pop after 500ms
					}
				}, 500);
			} else if (e.type === 'mousedown' && TouchHandler.touches > 0) {
				allow = false;
			}

			return allow;
		},
		touchup: function(e) {
			TouchHandler.allowEvent(e);
		}
	};


	/**
	 * Delegated click handler for .waves-effect element.
	 * returns null when .waves-effect element not in "click tree"
	 */
	function getWavesEffectElement(e) {
		if (TouchHandler.allowEvent(e) === false) {
			return null;
		}

		var element = null;
		var target = e.target || e.srcElement;

		while (target.parentElement !== null) {
			if (!(target instanceof SVGElement) && target.className.indexOf('waves-effect') !== -1) {
				element = target;
				break;
			} else if (target.classList.contains('waves-effect')) {
				element = target;
				break;
			}
			target = target.parentElement;
		}

		return element;
	}

	/**
	 * Bubble the click and show effect if .waves-effect elem was found
	 */
	function showEffect(e) {
		var element = getWavesEffectElement(e);

		if (element !== null) {
			Effect.show(e, element);

			if ('ontouchstart' in window) {
				element.addEventListener('touchend', Effect.hide, false);
				element.addEventListener('touchcancel', Effect.hide, false);
			}

			element.addEventListener('mouseup', Effect.hide, false);
			element.addEventListener('mouseleave', Effect.hide, false);
		}
	}

	Waves.displayEffect = function(options) {
		options = options || {};

		if ('duration' in options) {
			Effect.duration = options.duration;
		}

		//Wrap input inside <i> tag
		Effect.wrapInput($$('.waves-effect'));

		if ('ontouchstart' in window) {
			document.body.addEventListener('touchstart', showEffect, false);
		}

		document.body.addEventListener('mousedown', showEffect, false);
	};

	/**
	 * Attach Waves to an input element (or any element which doesn't
	 * bubble mouseup/mousedown events).
	 * Intended to be used with dynamically loaded forms/inputs, or
	 * where the user doesn't want a delegated click handler.
	 */
	Waves.attach = function(element) {
		//FUTURE: automatically add waves classes and allow users
		// to specify them with an options param? Eg. light/classic/button
		if (element.tagName.toLowerCase() === 'input') {
			Effect.wrapInput([element]);
			element = element.parentElement;
		}

		if ('ontouchstart' in window) {
			element.addEventListener('touchstart', showEffect, false);
		}

		element.addEventListener('mousedown', showEffect, false);
	};

	window.Waves = Waves;

	document.addEventListener('DOMContentLoaded', function() {
		Waves.displayEffect();
	}, false);

})(window);
;Materialize.toast = function (message, displayLength, className, completeCallback) {
	className = className || "";

	var container = document.getElementById('toast-container');

	// Create toast container if it does not exist
	if (container === null) {
		// create notification container
		container = document.createElement('div');
		container.id = 'toast-container';
		document.body.appendChild(container);
	}

	// Select and append toast
	var newToast = createToast(message);

	// only append toast if message is not undefined
	if(message){
		container.appendChild(newToast);
	}

	newToast.style.top = '35px';
	newToast.style.opacity = 0;

	// Animate toast in
	Vel(newToast, { "top" : "0px", opacity: 1 }, {duration: 300,
	easing: 'easeOutCubic',
	queue: false});

	// Allows timer to be pause while being panned
	var timeLeft = displayLength;
	var counterInterval = setInterval (function(){


	if (newToast.parentNode === null)
		window.clearInterval(counterInterval);

	// If toast is not being dragged, decrease its time remaining
	if (!newToast.classList.contains('panning')) {
		timeLeft -= 20;
	}

	if (timeLeft <= 0) {
		// Animate toast out
		Vel(newToast, {"opacity": 0, marginTop: '-40px'}, { duration: 375,
			easing: 'easeOutExpo',
			queue: false,
			complete: function(){
			// Call the optional callback
			if(typeof(completeCallback) === "function")
				completeCallback();
			// Remove toast after it times out
			this[0].parentNode.removeChild(this[0]);
			}
		});
		window.clearInterval(counterInterval);
	}
	}, 20);



	function createToast(html) {

		// Create toast
		var toast = document.createElement('div');
		toast.classList.add('toast');
		if (className) {
			var classes = className.split(' ');

			for (var i = 0, count = classes.length; i < count; i++) {
				toast.classList.add(classes[i]);
			}
		}
		// If type of parameter is HTML Element
		if ( typeof HTMLElement === "object" ? html instanceof HTMLElement : html && typeof html === "object" && html !== null && html.nodeType === 1 && typeof html.nodeName==="string"
) {
		toast.appendChild(html);
		}
		else if (html instanceof jQuery) {
		// Check if it is jQuery object
		toast.appendChild(html[0]);
		}
		else {
		// Insert as text;
		toast.innerHTML = html; 
		}
		// Bind hammer
		var hammerHandler = new Hammer(toast, {prevent_default: false});
		hammerHandler.on('pan', function(e) {
		var deltaX = e.deltaX;
		var activationDistance = 80;

		// Change toast state
		if (!toast.classList.contains('panning')){
			toast.classList.add('panning');
		}

		var opacityPercent = 1-Math.abs(deltaX / activationDistance);
		if (opacityPercent < 0)
			opacityPercent = 0;

		Vel(toast, {left: deltaX, opacity: opacityPercent }, {duration: 50, queue: false, easing: 'easeOutQuad'});

		});

		hammerHandler.on('panend', function(e) {
		var deltaX = e.deltaX;
		var activationDistance = 80;

		// If toast dragged past activation point
		if (Math.abs(deltaX) > activationDistance) {
			Vel(toast, {marginTop: '-40px'}, { duration: 375,
				easing: 'easeOutExpo',
				queue: false,
				complete: function(){
				if(typeof(completeCallback) === "function") {
					completeCallback();
				}
				toast.parentNode.removeChild(toast);
				}
			});

		} else {
			toast.classList.remove('panning');
			// Put toast back into original position
			Vel(toast, { left: 0, opacity: 1 }, { duration: 300,
			easing: 'easeOutExpo',
			queue: false
			});

		}
		});

		return toast;
	}
};
;(function ($) {

var methods = {
	init : function(options) {
	var defaults = {
		menuWidth: 300,
		edge: 'left',
		closeOnClick: false
	};
	options = $.extend(defaults, options);

	$(this).each(function(){
		var $this = $(this);
		var menu_id = $($this.attr('data-activates'));

		// Set to width
		if (options.menuWidth != 300) {
		menu_id.css('width', options.menuWidth);
		}

		// Add Touch Area
		var dragTarget = $('<div class="drawer-drag-target"></div>');
		$('body').append(dragTarget);

		if (options.edge == 'left') {
		menu_id.css('transform', 'translateX(-100%)');
		dragTarget.css({'left': 0}); // Add Touch Area
		}
		else {
		menu_id.addClass('right-aligned') // Change text-alignment to right
			.css('transform', 'translateX(100%)');
		dragTarget.css({'right': 0}); // Add Touch Area
		}

		// If fixed drawer, bring menu out
		if (menu_id.hasClass('fixed')) {
			if (window.innerWidth > 992) {
			menu_id.css('transform', 'translateX(0)');
			}
		}

		// Window resize to reset on large screens fixed
		if (menu_id.hasClass('fixed')) {
		$(window).resize( function() {
			if (window.innerWidth > 992) {
			// Close menu if window is resized bigger than 992 and user has fixed drawer
			if ($('#drawer-overlay').length !== 0 && menuOut) {
				removeMenu(true);
			}
			else {
				// menu_id.removeAttr('style');
				menu_id.css('transform', 'translateX(0%)');
				// menu_id.css('width', options.menuWidth);
			}
			}
			else if (menuOut === false){
			if (options.edge === 'left') {
				menu_id.css('transform', 'translateX(-100%)');
			} else {
				menu_id.css('transform', 'translateX(100%)');
			}

			}

		});
		}

		// if closeOnClick, then add close event for all a tags in side drawer
		if (options.closeOnClick === true) {
			menu_id.on("click.itemclick", "a:not(.collapsible-header)", function(){
				removeMenu();
			});
		}

		function removeMenu(restoreNav) {
			panning = false;
			menuOut = false;
			// Reenable scrolling
			$('body').css({
				overflow: '',
				width: ''
			});

			$('#drawer-overlay').velocity({opacity: 0}, {duration: 200,
				queue: false, easing: 'easeOutQuad',
				complete: function() {
				$(this).remove();
				} });
			if (options.edge === 'left') {
				// Reset phantom div
				dragTarget.css({width: '', right: '', left: '0'});
				menu_id.velocity(
				{'translateX': '-100%'},
				{ duration: 200,
					queue: false,
					easing: 'easeOutCubic',
					complete: function() {
					if (restoreNav === true) {
						// Restore Fixed drawer
						menu_id.removeAttr('style');
						menu_id.css('width', options.menuWidth);
					}
					}

				});
			}
			else {
				// Reset phantom div
				dragTarget.css({width: '', right: '0', left: ''});
				menu_id.velocity(
				{'translateX': '100%'},
				{ duration: 200,
					queue: false,
					easing: 'easeOutCubic',
					complete: function() {
						if (restoreNav === true) {
							// Restore Fixed drawer
							menu_id.removeAttr('style');
							menu_id.css('width', options.menuWidth);
						}
					}
				});
			}
		}



		// Touch Event
		var panning = false;
		var menuOut = false;

		dragTarget.on('click', function(){
			if (menuOut) {
				removeMenu();
			}
		});

		dragTarget.hammer({
		prevent_default: false
		}).bind('pan', function(e) {

		if (e.gesture.pointerType == "touch") {

			var direction = e.gesture.direction;
			var x = e.gesture.center.x;
			var y = e.gesture.center.y;
			var velocityX = e.gesture.velocityX;

			// Disable Scrolling
			var $body = $('body');
			var oldWidth = $body.innerWidth();
			$body.css('overflow', 'hidden');
			$body.width(oldWidth);

			// If overlay does not exist, create one and if it is clicked, close menu
			if ($('#drawer-overlay').length === 0) {
			var overlay = $('<div id="drawer-overlay"></div>');
			overlay.css('opacity', 0).click( function(){
				removeMenu();
			});
			$('body').append(overlay);
			}

			// Keep within boundaries
			if (options.edge === 'left') {
			if (x > options.menuWidth) { x = options.menuWidth; }
			else if (x < 0) { x = 0; }
			}

			if (options.edge === 'left') {
			// Left Direction
			if (x < (options.menuWidth / 2)) { menuOut = false; }
			// Right Direction
			else if (x >= (options.menuWidth / 2)) { menuOut = true; }
			menu_id.css('transform', 'translateX(' + (x - options.menuWidth) + 'px)');
			}
			else {
			// Left Direction
			if (x < (window.innerWidth - options.menuWidth / 2)) {
				menuOut = true;
			}
			// Right Direction
			else if (x >= (window.innerWidth - options.menuWidth / 2)) {
			 menuOut = false;
			 }
			var rightPos = (x - options.menuWidth / 2);
			if (rightPos < 0) {
				rightPos = 0;
			}

			menu_id.css('transform', 'translateX(' + rightPos + 'px)');
			}


			// Percentage overlay
			var overlayPerc;
			if (options.edge === 'left') {
			overlayPerc = x / options.menuWidth;
			$('#drawer-overlay').velocity({opacity: overlayPerc }, {duration: 10, queue: false, easing: 'easeOutQuad'});
			}
			else {
			overlayPerc = Math.abs((x - window.innerWidth) / options.menuWidth);
			$('#drawer-overlay').velocity({opacity: overlayPerc }, {duration: 10, queue: false, easing: 'easeOutQuad'});
			}
		}

		}).bind('panend', function(e) {

		if (e.gesture.pointerType == "touch") {
			var velocityX = e.gesture.velocityX;
			var x = e.gesture.center.x;
			var leftPos = x - options.menuWidth;
			var rightPos = x - options.menuWidth / 2;
			if (leftPos > 0 ) {
			leftPos = 0;
			}
			if (rightPos < 0) {
			rightPos = 0;
			}
			panning = false;

			if (options.edge === 'left') {
			// If velocityX <= 0.3 then the user is flinging the menu closed so ignore menuOut
			if ((menuOut && velocityX <= 0.3) || velocityX < -0.5) {
				// Return menu to open
				if (leftPos !== 0) {
				menu_id.velocity({'translateX': [0, leftPos]}, {duration: 300, queue: false, easing: 'easeOutQuad'});
				}

				$('#drawer-overlay').velocity({opacity: 1 }, {duration: 50, queue: false, easing: 'easeOutQuad'});
				dragTarget.css({width: '50%', right: 0, left: ''});
				menuOut = true;
			}
			else if (!menuOut || velocityX > 0.3) {
				// Enable Scrolling
				$('body').css({
				overflow: '',
				width: ''
				});
				// Slide menu closed
				menu_id.velocity({'translateX': [-1 * options.menuWidth - 10, leftPos]}, {duration: 200, queue: false, easing: 'easeOutQuad'});
				$('#drawer-overlay').velocity({opacity: 0 }, {duration: 200, queue: false, easing: 'easeOutQuad',
				complete: function () {
					$(this).remove();
				}});
				dragTarget.css({width: '10px', right: '', left: 0});
			}
			}
			else {
			if ((menuOut && velocityX >= -0.3) || velocityX > 0.5) {
				// Return menu to open
				if (rightPos !== 0) {
				menu_id.velocity({'translateX': [0, rightPos]}, {duration: 300, queue: false, easing: 'easeOutQuad'});
				}

				$('#drawer-overlay').velocity({opacity: 1 }, {duration: 50, queue: false, easing: 'easeOutQuad'});
				dragTarget.css({width: '50%', right: '', left: 0});
				menuOut = true;
			}
			else if (!menuOut || velocityX < -0.3) {
				// Enable Scrolling
				$('body').css({
				overflow: '',
				width: ''
				});

				// Slide menu closed
				menu_id.velocity({'translateX': [options.menuWidth + 10, rightPos]}, {duration: 200, queue: false, easing: 'easeOutQuad'});
				$('#drawer-overlay').velocity({opacity: 0 }, {duration: 200, queue: false, easing: 'easeOutQuad',
				complete: function () {
					$(this).remove();
				}});
				dragTarget.css({width: '10px', right: 0, left: ''});
			}
			}

		}
		});

		$this.click(function() {
			if (menuOut === true) {
				menuOut = false;
				panning = false;
				removeMenu();
			}
			else {

				// Disable Scrolling
				var $body = $('body');
				var oldWidth = $body.innerWidth();
				$body.css('overflow', 'hidden');
				$body.width(oldWidth);

				// Push current drag target on top of DOM tree
				$('body').append(dragTarget);

				if (options.edge === 'left') {
					dragTarget.css({width: '50%', right: 0, left: ''});
					menu_id.velocity({'translateX': [0, -1 * options.menuWidth]}, {duration: 300, queue: false, easing: 'easeOutQuad'});
				}
				else {
					dragTarget.css({width: '50%', right: '', left: 0});
					menu_id.velocity({'translateX': [0, options.menuWidth]}, {duration: 300, queue: false, easing: 'easeOutQuad'});
				}

				var overlay = $('<div id="drawer-overlay"></div>');
				overlay.css('opacity', 0)
				.click(function(){
					menuOut = false;
					panning = false;
					removeMenu();
					overlay.velocity({opacity: 0}, {duration: 300, queue: false, easing: 'easeOutQuad',
					complete: function() {
						$(this).remove();
					} });

				});
				$('body').append(overlay);
				overlay.velocity({opacity: 1}, {duration: 300, queue: false, easing: 'easeOutQuad',
					complete: function () {
					menuOut = true;
					panning = false;
					}
				});
			}

			return false;
		});
	});


	},
	show : function() {
		this.trigger('click');
	},
	hide : function() {
		$('#drawer-overlay').trigger('click');
	}
};


	$.fn.drawer = function(methodOrOptions) {
		if (methods[methodOrOptions] ) {
			return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
			// Default to "init"
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +methodOrOptions + ' does not exist on jQuery.drawer' );
		}
	}; // Plugin end
}(jQuery));

;(function($) {
	/**
	 * Extend jquery with a scrollspy plugin.
	 * This watches the window scroll and fires events when elements are scrolled into viewport.
	 *
	 * throttle() and getTime() taken from Underscore.js
	 * https://github.com/jashkenas/underscore
	 *
	 * @author Copyright 2013 John Smart
	 * @license https://raw.github.com/thesmart/jquery-scrollspy/master/LICENSE
	 * @see https://github.com/thesmart
	 * @version 0.1.2
	*/

	var jWindow = $(window);
	var elements = [];
	var elementsInView = [];
	var isSpying = false;
	var ticks = 0;
	var unique_id = 1;
	var offset = {
		top : 0,
		right : 0,
		bottom : 0,
		left : 0,
	}

	/**
	 * Find elements that are within the boundary
	 * @param {number} top
	 * @param {number} right
	 * @param {number} bottom
	 * @param {number} left
	 * @return {jQuery}		A collection of elements
	 */
	function findElements(top, right, bottom, left) {
		var hits = $();
		$.each(elements, function(i, element) {
			if (element.height() > 0) {
				var elTop = element.offset().top,
					elLeft = element.offset().left,
					elRight = elLeft + element.width(),
					elBottom = elTop + element.height();

				var isIntersect = !(elLeft > right ||
					elRight < left ||
					elTop > bottom ||
					elBottom < top);

				if (isIntersect) {
					hits.push(element);
				}
			}
		});

		return hits;
	}


	/**
	 * Called when the user scrolls the window
	 */
	function onScroll() {
		// unique tick id
		++ticks;

		// viewport rectangle
		var top = jWindow.scrollTop(),
			left = jWindow.scrollLeft(),
			right = left + jWindow.width(),
			bottom = top + jWindow.height();

		// determine which elements are in view
//+ 60 accounts for fixed nav
		var intersections = findElements(top+offset.top + 200, right+offset.right, bottom+offset.bottom, left+offset.left);
		$.each(intersections, function(i, element) {

			var lastTick = element.data('scrollSpy:ticks');
			if (typeof lastTick != 'number') {
				// entered into view
				element.triggerHandler('scrollSpy:enter');
			}

			// update tick id
			element.data('scrollSpy:ticks', ticks);
		});

		// determine which elements are no longer in view
		$.each(elementsInView, function(i, element) {
			var lastTick = element.data('scrollSpy:ticks');
			if (typeof lastTick == 'number' && lastTick !== ticks) {
				// exited from view
				element.triggerHandler('scrollSpy:exit');
				element.data('scrollSpy:ticks', null);
			}
		});

		// remember elements in view for next tick
		elementsInView = intersections;
	}

	/**
	 * Called when window is resized
	*/
	function onWinSize() {
		jWindow.trigger('scrollSpy:winSize');
	}

	/**
	 * Get time in ms
 * @license https://raw.github.com/jashkenas/underscore/master/LICENSE
	 * @type {function}
	 * @return {number}
	 */
	var getTime = (Date.now || function () {
		return new Date().getTime();
	});

	/**
	 * Returns a function, that, when invoked, will only be triggered at most once
	 * during a given window of time. Normally, the throttled function will run
	 * as much as it can, without ever going more than once per `wait` duration;
	 * but if you'd like to disable the execution on the leading edge, pass
	 * `{leading: false}`. To disable execution on the trailing edge, ditto.
	 * @license https://raw.github.com/jashkenas/underscore/master/LICENSE
	 * @param {function} func
	 * @param {number} wait
	 * @param {Object=} options
	 * @returns {Function}
	 */
	function throttle(func, wait, options) {
		var context, args, result;
		var timeout = null;
		var previous = 0;
		options || (options = {});
		var later = function () {
			previous = options.leading === false ? 0 : getTime();
			timeout = null;
			result = func.apply(context, args);
			context = args = null;
		};
		return function () {
			var now = getTime();
			if (!previous && options.leading === false) previous = now;
			var remaining = wait - (now - previous);
			context = this;
			args = arguments;
			if (remaining <= 0) {
				clearTimeout(timeout);
				timeout = null;
				previous = now;
				result = func.apply(context, args);
				context = args = null;
			} else if (!timeout && options.trailing !== false) {
				timeout = setTimeout(later, remaining);
			}
			return result;
		};
	};

	/**
	 * Enables ScrollSpy using a selector
	 * @param {jQuery|string} selectorThe elements collection, or a selector
	 * @param {Object=} options	Optional.
		throttle : number -> scrollspy throttling. Default: 100 ms
		offsetTop : number -> offset from top. Default: 0
		offsetRight : number -> offset from right. Default: 0
		offsetBottom : number -> offset from bottom. Default: 0
		offsetLeft : number -> offset from left. Default: 0
	 * @returns {jQuery}
	 */
	$.scrollSpy = function(selector, options) {
	var defaults = {
			throttle: 100,
			scrollOffset: 200 // offset - 200 allows elements near bottom of page to scroll
	};
	options = $.extend(defaults, options);

		var visible = [];
		selector = $(selector);
		selector.each(function(i, element) {
			elements.push($(element));
			$(element).data("scrollSpy:id", i);
			// Smooth scroll to section
		$('a[href="#' + $(element).attr('id') + '"]').click(function(e) {
			e.preventDefault();
			var offset = $(this.hash).offset().top + 1;
			$('html, body').animate({ scrollTop: offset - options.scrollOffset }, {duration: 400, queue: false, easing: 'easeOutCubic'});
		});
		});

		offset.top = options.offsetTop || 0;
		offset.right = options.offsetRight || 0;
		offset.bottom = options.offsetBottom || 0;
		offset.left = options.offsetLeft || 0;

		var throttledScroll = throttle(onScroll, options.throttle || 100);
		var readyScroll = function(){
			$(document).ready(throttledScroll);
		};

		if (!isSpying) {
			jWindow.on('scroll', readyScroll);
			jWindow.on('resize', readyScroll);
			isSpying = true;
		}

		// perform a scan once, after current execution context, and after dom is ready
		setTimeout(readyScroll, 0);


		selector.on('scrollSpy:enter', function() {
			visible = $.grep(visible, function(value) {
		return value.height() != 0;
		});

			var $this = $(this);

			if (visible[0]) {
				$('a[href="#' + visible[0].attr('id') + '"]').removeClass('active');
				if ($this.data('scrollSpy:id') < visible[0].data('scrollSpy:id')) {
					visible.unshift($(this));
				}
				else {
					visible.push($(this));
				}
			}
			else {
				visible.push($(this));
			}


			$('a[href="#' + visible[0].attr('id') + '"]').addClass('active');
		});
		selector.on('scrollSpy:exit', function() {
			visible = $.grep(visible, function(value) {
		return value.height() != 0;
		});

			if (visible[0]) {
				$('a[href="#' + visible[0].attr('id') + '"]').removeClass('active');
				var $this = $(this);
				visible = $.grep(visible, function(value) {
			return value.attr('id') != $this.attr('id');
		});
		if (visible[0]) { // Check if empty
					$('a[href="#' + visible[0].attr('id') + '"]').addClass('active');
		}
			}
		});

		return selector;
	};

	/**
	 * Listen for window resize events
	 * @param {Object=} options						Optional. Set { throttle: number } to change throttling. Default: 100 ms
	 * @returns {jQuery}		$(window)
	 */
	$.winSizeSpy = function(options) {
		$.winSizeSpy = function() { return jWindow; }; // lock from multiple calls
		options = options || {
			throttle: 100
		};
		return jWindow.on('resize', throttle(onWinSize, options.throttle || 100));
	};

	/**
	 * Enables ScrollSpy on a collection of elements
	 * e.g. $('.scrollSpy').scrollSpy()
	 * @param {Object=} options	Optional.
											throttle : number -> scrollspy throttling. Default: 100 ms
											offsetTop : number -> offset from top. Default: 0
											offsetRight : number -> offset from right. Default: 0
											offsetBottom : number -> offset from bottom. Default: 0
											offsetLeft : number -> offset from left. Default: 0
	 * @returns {jQuery}
	 */
	$.fn.scrollSpy = function(options) {
		return $.scrollSpy($(this), options);
	};

})(jQuery);
;(function ($) {
$(document).ready(function() {

	// Function to update labels of text fields
	Materialize.updateTextFields = function() {
	var input_selector = 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], textarea';
	$(input_selector).each(function(index, element) {
		if ($(element).is('input[type=password]')) {
			var autocompleted = $(element).autocomplete("instance");
			if (autocompleted !== 'undefined') {
				validate_field($(this));
				$(this).siblings('label').addClass('active');
			}
			
		}
		if ($(element).val().length > 0 || element.autofocus ||$(this).attr('placeholder') !== undefined || $(element)[0].validity.badInput === true) {
		$(this).siblings('label').addClass('active');
		}
		else {
		$(this).siblings('label').removeClass('active');
		}
	});
	};

	// Text based inputs
	var input_selector = 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=number], input[type=search], textarea';

	// Add active if form auto complete
	$(document).on('change', input_selector, function () {
		validate_field($(this));
	if($(this).val().length !== 0 || $(this).attr('placeholder') !== undefined) {
		$(this).siblings('label').addClass('active');
	}
	
	});

	// Add active if input element has been pre-populated on document ready
	$(document).ready(function() {
	Materialize.updateTextFields();
	});

	// HTML DOM FORM RESET handling
	$(document).on('reset', function(e) {
	var formReset = $(e.target);
	if (formReset.is('form')) {
		formReset.find(input_selector).removeClass('valid').removeClass('invalid');
		formReset.find(input_selector).each(function () {
		if ($(this).attr('value') === '') {
			$(this).siblings('label').removeClass('active');
		}
		});

		// Reset select
		formReset.find('select.initialized').each(function () {
		var reset_text = formReset.find('option[selected]').text();
		formReset.siblings('input.select-dropdown').val(reset_text);
		});
	}
	});

	// Add active when element has focus
	$(document).on('focus', input_selector, function () {
	$(this).siblings('label, .prefix').addClass('active');
	});

	$(document).on('blur', input_selector, function () {
	var $inputElement = $(this);
	var selector = ".prefix";

	if ($inputElement.val().length === 0 && $inputElement[0].validity.badInput !== true && $inputElement.attr('placeholder') === undefined) {
		selector += ", label";
	}

	$inputElement.siblings(selector).removeClass('active');

	validate_field($inputElement);
	});

	window.validate_field = function(object) {
	var hasLength = object.attr('length') !== undefined;
	var lenAttr = parseInt(object.attr('length'));
	var len = object.val().length;

	if (object.val().length === 0 && object[0].validity.badInput === false) {
		if (object.hasClass('validate')) {
		object.removeClass('valid');
		object.removeClass('invalid');
		}
	}
	else {
		if (object.hasClass('validate')) {
		// Check for character counter attributes
		if ((object.is(':valid') && hasLength && (len <= lenAttr)) || (object.is(':valid') && !hasLength)) {
			object.removeClass('invalid');
			object.addClass('valid');
		}
		else {
			object.removeClass('valid');
			object.addClass('invalid');
		}
		}
	}
	};

	// Radio and Checkbox focus class
	var radio_checkbox = 'input[type=radio], input[type=checkbox]';
	$(document).on('keyup.radio', radio_checkbox, function(e) {
		
	// TAB, check if tabbing to radio or checkbox.
	if (e.which === 9) {
		$(this).addClass('tabbed');
		var $this = $(this);
		$this.one('blur', function(e) {

		$(this).removeClass('tabbed');
		});
		return;
	}
	});

	// Textarea Auto Resize
	var hiddenDiv = $('.hiddendiv').first();
	if (!hiddenDiv.length) {
	hiddenDiv = $('<div class="hiddendiv common"></div>');
	$('body').append(hiddenDiv);
	}
	var text_area_selector = '.materialize-textarea';

	function textareaAutoResize($textarea) {
	// Set font properties of hiddenDiv

	var fontFamily = $textarea.css('font-family');
	var fontSize = $textarea.css('font-size');
	var lineHeight = $textarea.css('line-height');

	if (fontSize) { hiddenDiv.css('font-size', fontSize); }
	if (fontFamily) { hiddenDiv.css('font-family', fontFamily); }
	if (lineHeight) { hiddenDiv.css('line-height', lineHeight); }

	if ($textarea.attr('wrap') === "off") {
		hiddenDiv.css('overflow-wrap', "normal")
				 .css('white-space', "pre");
	}

	hiddenDiv.text($textarea.val() + '\n');
	var content = hiddenDiv.html().replace(/\n/g, '<br>');
	hiddenDiv.html(content);


	// When textarea is hidden, width goes crazy.
	// Approximate with half of window size

	if ($textarea.is(':visible')) {
		hiddenDiv.css('width', $textarea.width());
	}
	else {
		hiddenDiv.css('width', $(window).width()/2);
	}

	$textarea.css('height', hiddenDiv.height());
	}

	$(text_area_selector).each(function () {
	var $textarea = $(this);
	if ($textarea.val().length) {
		textareaAutoResize($textarea);
	}
	});

	$('body').on('keyup keydown autoresize', text_area_selector, function () {
	textareaAutoResize($(this));
	});

	// File Input Path
	$(document).on('change', '.file-field input[type="file"]', function () {
	var file_field = $(this).closest('.file-field');
	var path_input = file_field.find('input.file-path');
	var files= $(this)[0].files;
	var file_names = [];
	for (var i = 0; i < files.length; i++) {
		file_names.push(files[i].name);
	}
	path_input.val(file_names.join(", "));
	path_input.trigger('change');
	});

	/****************
	*Range Input*
	****************/

	var range_type = 'input[type=range]';
	var range_mousedown = false;
	var left;

	$(range_type).each(function () {
	var thumb = $('<span class="thumb"><span class="value"></span></span>');
	$(this).after(thumb);
	});

	var range_wrapper = '.range-field';
	$(document).on('change', range_type, function(e) {
	var thumb = $(this).siblings('.thumb');
	thumb.find('.value').html($(this).val());
	});

	$(document).on('input mousedown touchstart', range_type, function(e) {
	var thumb = $(this).siblings('.thumb');
	var width = $(this).outerWidth();

	// If thumb indicator does not exist yet, create it
	if (thumb.length <= 0) {
		thumb = $('<span class="thumb"><span class="value"></span></span>');
		$(this).after(thumb);
	}

	// Set indicator value
	thumb.find('.value').html($(this).val());

	range_mousedown = true;
	$(this).addClass('active');

	if (!thumb.hasClass('active')) {
		thumb.velocity({ height: "30px", width: "30px", top: "-20px", marginLeft: "-15px"}, { duration: 300, easing: 'easeOutExpo' });
	}

	if (e.type !== 'input') {
		if(e.pageX === undefined || e.pageX === null){//mobile
		 left = e.originalEvent.touches[0].pageX - $(this).offset().left;
		}
		else{ // desktop
		 left = e.pageX - $(this).offset().left;
		}
		if (left < 0) {
		left = 0;
		}
		else if (left > width) {
		left = width;
		}
		thumb.addClass('active').css('left', left);
	}

	thumb.find('.value').html($(this).val());
	});

	$(document).on('mouseup touchend', range_wrapper, function() {
	range_mousedown = false;
	$(this).removeClass('active');
	});

	$(document).on('mousemove touchmove', range_wrapper, function(e) {
	var thumb = $(this).children('.thumb');
	var left;
	if (range_mousedown) {
		if (!thumb.hasClass('active')) {
		thumb.velocity({ height: '30px', width: '30px', top: '-20px', marginLeft: '-15px'}, { duration: 300, easing: 'easeOutExpo' });
		}
		if (e.pageX === undefined || e.pageX === null) { //mobile
		left = e.originalEvent.touches[0].pageX - $(this).offset().left;
		}
		else{ // desktop
		left = e.pageX - $(this).offset().left;
		}
		var width = $(this).outerWidth();

		if (left < 0) {
		left = 0;
		}
		else if (left > width) {
		left = width;
		}
		thumb.addClass('active').css('left', left);
		thumb.find('.value').html(thumb.siblings(range_type).val());
	}
	});

	$(document).on('mouseout touchleave', range_wrapper, function() {
	if (!range_mousedown) {

		var thumb = $(this).children('.thumb');

		if (thumb.hasClass('active')) {
		thumb.velocity({ height: '0', width: '0', top: '10px', marginLeft: '-6px'}, { duration: 100 });
		}
		thumb.removeClass('active');
	}
	});

	/**************************
	 * Auto complete plugin*
	 *************************/
	$.fn.autocomplete = function (options) {
	// Defaults
	var defaults = {
		data: {}
	};

	options = $.extend(defaults, options);

	return this.each(function() {
		var $input = $(this);
		var data = options.data,
			$inputDiv = $input.closest('.input-field'); // Div to append on

		// Check if data isn't empty
		if (!$.isEmptyObject(data)) {
		// Create autocomplete element
		var $autocomplete = $('<ul class="autocomplete-content dropdown-content"></ul>');

		// Append autocomplete element
		if ($inputDiv.length) {
			$inputDiv.append($autocomplete); // Set ul in body
		} else {
			$input.after($autocomplete);
		}

		var highlight = function(string, $el) {
			var img = $el.find('img');
			var matchStart = $el.text().toLowerCase().indexOf("" + string.toLowerCase() + ""),
				matchEnd = matchStart + string.length - 1,
				beforeMatch = $el.text().slice(0, matchStart),
				matchText = $el.text().slice(matchStart, matchEnd + 1),
				afterMatch = $el.text().slice(matchEnd + 1);
			$el.html("<span>" + beforeMatch + "<span class='highlight'>" + matchText + "</span>" + afterMatch + "</span>");
			if (img.length) {
			$el.prepend(img);
			}
		};

		// Perform search
		$input.on('keyup', function (e) {
			// Capture Enter
			if (e.which === 13) {
			$autocomplete.find('li').first().click();
			return;
			}

			var val = $input.val().toLowerCase();
			$autocomplete.empty();

			// Check if the input isn't empty
			if (val !== '') {
			for(var key in data) {
				if (data.hasOwnProperty(key) &&
					key.toLowerCase().indexOf(val) !== -1 &&
					key.toLowerCase() !== val) {
				var autocompleteOption = $('<li></li>');
				if(!!data[key]) {
					autocompleteOption.append('<img src="'+ data[key] +'" class="right circle"><span>'+ key +'</span>');
				} else {
					autocompleteOption.append('<span>'+ key +'</span>');
				}
				$autocomplete.append(autocompleteOption);

				highlight(val, autocompleteOption);
				}
			}
			}
		});

		// Set input value
		$autocomplete.on('click', 'li', function () {
			$input.val($(this).text().trim());
			$autocomplete.empty();
		});
		}
	});
	};

}); // End of $(document).ready

/*******************
 *Select Plugin*
 ******************/
$.fn.material_select = function (callback) {
	var defaults = {
		closeonselect: true,
		closeonclickoutside: false
	};
	$(this).each(function(){
	var $select = $(this);

	if ($select.hasClass('browser-default')) {
		return; // Continue to next (return false breaks out of entire loop)
	}

	var multiple = $select.attr('multiple') ? true : false,
		lastID = $select.data('select-id'); // Tear down structure if Select needs to be rebuilt

	if (lastID) {
		$select.parent().find('span.caret').remove();
		$select.parent().find('input').remove();

		$select.unwrap();
		$('ul#select-options-'+lastID).remove();
	}

	// If destroying the select, remove the selelct-id and reset it to it's uninitialized state.
	if(callback === 'destroy') {
		$select.data('select-id', null).removeClass('initialized');
		return;
	}

	var uniqueID = Materialize.guid();
	$select.data('select-id', uniqueID);
	var wrapper = $('<div class="select-wrapper white"></div>');
	wrapper.addClass($select.attr('class'));
	var options = $('<ul id="select-options-' + uniqueID +'" class="dropdown-content select-dropdown ' + (multiple ? 'multiple-select-dropdown' : '') + '"></ul>'),
		selectChildren = $select.children('option, optgroup'),
		valuesSelected = [],
		optionsHover = false,
		selectsearchdom = $('<li class="selectsearchdom"><span><i class="material-icons prefix">search</i><input id="select-search-'+uniqueID+'" type="text" class="validate"><label for="select-search-'+uniqueID+'">Search</label></span></li>');


	var label = $select.find('option:selected').html() || $select.find('option:first').html() || "";

	// Function that renders and appends the option taking into
	// account type and possible image icon.
	var appendOptionWithIcon = function(select, option, type) {
		// Add disabled attr if disabled
		var disabledClass = (option.is(':disabled')) ? 'disabled ' : '';
		var optgroupClass = (type === 'optgroup-option') ? 'optgroup-option ' : '';

		// add icons
		var icon_url = option.data('icon');
		var classes = option.attr('class');
		if (!!icon_url) {
		var classString = '';
		if (!!classes) classString = ' class="' + classes + '"';

		// Check for multiple type.
		if (type === 'multiple') {
			options.append($('<li class="' + disabledClass + '"><img src="' + icon_url + '"' + classString + '><span><input type="checkbox"' + disabledClass + '/><label></label>' + option.html() + '</span></li>'));
		} else {
			options.append($('<li class="' + disabledClass + optgroupClass + '"><img src="' + icon_url + '"' + classString + '><span>' + option.html() + '</span></li>'));
		}
		return true;
		}

		// Check for multiple type.
		if (type === 'multiple') {
		options.append($('<li class="' + disabledClass + '"><span><input type="checkbox"' + disabledClass + '/><label></label>' + option.html() + '</span></li>'));
		} else {
		options.append($('<li class="' + disabledClass + optgroupClass + '"><span>' + option.html() + '</span></li>'));
		}
	};

	/* Create dropdown structure. */
	if (selectChildren.length) {
		selectChildren.each(function() {
		if ($(this).is('option')) {
			// Direct descendant option.
			if (multiple) {
			appendOptionWithIcon($select, $(this), 'multiple');

			} else {
			appendOptionWithIcon($select, $(this));
			}
		} else if ($(this).is('optgroup')) {
			// Optgroup.
			var selectOptions = $(this).children('option');
			options.append($('<li class="optgroup"><span>' + $(this).attr('label') + '</span></li>'));

			selectOptions.each(function() {
			appendOptionWithIcon($select, $(this), 'optgroup-option');
			});
		}
		});
	}

	options.find('li:not(.optgroup)').each(function (i) {
		$(this).click(function (e) {
			if($.inArray(e.currentTarget, selectsearchdom.children())){
				console.log(e.currentTarget);
			}
			if ($(this).hasClass('selectsearchdom')) {
				console.log('Search dom clicked');
			}
			if (!$(this).hasClass('selectsearchdom')) {
				// Check if option element is disabled
			if (!$(this).hasClass('disabled') && !$(this).hasClass('optgroup')) {
				var selected = true;

				if (multiple) {
				$('input[type="checkbox"]', this).prop('checked', function(i, v) { return !v; });
				selected = toggleEntryFromArray(valuesSelected, $(this).index(), $select);
				$newSelect.trigger('focus');
				} else {
				options.find('li').removeClass('active');
				$(this).toggleClass('active');
				$newSelect.val($(this).text());
				}

				activateOption(options, $(this));
				$select.find('option').eq(i).prop('selected', selected);
				// Trigger onchange() event
				$select.trigger('change');
				if (typeof callback !== 'undefined') callback();
			}
			}
			

		e.stopPropagation();
		});
	});

	// Wrap Elements
	$select.wrap(wrapper);
	// Add Select Display Element
	var dropdownIcon = $('<span class="caret">&#9660;</span>');
	if ($select.is(':disabled'))
		dropdownIcon.addClass('disabled');

	// escape double quotes
	var sanitizedLabelHtml = label.replace(/"/g, '&quot;');

	var $newSelect = $('<input type="text" class="select-dropdown" readonly="true" ' + (($select.is(':disabled')) ? 'disabled' : '') + ' data-activates="select-options-' + uniqueID +'" value="'+ sanitizedLabelHtml +'"/>');
	$select.before($newSelect);
	$newSelect.before(dropdownIcon);

	$newSelect.after(options);
	// Check if section element is disabled
	if (!$select.is(':disabled')) {
		$newSelect.dropdown({'hover': false, alignment: 'left', 'closeOnClick': false});
	}

	// Copy tabindex
	if ($select.attr('tabindex')) {
		$($newSelect[0]).attr('tabindex', $select.attr('tabindex'));
	}

	$select.addClass('initialized');

	$newSelect.on({
		'focus': function (){
		if ($('ul.select-dropdown').not(options[0]).is(':visible')) {
			$('input.select-dropdown').trigger('close');
		}
		if (!options.is(':visible')) {
			$(this).trigger('open', ['focus']);
			var label = $(this).val();
			var selectedOption = options.find('li').filter(function() {
			return $(this).text().toLowerCase() === label.toLowerCase();
			})[0];
			activateOption(options, selectedOption);
		}
		},
		'click': function (e){
		e.stopPropagation();
		}
	});

	$newSelect.on('blur', function() {
		if (!multiple) {
		$(this).trigger('close');
		}
		options.find('li.selected').removeClass('selected');
	});

	options.hover(function() {
		optionsHover = true;
	}, function () {
		optionsHover = false;
	});

	$(window).on({
		'click': function () {
		multiple && (optionsHover || $newSelect.trigger('close'));
		}
	});

	// Add initial multiple selections.
	if (multiple) {
		$select.find("option:selected:not(:disabled)").each(function () {
		var index = $(this).index();

		toggleEntryFromArray(valuesSelected, index, $select);
		options.find("li").eq(index).find(":checkbox").prop("checked", true);
		});
	}

	// Make option as selected and scroll to selected position
	var activateOption = function(collection, newOption) {
		if (newOption) {
		collection.find('li.selected').removeClass('selected');
		var option = $(newOption);
		option.addClass('selected');
		options.scrollTo(option);
		}
	};

	// Allow user to search by typing
	// this array is cleared after 1 second
	var filterQuery = [],
		onKeyDown = function(e){
			// TAB - switch to another input
			if(e.which == 9){
			$newSelect.trigger('close');
			return;
			}

			// ARROW DOWN WHEN SELECT IS CLOSED - open select options
			if(e.which == 40 && !options.is(':visible')){
			$newSelect.trigger('open');
			return;
			}

			// ENTER WHEN SELECT IS CLOSED - submit form
			if(e.which == 13 && !options.is(':visible')){
			return;
			}

			e.preventDefault();

			// CASE WHEN USER TYPE LETTERS
			var letter = String.fromCharCode(e.which).toLowerCase(),
				nonLetters = [9,13,27,38,40];
			if (letter && (nonLetters.indexOf(e.which) === -1)) {
			filterQuery.push(letter);

			var string = filterQuery.join(''),
				newOption = options.find('li').filter(function() {
					return $(this).text().toLowerCase().indexOf(string) === 0;
				})[0];

			if (newOption) {
				activateOption(options, newOption);
			}
			}

			// ENTER - select option and close when select options are opened
			if (e.which == 13) {
			var activeOption = options.find('li.selected:not(.disabled)')[0];
			if(activeOption){
				$(activeOption).trigger('click');
				if (!multiple) {
				$newSelect.trigger('close');
				}
			}
			}

			// ARROW DOWN - move to next not disabled option
			if (e.which == 40) {
			if (options.find('li.selected').length) {
				newOption = options.find('li.selected').next('li:not(.disabled)')[0];
			} else {
				newOption = options.find('li:not(.disabled)')[0];
			}
			activateOption(options, newOption);
			}

			// ESC - close options
			if (e.which == 27) {
			$newSelect.trigger('close');
			}

			// ARROW UP - move to previous not disabled option
			if (e.which == 38) {
			newOption = options.find('li.selected').prev('li:not(.disabled)')[0];
			if(newOption)
				activateOption(options, newOption);
			}

			// Automaticaly clean filter query so user can search again by starting letters
			setTimeout(function(){ filterQuery = []; }, 1000);
		};

	$newSelect.on('keydown', onKeyDown);
	});

	function toggleEntryFromArray(entriesArray, entryIndex, select) {
	var index = entriesArray.indexOf(entryIndex),
		notAdded = index === -1;

	if (notAdded) {
		entriesArray.push(entryIndex);
	} else {
		entriesArray.splice(index, 1);
	}

	select.siblings('ul.dropdown-content').find('li').eq(entryIndex).toggleClass('active');

	// use notAdded instead of true (to detect if the option is selected or not)
	select.find('option').eq(entryIndex).prop('selected', notAdded);
	setValueToInput(entriesArray, select);

	return notAdded;
	}

	function setValueToInput(entriesArray, select) {
	var value = '';

	for (var i = 0, count = entriesArray.length; i < count; i++) {
		var text = select.find('option').eq(entriesArray[i]).text();

		i === 0 ? value += text : value += ', ' + text;
	}

	if (value === '') {
		value = select.find('option:disabled').eq(0).text();
	}

	select.siblings('input.select-dropdown').val(value);
	}
};

}( jQuery ));
;(function ($) {

var methods = {

	init : function(options) {
	var defaults = {
		indicators: true,
		height: 400,
		transition: 500,
		interval: 6000
	};
	options = $.extend(defaults, options);

	return this.each(function() {

		// For each slider, we want to keep track of
		// which slide is active and its associated content
		var $this = $(this);
		var $slider = $this.find('ul.slides').first();
		var $slides = $slider.find('> li');
		var $active_index = $slider.find('.active').index();
		var $active, $indicators, $interval;
		if ($active_index != -1) { $active = $slides.eq($active_index); }

		// Transitions the caption depending on alignment
		function captionTransition(caption, duration) {
		if (caption.hasClass("center-align")) {
			caption.velocity({opacity: 0, translateY: -100}, {duration: duration, queue: false});
		}
		else if (caption.hasClass("right-align")) {
			caption.velocity({opacity: 0, translateX: 100}, {duration: duration, queue: false});
		}
		else if (caption.hasClass("left-align")) {
			caption.velocity({opacity: 0, translateX: -100}, {duration: duration, queue: false});
		}
		}

		// This function will transition the slide to any index of the next slide
		function moveToSlide(index) {
		// Wrap around indices.
		if (index >= $slides.length) index = 0;
		else if (index < 0) index = $slides.length -1;

		$active_index = $slider.find('.active').index();

		// Only do if index changes
		if ($active_index != index) {
			$active = $slides.eq($active_index);
			$caption = $active.find('.caption');

			$active.removeClass('active');
			$active.velocity({opacity: 0}, {duration: options.transition, queue: false, easing: 'easeOutQuad',
							complete: function() {
								$slides.not('.active').velocity({opacity: 0, translateX: 0, translateY: 0}, {duration: 0, queue: false});
							} });
			captionTransition($caption, options.transition);


			// Update indicators
			if (options.indicators) {
			$indicators.eq($active_index).removeClass('active');
			}

			$slides.eq(index).velocity({opacity: 1}, {duration: options.transition, queue: false, easing: 'easeOutQuad'});
			$slides.eq(index).find('.caption').velocity({opacity: 1, translateX: 0, translateY: 0}, {duration: options.transition, delay: options.transition, queue: false, easing: 'easeOutQuad'});
			$slides.eq(index).addClass('active');


			// Update indicators
			if (options.indicators) {
			$indicators.eq(index).addClass('active');
			}
		}
		}

		// Set height of slider
		// If fullscreen, do nothing
		if (!$this.hasClass('fullscreen')) {
		if (options.indicators) {
			// Add height if indicators are present
			$this.height(options.height + 40);
		}
		else {
			$this.height(options.height);
		}
		$slider.height(options.height);
		}


		// Set initial positions of captions
		$slides.find('.caption').each(function () {
		captionTransition($(this), 0);
		});

		// Move img src into background-image
		$slides.find('img').each(function () {
		var placeholderBase64 = 'data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		if ($(this).attr('src') !== placeholderBase64) {
			$(this).css('background-image', 'url(' + $(this).attr('src') + ')' );
			$(this).attr('src', placeholderBase64);
		}
		});

		// dynamically add indicators
		if (options.indicators) {
		$indicators = $('<ul class="indicators"></ul>');
		$slides.each(function( index ) {
			var $indicator = $('<li class="indicator-item"></li>');

			// Handle clicks on indicators
			$indicator.click(function () {
			var $parent = $slider.parent();
			var curr_index = $parent.find($(this)).index();
			moveToSlide(curr_index);

			// reset interval
			clearInterval($interval);
			$interval = setInterval(
				function(){
				$active_index = $slider.find('.active').index();
				if ($slides.length == $active_index + 1) $active_index = 0; // loop to start
				else $active_index += 1;

				moveToSlide($active_index);

				}, options.transition + options.interval
			);
			});
			$indicators.append($indicator);
		});
		$this.append($indicators);
		$indicators = $this.find('ul.indicators').find('li.indicator-item');
		}

		if ($active) {
		$active.show();
		}
		else {
		$slides.first().addClass('active').velocity({opacity: 1}, {duration: options.transition, queue: false, easing: 'easeOutQuad'});

		$active_index = 0;
		$active = $slides.eq($active_index);

		// Update indicators
		if (options.indicators) {
			$indicators.eq($active_index).addClass('active');
		}
		}

		// Adjust height to current slide
		$active.find('img').each(function() {
		$active.find('.caption').velocity({opacity: 1, translateX: 0, translateY: 0}, {duration: options.transition, queue: false, easing: 'easeOutQuad'});
		});

		// auto scroll
		$interval = setInterval(
		function(){
			$active_index = $slider.find('.active').index();
			moveToSlide($active_index + 1);

		}, options.transition + options.interval
		);


		// HammerJS, Swipe navigation

		// Touch Event
		var panning = false;
		var swipeLeft = false;
		var swipeRight = false;

		$this.hammer({
			prevent_default: false
		}).bind('pan', function(e) {
		if (e.gesture.pointerType === "touch") {

			// reset interval
			clearInterval($interval);

			var direction = e.gesture.direction;
			var x = e.gesture.deltaX;
			var velocityX = e.gesture.velocityX;

			$curr_slide = $slider.find('.active');
			$curr_slide.velocity({ translateX: x
				}, {duration: 50, queue: false, easing: 'easeOutQuad'});

			// Swipe Left
			if (direction === 4 && (x > ($this.innerWidth() / 2) || velocityX < -0.65)) {
			swipeRight = true;
			}
			// Swipe Right
			else if (direction === 2 && (x < (-1 * $this.innerWidth() / 2) || velocityX > 0.65)) {
			swipeLeft = true;
			}

			// Make Slide Behind active slide visible
			var next_slide;
			if (swipeLeft) {
			next_slide = $curr_slide.next();
			if (next_slide.length === 0) {
				next_slide = $slides.first();
			}
			next_slide.velocity({ opacity: 1
				}, {duration: 300, queue: false, easing: 'easeOutQuad'});
			}
			if (swipeRight) {
			next_slide = $curr_slide.prev();
			if (next_slide.length === 0) {
				next_slide = $slides.last();
			}
			next_slide.velocity({ opacity: 1
				}, {duration: 300, queue: false, easing: 'easeOutQuad'});
			}


		}

		}).bind('panend', function(e) {
		if (e.gesture.pointerType === "touch") {

			$curr_slide = $slider.find('.active');
			panning = false;
			curr_index = $slider.find('.active').index();

			if (!swipeRight && !swipeLeft || $slides.length <=1) {
			// Return to original spot
			$curr_slide.velocity({ translateX: 0
				}, {duration: 300, queue: false, easing: 'easeOutQuad'});
			}
			else if (swipeLeft) {
			moveToSlide(curr_index + 1);
			$curr_slide.velocity({translateX: -1 * $this.innerWidth() }, {duration: 300, queue: false, easing: 'easeOutQuad',
									complete: function() {
									$curr_slide.velocity({opacity: 0, translateX: 0}, {duration: 0, queue: false});
									} });
			}
			else if (swipeRight) {
			moveToSlide(curr_index - 1);
			$curr_slide.velocity({translateX: $this.innerWidth() }, {duration: 300, queue: false, easing: 'easeOutQuad',
									complete: function() {
									$curr_slide.velocity({opacity: 0, translateX: 0}, {duration: 0, queue: false});
									} });
			}
			swipeLeft = false;
			swipeRight = false;

			// Restart interval
			clearInterval($interval);
			$interval = setInterval(
			function(){
				$active_index = $slider.find('.active').index();
				if ($slides.length == $active_index + 1) $active_index = 0; // loop to start
				else $active_index += 1;

				moveToSlide($active_index);

			}, options.transition + options.interval
			);
		}
		});

		$this.on('sliderPause', function() {
		clearInterval($interval);
		});

		$this.on('sliderStart', function() {
		clearInterval($interval);
		$interval = setInterval(
			function(){
			$active_index = $slider.find('.active').index();
			if ($slides.length == $active_index + 1) $active_index = 0; // loop to start
			else $active_index += 1;

			moveToSlide($active_index);

			}, options.transition + options.interval
		);
		});

		$this.on('sliderNext', function() {
		$active_index = $slider.find('.active').index();
		moveToSlide($active_index + 1);
		});

		$this.on('sliderPrev', function() {
		$active_index = $slider.find('.active').index();
		moveToSlide($active_index - 1);
		});

	});



	},
	pause : function() {
	$(this).trigger('sliderPause');
	},
	start : function() {
	$(this).trigger('sliderStart');
	},
	next : function() {
	$(this).trigger('sliderNext');
	},
	prev : function() {
	$(this).trigger('sliderPrev');
	}
};


	$.fn.materialslider = function(methodOrOptions) {
	if ( methods[methodOrOptions] ) {
		return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	} else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
		// Default to "init"
		return methods.init.apply( this, arguments );
	} else {
		$.error( 'Method ' +methodOrOptions + ' does not exist on jQuery.tooltip' );
	}
	}; // Plugin end
}( jQuery ));
;(function ($) {
$(document).ready(function() {

	$(document).on('click.card', '.card', function (e) {
	if ($(this).find('> .card-reveal').length) {
		if ($(e.target).is($('.card-reveal .card-title')) || $(e.target).is($('.card-reveal .card-title i'))) {
		// Make Reveal animate down and display none
		$(this).find('.card-reveal').velocity(
			{translateY: 0}, {
			duration: 225,
			queue: false,
			easing: 'easeInOutQuad',
			complete: function() { $(this).css({ display: 'none'}); }
			}
		);
		}
		else if ($(e.target).is($('.card .activator')) ||
				 $(e.target).is($('.card .activator i')) ) {
		$(e.target).closest('.card').css('overflow', 'hidden');
		$(this).find('.card-reveal').css({ display: 'block'}).velocity("stop", false).velocity({translateY: '-100%'}, {duration: 300, queue: false, easing: 'easeInOutQuad'});
		}
	}
	});

});
}( jQuery ));;(function ($) {
var chipsHandleEvents = false;
var materialChipsDefaults = {
	data: [],
	placeholder: '',
	secondaryPlaceholder: ''
};

$(document).ready(function(){
	// Handle removal of static chips.
	$(document).on('click', '.chip .close', function(e){
	var $chips = $(this).closest('.chips');
	if ($chips.data('initialized')) {
		return;
	}
	$(this).closest('.chip').remove();
	});
});

$.fn.material_chip = function (options) {
	var self = this;
	this.$el = $(this);
	this.$document = $(document);
	this.SELS = {
	CHIPS: '.chips',
	CHIP: '.chip',
	INPUT: 'input',
	DELETE: '.material-icons',
	SELECTED_CHIP: '.selected',
	};

	if ('data' === options) {
	return this.$el.data('chips');
	}

	if ('options' === options) {
	return this.$el.data('options');
	}

	this.$el.data('options', $.extend({}, materialChipsDefaults, options));

	// Initialize
	this.init = function() {
	var i = 0;
	var chips;
	self.$el.each(function(){
		var $chips = $(this);
		if ($chips.data('initialized')) {
		// Prevent double initialization.
		return;
		}
		var options = $chips.data('options');
		if (!options.data || !options.data instanceof Array) {
		options.data = [];
		}
		$chips.data('chips', options.data);
		$chips.data('index', i);
		$chips.data('initialized', true);

		if (!$chips.hasClass(self.SELS.CHIPS)) {
		$chips.addClass('chips');
		}

		self.chips($chips);
		i++;
	});
	};

	this.handleEvents = function(){
	var SELS = self.SELS;

	self.$document.on('click', SELS.CHIPS, function(e){
		$(e.target).find(SELS.INPUT).focus();
	});

	self.$document.on('click', SELS.CHIP, function(e){
		$(SELS.CHIP).removeClass('selected');
		$(this).toggleClass('selected');
	});

	self.$document.on('keydown', function(e){
		if ($(e.target).is('input, textarea')) {
		return;
		}

		// delete
		var $chip = self.$document.find(SELS.CHIP + SELS.SELECTED_CHIP);
		var $chips = $chip.closest(SELS.CHIPS);
		var length = $chip.siblings(SELS.CHIP).length;
		var index;

		if (!$chip.length) {
		return;
		}

		if (e.which === 8 || e.which === 46) {
		e.preventDefault();
		var chipsIndex = $chips.data('index');

		index = $chip.index();
		self.deleteChip(chipsIndex, index, $chips);

		var selectIndex = null;
		if ((index + 1) < length) {
			selectIndex = index;
		} else if (index === length || (index + 1) === length) {
			selectIndex = length - 1;
		}

		if (selectIndex < 0) selectIndex = null;

		if (null !== selectIndex) {
			self.selectChip(chipsIndex, selectIndex, $chips);
		}
		if (!length) $chips.find('input').focus();

		// left
		} else if (e.which === 37) {
		index = $chip.index() - 1;
		if (index < 0) {
			return;
		}
		$(SELS.CHIP).removeClass('selected');
		self.selectChip($chips.data('index'), index, $chips);

		// right
		} else if (e.which === 39) {
		index = $chip.index() + 1;
		$(SELS.CHIP).removeClass('selected');
		if (index > length) {
			$chips.find('input').focus();
			return;
		}
		self.selectChip($chips.data('index'), index, $chips);
		}
	});

	self.$document.on('focusin', SELS.CHIPS + ' ' + SELS.INPUT, function(e){
		$(e.target).closest(SELS.CHIPS).addClass('focus');
		$(SELS.CHIP).removeClass('selected');
	});

	self.$document.on('focusout', SELS.CHIPS + ' ' + SELS.INPUT, function(e){
		$(e.target).closest(SELS.CHIPS).removeClass('focus');
	});

	self.$document.on('keydown', SELS.CHIPS + ' ' + SELS.INPUT, function(e){
		var $target = $(e.target);
		var $chips = $target.closest(SELS.CHIPS);
		var chipsIndex = $chips.data('index');
		var chipsLength = $chips.children(SELS.CHIP).length;

		// enter
		if (13 === e.which) {
		e.preventDefault();
		self.addChip(chipsIndex, {tag: $target.val()}, $chips);
		$target.val('');
		return;
		}

		// delete or left
		 if ((8 === e.keyCode || 37 === e.keyCode) && '' === $target.val() && chipsLength) {
		self.selectChip(chipsIndex, chipsLength - 1, $chips);
		$target.blur();
		return;
		}
	});

	self.$document.on('click', SELS.CHIPS + ' ' + SELS.DELETE, function(e) {
		var $target = $(e.target);
		var $chips = $target.closest(SELS.CHIPS);
		var $chip = $target.closest(SELS.CHIP);
		e.stopPropagation();
		self.deleteChip(
		$chips.data('index'),
		$chip.index(),
		$chips
		);
		$chips.find('input').focus();
	});
	};

	this.chips = function($chips) {
	var html = '';
	var options = $chips.data('options');
	$chips.data('chips').forEach(function(elem){
		html += self.renderChip(elem);
	});

	html += '<input class="input" placeholder="">';
	$chips.html(html);
	self.setPlaceholder($chips);
	};

	this.renderChip = function(elem) {
	if (!elem.tag) return;

	var html = '<div class="chip">' + elem.tag;
	if (elem.image) {
		html += ' <img src="' + elem.image + '"> ';
	}
	html += '<i class="material-icons close">close</i>';
	html += '</div>';
	return html;
	};

	this.setPlaceholder = function($chips) {
	var options = $chips.data('options');
	if ($chips.data('chips').length && options.placeholder) {
		$chips.find('input').prop('placeholder', options.placeholder);
	} else if (!$chips.data('chips').length && options.secondaryPlaceholder) {
		$chips.find('input').prop('placeholder', options.secondaryPlaceholder);
	}
	};

	this.isValid = function($chips, elem) {
	var chips = $chips.data('chips');
	var exists = false;
	for (var i=0; i < chips.length; i++) {
		if (chips[i].tag === elem.tag) {
			exists = true;
			return;
		}
	}
	return '' !== elem.tag && !exists;
	};

	this.addChip = function(chipsIndex, elem, $chips) {
	if (!self.isValid($chips, elem)) {
		return;
	}
	var options = $chips.data('options');
	var chipHtml = self.renderChip(elem);
	$chips.data('chips').push(elem);
	$(chipHtml).insertBefore($chips.find('input'));
	$chips.trigger('chip.add', elem);
	self.setPlaceholder($chips);
	};

	this.deleteChip = function(chipsIndex, chipIndex, $chips) {
	var chip = $chips.find('.chip').eq(chipIndex);
	$chips.trigger('chip.delete', chip);
	chip.remove();
	$chips.data('chips').splice(chipIndex, 1);
	self.setPlaceholder($chips);
	};

	this.selectChip = function(chipsIndex, chipIndex, $chips) {
	var $chip = $chips.find('.chip').eq(chipIndex);
	if ($chip && false === $chip.hasClass('selected')) {
		$chip.addClass('selected');
		$chips.trigger('chip.select', $chips.data('chips')[chipIndex]);
	}
	};

	this.getChipsElement = function(index, $chips) {
	return $chips.eq(index);
	};

	// init
	this.init();

	if (!chipsHandleEvents) {
	this.handleEvents();
	chipsHandleEvents = true;
	}
};
}( jQuery ));;(function ($) {
$.fn.pushpin = function (options) {
	// Defaults
	var defaults = {
	top: 0,
	bottom: Infinity,
	offset: 0
	};

	// Remove pushpin event and classes
	if (options === "remove") {
	this.each(function () {
		if (id = $(this).data('pushpin-id')) {
		$(window).off('scroll.' + id);
		$(this).removeData('pushpin-id').removeClass('pin-top pinned pin-bottom').removeAttr('style');
		}
	});
	return false;
	}

	options = $.extend(defaults, options);


	$index = 0;
	return this.each(function() {
	var $uniqueId = Materialize.guid(),
		$this = $(this),
		$original_offset = $(this).offset().top;

	function removePinClasses(object) {
		object.removeClass('pin-top');
		object.removeClass('pinned');
		object.removeClass('pin-bottom');
	}

	function updateElements(objects, scrolled) {
		objects.each(function () {
		// Add position fixed (because its between top and bottom)
		if (options.top <= scrolled && options.bottom >= scrolled && !$(this).hasClass('pinned')) {
			removePinClasses($(this));
			$(this).css('top', options.offset);
			$(this).addClass('pinned');
		}

		// Add pin-top (when scrolled position is above top)
		if (scrolled < options.top && !$(this).hasClass('pin-top')) {
			removePinClasses($(this));
			$(this).css('top', 0);
			$(this).addClass('pin-top');
		}

		// Add pin-bottom (when scrolled position is below bottom)
		if (scrolled > options.bottom && !$(this).hasClass('pin-bottom')) {
			removePinClasses($(this));
			$(this).addClass('pin-bottom');
			$(this).css('top', options.bottom - $original_offset);
		}
		});
	}

	$(this).data('pushpin-id', $uniqueId);
	updateElements($this, $(window).scrollTop());
	$(window).on('scroll.' + $uniqueId, function () {
		var $scrolled = $(window).scrollTop() + options.offset;
		updateElements($this, $scrolled);
	});

	});

};
}( jQuery ));;(function ($) {
$(document).ready(function() {

	// jQuery reverse
	$.fn.reverse = [].reverse;

	// Hover behaviour: make sure this doesn't work on .click-to-toggle FABs!
	$(document).on('mouseenter.fixedActionBtn', '.fixed-action-btn:not(.click-to-toggle)', function(e) {
	var $this = $(this);
	openFABMenu($this);
	});
	$(document).on('mouseleave.fixedActionBtn', '.fixed-action-btn:not(.click-to-toggle)', function(e) {
	var $this = $(this);
	closeFABMenu($this);
	});

	// Toggle-on-click behaviour.
	$(document).on('click.fixedActionBtn', '.fixed-action-btn.click-to-toggle > a', function(e) {
	var $this = $(this);
	var $menu = $this.parent();
	if ($menu.hasClass('active')) {
		closeFABMenu($menu);
	} else {
		openFABMenu($menu);
	}
	});

});

$.fn.extend({
	openFAB: function() {
	openFABMenu($(this));
	},
	closeFAB: function() {
	closeFABMenu($(this));
	}
});


var openFABMenu = function (btn) {
	$this = btn;
	if ($this.hasClass('active') === false) {

	// Get direction option
	var horizontal = $this.hasClass('horizontal');
	var offsetY, offsetX;

	if (horizontal === true) {
		offsetX = 40;
	} else {
		offsetY = 40;
	}

	$this.addClass('active');
	$this.find('ul .btn-floating').velocity(
		{ scaleY: ".4", scaleX: ".4", translateY: offsetY + 'px', translateX: offsetX + 'px'},
		{ duration: 0 });

	var time = 0;
	$this.find('ul .btn-floating').reverse().each( function () {
		$(this).velocity(
		{ opacity: "1", scaleX: "1", scaleY: "1", translateY: "0", translateX: '0'},
		{ duration: 80, delay: time });
		time += 40;
	});
	}
};

var closeFABMenu = function (btn) {
	$this = btn;
	// Get direction option
	var horizontal = $this.hasClass('horizontal');
	var offsetY, offsetX;

	if (horizontal === true) {
	offsetX = 40;
	} else {
	offsetY = 40;
	}

	$this.removeClass('active');
	var time = 0;
	$this.find('ul .btn-floating').velocity("stop", true);
	$this.find('ul .btn-floating').velocity(
	{ opacity: "0", scaleX: ".4", scaleY: ".4", translateY: offsetY + 'px', translateX: offsetX + 'px'},
	{ duration: 80 }
	);
};


}( jQuery ));
;(function ($) {
// Image transition function
Materialize.fadeInImage =function(selectorOrEl) {
	var element;
	if (typeof(selectorOrEl) === 'string') {
	element = $(selectorOrEl);
	} else if (typeof(selectorOrEl) === 'object') {
	element = selectorOrEl;
	} else {
	return;
	}
	element.css({opacity: 0});
	$(element).velocity({opacity: 1}, {
		duration: 650,
		queue: false,
		easing: 'easeOutSine'
	});
	$(element).velocity({opacity: 1}, {
		duration: 1300,
		queue: false,
		easing: 'swing',
		step: function(now, fx) {
			fx.start = 100;
			var grayscale_setting = now/100;
			var brightness_setting = 150 - (100 - now)/1.75;

			if (brightness_setting < 100) {
				brightness_setting = 100;
			}
			if (now >= 0) {
				$(this).css({
					"-webkit-filter": "grayscale("+grayscale_setting+")" + "brightness("+brightness_setting+"%)",
					"filter": "grayscale("+grayscale_setting+")" + "brightness("+brightness_setting+"%)"
				});
			}
		}
	});
};

// Horizontal staggered list
Materialize.showStaggeredList = function(selectorOrEl) {
	var element;
	if (typeof(selectorOrEl) === 'string') {
	element = $(selectorOrEl);
	} else if (typeof(selectorOrEl) === 'object') {
	element = selectorOrEl;
	} else {
	return;
	}
	var time = 0;
	element.find('li').velocity(
		{ translateX: "-100px"},
		{ duration: 0 });

	element.find('li').each(function() {
	$(this).velocity(
		{ opacity: "1", translateX: "0"},
		{ duration: 800, delay: time, easing: [60, 10] });
	time += 120;
	});
};


$(document).ready(function() {
	// Hardcoded .staggered-list scrollFire
	// var staggeredListOptions = [];
	// $('ul.staggered-list').each(function (i) {

	// var label = 'scrollFire-' + i;
	// $(this).addClass(label);
	// staggeredListOptions.push(
	// {selector: 'ul.staggered-list.' + label,
	//offset: 200,
	//callback: 'showStaggeredList("ul.staggered-list.' + label + '")'});
	// });
	// scrollFire(staggeredListOptions);

	// HammerJS, Swipe navigation

	// Touch Event
	var swipeLeft = false;
	var swipeRight = false;


	// Dismissible Collections
	$('.dismissable').each(function() {
	$(this).hammer({
		prevent_default: false
	}).bind('pan', function(e) {
		if (e.gesture.pointerType === "touch") {
		var $this = $(this);
		var direction = e.gesture.direction;
		var x = e.gesture.deltaX;
		var velocityX = e.gesture.velocityX;

		$this.velocity({ translateX: x
			}, {duration: 50, queue: false, easing: 'easeOutQuad'});

		// Swipe Left
		if (direction === 4 && (x > ($this.innerWidth() / 2) || velocityX < -0.75)) {
			swipeLeft = true;
		}

		// Swipe Right
		if (direction === 2 && (x < (-1 * $this.innerWidth() / 2) || velocityX > 0.75)) {
			swipeRight = true;
		}
		}
	}).bind('panend', function(e) {
		// Reset if collection is moved back into original position
		if (Math.abs(e.gesture.deltaX) < ($(this).innerWidth() / 2)) {
		swipeRight = false;
		swipeLeft = false;
		}

		if (e.gesture.pointerType === "touch") {
		var $this = $(this);
		if (swipeLeft || swipeRight) {
			var fullWidth;
			if (swipeLeft) { fullWidth = $this.innerWidth(); }
			else { fullWidth = -1 * $this.innerWidth(); }

			$this.velocity({ translateX: fullWidth,
			}, {duration: 100, queue: false, easing: 'easeOutQuad', complete:
			function() {
				$this.css('border', 'none');
				$this.velocity({ height: 0, padding: 0,
				}, {duration: 200, queue: false, easing: 'easeOutQuad', complete:
					function() { $this.remove(); }
				});
			}
			});
		}
		else {
			$this.velocity({ translateX: 0,
			}, {duration: 100, queue: false, easing: 'easeOutQuad'});
		}
		swipeLeft = false;
		swipeRight = false;
		}
	});

	});


	// time = 0
	// // Vertical Staggered list
	// $('ul.staggered-list.vertical li').velocity(
	// { translateY: "100px"},
	// { duration: 0 });

	// $('ul.staggered-list.vertical li').each(function() {
	// $(this).velocity(
	// { opacity: "1", translateY: "0"},
	// { duration: 800, delay: time, easing: [60, 25] });
	// time += 120;
	// });

	// // Fade in and Scale
	// $('.fade-in.scale').velocity(
	// { scaleX: .4, scaleY: .4, translateX: -600},
	// { duration: 0});
	// $('.fade-in').each(function() {
	// $(this).velocity(
	// { opacity: "1", scaleX: 1, scaleY: 1, translateX: 0},
	// { duration: 800, easing: [60, 10] });
	// });
});
}( jQuery ));
;(function($) {

// Input: Array of JSON objects {selector, offset, callback}

Materialize.scrollFire = function(options) {

	var didScroll = false;

	window.addEventListener("scroll", function() {
	didScroll = true;
	});

	// Rate limit to 100ms
	setInterval(function() {
	if(didScroll) {
		didScroll = false;

		var windowScroll = window.pageYOffset + window.innerHeight;

		for (var i = 0 ; i < options.length; i++) {
			// Get options from each line
			var value = options[i];
			var selector = value.selector,
				offset = value.offset,
				callback = value.callback;

			var currentElement = document.querySelector(selector);
			if ( currentElement !== null) {
			var elementOffset = currentElement.getBoundingClientRect().top + window.pageYOffset;

			if (windowScroll > (elementOffset + offset)) {
				if (value.done !== true) {
				if (typeof(callback) === 'function') {
					callback.call(this, currentElement);
				} else if (typeof(callback) === 'string') {
					var callbackFunc = new Function(callback);
					callbackFunc(currentElement);
				}
				value.done = true;
				}
			}
			}
		}
	}
	}, 100);
};

})(jQuery);
;/*!
 * pickadate.js v3.5.0, 2014/04/13
 * By Amsul, http://amsul.ca
 * Hosted on http://amsul.github.io/pickadate.js
 * Licensed under MIT
 */

(function ( factory ) {

	// AMD.
	if ( typeof define == 'function' && define.amd )
		define( 'picker', ['jquery'], factory )

	// Node.js/browserify.
	else if ( typeof exports == 'object' )
		module.exports = factory( require('jquery') )

	// Browser globals.
	else this.Picker = factory( jQuery )

}(function( $ ) {

var $window = $( window )
var $document = $( document )
var $html = $( document.documentElement )


/**
 * The picker constructor that creates a blank picker.
 */
function PickerConstructor( ELEMENT, NAME, COMPONENT, OPTIONS ) {

	// If there’s no element, return the picker constructor.
	if ( !ELEMENT ) return PickerConstructor


	var
		IS_DEFAULT_THEME = false,


		// The state of the picker.
		STATE = {
			id: ELEMENT.id || 'P' + Math.abs( ~~(Math.random() * new Date()) )
		},


		// Merge the defaults and options passed.
		SETTINGS = COMPONENT ? $.extend( true, {}, COMPONENT.defaults, OPTIONS ) : OPTIONS || {},


		// Merge the default classes with the settings classes.
		CLASSES = $.extend( {}, PickerConstructor.klasses(), SETTINGS.klass ),


		// The element node wrapper into a jQuery object.
		$ELEMENT = $( ELEMENT ),


		// Pseudo picker constructor.
		PickerInstance = function() {
			return this.start()
		},


		// The picker prototype.
		P = PickerInstance.prototype = {

			constructor: PickerInstance,

			$node: $ELEMENT,


			/**
			 * Initialize everything
			 */
			start: function() {

				// If it’s already started, do nothing.
				if ( STATE && STATE.start ) return P


				// Update the picker states.
				STATE.methods = {}
				STATE.start = true
				STATE.open = false
				STATE.type = ELEMENT.type


				// Confirm focus state, convert into text input to remove UA stylings,
				// and set as readonly to prevent keyboard popup.
				ELEMENT.autofocus = ELEMENT == getActiveElement()
				ELEMENT.readOnly = !SETTINGS.editable
				ELEMENT.id = ELEMENT.id || STATE.id
				if ( ELEMENT.type != 'text' ) {
					ELEMENT.type = 'text'
				}


				// Create a new picker component with the settings.
				P.component = new COMPONENT(P, SETTINGS)


				// Create the picker root with a holder and then prepare it.
				P.$root = $( PickerConstructor._.node('div', createWrappedComponent(), CLASSES.picker, 'id="' + ELEMENT.id + '_root" tabindex="0"') )
				prepareElementRoot()


				// If there’s a format for the hidden input element, create the element.
				if ( SETTINGS.formatSubmit ) {
					prepareElementHidden()
				}


				// Prepare the input element.
				prepareElement()


				// Insert the root as specified in the settings.
				if ( SETTINGS.container ) $( SETTINGS.container ).append( P.$root )
				else $ELEMENT.after( P.$root )


				// Bind the default component and settings events.
				P.on({
					start: P.component.onStart,
					render: P.component.onRender,
					stop: P.component.onStop,
					open: P.component.onOpen,
					close: P.component.onClose,
					set: P.component.onSet
				}).on({
					start: SETTINGS.onStart,
					render: SETTINGS.onRender,
					stop: SETTINGS.onStop,
					open: SETTINGS.onOpen,
					close: SETTINGS.onClose,
					set: SETTINGS.onSet
				})


				// Once we’re all set, check the theme in use.
				IS_DEFAULT_THEME = isUsingDefaultTheme( P.$root.children()[ 0 ] )


				// If the element has autofocus, open the picker.
				if ( ELEMENT.autofocus ) {
					P.open()
				}


				// Trigger queued the “start” and “render” events.
				return P.trigger( 'start' ).trigger( 'render' )
			}, //start


			/**
			 * Render a new picker
			 */
			render: function( entireComponent ) {

				// Insert a new component holder in the root or box.
				if ( entireComponent ) P.$root.html( createWrappedComponent() )
				else P.$root.find( '.' + CLASSES.box ).html( P.component.nodes( STATE.open ) )

				// Trigger the queued “render” events.
				return P.trigger( 'render' )
			}, //render


			/**
			 * Destroy everything
			 */
			stop: function() {

				// If it’s already stopped, do nothing.
				if ( !STATE.start ) return P

				// Then close the picker.
				P.close()

				// Remove the hidden field.
				if ( P._hidden ) {
					P._hidden.parentNode.removeChild( P._hidden )
				}

				// Remove the root.
				P.$root.remove()

				// Remove the input class, remove the stored data, and unbind
				// the events (after a tick for IE - see `P.close`).
				$ELEMENT.removeClass( CLASSES.input ).removeData( NAME )
				setTimeout( function() {
					$ELEMENT.off( '.' + STATE.id )
				}, 0)

				// Restore the element state
				ELEMENT.type = STATE.type
				ELEMENT.readOnly = false

				// Trigger the queued “stop” events.
				P.trigger( 'stop' )

				// Reset the picker states.
				STATE.methods = {}
				STATE.start = false

				return P
			}, //stop


			/**
			 * Open up the picker
			 */
			open: function( dontGiveFocus ) {

				// If it’s already open, do nothing.
				if ( STATE.open ) return P

				// Add the “active” class.
				$ELEMENT.addClass( CLASSES.active )
				aria( ELEMENT, 'expanded', true )

				// * A Firefox bug, when `html` has `overflow:hidden`, results in
				// killing transitions :(. So add the “opened” state on the next tick.
				// Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=625289
				setTimeout( function() {

					// Add the “opened” class to the picker root.
					P.$root.addClass( CLASSES.opened )
					aria( P.$root[0], 'hidden', false )

				}, 0 )

				// If we have to give focus, bind the element and doc events.
				if ( dontGiveFocus !== false ) {

					// Set it as open.
					STATE.open = true

					// Prevent the page from scrolling.
					if ( IS_DEFAULT_THEME ) {
						$html.
							css( 'overflow', 'hidden' ).
							css( 'padding-right', '+=' + getScrollbarWidth() )
					}

					// Pass focus to the root element’s jQuery object.
					// * Workaround for iOS8 to bring the picker’s root into view.
					P.$root.eq(0).focus()

					// Bind the document events.
					$document.on( 'click.' + STATE.id + ' focusin.' + STATE.id, function( event ) {

						var target = event.target

						// If the target of the event is not the element, close the picker picker.
						// * Don’t worry about clicks or focusins on the root because those don’t bubble up.
						// Also, for Firefox, a click on an `option` element bubbles up directly
						// to the doc. So make sure the target wasn't the doc.
						// * In Firefox stopPropagation() doesn’t prevent right-click events from bubbling,
						// which causes the picker to unexpectedly close when right-clicking it. So make
						// sure the event wasn’t a right-click.
						if ( target != ELEMENT && target != document && event.which != 3 ) {

							// If the target was the holder that covers the screen,
							// keep the element focused to maintain tabindex.
							P.close( target === P.$root.children()[0] )
						}

					}).on( 'keydown.' + STATE.id, function( event ) {

						var
							// Get the keycode.
							keycode = event.keyCode,

							// Translate that to a selection change.
							keycodeToMove = P.component.key[ keycode ],

							// Grab the target.
							target = event.target


						// On escape, close the picker and give focus.
						if ( keycode == 27 ) {
							P.close( true )
						}


						// Check if there is a key movement or “enter” keypress on the element.
						else if ( target == P.$root[0] && ( keycodeToMove || keycode == 13 ) ) {

							// Prevent the default action to stop page movement.
							event.preventDefault()

							// Trigger the key movement action.
							if ( keycodeToMove ) {
								PickerConstructor._.trigger( P.component.key.go, P, [ PickerConstructor._.trigger( keycodeToMove ) ] )
							}

							// On “enter”, if the highlighted item isn’t disabled, set the value and close.
							else if ( !P.$root.find( '.' + CLASSES.highlighted ).hasClass( CLASSES.disabled ) ) {
								P.set( 'select', P.component.item.highlight ).close()
							}
						}


						// If the target is within the root and “enter” is pressed,
						// prevent the default action and trigger a click on the target instead.
						else if ( $.contains( P.$root[0], target ) && keycode == 13 ) {
							event.preventDefault()
							target.click()
						}
					})
				}

				// Trigger the queued “open” events.
				return P.trigger( 'open' )
			}, //open


			/**
			 * Close the picker
			 */
			close: function( giveFocus ) {

				// If we need to give focus, do it before changing states.
				if ( giveFocus ) {
					// ....ah yes! It would’ve been incomplete without a crazy workaround for IE :|
					// The focus is triggered *after* the close has completed - causing it
					// to open again. So unbind and rebind the event at the next tick.
					P.$root.off( 'focus.toOpen' ).eq(0).focus()
					setTimeout( function() {
						P.$root.on( 'focus.toOpen', handleFocusToOpenEvent )
					}, 0 )
				}

				// Remove the “active” class.
				$ELEMENT.removeClass( CLASSES.active )
				aria( ELEMENT, 'expanded', false )

				// * A Firefox bug, when `html` has `overflow:hidden`, results in
				// killing transitions :(. So remove the “opened” state on the next tick.
				// Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=625289
				setTimeout( function() {

					// Remove the “opened” and “focused” class from the picker root.
					P.$root.removeClass( CLASSES.opened + ' ' + CLASSES.focused )
					aria( P.$root[0], 'hidden', true )

				}, 0 )

				// If it’s already closed, do nothing more.
				if ( !STATE.open ) return P

				// Set it as closed.
				STATE.open = false

				// Allow the page to scroll.
				if ( IS_DEFAULT_THEME ) {
					$html.
						css( 'overflow', '' ).
						css( 'padding-right', '-=' + getScrollbarWidth() )
				}

				// Unbind the document events.
				$document.off( '.' + STATE.id )

				// Trigger the queued “close” events.
				return P.trigger( 'close' )
			}, //close


			/**
			 * Clear the values
			 */
			clear: function( options ) {
				return P.set( 'clear', null, options )
			}, //clear


			/**
			 * Set something
			 */
			set: function( thing, value, options ) {

				var thingItem, thingValue,
					thingIsObject = $.isPlainObject( thing ),
					thingObject = thingIsObject ? thing : {}

				// Make sure we have usable options.
				options = thingIsObject && $.isPlainObject( value ) ? value : options || {}

				if ( thing ) {

					// If the thing isn’t an object, make it one.
					if ( !thingIsObject ) {
						thingObject[ thing ] = value
					}

					// Go through the things of items to set.
					for ( thingItem in thingObject ) {

						// Grab the value of the thing.
						thingValue = thingObject[ thingItem ]

						// First, if the item exists and there’s a value, set it.
						if ( thingItem in P.component.item ) {
							if ( thingValue === undefined ) thingValue = null
							P.component.set( thingItem, thingValue, options )
						}

						// Then, check to update the element value and broadcast a change.
						if ( thingItem == 'select' || thingItem == 'clear' ) {
							$ELEMENT.
								val( thingItem == 'clear' ? '' : P.get( thingItem, SETTINGS.format ) ).
								trigger( 'change' )
						}
					}

					// Render a new picker.
					P.render()
				}

				// When the method isn’t muted, trigger queued “set” events and pass the `thingObject`.
				return options.muted ? P : P.trigger( 'set', thingObject )
			}, //set


			/**
			 * Get something
			 */
			get: function( thing, format ) {

				// Make sure there’s something to get.
				thing = thing || 'value'

				// If a picker state exists, return that.
				if ( STATE[ thing ] != null ) {
					return STATE[ thing ]
				}

				// Return the submission value, if that.
				if ( thing == 'valueSubmit' ) {
					if ( P._hidden ) {
						return P._hidden.value
					}
					thing = 'value'
				}

				// Return the value, if that.
				if ( thing == 'value' ) {
					return ELEMENT.value
				}

				// Check if a component item exists, return that.
				if ( thing in P.component.item ) {
					if ( typeof format == 'string' ) {
						var thingValue = P.component.get( thing )
						return thingValue ?
							PickerConstructor._.trigger(
								P.component.formats.toString,
								P.component,
								[ format, thingValue ]
							) : ''
					}
					return P.component.get( thing )
				}
			}, //get



			/**
			 * Bind events on the things.
			 */
			on: function( thing, method, internal ) {

				var thingName, thingMethod,
					thingIsObject = $.isPlainObject( thing ),
					thingObject = thingIsObject ? thing : {}

				if ( thing ) {

					// If the thing isn’t an object, make it one.
					if ( !thingIsObject ) {
						thingObject[ thing ] = method
					}

					// Go through the things to bind to.
					for ( thingName in thingObject ) {

						// Grab the method of the thing.
						thingMethod = thingObject[ thingName ]

						// If it was an internal binding, prefix it.
						if ( internal ) {
							thingName = '_' + thingName
						}

						// Make sure the thing methods collection exists.
						STATE.methods[ thingName ] = STATE.methods[ thingName ] || []

						// Add the method to the relative method collection.
						STATE.methods[ thingName ].push( thingMethod )
					}
				}

				return P
			}, //on



			/**
			 * Unbind events on the things.
			 */
			off: function() {
				var i, thingName,
					names = arguments;
				for ( i = 0, namesCount = names.length; i < namesCount; i += 1 ) {
					thingName = names[i]
					if ( thingName in STATE.methods ) {
						delete STATE.methods[thingName]
					}
				}
				return P
			},


			/**
			 * Fire off method events.
			 */
			trigger: function( name, data ) {
				var _trigger = function( name ) {
					var methodList = STATE.methods[ name ]
					if ( methodList ) {
						methodList.map( function( method ) {
							PickerConstructor._.trigger( method, P, [ data ] )
						})
					}
				}
				_trigger( '_' + name )
				_trigger( name )
				return P
			} //trigger
		} //PickerInstance.prototype


	/**
	 * Wrap the picker holder components together.
	 */
	function createWrappedComponent() {

		// Create a picker wrapper holder
		return PickerConstructor._.node( 'div',

			// Create a picker wrapper node
			PickerConstructor._.node( 'div',

				// Create a picker frame
				PickerConstructor._.node( 'div',

					// Create a picker box node
					PickerConstructor._.node( 'div',

						// Create the components nodes.
						P.component.nodes( STATE.open ),

						// The picker box class
						CLASSES.box
					),

					// Picker wrap class
					CLASSES.wrap
				),

				// Picker frame class
				CLASSES.frame
			),

			// Picker holder class
			CLASSES.holder
		) //endreturn
	} //createWrappedComponent



	/**
	 * Prepare the input element with all bindings.
	 */
	function prepareElement() {

		$ELEMENT.

			// Store the picker data by component name.
			data(NAME, P).

			// Add the “input” class name.
			addClass(CLASSES.input).

			// Remove the tabindex.
			attr('tabindex', -1).

			// If there’s a `data-value`, update the value of the element.
			val( $ELEMENT.data('value') ?
				P.get('select', SETTINGS.format) :
				ELEMENT.value
			)


		// Only bind keydown events if the element isn’t editable.
		if ( !SETTINGS.editable ) {

			$ELEMENT.

				// On focus/click, focus onto the root to open it up.
				on( 'focus.' + STATE.id + ' click.' + STATE.id, function( event ) {
					event.preventDefault()
					P.$root.eq(0).focus()
				}).

				// Handle keyboard event based on the picker being opened or not.
				on( 'keydown.' + STATE.id, handleKeydownEvent )
		}


		// Update the aria attributes.
		aria(ELEMENT, {
			haspopup: true,
			expanded: false,
			readonly: false,
			owns: ELEMENT.id + '_root'
		})
	}


	/**
	 * Prepare the root picker element with all bindings.
	 */
	function prepareElementRoot() {

		P.$root.

			on({

				// For iOS8.
				keydown: handleKeydownEvent,

				// When something within the root is focused, stop from bubbling
				// to the doc and remove the “focused” state from the root.
				focusin: function( event ) {
					P.$root.removeClass( CLASSES.focused )
					event.stopPropagation()
				},

				// When something within the root holder is clicked, stop it
				// from bubbling to the doc.
				'mousedown click': function( event ) {

					var target = event.target

					// Make sure the target isn’t the root holder so it can bubble up.
					if ( target != P.$root.children()[ 0 ] ) {

						event.stopPropagation()

						// * For mousedown events, cancel the default action in order to
						// prevent cases where focus is shifted onto external elements
						// when using things like jQuery mobile or MagnificPopup (ref: #249 & #120).
						// Also, for Firefox, don’t prevent action on the `option` element.
						if ( event.type == 'mousedown' && !$( target ).is( 'input, select, textarea, button, option' )) {

							event.preventDefault()

							// Re-focus onto the root so that users can click away
							// from elements focused within the picker.
							P.$root.eq(0).focus()
						}
					}
				}
			}).

			// Add/remove the “target” class on focus and blur.
			on({
				focus: function() {
					$ELEMENT.addClass( CLASSES.target )
				},
				blur: function() {
					$ELEMENT.removeClass( CLASSES.target )
				}
			}).

			// Open the picker and adjust the root “focused” state
			on( 'focus.toOpen', handleFocusToOpenEvent ).

			// If there’s a click on an actionable element, carry out the actions.
			on( 'click', '[data-pick], [data-nav], [data-clear], [data-close]', function() {

				var $target = $( this ),
					targetData = $target.data(),
					targetDisabled = $target.hasClass( CLASSES.navDisabled ) || $target.hasClass( CLASSES.disabled ),

					// * For IE, non-focusable elements can be active elements as well
					// (http://stackoverflow.com/a/2684561).
					activeElement = getActiveElement()
					activeElement = activeElement && ( activeElement.type || activeElement.href )

				// If it’s disabled or nothing inside is actively focused, re-focus the element.
				if ( targetDisabled || activeElement && !$.contains( P.$root[0], activeElement ) ) {
					P.$root.eq(0).focus()
				}

				// If something is superficially changed, update the `highlight` based on the `nav`.
				if ( !targetDisabled && targetData.nav ) {
					P.set( 'highlight', P.component.item.highlight, { nav: targetData.nav } )
				}

				// If something is picked, set `select` then close with focus.
				else if ( !targetDisabled && 'pick' in targetData ) {
					P.set( 'select', targetData.pick )
				}

				// If a “clear” button is pressed, empty the values and close with focus.
				else if ( targetData.clear ) {
					P.clear().close( true )
				}

				else if ( targetData.close ) {
					P.close( true )
				}

			}) //P.$root

		aria( P.$root[0], 'hidden', true )
	}


	 /**
	* Prepare the hidden input element along with all bindings.
	*/
	function prepareElementHidden() {

		var name

		if ( SETTINGS.hiddenName === true ) {
			name = ELEMENT.name
			ELEMENT.name = ''
		}
		else {
			name = [
				typeof SETTINGS.hiddenPrefix == 'string' ? SETTINGS.hiddenPrefix : '',
				typeof SETTINGS.hiddenSuffix == 'string' ? SETTINGS.hiddenSuffix : '_submit'
			]
			name = name[0] + ELEMENT.name + name[1]
		}

		P._hidden = $(
			'<input ' +
			'type=hidden ' +

			// Create the name using the original input’s with a prefix and suffix.
			'name="' + name + '"' +

			// If the element has a value, set the hidden value as well.
			(
				$ELEMENT.data('value') || ELEMENT.value ?
					' value="' + P.get('select', SETTINGS.formatSubmit) + '"' :
					''
			) +
			'>'
		)[0]

		$ELEMENT.

			// If the value changes, update the hidden input with the correct format.
			on('change.' + STATE.id, function() {
				P._hidden.value = ELEMENT.value ?
					P.get('select', SETTINGS.formatSubmit) :
					''
			})


		// Insert the hidden input as specified in the settings.
		if ( SETTINGS.container ) $( SETTINGS.container ).append( P._hidden )
		else $ELEMENT.after( P._hidden )
	}


	// For iOS8.
	function handleKeydownEvent( event ) {

		var keycode = event.keyCode,

			// Check if one of the delete keys was pressed.
			isKeycodeDelete = /^(8|46)$/.test(keycode)

		// For some reason IE clears the input value on “escape”.
		if ( keycode == 27 ) {
			P.close()
			return false
		}

		// Check if `space` or `delete` was pressed or the picker is closed with a key movement.
		if ( keycode == 32 || isKeycodeDelete || !STATE.open && P.component.key[keycode] ) {

			// Prevent it from moving the page and bubbling to doc.
			event.preventDefault()
			event.stopPropagation()

			// If `delete` was pressed, clear the values and close the picker.
			// Otherwise open the picker.
			if ( isKeycodeDelete ) { P.clear().close() }
			else { P.open() }
		}
	}


	// Separated for IE
	function handleFocusToOpenEvent( event ) {

		// Stop the event from propagating to the doc.
		event.stopPropagation()

		// If it’s a focus event, add the “focused” class to the root.
		if ( event.type == 'focus' ) {
			P.$root.addClass( CLASSES.focused )
		}

		// And then finally open the picker.
		P.open()
	}


	// Return a new picker instance.
	return new PickerInstance()
} //PickerConstructor



/**
 * The default classes and prefix to use for the HTML classes.
 */
PickerConstructor.klasses = function( prefix ) {
	prefix = prefix || 'picker'
	return {

		picker: prefix,
		opened: prefix + '--opened',
		focused: prefix + '--focused',

		input: prefix + '__input',
		active: prefix + '__input--active',
		target: prefix + '__input--target',

		holder: prefix + '__holder',

		frame: prefix + '__frame',
		wrap: prefix + '__wrap',

		box: prefix + '__box'
	}
} //PickerConstructor.klasses



/**
 * Check if the default theme is being used.
 */
function isUsingDefaultTheme( element ) {

	var theme,
		prop = 'position'

	// For IE.
	if ( element.currentStyle ) {
		theme = element.currentStyle[prop]
	}

	// For normal browsers.
	else if ( window.getComputedStyle ) {
		theme = getComputedStyle( element )[prop]
	}

	return theme == 'fixed'
}



/**
 * Get the width of the browser’s scrollbar.
 * Taken from: https://github.com/VodkaBears/Remodal/blob/master/src/jquery.remodal.js
 */
function getScrollbarWidth() {

	if ( $html.height() <= $window.height() ) {
		return 0
	}

	var $outer = $( '<div style="visibility:hidden;width:100px" />' ).
		appendTo( 'body' )

	// Get the width without scrollbars.
	var widthWithoutScroll = $outer[0].offsetWidth

	// Force adding scrollbars.
	$outer.css( 'overflow', 'scroll' )

	// Add the inner div.
	var $inner = $( '<div style="width:100%" />' ).appendTo( $outer )

	// Get the width with scrollbars.
	var widthWithScroll = $inner[0].offsetWidth

	// Remove the divs.
	$outer.remove()

	// Return the difference between the widths.
	return widthWithoutScroll - widthWithScroll
}



/**
 * PickerConstructor helper methods.
 */
PickerConstructor._ = {

	/**
	 * Create a group of nodes. Expects:
	 * `
		{
			min:{Integer},
			max:{Integer},
			i:{Integer},
			node: {String},
			item: {Function}
		}
	 * `
	 */
	group: function( groupObject ) {

		var
			// Scope for the looped object
			loopObjectScope,

			// Create the nodes list
			nodesList = '',

			// The counter starts from the `min`
			counter = PickerConstructor._.trigger( groupObject.min, groupObject )


		// Loop from the `min` to `max`, incrementing by `i`
		for ( ; counter <= PickerConstructor._.trigger( groupObject.max, groupObject, [ counter ] ); counter += groupObject.i ) {

			// Trigger the `item` function within scope of the object
			loopObjectScope = PickerConstructor._.trigger( groupObject.item, groupObject, [ counter ] )

			// Splice the subgroup and create nodes out of the sub nodes
			nodesList += PickerConstructor._.node(
				groupObject.node,
				loopObjectScope[ 0 ], // the node
				loopObjectScope[ 1 ], // the classes
				loopObjectScope[ 2 ]// the attributes
			)
		}

		// Return the list of nodes
		return nodesList
	}, //group


	/**
	 * Create a dom node string
	 */
	node: function( wrapper, item, klass, attribute ) {

		// If the item is false-y, just return an empty string
		if ( !item ) return ''

		// If the item is an array, do a join
		item = $.isArray( item ) ? item.join( '' ) : item

		// Check for the class
		klass = klass ? ' class="' + klass + '"' : ''

		// Check for any attributes
		attribute = attribute ? ' ' + attribute : ''

		// Return the wrapped item
		return '<' + wrapper + klass + attribute + '>' + item + '</' + wrapper + '>'
	}, //node


	/**
	 * Lead numbers below 10 with a zero.
	 */
	lead: function( number ) {
		return ( number < 10 ? '0': '' ) + number
	},


	/**
	 * Trigger a function otherwise return the value.
	 */
	trigger: function( callback, scope, args ) {
		return typeof callback == 'function' ? callback.apply( scope, args || [] ) : callback
	},


	/**
	 * If the second character is a digit, length is 2 otherwise 1.
	 */
	digits: function( string ) {
		return ( /\d/ ).test( string[ 1 ] ) ? 2 : 1
	},


	/**
	 * Tell if something is a date object.
	 */
	isDate: function( value ) {
		return {}.toString.call( value ).indexOf( 'Date' ) > -1 && this.isInteger( value.getDate() )
	},


	/**
	 * Tell if something is an integer.
	 */
	isInteger: function( value ) {
		return {}.toString.call( value ).indexOf( 'Number' ) > -1 && value % 1 === 0
	},


	/**
	 * Create ARIA attribute strings.
	 */
	ariaAttr: ariaAttr
} //PickerConstructor._



/**
 * Extend the picker with a component and defaults.
 */
PickerConstructor.extend = function( name, Component ) {

	// Extend jQuery.
	$.fn[ name ] = function( options, action ) {

		// Grab the component data.
		var componentData = this.data( name )

		// If the picker is requested, return the data object.
		if ( options == 'picker' ) {
			return componentData
		}

		// If the component data exists and `options` is a string, carry out the action.
		if ( componentData && typeof options == 'string' ) {
			return PickerConstructor._.trigger( componentData[ options ], componentData, [ action ] )
		}

		// Otherwise go through each matched element and if the component
		// doesn’t exist, create a new picker using `this` element
		// and merging the defaults and options with a deep copy.
		return this.each( function() {
			var $this = $( this )
			if ( !$this.data( name ) ) {
				new PickerConstructor( this, name, Component, options )
			}
		})
	}

	// Set the defaults.
	$.fn[ name ].defaults = Component.defaults
} //PickerConstructor.extend



function aria(element, attribute, value) {
	if ( $.isPlainObject(attribute) ) {
		for ( var key in attribute ) {
			ariaSet(element, key, attribute[key])
		}
	}
	else {
		ariaSet(element, attribute, value)
	}
}
function ariaSet(element, attribute, value) {
	element.setAttribute(
		(attribute == 'role' ? '' : 'aria-') + attribute,
		value
	)
}
function ariaAttr(attribute, data) {
	if ( !$.isPlainObject(attribute) ) {
		attribute = { attribute: data }
	}
	data = ''
	for ( var key in attribute ) {
		var attr = (key == 'role' ? '' : 'aria-') + key,
			attrVal = attribute[key]
		data += attrVal == null ? '' : attr + '="' + attribute[key] + '"'
	}
	return data
}

// IE8 bug throws an error for activeElements within iframes.
function getActiveElement() {
	try {
		return document.activeElement
	} catch ( err ) { }
}



// Expose the picker constructor.
return PickerConstructor


}));


;/*!
 * Date picker for pickadate.js v3.5.0
 * http://amsul.github.io/pickadate.js/date.htm
 */

(function ( factory ) {

	// AMD.
	if ( typeof define == 'function' && define.amd )
		define( ['picker', 'jquery'], factory )

	// Node.js/browserify.
	else if ( typeof exports == 'object' )
		module.exports = factory( require('./picker.js'), require('jquery') )

	// Browser globals.
	else factory( Picker, jQuery )

}(function( Picker, $ ) {


/**
 * Globals and constants
 */
var DAYS_IN_WEEK = 7,
	WEEKS_IN_CALENDAR = 6,
	_ = Picker._



/**
 * The date picker constructor
 */
function DatePicker( picker, settings ) {

	var calendar = this,
		element = picker.$node[ 0 ],
		elementValue = element.value,
		elementDataValue = picker.$node.data( 'value' ),
		valueString = elementDataValue || elementValue,
		formatString = elementDataValue ? settings.formatSubmit : settings.format,
		isRTL = function() {

			return element.currentStyle ?

				// For IE.
				element.currentStyle.direction == 'rtl' :

				// For normal browsers.
				getComputedStyle( picker.$root[0] ).direction == 'rtl'
		}

	calendar.settings = settings
	calendar.$node = picker.$node

	// The queue of methods that will be used to build item objects.
	calendar.queue = {
		min: 'measure create',
		max: 'measure create',
		now: 'now create',
		select: 'parse create validate',
		highlight: 'parse navigate create validate',
		view: 'parse create validate viewset',
		disable: 'deactivate',
		enable: 'activate'
	}

	// The component's item object.
	calendar.item = {}

	calendar.item.clear = null
	calendar.item.disable = ( settings.disable || [] ).slice( 0 )
	calendar.item.enable = -(function( collectionDisabled ) {
		return collectionDisabled[ 0 ] === true ? collectionDisabled.shift() : -1
	})( calendar.item.disable )

	calendar.
		set( 'min', settings.min ).
		set( 'max', settings.max ).
		set( 'now' )

	// When there’s a value, set the `select`, which in turn
	// also sets the `highlight` and `view`.
	if ( valueString ) {
		calendar.set( 'select', valueString, { format: formatString })
	}

	// If there’s no value, default to highlighting “today”.
	else {
		calendar.
			set( 'select', null ).
			set( 'highlight', calendar.item.now )
	}


	// The keycode to movement mapping.
	calendar.key = {
		40: 7, // Down
		38: -7, // Up
		39: function() { return isRTL() ? -1 : 1 }, // Right
		37: function() { return isRTL() ? 1 : -1 }, // Left
		go: function( timeChange ) {
			var highlightedObject = calendar.item.highlight,
				targetDate = new Date( highlightedObject.year, highlightedObject.month, highlightedObject.date + timeChange )
			calendar.set(
				'highlight',
				targetDate,
				{ interval: timeChange }
			)
			this.render()
		}
	}


	// Bind some picker events.
	picker.
		on( 'render', function() {
			picker.$root.find( '.' + settings.klass.selectMonth ).on( 'change', function() {
				var value = this.value
				if ( value ) {
					picker.set( 'highlight', [ picker.get( 'view' ).year, value, picker.get( 'highlight' ).date ] )
					picker.$root.find( '.' + settings.klass.selectMonth ).trigger( 'focus' )
				}
			})
			picker.$root.find( '.' + settings.klass.selectYear ).on( 'change', function() {
				var value = this.value
				if ( value ) {
					picker.set( 'highlight', [ value, picker.get( 'view' ).month, picker.get( 'highlight' ).date ] )
					picker.$root.find( '.' + settings.klass.selectYear ).trigger( 'focus' )
				}
			})
		}, 1 ).
		on( 'open', function() {
			var includeToday = ''
			if ( calendar.disabled( calendar.get('now') ) ) {
				includeToday = ':not(.' + settings.klass.buttonToday + ')'
			}
			picker.$root.find( 'button' + includeToday + ', select' ).attr( 'disabled', false )
		}, 1 ).
		on( 'close', function() {
			picker.$root.find( 'button, select' ).attr( 'disabled', true )
		}, 1 )

} //DatePicker


/**
 * Set a datepicker item object.
 */
DatePicker.prototype.set = function( type, value, options ) {

	var calendar = this,
		calendarItem = calendar.item

	// If the value is `null` just set it immediately.
	if ( value === null ) {
		if ( type == 'clear' ) type = 'select'
		calendarItem[ type ] = value
		return calendar
	}

	// Otherwise go through the queue of methods, and invoke the functions.
	// Update this as the time unit, and set the final value as this item.
	// * In the case of `enable`, keep the queue but set `disable` instead.
	// And in the case of `flip`, keep the queue but set `enable` instead.
	calendarItem[ ( type == 'enable' ? 'disable' : type == 'flip' ? 'enable' : type ) ] = calendar.queue[ type ].split( ' ' ).map( function( method ) {
		value = calendar[ method ]( type, value, options )
		return value
	}).pop()

	// Check if we need to cascade through more updates.
	if ( type == 'select' ) {
		calendar.set( 'highlight', calendarItem.select, options )
	}
	else if ( type == 'highlight' ) {
		calendar.set( 'view', calendarItem.highlight, options )
	}
	else if ( type.match( /^(flip|min|max|disable|enable)$/ ) ) {
		if ( calendarItem.select && calendar.disabled( calendarItem.select ) ) {
			calendar.set( 'select', calendarItem.select, options )
		}
		if ( calendarItem.highlight && calendar.disabled( calendarItem.highlight ) ) {
			calendar.set( 'highlight', calendarItem.highlight, options )
		}
	}

	return calendar
} //DatePicker.prototype.set


/**
 * Get a datepicker item object.
 */
DatePicker.prototype.get = function( type ) {
	return this.item[ type ]
} //DatePicker.prototype.get


/**
 * Create a picker date object.
 */
DatePicker.prototype.create = function( type, value, options ) {

	var isInfiniteValue,
		calendar = this

	// If there’s no value, use the type as the value.
	value = value === undefined ? type : value


	// If it’s infinity, update the value.
	if ( value == -Infinity || value == Infinity ) {
		isInfiniteValue = value
	}

	// If it’s an object, use the native date object.
	else if ( $.isPlainObject( value ) && _.isInteger( value.pick ) ) {
		value = value.obj
	}

	// If it’s an array, convert it into a date and make sure
	// that it’s a valid date – otherwise default to today.
	else if ( $.isArray( value ) ) {
		value = new Date( value[ 0 ], value[ 1 ], value[ 2 ] )
		value = _.isDate( value ) ? value : calendar.create().obj
	}

	// If it’s a number or date object, make a normalized date.
	else if ( _.isInteger( value ) || _.isDate( value ) ) {
		value = calendar.normalize( new Date( value ), options )
	}

	// If it’s a literal true or any other case, set it to now.
	else /*if ( value === true )*/ {
		value = calendar.now( type, value, options )
	}

	// Return the compiled object.
	return {
		year: isInfiniteValue || value.getFullYear(),
		month: isInfiniteValue || value.getMonth(),
		date: isInfiniteValue || value.getDate(),
		day: isInfiniteValue || value.getDay(),
		obj: isInfiniteValue || value,
		pick: isInfiniteValue || value.getTime()
	}
} //DatePicker.prototype.create


/**
 * Create a range limit object using an array, date object,
 * literal “true”, or integer relative to another time.
 */
DatePicker.prototype.createRange = function( from, to ) {

	var calendar = this,
		createDate = function( date ) {
			if ( date === true || $.isArray( date ) || _.isDate( date ) ) {
				return calendar.create( date )
			}
			return date
		}

	// Create objects if possible.
	if ( !_.isInteger( from ) ) {
		from = createDate( from )
	}
	if ( !_.isInteger( to ) ) {
		to = createDate( to )
	}

	// Create relative dates.
	if ( _.isInteger( from ) && $.isPlainObject( to ) ) {
		from = [ to.year, to.month, to.date + from ];
	}
	else if ( _.isInteger( to ) && $.isPlainObject( from ) ) {
		to = [ from.year, from.month, from.date + to ];
	}

	return {
		from: createDate( from ),
		to: createDate( to )
	}
} //DatePicker.prototype.createRange


/**
 * Check if a date unit falls within a date range object.
 */
DatePicker.prototype.withinRange = function( range, dateUnit ) {
	range = this.createRange(range.from, range.to)
	return dateUnit.pick >= range.from.pick && dateUnit.pick <= range.to.pick
}


/**
 * Check if two date range objects overlap.
 */
DatePicker.prototype.overlapRanges = function( one, two ) {

	var calendar = this

	// Convert the ranges into comparable dates.
	one = calendar.createRange( one.from, one.to )
	two = calendar.createRange( two.from, two.to )

	return calendar.withinRange( one, two.from ) || calendar.withinRange( one, two.to ) ||
		calendar.withinRange( two, one.from ) || calendar.withinRange( two, one.to )
}


/**
 * Get the date today.
 */
DatePicker.prototype.now = function( type, value, options ) {
	value = new Date()
	if ( options && options.rel ) {
		value.setDate( value.getDate() + options.rel )
	}
	return this.normalize( value, options )
}


/**
 * Navigate to next/prev month.
 */
DatePicker.prototype.navigate = function( type, value, options ) {

	var targetDateObject,
		targetYear,
		targetMonth,
		targetDate,
		isTargetArray = $.isArray( value ),
		isTargetObject = $.isPlainObject( value ),
		viewsetObject = this.item.view/*,
		safety = 100*/


	if ( isTargetArray || isTargetObject ) {

		if ( isTargetObject ) {
			targetYear = value.year
			targetMonth = value.month
			targetDate = value.date
		}
		else {
			targetYear = +value[0]
			targetMonth = +value[1]
			targetDate = +value[2]
		}

		// If we’re navigating months but the view is in a different
		// month, navigate to the view’s year and month.
		if ( options && options.nav && viewsetObject && viewsetObject.month !== targetMonth ) {
			targetYear = viewsetObject.year
			targetMonth = viewsetObject.month
		}

		// Figure out the expected target year and month.
		targetDateObject = new Date( targetYear, targetMonth + ( options && options.nav ? options.nav : 0 ), 1 )
		targetYear = targetDateObject.getFullYear()
		targetMonth = targetDateObject.getMonth()

		// If the month we’re going to doesn’t have enough days,
		// keep decreasing the date until we reach the month’s last date.
		while ( /*safety &&*/ new Date( targetYear, targetMonth, targetDate ).getMonth() !== targetMonth ) {
			targetDate -= 1
			/*safety -= 1
			if ( !safety ) {
				throw 'Fell into an infinite loop while navigating to ' + new Date( targetYear, targetMonth, targetDate ) + '.'
			}*/
		}

		value = [ targetYear, targetMonth, targetDate ]
	}

	return value
} //DatePicker.prototype.navigate


/**
 * Normalize a date by setting the hours to midnight.
 */
DatePicker.prototype.normalize = function( value/*, options*/ ) {
	value.setHours( 0, 0, 0, 0 )
	return value
}


/**
 * Measure the range of dates.
 */
DatePicker.prototype.measure = function( type, value/*, options*/ ) {

	var calendar = this

	// If it’s anything false-y, remove the limits.
	if ( !value ) {
		value = type == 'min' ? -Infinity : Infinity
	}

	// If it’s a string, parse it.
	else if ( typeof value == 'string' ) {
		value = calendar.parse( type, value )
	}

	// If it's an integer, get a date relative to today.
	else if ( _.isInteger( value ) ) {
		value = calendar.now( type, value, { rel: value } )
	}

	return value
} ///DatePicker.prototype.measure


/**
 * Create a viewset object based on navigation.
 */
DatePicker.prototype.viewset = function( type, dateObject/*, options*/ ) {
	return this.create([ dateObject.year, dateObject.month, 1 ])
}


/**
 * Validate a date as enabled and shift if needed.
 */
DatePicker.prototype.validate = function( type, dateObject, options ) {

	var calendar = this,

		// Keep a reference to the original date.
		originalDateObject = dateObject,

		// Make sure we have an interval.
		interval = options && options.interval ? options.interval : 1,

		// Check if the calendar enabled dates are inverted.
		isFlippedBase = calendar.item.enable === -1,

		// Check if we have any enabled dates after/before now.
		hasEnabledBeforeTarget, hasEnabledAfterTarget,

		// The min & max limits.
		minLimitObject = calendar.item.min,
		maxLimitObject = calendar.item.max,

		// Check if we’ve reached the limit during shifting.
		reachedMin, reachedMax,

		// Check if the calendar is inverted and at least one weekday is enabled.
		hasEnabledWeekdays = isFlippedBase && calendar.item.disable.filter( function( value ) {

			// If there’s a date, check where it is relative to the target.
			if ( $.isArray( value ) ) {
				var dateTime = calendar.create( value ).pick
				if ( dateTime < dateObject.pick ) hasEnabledBeforeTarget = true
				else if ( dateTime > dateObject.pick ) hasEnabledAfterTarget = true
			}

			// Return only integers for enabled weekdays.
			return _.isInteger( value )
		}).length/*,

		safety = 100*/



	// Cases to validate for:
	// [1] Not inverted and date disabled.
	// [2] Inverted and some dates enabled.
	// [3] Not inverted and out of range.
	//
	// Cases to **not** validate for:
	// • Navigating months.
	// • Not inverted and date enabled.
	// • Inverted and all dates disabled.
	// • ..and anything else.
	if ( !options || !options.nav ) if (
		/* 1 */ ( !isFlippedBase && calendar.disabled( dateObject ) ) ||
		/* 2 */ ( isFlippedBase && calendar.disabled( dateObject ) && ( hasEnabledWeekdays || hasEnabledBeforeTarget || hasEnabledAfterTarget ) ) ||
		/* 3 */ ( !isFlippedBase && (dateObject.pick <= minLimitObject.pick || dateObject.pick >= maxLimitObject.pick) )
	) {


		// When inverted, flip the direction if there aren’t any enabled weekdays
		// and there are no enabled dates in the direction of the interval.
		if ( isFlippedBase && !hasEnabledWeekdays && ( ( !hasEnabledAfterTarget && interval > 0 ) || ( !hasEnabledBeforeTarget && interval < 0 ) ) ) {
			interval *= -1
		}


		// Keep looping until we reach an enabled date.
		while ( /*safety &&*/ calendar.disabled( dateObject ) ) {

			/*safety -= 1
			if ( !safety ) {
				throw 'Fell into an infinite loop while validating ' + dateObject.obj + '.'
			}*/


			// If we’ve looped into the next/prev month with a large interval, return to the original date and flatten the interval.
			if ( Math.abs( interval ) > 1 && ( dateObject.month < originalDateObject.month || dateObject.month > originalDateObject.month ) ) {
				dateObject = originalDateObject
				interval = interval > 0 ? 1 : -1
			}


			// If we’ve reached the min/max limit, reverse the direction, flatten the interval and set it to the limit.
			if ( dateObject.pick <= minLimitObject.pick ) {
				reachedMin = true
				interval = 1
				dateObject = calendar.create([
					minLimitObject.year,
					minLimitObject.month,
					minLimitObject.date + (dateObject.pick === minLimitObject.pick ? 0 : -1)
				])
			}
			else if ( dateObject.pick >= maxLimitObject.pick ) {
				reachedMax = true
				interval = -1
				dateObject = calendar.create([
					maxLimitObject.year,
					maxLimitObject.month,
					maxLimitObject.date + (dateObject.pick === maxLimitObject.pick ? 0 : 1)
				])
			}


			// If we’ve reached both limits, just break out of the loop.
			if ( reachedMin && reachedMax ) {
				break
			}


			// Finally, create the shifted date using the interval and keep looping.
			dateObject = calendar.create([ dateObject.year, dateObject.month, dateObject.date + interval ])
		}

	} //endif


	// Return the date object settled on.
	return dateObject
} //DatePicker.prototype.validate


/**
 * Check if a date is disabled.
 */
DatePicker.prototype.disabled = function( dateToVerify ) {

	var
		calendar = this,

		// Filter through the disabled dates to check if this is one.
		isDisabledMatch = calendar.item.disable.filter( function( dateToDisable ) {

			// If the date is a number, match the weekday with 0index and `firstDay` check.
			if ( _.isInteger( dateToDisable ) ) {
				return dateToVerify.day === ( calendar.settings.firstDay ? dateToDisable : dateToDisable - 1 ) % 7
			}

			// If it’s an array or a native JS date, create and match the exact date.
			if ( $.isArray( dateToDisable ) || _.isDate( dateToDisable ) ) {
				return dateToVerify.pick === calendar.create( dateToDisable ).pick
			}

			// If it’s an object, match a date within the “from” and “to” range.
			if ( $.isPlainObject( dateToDisable ) ) {
				return calendar.withinRange( dateToDisable, dateToVerify )
			}
		})

	// If this date matches a disabled date, confirm it’s not inverted.
	isDisabledMatch = isDisabledMatch.length && !isDisabledMatch.filter(function( dateToDisable ) {
		return $.isArray( dateToDisable ) && dateToDisable[3] == 'inverted' ||
			$.isPlainObject( dateToDisable ) && dateToDisable.inverted
	}).length

	// Check the calendar “enabled” flag and respectively flip the
	// disabled state. Then also check if it’s beyond the min/max limits.
	return calendar.item.enable === -1 ? !isDisabledMatch : isDisabledMatch ||
		dateToVerify.pick < calendar.item.min.pick ||
		dateToVerify.pick > calendar.item.max.pick

} //DatePicker.prototype.disabled


/**
 * Parse a string into a usable type.
 */
DatePicker.prototype.parse = function( type, value, options ) {

	var calendar = this,
		parsingObject = {}

	// If it’s already parsed, we’re good.
	if ( !value || typeof value != 'string' ) {
		return value
	}

	// We need a `.format` to parse the value with.
	if ( !( options && options.format ) ) {
		options = options || {}
		options.format = calendar.settings.format
	}

	// Convert the format into an array and then map through it.
	calendar.formats.toArray( options.format ).map( function( label ) {

		var
			// Grab the formatting label.
			formattingLabel = calendar.formats[ label ],

			// The format length is from the formatting label function or the
			// label length without the escaping exclamation (!) mark.
			formatLength = formattingLabel ? _.trigger( formattingLabel, calendar, [ value, parsingObject ] ) : label.replace( /^!/, '' ).length

		// If there's a format label, split the value up to the format length.
		// Then add it to the parsing object with appropriate label.
		if ( formattingLabel ) {
			parsingObject[ label ] = value.substr( 0, formatLength )
		}

		// Update the value as the substring from format length to end.
		value = value.substr( formatLength )
	})

	// Compensate for month 0index.
	return [
		parsingObject.yyyy || parsingObject.yy,
		+( parsingObject.mm || parsingObject.m ) - 1,
		parsingObject.dd || parsingObject.d
	]
} //DatePicker.prototype.parse


/**
 * Various formats to display the object in.
 */
DatePicker.prototype.formats = (function() {

	// Return the length of the first word in a collection.
	function getWordLengthFromCollection( string, collection, dateObject ) {

		// Grab the first word from the string.
		var word = string.match( /\w+/ )[ 0 ]

		// If there's no month index, add it to the date object
		if ( !dateObject.mm && !dateObject.m ) {
			dateObject.m = collection.indexOf( word ) + 1
		}

		// Return the length of the word.
		return word.length
	}

	// Get the length of the first word in a string.
	function getFirstWordLength( string ) {
		return string.match( /\w+/ )[ 0 ].length
	}

	return {

		d: function( string, dateObject ) {

			// If there's string, then get the digits length.
			// Otherwise return the selected date.
			return string ? _.digits( string ) : dateObject.date
		},
		dd: function( string, dateObject ) {

			// If there's a string, then the length is always 2.
			// Otherwise return the selected date with a leading zero.
			return string ? 2 : _.lead( dateObject.date )
		},
		ddd: function( string, dateObject ) {

			// If there's a string, then get the length of the first word.
			// Otherwise return the short selected weekday.
			return string ? getFirstWordLength( string ) : this.settings.weekdaysShort[ dateObject.day ]
		},
		dddd: function( string, dateObject ) {

			// If there's a string, then get the length of the first word.
			// Otherwise return the full selected weekday.
			return string ? getFirstWordLength( string ) : this.settings.weekdaysFull[ dateObject.day ]
		},
		m: function( string, dateObject ) {

			// If there's a string, then get the length of the digits
			// Otherwise return the selected month with 0index compensation.
			return string ? _.digits( string ) : dateObject.month + 1
		},
		mm: function( string, dateObject ) {

			// If there's a string, then the length is always 2.
			// Otherwise return the selected month with 0index and leading zero.
			return string ? 2 : _.lead( dateObject.month + 1 )
		},
		mmm: function( string, dateObject ) {

			var collection = this.settings.monthsShort

			// If there's a string, get length of the relevant month from the short
			// months collection. Otherwise return the selected month from that collection.
			return string ? getWordLengthFromCollection( string, collection, dateObject ) : collection[ dateObject.month ]
		},
		mmmm: function( string, dateObject ) {

			var collection = this.settings.monthsFull

			// If there's a string, get length of the relevant month from the full
			// months collection. Otherwise return the selected month from that collection.
			return string ? getWordLengthFromCollection( string, collection, dateObject ) : collection[ dateObject.month ]
		},
		yy: function( string, dateObject ) {

			// If there's a string, then the length is always 2.
			// Otherwise return the selected year by slicing out the first 2 digits.
			return string ? 2 : ( '' + dateObject.year ).slice( 2 )
		},
		yyyy: function( string, dateObject ) {

			// If there's a string, then the length is always 4.
			// Otherwise return the selected year.
			return string ? 4 : dateObject.year
		},

		// Create an array by splitting the formatting string passed.
		toArray: function( formatString ) { return formatString.split( /(d{1,4}|m{1,4}|y{4}|yy|!.)/g ) },

		// Format an object into a string using the formatting options.
		toString: function ( formatString, itemObject ) {
			var calendar = this
			return calendar.formats.toArray( formatString ).map( function( label ) {
				return _.trigger( calendar.formats[ label ], calendar, [ 0, itemObject ] ) || label.replace( /^!/, '' )
			}).join( '' )
		}
	}
})() //DatePicker.prototype.formats




/**
 * Check if two date units are the exact.
 */
DatePicker.prototype.isDateExact = function( one, two ) {

	var calendar = this

	// When we’re working with weekdays, do a direct comparison.
	if (
		( _.isInteger( one ) && _.isInteger( two ) ) ||
		( typeof one == 'boolean' && typeof two == 'boolean' )
	 ) {
		return one === two
	}

	// When we’re working with date representations, compare the “pick” value.
	if (
		( _.isDate( one ) || $.isArray( one ) ) &&
		( _.isDate( two ) || $.isArray( two ) )
	) {
		return calendar.create( one ).pick === calendar.create( two ).pick
	}

	// When we’re working with range objects, compare the “from” and “to”.
	if ( $.isPlainObject( one ) && $.isPlainObject( two ) ) {
		return calendar.isDateExact( one.from, two.from ) && calendar.isDateExact( one.to, two.to )
	}

	return false
}


/**
 * Check if two date units overlap.
 */
DatePicker.prototype.isDateOverlap = function( one, two ) {

	var calendar = this,
		firstDay = calendar.settings.firstDay ? 1 : 0

	// When we’re working with a weekday index, compare the days.
	if ( _.isInteger( one ) && ( _.isDate( two ) || $.isArray( two ) ) ) {
		one = one % 7 + firstDay
		return one === calendar.create( two ).day + 1
	}
	if ( _.isInteger( two ) && ( _.isDate( one ) || $.isArray( one ) ) ) {
		two = two % 7 + firstDay
		return two === calendar.create( one ).day + 1
	}

	// When we’re working with range objects, check if the ranges overlap.
	if ( $.isPlainObject( one ) && $.isPlainObject( two ) ) {
		return calendar.overlapRanges( one, two )
	}

	return false
}


/**
 * Flip the “enabled” state.
 */
DatePicker.prototype.flipEnable = function(val) {
	var itemObject = this.item
	itemObject.enable = val || (itemObject.enable == -1 ? 1 : -1)
}


/**
 * Mark a collection of dates as “disabled”.
 */
DatePicker.prototype.deactivate = function( type, datesToDisable ) {

	var calendar = this,
		disabledItems = calendar.item.disable.slice(0)


	// If we’re flipping, that’s all we need to do.
	if ( datesToDisable == 'flip' ) {
		calendar.flipEnable()
	}

	else if ( datesToDisable === false ) {
		calendar.flipEnable(1)
		disabledItems = []
	}

	else if ( datesToDisable === true ) {
		calendar.flipEnable(-1)
		disabledItems = []
	}

	// Otherwise go through the dates to disable.
	else {

		datesToDisable.map(function( unitToDisable ) {

			var matchFound

			// When we have disabled items, check for matches.
			// If something is matched, immediately break out.
			for ( var index = 0; index < disabledItems.length; index += 1 ) {
				if ( calendar.isDateExact( unitToDisable, disabledItems[index] ) ) {
					matchFound = true
					break
				}
			}

			// If nothing was found, add the validated unit to the collection.
			if ( !matchFound ) {
				if (
					_.isInteger( unitToDisable ) ||
					_.isDate( unitToDisable ) ||
					$.isArray( unitToDisable ) ||
					( $.isPlainObject( unitToDisable ) && unitToDisable.from && unitToDisable.to )
				) {
					disabledItems.push( unitToDisable )
				}
			}
		})
	}

	// Return the updated collection.
	return disabledItems
} //DatePicker.prototype.deactivate


/**
 * Mark a collection of dates as “enabled”.
 */
DatePicker.prototype.activate = function( type, datesToEnable ) {

	var calendar = this,
		disabledItems = calendar.item.disable,
		disabledItemsCount = disabledItems.length

	// If we’re flipping, that’s all we need to do.
	if ( datesToEnable == 'flip' ) {
		calendar.flipEnable()
	}

	else if ( datesToEnable === true ) {
		calendar.flipEnable(1)
		disabledItems = []
	}

	else if ( datesToEnable === false ) {
		calendar.flipEnable(-1)
		disabledItems = []
	}

	// Otherwise go through the disabled dates.
	else {

		datesToEnable.map(function( unitToEnable ) {

			var matchFound,
				disabledUnit,
				index,
				isExactRange

			// Go through the disabled items and try to find a match.
			for ( index = 0; index < disabledItemsCount; index += 1 ) {

				disabledUnit = disabledItems[index]

				// When an exact match is found, remove it from the collection.
				if ( calendar.isDateExact( disabledUnit, unitToEnable ) ) {
					matchFound = disabledItems[index] = null
					isExactRange = true
					break
				}

				// When an overlapped match is found, add the “inverted” state to it.
				else if ( calendar.isDateOverlap( disabledUnit, unitToEnable ) ) {
					if ( $.isPlainObject( unitToEnable ) ) {
						unitToEnable.inverted = true
						matchFound = unitToEnable
					}
					else if ( $.isArray( unitToEnable ) ) {
						matchFound = unitToEnable
						if ( !matchFound[3] ) matchFound.push( 'inverted' )
					}
					else if ( _.isDate( unitToEnable ) ) {
						matchFound = [ unitToEnable.getFullYear(), unitToEnable.getMonth(), unitToEnable.getDate(), 'inverted' ]
					}
					break
				}
			}

			// If a match was found, remove a previous duplicate entry.
			if ( matchFound ) for ( index = 0; index < disabledItemsCount; index += 1 ) {
				if ( calendar.isDateExact( disabledItems[index], unitToEnable ) ) {
					disabledItems[index] = null
					break
				}
			}

			// In the event that we’re dealing with an exact range of dates,
			// make sure there are no “inverted” dates because of it.
			if ( isExactRange ) for ( index = 0; index < disabledItemsCount; index += 1 ) {
				if ( calendar.isDateOverlap( disabledItems[index], unitToEnable ) ) {
					disabledItems[index] = null
					break
				}
			}

			// If something is still matched, add it into the collection.
			if ( matchFound ) {
				disabledItems.push( matchFound )
			}
		})
	}

	// Return the updated collection.
	return disabledItems.filter(function( val ) { return val != null })
} //DatePicker.prototype.activate


/**
 * Create a string for the nodes in the picker.
 */
DatePicker.prototype.nodes = function( isOpen ) {

	var
		calendar = this,
		settings = calendar.settings,
		calendarItem = calendar.item,
		nowObject = calendarItem.now,
		selectedObject = calendarItem.select,
		highlightedObject = calendarItem.highlight,
		viewsetObject = calendarItem.view,
		disabledCollection = calendarItem.disable,
		minLimitObject = calendarItem.min,
		maxLimitObject = calendarItem.max,


		// Create the calendar table head using a copy of weekday labels collection.
		// * We do a copy so we don't mutate the original array.
		tableHead = (function( collection, fullCollection ) {

			// If the first day should be Monday, move Sunday to the end.
			if ( settings.firstDay ) {
				collection.push( collection.shift() )
				fullCollection.push( fullCollection.shift() )
			}

			// Create and return the table head group.
			return _.node(
				'thead',
				_.node(
					'tr',
					_.group({
						min: 0,
						max: DAYS_IN_WEEK - 1,
						i: 1,
						node: 'th',
						item: function( counter ) {
							return [
								collection[ counter ],
								settings.klass.weekdays,
								'scope=col title="' + fullCollection[ counter ] + '"'
							]
						}
					})
				)
			) //endreturn

		// Materialize modified
		})( ( settings.showWeekdaysFull ? settings.weekdaysFull : settings.weekdaysLetter ).slice( 0 ), settings.weekdaysFull.slice( 0 ) ), //tableHead


		// Create the nav for next/prev month.
		createMonthNav = function( next ) {

			// Otherwise, return the created month tag.
			return _.node(
				'div',
				' ',
				settings.klass[ 'nav' + ( next ? 'Next' : 'Prev' ) ] + (

					// If the focused month is outside the range, disabled the button.
					( next && viewsetObject.year >= maxLimitObject.year && viewsetObject.month >= maxLimitObject.month ) ||
					( !next && viewsetObject.year <= minLimitObject.year && viewsetObject.month <= minLimitObject.month ) ?
					' ' + settings.klass.navDisabled : ''
				),
				'data-nav=' + ( next || -1 ) + ' ' +
				_.ariaAttr({
					role: 'button',
					controls: calendar.$node[0].id + '_table'
				}) + ' ' +
				'title="' + (next ? settings.labelMonthNext : settings.labelMonthPrev ) + '"'
			) //endreturn
		}, //createMonthNav


		// Create the month label.
		//Materialize modified
		createMonthLabel = function(override) {

			var monthsCollection = settings.showMonthsShort ? settings.monthsShort : settings.monthsFull

			 // Materialize modified
			if (override == "short_months") {
			monthsCollection = settings.monthsShort;
			}

			// If there are months to select, add a dropdown menu.
			if ( settings.selectMonths&& override == undefined) {

				return _.node( 'select',
					_.group({
						min: 0,
						max: 11,
						i: 1,
						node: 'option',
						item: function( loopedMonth ) {

							return [

								// The looped month and no classes.
								monthsCollection[ loopedMonth ], 0,

								// Set the value and selected index.
								'value=' + loopedMonth +
								( viewsetObject.month == loopedMonth ? ' selected' : '' ) +
								(
									(
										( viewsetObject.year == minLimitObject.year && loopedMonth < minLimitObject.month ) ||
										( viewsetObject.year == maxLimitObject.year && loopedMonth > maxLimitObject.month )
									) ?
									' disabled' : ''
								)
							]
						}
					}),
					settings.klass.selectMonth + ' browser-default',
					( isOpen ? '' : 'disabled' ) + ' ' +
					_.ariaAttr({ controls: calendar.$node[0].id + '_table' }) + ' ' +
					'title="' + settings.labelMonthSelect + '"'
				)
			}

			// Materialize modified
			if (override == "short_months")
				if (selectedObject != null)
				return _.node( 'div', monthsCollection[ selectedObject.month ] );
				else return _.node( 'div', monthsCollection[ viewsetObject.month ] );

			// If there's a need for a month selector
			return _.node( 'div', monthsCollection[ viewsetObject.month ], settings.klass.month )
		}, //createMonthLabel


		// Create the year label.
		// Materialize modified
		createYearLabel = function(override) {

			var focusedYear = viewsetObject.year,

			// If years selector is set to a literal "true", set it to 5. Otherwise
			// divide in half to get half before and half after focused year.
			numberYears = settings.selectYears === true ? 5 : ~~( settings.selectYears / 2 )

			// If there are years to select, add a dropdown menu.
			if ( numberYears ) {

				var
					minYear = minLimitObject.year,
					maxYear = maxLimitObject.year,
					lowestYear = focusedYear - numberYears,
					highestYear = focusedYear + numberYears

				// If the min year is greater than the lowest year, increase the highest year
				// by the difference and set the lowest year to the min year.
				if ( minYear > lowestYear ) {
					highestYear += minYear - lowestYear
					lowestYear = minYear
				}

				// If the max year is less than the highest year, decrease the lowest year
				// by the lower of the two: available and needed years. Then set the
				// highest year to the max year.
				if ( maxYear < highestYear ) {

					var availableYears = lowestYear - minYear,
						neededYears = highestYear - maxYear

					lowestYear -= availableYears > neededYears ? neededYears : availableYears
					highestYear = maxYear
				}

				if ( settings.selectYears&& override == undefined ) {
					return _.node( 'select',
						_.group({
							min: lowestYear,
							max: highestYear,
							i: 1,
							node: 'option',
							item: function( loopedYear ) {
								return [

									// The looped year and no classes.
									loopedYear, 0,

									// Set the value and selected index.
									'value=' + loopedYear + ( focusedYear == loopedYear ? ' selected' : '' )
								]
							}
						}),
						settings.klass.selectYear + ' browser-default',
						( isOpen ? '' : 'disabled' ) + ' ' + _.ariaAttr({ controls: calendar.$node[0].id + '_table' }) + ' ' +
						'title="' + settings.labelYearSelect + '"'
					)
				}
			}

			// Materialize modified
			if (override == "raw")
				return _.node( 'div', focusedYear )

			// Otherwise just return the year focused
			return _.node( 'div', focusedYear, settings.klass.year )
		} //createYearLabel


		// Materialize modified
		createDayLabel = function() {
				if (selectedObject != null)
					return _.node( 'div', selectedObject.date)
				else return _.node( 'div', nowObject.date)
			}
		createWeekdayLabel = function() {
			var display_day;

			if (selectedObject != null)
				display_day = selectedObject.day;
			else
				display_day = nowObject.day;
			var weekday = settings.weekdaysFull[ display_day ]
			return weekday
		}


	// Create and return the entire calendar.
return _.node(
		// Date presentation View
		'div',
			_.node(
				'div',
				createWeekdayLabel(),
				"picker__weekday-display"
			)+
			_.node(
				// Div for short Month
				'div',
				createMonthLabel("short_months"),
				settings.klass.month_display
			)+
			_.node(
				// Div for Day
				'div',
				createDayLabel() ,
				settings.klass.day_display
			)+
			_.node(
				// Div for Year
				'div',
				createYearLabel("raw") ,
				settings.klass.year_display
			),
		settings.klass.date_display
	)+
	// Calendar container
	_.node('div',
		_.node('div',
		( settings.selectYears ?createMonthLabel() + createYearLabel() : createMonthLabel() + createYearLabel() ) +
		createMonthNav() + createMonthNav( 1 ),
		settings.klass.header
	) + _.node(
		'table',
		tableHead +
		_.node(
			'tbody',
			_.group({
				min: 0,
				max: WEEKS_IN_CALENDAR - 1,
				i: 1,
				node: 'tr',
				item: function( rowCounter ) {

					// If Monday is the first day and the month starts on Sunday, shift the date back a week.
					var shiftDateBy = settings.firstDay && calendar.create([ viewsetObject.year, viewsetObject.month, 1 ]).day === 0 ? -7 : 0

					return [
						_.group({
							min: DAYS_IN_WEEK * rowCounter - viewsetObject.day + shiftDateBy + 1, // Add 1 for weekday 0index
							max: function() {
								return this.min + DAYS_IN_WEEK - 1
							},
							i: 1,
							node: 'td',
							item: function( targetDate ) {

								// Convert the time date from a relative date to a target date.
								targetDate = calendar.create([ viewsetObject.year, viewsetObject.month, targetDate + ( settings.firstDay ? 1 : 0 ) ])

								var isSelected = selectedObject && selectedObject.pick == targetDate.pick,
									isHighlighted = highlightedObject && highlightedObject.pick == targetDate.pick,
									isDisabled = disabledCollection && calendar.disabled( targetDate ) || targetDate.pick < minLimitObject.pick || targetDate.pick > maxLimitObject.pick,
									formattedDate = _.trigger( calendar.formats.toString, calendar, [ settings.format, targetDate ] )

								return [
									_.node(
										'div',
										targetDate.date,
										(function( klasses ) {

											// Add the `infocus` or `outfocus` classes based on month in view.
											klasses.push( viewsetObject.month == targetDate.month ? settings.klass.infocus : settings.klass.outfocus )

											// Add the `today` class if needed.
											if ( nowObject.pick == targetDate.pick ) {
												klasses.push( settings.klass.now )
											}

											// Add the `selected` class if something's selected and the time matches.
											if ( isSelected ) {
												klasses.push( settings.klass.selected )
											}

											// Add the `highlighted` class if something's highlighted and the time matches.
											if ( isHighlighted ) {
												klasses.push( settings.klass.highlighted )
											}

											// Add the `disabled` class if something's disabled and the object matches.
											if ( isDisabled ) {
												klasses.push( settings.klass.disabled )
											}

											return klasses.join( ' ' )
										})([ settings.klass.day ]),
										'data-pick=' + targetDate.pick + ' ' + _.ariaAttr({
											role: 'gridcell',
											label: formattedDate,
											selected: isSelected && calendar.$node.val() === formattedDate ? true : null,
											activedescendant: isHighlighted ? true : null,
											disabled: isDisabled ? true : null
										})
									),
									'',
									_.ariaAttr({ role: 'presentation' })
								] //endreturn
							}
						})
					] //endreturn
				}
			})
		),
		settings.klass.table,
		'id="' + calendar.$node[0].id + '_table' + '" ' + _.ariaAttr({
			role: 'grid',
			controls: calendar.$node[0].id,
			readonly: true
		})
	)
	, settings.klass.calendar_container) // end calendar

	 +

	// * For Firefox forms to submit, make sure to set the buttons’ `type` attributes as “button”.
	_.node(
		'div',
		_.node( 'button', settings.today, "btn-flat picker__today",
			'type=button data-pick=' + nowObject.pick +
			( isOpen && !calendar.disabled(nowObject) ? '' : ' disabled' ) + ' ' +
			_.ariaAttr({ controls: calendar.$node[0].id }) ) +
		_.node( 'button', settings.clear, "btn-flat picker__clear",
			'type=button data-clear=1' +
			( isOpen ? '' : ' disabled' ) + ' ' +
			_.ariaAttr({ controls: calendar.$node[0].id }) ) +
		_.node('button', settings.close, "btn-flat picker__close",
			'type=button data-close=true ' +
			( isOpen ? '' : ' disabled' ) + ' ' +
			_.ariaAttr({ controls: calendar.$node[0].id }) ),
		settings.klass.footer
	) //endreturn
} //DatePicker.prototype.nodes




/**
 * The date picker defaults.
 */
DatePicker.defaults = (function( prefix ) {

	return {

		// The title label to use for the month nav buttons
		labelMonthNext: 'Next month',
		labelMonthPrev: 'Previous month',

		// The title label to use for the dropdown selectors
		labelMonthSelect: 'Select a month',
		labelYearSelect: 'Select a year',

		// Months and weekdays
		monthsFull: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
		monthsShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
		weekdaysFull: [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ],
		weekdaysShort: [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],

		// Materialize modified
		weekdaysLetter: [ 'S', 'M', 'T', 'W', 'T', 'F', 'S' ],

		// Today and clear
		today: 'Today',
		clear: 'Clear',
		close: 'Close',

		// The format to show on the `input` element
		format: 'YYYY-MM-DD',

		// Classes
		klass: {

			table: prefix + 'table',

			header: prefix + 'header',


			// Materialize Added klasses
			date_display: prefix + 'date-display',
			day_display: prefix + 'day-display',
			month_display: prefix + 'month-display',
			year_display: prefix + 'year-display',
			calendar_container: prefix + 'calendar-container',
			// end



			navPrev: prefix + 'nav--prev',
			navNext: prefix + 'nav--next',
			navDisabled: prefix + 'nav--disabled',

			month: prefix + 'month',
			year: prefix + 'year',

			selectMonth: prefix + 'select--month',
			selectYear: prefix + 'select--year',

			weekdays: prefix + 'weekday',

			day: prefix + 'day',
			disabled: prefix + 'day--disabled',
			selected: prefix + 'day--selected',
			highlighted: prefix + 'day--highlighted',
			now: prefix + 'day--today',
			infocus: prefix + 'day--infocus',
			outfocus: prefix + 'day--outfocus',

			footer: prefix + 'footer',

			buttonClear: prefix + 'button--clear',
			buttonToday: prefix + 'button--today',
			buttonClose: prefix + 'button--close'
		}
	}
})( Picker.klasses().picker + '__' )





/**
 * Extend the picker to add the date picker.
 */
Picker.extend( 'pickadate', DatePicker )


}));


;(function ($) {

$.fn.characterCounter = function(){
	return this.each(function(){
	var $input = $(this);
	var $counterElement = $input.parent().find('span[class="character-counter"]');

	// character counter has already been added appended to the parent container
	if ($counterElement.length) {
		return;
	}

	var itHasLengthAttribute = $input.attr('length') !== undefined;

	if(itHasLengthAttribute){
		$input.on('input', updateCounter);
		$input.on('focus', updateCounter);
		$input.on('blur', removeCounterElement);

		addCounterElement($input);
	}

	});
};

function updateCounter(){
	var maxLength = +$(this).attr('length'),
	actualLength= +$(this).val().length,
	isValidLength = actualLength <= maxLength;

	$(this).parent().find('span[class="character-counter"]')
					.html( actualLength + '/' + maxLength);

	addInputStyle(isValidLength, $(this));
}

function addCounterElement($input) {
	var $counterElement = $input.parent().find('span[class="character-counter"]');

	if ($counterElement.length) {
	return;
	}

	$counterElement = $('<span/>')
						.addClass('character-counter')
						.css('float','right')
						.css('font-size','12px')
						.css('height', 1);

	$input.parent().append($counterElement);
}

function removeCounterElement(){
	$(this).parent().find('span[class="character-counter"]').html('');
}

function addInputStyle(isValidLength, $input){
	var inputHasInvalidClass = $input.hasClass('invalid');
	if (isValidLength && inputHasInvalidClass) {
	$input.removeClass('invalid');
	}
	else if(!isValidLength && !inputHasInvalidClass){
	$input.removeClass('valid');
	$input.addClass('invalid');
	}
}

$(document).ready(function(){
	$('input, textarea').characterCounter();
});

}( jQuery ));
;(function ($) {

var methods = {

	init : function(options) {
	var defaults = {
		time_constant: 200, // ms
		dist: -100, // zoom scale TODO: make this more intuitive as an option
		shift: 0, // spacing for center image
		padding: 0, // Padding between non center items
		full_width: false, // Change to full width styles
		indicators: false, // Toggle indicators
		no_wrap: false // Don't wrap around and cycle through items.
	};
	options = $.extend(defaults, options);

	return this.each(function() {

		var images, offset, center, pressed, dim, count,
			reference, referenceY, amplitude, target, velocity,
			xform, frame, timestamp, ticker, dragged, vertical_dragged;
		var $indicators = $('<ul class="indicators"></ul>');


		// Initialize
		var view = $(this);
		var showIndicators = view.attr('data-indicators') || options.indicators;

		// Don't double initialize.
		if (view.hasClass('initialized')) {
		// Redraw carousel.
		$(this).trigger('carouselNext', [0.000001]);
		return true;
		}


		// Options
		if (options.full_width) {
		options.dist = 0;
		var firstImage = view.find('.carousel-item img').first();
		if (firstImage.length) {
			imageHeight = firstImage.load(function(){
			view.css('height', $(this).height());
			});
		} else {
			imageHeight = view.find('.carousel-item').first().height();
			view.css('height', imageHeight);
		}

		// Offset fixed items when indicators.
		if (showIndicators) {
			view.find('.carousel-fixed-item').addClass('with-indicators');
		}
		}


		view.addClass('initialized');
		pressed = false;
		offset = target = 0;
		images = [];
		item_width = view.find('.carousel-item').first().innerWidth();
		dim = item_width * 2 + options.padding;

		view.find('.carousel-item').each(function (i) {
		images.push($(this)[0]);
		if (showIndicators) {
			var $indicator = $('<li class="indicator-item"></li>');

			// Add active to first by default.
			if (i === 0) {
			$indicator.addClass('active');
			}

			// Handle clicks on indicators.
			$indicator.click(function () {
			var index = $(this).index();
			cycleTo(index);
			});
			$indicators.append($indicator);
		}
		});

		if (showIndicators) {
		view.append($indicators);
		}
		count = images.length;


		function setupEvents() {
		if (typeof window.ontouchstart !== 'undefined') {
			view[0].addEventListener('touchstart', tap);
			view[0].addEventListener('touchmove', drag);
			view[0].addEventListener('touchend', release);
		}
		view[0].addEventListener('mousedown', tap);
		view[0].addEventListener('mousemove', drag);
		view[0].addEventListener('mouseup', release);
		view[0].addEventListener('mouseleave', release);
		view[0].addEventListener('click', click);
		}

		function xpos(e) {
		// touch event
		if (e.targetTouches && (e.targetTouches.length >= 1)) {
			return e.targetTouches[0].clientX;
		}

		// mouse event
		return e.clientX;
		}

		function ypos(e) {
		// touch event
		if (e.targetTouches && (e.targetTouches.length >= 1)) {
			return e.targetTouches[0].clientY;
		}

		// mouse event
		return e.clientY;
		}

		function wrap(x) {
		return (x >= count) ? (x % count) : (x < 0) ? wrap(count + (x % count)) : x;
		}

		function scroll(x) {
		var i, half, delta, dir, tween, el, alignment, xTranslation;

		offset = (typeof x === 'number') ? x : offset;
		center = Math.floor((offset + dim / 2) / dim);
		delta = offset - center * dim;
		dir = (delta < 0) ? 1 : -1;
		tween = -dir * delta * 2 / dim;
		half = count >> 1;

		if (!options.full_width) {
			alignment = 'translateX(' + (view[0].clientWidth - item_width) / 2 + 'px) ';
			alignment += 'translateY(' + (view[0].clientHeight - item_width) / 2 + 'px)';
		} else {
			alignment = 'translateX(0)';
		}

		// Set indicator active
		if (showIndicators) {
			var diff = (center % count);
			var activeIndicator = $indicators.find('.indicator-item.active');
			if (activeIndicator.index() !== diff) {
			activeIndicator.removeClass('active');
			$indicators.find('.indicator-item').eq(diff).addClass('active');
			}
		}

		// center
		// Don't show wrapped items.
		if (!options.no_wrap || (center >= 0 && center < count)) {
			el = images[wrap(center)];
			el.style[xform] = alignment +
			' translateX(' + (-delta / 2) + 'px)' +
			' translateX(' + (dir * options.shift * tween * i) + 'px)' +
			' translateZ(' + (options.dist * tween) + 'px)';
			el.style.zIndex = 0;
			if (options.full_width) { tweenedOpacity = 1; }
			else { tweenedOpacity = 1 - 0.2 * tween; }
			el.style.opacity = tweenedOpacity;
			el.style.display = 'block';
		}

		for (i = 1; i <= half; ++i) {
			// right side
			if (options.full_width) {
			zTranslation = options.dist;
			tweenedOpacity = (i === half && delta < 0) ? 1 - tween : 1;
			} else {
			zTranslation = options.dist * (i * 2 + tween * dir);
			tweenedOpacity = 1 - 0.2 * (i * 2 + tween * dir);
			}
			// Don't show wrapped items.
			if (!options.no_wrap || center + i < count) {
			el = images[wrap(center + i)];
			el.style[xform] = alignment +
				' translateX(' + (options.shift + (dim * i - delta) / 2) + 'px)' +
				' translateZ(' + zTranslation + 'px)';
			el.style.zIndex = -i;
			el.style.opacity = tweenedOpacity;
			el.style.display = 'block';
			}


			// left side
			if (options.full_width) {
			zTranslation = options.dist;
			tweenedOpacity = (i === half && delta > 0) ? 1 - tween : 1;
			} else {
			zTranslation = options.dist * (i * 2 - tween * dir);
			tweenedOpacity = 1 - 0.2 * (i * 2 - tween * dir);
			}
			// Don't show wrapped items.
			if (!options.no_wrap || center - i >= 0) {
			el = images[wrap(center - i)];
			el.style[xform] = alignment +
				' translateX(' + (-options.shift + (-dim * i - delta) / 2) + 'px)' +
				' translateZ(' + zTranslation + 'px)';
			el.style.zIndex = -i;
			el.style.opacity = tweenedOpacity;
			el.style.display = 'block';
			}
		}

		// center
		// Don't show wrapped items.
		if (!options.no_wrap || (center >= 0 && center < count)) {
			el = images[wrap(center)];
			el.style[xform] = alignment +
			' translateX(' + (-delta / 2) + 'px)' +
			' translateX(' + (dir * options.shift * tween) + 'px)' +
			' translateZ(' + (options.dist * tween) + 'px)';
			el.style.zIndex = 0;
			if (options.full_width) { tweenedOpacity = 1; }
			else { tweenedOpacity = 1 - 0.2 * tween; }
			el.style.opacity = tweenedOpacity;
			el.style.display = 'block';
		}
		}

		function track() {
		var now, elapsed, delta, v;

		now = Date.now();
		elapsed = now - timestamp;
		timestamp = now;
		delta = offset - frame;
		frame = offset;

		v = 1000 * delta / (1 + elapsed);
		velocity = 0.8 * v + 0.2 * velocity;
		}

		function autoScroll() {
		var elapsed, delta;

		if (amplitude) {
			elapsed = Date.now() - timestamp;
			delta = amplitude * Math.exp(-elapsed / options.time_constant);
			if (delta > 2 || delta < -2) {
				scroll(target - delta);
				requestAnimationFrame(autoScroll);
			} else {
				scroll(target);
			}
		}
		}

		function click(e) {
		// Disable clicks if carousel was dragged.
		if (dragged) {
			e.preventDefault();
			e.stopPropagation();
			return false;

		} else if (!options.full_width) {
			var clickedIndex = $(e.target).closest('.carousel-item').index();
			var diff = (center % count) - clickedIndex;

			// Disable clicks if carousel was shifted by click
			if (diff !== 0) {
			e.preventDefault();
			e.stopPropagation();
			}
			cycleTo(clickedIndex);
		}
		}

		function cycleTo(n) {
		var diff = (center % count) - n;

		// Account for wraparound.
		if (!options.no_wrap) {
			if (diff < 0) {
			if (Math.abs(diff + count) < Math.abs(diff)) { diff += count; }

			} else if (diff > 0) {
			if (Math.abs(diff - count) < diff) { diff -= count; }
			}
		}

		// Call prev or next accordingly.
		if (diff < 0) {
			view.trigger('carouselNext', [Math.abs(diff)]);

		} else if (diff > 0) {
			view.trigger('carouselPrev', [diff]);
		}
		}

		function tap(e) {
		pressed = true;
		dragged = false;
		vertical_dragged = false;
		reference = xpos(e);
		referenceY = ypos(e);

		velocity = amplitude = 0;
		frame = offset;
		timestamp = Date.now();
		clearInterval(ticker);
		ticker = setInterval(track, 100);

		}

		function drag(e) {
		var x, delta, deltaY;
		if (pressed) {
			x = xpos(e);
			y = ypos(e);
			delta = reference - x;
			deltaY = Math.abs(referenceY - y);
			if (deltaY < 30 && !vertical_dragged) {
			// If vertical scrolling don't allow dragging.
			if (delta > 2 || delta < -2) {
				dragged = true;
				reference = x;
				scroll(offset + delta);
			}

			} else if (dragged) {
			// If dragging don't allow vertical scroll.
			e.preventDefault();
			e.stopPropagation();
			return false;

			} else {
			// Vertical scrolling.
			vertical_dragged = true;
			}
		}

		if (dragged) {
			// If dragging don't allow vertical scroll.
			e.preventDefault();
			e.stopPropagation();
			return false;
		}
		}

		function release(e) {
		if (pressed) {
			pressed = false;
		} else {
			return;
		}

		clearInterval(ticker);
		target = offset;
		if (velocity > 10 || velocity < -10) {
			amplitude = 0.9 * velocity;
			target = offset + amplitude;
		}
		target = Math.round(target / dim) * dim;

		// No wrap of items.
		if (options.no_wrap) {
			if (target >= dim * (count - 1)) {
			target = dim * (count - 1);
			} else if (target < 0) {
			target = 0;
			}
		}
		amplitude = target - offset;
		timestamp = Date.now();
		requestAnimationFrame(autoScroll);

		if (dragged) {
			e.preventDefault();
			e.stopPropagation();
		}
		return false;
		}

		xform = 'transform';
		['webkit', 'Moz', 'O', 'ms'].every(function (prefix) {
		var e = prefix + 'Transform';
		if (typeof document.body.style[e] !== 'undefined') {
			xform = e;
			return false;
		}
		return true;
		});



		window.onresize = scroll;

		setupEvents();
		scroll(offset);

		$(this).on('carouselNext', function(e, n) {
		if (n === undefined) {
			n = 1;
		}
		target = offset + dim * n;
		if (offset !== target) {
			amplitude = target - offset;
			timestamp = Date.now();
			requestAnimationFrame(autoScroll);
		}
		});

		$(this).on('carouselPrev', function(e, n) {
		if (n === undefined) {
			n = 1;
		}
		target = offset - dim * n;
		if (offset !== target) {
			amplitude = target - offset;
			timestamp = Date.now();
			requestAnimationFrame(autoScroll);
		}
		});

		$(this).on('carouselSet', function(e, n) {
		if (n === undefined) {
			n = 0;
		}
		cycleTo(n);
		});

	});



	},
	next : function(n) {
	$(this).trigger('carouselNext', [n]);
	},
	prev : function(n) {
	$(this).trigger('carouselPrev', [n]);
	},
	set : function(n) {
	$(this).trigger('carouselSet', [n]);
	}
};


	$.fn.carousel = function(methodOrOptions) {
	if ( methods[methodOrOptions] ) {
		return methods[ methodOrOptions ].apply( this, Array.prototype.slice.call( arguments, 1 ));
	} else if ( typeof methodOrOptions === 'object' || ! methodOrOptions ) {
		// Default to "init"
		return methods.init.apply( this, arguments );
	} else {
		$.error( 'Method ' +methodOrOptions + ' does not exist on jQuery.carousel' );
	}
	}; // Plugin end


}( jQuery ));




;(function($){
	var quttonnamespace = 'qutton';
	var quttoninstance = {
		template : '<div class="qutton">\
						<div class="qutton_dialog">\
								<h2>Upload a new file</h2>\
						</div>\
						</div>',
		options : {
			title: 'Hey there',
			content : 'Notifacation Text',			
			buttons : {},
			onshow : null,
			width : 200,
			height : 100,
			backgroundColor : "#EB1220",
			easing : 'easeInOutQuint',
			onclose : null
		},
		init : function(options){
			quttoninstance.options = $.extend(quttoninstance.options, options);
			quttoninstance.element = $(this);
			quttoninstance.dialog = $(quttoninstance.template).children();
			quttoninstance.build();
			
		},
		build : function(){
			$(quttoninstance.template).insertAfter(quttoninstance.element);
			quttoninstance.quttonconfig = {
				width : quttoninstance.element.outerWidth(),
				height : quttoninstance.element.outerHeight(),
				backgroundColor : quttoninstance.toHex(quttoninstance.element.css('background-color')),
				borderRadius : quttoninstance.element.css('border-radius'),
				zIndex : quttoninstance.element.css('z-index')
			}
			$(quttoninstance.template).css({
				'width' : quttoninstance.quttonconfig.width + "px",
				'height' : quttoninstance.quttonconfig.height + "px",
				'background-color' : quttoninstance.quttonconfig.backgroundColor,
				'border-radius' : quttoninstance.quttonconfig.height + "px"
			});
			
			
			quttoninstance.element.click(function(event){
				quttoninstance.show();
			});	
			
		},
		show : function(){
			var translate = {
				X : -1 * (quttoninstance.quttonconfig.width/2 - quttoninstance.options.width/2),
				Y : -0.5 * (quttoninstance.quttonconfig.width/2 - quttoninstance.options.height/2)
			};
			
			var inSequence= [
				{
					e : quttoninstance.template, 
					p : {
						width : quttoninstance.options.width +"px",
						height : quttoninstance.options.height + "px",
						borderRadius : quttoninstance.quttonconfig.borderRadius,
						backgroundColor : quttoninstance.quttonconfig.backgroundColor,
						translateX : translate.X + quttoninstance.keepInBounds().X + "px",
						translateY : translate.Y + quttoninstance.keepInBounds().Y + "px"
					}, 
					o : {
						duration : 500, 
						easing : quttoninstance.options.easing,
						begin : function() {
							quttoninstance.template.css({
								'position' : 'absolute',
								'z-index' : '10000'
							});
						},
						complete : function() {
							quttoninstance.template.css({
								display:"block"
							});
							quttoninstance.isOpen = true;	
						}

					}},

				{e : quttoninstance.template, p : "fadeIn", o : {duration : 300}}
			];

			$.Velocity.RunSequence(inSequence);
		},
		hide : function(){
			
		},
		toHex : function(rgb){
			rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
			 return (rgb && rgb.length === 4) ? "#" +
			("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
			("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
			("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
		},
		keepInBounds : function(){
			var $window = $(window);
			var windowWidth = $window.width();
			var windowHeight = $window.height();

			var position = quttoninstance.element.position();	

			// Coordinates of top center of Qutton before it converts to a a dialog
			var buttonCenterTop = {
				top : position.top,
				left : position.left + (quttoninstance.options.width/2)
			};

			// Coordinates of the dialog once it opens
			var dialogCoords = {
				top : buttonCenterTop.top - ( 0.5 * (quttoninstance.quttonconfig.height/2 - quttoninstance.options.height/2)),
				left : buttonCenterTop.left - (quttoninstance.quttonconfig.width/2),
			};

			// How much the dialog extends beyond the document
			var extend= {
				left : dialogCoords.left,
				right : windowWidth - (dialogCoords.left + quttoninstance.quttonconfig.width),
				top : dialogCoords.top,
				bottom : windowHeight - (dialogCoords.top + quttoninstance.quttonconfig.height)
			};

			// Amount to translate in X and Y if possible to bring dialog in bounds of document
			var translateInBounds = {
				X : quttoninstance.calculateTranslateAmount(extend.left, extend.right), 
				Y : quttoninstance.calculateTranslateAmount(extend.top, extend.bottom) 
			};

			return translateInBounds;
		},
		calculateTranslateAmount : function(extendSideOne, extendSideTwo){
			if((extendSideOne < 0 && extendSideTwo < 0) || (extendSideOne > 0 && extendSideTwo > 0 )) { 
				return 0;	
			}

			// We want to translate in opposite direction of extension
			return (extendSideOne < 0 ? -extendSideOne : extendSideTwo);
		}
	};
	$.fn.qutton = function(options){
		if (quttoninstance[options] ) {
			return quttoninstance[ options ].apply(this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof options === 'object' || ! options ) {
			// Default to "init"
			return quttoninstance.init.apply(this, arguments );
		} else {
			$.error( 'Method ' +options + ' does not exist on '+namespace);
		} 
	}




}(jQuery));



;( function( $, window, document, undefined ) {
	"use strict";
		var defaults = {
				searchable: true,
				onselect : null,
				onopen : null,
				onclose : null,
				openonhover: false,
				closeonselect: true,
				closeonclickoutside: false
			};

		// The actual plugin constructor
		function Materialselect (element, options) {
			this.element = $(element);
			this.settings = $.extend({}, defaults, options);
			this.uid = Materialize.guid();
			this.init();
		}

		// Avoid Plugin.prototype conflicts
		$.extend( Materialselect.prototype, {
			init: function() {
				this.build();
			},
			build: function() {
				var instance = this;
				instance.wrapper = $('<div class="select-wrapper"></div>');
				instance.wrapper.addClass(instance.element.attr('class'));
				instance.multiple = instance.element.attr('multiple') ? true : false;
				instance.disabled = instance.element.is(':disabled');

				instance.selectdropdown = $('<ul id="select-options-'+instance.uid+'" class="dropdown-content white select-dropdown'+ (instance.multiple ? ' multiple-select-dropdown' : '')+'"></ul>');
				instance.selectoptions = instance.element.children('option, optgroup');
				instance.optionsvalues = [];
				instance.optionstexts = [];
				instance.allselectoptions = [];

				instance.selectdropdownsearchdom =$('<li class="input-field"><label for="'+instance.uid+'-searcher"><i class="material-icons spaced-text">search</i>Search</label><input id="'+instance.uid+'-searcher" type="text" ></li>');
				if (instance.settings.searchable) {					
					instance.selectdropdown.append(instance.selectdropdownsearchdom);
					
				}
				instance.dropdownicon = $('<span class="caret">&#9660;</span>');	

				if (instance.disabled){
					instance.dropdownicon.addClass('disabled');
				}

				/* Create dropdown structure. */
				if (instance.selectoptions.length) {
					instance.selectoptions.each(function() {
					if ($(this).is('option')) {
						var option = $(this);
						var optionvalue = option.attr('value');
						var optiontext = option.text();
						var icon = option.data('icon');
						var image = option.data('image');
						var classes = option.attr('class');
						var disabled = (option.is(':disabled')) ? true : false;
						var optionvars= {};

						if (typeof optionvalue == 'undefined') {
						optionvalue = ''; 
						}
						if (typeof optiontext == 'undefined') {
						optiontext = '';
						}
						if (typeof icon == 'undefined') {
						icon = false; 
						}
						if (typeof image == 'undefined') {
						image = false; 
						}
						if (typeof classes == 'undefined') {
						classes = false;
						}
						optionvars['value'] = optionvalue;
						optionvars['text'] = optiontext;
						optionvars['icon'] = icon;
						optionvars['image'] = image;
						optionvars['classes'] = classes;


						instance.optionsvalues.push(optionvalue);
						instance.optionstexts.push(optiontext);

						instance.allselectoptions.push(optionvars);

						instance.addoption(optionvars, disabled);

					}
					else if ($(this).is('optgroup')) {
						// Optgroup.
						var selectOptions = $(this).children('option');
						instance.selectdropdown.append($('<li class="optgroup"><span>' + $(this).attr('label') + '</span></li>'));
					}
					});
				}



				instance.element.wrap(instance.wrapper);
				
				if (instance.multiple) {
					instance.newselect = $('<div class="chips select-dropdown" data-activates="select-options-' + instance.uid +'"> </div>');
				}
				else{
					instance.newselect = $('<input type="text" class="select-dropdown" readonly="true" '+((instance.disabled) ? 'disabled' : '')+' data-activates="select-options-' + instance.uid +'"/>');
				} 
				

				
				
				
				instance.element.before(instance.newselect);
				instance.newselect.before(instance.dropdownicon);
				instance.newselect.after(instance.selectdropdown);

					// Check if section element is disabled
				if (!instance.disabled) {
					instance.newselect.dropdown({hover : false, 
												constrainWidth : true, 
												alignment : 'left',
												onopen : function(){
													instance.selectdropdownsearchdom.find('#'+instance.uid+'-searcher').focus();
													
												},
												closeOnClick : false});
				}
				

				if (instance.multiple) {
					instance.newselect.material_chip();
				}
				
				instance.initevents();
				
				if (instance.settings.searchable) {

				}
				instance.searchinput = instance.selectdropdownsearchdom.find('input[type="text"]');
				$(instance.searchinput).on("change paste keyup", function() {
					var searchkeyword = $(this).val();
					searchkeyword.trim();
					if (searchkeyword.length > 0) {
					instance.search(searchkeyword);
					}
					else{
					instance.refresh();
					}
					
				});
				if (instance.multiple) {
					instance.currentselections = instance.element.find('option:selected') || instance.element.find('option:first') || "";
					instance.currentselections.each(function(){
						var optionvalue = $(this).attr("value");
						$("li[data-value='"+optionvalue+"']").trigger("click");
					});					
				}
				else{
					instance.currentselection = instance.element.find('option:selected').attr('value') || instance.element.find('option:first').attr('value') || "";
					instance.setselection(instance.currentselection);
				}
				instance.element.css({"display":"none"});
			},
			addoption : function(vars, disabled=false){
				var instance = this;
				var icon = false;
				var image = false;
				var value = false;
				var text = false;
				var classess = false;

				if('icon' in vars){
					icon = vars['icon'];
				}
				if('image' in vars){
					image = vars['image'];
				}
				if('value' in vars){
					value = vars['value'];
				}
				if('text' in vars){
					text = vars['text'];
				}
				if('classess' in vars){
					classess = vars['classess'];
				}

				var option = $('<li'+((value) ? ' data-value="'+value+'"' : '')+''+((classess) ? ' class="'+classess+'"' : '')+'>'+(icon? '<i class="material-icons circle">'+icon+'</i>' : (image? '<img src="'+image+'">' : ''))+'<span>'+((text) ? ''+text+'' : '')+'</span></li>');

				if (instance.multiple) {
					option = $('<li'+((value) ? ' data-value="'+value+'"' : '')+''+((classess) ? ' class="'+classess+'"' : '')+'>'+(icon? '<i class="material-icons circle">'+icon+'</i>' : (image? '<img src="'+image+'">' : ''))+'<span><input type="checkbox"/><label></label>'+((text) ? ''+text+'' : '')+'</span></li>');
				}

				instance.selectdropdown.append(option);					
			
			},
			removealloptions : function(){
				var instance = this;
				instance.selectdropdown.find('li:not(.optgroup):not(.input-field)').each(function(){
					$(this).off("click");
					$(this).remove();
				});
			},
			initevents : function(){
				var instance = this;
				instance.element.bind('addselectoptions', function(event, options){
					for (var i = 0; i <= options.length - 1; i++) {
					var optiondata = options[i];
					if (!instance.optionsvalues.includes(optiondata['value'])) {
						instance.optionsvalues.push(optiondata['value']);
						instance.optionstexts.push(optiondata['text']);
						instance.allselectoptions.push(optiondata);
						instance.element.append('<option value="'+optiondata['value']+'">'+optiondata['text']+'</option>');
						instance.addoption(optiondata);
					}
						
					}
					instance.initevents();
				});
				if (instance.settings.searchable) {
					instance.selectdropdownsearchdom.on({
						click : function (e) {
							e.stopPropagation();
						}
					});
				}
					
				instance.selectdropdown.find('li:not(.optgroup):not(.input-field)').each(function(){
					$(this).on({
					click : function(e){
						if (!$(this).hasClass('disabled') && !$(this).hasClass('optgroup')) {
						var value = $(this).data('value');
						if (instance.multiple) {
							if (!$(this).hasClass('selected')) {
							$(this).addClass('selected');
								$('input[type="checkbox"]', this).prop('checked', true);
							}
							else{
								$(this).removeClass('selected');
								$('input[type="checkbox"]', this).prop('checked', false);
							}
						}
							instance.setselection(value);
						}
						e.stopPropagation();
					} 
					});
					
				});

			},
			refresh : function(){
				var instance = this;
				instance.removealloptions();
				$.each(instance.allselectoptions, function(index, value){
					instance.addoption(instance.allselectoptions[index]);
				});
				instance.initevents();
			},
			search : function(keyword){
				var instance = this;
				instance.selectdropdown.find('li:not(.optgroup):not(.input-field)').each(function(){
					$(this).hide();
				});
				
				keyword = keyword.toLowerCase();
				var results = [];
					var found = $.grep(instance.optionstexts, function(value, index) {
					value = value.toLowerCase();
					if (value.includes(keyword)) {
						results.push(index);
					}
				});
				$.each(results, function(index, value) {
					var resultvalue = instance.optionsvalues[value];
					instance.selectdropdown.find('li[data-value="'+resultvalue+'"]').show();
				});
				instance.initevents();	
			},
			setselection : function(value){
				var instance = this;
				var position = instance.optionsvalues.indexOf(value);
				var option = instance.element.children('option[value="'+value+'"]');
				
				var selectdropdown = instance.selectdropdown;
				var dropdownoption = selectdropdown.find('li[data-value="'+value+'"]');
				if (instance.multiple) {
					instance.newselect.empty();
					var chipdata = [];
					selectdropdown.children('li.selected').each(function(){
						var selectedoptionvalue = $(this).data('value');
						$.grep(instance.optionsvalues, function(v, index) {
						if (v == selectedoptionvalue) {
							instance.newselect.append($('<div class="chip" data-value="'+v+'">'+instance.optionstexts[index]+' <i class="material-icons close">close</i></div>'));
							

						}
						});
					});					
					
					instance.newselect.on('chip.delete', function(e, chip){
						var selectvalue = $(chip).data('value');
						var dropdownselectoption = selectdropdown.children('li.selected[data-value="'+selectvalue+'"]');
						dropdownselectoption.trigger("click");	
					});
					var currentstate = option.prop("selected");
					if (currentstate) {
						option.prop("selected", true);
					}
					else{
						option.prop("selected", false);
					}
					
					instance.element.val(value).trigger('change');
					
					
				}
				else{
					instance.selectdropdown.find('li').removeClass('selected');
					dropdownoption.addClass('selected');
					instance.element.val(value).trigger('change');
					instance.newselect.val(dropdownoption.text());
					instance.newselect.dropdown('close');
				}
			
			
			}



		});

		// A really lightweight plugin wrapper around the constructor,
		// preventing against multiple instantiations
		$.fn.materialselect = function(options) {
			return this.each(function() {
				if (!$.data(this, "plugin_materialselect") ) {
					$.data( this, "plugin_materialselect", new Materialselect( this, options) );
				}
			} );
		};

})(jQuery, window, document);






//Materialscrollbar plugin
;( function( $, window, document, undefined ) {
"use strict";

	var classes = {
			verticalwrapper: 'vertical',
			horizontalwrapper: 'horizontal',
			track: 'track'
		};

	var defaults = {
			autoHide: true,
			placement: 'outside',
			axis:'xy',
			bgcolor:'#ff0000',
			color:'#9e9e9e',
			size: 5,
			barsize: 20
	};

	// The actual plugin constructor
	function Materialscrollbar (element, options) {
	this.element = $(element);
	this.options = $.extend({}, defaults, options);
	this.uid = Materialize.guid();
	this.overflowsize = {'x':0, 'y':0};
	this.init();


	}

	// Avoid Plugin.prototype conflicts
	$.extend( Materialscrollbar.prototype, {
	init: function() {
		this.outerheight = this.element.outerHeight();
		this.innerheight = this.element.innerHeight();
		this.outerwidth = this.element.outerWidth();
		this.innerwidth = this.element.innerWidth();
		this.elementchildren = this.element.children();
		this.build();
		this.bindlisteners();
	},
	build : function(){
		var instance = this;
			
			

			var borderradius = Math.floor(0.5*this.options.size);
			var barborderradius = Math.floor(0.5*this.options.barsize);
			this.idlebarcolor = Materialize.colors.lighten(this.options.color, 2);
			



			this.element.css({'overflow' : 'hidden'});

			this.scrollbarvertical = $('<div class="scrollbar '+classes.verticalwrapper+'"> </div>');
			this.scrollbarhorizontal = $('<div class="scrollbar '+classes.horizontalwrapper+'"> </div>');

			this.scrollbarvertical.css({'background':this.options.bgcolor, 'width':this.options.size+'px', 'border-radius':borderradius+'px'});
			this.scrollbarhorizontal.css({'background':this.options.bgcolor, 'height':this.options.size+'px', 'border-radius':borderradius+'px'});

			

			this.bar = $('<div class="bar"> </div>');

			this.bar.css({'background':this.idlebarcolor});
			

			if (this.hasoverflow('x')) {
				var horizontalscrollbar = this.element.find('.'+classes.horizontalwrapper);

				if (typeof horizontalscrollbar == 'undefined' || horizontalscrollbar.length == 0) {
				this.element.prepend(this.scrollbarhorizontal); 
				this.scrollbarhorizontal.append(this.bar);
				}
				
			}
			if (this.hasoverflow('y')) {
				var verticalscrollbar = this.element.find('.'+classes.verticalwrapper);
				if (typeof verticalscrollbar == 'undefined' || verticalscrollbar.length == 0) {
				this.element.prepend(this.scrollbarvertical);
				this.scrollbarvertical.append(this.bar);
				}
			}

			this.scrollbarhorizontal.find('.bar').css({'height':this.options.barsize+'px', 'border-radius':barborderradius+'px'});
			this.scrollbarvertical.find('.bar').css({'width':this.options.barsize+'px', 'border-radius':barborderradius+'px'});


			var barmargin, margin, vbarlength, hbarlength;

			if (this.options.barsize > this.options.size) {
			var perc = this.options.size/this.options.barsize;
				margin = perc * this.options.barsize;
				margin = margin.toFixed(1);
				barmargin = (this.options.barsize - this.options.size)/2;
				this.scrollbarvertical.css({'transform':'translateX(-'+margin+'px)'});
				this.scrollbarvertical.find('.bar').css({'transform':'translateX(-'+barmargin+'px)'});
			}
			if (this.overflowsize.y > 0) {
				var overflowratio = this.overflowsize.y/this.innerheight;
				vbarlength = overflowratio*this.innerheight;
				this.scrollbarvertical.find('.bar').css({'height':+vbarlength+'px', 'top':'0px'});
			}

			
			
		},
		bindlisteners : function(){
			var instance = this;
			instance.element.bind({
				mouseenter : function(e){
				instance.scrollbarhorizontal.find('.bar').velocity({ 
				backgroundColor: instance.options.color
				}, 200);
				instance.scrollbarvertical.find('.bar').velocity({ 
				backgroundColor: instance.options.color
				}, 200);
				},
				mouseleave : function(e){
				instance.scrollbarhorizontal.find('.bar').velocity({ 
				backgroundColor: instance.idlebarcolor
				}, 300);
				instance.scrollbarvertical.find('.bar').velocity({ 
				backgroundColor: instance.idlebarcolor
				}, 300);
				}
			});
		},
		unbindlisteners : function(){

		},
		hasoverflow : function(axis='y'){
			var instance = this;
			var totalchildrenheight = 0;
			var totalchildrenwidth = 0;
			var overflow = false;
			var difference;
			
			$.each(instance.elementchildren, function(index, child){
				totalchildrenheight += child.offsetTop+child.offsetHeight;
				totalchildrenwidth += child.offsetLeft+child.offsetWidth;
			});

			if (axis=='y') {
				if (totalchildrenheight > this.innerheight) {
				overflow = true;
				difference = totalchildrenheight - this.innerheight;
				this.overflowsize.y = difference;
				}
			}
			else if (axis=='x') {
				if (totalchildrenwidth > this.innerwidth) {
				overflow = true;
				difference = totalchildrenwidth - this.innerwidth;
				this.overflowsize.x = difference;
				}
			}
			return overflow;
		},
		show : function(){
			
		},
		scrollTo : function(){
			
		},
		hide : function(){
			
		},
		update : function(){
			
		},
		destroy : function(){
			
		}
	} );

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn.materialscrollbar = function(options) {
	return this.each(function() {
		if (!$.data(this, "plugin_materialscrollbar") ) {
		$.data( this, "plugin_materialscrollbar", new Materialscrollbar( this, options) );
		}
	} );
	};

})(jQuery, window, document);







;(function( $, window, document, undefined ) {
"use strict";
	var defaults = {
			datadom: ".pagebody",
			doubleclick: false,
			ajaxurl: "#",
			ajax: "none",
			error500dom : '<div class="browser-window">\
						<div class="top-bar">\
						<div class="circles">\
							<div id="close-circle" class="circle"></div>\
							<div id="minimize-circle" class="circle"></div>\
							<div id="maximize-circle" class="circle"></div>\
						</div>\
						</div>\
						<div class="content">\
						<div class="row">\
							<div id="site-layout-example-top" class="col s12">\
							<p class="flat-text-logo center white-text caption-uppercase">Internal server error</p>\
							</div>\
							<div id="site-layout-example-right" class="col s12 m12 l12">\
							<div class="row center">\
								<h1 class="text-long-shadow col s12">500</h1>\
							</div>\
							<div class="row center">\
								<p class="center white-text col s12">Something has gone seriously wrong. Please try later.</p>\
								</p><p>\
								</p>\
							</div>\
							</div>\
						</div>\
						</div>\
					</div>',
		error404dom : '<div class="browser-window">\
						<div class="top-bar">\
						<div class="circles">\
							<div id="close-circle" class="circle"></div>\
							<div id="minimize-circle" class="circle"></div>\
							<div id="maximize-circle" class="circle"></div>\
						</div>\
						</div>\
						<div class="content">\
						<div class="row">\
							<div id="site-layout-example-top" class="col s12">\
							<p class="flat-text-logo center white-text caption-uppercase">Sorry but we couldn’t find this page :(</p>\
							</div>\
							<div id="site-layout-example-right" class="col s12 m12 l12">\
							<div class="row center">\
								<h1 class="text-long-shadow col s12">404</h1>\
							</div>\
							<div class="row center">\
								<p class="center white-text col s12">Page not found.</p>\
								</p><p>\
								</p>\
							</div>\
							</div>\
						</div>\
						</div>\
					</div>',
			method: "GET",
			datatype: "HTML",
			progressbars: {
				'header' : '<div class="progressbar"></div>',
				'bouncy' : '<div class="ajaxed-progress">\
						<div class="ajaxed-loaders">\
						<span></span>\
						<span></span>\
						<span></span>\
						</div>\
					</div>',
				
				'horizontal' : '<div class="progress v-centered progressbar">\
								<div class="indeterminate"></div>\
								</div>',

				'circular' : '<div class="preloader-wrapper big active vh-centered">\
							<div class="spinner-layer spinner-blue">\
								<div class="circle-clipper left">\
								<div class="circle"></div>\
								</div><div class="gap-patch">\
								<div class="circle"></div>\
								</div><div class="circle-clipper right">\
								<div class="circle"></div>\
								</div>\
							</div>\
							<div class="spinner-layer spinner-red">\
								<div class="circle-clipper left">\
								<div class="circle"></div>\
								</div><div class="gap-patch">\
								<div class="circle"></div>\
								</div><div class="circle-clipper right">\
								<div class="circle"></div>\
								</div>\
							</div>\
							<div class="spinner-layer spinner-yellow">\
								<div class="circle-clipper left">\
								<div class="circle"></div>\
								</div><div class="gap-patch">\
								<div class="circle"></div>\
								</div><div class="circle-clipper right">\
								<div class="circle"></div>\
								</div>\
							</div>\
							<div class="spinner-layer spinner-green">\
								<div class="circle-clipper left">\
								<div class="circle"></div>\
								</div><div class="gap-patch">\
								<div class="circle"></div>\
								</div><div class="circle-clipper right">\
								<div class="circle"></div>\
								</div>\
							</div>\
					</div>'
		},
		progressbar: "header",
		progressbardom: ".mainheader",
		onload: null,
		onerror: null,
		oncomplete: null,
		beforeload: null, 
		activeclass: "active",
		highlightclass: "highlighted",
		datalinkclass: "datalink",
		refreshrate: false,
		autoload: false
	};

	// The actual plugin constructor
	function Ajaxed (element, options) {
		this.element = $(element);
		this.options = $.extend({}, defaults, options);
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(Ajaxed.prototype, {
	init: function() {
		this.build();
		this.initevents();
		this.loadinterval = null;
		var inlineautoload = this.element.data("autoload");
		if (typeof inlineautoload != "undefined") {
			this.options.autoload = inlineautoload;
		}
		if (this.options.autoload) {
			this.load();
		}
	},
	build: function() {
		if (typeof this.element.attr("href") !== 'undefined') {
			this.options.ajaxurl = this.element.attr("href");
		}
		if (typeof this.element.attr("datadom") !== 'undefined') {
			this.options.datadom = this.element.attr("datadom");
		} 
	},
	initevents: function(){
		var instance = this;
		instance.element.on({
			click : function(event){
			event.preventDefault();
			if (instance.options.doubleclick == false) {
				instance.load();
			}
			else{
				if (!event.ctrlKey) {
				if (instance.options.highlightclass != false) {
					$(instance.element).siblings().removeClass(instance.options.highlightclass);
					if (!instance.element.hasClass(instance.options.highlightclass)) {
					instance.element.addClass(instance.options.highlightclass);
				}
				}
				}
				else{
				if (instance.options.highlightclass != false) {
					if (!instance.element.hasClass(instance.options.highlightclass)) {
					instance.element.addClass(instance.options.highlightclass);
				}
				else{
					instance.element.removeClass(instance.options.highlightclass);
				}
				}
				} 
				
				 instance.parentevents();
			
			} 
			}, 
			dblclick: function(event){
			if (instance.options.doubleclick == true) {
				event.preventDefault();
				instance.parentevents();
				instance.load();
			}
			}
			
		});

		//bind progress complete event
		this.element.bind('onajaxsuccessful', function(event, appenddata){
			if (typeof(appenddata) != "undefined") {
				if ($.isFunction(instance.options.onload)) {
					instance.options.onload.call(this, instance.element, instance.options.datadom, appenddata);
				}
				else{
					$(instance.options.datadom).empty();
					$(instance.options.datadom).append(appenddata);
				}
			} 
				
			if ($.isFunction(instance.options.oncomplete)) {
				instance.options.oncomplete.call(this, instance.element, instance.options.datadom);
			}
				
				
		});

		},
		parentevents: function(){
		var instance = this;
		if (instance.element.hasClass(instance.options.datalinkclass)) {
			var elementparentobject = instance.element.parent();
			if (elementparentobject.length > 0) {
			var parentelement = elementparentobject[0];

			var parentevents = jQuery._data(parentelement, "events");
			if (typeof parentevents !=='undefined') {
			$(parentelement).unbind("keydown");
			}

			$(parentelement).bind("keydown", function(event) {
			var highlightedelements = $(parentelement).find('.'+instance.options.highlightclass);
			

			if (event.ctrlKey) {
				if (event.key.toLowerCase()=="a") {
				event.preventDefault();
				if (instance.options.highlightclass != false) {
					instance.element.siblings().addClass(instance.options.highlightclass);
					if (!instance.element.hasClass(instance.options.highlightclass)) {
					instance.element.addClass(instance.options.highlightclass);
					}
				}
					
				}
			}
			else{
				if (event.key.toLowerCase()=="enter") {
				if (highlightedelements.length == 1) {
					var lasthilightedindex = highlightedelements.length-1;
					var lasthighlightedelement = highlightedelements[lasthilightedindex];
					instance.loadsibling(lasthighlightedelement);
				}
				}
				else if (event.key.toLowerCase()=="delete") {
				console.log("delete key pressed");
				}
				else if (event.key.toLowerCase()=="arrowdown") {

					var lasthilightedindex = highlightedelements.length-1;
					var lasthighlightedelement = highlightedelements[lasthilightedindex];

					if (instance.options.highlightclass != false) {
					$(lasthighlightedelement).siblings().removeClass(instance.options.highlightclass);
					$(lasthighlightedelement).removeClass(instance.options.highlightclass);
					if (!$(lasthighlightedelement).prev().hasClass(instance.options.highlightclass)) {
						$(lasthighlightedelement).prev().addClass(instance.options.highlightclass);
					}
					}

				}
				else if (event.key.toLowerCase()=="arrowup") {

					var lasthilightedindex = highlightedelements.length-1;
					var lasthighlightedelement = highlightedelements[lasthilightedindex];

					if (instance.options.highlightclass != false) {
					$(lasthighlightedelement).siblings().removeClass(instance.options.highlightclass);
					$(lasthighlightedelement).removeClass(instance.options.highlightclass);
					if (!$(lasthighlightedelement).prev().hasClass(instance.options.highlightclass)) {
						$(lasthighlightedelement).prev().addClass(instance.options.highlightclass);
					}
					}
					

				}

			}
			
			});
	
			}
					
		}


		},
		load: function(){
		var progressbars = this.options.progressbars;
		var datadom = this.options.datadom;
		datadom = $(datadom);
		var instance = this;
		var progressbardom = this.options.progressbar;
		var progressbarname = this.options.progressbar;
		if (!(progressbarname in progressbars)) {
			progressbarname = "header";
		}
		var progressbar = this.options.progressbars[progressbarname];
			

		if (this.options.activeclass != false) {
			$(instance.element).siblings().removeClass(instance.options.highlightclass);
			$(instance.element).siblings().removeClass(instance.options.activeclass);
			if (!instance.element.hasClass(instance.options.activeclass)) {
				instance.element.addClass(instance.options.activeclass);
			}
		}
		
		
		if (this.options.progressbar != false) { 		
			$(progressbar).appendTo(progressbardom);
		}
		if (!instance.options.ajaxurl.includes('#')) {
			$.ajax({
			url: instance.options.ajaxurl,
			dataType: instance.options.datatype,
			success: function(successdata, textStatus, xhr){
				if (xhr.status == 200) {
					instance.element.trigger("onajaxsuccessful", [successdata]);
				}
				else{
					instance.element.trigger("onajaxsuccessful");
					$.fn.httperror(e);
				}
			},
			error:function(e){
				var errortext = e.responseText;
				var errorcode = e.status;

				if (errorcode != 200) {
					instance.element.trigger("onajaxsuccessful");
					$.fn.httperror(e);					
				}
				else{					
					if (instance.options.datatype == "JSON") {
						var jsondata = JSON.parse(errortext);
						instance.element.trigger("onajaxsuccessful", [jsondata]);
					}
					
				}

									
									
				
			},
			complete : function(event, xhr){
				if (instance.options.refreshrate != false && instance.options.refreshrate > 0) {
				setTimeout(function(){
					instance.load();
					}, instance.options.refreshrate);
				}

				if (instance.options.progressbar != false) {
					var progressbarclass = $(progressbar).attr("class");			
					$(progressbardom).find('.'+progressbarclass).remove(); 
				}
			}
			});
		

			
		}
				
		
		},

		loadsibling : function(siblingelement){
		$(siblingelement).trigger('dblclick');
					
		}






	} );

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn.ajaxed = function(options) {
		return this.each(function(){
				if (!$.data(this, "plugin_ajaxed") ) {
				$.data( this, "plugin_ajaxed", new Ajaxed(this, options) );
				}
		});
	};

}(jQuery, window, document));




























//Notifacation
;( function( $, window, document, undefined) {
"use strict";
	var defaults = {
			title: 'Hey there',
			text : 'Notifacation Text',
			icon : 'info',
			imagesrc : false,
			footnote : false,
			type : "info",
			notifacations : ['app', 'desktop'],
			closewith: 'timeout',
			timeout : 3000,
			autoshow : true,
			onshow : null,
			onclick : null,
			ondesktopnotify : null,
			oninappnotify : null,
			ondismiss : null
	};

	// The actual plugin constructor
	function Notify(element, options) {
		this.element = $(element);
		this.options = $.extend({}, defaults, options);
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(Notify.prototype, {
	init: function() {
		this.build();
	},
	build: function() {
		var instance = this;
		this.notifacations = [];
		
		if (this.options.notifacations.includes('desktop')) {
			var notifaction = this.desktopnotifacation;
			this.notifacations.push(notifaction);
		}
		if(this.options.notifacations.includes('app')) {
			var notifaction = this.appnotifacation;
			this.notifacations.push(notifaction);
		}

		if (this.notifacations.length > 0) {
			for(var notifaction in this.notifacations){
				instance.notifacations[notifaction].build(instance);
			}
		}

		if (this.options.autoshow) {
			instance.show();
		}

	},
	show : function(){
		var instance = this; 	

		if (this.notifacations.length > 0) {
			for(var notifaction in this.notifacations){
				this.notifacations[notifaction].show();
			}
		}
	},

	dismiss : function(){
		var instance = this; 	

		if (this.notifacations.length > 0) {
			for(var notifaction in this.notifacations){
				this.notifacations[notifaction].dismiss();
			}
		}
	},

	desktopnotifacation : {
		build : function(instance){
			this.instance = instance; 
			this.browserhaspermission();
		}, 
		browserhaspermission : function(){
			if (!window.Notification) {
				return false;
			}
			else{
				if (Notification.permission === 'default') {
					Notification.requestPermission(function(perm) {
						if (perm === 'denied'){
							return false;
						}
						else{
							return true;
						}

					});
				}
				else if (Notification.permission === 'granted') {
					return true;
				}
			}
		}, 	
		show : function(){
			var instance = this;
			if(this.browserhaspermission()){
				var title = this.instance.options.title;
				var text = this.instance.options.text;
				var imagesrc = this.instance.options.imagesrc;
				var icon = this.instance.options.icon;
				this.notifacation = new Notification(title, {
						body: text,
						icon: imagesrc,
						badge: imagesrc,
						requireInteraction: true,
						ondisplay : function (){
							if ($.isFunction(this.instance.options.ondesktopnotify)) {				
								this.instance.options.ondesktopnotify.call(this);
							}
						},
						onclick : function (){
							if ($.isFunction(this.instance.options.onclick)) {
								this.instance.options.ondesktopnotify.call(this);
							}
						}
					});

				if (!$.isFunction(this.instance.options.ondismiss)) {
					setTimeout(function(){
						
					}, this.instance.options.timeout);
				}
			}
			
		},
		dismiss : function(){
			this.notifacation.close();
		}
	},

	appnotifacation : {
		build : function(instance){
			this.instance = instance;
			this.options = this.instance.options;
			var existingtoasts = $(instance.element).find('.mdtoast');
			this.toastindex = existingtoasts.length+1;
			this.toastiid = "mdtoast-"+this.toastindex;
			var instance = this;
				this.toast = $('<div />').appendTo('body');
					this.toast.attr('class', 'mdtoast');
					this.toast.attr('id', instance.toastiid);
				this.toastheaderdom = $('<div />').appendTo(instance.toast);
					this.toastheaderdom.attr('class', 'toast-header');
				this.toastbodydom = $('<div />').appendTo(instance.toast);
					this.toastbodydom.attr('class', 'toast-body');
				this.toastmediadom = $('<div />').appendTo(instance.toast);
					instance.toastmediadom.attr('class', 'toast-media');
				this.toastfooterdom = $('<div />').appendTo(instance.toast);
					this.toastfooterdom.attr('class', 'toast-footer');

				this.toastprogressdom = false;

				if (instance.options.closewith == 'timeout') {
					this.toastprogressdom = $('<div />').appendTo(instance.toast);
					this.toastprogressdom.attr('class', 'progress');
					this.toastprogressbardom = $('<div />').appendTo(instance.toastprogressdom);
					this.toastprogressbardom.attr('class', 'determinate');
					Vel(instance.toastprogressbardom, {width: '100%', opacity: 1 }, {duration: 20,
					easing: 'easeInOutElastic',
					queue: false});
				}

				if (instance.options.class != false) {
					this.toast.addClass(instance.options.class);
				}

				if (this.instance.title != false) {
					this.toastheaderdom.html('<i class="material-icons spaced-text">'+instance.options.icon+'</i> <span class="grey-text">'+instance.options.title+"</span>");
				}
				if (instance.options.text != false) {
					this.toastbodydom.html(instance.options.text);
				}

				if (instance.options.footnote != false) {
					this.toastfooterdom.html(instance.options.footnote);
				}
				

				if (instance.options.imagesrc == false) {
					this.toastmediadom.html(instance.options.icon);
				}
				else{
					this.toastmediadom.html('<img src="'+instance.options.imagesrc+'"/>');
				}
				
				if (instance.options.type == 'success') {
					this.toastheaderdom.addClass('green-text');
					if (instance.options.imagesrc == false) {
						this.toastmediadom.addClass('green-text');
					}
				}
				if (instance.options.type == 'info') {
					this.toastheaderdom.addClass('blue-text');
					if (instance.options.imagesrc == false) {
						this.toastmediadom.addClass('blue-text');
					}
				}
				if (instance.options.type == 'warning') {
					this.toastheaderdom.addClass('orange-text');
					if (instance.options.imagesrc == false) {
						this.toastmediadom.addClass('orange-text');
					}
				}
				if (instance.options.type == 'error') {
					this.toastheaderdom.addClass('red-text');
					if (this.options.imagesrc == false) {
						this.toastmediadom.addClass('red-text');
					}
				}


				this.position = {};
				this.position.pos = 'top';
				var screenwidth = $(window).width();
				if (screenwidth <= 600) {
					this.position.pos = 'bottom';
				}
				else if (screenwidth >= 601) {
					this.position.pos = 'top';
				}

				instance = this;


			
		},
		show : function(){
			var instance = this;
			this.toast.css({opacity: 0})
				if (this.position.pos == 'top') {
					// Animate toast in
					Vel(instance.toast, {right: 10, opacity: 1}, {duration: 225,
					easing: [0, 0, 0.2, 1 ],
					queue: false});
				}
				else{
					// Animate toast in
					Vel(instance.toast, {right: 10, opacity: 1 }, {duration: 225,
					easing: [0, 0, 0.2, 1 ],
					queue: false});
				}



				if (instance.options.closewith=='timeout') {
					var timeleft = instance.options.timeout;
					var percentColors = [
						{ pct: 0.0, color: { r: 0xff, g: 0x00, b: 0 } },
						{ pct: 0.5, color: { r: 0xff, g: 0xff, b: 0xe0 } },
						{ pct: 1.0, color: { r: 0, g: 0xdd, b: 0xcc } } ];

					var percentagecolor = function(pct) {
						for (var i = 1; i < percentColors.length - 1; i++) {
							if (pct < percentColors[i].pct) {
								break;
							}
						}
						var lower = percentColors[i - 1];
						var upper = percentColors[i];
						var range = upper.pct - lower.pct;
						var rangePct = (pct - lower.pct) / range;
						var pctLower = 1 - rangePct;
						var pctUpper = rangePct;
						var color = {
							r: Math.floor(lower.color.r * pctLower + upper.color.r * pctUpper),
							g: Math.floor(lower.color.g * pctLower + upper.color.g * pctUpper),
							b: Math.floor(lower.color.b * pctLower + upper.color.b * pctUpper)
						};
						var red = Number(color.r).toString(16);
							if (red.length < 2) {
								 red = "0" + red;
							}
						var green = Number(color.g).toString(16);
							if (green.length < 2) {
								 green = "0" + green;
							}
						var blue = Number(color.b).toString(16);
							if (blue.length < 2) {
								 blue = "0" + blue;
							}
						return '#' + red + green + blue;
					}
					




					var counterInterval = setInterval (function(){							
						timeleft = timeleft-20;
						var lefttototaltimeratio = timeleft/instance.options.timeout;
						var timeleftperc = lefttototaltimeratio*100;
							timeleftperc = timeleftperc.toFixed(2);

						var progressbarbgcolor = percentagecolor(lefttototaltimeratio);
						instance.toastprogressbardom.css({"background": progressbarbgcolor});
						Vel(instance.toastprogressbardom, {"width": timeleftperc+'%'}, {duration: 20,
						easing: [0, 0, 0.2, 1 ],
						queue: false
						});
						if (timeleft <= 0) {
							instance.dismiss();
							window.clearInterval(counterInterval);
						}
					}, 20);
				}
				else if (instance.options.closewith=='click') {
					instance.toast.click(function(e){
						instance.dismiss();
					});
				}
				
				if ($.isFunction(instance.options.onshow)) {
					instance.options.onshow.call(this, instance.toast);
				}
			if ($.isFunction(instance.options.oninappnotify)) {
				instance.options.oninappnotify.call(this);
			}

		},
		dismiss : function(){
			var instance = this;
			if (instance.position.pos == 'top') {
					// Animate toast out
					Vel(instance.toast, {"opacity": 0, marginRight: '-50px'}, { duration: 195,
						easing: [0.4, 0, 0.2, 1 ],
						queue: false,
						complete: function(){
						instance.toast.remove();
						}
					});
				}
				else{
					// Animate toast out
					Vel(instance.toast, {"opacity": 0, marginBottom: '-40px'}, { duration: 195,
						easing: [0.4, 0, 0.2, 1 ],
						queue: false,
						complete: function(){
						instance.toast.remove();
						}
					});
				}

				if ($.isFunction(instance.options.onclose)) {
					instance.options.onclose.call(this, instance.toast);
				}
		}
	}
	});

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.notify = function(options){
		new Notify($("body"), options);
	}
	$.fn.notify = function(options) { 	
		new Notify(this, options);
	};

}(jQuery, window, document));



//Delauney background
;(function($, window, document, undefined) {
	var EPSILON = 1.0 / 1048576.0;
	var Delaunay = {
			supertriangle : function(vertices) {
			var xmin = Number.POSITIVE_INFINITY,
					ymin = Number.POSITIVE_INFINITY,
					xmax = Number.NEGATIVE_INFINITY,
					ymax = Number.NEGATIVE_INFINITY,
					i, dx, dy, dmax, xmid, ymid;

			for(i = vertices.length; i--; ) {
				if(vertices[i][0] < xmin) xmin = vertices[i][0];
				if(vertices[i][0] > xmax) xmax = vertices[i][0];
				if(vertices[i][1] < ymin) ymin = vertices[i][1];
				if(vertices[i][1] > ymax) ymax = vertices[i][1];
			}

			dx = xmax - xmin;
			dy = ymax - ymin;
			dmax = Math.max(dx, dy);
			xmid = xmin + dx * 0.5;
			ymid = ymin + dy * 0.5;

			return [
				[xmid - 20 * dmax, ymid -      dmax],
				[xmid            , ymid + 20 * dmax],
				[xmid + 20 * dmax, ymid -      dmax]
			];
		},

		circumcircle : function(vertices, i, j, k) {
			var x1 = vertices[i][0],
					y1 = vertices[i][1],
					x2 = vertices[j][0],
					y2 = vertices[j][1],
					x3 = vertices[k][0],
					y3 = vertices[k][1],
					fabsy1y2 = Math.abs(y1 - y2),
					fabsy2y3 = Math.abs(y2 - y3),
					xc, yc, m1, m2, mx1, mx2, my1, my2, dx, dy;

			/* Check for coincident points */
			if(fabsy1y2 < EPSILON && fabsy2y3 < EPSILON)
				throw new Error("Eek! Coincident points!");

			if(fabsy1y2 < EPSILON) {
				m2  = -((x3 - x2) / (y3 - y2));
				mx2 = (x2 + x3) / 2.0;
				my2 = (y2 + y3) / 2.0;
				xc  = (x2 + x1) / 2.0;
				yc  = m2 * (xc - mx2) + my2;
			}

			else if(fabsy2y3 < EPSILON) {
				m1  = -((x2 - x1) / (y2 - y1));
				mx1 = (x1 + x2) / 2.0;
				my1 = (y1 + y2) / 2.0;
				xc  = (x3 + x2) / 2.0;
				yc  = m1 * (xc - mx1) + my1;
			}

			else {
				m1  = -((x2 - x1) / (y2 - y1));
				m2  = -((x3 - x2) / (y3 - y2));
				mx1 = (x1 + x2) / 2.0;
				mx2 = (x2 + x3) / 2.0;
				my1 = (y1 + y2) / 2.0;
				my2 = (y2 + y3) / 2.0;
				xc  = (m1 * mx1 - m2 * mx2 + my2 - my1) / (m1 - m2);
				yc  = (fabsy1y2 > fabsy2y3) ?
					m1 * (xc - mx1) + my1 :
					m2 * (xc - mx2) + my2;
			}

			dx = x2 - xc;
			dy = y2 - yc;
			return {i: i, j: j, k: k, x: xc, y: yc, r: dx * dx + dy * dy};
		},

		dedup : function(edges) {
			var i, j, a, b, m, n;
			for(j = edges.length; j; ) {
				b = edges[--j];
				a = edges[--j];

				for(i = j; i; ) {
					n = edges[--i];
					m = edges[--i];

					if((a === m && b === n) || (a === n && b === m)) {
						edges.splice(j, 2);
						edges.splice(i, 2);
						break;
					}
				}
			}
			return edges;
		},

		triangulate: function(vertices, key) {
			var n = vertices.length, i, j, indices, st, open, closed, edges, dx, dy, a, b, c;

			/* Bail if there aren't enough vertices to form any triangles. */
			if(n < 3){			
				return [];
			}

			/* Slice out the actual vertices from the passed objects. (Duplicate the
			 * array even if we don't, though, since we need to make a supertriangle
			 * later on!) */
			vertices = vertices.slice(0);

			if(key){
				for(i = n; i--; ){
					vertices[i] = vertices[i][key];
				}
			}

			/* Make an array of indices into the vertex array, sorted by the
			 * vertices' x-position. */
			indices = new Array(n);

			for(i = n; i--; ){
				indices[i] = i;
			}

			indices.sort(function(i, j) {
				return vertices[j][0] - vertices[i][0];
			});

			/* Next, find the vertices of the supertriangle (which contains all other
			 * triangles), and append them onto the end of a (copy of) the vertex
			 * array. */
			st = this.supertriangle(vertices);
			vertices.push(st[0], st[1], st[2]);
			
			/* Initialize the open list (containing the supertriangle and nothing
			 * else) and the closed list (which is empty since we havn't processed
			 * any triangles yet). */
			open   = [this.circumcircle(vertices, n + 0, n + 1, n + 2)];
			closed = [];
			edges  = [];

			/* Incrementally add each vertex to the mesh. */
			for(i = indices.length; i--; edges.length = 0) {
				c = indices[i];

				/* For each open triangle, check to see if the current point is
				 * inside it's circumcircle. If it is, remove the triangle and add
				 * it's edges to an edge list. */
				for(j = open.length; j--; ) {
					/* If this point is to the right of this triangle's circumcircle,
					 * then this triangle should never get checked again. Remove it
					 * from the open list, add it to the closed list, and skip. */
					dx = vertices[c][0] - open[j].x;
					if(dx > 0.0 && dx * dx > open[j].r) {
					closed.push(open[j]);
					open.splice(j, 1);
					continue;
					}

					/* If we're outside the circumcircle, skip this triangle. */
					dy = vertices[c][1] - open[j].y;
					if(dx * dx + dy * dy - open[j].r > EPSILON){
						continue;
					}
					

					/* Remove the triangle and add it's edges to the edge list. */
					edges.push(
							open[j].i, open[j].j,
							open[j].j, open[j].k,
							open[j].k, open[j].i
						);
					open.splice(j, 1);
				}

				/* Remove any doubled edges. */
				edges = this.dedup(edges);

				/* Add a new triangle for each edge. */
				for(j = edges.length; j; ) {
					b = edges[--j];
					a = edges[--j];
					open.push(this.circumcircle(vertices, a, b, c));
				}
			}

			/* Copy any remaining open triangles to the closed list, and then
			 * remove any triangles that share a vertex with the supertriangle,
			 * building a list of triplets that represent triangles. */
			for(i = open.length; i--; )
				closed.push(open[i]);
			open.length = 0;

			for(i = closed.length; i--; )
				if(closed[i].i < n && closed[i].j < n && closed[i].k < n)
					open.push(closed[i].i, closed[i].j, closed[i].k);

			/* Yay, we're done! */
			return open;
		},
		contains: function(tri, p) {
			/* Bounding box test first, for quick rejections. */
			if((p[0] < tri[0][0] && p[0] < tri[1][0] && p[0] < tri[2][0]) ||
				 (p[0] > tri[0][0] && p[0] > tri[1][0] && p[0] > tri[2][0]) ||
				 (p[1] < tri[0][1] && p[1] < tri[1][1] && p[1] < tri[2][1]) ||
				 (p[1] > tri[0][1] && p[1] > tri[1][1] && p[1] > tri[2][1]))
				return null;

			var a = tri[1][0] - tri[0][0],
					b = tri[2][0] - tri[0][0],
					c = tri[1][1] - tri[0][1],
					d = tri[2][1] - tri[0][1],
					i = a * d - b * c;

			/* Degenerate tri. */
			if(i === 0.0){
				return null;
			}

			var u = (d * (p[0] - tri[0][0]) - b * (p[1] - tri[0][1])) / i,
				v = (a * (p[1] - tri[0][1]) - c * (p[0] - tri[0][0])) / i;

			/* If we're outside the tri, fail. */
			if(u < 0.0 || v < 0.0 || (u + v) > 1.0){
				return null;
			}

			return [u, v];
		},
		hextorgb : function(hex) {
			// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
			var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
			hex = hex.replace(shorthandRegex, function(m, r, g, b) {
				return r + r + g + g + b + b;
			});
			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
			return result ? parseInt(result[1], 16)+','+parseInt(result[2], 16)+','+parseInt(result[3], 16) : "0,0,0";
		},
		rgbtohex : function(r, g, b) {
			var hexr = Number(r).toString(16);
			var hexg = Number(g).toString(16);
			var hexb = Number(b).toString(16);
			if (hexr.length < 2) {
				hexr = "0" + hexr;
			}
			if (hexg.length < 2) {
				hexg = "0" + hexg;
			}
			if (hexb.length < 2) {
				hexb = "0" + hexb;
			}
			return "#" + hexr + hexg + hexb;
		},
		darken : function(color, amt) {
			amt = amt*16;
			color = this.hextorgb(color);
			color = color.split(",");
			

			var r = Math.round(parseInt(color[0]) - amt);
			if ( r > 255 ) r = 255;
			else if(r < 0) r = 0;

			var g = Math.round(parseInt(color[1]) - amt);
			if ( g > 255 ) g = 255;
			else if( g < 0 ) g = 0;

			var b = Math.round(parseInt(color[2]) - amt);

			if ( b > 255 ) b = 255;
			else if(b < 0) b = 0;

			return this.rgbtohex(r, g, b);

		},
		lighten : function(color, amt) {
			amt = amt*16;
			color = this.hextorgb(color);
			color = color.split(",");
			

			var r = Math.round(parseInt(color[0]) + amt);
			if ( r > 255 ) r = 255;
			else if(r < 0) r = 0;

			var g = Math.round(parseInt(color[1]) + amt);
			if ( g > 255 ) g = 255;
			else if( g < 0 ) g = 0;

			var b = Math.round(parseInt(color[2]) + amt);

			if ( b > 255 ) b = 255;
			else if(b < 0) b = 0;

			return this.rgbtohex(r, g, b);

		},
		intercept : function(a, b, intercept){
			var usePound = false;
			if (typeof intercept == "undefined") {
				intercept = 0.5;
			}
			if (a.startsWith("#")) {
				a = this.hextorgb(a);
				usePound = true;
			}
			if (b.startsWith("#")) {
				b = this.hextorgb(b);
				usePound = true;
			}
			if (a == null) {}
			a = a.split(",");
			b = b.split(",");
			for (var i = 0; i < a.length; i++) {
				a[i] = parseInt(a[i]);
				b[i] = parseInt(b[i]);
			}
			var c = new Array(3);
			c[0] = Math.round(a[0]+((b[0] - a[0])*intercept));
			c[1] = Math.round(a[1]+((b[1] - a[1])*intercept));
			c[2] = Math.round(a[2]+((b[2] - a[2])*intercept));

			
			var result = c[0]+','+c[1]+','+c[2];
			if(usePound) {
				result = this.rgbtohex(c[0],c[1],c[2]);
			}
			return result;
		}
	};



	var defaults = {
		count : 50,
		colors :[primaryColor, primaryDarkColor],
		mouselight:true,
		mouselightcolor:accentColor,
		mouselightradius : 0.3,
		adjustonresize : false,
		variance : 2,
		pattern : "diagonal",
		direction : "normal",
		zIndex : 0,
		ongenerate:null
	};

	// The actual plugin constructor
	function Delauneybg(element, options) {
		if (!element) {
			this.element = $('body');
		}
		else{
			this.element = $(element);
		}
		this.options = $.extend({}, defaults, options);
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(Delauneybg.prototype, {		
		init: function() {
			this.vertices = [];
			this.triangles = [];
			this.uid = Materialize.guid();			
			this.build();
			this.plane();
		},
		build: function() {
			this.width = this.element.outerWidth();
			this.height = this.element.outerHeight();
			this.colors = [];
			if (typeof(this.options.colors) != "object") {
				this.colors[0] = this.options.colors;
			}
			else{
				this.colors[0] = this.options.colors[0];
			}
			
			this.mouse = {x:null,y:null}

			var noofcoloroptions = this.options.colors.length;
			for (var i = 1; i < noofcoloroptions; i++) {				
				var colorposition = Math.floor(i/(noofcoloroptions-1)*10);
				var noofcolors = this.colors.length;
				if (colorposition > noofcolors) {
					var nextindex = noofcolors;
					var lastindex = colorposition;
					for (var j = nextindex; j < lastindex; j++) {
						var percentile = (j-1)/lastindex;
						var percentilecolor = Delaunay.intercept(this.colors[j-1], this.options.colors[i], percentile);
						if (percentilecolor == "#000000") {
							percentilecolor = Delaunay.lighten(percentilecolor, Math.random());
						}
						else{
							percentilecolor = Delaunay.darken(percentilecolor, Math.random());
						}
						this.colors.push(percentilecolor);
					}
				}
			}
			
			this.initevents();
		},
		initevents : function(){
			var instance = this;
			//window size change, so canvas doesn't deform
			window.addEventListener("resize", this, false);
			window.addEventListener("mousemove", this, false);
			this.handleEvent = function(e) {
				switch(e.type) {
					case "resize":
						instance.rebuild();
						instance.svg.remove();
						instance.plane();
					break;
					case "mousemove":
						var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
						var scrollLeft = document.body.scrollLeft || document.documentElement.scrollLeft;
						this.mouse.x = e.clientX - this.element.offset().left + scrollLeft;
						this.mouse.y = e.clientY - this.element.offset().top + scrollTop;
						this.renderlight();
						
					break;
				}
			};
			
		},

		rebuild: function(){			
			this.width = this.element.outerWidth();
			this.height = this.element.outerHeight();
			this.svg.setAttributeNS(null, 'viewBox', '0 0 ' + this.width + ' ' + this.height);
		},

		plane: function() {
			if (typeof(this.svg)) {}
			
			// Cache Variables
			var x, y, vertices = new Array(this.options.count);



			for(i = vertices.length; i--;) {
				x =  Math.random()*this.width;
				y =  Math.random()*this.height;

				vertices[i] = [x, y];
			}

			// Generate additional points on the perimeter so that there are no holes in the pattern
			vertices.push([0, 0]);
			vertices.push([this.width/2, 0]);
			vertices.push([this.width, 0]);
			vertices.push([this.width, this.height/2]);
			vertices.push([this.width, this.height]);
			vertices.push([this.width/2, this.height]);
			vertices.push([0, this.height]);
			vertices.push([0, this.height/2]);

			this.triangles = [];

			// Create an array of triangulated coordinates from our vertices
			var triangles = Delaunay.triangulate(vertices);

			for(i = triangles.length; i; ) {
				--i;
				var p1 = [Math.ceil(vertices[triangles[i]][0]), Math.ceil(vertices[triangles[i]][1])];
				--i;
				var p2 = [Math.ceil(vertices[triangles[i]][0]), Math.ceil(vertices[triangles[i]][1])];
				--i;
				var p3 = [Math.ceil(vertices[triangles[i]][0]), Math.ceil(vertices[triangles[i]][1])];

				var triangle = [[p1[0], p1[1]], [p2[0], p2[1]], [p3[0], p3[1]]];
				
				this.triangles.push(triangle);
			}
			this.triangles.sort(function(a, b){
				var apointx = (a[0][0]+a[1][0]+a[2][0])/3;
				var apointy = (a[0][1]+a[1][1]+a[2][1])/3;
				var bpointx = (b[0][0]+b[1][0]+b[2][0])/3;
				var bpointy = (b[0][1]+b[1][1]+b[2][1])/3;
				var adiagonal = Math.sqrt(Math.pow(apointx, 2) + Math.pow(apointy, 2));
				var bdiagonal = Math.sqrt(Math.pow(bpointx, 2) + Math.pow(bpointy, 2));
				var meshdiagonal = Math.sqrt(Math.pow(this.width, 2) + Math.pow(this.width, 2));

				var aposition = adiagonal/meshdiagonal;
				var bposition = bdiagonal/meshdiagonal;
				return aposition - bposition;
			});
			this.render();
		},
		render : function(){			
			this.svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
			var svgNS = this.svg.namespaceURI;
			this.svg.setAttributeNS(null, 'viewBox', '0 0 ' + this.width + ' ' + this.height);
			this.svg.setAttributeNS(null, 'id', this.uid);
			
			this.svg.style.position="absolute";
			this.svg.style.top="0";
			this.svg.style.left="0";
			this.svg.style.zIndex=this.options.zIndex;
			var elem = this.element;
			$(elem).append(this.svg);
			for (var i = 0; i < this.triangles.length; i++) {
				this.polygon(this.triangles[i]);
			}
			if ($.isFunction(this.options.ongenerate)) {
					this.options.ongenerate.call(this.element);
			}
		},
		renderlight : function(){
			
		},
		polygon : function(points){
			var polygoncolor = this.polygoncolor(points);
			var polygon = document.createElementNS("http://www.w3.org/2000/svg", "polygon");

			polygon.style.stroke = polygoncolor;
			polygon.style.fill = polygoncolor;
			polygon.setAttributeNS(null, 'stroke-miterlimit', '1');
			polygon.setAttributeNS(null, 'stroke-width', '1');
			this.svg.appendChild(polygon);
			for (var value of points) {
				var point = this.svg.createSVGPoint();
				point.x = value[0];
				point.y = value[1];
				polygon.points.appendItem(point);
			}

		},
		polygoncolor : function(points){
			var averagepointx = (points[0][0]+points[1][0]+points[2][0])/3;
			var averagepointy = (points[0][1]+points[1][1]+points[2][1])/3;

			var averageposition = ((averagepointx/this.width)+(averagepointy/this.height))/2;
			var colorposition = Math.floor(averageposition*10);

			var interceptpercentage = averageposition;
			if (colorposition == 0) {
				colorposition = 1;
			}
			var color = Materialize.colors.intercept(this.colors[colorposition], this.colors[colorposition-1], Math.random());

			color = Materialize.colors.darken(color, Math.random());
			
			return color;
			
		}


	});




	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn.delauneybg = function(options) {
		return this.each(function() {
			if (!$.data(this, "plugin_delauneybg") ) {
				$.data( this, "plugin_delauneybg", new Delauneybg(this, options));
			}
		});
	};

	$(document).ready(function(){
		$(".delauneybg").delauneybg();
	});




}(jQuery, window, document));






//User Interface Utilities
;(function($, window, document) {


}(jQuery, window, document));