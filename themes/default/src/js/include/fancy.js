import { Fancybox } from "@fancyapps/ui";

Fancybox.bind("[data-fancybox]", {
  thumbs     : false,
  slideShow  : false,
  Image : {
    zoom: false,
    protect : true
  },
  Toolbar: {
    display: [
      "close"
    ],
  },
});
