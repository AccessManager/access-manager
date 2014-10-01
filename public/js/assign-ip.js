$(function(){
	$('#subnet').on('change',function(){
		var subnet_id = $(this).val();
		var ip_div = $('#ip-div');
		var ip_list = $('#ip-list');

		var promise = $.ajax({
			url : 'http://localhost/am-laravel/json/get-ip-list/'+subnet_id,
			method : 'GET',
		}).promise();
		promise.done(function(result){
			if( ! $.isEmptyObject(result) ) {
				ip_div.removeClass('hidden');
				ip_list.empty();
				// ip_list.append("<option value='0'>NONE</option>");
				$.each(result, function(index, obj){
					ip_list.append("<option value='"+index+"'>"+obj+"</option>");
				});
			} else {
				ip_div.addClass('hidden');
				ip_list.val(0);
			}
		});
	});
});

//end of file assign-ip.js