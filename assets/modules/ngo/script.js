$.fn.extend ({	
	attributedtosdashgraph : function(renderdom, cleardom=false) {
		var dataurl = $.fn.site_url("api/Api/getrecords?entity=ngo_donors&select=count&column=pe_lKeyID&groupby=pe_lAttributedTo&keys=1");
		$.get(dataurl, function(data){
			console.log(data);
			$(renderdom).append(data);

		});
	}

});
$(function(){
	$.fn.attributedtosdashgraph("#attrtimeline");
});
