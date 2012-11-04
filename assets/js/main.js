jQuery.fn.defaults = function() {
	$(this).each(function() {
		if ($(this).attr("default") != "") {
			if ($(this).val() == "")
				$(this).val($(this).attr('default'));
			$(this).blur(function() {
				if ($(this).val() == "")
					$(this).val($(this).attr('default'));
			});
			$(this).click(function() {
				if ($(this).val() == $(this).attr('default'))
					$(this).val("");
			});
			$(this).keydown(function() {
				if ($(this).val() == $(this).attr('default'))
					$(this).val("");
			});
		}
	});
};
$(function(){
	$("input").defaults();
	$("textarea").defaults();
});