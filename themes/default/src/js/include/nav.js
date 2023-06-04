document.addEventListener("DOMContentLoaded", function() {

  // burger
  document.getElementById('menuButton').addEventListener('click', function (event) {
    window.scrollTo(0, 0);
    document.querySelector('html').classList.toggle('mobile-nav--active');
  });

  // toggle expanded-class
  // open and do not navigate on collapsed:not(.expanded) navi-items on mobile nav (touch)
  document.querySelector('.menu1').addEventListener('click', (event) => {
    if (event.target.closest('li.has-children.expanded >a')) {
      window.location = event.target.getAttribute('href');
    } else if (document.querySelector('html').classList.contains('mobile-nav--active') &&
        event.target.closest('li.has-children >a'))
    {
      event.preventDefault();
      event.target.parentElement.classList.toggle('expanded');
    }
  });

  // collapse/expand navi per .trigger
  triggers = document.querySelectorAll('span.trigger');
  triggers.forEach(trigger => {
    trigger.addEventListener('click', (event) => {
      event.stopPropagation();
      event.target.parentElement.classList.toggle('expanded');
    });
  });

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
