(function() {

  const headings = document.querySelectorAll('h1.flip, h2.flip, h3.flip');

  Array.prototype.forEach.call(headings, definitionTitle => {

    let btn = definitionTitle.querySelector('button');
    let target = definitionTitle.nextElementSibling;

    btn.onclick = (event) => {

      // bail-out if clicked element doesn't have .flip class
      if (!event.target.classList.contains('flip')) return;

      let expanded = btn.getAttribute('aria-expanded') === 'true';
      let heading = definitionTitle.id;
      let hash = window.location.hash.substr(1);

      btn.setAttribute('aria-expanded', !expanded);
      target.hidden = expanded;

      if (heading && !expanded) {
        history.replaceState(null, null, '#' + heading)
      }
      if (heading && expanded && heading == hash) {
        history.replaceState(null, document.title, window.location.pathname + window.location.search);
      }
    }
  });

  // open per hash
  document.addEventListener('DOMContentLoaded', function(event) {
    let hash = window.location.hash.substr(1);

    if (hash) {
      Array.prototype.forEach.call(headings, definitionTitle => {
        let btn = definitionTitle.querySelector('button');
        let target = definitionTitle.nextElementSibling;

        if (hash === definitionTitle.id) {
          btn.setAttribute('aria-expanded', 'true')
          target.removeAttribute('hidden')
          btn.focus()
        }
      });
    }
  });

})();
