function access_type(access) {
	// var access = parseInt($("input[name='access']").val());
		switch( access )
		{
			case 1:
				$('.allowed').removeClass('hidden');
				$('.partial').addClass('hidden');
				break;
			case 0:
				$('.allowed').addClass('hidden');
				$('.partial').addClass('hidden');
				break;
			case 2:
				$('.allowed').addClass('hidden');
				$('.partial').addClass('hidden');
				$('.partial-main').removeClass('hidden');
				break;
		}
}

	var prAllowed = $('#pr-allowed');
	var secAllowed = $('#sec-allowed');
	var partial_sub = $('.partial-sub');
	var pr_policy = $('.pr-policy');
	var sec_policy = $('.sec-policy');
	var pr_acct = $('.pr-accountable');
	var sec_acct = $('.sec-accountable');

function partial_primary() {
	if( prAllowed[0].checked || secAllowed[0].checked ) {
			partial_sub.removeClass('hidden');
			if(prAllowed[0].checked) {
				pr_policy.removeClass('hidden');
				pr_acct.removeClass('hidden');
			} else {
				pr_policy.addClass('hidden');
				pr_acct.addClass('hidden');
			}
			if(secAllowed[0].checked ) {
				sec_policy.removeClass('hidden');
				sec_acct.removeClass('hidden');
			} else {
				sec_policy.addClass('hidden');
				sec_acct.addClass('hidden');
			}
		} else {
			partial_sub.addClass('hidden');
		}
}

function partial_secondary() {
	if( prAllowed[0].checked || secAllowed[0].checked ) {
			partial_sub.removeClass('hidden');
			if(prAllowed[0].checked) {
				pr_policy.removeClass('hidden');
				pr_acct.removeClass('hidden');
			} else {
				pr_policy.addClass('hidden');
				pr_acct.addClass('hidden');
			}
			if(secAllowed[0].checked ) {
				sec_policy.removeClass('hidden');
				sec_acct.removeClass('hidden');
			} else {
				sec_policy.addClass('hidden');
				sec_acct.addClass('hidden');
			}
		} else {
			partial_sub.addClass('hidden');
		}
}

$(function(){

	$("input[name='access']").click(function(){
		access_type(parseInt($(this).val()));
	})

	prAllowed.on('change',function(){
		partial_primary();
	})
	secAllowed.on('change',function(){
		partial_secondary();
	})

	$('#reset').click(function(){
		var type = $("input[name='access']:checked").val();
		console.log(type);
		access_type(parseInt(type));
		partial_primary();
		partial_secondary();
	})
})