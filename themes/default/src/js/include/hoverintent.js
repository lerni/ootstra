import hoverintent from 'hoverintent';

var hiopts = {
  timeout: 500,
  interval: 100
};

var _hoverTriggers = document.querySelectorAll('.menu1 >li.has-children');

Array.prototype.forEach.call(_hoverTriggers, function(el) {
  hoverintent(el,
    function() {
      if (!el.classList.contains("pseudohover")) {
        el.classList.add("pseudohover");
      }
    }, function() {
      el.classList.remove("pseudohover");
    }
  ).options(hiopts);
});
