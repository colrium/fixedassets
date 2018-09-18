// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
  alert('Material Icon picker requires jquery');
}
else{


	$.widget( "collinslibstime.timepicker", {
		    options: {
		    	zindex : 10,
		        formats	: [12, 24],
		        periods : ["am", "pm"],
		        aux_periods : ["morning", "noon", "afternoon", "evening"],
		        format : 12,
		        defaulttime: "12:00:00",
		        showseconds: false
		    },
		    NAMESPACE: 'timepicker',
		    CLASSES:{
		    	CLASS_INLINE : "-inline",
				CLASS_DROPDOWN : "-dropdown",
				CLASS_TOP_LEFT : "-top-left",
				CLASS_TOP_RIGHT : "-top-right",
				CLASS_BOTTOM_LEFT : "-bottom-left",
				CLASS_BOTTOM_RIGHT : "-bottom-right",
				CLASS_HIDE : '-hide'
		    },

		    _create: function() {
				this.$window = $(window);
				this.document = window.document;
				this.$document = $(document);
		    	this.createTimePicker();
		    	this.elementoffsettop = this.element.offset().top;
		    	this.windowheight = this.$window.height();
		    	
			},

			createTimePicker: function(){
				this.isshowing = false;
				if (this.element.is('input[type="text"]')) {
					if (this.element.val() != '') {
						this.options.selectedicon = this.element.val();
					}
				}
				this.isshowing = false;
				this.pickerwidth = this.element.width();
				this.othertimepickers = $('body').find('.tp-wrapper');
				this.tpid = this.othertimepickers.length + 1;
		        
		        this._createtimepickerelements();




			},

			_createtimepickerelements: function(){				

				

				this.tpcontainer = $('<div />', {
					class: this.NAMESPACE+'-container', 
					id: this.NAMESPACE+'-container-'+this.tpid
				});

				this.tpdropdown = $('<div />', {
					class: this.NAMESPACE+'-dropdown', 
					id: this.NAMESPACE+'-dropdown-'+this.tpid
				});

				this.pickerclass = this.NAMESPACE+''+this.CLASSES.CLASS_BOTTOM_LEFT;

				this.tpcontainer.addClass(this.pickerclass);

				this.tpinputswrapper = $('<div />', {
					class: 'row '+this.NAMESPACE+'-inputs-wrapper padded', 
					id: 'tp-inputs-wrapper-'+this.tpid
				});

				this.tphiwrapper = $('<div />', {
					class: 'input-field col s6'
				});
				this.tphourinputlabel = $('<label />', {
					for: this.NAMESPACE+'-h-input-'+this.tpid, 
					html: 'Hour'
				});
				this.tphourinput = $('<input />', {
					type: 'number', 
					class: 'validate',
					name: this.NAMESPACE+'-h-input-'+this.tpid,
					id: this.NAMESPACE+'-h-input-'+this.tpid
				});


				this.tpmiwrapper = $('<div />', {
					class: 'input-field col s6'
				});
				this.tpmininputlabel = $('<label />', {
					for: this.NAMESPACE+'-m-input-'+this.tpid, 
					html: 'Min'
				});
				this.tpmininput = $('<input />', {
					type: 'number', 
					class: 'validate',
					name: this.NAMESPACE+'-m-input-'+this.tpid,
					id: this.NAMESPACE+'-m-input-'+this.tpid
				});



				this.tpsiwrapper = $('<div />', {
					class: 'input-field col s4'
				});
				this.tpsecinputlabel = $('<label />', {
					for: this.NAMESPACE+'-s-input-'+this.tpid, 
					html: 'Sec'
				});
				this.tpsecinput = $('<input />', {
					type: 'number', 
					class: 'validate',
					name: this.NAMESPACE+'-s-input-'+this.tpid,
					id: this.NAMESPACE+'-s-input-'+this.tpid
				});

				if (this.options.showseconds == true) {
					this.tphiwrapper.removeClass('col s6');
					this.tphiwrapper.addClass('col s4');
					this.tpmiwrapper.removeClass('col s6');
					this.tpmiwrapper.addClass('col s4');

					//append elements
					this.tphiwrapper.append(this.tphourinputlabel);
					this.tphiwrapper.append(this.tphourinput);

					this.tpmiwrapper.append(this.tpmininputlabel);
					this.tpmiwrapper.append(this.tpmininput);

					this.tpsiwrapper.append(this.tpsecinputlabel);
					this.tpsiwrapper.append(this.tpsecinput);

					//append to tpi wrapper
					this.tpinputswrapper.append(this.tphiwrapper);
					this.tpinputswrapper.append(this.tpmiwrapper);
					this.tpinputswrapper.append(this.tpsiwrapper);


					//append to tp wrapper
					this.tpdropdown.append(this.tpinputswrapper);
				}
				else{

					//append elements
					this.tphiwrapper.append(this.tphourinputlabel);
					this.tphiwrapper.append(this.tphourinput);

					this.tpmiwrapper.append(this.tpmininputlabel);
					this.tpmiwrapper.append(this.tpmininput);

					//append to tpi wrapper
					this.tpinputswrapper.append(this.tphiwrapper);
					this.tpinputswrapper.append(this.tpmiwrapper);

					//append to tp wrapper
					this.tpdropdown.append(this.tpinputswrapper);

				}

				
				this.tpcontainer.append(this.tpdropdown);
				this.tpcontainer.insertAfter(this.element);
				this.placepicker();
			},

			placepicker:function(){
				this.picker = this.$document.find('#'+this.NAMESPACE+'-container-'+this.tpid);
				console.log(this.picker.outerHeight());
			},

			showPicker: function(picker) {
		    	$(picker).animate({
				    width: this.pickerwidth,
				    height: "530px"
				}, 250, "easeInElastic", function() {});
		    	this.isshowing = true;
		    },

		    hidePicker: function(picker) {
		    	$(picker).animate({
				    width: 0,
				    height: 0
				}, 250, "easeOutElastic", function() {});
				this.isshowing = false;
		    }




	});




}