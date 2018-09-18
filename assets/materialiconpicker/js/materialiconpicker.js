// Check for jQuery.
if (typeof(jQuery) === 'undefined') {
  alert('Material Icon picker requires jquery');
}
else{


		$.widget( "collinslibs.materialiconpicker", {
			options: {
				template	: '<div class="row mip-header rounded-top-5px"><div class="col s12 padded"><h4 class="full-width center-align mip-title"> </h4></div></div><div class="row mip-body"><div class="row"><div class="input-field col s12 mip-search-input-wrapper"><input type="text" class="validate mip-search-input"><label for="mip-search1"><i class="material-icons spaced-text">search</i> Search Icon</label></div><div class="input-field col s12 mip-select-wrapper"><select class="full-width mip-cat-select" name=""></select></div></div><div class="row"><div class="col s12 mip-icons-wrapper"></div></div></div><div class="row mip-footer"><div class="mip-pages"></div><div class="mip-icon-info"></div></div>',

				icons : {
						'Actions' : ["3d_rotation", "accessibility", "accessible", "account_balance", "account_balance_wallet", "account_box", "account_circle", "add_shopping_cart", "alarm", "alarm_add", "alarm_off", "alarm_on", "all_out", "android", "announcement", "aspect_ratio", "assessment", "assignment", "assignment_ind", "assignment_late", "assignment_return", "assignment_returned", "assignment_turned_in", "autorenew", "backup", "book", "bookmark", "bookmark_border", "bug_report", "build", "cached", "camera_enhance", "card_giftcard", "card_membership", "card_travel", "change_history", "check_circle", "chrome_reader_mode", "class", "code", "compare_arrows", "copyright", "credit_card", "dashboard", "date_range", "delete", "delete_forever", "description", "dns", "done", "done_all", "donut_large", "donut_small", "eject", "euro_symbol", "event", "event_seat", "exit_to_app", "explore", "extension", "face", "favorite", "favorite_border", "feedback", "find_in_page", "find_replace", "fingerprint", "flight_land", "flight_takeoff", "flip_to_back", "flip_to_front", "g_translate", "gavel", "get_app", "gif", "grade", "group_work", "help", "help_outline", "highlight_off", "history", "home", "hourglass_empty", "hourglass_full", "http", "https", "important_devices", "info", "info_outline", "input", "invert_colors", "label", "label_outline", "language", "launch", "lightbulb_outline", "line_style", "line_weight", "list", "lock", "lock_open", "lock_outline", "loyalty", "markunread_mailbox", "motorcycle", "note_add", "offline_pin", "opacity", "open_in_browser", "open_in_new", "open_with", "pageview", "pan_tool", "payment", "perm_camera_mic", "perm_contact_calendar", "perm_data_setting", "perm_device_information", "perm_identity", "perm_media", "perm_phone_msg", "perm_scan_wifi", "pets", "picture_in_picture", "picture_in_picture_alt", "play_for_work", "polymer", "power_settings_new", "pregnant_woman", "print", "query_builder", "question_answer", "receipt", "record_voice_over", "redeem", "remove_shopping_cart", "reorder", "report_problem", "restore", "restore_page", "room", "rounded_corner", "rowing", "schedule", "search", "settings", "settings_applications", "settings_backup_restore", "settings_bluetooth", "settings_brightness", "settings_cell", "settings_ethernet", "settings_input_antenna", "settings_input_component", "settings_input_composite", "settings_input_hdmi", "settings_input_svideo", "settings_overscan", "settings_phone", "settings_power", "settings_remote", "settings_voice", "shop", "shop_two", "shopping_basket", "shopping_cart", "speaker_notes", "speaker_notes_off", "spellcheck", "stars", "store", "subject", "supervisor_account", "swap_horiz", "swap_vert", "swap_vertical_circle", "system_update_alt", "tab", "tab_unselected", "theaters", "thumb_down", "thumb_up", "thumbs_up_down", "timeline", "toc", "today", "toll", "touch_app", "track_changes", "translate", "trending_down", "trending_flat", "trending_up", "turned_in", "turned_in_not", "update", "verified_user", "view_agenda", "view_array", "view_carousel", "view_column", "view_day", "view_headline", "view_list", "view_module", "view_quilt", "view_stream", "view_week", "visibility", "visibility_off", "watch_later", "work", "youtube_searched_for", "zoom_in", "zoom_out"],

						'Alert' : ["add_alert", "error", "error_outline", "warning"],

						'AV' : ["add_to_queue", "airplay", "album", "art_track", "av_timer", "branding_watermark", "call_to_action", "closed_caption", "equalizer", "explicit", "fast_forward", "fast_rewind", "featured_play_list", "featured_video", "fiber_dvr", "fiber_manual_record", "fiber_new", "fiber_pin", "fiber_smart_record", "forward_10", "forward_30", "forward_5", "games", "hd", "hearing", "high_quality", "library_add", "library_books", "library_music", "loop", "mic", "mic_none", "mic_off", "movie", "music_video", "new_releases",  "note", "pause", "pause_circle_filled", "pause_circle_outline", "play_arrow", "play_circle_filled", "play_circle_outline", "playlist_add", "playlist_add_check", "playlist_play", "queue", "queue_music", "queue_play_next", "radio", "recent_actors", "remove_from_queue", "repeat", "repeat_one", "replay_10", "replay", "replay_30", "replay_5", "shuffle", "skip_next", "skip_previous", "slow_motion_video", "snooze", "sort_by_alpha", "stop", "subscriptions", "subtitles", "surround_sound", "video_call", "video_label", "video_library", "videocam", "videocam_off", "volume_down", "volume_mute", "volume_off", "volume_up", "web", "web_asset"],

						'Communication' : ["business", "call", "call_end", "call_made", "call_merge", "call_missed", "call_missed_outgoing", "call_received", "call_split", "chat", "chat_bubble", "chat_bubble_outline", "clear_all", "comment", "contact_mail", "contact_phone", "contacts", "dialer_sip", "dialpad", "email", "forum", "import_contactsl", "import_export", "invert_colors_off", "live_help", "location_off", "location_on", "mail_outline", "message", "no_sim", "phone", "phonelink_erase", "phonelink_lock", "phonelink_ring", "phonelink_setup", "portable_wifi_off", "present_to_all", "ring_volume", "rss_feed", "screen_share", "speaker_phone", "stay_current_landscape", "stay_current_portrait", "stay_primary_landscape", "stay_primary_portrait", "stop_screen_share", "swap_calls", "textsms", "voicemail", "vpn_key"],

						'Content' : ["add", "add_box", "add_circle", "add_circle_outline", "archive", "backspace", "block", "clear", "content_copy", "content_cut", "content_paste", "create", "delete_sweep", "drafts", "filter_list", "flag", "font_download", "forward", "gesture", "inbox", "link", "low_priority", "mail", "markunread", "move_to_inbox", "next_week", "redo", "remove", "remove_circle", "remove_circle_outline", "reply", "reply_all", "report", "save", "select_all", "send", "sort", "text_format", "unarchive", "undo", "weekend"],

						'Device' : ["airplanemode_on", "battery_alert", "battery_charging_full", "battery_full", "battery_std", "battery_unknown", "bluetooth", "bluetooth_connected", "bluetooth_disabled", "bluetooth_searching", "brightness_auto", "brightness_high", "brightness_low", "brightness_medium", "data_usage", "developer_mode", "devices", "dvr", "gps_fixed", "gps_not_fixed", "gps_off", "location_disabled", "location_searching", "multitrack_audio", "network_cell", "network_wifi", "nfc", "now_wallpaper", "now_widgets", "screen_lock_landscape", "screen_lock_portrait", "screen_lock_rotation", "screen_rotation", "sd_storage", "settings_system_daydream", "storage", "usb", "wifi_lock", "wifi_tethering", "access_alarm", "access_alarm", "access_time", "add_alarm", "airplanemode_off", "wifi_tethering"],

						'Editor' : ["attach_file", "attach_money", "border_all", "border_bottom", "border_clear", "border_color", "border_horizontal", "border_inner", "border_left", "border_outer", "border_right", "border_style", "border_top", "border_vertical", "bubble_chart", "drag_handle", "format_align_center", "format_align_justify", "format_align_left", "format_align_right", "format_bold", "format_clear", "format_color_fill", "format_color_reset", "format_color_text", "format_indent_decrease", "format_indent_increase", "format_italic", "format_line_spacing", "format_list_bulleted", "format_list_numbered", "format_paint", "format_quote", "format_shapes", "format_size", "format_strikethrough", "format_textdirection_l_to_r", "format_textdirection_r_to_l", "format_underlined", "functions", "highlight", "insert_chart", "insert_comment", "insert_drive_file", "insert_emoticon", "insert_invitation", "insert_link", "insert_photo", "linear_scale", "merge_type", "mode_comment", "mode_edit", "monetization_on", "money_off", "multiline_chart", "pie_chart", "pie_chart_outlined", "publish", "short_text", "show_chart", "space_bar", "strikethrough_s", "text_fields", "title", "vertical_align_bottom", "vertical_align_center", "vertical_align_top", "wrap_text"],

						'File' : ["attachment", "cloud", "cloud_circle", "cloud_done", "cloud_download", "cloud_off", "cloud_queue", "cloud_upload", "create_new_folder", "file_download", "file_upload", "folder", "folder_open", "folder_shared"],

						'Hardware' : ["cast", "cast_connected", "computer", "desktop_mac", "desktop_windows", "developer_board", "device_hub", "devices_other", "dock", "gamepad", "headset", "headset_mic", "keyboard", "keyboard_arrow_down", "keyboard_arrow_left", "keyboard_arrow_right", "keyboard_arrow_up", "keyboard_backspace", "keyboard_capslock", "keyboard_hide", "keyboard_return", "keyboard_tab", "keyboard_voice", "laptop", "laptop_chromebook", "laptop_mac", "laptop_windows", "memory", "mouse", "phone_android", "phone_iphone", "phonelink", "phonelink_off", "power_input", "router", "scanner", "security", "sim_card", "smartphone", "speaker", "speaker_group", "tablet", "tablet_android", "tablet_mac", "toys", "tv", "videogame_asset", "watch"],

						'Image' : ["add_a_photo", "add_to_photos", "adjust", "assistant", "assistant_photo", "audiotrack", "blur_circular", "blur_linear", "blur_off", "blur_on", "brightness_1", "brightness_2", "brightness_3", "brightness_4", "brightness_5", "brightness_6", "brightness_7", "broken_image", "brush", "burst_mode", "camera", "camera_alt", "camera_front", "camera_rear", "camera_roll", "center_focus_strong", "center_focus_weak", "collections", "collections_bookmark", "color_lens", "colorize", "compare", "control_point", "control_point_duplicate", "crop_16_9", "crop", "crop_3_2", "crop_5_4", "crop_7_5", "crop_din", "crop_free", "crop_landscape", "crop_original", "crop_portrait", "crop_rotate", "crop_square", "dehaze", "details", "edit", "exposure", "exposure_neg_1", "exposure_neg_2", "exposure_plus_1", "exposure_plus_2", "exposure_zero", "filter_1", "filter", "filter_2", "filter_3", "filter_4", "filter_5", "filter_6", "filter_7", "filter_8", "filter_9", "filter_9_plus", "filter_b_and_w", "filter_center_focus", "filter_drama", "filter_frames", "filter_hdr", "filter_none", "filter_tilt_shift", "filter_vintage", "flare", "flash_auto", "flash_off", "flash_on", "flip", "gradient", "grain", "grid_off", "grid_on", "hdr_off", "hdr_on", "hdr_strong", "hdr_weak", "healing", "image", "image_aspect_ratio", "iso", "landscape", "leak_add", "leak_remove", "lens", "linked_camera", "looks", "looks_3", "looks_4", "looks_5", "looks_6", "looks_one", "looks_two", "loupe", "monochrome_photos", "movie_creation", "movie_filter", "music_note", "nature", "nature_people", "navigate_before", "navigate_next", "palette", "panorama", "panorama_fish_eye", "panorama_horizontal", "panorama_vertical", "panorama_wide_angle", "photo", "photo_album", "photo_camera", "photo_filter", "photo_library", "photo_size_select_actual", "photo_size_select_large", "photo_size_select_small", "picture_as_pdf", "portrait", "remove_red_eye", "rotate_90_degrees_ccw", "rotate_left", "rotate_right", "slideshow", "straighten", "style", "switch_camera", "switch_video", "tag_faces", "texture", "timelapse", "timer_10", "timer", "timer_3", "timer_off", "tonality", "transform", "tune", "view_comfy", "view_compact", "vignette", "wb_auto", "wb_cloudy", "wb_incandescent", "wb_iridescent", "wb_sunny"],

						'Maps' : ["add_location", "beenhere", "directions", "directions_bike", "directions_boat", "directions_bus", "directions_car", "directions_railway", "directions_run", "directions_subway", "directions_transit", "directions_walk", "edit_location", "ev_station", "flight", "hotel", "layers", "layers_clear", "local_activity", "local_airport", "local_atm", "local_bar", "local_cafe", "local_car_wash", "local_convenience_store", "local_dining", "local_drink", "local_florist", "local_gas_station", "local_grocery_store", "local_hospital", "local_hotel", "local_laundry_service", "local_library", "local_mall", "local_movies", "local_offer", "local_parking", "local_pharmacy", "local_phone", "local_pizza", "local_play", "local_post_office", "local_printshop", "local_see", "local_shipping", "local_taxi", "map", "my_location", "navigation", "near_me", "person_pin", "person_pin_circle", "pin_drop", "place", "rate_review", "restaurant", "restaurant_menu", "satellite", "store_mall_directory", "streetview", "subway", "terrain", "traffic", "train", "tram", "transfer_within_a_station", "zoom_out_map"],

						'Navigation' : ["apps", "arrow_back", "arrow_downward", "arrow_drop_down", "arrow_drop_down_circle", "arrow_drop_up", "arrow_forward", "arrow_upward", "cancel", "check", "chevron_left", "chevron_right", "close", "expand_less", "expand_more", "first_page", "fullscreen", "fullscreen_exit", "last_page", "menu", "more_horiz", "more_vert", "refresh", "subdirectory_arrow_left", "subdirectory_arrow_right", "unfold_less", "unfold_more"],

						'Notifacation' : ["adb", "airline_seat_flat", "airline_seat_flat_angled", "airline_seat_individual_suite", "airline_seat_legroom_extra", "airline_seat_legroom_normal", "airline_seat_legroom_reduced", "airline_seat_recline_extra", "airline_seat_recline_normal", "bluetooth_audio", "confirmation_number", "disc_full", "do_not_disturb", "do_not_disturb_alt", "do_not_disturb_off", "do_not_disturb_on", "drive_eta", "enhanced_encryption", "event_available", "event_busy", "event_note", "folder_special", "live_tv", "mms", "more", "network_check", "network_locked", "no_encryption", "ondemand_video", "personal_video", "phone_bluetooth_speaker", "phone_forwarded", "phone_in_talk", "phone_locked", "phone_missed", "phone_paused", "power", "priority_high", "rv_hookup", "sd_card", "sim_card_alert", "sms", "sms_failed", "sync", "sync_disabled", "sync_problem", "system_update", "tap_and_play", "time_to_leave", "vibration", "voice_chat", "vpn_lock", "wc", "wifi"],

						'Places' : ["ac_unit", "airport_shuttle", "all_inclusive", "beach_access", "business_center", "casino", "child_care", "child_friendly", "fitness_center", "free_breakfast", "golf_course", "hot_tub", "kitchen", "pool", "room_service", "smoke_free", "smoking_rooms", "spa"],

						'Social' : ["cake", "domain", "group", "group_add", "location_city", "mood", "mood_bad", "notifications", "notifications_active", "notifications_none", "notifications_off", "notifications_paused", "pages", "party_mode", "people", "people_outline", "person", "person_add", "person_outline", "plus_one", "poll", "public", "school", "sentiment_dissatisfied", "sentiment_neutral", "sentiment_satisfied", "sentiment_very_dissatisfied", "sentiment_very_satisfied", "share", "whatshot"],

						'Toggle' : ["check_box", "check_box_outline_blank", "indeterminate_check_box", "radio_button_checked", "radio_button_unchecked", "star", "star_border", "star_half"]
					  },
				selectedicon 	: '3d_rotation',
				minwidth: 320
			},

			_create: function() {
				this.createPicker();

			},

			createPicker: function(){
				var instance = this;
				if (this.element.is('input[type="text"]')) {
					if (this.element.val() != '') {
						this.options.selectedicon = this.element.val();
					}
				}
				this.isshowing = false;
				this.pickerwidth = this.element.width();
				var otherpickers = $('body').find('.icon-selector-wrapper');
				instance.pickerid = otherpickers.length + 1;
				this.mipcontainer = $('<div />', {
					class: 'mip-wrapper z-depth-2 white rounded-5px', 
					id: 'mip-wrapper-'+instance.pickerid
				});
				if (instance.element.width() < instance.options.minwidth) {
					this.pickerwidth = instance.options.minwidth;
				}
				else{
					this.pickerwidth = this.element.width();
				}
				
				this._on($(window), {
					resize:function(){
						if (instance.element.width() < instance.options.minwidth) {
							this.pickerwidth = instance.options.minwidth;
						}
						else{
							this.pickerwidth = this.element.width();
						}
						
					}
				});
				if (!this.element.hasClass('material-icons')) {
					this.element.addClass('material-icons');
				}
				this._initializepicker();


			},

			_initializepicker: function() {
				var instance = this;
				this._on(this.element, {
					click: function(event){
						this.showPicker(this.mipcontainer);
					}
				});

				this._on(document, {
					click: function(event){
						if (!$(event.target).is(this.element) && !$(event.target).is(this.element) && instance.mipcontainer.has(event.target).length === 0) {
							this.hidePicker(this.mipcontainer);
						}
					}
				});
			},
			
			setSelectedIcon: function(icon) {
				this.options.selectedicon = icon;
				this.mipTitle.html('<i class="material-icons spaced-text">'+icon+'</i> '+icon);
				this._setIconInformation(icon);
				if (this.element.is('input[type="text"]')) {
					this.element.attr("value", icon);
					Materialize.updateTextFields();
				}
				
			}, 

			updatefooter: function() {		    	
				this.mipPagPageTxt.text((this.showingpage+1)+' of '+this.iconpages.length);
			},

			showPage: function(page) {
				for (var i = this.iconpages.length - 1; i >= 0; i--) {
					if (i===page) {
						this.iconpages[page].show(350, "easeInSine");
					}
					else{
						this.iconpages[i].hide(250, "easeOutElastic");
					}		    		
				}

				this.showingpage = page;
				this.showingpageelement = this.iconpages[this.showingpage];

				this.showingpageicons = this.showingpageelement.children();
				
				for (var l = this.showingpageicons.length - 1; l >= 0; l--) {
					this._on($(this.showingpageicons[l]),{
						click: function(event){
							this.showingpageicons.removeClass('selected');
							this.setSelectedIcon($(event.target).text());
							$(event.target).addClass('selected');
							this.options.selectedicon = $(this.showingpageicons[l]).text();
						},
						mouseenter:function(event){
							this._setIconInformation($(event.target).text());
						},
						mouseleave:function(event){
							this._setIconInformation('');
						}
					});

					if ($(this.showingpageicons[l]).text()== this.options.selectedicon) {
						this.showingpageicons.removeClass('selected');
						$(this.showingpageicons[l]).addClass('selected');
					}
				}
				
				
				this.updatefooter();        
			},

			showPicker: function(picker) {
				var instance = this;
				

				this.mipcontainer.css("width", this.pickerwidth);
				this.mipcontainer.append(this.options.template);
				this.mipTitle = this.mipcontainer.find('.mip-title');
				this.mipBody = this.mipcontainer.find('.mip-body');
				this.mipSearchWrapper = this.mipcontainer.find('.mip-search-input-wrapper');
				this.mipSearch = this.mipcontainer.find('.mip-search-input');
				this.mipSelect = this.mipcontainer.find('.mip-cat-select');
				this.mipIconsWrapper = this.mipcontainer.find('.mip-icons-wrapper');
				this.mipPagination = this.mipcontainer.find('.mip-pages');
				this.mipIconInfo = this.mipcontainer.find('.mip-icon-info');

				this.mipTitle.attr("id", "mipTitle"+instance.pickerid);
				this.mipBody.attr("id", "mipBody"+instance.pickerid);
				this.mipSearch.attr("id", "mipSearch"+instance.pickerid);
				this.mipSelect.attr("id", "mipSelect"+instance.pickerid);
				this.mipIconsWrapper.attr("id", "mipiconswrapper"+instance.pickerid);
				this.mipPagination.attr("id", "mippages"+instance.pickerid);
				this.mipIconInfo.attr("id", "mipiconinfo"+instance.pickerid);
				this.showingpage = 0;

				this.iconpages = new Array();
				this.pagesindex = 0;

					for(iconcat in instance.options.icons){						
						
						var iconPage = $('<div />', {
								class:"full-width mip-icon-page",
								id: "mip-"+instance.pickerid+"-page-"+iconcat
							});
						var icons = instance.options.icons[iconcat];
						if( instance.options.icons.hasOwnProperty(iconcat) ) {
						  icons = instance.options.icons[iconcat];
						  for (var i = icons.length - 1; i >= 0; i--) {
								iconPage.append($('<i />', {class:"material-icons mip-icon", text:icons[i]}));
								if (icons[i] === this.options.selectedicon) {
									this.showingpage = this.pagesindex;
								}

						  }
						}
						if (this.showingpage===this.pagesindex) {
							this.mipSelect.append($("<option />", {value:this.pagesindex, text:iconcat, selected:true}));
						}
						else{
							this.mipSelect.append($("<option />", {value:this.pagesindex, text:iconcat}));
						}
						
						this.mipIconsWrapper.append(iconPage);
						this.iconpages.push(iconPage);

						this.pagesindex++;
					}

				
					

				
				this.mipPagFirstPageBtn = 	$('<button />', {
												class:"btn-circle small waves-effect waves-dark", 
												id: '#firstpage'+instance.pickerid,
												html: $('<i />', {
													class:"material-icons normal-text",
													text: "first_page"
												})
											});
				this.mipPagPrevPageBtn = 	$('<button />', {
												class:"btn-circle small waves-effect waves-dark", 
												id: '#previouspage'+instance.pickerid,
												html: $('<i />', {
													class:"material-icons normal-text",
													text: "chevron_left"
												})
											});

				this.mipPagPageTxt = 	$('<i />', {
												class:"pagination-text", 
												id: '#pagination'+instance.pickerid
											});


				this.mipPagNxtPageBtn = 	$('<button />', {
												class:"btn-circle small waves-effect waves-dark", 
												id: '#nextpage'+instance.pickerid,
												html: $('<i />', {
													class:"material-icons normal-text",
													text: "chevron_right"
												})
											});
				this.mipPagLastPageBtn = 	$('<button />', {
												class:"btn-circle small waves-effect waves-dark", 
												id: '#lastpage'+instance.pickerid,
												html: $('<i />', {
													class:"material-icons normal-text",
													text: "last_page"
												})
											});

				this.mipPagination.append(this.mipPagFirstPageBtn);
				this.mipPagination.append(this.mipPagPrevPageBtn);
				this.mipPagination.append(this.mipPagPageTxt);
				this.mipPagination.append(this.mipPagNxtPageBtn);				
				this.mipPagination.append(this.mipPagLastPageBtn);

				this.mipcontainer.insertAfter(this.element);

				this._on(this.mipPagFirstPageBtn, {
					click: function(event){
						event.preventDefault();
						this.showPage(0);
					}
				});

				this._on(this.mipPagPrevPageBtn, {
					click: function(event){
						event.preventDefault();
						if(this.showingpage > 0 && this.showingpage < this.iconpages.length-1){
							var prevpg = this.showingpage-1;
							this.showPage(prevpg);
						}
						
					}
				});

				this._on(this.mipPagNxtPageBtn, {
					click: function(event){
						event.preventDefault();
						if (this.showingpage !== this.iconpages.length-1) {
							var nextpg = this.showingpage+1;
							this.showPage(nextpg);
						}						
					}
				});
				
				this._on(this.mipPagLastPageBtn, {
					click: function(event){
						event.preventDefault();
						this.showPage(this.iconpages.length-1);
					}
				});

				this.showPage(this.showingpage);


				

				this._on(this.mipSelect,{
					change: function(){
						var slectedpage =  this.mipSelect.val();
						this.showPage(parseInt(slectedpage));
					}
				});

				this._on(this.mipSearch,{
					input: function(){
						this._searchforIcon(this.mipSearch.val());
					}
				});

				if (this.element.is('input')) {
					var currenticon = this.element.attr('value');
					if(typeof currenticon != 'undefined' && currenticon != ''){
						this.setSelectedIcon(currenticon);
					}
					
				}


				


				this.mipSelect.materialselect();
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
				picker.empty();
				picker.remove();
			},

			
			_searchforIcon: function(icon) {
				this.mipIconsWrapper.remove('.mip-search');
				if (icon.length > 0) {
					var searCont = this.mipIconsWrapper.find('.mip-search');
					if (searCont.length == 0) {
						var searchResults = $('<div />', {class:"mip-icon-page mip-search"});
					}
					else{
						var searchResults = $(searCont[0]);
					}
					searchResults.html('');
					var icons = this.options.icons;
					var results = new Array();
					for(iconcat in icons){
						for (var i = icons[iconcat].length - 1; i >= 0; i--) {
							var similar = false;
							var foundchars  = icons[iconcat][i].indexOf(icon.toLowerCase());
							if (foundchars !== -1) {
								results.push(icons[iconcat][i]);		    					
							}
						}

					}

					
					for (var k = results.length - 1; k >= 0; k--) {
						var searchicon = ($('<i />', {
							class: "material-icons mip-icon",
							text: results[k]
						}));
						searchResults.append(searchicon);

						this._on(searchicon,{
							click: function(event){
								this.showingpageicons.removeClass('selected');
								searchResults.removeClass('selected');
								this.setSelectedIcon($(event.target).text());
								$(event.target).addClass('selected');
							}
						});

						
					}
					for (var k = this.iconpages.length - 1; k >= 0; k--) {
						this.iconpages[k].hide();
					}

					this.mipIconsWrapper.prepend(searchResults);
					
				}
				else{
					this.showPage(this.showingpage);
				}
				
			},
			_setIconInformation: function(icon){
				if (icon == "") {
					this.mipIconInfo.html('<i>'+this.options.selectedicon+'</i>');
					
				}
				else{
					this.mipIconInfo.html('<i>'+icon+'</i>');
				}
				
			}





		});

		
}