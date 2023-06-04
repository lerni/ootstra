import { Fancybox } from "@fancyapps/ui";

Fancybox.bind("[data-fancybox]", {
  Thumbs: false,
  Images: {
    zoom: false,
    protect : true
  },
  Thumbs: {
    type: "modern",
  },
  Toolbar: {
    display: {
      left: [],
      middle: [],
      right: ["close"]
    }
  }
});
