$(function(){
	$('.profile-nav').click(function(e){
		e.preventDefault();
		var t = $(this);
		t.siblings().removeClass('active');
		t.addClass('active');
		
		var target = t.attr('target');

		$('.all').addClass('hidden',5000,'easeOutBounce');
		$('#'+target).removeClass('hidden',5000,'easeOutBounce');
	});
});