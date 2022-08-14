document.addEventListener("DOMContentLoaded", function() {

	// burger
	document.getElementById('menuButton').addEventListener('click', function (event) {
    document.querySelector('html').classList.toggle('mobile-nav--active');
		event.preventDefault();
	});

	// toggle expanded-class
  // open and do not navigate on collapsed:not(.expanded) navi-items
  document.querySelector('.menu1').addEventListener('click', (event) => {
    if (event.target.closest('li.has-children.expanded >a')) {
      window.location = event.target.getAttribute('href');
    }
    if (event.target.closest('li.has-children >a')) {
      event.preventDefault();
      event.target.parentElement.classList.toggle('expanded');
    }
	});

	// collapse/expand navi per .trigger
  trigger = document.querySelector('span.trigger');
  if (trigger) {
    document.querySelector('span.trigger').addEventListener('click', (event) => {
      event.stopPropagation();
      event.target.parentElement.classList.toggle('expanded');
    });
  }

  document.querySelector('.menu1').addEventListener('mouseleave', (event) => {
    if (!document.querySelector('html').classList.contains('mobile-nav--active')) {
      items = document.querySelectorAll('.menu1 li');
      items.forEach(i => {
        i.classList.remove('expanded');
      });
    }
	});

});

// we need to prevent loading from cache if back-button is used, cos ios-safari would apply the fadeTo-effect to the destination not the original
window.onpageshow = function(event) {
	if (event.persisted) {
		window.location.reload()
	}
};
