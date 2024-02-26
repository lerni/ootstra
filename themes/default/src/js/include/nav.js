document.addEventListener("DOMContentLoaded", () => {

  // burger
  document.querySelector('#menuButton').addEventListener('click', event => {
    document.querySelector('html').classList.toggle('mobile-nav--active');
    let menuButton = document.querySelector('#menuButton');
    let isExpanded = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', !isExpanded);
    document.getElementById('header').scrollIntoView();
  });

  // toggle expanded-class
  // open and do not navigate on collapsed:not(.expanded) navi-items on mobile nav (touch)
  document.querySelector('.menu1').addEventListener('click', event => {
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
  const triggers = document.querySelectorAll('span.trigger');
  triggers.forEach(trigger => {
    trigger.addEventListener('click', event => {
      event.target.closest('li').classList.toggle('expanded');
    });
  });

  document.querySelector('.menu1').addEventListener('mouseleave', event => {
    if (!document.querySelector('html').classList.contains('mobile-nav--active')) {
      const items = document.querySelectorAll('.menu1 li');
      items.forEach(i => {
        i.classList.remove('expanded');
      });
    }
  });
});

// we need to prevent loading from cache if back-button is used, cos ios-safari would apply the fadeTo-effect to the destination not the original
window.onpageshow = event => {
  if (event.persisted) {
    window.location.reload()
  }
};
