jQuery.fn.bind_boots = function() {
	$("input").defaults();
	$(".boot-type").each(function() {
		$(this).autocomplete({
			source: boots,
			minLength: 0
		});
		$(this).click(function() {
			$(this).autocomplete("search", '');
		});
		$(this).focus(function() {
			$(this).autocomplete("search", '');
		});
	})
	$(".boot-count").each(function() {
		$(this).blur(function() {
			var add_boots = false;
			if ($(this).val() > 0) {
				$(".boot-count").each(function() {
					if ($(this).val() > 0)
						add_boots = true;
				});
				if (add_boots) {
					if ($(this).parent().children(".boot-type").val() != $(this).parent().children(".boot-type").attr('default')) {
						var date = new Date();
						var hash = date.getTime();
						$(this).parent().before('<div>' +
								'<input type="text" class="boot-type" name="boot-type-' + hash + '" default="Enter or Select Boot Type"> ' +
								'<input type="text" class="boot-count" name="boot-count-' + hash + '" default="Enter the Boot Count">' +
							'</div>');
						$(this).bind_boots();
					} else {
						$(this).parent().children(".boot-type").focus();
						$(this).parent().children(".boot-type").css("background", "#FC6");
					} 
				}
			}
		});
	});
};
jQuery.fn.bind_services = function() {
	$("input").defaults();
	$(".service").each(function() {
		$(this).autocomplete({
			source: services,
			minLength: 0
		});
		$(this).bind_comboboxes();
		$(this).blur(function() {
			var add_service = false;
			$(".service").each(function() {
				if ($(this).val() != 'Enter or Select a Service')
					add_service = true;
			});
			if (add_service) {
				var date = new Date();
				var hash = date.getTime();
				if ($(this).val() != $(this).attr('default')) {
					$(this).before('<input type="text" class="service" name="service-type-' + hash + '" default="Enter or Select a Service"><br>');
					$(this).bind_services();
				}
			}
		});
	});
};
jQuery.fn.bind_comboboxes = function() {
	$(this).each(function() {
		$(this).click(function() {
			$(this).autocomplete("search", '');
		});
		$(this).focus(function() {
			$(this).autocomplete("search", '');
		});
	});
}

$(function(){
	$("#organization").autocomplete({
		source: organizations,
		minLength: 0
	});
	$("#disaster").autocomplete({
		source: disasters,
		minLength: 0
	});
	$(".combo").bind_comboboxes();
	$(this).bind_boots();
	$(this).bind_services();
	//$("body").prepend("<h1>JS LIVES</h1>");
	
});