(function () {
  const headings = document.querySelectorAll("h1.flip, h2.flip, h3.flip");

  Array.prototype.forEach.call(headings, (title) => {
    let btn = title.querySelector("button");
    let target = title.nextElementSibling;

    btn.onclick = (event) => {
      let expanded = btn.getAttribute("aria-expanded") === "true";
      let heading = title.id;
      let hash = window.location.hash.substr(1);

      btn.setAttribute("aria-expanded", !expanded);
      target.hidden = expanded;

      if (heading && !expanded) {
        history.replaceState(null, null, "#" + heading);
      }
      if (heading && expanded && heading == hash) {
        history.replaceState(
          null,
          document.title,
          window.location.pathname + window.location.search
        );
      }
    };
  });
  // open per hash
  window.addEventListener("hashchange", openPerHash);
  document.addEventListener("DOMContentLoaded", openPerHash);
  function openPerHash(event) {
    let hash = window.location.hash.substr(1);

    if (hash) {
      Array.prototype.forEach.call(headings, (title) => {
        let btn = title.querySelector("button");
        let target = title.nextElementSibling;

        if (hash === title.id) {
          btn.setAttribute("aria-expanded", "true");
          target.removeAttribute("hidden");
          btn.focus();
        }
      });
    }
  }
})();
