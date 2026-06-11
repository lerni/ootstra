import { Fancybox } from "@fancyapps/ui/dist/fancybox/";

Fancybox.bind("[data-fancybox]", {
  zoomEffect: false,
  Carousel: {
    Thumbs: {
      type: "modern",
    },
    Toolbar: {
      display: {
        left: [],
        middle: [],
        right: ["close"],
      },
    },
    Zoomable: {
      Panzoom: {
        protected: true,
      },
    },
  },
});
