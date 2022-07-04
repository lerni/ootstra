import { Fancybox } from "@fancyapps/ui";

Fancybox.bind("[data-fancybox]", {
  Thumbs: false,
  slideShow  : false,
  Image : {
    zoom: false,
    protect : true
  },
  Toolbar: {
    display: [
      "close"
    ],
  }
});
