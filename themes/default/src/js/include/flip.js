$(".flip header").click(function() {
	$(this).next('div.flip').slideToggle('fast');
	$(this).parent().toggleClass("open");
	if ($(this).parent().hasClass("open")) {
		$(this).next("div.flip").attr("aria-expanded", true);
	} else {
		$(this).next("div.flip").attr("aria-expanded", false);
	}
});
