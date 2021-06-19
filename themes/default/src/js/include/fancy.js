// // FancyApps
// window.fancybox = require('@fancyapps/fancybox');
// we require this in template - bundle gets to fat

$(document).ready(function() {
  if (typeof fancybox === 'object') {
    $("[data-fancybox]").fancybox({
      thumbs     : false,
      slideShow  : false,
      image : {
        protect : true
      },
      buttons: [
        // "zoom",
        //"share",
        // "slideShow",
        //"fullScreen",
        //"download",
        // "thumbs",
        "close"
      ]
    });
  }
});
