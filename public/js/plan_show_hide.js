$(function(){
	var plan_type = $("input[name='plan_type']");
	var limit_type = $("input[name='limit_type']");
	var limit_type_div = $('.limit_type');
	var all_limited = $('.limited');
	var time_limit = $('.time_limit');
	var data_limit = $('.data_limit');
	// var policy_type = $("input[name='policy_type']");
	var aq_access = $(".aq_access");
	var aq_allowed = $('#aq-allowed');
	var aq_policy = $('.aq_policy');
	var policy_type = $("input[name='policy_type']");
	var single_policy = $('.single-policy');
	var policy_schema = $('.policy-schema');


	plan_type.click(function(){
		var type = parseInt ( $(this).val() );
		all_limited.addClass('hidden');
		switch(type) {
			case 0:
			
				break;
			case 1:
			limit_type_div.removeClass('hidden');
				break;
		}
	})

	limit_type.click(function(){
		// console.log("clicked.");
			var type = parseInt( $(this).val() );
			all_limited.addClass('hidden');
			aq_access.removeClass('hidden');
			switch(type) {
				case 0:
				limit_type_div.removeClass('hidden');
				time_limit.removeClass('hidden');
					break;
				case 1:
				limit_type_div.removeClass('hidden');
				data_limit.removeClass('hidden');
					break;
				case 2:
				limit_type_div.removeClass('hidden');
				time_limit.removeClass('hidden');
				data_limit.removeClass('hidden');
					break;
			}
		})

	aq_allowed.on('change',function(){
		if(aq_allowed[0].checked) {
			aq_policy.removeClass('hidden');
		} else {
			aq_policy.addClass('hidden');
		}
	})

	policy_type.click(function(){
		// var value = $(this).val();
		// console.log('policy clicked');
		switch( $(this).val() ) {
			case 'Policy': 
			single_policy.removeClass('hidden');
			policy_schema.addClass('hidden');
			// $('#policy').attr('name','policy_id');
			// $('#schema').attr('name','else');
				break;
			case 'PolicySchema':
			single_policy.addClass('hidden');
			policy_schema.removeClass('hidden');
			// $('#schema').attr('name','policy_id');
			// $('#policy').attr('name','something');
				break;
		}
	})


})