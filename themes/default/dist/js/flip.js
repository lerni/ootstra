/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************!*\
  !*** ./src/js/flip.js ***!
  \************************/
(function () {
  var accordions = document.querySelectorAll(".content-parts.accordion details");
  Array.prototype.forEach.call(accordions, function (details) {
    // Handle manual toggling to update URL hash
    details.addEventListener("toggle", function (event) {
      var detailsId = details.id;
      var hash = window.location.hash.substr(1);
      if (detailsId) {
        if (details.open) {
          // Details was opened - update hash
          history.replaceState(null, null, "#" + detailsId);
        } else if (detailsId === hash) {
          // Details was closed and it was the current hash - remove hash
          history.replaceState(null, document.title, window.location.pathname + window.location.search);
        }
      }
    });
  });

  // Open accordion per hash
  window.addEventListener("hashchange", openPerHash);
  document.addEventListener("DOMContentLoaded", openPerHash);
  function openPerHash(event) {
    var hash = window.location.hash.substr(1);
    if (hash) {
      Array.prototype.forEach.call(accordions, function (details) {
        if (hash === details.id) {
          details.open = true;
          // Focus the summary element for accessibility
          var summary = details.querySelector("summary");
          if (summary) {
            summary.focus();
          }
        }
      });
    }
  }
})();
/******/ })()
;
//# sourceMappingURL=flip.js.map