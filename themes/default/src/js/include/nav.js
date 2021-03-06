$(document).ready(function() {

	// burger
	var menuButton = document.getElementById('menuButton');
	menuButton.addEventListener('click', function (event) {
		$('html').toggleClass('mobile-nav--active');
		event.preventDefault();
	});

	// just open and do not navigate on collapsed navi-items
	$('.menu1').on('click', '>li.has-children:not(.expanded) > a', function(event) {
		if ($('html').hasClass('mobile-nav--active')) {
			event.preventDefault();
			event.stopPropagation();
			$(this).parent().find("ul.mobile-menu2").toggleClass('expanded');
			$(this).closest("li").toggleClass('expanded');
		}
	});

	// collapse/expand navi per .trigger
	$('span.trigger').on('click', function(event) {
		$(this).next("ul").toggleClass('expanded');
		$(this).closest("li").toggleClass('expanded');
	});

	// if we navigate, we fade-out .menu1 a bit to indicate action
	$('.menu1').on('click', '>li:not(".has-children") > a, >li.expanded > a, .mobile-menu2 li > a', function(event) {
		if ($('html').hasClass('mobile-nav--active')) {
			// event.stopPropagation();
			$('html').fadeTo("fast", 0.6);
		}
	});

	$('html').on('click touch', '#overlaynav', function(event) {
		if ($('html').hasClass('mobile-nav--active')) {
			$('html').toggleClass('mobile-nav--active');
		}
	});
});

// we need to prevent loading from cache if back-button is used, cos ios-safari would apply the fadeTo-effect to the destination not the original
window.onpageshow = function(event) {
    if (event.persisted) {
        window.location.reload()
    }
};
