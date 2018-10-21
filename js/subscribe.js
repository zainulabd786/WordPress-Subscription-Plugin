jQuery(document).ready(function($){
	$(".subscribe-btn").click(function(e){
		e.preventDefault();
		$.post(ajax_url, {
			action: "sub_subscribe_action",
			email: $(".subscribe-inp").val()
		}, function(resp){
			$(".sub-subscribe-response").html(resp);
		});
	});
});


