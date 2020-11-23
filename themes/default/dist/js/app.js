/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js":
/*!******************************************************************!*\
  !*** ./node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// ==================================================
// fancyBox v3.5.7
//
// Licensed GPLv3 for open source use
// or fancyBox Commercial License for commercial use
//
// http://fancyapps.com/fancybox/
// Copyright 2019 fancyApps
//
// ==================================================
(function (window, document, $, undefined) {
  "use strict";

  window.console = window.console || {
    info: function info(stuff) {}
  }; // If there's no jQuery, fancyBox can't work
  // =========================================

  if (!$) {
    return;
  } // Check if fancyBox is already initialized
  // ========================================


  if ($.fn.fancybox) {
    console.info("fancyBox already initialized");
    return;
  } // Private default settings
  // ========================


  var defaults = {
    // Close existing modals
    // Set this to false if you do not need to stack multiple instances
    closeExisting: false,
    // Enable infinite gallery navigation
    loop: false,
    // Horizontal space between slides
    gutter: 50,
    // Enable keyboard navigation
    keyboard: true,
    // Should allow caption to overlap the content
    preventCaptionOverlap: true,
    // Should display navigation arrows at the screen edges
    arrows: true,
    // Should display counter at the top left corner
    infobar: true,
    // Should display close button (using `btnTpl.smallBtn` template) over the content
    // Can be true, false, "auto"
    // If "auto" - will be automatically enabled for "html", "inline" or "ajax" items
    smallBtn: "auto",
    // Should display toolbar (buttons at the top)
    // Can be true, false, "auto"
    // If "auto" - will be automatically hidden if "smallBtn" is enabled
    toolbar: "auto",
    // What buttons should appear in the top right corner.
    // Buttons will be created using templates from `btnTpl` option
    // and they will be placed into toolbar (class="fancybox-toolbar"` element)
    buttons: ["zoom", //"share",
    "slideShow", //"fullScreen",
    //"download",
    "thumbs", "close"],
    // Detect "idle" time in seconds
    idleTime: 3,
    // Disable right-click and use simple image protection for images
    protect: false,
    // Shortcut to make content "modal" - disable keyboard navigtion, hide buttons, etc
    modal: false,
    image: {
      // Wait for images to load before displaying
      //   true  - wait for image to load and then display;
      //   false - display thumbnail and load the full-sized image over top,
      //           requires predefined image dimensions (`data-width` and `data-height` attributes)
      preload: false
    },
    ajax: {
      // Object containing settings for ajax request
      settings: {
        // This helps to indicate that request comes from the modal
        // Feel free to change naming
        data: {
          fancybox: true
        }
      }
    },
    iframe: {
      // Iframe template
      tpl: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" allowfullscreen="allowfullscreen" allow="autoplay; fullscreen" src=""></iframe>',
      // Preload iframe before displaying it
      // This allows to calculate iframe content width and height
      // (note: Due to "Same Origin Policy", you can't get cross domain data).
      preload: true,
      // Custom CSS styling for iframe wrapping element
      // You can use this to set custom iframe dimensions
      css: {},
      // Iframe tag attributes
      attr: {
        scrolling: "auto"
      }
    },
    // For HTML5 video only
    video: {
      tpl: '<video class="fancybox-video" controls controlsList="nodownload" poster="{{poster}}">' + '<source src="{{src}}" type="{{format}}" />' + 'Sorry, your browser doesn\'t support embedded videos, <a href="{{src}}">download</a> and watch with your favorite video player!' + "</video>",
      format: "",
      // custom video format
      autoStart: true
    },
    // Default content type if cannot be detected automatically
    defaultType: "image",
    // Open/close animation type
    // Possible values:
    //   false            - disable
    //   "zoom"           - zoom images from/to thumbnail
    //   "fade"
    //   "zoom-in-out"
    //
    animationEffect: "zoom",
    // Duration in ms for open/close animation
    animationDuration: 366,
    // Should image change opacity while zooming
    // If opacity is "auto", then opacity will be changed if image and thumbnail have different aspect ratios
    zoomOpacity: "auto",
    // Transition effect between slides
    //
    // Possible values:
    //   false            - disable
    //   "fade'
    //   "slide'
    //   "circular'
    //   "tube'
    //   "zoom-in-out'
    //   "rotate'
    //
    transitionEffect: "fade",
    // Duration in ms for transition animation
    transitionDuration: 366,
    // Custom CSS class for slide element
    slideClass: "",
    // Custom CSS class for layout
    baseClass: "",
    // Base template for layout
    baseTpl: '<div class="fancybox-container" role="dialog" tabindex="-1">' + '<div class="fancybox-bg"></div>' + '<div class="fancybox-inner">' + '<div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div>' + '<div class="fancybox-toolbar">{{buttons}}</div>' + '<div class="fancybox-navigation">{{arrows}}</div>' + '<div class="fancybox-stage"></div>' + '<div class="fancybox-caption"><div class="fancybox-caption__body"></div></div>' + "</div>" + "</div>",
    // Loading indicator template
    spinnerTpl: '<div class="fancybox-loading"></div>',
    // Error message template
    errorTpl: '<div class="fancybox-error"><p>{{ERROR}}</p></div>',
    btnTpl: {
      download: '<a download data-fancybox-download class="fancybox-button fancybox-button--download" title="{{DOWNLOAD}}" href="javascript:;">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.62 17.09V19H5.38v-1.91zm-2.97-6.96L17 11.45l-5 4.87-5-4.87 1.36-1.32 2.68 2.64V5h1.92v7.77z"/></svg>' + "</a>",
      zoom: '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 17.3l-3-3a5.9 5.9 0 0 0-.6-7.6 5.9 5.9 0 0 0-8.4 0 5.9 5.9 0 0 0 0 8.4 5.9 5.9 0 0 0 7.7.7l3 3a1 1 0 0 0 1.3 0c.4-.5.4-1 0-1.5zM8.1 13.8a4 4 0 0 1 0-5.7 4 4 0 0 1 5.7 0 4 4 0 0 1 0 5.7 4 4 0 0 1-5.7 0z"/></svg>' + "</button>",
      close: '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"/></svg>' + "</button>",
      // Arrows
      arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' + '<div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.28 15.7l-1.34 1.37L5 12l4.94-5.07 1.34 1.38-2.68 2.72H19v1.94H8.6z"/></svg></div>' + "</button>",
      arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' + '<div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.4 12.97l-2.68 2.72 1.34 1.38L19 12l-4.94-5.07-1.34 1.38 2.68 2.72H5v1.94z"/></svg></div>' + "</button>",
      // This small close button will be appended to your html/inline/ajax content by default,
      // if "smallBtn" option is not set to false
      smallBtn: '<button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="{{CLOSE}}">' + '<svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"/></svg>' + "</button>"
    },
    // Container is injected into this element
    parentEl: "body",
    // Hide browser vertical scrollbars; use at your own risk
    hideScrollbar: true,
    // Focus handling
    // ==============
    // Try to focus on the first focusable element after opening
    autoFocus: true,
    // Put focus back to active element after closing
    backFocus: true,
    // Do not let user to focus on element outside modal content
    trapFocus: true,
    // Module specific options
    // =======================
    fullScreen: {
      autoStart: false
    },
    // Set `touch: false` to disable panning/swiping
    touch: {
      vertical: true,
      // Allow to drag content vertically
      momentum: true // Continue movement after releasing mouse/touch when panning

    },
    // Hash value when initializing manually,
    // set `false` to disable hash change
    hash: null,
    // Customize or add new media types
    // Example:

    /*
      media : {
        youtube : {
          params : {
            autoplay : 0
          }
        }
      }
    */
    media: {},
    slideShow: {
      autoStart: false,
      speed: 3000
    },
    thumbs: {
      autoStart: false,
      // Display thumbnails on opening
      hideOnClose: true,
      // Hide thumbnail grid when closing animation starts
      parentEl: ".fancybox-container",
      // Container is injected into this element
      axis: "y" // Vertical (y) or horizontal (x) scrolling

    },
    // Use mousewheel to navigate gallery
    // If 'auto' - enabled for images only
    wheel: "auto",
    // Callbacks
    //==========
    // See Documentation/API/Events for more information
    // Example:

    /*
      afterShow: function( instance, current ) {
        console.info( 'Clicked element:' );
        console.info( current.opts.$orig );
      }
    */
    onInit: $.noop,
    // When instance has been initialized
    beforeLoad: $.noop,
    // Before the content of a slide is being loaded
    afterLoad: $.noop,
    // When the content of a slide is done loading
    beforeShow: $.noop,
    // Before open animation starts
    afterShow: $.noop,
    // When content is done loading and animating
    beforeClose: $.noop,
    // Before the instance attempts to close. Return false to cancel the close.
    afterClose: $.noop,
    // After instance has been closed
    onActivate: $.noop,
    // When instance is brought to front
    onDeactivate: $.noop,
    // When other instance has been activated
    // Interaction
    // ===========
    // Use options below to customize taken action when user clicks or double clicks on the fancyBox area,
    // each option can be string or method that returns value.
    //
    // Possible values:
    //   "close"           - close instance
    //   "next"            - move to next gallery item
    //   "nextOrClose"     - move to next gallery item or close if gallery has only one item
    //   "toggleControls"  - show/hide controls
    //   "zoom"            - zoom image (if loaded)
    //   false             - do nothing
    // Clicked on the content
    clickContent: function clickContent(current, event) {
      return current.type === "image" ? "zoom" : false;
    },
    // Clicked on the slide
    clickSlide: "close",
    // Clicked on the background (backdrop) element;
    // if you have not changed the layout, then most likely you need to use `clickSlide` option
    clickOutside: "close",
    // Same as previous two, but for double click
    dblclickContent: false,
    dblclickSlide: false,
    dblclickOutside: false,
    // Custom options when mobile device is detected
    // =============================================
    mobile: {
      preventCaptionOverlap: false,
      idleTime: false,
      clickContent: function clickContent(current, event) {
        return current.type === "image" ? "toggleControls" : false;
      },
      clickSlide: function clickSlide(current, event) {
        return current.type === "image" ? "toggleControls" : "close";
      },
      dblclickContent: function dblclickContent(current, event) {
        return current.type === "image" ? "zoom" : false;
      },
      dblclickSlide: function dblclickSlide(current, event) {
        return current.type === "image" ? "zoom" : false;
      }
    },
    // Internationalization
    // ====================
    lang: "en",
    i18n: {
      en: {
        CLOSE: "Close",
        NEXT: "Next",
        PREV: "Previous",
        ERROR: "The requested content cannot be loaded. <br/> Please try again later.",
        PLAY_START: "Start slideshow",
        PLAY_STOP: "Pause slideshow",
        FULL_SCREEN: "Full screen",
        THUMBS: "Thumbnails",
        DOWNLOAD: "Download",
        SHARE: "Share",
        ZOOM: "Zoom"
      },
      de: {
        CLOSE: "Schlie&szlig;en",
        NEXT: "Weiter",
        PREV: "Zur&uuml;ck",
        ERROR: "Die angeforderten Daten konnten nicht geladen werden. <br/> Bitte versuchen Sie es sp&auml;ter nochmal.",
        PLAY_START: "Diaschau starten",
        PLAY_STOP: "Diaschau beenden",
        FULL_SCREEN: "Vollbild",
        THUMBS: "Vorschaubilder",
        DOWNLOAD: "Herunterladen",
        SHARE: "Teilen",
        ZOOM: "Vergr&ouml;&szlig;ern"
      }
    }
  }; // Few useful variables and methods
  // ================================

  var $W = $(window);
  var $D = $(document);
  var called = 0; // Check if an object is a jQuery object and not a native JavaScript object
  // ========================================================================

  var isQuery = function isQuery(obj) {
    return obj && obj.hasOwnProperty && obj instanceof $;
  }; // Handle multiple browsers for "requestAnimationFrame" and "cancelAnimationFrame"
  // ===============================================================================


  var requestAFrame = function () {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || // if all else fails, use setTimeout
    function (callback) {
      return window.setTimeout(callback, 1000 / 60);
    };
  }();

  var cancelAFrame = function () {
    return window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || function (id) {
      window.clearTimeout(id);
    };
  }(); // Detect the supported transition-end event property name
  // =======================================================


  var transitionEnd = function () {
    var el = document.createElement("fakeelement"),
        t;
    var transitions = {
      transition: "transitionend",
      OTransition: "oTransitionEnd",
      MozTransition: "transitionend",
      WebkitTransition: "webkitTransitionEnd"
    };

    for (t in transitions) {
      if (el.style[t] !== undefined) {
        return transitions[t];
      }
    }

    return "transitionend";
  }(); // Force redraw on an element.
  // This helps in cases where the browser doesn't redraw an updated element properly
  // ================================================================================


  var forceRedraw = function forceRedraw($el) {
    return $el && $el.length && $el[0].offsetHeight;
  }; // Exclude array (`buttons`) options from deep merging
  // ===================================================


  var mergeOpts = function mergeOpts(opts1, opts2) {
    var rez = $.extend(true, {}, opts1, opts2);
    $.each(opts2, function (key, value) {
      if ($.isArray(value)) {
        rez[key] = value;
      }
    });
    return rez;
  }; // How much of an element is visible in viewport
  // =============================================


  var inViewport = function inViewport(elem) {
    var elemCenter, rez;

    if (!elem || elem.ownerDocument !== document) {
      return false;
    }

    $(".fancybox-container").css("pointer-events", "none");
    elemCenter = {
      x: elem.getBoundingClientRect().left + elem.offsetWidth / 2,
      y: elem.getBoundingClientRect().top + elem.offsetHeight / 2
    };
    rez = document.elementFromPoint(elemCenter.x, elemCenter.y) === elem;
    $(".fancybox-container").css("pointer-events", "");
    return rez;
  }; // Class definition
  // ================


  var FancyBox = function FancyBox(content, opts, index) {
    var self = this;
    self.opts = mergeOpts({
      index: index
    }, $.fancybox.defaults);

    if ($.isPlainObject(opts)) {
      self.opts = mergeOpts(self.opts, opts);
    }

    if ($.fancybox.isMobile) {
      self.opts = mergeOpts(self.opts, self.opts.mobile);
    }

    self.id = self.opts.id || ++called;
    self.currIndex = parseInt(self.opts.index, 10) || 0;
    self.prevIndex = null;
    self.prevPos = null;
    self.currPos = 0;
    self.firstRun = true; // All group items

    self.group = []; // Existing slides (for current, next and previous gallery items)

    self.slides = {}; // Create group elements

    self.addContent(content);

    if (!self.group.length) {
      return;
    }

    self.init();
  };

  $.extend(FancyBox.prototype, {
    // Create DOM structure
    // ====================
    init: function init() {
      var self = this,
          firstItem = self.group[self.currIndex],
          firstItemOpts = firstItem.opts,
          $container,
          buttonStr;

      if (firstItemOpts.closeExisting) {
        $.fancybox.close(true);
      } // Hide scrollbars
      // ===============


      $("body").addClass("fancybox-active");

      if (!$.fancybox.getInstance() && firstItemOpts.hideScrollbar !== false && !$.fancybox.isMobile && document.body.scrollHeight > window.innerHeight) {
        $("head").append('<style id="fancybox-style-noscroll" type="text/css">.compensate-for-scrollbar{margin-right:' + (window.innerWidth - document.documentElement.clientWidth) + "px;}</style>");
        $("body").addClass("compensate-for-scrollbar");
      } // Build html markup and set references
      // ====================================
      // Build html code for buttons and insert into main template


      buttonStr = "";
      $.each(firstItemOpts.buttons, function (index, value) {
        buttonStr += firstItemOpts.btnTpl[value] || "";
      }); // Create markup from base template, it will be initially hidden to
      // avoid unnecessary work like painting while initializing is not complete

      $container = $(self.translate(self, firstItemOpts.baseTpl.replace("{{buttons}}", buttonStr).replace("{{arrows}}", firstItemOpts.btnTpl.arrowLeft + firstItemOpts.btnTpl.arrowRight))).attr("id", "fancybox-container-" + self.id).addClass(firstItemOpts.baseClass).data("FancyBox", self).appendTo(firstItemOpts.parentEl); // Create object holding references to jQuery wrapped nodes

      self.$refs = {
        container: $container
      };
      ["bg", "inner", "infobar", "toolbar", "stage", "caption", "navigation"].forEach(function (item) {
        self.$refs[item] = $container.find(".fancybox-" + item);
      });
      self.trigger("onInit"); // Enable events, deactive previous instances

      self.activate(); // Build slides, load and reveal content

      self.jumpTo(self.currIndex);
    },
    // Simple i18n support - replaces object keys found in template
    // with corresponding values
    // ============================================================
    translate: function translate(obj, str) {
      var arr = obj.opts.i18n[obj.opts.lang] || obj.opts.i18n.en;
      return str.replace(/\{\{(\w+)\}\}/g, function (match, n) {
        return arr[n] === undefined ? match : arr[n];
      });
    },
    // Populate current group with fresh content
    // Check if each object has valid type and content
    // ===============================================
    addContent: function addContent(content) {
      var self = this,
          items = $.makeArray(content),
          thumbs;
      $.each(items, function (i, item) {
        var obj = {},
            opts = {},
            $item,
            type,
            found,
            src,
            srcParts; // Step 1 - Make sure we have an object
        // ====================================

        if ($.isPlainObject(item)) {
          // We probably have manual usage here, something like
          // $.fancybox.open( [ { src : "image.jpg", type : "image" } ] )
          obj = item;
          opts = item.opts || item;
        } else if ($.type(item) === "object" && $(item).length) {
          // Here we probably have jQuery collection returned by some selector
          $item = $(item); // Support attributes like `data-options='{"touch" : false}'` and `data-touch='false'`

          opts = $item.data() || {};
          opts = $.extend(true, {}, opts, opts.options); // Here we store clicked element

          opts.$orig = $item;
          obj.src = self.opts.src || opts.src || $item.attr("href"); // Assume that simple syntax is used, for example:
          //   `$.fancybox.open( $("#test"), {} );`

          if (!obj.type && !obj.src) {
            obj.type = "inline";
            obj.src = item;
          }
        } else {
          // Assume we have a simple html code, for example:
          //   $.fancybox.open( '<div><h1>Hi!</h1></div>' );
          obj = {
            type: "html",
            src: item + ""
          };
        } // Each gallery object has full collection of options


        obj.opts = $.extend(true, {}, self.opts, opts); // Do not merge buttons array

        if ($.isArray(opts.buttons)) {
          obj.opts.buttons = opts.buttons;
        }

        if ($.fancybox.isMobile && obj.opts.mobile) {
          obj.opts = mergeOpts(obj.opts, obj.opts.mobile);
        } // Step 2 - Make sure we have content type, if not - try to guess
        // ==============================================================


        type = obj.type || obj.opts.type;
        src = obj.src || "";

        if (!type && src) {
          if (found = src.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i)) {
            type = "video";

            if (!obj.opts.video.format) {
              obj.opts.video.format = "video/" + (found[1] === "ogv" ? "ogg" : found[1]);
            }
          } else if (src.match(/(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i)) {
            type = "image";
          } else if (src.match(/\.(pdf)((\?|#).*)?$/i)) {
            type = "iframe";
            obj = $.extend(true, obj, {
              contentType: "pdf",
              opts: {
                iframe: {
                  preload: false
                }
              }
            });
          } else if (src.charAt(0) === "#") {
            type = "inline";
          }
        }

        if (type) {
          obj.type = type;
        } else {
          self.trigger("objectNeedsType", obj);
        }

        if (!obj.contentType) {
          obj.contentType = $.inArray(obj.type, ["html", "inline", "ajax"]) > -1 ? "html" : obj.type;
        } // Step 3 - Some adjustments
        // =========================


        obj.index = self.group.length;

        if (obj.opts.smallBtn == "auto") {
          obj.opts.smallBtn = $.inArray(obj.type, ["html", "inline", "ajax"]) > -1;
        }

        if (obj.opts.toolbar === "auto") {
          obj.opts.toolbar = !obj.opts.smallBtn;
        } // Find thumbnail image, check if exists and if is in the viewport


        obj.$thumb = obj.opts.$thumb || null;

        if (obj.opts.$trigger && obj.index === self.opts.index) {
          obj.$thumb = obj.opts.$trigger.find("img:first");

          if (obj.$thumb.length) {
            obj.opts.$orig = obj.opts.$trigger;
          }
        }

        if (!(obj.$thumb && obj.$thumb.length) && obj.opts.$orig) {
          obj.$thumb = obj.opts.$orig.find("img:first");
        }

        if (obj.$thumb && !obj.$thumb.length) {
          obj.$thumb = null;
        }

        obj.thumb = obj.opts.thumb || (obj.$thumb ? obj.$thumb[0].src : null); // "caption" is a "special" option, it can be used to customize caption per gallery item

        if ($.type(obj.opts.caption) === "function") {
          obj.opts.caption = obj.opts.caption.apply(item, [self, obj]);
        }

        if ($.type(self.opts.caption) === "function") {
          obj.opts.caption = self.opts.caption.apply(item, [self, obj]);
        } // Make sure we have caption as a string or jQuery object


        if (!(obj.opts.caption instanceof $)) {
          obj.opts.caption = obj.opts.caption === undefined ? "" : obj.opts.caption + "";
        } // Check if url contains "filter" used to filter the content
        // Example: "ajax.html #something"


        if (obj.type === "ajax") {
          srcParts = src.split(/\s+/, 2);

          if (srcParts.length > 1) {
            obj.src = srcParts.shift();
            obj.opts.filter = srcParts.shift();
          }
        } // Hide all buttons and disable interactivity for modal items


        if (obj.opts.modal) {
          obj.opts = $.extend(true, obj.opts, {
            trapFocus: true,
            // Remove buttons
            infobar: 0,
            toolbar: 0,
            smallBtn: 0,
            // Disable keyboard navigation
            keyboard: 0,
            // Disable some modules
            slideShow: 0,
            fullScreen: 0,
            thumbs: 0,
            touch: 0,
            // Disable click event handlers
            clickContent: false,
            clickSlide: false,
            clickOutside: false,
            dblclickContent: false,
            dblclickSlide: false,
            dblclickOutside: false
          });
        } // Step 4 - Add processed object to group
        // ======================================


        self.group.push(obj);
      }); // Update controls if gallery is already opened

      if (Object.keys(self.slides).length) {
        self.updateControls(); // Update thumbnails, if needed

        thumbs = self.Thumbs;

        if (thumbs && thumbs.isActive) {
          thumbs.create();
          thumbs.focus();
        }
      }
    },
    // Attach an event handler functions for:
    //   - navigation buttons
    //   - browser scrolling, resizing;
    //   - focusing
    //   - keyboard
    //   - detecting inactivity
    // ======================================
    addEvents: function addEvents() {
      var self = this;
      self.removeEvents(); // Make navigation elements clickable
      // ==================================

      self.$refs.container.on("click.fb-close", "[data-fancybox-close]", function (e) {
        e.stopPropagation();
        e.preventDefault();
        self.close(e);
      }).on("touchstart.fb-prev click.fb-prev", "[data-fancybox-prev]", function (e) {
        e.stopPropagation();
        e.preventDefault();
        self.previous();
      }).on("touchstart.fb-next click.fb-next", "[data-fancybox-next]", function (e) {
        e.stopPropagation();
        e.preventDefault();
        self.next();
      }).on("click.fb", "[data-fancybox-zoom]", function (e) {
        // Click handler for zoom button
        self[self.isScaledDown() ? "scaleToActual" : "scaleToFit"]();
      }); // Handle page scrolling and browser resizing
      // ==========================================

      $W.on("orientationchange.fb resize.fb", function (e) {
        if (e && e.originalEvent && e.originalEvent.type === "resize") {
          if (self.requestId) {
            cancelAFrame(self.requestId);
          }

          self.requestId = requestAFrame(function () {
            self.update(e);
          });
        } else {
          if (self.current && self.current.type === "iframe") {
            self.$refs.stage.hide();
          }

          setTimeout(function () {
            self.$refs.stage.show();
            self.update(e);
          }, $.fancybox.isMobile ? 600 : 250);
        }
      });
      $D.on("keydown.fb", function (e) {
        var instance = $.fancybox ? $.fancybox.getInstance() : null,
            current = instance.current,
            keycode = e.keyCode || e.which; // Trap keyboard focus inside of the modal
        // =======================================

        if (keycode == 9) {
          if (current.opts.trapFocus) {
            self.focus(e);
          }

          return;
        } // Enable keyboard navigation
        // ==========================


        if (!current.opts.keyboard || e.ctrlKey || e.altKey || e.shiftKey || $(e.target).is("input,textarea,video,audio,select")) {
          return;
        } // Backspace and Esc keys


        if (keycode === 8 || keycode === 27) {
          e.preventDefault();
          self.close(e);
          return;
        } // Left arrow and Up arrow


        if (keycode === 37 || keycode === 38) {
          e.preventDefault();
          self.previous();
          return;
        } // Righ arrow and Down arrow


        if (keycode === 39 || keycode === 40) {
          e.preventDefault();
          self.next();
          return;
        }

        self.trigger("afterKeydown", e, keycode);
      }); // Hide controls after some inactivity period

      if (self.group[self.currIndex].opts.idleTime) {
        self.idleSecondsCounter = 0;
        $D.on("mousemove.fb-idle mouseleave.fb-idle mousedown.fb-idle touchstart.fb-idle touchmove.fb-idle scroll.fb-idle keydown.fb-idle", function (e) {
          self.idleSecondsCounter = 0;

          if (self.isIdle) {
            self.showControls();
          }

          self.isIdle = false;
        });
        self.idleInterval = window.setInterval(function () {
          self.idleSecondsCounter++;

          if (self.idleSecondsCounter >= self.group[self.currIndex].opts.idleTime && !self.isDragging) {
            self.isIdle = true;
            self.idleSecondsCounter = 0;
            self.hideControls();
          }
        }, 1000);
      }
    },
    // Remove events added by the core
    // ===============================
    removeEvents: function removeEvents() {
      var self = this;
      $W.off("orientationchange.fb resize.fb");
      $D.off("keydown.fb .fb-idle");
      this.$refs.container.off(".fb-close .fb-prev .fb-next");

      if (self.idleInterval) {
        window.clearInterval(self.idleInterval);
        self.idleInterval = null;
      }
    },
    // Change to previous gallery item
    // ===============================
    previous: function previous(duration) {
      return this.jumpTo(this.currPos - 1, duration);
    },
    // Change to next gallery item
    // ===========================
    next: function next(duration) {
      return this.jumpTo(this.currPos + 1, duration);
    },
    // Switch to selected gallery item
    // ===============================
    jumpTo: function jumpTo(pos, duration) {
      var self = this,
          groupLen = self.group.length,
          firstRun,
          isMoved,
          loop,
          current,
          previous,
          slidePos,
          stagePos,
          prop,
          diff;

      if (self.isDragging || self.isClosing || self.isAnimating && self.firstRun) {
        return;
      } // Should loop?


      pos = parseInt(pos, 10);
      loop = self.current ? self.current.opts.loop : self.opts.loop;

      if (!loop && (pos < 0 || pos >= groupLen)) {
        return false;
      } // Check if opening for the first time; this helps to speed things up


      firstRun = self.firstRun = !Object.keys(self.slides).length; // Create slides

      previous = self.current;
      self.prevIndex = self.currIndex;
      self.prevPos = self.currPos;
      current = self.createSlide(pos);

      if (groupLen > 1) {
        if (loop || current.index < groupLen - 1) {
          self.createSlide(pos + 1);
        }

        if (loop || current.index > 0) {
          self.createSlide(pos - 1);
        }
      }

      self.current = current;
      self.currIndex = current.index;
      self.currPos = current.pos;
      self.trigger("beforeShow", firstRun);
      self.updateControls(); // Validate duration length

      current.forcedDuration = undefined;

      if ($.isNumeric(duration)) {
        current.forcedDuration = duration;
      } else {
        duration = current.opts[firstRun ? "animationDuration" : "transitionDuration"];
      }

      duration = parseInt(duration, 10); // Check if user has swiped the slides or if still animating

      isMoved = self.isMoved(current); // Make sure current slide is visible

      current.$slide.addClass("fancybox-slide--current"); // Fresh start - reveal container, current slide and start loading content

      if (firstRun) {
        if (current.opts.animationEffect && duration) {
          self.$refs.container.css("transition-duration", duration + "ms");
        }

        self.$refs.container.addClass("fancybox-is-open").trigger("focus"); // Attempt to load content into slide
        // This will later call `afterLoad` -> `revealContent`

        self.loadSlide(current);
        self.preload("image");
        return;
      } // Get actual slide/stage positions (before cleaning up)


      slidePos = $.fancybox.getTranslate(previous.$slide);
      stagePos = $.fancybox.getTranslate(self.$refs.stage); // Clean up all slides

      $.each(self.slides, function (index, slide) {
        $.fancybox.stop(slide.$slide, true);
      });

      if (previous.pos !== current.pos) {
        previous.isComplete = false;
      }

      previous.$slide.removeClass("fancybox-slide--complete fancybox-slide--current"); // If slides are out of place, then animate them to correct position

      if (isMoved) {
        // Calculate horizontal swipe distance
        diff = slidePos.left - (previous.pos * slidePos.width + previous.pos * previous.opts.gutter);
        $.each(self.slides, function (index, slide) {
          slide.$slide.removeClass("fancybox-animated").removeClass(function (index, className) {
            return (className.match(/(^|\s)fancybox-fx-\S+/g) || []).join(" ");
          }); // Make sure that each slide is in equal distance
          // This is mostly needed for freshly added slides, because they are not yet positioned

          var leftPos = slide.pos * slidePos.width + slide.pos * slide.opts.gutter;
          $.fancybox.setTranslate(slide.$slide, {
            top: 0,
            left: leftPos - stagePos.left + diff
          });

          if (slide.pos !== current.pos) {
            slide.$slide.addClass("fancybox-slide--" + (slide.pos > current.pos ? "next" : "previous"));
          } // Redraw to make sure that transition will start


          forceRedraw(slide.$slide); // Animate the slide

          $.fancybox.animate(slide.$slide, {
            top: 0,
            left: (slide.pos - current.pos) * slidePos.width + (slide.pos - current.pos) * slide.opts.gutter
          }, duration, function () {
            slide.$slide.css({
              transform: "",
              opacity: ""
            }).removeClass("fancybox-slide--next fancybox-slide--previous");

            if (slide.pos === self.currPos) {
              self.complete();
            }
          });
        });
      } else if (duration && current.opts.transitionEffect) {
        // Set transition effect for previously active slide
        prop = "fancybox-animated fancybox-fx-" + current.opts.transitionEffect;
        previous.$slide.addClass("fancybox-slide--" + (previous.pos > current.pos ? "next" : "previous"));
        $.fancybox.animate(previous.$slide, prop, duration, function () {
          previous.$slide.removeClass(prop).removeClass("fancybox-slide--next fancybox-slide--previous");
        }, false);
      }

      if (current.isLoaded) {
        self.revealContent(current);
      } else {
        self.loadSlide(current);
      }

      self.preload("image");
    },
    // Create new "slide" element
    // These are gallery items  that are actually added to DOM
    // =======================================================
    createSlide: function createSlide(pos) {
      var self = this,
          $slide,
          index;
      index = pos % self.group.length;
      index = index < 0 ? self.group.length + index : index;

      if (!self.slides[pos] && self.group[index]) {
        $slide = $('<div class="fancybox-slide"></div>').appendTo(self.$refs.stage);
        self.slides[pos] = $.extend(true, {}, self.group[index], {
          pos: pos,
          $slide: $slide,
          isLoaded: false
        });
        self.updateSlide(self.slides[pos]);
      }

      return self.slides[pos];
    },
    // Scale image to the actual size of the image;
    // x and y values should be relative to the slide
    // ==============================================
    scaleToActual: function scaleToActual(x, y, duration) {
      var self = this,
          current = self.current,
          $content = current.$content,
          canvasWidth = $.fancybox.getTranslate(current.$slide).width,
          canvasHeight = $.fancybox.getTranslate(current.$slide).height,
          newImgWidth = current.width,
          newImgHeight = current.height,
          imgPos,
          posX,
          posY,
          scaleX,
          scaleY;

      if (self.isAnimating || self.isMoved() || !$content || !(current.type == "image" && current.isLoaded && !current.hasError)) {
        return;
      }

      self.isAnimating = true;
      $.fancybox.stop($content);
      x = x === undefined ? canvasWidth * 0.5 : x;
      y = y === undefined ? canvasHeight * 0.5 : y;
      imgPos = $.fancybox.getTranslate($content);
      imgPos.top -= $.fancybox.getTranslate(current.$slide).top;
      imgPos.left -= $.fancybox.getTranslate(current.$slide).left;
      scaleX = newImgWidth / imgPos.width;
      scaleY = newImgHeight / imgPos.height; // Get center position for original image

      posX = canvasWidth * 0.5 - newImgWidth * 0.5;
      posY = canvasHeight * 0.5 - newImgHeight * 0.5; // Make sure image does not move away from edges

      if (newImgWidth > canvasWidth) {
        posX = imgPos.left * scaleX - (x * scaleX - x);

        if (posX > 0) {
          posX = 0;
        }

        if (posX < canvasWidth - newImgWidth) {
          posX = canvasWidth - newImgWidth;
        }
      }

      if (newImgHeight > canvasHeight) {
        posY = imgPos.top * scaleY - (y * scaleY - y);

        if (posY > 0) {
          posY = 0;
        }

        if (posY < canvasHeight - newImgHeight) {
          posY = canvasHeight - newImgHeight;
        }
      }

      self.updateCursor(newImgWidth, newImgHeight);
      $.fancybox.animate($content, {
        top: posY,
        left: posX,
        scaleX: scaleX,
        scaleY: scaleY
      }, duration || 366, function () {
        self.isAnimating = false;
      }); // Stop slideshow

      if (self.SlideShow && self.SlideShow.isActive) {
        self.SlideShow.stop();
      }
    },
    // Scale image to fit inside parent element
    // ========================================
    scaleToFit: function scaleToFit(duration) {
      var self = this,
          current = self.current,
          $content = current.$content,
          end;

      if (self.isAnimating || self.isMoved() || !$content || !(current.type == "image" && current.isLoaded && !current.hasError)) {
        return;
      }

      self.isAnimating = true;
      $.fancybox.stop($content);
      end = self.getFitPos(current);
      self.updateCursor(end.width, end.height);
      $.fancybox.animate($content, {
        top: end.top,
        left: end.left,
        scaleX: end.width / $content.width(),
        scaleY: end.height / $content.height()
      }, duration || 366, function () {
        self.isAnimating = false;
      });
    },
    // Calculate image size to fit inside viewport
    // ===========================================
    getFitPos: function getFitPos(slide) {
      var self = this,
          $content = slide.$content,
          $slide = slide.$slide,
          width = slide.width || slide.opts.width,
          height = slide.height || slide.opts.height,
          maxWidth,
          maxHeight,
          minRatio,
          aspectRatio,
          rez = {};

      if (!slide.isLoaded || !$content || !$content.length) {
        return false;
      }

      maxWidth = $.fancybox.getTranslate(self.$refs.stage).width;
      maxHeight = $.fancybox.getTranslate(self.$refs.stage).height;
      maxWidth -= parseFloat($slide.css("paddingLeft")) + parseFloat($slide.css("paddingRight")) + parseFloat($content.css("marginLeft")) + parseFloat($content.css("marginRight"));
      maxHeight -= parseFloat($slide.css("paddingTop")) + parseFloat($slide.css("paddingBottom")) + parseFloat($content.css("marginTop")) + parseFloat($content.css("marginBottom"));

      if (!width || !height) {
        width = maxWidth;
        height = maxHeight;
      }

      minRatio = Math.min(1, maxWidth / width, maxHeight / height);
      width = minRatio * width;
      height = minRatio * height; // Adjust width/height to precisely fit into container

      if (width > maxWidth - 0.5) {
        width = maxWidth;
      }

      if (height > maxHeight - 0.5) {
        height = maxHeight;
      }

      if (slide.type === "image") {
        rez.top = Math.floor((maxHeight - height) * 0.5) + parseFloat($slide.css("paddingTop"));
        rez.left = Math.floor((maxWidth - width) * 0.5) + parseFloat($slide.css("paddingLeft"));
      } else if (slide.contentType === "video") {
        // Force aspect ratio for the video
        // "I say the whole world must learn of our peaceful ways… by force!"
        aspectRatio = slide.opts.width && slide.opts.height ? width / height : slide.opts.ratio || 16 / 9;

        if (height > width / aspectRatio) {
          height = width / aspectRatio;
        } else if (width > height * aspectRatio) {
          width = height * aspectRatio;
        }
      }

      rez.width = width;
      rez.height = height;
      return rez;
    },
    // Update content size and position for all slides
    // ==============================================
    update: function update(e) {
      var self = this;
      $.each(self.slides, function (key, slide) {
        self.updateSlide(slide, e);
      });
    },
    // Update slide content position and size
    // ======================================
    updateSlide: function updateSlide(slide, e) {
      var self = this,
          $content = slide && slide.$content,
          width = slide.width || slide.opts.width,
          height = slide.height || slide.opts.height,
          $slide = slide.$slide; // First, prevent caption overlap, if needed

      self.adjustCaption(slide); // Then resize content to fit inside the slide

      if ($content && (width || height || slide.contentType === "video") && !slide.hasError) {
        $.fancybox.stop($content);
        $.fancybox.setTranslate($content, self.getFitPos(slide));

        if (slide.pos === self.currPos) {
          self.isAnimating = false;
          self.updateCursor();
        }
      } // Then some adjustments


      self.adjustLayout(slide);

      if ($slide.length) {
        $slide.trigger("refresh");

        if (slide.pos === self.currPos) {
          self.$refs.toolbar.add(self.$refs.navigation.find(".fancybox-button--arrow_right")).toggleClass("compensate-for-scrollbar", $slide.get(0).scrollHeight > $slide.get(0).clientHeight);
        }
      }

      self.trigger("onUpdate", slide, e);
    },
    // Horizontally center slide
    // =========================
    centerSlide: function centerSlide(duration) {
      var self = this,
          current = self.current,
          $slide = current.$slide;

      if (self.isClosing || !current) {
        return;
      }

      $slide.siblings().css({
        transform: "",
        opacity: ""
      });
      $slide.parent().children().removeClass("fancybox-slide--previous fancybox-slide--next");
      $.fancybox.animate($slide, {
        top: 0,
        left: 0,
        opacity: 1
      }, duration === undefined ? 0 : duration, function () {
        // Clean up
        $slide.css({
          transform: "",
          opacity: ""
        });

        if (!current.isComplete) {
          self.complete();
        }
      }, false);
    },
    // Check if current slide is moved (swiped)
    // ========================================
    isMoved: function isMoved(slide) {
      var current = slide || this.current,
          slidePos,
          stagePos;

      if (!current) {
        return false;
      }

      stagePos = $.fancybox.getTranslate(this.$refs.stage);
      slidePos = $.fancybox.getTranslate(current.$slide);
      return !current.$slide.hasClass("fancybox-animated") && (Math.abs(slidePos.top - stagePos.top) > 0.5 || Math.abs(slidePos.left - stagePos.left) > 0.5);
    },
    // Update cursor style depending if content can be zoomed
    // ======================================================
    updateCursor: function updateCursor(nextWidth, nextHeight) {
      var self = this,
          current = self.current,
          $container = self.$refs.container,
          canPan,
          isZoomable;

      if (!current || self.isClosing || !self.Guestures) {
        return;
      }

      $container.removeClass("fancybox-is-zoomable fancybox-can-zoomIn fancybox-can-zoomOut fancybox-can-swipe fancybox-can-pan");
      canPan = self.canPan(nextWidth, nextHeight);
      isZoomable = canPan ? true : self.isZoomable();
      $container.toggleClass("fancybox-is-zoomable", isZoomable);
      $("[data-fancybox-zoom]").prop("disabled", !isZoomable);

      if (canPan) {
        $container.addClass("fancybox-can-pan");
      } else if (isZoomable && (current.opts.clickContent === "zoom" || $.isFunction(current.opts.clickContent) && current.opts.clickContent(current) == "zoom")) {
        $container.addClass("fancybox-can-zoomIn");
      } else if (current.opts.touch && (current.opts.touch.vertical || self.group.length > 1) && current.contentType !== "video") {
        $container.addClass("fancybox-can-swipe");
      }
    },
    // Check if current slide is zoomable
    // ==================================
    isZoomable: function isZoomable() {
      var self = this,
          current = self.current,
          fitPos; // Assume that slide is zoomable if:
      //   - image is still loading
      //   - actual size of the image is smaller than available area

      if (current && !self.isClosing && current.type === "image" && !current.hasError) {
        if (!current.isLoaded) {
          return true;
        }

        fitPos = self.getFitPos(current);

        if (fitPos && (current.width > fitPos.width || current.height > fitPos.height)) {
          return true;
        }
      }

      return false;
    },
    // Check if current image dimensions are smaller than actual
    // =========================================================
    isScaledDown: function isScaledDown(nextWidth, nextHeight) {
      var self = this,
          rez = false,
          current = self.current,
          $content = current.$content;

      if (nextWidth !== undefined && nextHeight !== undefined) {
        rez = nextWidth < current.width && nextHeight < current.height;
      } else if ($content) {
        rez = $.fancybox.getTranslate($content);
        rez = rez.width < current.width && rez.height < current.height;
      }

      return rez;
    },
    // Check if image dimensions exceed parent element
    // ===============================================
    canPan: function canPan(nextWidth, nextHeight) {
      var self = this,
          current = self.current,
          pos = null,
          rez = false;

      if (current.type === "image" && (current.isComplete || nextWidth && nextHeight) && !current.hasError) {
        rez = self.getFitPos(current);

        if (nextWidth !== undefined && nextHeight !== undefined) {
          pos = {
            width: nextWidth,
            height: nextHeight
          };
        } else if (current.isComplete) {
          pos = $.fancybox.getTranslate(current.$content);
        }

        if (pos && rez) {
          rez = Math.abs(pos.width - rez.width) > 1.5 || Math.abs(pos.height - rez.height) > 1.5;
        }
      }

      return rez;
    },
    // Load content into the slide
    // ===========================
    loadSlide: function loadSlide(slide) {
      var self = this,
          type,
          $slide,
          ajaxLoad;

      if (slide.isLoading || slide.isLoaded) {
        return;
      }

      slide.isLoading = true;

      if (self.trigger("beforeLoad", slide) === false) {
        slide.isLoading = false;
        return false;
      }

      type = slide.type;
      $slide = slide.$slide;
      $slide.off("refresh").trigger("onReset").addClass(slide.opts.slideClass); // Create content depending on the type

      switch (type) {
        case "image":
          self.setImage(slide);
          break;

        case "iframe":
          self.setIframe(slide);
          break;

        case "html":
          self.setContent(slide, slide.src || slide.content);
          break;

        case "video":
          self.setContent(slide, slide.opts.video.tpl.replace(/\{\{src\}\}/gi, slide.src).replace("{{format}}", slide.opts.videoFormat || slide.opts.video.format || "").replace("{{poster}}", slide.thumb || ""));
          break;

        case "inline":
          if ($(slide.src).length) {
            self.setContent(slide, $(slide.src));
          } else {
            self.setError(slide);
          }

          break;

        case "ajax":
          self.showLoading(slide);
          ajaxLoad = $.ajax($.extend({}, slide.opts.ajax.settings, {
            url: slide.src,
            success: function success(data, textStatus) {
              if (textStatus === "success") {
                self.setContent(slide, data);
              }
            },
            error: function error(jqXHR, textStatus) {
              if (jqXHR && textStatus !== "abort") {
                self.setError(slide);
              }
            }
          }));
          $slide.one("onReset", function () {
            ajaxLoad.abort();
          });
          break;

        default:
          self.setError(slide);
          break;
      }

      return true;
    },
    // Use thumbnail image, if possible
    // ================================
    setImage: function setImage(slide) {
      var self = this,
          ghost; // Check if need to show loading icon

      setTimeout(function () {
        var $img = slide.$image;

        if (!self.isClosing && slide.isLoading && (!$img || !$img.length || !$img[0].complete) && !slide.hasError) {
          self.showLoading(slide);
        }
      }, 50); //Check if image has srcset

      self.checkSrcset(slide); // This will be wrapper containing both ghost and actual image

      slide.$content = $('<div class="fancybox-content"></div>').addClass("fancybox-is-hidden").appendTo(slide.$slide.addClass("fancybox-slide--image")); // If we have a thumbnail, we can display it while actual image is loading
      // Users will not stare at black screen and actual image will appear gradually

      if (slide.opts.preload !== false && slide.opts.width && slide.opts.height && slide.thumb) {
        slide.width = slide.opts.width;
        slide.height = slide.opts.height;
        ghost = document.createElement("img");

        ghost.onerror = function () {
          $(this).remove();
          slide.$ghost = null;
        };

        ghost.onload = function () {
          self.afterLoad(slide);
        };

        slide.$ghost = $(ghost).addClass("fancybox-image").appendTo(slide.$content).attr("src", slide.thumb);
      } // Start loading actual image


      self.setBigImage(slide);
    },
    // Check if image has srcset and get the source
    // ============================================
    checkSrcset: function checkSrcset(slide) {
      var srcset = slide.opts.srcset || slide.opts.image.srcset,
          found,
          temp,
          pxRatio,
          windowWidth; // If we have "srcset", then we need to find first matching "src" value.
      // This is necessary, because when you set an src attribute, the browser will preload the image
      // before any javascript or even CSS is applied.

      if (srcset) {
        pxRatio = window.devicePixelRatio || 1;
        windowWidth = window.innerWidth * pxRatio;
        temp = srcset.split(",").map(function (el) {
          var ret = {};
          el.trim().split(/\s+/).forEach(function (el, i) {
            var value = parseInt(el.substring(0, el.length - 1), 10);

            if (i === 0) {
              return ret.url = el;
            }

            if (value) {
              ret.value = value;
              ret.postfix = el[el.length - 1];
            }
          });
          return ret;
        }); // Sort by value

        temp.sort(function (a, b) {
          return a.value - b.value;
        }); // Ok, now we have an array of all srcset values

        for (var j = 0; j < temp.length; j++) {
          var el = temp[j];

          if (el.postfix === "w" && el.value >= windowWidth || el.postfix === "x" && el.value >= pxRatio) {
            found = el;
            break;
          }
        } // If not found, take the last one


        if (!found && temp.length) {
          found = temp[temp.length - 1];
        }

        if (found) {
          slide.src = found.url; // If we have default width/height values, we can calculate height for matching source

          if (slide.width && slide.height && found.postfix == "w") {
            slide.height = slide.width / slide.height * found.value;
            slide.width = found.value;
          }

          slide.opts.srcset = srcset;
        }
      }
    },
    // Create full-size image
    // ======================
    setBigImage: function setBigImage(slide) {
      var self = this,
          img = document.createElement("img"),
          $img = $(img);
      slide.$image = $img.one("error", function () {
        self.setError(slide);
      }).one("load", function () {
        var sizes;

        if (!slide.$ghost) {
          self.resolveImageSlideSize(slide, this.naturalWidth, this.naturalHeight);
          self.afterLoad(slide);
        }

        if (self.isClosing) {
          return;
        }

        if (slide.opts.srcset) {
          sizes = slide.opts.sizes;

          if (!sizes || sizes === "auto") {
            sizes = (slide.width / slide.height > 1 && $W.width() / $W.height() > 1 ? "100" : Math.round(slide.width / slide.height * 100)) + "vw";
          }

          $img.attr("sizes", sizes).attr("srcset", slide.opts.srcset);
        } // Hide temporary image after some delay


        if (slide.$ghost) {
          setTimeout(function () {
            if (slide.$ghost && !self.isClosing) {
              slide.$ghost.hide();
            }
          }, Math.min(300, Math.max(1000, slide.height / 1600)));
        }

        self.hideLoading(slide);
      }).addClass("fancybox-image").attr("src", slide.src).appendTo(slide.$content);

      if ((img.complete || img.readyState == "complete") && $img.naturalWidth && $img.naturalHeight) {
        $img.trigger("load");
      } else if (img.error) {
        $img.trigger("error");
      }
    },
    // Computes the slide size from image size and maxWidth/maxHeight
    // ==============================================================
    resolveImageSlideSize: function resolveImageSlideSize(slide, imgWidth, imgHeight) {
      var maxWidth = parseInt(slide.opts.width, 10),
          maxHeight = parseInt(slide.opts.height, 10); // Sets the default values from the image

      slide.width = imgWidth;
      slide.height = imgHeight;

      if (maxWidth > 0) {
        slide.width = maxWidth;
        slide.height = Math.floor(maxWidth * imgHeight / imgWidth);
      }

      if (maxHeight > 0) {
        slide.width = Math.floor(maxHeight * imgWidth / imgHeight);
        slide.height = maxHeight;
      }
    },
    // Create iframe wrapper, iframe and bindings
    // ==========================================
    setIframe: function setIframe(slide) {
      var self = this,
          opts = slide.opts.iframe,
          $slide = slide.$slide,
          $iframe;
      slide.$content = $('<div class="fancybox-content' + (opts.preload ? " fancybox-is-hidden" : "") + '"></div>').css(opts.css).appendTo($slide);
      $slide.addClass("fancybox-slide--" + slide.contentType);
      slide.$iframe = $iframe = $(opts.tpl.replace(/\{rnd\}/g, new Date().getTime())).attr(opts.attr).appendTo(slide.$content);

      if (opts.preload) {
        self.showLoading(slide); // Unfortunately, it is not always possible to determine if iframe is successfully loaded
        // (due to browser security policy)

        $iframe.on("load.fb error.fb", function (e) {
          this.isReady = 1;
          slide.$slide.trigger("refresh");
          self.afterLoad(slide);
        }); // Recalculate iframe content size
        // ===============================

        $slide.on("refresh.fb", function () {
          var $content = slide.$content,
              frameWidth = opts.css.width,
              frameHeight = opts.css.height,
              $contents,
              $body;

          if ($iframe[0].isReady !== 1) {
            return;
          }

          try {
            $contents = $iframe.contents();
            $body = $contents.find("body");
          } catch (ignore) {} // Calculate content dimensions, if it is accessible


          if ($body && $body.length && $body.children().length) {
            // Avoid scrolling to top (if multiple instances)
            $slide.css("overflow", "visible");
            $content.css({
              width: "100%",
              "max-width": "100%",
              height: "9999px"
            });

            if (frameWidth === undefined) {
              frameWidth = Math.ceil(Math.max($body[0].clientWidth, $body.outerWidth(true)));
            }

            $content.css("width", frameWidth ? frameWidth : "").css("max-width", "");

            if (frameHeight === undefined) {
              frameHeight = Math.ceil(Math.max($body[0].clientHeight, $body.outerHeight(true)));
            }

            $content.css("height", frameHeight ? frameHeight : "");
            $slide.css("overflow", "auto");
          }

          $content.removeClass("fancybox-is-hidden");
        });
      } else {
        self.afterLoad(slide);
      }

      $iframe.attr("src", slide.src); // Remove iframe if closing or changing gallery item

      $slide.one("onReset", function () {
        // This helps IE not to throw errors when closing
        try {
          $(this).find("iframe").hide().unbind().attr("src", "//about:blank");
        } catch (ignore) {}

        $(this).off("refresh.fb").empty();
        slide.isLoaded = false;
        slide.isRevealed = false;
      });
    },
    // Wrap and append content to the slide
    // ======================================
    setContent: function setContent(slide, content) {
      var self = this;

      if (self.isClosing) {
        return;
      }

      self.hideLoading(slide);

      if (slide.$content) {
        $.fancybox.stop(slide.$content);
      }

      slide.$slide.empty(); // If content is a jQuery object, then it will be moved to the slide.
      // The placeholder is created so we will know where to put it back.

      if (isQuery(content) && content.parent().length) {
        // Make sure content is not already moved to fancyBox
        if (content.hasClass("fancybox-content") || content.parent().hasClass("fancybox-content")) {
          content.parents(".fancybox-slide").trigger("onReset");
        } // Create temporary element marking original place of the content


        slide.$placeholder = $("<div>").hide().insertAfter(content); // Make sure content is visible

        content.css("display", "inline-block");
      } else if (!slide.hasError) {
        // If content is just a plain text, try to convert it to html
        if ($.type(content) === "string") {
          content = $("<div>").append($.trim(content)).contents();
        } // If "filter" option is provided, then filter content


        if (slide.opts.filter) {
          content = $("<div>").html(content).find(slide.opts.filter);
        }
      }

      slide.$slide.one("onReset", function () {
        // Pause all html5 video/audio
        $(this).find("video,audio").trigger("pause"); // Put content back

        if (slide.$placeholder) {
          slide.$placeholder.after(content.removeClass("fancybox-content").hide()).remove();
          slide.$placeholder = null;
        } // Remove custom close button


        if (slide.$smallBtn) {
          slide.$smallBtn.remove();
          slide.$smallBtn = null;
        } // Remove content and mark slide as not loaded


        if (!slide.hasError) {
          $(this).empty();
          slide.isLoaded = false;
          slide.isRevealed = false;
        }
      });
      $(content).appendTo(slide.$slide);

      if ($(content).is("video,audio")) {
        $(content).addClass("fancybox-video");
        $(content).wrap("<div></div>");
        slide.contentType = "video";
        slide.opts.width = slide.opts.width || $(content).attr("width");
        slide.opts.height = slide.opts.height || $(content).attr("height");
      }

      slide.$content = slide.$slide.children().filter("div,form,main,video,audio,article,.fancybox-content").first();
      slide.$content.siblings().hide(); // Re-check if there is a valid content
      // (in some cases, ajax response can contain various elements or plain text)

      if (!slide.$content.length) {
        slide.$content = slide.$slide.wrapInner("<div></div>").children().first();
      }

      slide.$content.addClass("fancybox-content");
      slide.$slide.addClass("fancybox-slide--" + slide.contentType);
      self.afterLoad(slide);
    },
    // Display error message
    // =====================
    setError: function setError(slide) {
      slide.hasError = true;
      slide.$slide.trigger("onReset").removeClass("fancybox-slide--" + slide.contentType).addClass("fancybox-slide--error");
      slide.contentType = "html";
      this.setContent(slide, this.translate(slide, slide.opts.errorTpl));

      if (slide.pos === this.currPos) {
        this.isAnimating = false;
      }
    },
    // Show loading icon inside the slide
    // ==================================
    showLoading: function showLoading(slide) {
      var self = this;
      slide = slide || self.current;

      if (slide && !slide.$spinner) {
        slide.$spinner = $(self.translate(self, self.opts.spinnerTpl)).appendTo(slide.$slide).hide().fadeIn("fast");
      }
    },
    // Remove loading icon from the slide
    // ==================================
    hideLoading: function hideLoading(slide) {
      var self = this;
      slide = slide || self.current;

      if (slide && slide.$spinner) {
        slide.$spinner.stop().remove();
        delete slide.$spinner;
      }
    },
    // Adjustments after slide content has been loaded
    // ===============================================
    afterLoad: function afterLoad(slide) {
      var self = this;

      if (self.isClosing) {
        return;
      }

      slide.isLoading = false;
      slide.isLoaded = true;
      self.trigger("afterLoad", slide);
      self.hideLoading(slide); // Add small close button

      if (slide.opts.smallBtn && (!slide.$smallBtn || !slide.$smallBtn.length)) {
        slide.$smallBtn = $(self.translate(slide, slide.opts.btnTpl.smallBtn)).appendTo(slide.$content);
      } // Disable right click


      if (slide.opts.protect && slide.$content && !slide.hasError) {
        slide.$content.on("contextmenu.fb", function (e) {
          if (e.button == 2) {
            e.preventDefault();
          }

          return true;
        }); // Add fake element on top of the image
        // This makes a bit harder for user to select image

        if (slide.type === "image") {
          $('<div class="fancybox-spaceball"></div>').appendTo(slide.$content);
        }
      }

      self.adjustCaption(slide);
      self.adjustLayout(slide);

      if (slide.pos === self.currPos) {
        self.updateCursor();
      }

      self.revealContent(slide);
    },
    // Prevent caption overlap,
    // fix css inconsistency across browsers
    // =====================================
    adjustCaption: function adjustCaption(slide) {
      var self = this,
          current = slide || self.current,
          caption = current.opts.caption,
          preventOverlap = current.opts.preventCaptionOverlap,
          $caption = self.$refs.caption,
          $clone,
          captionH = false;
      $caption.toggleClass("fancybox-caption--separate", preventOverlap);

      if (preventOverlap && caption && caption.length) {
        if (current.pos !== self.currPos) {
          $clone = $caption.clone().appendTo($caption.parent());
          $clone.children().eq(0).empty().html(caption);
          captionH = $clone.outerHeight(true);
          $clone.empty().remove();
        } else if (self.$caption) {
          captionH = self.$caption.outerHeight(true);
        }

        current.$slide.css("padding-bottom", captionH || "");
      }
    },
    // Simple hack to fix inconsistency across browsers, described here (affects Edge, too):
    // https://bugzilla.mozilla.org/show_bug.cgi?id=748518
    // ====================================================================================
    adjustLayout: function adjustLayout(slide) {
      var self = this,
          current = slide || self.current,
          scrollHeight,
          marginBottom,
          inlinePadding,
          actualPadding;

      if (current.isLoaded && current.opts.disableLayoutFix !== true) {
        current.$content.css("margin-bottom", ""); // If we would always set margin-bottom for the content,
        // then it would potentially break vertical align

        if (current.$content.outerHeight() > current.$slide.height() + 0.5) {
          inlinePadding = current.$slide[0].style["padding-bottom"];
          actualPadding = current.$slide.css("padding-bottom");

          if (parseFloat(actualPadding) > 0) {
            scrollHeight = current.$slide[0].scrollHeight;
            current.$slide.css("padding-bottom", 0);

            if (Math.abs(scrollHeight - current.$slide[0].scrollHeight) < 1) {
              marginBottom = actualPadding;
            }

            current.$slide.css("padding-bottom", inlinePadding);
          }
        }

        current.$content.css("margin-bottom", marginBottom);
      }
    },
    // Make content visible
    // This method is called right after content has been loaded or
    // user navigates gallery and transition should start
    // ============================================================
    revealContent: function revealContent(slide) {
      var self = this,
          $slide = slide.$slide,
          end = false,
          start = false,
          isMoved = self.isMoved(slide),
          isRevealed = slide.isRevealed,
          effect,
          effectClassName,
          duration,
          opacity;
      slide.isRevealed = true;
      effect = slide.opts[self.firstRun ? "animationEffect" : "transitionEffect"];
      duration = slide.opts[self.firstRun ? "animationDuration" : "transitionDuration"];
      duration = parseInt(slide.forcedDuration === undefined ? duration : slide.forcedDuration, 10);

      if (isMoved || slide.pos !== self.currPos || !duration) {
        effect = false;
      } // Check if can zoom


      if (effect === "zoom") {
        if (slide.pos === self.currPos && duration && slide.type === "image" && !slide.hasError && (start = self.getThumbPos(slide))) {
          end = self.getFitPos(slide);
        } else {
          effect = "fade";
        }
      } // Zoom animation
      // ==============


      if (effect === "zoom") {
        self.isAnimating = true;
        end.scaleX = end.width / start.width;
        end.scaleY = end.height / start.height; // Check if we need to animate opacity

        opacity = slide.opts.zoomOpacity;

        if (opacity == "auto") {
          opacity = Math.abs(slide.width / slide.height - start.width / start.height) > 0.1;
        }

        if (opacity) {
          start.opacity = 0.1;
          end.opacity = 1;
        } // Draw image at start position


        $.fancybox.setTranslate(slide.$content.removeClass("fancybox-is-hidden"), start);
        forceRedraw(slide.$content); // Start animation

        $.fancybox.animate(slide.$content, end, duration, function () {
          self.isAnimating = false;
          self.complete();
        });
        return;
      }

      self.updateSlide(slide); // Simply show content if no effect
      // ================================

      if (!effect) {
        slide.$content.removeClass("fancybox-is-hidden");

        if (!isRevealed && isMoved && slide.type === "image" && !slide.hasError) {
          slide.$content.hide().fadeIn("fast");
        }

        if (slide.pos === self.currPos) {
          self.complete();
        }

        return;
      } // Prepare for CSS transiton
      // =========================


      $.fancybox.stop($slide); //effectClassName = "fancybox-animated fancybox-slide--" + (slide.pos >= self.prevPos ? "next" : "previous") + " fancybox-fx-" + effect;

      effectClassName = "fancybox-slide--" + (slide.pos >= self.prevPos ? "next" : "previous") + " fancybox-animated fancybox-fx-" + effect;
      $slide.addClass(effectClassName).removeClass("fancybox-slide--current"); //.addClass(effectClassName);

      slide.$content.removeClass("fancybox-is-hidden"); // Force reflow

      forceRedraw($slide);

      if (slide.type !== "image") {
        slide.$content.hide().show(0);
      }

      $.fancybox.animate($slide, "fancybox-slide--current", duration, function () {
        $slide.removeClass(effectClassName).css({
          transform: "",
          opacity: ""
        });

        if (slide.pos === self.currPos) {
          self.complete();
        }
      }, true);
    },
    // Check if we can and have to zoom from thumbnail
    //================================================
    getThumbPos: function getThumbPos(slide) {
      var rez = false,
          $thumb = slide.$thumb,
          thumbPos,
          btw,
          brw,
          bbw,
          blw;

      if (!$thumb || !inViewport($thumb[0])) {
        return false;
      }

      thumbPos = $.fancybox.getTranslate($thumb);
      btw = parseFloat($thumb.css("border-top-width") || 0);
      brw = parseFloat($thumb.css("border-right-width") || 0);
      bbw = parseFloat($thumb.css("border-bottom-width") || 0);
      blw = parseFloat($thumb.css("border-left-width") || 0);
      rez = {
        top: thumbPos.top + btw,
        left: thumbPos.left + blw,
        width: thumbPos.width - brw - blw,
        height: thumbPos.height - btw - bbw,
        scaleX: 1,
        scaleY: 1
      };
      return thumbPos.width > 0 && thumbPos.height > 0 ? rez : false;
    },
    // Final adjustments after current gallery item is moved to position
    // and it`s content is loaded
    // ==================================================================
    complete: function complete() {
      var self = this,
          current = self.current,
          slides = {},
          $el;

      if (self.isMoved() || !current.isLoaded) {
        return;
      }

      if (!current.isComplete) {
        current.isComplete = true;
        current.$slide.siblings().trigger("onReset");
        self.preload("inline"); // Trigger any CSS transiton inside the slide

        forceRedraw(current.$slide);
        current.$slide.addClass("fancybox-slide--complete"); // Remove unnecessary slides

        $.each(self.slides, function (key, slide) {
          if (slide.pos >= self.currPos - 1 && slide.pos <= self.currPos + 1) {
            slides[slide.pos] = slide;
          } else if (slide) {
            $.fancybox.stop(slide.$slide);
            slide.$slide.off().remove();
          }
        });
        self.slides = slides;
      }

      self.isAnimating = false;
      self.updateCursor();
      self.trigger("afterShow"); // Autoplay first html5 video/audio

      if (!!current.opts.video.autoStart) {
        current.$slide.find("video,audio").filter(":visible:first").trigger("play").one("ended", function () {
          if (Document.exitFullscreen) {
            Document.exitFullscreen();
          } else if (this.webkitExitFullscreen) {
            this.webkitExitFullscreen();
          }

          self.next();
        });
      } // Try to focus on the first focusable element


      if (current.opts.autoFocus && current.contentType === "html") {
        // Look for the first input with autofocus attribute
        $el = current.$content.find("input[autofocus]:enabled:visible:first");

        if ($el.length) {
          $el.trigger("focus");
        } else {
          self.focus(null, true);
        }
      } // Avoid jumping


      current.$slide.scrollTop(0).scrollLeft(0);
    },
    // Preload next and previous slides
    // ================================
    preload: function preload(type) {
      var self = this,
          prev,
          next;

      if (self.group.length < 2) {
        return;
      }

      next = self.slides[self.currPos + 1];
      prev = self.slides[self.currPos - 1];

      if (prev && prev.type === type) {
        self.loadSlide(prev);
      }

      if (next && next.type === type) {
        self.loadSlide(next);
      }
    },
    // Try to find and focus on the first focusable element
    // ====================================================
    focus: function focus(e, firstRun) {
      var self = this,
          focusableStr = ["a[href]", "area[href]", 'input:not([disabled]):not([type="hidden"]):not([aria-hidden])', "select:not([disabled]):not([aria-hidden])", "textarea:not([disabled]):not([aria-hidden])", "button:not([disabled]):not([aria-hidden])", "iframe", "object", "embed", "video", "audio", "[contenteditable]", '[tabindex]:not([tabindex^="-"])'].join(","),
          focusableItems,
          focusedItemIndex;

      if (self.isClosing) {
        return;
      }

      if (e || !self.current || !self.current.isComplete) {
        // Focus on any element inside fancybox
        focusableItems = self.$refs.container.find("*:visible");
      } else {
        // Focus inside current slide
        focusableItems = self.current.$slide.find("*:visible" + (firstRun ? ":not(.fancybox-close-small)" : ""));
      }

      focusableItems = focusableItems.filter(focusableStr).filter(function () {
        return $(this).css("visibility") !== "hidden" && !$(this).hasClass("disabled");
      });

      if (focusableItems.length) {
        focusedItemIndex = focusableItems.index(document.activeElement);

        if (e && e.shiftKey) {
          // Back tab
          if (focusedItemIndex < 0 || focusedItemIndex == 0) {
            e.preventDefault();
            focusableItems.eq(focusableItems.length - 1).trigger("focus");
          }
        } else {
          // Outside or Forward tab
          if (focusedItemIndex < 0 || focusedItemIndex == focusableItems.length - 1) {
            if (e) {
              e.preventDefault();
            }

            focusableItems.eq(0).trigger("focus");
          }
        }
      } else {
        self.$refs.container.trigger("focus");
      }
    },
    // Activates current instance - brings container to the front and enables keyboard,
    // notifies other instances about deactivating
    // =================================================================================
    activate: function activate() {
      var self = this; // Deactivate all instances

      $(".fancybox-container").each(function () {
        var instance = $(this).data("FancyBox"); // Skip self and closing instances

        if (instance && instance.id !== self.id && !instance.isClosing) {
          instance.trigger("onDeactivate");
          instance.removeEvents();
          instance.isVisible = false;
        }
      });
      self.isVisible = true;

      if (self.current || self.isIdle) {
        self.update();
        self.updateControls();
      }

      self.trigger("onActivate");
      self.addEvents();
    },
    // Start closing procedure
    // This will start "zoom-out" animation if needed and clean everything up afterwards
    // =================================================================================
    close: function close(e, d) {
      var self = this,
          current = self.current,
          effect,
          duration,
          $content,
          domRect,
          opacity,
          start,
          end;

      var done = function done() {
        self.cleanUp(e);
      };

      if (self.isClosing) {
        return false;
      }

      self.isClosing = true; // If beforeClose callback prevents closing, make sure content is centered

      if (self.trigger("beforeClose", e) === false) {
        self.isClosing = false;
        requestAFrame(function () {
          self.update();
        });
        return false;
      } // Remove all events
      // If there are multiple instances, they will be set again by "activate" method


      self.removeEvents();
      $content = current.$content;
      effect = current.opts.animationEffect;
      duration = $.isNumeric(d) ? d : effect ? current.opts.animationDuration : 0;
      current.$slide.removeClass("fancybox-slide--complete fancybox-slide--next fancybox-slide--previous fancybox-animated");

      if (e !== true) {
        $.fancybox.stop(current.$slide);
      } else {
        effect = false;
      } // Remove other slides


      current.$slide.siblings().trigger("onReset").remove(); // Trigger animations

      if (duration) {
        self.$refs.container.removeClass("fancybox-is-open").addClass("fancybox-is-closing").css("transition-duration", duration + "ms");
      } // Clean up


      self.hideLoading(current);
      self.hideControls(true);
      self.updateCursor(); // Check if possible to zoom-out

      if (effect === "zoom" && !($content && duration && current.type === "image" && !self.isMoved() && !current.hasError && (end = self.getThumbPos(current)))) {
        effect = "fade";
      }

      if (effect === "zoom") {
        $.fancybox.stop($content);
        domRect = $.fancybox.getTranslate($content);
        start = {
          top: domRect.top,
          left: domRect.left,
          scaleX: domRect.width / end.width,
          scaleY: domRect.height / end.height,
          width: end.width,
          height: end.height
        }; // Check if we need to animate opacity

        opacity = current.opts.zoomOpacity;

        if (opacity == "auto") {
          opacity = Math.abs(current.width / current.height - end.width / end.height) > 0.1;
        }

        if (opacity) {
          end.opacity = 0;
        }

        $.fancybox.setTranslate($content, start);
        forceRedraw($content);
        $.fancybox.animate($content, end, duration, done);
        return true;
      }

      if (effect && duration) {
        $.fancybox.animate(current.$slide.addClass("fancybox-slide--previous").removeClass("fancybox-slide--current"), "fancybox-animated fancybox-fx-" + effect, duration, done);
      } else {
        // If skip animation
        if (e === true) {
          setTimeout(done, duration);
        } else {
          done();
        }
      }

      return true;
    },
    // Final adjustments after removing the instance
    // =============================================
    cleanUp: function cleanUp(e) {
      var self = this,
          instance,
          $focus = self.current.opts.$orig,
          x,
          y;
      self.current.$slide.trigger("onReset");
      self.$refs.container.empty().remove();
      self.trigger("afterClose", e); // Place back focus

      if (!!self.current.opts.backFocus) {
        if (!$focus || !$focus.length || !$focus.is(":visible")) {
          $focus = self.$trigger;
        }

        if ($focus && $focus.length) {
          x = window.scrollX;
          y = window.scrollY;
          $focus.trigger("focus");
          $("html, body").scrollTop(y).scrollLeft(x);
        }
      }

      self.current = null; // Check if there are other instances

      instance = $.fancybox.getInstance();

      if (instance) {
        instance.activate();
      } else {
        $("body").removeClass("fancybox-active compensate-for-scrollbar");
        $("#fancybox-style-noscroll").remove();
      }
    },
    // Call callback and trigger an event
    // ==================================
    trigger: function trigger(name, slide) {
      var args = Array.prototype.slice.call(arguments, 1),
          self = this,
          obj = slide && slide.opts ? slide : self.current,
          rez;

      if (obj) {
        args.unshift(obj);
      } else {
        obj = self;
      }

      args.unshift(self);

      if ($.isFunction(obj.opts[name])) {
        rez = obj.opts[name].apply(obj, args);
      }

      if (rez === false) {
        return rez;
      }

      if (name === "afterClose" || !self.$refs) {
        $D.trigger(name + ".fb", args);
      } else {
        self.$refs.container.trigger(name + ".fb", args);
      }
    },
    // Update infobar values, navigation button states and reveal caption
    // ==================================================================
    updateControls: function updateControls() {
      var self = this,
          current = self.current,
          index = current.index,
          $container = self.$refs.container,
          $caption = self.$refs.caption,
          caption = current.opts.caption; // Recalculate content dimensions

      current.$slide.trigger("refresh"); // Set caption

      if (caption && caption.length) {
        self.$caption = $caption;
        $caption.children().eq(0).html(caption);
      } else {
        self.$caption = null;
      }

      if (!self.hasHiddenControls && !self.isIdle) {
        self.showControls();
      } // Update info and navigation elements


      $container.find("[data-fancybox-count]").html(self.group.length);
      $container.find("[data-fancybox-index]").html(index + 1);
      $container.find("[data-fancybox-prev]").prop("disabled", !current.opts.loop && index <= 0);
      $container.find("[data-fancybox-next]").prop("disabled", !current.opts.loop && index >= self.group.length - 1);

      if (current.type === "image") {
        // Re-enable buttons; update download button source
        $container.find("[data-fancybox-zoom]").show().end().find("[data-fancybox-download]").attr("href", current.opts.image.src || current.src).show();
      } else if (current.opts.toolbar) {
        $container.find("[data-fancybox-download],[data-fancybox-zoom]").hide();
      } // Make sure focus is not on disabled button/element


      if ($(document.activeElement).is(":hidden,[disabled]")) {
        self.$refs.container.trigger("focus");
      }
    },
    // Hide toolbar and caption
    // ========================
    hideControls: function hideControls(andCaption) {
      var self = this,
          arr = ["infobar", "toolbar", "nav"];

      if (andCaption || !self.current.opts.preventCaptionOverlap) {
        arr.push("caption");
      }

      this.$refs.container.removeClass(arr.map(function (i) {
        return "fancybox-show-" + i;
      }).join(" "));
      this.hasHiddenControls = true;
    },
    showControls: function showControls() {
      var self = this,
          opts = self.current ? self.current.opts : self.opts,
          $container = self.$refs.container;
      self.hasHiddenControls = false;
      self.idleSecondsCounter = 0;
      $container.toggleClass("fancybox-show-toolbar", !!(opts.toolbar && opts.buttons)).toggleClass("fancybox-show-infobar", !!(opts.infobar && self.group.length > 1)).toggleClass("fancybox-show-caption", !!self.$caption).toggleClass("fancybox-show-nav", !!(opts.arrows && self.group.length > 1)).toggleClass("fancybox-is-modal", !!opts.modal);
    },
    // Toggle toolbar and caption
    // ==========================
    toggleControls: function toggleControls() {
      if (this.hasHiddenControls) {
        this.showControls();
      } else {
        this.hideControls();
      }
    }
  });
  $.fancybox = {
    version: "3.5.7",
    defaults: defaults,
    // Get current instance and execute a command.
    //
    // Examples of usage:
    //
    //   $instance = $.fancybox.getInstance();
    //   $.fancybox.getInstance().jumpTo( 1 );
    //   $.fancybox.getInstance( 'jumpTo', 1 );
    //   $.fancybox.getInstance( function() {
    //       console.info( this.currIndex );
    //   });
    // ======================================================
    getInstance: function getInstance(command) {
      var instance = $('.fancybox-container:not(".fancybox-is-closing"):last').data("FancyBox"),
          args = Array.prototype.slice.call(arguments, 1);

      if (instance instanceof FancyBox) {
        if ($.type(command) === "string") {
          instance[command].apply(instance, args);
        } else if ($.type(command) === "function") {
          command.apply(instance, args);
        }

        return instance;
      }

      return false;
    },
    // Create new instance
    // ===================
    open: function open(items, opts, index) {
      return new FancyBox(items, opts, index);
    },
    // Close current or all instances
    // ==============================
    close: function close(all) {
      var instance = this.getInstance();

      if (instance) {
        instance.close(); // Try to find and close next instance

        if (all === true) {
          this.close(all);
        }
      }
    },
    // Close all instances and unbind all events
    // =========================================
    destroy: function destroy() {
      this.close(true);
      $D.add("body").off("click.fb-start", "**");
    },
    // Try to detect mobile devices
    // ============================
    isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    // Detect if 'translate3d' support is available
    // ============================================
    use3d: function () {
      var div = document.createElement("div");
      return window.getComputedStyle && window.getComputedStyle(div) && window.getComputedStyle(div).getPropertyValue("transform") && !(document.documentMode && document.documentMode < 11);
    }(),
    // Helper function to get current visual state of an element
    // returns array[ top, left, horizontal-scale, vertical-scale, opacity ]
    // =====================================================================
    getTranslate: function getTranslate($el) {
      var domRect;

      if (!$el || !$el.length) {
        return false;
      }

      domRect = $el[0].getBoundingClientRect();
      return {
        top: domRect.top || 0,
        left: domRect.left || 0,
        width: domRect.width,
        height: domRect.height,
        opacity: parseFloat($el.css("opacity"))
      };
    },
    // Shortcut for setting "translate3d" properties for element
    // Can set be used to set opacity, too
    // ========================================================
    setTranslate: function setTranslate($el, props) {
      var str = "",
          css = {};

      if (!$el || !props) {
        return;
      }

      if (props.left !== undefined || props.top !== undefined) {
        str = (props.left === undefined ? $el.position().left : props.left) + "px, " + (props.top === undefined ? $el.position().top : props.top) + "px";

        if (this.use3d) {
          str = "translate3d(" + str + ", 0px)";
        } else {
          str = "translate(" + str + ")";
        }
      }

      if (props.scaleX !== undefined && props.scaleY !== undefined) {
        str += " scale(" + props.scaleX + ", " + props.scaleY + ")";
      } else if (props.scaleX !== undefined) {
        str += " scaleX(" + props.scaleX + ")";
      }

      if (str.length) {
        css.transform = str;
      }

      if (props.opacity !== undefined) {
        css.opacity = props.opacity;
      }

      if (props.width !== undefined) {
        css.width = props.width;
      }

      if (props.height !== undefined) {
        css.height = props.height;
      }

      return $el.css(css);
    },
    // Simple CSS transition handler
    // =============================
    animate: function animate($el, to, duration, callback, leaveAnimationName) {
      var self = this,
          from;

      if ($.isFunction(duration)) {
        callback = duration;
        duration = null;
      }

      self.stop($el);
      from = self.getTranslate($el);
      $el.on(transitionEnd, function (e) {
        // Skip events from child elements and z-index change
        if (e && e.originalEvent && (!$el.is(e.originalEvent.target) || e.originalEvent.propertyName == "z-index")) {
          return;
        }

        self.stop($el);

        if ($.isNumeric(duration)) {
          $el.css("transition-duration", "");
        }

        if ($.isPlainObject(to)) {
          if (to.scaleX !== undefined && to.scaleY !== undefined) {
            self.setTranslate($el, {
              top: to.top,
              left: to.left,
              width: from.width * to.scaleX,
              height: from.height * to.scaleY,
              scaleX: 1,
              scaleY: 1
            });
          }
        } else if (leaveAnimationName !== true) {
          $el.removeClass(to);
        }

        if ($.isFunction(callback)) {
          callback(e);
        }
      });

      if ($.isNumeric(duration)) {
        $el.css("transition-duration", duration + "ms");
      } // Start animation by changing CSS properties or class name


      if ($.isPlainObject(to)) {
        if (to.scaleX !== undefined && to.scaleY !== undefined) {
          delete to.width;
          delete to.height;

          if ($el.parent().hasClass("fancybox-slide--image")) {
            $el.parent().addClass("fancybox-is-scaling");
          }
        }

        $.fancybox.setTranslate($el, to);
      } else {
        $el.addClass(to);
      } // Make sure that `transitionend` callback gets fired


      $el.data("timer", setTimeout(function () {
        $el.trigger(transitionEnd);
      }, duration + 33));
    },
    stop: function stop($el, callCallback) {
      if ($el && $el.length) {
        clearTimeout($el.data("timer"));

        if (callCallback) {
          $el.trigger(transitionEnd);
        }

        $el.off(transitionEnd).css("transition-duration", "");
        $el.parent().removeClass("fancybox-is-scaling");
      }
    }
  }; // Default click handler for "fancyboxed" links
  // ============================================

  function _run(e, opts) {
    var items = [],
        index = 0,
        $target,
        value,
        instance; // Avoid opening multiple times

    if (e && e.isDefaultPrevented()) {
      return;
    }

    e.preventDefault();
    opts = opts || {};

    if (e && e.data) {
      opts = mergeOpts(e.data.options, opts);
    }

    $target = opts.$target || $(e.currentTarget).trigger("blur");
    instance = $.fancybox.getInstance();

    if (instance && instance.$trigger && instance.$trigger.is($target)) {
      return;
    }

    if (opts.selector) {
      items = $(opts.selector);
    } else {
      // Get all related items and find index for clicked one
      value = $target.attr("data-fancybox") || "";

      if (value) {
        items = e.data ? e.data.items : [];
        items = items.length ? items.filter('[data-fancybox="' + value + '"]') : $('[data-fancybox="' + value + '"]');
      } else {
        items = [$target];
      }
    }

    index = $(items).index($target); // Sometimes current item can not be found

    if (index < 0) {
      index = 0;
    }

    instance = $.fancybox.open(items, opts, index); // Save last active element

    instance.$trigger = $target;
  } // Create a jQuery plugin
  // ======================


  $.fn.fancybox = function (options) {
    var selector;
    options = options || {};
    selector = options.selector || false;

    if (selector) {
      // Use body element instead of document so it executes first
      $("body").off("click.fb-start", selector).on("click.fb-start", selector, {
        options: options
      }, _run);
    } else {
      this.off("click.fb-start").on("click.fb-start", {
        items: this,
        options: options
      }, _run);
    }

    return this;
  }; // Self initializing plugin for all elements having `data-fancybox` attribute
  // ==========================================================================


  $D.on("click.fb-start", "[data-fancybox]", _run); // Enable "trigger elements"
  // =========================

  $D.on("click.fb-start", "[data-fancybox-trigger]", function (e) {
    $('[data-fancybox="' + $(this).attr("data-fancybox-trigger") + '"]').eq($(this).attr("data-fancybox-index") || 0).trigger("click.fb-start", {
      $trigger: $(this)
    });
  }); // Track focus event for better accessibility styling
  // ==================================================

  (function () {
    var buttonStr = ".fancybox-button",
        focusStr = "fancybox-focus",
        $pressed = null;
    $D.on("mousedown mouseup focus blur", buttonStr, function (e) {
      switch (e.type) {
        case "mousedown":
          $pressed = $(this);
          break;

        case "mouseup":
          $pressed = null;
          break;

        case "focusin":
          $(buttonStr).removeClass(focusStr);

          if (!$(this).is($pressed) && !$(this).is("[disabled]")) {
            $(this).addClass(focusStr);
          }

          break;

        case "focusout":
          $(buttonStr).removeClass(focusStr);
          break;
      }
    });
  })();
})(window, document, jQuery); // ==========================================================================
//
// Media
// Adds additional media type support
//
// ==========================================================================


(function ($) {
  "use strict"; // Object containing properties for each media type

  var defaults = {
    youtube: {
      matcher: /(youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(watch\?(.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*))(.*)/i,
      params: {
        autoplay: 1,
        autohide: 1,
        fs: 1,
        rel: 0,
        hd: 1,
        wmode: "transparent",
        enablejsapi: 1,
        html5: 1
      },
      paramPlace: 8,
      type: "iframe",
      url: "https://www.youtube-nocookie.com/embed/$4",
      thumb: "https://img.youtube.com/vi/$4/hqdefault.jpg"
    },
    vimeo: {
      matcher: /^.+vimeo.com\/(.*\/)?([\d]+)(.*)?/,
      params: {
        autoplay: 1,
        hd: 1,
        show_title: 1,
        show_byline: 1,
        show_portrait: 0,
        fullscreen: 1
      },
      paramPlace: 3,
      type: "iframe",
      url: "//player.vimeo.com/video/$2"
    },
    instagram: {
      matcher: /(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,
      type: "image",
      url: "//$1/p/$2/media/?size=l"
    },
    // Examples:
    // http://maps.google.com/?ll=48.857995,2.294297&spn=0.007666,0.021136&t=m&z=16
    // https://www.google.com/maps/@37.7852006,-122.4146355,14.65z
    // https://www.google.com/maps/@52.2111123,2.9237542,6.61z?hl=en
    // https://www.google.com/maps/place/Googleplex/@37.4220041,-122.0833494,17z/data=!4m5!3m4!1s0x0:0x6c296c66619367e0!8m2!3d37.4219998!4d-122.0840572
    gmap_place: {
      matcher: /(maps\.)?google\.([a-z]{2,3}(\.[a-z]{2})?)\/(((maps\/(place\/(.*)\/)?\@(.*),(\d+.?\d+?)z))|(\?ll=))(.*)?/i,
      type: "iframe",
      url: function url(rez) {
        return "//maps.google." + rez[2] + "/?ll=" + (rez[9] ? rez[9] + "&z=" + Math.floor(rez[10]) + (rez[12] ? rez[12].replace(/^\//, "&") : "") : rez[12] + "").replace(/\?/, "&") + "&output=" + (rez[12] && rez[12].indexOf("layer=c") > 0 ? "svembed" : "embed");
      }
    },
    // Examples:
    // https://www.google.com/maps/search/Empire+State+Building/
    // https://www.google.com/maps/search/?api=1&query=centurylink+field
    // https://www.google.com/maps/search/?api=1&query=47.5951518,-122.3316393
    gmap_search: {
      matcher: /(maps\.)?google\.([a-z]{2,3}(\.[a-z]{2})?)\/(maps\/search\/)(.*)/i,
      type: "iframe",
      url: function url(rez) {
        return "//maps.google." + rez[2] + "/maps?q=" + rez[5].replace("query=", "q=").replace("api=1", "") + "&output=embed";
      }
    }
  }; // Formats matching url to final form

  var format = function format(url, rez, params) {
    if (!url) {
      return;
    }

    params = params || "";

    if ($.type(params) === "object") {
      params = $.param(params, true);
    }

    $.each(rez, function (key, value) {
      url = url.replace("$" + key, value || "");
    });

    if (params.length) {
      url += (url.indexOf("?") > 0 ? "&" : "?") + params;
    }

    return url;
  };

  $(document).on("objectNeedsType.fb", function (e, instance, item) {
    var url = item.src || "",
        type = false,
        media,
        thumb,
        rez,
        params,
        urlParams,
        paramObj,
        provider;
    media = $.extend(true, {}, defaults, item.opts.media); // Look for any matching media type

    $.each(media, function (providerName, providerOpts) {
      rez = url.match(providerOpts.matcher);

      if (!rez) {
        return;
      }

      type = providerOpts.type;
      provider = providerName;
      paramObj = {};

      if (providerOpts.paramPlace && rez[providerOpts.paramPlace]) {
        urlParams = rez[providerOpts.paramPlace];

        if (urlParams[0] == "?") {
          urlParams = urlParams.substring(1);
        }

        urlParams = urlParams.split("&");

        for (var m = 0; m < urlParams.length; ++m) {
          var p = urlParams[m].split("=", 2);

          if (p.length == 2) {
            paramObj[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
          }
        }
      }

      params = $.extend(true, {}, providerOpts.params, item.opts[providerName], paramObj);
      url = $.type(providerOpts.url) === "function" ? providerOpts.url.call(this, rez, params, item) : format(providerOpts.url, rez, params);
      thumb = $.type(providerOpts.thumb) === "function" ? providerOpts.thumb.call(this, rez, params, item) : format(providerOpts.thumb, rez);

      if (providerName === "youtube") {
        url = url.replace(/&t=((\d+)m)?(\d+)s/, function (match, p1, m, s) {
          return "&start=" + ((m ? parseInt(m, 10) * 60 : 0) + parseInt(s, 10));
        });
      } else if (providerName === "vimeo") {
        url = url.replace("&%23", "#");
      }

      return false;
    }); // If it is found, then change content type and update the url

    if (type) {
      if (!item.opts.thumb && !(item.opts.$thumb && item.opts.$thumb.length)) {
        item.opts.thumb = thumb;
      }

      if (type === "iframe") {
        item.opts = $.extend(true, item.opts, {
          iframe: {
            preload: false,
            attr: {
              scrolling: "no"
            }
          }
        });
      }

      $.extend(item, {
        type: type,
        src: url,
        origSrc: item.src,
        contentSource: provider,
        contentType: type === "image" ? "image" : provider == "gmap_place" || provider == "gmap_search" ? "map" : "video"
      });
    } else if (url) {
      item.type = item.opts.defaultType;
    }
  }); // Load YouTube/Video API on request to detect when video finished playing

  var VideoAPILoader = {
    youtube: {
      src: "https://www.youtube.com/iframe_api",
      "class": "YT",
      loading: false,
      loaded: false
    },
    vimeo: {
      src: "https://player.vimeo.com/api/player.js",
      "class": "Vimeo",
      loading: false,
      loaded: false
    },
    load: function load(vendor) {
      var _this = this,
          script;

      if (this[vendor].loaded) {
        setTimeout(function () {
          _this.done(vendor);
        });
        return;
      }

      if (this[vendor].loading) {
        return;
      }

      this[vendor].loading = true;
      script = document.createElement("script");
      script.type = "text/javascript";
      script.src = this[vendor].src;

      if (vendor === "youtube") {
        window.onYouTubeIframeAPIReady = function () {
          _this[vendor].loaded = true;

          _this.done(vendor);
        };
      } else {
        script.onload = function () {
          _this[vendor].loaded = true;

          _this.done(vendor);
        };
      }

      document.body.appendChild(script);
    },
    done: function done(vendor) {
      var instance, $el, player;

      if (vendor === "youtube") {
        delete window.onYouTubeIframeAPIReady;
      }

      instance = $.fancybox.getInstance();

      if (instance) {
        $el = instance.current.$content.find("iframe");

        if (vendor === "youtube" && YT !== undefined && YT) {
          player = new YT.Player($el.attr("id"), {
            events: {
              onStateChange: function onStateChange(e) {
                if (e.data == 0) {
                  instance.next();
                }
              }
            }
          });
        } else if (vendor === "vimeo" && Vimeo !== undefined && Vimeo) {
          player = new Vimeo.Player($el);
          player.on("ended", function () {
            instance.next();
          });
        }
      }
    }
  };
  $(document).on({
    "afterShow.fb": function afterShowFb(e, instance, current) {
      if (instance.group.length > 1 && (current.contentSource === "youtube" || current.contentSource === "vimeo")) {
        VideoAPILoader.load(current.contentSource);
      }
    }
  });
})(jQuery); // ==========================================================================
//
// Guestures
// Adds touch guestures, handles click and tap events
//
// ==========================================================================


(function (window, document, $) {
  "use strict";

  var requestAFrame = function () {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || // if all else fails, use setTimeout
    function (callback) {
      return window.setTimeout(callback, 1000 / 60);
    };
  }();

  var cancelAFrame = function () {
    return window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || function (id) {
      window.clearTimeout(id);
    };
  }();

  var getPointerXY = function getPointerXY(e) {
    var result = [];
    e = e.originalEvent || e || window.e;
    e = e.touches && e.touches.length ? e.touches : e.changedTouches && e.changedTouches.length ? e.changedTouches : [e];

    for (var key in e) {
      if (e[key].pageX) {
        result.push({
          x: e[key].pageX,
          y: e[key].pageY
        });
      } else if (e[key].clientX) {
        result.push({
          x: e[key].clientX,
          y: e[key].clientY
        });
      }
    }

    return result;
  };

  var distance = function distance(point2, point1, what) {
    if (!point1 || !point2) {
      return 0;
    }

    if (what === "x") {
      return point2.x - point1.x;
    } else if (what === "y") {
      return point2.y - point1.y;
    }

    return Math.sqrt(Math.pow(point2.x - point1.x, 2) + Math.pow(point2.y - point1.y, 2));
  };

  var isClickable = function isClickable($el) {
    if ($el.is('a,area,button,[role="button"],input,label,select,summary,textarea,video,audio,iframe') || $.isFunction($el.get(0).onclick) || $el.data("selectable")) {
      return true;
    } // Check for attributes like data-fancybox-next or data-fancybox-close


    for (var i = 0, atts = $el[0].attributes, n = atts.length; i < n; i++) {
      if (atts[i].nodeName.substr(0, 14) === "data-fancybox-") {
        return true;
      }
    }

    return false;
  };

  var hasScrollbars = function hasScrollbars(el) {
    var overflowY = window.getComputedStyle(el)["overflow-y"],
        overflowX = window.getComputedStyle(el)["overflow-x"],
        vertical = (overflowY === "scroll" || overflowY === "auto") && el.scrollHeight > el.clientHeight,
        horizontal = (overflowX === "scroll" || overflowX === "auto") && el.scrollWidth > el.clientWidth;
    return vertical || horizontal;
  };

  var isScrollable = function isScrollable($el) {
    var rez = false;

    while (true) {
      rez = hasScrollbars($el.get(0));

      if (rez) {
        break;
      }

      $el = $el.parent();

      if (!$el.length || $el.hasClass("fancybox-stage") || $el.is("body")) {
        break;
      }
    }

    return rez;
  };

  var Guestures = function Guestures(instance) {
    var self = this;
    self.instance = instance;
    self.$bg = instance.$refs.bg;
    self.$stage = instance.$refs.stage;
    self.$container = instance.$refs.container;
    self.destroy();
    self.$container.on("touchstart.fb.touch mousedown.fb.touch", $.proxy(self, "ontouchstart"));
  };

  Guestures.prototype.destroy = function () {
    var self = this;
    self.$container.off(".fb.touch");
    $(document).off(".fb.touch");

    if (self.requestId) {
      cancelAFrame(self.requestId);
      self.requestId = null;
    }

    if (self.tapped) {
      clearTimeout(self.tapped);
      self.tapped = null;
    }
  };

  Guestures.prototype.ontouchstart = function (e) {
    var self = this,
        $target = $(e.target),
        instance = self.instance,
        current = instance.current,
        $slide = current.$slide,
        $content = current.$content,
        isTouchDevice = e.type == "touchstart"; // Do not respond to both (touch and mouse) events

    if (isTouchDevice) {
      self.$container.off("mousedown.fb.touch");
    } // Ignore right click


    if (e.originalEvent && e.originalEvent.button == 2) {
      return;
    } // Ignore taping on links, buttons, input elements


    if (!$slide.length || !$target.length || isClickable($target) || isClickable($target.parent())) {
      return;
    } // Ignore clicks on the scrollbar


    if (!$target.is("img") && e.originalEvent.clientX > $target[0].clientWidth + $target.offset().left) {
      return;
    } // Ignore clicks while zooming or closing


    if (!current || instance.isAnimating || current.$slide.hasClass("fancybox-animated")) {
      e.stopPropagation();
      e.preventDefault();
      return;
    }

    self.realPoints = self.startPoints = getPointerXY(e);

    if (!self.startPoints.length) {
      return;
    } // Allow other scripts to catch touch event if "touch" is set to false


    if (current.touch) {
      e.stopPropagation();
    }

    self.startEvent = e;
    self.canTap = true;
    self.$target = $target;
    self.$content = $content;
    self.opts = current.opts.touch;
    self.isPanning = false;
    self.isSwiping = false;
    self.isZooming = false;
    self.isScrolling = false;
    self.canPan = instance.canPan();
    self.startTime = new Date().getTime();
    self.distanceX = self.distanceY = self.distance = 0;
    self.canvasWidth = Math.round($slide[0].clientWidth);
    self.canvasHeight = Math.round($slide[0].clientHeight);
    self.contentLastPos = null;
    self.contentStartPos = $.fancybox.getTranslate(self.$content) || {
      top: 0,
      left: 0
    };
    self.sliderStartPos = $.fancybox.getTranslate($slide); // Since position will be absolute, but we need to make it relative to the stage

    self.stagePos = $.fancybox.getTranslate(instance.$refs.stage);
    self.sliderStartPos.top -= self.stagePos.top;
    self.sliderStartPos.left -= self.stagePos.left;
    self.contentStartPos.top -= self.stagePos.top;
    self.contentStartPos.left -= self.stagePos.left;
    $(document).off(".fb.touch").on(isTouchDevice ? "touchend.fb.touch touchcancel.fb.touch" : "mouseup.fb.touch mouseleave.fb.touch", $.proxy(self, "ontouchend")).on(isTouchDevice ? "touchmove.fb.touch" : "mousemove.fb.touch", $.proxy(self, "ontouchmove"));

    if ($.fancybox.isMobile) {
      document.addEventListener("scroll", self.onscroll, true);
    } // Skip if clicked outside the sliding area


    if (!(self.opts || self.canPan) || !($target.is(self.$stage) || self.$stage.find($target).length)) {
      if ($target.is(".fancybox-image")) {
        e.preventDefault();
      }

      if (!($.fancybox.isMobile && $target.parents(".fancybox-caption").length)) {
        return;
      }
    }

    self.isScrollable = isScrollable($target) || isScrollable($target.parent()); // Check if element is scrollable and try to prevent default behavior (scrolling)

    if (!($.fancybox.isMobile && self.isScrollable)) {
      e.preventDefault();
    } // One finger or mouse click - swipe or pan an image


    if (self.startPoints.length === 1 || current.hasError) {
      if (self.canPan) {
        $.fancybox.stop(self.$content);
        self.isPanning = true;
      } else {
        self.isSwiping = true;
      }

      self.$container.addClass("fancybox-is-grabbing");
    } // Two fingers - zoom image


    if (self.startPoints.length === 2 && current.type === "image" && (current.isLoaded || current.$ghost)) {
      self.canTap = false;
      self.isSwiping = false;
      self.isPanning = false;
      self.isZooming = true;
      $.fancybox.stop(self.$content);
      self.centerPointStartX = (self.startPoints[0].x + self.startPoints[1].x) * 0.5 - $(window).scrollLeft();
      self.centerPointStartY = (self.startPoints[0].y + self.startPoints[1].y) * 0.5 - $(window).scrollTop();
      self.percentageOfImageAtPinchPointX = (self.centerPointStartX - self.contentStartPos.left) / self.contentStartPos.width;
      self.percentageOfImageAtPinchPointY = (self.centerPointStartY - self.contentStartPos.top) / self.contentStartPos.height;
      self.startDistanceBetweenFingers = distance(self.startPoints[0], self.startPoints[1]);
    }
  };

  Guestures.prototype.onscroll = function (e) {
    var self = this;
    self.isScrolling = true;
    document.removeEventListener("scroll", self.onscroll, true);
  };

  Guestures.prototype.ontouchmove = function (e) {
    var self = this; // Make sure user has not released over iframe or disabled element

    if (e.originalEvent.buttons !== undefined && e.originalEvent.buttons === 0) {
      self.ontouchend(e);
      return;
    }

    if (self.isScrolling) {
      self.canTap = false;
      return;
    }

    self.newPoints = getPointerXY(e);

    if (!(self.opts || self.canPan) || !self.newPoints.length || !self.newPoints.length) {
      return;
    }

    if (!(self.isSwiping && self.isSwiping === true)) {
      e.preventDefault();
    }

    self.distanceX = distance(self.newPoints[0], self.startPoints[0], "x");
    self.distanceY = distance(self.newPoints[0], self.startPoints[0], "y");
    self.distance = distance(self.newPoints[0], self.startPoints[0]); // Skip false ontouchmove events (Chrome)

    if (self.distance > 0) {
      if (self.isSwiping) {
        self.onSwipe(e);
      } else if (self.isPanning) {
        self.onPan();
      } else if (self.isZooming) {
        self.onZoom();
      }
    }
  };

  Guestures.prototype.onSwipe = function (e) {
    var self = this,
        instance = self.instance,
        swiping = self.isSwiping,
        left = self.sliderStartPos.left || 0,
        angle; // If direction is not yet determined

    if (swiping === true) {
      // We need at least 10px distance to correctly calculate an angle
      if (Math.abs(self.distance) > 10) {
        self.canTap = false;

        if (instance.group.length < 2 && self.opts.vertical) {
          self.isSwiping = "y";
        } else if (instance.isDragging || self.opts.vertical === false || self.opts.vertical === "auto" && $(window).width() > 800) {
          self.isSwiping = "x";
        } else {
          angle = Math.abs(Math.atan2(self.distanceY, self.distanceX) * 180 / Math.PI);
          self.isSwiping = angle > 45 && angle < 135 ? "y" : "x";
        }

        if (self.isSwiping === "y" && $.fancybox.isMobile && self.isScrollable) {
          self.isScrolling = true;
          return;
        }

        instance.isDragging = self.isSwiping; // Reset points to avoid jumping, because we dropped first swipes to calculate the angle

        self.startPoints = self.newPoints;
        $.each(instance.slides, function (index, slide) {
          var slidePos, stagePos;
          $.fancybox.stop(slide.$slide);
          slidePos = $.fancybox.getTranslate(slide.$slide);
          stagePos = $.fancybox.getTranslate(instance.$refs.stage);
          slide.$slide.css({
            transform: "",
            opacity: "",
            "transition-duration": ""
          }).removeClass("fancybox-animated").removeClass(function (index, className) {
            return (className.match(/(^|\s)fancybox-fx-\S+/g) || []).join(" ");
          });

          if (slide.pos === instance.current.pos) {
            self.sliderStartPos.top = slidePos.top - stagePos.top;
            self.sliderStartPos.left = slidePos.left - stagePos.left;
          }

          $.fancybox.setTranslate(slide.$slide, {
            top: slidePos.top - stagePos.top,
            left: slidePos.left - stagePos.left
          });
        }); // Stop slideshow

        if (instance.SlideShow && instance.SlideShow.isActive) {
          instance.SlideShow.stop();
        }
      }

      return;
    } // Sticky edges


    if (swiping == "x") {
      if (self.distanceX > 0 && (self.instance.group.length < 2 || self.instance.current.index === 0 && !self.instance.current.opts.loop)) {
        left = left + Math.pow(self.distanceX, 0.8);
      } else if (self.distanceX < 0 && (self.instance.group.length < 2 || self.instance.current.index === self.instance.group.length - 1 && !self.instance.current.opts.loop)) {
        left = left - Math.pow(-self.distanceX, 0.8);
      } else {
        left = left + self.distanceX;
      }
    }

    self.sliderLastPos = {
      top: swiping == "x" ? 0 : self.sliderStartPos.top + self.distanceY,
      left: left
    };

    if (self.requestId) {
      cancelAFrame(self.requestId);
      self.requestId = null;
    }

    self.requestId = requestAFrame(function () {
      if (self.sliderLastPos) {
        $.each(self.instance.slides, function (index, slide) {
          var pos = slide.pos - self.instance.currPos;
          $.fancybox.setTranslate(slide.$slide, {
            top: self.sliderLastPos.top,
            left: self.sliderLastPos.left + pos * self.canvasWidth + pos * slide.opts.gutter
          });
        });
        self.$container.addClass("fancybox-is-sliding");
      }
    });
  };

  Guestures.prototype.onPan = function () {
    var self = this; // Prevent accidental movement (sometimes, when tapping casually, finger can move a bit)

    if (distance(self.newPoints[0], self.realPoints[0]) < ($.fancybox.isMobile ? 10 : 5)) {
      self.startPoints = self.newPoints;
      return;
    }

    self.canTap = false;
    self.contentLastPos = self.limitMovement();

    if (self.requestId) {
      cancelAFrame(self.requestId);
    }

    self.requestId = requestAFrame(function () {
      $.fancybox.setTranslate(self.$content, self.contentLastPos);
    });
  }; // Make panning sticky to the edges


  Guestures.prototype.limitMovement = function () {
    var self = this;
    var canvasWidth = self.canvasWidth;
    var canvasHeight = self.canvasHeight;
    var distanceX = self.distanceX;
    var distanceY = self.distanceY;
    var contentStartPos = self.contentStartPos;
    var currentOffsetX = contentStartPos.left;
    var currentOffsetY = contentStartPos.top;
    var currentWidth = contentStartPos.width;
    var currentHeight = contentStartPos.height;
    var minTranslateX, minTranslateY, maxTranslateX, maxTranslateY, newOffsetX, newOffsetY;

    if (currentWidth > canvasWidth) {
      newOffsetX = currentOffsetX + distanceX;
    } else {
      newOffsetX = currentOffsetX;
    }

    newOffsetY = currentOffsetY + distanceY; // Slow down proportionally to traveled distance

    minTranslateX = Math.max(0, canvasWidth * 0.5 - currentWidth * 0.5);
    minTranslateY = Math.max(0, canvasHeight * 0.5 - currentHeight * 0.5);
    maxTranslateX = Math.min(canvasWidth - currentWidth, canvasWidth * 0.5 - currentWidth * 0.5);
    maxTranslateY = Math.min(canvasHeight - currentHeight, canvasHeight * 0.5 - currentHeight * 0.5); //   ->

    if (distanceX > 0 && newOffsetX > minTranslateX) {
      newOffsetX = minTranslateX - 1 + Math.pow(-minTranslateX + currentOffsetX + distanceX, 0.8) || 0;
    } //    <-


    if (distanceX < 0 && newOffsetX < maxTranslateX) {
      newOffsetX = maxTranslateX + 1 - Math.pow(maxTranslateX - currentOffsetX - distanceX, 0.8) || 0;
    } //   \/


    if (distanceY > 0 && newOffsetY > minTranslateY) {
      newOffsetY = minTranslateY - 1 + Math.pow(-minTranslateY + currentOffsetY + distanceY, 0.8) || 0;
    } //   /\


    if (distanceY < 0 && newOffsetY < maxTranslateY) {
      newOffsetY = maxTranslateY + 1 - Math.pow(maxTranslateY - currentOffsetY - distanceY, 0.8) || 0;
    }

    return {
      top: newOffsetY,
      left: newOffsetX
    };
  };

  Guestures.prototype.limitPosition = function (newOffsetX, newOffsetY, newWidth, newHeight) {
    var self = this;
    var canvasWidth = self.canvasWidth;
    var canvasHeight = self.canvasHeight;

    if (newWidth > canvasWidth) {
      newOffsetX = newOffsetX > 0 ? 0 : newOffsetX;
      newOffsetX = newOffsetX < canvasWidth - newWidth ? canvasWidth - newWidth : newOffsetX;
    } else {
      // Center horizontally
      newOffsetX = Math.max(0, canvasWidth / 2 - newWidth / 2);
    }

    if (newHeight > canvasHeight) {
      newOffsetY = newOffsetY > 0 ? 0 : newOffsetY;
      newOffsetY = newOffsetY < canvasHeight - newHeight ? canvasHeight - newHeight : newOffsetY;
    } else {
      // Center vertically
      newOffsetY = Math.max(0, canvasHeight / 2 - newHeight / 2);
    }

    return {
      top: newOffsetY,
      left: newOffsetX
    };
  };

  Guestures.prototype.onZoom = function () {
    var self = this; // Calculate current distance between points to get pinch ratio and new width and height

    var contentStartPos = self.contentStartPos;
    var currentWidth = contentStartPos.width;
    var currentHeight = contentStartPos.height;
    var currentOffsetX = contentStartPos.left;
    var currentOffsetY = contentStartPos.top;
    var endDistanceBetweenFingers = distance(self.newPoints[0], self.newPoints[1]);
    var pinchRatio = endDistanceBetweenFingers / self.startDistanceBetweenFingers;
    var newWidth = Math.floor(currentWidth * pinchRatio);
    var newHeight = Math.floor(currentHeight * pinchRatio); // This is the translation due to pinch-zooming

    var translateFromZoomingX = (currentWidth - newWidth) * self.percentageOfImageAtPinchPointX;
    var translateFromZoomingY = (currentHeight - newHeight) * self.percentageOfImageAtPinchPointY; // Point between the two touches

    var centerPointEndX = (self.newPoints[0].x + self.newPoints[1].x) / 2 - $(window).scrollLeft();
    var centerPointEndY = (self.newPoints[0].y + self.newPoints[1].y) / 2 - $(window).scrollTop(); // And this is the translation due to translation of the centerpoint
    // between the two fingers

    var translateFromTranslatingX = centerPointEndX - self.centerPointStartX;
    var translateFromTranslatingY = centerPointEndY - self.centerPointStartY; // The new offset is the old/current one plus the total translation

    var newOffsetX = currentOffsetX + (translateFromZoomingX + translateFromTranslatingX);
    var newOffsetY = currentOffsetY + (translateFromZoomingY + translateFromTranslatingY);
    var newPos = {
      top: newOffsetY,
      left: newOffsetX,
      scaleX: pinchRatio,
      scaleY: pinchRatio
    };
    self.canTap = false;
    self.newWidth = newWidth;
    self.newHeight = newHeight;
    self.contentLastPos = newPos;

    if (self.requestId) {
      cancelAFrame(self.requestId);
    }

    self.requestId = requestAFrame(function () {
      $.fancybox.setTranslate(self.$content, self.contentLastPos);
    });
  };

  Guestures.prototype.ontouchend = function (e) {
    var self = this;
    var swiping = self.isSwiping;
    var panning = self.isPanning;
    var zooming = self.isZooming;
    var scrolling = self.isScrolling;
    self.endPoints = getPointerXY(e);
    self.dMs = Math.max(new Date().getTime() - self.startTime, 1);
    self.$container.removeClass("fancybox-is-grabbing");
    $(document).off(".fb.touch");
    document.removeEventListener("scroll", self.onscroll, true);

    if (self.requestId) {
      cancelAFrame(self.requestId);
      self.requestId = null;
    }

    self.isSwiping = false;
    self.isPanning = false;
    self.isZooming = false;
    self.isScrolling = false;
    self.instance.isDragging = false;

    if (self.canTap) {
      return self.onTap(e);
    }

    self.speed = 100; // Speed in px/ms

    self.velocityX = self.distanceX / self.dMs * 0.5;
    self.velocityY = self.distanceY / self.dMs * 0.5;

    if (panning) {
      self.endPanning();
    } else if (zooming) {
      self.endZooming();
    } else {
      self.endSwiping(swiping, scrolling);
    }

    return;
  };

  Guestures.prototype.endSwiping = function (swiping, scrolling) {
    var self = this,
        ret = false,
        len = self.instance.group.length,
        distanceX = Math.abs(self.distanceX),
        canAdvance = swiping == "x" && len > 1 && (self.dMs > 130 && distanceX > 10 || distanceX > 50),
        speedX = 300;
    self.sliderLastPos = null; // Close if swiped vertically / navigate if horizontally

    if (swiping == "y" && !scrolling && Math.abs(self.distanceY) > 50) {
      // Continue vertical movement
      $.fancybox.animate(self.instance.current.$slide, {
        top: self.sliderStartPos.top + self.distanceY + self.velocityY * 150,
        opacity: 0
      }, 200);
      ret = self.instance.close(true, 250);
    } else if (canAdvance && self.distanceX > 0) {
      ret = self.instance.previous(speedX);
    } else if (canAdvance && self.distanceX < 0) {
      ret = self.instance.next(speedX);
    }

    if (ret === false && (swiping == "x" || swiping == "y")) {
      self.instance.centerSlide(200);
    }

    self.$container.removeClass("fancybox-is-sliding");
  }; // Limit panning from edges
  // ========================


  Guestures.prototype.endPanning = function () {
    var self = this,
        newOffsetX,
        newOffsetY,
        newPos;

    if (!self.contentLastPos) {
      return;
    }

    if (self.opts.momentum === false || self.dMs > 350) {
      newOffsetX = self.contentLastPos.left;
      newOffsetY = self.contentLastPos.top;
    } else {
      // Continue movement
      newOffsetX = self.contentLastPos.left + self.velocityX * 500;
      newOffsetY = self.contentLastPos.top + self.velocityY * 500;
    }

    newPos = self.limitPosition(newOffsetX, newOffsetY, self.contentStartPos.width, self.contentStartPos.height);
    newPos.width = self.contentStartPos.width;
    newPos.height = self.contentStartPos.height;
    $.fancybox.animate(self.$content, newPos, 366);
  };

  Guestures.prototype.endZooming = function () {
    var self = this;
    var current = self.instance.current;
    var newOffsetX, newOffsetY, newPos, reset;
    var newWidth = self.newWidth;
    var newHeight = self.newHeight;

    if (!self.contentLastPos) {
      return;
    }

    newOffsetX = self.contentLastPos.left;
    newOffsetY = self.contentLastPos.top;
    reset = {
      top: newOffsetY,
      left: newOffsetX,
      width: newWidth,
      height: newHeight,
      scaleX: 1,
      scaleY: 1
    }; // Reset scalex/scaleY values; this helps for perfomance and does not break animation

    $.fancybox.setTranslate(self.$content, reset);

    if (newWidth < self.canvasWidth && newHeight < self.canvasHeight) {
      self.instance.scaleToFit(150);
    } else if (newWidth > current.width || newHeight > current.height) {
      self.instance.scaleToActual(self.centerPointStartX, self.centerPointStartY, 150);
    } else {
      newPos = self.limitPosition(newOffsetX, newOffsetY, newWidth, newHeight);
      $.fancybox.animate(self.$content, newPos, 150);
    }
  };

  Guestures.prototype.onTap = function (e) {
    var self = this;
    var $target = $(e.target);
    var instance = self.instance;
    var current = instance.current;
    var endPoints = e && getPointerXY(e) || self.startPoints;
    var tapX = endPoints[0] ? endPoints[0].x - $(window).scrollLeft() - self.stagePos.left : 0;
    var tapY = endPoints[0] ? endPoints[0].y - $(window).scrollTop() - self.stagePos.top : 0;
    var where;

    var process = function process(prefix) {
      var action = current.opts[prefix];

      if ($.isFunction(action)) {
        action = action.apply(instance, [current, e]);
      }

      if (!action) {
        return;
      }

      switch (action) {
        case "close":
          instance.close(self.startEvent);
          break;

        case "toggleControls":
          instance.toggleControls();
          break;

        case "next":
          instance.next();
          break;

        case "nextOrClose":
          if (instance.group.length > 1) {
            instance.next();
          } else {
            instance.close(self.startEvent);
          }

          break;

        case "zoom":
          if (current.type == "image" && (current.isLoaded || current.$ghost)) {
            if (instance.canPan()) {
              instance.scaleToFit();
            } else if (instance.isScaledDown()) {
              instance.scaleToActual(tapX, tapY);
            } else if (instance.group.length < 2) {
              instance.close(self.startEvent);
            }
          }

          break;
      }
    }; // Ignore right click


    if (e.originalEvent && e.originalEvent.button == 2) {
      return;
    } // Skip if clicked on the scrollbar


    if (!$target.is("img") && tapX > $target[0].clientWidth + $target.offset().left) {
      return;
    } // Check where is clicked


    if ($target.is(".fancybox-bg,.fancybox-inner,.fancybox-outer,.fancybox-container")) {
      where = "Outside";
    } else if ($target.is(".fancybox-slide")) {
      where = "Slide";
    } else if (instance.current.$content && instance.current.$content.find($target).addBack().filter($target).length) {
      where = "Content";
    } else {
      return;
    } // Check if this is a double tap


    if (self.tapped) {
      // Stop previously created single tap
      clearTimeout(self.tapped);
      self.tapped = null; // Skip if distance between taps is too big

      if (Math.abs(tapX - self.tapX) > 50 || Math.abs(tapY - self.tapY) > 50) {
        return this;
      } // OK, now we assume that this is a double-tap


      process("dblclick" + where);
    } else {
      // Single tap will be processed if user has not clicked second time within 300ms
      // or there is no need to wait for double-tap
      self.tapX = tapX;
      self.tapY = tapY;

      if (current.opts["dblclick" + where] && current.opts["dblclick" + where] !== current.opts["click" + where]) {
        self.tapped = setTimeout(function () {
          self.tapped = null;

          if (!instance.isAnimating) {
            process("click" + where);
          }
        }, 500);
      } else {
        process("click" + where);
      }
    }

    return this;
  };

  $(document).on("onActivate.fb", function (e, instance) {
    if (instance && !instance.Guestures) {
      instance.Guestures = new Guestures(instance);
    }
  }).on("beforeClose.fb", function (e, instance) {
    if (instance && instance.Guestures) {
      instance.Guestures.destroy();
    }
  });
})(window, document, jQuery); // ==========================================================================
//
// SlideShow
// Enables slideshow functionality
//
// Example of usage:
// $.fancybox.getInstance().SlideShow.start()
//
// ==========================================================================


(function (document, $) {
  "use strict";

  $.extend(true, $.fancybox.defaults, {
    btnTpl: {
      slideShow: '<button data-fancybox-play class="fancybox-button fancybox-button--play" title="{{PLAY_START}}">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M6.5 5.4v13.2l11-6.6z"/></svg>' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.33 5.75h2.2v12.5h-2.2V5.75zm5.15 0h2.2v12.5h-2.2V5.75z"/></svg>' + "</button>"
    },
    slideShow: {
      autoStart: false,
      speed: 3000,
      progress: true
    }
  });

  var SlideShow = function SlideShow(instance) {
    this.instance = instance;
    this.init();
  };

  $.extend(SlideShow.prototype, {
    timer: null,
    isActive: false,
    $button: null,
    init: function init() {
      var self = this,
          instance = self.instance,
          opts = instance.group[instance.currIndex].opts.slideShow;
      self.$button = instance.$refs.toolbar.find("[data-fancybox-play]").on("click", function () {
        self.toggle();
      });

      if (instance.group.length < 2 || !opts) {
        self.$button.hide();
      } else if (opts.progress) {
        self.$progress = $('<div class="fancybox-progress"></div>').appendTo(instance.$refs.inner);
      }
    },
    set: function set(force) {
      var self = this,
          instance = self.instance,
          current = instance.current; // Check if reached last element

      if (current && (force === true || current.opts.loop || instance.currIndex < instance.group.length - 1)) {
        if (self.isActive && current.contentType !== "video") {
          if (self.$progress) {
            $.fancybox.animate(self.$progress.show(), {
              scaleX: 1
            }, current.opts.slideShow.speed);
          }

          self.timer = setTimeout(function () {
            if (!instance.current.opts.loop && instance.current.index == instance.group.length - 1) {
              instance.jumpTo(0);
            } else {
              instance.next();
            }
          }, current.opts.slideShow.speed);
        }
      } else {
        self.stop();
        instance.idleSecondsCounter = 0;
        instance.showControls();
      }
    },
    clear: function clear() {
      var self = this;
      clearTimeout(self.timer);
      self.timer = null;

      if (self.$progress) {
        self.$progress.removeAttr("style").hide();
      }
    },
    start: function start() {
      var self = this,
          current = self.instance.current;

      if (current) {
        self.$button.attr("title", (current.opts.i18n[current.opts.lang] || current.opts.i18n.en).PLAY_STOP).removeClass("fancybox-button--play").addClass("fancybox-button--pause");
        self.isActive = true;

        if (current.isComplete) {
          self.set(true);
        }

        self.instance.trigger("onSlideShowChange", true);
      }
    },
    stop: function stop() {
      var self = this,
          current = self.instance.current;
      self.clear();
      self.$button.attr("title", (current.opts.i18n[current.opts.lang] || current.opts.i18n.en).PLAY_START).removeClass("fancybox-button--pause").addClass("fancybox-button--play");
      self.isActive = false;
      self.instance.trigger("onSlideShowChange", false);

      if (self.$progress) {
        self.$progress.removeAttr("style").hide();
      }
    },
    toggle: function toggle() {
      var self = this;

      if (self.isActive) {
        self.stop();
      } else {
        self.start();
      }
    }
  });
  $(document).on({
    "onInit.fb": function onInitFb(e, instance) {
      if (instance && !instance.SlideShow) {
        instance.SlideShow = new SlideShow(instance);
      }
    },
    "beforeShow.fb": function beforeShowFb(e, instance, current, firstRun) {
      var SlideShow = instance && instance.SlideShow;

      if (firstRun) {
        if (SlideShow && current.opts.slideShow.autoStart) {
          SlideShow.start();
        }
      } else if (SlideShow && SlideShow.isActive) {
        SlideShow.clear();
      }
    },
    "afterShow.fb": function afterShowFb(e, instance, current) {
      var SlideShow = instance && instance.SlideShow;

      if (SlideShow && SlideShow.isActive) {
        SlideShow.set();
      }
    },
    "afterKeydown.fb": function afterKeydownFb(e, instance, current, keypress, keycode) {
      var SlideShow = instance && instance.SlideShow; // "P" or Spacebar

      if (SlideShow && current.opts.slideShow && (keycode === 80 || keycode === 32) && !$(document.activeElement).is("button,a,input")) {
        keypress.preventDefault();
        SlideShow.toggle();
      }
    },
    "beforeClose.fb onDeactivate.fb": function beforeCloseFbOnDeactivateFb(e, instance) {
      var SlideShow = instance && instance.SlideShow;

      if (SlideShow) {
        SlideShow.stop();
      }
    }
  }); // Page Visibility API to pause slideshow when window is not active

  $(document).on("visibilitychange", function () {
    var instance = $.fancybox.getInstance(),
        SlideShow = instance && instance.SlideShow;

    if (SlideShow && SlideShow.isActive) {
      if (document.hidden) {
        SlideShow.clear();
      } else {
        SlideShow.set();
      }
    }
  });
})(document, jQuery); // ==========================================================================
//
// FullScreen
// Adds fullscreen functionality
//
// ==========================================================================


(function (document, $) {
  "use strict"; // Collection of methods supported by user browser

  var fn = function () {
    var fnMap = [["requestFullscreen", "exitFullscreen", "fullscreenElement", "fullscreenEnabled", "fullscreenchange", "fullscreenerror"], // new WebKit
    ["webkitRequestFullscreen", "webkitExitFullscreen", "webkitFullscreenElement", "webkitFullscreenEnabled", "webkitfullscreenchange", "webkitfullscreenerror"], // old WebKit (Safari 5.1)
    ["webkitRequestFullScreen", "webkitCancelFullScreen", "webkitCurrentFullScreenElement", "webkitCancelFullScreen", "webkitfullscreenchange", "webkitfullscreenerror"], ["mozRequestFullScreen", "mozCancelFullScreen", "mozFullScreenElement", "mozFullScreenEnabled", "mozfullscreenchange", "mozfullscreenerror"], ["msRequestFullscreen", "msExitFullscreen", "msFullscreenElement", "msFullscreenEnabled", "MSFullscreenChange", "MSFullscreenError"]];
    var ret = {};

    for (var i = 0; i < fnMap.length; i++) {
      var val = fnMap[i];

      if (val && val[1] in document) {
        for (var j = 0; j < val.length; j++) {
          ret[fnMap[0][j]] = val[j];
        }

        return ret;
      }
    }

    return false;
  }();

  if (fn) {
    var FullScreen = {
      request: function request(elem) {
        elem = elem || document.documentElement;
        elem[fn.requestFullscreen](elem.ALLOW_KEYBOARD_INPUT);
      },
      exit: function exit() {
        document[fn.exitFullscreen]();
      },
      toggle: function toggle(elem) {
        elem = elem || document.documentElement;

        if (this.isFullscreen()) {
          this.exit();
        } else {
          this.request(elem);
        }
      },
      isFullscreen: function isFullscreen() {
        return Boolean(document[fn.fullscreenElement]);
      },
      enabled: function enabled() {
        return Boolean(document[fn.fullscreenEnabled]);
      }
    };
    $.extend(true, $.fancybox.defaults, {
      btnTpl: {
        fullScreen: '<button data-fancybox-fullscreen class="fancybox-button fancybox-button--fsenter" title="{{FULL_SCREEN}}">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5 16h3v3h2v-5H5zm3-8H5v2h5V5H8zm6 11h2v-3h3v-2h-5zm2-11V5h-2v5h5V8z"/></svg>' + "</button>"
      },
      fullScreen: {
        autoStart: false
      }
    });
    $(document).on(fn.fullscreenchange, function () {
      var isFullscreen = FullScreen.isFullscreen(),
          instance = $.fancybox.getInstance();

      if (instance) {
        // If image is zooming, then force to stop and reposition properly
        if (instance.current && instance.current.type === "image" && instance.isAnimating) {
          instance.isAnimating = false;
          instance.update(true, true, 0);

          if (!instance.isComplete) {
            instance.complete();
          }
        }

        instance.trigger("onFullscreenChange", isFullscreen);
        instance.$refs.container.toggleClass("fancybox-is-fullscreen", isFullscreen);
        instance.$refs.toolbar.find("[data-fancybox-fullscreen]").toggleClass("fancybox-button--fsenter", !isFullscreen).toggleClass("fancybox-button--fsexit", isFullscreen);
      }
    });
  }

  $(document).on({
    "onInit.fb": function onInitFb(e, instance) {
      var $container;

      if (!fn) {
        instance.$refs.toolbar.find("[data-fancybox-fullscreen]").remove();
        return;
      }

      if (instance && instance.group[instance.currIndex].opts.fullScreen) {
        $container = instance.$refs.container;
        $container.on("click.fb-fullscreen", "[data-fancybox-fullscreen]", function (e) {
          e.stopPropagation();
          e.preventDefault();
          FullScreen.toggle();
        });

        if (instance.opts.fullScreen && instance.opts.fullScreen.autoStart === true) {
          FullScreen.request();
        } // Expose API


        instance.FullScreen = FullScreen;
      } else if (instance) {
        instance.$refs.toolbar.find("[data-fancybox-fullscreen]").hide();
      }
    },
    "afterKeydown.fb": function afterKeydownFb(e, instance, current, keypress, keycode) {
      // "F"
      if (instance && instance.FullScreen && keycode === 70) {
        keypress.preventDefault();
        instance.FullScreen.toggle();
      }
    },
    "beforeClose.fb": function beforeCloseFb(e, instance) {
      if (instance && instance.FullScreen && instance.$refs.container.hasClass("fancybox-is-fullscreen")) {
        FullScreen.exit();
      }
    }
  });
})(document, jQuery); // ==========================================================================
//
// Thumbs
// Displays thumbnails in a grid
//
// ==========================================================================


(function (document, $) {
  "use strict";

  var CLASS = "fancybox-thumbs",
      CLASS_ACTIVE = CLASS + "-active"; // Make sure there are default values

  $.fancybox.defaults = $.extend(true, {
    btnTpl: {
      thumbs: '<button data-fancybox-thumbs class="fancybox-button fancybox-button--thumbs" title="{{THUMBS}}">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14.59 14.59h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76H5.65v-3.76zm8.94-4.47h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76h-3.76v-3.76zm-4.47 0h3.76v3.76H5.65v-3.76zm8.94-4.47h3.76v3.76h-3.76V5.65zm-4.47 0h3.76v3.76h-3.76V5.65zm-4.47 0h3.76v3.76H5.65V5.65z"/></svg>' + "</button>"
    },
    thumbs: {
      autoStart: false,
      // Display thumbnails on opening
      hideOnClose: true,
      // Hide thumbnail grid when closing animation starts
      parentEl: ".fancybox-container",
      // Container is injected into this element
      axis: "y" // Vertical (y) or horizontal (x) scrolling

    }
  }, $.fancybox.defaults);

  var FancyThumbs = function FancyThumbs(instance) {
    this.init(instance);
  };

  $.extend(FancyThumbs.prototype, {
    $button: null,
    $grid: null,
    $list: null,
    isVisible: false,
    isActive: false,
    init: function init(instance) {
      var self = this,
          group = instance.group,
          enabled = 0;
      self.instance = instance;
      self.opts = group[instance.currIndex].opts.thumbs;
      instance.Thumbs = self;
      self.$button = instance.$refs.toolbar.find("[data-fancybox-thumbs]"); // Enable thumbs if at least two group items have thumbnails

      for (var i = 0, len = group.length; i < len; i++) {
        if (group[i].thumb) {
          enabled++;
        }

        if (enabled > 1) {
          break;
        }
      }

      if (enabled > 1 && !!self.opts) {
        self.$button.removeAttr("style").on("click", function () {
          self.toggle();
        });
        self.isActive = true;
      } else {
        self.$button.hide();
      }
    },
    create: function create() {
      var self = this,
          instance = self.instance,
          parentEl = self.opts.parentEl,
          list = [],
          src;

      if (!self.$grid) {
        // Create main element
        self.$grid = $('<div class="' + CLASS + " " + CLASS + "-" + self.opts.axis + '"></div>').appendTo(instance.$refs.container.find(parentEl).addBack().filter(parentEl)); // Add "click" event that performs gallery navigation

        self.$grid.on("click", "a", function () {
          instance.jumpTo($(this).attr("data-index"));
        });
      } // Build the list


      if (!self.$list) {
        self.$list = $('<div class="' + CLASS + '__list">').appendTo(self.$grid);
      }

      $.each(instance.group, function (i, item) {
        src = item.thumb;

        if (!src && item.type === "image") {
          src = item.src;
        }

        list.push('<a href="javascript:;" tabindex="0" data-index="' + i + '"' + (src && src.length ? ' style="background-image:url(' + src + ')"' : 'class="fancybox-thumbs-missing"') + "></a>");
      });
      self.$list[0].innerHTML = list.join("");

      if (self.opts.axis === "x") {
        // Set fixed width for list element to enable horizontal scrolling
        self.$list.width(parseInt(self.$grid.css("padding-right"), 10) + instance.group.length * self.$list.children().eq(0).outerWidth(true));
      }
    },
    focus: function focus(duration) {
      var self = this,
          $list = self.$list,
          $grid = self.$grid,
          thumb,
          thumbPos;

      if (!self.instance.current) {
        return;
      }

      thumb = $list.children().removeClass(CLASS_ACTIVE).filter('[data-index="' + self.instance.current.index + '"]').addClass(CLASS_ACTIVE);
      thumbPos = thumb.position(); // Check if need to scroll to make current thumb visible

      if (self.opts.axis === "y" && (thumbPos.top < 0 || thumbPos.top > $list.height() - thumb.outerHeight())) {
        $list.stop().animate({
          scrollTop: $list.scrollTop() + thumbPos.top
        }, duration);
      } else if (self.opts.axis === "x" && (thumbPos.left < $grid.scrollLeft() || thumbPos.left > $grid.scrollLeft() + ($grid.width() - thumb.outerWidth()))) {
        $list.parent().stop().animate({
          scrollLeft: thumbPos.left
        }, duration);
      }
    },
    update: function update() {
      var that = this;
      that.instance.$refs.container.toggleClass("fancybox-show-thumbs", this.isVisible);

      if (that.isVisible) {
        if (!that.$grid) {
          that.create();
        }

        that.instance.trigger("onThumbsShow");
        that.focus(0);
      } else if (that.$grid) {
        that.instance.trigger("onThumbsHide");
      } // Update content position


      that.instance.update();
    },
    hide: function hide() {
      this.isVisible = false;
      this.update();
    },
    show: function show() {
      this.isVisible = true;
      this.update();
    },
    toggle: function toggle() {
      this.isVisible = !this.isVisible;
      this.update();
    }
  });
  $(document).on({
    "onInit.fb": function onInitFb(e, instance) {
      var Thumbs;

      if (instance && !instance.Thumbs) {
        Thumbs = new FancyThumbs(instance);

        if (Thumbs.isActive && Thumbs.opts.autoStart === true) {
          Thumbs.show();
        }
      }
    },
    "beforeShow.fb": function beforeShowFb(e, instance, item, firstRun) {
      var Thumbs = instance && instance.Thumbs;

      if (Thumbs && Thumbs.isVisible) {
        Thumbs.focus(firstRun ? 0 : 250);
      }
    },
    "afterKeydown.fb": function afterKeydownFb(e, instance, current, keypress, keycode) {
      var Thumbs = instance && instance.Thumbs; // "G"

      if (Thumbs && Thumbs.isActive && keycode === 71) {
        keypress.preventDefault();
        Thumbs.toggle();
      }
    },
    "beforeClose.fb": function beforeCloseFb(e, instance) {
      var Thumbs = instance && instance.Thumbs;

      if (Thumbs && Thumbs.isVisible && Thumbs.opts.hideOnClose !== false) {
        Thumbs.$grid.hide();
      }
    }
  });
})(document, jQuery); //// ==========================================================================
//
// Share
// Displays simple form for sharing current url
//
// ==========================================================================


(function (document, $) {
  "use strict";

  $.extend(true, $.fancybox.defaults, {
    btnTpl: {
      share: '<button data-fancybox-share class="fancybox-button fancybox-button--share" title="{{SHARE}}">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2.55 19c1.4-8.4 9.1-9.8 11.9-9.8V5l7 7-7 6.3v-3.5c-2.8 0-10.5 2.1-11.9 4.2z"/></svg>' + "</button>"
    },
    share: {
      url: function url(instance, item) {
        return (!instance.currentHash && !(item.type === "inline" || item.type === "html") ? item.origSrc || item.src : false) || window.location;
      },
      tpl: '<div class="fancybox-share">' + "<h1>{{SHARE}}</h1>" + "<p>" + '<a class="fancybox-share__button fancybox-share__button--fb" href="https://www.facebook.com/sharer/sharer.php?u={{url}}">' + '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m287 456v-299c0-21 6-35 35-35h38v-63c-7-1-29-3-55-3-54 0-91 33-91 94v306m143-254h-205v72h196" /></svg>' + "<span>Facebook</span>" + "</a>" + '<a class="fancybox-share__button fancybox-share__button--tw" href="https://twitter.com/intent/tweet?url={{url}}&text={{descr}}">' + '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m456 133c-14 7-31 11-47 13 17-10 30-27 37-46-15 10-34 16-52 20-61-62-157-7-141 75-68-3-129-35-169-85-22 37-11 86 26 109-13 0-26-4-37-9 0 39 28 72 65 80-12 3-25 4-37 2 10 33 41 57 77 57-42 30-77 38-122 34 170 111 378-32 359-208 16-11 30-25 41-42z" /></svg>' + "<span>Twitter</span>" + "</a>" + '<a class="fancybox-share__button fancybox-share__button--pt" href="https://www.pinterest.com/pin/create/button/?url={{url}}&description={{descr}}&media={{media}}">' + '<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m265 56c-109 0-164 78-164 144 0 39 15 74 47 87 5 2 10 0 12-5l4-19c2-6 1-8-3-13-9-11-15-25-15-45 0-58 43-110 113-110 62 0 96 38 96 88 0 67-30 122-73 122-24 0-42-19-36-44 6-29 20-60 20-81 0-19-10-35-31-35-25 0-44 26-44 60 0 21 7 36 7 36l-30 125c-8 37-1 83 0 87 0 3 4 4 5 2 2-3 32-39 42-75l16-64c8 16 31 29 56 29 74 0 124-67 124-157 0-69-58-132-146-132z" fill="#fff"/></svg>' + "<span>Pinterest</span>" + "</a>" + "</p>" + '<p><input class="fancybox-share__input" type="text" value="{{url_raw}}" onclick="select()" /></p>' + "</div>"
    }
  });

  function escapeHtml(string) {
    var entityMap = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#39;",
      "/": "&#x2F;",
      "`": "&#x60;",
      "=": "&#x3D;"
    };
    return String(string).replace(/[&<>"'`=\/]/g, function (s) {
      return entityMap[s];
    });
  }

  $(document).on("click", "[data-fancybox-share]", function () {
    var instance = $.fancybox.getInstance(),
        current = instance.current || null,
        url,
        tpl;

    if (!current) {
      return;
    }

    if ($.type(current.opts.share.url) === "function") {
      url = current.opts.share.url.apply(current, [instance, current]);
    }

    tpl = current.opts.share.tpl.replace(/\{\{media\}\}/g, current.type === "image" ? encodeURIComponent(current.src) : "").replace(/\{\{url\}\}/g, encodeURIComponent(url)).replace(/\{\{url_raw\}\}/g, escapeHtml(url)).replace(/\{\{descr\}\}/g, instance.$caption ? encodeURIComponent(instance.$caption.text()) : "");
    $.fancybox.open({
      src: instance.translate(instance, tpl),
      type: "html",
      opts: {
        touch: false,
        animationEffect: false,
        afterLoad: function afterLoad(shareInstance, shareCurrent) {
          // Close self if parent instance is closing
          instance.$refs.container.one("beforeClose.fb", function () {
            shareInstance.close(null, 0);
          }); // Opening links in a popup window

          shareCurrent.$content.find(".fancybox-share__button").click(function () {
            window.open(this.href, "Share", "width=550, height=450");
            return false;
          });
        },
        mobile: {
          autoFocus: false
        }
      }
    });
  });
})(document, jQuery); // ==========================================================================
//
// Hash
// Enables linking to each modal
//
// ==========================================================================


(function (window, document, $) {
  "use strict"; // Simple $.escapeSelector polyfill (for jQuery prior v3)

  if (!$.escapeSelector) {
    $.escapeSelector = function (sel) {
      var rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;

      var fcssescape = function fcssescape(ch, asCodePoint) {
        if (asCodePoint) {
          // U+0000 NULL becomes U+FFFD REPLACEMENT CHARACTER
          if (ch === "\0") {
            return "\uFFFD";
          } // Control characters and (dependent upon position) numbers get escaped as code points


          return ch.slice(0, -1) + "\\" + ch.charCodeAt(ch.length - 1).toString(16) + " ";
        } // Other potentially-special ASCII characters get backslash-escaped


        return "\\" + ch;
      };

      return (sel + "").replace(rcssescape, fcssescape);
    };
  } // Get info about gallery name and current index from url


  function parseUrl() {
    var hash = window.location.hash.substr(1),
        rez = hash.split("-"),
        index = rez.length > 1 && /^\+?\d+$/.test(rez[rez.length - 1]) ? parseInt(rez.pop(-1), 10) || 1 : 1,
        gallery = rez.join("-");
    return {
      hash: hash,

      /* Index is starting from 1 */
      index: index < 1 ? 1 : index,
      gallery: gallery
    };
  } // Trigger click evnt on links to open new fancyBox instance


  function triggerFromUrl(url) {
    if (url.gallery !== "") {
      // If we can find element matching 'data-fancybox' atribute,
      // then triggering click event should start fancyBox
      $("[data-fancybox='" + $.escapeSelector(url.gallery) + "']").eq(url.index - 1).focus().trigger("click.fb-start");
    }
  } // Get gallery name from current instance


  function getGalleryID(instance) {
    var opts, ret;

    if (!instance) {
      return false;
    }

    opts = instance.current ? instance.current.opts : instance.opts;
    ret = opts.hash || (opts.$orig ? opts.$orig.data("fancybox") || opts.$orig.data("fancybox-trigger") : "");
    return ret === "" ? false : ret;
  } // Start when DOM becomes ready


  $(function () {
    // Check if user has disabled this module
    if ($.fancybox.defaults.hash === false) {
      return;
    } // Update hash when opening/closing fancyBox


    $(document).on({
      "onInit.fb": function onInitFb(e, instance) {
        var url, gallery;

        if (instance.group[instance.currIndex].opts.hash === false) {
          return;
        }

        url = parseUrl();
        gallery = getGalleryID(instance); // Make sure gallery start index matches index from hash

        if (gallery && url.gallery && gallery == url.gallery) {
          instance.currIndex = url.index - 1;
        }
      },
      "beforeShow.fb": function beforeShowFb(e, instance, current, firstRun) {
        var gallery;

        if (!current || current.opts.hash === false) {
          return;
        } // Check if need to update window hash


        gallery = getGalleryID(instance);

        if (!gallery) {
          return;
        } // Variable containing last hash value set by fancyBox
        // It will be used to determine if fancyBox needs to close after hash change is detected


        instance.currentHash = gallery + (instance.group.length > 1 ? "-" + (current.index + 1) : ""); // If current hash is the same (this instance most likely is opened by hashchange), then do nothing

        if (window.location.hash === "#" + instance.currentHash) {
          return;
        }

        if (firstRun && !instance.origHash) {
          instance.origHash = window.location.hash;
        }

        if (instance.hashTimer) {
          clearTimeout(instance.hashTimer);
        } // Update hash


        instance.hashTimer = setTimeout(function () {
          if ("replaceState" in window.history) {
            window.history[firstRun ? "pushState" : "replaceState"]({}, document.title, window.location.pathname + window.location.search + "#" + instance.currentHash);

            if (firstRun) {
              instance.hasCreatedHistory = true;
            }
          } else {
            window.location.hash = instance.currentHash;
          }

          instance.hashTimer = null;
        }, 300);
      },
      "beforeClose.fb": function beforeCloseFb(e, instance, current) {
        if (!current || current.opts.hash === false) {
          return;
        }

        clearTimeout(instance.hashTimer); // Goto previous history entry

        if (instance.currentHash && instance.hasCreatedHistory) {
          window.history.back();
        } else if (instance.currentHash) {
          if ("replaceState" in window.history) {
            window.history.replaceState({}, document.title, window.location.pathname + window.location.search + (instance.origHash || ""));
          } else {
            window.location.hash = instance.origHash;
          }
        }

        instance.currentHash = null;
      }
    }); // Check if need to start/close after url has changed

    $(window).on("hashchange.fb", function () {
      var url = parseUrl(),
          fb = null; // Find last fancyBox instance that has "hash"

      $.each($(".fancybox-container").get().reverse(), function (index, value) {
        var tmp = $(value).data("FancyBox");

        if (tmp && tmp.currentHash) {
          fb = tmp;
          return false;
        }
      });

      if (fb) {
        // Now, compare hash values
        if (fb.currentHash !== url.gallery + "-" + url.index && !(url.index === 1 && fb.currentHash == url.gallery)) {
          fb.currentHash = null;
          fb.close();
        }
      } else if (url.gallery !== "") {
        triggerFromUrl(url);
      }
    }); // Check current hash and trigger click event on matching element to start fancyBox, if needed

    setTimeout(function () {
      if (!$.fancybox.getInstance()) {
        triggerFromUrl(parseUrl());
      }
    }, 50);
  });
})(window, document, jQuery); // ==========================================================================
//
// Wheel
// Basic mouse weheel support for gallery navigation
//
// ==========================================================================


(function (document, $) {
  "use strict";

  var prevTime = new Date().getTime();
  $(document).on({
    "onInit.fb": function onInitFb(e, instance, current) {
      instance.$refs.stage.on("mousewheel DOMMouseScroll wheel MozMousePixelScroll", function (e) {
        var current = instance.current,
            currTime = new Date().getTime();

        if (instance.group.length < 2 || current.opts.wheel === false || current.opts.wheel === "auto" && current.type !== "image") {
          return;
        }

        e.preventDefault();
        e.stopPropagation();

        if (current.$slide.hasClass("fancybox-animated")) {
          return;
        }

        e = e.originalEvent || e;

        if (currTime - prevTime < 250) {
          return;
        }

        prevTime = currTime;
        instance[(-e.deltaY || -e.deltaX || e.wheelDelta || -e.detail) < 0 ? "next" : "previous"]();
      });
    }
  });
})(document, jQuery);

/***/ }),

/***/ "./node_modules/dom7/dist/dom7.modular.js":
/*!************************************************!*\
  !*** ./node_modules/dom7/dist/dom7.modular.js ***!
  \************************************************/
/*! exports provided: $, addClass, removeClass, hasClass, toggleClass, attr, removeAttr, prop, data, removeData, dataset, val, transform, transition, on, off, once, trigger, transitionEnd, animationEnd, width, outerWidth, height, outerHeight, offset, hide, show, styles, css, toArray, each, forEach, filter, map, html, text, is, indexOf, index, eq, append, appendTo, prepend, prependTo, insertBefore, insertAfter, next, nextAll, prev, prevAll, siblings, parent, parents, closest, find, children, remove, detach, add, empty, scrollTo, scrollTop, scrollLeft, animate, stop, click, blur, focus, focusin, focusout, keyup, keydown, keypress, submit, change, mousedown, mousemove, mouseup, mouseenter, mouseleave, mouseout, mouseover, touchstart, touchend, touchmove, resize, scroll */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "$", function() { return $; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addClass", function() { return addClass; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "removeClass", function() { return removeClass; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hasClass", function() { return hasClass; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggleClass", function() { return toggleClass; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "attr", function() { return attr; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "removeAttr", function() { return removeAttr; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "prop", function() { return prop; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "data", function() { return data; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "removeData", function() { return removeData; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dataset", function() { return dataset; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "val", function() { return val; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "transform", function() { return transform; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "transition", function() { return transition; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "on", function() { return on; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "off", function() { return off; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "once", function() { return once; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "trigger", function() { return trigger; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "transitionEnd", function() { return transitionEnd; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "animationEnd", function() { return animationEnd; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "width", function() { return width; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "outerWidth", function() { return outerWidth; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "height", function() { return height; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "outerHeight", function() { return outerHeight; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "offset", function() { return offset; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hide", function() { return hide; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "show", function() { return show; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "styles", function() { return styles; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "css", function() { return css; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toArray", function() { return toArray; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "each", function() { return each; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "forEach", function() { return forEach; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "filter", function() { return filter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "map", function() { return map; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "html", function() { return html; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "text", function() { return text; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "is", function() { return is; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "indexOf", function() { return indexOf; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "index", function() { return index; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "eq", function() { return eq; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "append", function() { return append; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "appendTo", function() { return appendTo; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "prepend", function() { return prepend; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "prependTo", function() { return prependTo; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "insertBefore", function() { return insertBefore; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "insertAfter", function() { return insertAfter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "next", function() { return next; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "nextAll", function() { return nextAll; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "prev", function() { return prev; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "prevAll", function() { return prevAll; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "siblings", function() { return siblings; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parent", function() { return parent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parents", function() { return parents; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "closest", function() { return closest; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "find", function() { return find; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "children", function() { return children; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "remove", function() { return remove; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "detach", function() { return detach; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "add", function() { return add; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "empty", function() { return empty; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "scrollTo", function() { return scrollTo; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "scrollTop", function() { return scrollTop; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "scrollLeft", function() { return scrollLeft; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "animate", function() { return animate; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "stop", function() { return stop; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "click", function() { return click; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "blur", function() { return blur; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "focus", function() { return focus; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "focusin", function() { return focusin; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "focusout", function() { return focusout; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "keyup", function() { return keyup; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "keydown", function() { return keydown; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "keypress", function() { return keypress; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "submit", function() { return submit; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "change", function() { return change; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mousedown", function() { return mousedown; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mousemove", function() { return mousemove; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mouseup", function() { return mouseup; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mouseenter", function() { return mouseenter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mouseleave", function() { return mouseleave; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mouseout", function() { return mouseout; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mouseover", function() { return mouseover; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "touchstart", function() { return touchstart; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "touchend", function() { return touchend; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "touchmove", function() { return touchmove; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resize", function() { return resize; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "scroll", function() { return scroll; });
/* harmony import */ var ssr_window__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ssr-window */ "./node_modules/ssr-window/dist/ssr-window.esm.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Dom7 2.1.5
 * Minimalistic JavaScript library for DOM manipulation, with a jQuery-compatible API
 * http://framework7.io/docs/dom.html
 *
 * Copyright 2020, Vladimir Kharlampidi
 * The iDangero.us
 * http://www.idangero.us/
 *
 * Licensed under MIT
 *
 * Released on: May 15, 2020
 */


var Dom7 = function Dom7(arr) {
  _classCallCheck(this, Dom7);

  var self = this; // Create array-like object

  for (var i = 0; i < arr.length; i += 1) {
    self[i] = arr[i];
  }

  self.length = arr.length; // Return collection with methods

  return this;
};

function $(selector, context) {
  var arr = [];
  var i = 0;

  if (selector && !context) {
    if (selector instanceof Dom7) {
      return selector;
    }
  }

  if (selector) {
    // String
    if (typeof selector === 'string') {
      var els;
      var tempParent;

      var _html = selector.trim();

      if (_html.indexOf('<') >= 0 && _html.indexOf('>') >= 0) {
        var toCreate = 'div';
        if (_html.indexOf('<li') === 0) toCreate = 'ul';
        if (_html.indexOf('<tr') === 0) toCreate = 'tbody';
        if (_html.indexOf('<td') === 0 || _html.indexOf('<th') === 0) toCreate = 'tr';
        if (_html.indexOf('<tbody') === 0) toCreate = 'table';
        if (_html.indexOf('<option') === 0) toCreate = 'select';
        tempParent = ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"].createElement(toCreate);
        tempParent.innerHTML = _html;

        for (i = 0; i < tempParent.childNodes.length; i += 1) {
          arr.push(tempParent.childNodes[i]);
        }
      } else {
        if (!context && selector[0] === '#' && !selector.match(/[ .<>:~]/)) {
          // Pure ID selector
          els = [ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"].getElementById(selector.trim().split('#')[1])];
        } else {
          // Other selectors
          els = (context || ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"]).querySelectorAll(selector.trim());
        }

        for (i = 0; i < els.length; i += 1) {
          if (els[i]) arr.push(els[i]);
        }
      }
    } else if (selector.nodeType || selector === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"] || selector === ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"]) {
      // Node/element
      arr.push(selector);
    } else if (selector.length > 0 && selector[0].nodeType) {
      // Array of elements or instance of Dom
      for (i = 0; i < selector.length; i += 1) {
        arr.push(selector[i]);
      }
    }
  }

  return new Dom7(arr);
}

$.fn = Dom7.prototype;
$.Class = Dom7;
$.Dom7 = Dom7;

function unique(arr) {
  var uniqueArray = [];

  for (var i = 0; i < arr.length; i += 1) {
    if (uniqueArray.indexOf(arr[i]) === -1) uniqueArray.push(arr[i]);
  }

  return uniqueArray;
}

function toCamelCase(string) {
  return string.toLowerCase().replace(/-(.)/g, function (match, group1) {
    return group1.toUpperCase();
  });
}

function requestAnimationFrame(callback) {
  if (ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].requestAnimationFrame) return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].requestAnimationFrame(callback);else if (ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].webkitRequestAnimationFrame) return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].webkitRequestAnimationFrame(callback);
  return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].setTimeout(callback, 1000 / 60);
}

function cancelAnimationFrame(id) {
  if (ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].cancelAnimationFrame) return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].cancelAnimationFrame(id);else if (ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].webkitCancelAnimationFrame) return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].webkitCancelAnimationFrame(id);
  return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].clearTimeout(id);
} // Classes and attributes


function addClass(className) {
  if (typeof className === 'undefined') {
    return this;
  }

  var classes = className.split(' ');

  for (var i = 0; i < classes.length; i += 1) {
    for (var j = 0; j < this.length; j += 1) {
      if (typeof this[j] !== 'undefined' && typeof this[j].classList !== 'undefined') this[j].classList.add(classes[i]);
    }
  }

  return this;
}

function removeClass(className) {
  var classes = className.split(' ');

  for (var i = 0; i < classes.length; i += 1) {
    for (var j = 0; j < this.length; j += 1) {
      if (typeof this[j] !== 'undefined' && typeof this[j].classList !== 'undefined') this[j].classList.remove(classes[i]);
    }
  }

  return this;
}

function hasClass(className) {
  if (!this[0]) return false;
  return this[0].classList.contains(className);
}

function toggleClass(className) {
  var classes = className.split(' ');

  for (var i = 0; i < classes.length; i += 1) {
    for (var j = 0; j < this.length; j += 1) {
      if (typeof this[j] !== 'undefined' && typeof this[j].classList !== 'undefined') this[j].classList.toggle(classes[i]);
    }
  }

  return this;
}

function attr(attrs, value) {
  if (arguments.length === 1 && typeof attrs === 'string') {
    // Get attr
    if (this[0]) return this[0].getAttribute(attrs);
    return undefined;
  } // Set attrs


  for (var i = 0; i < this.length; i += 1) {
    if (arguments.length === 2) {
      // String
      this[i].setAttribute(attrs, value);
    } else {
      // Object
      // eslint-disable-next-line
      for (var attrName in attrs) {
        this[i][attrName] = attrs[attrName];
        this[i].setAttribute(attrName, attrs[attrName]);
      }
    }
  }

  return this;
} // eslint-disable-next-line


function removeAttr(attr) {
  for (var i = 0; i < this.length; i += 1) {
    this[i].removeAttribute(attr);
  }

  return this;
} // eslint-disable-next-line


function prop(props, value) {
  if (arguments.length === 1 && typeof props === 'string') {
    // Get prop
    if (this[0]) return this[0][props];
  } else {
    // Set props
    for (var i = 0; i < this.length; i += 1) {
      if (arguments.length === 2) {
        // String
        this[i][props] = value;
      } else {
        // Object
        // eslint-disable-next-line
        for (var propName in props) {
          this[i][propName] = props[propName];
        }
      }
    }

    return this;
  }
}

function data(key, value) {
  var el;

  if (typeof value === 'undefined') {
    el = this[0]; // Get value

    if (el) {
      if (el.dom7ElementDataStorage && key in el.dom7ElementDataStorage) {
        return el.dom7ElementDataStorage[key];
      }

      var dataKey = el.getAttribute("data-".concat(key));

      if (dataKey) {
        return dataKey;
      }

      return undefined;
    }

    return undefined;
  } // Set value


  for (var i = 0; i < this.length; i += 1) {
    el = this[i];
    if (!el.dom7ElementDataStorage) el.dom7ElementDataStorage = {};
    el.dom7ElementDataStorage[key] = value;
  }

  return this;
}

function removeData(key) {
  for (var i = 0; i < this.length; i += 1) {
    var el = this[i];

    if (el.dom7ElementDataStorage && el.dom7ElementDataStorage[key]) {
      el.dom7ElementDataStorage[key] = null;
      delete el.dom7ElementDataStorage[key];
    }
  }
}

function dataset() {
  var el = this[0];
  if (!el) return undefined;
  var dataset = {}; // eslint-disable-line

  if (el.dataset) {
    // eslint-disable-next-line
    for (var dataKey in el.dataset) {
      dataset[dataKey] = el.dataset[dataKey];
    }
  } else {
    for (var i = 0; i < el.attributes.length; i += 1) {
      // eslint-disable-next-line
      var _attr = el.attributes[i];

      if (_attr.name.indexOf('data-') >= 0) {
        dataset[toCamelCase(_attr.name.split('data-')[1])] = _attr.value;
      }
    }
  } // eslint-disable-next-line


  for (var key in dataset) {
    if (dataset[key] === 'false') dataset[key] = false;else if (dataset[key] === 'true') dataset[key] = true;else if (parseFloat(dataset[key]) === dataset[key] * 1) dataset[key] *= 1;
  }

  return dataset;
}

function val(value) {
  var dom = this;

  if (typeof value === 'undefined') {
    if (dom[0]) {
      if (dom[0].multiple && dom[0].nodeName.toLowerCase() === 'select') {
        var values = [];

        for (var i = 0; i < dom[0].selectedOptions.length; i += 1) {
          values.push(dom[0].selectedOptions[i].value);
        }

        return values;
      }

      return dom[0].value;
    }

    return undefined;
  }

  for (var _i = 0; _i < dom.length; _i += 1) {
    var el = dom[_i];

    if (Array.isArray(value) && el.multiple && el.nodeName.toLowerCase() === 'select') {
      for (var j = 0; j < el.options.length; j += 1) {
        el.options[j].selected = value.indexOf(el.options[j].value) >= 0;
      }
    } else {
      el.value = value;
    }
  }

  return dom;
} // Transforms
// eslint-disable-next-line


function transform(transform) {
  for (var i = 0; i < this.length; i += 1) {
    var elStyle = this[i].style;
    elStyle.webkitTransform = transform;
    elStyle.transform = transform;
  }

  return this;
}

function transition(duration) {
  if (typeof duration !== 'string') {
    duration = "".concat(duration, "ms"); // eslint-disable-line
  }

  for (var i = 0; i < this.length; i += 1) {
    var elStyle = this[i].style;
    elStyle.webkitTransitionDuration = duration;
    elStyle.transitionDuration = duration;
  }

  return this;
} // Events


function on() {
  for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
    args[_key] = arguments[_key];
  }

  var eventType = args[0],
      targetSelector = args[1],
      listener = args[2],
      capture = args[3];

  if (typeof args[1] === 'function') {
    eventType = args[0];
    listener = args[1];
    capture = args[2];
    targetSelector = undefined;
  }

  if (!capture) capture = false;

  function handleLiveEvent(e) {
    var target = e.target;
    if (!target) return;
    var eventData = e.target.dom7EventData || [];

    if (eventData.indexOf(e) < 0) {
      eventData.unshift(e);
    }

    if ($(target).is(targetSelector)) listener.apply(target, eventData);else {
      var _parents = $(target).parents(); // eslint-disable-line


      for (var k = 0; k < _parents.length; k += 1) {
        if ($(_parents[k]).is(targetSelector)) listener.apply(_parents[k], eventData);
      }
    }
  }

  function handleEvent(e) {
    var eventData = e && e.target ? e.target.dom7EventData || [] : [];

    if (eventData.indexOf(e) < 0) {
      eventData.unshift(e);
    }

    listener.apply(this, eventData);
  }

  var events = eventType.split(' ');
  var j;

  for (var i = 0; i < this.length; i += 1) {
    var el = this[i];

    if (!targetSelector) {
      for (j = 0; j < events.length; j += 1) {
        var event = events[j];
        if (!el.dom7Listeners) el.dom7Listeners = {};
        if (!el.dom7Listeners[event]) el.dom7Listeners[event] = [];
        el.dom7Listeners[event].push({
          listener: listener,
          proxyListener: handleEvent
        });
        el.addEventListener(event, handleEvent, capture);
      }
    } else {
      // Live events
      for (j = 0; j < events.length; j += 1) {
        var _event = events[j];
        if (!el.dom7LiveListeners) el.dom7LiveListeners = {};
        if (!el.dom7LiveListeners[_event]) el.dom7LiveListeners[_event] = [];

        el.dom7LiveListeners[_event].push({
          listener: listener,
          proxyListener: handleLiveEvent
        });

        el.addEventListener(_event, handleLiveEvent, capture);
      }
    }
  }

  return this;
}

function off() {
  for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
    args[_key2] = arguments[_key2];
  }

  var eventType = args[0],
      targetSelector = args[1],
      listener = args[2],
      capture = args[3];

  if (typeof args[1] === 'function') {
    eventType = args[0];
    listener = args[1];
    capture = args[2];
    targetSelector = undefined;
  }

  if (!capture) capture = false;
  var events = eventType.split(' ');

  for (var i = 0; i < events.length; i += 1) {
    var event = events[i];

    for (var j = 0; j < this.length; j += 1) {
      var el = this[j];
      var handlers = void 0;

      if (!targetSelector && el.dom7Listeners) {
        handlers = el.dom7Listeners[event];
      } else if (targetSelector && el.dom7LiveListeners) {
        handlers = el.dom7LiveListeners[event];
      }

      if (handlers && handlers.length) {
        for (var k = handlers.length - 1; k >= 0; k -= 1) {
          var handler = handlers[k];

          if (listener && handler.listener === listener) {
            el.removeEventListener(event, handler.proxyListener, capture);
            handlers.splice(k, 1);
          } else if (listener && handler.listener && handler.listener.dom7proxy && handler.listener.dom7proxy === listener) {
            el.removeEventListener(event, handler.proxyListener, capture);
            handlers.splice(k, 1);
          } else if (!listener) {
            el.removeEventListener(event, handler.proxyListener, capture);
            handlers.splice(k, 1);
          }
        }
      }
    }
  }

  return this;
}

function once() {
  var dom = this;

  for (var _len3 = arguments.length, args = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
    args[_key3] = arguments[_key3];
  }

  var eventName = args[0],
      targetSelector = args[1],
      listener = args[2],
      capture = args[3];

  if (typeof args[1] === 'function') {
    eventName = args[0];
    listener = args[1];
    capture = args[2];
    targetSelector = undefined;
  }

  function onceHandler() {
    for (var _len4 = arguments.length, eventArgs = new Array(_len4), _key4 = 0; _key4 < _len4; _key4++) {
      eventArgs[_key4] = arguments[_key4];
    }

    listener.apply(this, eventArgs);
    dom.off(eventName, targetSelector, onceHandler, capture);

    if (onceHandler.dom7proxy) {
      delete onceHandler.dom7proxy;
    }
  }

  onceHandler.dom7proxy = listener;
  return dom.on(eventName, targetSelector, onceHandler, capture);
}

function trigger() {
  for (var _len5 = arguments.length, args = new Array(_len5), _key5 = 0; _key5 < _len5; _key5++) {
    args[_key5] = arguments[_key5];
  }

  var events = args[0].split(' ');
  var eventData = args[1];

  for (var i = 0; i < events.length; i += 1) {
    var event = events[i];

    for (var j = 0; j < this.length; j += 1) {
      var el = this[j];
      var evt = void 0;

      try {
        evt = new ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].CustomEvent(event, {
          detail: eventData,
          bubbles: true,
          cancelable: true
        });
      } catch (e) {
        evt = ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"].createEvent('Event');
        evt.initEvent(event, true, true);
        evt.detail = eventData;
      } // eslint-disable-next-line


      el.dom7EventData = args.filter(function (data, dataIndex) {
        return dataIndex > 0;
      });
      el.dispatchEvent(evt);
      el.dom7EventData = [];
      delete el.dom7EventData;
    }
  }

  return this;
}

function transitionEnd(callback) {
  var events = ['webkitTransitionEnd', 'transitionend'];
  var dom = this;
  var i;

  function fireCallBack(e) {
    /* jshint validthis:true */
    if (e.target !== this) return;
    callback.call(this, e);

    for (i = 0; i < events.length; i += 1) {
      dom.off(events[i], fireCallBack);
    }
  }

  if (callback) {
    for (i = 0; i < events.length; i += 1) {
      dom.on(events[i], fireCallBack);
    }
  }

  return this;
}

function animationEnd(callback) {
  var events = ['webkitAnimationEnd', 'animationend'];
  var dom = this;
  var i;

  function fireCallBack(e) {
    if (e.target !== this) return;
    callback.call(this, e);

    for (i = 0; i < events.length; i += 1) {
      dom.off(events[i], fireCallBack);
    }
  }

  if (callback) {
    for (i = 0; i < events.length; i += 1) {
      dom.on(events[i], fireCallBack);
    }
  }

  return this;
} // Sizing/Styles


function width() {
  if (this[0] === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"]) {
    return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].innerWidth;
  }

  if (this.length > 0) {
    return parseFloat(this.css('width'));
  }

  return null;
}

function outerWidth(includeMargins) {
  if (this.length > 0) {
    if (includeMargins) {
      // eslint-disable-next-line
      var _styles = this.styles();

      return this[0].offsetWidth + parseFloat(_styles.getPropertyValue('margin-right')) + parseFloat(_styles.getPropertyValue('margin-left'));
    }

    return this[0].offsetWidth;
  }

  return null;
}

function height() {
  if (this[0] === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"]) {
    return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].innerHeight;
  }

  if (this.length > 0) {
    return parseFloat(this.css('height'));
  }

  return null;
}

function outerHeight(includeMargins) {
  if (this.length > 0) {
    if (includeMargins) {
      // eslint-disable-next-line
      var _styles2 = this.styles();

      return this[0].offsetHeight + parseFloat(_styles2.getPropertyValue('margin-top')) + parseFloat(_styles2.getPropertyValue('margin-bottom'));
    }

    return this[0].offsetHeight;
  }

  return null;
}

function offset() {
  if (this.length > 0) {
    var el = this[0];
    var box = el.getBoundingClientRect();
    var body = ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"].body;
    var clientTop = el.clientTop || body.clientTop || 0;
    var clientLeft = el.clientLeft || body.clientLeft || 0;

    var _scrollTop = el === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"] ? ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].scrollY : el.scrollTop;

    var _scrollLeft = el === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"] ? ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].scrollX : el.scrollLeft;

    return {
      top: box.top + _scrollTop - clientTop,
      left: box.left + _scrollLeft - clientLeft
    };
  }

  return null;
}

function hide() {
  for (var i = 0; i < this.length; i += 1) {
    this[i].style.display = 'none';
  }

  return this;
}

function show() {
  for (var i = 0; i < this.length; i += 1) {
    var el = this[i];

    if (el.style.display === 'none') {
      el.style.display = '';
    }

    if (ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].getComputedStyle(el, null).getPropertyValue('display') === 'none') {
      // Still not visible
      el.style.display = 'block';
    }
  }

  return this;
}

function styles() {
  if (this[0]) return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].getComputedStyle(this[0], null);
  return {};
}

function css(props, value) {
  var i;

  if (arguments.length === 1) {
    if (typeof props === 'string') {
      if (this[0]) return ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].getComputedStyle(this[0], null).getPropertyValue(props);
    } else {
      for (i = 0; i < this.length; i += 1) {
        // eslint-disable-next-line
        for (var _prop in props) {
          this[i].style[_prop] = props[_prop];
        }
      }

      return this;
    }
  }

  if (arguments.length === 2 && typeof props === 'string') {
    for (i = 0; i < this.length; i += 1) {
      this[i].style[props] = value;
    }

    return this;
  }

  return this;
} // Dom manipulation


function toArray() {
  var arr = [];

  for (var i = 0; i < this.length; i += 1) {
    arr.push(this[i]);
  }

  return arr;
} // Iterate over the collection passing elements to `callback`


function each(callback) {
  // Don't bother continuing without a callback
  if (!callback) return this; // Iterate over the current collection

  for (var i = 0; i < this.length; i += 1) {
    // If the callback returns false
    if (callback.call(this[i], i, this[i]) === false) {
      // End the loop early
      return this;
    }
  } // Return `this` to allow chained DOM operations


  return this;
}

function forEach(callback) {
  // Don't bother continuing without a callback
  if (!callback) return this; // Iterate over the current collection

  for (var i = 0; i < this.length; i += 1) {
    // If the callback returns false
    if (callback.call(this[i], this[i], i) === false) {
      // End the loop early
      return this;
    }
  } // Return `this` to allow chained DOM operations


  return this;
}

function filter(callback) {
  var matchedItems = [];
  var dom = this;

  for (var i = 0; i < dom.length; i += 1) {
    if (callback.call(dom[i], i, dom[i])) matchedItems.push(dom[i]);
  }

  return new Dom7(matchedItems);
}

function map(callback) {
  var modifiedItems = [];
  var dom = this;

  for (var i = 0; i < dom.length; i += 1) {
    modifiedItems.push(callback.call(dom[i], i, dom[i]));
  }

  return new Dom7(modifiedItems);
} // eslint-disable-next-line


function html(html) {
  if (typeof html === 'undefined') {
    return this[0] ? this[0].innerHTML : undefined;
  }

  for (var i = 0; i < this.length; i += 1) {
    this[i].innerHTML = html;
  }

  return this;
} // eslint-disable-next-line


function text(text) {
  if (typeof text === 'undefined') {
    if (this[0]) {
      return this[0].textContent.trim();
    }

    return null;
  }

  for (var i = 0; i < this.length; i += 1) {
    this[i].textContent = text;
  }

  return this;
}

function is(selector) {
  var el = this[0];
  var compareWith;
  var i;
  if (!el || typeof selector === 'undefined') return false;

  if (typeof selector === 'string') {
    if (el.matches) return el.matches(selector);else if (el.webkitMatchesSelector) return el.webkitMatchesSelector(selector);else if (el.msMatchesSelector) return el.msMatchesSelector(selector);
    compareWith = $(selector);

    for (i = 0; i < compareWith.length; i += 1) {
      if (compareWith[i] === el) return true;
    }

    return false;
  } else if (selector === ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"]) return el === ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"];else if (selector === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"]) return el === ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"];

  if (selector.nodeType || selector instanceof Dom7) {
    compareWith = selector.nodeType ? [selector] : selector;

    for (i = 0; i < compareWith.length; i += 1) {
      if (compareWith[i] === el) return true;
    }

    return false;
  }

  return false;
}

function indexOf(el) {
  for (var i = 0; i < this.length; i += 1) {
    if (this[i] === el) return i;
  }

  return -1;
}

function index() {
  var child = this[0];
  var i;

  if (child) {
    i = 0; // eslint-disable-next-line

    while ((child = child.previousSibling) !== null) {
      if (child.nodeType === 1) i += 1;
    }

    return i;
  }

  return undefined;
} // eslint-disable-next-line


function eq(index) {
  if (typeof index === 'undefined') return this;
  var length = this.length;
  var returnIndex;

  if (index > length - 1) {
    return new Dom7([]);
  }

  if (index < 0) {
    returnIndex = length + index;
    if (returnIndex < 0) return new Dom7([]);
    return new Dom7([this[returnIndex]]);
  }

  return new Dom7([this[index]]);
}

function append() {
  var newChild;

  for (var k = 0; k < arguments.length; k += 1) {
    newChild = k < 0 || arguments.length <= k ? undefined : arguments[k];

    for (var i = 0; i < this.length; i += 1) {
      if (typeof newChild === 'string') {
        var tempDiv = ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"].createElement('div');
        tempDiv.innerHTML = newChild;

        while (tempDiv.firstChild) {
          this[i].appendChild(tempDiv.firstChild);
        }
      } else if (newChild instanceof Dom7) {
        for (var j = 0; j < newChild.length; j += 1) {
          this[i].appendChild(newChild[j]);
        }
      } else {
        this[i].appendChild(newChild);
      }
    }
  }

  return this;
} // eslint-disable-next-line


function appendTo(parent) {
  $(parent).append(this);
  return this;
}

function prepend(newChild) {
  var i;
  var j;

  for (i = 0; i < this.length; i += 1) {
    if (typeof newChild === 'string') {
      var tempDiv = ssr_window__WEBPACK_IMPORTED_MODULE_0__["document"].createElement('div');
      tempDiv.innerHTML = newChild;

      for (j = tempDiv.childNodes.length - 1; j >= 0; j -= 1) {
        this[i].insertBefore(tempDiv.childNodes[j], this[i].childNodes[0]);
      }
    } else if (newChild instanceof Dom7) {
      for (j = 0; j < newChild.length; j += 1) {
        this[i].insertBefore(newChild[j], this[i].childNodes[0]);
      }
    } else {
      this[i].insertBefore(newChild, this[i].childNodes[0]);
    }
  }

  return this;
} // eslint-disable-next-line


function prependTo(parent) {
  $(parent).prepend(this);
  return this;
}

function insertBefore(selector) {
  var before = $(selector);

  for (var i = 0; i < this.length; i += 1) {
    if (before.length === 1) {
      before[0].parentNode.insertBefore(this[i], before[0]);
    } else if (before.length > 1) {
      for (var j = 0; j < before.length; j += 1) {
        before[j].parentNode.insertBefore(this[i].cloneNode(true), before[j]);
      }
    }
  }
}

function insertAfter(selector) {
  var after = $(selector);

  for (var i = 0; i < this.length; i += 1) {
    if (after.length === 1) {
      after[0].parentNode.insertBefore(this[i], after[0].nextSibling);
    } else if (after.length > 1) {
      for (var j = 0; j < after.length; j += 1) {
        after[j].parentNode.insertBefore(this[i].cloneNode(true), after[j].nextSibling);
      }
    }
  }
}

function next(selector) {
  if (this.length > 0) {
    if (selector) {
      if (this[0].nextElementSibling && $(this[0].nextElementSibling).is(selector)) {
        return new Dom7([this[0].nextElementSibling]);
      }

      return new Dom7([]);
    }

    if (this[0].nextElementSibling) return new Dom7([this[0].nextElementSibling]);
    return new Dom7([]);
  }

  return new Dom7([]);
}

function nextAll(selector) {
  var nextEls = [];
  var el = this[0];
  if (!el) return new Dom7([]);

  while (el.nextElementSibling) {
    var _next = el.nextElementSibling; // eslint-disable-line

    if (selector) {
      if ($(_next).is(selector)) nextEls.push(_next);
    } else nextEls.push(_next);

    el = _next;
  }

  return new Dom7(nextEls);
}

function prev(selector) {
  if (this.length > 0) {
    var el = this[0];

    if (selector) {
      if (el.previousElementSibling && $(el.previousElementSibling).is(selector)) {
        return new Dom7([el.previousElementSibling]);
      }

      return new Dom7([]);
    }

    if (el.previousElementSibling) return new Dom7([el.previousElementSibling]);
    return new Dom7([]);
  }

  return new Dom7([]);
}

function prevAll(selector) {
  var prevEls = [];
  var el = this[0];
  if (!el) return new Dom7([]);

  while (el.previousElementSibling) {
    var _prev = el.previousElementSibling; // eslint-disable-line

    if (selector) {
      if ($(_prev).is(selector)) prevEls.push(_prev);
    } else prevEls.push(_prev);

    el = _prev;
  }

  return new Dom7(prevEls);
}

function siblings(selector) {
  return this.nextAll(selector).add(this.prevAll(selector));
}

function parent(selector) {
  var parents = []; // eslint-disable-line

  for (var i = 0; i < this.length; i += 1) {
    if (this[i].parentNode !== null) {
      if (selector) {
        if ($(this[i].parentNode).is(selector)) parents.push(this[i].parentNode);
      } else {
        parents.push(this[i].parentNode);
      }
    }
  }

  return $(unique(parents));
}

function parents(selector) {
  var parents = []; // eslint-disable-line

  for (var i = 0; i < this.length; i += 1) {
    var _parent = this[i].parentNode; // eslint-disable-line

    while (_parent) {
      if (selector) {
        if ($(_parent).is(selector)) parents.push(_parent);
      } else {
        parents.push(_parent);
      }

      _parent = _parent.parentNode;
    }
  }

  return $(unique(parents));
}

function closest(selector) {
  var closest = this; // eslint-disable-line

  if (typeof selector === 'undefined') {
    return new Dom7([]);
  }

  if (!closest.is(selector)) {
    closest = closest.parents(selector).eq(0);
  }

  return closest;
}

function find(selector) {
  var foundElements = [];

  for (var i = 0; i < this.length; i += 1) {
    var found = this[i].querySelectorAll(selector);

    for (var j = 0; j < found.length; j += 1) {
      foundElements.push(found[j]);
    }
  }

  return new Dom7(foundElements);
}

function children(selector) {
  var children = []; // eslint-disable-line

  for (var i = 0; i < this.length; i += 1) {
    var childNodes = this[i].childNodes;

    for (var j = 0; j < childNodes.length; j += 1) {
      if (!selector) {
        if (childNodes[j].nodeType === 1) children.push(childNodes[j]);
      } else if (childNodes[j].nodeType === 1 && $(childNodes[j]).is(selector)) {
        children.push(childNodes[j]);
      }
    }
  }

  return new Dom7(unique(children));
}

function remove() {
  for (var i = 0; i < this.length; i += 1) {
    if (this[i].parentNode) this[i].parentNode.removeChild(this[i]);
  }

  return this;
}

function detach() {
  return this.remove();
}

function add() {
  var dom = this;
  var i;
  var j;

  for (var _len6 = arguments.length, args = new Array(_len6), _key6 = 0; _key6 < _len6; _key6++) {
    args[_key6] = arguments[_key6];
  }

  for (i = 0; i < args.length; i += 1) {
    var toAdd = $(args[i]);

    for (j = 0; j < toAdd.length; j += 1) {
      dom[dom.length] = toAdd[j];
      dom.length += 1;
    }
  }

  return dom;
}

function empty() {
  for (var i = 0; i < this.length; i += 1) {
    var el = this[i];

    if (el.nodeType === 1) {
      for (var j = 0; j < el.childNodes.length; j += 1) {
        if (el.childNodes[j].parentNode) {
          el.childNodes[j].parentNode.removeChild(el.childNodes[j]);
        }
      }

      el.textContent = '';
    }
  }

  return this;
}

function scrollTo() {
  for (var _len7 = arguments.length, args = new Array(_len7), _key7 = 0; _key7 < _len7; _key7++) {
    args[_key7] = arguments[_key7];
  }

  var left = args[0],
      top = args[1],
      duration = args[2],
      easing = args[3],
      callback = args[4];

  if (args.length === 4 && typeof easing === 'function') {
    callback = easing;
    left = args[0];
    top = args[1];
    duration = args[2];
    callback = args[3];
    easing = args[4];
  }

  if (typeof easing === 'undefined') easing = 'swing';
  return this.each(function animate() {
    var el = this;
    var currentTop;
    var currentLeft;
    var maxTop;
    var maxLeft;
    var newTop;
    var newLeft;
    var scrollTop; // eslint-disable-line

    var scrollLeft; // eslint-disable-line

    var animateTop = top > 0 || top === 0;
    var animateLeft = left > 0 || left === 0;

    if (typeof easing === 'undefined') {
      easing = 'swing';
    }

    if (animateTop) {
      currentTop = el.scrollTop;

      if (!duration) {
        el.scrollTop = top;
      }
    }

    if (animateLeft) {
      currentLeft = el.scrollLeft;

      if (!duration) {
        el.scrollLeft = left;
      }
    }

    if (!duration) return;

    if (animateTop) {
      maxTop = el.scrollHeight - el.offsetHeight;
      newTop = Math.max(Math.min(top, maxTop), 0);
    }

    if (animateLeft) {
      maxLeft = el.scrollWidth - el.offsetWidth;
      newLeft = Math.max(Math.min(left, maxLeft), 0);
    }

    var startTime = null;
    if (animateTop && newTop === currentTop) animateTop = false;
    if (animateLeft && newLeft === currentLeft) animateLeft = false;

    function render() {
      var time = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : new Date().getTime();

      if (startTime === null) {
        startTime = time;
      }

      var progress = Math.max(Math.min((time - startTime) / duration, 1), 0);
      var easeProgress = easing === 'linear' ? progress : 0.5 - Math.cos(progress * Math.PI) / 2;
      var done;
      if (animateTop) scrollTop = currentTop + easeProgress * (newTop - currentTop);
      if (animateLeft) scrollLeft = currentLeft + easeProgress * (newLeft - currentLeft);

      if (animateTop && newTop > currentTop && scrollTop >= newTop) {
        el.scrollTop = newTop;
        done = true;
      }

      if (animateTop && newTop < currentTop && scrollTop <= newTop) {
        el.scrollTop = newTop;
        done = true;
      }

      if (animateLeft && newLeft > currentLeft && scrollLeft >= newLeft) {
        el.scrollLeft = newLeft;
        done = true;
      }

      if (animateLeft && newLeft < currentLeft && scrollLeft <= newLeft) {
        el.scrollLeft = newLeft;
        done = true;
      }

      if (done) {
        if (callback) callback();
        return;
      }

      if (animateTop) el.scrollTop = scrollTop;
      if (animateLeft) el.scrollLeft = scrollLeft;
      requestAnimationFrame(render);
    }

    requestAnimationFrame(render);
  });
} // scrollTop(top, duration, easing, callback) {


function scrollTop() {
  for (var _len8 = arguments.length, args = new Array(_len8), _key8 = 0; _key8 < _len8; _key8++) {
    args[_key8] = arguments[_key8];
  }

  var top = args[0],
      duration = args[1],
      easing = args[2],
      callback = args[3];

  if (args.length === 3 && typeof easing === 'function') {
    top = args[0];
    duration = args[1];
    callback = args[2];
    easing = args[3];
  }

  var dom = this;

  if (typeof top === 'undefined') {
    if (dom.length > 0) return dom[0].scrollTop;
    return null;
  }

  return dom.scrollTo(undefined, top, duration, easing, callback);
}

function scrollLeft() {
  for (var _len9 = arguments.length, args = new Array(_len9), _key9 = 0; _key9 < _len9; _key9++) {
    args[_key9] = arguments[_key9];
  }

  var left = args[0],
      duration = args[1],
      easing = args[2],
      callback = args[3];

  if (args.length === 3 && typeof easing === 'function') {
    left = args[0];
    duration = args[1];
    callback = args[2];
    easing = args[3];
  }

  var dom = this;

  if (typeof left === 'undefined') {
    if (dom.length > 0) return dom[0].scrollLeft;
    return null;
  }

  return dom.scrollTo(left, undefined, duration, easing, callback);
}

function animate(initialProps, initialParams) {
  var els = this;
  var a = {
    props: Object.assign({}, initialProps),
    params: Object.assign({
      duration: 300,
      easing: 'swing' // or 'linear'

      /* Callbacks
      begin(elements)
      complete(elements)
      progress(elements, complete, remaining, start, tweenValue)
      */

    }, initialParams),
    elements: els,
    animating: false,
    que: [],
    easingProgress: function easingProgress(easing, progress) {
      if (easing === 'swing') {
        return 0.5 - Math.cos(progress * Math.PI) / 2;
      }

      if (typeof easing === 'function') {
        return easing(progress);
      }

      return progress;
    },
    stop: function stop() {
      if (a.frameId) {
        cancelAnimationFrame(a.frameId);
      }

      a.animating = false;
      a.elements.each(function (index, el) {
        var element = el;
        delete element.dom7AnimateInstance;
      });
      a.que = [];
    },
    done: function done(complete) {
      a.animating = false;
      a.elements.each(function (index, el) {
        var element = el;
        delete element.dom7AnimateInstance;
      });
      if (complete) complete(els);

      if (a.que.length > 0) {
        var que = a.que.shift();
        a.animate(que[0], que[1]);
      }
    },
    animate: function animate(props, params) {
      if (a.animating) {
        a.que.push([props, params]);
        return a;
      }

      var elements = []; // Define & Cache Initials & Units

      a.elements.each(function (index, el) {
        var initialFullValue;
        var initialValue;
        var unit;
        var finalValue;
        var finalFullValue;
        if (!el.dom7AnimateInstance) a.elements[index].dom7AnimateInstance = a;
        elements[index] = {
          container: el
        };
        Object.keys(props).forEach(function (prop) {
          initialFullValue = ssr_window__WEBPACK_IMPORTED_MODULE_0__["window"].getComputedStyle(el, null).getPropertyValue(prop).replace(',', '.');
          initialValue = parseFloat(initialFullValue);
          unit = initialFullValue.replace(initialValue, '');
          finalValue = parseFloat(props[prop]);
          finalFullValue = props[prop] + unit;
          elements[index][prop] = {
            initialFullValue: initialFullValue,
            initialValue: initialValue,
            unit: unit,
            finalValue: finalValue,
            finalFullValue: finalFullValue,
            currentValue: initialValue
          };
        });
      });
      var startTime = null;
      var time;
      var elementsDone = 0;
      var propsDone = 0;
      var done;
      var began = false;
      a.animating = true;

      function render() {
        time = new Date().getTime();
        var progress;
        var easeProgress; // let el;

        if (!began) {
          began = true;
          if (params.begin) params.begin(els);
        }

        if (startTime === null) {
          startTime = time;
        }

        if (params.progress) {
          // eslint-disable-next-line
          params.progress(els, Math.max(Math.min((time - startTime) / params.duration, 1), 0), startTime + params.duration - time < 0 ? 0 : startTime + params.duration - time, startTime);
        }

        elements.forEach(function (element) {
          var el = element;
          if (done || el.done) return;
          Object.keys(props).forEach(function (prop) {
            if (done || el.done) return;
            progress = Math.max(Math.min((time - startTime) / params.duration, 1), 0);
            easeProgress = a.easingProgress(params.easing, progress);
            var _el$prop = el[prop],
                initialValue = _el$prop.initialValue,
                finalValue = _el$prop.finalValue,
                unit = _el$prop.unit;
            el[prop].currentValue = initialValue + easeProgress * (finalValue - initialValue);
            var currentValue = el[prop].currentValue;

            if (finalValue > initialValue && currentValue >= finalValue || finalValue < initialValue && currentValue <= finalValue) {
              el.container.style[prop] = finalValue + unit;
              propsDone += 1;

              if (propsDone === Object.keys(props).length) {
                el.done = true;
                elementsDone += 1;
              }

              if (elementsDone === elements.length) {
                done = true;
              }
            }

            if (done) {
              a.done(params.complete);
              return;
            }

            el.container.style[prop] = currentValue + unit;
          });
        });
        if (done) return; // Then call

        a.frameId = requestAnimationFrame(render);
      }

      a.frameId = requestAnimationFrame(render);
      return a;
    }
  };

  if (a.elements.length === 0) {
    return els;
  }

  var animateInstance;

  for (var i = 0; i < a.elements.length; i += 1) {
    if (a.elements[i].dom7AnimateInstance) {
      animateInstance = a.elements[i].dom7AnimateInstance;
    } else a.elements[i].dom7AnimateInstance = a;
  }

  if (!animateInstance) {
    animateInstance = a;
  }

  if (initialProps === 'stop') {
    animateInstance.stop();
  } else {
    animateInstance.animate(a.props, a.params);
  }

  return els;
}

function stop() {
  var els = this;

  for (var i = 0; i < els.length; i += 1) {
    if (els[i].dom7AnimateInstance) {
      els[i].dom7AnimateInstance.stop();
    }
  }
}

var noTrigger = 'resize scroll'.split(' ');

function eventShortcut(name) {
  for (var _len10 = arguments.length, args = new Array(_len10 > 1 ? _len10 - 1 : 0), _key10 = 1; _key10 < _len10; _key10++) {
    args[_key10 - 1] = arguments[_key10];
  }

  if (typeof args[0] === 'undefined') {
    for (var i = 0; i < this.length; i += 1) {
      if (noTrigger.indexOf(name) < 0) {
        if (name in this[i]) this[i][name]();else {
          $(this[i]).trigger(name);
        }
      }
    }

    return this;
  }

  return this.on.apply(this, [name].concat(args));
}

function click() {
  for (var _len11 = arguments.length, args = new Array(_len11), _key11 = 0; _key11 < _len11; _key11++) {
    args[_key11] = arguments[_key11];
  }

  return eventShortcut.bind(this).apply(void 0, ['click'].concat(args));
}

function blur() {
  for (var _len12 = arguments.length, args = new Array(_len12), _key12 = 0; _key12 < _len12; _key12++) {
    args[_key12] = arguments[_key12];
  }

  return eventShortcut.bind(this).apply(void 0, ['blur'].concat(args));
}

function focus() {
  for (var _len13 = arguments.length, args = new Array(_len13), _key13 = 0; _key13 < _len13; _key13++) {
    args[_key13] = arguments[_key13];
  }

  return eventShortcut.bind(this).apply(void 0, ['focus'].concat(args));
}

function focusin() {
  for (var _len14 = arguments.length, args = new Array(_len14), _key14 = 0; _key14 < _len14; _key14++) {
    args[_key14] = arguments[_key14];
  }

  return eventShortcut.bind(this).apply(void 0, ['focusin'].concat(args));
}

function focusout() {
  for (var _len15 = arguments.length, args = new Array(_len15), _key15 = 0; _key15 < _len15; _key15++) {
    args[_key15] = arguments[_key15];
  }

  return eventShortcut.bind(this).apply(void 0, ['focusout'].concat(args));
}

function keyup() {
  for (var _len16 = arguments.length, args = new Array(_len16), _key16 = 0; _key16 < _len16; _key16++) {
    args[_key16] = arguments[_key16];
  }

  return eventShortcut.bind(this).apply(void 0, ['keyup'].concat(args));
}

function keydown() {
  for (var _len17 = arguments.length, args = new Array(_len17), _key17 = 0; _key17 < _len17; _key17++) {
    args[_key17] = arguments[_key17];
  }

  return eventShortcut.bind(this).apply(void 0, ['keydown'].concat(args));
}

function keypress() {
  for (var _len18 = arguments.length, args = new Array(_len18), _key18 = 0; _key18 < _len18; _key18++) {
    args[_key18] = arguments[_key18];
  }

  return eventShortcut.bind(this).apply(void 0, ['keypress'].concat(args));
}

function submit() {
  for (var _len19 = arguments.length, args = new Array(_len19), _key19 = 0; _key19 < _len19; _key19++) {
    args[_key19] = arguments[_key19];
  }

  return eventShortcut.bind(this).apply(void 0, ['submit'].concat(args));
}

function change() {
  for (var _len20 = arguments.length, args = new Array(_len20), _key20 = 0; _key20 < _len20; _key20++) {
    args[_key20] = arguments[_key20];
  }

  return eventShortcut.bind(this).apply(void 0, ['change'].concat(args));
}

function mousedown() {
  for (var _len21 = arguments.length, args = new Array(_len21), _key21 = 0; _key21 < _len21; _key21++) {
    args[_key21] = arguments[_key21];
  }

  return eventShortcut.bind(this).apply(void 0, ['mousedown'].concat(args));
}

function mousemove() {
  for (var _len22 = arguments.length, args = new Array(_len22), _key22 = 0; _key22 < _len22; _key22++) {
    args[_key22] = arguments[_key22];
  }

  return eventShortcut.bind(this).apply(void 0, ['mousemove'].concat(args));
}

function mouseup() {
  for (var _len23 = arguments.length, args = new Array(_len23), _key23 = 0; _key23 < _len23; _key23++) {
    args[_key23] = arguments[_key23];
  }

  return eventShortcut.bind(this).apply(void 0, ['mouseup'].concat(args));
}

function mouseenter() {
  for (var _len24 = arguments.length, args = new Array(_len24), _key24 = 0; _key24 < _len24; _key24++) {
    args[_key24] = arguments[_key24];
  }

  return eventShortcut.bind(this).apply(void 0, ['mouseenter'].concat(args));
}

function mouseleave() {
  for (var _len25 = arguments.length, args = new Array(_len25), _key25 = 0; _key25 < _len25; _key25++) {
    args[_key25] = arguments[_key25];
  }

  return eventShortcut.bind(this).apply(void 0, ['mouseleave'].concat(args));
}

function mouseout() {
  for (var _len26 = arguments.length, args = new Array(_len26), _key26 = 0; _key26 < _len26; _key26++) {
    args[_key26] = arguments[_key26];
  }

  return eventShortcut.bind(this).apply(void 0, ['mouseout'].concat(args));
}

function mouseover() {
  for (var _len27 = arguments.length, args = new Array(_len27), _key27 = 0; _key27 < _len27; _key27++) {
    args[_key27] = arguments[_key27];
  }

  return eventShortcut.bind(this).apply(void 0, ['mouseover'].concat(args));
}

function touchstart() {
  for (var _len28 = arguments.length, args = new Array(_len28), _key28 = 0; _key28 < _len28; _key28++) {
    args[_key28] = arguments[_key28];
  }

  return eventShortcut.bind(this).apply(void 0, ['touchstart'].concat(args));
}

function touchend() {
  for (var _len29 = arguments.length, args = new Array(_len29), _key29 = 0; _key29 < _len29; _key29++) {
    args[_key29] = arguments[_key29];
  }

  return eventShortcut.bind(this).apply(void 0, ['touchend'].concat(args));
}

function touchmove() {
  for (var _len30 = arguments.length, args = new Array(_len30), _key30 = 0; _key30 < _len30; _key30++) {
    args[_key30] = arguments[_key30];
  }

  return eventShortcut.bind(this).apply(void 0, ['touchmove'].concat(args));
}

function resize() {
  for (var _len31 = arguments.length, args = new Array(_len31), _key31 = 0; _key31 < _len31; _key31++) {
    args[_key31] = arguments[_key31];
  }

  return eventShortcut.bind(this).apply(void 0, ['resize'].concat(args));
}

function scroll() {
  for (var _len32 = arguments.length, args = new Array(_len32), _key32 = 0; _key32 < _len32; _key32++) {
    args[_key32] = arguments[_key32];
  }

  return eventShortcut.bind(this).apply(void 0, ['scroll'].concat(args));
}



/***/ }),

/***/ "./node_modules/headroom.js/dist/headroom.js":
/*!***************************************************!*\
  !*** ./node_modules/headroom.js/dist/headroom.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*!
 * headroom.js v0.10.4 - Give your page some headroom. Hide your header until you need it
 * Copyright (c) 2020 Nick Williams - http://wicky.nillia.ms/headroom.js
 * License: MIT
 */
(function (global, factory) {
  ( false ? undefined : _typeof(exports)) === 'object' && typeof module !== 'undefined' ? module.exports = factory() :  true ? !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)) : (undefined);
})(this, function () {
  'use strict';

  function isBrowser() {
    return typeof window !== "undefined";
  }
  /**
   * Used to detect browser support for adding an event listener with options
   * Credit: https://developer.mozilla.org/en-US/docs/Web/API/EventTarget/addEventListener
   */


  function passiveEventsSupported() {
    var supported = false;

    try {
      var options = {
        // eslint-disable-next-line getter-return
        get passive() {
          supported = true;
        }

      };
      window.addEventListener("test", options, options);
      window.removeEventListener("test", options, options);
    } catch (err) {
      supported = false;
    }

    return supported;
  }

  function isSupported() {
    return !!(isBrowser() && function () {}.bind && "classList" in document.documentElement && Object.assign && Object.keys && requestAnimationFrame);
  }

  function isDocument(obj) {
    return obj.nodeType === 9; // Node.DOCUMENT_NODE === 9
  }

  function isWindow(obj) {
    // `obj === window` or `obj instanceof Window` is not sufficient,
    // as the obj may be the window of an iframe.
    return obj && obj.document && isDocument(obj.document);
  }

  function windowScroller(win) {
    var doc = win.document;
    var body = doc.body;
    var html = doc.documentElement;
    return {
      /**
       * @see http://james.padolsey.com/javascript/get-document-height-cross-browser/
       * @return {Number} the scroll height of the document in pixels
       */
      scrollHeight: function scrollHeight() {
        return Math.max(body.scrollHeight, html.scrollHeight, body.offsetHeight, html.offsetHeight, body.clientHeight, html.clientHeight);
      },

      /**
       * @see http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
       * @return {Number} the height of the viewport in pixels
       */
      height: function height() {
        return win.innerHeight || html.clientHeight || body.clientHeight;
      },

      /**
       * Gets the Y scroll position
       * @return {Number} pixels the page has scrolled along the Y-axis
       */
      scrollY: function scrollY() {
        if (win.pageYOffset !== undefined) {
          return win.pageYOffset;
        }

        return (html || body.parentNode || body).scrollTop;
      }
    };
  }

  function elementScroller(element) {
    return {
      /**
       * @return {Number} the scroll height of the element in pixels
       */
      scrollHeight: function scrollHeight() {
        return Math.max(element.scrollHeight, element.offsetHeight, element.clientHeight);
      },

      /**
       * @return {Number} the height of the element in pixels
       */
      height: function height() {
        return Math.max(element.offsetHeight, element.clientHeight);
      },

      /**
       * Gets the Y scroll position
       * @return {Number} pixels the element has scrolled along the Y-axis
       */
      scrollY: function scrollY() {
        return element.scrollTop;
      }
    };
  }

  function createScroller(element) {
    return isWindow(element) ? windowScroller(element) : elementScroller(element);
  }
  /**
   * @param element EventTarget
   */


  function trackScroll(element, options, callback) {
    var isPassiveSupported = passiveEventsSupported();
    var rafId;
    var scrolled = false;
    var scroller = createScroller(element);
    var lastScrollY = scroller.scrollY();
    var details = {};

    function update() {
      var scrollY = Math.round(scroller.scrollY());
      var height = scroller.height();
      var scrollHeight = scroller.scrollHeight(); // reuse object for less memory churn

      details.scrollY = scrollY;
      details.lastScrollY = lastScrollY;
      details.direction = scrollY > lastScrollY ? "down" : "up";
      details.distance = Math.abs(scrollY - lastScrollY);
      details.isOutOfBounds = scrollY < 0 || scrollY + height > scrollHeight;
      details.top = scrollY <= options.offset;
      details.bottom = scrollY + height >= scrollHeight;
      details.toleranceExceeded = details.distance > options.tolerance[details.direction];
      callback(details);
      lastScrollY = scrollY;
      scrolled = false;
    }

    function handleScroll() {
      if (!scrolled) {
        scrolled = true;
        rafId = requestAnimationFrame(update);
      }
    }

    var eventOptions = isPassiveSupported ? {
      passive: true,
      capture: false
    } : false;
    element.addEventListener("scroll", handleScroll, eventOptions);
    update();
    return {
      destroy: function destroy() {
        cancelAnimationFrame(rafId);
        element.removeEventListener("scroll", handleScroll, eventOptions);
      }
    };
  }

  function normalizeTolerance(t) {
    return t === Object(t) ? t : {
      down: t,
      up: t
    };
  }
  /**
   * UI enhancement for fixed headers.
   * Hides header when scrolling down
   * Shows header when scrolling up
   * @constructor
   * @param {DOMElement} elem the header element
   * @param {Object} options options for the widget
   */


  function Headroom(elem, options) {
    options = options || {};
    Object.assign(this, Headroom.options, options);
    this.classes = Object.assign({}, Headroom.options.classes, options.classes);
    this.elem = elem;
    this.tolerance = normalizeTolerance(this.tolerance);
    this.initialised = false;
    this.frozen = false;
  }

  Headroom.prototype = {
    constructor: Headroom,

    /**
     * Start listening to scrolling
     * @public
     */
    init: function init() {
      if (Headroom.cutsTheMustard && !this.initialised) {
        this.addClass("initial");
        this.initialised = true; // defer event registration to handle browser
        // potentially restoring previous scroll position

        setTimeout(function (self) {
          self.scrollTracker = trackScroll(self.scroller, {
            offset: self.offset,
            tolerance: self.tolerance
          }, self.update.bind(self));
        }, 100, this);
      }

      return this;
    },

    /**
     * Destroy the widget, clearing up after itself
     * @public
     */
    destroy: function destroy() {
      this.initialised = false;
      Object.keys(this.classes).forEach(this.removeClass, this);
      this.scrollTracker.destroy();
    },

    /**
     * Unpin the element
     * @public
     */
    unpin: function unpin() {
      if (this.hasClass("pinned") || !this.hasClass("unpinned")) {
        this.addClass("unpinned");
        this.removeClass("pinned");

        if (this.onUnpin) {
          this.onUnpin.call(this);
        }
      }
    },

    /**
     * Pin the element
     * @public
     */
    pin: function pin() {
      if (this.hasClass("unpinned")) {
        this.addClass("pinned");
        this.removeClass("unpinned");

        if (this.onPin) {
          this.onPin.call(this);
        }
      }
    },

    /**
     * Freezes the current state of the widget
     * @public
     */
    freeze: function freeze() {
      this.frozen = true;
      this.addClass("frozen");
    },

    /**
     * Re-enables the default behaviour of the widget
     * @public
     */
    unfreeze: function unfreeze() {
      this.frozen = false;
      this.removeClass("frozen");
    },
    top: function top() {
      if (!this.hasClass("top")) {
        this.addClass("top");
        this.removeClass("notTop");

        if (this.onTop) {
          this.onTop.call(this);
        }
      }
    },
    notTop: function notTop() {
      if (!this.hasClass("notTop")) {
        this.addClass("notTop");
        this.removeClass("top");

        if (this.onNotTop) {
          this.onNotTop.call(this);
        }
      }
    },
    bottom: function bottom() {
      if (!this.hasClass("bottom")) {
        this.addClass("bottom");
        this.removeClass("notBottom");

        if (this.onBottom) {
          this.onBottom.call(this);
        }
      }
    },
    notBottom: function notBottom() {
      if (!this.hasClass("notBottom")) {
        this.addClass("notBottom");
        this.removeClass("bottom");

        if (this.onNotBottom) {
          this.onNotBottom.call(this);
        }
      }
    },
    shouldUnpin: function shouldUnpin(details) {
      var scrollingDown = details.direction === "down";
      return scrollingDown && !details.top && details.toleranceExceeded;
    },
    shouldPin: function shouldPin(details) {
      var scrollingUp = details.direction === "up";
      return scrollingUp && details.toleranceExceeded || details.top;
    },
    addClass: function addClass(className) {
      this.elem.classList.add(this.classes[className]);
    },
    removeClass: function removeClass(className) {
      this.elem.classList.remove(this.classes[className]);
    },
    hasClass: function hasClass(className) {
      return this.elem.classList.contains(this.classes[className]);
    },
    update: function update(details) {
      if (details.isOutOfBounds) {
        // Ignore bouncy scrolling in OSX
        return;
      }

      if (this.frozen === true) {
        return;
      }

      if (details.top) {
        this.top();
      } else {
        this.notTop();
      }

      if (details.bottom) {
        this.bottom();
      } else {
        this.notBottom();
      }

      if (this.shouldUnpin(details)) {
        this.unpin();
      } else if (this.shouldPin(details)) {
        this.pin();
      }
    }
  };
  /**
   * Default options
   * @type {Object}
   */

  Headroom.options = {
    tolerance: {
      up: 0,
      down: 0
    },
    offset: 0,
    scroller: isBrowser() ? window : null,
    classes: {
      frozen: "headroom--frozen",
      pinned: "headroom--pinned",
      unpinned: "headroom--unpinned",
      top: "headroom--top",
      notTop: "headroom--not-top",
      bottom: "headroom--bottom",
      notBottom: "headroom--not-bottom",
      initial: "headroom"
    }
  };
  Headroom.cutsTheMustard = isSupported();
  return Headroom;
});

/***/ }),

/***/ "./node_modules/jquery/dist/jquery.js":
/*!********************************************!*\
  !*** ./node_modules/jquery/dist/jquery.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(module) {var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*!
 * jQuery JavaScript Library v3.5.1
 * https://jquery.com/
 *
 * Includes Sizzle.js
 * https://sizzlejs.com/
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2020-05-04T22:49Z
 */
(function (global, factory) {
  "use strict";

  if (( false ? undefined : _typeof(module)) === "object" && _typeof(module.exports) === "object") {
    // For CommonJS and CommonJS-like environments where a proper `window`
    // is present, execute the factory and get jQuery.
    // For environments that do not have a `window` with a `document`
    // (such as Node.js), expose a factory as module.exports.
    // This accentuates the need for the creation of a real `window`.
    // e.g. var jQuery = require("jquery")(window);
    // See ticket #14549 for more info.
    module.exports = global.document ? factory(global, true) : function (w) {
      if (!w.document) {
        throw new Error("jQuery requires a window with a document");
      }

      return factory(w);
    };
  } else {
    factory(global);
  } // Pass this if window is not defined yet

})(typeof window !== "undefined" ? window : this, function (window, noGlobal) {
  // Edge <= 12 - 13+, Firefox <=18 - 45+, IE 10 - 11, Safari 5.1 - 9+, iOS 6 - 9.1
  // throw exceptions when non-strict code (e.g., ASP.NET 4.5) accesses strict mode
  // arguments.callee.caller (trac-13335). But as of jQuery 3.0 (2016), strict mode should be common
  // enough that all such attempts are guarded in a try block.
  "use strict";

  var arr = [];
  var getProto = Object.getPrototypeOf;
  var _slice = arr.slice;
  var flat = arr.flat ? function (array) {
    return arr.flat.call(array);
  } : function (array) {
    return arr.concat.apply([], array);
  };
  var push = arr.push;
  var indexOf = arr.indexOf;
  var class2type = {};
  var toString = class2type.toString;
  var hasOwn = class2type.hasOwnProperty;
  var fnToString = hasOwn.toString;
  var ObjectFunctionString = fnToString.call(Object);
  var support = {};

  var isFunction = function isFunction(obj) {
    // Support: Chrome <=57, Firefox <=52
    // In some browsers, typeof returns "function" for HTML <object> elements
    // (i.e., `typeof document.createElement( "object" ) === "function"`).
    // We don't want to classify *any* DOM node as a function.
    return typeof obj === "function" && typeof obj.nodeType !== "number";
  };

  var isWindow = function isWindow(obj) {
    return obj != null && obj === obj.window;
  };

  var document = window.document;
  var preservedScriptAttributes = {
    type: true,
    src: true,
    nonce: true,
    noModule: true
  };

  function DOMEval(code, node, doc) {
    doc = doc || document;
    var i,
        val,
        script = doc.createElement("script");
    script.text = code;

    if (node) {
      for (i in preservedScriptAttributes) {
        // Support: Firefox 64+, Edge 18+
        // Some browsers don't support the "nonce" property on scripts.
        // On the other hand, just using `getAttribute` is not enough as
        // the `nonce` attribute is reset to an empty string whenever it
        // becomes browsing-context connected.
        // See https://github.com/whatwg/html/issues/2369
        // See https://html.spec.whatwg.org/#nonce-attributes
        // The `node.getAttribute` check was added for the sake of
        // `jQuery.globalEval` so that it can fake a nonce-containing node
        // via an object.
        val = node[i] || node.getAttribute && node.getAttribute(i);

        if (val) {
          script.setAttribute(i, val);
        }
      }
    }

    doc.head.appendChild(script).parentNode.removeChild(script);
  }

  function toType(obj) {
    if (obj == null) {
      return obj + "";
    } // Support: Android <=2.3 only (functionish RegExp)


    return _typeof(obj) === "object" || typeof obj === "function" ? class2type[toString.call(obj)] || "object" : _typeof(obj);
  }
  /* global Symbol */
  // Defining this global in .eslintrc.json would create a danger of using the global
  // unguarded in another place, it seems safer to define global only for this module


  var version = "3.5.1",
      // Define a local copy of jQuery
  jQuery = function jQuery(selector, context) {
    // The jQuery object is actually just the init constructor 'enhanced'
    // Need init if jQuery is called (just allow error to be thrown if not included)
    return new jQuery.fn.init(selector, context);
  };

  jQuery.fn = jQuery.prototype = {
    // The current version of jQuery being used
    jquery: version,
    constructor: jQuery,
    // The default length of a jQuery object is 0
    length: 0,
    toArray: function toArray() {
      return _slice.call(this);
    },
    // Get the Nth element in the matched element set OR
    // Get the whole matched element set as a clean array
    get: function get(num) {
      // Return all the elements in a clean array
      if (num == null) {
        return _slice.call(this);
      } // Return just the one element from the set


      return num < 0 ? this[num + this.length] : this[num];
    },
    // Take an array of elements and push it onto the stack
    // (returning the new matched element set)
    pushStack: function pushStack(elems) {
      // Build a new jQuery matched element set
      var ret = jQuery.merge(this.constructor(), elems); // Add the old object onto the stack (as a reference)

      ret.prevObject = this; // Return the newly-formed element set

      return ret;
    },
    // Execute a callback for every element in the matched set.
    each: function each(callback) {
      return jQuery.each(this, callback);
    },
    map: function map(callback) {
      return this.pushStack(jQuery.map(this, function (elem, i) {
        return callback.call(elem, i, elem);
      }));
    },
    slice: function slice() {
      return this.pushStack(_slice.apply(this, arguments));
    },
    first: function first() {
      return this.eq(0);
    },
    last: function last() {
      return this.eq(-1);
    },
    even: function even() {
      return this.pushStack(jQuery.grep(this, function (_elem, i) {
        return (i + 1) % 2;
      }));
    },
    odd: function odd() {
      return this.pushStack(jQuery.grep(this, function (_elem, i) {
        return i % 2;
      }));
    },
    eq: function eq(i) {
      var len = this.length,
          j = +i + (i < 0 ? len : 0);
      return this.pushStack(j >= 0 && j < len ? [this[j]] : []);
    },
    end: function end() {
      return this.prevObject || this.constructor();
    },
    // For internal use only.
    // Behaves like an Array's method, not like a jQuery method.
    push: push,
    sort: arr.sort,
    splice: arr.splice
  };

  jQuery.extend = jQuery.fn.extend = function () {
    var options,
        name,
        src,
        copy,
        copyIsArray,
        clone,
        target = arguments[0] || {},
        i = 1,
        length = arguments.length,
        deep = false; // Handle a deep copy situation

    if (typeof target === "boolean") {
      deep = target; // Skip the boolean and the target

      target = arguments[i] || {};
      i++;
    } // Handle case when target is a string or something (possible in deep copy)


    if (_typeof(target) !== "object" && !isFunction(target)) {
      target = {};
    } // Extend jQuery itself if only one argument is passed


    if (i === length) {
      target = this;
      i--;
    }

    for (; i < length; i++) {
      // Only deal with non-null/undefined values
      if ((options = arguments[i]) != null) {
        // Extend the base object
        for (name in options) {
          copy = options[name]; // Prevent Object.prototype pollution
          // Prevent never-ending loop

          if (name === "__proto__" || target === copy) {
            continue;
          } // Recurse if we're merging plain objects or arrays


          if (deep && copy && (jQuery.isPlainObject(copy) || (copyIsArray = Array.isArray(copy)))) {
            src = target[name]; // Ensure proper type for the source value

            if (copyIsArray && !Array.isArray(src)) {
              clone = [];
            } else if (!copyIsArray && !jQuery.isPlainObject(src)) {
              clone = {};
            } else {
              clone = src;
            }

            copyIsArray = false; // Never move original objects, clone them

            target[name] = jQuery.extend(deep, clone, copy); // Don't bring in undefined values
          } else if (copy !== undefined) {
            target[name] = copy;
          }
        }
      }
    } // Return the modified object


    return target;
  };

  jQuery.extend({
    // Unique for each copy of jQuery on the page
    expando: "jQuery" + (version + Math.random()).replace(/\D/g, ""),
    // Assume jQuery is ready without the ready module
    isReady: true,
    error: function error(msg) {
      throw new Error(msg);
    },
    noop: function noop() {},
    isPlainObject: function isPlainObject(obj) {
      var proto, Ctor; // Detect obvious negatives
      // Use toString instead of jQuery.type to catch host objects

      if (!obj || toString.call(obj) !== "[object Object]") {
        return false;
      }

      proto = getProto(obj); // Objects with no prototype (e.g., `Object.create( null )`) are plain

      if (!proto) {
        return true;
      } // Objects with prototype are plain iff they were constructed by a global Object function


      Ctor = hasOwn.call(proto, "constructor") && proto.constructor;
      return typeof Ctor === "function" && fnToString.call(Ctor) === ObjectFunctionString;
    },
    isEmptyObject: function isEmptyObject(obj) {
      var name;

      for (name in obj) {
        return false;
      }

      return true;
    },
    // Evaluates a script in a provided context; falls back to the global one
    // if not specified.
    globalEval: function globalEval(code, options, doc) {
      DOMEval(code, {
        nonce: options && options.nonce
      }, doc);
    },
    each: function each(obj, callback) {
      var length,
          i = 0;

      if (isArrayLike(obj)) {
        length = obj.length;

        for (; i < length; i++) {
          if (callback.call(obj[i], i, obj[i]) === false) {
            break;
          }
        }
      } else {
        for (i in obj) {
          if (callback.call(obj[i], i, obj[i]) === false) {
            break;
          }
        }
      }

      return obj;
    },
    // results is for internal usage only
    makeArray: function makeArray(arr, results) {
      var ret = results || [];

      if (arr != null) {
        if (isArrayLike(Object(arr))) {
          jQuery.merge(ret, typeof arr === "string" ? [arr] : arr);
        } else {
          push.call(ret, arr);
        }
      }

      return ret;
    },
    inArray: function inArray(elem, arr, i) {
      return arr == null ? -1 : indexOf.call(arr, elem, i);
    },
    // Support: Android <=4.0 only, PhantomJS 1 only
    // push.apply(_, arraylike) throws on ancient WebKit
    merge: function merge(first, second) {
      var len = +second.length,
          j = 0,
          i = first.length;

      for (; j < len; j++) {
        first[i++] = second[j];
      }

      first.length = i;
      return first;
    },
    grep: function grep(elems, callback, invert) {
      var callbackInverse,
          matches = [],
          i = 0,
          length = elems.length,
          callbackExpect = !invert; // Go through the array, only saving the items
      // that pass the validator function

      for (; i < length; i++) {
        callbackInverse = !callback(elems[i], i);

        if (callbackInverse !== callbackExpect) {
          matches.push(elems[i]);
        }
      }

      return matches;
    },
    // arg is for internal usage only
    map: function map(elems, callback, arg) {
      var length,
          value,
          i = 0,
          ret = []; // Go through the array, translating each of the items to their new values

      if (isArrayLike(elems)) {
        length = elems.length;

        for (; i < length; i++) {
          value = callback(elems[i], i, arg);

          if (value != null) {
            ret.push(value);
          }
        } // Go through every key on the object,

      } else {
        for (i in elems) {
          value = callback(elems[i], i, arg);

          if (value != null) {
            ret.push(value);
          }
        }
      } // Flatten any nested arrays


      return flat(ret);
    },
    // A global GUID counter for objects
    guid: 1,
    // jQuery.support is not used in Core but other projects attach their
    // properties to it so it needs to exist.
    support: support
  });

  if (typeof Symbol === "function") {
    jQuery.fn[Symbol.iterator] = arr[Symbol.iterator];
  } // Populate the class2type map


  jQuery.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (_i, name) {
    class2type["[object " + name + "]"] = name.toLowerCase();
  });

  function isArrayLike(obj) {
    // Support: real iOS 8.2 only (not reproducible in simulator)
    // `in` check used to prevent JIT error (gh-2145)
    // hasOwn isn't used here due to false negatives
    // regarding Nodelist length in IE
    var length = !!obj && "length" in obj && obj.length,
        type = toType(obj);

    if (isFunction(obj) || isWindow(obj)) {
      return false;
    }

    return type === "array" || length === 0 || typeof length === "number" && length > 0 && length - 1 in obj;
  }

  var Sizzle =
  /*!
   * Sizzle CSS Selector Engine v2.3.5
   * https://sizzlejs.com/
   *
   * Copyright JS Foundation and other contributors
   * Released under the MIT license
   * https://js.foundation/
   *
   * Date: 2020-03-14
   */
  function (window) {
    var i,
        support,
        Expr,
        getText,
        isXML,
        tokenize,
        compile,
        select,
        outermostContext,
        sortInput,
        hasDuplicate,
        // Local document vars
    setDocument,
        document,
        docElem,
        documentIsHTML,
        rbuggyQSA,
        rbuggyMatches,
        matches,
        contains,
        // Instance-specific data
    expando = "sizzle" + 1 * new Date(),
        preferredDoc = window.document,
        dirruns = 0,
        done = 0,
        classCache = createCache(),
        tokenCache = createCache(),
        compilerCache = createCache(),
        nonnativeSelectorCache = createCache(),
        sortOrder = function sortOrder(a, b) {
      if (a === b) {
        hasDuplicate = true;
      }

      return 0;
    },
        // Instance methods
    hasOwn = {}.hasOwnProperty,
        arr = [],
        pop = arr.pop,
        pushNative = arr.push,
        push = arr.push,
        slice = arr.slice,
        // Use a stripped-down indexOf as it's faster than native
    // https://jsperf.com/thor-indexof-vs-for/5
    indexOf = function indexOf(list, elem) {
      var i = 0,
          len = list.length;

      for (; i < len; i++) {
        if (list[i] === elem) {
          return i;
        }
      }

      return -1;
    },
        booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|" + "ismap|loop|multiple|open|readonly|required|scoped",
        // Regular expressions
    // http://www.w3.org/TR/css3-selectors/#whitespace
    whitespace = "[\\x20\\t\\r\\n\\f]",
        // https://www.w3.org/TR/css-syntax-3/#ident-token-diagram
    identifier = "(?:\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
        // Attribute selectors: http://www.w3.org/TR/selectors/#attribute-selectors
    attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace + // Operator (capture 2)
    "*([*^$|!~]?=)" + whitespace + // "Attribute values must be CSS identifiers [capture 5]
    // or strings [capture 3 or capture 4]"
    "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" + whitespace + "*\\]",
        pseudos = ":(" + identifier + ")(?:\\((" + // To reduce the number of selectors needing tokenize in the preFilter, prefer arguments:
    // 1. quoted (capture 3; capture 4 or capture 5)
    "('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" + // 2. simple (capture 6)
    "((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" + // 3. anything else (capture 2)
    ".*" + ")\\)|)",
        // Leading and non-escaped trailing whitespace, capturing some non-whitespace characters preceding the latter
    rwhitespace = new RegExp(whitespace + "+", "g"),
        rtrim = new RegExp("^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$", "g"),
        rcomma = new RegExp("^" + whitespace + "*," + whitespace + "*"),
        rcombinators = new RegExp("^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace + "*"),
        rdescend = new RegExp(whitespace + "|>"),
        rpseudo = new RegExp(pseudos),
        ridentifier = new RegExp("^" + identifier + "$"),
        matchExpr = {
      "ID": new RegExp("^#(" + identifier + ")"),
      "CLASS": new RegExp("^\\.(" + identifier + ")"),
      "TAG": new RegExp("^(" + identifier + "|[*])"),
      "ATTR": new RegExp("^" + attributes),
      "PSEUDO": new RegExp("^" + pseudos),
      "CHILD": new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace + "*(\\d+)|))" + whitespace + "*\\)|)", "i"),
      "bool": new RegExp("^(?:" + booleans + ")$", "i"),
      // For use in libraries implementing .is()
      // We use this for POS matching in `select`
      "needsContext": new RegExp("^" + whitespace + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace + "*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i")
    },
        rhtml = /HTML$/i,
        rinputs = /^(?:input|select|textarea|button)$/i,
        rheader = /^h\d$/i,
        rnative = /^[^{]+\{\s*\[native \w/,
        // Easily-parseable/retrievable ID or TAG or CLASS selectors
    rquickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
        rsibling = /[+~]/,
        // CSS escapes
    // http://www.w3.org/TR/CSS21/syndata.html#escaped-characters
    runescape = new RegExp("\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g"),
        funescape = function funescape(escape, nonHex) {
      var high = "0x" + escape.slice(1) - 0x10000;
      return nonHex ? // Strip the backslash prefix from a non-hex escape sequence
      nonHex : // Replace a hexadecimal escape sequence with the encoded Unicode code point
      // Support: IE <=11+
      // For values outside the Basic Multilingual Plane (BMP), manually construct a
      // surrogate pair
      high < 0 ? String.fromCharCode(high + 0x10000) : String.fromCharCode(high >> 10 | 0xD800, high & 0x3FF | 0xDC00);
    },
        // CSS string/identifier serialization
    // https://drafts.csswg.org/cssom/#common-serializing-idioms
    rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
        fcssescape = function fcssescape(ch, asCodePoint) {
      if (asCodePoint) {
        // U+0000 NULL becomes U+FFFD REPLACEMENT CHARACTER
        if (ch === "\0") {
          return "\uFFFD";
        } // Control characters and (dependent upon position) numbers get escaped as code points


        return ch.slice(0, -1) + "\\" + ch.charCodeAt(ch.length - 1).toString(16) + " ";
      } // Other potentially-special ASCII characters get backslash-escaped


      return "\\" + ch;
    },
        // Used for iframes
    // See setDocument()
    // Removing the function wrapper causes a "Permission Denied"
    // error in IE
    unloadHandler = function unloadHandler() {
      setDocument();
    },
        inDisabledFieldset = addCombinator(function (elem) {
      return elem.disabled === true && elem.nodeName.toLowerCase() === "fieldset";
    }, {
      dir: "parentNode",
      next: "legend"
    }); // Optimize for push.apply( _, NodeList )


    try {
      push.apply(arr = slice.call(preferredDoc.childNodes), preferredDoc.childNodes); // Support: Android<4.0
      // Detect silently failing push.apply
      // eslint-disable-next-line no-unused-expressions

      arr[preferredDoc.childNodes.length].nodeType;
    } catch (e) {
      push = {
        apply: arr.length ? // Leverage slice if possible
        function (target, els) {
          pushNative.apply(target, slice.call(els));
        } : // Support: IE<9
        // Otherwise append directly
        function (target, els) {
          var j = target.length,
              i = 0; // Can't trust NodeList.length

          while (target[j++] = els[i++]) {}

          target.length = j - 1;
        }
      };
    }

    function Sizzle(selector, context, results, seed) {
      var m,
          i,
          elem,
          nid,
          match,
          groups,
          newSelector,
          newContext = context && context.ownerDocument,
          // nodeType defaults to 9, since context defaults to document
      nodeType = context ? context.nodeType : 9;
      results = results || []; // Return early from calls with invalid selector or context

      if (typeof selector !== "string" || !selector || nodeType !== 1 && nodeType !== 9 && nodeType !== 11) {
        return results;
      } // Try to shortcut find operations (as opposed to filters) in HTML documents


      if (!seed) {
        setDocument(context);
        context = context || document;

        if (documentIsHTML) {
          // If the selector is sufficiently simple, try using a "get*By*" DOM method
          // (excepting DocumentFragment context, where the methods don't exist)
          if (nodeType !== 11 && (match = rquickExpr.exec(selector))) {
            // ID selector
            if (m = match[1]) {
              // Document context
              if (nodeType === 9) {
                if (elem = context.getElementById(m)) {
                  // Support: IE, Opera, Webkit
                  // TODO: identify versions
                  // getElementById can match elements by name instead of ID
                  if (elem.id === m) {
                    results.push(elem);
                    return results;
                  }
                } else {
                  return results;
                } // Element context

              } else {
                // Support: IE, Opera, Webkit
                // TODO: identify versions
                // getElementById can match elements by name instead of ID
                if (newContext && (elem = newContext.getElementById(m)) && contains(context, elem) && elem.id === m) {
                  results.push(elem);
                  return results;
                }
              } // Type selector

            } else if (match[2]) {
              push.apply(results, context.getElementsByTagName(selector));
              return results; // Class selector
            } else if ((m = match[3]) && support.getElementsByClassName && context.getElementsByClassName) {
              push.apply(results, context.getElementsByClassName(m));
              return results;
            }
          } // Take advantage of querySelectorAll


          if (support.qsa && !nonnativeSelectorCache[selector + " "] && (!rbuggyQSA || !rbuggyQSA.test(selector)) && ( // Support: IE 8 only
          // Exclude object elements
          nodeType !== 1 || context.nodeName.toLowerCase() !== "object")) {
            newSelector = selector;
            newContext = context; // qSA considers elements outside a scoping root when evaluating child or
            // descendant combinators, which is not what we want.
            // In such cases, we work around the behavior by prefixing every selector in the
            // list with an ID selector referencing the scope context.
            // The technique has to be used as well when a leading combinator is used
            // as such selectors are not recognized by querySelectorAll.
            // Thanks to Andrew Dupont for this technique.

            if (nodeType === 1 && (rdescend.test(selector) || rcombinators.test(selector))) {
              // Expand context for sibling selectors
              newContext = rsibling.test(selector) && testContext(context.parentNode) || context; // We can use :scope instead of the ID hack if the browser
              // supports it & if we're not changing the context.

              if (newContext !== context || !support.scope) {
                // Capture the context ID, setting it first if necessary
                if (nid = context.getAttribute("id")) {
                  nid = nid.replace(rcssescape, fcssescape);
                } else {
                  context.setAttribute("id", nid = expando);
                }
              } // Prefix every selector in the list


              groups = tokenize(selector);
              i = groups.length;

              while (i--) {
                groups[i] = (nid ? "#" + nid : ":scope") + " " + toSelector(groups[i]);
              }

              newSelector = groups.join(",");
            }

            try {
              push.apply(results, newContext.querySelectorAll(newSelector));
              return results;
            } catch (qsaError) {
              nonnativeSelectorCache(selector, true);
            } finally {
              if (nid === expando) {
                context.removeAttribute("id");
              }
            }
          }
        }
      } // All others


      return select(selector.replace(rtrim, "$1"), context, results, seed);
    }
    /**
     * Create key-value caches of limited size
     * @returns {function(string, object)} Returns the Object data after storing it on itself with
     *	property name the (space-suffixed) string and (if the cache is larger than Expr.cacheLength)
     *	deleting the oldest entry
     */


    function createCache() {
      var keys = [];

      function cache(key, value) {
        // Use (key + " ") to avoid collision with native prototype properties (see Issue #157)
        if (keys.push(key + " ") > Expr.cacheLength) {
          // Only keep the most recent entries
          delete cache[keys.shift()];
        }

        return cache[key + " "] = value;
      }

      return cache;
    }
    /**
     * Mark a function for special use by Sizzle
     * @param {Function} fn The function to mark
     */


    function markFunction(fn) {
      fn[expando] = true;
      return fn;
    }
    /**
     * Support testing using an element
     * @param {Function} fn Passed the created element and returns a boolean result
     */


    function assert(fn) {
      var el = document.createElement("fieldset");

      try {
        return !!fn(el);
      } catch (e) {
        return false;
      } finally {
        // Remove from its parent by default
        if (el.parentNode) {
          el.parentNode.removeChild(el);
        } // release memory in IE


        el = null;
      }
    }
    /**
     * Adds the same handler for all of the specified attrs
     * @param {String} attrs Pipe-separated list of attributes
     * @param {Function} handler The method that will be applied
     */


    function addHandle(attrs, handler) {
      var arr = attrs.split("|"),
          i = arr.length;

      while (i--) {
        Expr.attrHandle[arr[i]] = handler;
      }
    }
    /**
     * Checks document order of two siblings
     * @param {Element} a
     * @param {Element} b
     * @returns {Number} Returns less than 0 if a precedes b, greater than 0 if a follows b
     */


    function siblingCheck(a, b) {
      var cur = b && a,
          diff = cur && a.nodeType === 1 && b.nodeType === 1 && a.sourceIndex - b.sourceIndex; // Use IE sourceIndex if available on both nodes

      if (diff) {
        return diff;
      } // Check if b follows a


      if (cur) {
        while (cur = cur.nextSibling) {
          if (cur === b) {
            return -1;
          }
        }
      }

      return a ? 1 : -1;
    }
    /**
     * Returns a function to use in pseudos for input types
     * @param {String} type
     */


    function createInputPseudo(type) {
      return function (elem) {
        var name = elem.nodeName.toLowerCase();
        return name === "input" && elem.type === type;
      };
    }
    /**
     * Returns a function to use in pseudos for buttons
     * @param {String} type
     */


    function createButtonPseudo(type) {
      return function (elem) {
        var name = elem.nodeName.toLowerCase();
        return (name === "input" || name === "button") && elem.type === type;
      };
    }
    /**
     * Returns a function to use in pseudos for :enabled/:disabled
     * @param {Boolean} disabled true for :disabled; false for :enabled
     */


    function createDisabledPseudo(disabled) {
      // Known :disabled false positives: fieldset[disabled] > legend:nth-of-type(n+2) :can-disable
      return function (elem) {
        // Only certain elements can match :enabled or :disabled
        // https://html.spec.whatwg.org/multipage/scripting.html#selector-enabled
        // https://html.spec.whatwg.org/multipage/scripting.html#selector-disabled
        if ("form" in elem) {
          // Check for inherited disabledness on relevant non-disabled elements:
          // * listed form-associated elements in a disabled fieldset
          //   https://html.spec.whatwg.org/multipage/forms.html#category-listed
          //   https://html.spec.whatwg.org/multipage/forms.html#concept-fe-disabled
          // * option elements in a disabled optgroup
          //   https://html.spec.whatwg.org/multipage/forms.html#concept-option-disabled
          // All such elements have a "form" property.
          if (elem.parentNode && elem.disabled === false) {
            // Option elements defer to a parent optgroup if present
            if ("label" in elem) {
              if ("label" in elem.parentNode) {
                return elem.parentNode.disabled === disabled;
              } else {
                return elem.disabled === disabled;
              }
            } // Support: IE 6 - 11
            // Use the isDisabled shortcut property to check for disabled fieldset ancestors


            return elem.isDisabled === disabled || // Where there is no isDisabled, check manually

            /* jshint -W018 */
            elem.isDisabled !== !disabled && inDisabledFieldset(elem) === disabled;
          }

          return elem.disabled === disabled; // Try to winnow out elements that can't be disabled before trusting the disabled property.
          // Some victims get caught in our net (label, legend, menu, track), but it shouldn't
          // even exist on them, let alone have a boolean value.
        } else if ("label" in elem) {
          return elem.disabled === disabled;
        } // Remaining elements are neither :enabled nor :disabled


        return false;
      };
    }
    /**
     * Returns a function to use in pseudos for positionals
     * @param {Function} fn
     */


    function createPositionalPseudo(fn) {
      return markFunction(function (argument) {
        argument = +argument;
        return markFunction(function (seed, matches) {
          var j,
              matchIndexes = fn([], seed.length, argument),
              i = matchIndexes.length; // Match elements found at the specified indexes

          while (i--) {
            if (seed[j = matchIndexes[i]]) {
              seed[j] = !(matches[j] = seed[j]);
            }
          }
        });
      });
    }
    /**
     * Checks a node for validity as a Sizzle context
     * @param {Element|Object=} context
     * @returns {Element|Object|Boolean} The input node if acceptable, otherwise a falsy value
     */


    function testContext(context) {
      return context && typeof context.getElementsByTagName !== "undefined" && context;
    } // Expose support vars for convenience


    support = Sizzle.support = {};
    /**
     * Detects XML nodes
     * @param {Element|Object} elem An element or a document
     * @returns {Boolean} True iff elem is a non-HTML XML node
     */

    isXML = Sizzle.isXML = function (elem) {
      var namespace = elem.namespaceURI,
          docElem = (elem.ownerDocument || elem).documentElement; // Support: IE <=8
      // Assume HTML when documentElement doesn't yet exist, such as inside loading iframes
      // https://bugs.jquery.com/ticket/4833

      return !rhtml.test(namespace || docElem && docElem.nodeName || "HTML");
    };
    /**
     * Sets document-related variables once based on the current document
     * @param {Element|Object} [doc] An element or document object to use to set the document
     * @returns {Object} Returns the current document
     */


    setDocument = Sizzle.setDocument = function (node) {
      var hasCompare,
          subWindow,
          doc = node ? node.ownerDocument || node : preferredDoc; // Return early if doc is invalid or already selected
      // Support: IE 11+, Edge 17 - 18+
      // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
      // two documents; shallow comparisons work.
      // eslint-disable-next-line eqeqeq

      if (doc == document || doc.nodeType !== 9 || !doc.documentElement) {
        return document;
      } // Update global variables


      document = doc;
      docElem = document.documentElement;
      documentIsHTML = !isXML(document); // Support: IE 9 - 11+, Edge 12 - 18+
      // Accessing iframe documents after unload throws "permission denied" errors (jQuery #13936)
      // Support: IE 11+, Edge 17 - 18+
      // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
      // two documents; shallow comparisons work.
      // eslint-disable-next-line eqeqeq

      if (preferredDoc != document && (subWindow = document.defaultView) && subWindow.top !== subWindow) {
        // Support: IE 11, Edge
        if (subWindow.addEventListener) {
          subWindow.addEventListener("unload", unloadHandler, false); // Support: IE 9 - 10 only
        } else if (subWindow.attachEvent) {
          subWindow.attachEvent("onunload", unloadHandler);
        }
      } // Support: IE 8 - 11+, Edge 12 - 18+, Chrome <=16 - 25 only, Firefox <=3.6 - 31 only,
      // Safari 4 - 5 only, Opera <=11.6 - 12.x only
      // IE/Edge & older browsers don't support the :scope pseudo-class.
      // Support: Safari 6.0 only
      // Safari 6.0 supports :scope but it's an alias of :root there.


      support.scope = assert(function (el) {
        docElem.appendChild(el).appendChild(document.createElement("div"));
        return typeof el.querySelectorAll !== "undefined" && !el.querySelectorAll(":scope fieldset div").length;
      });
      /* Attributes
      ---------------------------------------------------------------------- */
      // Support: IE<8
      // Verify that getAttribute really returns attributes and not properties
      // (excepting IE8 booleans)

      support.attributes = assert(function (el) {
        el.className = "i";
        return !el.getAttribute("className");
      });
      /* getElement(s)By*
      ---------------------------------------------------------------------- */
      // Check if getElementsByTagName("*") returns only elements

      support.getElementsByTagName = assert(function (el) {
        el.appendChild(document.createComment(""));
        return !el.getElementsByTagName("*").length;
      }); // Support: IE<9

      support.getElementsByClassName = rnative.test(document.getElementsByClassName); // Support: IE<10
      // Check if getElementById returns elements by name
      // The broken getElementById methods don't pick up programmatically-set names,
      // so use a roundabout getElementsByName test

      support.getById = assert(function (el) {
        docElem.appendChild(el).id = expando;
        return !document.getElementsByName || !document.getElementsByName(expando).length;
      }); // ID filter and find

      if (support.getById) {
        Expr.filter["ID"] = function (id) {
          var attrId = id.replace(runescape, funescape);
          return function (elem) {
            return elem.getAttribute("id") === attrId;
          };
        };

        Expr.find["ID"] = function (id, context) {
          if (typeof context.getElementById !== "undefined" && documentIsHTML) {
            var elem = context.getElementById(id);
            return elem ? [elem] : [];
          }
        };
      } else {
        Expr.filter["ID"] = function (id) {
          var attrId = id.replace(runescape, funescape);
          return function (elem) {
            var node = typeof elem.getAttributeNode !== "undefined" && elem.getAttributeNode("id");
            return node && node.value === attrId;
          };
        }; // Support: IE 6 - 7 only
        // getElementById is not reliable as a find shortcut


        Expr.find["ID"] = function (id, context) {
          if (typeof context.getElementById !== "undefined" && documentIsHTML) {
            var node,
                i,
                elems,
                elem = context.getElementById(id);

            if (elem) {
              // Verify the id attribute
              node = elem.getAttributeNode("id");

              if (node && node.value === id) {
                return [elem];
              } // Fall back on getElementsByName


              elems = context.getElementsByName(id);
              i = 0;

              while (elem = elems[i++]) {
                node = elem.getAttributeNode("id");

                if (node && node.value === id) {
                  return [elem];
                }
              }
            }

            return [];
          }
        };
      } // Tag


      Expr.find["TAG"] = support.getElementsByTagName ? function (tag, context) {
        if (typeof context.getElementsByTagName !== "undefined") {
          return context.getElementsByTagName(tag); // DocumentFragment nodes don't have gEBTN
        } else if (support.qsa) {
          return context.querySelectorAll(tag);
        }
      } : function (tag, context) {
        var elem,
            tmp = [],
            i = 0,
            // By happy coincidence, a (broken) gEBTN appears on DocumentFragment nodes too
        results = context.getElementsByTagName(tag); // Filter out possible comments

        if (tag === "*") {
          while (elem = results[i++]) {
            if (elem.nodeType === 1) {
              tmp.push(elem);
            }
          }

          return tmp;
        }

        return results;
      }; // Class

      Expr.find["CLASS"] = support.getElementsByClassName && function (className, context) {
        if (typeof context.getElementsByClassName !== "undefined" && documentIsHTML) {
          return context.getElementsByClassName(className);
        }
      };
      /* QSA/matchesSelector
      ---------------------------------------------------------------------- */
      // QSA and matchesSelector support
      // matchesSelector(:active) reports false when true (IE9/Opera 11.5)


      rbuggyMatches = []; // qSa(:focus) reports false when true (Chrome 21)
      // We allow this because of a bug in IE8/9 that throws an error
      // whenever `document.activeElement` is accessed on an iframe
      // So, we allow :focus to pass through QSA all the time to avoid the IE error
      // See https://bugs.jquery.com/ticket/13378

      rbuggyQSA = [];

      if (support.qsa = rnative.test(document.querySelectorAll)) {
        // Build QSA regex
        // Regex strategy adopted from Diego Perini
        assert(function (el) {
          var input; // Select is set to empty string on purpose
          // This is to test IE's treatment of not explicitly
          // setting a boolean content attribute,
          // since its presence should be enough
          // https://bugs.jquery.com/ticket/12359

          docElem.appendChild(el).innerHTML = "<a id='" + expando + "'></a>" + "<select id='" + expando + "-\r\\' msallowcapture=''>" + "<option selected=''></option></select>"; // Support: IE8, Opera 11-12.16
          // Nothing should be selected when empty strings follow ^= or $= or *=
          // The test attribute must be unknown in Opera but "safe" for WinRT
          // https://msdn.microsoft.com/en-us/library/ie/hh465388.aspx#attribute_section

          if (el.querySelectorAll("[msallowcapture^='']").length) {
            rbuggyQSA.push("[*^$]=" + whitespace + "*(?:''|\"\")");
          } // Support: IE8
          // Boolean attributes and "value" are not treated correctly


          if (!el.querySelectorAll("[selected]").length) {
            rbuggyQSA.push("\\[" + whitespace + "*(?:value|" + booleans + ")");
          } // Support: Chrome<29, Android<4.4, Safari<7.0+, iOS<7.0+, PhantomJS<1.9.8+


          if (!el.querySelectorAll("[id~=" + expando + "-]").length) {
            rbuggyQSA.push("~=");
          } // Support: IE 11+, Edge 15 - 18+
          // IE 11/Edge don't find elements on a `[name='']` query in some cases.
          // Adding a temporary attribute to the document before the selection works
          // around the issue.
          // Interestingly, IE 10 & older don't seem to have the issue.


          input = document.createElement("input");
          input.setAttribute("name", "");
          el.appendChild(input);

          if (!el.querySelectorAll("[name='']").length) {
            rbuggyQSA.push("\\[" + whitespace + "*name" + whitespace + "*=" + whitespace + "*(?:''|\"\")");
          } // Webkit/Opera - :checked should return selected option elements
          // http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
          // IE8 throws error here and will not see later tests


          if (!el.querySelectorAll(":checked").length) {
            rbuggyQSA.push(":checked");
          } // Support: Safari 8+, iOS 8+
          // https://bugs.webkit.org/show_bug.cgi?id=136851
          // In-page `selector#id sibling-combinator selector` fails


          if (!el.querySelectorAll("a#" + expando + "+*").length) {
            rbuggyQSA.push(".#.+[+~]");
          } // Support: Firefox <=3.6 - 5 only
          // Old Firefox doesn't throw on a badly-escaped identifier.


          el.querySelectorAll("\\\f");
          rbuggyQSA.push("[\\r\\n\\f]");
        });
        assert(function (el) {
          el.innerHTML = "<a href='' disabled='disabled'></a>" + "<select disabled='disabled'><option/></select>"; // Support: Windows 8 Native Apps
          // The type and name attributes are restricted during .innerHTML assignment

          var input = document.createElement("input");
          input.setAttribute("type", "hidden");
          el.appendChild(input).setAttribute("name", "D"); // Support: IE8
          // Enforce case-sensitivity of name attribute

          if (el.querySelectorAll("[name=d]").length) {
            rbuggyQSA.push("name" + whitespace + "*[*^$|!~]?=");
          } // FF 3.5 - :enabled/:disabled and hidden elements (hidden elements are still enabled)
          // IE8 throws error here and will not see later tests


          if (el.querySelectorAll(":enabled").length !== 2) {
            rbuggyQSA.push(":enabled", ":disabled");
          } // Support: IE9-11+
          // IE's :disabled selector does not pick up the children of disabled fieldsets


          docElem.appendChild(el).disabled = true;

          if (el.querySelectorAll(":disabled").length !== 2) {
            rbuggyQSA.push(":enabled", ":disabled");
          } // Support: Opera 10 - 11 only
          // Opera 10-11 does not throw on post-comma invalid pseudos


          el.querySelectorAll("*,:x");
          rbuggyQSA.push(",.*:");
        });
      }

      if (support.matchesSelector = rnative.test(matches = docElem.matches || docElem.webkitMatchesSelector || docElem.mozMatchesSelector || docElem.oMatchesSelector || docElem.msMatchesSelector)) {
        assert(function (el) {
          // Check to see if it's possible to do matchesSelector
          // on a disconnected node (IE 9)
          support.disconnectedMatch = matches.call(el, "*"); // This should fail with an exception
          // Gecko does not error, returns false instead

          matches.call(el, "[s!='']:x");
          rbuggyMatches.push("!=", pseudos);
        });
      }

      rbuggyQSA = rbuggyQSA.length && new RegExp(rbuggyQSA.join("|"));
      rbuggyMatches = rbuggyMatches.length && new RegExp(rbuggyMatches.join("|"));
      /* Contains
      ---------------------------------------------------------------------- */

      hasCompare = rnative.test(docElem.compareDocumentPosition); // Element contains another
      // Purposefully self-exclusive
      // As in, an element does not contain itself

      contains = hasCompare || rnative.test(docElem.contains) ? function (a, b) {
        var adown = a.nodeType === 9 ? a.documentElement : a,
            bup = b && b.parentNode;
        return a === bup || !!(bup && bup.nodeType === 1 && (adown.contains ? adown.contains(bup) : a.compareDocumentPosition && a.compareDocumentPosition(bup) & 16));
      } : function (a, b) {
        if (b) {
          while (b = b.parentNode) {
            if (b === a) {
              return true;
            }
          }
        }

        return false;
      };
      /* Sorting
      ---------------------------------------------------------------------- */
      // Document order sorting

      sortOrder = hasCompare ? function (a, b) {
        // Flag for duplicate removal
        if (a === b) {
          hasDuplicate = true;
          return 0;
        } // Sort on method existence if only one input has compareDocumentPosition


        var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;

        if (compare) {
          return compare;
        } // Calculate position if both inputs belong to the same document
        // Support: IE 11+, Edge 17 - 18+
        // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
        // two documents; shallow comparisons work.
        // eslint-disable-next-line eqeqeq


        compare = (a.ownerDocument || a) == (b.ownerDocument || b) ? a.compareDocumentPosition(b) : // Otherwise we know they are disconnected
        1; // Disconnected nodes

        if (compare & 1 || !support.sortDetached && b.compareDocumentPosition(a) === compare) {
          // Choose the first element that is related to our preferred document
          // Support: IE 11+, Edge 17 - 18+
          // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
          // two documents; shallow comparisons work.
          // eslint-disable-next-line eqeqeq
          if (a == document || a.ownerDocument == preferredDoc && contains(preferredDoc, a)) {
            return -1;
          } // Support: IE 11+, Edge 17 - 18+
          // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
          // two documents; shallow comparisons work.
          // eslint-disable-next-line eqeqeq


          if (b == document || b.ownerDocument == preferredDoc && contains(preferredDoc, b)) {
            return 1;
          } // Maintain original order


          return sortInput ? indexOf(sortInput, a) - indexOf(sortInput, b) : 0;
        }

        return compare & 4 ? -1 : 1;
      } : function (a, b) {
        // Exit early if the nodes are identical
        if (a === b) {
          hasDuplicate = true;
          return 0;
        }

        var cur,
            i = 0,
            aup = a.parentNode,
            bup = b.parentNode,
            ap = [a],
            bp = [b]; // Parentless nodes are either documents or disconnected

        if (!aup || !bup) {
          // Support: IE 11+, Edge 17 - 18+
          // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
          // two documents; shallow comparisons work.

          /* eslint-disable eqeqeq */
          return a == document ? -1 : b == document ? 1 :
          /* eslint-enable eqeqeq */
          aup ? -1 : bup ? 1 : sortInput ? indexOf(sortInput, a) - indexOf(sortInput, b) : 0; // If the nodes are siblings, we can do a quick check
        } else if (aup === bup) {
          return siblingCheck(a, b);
        } // Otherwise we need full lists of their ancestors for comparison


        cur = a;

        while (cur = cur.parentNode) {
          ap.unshift(cur);
        }

        cur = b;

        while (cur = cur.parentNode) {
          bp.unshift(cur);
        } // Walk down the tree looking for a discrepancy


        while (ap[i] === bp[i]) {
          i++;
        }

        return i ? // Do a sibling check if the nodes have a common ancestor
        siblingCheck(ap[i], bp[i]) : // Otherwise nodes in our document sort first
        // Support: IE 11+, Edge 17 - 18+
        // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
        // two documents; shallow comparisons work.

        /* eslint-disable eqeqeq */
        ap[i] == preferredDoc ? -1 : bp[i] == preferredDoc ? 1 :
        /* eslint-enable eqeqeq */
        0;
      };
      return document;
    };

    Sizzle.matches = function (expr, elements) {
      return Sizzle(expr, null, null, elements);
    };

    Sizzle.matchesSelector = function (elem, expr) {
      setDocument(elem);

      if (support.matchesSelector && documentIsHTML && !nonnativeSelectorCache[expr + " "] && (!rbuggyMatches || !rbuggyMatches.test(expr)) && (!rbuggyQSA || !rbuggyQSA.test(expr))) {
        try {
          var ret = matches.call(elem, expr); // IE 9's matchesSelector returns false on disconnected nodes

          if (ret || support.disconnectedMatch || // As well, disconnected nodes are said to be in a document
          // fragment in IE 9
          elem.document && elem.document.nodeType !== 11) {
            return ret;
          }
        } catch (e) {
          nonnativeSelectorCache(expr, true);
        }
      }

      return Sizzle(expr, document, null, [elem]).length > 0;
    };

    Sizzle.contains = function (context, elem) {
      // Set document vars if needed
      // Support: IE 11+, Edge 17 - 18+
      // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
      // two documents; shallow comparisons work.
      // eslint-disable-next-line eqeqeq
      if ((context.ownerDocument || context) != document) {
        setDocument(context);
      }

      return contains(context, elem);
    };

    Sizzle.attr = function (elem, name) {
      // Set document vars if needed
      // Support: IE 11+, Edge 17 - 18+
      // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
      // two documents; shallow comparisons work.
      // eslint-disable-next-line eqeqeq
      if ((elem.ownerDocument || elem) != document) {
        setDocument(elem);
      }

      var fn = Expr.attrHandle[name.toLowerCase()],
          // Don't get fooled by Object.prototype properties (jQuery #13807)
      val = fn && hasOwn.call(Expr.attrHandle, name.toLowerCase()) ? fn(elem, name, !documentIsHTML) : undefined;
      return val !== undefined ? val : support.attributes || !documentIsHTML ? elem.getAttribute(name) : (val = elem.getAttributeNode(name)) && val.specified ? val.value : null;
    };

    Sizzle.escape = function (sel) {
      return (sel + "").replace(rcssescape, fcssescape);
    };

    Sizzle.error = function (msg) {
      throw new Error("Syntax error, unrecognized expression: " + msg);
    };
    /**
     * Document sorting and removing duplicates
     * @param {ArrayLike} results
     */


    Sizzle.uniqueSort = function (results) {
      var elem,
          duplicates = [],
          j = 0,
          i = 0; // Unless we *know* we can detect duplicates, assume their presence

      hasDuplicate = !support.detectDuplicates;
      sortInput = !support.sortStable && results.slice(0);
      results.sort(sortOrder);

      if (hasDuplicate) {
        while (elem = results[i++]) {
          if (elem === results[i]) {
            j = duplicates.push(i);
          }
        }

        while (j--) {
          results.splice(duplicates[j], 1);
        }
      } // Clear input after sorting to release objects
      // See https://github.com/jquery/sizzle/pull/225


      sortInput = null;
      return results;
    };
    /**
     * Utility function for retrieving the text value of an array of DOM nodes
     * @param {Array|Element} elem
     */


    getText = Sizzle.getText = function (elem) {
      var node,
          ret = "",
          i = 0,
          nodeType = elem.nodeType;

      if (!nodeType) {
        // If no nodeType, this is expected to be an array
        while (node = elem[i++]) {
          // Do not traverse comment nodes
          ret += getText(node);
        }
      } else if (nodeType === 1 || nodeType === 9 || nodeType === 11) {
        // Use textContent for elements
        // innerText usage removed for consistency of new lines (jQuery #11153)
        if (typeof elem.textContent === "string") {
          return elem.textContent;
        } else {
          // Traverse its children
          for (elem = elem.firstChild; elem; elem = elem.nextSibling) {
            ret += getText(elem);
          }
        }
      } else if (nodeType === 3 || nodeType === 4) {
        return elem.nodeValue;
      } // Do not include comment or processing instruction nodes


      return ret;
    };

    Expr = Sizzle.selectors = {
      // Can be adjusted by the user
      cacheLength: 50,
      createPseudo: markFunction,
      match: matchExpr,
      attrHandle: {},
      find: {},
      relative: {
        ">": {
          dir: "parentNode",
          first: true
        },
        " ": {
          dir: "parentNode"
        },
        "+": {
          dir: "previousSibling",
          first: true
        },
        "~": {
          dir: "previousSibling"
        }
      },
      preFilter: {
        "ATTR": function ATTR(match) {
          match[1] = match[1].replace(runescape, funescape); // Move the given value to match[3] whether quoted or unquoted

          match[3] = (match[3] || match[4] || match[5] || "").replace(runescape, funescape);

          if (match[2] === "~=") {
            match[3] = " " + match[3] + " ";
          }

          return match.slice(0, 4);
        },
        "CHILD": function CHILD(match) {
          /* matches from matchExpr["CHILD"]
          	1 type (only|nth|...)
          	2 what (child|of-type)
          	3 argument (even|odd|\d*|\d*n([+-]\d+)?|...)
          	4 xn-component of xn+y argument ([+-]?\d*n|)
          	5 sign of xn-component
          	6 x of xn-component
          	7 sign of y-component
          	8 y of y-component
          */
          match[1] = match[1].toLowerCase();

          if (match[1].slice(0, 3) === "nth") {
            // nth-* requires argument
            if (!match[3]) {
              Sizzle.error(match[0]);
            } // numeric x and y parameters for Expr.filter.CHILD
            // remember that false/true cast respectively to 0/1


            match[4] = +(match[4] ? match[5] + (match[6] || 1) : 2 * (match[3] === "even" || match[3] === "odd"));
            match[5] = +(match[7] + match[8] || match[3] === "odd"); // other types prohibit arguments
          } else if (match[3]) {
            Sizzle.error(match[0]);
          }

          return match;
        },
        "PSEUDO": function PSEUDO(match) {
          var excess,
              unquoted = !match[6] && match[2];

          if (matchExpr["CHILD"].test(match[0])) {
            return null;
          } // Accept quoted arguments as-is


          if (match[3]) {
            match[2] = match[4] || match[5] || ""; // Strip excess characters from unquoted arguments
          } else if (unquoted && rpseudo.test(unquoted) && ( // Get excess from tokenize (recursively)
          excess = tokenize(unquoted, true)) && ( // advance to the next closing parenthesis
          excess = unquoted.indexOf(")", unquoted.length - excess) - unquoted.length)) {
            // excess is a negative index
            match[0] = match[0].slice(0, excess);
            match[2] = unquoted.slice(0, excess);
          } // Return only captures needed by the pseudo filter method (type and argument)


          return match.slice(0, 3);
        }
      },
      filter: {
        "TAG": function TAG(nodeNameSelector) {
          var nodeName = nodeNameSelector.replace(runescape, funescape).toLowerCase();
          return nodeNameSelector === "*" ? function () {
            return true;
          } : function (elem) {
            return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
          };
        },
        "CLASS": function CLASS(className) {
          var pattern = classCache[className + " "];
          return pattern || (pattern = new RegExp("(^|" + whitespace + ")" + className + "(" + whitespace + "|$)")) && classCache(className, function (elem) {
            return pattern.test(typeof elem.className === "string" && elem.className || typeof elem.getAttribute !== "undefined" && elem.getAttribute("class") || "");
          });
        },
        "ATTR": function ATTR(name, operator, check) {
          return function (elem) {
            var result = Sizzle.attr(elem, name);

            if (result == null) {
              return operator === "!=";
            }

            if (!operator) {
              return true;
            }

            result += "";
            /* eslint-disable max-len */

            return operator === "=" ? result === check : operator === "!=" ? result !== check : operator === "^=" ? check && result.indexOf(check) === 0 : operator === "*=" ? check && result.indexOf(check) > -1 : operator === "$=" ? check && result.slice(-check.length) === check : operator === "~=" ? (" " + result.replace(rwhitespace, " ") + " ").indexOf(check) > -1 : operator === "|=" ? result === check || result.slice(0, check.length + 1) === check + "-" : false;
            /* eslint-enable max-len */
          };
        },
        "CHILD": function CHILD(type, what, _argument, first, last) {
          var simple = type.slice(0, 3) !== "nth",
              forward = type.slice(-4) !== "last",
              ofType = what === "of-type";
          return first === 1 && last === 0 ? // Shortcut for :nth-*(n)
          function (elem) {
            return !!elem.parentNode;
          } : function (elem, _context, xml) {
            var cache,
                uniqueCache,
                outerCache,
                node,
                nodeIndex,
                start,
                dir = simple !== forward ? "nextSibling" : "previousSibling",
                parent = elem.parentNode,
                name = ofType && elem.nodeName.toLowerCase(),
                useCache = !xml && !ofType,
                diff = false;

            if (parent) {
              // :(first|last|only)-(child|of-type)
              if (simple) {
                while (dir) {
                  node = elem;

                  while (node = node[dir]) {
                    if (ofType ? node.nodeName.toLowerCase() === name : node.nodeType === 1) {
                      return false;
                    }
                  } // Reverse direction for :only-* (if we haven't yet done so)


                  start = dir = type === "only" && !start && "nextSibling";
                }

                return true;
              }

              start = [forward ? parent.firstChild : parent.lastChild]; // non-xml :nth-child(...) stores cache data on `parent`

              if (forward && useCache) {
                // Seek `elem` from a previously-cached index
                // ...in a gzip-friendly way
                node = parent;
                outerCache = node[expando] || (node[expando] = {}); // Support: IE <9 only
                // Defend against cloned attroperties (jQuery gh-1709)

                uniqueCache = outerCache[node.uniqueID] || (outerCache[node.uniqueID] = {});
                cache = uniqueCache[type] || [];
                nodeIndex = cache[0] === dirruns && cache[1];
                diff = nodeIndex && cache[2];
                node = nodeIndex && parent.childNodes[nodeIndex];

                while (node = ++nodeIndex && node && node[dir] || ( // Fallback to seeking `elem` from the start
                diff = nodeIndex = 0) || start.pop()) {
                  // When found, cache indexes on `parent` and break
                  if (node.nodeType === 1 && ++diff && node === elem) {
                    uniqueCache[type] = [dirruns, nodeIndex, diff];
                    break;
                  }
                }
              } else {
                // Use previously-cached element index if available
                if (useCache) {
                  // ...in a gzip-friendly way
                  node = elem;
                  outerCache = node[expando] || (node[expando] = {}); // Support: IE <9 only
                  // Defend against cloned attroperties (jQuery gh-1709)

                  uniqueCache = outerCache[node.uniqueID] || (outerCache[node.uniqueID] = {});
                  cache = uniqueCache[type] || [];
                  nodeIndex = cache[0] === dirruns && cache[1];
                  diff = nodeIndex;
                } // xml :nth-child(...)
                // or :nth-last-child(...) or :nth(-last)?-of-type(...)


                if (diff === false) {
                  // Use the same loop as above to seek `elem` from the start
                  while (node = ++nodeIndex && node && node[dir] || (diff = nodeIndex = 0) || start.pop()) {
                    if ((ofType ? node.nodeName.toLowerCase() === name : node.nodeType === 1) && ++diff) {
                      // Cache the index of each encountered element
                      if (useCache) {
                        outerCache = node[expando] || (node[expando] = {}); // Support: IE <9 only
                        // Defend against cloned attroperties (jQuery gh-1709)

                        uniqueCache = outerCache[node.uniqueID] || (outerCache[node.uniqueID] = {});
                        uniqueCache[type] = [dirruns, diff];
                      }

                      if (node === elem) {
                        break;
                      }
                    }
                  }
                }
              } // Incorporate the offset, then check against cycle size


              diff -= last;
              return diff === first || diff % first === 0 && diff / first >= 0;
            }
          };
        },
        "PSEUDO": function PSEUDO(pseudo, argument) {
          // pseudo-class names are case-insensitive
          // http://www.w3.org/TR/selectors/#pseudo-classes
          // Prioritize by case sensitivity in case custom pseudos are added with uppercase letters
          // Remember that setFilters inherits from pseudos
          var args,
              fn = Expr.pseudos[pseudo] || Expr.setFilters[pseudo.toLowerCase()] || Sizzle.error("unsupported pseudo: " + pseudo); // The user may use createPseudo to indicate that
          // arguments are needed to create the filter function
          // just as Sizzle does

          if (fn[expando]) {
            return fn(argument);
          } // But maintain support for old signatures


          if (fn.length > 1) {
            args = [pseudo, pseudo, "", argument];
            return Expr.setFilters.hasOwnProperty(pseudo.toLowerCase()) ? markFunction(function (seed, matches) {
              var idx,
                  matched = fn(seed, argument),
                  i = matched.length;

              while (i--) {
                idx = indexOf(seed, matched[i]);
                seed[idx] = !(matches[idx] = matched[i]);
              }
            }) : function (elem) {
              return fn(elem, 0, args);
            };
          }

          return fn;
        }
      },
      pseudos: {
        // Potentially complex pseudos
        "not": markFunction(function (selector) {
          // Trim the selector passed to compile
          // to avoid treating leading and trailing
          // spaces as combinators
          var input = [],
              results = [],
              matcher = compile(selector.replace(rtrim, "$1"));
          return matcher[expando] ? markFunction(function (seed, matches, _context, xml) {
            var elem,
                unmatched = matcher(seed, null, xml, []),
                i = seed.length; // Match elements unmatched by `matcher`

            while (i--) {
              if (elem = unmatched[i]) {
                seed[i] = !(matches[i] = elem);
              }
            }
          }) : function (elem, _context, xml) {
            input[0] = elem;
            matcher(input, null, xml, results); // Don't keep the element (issue #299)

            input[0] = null;
            return !results.pop();
          };
        }),
        "has": markFunction(function (selector) {
          return function (elem) {
            return Sizzle(selector, elem).length > 0;
          };
        }),
        "contains": markFunction(function (text) {
          text = text.replace(runescape, funescape);
          return function (elem) {
            return (elem.textContent || getText(elem)).indexOf(text) > -1;
          };
        }),
        // "Whether an element is represented by a :lang() selector
        // is based solely on the element's language value
        // being equal to the identifier C,
        // or beginning with the identifier C immediately followed by "-".
        // The matching of C against the element's language value is performed case-insensitively.
        // The identifier C does not have to be a valid language name."
        // http://www.w3.org/TR/selectors/#lang-pseudo
        "lang": markFunction(function (lang) {
          // lang value must be a valid identifier
          if (!ridentifier.test(lang || "")) {
            Sizzle.error("unsupported lang: " + lang);
          }

          lang = lang.replace(runescape, funescape).toLowerCase();
          return function (elem) {
            var elemLang;

            do {
              if (elemLang = documentIsHTML ? elem.lang : elem.getAttribute("xml:lang") || elem.getAttribute("lang")) {
                elemLang = elemLang.toLowerCase();
                return elemLang === lang || elemLang.indexOf(lang + "-") === 0;
              }
            } while ((elem = elem.parentNode) && elem.nodeType === 1);

            return false;
          };
        }),
        // Miscellaneous
        "target": function target(elem) {
          var hash = window.location && window.location.hash;
          return hash && hash.slice(1) === elem.id;
        },
        "root": function root(elem) {
          return elem === docElem;
        },
        "focus": function focus(elem) {
          return elem === document.activeElement && (!document.hasFocus || document.hasFocus()) && !!(elem.type || elem.href || ~elem.tabIndex);
        },
        // Boolean properties
        "enabled": createDisabledPseudo(false),
        "disabled": createDisabledPseudo(true),
        "checked": function checked(elem) {
          // In CSS3, :checked should return both checked and selected elements
          // http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
          var nodeName = elem.nodeName.toLowerCase();
          return nodeName === "input" && !!elem.checked || nodeName === "option" && !!elem.selected;
        },
        "selected": function selected(elem) {
          // Accessing this property makes selected-by-default
          // options in Safari work properly
          if (elem.parentNode) {
            // eslint-disable-next-line no-unused-expressions
            elem.parentNode.selectedIndex;
          }

          return elem.selected === true;
        },
        // Contents
        "empty": function empty(elem) {
          // http://www.w3.org/TR/selectors/#empty-pseudo
          // :empty is negated by element (1) or content nodes (text: 3; cdata: 4; entity ref: 5),
          //   but not by others (comment: 8; processing instruction: 7; etc.)
          // nodeType < 6 works because attributes (2) do not appear as children
          for (elem = elem.firstChild; elem; elem = elem.nextSibling) {
            if (elem.nodeType < 6) {
              return false;
            }
          }

          return true;
        },
        "parent": function parent(elem) {
          return !Expr.pseudos["empty"](elem);
        },
        // Element/input types
        "header": function header(elem) {
          return rheader.test(elem.nodeName);
        },
        "input": function input(elem) {
          return rinputs.test(elem.nodeName);
        },
        "button": function button(elem) {
          var name = elem.nodeName.toLowerCase();
          return name === "input" && elem.type === "button" || name === "button";
        },
        "text": function text(elem) {
          var attr;
          return elem.nodeName.toLowerCase() === "input" && elem.type === "text" && ( // Support: IE<8
          // New HTML5 attribute values (e.g., "search") appear with elem.type === "text"
          (attr = elem.getAttribute("type")) == null || attr.toLowerCase() === "text");
        },
        // Position-in-collection
        "first": createPositionalPseudo(function () {
          return [0];
        }),
        "last": createPositionalPseudo(function (_matchIndexes, length) {
          return [length - 1];
        }),
        "eq": createPositionalPseudo(function (_matchIndexes, length, argument) {
          return [argument < 0 ? argument + length : argument];
        }),
        "even": createPositionalPseudo(function (matchIndexes, length) {
          var i = 0;

          for (; i < length; i += 2) {
            matchIndexes.push(i);
          }

          return matchIndexes;
        }),
        "odd": createPositionalPseudo(function (matchIndexes, length) {
          var i = 1;

          for (; i < length; i += 2) {
            matchIndexes.push(i);
          }

          return matchIndexes;
        }),
        "lt": createPositionalPseudo(function (matchIndexes, length, argument) {
          var i = argument < 0 ? argument + length : argument > length ? length : argument;

          for (; --i >= 0;) {
            matchIndexes.push(i);
          }

          return matchIndexes;
        }),
        "gt": createPositionalPseudo(function (matchIndexes, length, argument) {
          var i = argument < 0 ? argument + length : argument;

          for (; ++i < length;) {
            matchIndexes.push(i);
          }

          return matchIndexes;
        })
      }
    };
    Expr.pseudos["nth"] = Expr.pseudos["eq"]; // Add button/input type pseudos

    for (i in {
      radio: true,
      checkbox: true,
      file: true,
      password: true,
      image: true
    }) {
      Expr.pseudos[i] = createInputPseudo(i);
    }

    for (i in {
      submit: true,
      reset: true
    }) {
      Expr.pseudos[i] = createButtonPseudo(i);
    } // Easy API for creating new setFilters


    function setFilters() {}

    setFilters.prototype = Expr.filters = Expr.pseudos;
    Expr.setFilters = new setFilters();

    tokenize = Sizzle.tokenize = function (selector, parseOnly) {
      var matched,
          match,
          tokens,
          type,
          soFar,
          groups,
          preFilters,
          cached = tokenCache[selector + " "];

      if (cached) {
        return parseOnly ? 0 : cached.slice(0);
      }

      soFar = selector;
      groups = [];
      preFilters = Expr.preFilter;

      while (soFar) {
        // Comma and first run
        if (!matched || (match = rcomma.exec(soFar))) {
          if (match) {
            // Don't consume trailing commas as valid
            soFar = soFar.slice(match[0].length) || soFar;
          }

          groups.push(tokens = []);
        }

        matched = false; // Combinators

        if (match = rcombinators.exec(soFar)) {
          matched = match.shift();
          tokens.push({
            value: matched,
            // Cast descendant combinators to space
            type: match[0].replace(rtrim, " ")
          });
          soFar = soFar.slice(matched.length);
        } // Filters


        for (type in Expr.filter) {
          if ((match = matchExpr[type].exec(soFar)) && (!preFilters[type] || (match = preFilters[type](match)))) {
            matched = match.shift();
            tokens.push({
              value: matched,
              type: type,
              matches: match
            });
            soFar = soFar.slice(matched.length);
          }
        }

        if (!matched) {
          break;
        }
      } // Return the length of the invalid excess
      // if we're just parsing
      // Otherwise, throw an error or return tokens


      return parseOnly ? soFar.length : soFar ? Sizzle.error(selector) : // Cache the tokens
      tokenCache(selector, groups).slice(0);
    };

    function toSelector(tokens) {
      var i = 0,
          len = tokens.length,
          selector = "";

      for (; i < len; i++) {
        selector += tokens[i].value;
      }

      return selector;
    }

    function addCombinator(matcher, combinator, base) {
      var dir = combinator.dir,
          skip = combinator.next,
          key = skip || dir,
          checkNonElements = base && key === "parentNode",
          doneName = done++;
      return combinator.first ? // Check against closest ancestor/preceding element
      function (elem, context, xml) {
        while (elem = elem[dir]) {
          if (elem.nodeType === 1 || checkNonElements) {
            return matcher(elem, context, xml);
          }
        }

        return false;
      } : // Check against all ancestor/preceding elements
      function (elem, context, xml) {
        var oldCache,
            uniqueCache,
            outerCache,
            newCache = [dirruns, doneName]; // We can't set arbitrary data on XML nodes, so they don't benefit from combinator caching

        if (xml) {
          while (elem = elem[dir]) {
            if (elem.nodeType === 1 || checkNonElements) {
              if (matcher(elem, context, xml)) {
                return true;
              }
            }
          }
        } else {
          while (elem = elem[dir]) {
            if (elem.nodeType === 1 || checkNonElements) {
              outerCache = elem[expando] || (elem[expando] = {}); // Support: IE <9 only
              // Defend against cloned attroperties (jQuery gh-1709)

              uniqueCache = outerCache[elem.uniqueID] || (outerCache[elem.uniqueID] = {});

              if (skip && skip === elem.nodeName.toLowerCase()) {
                elem = elem[dir] || elem;
              } else if ((oldCache = uniqueCache[key]) && oldCache[0] === dirruns && oldCache[1] === doneName) {
                // Assign to newCache so results back-propagate to previous elements
                return newCache[2] = oldCache[2];
              } else {
                // Reuse newcache so results back-propagate to previous elements
                uniqueCache[key] = newCache; // A match means we're done; a fail means we have to keep checking

                if (newCache[2] = matcher(elem, context, xml)) {
                  return true;
                }
              }
            }
          }
        }

        return false;
      };
    }

    function elementMatcher(matchers) {
      return matchers.length > 1 ? function (elem, context, xml) {
        var i = matchers.length;

        while (i--) {
          if (!matchers[i](elem, context, xml)) {
            return false;
          }
        }

        return true;
      } : matchers[0];
    }

    function multipleContexts(selector, contexts, results) {
      var i = 0,
          len = contexts.length;

      for (; i < len; i++) {
        Sizzle(selector, contexts[i], results);
      }

      return results;
    }

    function condense(unmatched, map, filter, context, xml) {
      var elem,
          newUnmatched = [],
          i = 0,
          len = unmatched.length,
          mapped = map != null;

      for (; i < len; i++) {
        if (elem = unmatched[i]) {
          if (!filter || filter(elem, context, xml)) {
            newUnmatched.push(elem);

            if (mapped) {
              map.push(i);
            }
          }
        }
      }

      return newUnmatched;
    }

    function setMatcher(preFilter, selector, matcher, postFilter, postFinder, postSelector) {
      if (postFilter && !postFilter[expando]) {
        postFilter = setMatcher(postFilter);
      }

      if (postFinder && !postFinder[expando]) {
        postFinder = setMatcher(postFinder, postSelector);
      }

      return markFunction(function (seed, results, context, xml) {
        var temp,
            i,
            elem,
            preMap = [],
            postMap = [],
            preexisting = results.length,
            // Get initial elements from seed or context
        elems = seed || multipleContexts(selector || "*", context.nodeType ? [context] : context, []),
            // Prefilter to get matcher input, preserving a map for seed-results synchronization
        matcherIn = preFilter && (seed || !selector) ? condense(elems, preMap, preFilter, context, xml) : elems,
            matcherOut = matcher ? // If we have a postFinder, or filtered seed, or non-seed postFilter or preexisting results,
        postFinder || (seed ? preFilter : preexisting || postFilter) ? // ...intermediate processing is necessary
        [] : // ...otherwise use results directly
        results : matcherIn; // Find primary matches

        if (matcher) {
          matcher(matcherIn, matcherOut, context, xml);
        } // Apply postFilter


        if (postFilter) {
          temp = condense(matcherOut, postMap);
          postFilter(temp, [], context, xml); // Un-match failing elements by moving them back to matcherIn

          i = temp.length;

          while (i--) {
            if (elem = temp[i]) {
              matcherOut[postMap[i]] = !(matcherIn[postMap[i]] = elem);
            }
          }
        }

        if (seed) {
          if (postFinder || preFilter) {
            if (postFinder) {
              // Get the final matcherOut by condensing this intermediate into postFinder contexts
              temp = [];
              i = matcherOut.length;

              while (i--) {
                if (elem = matcherOut[i]) {
                  // Restore matcherIn since elem is not yet a final match
                  temp.push(matcherIn[i] = elem);
                }
              }

              postFinder(null, matcherOut = [], temp, xml);
            } // Move matched elements from seed to results to keep them synchronized


            i = matcherOut.length;

            while (i--) {
              if ((elem = matcherOut[i]) && (temp = postFinder ? indexOf(seed, elem) : preMap[i]) > -1) {
                seed[temp] = !(results[temp] = elem);
              }
            }
          } // Add elements to results, through postFinder if defined

        } else {
          matcherOut = condense(matcherOut === results ? matcherOut.splice(preexisting, matcherOut.length) : matcherOut);

          if (postFinder) {
            postFinder(null, results, matcherOut, xml);
          } else {
            push.apply(results, matcherOut);
          }
        }
      });
    }

    function matcherFromTokens(tokens) {
      var checkContext,
          matcher,
          j,
          len = tokens.length,
          leadingRelative = Expr.relative[tokens[0].type],
          implicitRelative = leadingRelative || Expr.relative[" "],
          i = leadingRelative ? 1 : 0,
          // The foundational matcher ensures that elements are reachable from top-level context(s)
      matchContext = addCombinator(function (elem) {
        return elem === checkContext;
      }, implicitRelative, true),
          matchAnyContext = addCombinator(function (elem) {
        return indexOf(checkContext, elem) > -1;
      }, implicitRelative, true),
          matchers = [function (elem, context, xml) {
        var ret = !leadingRelative && (xml || context !== outermostContext) || ((checkContext = context).nodeType ? matchContext(elem, context, xml) : matchAnyContext(elem, context, xml)); // Avoid hanging onto element (issue #299)

        checkContext = null;
        return ret;
      }];

      for (; i < len; i++) {
        if (matcher = Expr.relative[tokens[i].type]) {
          matchers = [addCombinator(elementMatcher(matchers), matcher)];
        } else {
          matcher = Expr.filter[tokens[i].type].apply(null, tokens[i].matches); // Return special upon seeing a positional matcher

          if (matcher[expando]) {
            // Find the next relative operator (if any) for proper handling
            j = ++i;

            for (; j < len; j++) {
              if (Expr.relative[tokens[j].type]) {
                break;
              }
            }

            return setMatcher(i > 1 && elementMatcher(matchers), i > 1 && toSelector( // If the preceding token was a descendant combinator, insert an implicit any-element `*`
            tokens.slice(0, i - 1).concat({
              value: tokens[i - 2].type === " " ? "*" : ""
            })).replace(rtrim, "$1"), matcher, i < j && matcherFromTokens(tokens.slice(i, j)), j < len && matcherFromTokens(tokens = tokens.slice(j)), j < len && toSelector(tokens));
          }

          matchers.push(matcher);
        }
      }

      return elementMatcher(matchers);
    }

    function matcherFromGroupMatchers(elementMatchers, setMatchers) {
      var bySet = setMatchers.length > 0,
          byElement = elementMatchers.length > 0,
          superMatcher = function superMatcher(seed, context, xml, results, outermost) {
        var elem,
            j,
            matcher,
            matchedCount = 0,
            i = "0",
            unmatched = seed && [],
            setMatched = [],
            contextBackup = outermostContext,
            // We must always have either seed elements or outermost context
        elems = seed || byElement && Expr.find["TAG"]("*", outermost),
            // Use integer dirruns iff this is the outermost matcher
        dirrunsUnique = dirruns += contextBackup == null ? 1 : Math.random() || 0.1,
            len = elems.length;

        if (outermost) {
          // Support: IE 11+, Edge 17 - 18+
          // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
          // two documents; shallow comparisons work.
          // eslint-disable-next-line eqeqeq
          outermostContext = context == document || context || outermost;
        } // Add elements passing elementMatchers directly to results
        // Support: IE<9, Safari
        // Tolerate NodeList properties (IE: "length"; Safari: <number>) matching elements by id


        for (; i !== len && (elem = elems[i]) != null; i++) {
          if (byElement && elem) {
            j = 0; // Support: IE 11+, Edge 17 - 18+
            // IE/Edge sometimes throw a "Permission denied" error when strict-comparing
            // two documents; shallow comparisons work.
            // eslint-disable-next-line eqeqeq

            if (!context && elem.ownerDocument != document) {
              setDocument(elem);
              xml = !documentIsHTML;
            }

            while (matcher = elementMatchers[j++]) {
              if (matcher(elem, context || document, xml)) {
                results.push(elem);
                break;
              }
            }

            if (outermost) {
              dirruns = dirrunsUnique;
            }
          } // Track unmatched elements for set filters


          if (bySet) {
            // They will have gone through all possible matchers
            if (elem = !matcher && elem) {
              matchedCount--;
            } // Lengthen the array for every element, matched or not


            if (seed) {
              unmatched.push(elem);
            }
          }
        } // `i` is now the count of elements visited above, and adding it to `matchedCount`
        // makes the latter nonnegative.


        matchedCount += i; // Apply set filters to unmatched elements
        // NOTE: This can be skipped if there are no unmatched elements (i.e., `matchedCount`
        // equals `i`), unless we didn't visit _any_ elements in the above loop because we have
        // no element matchers and no seed.
        // Incrementing an initially-string "0" `i` allows `i` to remain a string only in that
        // case, which will result in a "00" `matchedCount` that differs from `i` but is also
        // numerically zero.

        if (bySet && i !== matchedCount) {
          j = 0;

          while (matcher = setMatchers[j++]) {
            matcher(unmatched, setMatched, context, xml);
          }

          if (seed) {
            // Reintegrate element matches to eliminate the need for sorting
            if (matchedCount > 0) {
              while (i--) {
                if (!(unmatched[i] || setMatched[i])) {
                  setMatched[i] = pop.call(results);
                }
              }
            } // Discard index placeholder values to get only actual matches


            setMatched = condense(setMatched);
          } // Add matches to results


          push.apply(results, setMatched); // Seedless set matches succeeding multiple successful matchers stipulate sorting

          if (outermost && !seed && setMatched.length > 0 && matchedCount + setMatchers.length > 1) {
            Sizzle.uniqueSort(results);
          }
        } // Override manipulation of globals by nested matchers


        if (outermost) {
          dirruns = dirrunsUnique;
          outermostContext = contextBackup;
        }

        return unmatched;
      };

      return bySet ? markFunction(superMatcher) : superMatcher;
    }

    compile = Sizzle.compile = function (selector, match
    /* Internal Use Only */
    ) {
      var i,
          setMatchers = [],
          elementMatchers = [],
          cached = compilerCache[selector + " "];

      if (!cached) {
        // Generate a function of recursive functions that can be used to check each element
        if (!match) {
          match = tokenize(selector);
        }

        i = match.length;

        while (i--) {
          cached = matcherFromTokens(match[i]);

          if (cached[expando]) {
            setMatchers.push(cached);
          } else {
            elementMatchers.push(cached);
          }
        } // Cache the compiled function


        cached = compilerCache(selector, matcherFromGroupMatchers(elementMatchers, setMatchers)); // Save selector and tokenization

        cached.selector = selector;
      }

      return cached;
    };
    /**
     * A low-level selection function that works with Sizzle's compiled
     *  selector functions
     * @param {String|Function} selector A selector or a pre-compiled
     *  selector function built with Sizzle.compile
     * @param {Element} context
     * @param {Array} [results]
     * @param {Array} [seed] A set of elements to match against
     */


    select = Sizzle.select = function (selector, context, results, seed) {
      var i,
          tokens,
          token,
          type,
          find,
          compiled = typeof selector === "function" && selector,
          match = !seed && tokenize(selector = compiled.selector || selector);
      results = results || []; // Try to minimize operations if there is only one selector in the list and no seed
      // (the latter of which guarantees us context)

      if (match.length === 1) {
        // Reduce context if the leading compound selector is an ID
        tokens = match[0] = match[0].slice(0);

        if (tokens.length > 2 && (token = tokens[0]).type === "ID" && context.nodeType === 9 && documentIsHTML && Expr.relative[tokens[1].type]) {
          context = (Expr.find["ID"](token.matches[0].replace(runescape, funescape), context) || [])[0];

          if (!context) {
            return results; // Precompiled matchers will still verify ancestry, so step up a level
          } else if (compiled) {
            context = context.parentNode;
          }

          selector = selector.slice(tokens.shift().value.length);
        } // Fetch a seed set for right-to-left matching


        i = matchExpr["needsContext"].test(selector) ? 0 : tokens.length;

        while (i--) {
          token = tokens[i]; // Abort if we hit a combinator

          if (Expr.relative[type = token.type]) {
            break;
          }

          if (find = Expr.find[type]) {
            // Search, expanding context for leading sibling combinators
            if (seed = find(token.matches[0].replace(runescape, funescape), rsibling.test(tokens[0].type) && testContext(context.parentNode) || context)) {
              // If seed is empty or no tokens remain, we can return early
              tokens.splice(i, 1);
              selector = seed.length && toSelector(tokens);

              if (!selector) {
                push.apply(results, seed);
                return results;
              }

              break;
            }
          }
        }
      } // Compile and execute a filtering function if one is not provided
      // Provide `match` to avoid retokenization if we modified the selector above


      (compiled || compile(selector, match))(seed, context, !documentIsHTML, results, !context || rsibling.test(selector) && testContext(context.parentNode) || context);
      return results;
    }; // One-time assignments
    // Sort stability


    support.sortStable = expando.split("").sort(sortOrder).join("") === expando; // Support: Chrome 14-35+
    // Always assume duplicates if they aren't passed to the comparison function

    support.detectDuplicates = !!hasDuplicate; // Initialize against the default document

    setDocument(); // Support: Webkit<537.32 - Safari 6.0.3/Chrome 25 (fixed in Chrome 27)
    // Detached nodes confoundingly follow *each other*

    support.sortDetached = assert(function (el) {
      // Should return 1, but returns 4 (following)
      return el.compareDocumentPosition(document.createElement("fieldset")) & 1;
    }); // Support: IE<8
    // Prevent attribute/property "interpolation"
    // https://msdn.microsoft.com/en-us/library/ms536429%28VS.85%29.aspx

    if (!assert(function (el) {
      el.innerHTML = "<a href='#'></a>";
      return el.firstChild.getAttribute("href") === "#";
    })) {
      addHandle("type|href|height|width", function (elem, name, isXML) {
        if (!isXML) {
          return elem.getAttribute(name, name.toLowerCase() === "type" ? 1 : 2);
        }
      });
    } // Support: IE<9
    // Use defaultValue in place of getAttribute("value")


    if (!support.attributes || !assert(function (el) {
      el.innerHTML = "<input/>";
      el.firstChild.setAttribute("value", "");
      return el.firstChild.getAttribute("value") === "";
    })) {
      addHandle("value", function (elem, _name, isXML) {
        if (!isXML && elem.nodeName.toLowerCase() === "input") {
          return elem.defaultValue;
        }
      });
    } // Support: IE<9
    // Use getAttributeNode to fetch booleans when getAttribute lies


    if (!assert(function (el) {
      return el.getAttribute("disabled") == null;
    })) {
      addHandle(booleans, function (elem, name, isXML) {
        var val;

        if (!isXML) {
          return elem[name] === true ? name.toLowerCase() : (val = elem.getAttributeNode(name)) && val.specified ? val.value : null;
        }
      });
    }

    return Sizzle;
  }(window);

  jQuery.find = Sizzle;
  jQuery.expr = Sizzle.selectors; // Deprecated

  jQuery.expr[":"] = jQuery.expr.pseudos;
  jQuery.uniqueSort = jQuery.unique = Sizzle.uniqueSort;
  jQuery.text = Sizzle.getText;
  jQuery.isXMLDoc = Sizzle.isXML;
  jQuery.contains = Sizzle.contains;
  jQuery.escapeSelector = Sizzle.escape;

  var dir = function dir(elem, _dir, until) {
    var matched = [],
        truncate = until !== undefined;

    while ((elem = elem[_dir]) && elem.nodeType !== 9) {
      if (elem.nodeType === 1) {
        if (truncate && jQuery(elem).is(until)) {
          break;
        }

        matched.push(elem);
      }
    }

    return matched;
  };

  var _siblings = function siblings(n, elem) {
    var matched = [];

    for (; n; n = n.nextSibling) {
      if (n.nodeType === 1 && n !== elem) {
        matched.push(n);
      }
    }

    return matched;
  };

  var rneedsContext = jQuery.expr.match.needsContext;

  function nodeName(elem, name) {
    return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();
  }

  ;
  var rsingleTag = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i; // Implement the identical functionality for filter and not

  function winnow(elements, qualifier, not) {
    if (isFunction(qualifier)) {
      return jQuery.grep(elements, function (elem, i) {
        return !!qualifier.call(elem, i, elem) !== not;
      });
    } // Single element


    if (qualifier.nodeType) {
      return jQuery.grep(elements, function (elem) {
        return elem === qualifier !== not;
      });
    } // Arraylike of elements (jQuery, arguments, Array)


    if (typeof qualifier !== "string") {
      return jQuery.grep(elements, function (elem) {
        return indexOf.call(qualifier, elem) > -1 !== not;
      });
    } // Filtered directly for both simple and complex selectors


    return jQuery.filter(qualifier, elements, not);
  }

  jQuery.filter = function (expr, elems, not) {
    var elem = elems[0];

    if (not) {
      expr = ":not(" + expr + ")";
    }

    if (elems.length === 1 && elem.nodeType === 1) {
      return jQuery.find.matchesSelector(elem, expr) ? [elem] : [];
    }

    return jQuery.find.matches(expr, jQuery.grep(elems, function (elem) {
      return elem.nodeType === 1;
    }));
  };

  jQuery.fn.extend({
    find: function find(selector) {
      var i,
          ret,
          len = this.length,
          self = this;

      if (typeof selector !== "string") {
        return this.pushStack(jQuery(selector).filter(function () {
          for (i = 0; i < len; i++) {
            if (jQuery.contains(self[i], this)) {
              return true;
            }
          }
        }));
      }

      ret = this.pushStack([]);

      for (i = 0; i < len; i++) {
        jQuery.find(selector, self[i], ret);
      }

      return len > 1 ? jQuery.uniqueSort(ret) : ret;
    },
    filter: function filter(selector) {
      return this.pushStack(winnow(this, selector || [], false));
    },
    not: function not(selector) {
      return this.pushStack(winnow(this, selector || [], true));
    },
    is: function is(selector) {
      return !!winnow(this, // If this is a positional/relative selector, check membership in the returned set
      // so $("p:first").is("p:last") won't return true for a doc with two "p".
      typeof selector === "string" && rneedsContext.test(selector) ? jQuery(selector) : selector || [], false).length;
    }
  }); // Initialize a jQuery object
  // A central reference to the root jQuery(document)

  var rootjQuery,
      // A simple way to check for HTML strings
  // Prioritize #id over <tag> to avoid XSS via location.hash (#9521)
  // Strict HTML recognition (#11290: must start with <)
  // Shortcut simple #id case for speed
  rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/,
      init = jQuery.fn.init = function (selector, context, root) {
    var match, elem; // HANDLE: $(""), $(null), $(undefined), $(false)

    if (!selector) {
      return this;
    } // Method init() accepts an alternate rootjQuery
    // so migrate can support jQuery.sub (gh-2101)


    root = root || rootjQuery; // Handle HTML strings

    if (typeof selector === "string") {
      if (selector[0] === "<" && selector[selector.length - 1] === ">" && selector.length >= 3) {
        // Assume that strings that start and end with <> are HTML and skip the regex check
        match = [null, selector, null];
      } else {
        match = rquickExpr.exec(selector);
      } // Match html or make sure no context is specified for #id


      if (match && (match[1] || !context)) {
        // HANDLE: $(html) -> $(array)
        if (match[1]) {
          context = context instanceof jQuery ? context[0] : context; // Option to run scripts is true for back-compat
          // Intentionally let the error be thrown if parseHTML is not present

          jQuery.merge(this, jQuery.parseHTML(match[1], context && context.nodeType ? context.ownerDocument || context : document, true)); // HANDLE: $(html, props)

          if (rsingleTag.test(match[1]) && jQuery.isPlainObject(context)) {
            for (match in context) {
              // Properties of context are called as methods if possible
              if (isFunction(this[match])) {
                this[match](context[match]); // ...and otherwise set as attributes
              } else {
                this.attr(match, context[match]);
              }
            }
          }

          return this; // HANDLE: $(#id)
        } else {
          elem = document.getElementById(match[2]);

          if (elem) {
            // Inject the element directly into the jQuery object
            this[0] = elem;
            this.length = 1;
          }

          return this;
        } // HANDLE: $(expr, $(...))

      } else if (!context || context.jquery) {
        return (context || root).find(selector); // HANDLE: $(expr, context)
        // (which is just equivalent to: $(context).find(expr)
      } else {
        return this.constructor(context).find(selector);
      } // HANDLE: $(DOMElement)

    } else if (selector.nodeType) {
      this[0] = selector;
      this.length = 1;
      return this; // HANDLE: $(function)
      // Shortcut for document ready
    } else if (isFunction(selector)) {
      return root.ready !== undefined ? root.ready(selector) : // Execute immediately if ready is not present
      selector(jQuery);
    }

    return jQuery.makeArray(selector, this);
  }; // Give the init function the jQuery prototype for later instantiation


  init.prototype = jQuery.fn; // Initialize central reference

  rootjQuery = jQuery(document);
  var rparentsprev = /^(?:parents|prev(?:Until|All))/,
      // Methods guaranteed to produce a unique set when starting from a unique set
  guaranteedUnique = {
    children: true,
    contents: true,
    next: true,
    prev: true
  };
  jQuery.fn.extend({
    has: function has(target) {
      var targets = jQuery(target, this),
          l = targets.length;
      return this.filter(function () {
        var i = 0;

        for (; i < l; i++) {
          if (jQuery.contains(this, targets[i])) {
            return true;
          }
        }
      });
    },
    closest: function closest(selectors, context) {
      var cur,
          i = 0,
          l = this.length,
          matched = [],
          targets = typeof selectors !== "string" && jQuery(selectors); // Positional selectors never match, since there's no _selection_ context

      if (!rneedsContext.test(selectors)) {
        for (; i < l; i++) {
          for (cur = this[i]; cur && cur !== context; cur = cur.parentNode) {
            // Always skip document fragments
            if (cur.nodeType < 11 && (targets ? targets.index(cur) > -1 : // Don't pass non-elements to Sizzle
            cur.nodeType === 1 && jQuery.find.matchesSelector(cur, selectors))) {
              matched.push(cur);
              break;
            }
          }
        }
      }

      return this.pushStack(matched.length > 1 ? jQuery.uniqueSort(matched) : matched);
    },
    // Determine the position of an element within the set
    index: function index(elem) {
      // No argument, return index in parent
      if (!elem) {
        return this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
      } // Index in selector


      if (typeof elem === "string") {
        return indexOf.call(jQuery(elem), this[0]);
      } // Locate the position of the desired element


      return indexOf.call(this, // If it receives a jQuery object, the first element is used
      elem.jquery ? elem[0] : elem);
    },
    add: function add(selector, context) {
      return this.pushStack(jQuery.uniqueSort(jQuery.merge(this.get(), jQuery(selector, context))));
    },
    addBack: function addBack(selector) {
      return this.add(selector == null ? this.prevObject : this.prevObject.filter(selector));
    }
  });

  function sibling(cur, dir) {
    while ((cur = cur[dir]) && cur.nodeType !== 1) {}

    return cur;
  }

  jQuery.each({
    parent: function parent(elem) {
      var parent = elem.parentNode;
      return parent && parent.nodeType !== 11 ? parent : null;
    },
    parents: function parents(elem) {
      return dir(elem, "parentNode");
    },
    parentsUntil: function parentsUntil(elem, _i, until) {
      return dir(elem, "parentNode", until);
    },
    next: function next(elem) {
      return sibling(elem, "nextSibling");
    },
    prev: function prev(elem) {
      return sibling(elem, "previousSibling");
    },
    nextAll: function nextAll(elem) {
      return dir(elem, "nextSibling");
    },
    prevAll: function prevAll(elem) {
      return dir(elem, "previousSibling");
    },
    nextUntil: function nextUntil(elem, _i, until) {
      return dir(elem, "nextSibling", until);
    },
    prevUntil: function prevUntil(elem, _i, until) {
      return dir(elem, "previousSibling", until);
    },
    siblings: function siblings(elem) {
      return _siblings((elem.parentNode || {}).firstChild, elem);
    },
    children: function children(elem) {
      return _siblings(elem.firstChild);
    },
    contents: function contents(elem) {
      if (elem.contentDocument != null && // Support: IE 11+
      // <object> elements with no `data` attribute has an object
      // `contentDocument` with a `null` prototype.
      getProto(elem.contentDocument)) {
        return elem.contentDocument;
      } // Support: IE 9 - 11 only, iOS 7 only, Android Browser <=4.3 only
      // Treat the template element as a regular one in browsers that
      // don't support it.


      if (nodeName(elem, "template")) {
        elem = elem.content || elem;
      }

      return jQuery.merge([], elem.childNodes);
    }
  }, function (name, fn) {
    jQuery.fn[name] = function (until, selector) {
      var matched = jQuery.map(this, fn, until);

      if (name.slice(-5) !== "Until") {
        selector = until;
      }

      if (selector && typeof selector === "string") {
        matched = jQuery.filter(selector, matched);
      }

      if (this.length > 1) {
        // Remove duplicates
        if (!guaranteedUnique[name]) {
          jQuery.uniqueSort(matched);
        } // Reverse order for parents* and prev-derivatives


        if (rparentsprev.test(name)) {
          matched.reverse();
        }
      }

      return this.pushStack(matched);
    };
  });
  var rnothtmlwhite = /[^\x20\t\r\n\f]+/g; // Convert String-formatted options into Object-formatted ones

  function createOptions(options) {
    var object = {};
    jQuery.each(options.match(rnothtmlwhite) || [], function (_, flag) {
      object[flag] = true;
    });
    return object;
  }
  /*
   * Create a callback list using the following parameters:
   *
   *	options: an optional list of space-separated options that will change how
   *			the callback list behaves or a more traditional option object
   *
   * By default a callback list will act like an event callback list and can be
   * "fired" multiple times.
   *
   * Possible options:
   *
   *	once:			will ensure the callback list can only be fired once (like a Deferred)
   *
   *	memory:			will keep track of previous values and will call any callback added
   *					after the list has been fired right away with the latest "memorized"
   *					values (like a Deferred)
   *
   *	unique:			will ensure a callback can only be added once (no duplicate in the list)
   *
   *	stopOnFalse:	interrupt callings when a callback returns false
   *
   */


  jQuery.Callbacks = function (options) {
    // Convert options from String-formatted to Object-formatted if needed
    // (we check in cache first)
    options = typeof options === "string" ? createOptions(options) : jQuery.extend({}, options);

    var // Flag to know if list is currently firing
    firing,
        // Last fire value for non-forgettable lists
    memory,
        // Flag to know if list was already fired
    _fired,
        // Flag to prevent firing
    _locked,
        // Actual callback list
    list = [],
        // Queue of execution data for repeatable lists
    queue = [],
        // Index of currently firing callback (modified by add/remove as needed)
    firingIndex = -1,
        // Fire callbacks
    fire = function fire() {
      // Enforce single-firing
      _locked = _locked || options.once; // Execute callbacks for all pending executions,
      // respecting firingIndex overrides and runtime changes

      _fired = firing = true;

      for (; queue.length; firingIndex = -1) {
        memory = queue.shift();

        while (++firingIndex < list.length) {
          // Run callback and check for early termination
          if (list[firingIndex].apply(memory[0], memory[1]) === false && options.stopOnFalse) {
            // Jump to end and forget the data so .add doesn't re-fire
            firingIndex = list.length;
            memory = false;
          }
        }
      } // Forget the data if we're done with it


      if (!options.memory) {
        memory = false;
      }

      firing = false; // Clean up if we're done firing for good

      if (_locked) {
        // Keep an empty list if we have data for future add calls
        if (memory) {
          list = []; // Otherwise, this object is spent
        } else {
          list = "";
        }
      }
    },
        // Actual Callbacks object
    self = {
      // Add a callback or a collection of callbacks to the list
      add: function add() {
        if (list) {
          // If we have memory from a past run, we should fire after adding
          if (memory && !firing) {
            firingIndex = list.length - 1;
            queue.push(memory);
          }

          (function add(args) {
            jQuery.each(args, function (_, arg) {
              if (isFunction(arg)) {
                if (!options.unique || !self.has(arg)) {
                  list.push(arg);
                }
              } else if (arg && arg.length && toType(arg) !== "string") {
                // Inspect recursively
                add(arg);
              }
            });
          })(arguments);

          if (memory && !firing) {
            fire();
          }
        }

        return this;
      },
      // Remove a callback from the list
      remove: function remove() {
        jQuery.each(arguments, function (_, arg) {
          var index;

          while ((index = jQuery.inArray(arg, list, index)) > -1) {
            list.splice(index, 1); // Handle firing indexes

            if (index <= firingIndex) {
              firingIndex--;
            }
          }
        });
        return this;
      },
      // Check if a given callback is in the list.
      // If no argument is given, return whether or not list has callbacks attached.
      has: function has(fn) {
        return fn ? jQuery.inArray(fn, list) > -1 : list.length > 0;
      },
      // Remove all callbacks from the list
      empty: function empty() {
        if (list) {
          list = [];
        }

        return this;
      },
      // Disable .fire and .add
      // Abort any current/pending executions
      // Clear all callbacks and values
      disable: function disable() {
        _locked = queue = [];
        list = memory = "";
        return this;
      },
      disabled: function disabled() {
        return !list;
      },
      // Disable .fire
      // Also disable .add unless we have memory (since it would have no effect)
      // Abort any pending executions
      lock: function lock() {
        _locked = queue = [];

        if (!memory && !firing) {
          list = memory = "";
        }

        return this;
      },
      locked: function locked() {
        return !!_locked;
      },
      // Call all callbacks with the given context and arguments
      fireWith: function fireWith(context, args) {
        if (!_locked) {
          args = args || [];
          args = [context, args.slice ? args.slice() : args];
          queue.push(args);

          if (!firing) {
            fire();
          }
        }

        return this;
      },
      // Call all the callbacks with the given arguments
      fire: function fire() {
        self.fireWith(this, arguments);
        return this;
      },
      // To know if the callbacks have already been called at least once
      fired: function fired() {
        return !!_fired;
      }
    };

    return self;
  };

  function Identity(v) {
    return v;
  }

  function Thrower(ex) {
    throw ex;
  }

  function adoptValue(value, resolve, reject, noValue) {
    var method;

    try {
      // Check for promise aspect first to privilege synchronous behavior
      if (value && isFunction(method = value.promise)) {
        method.call(value).done(resolve).fail(reject); // Other thenables
      } else if (value && isFunction(method = value.then)) {
        method.call(value, resolve, reject); // Other non-thenables
      } else {
        // Control `resolve` arguments by letting Array#slice cast boolean `noValue` to integer:
        // * false: [ value ].slice( 0 ) => resolve( value )
        // * true: [ value ].slice( 1 ) => resolve()
        resolve.apply(undefined, [value].slice(noValue));
      } // For Promises/A+, convert exceptions into rejections
      // Since jQuery.when doesn't unwrap thenables, we can skip the extra checks appearing in
      // Deferred#then to conditionally suppress rejection.

    } catch (value) {
      // Support: Android 4.0 only
      // Strict mode functions invoked without .call/.apply get global-object context
      reject.apply(undefined, [value]);
    }
  }

  jQuery.extend({
    Deferred: function Deferred(func) {
      var tuples = [// action, add listener, callbacks,
      // ... .then handlers, argument index, [final state]
      ["notify", "progress", jQuery.Callbacks("memory"), jQuery.Callbacks("memory"), 2], ["resolve", "done", jQuery.Callbacks("once memory"), jQuery.Callbacks("once memory"), 0, "resolved"], ["reject", "fail", jQuery.Callbacks("once memory"), jQuery.Callbacks("once memory"), 1, "rejected"]],
          _state = "pending",
          _promise = {
        state: function state() {
          return _state;
        },
        always: function always() {
          deferred.done(arguments).fail(arguments);
          return this;
        },
        "catch": function _catch(fn) {
          return _promise.then(null, fn);
        },
        // Keep pipe for back-compat
        pipe: function pipe()
        /* fnDone, fnFail, fnProgress */
        {
          var fns = arguments;
          return jQuery.Deferred(function (newDefer) {
            jQuery.each(tuples, function (_i, tuple) {
              // Map tuples (progress, done, fail) to arguments (done, fail, progress)
              var fn = isFunction(fns[tuple[4]]) && fns[tuple[4]]; // deferred.progress(function() { bind to newDefer or newDefer.notify })
              // deferred.done(function() { bind to newDefer or newDefer.resolve })
              // deferred.fail(function() { bind to newDefer or newDefer.reject })

              deferred[tuple[1]](function () {
                var returned = fn && fn.apply(this, arguments);

                if (returned && isFunction(returned.promise)) {
                  returned.promise().progress(newDefer.notify).done(newDefer.resolve).fail(newDefer.reject);
                } else {
                  newDefer[tuple[0] + "With"](this, fn ? [returned] : arguments);
                }
              });
            });
            fns = null;
          }).promise();
        },
        then: function then(onFulfilled, onRejected, onProgress) {
          var maxDepth = 0;

          function resolve(depth, deferred, handler, special) {
            return function () {
              var that = this,
                  args = arguments,
                  mightThrow = function mightThrow() {
                var returned, then; // Support: Promises/A+ section 2.3.3.3.3
                // https://promisesaplus.com/#point-59
                // Ignore double-resolution attempts

                if (depth < maxDepth) {
                  return;
                }

                returned = handler.apply(that, args); // Support: Promises/A+ section 2.3.1
                // https://promisesaplus.com/#point-48

                if (returned === deferred.promise()) {
                  throw new TypeError("Thenable self-resolution");
                } // Support: Promises/A+ sections 2.3.3.1, 3.5
                // https://promisesaplus.com/#point-54
                // https://promisesaplus.com/#point-75
                // Retrieve `then` only once


                then = returned && ( // Support: Promises/A+ section 2.3.4
                // https://promisesaplus.com/#point-64
                // Only check objects and functions for thenability
                _typeof(returned) === "object" || typeof returned === "function") && returned.then; // Handle a returned thenable

                if (isFunction(then)) {
                  // Special processors (notify) just wait for resolution
                  if (special) {
                    then.call(returned, resolve(maxDepth, deferred, Identity, special), resolve(maxDepth, deferred, Thrower, special)); // Normal processors (resolve) also hook into progress
                  } else {
                    // ...and disregard older resolution values
                    maxDepth++;
                    then.call(returned, resolve(maxDepth, deferred, Identity, special), resolve(maxDepth, deferred, Thrower, special), resolve(maxDepth, deferred, Identity, deferred.notifyWith));
                  } // Handle all other returned values

                } else {
                  // Only substitute handlers pass on context
                  // and multiple values (non-spec behavior)
                  if (handler !== Identity) {
                    that = undefined;
                    args = [returned];
                  } // Process the value(s)
                  // Default process is resolve


                  (special || deferred.resolveWith)(that, args);
                }
              },
                  // Only normal processors (resolve) catch and reject exceptions
              process = special ? mightThrow : function () {
                try {
                  mightThrow();
                } catch (e) {
                  if (jQuery.Deferred.exceptionHook) {
                    jQuery.Deferred.exceptionHook(e, process.stackTrace);
                  } // Support: Promises/A+ section 2.3.3.3.4.1
                  // https://promisesaplus.com/#point-61
                  // Ignore post-resolution exceptions


                  if (depth + 1 >= maxDepth) {
                    // Only substitute handlers pass on context
                    // and multiple values (non-spec behavior)
                    if (handler !== Thrower) {
                      that = undefined;
                      args = [e];
                    }

                    deferred.rejectWith(that, args);
                  }
                }
              }; // Support: Promises/A+ section 2.3.3.3.1
              // https://promisesaplus.com/#point-57
              // Re-resolve promises immediately to dodge false rejection from
              // subsequent errors


              if (depth) {
                process();
              } else {
                // Call an optional hook to record the stack, in case of exception
                // since it's otherwise lost when execution goes async
                if (jQuery.Deferred.getStackHook) {
                  process.stackTrace = jQuery.Deferred.getStackHook();
                }

                window.setTimeout(process);
              }
            };
          }

          return jQuery.Deferred(function (newDefer) {
            // progress_handlers.add( ... )
            tuples[0][3].add(resolve(0, newDefer, isFunction(onProgress) ? onProgress : Identity, newDefer.notifyWith)); // fulfilled_handlers.add( ... )

            tuples[1][3].add(resolve(0, newDefer, isFunction(onFulfilled) ? onFulfilled : Identity)); // rejected_handlers.add( ... )

            tuples[2][3].add(resolve(0, newDefer, isFunction(onRejected) ? onRejected : Thrower));
          }).promise();
        },
        // Get a promise for this deferred
        // If obj is provided, the promise aspect is added to the object
        promise: function promise(obj) {
          return obj != null ? jQuery.extend(obj, _promise) : _promise;
        }
      },
          deferred = {}; // Add list-specific methods

      jQuery.each(tuples, function (i, tuple) {
        var list = tuple[2],
            stateString = tuple[5]; // promise.progress = list.add
        // promise.done = list.add
        // promise.fail = list.add

        _promise[tuple[1]] = list.add; // Handle state

        if (stateString) {
          list.add(function () {
            // state = "resolved" (i.e., fulfilled)
            // state = "rejected"
            _state = stateString;
          }, // rejected_callbacks.disable
          // fulfilled_callbacks.disable
          tuples[3 - i][2].disable, // rejected_handlers.disable
          // fulfilled_handlers.disable
          tuples[3 - i][3].disable, // progress_callbacks.lock
          tuples[0][2].lock, // progress_handlers.lock
          tuples[0][3].lock);
        } // progress_handlers.fire
        // fulfilled_handlers.fire
        // rejected_handlers.fire


        list.add(tuple[3].fire); // deferred.notify = function() { deferred.notifyWith(...) }
        // deferred.resolve = function() { deferred.resolveWith(...) }
        // deferred.reject = function() { deferred.rejectWith(...) }

        deferred[tuple[0]] = function () {
          deferred[tuple[0] + "With"](this === deferred ? undefined : this, arguments);
          return this;
        }; // deferred.notifyWith = list.fireWith
        // deferred.resolveWith = list.fireWith
        // deferred.rejectWith = list.fireWith


        deferred[tuple[0] + "With"] = list.fireWith;
      }); // Make the deferred a promise

      _promise.promise(deferred); // Call given func if any


      if (func) {
        func.call(deferred, deferred);
      } // All done!


      return deferred;
    },
    // Deferred helper
    when: function when(singleValue) {
      var // count of uncompleted subordinates
      remaining = arguments.length,
          // count of unprocessed arguments
      i = remaining,
          // subordinate fulfillment data
      resolveContexts = Array(i),
          resolveValues = _slice.call(arguments),
          // the master Deferred
      master = jQuery.Deferred(),
          // subordinate callback factory
      updateFunc = function updateFunc(i) {
        return function (value) {
          resolveContexts[i] = this;
          resolveValues[i] = arguments.length > 1 ? _slice.call(arguments) : value;

          if (! --remaining) {
            master.resolveWith(resolveContexts, resolveValues);
          }
        };
      }; // Single- and empty arguments are adopted like Promise.resolve


      if (remaining <= 1) {
        adoptValue(singleValue, master.done(updateFunc(i)).resolve, master.reject, !remaining); // Use .then() to unwrap secondary thenables (cf. gh-3000)

        if (master.state() === "pending" || isFunction(resolveValues[i] && resolveValues[i].then)) {
          return master.then();
        }
      } // Multiple arguments are aggregated like Promise.all array elements


      while (i--) {
        adoptValue(resolveValues[i], updateFunc(i), master.reject);
      }

      return master.promise();
    }
  }); // These usually indicate a programmer mistake during development,
  // warn about them ASAP rather than swallowing them by default.

  var rerrorNames = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;

  jQuery.Deferred.exceptionHook = function (error, stack) {
    // Support: IE 8 - 9 only
    // Console exists when dev tools are open, which can happen at any time
    if (window.console && window.console.warn && error && rerrorNames.test(error.name)) {
      window.console.warn("jQuery.Deferred exception: " + error.message, error.stack, stack);
    }
  };

  jQuery.readyException = function (error) {
    window.setTimeout(function () {
      throw error;
    });
  }; // The deferred used on DOM ready


  var readyList = jQuery.Deferred();

  jQuery.fn.ready = function (fn) {
    readyList.then(fn) // Wrap jQuery.readyException in a function so that the lookup
    // happens at the time of error handling instead of callback
    // registration.
    ["catch"](function (error) {
      jQuery.readyException(error);
    });
    return this;
  };

  jQuery.extend({
    // Is the DOM ready to be used? Set to true once it occurs.
    isReady: false,
    // A counter to track how many items to wait for before
    // the ready event fires. See #6781
    readyWait: 1,
    // Handle when the DOM is ready
    ready: function ready(wait) {
      // Abort if there are pending holds or we're already ready
      if (wait === true ? --jQuery.readyWait : jQuery.isReady) {
        return;
      } // Remember that the DOM is ready


      jQuery.isReady = true; // If a normal DOM Ready event fired, decrement, and wait if need be

      if (wait !== true && --jQuery.readyWait > 0) {
        return;
      } // If there are functions bound, to execute


      readyList.resolveWith(document, [jQuery]);
    }
  });
  jQuery.ready.then = readyList.then; // The ready event handler and self cleanup method

  function completed() {
    document.removeEventListener("DOMContentLoaded", completed);
    window.removeEventListener("load", completed);
    jQuery.ready();
  } // Catch cases where $(document).ready() is called
  // after the browser event has already occurred.
  // Support: IE <=9 - 10 only
  // Older IE sometimes signals "interactive" too soon


  if (document.readyState === "complete" || document.readyState !== "loading" && !document.documentElement.doScroll) {
    // Handle it asynchronously to allow scripts the opportunity to delay ready
    window.setTimeout(jQuery.ready);
  } else {
    // Use the handy event callback
    document.addEventListener("DOMContentLoaded", completed); // A fallback to window.onload, that will always work

    window.addEventListener("load", completed);
  } // Multifunctional method to get and set values of a collection
  // The value/s can optionally be executed if it's a function


  var access = function access(elems, fn, key, value, chainable, emptyGet, raw) {
    var i = 0,
        len = elems.length,
        bulk = key == null; // Sets many values

    if (toType(key) === "object") {
      chainable = true;

      for (i in key) {
        access(elems, fn, i, key[i], true, emptyGet, raw);
      } // Sets one value

    } else if (value !== undefined) {
      chainable = true;

      if (!isFunction(value)) {
        raw = true;
      }

      if (bulk) {
        // Bulk operations run against the entire set
        if (raw) {
          fn.call(elems, value);
          fn = null; // ...except when executing function values
        } else {
          bulk = fn;

          fn = function fn(elem, _key, value) {
            return bulk.call(jQuery(elem), value);
          };
        }
      }

      if (fn) {
        for (; i < len; i++) {
          fn(elems[i], key, raw ? value : value.call(elems[i], i, fn(elems[i], key)));
        }
      }
    }

    if (chainable) {
      return elems;
    } // Gets


    if (bulk) {
      return fn.call(elems);
    }

    return len ? fn(elems[0], key) : emptyGet;
  }; // Matches dashed string for camelizing


  var rmsPrefix = /^-ms-/,
      rdashAlpha = /-([a-z])/g; // Used by camelCase as callback to replace()

  function fcamelCase(_all, letter) {
    return letter.toUpperCase();
  } // Convert dashed to camelCase; used by the css and data modules
  // Support: IE <=9 - 11, Edge 12 - 15
  // Microsoft forgot to hump their vendor prefix (#9572)


  function camelCase(string) {
    return string.replace(rmsPrefix, "ms-").replace(rdashAlpha, fcamelCase);
  }

  var acceptData = function acceptData(owner) {
    // Accepts only:
    //  - Node
    //    - Node.ELEMENT_NODE
    //    - Node.DOCUMENT_NODE
    //  - Object
    //    - Any
    return owner.nodeType === 1 || owner.nodeType === 9 || !+owner.nodeType;
  };

  function Data() {
    this.expando = jQuery.expando + Data.uid++;
  }

  Data.uid = 1;
  Data.prototype = {
    cache: function cache(owner) {
      // Check if the owner object already has a cache
      var value = owner[this.expando]; // If not, create one

      if (!value) {
        value = {}; // We can accept data for non-element nodes in modern browsers,
        // but we should not, see #8335.
        // Always return an empty object.

        if (acceptData(owner)) {
          // If it is a node unlikely to be stringify-ed or looped over
          // use plain assignment
          if (owner.nodeType) {
            owner[this.expando] = value; // Otherwise secure it in a non-enumerable property
            // configurable must be true to allow the property to be
            // deleted when data is removed
          } else {
            Object.defineProperty(owner, this.expando, {
              value: value,
              configurable: true
            });
          }
        }
      }

      return value;
    },
    set: function set(owner, data, value) {
      var prop,
          cache = this.cache(owner); // Handle: [ owner, key, value ] args
      // Always use camelCase key (gh-2257)

      if (typeof data === "string") {
        cache[camelCase(data)] = value; // Handle: [ owner, { properties } ] args
      } else {
        // Copy the properties one-by-one to the cache object
        for (prop in data) {
          cache[camelCase(prop)] = data[prop];
        }
      }

      return cache;
    },
    get: function get(owner, key) {
      return key === undefined ? this.cache(owner) : // Always use camelCase key (gh-2257)
      owner[this.expando] && owner[this.expando][camelCase(key)];
    },
    access: function access(owner, key, value) {
      // In cases where either:
      //
      //   1. No key was specified
      //   2. A string key was specified, but no value provided
      //
      // Take the "read" path and allow the get method to determine
      // which value to return, respectively either:
      //
      //   1. The entire cache object
      //   2. The data stored at the key
      //
      if (key === undefined || key && typeof key === "string" && value === undefined) {
        return this.get(owner, key);
      } // When the key is not a string, or both a key and value
      // are specified, set or extend (existing objects) with either:
      //
      //   1. An object of properties
      //   2. A key and value
      //


      this.set(owner, key, value); // Since the "set" path can have two possible entry points
      // return the expected data based on which path was taken[*]

      return value !== undefined ? value : key;
    },
    remove: function remove(owner, key) {
      var i,
          cache = owner[this.expando];

      if (cache === undefined) {
        return;
      }

      if (key !== undefined) {
        // Support array or space separated string of keys
        if (Array.isArray(key)) {
          // If key is an array of keys...
          // We always set camelCase keys, so remove that.
          key = key.map(camelCase);
        } else {
          key = camelCase(key); // If a key with the spaces exists, use it.
          // Otherwise, create an array by matching non-whitespace

          key = key in cache ? [key] : key.match(rnothtmlwhite) || [];
        }

        i = key.length;

        while (i--) {
          delete cache[key[i]];
        }
      } // Remove the expando if there's no more data


      if (key === undefined || jQuery.isEmptyObject(cache)) {
        // Support: Chrome <=35 - 45
        // Webkit & Blink performance suffers when deleting properties
        // from DOM nodes, so set to undefined instead
        // https://bugs.chromium.org/p/chromium/issues/detail?id=378607 (bug restricted)
        if (owner.nodeType) {
          owner[this.expando] = undefined;
        } else {
          delete owner[this.expando];
        }
      }
    },
    hasData: function hasData(owner) {
      var cache = owner[this.expando];
      return cache !== undefined && !jQuery.isEmptyObject(cache);
    }
  };
  var dataPriv = new Data();
  var dataUser = new Data(); //	Implementation Summary
  //
  //	1. Enforce API surface and semantic compatibility with 1.9.x branch
  //	2. Improve the module's maintainability by reducing the storage
  //		paths to a single mechanism.
  //	3. Use the same single mechanism to support "private" and "user" data.
  //	4. _Never_ expose "private" data to user code (TODO: Drop _data, _removeData)
  //	5. Avoid exposing implementation details on user objects (eg. expando properties)
  //	6. Provide a clear path for implementation upgrade to WeakMap in 2014

  var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
      rmultiDash = /[A-Z]/g;

  function getData(data) {
    if (data === "true") {
      return true;
    }

    if (data === "false") {
      return false;
    }

    if (data === "null") {
      return null;
    } // Only convert to a number if it doesn't change the string


    if (data === +data + "") {
      return +data;
    }

    if (rbrace.test(data)) {
      return JSON.parse(data);
    }

    return data;
  }

  function dataAttr(elem, key, data) {
    var name; // If nothing was found internally, try to fetch any
    // data from the HTML5 data-* attribute

    if (data === undefined && elem.nodeType === 1) {
      name = "data-" + key.replace(rmultiDash, "-$&").toLowerCase();
      data = elem.getAttribute(name);

      if (typeof data === "string") {
        try {
          data = getData(data);
        } catch (e) {} // Make sure we set the data so it isn't changed later


        dataUser.set(elem, key, data);
      } else {
        data = undefined;
      }
    }

    return data;
  }

  jQuery.extend({
    hasData: function hasData(elem) {
      return dataUser.hasData(elem) || dataPriv.hasData(elem);
    },
    data: function data(elem, name, _data) {
      return dataUser.access(elem, name, _data);
    },
    removeData: function removeData(elem, name) {
      dataUser.remove(elem, name);
    },
    // TODO: Now that all calls to _data and _removeData have been replaced
    // with direct calls to dataPriv methods, these can be deprecated.
    _data: function _data(elem, name, data) {
      return dataPriv.access(elem, name, data);
    },
    _removeData: function _removeData(elem, name) {
      dataPriv.remove(elem, name);
    }
  });
  jQuery.fn.extend({
    data: function data(key, value) {
      var i,
          name,
          data,
          elem = this[0],
          attrs = elem && elem.attributes; // Gets all values

      if (key === undefined) {
        if (this.length) {
          data = dataUser.get(elem);

          if (elem.nodeType === 1 && !dataPriv.get(elem, "hasDataAttrs")) {
            i = attrs.length;

            while (i--) {
              // Support: IE 11 only
              // The attrs elements can be null (#14894)
              if (attrs[i]) {
                name = attrs[i].name;

                if (name.indexOf("data-") === 0) {
                  name = camelCase(name.slice(5));
                  dataAttr(elem, name, data[name]);
                }
              }
            }

            dataPriv.set(elem, "hasDataAttrs", true);
          }
        }

        return data;
      } // Sets multiple values


      if (_typeof(key) === "object") {
        return this.each(function () {
          dataUser.set(this, key);
        });
      }

      return access(this, function (value) {
        var data; // The calling jQuery object (element matches) is not empty
        // (and therefore has an element appears at this[ 0 ]) and the
        // `value` parameter was not undefined. An empty jQuery object
        // will result in `undefined` for elem = this[ 0 ] which will
        // throw an exception if an attempt to read a data cache is made.

        if (elem && value === undefined) {
          // Attempt to get data from the cache
          // The key will always be camelCased in Data
          data = dataUser.get(elem, key);

          if (data !== undefined) {
            return data;
          } // Attempt to "discover" the data in
          // HTML5 custom data-* attrs


          data = dataAttr(elem, key);

          if (data !== undefined) {
            return data;
          } // We tried really hard, but the data doesn't exist.


          return;
        } // Set the data...


        this.each(function () {
          // We always store the camelCased key
          dataUser.set(this, key, value);
        });
      }, null, value, arguments.length > 1, null, true);
    },
    removeData: function removeData(key) {
      return this.each(function () {
        dataUser.remove(this, key);
      });
    }
  });
  jQuery.extend({
    queue: function queue(elem, type, data) {
      var queue;

      if (elem) {
        type = (type || "fx") + "queue";
        queue = dataPriv.get(elem, type); // Speed up dequeue by getting out quickly if this is just a lookup

        if (data) {
          if (!queue || Array.isArray(data)) {
            queue = dataPriv.access(elem, type, jQuery.makeArray(data));
          } else {
            queue.push(data);
          }
        }

        return queue || [];
      }
    },
    dequeue: function dequeue(elem, type) {
      type = type || "fx";

      var queue = jQuery.queue(elem, type),
          startLength = queue.length,
          fn = queue.shift(),
          hooks = jQuery._queueHooks(elem, type),
          next = function next() {
        jQuery.dequeue(elem, type);
      }; // If the fx queue is dequeued, always remove the progress sentinel


      if (fn === "inprogress") {
        fn = queue.shift();
        startLength--;
      }

      if (fn) {
        // Add a progress sentinel to prevent the fx queue from being
        // automatically dequeued
        if (type === "fx") {
          queue.unshift("inprogress");
        } // Clear up the last queue stop function


        delete hooks.stop;
        fn.call(elem, next, hooks);
      }

      if (!startLength && hooks) {
        hooks.empty.fire();
      }
    },
    // Not public - generate a queueHooks object, or return the current one
    _queueHooks: function _queueHooks(elem, type) {
      var key = type + "queueHooks";
      return dataPriv.get(elem, key) || dataPriv.access(elem, key, {
        empty: jQuery.Callbacks("once memory").add(function () {
          dataPriv.remove(elem, [type + "queue", key]);
        })
      });
    }
  });
  jQuery.fn.extend({
    queue: function queue(type, data) {
      var setter = 2;

      if (typeof type !== "string") {
        data = type;
        type = "fx";
        setter--;
      }

      if (arguments.length < setter) {
        return jQuery.queue(this[0], type);
      }

      return data === undefined ? this : this.each(function () {
        var queue = jQuery.queue(this, type, data); // Ensure a hooks for this queue

        jQuery._queueHooks(this, type);

        if (type === "fx" && queue[0] !== "inprogress") {
          jQuery.dequeue(this, type);
        }
      });
    },
    dequeue: function dequeue(type) {
      return this.each(function () {
        jQuery.dequeue(this, type);
      });
    },
    clearQueue: function clearQueue(type) {
      return this.queue(type || "fx", []);
    },
    // Get a promise resolved when queues of a certain type
    // are emptied (fx is the type by default)
    promise: function promise(type, obj) {
      var tmp,
          count = 1,
          defer = jQuery.Deferred(),
          elements = this,
          i = this.length,
          resolve = function resolve() {
        if (! --count) {
          defer.resolveWith(elements, [elements]);
        }
      };

      if (typeof type !== "string") {
        obj = type;
        type = undefined;
      }

      type = type || "fx";

      while (i--) {
        tmp = dataPriv.get(elements[i], type + "queueHooks");

        if (tmp && tmp.empty) {
          count++;
          tmp.empty.add(resolve);
        }
      }

      resolve();
      return defer.promise(obj);
    }
  });
  var pnum = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source;
  var rcssNum = new RegExp("^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i");
  var cssExpand = ["Top", "Right", "Bottom", "Left"];
  var documentElement = document.documentElement;

  var isAttached = function isAttached(elem) {
    return jQuery.contains(elem.ownerDocument, elem);
  },
      composed = {
    composed: true
  }; // Support: IE 9 - 11+, Edge 12 - 18+, iOS 10.0 - 10.2 only
  // Check attachment across shadow DOM boundaries when possible (gh-3504)
  // Support: iOS 10.0-10.2 only
  // Early iOS 10 versions support `attachShadow` but not `getRootNode`,
  // leading to errors. We need to check for `getRootNode`.


  if (documentElement.getRootNode) {
    isAttached = function isAttached(elem) {
      return jQuery.contains(elem.ownerDocument, elem) || elem.getRootNode(composed) === elem.ownerDocument;
    };
  }

  var isHiddenWithinTree = function isHiddenWithinTree(elem, el) {
    // isHiddenWithinTree might be called from jQuery#filter function;
    // in that case, element will be second argument
    elem = el || elem; // Inline style trumps all

    return elem.style.display === "none" || elem.style.display === "" && // Otherwise, check computed style
    // Support: Firefox <=43 - 45
    // Disconnected elements can have computed display: none, so first confirm that elem is
    // in the document.
    isAttached(elem) && jQuery.css(elem, "display") === "none";
  };

  function adjustCSS(elem, prop, valueParts, tween) {
    var adjusted,
        scale,
        maxIterations = 20,
        currentValue = tween ? function () {
      return tween.cur();
    } : function () {
      return jQuery.css(elem, prop, "");
    },
        initial = currentValue(),
        unit = valueParts && valueParts[3] || (jQuery.cssNumber[prop] ? "" : "px"),
        // Starting value computation is required for potential unit mismatches
    initialInUnit = elem.nodeType && (jQuery.cssNumber[prop] || unit !== "px" && +initial) && rcssNum.exec(jQuery.css(elem, prop));

    if (initialInUnit && initialInUnit[3] !== unit) {
      // Support: Firefox <=54
      // Halve the iteration target value to prevent interference from CSS upper bounds (gh-2144)
      initial = initial / 2; // Trust units reported by jQuery.css

      unit = unit || initialInUnit[3]; // Iteratively approximate from a nonzero starting point

      initialInUnit = +initial || 1;

      while (maxIterations--) {
        // Evaluate and update our best guess (doubling guesses that zero out).
        // Finish if the scale equals or crosses 1 (making the old*new product non-positive).
        jQuery.style(elem, prop, initialInUnit + unit);

        if ((1 - scale) * (1 - (scale = currentValue() / initial || 0.5)) <= 0) {
          maxIterations = 0;
        }

        initialInUnit = initialInUnit / scale;
      }

      initialInUnit = initialInUnit * 2;
      jQuery.style(elem, prop, initialInUnit + unit); // Make sure we update the tween properties later on

      valueParts = valueParts || [];
    }

    if (valueParts) {
      initialInUnit = +initialInUnit || +initial || 0; // Apply relative offset (+=/-=) if specified

      adjusted = valueParts[1] ? initialInUnit + (valueParts[1] + 1) * valueParts[2] : +valueParts[2];

      if (tween) {
        tween.unit = unit;
        tween.start = initialInUnit;
        tween.end = adjusted;
      }
    }

    return adjusted;
  }

  var defaultDisplayMap = {};

  function getDefaultDisplay(elem) {
    var temp,
        doc = elem.ownerDocument,
        nodeName = elem.nodeName,
        display = defaultDisplayMap[nodeName];

    if (display) {
      return display;
    }

    temp = doc.body.appendChild(doc.createElement(nodeName));
    display = jQuery.css(temp, "display");
    temp.parentNode.removeChild(temp);

    if (display === "none") {
      display = "block";
    }

    defaultDisplayMap[nodeName] = display;
    return display;
  }

  function showHide(elements, show) {
    var display,
        elem,
        values = [],
        index = 0,
        length = elements.length; // Determine new display value for elements that need to change

    for (; index < length; index++) {
      elem = elements[index];

      if (!elem.style) {
        continue;
      }

      display = elem.style.display;

      if (show) {
        // Since we force visibility upon cascade-hidden elements, an immediate (and slow)
        // check is required in this first loop unless we have a nonempty display value (either
        // inline or about-to-be-restored)
        if (display === "none") {
          values[index] = dataPriv.get(elem, "display") || null;

          if (!values[index]) {
            elem.style.display = "";
          }
        }

        if (elem.style.display === "" && isHiddenWithinTree(elem)) {
          values[index] = getDefaultDisplay(elem);
        }
      } else {
        if (display !== "none") {
          values[index] = "none"; // Remember what we're overwriting

          dataPriv.set(elem, "display", display);
        }
      }
    } // Set the display of the elements in a second loop to avoid constant reflow


    for (index = 0; index < length; index++) {
      if (values[index] != null) {
        elements[index].style.display = values[index];
      }
    }

    return elements;
  }

  jQuery.fn.extend({
    show: function show() {
      return showHide(this, true);
    },
    hide: function hide() {
      return showHide(this);
    },
    toggle: function toggle(state) {
      if (typeof state === "boolean") {
        return state ? this.show() : this.hide();
      }

      return this.each(function () {
        if (isHiddenWithinTree(this)) {
          jQuery(this).show();
        } else {
          jQuery(this).hide();
        }
      });
    }
  });
  var rcheckableType = /^(?:checkbox|radio)$/i;
  var rtagName = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i;
  var rscriptType = /^$|^module$|\/(?:java|ecma)script/i;

  (function () {
    var fragment = document.createDocumentFragment(),
        div = fragment.appendChild(document.createElement("div")),
        input = document.createElement("input"); // Support: Android 4.0 - 4.3 only
    // Check state lost if the name is set (#11217)
    // Support: Windows Web Apps (WWA)
    // `name` and `type` must use .setAttribute for WWA (#14901)

    input.setAttribute("type", "radio");
    input.setAttribute("checked", "checked");
    input.setAttribute("name", "t");
    div.appendChild(input); // Support: Android <=4.1 only
    // Older WebKit doesn't clone checked state correctly in fragments

    support.checkClone = div.cloneNode(true).cloneNode(true).lastChild.checked; // Support: IE <=11 only
    // Make sure textarea (and checkbox) defaultValue is properly cloned

    div.innerHTML = "<textarea>x</textarea>";
    support.noCloneChecked = !!div.cloneNode(true).lastChild.defaultValue; // Support: IE <=9 only
    // IE <=9 replaces <option> tags with their contents when inserted outside of
    // the select element.

    div.innerHTML = "<option></option>";
    support.option = !!div.lastChild;
  })(); // We have to close these tags to support XHTML (#13200)


  var wrapMap = {
    // XHTML parsers do not magically insert elements in the
    // same way that tag soup parsers do. So we cannot shorten
    // this by omitting <tbody> or other required elements.
    thead: [1, "<table>", "</table>"],
    col: [2, "<table><colgroup>", "</colgroup></table>"],
    tr: [2, "<table><tbody>", "</tbody></table>"],
    td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
    _default: [0, "", ""]
  };
  wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
  wrapMap.th = wrapMap.td; // Support: IE <=9 only

  if (!support.option) {
    wrapMap.optgroup = wrapMap.option = [1, "<select multiple='multiple'>", "</select>"];
  }

  function getAll(context, tag) {
    // Support: IE <=9 - 11 only
    // Use typeof to avoid zero-argument method invocation on host objects (#15151)
    var ret;

    if (typeof context.getElementsByTagName !== "undefined") {
      ret = context.getElementsByTagName(tag || "*");
    } else if (typeof context.querySelectorAll !== "undefined") {
      ret = context.querySelectorAll(tag || "*");
    } else {
      ret = [];
    }

    if (tag === undefined || tag && nodeName(context, tag)) {
      return jQuery.merge([context], ret);
    }

    return ret;
  } // Mark scripts as having already been evaluated


  function setGlobalEval(elems, refElements) {
    var i = 0,
        l = elems.length;

    for (; i < l; i++) {
      dataPriv.set(elems[i], "globalEval", !refElements || dataPriv.get(refElements[i], "globalEval"));
    }
  }

  var rhtml = /<|&#?\w+;/;

  function buildFragment(elems, context, scripts, selection, ignored) {
    var elem,
        tmp,
        tag,
        wrap,
        attached,
        j,
        fragment = context.createDocumentFragment(),
        nodes = [],
        i = 0,
        l = elems.length;

    for (; i < l; i++) {
      elem = elems[i];

      if (elem || elem === 0) {
        // Add nodes directly
        if (toType(elem) === "object") {
          // Support: Android <=4.0 only, PhantomJS 1 only
          // push.apply(_, arraylike) throws on ancient WebKit
          jQuery.merge(nodes, elem.nodeType ? [elem] : elem); // Convert non-html into a text node
        } else if (!rhtml.test(elem)) {
          nodes.push(context.createTextNode(elem)); // Convert html into DOM nodes
        } else {
          tmp = tmp || fragment.appendChild(context.createElement("div")); // Deserialize a standard representation

          tag = (rtagName.exec(elem) || ["", ""])[1].toLowerCase();
          wrap = wrapMap[tag] || wrapMap._default;
          tmp.innerHTML = wrap[1] + jQuery.htmlPrefilter(elem) + wrap[2]; // Descend through wrappers to the right content

          j = wrap[0];

          while (j--) {
            tmp = tmp.lastChild;
          } // Support: Android <=4.0 only, PhantomJS 1 only
          // push.apply(_, arraylike) throws on ancient WebKit


          jQuery.merge(nodes, tmp.childNodes); // Remember the top-level container

          tmp = fragment.firstChild; // Ensure the created nodes are orphaned (#12392)

          tmp.textContent = "";
        }
      }
    } // Remove wrapper from fragment


    fragment.textContent = "";
    i = 0;

    while (elem = nodes[i++]) {
      // Skip elements already in the context collection (trac-4087)
      if (selection && jQuery.inArray(elem, selection) > -1) {
        if (ignored) {
          ignored.push(elem);
        }

        continue;
      }

      attached = isAttached(elem); // Append to fragment

      tmp = getAll(fragment.appendChild(elem), "script"); // Preserve script evaluation history

      if (attached) {
        setGlobalEval(tmp);
      } // Capture executables


      if (scripts) {
        j = 0;

        while (elem = tmp[j++]) {
          if (rscriptType.test(elem.type || "")) {
            scripts.push(elem);
          }
        }
      }
    }

    return fragment;
  }

  var rkeyEvent = /^key/,
      rmouseEvent = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
      rtypenamespace = /^([^.]*)(?:\.(.+)|)/;

  function returnTrue() {
    return true;
  }

  function returnFalse() {
    return false;
  } // Support: IE <=9 - 11+
  // focus() and blur() are asynchronous, except when they are no-op.
  // So expect focus to be synchronous when the element is already active,
  // and blur to be synchronous when the element is not already active.
  // (focus and blur are always synchronous in other supported browsers,
  // this just defines when we can count on it).


  function expectSync(elem, type) {
    return elem === safeActiveElement() === (type === "focus");
  } // Support: IE <=9 only
  // Accessing document.activeElement can throw unexpectedly
  // https://bugs.jquery.com/ticket/13393


  function safeActiveElement() {
    try {
      return document.activeElement;
    } catch (err) {}
  }

  function _on(elem, types, selector, data, fn, one) {
    var origFn, type; // Types can be a map of types/handlers

    if (_typeof(types) === "object") {
      // ( types-Object, selector, data )
      if (typeof selector !== "string") {
        // ( types-Object, data )
        data = data || selector;
        selector = undefined;
      }

      for (type in types) {
        _on(elem, type, selector, data, types[type], one);
      }

      return elem;
    }

    if (data == null && fn == null) {
      // ( types, fn )
      fn = selector;
      data = selector = undefined;
    } else if (fn == null) {
      if (typeof selector === "string") {
        // ( types, selector, fn )
        fn = data;
        data = undefined;
      } else {
        // ( types, data, fn )
        fn = data;
        data = selector;
        selector = undefined;
      }
    }

    if (fn === false) {
      fn = returnFalse;
    } else if (!fn) {
      return elem;
    }

    if (one === 1) {
      origFn = fn;

      fn = function fn(event) {
        // Can use an empty set, since event contains the info
        jQuery().off(event);
        return origFn.apply(this, arguments);
      }; // Use same guid so caller can remove using origFn


      fn.guid = origFn.guid || (origFn.guid = jQuery.guid++);
    }

    return elem.each(function () {
      jQuery.event.add(this, types, fn, data, selector);
    });
  }
  /*
   * Helper functions for managing events -- not part of the public interface.
   * Props to Dean Edwards' addEvent library for many of the ideas.
   */


  jQuery.event = {
    global: {},
    add: function add(elem, types, handler, data, selector) {
      var handleObjIn,
          eventHandle,
          tmp,
          events,
          t,
          handleObj,
          special,
          handlers,
          type,
          namespaces,
          origType,
          elemData = dataPriv.get(elem); // Only attach events to objects that accept data

      if (!acceptData(elem)) {
        return;
      } // Caller can pass in an object of custom data in lieu of the handler


      if (handler.handler) {
        handleObjIn = handler;
        handler = handleObjIn.handler;
        selector = handleObjIn.selector;
      } // Ensure that invalid selectors throw exceptions at attach time
      // Evaluate against documentElement in case elem is a non-element node (e.g., document)


      if (selector) {
        jQuery.find.matchesSelector(documentElement, selector);
      } // Make sure that the handler has a unique ID, used to find/remove it later


      if (!handler.guid) {
        handler.guid = jQuery.guid++;
      } // Init the element's event structure and main handler, if this is the first


      if (!(events = elemData.events)) {
        events = elemData.events = Object.create(null);
      }

      if (!(eventHandle = elemData.handle)) {
        eventHandle = elemData.handle = function (e) {
          // Discard the second event of a jQuery.event.trigger() and
          // when an event is called after a page has unloaded
          return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ? jQuery.event.dispatch.apply(elem, arguments) : undefined;
        };
      } // Handle multiple events separated by a space


      types = (types || "").match(rnothtmlwhite) || [""];
      t = types.length;

      while (t--) {
        tmp = rtypenamespace.exec(types[t]) || [];
        type = origType = tmp[1];
        namespaces = (tmp[2] || "").split(".").sort(); // There *must* be a type, no attaching namespace-only handlers

        if (!type) {
          continue;
        } // If event changes its type, use the special event handlers for the changed type


        special = jQuery.event.special[type] || {}; // If selector defined, determine special event api type, otherwise given type

        type = (selector ? special.delegateType : special.bindType) || type; // Update special based on newly reset type

        special = jQuery.event.special[type] || {}; // handleObj is passed to all event handlers

        handleObj = jQuery.extend({
          type: type,
          origType: origType,
          data: data,
          handler: handler,
          guid: handler.guid,
          selector: selector,
          needsContext: selector && jQuery.expr.match.needsContext.test(selector),
          namespace: namespaces.join(".")
        }, handleObjIn); // Init the event handler queue if we're the first

        if (!(handlers = events[type])) {
          handlers = events[type] = [];
          handlers.delegateCount = 0; // Only use addEventListener if the special events handler returns false

          if (!special.setup || special.setup.call(elem, data, namespaces, eventHandle) === false) {
            if (elem.addEventListener) {
              elem.addEventListener(type, eventHandle);
            }
          }
        }

        if (special.add) {
          special.add.call(elem, handleObj);

          if (!handleObj.handler.guid) {
            handleObj.handler.guid = handler.guid;
          }
        } // Add to the element's handler list, delegates in front


        if (selector) {
          handlers.splice(handlers.delegateCount++, 0, handleObj);
        } else {
          handlers.push(handleObj);
        } // Keep track of which events have ever been used, for event optimization


        jQuery.event.global[type] = true;
      }
    },
    // Detach an event or set of events from an element
    remove: function remove(elem, types, handler, selector, mappedTypes) {
      var j,
          origCount,
          tmp,
          events,
          t,
          handleObj,
          special,
          handlers,
          type,
          namespaces,
          origType,
          elemData = dataPriv.hasData(elem) && dataPriv.get(elem);

      if (!elemData || !(events = elemData.events)) {
        return;
      } // Once for each type.namespace in types; type may be omitted


      types = (types || "").match(rnothtmlwhite) || [""];
      t = types.length;

      while (t--) {
        tmp = rtypenamespace.exec(types[t]) || [];
        type = origType = tmp[1];
        namespaces = (tmp[2] || "").split(".").sort(); // Unbind all events (on this namespace, if provided) for the element

        if (!type) {
          for (type in events) {
            jQuery.event.remove(elem, type + types[t], handler, selector, true);
          }

          continue;
        }

        special = jQuery.event.special[type] || {};
        type = (selector ? special.delegateType : special.bindType) || type;
        handlers = events[type] || [];
        tmp = tmp[2] && new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)"); // Remove matching events

        origCount = j = handlers.length;

        while (j--) {
          handleObj = handlers[j];

          if ((mappedTypes || origType === handleObj.origType) && (!handler || handler.guid === handleObj.guid) && (!tmp || tmp.test(handleObj.namespace)) && (!selector || selector === handleObj.selector || selector === "**" && handleObj.selector)) {
            handlers.splice(j, 1);

            if (handleObj.selector) {
              handlers.delegateCount--;
            }

            if (special.remove) {
              special.remove.call(elem, handleObj);
            }
          }
        } // Remove generic event handler if we removed something and no more handlers exist
        // (avoids potential for endless recursion during removal of special event handlers)


        if (origCount && !handlers.length) {
          if (!special.teardown || special.teardown.call(elem, namespaces, elemData.handle) === false) {
            jQuery.removeEvent(elem, type, elemData.handle);
          }

          delete events[type];
        }
      } // Remove data and the expando if it's no longer used


      if (jQuery.isEmptyObject(events)) {
        dataPriv.remove(elem, "handle events");
      }
    },
    dispatch: function dispatch(nativeEvent) {
      var i,
          j,
          ret,
          matched,
          handleObj,
          handlerQueue,
          args = new Array(arguments.length),
          // Make a writable jQuery.Event from the native event object
      event = jQuery.event.fix(nativeEvent),
          handlers = (dataPriv.get(this, "events") || Object.create(null))[event.type] || [],
          special = jQuery.event.special[event.type] || {}; // Use the fix-ed jQuery.Event rather than the (read-only) native event

      args[0] = event;

      for (i = 1; i < arguments.length; i++) {
        args[i] = arguments[i];
      }

      event.delegateTarget = this; // Call the preDispatch hook for the mapped type, and let it bail if desired

      if (special.preDispatch && special.preDispatch.call(this, event) === false) {
        return;
      } // Determine handlers


      handlerQueue = jQuery.event.handlers.call(this, event, handlers); // Run delegates first; they may want to stop propagation beneath us

      i = 0;

      while ((matched = handlerQueue[i++]) && !event.isPropagationStopped()) {
        event.currentTarget = matched.elem;
        j = 0;

        while ((handleObj = matched.handlers[j++]) && !event.isImmediatePropagationStopped()) {
          // If the event is namespaced, then each handler is only invoked if it is
          // specially universal or its namespaces are a superset of the event's.
          if (!event.rnamespace || handleObj.namespace === false || event.rnamespace.test(handleObj.namespace)) {
            event.handleObj = handleObj;
            event.data = handleObj.data;
            ret = ((jQuery.event.special[handleObj.origType] || {}).handle || handleObj.handler).apply(matched.elem, args);

            if (ret !== undefined) {
              if ((event.result = ret) === false) {
                event.preventDefault();
                event.stopPropagation();
              }
            }
          }
        }
      } // Call the postDispatch hook for the mapped type


      if (special.postDispatch) {
        special.postDispatch.call(this, event);
      }

      return event.result;
    },
    handlers: function handlers(event, _handlers) {
      var i,
          handleObj,
          sel,
          matchedHandlers,
          matchedSelectors,
          handlerQueue = [],
          delegateCount = _handlers.delegateCount,
          cur = event.target; // Find delegate handlers

      if (delegateCount && // Support: IE <=9
      // Black-hole SVG <use> instance trees (trac-13180)
      cur.nodeType && // Support: Firefox <=42
      // Suppress spec-violating clicks indicating a non-primary pointer button (trac-3861)
      // https://www.w3.org/TR/DOM-Level-3-Events/#event-type-click
      // Support: IE 11 only
      // ...but not arrow key "clicks" of radio inputs, which can have `button` -1 (gh-2343)
      !(event.type === "click" && event.button >= 1)) {
        for (; cur !== this; cur = cur.parentNode || this) {
          // Don't check non-elements (#13208)
          // Don't process clicks on disabled elements (#6911, #8165, #11382, #11764)
          if (cur.nodeType === 1 && !(event.type === "click" && cur.disabled === true)) {
            matchedHandlers = [];
            matchedSelectors = {};

            for (i = 0; i < delegateCount; i++) {
              handleObj = _handlers[i]; // Don't conflict with Object.prototype properties (#13203)

              sel = handleObj.selector + " ";

              if (matchedSelectors[sel] === undefined) {
                matchedSelectors[sel] = handleObj.needsContext ? jQuery(sel, this).index(cur) > -1 : jQuery.find(sel, this, null, [cur]).length;
              }

              if (matchedSelectors[sel]) {
                matchedHandlers.push(handleObj);
              }
            }

            if (matchedHandlers.length) {
              handlerQueue.push({
                elem: cur,
                handlers: matchedHandlers
              });
            }
          }
        }
      } // Add the remaining (directly-bound) handlers


      cur = this;

      if (delegateCount < _handlers.length) {
        handlerQueue.push({
          elem: cur,
          handlers: _handlers.slice(delegateCount)
        });
      }

      return handlerQueue;
    },
    addProp: function addProp(name, hook) {
      Object.defineProperty(jQuery.Event.prototype, name, {
        enumerable: true,
        configurable: true,
        get: isFunction(hook) ? function () {
          if (this.originalEvent) {
            return hook(this.originalEvent);
          }
        } : function () {
          if (this.originalEvent) {
            return this.originalEvent[name];
          }
        },
        set: function set(value) {
          Object.defineProperty(this, name, {
            enumerable: true,
            configurable: true,
            writable: true,
            value: value
          });
        }
      });
    },
    fix: function fix(originalEvent) {
      return originalEvent[jQuery.expando] ? originalEvent : new jQuery.Event(originalEvent);
    },
    special: {
      load: {
        // Prevent triggered image.load events from bubbling to window.load
        noBubble: true
      },
      click: {
        // Utilize native event to ensure correct state for checkable inputs
        setup: function setup(data) {
          // For mutual compressibility with _default, replace `this` access with a local var.
          // `|| data` is dead code meant only to preserve the variable through minification.
          var el = this || data; // Claim the first handler

          if (rcheckableType.test(el.type) && el.click && nodeName(el, "input")) {
            // dataPriv.set( el, "click", ... )
            leverageNative(el, "click", returnTrue);
          } // Return false to allow normal processing in the caller


          return false;
        },
        trigger: function trigger(data) {
          // For mutual compressibility with _default, replace `this` access with a local var.
          // `|| data` is dead code meant only to preserve the variable through minification.
          var el = this || data; // Force setup before triggering a click

          if (rcheckableType.test(el.type) && el.click && nodeName(el, "input")) {
            leverageNative(el, "click");
          } // Return non-false to allow normal event-path propagation


          return true;
        },
        // For cross-browser consistency, suppress native .click() on links
        // Also prevent it if we're currently inside a leveraged native-event stack
        _default: function _default(event) {
          var target = event.target;
          return rcheckableType.test(target.type) && target.click && nodeName(target, "input") && dataPriv.get(target, "click") || nodeName(target, "a");
        }
      },
      beforeunload: {
        postDispatch: function postDispatch(event) {
          // Support: Firefox 20+
          // Firefox doesn't alert if the returnValue field is not set.
          if (event.result !== undefined && event.originalEvent) {
            event.originalEvent.returnValue = event.result;
          }
        }
      }
    }
  }; // Ensure the presence of an event listener that handles manually-triggered
  // synthetic events by interrupting progress until reinvoked in response to
  // *native* events that it fires directly, ensuring that state changes have
  // already occurred before other listeners are invoked.

  function leverageNative(el, type, expectSync) {
    // Missing expectSync indicates a trigger call, which must force setup through jQuery.event.add
    if (!expectSync) {
      if (dataPriv.get(el, type) === undefined) {
        jQuery.event.add(el, type, returnTrue);
      }

      return;
    } // Register the controller as a special universal handler for all event namespaces


    dataPriv.set(el, type, false);
    jQuery.event.add(el, type, {
      namespace: false,
      handler: function handler(event) {
        var notAsync,
            result,
            saved = dataPriv.get(this, type);

        if (event.isTrigger & 1 && this[type]) {
          // Interrupt processing of the outer synthetic .trigger()ed event
          // Saved data should be false in such cases, but might be a leftover capture object
          // from an async native handler (gh-4350)
          if (!saved.length) {
            // Store arguments for use when handling the inner native event
            // There will always be at least one argument (an event object), so this array
            // will not be confused with a leftover capture object.
            saved = _slice.call(arguments);
            dataPriv.set(this, type, saved); // Trigger the native event and capture its result
            // Support: IE <=9 - 11+
            // focus() and blur() are asynchronous

            notAsync = expectSync(this, type);
            this[type]();
            result = dataPriv.get(this, type);

            if (saved !== result || notAsync) {
              dataPriv.set(this, type, false);
            } else {
              result = {};
            }

            if (saved !== result) {
              // Cancel the outer synthetic event
              event.stopImmediatePropagation();
              event.preventDefault();
              return result.value;
            } // If this is an inner synthetic event for an event with a bubbling surrogate
            // (focus or blur), assume that the surrogate already propagated from triggering the
            // native event and prevent that from happening again here.
            // This technically gets the ordering wrong w.r.t. to `.trigger()` (in which the
            // bubbling surrogate propagates *after* the non-bubbling base), but that seems
            // less bad than duplication.

          } else if ((jQuery.event.special[type] || {}).delegateType) {
            event.stopPropagation();
          } // If this is a native event triggered above, everything is now in order
          // Fire an inner synthetic event with the original arguments

        } else if (saved.length) {
          // ...and capture the result
          dataPriv.set(this, type, {
            value: jQuery.event.trigger( // Support: IE <=9 - 11+
            // Extend with the prototype to reset the above stopImmediatePropagation()
            jQuery.extend(saved[0], jQuery.Event.prototype), saved.slice(1), this)
          }); // Abort handling of the native event

          event.stopImmediatePropagation();
        }
      }
    });
  }

  jQuery.removeEvent = function (elem, type, handle) {
    // This "if" is needed for plain objects
    if (elem.removeEventListener) {
      elem.removeEventListener(type, handle);
    }
  };

  jQuery.Event = function (src, props) {
    // Allow instantiation without the 'new' keyword
    if (!(this instanceof jQuery.Event)) {
      return new jQuery.Event(src, props);
    } // Event object


    if (src && src.type) {
      this.originalEvent = src;
      this.type = src.type; // Events bubbling up the document may have been marked as prevented
      // by a handler lower down the tree; reflect the correct value.

      this.isDefaultPrevented = src.defaultPrevented || src.defaultPrevented === undefined && // Support: Android <=2.3 only
      src.returnValue === false ? returnTrue : returnFalse; // Create target properties
      // Support: Safari <=6 - 7 only
      // Target should not be a text node (#504, #13143)

      this.target = src.target && src.target.nodeType === 3 ? src.target.parentNode : src.target;
      this.currentTarget = src.currentTarget;
      this.relatedTarget = src.relatedTarget; // Event type
    } else {
      this.type = src;
    } // Put explicitly provided properties onto the event object


    if (props) {
      jQuery.extend(this, props);
    } // Create a timestamp if incoming event doesn't have one


    this.timeStamp = src && src.timeStamp || Date.now(); // Mark it as fixed

    this[jQuery.expando] = true;
  }; // jQuery.Event is based on DOM3 Events as specified by the ECMAScript Language Binding
  // https://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html


  jQuery.Event.prototype = {
    constructor: jQuery.Event,
    isDefaultPrevented: returnFalse,
    isPropagationStopped: returnFalse,
    isImmediatePropagationStopped: returnFalse,
    isSimulated: false,
    preventDefault: function preventDefault() {
      var e = this.originalEvent;
      this.isDefaultPrevented = returnTrue;

      if (e && !this.isSimulated) {
        e.preventDefault();
      }
    },
    stopPropagation: function stopPropagation() {
      var e = this.originalEvent;
      this.isPropagationStopped = returnTrue;

      if (e && !this.isSimulated) {
        e.stopPropagation();
      }
    },
    stopImmediatePropagation: function stopImmediatePropagation() {
      var e = this.originalEvent;
      this.isImmediatePropagationStopped = returnTrue;

      if (e && !this.isSimulated) {
        e.stopImmediatePropagation();
      }

      this.stopPropagation();
    }
  }; // Includes all common event props including KeyEvent and MouseEvent specific props

  jQuery.each({
    altKey: true,
    bubbles: true,
    cancelable: true,
    changedTouches: true,
    ctrlKey: true,
    detail: true,
    eventPhase: true,
    metaKey: true,
    pageX: true,
    pageY: true,
    shiftKey: true,
    view: true,
    "char": true,
    code: true,
    charCode: true,
    key: true,
    keyCode: true,
    button: true,
    buttons: true,
    clientX: true,
    clientY: true,
    offsetX: true,
    offsetY: true,
    pointerId: true,
    pointerType: true,
    screenX: true,
    screenY: true,
    targetTouches: true,
    toElement: true,
    touches: true,
    which: function which(event) {
      var button = event.button; // Add which for key events

      if (event.which == null && rkeyEvent.test(event.type)) {
        return event.charCode != null ? event.charCode : event.keyCode;
      } // Add which for click: 1 === left; 2 === middle; 3 === right


      if (!event.which && button !== undefined && rmouseEvent.test(event.type)) {
        if (button & 1) {
          return 1;
        }

        if (button & 2) {
          return 3;
        }

        if (button & 4) {
          return 2;
        }

        return 0;
      }

      return event.which;
    }
  }, jQuery.event.addProp);
  jQuery.each({
    focus: "focusin",
    blur: "focusout"
  }, function (type, delegateType) {
    jQuery.event.special[type] = {
      // Utilize native event if possible so blur/focus sequence is correct
      setup: function setup() {
        // Claim the first handler
        // dataPriv.set( this, "focus", ... )
        // dataPriv.set( this, "blur", ... )
        leverageNative(this, type, expectSync); // Return false to allow normal processing in the caller

        return false;
      },
      trigger: function trigger() {
        // Force setup before trigger
        leverageNative(this, type); // Return non-false to allow normal event-path propagation

        return true;
      },
      delegateType: delegateType
    };
  }); // Create mouseenter/leave events using mouseover/out and event-time checks
  // so that event delegation works in jQuery.
  // Do the same for pointerenter/pointerleave and pointerover/pointerout
  //
  // Support: Safari 7 only
  // Safari sends mouseenter too often; see:
  // https://bugs.chromium.org/p/chromium/issues/detail?id=470258
  // for the description of the bug (it existed in older Chrome versions as well).

  jQuery.each({
    mouseenter: "mouseover",
    mouseleave: "mouseout",
    pointerenter: "pointerover",
    pointerleave: "pointerout"
  }, function (orig, fix) {
    jQuery.event.special[orig] = {
      delegateType: fix,
      bindType: fix,
      handle: function handle(event) {
        var ret,
            target = this,
            related = event.relatedTarget,
            handleObj = event.handleObj; // For mouseenter/leave call the handler if related is outside the target.
        // NB: No relatedTarget if the mouse left/entered the browser window

        if (!related || related !== target && !jQuery.contains(target, related)) {
          event.type = handleObj.origType;
          ret = handleObj.handler.apply(this, arguments);
          event.type = fix;
        }

        return ret;
      }
    };
  });
  jQuery.fn.extend({
    on: function on(types, selector, data, fn) {
      return _on(this, types, selector, data, fn);
    },
    one: function one(types, selector, data, fn) {
      return _on(this, types, selector, data, fn, 1);
    },
    off: function off(types, selector, fn) {
      var handleObj, type;

      if (types && types.preventDefault && types.handleObj) {
        // ( event )  dispatched jQuery.Event
        handleObj = types.handleObj;
        jQuery(types.delegateTarget).off(handleObj.namespace ? handleObj.origType + "." + handleObj.namespace : handleObj.origType, handleObj.selector, handleObj.handler);
        return this;
      }

      if (_typeof(types) === "object") {
        // ( types-object [, selector] )
        for (type in types) {
          this.off(type, selector, types[type]);
        }

        return this;
      }

      if (selector === false || typeof selector === "function") {
        // ( types [, fn] )
        fn = selector;
        selector = undefined;
      }

      if (fn === false) {
        fn = returnFalse;
      }

      return this.each(function () {
        jQuery.event.remove(this, types, fn, selector);
      });
    }
  });
  var // Support: IE <=10 - 11, Edge 12 - 13 only
  // In IE/Edge using regex groups here causes severe slowdowns.
  // See https://connect.microsoft.com/IE/feedback/details/1736512/
  rnoInnerhtml = /<script|<style|<link/i,
      // checked="checked" or checked
  rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i,
      rcleanScript = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g; // Prefer a tbody over its parent table for containing new rows

  function manipulationTarget(elem, content) {
    if (nodeName(elem, "table") && nodeName(content.nodeType !== 11 ? content : content.firstChild, "tr")) {
      return jQuery(elem).children("tbody")[0] || elem;
    }

    return elem;
  } // Replace/restore the type attribute of script elements for safe DOM manipulation


  function disableScript(elem) {
    elem.type = (elem.getAttribute("type") !== null) + "/" + elem.type;
    return elem;
  }

  function restoreScript(elem) {
    if ((elem.type || "").slice(0, 5) === "true/") {
      elem.type = elem.type.slice(5);
    } else {
      elem.removeAttribute("type");
    }

    return elem;
  }

  function cloneCopyEvent(src, dest) {
    var i, l, type, pdataOld, udataOld, udataCur, events;

    if (dest.nodeType !== 1) {
      return;
    } // 1. Copy private data: events, handlers, etc.


    if (dataPriv.hasData(src)) {
      pdataOld = dataPriv.get(src);
      events = pdataOld.events;

      if (events) {
        dataPriv.remove(dest, "handle events");

        for (type in events) {
          for (i = 0, l = events[type].length; i < l; i++) {
            jQuery.event.add(dest, type, events[type][i]);
          }
        }
      }
    } // 2. Copy user data


    if (dataUser.hasData(src)) {
      udataOld = dataUser.access(src);
      udataCur = jQuery.extend({}, udataOld);
      dataUser.set(dest, udataCur);
    }
  } // Fix IE bugs, see support tests


  function fixInput(src, dest) {
    var nodeName = dest.nodeName.toLowerCase(); // Fails to persist the checked state of a cloned checkbox or radio button.

    if (nodeName === "input" && rcheckableType.test(src.type)) {
      dest.checked = src.checked; // Fails to return the selected option to the default selected state when cloning options
    } else if (nodeName === "input" || nodeName === "textarea") {
      dest.defaultValue = src.defaultValue;
    }
  }

  function domManip(collection, args, callback, ignored) {
    // Flatten any nested arrays
    args = flat(args);
    var fragment,
        first,
        scripts,
        hasScripts,
        node,
        doc,
        i = 0,
        l = collection.length,
        iNoClone = l - 1,
        value = args[0],
        valueIsFunction = isFunction(value); // We can't cloneNode fragments that contain checked, in WebKit

    if (valueIsFunction || l > 1 && typeof value === "string" && !support.checkClone && rchecked.test(value)) {
      return collection.each(function (index) {
        var self = collection.eq(index);

        if (valueIsFunction) {
          args[0] = value.call(this, index, self.html());
        }

        domManip(self, args, callback, ignored);
      });
    }

    if (l) {
      fragment = buildFragment(args, collection[0].ownerDocument, false, collection, ignored);
      first = fragment.firstChild;

      if (fragment.childNodes.length === 1) {
        fragment = first;
      } // Require either new content or an interest in ignored elements to invoke the callback


      if (first || ignored) {
        scripts = jQuery.map(getAll(fragment, "script"), disableScript);
        hasScripts = scripts.length; // Use the original fragment for the last item
        // instead of the first because it can end up
        // being emptied incorrectly in certain situations (#8070).

        for (; i < l; i++) {
          node = fragment;

          if (i !== iNoClone) {
            node = jQuery.clone(node, true, true); // Keep references to cloned scripts for later restoration

            if (hasScripts) {
              // Support: Android <=4.0 only, PhantomJS 1 only
              // push.apply(_, arraylike) throws on ancient WebKit
              jQuery.merge(scripts, getAll(node, "script"));
            }
          }

          callback.call(collection[i], node, i);
        }

        if (hasScripts) {
          doc = scripts[scripts.length - 1].ownerDocument; // Reenable scripts

          jQuery.map(scripts, restoreScript); // Evaluate executable scripts on first document insertion

          for (i = 0; i < hasScripts; i++) {
            node = scripts[i];

            if (rscriptType.test(node.type || "") && !dataPriv.access(node, "globalEval") && jQuery.contains(doc, node)) {
              if (node.src && (node.type || "").toLowerCase() !== "module") {
                // Optional AJAX dependency, but won't run scripts if not present
                if (jQuery._evalUrl && !node.noModule) {
                  jQuery._evalUrl(node.src, {
                    nonce: node.nonce || node.getAttribute("nonce")
                  }, doc);
                }
              } else {
                DOMEval(node.textContent.replace(rcleanScript, ""), node, doc);
              }
            }
          }
        }
      }
    }

    return collection;
  }

  function _remove(elem, selector, keepData) {
    var node,
        nodes = selector ? jQuery.filter(selector, elem) : elem,
        i = 0;

    for (; (node = nodes[i]) != null; i++) {
      if (!keepData && node.nodeType === 1) {
        jQuery.cleanData(getAll(node));
      }

      if (node.parentNode) {
        if (keepData && isAttached(node)) {
          setGlobalEval(getAll(node, "script"));
        }

        node.parentNode.removeChild(node);
      }
    }

    return elem;
  }

  jQuery.extend({
    htmlPrefilter: function htmlPrefilter(html) {
      return html;
    },
    clone: function clone(elem, dataAndEvents, deepDataAndEvents) {
      var i,
          l,
          srcElements,
          destElements,
          clone = elem.cloneNode(true),
          inPage = isAttached(elem); // Fix IE cloning issues

      if (!support.noCloneChecked && (elem.nodeType === 1 || elem.nodeType === 11) && !jQuery.isXMLDoc(elem)) {
        // We eschew Sizzle here for performance reasons: https://jsperf.com/getall-vs-sizzle/2
        destElements = getAll(clone);
        srcElements = getAll(elem);

        for (i = 0, l = srcElements.length; i < l; i++) {
          fixInput(srcElements[i], destElements[i]);
        }
      } // Copy the events from the original to the clone


      if (dataAndEvents) {
        if (deepDataAndEvents) {
          srcElements = srcElements || getAll(elem);
          destElements = destElements || getAll(clone);

          for (i = 0, l = srcElements.length; i < l; i++) {
            cloneCopyEvent(srcElements[i], destElements[i]);
          }
        } else {
          cloneCopyEvent(elem, clone);
        }
      } // Preserve script evaluation history


      destElements = getAll(clone, "script");

      if (destElements.length > 0) {
        setGlobalEval(destElements, !inPage && getAll(elem, "script"));
      } // Return the cloned set


      return clone;
    },
    cleanData: function cleanData(elems) {
      var data,
          elem,
          type,
          special = jQuery.event.special,
          i = 0;

      for (; (elem = elems[i]) !== undefined; i++) {
        if (acceptData(elem)) {
          if (data = elem[dataPriv.expando]) {
            if (data.events) {
              for (type in data.events) {
                if (special[type]) {
                  jQuery.event.remove(elem, type); // This is a shortcut to avoid jQuery.event.remove's overhead
                } else {
                  jQuery.removeEvent(elem, type, data.handle);
                }
              }
            } // Support: Chrome <=35 - 45+
            // Assign undefined instead of using delete, see Data#remove


            elem[dataPriv.expando] = undefined;
          }

          if (elem[dataUser.expando]) {
            // Support: Chrome <=35 - 45+
            // Assign undefined instead of using delete, see Data#remove
            elem[dataUser.expando] = undefined;
          }
        }
      }
    }
  });
  jQuery.fn.extend({
    detach: function detach(selector) {
      return _remove(this, selector, true);
    },
    remove: function remove(selector) {
      return _remove(this, selector);
    },
    text: function text(value) {
      return access(this, function (value) {
        return value === undefined ? jQuery.text(this) : this.empty().each(function () {
          if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
            this.textContent = value;
          }
        });
      }, null, value, arguments.length);
    },
    append: function append() {
      return domManip(this, arguments, function (elem) {
        if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
          var target = manipulationTarget(this, elem);
          target.appendChild(elem);
        }
      });
    },
    prepend: function prepend() {
      return domManip(this, arguments, function (elem) {
        if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
          var target = manipulationTarget(this, elem);
          target.insertBefore(elem, target.firstChild);
        }
      });
    },
    before: function before() {
      return domManip(this, arguments, function (elem) {
        if (this.parentNode) {
          this.parentNode.insertBefore(elem, this);
        }
      });
    },
    after: function after() {
      return domManip(this, arguments, function (elem) {
        if (this.parentNode) {
          this.parentNode.insertBefore(elem, this.nextSibling);
        }
      });
    },
    empty: function empty() {
      var elem,
          i = 0;

      for (; (elem = this[i]) != null; i++) {
        if (elem.nodeType === 1) {
          // Prevent memory leaks
          jQuery.cleanData(getAll(elem, false)); // Remove any remaining nodes

          elem.textContent = "";
        }
      }

      return this;
    },
    clone: function clone(dataAndEvents, deepDataAndEvents) {
      dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
      deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;
      return this.map(function () {
        return jQuery.clone(this, dataAndEvents, deepDataAndEvents);
      });
    },
    html: function html(value) {
      return access(this, function (value) {
        var elem = this[0] || {},
            i = 0,
            l = this.length;

        if (value === undefined && elem.nodeType === 1) {
          return elem.innerHTML;
        } // See if we can take a shortcut and just use innerHTML


        if (typeof value === "string" && !rnoInnerhtml.test(value) && !wrapMap[(rtagName.exec(value) || ["", ""])[1].toLowerCase()]) {
          value = jQuery.htmlPrefilter(value);

          try {
            for (; i < l; i++) {
              elem = this[i] || {}; // Remove element nodes and prevent memory leaks

              if (elem.nodeType === 1) {
                jQuery.cleanData(getAll(elem, false));
                elem.innerHTML = value;
              }
            }

            elem = 0; // If using innerHTML throws an exception, use the fallback method
          } catch (e) {}
        }

        if (elem) {
          this.empty().append(value);
        }
      }, null, value, arguments.length);
    },
    replaceWith: function replaceWith() {
      var ignored = []; // Make the changes, replacing each non-ignored context element with the new content

      return domManip(this, arguments, function (elem) {
        var parent = this.parentNode;

        if (jQuery.inArray(this, ignored) < 0) {
          jQuery.cleanData(getAll(this));

          if (parent) {
            parent.replaceChild(elem, this);
          }
        } // Force callback invocation

      }, ignored);
    }
  });
  jQuery.each({
    appendTo: "append",
    prependTo: "prepend",
    insertBefore: "before",
    insertAfter: "after",
    replaceAll: "replaceWith"
  }, function (name, original) {
    jQuery.fn[name] = function (selector) {
      var elems,
          ret = [],
          insert = jQuery(selector),
          last = insert.length - 1,
          i = 0;

      for (; i <= last; i++) {
        elems = i === last ? this : this.clone(true);
        jQuery(insert[i])[original](elems); // Support: Android <=4.0 only, PhantomJS 1 only
        // .get() because push.apply(_, arraylike) throws on ancient WebKit

        push.apply(ret, elems.get());
      }

      return this.pushStack(ret);
    };
  });
  var rnumnonpx = new RegExp("^(" + pnum + ")(?!px)[a-z%]+$", "i");

  var getStyles = function getStyles(elem) {
    // Support: IE <=11 only, Firefox <=30 (#15098, #14150)
    // IE throws on elements created in popups
    // FF meanwhile throws on frame elements through "defaultView.getComputedStyle"
    var view = elem.ownerDocument.defaultView;

    if (!view || !view.opener) {
      view = window;
    }

    return view.getComputedStyle(elem);
  };

  var swap = function swap(elem, options, callback) {
    var ret,
        name,
        old = {}; // Remember the old values, and insert the new ones

    for (name in options) {
      old[name] = elem.style[name];
      elem.style[name] = options[name];
    }

    ret = callback.call(elem); // Revert the old values

    for (name in options) {
      elem.style[name] = old[name];
    }

    return ret;
  };

  var rboxStyle = new RegExp(cssExpand.join("|"), "i");

  (function () {
    // Executing both pixelPosition & boxSizingReliable tests require only one layout
    // so they're executed at the same time to save the second computation.
    function computeStyleTests() {
      // This is a singleton, we need to execute it only once
      if (!div) {
        return;
      }

      container.style.cssText = "position:absolute;left:-11111px;width:60px;" + "margin-top:1px;padding:0;border:0";
      div.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;" + "margin:auto;border:1px;padding:1px;" + "width:60%;top:1%";
      documentElement.appendChild(container).appendChild(div);
      var divStyle = window.getComputedStyle(div);
      pixelPositionVal = divStyle.top !== "1%"; // Support: Android 4.0 - 4.3 only, Firefox <=3 - 44

      reliableMarginLeftVal = roundPixelMeasures(divStyle.marginLeft) === 12; // Support: Android 4.0 - 4.3 only, Safari <=9.1 - 10.1, iOS <=7.0 - 9.3
      // Some styles come back with percentage values, even though they shouldn't

      div.style.right = "60%";
      pixelBoxStylesVal = roundPixelMeasures(divStyle.right) === 36; // Support: IE 9 - 11 only
      // Detect misreporting of content dimensions for box-sizing:border-box elements

      boxSizingReliableVal = roundPixelMeasures(divStyle.width) === 36; // Support: IE 9 only
      // Detect overflow:scroll screwiness (gh-3699)
      // Support: Chrome <=64
      // Don't get tricked when zoom affects offsetWidth (gh-4029)

      div.style.position = "absolute";
      scrollboxSizeVal = roundPixelMeasures(div.offsetWidth / 3) === 12;
      documentElement.removeChild(container); // Nullify the div so it wouldn't be stored in the memory and
      // it will also be a sign that checks already performed

      div = null;
    }

    function roundPixelMeasures(measure) {
      return Math.round(parseFloat(measure));
    }

    var pixelPositionVal,
        boxSizingReliableVal,
        scrollboxSizeVal,
        pixelBoxStylesVal,
        reliableTrDimensionsVal,
        reliableMarginLeftVal,
        container = document.createElement("div"),
        div = document.createElement("div"); // Finish early in limited (non-browser) environments

    if (!div.style) {
      return;
    } // Support: IE <=9 - 11 only
    // Style of cloned element affects source element cloned (#8908)


    div.style.backgroundClip = "content-box";
    div.cloneNode(true).style.backgroundClip = "";
    support.clearCloneStyle = div.style.backgroundClip === "content-box";
    jQuery.extend(support, {
      boxSizingReliable: function boxSizingReliable() {
        computeStyleTests();
        return boxSizingReliableVal;
      },
      pixelBoxStyles: function pixelBoxStyles() {
        computeStyleTests();
        return pixelBoxStylesVal;
      },
      pixelPosition: function pixelPosition() {
        computeStyleTests();
        return pixelPositionVal;
      },
      reliableMarginLeft: function reliableMarginLeft() {
        computeStyleTests();
        return reliableMarginLeftVal;
      },
      scrollboxSize: function scrollboxSize() {
        computeStyleTests();
        return scrollboxSizeVal;
      },
      // Support: IE 9 - 11+, Edge 15 - 18+
      // IE/Edge misreport `getComputedStyle` of table rows with width/height
      // set in CSS while `offset*` properties report correct values.
      // Behavior in IE 9 is more subtle than in newer versions & it passes
      // some versions of this test; make sure not to make it pass there!
      reliableTrDimensions: function reliableTrDimensions() {
        var table, tr, trChild, trStyle;

        if (reliableTrDimensionsVal == null) {
          table = document.createElement("table");
          tr = document.createElement("tr");
          trChild = document.createElement("div");
          table.style.cssText = "position:absolute;left:-11111px";
          tr.style.height = "1px";
          trChild.style.height = "9px";
          documentElement.appendChild(table).appendChild(tr).appendChild(trChild);
          trStyle = window.getComputedStyle(tr);
          reliableTrDimensionsVal = parseInt(trStyle.height) > 3;
          documentElement.removeChild(table);
        }

        return reliableTrDimensionsVal;
      }
    });
  })();

  function curCSS(elem, name, computed) {
    var width,
        minWidth,
        maxWidth,
        ret,
        // Support: Firefox 51+
    // Retrieving style before computed somehow
    // fixes an issue with getting wrong values
    // on detached elements
    style = elem.style;
    computed = computed || getStyles(elem); // getPropertyValue is needed for:
    //   .css('filter') (IE 9 only, #12537)
    //   .css('--customProperty) (#3144)

    if (computed) {
      ret = computed.getPropertyValue(name) || computed[name];

      if (ret === "" && !isAttached(elem)) {
        ret = jQuery.style(elem, name);
      } // A tribute to the "awesome hack by Dean Edwards"
      // Android Browser returns percentage for some values,
      // but width seems to be reliably pixels.
      // This is against the CSSOM draft spec:
      // https://drafts.csswg.org/cssom/#resolved-values


      if (!support.pixelBoxStyles() && rnumnonpx.test(ret) && rboxStyle.test(name)) {
        // Remember the original values
        width = style.width;
        minWidth = style.minWidth;
        maxWidth = style.maxWidth; // Put in the new values to get a computed value out

        style.minWidth = style.maxWidth = style.width = ret;
        ret = computed.width; // Revert the changed values

        style.width = width;
        style.minWidth = minWidth;
        style.maxWidth = maxWidth;
      }
    }

    return ret !== undefined ? // Support: IE <=9 - 11 only
    // IE returns zIndex value as an integer.
    ret + "" : ret;
  }

  function addGetHookIf(conditionFn, hookFn) {
    // Define the hook, we'll check on the first run if it's really needed.
    return {
      get: function get() {
        if (conditionFn()) {
          // Hook not needed (or it's not possible to use it due
          // to missing dependency), remove it.
          delete this.get;
          return;
        } // Hook needed; redefine it so that the support test is not executed again.


        return (this.get = hookFn).apply(this, arguments);
      }
    };
  }

  var cssPrefixes = ["Webkit", "Moz", "ms"],
      emptyStyle = document.createElement("div").style,
      vendorProps = {}; // Return a vendor-prefixed property or undefined

  function vendorPropName(name) {
    // Check for vendor prefixed names
    var capName = name[0].toUpperCase() + name.slice(1),
        i = cssPrefixes.length;

    while (i--) {
      name = cssPrefixes[i] + capName;

      if (name in emptyStyle) {
        return name;
      }
    }
  } // Return a potentially-mapped jQuery.cssProps or vendor prefixed property


  function finalPropName(name) {
    var _final = jQuery.cssProps[name] || vendorProps[name];

    if (_final) {
      return _final;
    }

    if (name in emptyStyle) {
      return name;
    }

    return vendorProps[name] = vendorPropName(name) || name;
  }

  var // Swappable if display is none or starts with table
  // except "table", "table-cell", or "table-caption"
  // See here for display values: https://developer.mozilla.org/en-US/docs/CSS/display
  rdisplayswap = /^(none|table(?!-c[ea]).+)/,
      rcustomProp = /^--/,
      cssShow = {
    position: "absolute",
    visibility: "hidden",
    display: "block"
  },
      cssNormalTransform = {
    letterSpacing: "0",
    fontWeight: "400"
  };

  function setPositiveNumber(_elem, value, subtract) {
    // Any relative (+/-) values have already been
    // normalized at this point
    var matches = rcssNum.exec(value);
    return matches ? // Guard against undefined "subtract", e.g., when used as in cssHooks
    Math.max(0, matches[2] - (subtract || 0)) + (matches[3] || "px") : value;
  }

  function boxModelAdjustment(elem, dimension, box, isBorderBox, styles, computedVal) {
    var i = dimension === "width" ? 1 : 0,
        extra = 0,
        delta = 0; // Adjustment may not be necessary

    if (box === (isBorderBox ? "border" : "content")) {
      return 0;
    }

    for (; i < 4; i += 2) {
      // Both box models exclude margin
      if (box === "margin") {
        delta += jQuery.css(elem, box + cssExpand[i], true, styles);
      } // If we get here with a content-box, we're seeking "padding" or "border" or "margin"


      if (!isBorderBox) {
        // Add padding
        delta += jQuery.css(elem, "padding" + cssExpand[i], true, styles); // For "border" or "margin", add border

        if (box !== "padding") {
          delta += jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles); // But still keep track of it otherwise
        } else {
          extra += jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
        } // If we get here with a border-box (content + padding + border), we're seeking "content" or
        // "padding" or "margin"

      } else {
        // For "content", subtract padding
        if (box === "content") {
          delta -= jQuery.css(elem, "padding" + cssExpand[i], true, styles);
        } // For "content" or "padding", subtract border


        if (box !== "margin") {
          delta -= jQuery.css(elem, "border" + cssExpand[i] + "Width", true, styles);
        }
      }
    } // Account for positive content-box scroll gutter when requested by providing computedVal


    if (!isBorderBox && computedVal >= 0) {
      // offsetWidth/offsetHeight is a rounded sum of content, padding, scroll gutter, and border
      // Assuming integer scroll gutter, subtract the rest and round down
      delta += Math.max(0, Math.ceil(elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] - computedVal - delta - extra - 0.5 // If offsetWidth/offsetHeight is unknown, then we can't determine content-box scroll gutter
      // Use an explicit zero to avoid NaN (gh-3964)
      )) || 0;
    }

    return delta;
  }

  function getWidthOrHeight(elem, dimension, extra) {
    // Start with computed style
    var styles = getStyles(elem),
        // To avoid forcing a reflow, only fetch boxSizing if we need it (gh-4322).
    // Fake content-box until we know it's needed to know the true value.
    boxSizingNeeded = !support.boxSizingReliable() || extra,
        isBorderBox = boxSizingNeeded && jQuery.css(elem, "boxSizing", false, styles) === "border-box",
        valueIsBorderBox = isBorderBox,
        val = curCSS(elem, dimension, styles),
        offsetProp = "offset" + dimension[0].toUpperCase() + dimension.slice(1); // Support: Firefox <=54
    // Return a confounding non-pixel value or feign ignorance, as appropriate.

    if (rnumnonpx.test(val)) {
      if (!extra) {
        return val;
      }

      val = "auto";
    } // Support: IE 9 - 11 only
    // Use offsetWidth/offsetHeight for when box sizing is unreliable.
    // In those cases, the computed value can be trusted to be border-box.


    if ((!support.boxSizingReliable() && isBorderBox || // Support: IE 10 - 11+, Edge 15 - 18+
    // IE/Edge misreport `getComputedStyle` of table rows with width/height
    // set in CSS while `offset*` properties report correct values.
    // Interestingly, in some cases IE 9 doesn't suffer from this issue.
    !support.reliableTrDimensions() && nodeName(elem, "tr") || // Fall back to offsetWidth/offsetHeight when value is "auto"
    // This happens for inline elements with no explicit setting (gh-3571)
    val === "auto" || // Support: Android <=4.1 - 4.3 only
    // Also use offsetWidth/offsetHeight for misreported inline dimensions (gh-3602)
    !parseFloat(val) && jQuery.css(elem, "display", false, styles) === "inline") && // Make sure the element is visible & connected
    elem.getClientRects().length) {
      isBorderBox = jQuery.css(elem, "boxSizing", false, styles) === "border-box"; // Where available, offsetWidth/offsetHeight approximate border box dimensions.
      // Where not available (e.g., SVG), assume unreliable box-sizing and interpret the
      // retrieved value as a content box dimension.

      valueIsBorderBox = offsetProp in elem;

      if (valueIsBorderBox) {
        val = elem[offsetProp];
      }
    } // Normalize "" and auto


    val = parseFloat(val) || 0; // Adjust for the element's box model

    return val + boxModelAdjustment(elem, dimension, extra || (isBorderBox ? "border" : "content"), valueIsBorderBox, styles, // Provide the current computed size to request scroll gutter calculation (gh-3589)
    val) + "px";
  }

  jQuery.extend({
    // Add in style property hooks for overriding the default
    // behavior of getting and setting a style property
    cssHooks: {
      opacity: {
        get: function get(elem, computed) {
          if (computed) {
            // We should always get a number back from opacity
            var ret = curCSS(elem, "opacity");
            return ret === "" ? "1" : ret;
          }
        }
      }
    },
    // Don't automatically add "px" to these possibly-unitless properties
    cssNumber: {
      "animationIterationCount": true,
      "columnCount": true,
      "fillOpacity": true,
      "flexGrow": true,
      "flexShrink": true,
      "fontWeight": true,
      "gridArea": true,
      "gridColumn": true,
      "gridColumnEnd": true,
      "gridColumnStart": true,
      "gridRow": true,
      "gridRowEnd": true,
      "gridRowStart": true,
      "lineHeight": true,
      "opacity": true,
      "order": true,
      "orphans": true,
      "widows": true,
      "zIndex": true,
      "zoom": true
    },
    // Add in properties whose names you wish to fix before
    // setting or getting the value
    cssProps: {},
    // Get and set the style property on a DOM Node
    style: function style(elem, name, value, extra) {
      // Don't set styles on text and comment nodes
      if (!elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style) {
        return;
      } // Make sure that we're working with the right name


      var ret,
          type,
          hooks,
          origName = camelCase(name),
          isCustomProp = rcustomProp.test(name),
          style = elem.style; // Make sure that we're working with the right name. We don't
      // want to query the value if it is a CSS custom property
      // since they are user-defined.

      if (!isCustomProp) {
        name = finalPropName(origName);
      } // Gets hook for the prefixed version, then unprefixed version


      hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName]; // Check if we're setting a value

      if (value !== undefined) {
        type = _typeof(value); // Convert "+=" or "-=" to relative numbers (#7345)

        if (type === "string" && (ret = rcssNum.exec(value)) && ret[1]) {
          value = adjustCSS(elem, name, ret); // Fixes bug #9237

          type = "number";
        } // Make sure that null and NaN values aren't set (#7116)


        if (value == null || value !== value) {
          return;
        } // If a number was passed in, add the unit (except for certain CSS properties)
        // The isCustomProp check can be removed in jQuery 4.0 when we only auto-append
        // "px" to a few hardcoded values.


        if (type === "number" && !isCustomProp) {
          value += ret && ret[3] || (jQuery.cssNumber[origName] ? "" : "px");
        } // background-* props affect original clone's values


        if (!support.clearCloneStyle && value === "" && name.indexOf("background") === 0) {
          style[name] = "inherit";
        } // If a hook was provided, use that value, otherwise just set the specified value


        if (!hooks || !("set" in hooks) || (value = hooks.set(elem, value, extra)) !== undefined) {
          if (isCustomProp) {
            style.setProperty(name, value);
          } else {
            style[name] = value;
          }
        }
      } else {
        // If a hook was provided get the non-computed value from there
        if (hooks && "get" in hooks && (ret = hooks.get(elem, false, extra)) !== undefined) {
          return ret;
        } // Otherwise just get the value from the style object


        return style[name];
      }
    },
    css: function css(elem, name, extra, styles) {
      var val,
          num,
          hooks,
          origName = camelCase(name),
          isCustomProp = rcustomProp.test(name); // Make sure that we're working with the right name. We don't
      // want to modify the value if it is a CSS custom property
      // since they are user-defined.

      if (!isCustomProp) {
        name = finalPropName(origName);
      } // Try prefixed name followed by the unprefixed name


      hooks = jQuery.cssHooks[name] || jQuery.cssHooks[origName]; // If a hook was provided get the computed value from there

      if (hooks && "get" in hooks) {
        val = hooks.get(elem, true, extra);
      } // Otherwise, if a way to get the computed value exists, use that


      if (val === undefined) {
        val = curCSS(elem, name, styles);
      } // Convert "normal" to computed value


      if (val === "normal" && name in cssNormalTransform) {
        val = cssNormalTransform[name];
      } // Make numeric if forced or a qualifier was provided and val looks numeric


      if (extra === "" || extra) {
        num = parseFloat(val);
        return extra === true || isFinite(num) ? num || 0 : val;
      }

      return val;
    }
  });
  jQuery.each(["height", "width"], function (_i, dimension) {
    jQuery.cssHooks[dimension] = {
      get: function get(elem, computed, extra) {
        if (computed) {
          // Certain elements can have dimension info if we invisibly show them
          // but it must have a current display style that would benefit
          return rdisplayswap.test(jQuery.css(elem, "display")) && ( // Support: Safari 8+
          // Table columns in Safari have non-zero offsetWidth & zero
          // getBoundingClientRect().width unless display is changed.
          // Support: IE <=11 only
          // Running getBoundingClientRect on a disconnected node
          // in IE throws an error.
          !elem.getClientRects().length || !elem.getBoundingClientRect().width) ? swap(elem, cssShow, function () {
            return getWidthOrHeight(elem, dimension, extra);
          }) : getWidthOrHeight(elem, dimension, extra);
        }
      },
      set: function set(elem, value, extra) {
        var matches,
            styles = getStyles(elem),
            // Only read styles.position if the test has a chance to fail
        // to avoid forcing a reflow.
        scrollboxSizeBuggy = !support.scrollboxSize() && styles.position === "absolute",
            // To avoid forcing a reflow, only fetch boxSizing if we need it (gh-3991)
        boxSizingNeeded = scrollboxSizeBuggy || extra,
            isBorderBox = boxSizingNeeded && jQuery.css(elem, "boxSizing", false, styles) === "border-box",
            subtract = extra ? boxModelAdjustment(elem, dimension, extra, isBorderBox, styles) : 0; // Account for unreliable border-box dimensions by comparing offset* to computed and
        // faking a content-box to get border and padding (gh-3699)

        if (isBorderBox && scrollboxSizeBuggy) {
          subtract -= Math.ceil(elem["offset" + dimension[0].toUpperCase() + dimension.slice(1)] - parseFloat(styles[dimension]) - boxModelAdjustment(elem, dimension, "border", false, styles) - 0.5);
        } // Convert to pixels if value adjustment is needed


        if (subtract && (matches = rcssNum.exec(value)) && (matches[3] || "px") !== "px") {
          elem.style[dimension] = value;
          value = jQuery.css(elem, dimension);
        }

        return setPositiveNumber(elem, value, subtract);
      }
    };
  });
  jQuery.cssHooks.marginLeft = addGetHookIf(support.reliableMarginLeft, function (elem, computed) {
    if (computed) {
      return (parseFloat(curCSS(elem, "marginLeft")) || elem.getBoundingClientRect().left - swap(elem, {
        marginLeft: 0
      }, function () {
        return elem.getBoundingClientRect().left;
      })) + "px";
    }
  }); // These hooks are used by animate to expand properties

  jQuery.each({
    margin: "",
    padding: "",
    border: "Width"
  }, function (prefix, suffix) {
    jQuery.cssHooks[prefix + suffix] = {
      expand: function expand(value) {
        var i = 0,
            expanded = {},
            // Assumes a single number if not a string
        parts = typeof value === "string" ? value.split(" ") : [value];

        for (; i < 4; i++) {
          expanded[prefix + cssExpand[i] + suffix] = parts[i] || parts[i - 2] || parts[0];
        }

        return expanded;
      }
    };

    if (prefix !== "margin") {
      jQuery.cssHooks[prefix + suffix].set = setPositiveNumber;
    }
  });
  jQuery.fn.extend({
    css: function css(name, value) {
      return access(this, function (elem, name, value) {
        var styles,
            len,
            map = {},
            i = 0;

        if (Array.isArray(name)) {
          styles = getStyles(elem);
          len = name.length;

          for (; i < len; i++) {
            map[name[i]] = jQuery.css(elem, name[i], false, styles);
          }

          return map;
        }

        return value !== undefined ? jQuery.style(elem, name, value) : jQuery.css(elem, name);
      }, name, value, arguments.length > 1);
    }
  });

  function Tween(elem, options, prop, end, easing) {
    return new Tween.prototype.init(elem, options, prop, end, easing);
  }

  jQuery.Tween = Tween;
  Tween.prototype = {
    constructor: Tween,
    init: function init(elem, options, prop, end, easing, unit) {
      this.elem = elem;
      this.prop = prop;
      this.easing = easing || jQuery.easing._default;
      this.options = options;
      this.start = this.now = this.cur();
      this.end = end;
      this.unit = unit || (jQuery.cssNumber[prop] ? "" : "px");
    },
    cur: function cur() {
      var hooks = Tween.propHooks[this.prop];
      return hooks && hooks.get ? hooks.get(this) : Tween.propHooks._default.get(this);
    },
    run: function run(percent) {
      var eased,
          hooks = Tween.propHooks[this.prop];

      if (this.options.duration) {
        this.pos = eased = jQuery.easing[this.easing](percent, this.options.duration * percent, 0, 1, this.options.duration);
      } else {
        this.pos = eased = percent;
      }

      this.now = (this.end - this.start) * eased + this.start;

      if (this.options.step) {
        this.options.step.call(this.elem, this.now, this);
      }

      if (hooks && hooks.set) {
        hooks.set(this);
      } else {
        Tween.propHooks._default.set(this);
      }

      return this;
    }
  };
  Tween.prototype.init.prototype = Tween.prototype;
  Tween.propHooks = {
    _default: {
      get: function get(tween) {
        var result; // Use a property on the element directly when it is not a DOM element,
        // or when there is no matching style property that exists.

        if (tween.elem.nodeType !== 1 || tween.elem[tween.prop] != null && tween.elem.style[tween.prop] == null) {
          return tween.elem[tween.prop];
        } // Passing an empty string as a 3rd parameter to .css will automatically
        // attempt a parseFloat and fallback to a string if the parse fails.
        // Simple values such as "10px" are parsed to Float;
        // complex values such as "rotate(1rad)" are returned as-is.


        result = jQuery.css(tween.elem, tween.prop, ""); // Empty strings, null, undefined and "auto" are converted to 0.

        return !result || result === "auto" ? 0 : result;
      },
      set: function set(tween) {
        // Use step hook for back compat.
        // Use cssHook if its there.
        // Use .style if available and use plain properties where available.
        if (jQuery.fx.step[tween.prop]) {
          jQuery.fx.step[tween.prop](tween);
        } else if (tween.elem.nodeType === 1 && (jQuery.cssHooks[tween.prop] || tween.elem.style[finalPropName(tween.prop)] != null)) {
          jQuery.style(tween.elem, tween.prop, tween.now + tween.unit);
        } else {
          tween.elem[tween.prop] = tween.now;
        }
      }
    }
  }; // Support: IE <=9 only
  // Panic based approach to setting things on disconnected nodes

  Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
    set: function set(tween) {
      if (tween.elem.nodeType && tween.elem.parentNode) {
        tween.elem[tween.prop] = tween.now;
      }
    }
  };
  jQuery.easing = {
    linear: function linear(p) {
      return p;
    },
    swing: function swing(p) {
      return 0.5 - Math.cos(p * Math.PI) / 2;
    },
    _default: "swing"
  };
  jQuery.fx = Tween.prototype.init; // Back compat <1.8 extension point

  jQuery.fx.step = {};
  var fxNow,
      inProgress,
      rfxtypes = /^(?:toggle|show|hide)$/,
      rrun = /queueHooks$/;

  function schedule() {
    if (inProgress) {
      if (document.hidden === false && window.requestAnimationFrame) {
        window.requestAnimationFrame(schedule);
      } else {
        window.setTimeout(schedule, jQuery.fx.interval);
      }

      jQuery.fx.tick();
    }
  } // Animations created synchronously will run synchronously


  function createFxNow() {
    window.setTimeout(function () {
      fxNow = undefined;
    });
    return fxNow = Date.now();
  } // Generate parameters to create a standard animation


  function genFx(type, includeWidth) {
    var which,
        i = 0,
        attrs = {
      height: type
    }; // If we include width, step value is 1 to do all cssExpand values,
    // otherwise step value is 2 to skip over Left and Right

    includeWidth = includeWidth ? 1 : 0;

    for (; i < 4; i += 2 - includeWidth) {
      which = cssExpand[i];
      attrs["margin" + which] = attrs["padding" + which] = type;
    }

    if (includeWidth) {
      attrs.opacity = attrs.width = type;
    }

    return attrs;
  }

  function createTween(value, prop, animation) {
    var tween,
        collection = (Animation.tweeners[prop] || []).concat(Animation.tweeners["*"]),
        index = 0,
        length = collection.length;

    for (; index < length; index++) {
      if (tween = collection[index].call(animation, prop, value)) {
        // We're done with this property
        return tween;
      }
    }
  }

  function defaultPrefilter(elem, props, opts) {
    var prop,
        value,
        toggle,
        hooks,
        oldfire,
        propTween,
        restoreDisplay,
        display,
        isBox = "width" in props || "height" in props,
        anim = this,
        orig = {},
        style = elem.style,
        hidden = elem.nodeType && isHiddenWithinTree(elem),
        dataShow = dataPriv.get(elem, "fxshow"); // Queue-skipping animations hijack the fx hooks

    if (!opts.queue) {
      hooks = jQuery._queueHooks(elem, "fx");

      if (hooks.unqueued == null) {
        hooks.unqueued = 0;
        oldfire = hooks.empty.fire;

        hooks.empty.fire = function () {
          if (!hooks.unqueued) {
            oldfire();
          }
        };
      }

      hooks.unqueued++;
      anim.always(function () {
        // Ensure the complete handler is called before this completes
        anim.always(function () {
          hooks.unqueued--;

          if (!jQuery.queue(elem, "fx").length) {
            hooks.empty.fire();
          }
        });
      });
    } // Detect show/hide animations


    for (prop in props) {
      value = props[prop];

      if (rfxtypes.test(value)) {
        delete props[prop];
        toggle = toggle || value === "toggle";

        if (value === (hidden ? "hide" : "show")) {
          // Pretend to be hidden if this is a "show" and
          // there is still data from a stopped show/hide
          if (value === "show" && dataShow && dataShow[prop] !== undefined) {
            hidden = true; // Ignore all other no-op show/hide data
          } else {
            continue;
          }
        }

        orig[prop] = dataShow && dataShow[prop] || jQuery.style(elem, prop);
      }
    } // Bail out if this is a no-op like .hide().hide()


    propTween = !jQuery.isEmptyObject(props);

    if (!propTween && jQuery.isEmptyObject(orig)) {
      return;
    } // Restrict "overflow" and "display" styles during box animations


    if (isBox && elem.nodeType === 1) {
      // Support: IE <=9 - 11, Edge 12 - 15
      // Record all 3 overflow attributes because IE does not infer the shorthand
      // from identically-valued overflowX and overflowY and Edge just mirrors
      // the overflowX value there.
      opts.overflow = [style.overflow, style.overflowX, style.overflowY]; // Identify a display type, preferring old show/hide data over the CSS cascade

      restoreDisplay = dataShow && dataShow.display;

      if (restoreDisplay == null) {
        restoreDisplay = dataPriv.get(elem, "display");
      }

      display = jQuery.css(elem, "display");

      if (display === "none") {
        if (restoreDisplay) {
          display = restoreDisplay;
        } else {
          // Get nonempty value(s) by temporarily forcing visibility
          showHide([elem], true);
          restoreDisplay = elem.style.display || restoreDisplay;
          display = jQuery.css(elem, "display");
          showHide([elem]);
        }
      } // Animate inline elements as inline-block


      if (display === "inline" || display === "inline-block" && restoreDisplay != null) {
        if (jQuery.css(elem, "float") === "none") {
          // Restore the original display value at the end of pure show/hide animations
          if (!propTween) {
            anim.done(function () {
              style.display = restoreDisplay;
            });

            if (restoreDisplay == null) {
              display = style.display;
              restoreDisplay = display === "none" ? "" : display;
            }
          }

          style.display = "inline-block";
        }
      }
    }

    if (opts.overflow) {
      style.overflow = "hidden";
      anim.always(function () {
        style.overflow = opts.overflow[0];
        style.overflowX = opts.overflow[1];
        style.overflowY = opts.overflow[2];
      });
    } // Implement show/hide animations


    propTween = false;

    for (prop in orig) {
      // General show/hide setup for this element animation
      if (!propTween) {
        if (dataShow) {
          if ("hidden" in dataShow) {
            hidden = dataShow.hidden;
          }
        } else {
          dataShow = dataPriv.access(elem, "fxshow", {
            display: restoreDisplay
          });
        } // Store hidden/visible for toggle so `.stop().toggle()` "reverses"


        if (toggle) {
          dataShow.hidden = !hidden;
        } // Show elements before animating them


        if (hidden) {
          showHide([elem], true);
        }
        /* eslint-disable no-loop-func */


        anim.done(function () {
          /* eslint-enable no-loop-func */
          // The final step of a "hide" animation is actually hiding the element
          if (!hidden) {
            showHide([elem]);
          }

          dataPriv.remove(elem, "fxshow");

          for (prop in orig) {
            jQuery.style(elem, prop, orig[prop]);
          }
        });
      } // Per-property setup


      propTween = createTween(hidden ? dataShow[prop] : 0, prop, anim);

      if (!(prop in dataShow)) {
        dataShow[prop] = propTween.start;

        if (hidden) {
          propTween.end = propTween.start;
          propTween.start = 0;
        }
      }
    }
  }

  function propFilter(props, specialEasing) {
    var index, name, easing, value, hooks; // camelCase, specialEasing and expand cssHook pass

    for (index in props) {
      name = camelCase(index);
      easing = specialEasing[name];
      value = props[index];

      if (Array.isArray(value)) {
        easing = value[1];
        value = props[index] = value[0];
      }

      if (index !== name) {
        props[name] = value;
        delete props[index];
      }

      hooks = jQuery.cssHooks[name];

      if (hooks && "expand" in hooks) {
        value = hooks.expand(value);
        delete props[name]; // Not quite $.extend, this won't overwrite existing keys.
        // Reusing 'index' because we have the correct "name"

        for (index in value) {
          if (!(index in props)) {
            props[index] = value[index];
            specialEasing[index] = easing;
          }
        }
      } else {
        specialEasing[name] = easing;
      }
    }
  }

  function Animation(elem, properties, options) {
    var result,
        stopped,
        index = 0,
        length = Animation.prefilters.length,
        deferred = jQuery.Deferred().always(function () {
      // Don't match elem in the :animated selector
      delete tick.elem;
    }),
        tick = function tick() {
      if (stopped) {
        return false;
      }

      var currentTime = fxNow || createFxNow(),
          remaining = Math.max(0, animation.startTime + animation.duration - currentTime),
          // Support: Android 2.3 only
      // Archaic crash bug won't allow us to use `1 - ( 0.5 || 0 )` (#12497)
      temp = remaining / animation.duration || 0,
          percent = 1 - temp,
          index = 0,
          length = animation.tweens.length;

      for (; index < length; index++) {
        animation.tweens[index].run(percent);
      }

      deferred.notifyWith(elem, [animation, percent, remaining]); // If there's more to do, yield

      if (percent < 1 && length) {
        return remaining;
      } // If this was an empty animation, synthesize a final progress notification


      if (!length) {
        deferred.notifyWith(elem, [animation, 1, 0]);
      } // Resolve the animation and report its conclusion


      deferred.resolveWith(elem, [animation]);
      return false;
    },
        animation = deferred.promise({
      elem: elem,
      props: jQuery.extend({}, properties),
      opts: jQuery.extend(true, {
        specialEasing: {},
        easing: jQuery.easing._default
      }, options),
      originalProperties: properties,
      originalOptions: options,
      startTime: fxNow || createFxNow(),
      duration: options.duration,
      tweens: [],
      createTween: function createTween(prop, end) {
        var tween = jQuery.Tween(elem, animation.opts, prop, end, animation.opts.specialEasing[prop] || animation.opts.easing);
        animation.tweens.push(tween);
        return tween;
      },
      stop: function stop(gotoEnd) {
        var index = 0,
            // If we are going to the end, we want to run all the tweens
        // otherwise we skip this part
        length = gotoEnd ? animation.tweens.length : 0;

        if (stopped) {
          return this;
        }

        stopped = true;

        for (; index < length; index++) {
          animation.tweens[index].run(1);
        } // Resolve when we played the last frame; otherwise, reject


        if (gotoEnd) {
          deferred.notifyWith(elem, [animation, 1, 0]);
          deferred.resolveWith(elem, [animation, gotoEnd]);
        } else {
          deferred.rejectWith(elem, [animation, gotoEnd]);
        }

        return this;
      }
    }),
        props = animation.props;

    propFilter(props, animation.opts.specialEasing);

    for (; index < length; index++) {
      result = Animation.prefilters[index].call(animation, elem, props, animation.opts);

      if (result) {
        if (isFunction(result.stop)) {
          jQuery._queueHooks(animation.elem, animation.opts.queue).stop = result.stop.bind(result);
        }

        return result;
      }
    }

    jQuery.map(props, createTween, animation);

    if (isFunction(animation.opts.start)) {
      animation.opts.start.call(elem, animation);
    } // Attach callbacks from options


    animation.progress(animation.opts.progress).done(animation.opts.done, animation.opts.complete).fail(animation.opts.fail).always(animation.opts.always);
    jQuery.fx.timer(jQuery.extend(tick, {
      elem: elem,
      anim: animation,
      queue: animation.opts.queue
    }));
    return animation;
  }

  jQuery.Animation = jQuery.extend(Animation, {
    tweeners: {
      "*": [function (prop, value) {
        var tween = this.createTween(prop, value);
        adjustCSS(tween.elem, prop, rcssNum.exec(value), tween);
        return tween;
      }]
    },
    tweener: function tweener(props, callback) {
      if (isFunction(props)) {
        callback = props;
        props = ["*"];
      } else {
        props = props.match(rnothtmlwhite);
      }

      var prop,
          index = 0,
          length = props.length;

      for (; index < length; index++) {
        prop = props[index];
        Animation.tweeners[prop] = Animation.tweeners[prop] || [];
        Animation.tweeners[prop].unshift(callback);
      }
    },
    prefilters: [defaultPrefilter],
    prefilter: function prefilter(callback, prepend) {
      if (prepend) {
        Animation.prefilters.unshift(callback);
      } else {
        Animation.prefilters.push(callback);
      }
    }
  });

  jQuery.speed = function (speed, easing, fn) {
    var opt = speed && _typeof(speed) === "object" ? jQuery.extend({}, speed) : {
      complete: fn || !fn && easing || isFunction(speed) && speed,
      duration: speed,
      easing: fn && easing || easing && !isFunction(easing) && easing
    }; // Go to the end state if fx are off

    if (jQuery.fx.off) {
      opt.duration = 0;
    } else {
      if (typeof opt.duration !== "number") {
        if (opt.duration in jQuery.fx.speeds) {
          opt.duration = jQuery.fx.speeds[opt.duration];
        } else {
          opt.duration = jQuery.fx.speeds._default;
        }
      }
    } // Normalize opt.queue - true/undefined/null -> "fx"


    if (opt.queue == null || opt.queue === true) {
      opt.queue = "fx";
    } // Queueing


    opt.old = opt.complete;

    opt.complete = function () {
      if (isFunction(opt.old)) {
        opt.old.call(this);
      }

      if (opt.queue) {
        jQuery.dequeue(this, opt.queue);
      }
    };

    return opt;
  };

  jQuery.fn.extend({
    fadeTo: function fadeTo(speed, to, easing, callback) {
      // Show any hidden elements after setting opacity to 0
      return this.filter(isHiddenWithinTree).css("opacity", 0).show() // Animate to the value specified
      .end().animate({
        opacity: to
      }, speed, easing, callback);
    },
    animate: function animate(prop, speed, easing, callback) {
      var empty = jQuery.isEmptyObject(prop),
          optall = jQuery.speed(speed, easing, callback),
          doAnimation = function doAnimation() {
        // Operate on a copy of prop so per-property easing won't be lost
        var anim = Animation(this, jQuery.extend({}, prop), optall); // Empty animations, or finishing resolves immediately

        if (empty || dataPriv.get(this, "finish")) {
          anim.stop(true);
        }
      };

      doAnimation.finish = doAnimation;
      return empty || optall.queue === false ? this.each(doAnimation) : this.queue(optall.queue, doAnimation);
    },
    stop: function stop(type, clearQueue, gotoEnd) {
      var stopQueue = function stopQueue(hooks) {
        var stop = hooks.stop;
        delete hooks.stop;
        stop(gotoEnd);
      };

      if (typeof type !== "string") {
        gotoEnd = clearQueue;
        clearQueue = type;
        type = undefined;
      }

      if (clearQueue) {
        this.queue(type || "fx", []);
      }

      return this.each(function () {
        var dequeue = true,
            index = type != null && type + "queueHooks",
            timers = jQuery.timers,
            data = dataPriv.get(this);

        if (index) {
          if (data[index] && data[index].stop) {
            stopQueue(data[index]);
          }
        } else {
          for (index in data) {
            if (data[index] && data[index].stop && rrun.test(index)) {
              stopQueue(data[index]);
            }
          }
        }

        for (index = timers.length; index--;) {
          if (timers[index].elem === this && (type == null || timers[index].queue === type)) {
            timers[index].anim.stop(gotoEnd);
            dequeue = false;
            timers.splice(index, 1);
          }
        } // Start the next in the queue if the last step wasn't forced.
        // Timers currently will call their complete callbacks, which
        // will dequeue but only if they were gotoEnd.


        if (dequeue || !gotoEnd) {
          jQuery.dequeue(this, type);
        }
      });
    },
    finish: function finish(type) {
      if (type !== false) {
        type = type || "fx";
      }

      return this.each(function () {
        var index,
            data = dataPriv.get(this),
            queue = data[type + "queue"],
            hooks = data[type + "queueHooks"],
            timers = jQuery.timers,
            length = queue ? queue.length : 0; // Enable finishing flag on private data

        data.finish = true; // Empty the queue first

        jQuery.queue(this, type, []);

        if (hooks && hooks.stop) {
          hooks.stop.call(this, true);
        } // Look for any active animations, and finish them


        for (index = timers.length; index--;) {
          if (timers[index].elem === this && timers[index].queue === type) {
            timers[index].anim.stop(true);
            timers.splice(index, 1);
          }
        } // Look for any animations in the old queue and finish them


        for (index = 0; index < length; index++) {
          if (queue[index] && queue[index].finish) {
            queue[index].finish.call(this);
          }
        } // Turn off finishing flag


        delete data.finish;
      });
    }
  });
  jQuery.each(["toggle", "show", "hide"], function (_i, name) {
    var cssFn = jQuery.fn[name];

    jQuery.fn[name] = function (speed, easing, callback) {
      return speed == null || typeof speed === "boolean" ? cssFn.apply(this, arguments) : this.animate(genFx(name, true), speed, easing, callback);
    };
  }); // Generate shortcuts for custom animations

  jQuery.each({
    slideDown: genFx("show"),
    slideUp: genFx("hide"),
    slideToggle: genFx("toggle"),
    fadeIn: {
      opacity: "show"
    },
    fadeOut: {
      opacity: "hide"
    },
    fadeToggle: {
      opacity: "toggle"
    }
  }, function (name, props) {
    jQuery.fn[name] = function (speed, easing, callback) {
      return this.animate(props, speed, easing, callback);
    };
  });
  jQuery.timers = [];

  jQuery.fx.tick = function () {
    var timer,
        i = 0,
        timers = jQuery.timers;
    fxNow = Date.now();

    for (; i < timers.length; i++) {
      timer = timers[i]; // Run the timer and safely remove it when done (allowing for external removal)

      if (!timer() && timers[i] === timer) {
        timers.splice(i--, 1);
      }
    }

    if (!timers.length) {
      jQuery.fx.stop();
    }

    fxNow = undefined;
  };

  jQuery.fx.timer = function (timer) {
    jQuery.timers.push(timer);
    jQuery.fx.start();
  };

  jQuery.fx.interval = 13;

  jQuery.fx.start = function () {
    if (inProgress) {
      return;
    }

    inProgress = true;
    schedule();
  };

  jQuery.fx.stop = function () {
    inProgress = null;
  };

  jQuery.fx.speeds = {
    slow: 600,
    fast: 200,
    // Default speed
    _default: 400
  }; // Based off of the plugin by Clint Helfers, with permission.
  // https://web.archive.org/web/20100324014747/http://blindsignals.com/index.php/2009/07/jquery-delay/

  jQuery.fn.delay = function (time, type) {
    time = jQuery.fx ? jQuery.fx.speeds[time] || time : time;
    type = type || "fx";
    return this.queue(type, function (next, hooks) {
      var timeout = window.setTimeout(next, time);

      hooks.stop = function () {
        window.clearTimeout(timeout);
      };
    });
  };

  (function () {
    var input = document.createElement("input"),
        select = document.createElement("select"),
        opt = select.appendChild(document.createElement("option"));
    input.type = "checkbox"; // Support: Android <=4.3 only
    // Default value for a checkbox should be "on"

    support.checkOn = input.value !== ""; // Support: IE <=11 only
    // Must access selectedIndex to make default options select

    support.optSelected = opt.selected; // Support: IE <=11 only
    // An input loses its value after becoming a radio

    input = document.createElement("input");
    input.value = "t";
    input.type = "radio";
    support.radioValue = input.value === "t";
  })();

  var boolHook,
      attrHandle = jQuery.expr.attrHandle;
  jQuery.fn.extend({
    attr: function attr(name, value) {
      return access(this, jQuery.attr, name, value, arguments.length > 1);
    },
    removeAttr: function removeAttr(name) {
      return this.each(function () {
        jQuery.removeAttr(this, name);
      });
    }
  });
  jQuery.extend({
    attr: function attr(elem, name, value) {
      var ret,
          hooks,
          nType = elem.nodeType; // Don't get/set attributes on text, comment and attribute nodes

      if (nType === 3 || nType === 8 || nType === 2) {
        return;
      } // Fallback to prop when attributes are not supported


      if (typeof elem.getAttribute === "undefined") {
        return jQuery.prop(elem, name, value);
      } // Attribute hooks are determined by the lowercase version
      // Grab necessary hook if one is defined


      if (nType !== 1 || !jQuery.isXMLDoc(elem)) {
        hooks = jQuery.attrHooks[name.toLowerCase()] || (jQuery.expr.match.bool.test(name) ? boolHook : undefined);
      }

      if (value !== undefined) {
        if (value === null) {
          jQuery.removeAttr(elem, name);
          return;
        }

        if (hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== undefined) {
          return ret;
        }

        elem.setAttribute(name, value + "");
        return value;
      }

      if (hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null) {
        return ret;
      }

      ret = jQuery.find.attr(elem, name); // Non-existent attributes return null, we normalize to undefined

      return ret == null ? undefined : ret;
    },
    attrHooks: {
      type: {
        set: function set(elem, value) {
          if (!support.radioValue && value === "radio" && nodeName(elem, "input")) {
            var val = elem.value;
            elem.setAttribute("type", value);

            if (val) {
              elem.value = val;
            }

            return value;
          }
        }
      }
    },
    removeAttr: function removeAttr(elem, value) {
      var name,
          i = 0,
          // Attribute names can contain non-HTML whitespace characters
      // https://html.spec.whatwg.org/multipage/syntax.html#attributes-2
      attrNames = value && value.match(rnothtmlwhite);

      if (attrNames && elem.nodeType === 1) {
        while (name = attrNames[i++]) {
          elem.removeAttribute(name);
        }
      }
    }
  }); // Hooks for boolean attributes

  boolHook = {
    set: function set(elem, value, name) {
      if (value === false) {
        // Remove boolean attributes when set to false
        jQuery.removeAttr(elem, name);
      } else {
        elem.setAttribute(name, name);
      }

      return name;
    }
  };
  jQuery.each(jQuery.expr.match.bool.source.match(/\w+/g), function (_i, name) {
    var getter = attrHandle[name] || jQuery.find.attr;

    attrHandle[name] = function (elem, name, isXML) {
      var ret,
          handle,
          lowercaseName = name.toLowerCase();

      if (!isXML) {
        // Avoid an infinite loop by temporarily removing this function from the getter
        handle = attrHandle[lowercaseName];
        attrHandle[lowercaseName] = ret;
        ret = getter(elem, name, isXML) != null ? lowercaseName : null;
        attrHandle[lowercaseName] = handle;
      }

      return ret;
    };
  });
  var rfocusable = /^(?:input|select|textarea|button)$/i,
      rclickable = /^(?:a|area)$/i;
  jQuery.fn.extend({
    prop: function prop(name, value) {
      return access(this, jQuery.prop, name, value, arguments.length > 1);
    },
    removeProp: function removeProp(name) {
      return this.each(function () {
        delete this[jQuery.propFix[name] || name];
      });
    }
  });
  jQuery.extend({
    prop: function prop(elem, name, value) {
      var ret,
          hooks,
          nType = elem.nodeType; // Don't get/set properties on text, comment and attribute nodes

      if (nType === 3 || nType === 8 || nType === 2) {
        return;
      }

      if (nType !== 1 || !jQuery.isXMLDoc(elem)) {
        // Fix name and attach hooks
        name = jQuery.propFix[name] || name;
        hooks = jQuery.propHooks[name];
      }

      if (value !== undefined) {
        if (hooks && "set" in hooks && (ret = hooks.set(elem, value, name)) !== undefined) {
          return ret;
        }

        return elem[name] = value;
      }

      if (hooks && "get" in hooks && (ret = hooks.get(elem, name)) !== null) {
        return ret;
      }

      return elem[name];
    },
    propHooks: {
      tabIndex: {
        get: function get(elem) {
          // Support: IE <=9 - 11 only
          // elem.tabIndex doesn't always return the
          // correct value when it hasn't been explicitly set
          // https://web.archive.org/web/20141116233347/http://fluidproject.org/blog/2008/01/09/getting-setting-and-removing-tabindex-values-with-javascript/
          // Use proper attribute retrieval(#12072)
          var tabindex = jQuery.find.attr(elem, "tabindex");

          if (tabindex) {
            return parseInt(tabindex, 10);
          }

          if (rfocusable.test(elem.nodeName) || rclickable.test(elem.nodeName) && elem.href) {
            return 0;
          }

          return -1;
        }
      }
    },
    propFix: {
      "for": "htmlFor",
      "class": "className"
    }
  }); // Support: IE <=11 only
  // Accessing the selectedIndex property
  // forces the browser to respect setting selected
  // on the option
  // The getter ensures a default option is selected
  // when in an optgroup
  // eslint rule "no-unused-expressions" is disabled for this code
  // since it considers such accessions noop

  if (!support.optSelected) {
    jQuery.propHooks.selected = {
      get: function get(elem) {
        /* eslint no-unused-expressions: "off" */
        var parent = elem.parentNode;

        if (parent && parent.parentNode) {
          parent.parentNode.selectedIndex;
        }

        return null;
      },
      set: function set(elem) {
        /* eslint no-unused-expressions: "off" */
        var parent = elem.parentNode;

        if (parent) {
          parent.selectedIndex;

          if (parent.parentNode) {
            parent.parentNode.selectedIndex;
          }
        }
      }
    };
  }

  jQuery.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
    jQuery.propFix[this.toLowerCase()] = this;
  }); // Strip and collapse whitespace according to HTML spec
  // https://infra.spec.whatwg.org/#strip-and-collapse-ascii-whitespace

  function stripAndCollapse(value) {
    var tokens = value.match(rnothtmlwhite) || [];
    return tokens.join(" ");
  }

  function getClass(elem) {
    return elem.getAttribute && elem.getAttribute("class") || "";
  }

  function classesToArray(value) {
    if (Array.isArray(value)) {
      return value;
    }

    if (typeof value === "string") {
      return value.match(rnothtmlwhite) || [];
    }

    return [];
  }

  jQuery.fn.extend({
    addClass: function addClass(value) {
      var classes,
          elem,
          cur,
          curValue,
          clazz,
          j,
          finalValue,
          i = 0;

      if (isFunction(value)) {
        return this.each(function (j) {
          jQuery(this).addClass(value.call(this, j, getClass(this)));
        });
      }

      classes = classesToArray(value);

      if (classes.length) {
        while (elem = this[i++]) {
          curValue = getClass(elem);
          cur = elem.nodeType === 1 && " " + stripAndCollapse(curValue) + " ";

          if (cur) {
            j = 0;

            while (clazz = classes[j++]) {
              if (cur.indexOf(" " + clazz + " ") < 0) {
                cur += clazz + " ";
              }
            } // Only assign if different to avoid unneeded rendering.


            finalValue = stripAndCollapse(cur);

            if (curValue !== finalValue) {
              elem.setAttribute("class", finalValue);
            }
          }
        }
      }

      return this;
    },
    removeClass: function removeClass(value) {
      var classes,
          elem,
          cur,
          curValue,
          clazz,
          j,
          finalValue,
          i = 0;

      if (isFunction(value)) {
        return this.each(function (j) {
          jQuery(this).removeClass(value.call(this, j, getClass(this)));
        });
      }

      if (!arguments.length) {
        return this.attr("class", "");
      }

      classes = classesToArray(value);

      if (classes.length) {
        while (elem = this[i++]) {
          curValue = getClass(elem); // This expression is here for better compressibility (see addClass)

          cur = elem.nodeType === 1 && " " + stripAndCollapse(curValue) + " ";

          if (cur) {
            j = 0;

            while (clazz = classes[j++]) {
              // Remove *all* instances
              while (cur.indexOf(" " + clazz + " ") > -1) {
                cur = cur.replace(" " + clazz + " ", " ");
              }
            } // Only assign if different to avoid unneeded rendering.


            finalValue = stripAndCollapse(cur);

            if (curValue !== finalValue) {
              elem.setAttribute("class", finalValue);
            }
          }
        }
      }

      return this;
    },
    toggleClass: function toggleClass(value, stateVal) {
      var type = _typeof(value),
          isValidValue = type === "string" || Array.isArray(value);

      if (typeof stateVal === "boolean" && isValidValue) {
        return stateVal ? this.addClass(value) : this.removeClass(value);
      }

      if (isFunction(value)) {
        return this.each(function (i) {
          jQuery(this).toggleClass(value.call(this, i, getClass(this), stateVal), stateVal);
        });
      }

      return this.each(function () {
        var className, i, self, classNames;

        if (isValidValue) {
          // Toggle individual class names
          i = 0;
          self = jQuery(this);
          classNames = classesToArray(value);

          while (className = classNames[i++]) {
            // Check each className given, space separated list
            if (self.hasClass(className)) {
              self.removeClass(className);
            } else {
              self.addClass(className);
            }
          } // Toggle whole class name

        } else if (value === undefined || type === "boolean") {
          className = getClass(this);

          if (className) {
            // Store className if set
            dataPriv.set(this, "__className__", className);
          } // If the element has a class name or if we're passed `false`,
          // then remove the whole classname (if there was one, the above saved it).
          // Otherwise bring back whatever was previously saved (if anything),
          // falling back to the empty string if nothing was stored.


          if (this.setAttribute) {
            this.setAttribute("class", className || value === false ? "" : dataPriv.get(this, "__className__") || "");
          }
        }
      });
    },
    hasClass: function hasClass(selector) {
      var className,
          elem,
          i = 0;
      className = " " + selector + " ";

      while (elem = this[i++]) {
        if (elem.nodeType === 1 && (" " + stripAndCollapse(getClass(elem)) + " ").indexOf(className) > -1) {
          return true;
        }
      }

      return false;
    }
  });
  var rreturn = /\r/g;
  jQuery.fn.extend({
    val: function val(value) {
      var hooks,
          ret,
          valueIsFunction,
          elem = this[0];

      if (!arguments.length) {
        if (elem) {
          hooks = jQuery.valHooks[elem.type] || jQuery.valHooks[elem.nodeName.toLowerCase()];

          if (hooks && "get" in hooks && (ret = hooks.get(elem, "value")) !== undefined) {
            return ret;
          }

          ret = elem.value; // Handle most common string cases

          if (typeof ret === "string") {
            return ret.replace(rreturn, "");
          } // Handle cases where value is null/undef or number


          return ret == null ? "" : ret;
        }

        return;
      }

      valueIsFunction = isFunction(value);
      return this.each(function (i) {
        var val;

        if (this.nodeType !== 1) {
          return;
        }

        if (valueIsFunction) {
          val = value.call(this, i, jQuery(this).val());
        } else {
          val = value;
        } // Treat null/undefined as ""; convert numbers to string


        if (val == null) {
          val = "";
        } else if (typeof val === "number") {
          val += "";
        } else if (Array.isArray(val)) {
          val = jQuery.map(val, function (value) {
            return value == null ? "" : value + "";
          });
        }

        hooks = jQuery.valHooks[this.type] || jQuery.valHooks[this.nodeName.toLowerCase()]; // If set returns undefined, fall back to normal setting

        if (!hooks || !("set" in hooks) || hooks.set(this, val, "value") === undefined) {
          this.value = val;
        }
      });
    }
  });
  jQuery.extend({
    valHooks: {
      option: {
        get: function get(elem) {
          var val = jQuery.find.attr(elem, "value");
          return val != null ? val : // Support: IE <=10 - 11 only
          // option.text throws exceptions (#14686, #14858)
          // Strip and collapse whitespace
          // https://html.spec.whatwg.org/#strip-and-collapse-whitespace
          stripAndCollapse(jQuery.text(elem));
        }
      },
      select: {
        get: function get(elem) {
          var value,
              option,
              i,
              options = elem.options,
              index = elem.selectedIndex,
              one = elem.type === "select-one",
              values = one ? null : [],
              max = one ? index + 1 : options.length;

          if (index < 0) {
            i = max;
          } else {
            i = one ? index : 0;
          } // Loop through all the selected options


          for (; i < max; i++) {
            option = options[i]; // Support: IE <=9 only
            // IE8-9 doesn't update selected after form reset (#2551)

            if ((option.selected || i === index) && // Don't return options that are disabled or in a disabled optgroup
            !option.disabled && (!option.parentNode.disabled || !nodeName(option.parentNode, "optgroup"))) {
              // Get the specific value for the option
              value = jQuery(option).val(); // We don't need an array for one selects

              if (one) {
                return value;
              } // Multi-Selects return an array


              values.push(value);
            }
          }

          return values;
        },
        set: function set(elem, value) {
          var optionSet,
              option,
              options = elem.options,
              values = jQuery.makeArray(value),
              i = options.length;

          while (i--) {
            option = options[i];
            /* eslint-disable no-cond-assign */

            if (option.selected = jQuery.inArray(jQuery.valHooks.option.get(option), values) > -1) {
              optionSet = true;
            }
            /* eslint-enable no-cond-assign */

          } // Force browsers to behave consistently when non-matching value is set


          if (!optionSet) {
            elem.selectedIndex = -1;
          }

          return values;
        }
      }
    }
  }); // Radios and checkboxes getter/setter

  jQuery.each(["radio", "checkbox"], function () {
    jQuery.valHooks[this] = {
      set: function set(elem, value) {
        if (Array.isArray(value)) {
          return elem.checked = jQuery.inArray(jQuery(elem).val(), value) > -1;
        }
      }
    };

    if (!support.checkOn) {
      jQuery.valHooks[this].get = function (elem) {
        return elem.getAttribute("value") === null ? "on" : elem.value;
      };
    }
  }); // Return jQuery for attributes-only inclusion

  support.focusin = "onfocusin" in window;

  var rfocusMorph = /^(?:focusinfocus|focusoutblur)$/,
      stopPropagationCallback = function stopPropagationCallback(e) {
    e.stopPropagation();
  };

  jQuery.extend(jQuery.event, {
    trigger: function trigger(event, data, elem, onlyHandlers) {
      var i,
          cur,
          tmp,
          bubbleType,
          ontype,
          handle,
          special,
          lastElement,
          eventPath = [elem || document],
          type = hasOwn.call(event, "type") ? event.type : event,
          namespaces = hasOwn.call(event, "namespace") ? event.namespace.split(".") : [];
      cur = lastElement = tmp = elem = elem || document; // Don't do events on text and comment nodes

      if (elem.nodeType === 3 || elem.nodeType === 8) {
        return;
      } // focus/blur morphs to focusin/out; ensure we're not firing them right now


      if (rfocusMorph.test(type + jQuery.event.triggered)) {
        return;
      }

      if (type.indexOf(".") > -1) {
        // Namespaced trigger; create a regexp to match event type in handle()
        namespaces = type.split(".");
        type = namespaces.shift();
        namespaces.sort();
      }

      ontype = type.indexOf(":") < 0 && "on" + type; // Caller can pass in a jQuery.Event object, Object, or just an event type string

      event = event[jQuery.expando] ? event : new jQuery.Event(type, _typeof(event) === "object" && event); // Trigger bitmask: & 1 for native handlers; & 2 for jQuery (always true)

      event.isTrigger = onlyHandlers ? 2 : 3;
      event.namespace = namespaces.join(".");
      event.rnamespace = event.namespace ? new RegExp("(^|\\.)" + namespaces.join("\\.(?:.*\\.|)") + "(\\.|$)") : null; // Clean up the event in case it is being reused

      event.result = undefined;

      if (!event.target) {
        event.target = elem;
      } // Clone any incoming data and prepend the event, creating the handler arg list


      data = data == null ? [event] : jQuery.makeArray(data, [event]); // Allow special events to draw outside the lines

      special = jQuery.event.special[type] || {};

      if (!onlyHandlers && special.trigger && special.trigger.apply(elem, data) === false) {
        return;
      } // Determine event propagation path in advance, per W3C events spec (#9951)
      // Bubble up to document, then to window; watch for a global ownerDocument var (#9724)


      if (!onlyHandlers && !special.noBubble && !isWindow(elem)) {
        bubbleType = special.delegateType || type;

        if (!rfocusMorph.test(bubbleType + type)) {
          cur = cur.parentNode;
        }

        for (; cur; cur = cur.parentNode) {
          eventPath.push(cur);
          tmp = cur;
        } // Only add window if we got to document (e.g., not plain obj or detached DOM)


        if (tmp === (elem.ownerDocument || document)) {
          eventPath.push(tmp.defaultView || tmp.parentWindow || window);
        }
      } // Fire handlers on the event path


      i = 0;

      while ((cur = eventPath[i++]) && !event.isPropagationStopped()) {
        lastElement = cur;
        event.type = i > 1 ? bubbleType : special.bindType || type; // jQuery handler

        handle = (dataPriv.get(cur, "events") || Object.create(null))[event.type] && dataPriv.get(cur, "handle");

        if (handle) {
          handle.apply(cur, data);
        } // Native handler


        handle = ontype && cur[ontype];

        if (handle && handle.apply && acceptData(cur)) {
          event.result = handle.apply(cur, data);

          if (event.result === false) {
            event.preventDefault();
          }
        }
      }

      event.type = type; // If nobody prevented the default action, do it now

      if (!onlyHandlers && !event.isDefaultPrevented()) {
        if ((!special._default || special._default.apply(eventPath.pop(), data) === false) && acceptData(elem)) {
          // Call a native DOM method on the target with the same name as the event.
          // Don't do default actions on window, that's where global variables be (#6170)
          if (ontype && isFunction(elem[type]) && !isWindow(elem)) {
            // Don't re-trigger an onFOO event when we call its FOO() method
            tmp = elem[ontype];

            if (tmp) {
              elem[ontype] = null;
            } // Prevent re-triggering of the same event, since we already bubbled it above


            jQuery.event.triggered = type;

            if (event.isPropagationStopped()) {
              lastElement.addEventListener(type, stopPropagationCallback);
            }

            elem[type]();

            if (event.isPropagationStopped()) {
              lastElement.removeEventListener(type, stopPropagationCallback);
            }

            jQuery.event.triggered = undefined;

            if (tmp) {
              elem[ontype] = tmp;
            }
          }
        }
      }

      return event.result;
    },
    // Piggyback on a donor event to simulate a different one
    // Used only for `focus(in | out)` events
    simulate: function simulate(type, elem, event) {
      var e = jQuery.extend(new jQuery.Event(), event, {
        type: type,
        isSimulated: true
      });
      jQuery.event.trigger(e, null, elem);
    }
  });
  jQuery.fn.extend({
    trigger: function trigger(type, data) {
      return this.each(function () {
        jQuery.event.trigger(type, data, this);
      });
    },
    triggerHandler: function triggerHandler(type, data) {
      var elem = this[0];

      if (elem) {
        return jQuery.event.trigger(type, data, elem, true);
      }
    }
  }); // Support: Firefox <=44
  // Firefox doesn't have focus(in | out) events
  // Related ticket - https://bugzilla.mozilla.org/show_bug.cgi?id=687787
  //
  // Support: Chrome <=48 - 49, Safari <=9.0 - 9.1
  // focus(in | out) events fire after focus & blur events,
  // which is spec violation - http://www.w3.org/TR/DOM-Level-3-Events/#events-focusevent-event-order
  // Related ticket - https://bugs.chromium.org/p/chromium/issues/detail?id=449857

  if (!support.focusin) {
    jQuery.each({
      focus: "focusin",
      blur: "focusout"
    }, function (orig, fix) {
      // Attach a single capturing handler on the document while someone wants focusin/focusout
      var handler = function handler(event) {
        jQuery.event.simulate(fix, event.target, jQuery.event.fix(event));
      };

      jQuery.event.special[fix] = {
        setup: function setup() {
          // Handle: regular nodes (via `this.ownerDocument`), window
          // (via `this.document`) & document (via `this`).
          var doc = this.ownerDocument || this.document || this,
              attaches = dataPriv.access(doc, fix);

          if (!attaches) {
            doc.addEventListener(orig, handler, true);
          }

          dataPriv.access(doc, fix, (attaches || 0) + 1);
        },
        teardown: function teardown() {
          var doc = this.ownerDocument || this.document || this,
              attaches = dataPriv.access(doc, fix) - 1;

          if (!attaches) {
            doc.removeEventListener(orig, handler, true);
            dataPriv.remove(doc, fix);
          } else {
            dataPriv.access(doc, fix, attaches);
          }
        }
      };
    });
  }

  var location = window.location;
  var nonce = {
    guid: Date.now()
  };
  var rquery = /\?/; // Cross-browser xml parsing

  jQuery.parseXML = function (data) {
    var xml;

    if (!data || typeof data !== "string") {
      return null;
    } // Support: IE 9 - 11 only
    // IE throws on parseFromString with invalid input.


    try {
      xml = new window.DOMParser().parseFromString(data, "text/xml");
    } catch (e) {
      xml = undefined;
    }

    if (!xml || xml.getElementsByTagName("parsererror").length) {
      jQuery.error("Invalid XML: " + data);
    }

    return xml;
  };

  var rbracket = /\[\]$/,
      rCRLF = /\r?\n/g,
      rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
      rsubmittable = /^(?:input|select|textarea|keygen)/i;

  function buildParams(prefix, obj, traditional, add) {
    var name;

    if (Array.isArray(obj)) {
      // Serialize array item.
      jQuery.each(obj, function (i, v) {
        if (traditional || rbracket.test(prefix)) {
          // Treat each array item as a scalar.
          add(prefix, v);
        } else {
          // Item is non-scalar (array or object), encode its numeric index.
          buildParams(prefix + "[" + (_typeof(v) === "object" && v != null ? i : "") + "]", v, traditional, add);
        }
      });
    } else if (!traditional && toType(obj) === "object") {
      // Serialize object item.
      for (name in obj) {
        buildParams(prefix + "[" + name + "]", obj[name], traditional, add);
      }
    } else {
      // Serialize scalar item.
      add(prefix, obj);
    }
  } // Serialize an array of form elements or a set of
  // key/values into a query string


  jQuery.param = function (a, traditional) {
    var prefix,
        s = [],
        add = function add(key, valueOrFunction) {
      // If value is a function, invoke it and use its return value
      var value = isFunction(valueOrFunction) ? valueOrFunction() : valueOrFunction;
      s[s.length] = encodeURIComponent(key) + "=" + encodeURIComponent(value == null ? "" : value);
    };

    if (a == null) {
      return "";
    } // If an array was passed in, assume that it is an array of form elements.


    if (Array.isArray(a) || a.jquery && !jQuery.isPlainObject(a)) {
      // Serialize the form elements
      jQuery.each(a, function () {
        add(this.name, this.value);
      });
    } else {
      // If traditional, encode the "old" way (the way 1.3.2 or older
      // did it), otherwise encode params recursively.
      for (prefix in a) {
        buildParams(prefix, a[prefix], traditional, add);
      }
    } // Return the resulting serialization


    return s.join("&");
  };

  jQuery.fn.extend({
    serialize: function serialize() {
      return jQuery.param(this.serializeArray());
    },
    serializeArray: function serializeArray() {
      return this.map(function () {
        // Can add propHook for "elements" to filter or add form elements
        var elements = jQuery.prop(this, "elements");
        return elements ? jQuery.makeArray(elements) : this;
      }).filter(function () {
        var type = this.type; // Use .is( ":disabled" ) so that fieldset[disabled] works

        return this.name && !jQuery(this).is(":disabled") && rsubmittable.test(this.nodeName) && !rsubmitterTypes.test(type) && (this.checked || !rcheckableType.test(type));
      }).map(function (_i, elem) {
        var val = jQuery(this).val();

        if (val == null) {
          return null;
        }

        if (Array.isArray(val)) {
          return jQuery.map(val, function (val) {
            return {
              name: elem.name,
              value: val.replace(rCRLF, "\r\n")
            };
          });
        }

        return {
          name: elem.name,
          value: val.replace(rCRLF, "\r\n")
        };
      }).get();
    }
  });
  var r20 = /%20/g,
      rhash = /#.*$/,
      rantiCache = /([?&])_=[^&]*/,
      rheaders = /^(.*?):[ \t]*([^\r\n]*)$/mg,
      // #7653, #8125, #8152: local protocol detection
  rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
      rnoContent = /^(?:GET|HEAD)$/,
      rprotocol = /^\/\//,

  /* Prefilters
   * 1) They are useful to introduce custom dataTypes (see ajax/jsonp.js for an example)
   * 2) These are called:
   *    - BEFORE asking for a transport
   *    - AFTER param serialization (s.data is a string if s.processData is true)
   * 3) key is the dataType
   * 4) the catchall symbol "*" can be used
   * 5) execution will start with transport dataType and THEN continue down to "*" if needed
   */
  prefilters = {},

  /* Transports bindings
   * 1) key is the dataType
   * 2) the catchall symbol "*" can be used
   * 3) selection will start with transport dataType and THEN go to "*" if needed
   */
  transports = {},
      // Avoid comment-prolog char sequence (#10098); must appease lint and evade compression
  allTypes = "*/".concat("*"),
      // Anchor tag for parsing the document origin
  originAnchor = document.createElement("a");
  originAnchor.href = location.href; // Base "constructor" for jQuery.ajaxPrefilter and jQuery.ajaxTransport

  function addToPrefiltersOrTransports(structure) {
    // dataTypeExpression is optional and defaults to "*"
    return function (dataTypeExpression, func) {
      if (typeof dataTypeExpression !== "string") {
        func = dataTypeExpression;
        dataTypeExpression = "*";
      }

      var dataType,
          i = 0,
          dataTypes = dataTypeExpression.toLowerCase().match(rnothtmlwhite) || [];

      if (isFunction(func)) {
        // For each dataType in the dataTypeExpression
        while (dataType = dataTypes[i++]) {
          // Prepend if requested
          if (dataType[0] === "+") {
            dataType = dataType.slice(1) || "*";
            (structure[dataType] = structure[dataType] || []).unshift(func); // Otherwise append
          } else {
            (structure[dataType] = structure[dataType] || []).push(func);
          }
        }
      }
    };
  } // Base inspection function for prefilters and transports


  function inspectPrefiltersOrTransports(structure, options, originalOptions, jqXHR) {
    var inspected = {},
        seekingTransport = structure === transports;

    function inspect(dataType) {
      var selected;
      inspected[dataType] = true;
      jQuery.each(structure[dataType] || [], function (_, prefilterOrFactory) {
        var dataTypeOrTransport = prefilterOrFactory(options, originalOptions, jqXHR);

        if (typeof dataTypeOrTransport === "string" && !seekingTransport && !inspected[dataTypeOrTransport]) {
          options.dataTypes.unshift(dataTypeOrTransport);
          inspect(dataTypeOrTransport);
          return false;
        } else if (seekingTransport) {
          return !(selected = dataTypeOrTransport);
        }
      });
      return selected;
    }

    return inspect(options.dataTypes[0]) || !inspected["*"] && inspect("*");
  } // A special extend for ajax options
  // that takes "flat" options (not to be deep extended)
  // Fixes #9887


  function ajaxExtend(target, src) {
    var key,
        deep,
        flatOptions = jQuery.ajaxSettings.flatOptions || {};

    for (key in src) {
      if (src[key] !== undefined) {
        (flatOptions[key] ? target : deep || (deep = {}))[key] = src[key];
      }
    }

    if (deep) {
      jQuery.extend(true, target, deep);
    }

    return target;
  }
  /* Handles responses to an ajax request:
   * - finds the right dataType (mediates between content-type and expected dataType)
   * - returns the corresponding response
   */


  function ajaxHandleResponses(s, jqXHR, responses) {
    var ct,
        type,
        finalDataType,
        firstDataType,
        contents = s.contents,
        dataTypes = s.dataTypes; // Remove auto dataType and get content-type in the process

    while (dataTypes[0] === "*") {
      dataTypes.shift();

      if (ct === undefined) {
        ct = s.mimeType || jqXHR.getResponseHeader("Content-Type");
      }
    } // Check if we're dealing with a known content-type


    if (ct) {
      for (type in contents) {
        if (contents[type] && contents[type].test(ct)) {
          dataTypes.unshift(type);
          break;
        }
      }
    } // Check to see if we have a response for the expected dataType


    if (dataTypes[0] in responses) {
      finalDataType = dataTypes[0];
    } else {
      // Try convertible dataTypes
      for (type in responses) {
        if (!dataTypes[0] || s.converters[type + " " + dataTypes[0]]) {
          finalDataType = type;
          break;
        }

        if (!firstDataType) {
          firstDataType = type;
        }
      } // Or just use first one


      finalDataType = finalDataType || firstDataType;
    } // If we found a dataType
    // We add the dataType to the list if needed
    // and return the corresponding response


    if (finalDataType) {
      if (finalDataType !== dataTypes[0]) {
        dataTypes.unshift(finalDataType);
      }

      return responses[finalDataType];
    }
  }
  /* Chain conversions given the request and the original response
   * Also sets the responseXXX fields on the jqXHR instance
   */


  function ajaxConvert(s, response, jqXHR, isSuccess) {
    var conv2,
        current,
        conv,
        tmp,
        prev,
        converters = {},
        // Work with a copy of dataTypes in case we need to modify it for conversion
    dataTypes = s.dataTypes.slice(); // Create converters map with lowercased keys

    if (dataTypes[1]) {
      for (conv in s.converters) {
        converters[conv.toLowerCase()] = s.converters[conv];
      }
    }

    current = dataTypes.shift(); // Convert to each sequential dataType

    while (current) {
      if (s.responseFields[current]) {
        jqXHR[s.responseFields[current]] = response;
      } // Apply the dataFilter if provided


      if (!prev && isSuccess && s.dataFilter) {
        response = s.dataFilter(response, s.dataType);
      }

      prev = current;
      current = dataTypes.shift();

      if (current) {
        // There's only work to do if current dataType is non-auto
        if (current === "*") {
          current = prev; // Convert response if prev dataType is non-auto and differs from current
        } else if (prev !== "*" && prev !== current) {
          // Seek a direct converter
          conv = converters[prev + " " + current] || converters["* " + current]; // If none found, seek a pair

          if (!conv) {
            for (conv2 in converters) {
              // If conv2 outputs current
              tmp = conv2.split(" ");

              if (tmp[1] === current) {
                // If prev can be converted to accepted input
                conv = converters[prev + " " + tmp[0]] || converters["* " + tmp[0]];

                if (conv) {
                  // Condense equivalence converters
                  if (conv === true) {
                    conv = converters[conv2]; // Otherwise, insert the intermediate dataType
                  } else if (converters[conv2] !== true) {
                    current = tmp[0];
                    dataTypes.unshift(tmp[1]);
                  }

                  break;
                }
              }
            }
          } // Apply converter (if not an equivalence)


          if (conv !== true) {
            // Unless errors are allowed to bubble, catch and return them
            if (conv && s["throws"]) {
              response = conv(response);
            } else {
              try {
                response = conv(response);
              } catch (e) {
                return {
                  state: "parsererror",
                  error: conv ? e : "No conversion from " + prev + " to " + current
                };
              }
            }
          }
        }
      }
    }

    return {
      state: "success",
      data: response
    };
  }

  jQuery.extend({
    // Counter for holding the number of active queries
    active: 0,
    // Last-Modified header cache for next request
    lastModified: {},
    etag: {},
    ajaxSettings: {
      url: location.href,
      type: "GET",
      isLocal: rlocalProtocol.test(location.protocol),
      global: true,
      processData: true,
      async: true,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",

      /*
      timeout: 0,
      data: null,
      dataType: null,
      username: null,
      password: null,
      cache: null,
      throws: false,
      traditional: false,
      headers: {},
      */
      accepts: {
        "*": allTypes,
        text: "text/plain",
        html: "text/html",
        xml: "application/xml, text/xml",
        json: "application/json, text/javascript"
      },
      contents: {
        xml: /\bxml\b/,
        html: /\bhtml/,
        json: /\bjson\b/
      },
      responseFields: {
        xml: "responseXML",
        text: "responseText",
        json: "responseJSON"
      },
      // Data converters
      // Keys separate source (or catchall "*") and destination types with a single space
      converters: {
        // Convert anything to text
        "* text": String,
        // Text to html (true = no transformation)
        "text html": true,
        // Evaluate text as a json expression
        "text json": JSON.parse,
        // Parse text as xml
        "text xml": jQuery.parseXML
      },
      // For options that shouldn't be deep extended:
      // you can add your own custom options here if
      // and when you create one that shouldn't be
      // deep extended (see ajaxExtend)
      flatOptions: {
        url: true,
        context: true
      }
    },
    // Creates a full fledged settings object into target
    // with both ajaxSettings and settings fields.
    // If target is omitted, writes into ajaxSettings.
    ajaxSetup: function ajaxSetup(target, settings) {
      return settings ? // Building a settings object
      ajaxExtend(ajaxExtend(target, jQuery.ajaxSettings), settings) : // Extending ajaxSettings
      ajaxExtend(jQuery.ajaxSettings, target);
    },
    ajaxPrefilter: addToPrefiltersOrTransports(prefilters),
    ajaxTransport: addToPrefiltersOrTransports(transports),
    // Main method
    ajax: function ajax(url, options) {
      // If url is an object, simulate pre-1.5 signature
      if (_typeof(url) === "object") {
        options = url;
        url = undefined;
      } // Force options to be an object


      options = options || {};

      var transport,
          // URL without anti-cache param
      cacheURL,
          // Response headers
      responseHeadersString,
          responseHeaders,
          // timeout handle
      timeoutTimer,
          // Url cleanup var
      urlAnchor,
          // Request state (becomes false upon send and true upon completion)
      completed,
          // To know if global events are to be dispatched
      fireGlobals,
          // Loop variable
      i,
          // uncached part of the url
      uncached,
          // Create the final options object
      s = jQuery.ajaxSetup({}, options),
          // Callbacks context
      callbackContext = s.context || s,
          // Context for global events is callbackContext if it is a DOM node or jQuery collection
      globalEventContext = s.context && (callbackContext.nodeType || callbackContext.jquery) ? jQuery(callbackContext) : jQuery.event,
          // Deferreds
      deferred = jQuery.Deferred(),
          completeDeferred = jQuery.Callbacks("once memory"),
          // Status-dependent callbacks
      _statusCode = s.statusCode || {},
          // Headers (they are sent all at once)
      requestHeaders = {},
          requestHeadersNames = {},
          // Default abort message
      strAbort = "canceled",
          // Fake xhr
      jqXHR = {
        readyState: 0,
        // Builds headers hashtable if needed
        getResponseHeader: function getResponseHeader(key) {
          var match;

          if (completed) {
            if (!responseHeaders) {
              responseHeaders = {};

              while (match = rheaders.exec(responseHeadersString)) {
                responseHeaders[match[1].toLowerCase() + " "] = (responseHeaders[match[1].toLowerCase() + " "] || []).concat(match[2]);
              }
            }

            match = responseHeaders[key.toLowerCase() + " "];
          }

          return match == null ? null : match.join(", ");
        },
        // Raw string
        getAllResponseHeaders: function getAllResponseHeaders() {
          return completed ? responseHeadersString : null;
        },
        // Caches the header
        setRequestHeader: function setRequestHeader(name, value) {
          if (completed == null) {
            name = requestHeadersNames[name.toLowerCase()] = requestHeadersNames[name.toLowerCase()] || name;
            requestHeaders[name] = value;
          }

          return this;
        },
        // Overrides response content-type header
        overrideMimeType: function overrideMimeType(type) {
          if (completed == null) {
            s.mimeType = type;
          }

          return this;
        },
        // Status-dependent callbacks
        statusCode: function statusCode(map) {
          var code;

          if (map) {
            if (completed) {
              // Execute the appropriate callbacks
              jqXHR.always(map[jqXHR.status]);
            } else {
              // Lazy-add the new callbacks in a way that preserves old ones
              for (code in map) {
                _statusCode[code] = [_statusCode[code], map[code]];
              }
            }
          }

          return this;
        },
        // Cancel the request
        abort: function abort(statusText) {
          var finalText = statusText || strAbort;

          if (transport) {
            transport.abort(finalText);
          }

          done(0, finalText);
          return this;
        }
      }; // Attach deferreds


      deferred.promise(jqXHR); // Add protocol if not provided (prefilters might expect it)
      // Handle falsy url in the settings object (#10093: consistency with old signature)
      // We also use the url parameter if available

      s.url = ((url || s.url || location.href) + "").replace(rprotocol, location.protocol + "//"); // Alias method option to type as per ticket #12004

      s.type = options.method || options.type || s.method || s.type; // Extract dataTypes list

      s.dataTypes = (s.dataType || "*").toLowerCase().match(rnothtmlwhite) || [""]; // A cross-domain request is in order when the origin doesn't match the current origin.

      if (s.crossDomain == null) {
        urlAnchor = document.createElement("a"); // Support: IE <=8 - 11, Edge 12 - 15
        // IE throws exception on accessing the href property if url is malformed,
        // e.g. http://example.com:80x/

        try {
          urlAnchor.href = s.url; // Support: IE <=8 - 11 only
          // Anchor's host property isn't correctly set when s.url is relative

          urlAnchor.href = urlAnchor.href;
          s.crossDomain = originAnchor.protocol + "//" + originAnchor.host !== urlAnchor.protocol + "//" + urlAnchor.host;
        } catch (e) {
          // If there is an error parsing the URL, assume it is crossDomain,
          // it can be rejected by the transport if it is invalid
          s.crossDomain = true;
        }
      } // Convert data if not already a string


      if (s.data && s.processData && typeof s.data !== "string") {
        s.data = jQuery.param(s.data, s.traditional);
      } // Apply prefilters


      inspectPrefiltersOrTransports(prefilters, s, options, jqXHR); // If request was aborted inside a prefilter, stop there

      if (completed) {
        return jqXHR;
      } // We can fire global events as of now if asked to
      // Don't fire events if jQuery.event is undefined in an AMD-usage scenario (#15118)


      fireGlobals = jQuery.event && s.global; // Watch for a new set of requests

      if (fireGlobals && jQuery.active++ === 0) {
        jQuery.event.trigger("ajaxStart");
      } // Uppercase the type


      s.type = s.type.toUpperCase(); // Determine if request has content

      s.hasContent = !rnoContent.test(s.type); // Save the URL in case we're toying with the If-Modified-Since
      // and/or If-None-Match header later on
      // Remove hash to simplify url manipulation

      cacheURL = s.url.replace(rhash, ""); // More options handling for requests with no content

      if (!s.hasContent) {
        // Remember the hash so we can put it back
        uncached = s.url.slice(cacheURL.length); // If data is available and should be processed, append data to url

        if (s.data && (s.processData || typeof s.data === "string")) {
          cacheURL += (rquery.test(cacheURL) ? "&" : "?") + s.data; // #9682: remove data so that it's not used in an eventual retry

          delete s.data;
        } // Add or update anti-cache param if needed


        if (s.cache === false) {
          cacheURL = cacheURL.replace(rantiCache, "$1");
          uncached = (rquery.test(cacheURL) ? "&" : "?") + "_=" + nonce.guid++ + uncached;
        } // Put hash and anti-cache on the URL that will be requested (gh-1732)


        s.url = cacheURL + uncached; // Change '%20' to '+' if this is encoded form body content (gh-2658)
      } else if (s.data && s.processData && (s.contentType || "").indexOf("application/x-www-form-urlencoded") === 0) {
        s.data = s.data.replace(r20, "+");
      } // Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.


      if (s.ifModified) {
        if (jQuery.lastModified[cacheURL]) {
          jqXHR.setRequestHeader("If-Modified-Since", jQuery.lastModified[cacheURL]);
        }

        if (jQuery.etag[cacheURL]) {
          jqXHR.setRequestHeader("If-None-Match", jQuery.etag[cacheURL]);
        }
      } // Set the correct header, if data is being sent


      if (s.data && s.hasContent && s.contentType !== false || options.contentType) {
        jqXHR.setRequestHeader("Content-Type", s.contentType);
      } // Set the Accepts header for the server, depending on the dataType


      jqXHR.setRequestHeader("Accept", s.dataTypes[0] && s.accepts[s.dataTypes[0]] ? s.accepts[s.dataTypes[0]] + (s.dataTypes[0] !== "*" ? ", " + allTypes + "; q=0.01" : "") : s.accepts["*"]); // Check for headers option

      for (i in s.headers) {
        jqXHR.setRequestHeader(i, s.headers[i]);
      } // Allow custom headers/mimetypes and early abort


      if (s.beforeSend && (s.beforeSend.call(callbackContext, jqXHR, s) === false || completed)) {
        // Abort if not done already and return
        return jqXHR.abort();
      } // Aborting is no longer a cancellation


      strAbort = "abort"; // Install callbacks on deferreds

      completeDeferred.add(s.complete);
      jqXHR.done(s.success);
      jqXHR.fail(s.error); // Get transport

      transport = inspectPrefiltersOrTransports(transports, s, options, jqXHR); // If no transport, we auto-abort

      if (!transport) {
        done(-1, "No Transport");
      } else {
        jqXHR.readyState = 1; // Send global event

        if (fireGlobals) {
          globalEventContext.trigger("ajaxSend", [jqXHR, s]);
        } // If request was aborted inside ajaxSend, stop there


        if (completed) {
          return jqXHR;
        } // Timeout


        if (s.async && s.timeout > 0) {
          timeoutTimer = window.setTimeout(function () {
            jqXHR.abort("timeout");
          }, s.timeout);
        }

        try {
          completed = false;
          transport.send(requestHeaders, done);
        } catch (e) {
          // Rethrow post-completion exceptions
          if (completed) {
            throw e;
          } // Propagate others as results


          done(-1, e);
        }
      } // Callback for when everything is done


      function done(status, nativeStatusText, responses, headers) {
        var isSuccess,
            success,
            error,
            response,
            modified,
            statusText = nativeStatusText; // Ignore repeat invocations

        if (completed) {
          return;
        }

        completed = true; // Clear timeout if it exists

        if (timeoutTimer) {
          window.clearTimeout(timeoutTimer);
        } // Dereference transport for early garbage collection
        // (no matter how long the jqXHR object will be used)


        transport = undefined; // Cache response headers

        responseHeadersString = headers || ""; // Set readyState

        jqXHR.readyState = status > 0 ? 4 : 0; // Determine if successful

        isSuccess = status >= 200 && status < 300 || status === 304; // Get response data

        if (responses) {
          response = ajaxHandleResponses(s, jqXHR, responses);
        } // Use a noop converter for missing script


        if (!isSuccess && jQuery.inArray("script", s.dataTypes) > -1) {
          s.converters["text script"] = function () {};
        } // Convert no matter what (that way responseXXX fields are always set)


        response = ajaxConvert(s, response, jqXHR, isSuccess); // If successful, handle type chaining

        if (isSuccess) {
          // Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
          if (s.ifModified) {
            modified = jqXHR.getResponseHeader("Last-Modified");

            if (modified) {
              jQuery.lastModified[cacheURL] = modified;
            }

            modified = jqXHR.getResponseHeader("etag");

            if (modified) {
              jQuery.etag[cacheURL] = modified;
            }
          } // if no content


          if (status === 204 || s.type === "HEAD") {
            statusText = "nocontent"; // if not modified
          } else if (status === 304) {
            statusText = "notmodified"; // If we have data, let's convert it
          } else {
            statusText = response.state;
            success = response.data;
            error = response.error;
            isSuccess = !error;
          }
        } else {
          // Extract error from statusText and normalize for non-aborts
          error = statusText;

          if (status || !statusText) {
            statusText = "error";

            if (status < 0) {
              status = 0;
            }
          }
        } // Set data for the fake xhr object


        jqXHR.status = status;
        jqXHR.statusText = (nativeStatusText || statusText) + ""; // Success/Error

        if (isSuccess) {
          deferred.resolveWith(callbackContext, [success, statusText, jqXHR]);
        } else {
          deferred.rejectWith(callbackContext, [jqXHR, statusText, error]);
        } // Status-dependent callbacks


        jqXHR.statusCode(_statusCode);
        _statusCode = undefined;

        if (fireGlobals) {
          globalEventContext.trigger(isSuccess ? "ajaxSuccess" : "ajaxError", [jqXHR, s, isSuccess ? success : error]);
        } // Complete


        completeDeferred.fireWith(callbackContext, [jqXHR, statusText]);

        if (fireGlobals) {
          globalEventContext.trigger("ajaxComplete", [jqXHR, s]); // Handle the global AJAX counter

          if (! --jQuery.active) {
            jQuery.event.trigger("ajaxStop");
          }
        }
      }

      return jqXHR;
    },
    getJSON: function getJSON(url, data, callback) {
      return jQuery.get(url, data, callback, "json");
    },
    getScript: function getScript(url, callback) {
      return jQuery.get(url, undefined, callback, "script");
    }
  });
  jQuery.each(["get", "post"], function (_i, method) {
    jQuery[method] = function (url, data, callback, type) {
      // Shift arguments if data argument was omitted
      if (isFunction(data)) {
        type = type || callback;
        callback = data;
        data = undefined;
      } // The url can be an options object (which then must have .url)


      return jQuery.ajax(jQuery.extend({
        url: url,
        type: method,
        dataType: type,
        data: data,
        success: callback
      }, jQuery.isPlainObject(url) && url));
    };
  });
  jQuery.ajaxPrefilter(function (s) {
    var i;

    for (i in s.headers) {
      if (i.toLowerCase() === "content-type") {
        s.contentType = s.headers[i] || "";
      }
    }
  });

  jQuery._evalUrl = function (url, options, doc) {
    return jQuery.ajax({
      url: url,
      // Make this explicit, since user can override this through ajaxSetup (#11264)
      type: "GET",
      dataType: "script",
      cache: true,
      async: false,
      global: false,
      // Only evaluate the response if it is successful (gh-4126)
      // dataFilter is not invoked for failure responses, so using it instead
      // of the default converter is kludgy but it works.
      converters: {
        "text script": function textScript() {}
      },
      dataFilter: function dataFilter(response) {
        jQuery.globalEval(response, options, doc);
      }
    });
  };

  jQuery.fn.extend({
    wrapAll: function wrapAll(html) {
      var wrap;

      if (this[0]) {
        if (isFunction(html)) {
          html = html.call(this[0]);
        } // The elements to wrap the target around


        wrap = jQuery(html, this[0].ownerDocument).eq(0).clone(true);

        if (this[0].parentNode) {
          wrap.insertBefore(this[0]);
        }

        wrap.map(function () {
          var elem = this;

          while (elem.firstElementChild) {
            elem = elem.firstElementChild;
          }

          return elem;
        }).append(this);
      }

      return this;
    },
    wrapInner: function wrapInner(html) {
      if (isFunction(html)) {
        return this.each(function (i) {
          jQuery(this).wrapInner(html.call(this, i));
        });
      }

      return this.each(function () {
        var self = jQuery(this),
            contents = self.contents();

        if (contents.length) {
          contents.wrapAll(html);
        } else {
          self.append(html);
        }
      });
    },
    wrap: function wrap(html) {
      var htmlIsFunction = isFunction(html);
      return this.each(function (i) {
        jQuery(this).wrapAll(htmlIsFunction ? html.call(this, i) : html);
      });
    },
    unwrap: function unwrap(selector) {
      this.parent(selector).not("body").each(function () {
        jQuery(this).replaceWith(this.childNodes);
      });
      return this;
    }
  });

  jQuery.expr.pseudos.hidden = function (elem) {
    return !jQuery.expr.pseudos.visible(elem);
  };

  jQuery.expr.pseudos.visible = function (elem) {
    return !!(elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length);
  };

  jQuery.ajaxSettings.xhr = function () {
    try {
      return new window.XMLHttpRequest();
    } catch (e) {}
  };

  var xhrSuccessStatus = {
    // File protocol always yields status code 0, assume 200
    0: 200,
    // Support: IE <=9 only
    // #1450: sometimes IE returns 1223 when it should be 204
    1223: 204
  },
      xhrSupported = jQuery.ajaxSettings.xhr();
  support.cors = !!xhrSupported && "withCredentials" in xhrSupported;
  support.ajax = xhrSupported = !!xhrSupported;
  jQuery.ajaxTransport(function (options) {
    var _callback, errorCallback; // Cross domain only allowed if supported through XMLHttpRequest


    if (support.cors || xhrSupported && !options.crossDomain) {
      return {
        send: function send(headers, complete) {
          var i,
              xhr = options.xhr();
          xhr.open(options.type, options.url, options.async, options.username, options.password); // Apply custom fields if provided

          if (options.xhrFields) {
            for (i in options.xhrFields) {
              xhr[i] = options.xhrFields[i];
            }
          } // Override mime type if needed


          if (options.mimeType && xhr.overrideMimeType) {
            xhr.overrideMimeType(options.mimeType);
          } // X-Requested-With header
          // For cross-domain requests, seeing as conditions for a preflight are
          // akin to a jigsaw puzzle, we simply never set it to be sure.
          // (it can always be set on a per-request basis or even using ajaxSetup)
          // For same-domain requests, won't change header if already provided.


          if (!options.crossDomain && !headers["X-Requested-With"]) {
            headers["X-Requested-With"] = "XMLHttpRequest";
          } // Set headers


          for (i in headers) {
            xhr.setRequestHeader(i, headers[i]);
          } // Callback


          _callback = function callback(type) {
            return function () {
              if (_callback) {
                _callback = errorCallback = xhr.onload = xhr.onerror = xhr.onabort = xhr.ontimeout = xhr.onreadystatechange = null;

                if (type === "abort") {
                  xhr.abort();
                } else if (type === "error") {
                  // Support: IE <=9 only
                  // On a manual native abort, IE9 throws
                  // errors on any property access that is not readyState
                  if (typeof xhr.status !== "number") {
                    complete(0, "error");
                  } else {
                    complete( // File: protocol always yields status 0; see #8605, #14207
                    xhr.status, xhr.statusText);
                  }
                } else {
                  complete(xhrSuccessStatus[xhr.status] || xhr.status, xhr.statusText, // Support: IE <=9 only
                  // IE9 has no XHR2 but throws on binary (trac-11426)
                  // For XHR2 non-text, let the caller handle it (gh-2498)
                  (xhr.responseType || "text") !== "text" || typeof xhr.responseText !== "string" ? {
                    binary: xhr.response
                  } : {
                    text: xhr.responseText
                  }, xhr.getAllResponseHeaders());
                }
              }
            };
          }; // Listen to events


          xhr.onload = _callback();
          errorCallback = xhr.onerror = xhr.ontimeout = _callback("error"); // Support: IE 9 only
          // Use onreadystatechange to replace onabort
          // to handle uncaught aborts

          if (xhr.onabort !== undefined) {
            xhr.onabort = errorCallback;
          } else {
            xhr.onreadystatechange = function () {
              // Check readyState before timeout as it changes
              if (xhr.readyState === 4) {
                // Allow onerror to be called first,
                // but that will not handle a native abort
                // Also, save errorCallback to a variable
                // as xhr.onerror cannot be accessed
                window.setTimeout(function () {
                  if (_callback) {
                    errorCallback();
                  }
                });
              }
            };
          } // Create the abort callback


          _callback = _callback("abort");

          try {
            // Do send the request (this may raise an exception)
            xhr.send(options.hasContent && options.data || null);
          } catch (e) {
            // #14683: Only rethrow if this hasn't been notified as an error yet
            if (_callback) {
              throw e;
            }
          }
        },
        abort: function abort() {
          if (_callback) {
            _callback();
          }
        }
      };
    }
  }); // Prevent auto-execution of scripts when no explicit dataType was provided (See gh-2432)

  jQuery.ajaxPrefilter(function (s) {
    if (s.crossDomain) {
      s.contents.script = false;
    }
  }); // Install script dataType

  jQuery.ajaxSetup({
    accepts: {
      script: "text/javascript, application/javascript, " + "application/ecmascript, application/x-ecmascript"
    },
    contents: {
      script: /\b(?:java|ecma)script\b/
    },
    converters: {
      "text script": function textScript(text) {
        jQuery.globalEval(text);
        return text;
      }
    }
  }); // Handle cache's special case and crossDomain

  jQuery.ajaxPrefilter("script", function (s) {
    if (s.cache === undefined) {
      s.cache = false;
    }

    if (s.crossDomain) {
      s.type = "GET";
    }
  }); // Bind script tag hack transport

  jQuery.ajaxTransport("script", function (s) {
    // This transport only deals with cross domain or forced-by-attrs requests
    if (s.crossDomain || s.scriptAttrs) {
      var script, _callback2;

      return {
        send: function send(_, complete) {
          script = jQuery("<script>").attr(s.scriptAttrs || {}).prop({
            charset: s.scriptCharset,
            src: s.url
          }).on("load error", _callback2 = function callback(evt) {
            script.remove();
            _callback2 = null;

            if (evt) {
              complete(evt.type === "error" ? 404 : 200, evt.type);
            }
          }); // Use native DOM manipulation to avoid our domManip AJAX trickery

          document.head.appendChild(script[0]);
        },
        abort: function abort() {
          if (_callback2) {
            _callback2();
          }
        }
      };
    }
  });
  var oldCallbacks = [],
      rjsonp = /(=)\?(?=&|$)|\?\?/; // Default jsonp settings

  jQuery.ajaxSetup({
    jsonp: "callback",
    jsonpCallback: function jsonpCallback() {
      var callback = oldCallbacks.pop() || jQuery.expando + "_" + nonce.guid++;
      this[callback] = true;
      return callback;
    }
  }); // Detect, normalize options and install callbacks for jsonp requests

  jQuery.ajaxPrefilter("json jsonp", function (s, originalSettings, jqXHR) {
    var callbackName,
        overwritten,
        responseContainer,
        jsonProp = s.jsonp !== false && (rjsonp.test(s.url) ? "url" : typeof s.data === "string" && (s.contentType || "").indexOf("application/x-www-form-urlencoded") === 0 && rjsonp.test(s.data) && "data"); // Handle iff the expected data type is "jsonp" or we have a parameter to set

    if (jsonProp || s.dataTypes[0] === "jsonp") {
      // Get callback name, remembering preexisting value associated with it
      callbackName = s.jsonpCallback = isFunction(s.jsonpCallback) ? s.jsonpCallback() : s.jsonpCallback; // Insert callback into url or form data

      if (jsonProp) {
        s[jsonProp] = s[jsonProp].replace(rjsonp, "$1" + callbackName);
      } else if (s.jsonp !== false) {
        s.url += (rquery.test(s.url) ? "&" : "?") + s.jsonp + "=" + callbackName;
      } // Use data converter to retrieve json after script execution


      s.converters["script json"] = function () {
        if (!responseContainer) {
          jQuery.error(callbackName + " was not called");
        }

        return responseContainer[0];
      }; // Force json dataType


      s.dataTypes[0] = "json"; // Install callback

      overwritten = window[callbackName];

      window[callbackName] = function () {
        responseContainer = arguments;
      }; // Clean-up function (fires after converters)


      jqXHR.always(function () {
        // If previous value didn't exist - remove it
        if (overwritten === undefined) {
          jQuery(window).removeProp(callbackName); // Otherwise restore preexisting value
        } else {
          window[callbackName] = overwritten;
        } // Save back as free


        if (s[callbackName]) {
          // Make sure that re-using the options doesn't screw things around
          s.jsonpCallback = originalSettings.jsonpCallback; // Save the callback name for future use

          oldCallbacks.push(callbackName);
        } // Call if it was a function and we have a response


        if (responseContainer && isFunction(overwritten)) {
          overwritten(responseContainer[0]);
        }

        responseContainer = overwritten = undefined;
      }); // Delegate to script

      return "script";
    }
  }); // Support: Safari 8 only
  // In Safari 8 documents created via document.implementation.createHTMLDocument
  // collapse sibling forms: the second one becomes a child of the first one.
  // Because of that, this security measure has to be disabled in Safari 8.
  // https://bugs.webkit.org/show_bug.cgi?id=137337

  support.createHTMLDocument = function () {
    var body = document.implementation.createHTMLDocument("").body;
    body.innerHTML = "<form></form><form></form>";
    return body.childNodes.length === 2;
  }(); // Argument "data" should be string of html
  // context (optional): If specified, the fragment will be created in this context,
  // defaults to document
  // keepScripts (optional): If true, will include scripts passed in the html string


  jQuery.parseHTML = function (data, context, keepScripts) {
    if (typeof data !== "string") {
      return [];
    }

    if (typeof context === "boolean") {
      keepScripts = context;
      context = false;
    }

    var base, parsed, scripts;

    if (!context) {
      // Stop scripts or inline event handlers from being executed immediately
      // by using document.implementation
      if (support.createHTMLDocument) {
        context = document.implementation.createHTMLDocument(""); // Set the base href for the created document
        // so any parsed elements with URLs
        // are based on the document's URL (gh-2965)

        base = context.createElement("base");
        base.href = document.location.href;
        context.head.appendChild(base);
      } else {
        context = document;
      }
    }

    parsed = rsingleTag.exec(data);
    scripts = !keepScripts && []; // Single tag

    if (parsed) {
      return [context.createElement(parsed[1])];
    }

    parsed = buildFragment([data], context, scripts);

    if (scripts && scripts.length) {
      jQuery(scripts).remove();
    }

    return jQuery.merge([], parsed.childNodes);
  };
  /**
   * Load a url into a page
   */


  jQuery.fn.load = function (url, params, callback) {
    var selector,
        type,
        response,
        self = this,
        off = url.indexOf(" ");

    if (off > -1) {
      selector = stripAndCollapse(url.slice(off));
      url = url.slice(0, off);
    } // If it's a function


    if (isFunction(params)) {
      // We assume that it's the callback
      callback = params;
      params = undefined; // Otherwise, build a param string
    } else if (params && _typeof(params) === "object") {
      type = "POST";
    } // If we have elements to modify, make the request


    if (self.length > 0) {
      jQuery.ajax({
        url: url,
        // If "type" variable is undefined, then "GET" method will be used.
        // Make value of this field explicit since
        // user can override it through ajaxSetup method
        type: type || "GET",
        dataType: "html",
        data: params
      }).done(function (responseText) {
        // Save response for use in complete callback
        response = arguments;
        self.html(selector ? // If a selector was specified, locate the right elements in a dummy div
        // Exclude scripts to avoid IE 'Permission Denied' errors
        jQuery("<div>").append(jQuery.parseHTML(responseText)).find(selector) : // Otherwise use the full result
        responseText); // If the request succeeds, this function gets "data", "status", "jqXHR"
        // but they are ignored because response was set above.
        // If it fails, this function gets "jqXHR", "status", "error"
      }).always(callback && function (jqXHR, status) {
        self.each(function () {
          callback.apply(this, response || [jqXHR.responseText, status, jqXHR]);
        });
      });
    }

    return this;
  };

  jQuery.expr.pseudos.animated = function (elem) {
    return jQuery.grep(jQuery.timers, function (fn) {
      return elem === fn.elem;
    }).length;
  };

  jQuery.offset = {
    setOffset: function setOffset(elem, options, i) {
      var curPosition,
          curLeft,
          curCSSTop,
          curTop,
          curOffset,
          curCSSLeft,
          calculatePosition,
          position = jQuery.css(elem, "position"),
          curElem = jQuery(elem),
          props = {}; // Set position first, in-case top/left are set even on static elem

      if (position === "static") {
        elem.style.position = "relative";
      }

      curOffset = curElem.offset();
      curCSSTop = jQuery.css(elem, "top");
      curCSSLeft = jQuery.css(elem, "left");
      calculatePosition = (position === "absolute" || position === "fixed") && (curCSSTop + curCSSLeft).indexOf("auto") > -1; // Need to be able to calculate position if either
      // top or left is auto and position is either absolute or fixed

      if (calculatePosition) {
        curPosition = curElem.position();
        curTop = curPosition.top;
        curLeft = curPosition.left;
      } else {
        curTop = parseFloat(curCSSTop) || 0;
        curLeft = parseFloat(curCSSLeft) || 0;
      }

      if (isFunction(options)) {
        // Use jQuery.extend here to allow modification of coordinates argument (gh-1848)
        options = options.call(elem, i, jQuery.extend({}, curOffset));
      }

      if (options.top != null) {
        props.top = options.top - curOffset.top + curTop;
      }

      if (options.left != null) {
        props.left = options.left - curOffset.left + curLeft;
      }

      if ("using" in options) {
        options.using.call(elem, props);
      } else {
        if (typeof props.top === "number") {
          props.top += "px";
        }

        if (typeof props.left === "number") {
          props.left += "px";
        }

        curElem.css(props);
      }
    }
  };
  jQuery.fn.extend({
    // offset() relates an element's border box to the document origin
    offset: function offset(options) {
      // Preserve chaining for setter
      if (arguments.length) {
        return options === undefined ? this : this.each(function (i) {
          jQuery.offset.setOffset(this, options, i);
        });
      }

      var rect,
          win,
          elem = this[0];

      if (!elem) {
        return;
      } // Return zeros for disconnected and hidden (display: none) elements (gh-2310)
      // Support: IE <=11 only
      // Running getBoundingClientRect on a
      // disconnected node in IE throws an error


      if (!elem.getClientRects().length) {
        return {
          top: 0,
          left: 0
        };
      } // Get document-relative position by adding viewport scroll to viewport-relative gBCR


      rect = elem.getBoundingClientRect();
      win = elem.ownerDocument.defaultView;
      return {
        top: rect.top + win.pageYOffset,
        left: rect.left + win.pageXOffset
      };
    },
    // position() relates an element's margin box to its offset parent's padding box
    // This corresponds to the behavior of CSS absolute positioning
    position: function position() {
      if (!this[0]) {
        return;
      }

      var offsetParent,
          offset,
          doc,
          elem = this[0],
          parentOffset = {
        top: 0,
        left: 0
      }; // position:fixed elements are offset from the viewport, which itself always has zero offset

      if (jQuery.css(elem, "position") === "fixed") {
        // Assume position:fixed implies availability of getBoundingClientRect
        offset = elem.getBoundingClientRect();
      } else {
        offset = this.offset(); // Account for the *real* offset parent, which can be the document or its root element
        // when a statically positioned element is identified

        doc = elem.ownerDocument;
        offsetParent = elem.offsetParent || doc.documentElement;

        while (offsetParent && (offsetParent === doc.body || offsetParent === doc.documentElement) && jQuery.css(offsetParent, "position") === "static") {
          offsetParent = offsetParent.parentNode;
        }

        if (offsetParent && offsetParent !== elem && offsetParent.nodeType === 1) {
          // Incorporate borders into its offset, since they are outside its content origin
          parentOffset = jQuery(offsetParent).offset();
          parentOffset.top += jQuery.css(offsetParent, "borderTopWidth", true);
          parentOffset.left += jQuery.css(offsetParent, "borderLeftWidth", true);
        }
      } // Subtract parent offsets and element margins


      return {
        top: offset.top - parentOffset.top - jQuery.css(elem, "marginTop", true),
        left: offset.left - parentOffset.left - jQuery.css(elem, "marginLeft", true)
      };
    },
    // This method will return documentElement in the following cases:
    // 1) For the element inside the iframe without offsetParent, this method will return
    //    documentElement of the parent window
    // 2) For the hidden or detached element
    // 3) For body or html element, i.e. in case of the html node - it will return itself
    //
    // but those exceptions were never presented as a real life use-cases
    // and might be considered as more preferable results.
    //
    // This logic, however, is not guaranteed and can change at any point in the future
    offsetParent: function offsetParent() {
      return this.map(function () {
        var offsetParent = this.offsetParent;

        while (offsetParent && jQuery.css(offsetParent, "position") === "static") {
          offsetParent = offsetParent.offsetParent;
        }

        return offsetParent || documentElement;
      });
    }
  }); // Create scrollLeft and scrollTop methods

  jQuery.each({
    scrollLeft: "pageXOffset",
    scrollTop: "pageYOffset"
  }, function (method, prop) {
    var top = "pageYOffset" === prop;

    jQuery.fn[method] = function (val) {
      return access(this, function (elem, method, val) {
        // Coalesce documents and windows
        var win;

        if (isWindow(elem)) {
          win = elem;
        } else if (elem.nodeType === 9) {
          win = elem.defaultView;
        }

        if (val === undefined) {
          return win ? win[prop] : elem[method];
        }

        if (win) {
          win.scrollTo(!top ? val : win.pageXOffset, top ? val : win.pageYOffset);
        } else {
          elem[method] = val;
        }
      }, method, val, arguments.length);
    };
  }); // Support: Safari <=7 - 9.1, Chrome <=37 - 49
  // Add the top/left cssHooks using jQuery.fn.position
  // Webkit bug: https://bugs.webkit.org/show_bug.cgi?id=29084
  // Blink bug: https://bugs.chromium.org/p/chromium/issues/detail?id=589347
  // getComputedStyle returns percent when specified for top/left/bottom/right;
  // rather than make the css module depend on the offset module, just check for it here

  jQuery.each(["top", "left"], function (_i, prop) {
    jQuery.cssHooks[prop] = addGetHookIf(support.pixelPosition, function (elem, computed) {
      if (computed) {
        computed = curCSS(elem, prop); // If curCSS returns percentage, fallback to offset

        return rnumnonpx.test(computed) ? jQuery(elem).position()[prop] + "px" : computed;
      }
    });
  }); // Create innerHeight, innerWidth, height, width, outerHeight and outerWidth methods

  jQuery.each({
    Height: "height",
    Width: "width"
  }, function (name, type) {
    jQuery.each({
      padding: "inner" + name,
      content: type,
      "": "outer" + name
    }, function (defaultExtra, funcName) {
      // Margin is only for outerHeight, outerWidth
      jQuery.fn[funcName] = function (margin, value) {
        var chainable = arguments.length && (defaultExtra || typeof margin !== "boolean"),
            extra = defaultExtra || (margin === true || value === true ? "margin" : "border");
        return access(this, function (elem, type, value) {
          var doc;

          if (isWindow(elem)) {
            // $( window ).outerWidth/Height return w/h including scrollbars (gh-1729)
            return funcName.indexOf("outer") === 0 ? elem["inner" + name] : elem.document.documentElement["client" + name];
          } // Get document width or height


          if (elem.nodeType === 9) {
            doc = elem.documentElement; // Either scroll[Width/Height] or offset[Width/Height] or client[Width/Height],
            // whichever is greatest

            return Math.max(elem.body["scroll" + name], doc["scroll" + name], elem.body["offset" + name], doc["offset" + name], doc["client" + name]);
          }

          return value === undefined ? // Get width or height on the element, requesting but not forcing parseFloat
          jQuery.css(elem, type, extra) : // Set width or height on the element
          jQuery.style(elem, type, value, extra);
        }, type, chainable ? margin : undefined, chainable);
      };
    });
  });
  jQuery.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (_i, type) {
    jQuery.fn[type] = function (fn) {
      return this.on(type, fn);
    };
  });
  jQuery.fn.extend({
    bind: function bind(types, data, fn) {
      return this.on(types, null, data, fn);
    },
    unbind: function unbind(types, fn) {
      return this.off(types, null, fn);
    },
    delegate: function delegate(selector, types, data, fn) {
      return this.on(types, selector, data, fn);
    },
    undelegate: function undelegate(selector, types, fn) {
      // ( namespace ) or ( selector, types [, fn] )
      return arguments.length === 1 ? this.off(selector, "**") : this.off(types, selector || "**", fn);
    },
    hover: function hover(fnOver, fnOut) {
      return this.mouseenter(fnOver).mouseleave(fnOut || fnOver);
    }
  });
  jQuery.each(("blur focus focusin focusout resize scroll click dblclick " + "mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " + "change select submit keydown keypress keyup contextmenu").split(" "), function (_i, name) {
    // Handle event binding
    jQuery.fn[name] = function (data, fn) {
      return arguments.length > 0 ? this.on(name, null, data, fn) : this.trigger(name);
    };
  }); // Support: Android <=4.0 only
  // Make sure we trim BOM and NBSP

  var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g; // Bind a function to a context, optionally partially applying any
  // arguments.
  // jQuery.proxy is deprecated to promote standards (specifically Function#bind)
  // However, it is not slated for removal any time soon

  jQuery.proxy = function (fn, context) {
    var tmp, args, proxy;

    if (typeof context === "string") {
      tmp = fn[context];
      context = fn;
      fn = tmp;
    } // Quick check to determine if target is callable, in the spec
    // this throws a TypeError, but we will just return undefined.


    if (!isFunction(fn)) {
      return undefined;
    } // Simulated bind


    args = _slice.call(arguments, 2);

    proxy = function proxy() {
      return fn.apply(context || this, args.concat(_slice.call(arguments)));
    }; // Set the guid of unique handler to the same of original handler, so it can be removed


    proxy.guid = fn.guid = fn.guid || jQuery.guid++;
    return proxy;
  };

  jQuery.holdReady = function (hold) {
    if (hold) {
      jQuery.readyWait++;
    } else {
      jQuery.ready(true);
    }
  };

  jQuery.isArray = Array.isArray;
  jQuery.parseJSON = JSON.parse;
  jQuery.nodeName = nodeName;
  jQuery.isFunction = isFunction;
  jQuery.isWindow = isWindow;
  jQuery.camelCase = camelCase;
  jQuery.type = toType;
  jQuery.now = Date.now;

  jQuery.isNumeric = function (obj) {
    // As of jQuery 3.0, isNumeric is limited to
    // strings and numbers (primitives or objects)
    // that can be coerced to finite numbers (gh-2662)
    var type = jQuery.type(obj);
    return (type === "number" || type === "string") && // parseFloat NaNs numeric-cast false positives ("")
    // ...but misinterprets leading-number strings, particularly hex literals ("0x...")
    // subtraction forces infinities to NaN
    !isNaN(obj - parseFloat(obj));
  };

  jQuery.trim = function (text) {
    return text == null ? "" : (text + "").replace(rtrim, "");
  }; // Register as a named AMD module, since jQuery can be concatenated with other
  // files that may use define, but not via a proper concatenation script that
  // understands anonymous AMD modules. A named AMD is safest and most robust
  // way to register. Lowercase jquery is used because AMD module names are
  // derived from file names, and jQuery is normally delivered in a lowercase
  // file name. Do this after creating the global so that if an AMD module wants
  // to call noConflict to hide this version of jQuery, it will work.
  // Note that for maximum portability, libraries that are not jQuery should
  // declare themselves as anonymous modules, and avoid setting a global if an
  // AMD loader is present. jQuery is a special case. For more information, see
  // https://github.com/jrburke/requirejs/wiki/Updating-existing-libraries#wiki-anon


  if (true) {
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
      return jQuery;
    }).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  }

  var // Map over jQuery in case of overwrite
  _jQuery = window.jQuery,
      // Map over the $ in case of overwrite
  _$ = window.$;

  jQuery.noConflict = function (deep) {
    if (window.$ === jQuery) {
      window.$ = _$;
    }

    if (deep && window.jQuery === jQuery) {
      window.jQuery = _jQuery;
    }

    return jQuery;
  }; // Expose jQuery and $ identifiers, even in AMD
  // (#7102#comment:10, https://github.com/jquery/jquery/pull/557)
  // and CommonJS for browser emulators (#13566)


  if (typeof noGlobal === "undefined") {
    window.jQuery = window.$ = jQuery;
  }

  return jQuery;
});
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../webpack/buildin/module.js */ "./node_modules/webpack/buildin/module.js")(module)))

/***/ }),

/***/ "./node_modules/ssr-window/dist/ssr-window.esm.js":
/*!********************************************************!*\
  !*** ./node_modules/ssr-window/dist/ssr-window.esm.js ***!
  \********************************************************/
/*! exports provided: document, extend, window */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "document", function() { return doc; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "extend", function() { return extend; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "window", function() { return win; });
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/**
 * SSR Window 2.0.0
 * Better handling for window object in SSR environment
 * https://github.com/nolimits4web/ssr-window
 *
 * Copyright 2020, Vladimir Kharlampidi
 *
 * Licensed under MIT
 *
 * Released on: May 12, 2020
 */

/* eslint-disable no-param-reassign */
function isObject(obj) {
  return obj !== null && _typeof(obj) === 'object' && 'constructor' in obj && obj.constructor === Object;
}

function extend(target, src) {
  if (target === void 0) {
    target = {};
  }

  if (src === void 0) {
    src = {};
  }

  Object.keys(src).forEach(function (key) {
    if (typeof target[key] === 'undefined') target[key] = src[key];else if (isObject(src[key]) && isObject(target[key]) && Object.keys(src[key]).length > 0) {
      extend(target[key], src[key]);
    }
  });
}

var doc = typeof document !== 'undefined' ? document : {};
var ssrDocument = {
  body: {},
  addEventListener: function addEventListener() {},
  removeEventListener: function removeEventListener() {},
  activeElement: {
    blur: function blur() {},
    nodeName: ''
  },
  querySelector: function querySelector() {
    return null;
  },
  querySelectorAll: function querySelectorAll() {
    return [];
  },
  getElementById: function getElementById() {
    return null;
  },
  createEvent: function createEvent() {
    return {
      initEvent: function initEvent() {}
    };
  },
  createElement: function createElement() {
    return {
      children: [],
      childNodes: [],
      style: {},
      setAttribute: function setAttribute() {},
      getElementsByTagName: function getElementsByTagName() {
        return [];
      }
    };
  },
  createElementNS: function createElementNS() {
    return {};
  },
  importNode: function importNode() {
    return null;
  },
  location: {
    hash: '',
    host: '',
    hostname: '',
    href: '',
    origin: '',
    pathname: '',
    protocol: '',
    search: ''
  }
};
extend(doc, ssrDocument);
var win = typeof window !== 'undefined' ? window : {};
var ssrWindow = {
  document: ssrDocument,
  navigator: {
    userAgent: ''
  },
  location: {
    hash: '',
    host: '',
    hostname: '',
    href: '',
    origin: '',
    pathname: '',
    protocol: '',
    search: ''
  },
  history: {
    replaceState: function replaceState() {},
    pushState: function pushState() {},
    go: function go() {},
    back: function back() {}
  },
  CustomEvent: function CustomEvent() {
    return this;
  },
  addEventListener: function addEventListener() {},
  removeEventListener: function removeEventListener() {},
  getComputedStyle: function getComputedStyle() {
    return {
      getPropertyValue: function getPropertyValue() {
        return '';
      }
    };
  },
  Image: function Image() {},
  Date: function Date() {},
  screen: {},
  setTimeout: function setTimeout() {},
  clearTimeout: function clearTimeout() {},
  matchMedia: function matchMedia() {
    return {};
  }
};
extend(win, ssrWindow);


/***/ }),

/***/ "./node_modules/swiper/js/swiper.esm.bundle.js":
/*!*****************************************************!*\
  !*** ./node_modules/swiper/js/swiper.esm.bundle.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! dom7/dist/dom7.modular */ "./node_modules/dom7/dist/dom7.modular.js");
/* harmony import */ var ssr_window__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ssr-window */ "./node_modules/ssr-window/dist/ssr-window.esm.js");
function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function _createSuperInternal() { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/**
 * Swiper 5.4.5
 * Most modern mobile touch slider and framework with hardware accelerated transitions
 * http://swiperjs.com
 *
 * Copyright 2014-2020 Vladimir Kharlampidi
 *
 * Released under the MIT License
 *
 * Released on: June 16, 2020
 */


var Methods = {
  addClass: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["addClass"],
  removeClass: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["removeClass"],
  hasClass: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["hasClass"],
  toggleClass: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["toggleClass"],
  attr: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["attr"],
  removeAttr: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["removeAttr"],
  data: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["data"],
  transform: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["transform"],
  transition: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["transition"],
  on: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["on"],
  off: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["off"],
  trigger: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["trigger"],
  transitionEnd: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["transitionEnd"],
  outerWidth: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["outerWidth"],
  outerHeight: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["outerHeight"],
  offset: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["offset"],
  css: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["css"],
  each: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["each"],
  html: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["html"],
  text: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["text"],
  is: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["is"],
  index: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["index"],
  eq: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["eq"],
  append: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["append"],
  prepend: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["prepend"],
  next: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["next"],
  nextAll: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["nextAll"],
  prev: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["prev"],
  prevAll: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["prevAll"],
  parent: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["parent"],
  parents: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["parents"],
  closest: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["closest"],
  find: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["find"],
  children: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["children"],
  filter: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["filter"],
  remove: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["remove"],
  add: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["add"],
  styles: dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["styles"]
};
Object.keys(Methods).forEach(function (methodName) {
  dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"].fn[methodName] = dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"].fn[methodName] || Methods[methodName];
});
var Utils = {
  deleteProps: function deleteProps(obj) {
    var object = obj;
    Object.keys(object).forEach(function (key) {
      try {
        object[key] = null;
      } catch (e) {// no getter for object
      }

      try {
        delete object[key];
      } catch (e) {// something got wrong
      }
    });
  },
  nextTick: function nextTick(callback) {
    var delay = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
    return setTimeout(callback, delay);
  },
  now: function now() {
    return Date.now();
  },
  getTranslate: function getTranslate(el) {
    var axis = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'x';
    var matrix;
    var curTransform;
    var transformMatrix;
    var curStyle = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].getComputedStyle(el, null);

    if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].WebKitCSSMatrix) {
      curTransform = curStyle.transform || curStyle.webkitTransform;

      if (curTransform.split(',').length > 6) {
        curTransform = curTransform.split(', ').map(function (a) {
          return a.replace(',', '.');
        }).join(', ');
      } // Some old versions of Webkit choke when 'none' is passed; pass
      // empty string instead in this case


      transformMatrix = new ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].WebKitCSSMatrix(curTransform === 'none' ? '' : curTransform);
    } else {
      transformMatrix = curStyle.MozTransform || curStyle.OTransform || curStyle.MsTransform || curStyle.msTransform || curStyle.transform || curStyle.getPropertyValue('transform').replace('translate(', 'matrix(1, 0, 0, 1,');
      matrix = transformMatrix.toString().split(',');
    }

    if (axis === 'x') {
      // Latest Chrome and webkits Fix
      if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].WebKitCSSMatrix) curTransform = transformMatrix.m41; // Crazy IE10 Matrix
      else if (matrix.length === 16) curTransform = parseFloat(matrix[12]); // Normal Browsers
        else curTransform = parseFloat(matrix[4]);
    }

    if (axis === 'y') {
      // Latest Chrome and webkits Fix
      if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].WebKitCSSMatrix) curTransform = transformMatrix.m42; // Crazy IE10 Matrix
      else if (matrix.length === 16) curTransform = parseFloat(matrix[13]); // Normal Browsers
        else curTransform = parseFloat(matrix[5]);
    }

    return curTransform || 0;
  },
  parseUrlQuery: function parseUrlQuery(url) {
    var query = {};
    var urlToParse = url || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].location.href;
    var i;
    var params;
    var param;
    var length;

    if (typeof urlToParse === 'string' && urlToParse.length) {
      urlToParse = urlToParse.indexOf('?') > -1 ? urlToParse.replace(/\S*\?/, '') : '';
      params = urlToParse.split('&').filter(function (paramsPart) {
        return paramsPart !== '';
      });
      length = params.length;

      for (i = 0; i < length; i += 1) {
        param = params[i].replace(/#\S+/g, '').split('=');
        query[decodeURIComponent(param[0])] = typeof param[1] === 'undefined' ? undefined : decodeURIComponent(param[1]) || '';
      }
    }

    return query;
  },
  isObject: function isObject(o) {
    return _typeof(o) === 'object' && o !== null && o.constructor && o.constructor === Object;
  },
  extend: function extend() {
    var to = Object(arguments.length <= 0 ? undefined : arguments[0]);

    for (var i = 1; i < arguments.length; i += 1) {
      var nextSource = i < 0 || arguments.length <= i ? undefined : arguments[i];

      if (nextSource !== undefined && nextSource !== null) {
        var keysArray = Object.keys(Object(nextSource));

        for (var nextIndex = 0, len = keysArray.length; nextIndex < len; nextIndex += 1) {
          var nextKey = keysArray[nextIndex];
          var desc = Object.getOwnPropertyDescriptor(nextSource, nextKey);

          if (desc !== undefined && desc.enumerable) {
            if (Utils.isObject(to[nextKey]) && Utils.isObject(nextSource[nextKey])) {
              Utils.extend(to[nextKey], nextSource[nextKey]);
            } else if (!Utils.isObject(to[nextKey]) && Utils.isObject(nextSource[nextKey])) {
              to[nextKey] = {};
              Utils.extend(to[nextKey], nextSource[nextKey]);
            } else {
              to[nextKey] = nextSource[nextKey];
            }
          }
        }
      }
    }

    return to;
  }
};

var Support = function Support() {
  return {
    touch: !!('ontouchstart' in ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"] || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].DocumentTouch && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"] instanceof ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].DocumentTouch),
    pointerEvents: !!ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].PointerEvent && 'maxTouchPoints' in ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator && ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.maxTouchPoints >= 0,
    observer: function checkObserver() {
      return 'MutationObserver' in ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"] || 'WebkitMutationObserver' in ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"];
    }(),
    passiveListener: function checkPassiveListener() {
      var supportsPassive = false;

      try {
        var opts = Object.defineProperty({}, 'passive', {
          // eslint-disable-next-line
          get: function get() {
            supportsPassive = true;
          }
        });
        ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].addEventListener('testPassiveListener', null, opts);
      } catch (e) {// No support
      }

      return supportsPassive;
    }(),
    gestures: function checkGestures() {
      return 'ongesturestart' in ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"];
    }()
  };
}();

var SwiperClass = /*#__PURE__*/function () {
  function SwiperClass() {
    var params = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

    _classCallCheck(this, SwiperClass);

    var self = this;
    self.params = params; // Events

    self.eventsListeners = {};

    if (self.params && self.params.on) {
      Object.keys(self.params.on).forEach(function (eventName) {
        self.on(eventName, self.params.on[eventName]);
      });
    }
  }

  _createClass(SwiperClass, [{
    key: "on",
    value: function on(events, handler, priority) {
      var self = this;
      if (typeof handler !== 'function') return self;
      var method = priority ? 'unshift' : 'push';
      events.split(' ').forEach(function (event) {
        if (!self.eventsListeners[event]) self.eventsListeners[event] = [];
        self.eventsListeners[event][method](handler);
      });
      return self;
    }
  }, {
    key: "once",
    value: function once(events, handler, priority) {
      var self = this;
      if (typeof handler !== 'function') return self;

      function onceHandler() {
        self.off(events, onceHandler);

        if (onceHandler.f7proxy) {
          delete onceHandler.f7proxy;
        }

        for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
          args[_key] = arguments[_key];
        }

        handler.apply(self, args);
      }

      onceHandler.f7proxy = handler;
      return self.on(events, onceHandler, priority);
    }
  }, {
    key: "off",
    value: function off(events, handler) {
      var self = this;
      if (!self.eventsListeners) return self;
      events.split(' ').forEach(function (event) {
        if (typeof handler === 'undefined') {
          self.eventsListeners[event] = [];
        } else if (self.eventsListeners[event] && self.eventsListeners[event].length) {
          self.eventsListeners[event].forEach(function (eventHandler, index) {
            if (eventHandler === handler || eventHandler.f7proxy && eventHandler.f7proxy === handler) {
              self.eventsListeners[event].splice(index, 1);
            }
          });
        }
      });
      return self;
    }
  }, {
    key: "emit",
    value: function emit() {
      var self = this;
      if (!self.eventsListeners) return self;
      var events;
      var data;
      var context;

      for (var _len2 = arguments.length, args = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
        args[_key2] = arguments[_key2];
      }

      if (typeof args[0] === 'string' || Array.isArray(args[0])) {
        events = args[0];
        data = args.slice(1, args.length);
        context = self;
      } else {
        events = args[0].events;
        data = args[0].data;
        context = args[0].context || self;
      }

      var eventsArray = Array.isArray(events) ? events : events.split(' ');
      eventsArray.forEach(function (event) {
        if (self.eventsListeners && self.eventsListeners[event]) {
          var handlers = [];
          self.eventsListeners[event].forEach(function (eventHandler) {
            handlers.push(eventHandler);
          });
          handlers.forEach(function (eventHandler) {
            eventHandler.apply(context, data);
          });
        }
      });
      return self;
    }
  }, {
    key: "useModulesParams",
    value: function useModulesParams(instanceParams) {
      var instance = this;
      if (!instance.modules) return;
      Object.keys(instance.modules).forEach(function (moduleName) {
        var module = instance.modules[moduleName]; // Extend params

        if (module.params) {
          Utils.extend(instanceParams, module.params);
        }
      });
    }
  }, {
    key: "useModules",
    value: function useModules() {
      var modulesParams = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
      var instance = this;
      if (!instance.modules) return;
      Object.keys(instance.modules).forEach(function (moduleName) {
        var module = instance.modules[moduleName];
        var moduleParams = modulesParams[moduleName] || {}; // Extend instance methods and props

        if (module.instance) {
          Object.keys(module.instance).forEach(function (modulePropName) {
            var moduleProp = module.instance[modulePropName];

            if (typeof moduleProp === 'function') {
              instance[modulePropName] = moduleProp.bind(instance);
            } else {
              instance[modulePropName] = moduleProp;
            }
          });
        } // Add event listeners


        if (module.on && instance.on) {
          Object.keys(module.on).forEach(function (moduleEventName) {
            instance.on(moduleEventName, module.on[moduleEventName]);
          });
        } // Module create callback


        if (module.create) {
          module.create.bind(instance)(moduleParams);
        }
      });
    }
  }], [{
    key: "installModule",
    value: function installModule(module) {
      var Class = this;
      if (!Class.prototype.modules) Class.prototype.modules = {};
      var name = module.name || "".concat(Object.keys(Class.prototype.modules).length, "_").concat(Utils.now());
      Class.prototype.modules[name] = module; // Prototype

      if (module.proto) {
        Object.keys(module.proto).forEach(function (key) {
          Class.prototype[key] = module.proto[key];
        });
      } // Class


      if (module["static"]) {
        Object.keys(module["static"]).forEach(function (key) {
          Class[key] = module["static"][key];
        });
      } // Callback


      if (module.install) {
        for (var _len3 = arguments.length, params = new Array(_len3 > 1 ? _len3 - 1 : 0), _key3 = 1; _key3 < _len3; _key3++) {
          params[_key3 - 1] = arguments[_key3];
        }

        module.install.apply(Class, params);
      }

      return Class;
    }
  }, {
    key: "use",
    value: function use(module) {
      var Class = this;

      if (Array.isArray(module)) {
        module.forEach(function (m) {
          return Class.installModule(m);
        });
        return Class;
      }

      for (var _len4 = arguments.length, params = new Array(_len4 > 1 ? _len4 - 1 : 0), _key4 = 1; _key4 < _len4; _key4++) {
        params[_key4 - 1] = arguments[_key4];
      }

      return Class.installModule.apply(Class, [module].concat(params));
    }
  }, {
    key: "components",
    set: function set(components) {
      var Class = this;
      if (!Class.use) return;
      Class.use(components);
    }
  }]);

  return SwiperClass;
}();

function updateSize() {
  var swiper = this;
  var width;
  var height;
  var $el = swiper.$el;

  if (typeof swiper.params.width !== 'undefined') {
    width = swiper.params.width;
  } else {
    width = $el[0].clientWidth;
  }

  if (typeof swiper.params.height !== 'undefined') {
    height = swiper.params.height;
  } else {
    height = $el[0].clientHeight;
  }

  if (width === 0 && swiper.isHorizontal() || height === 0 && swiper.isVertical()) {
    return;
  } // Subtract paddings


  width = width - parseInt($el.css('padding-left'), 10) - parseInt($el.css('padding-right'), 10);
  height = height - parseInt($el.css('padding-top'), 10) - parseInt($el.css('padding-bottom'), 10);
  Utils.extend(swiper, {
    width: width,
    height: height,
    size: swiper.isHorizontal() ? width : height
  });
}

function updateSlides() {
  var swiper = this;
  var params = swiper.params;
  var $wrapperEl = swiper.$wrapperEl,
      swiperSize = swiper.size,
      rtl = swiper.rtlTranslate,
      wrongRTL = swiper.wrongRTL;
  var isVirtual = swiper.virtual && params.virtual.enabled;
  var previousSlidesLength = isVirtual ? swiper.virtual.slides.length : swiper.slides.length;
  var slides = $wrapperEl.children(".".concat(swiper.params.slideClass));
  var slidesLength = isVirtual ? swiper.virtual.slides.length : slides.length;
  var snapGrid = [];
  var slidesGrid = [];
  var slidesSizesGrid = [];

  function slidesForMargin(slideIndex) {
    if (!params.cssMode) return true;

    if (slideIndex === slides.length - 1) {
      return false;
    }

    return true;
  }

  var offsetBefore = params.slidesOffsetBefore;

  if (typeof offsetBefore === 'function') {
    offsetBefore = params.slidesOffsetBefore.call(swiper);
  }

  var offsetAfter = params.slidesOffsetAfter;

  if (typeof offsetAfter === 'function') {
    offsetAfter = params.slidesOffsetAfter.call(swiper);
  }

  var previousSnapGridLength = swiper.snapGrid.length;
  var previousSlidesGridLength = swiper.snapGrid.length;
  var spaceBetween = params.spaceBetween;
  var slidePosition = -offsetBefore;
  var prevSlideSize = 0;
  var index = 0;

  if (typeof swiperSize === 'undefined') {
    return;
  }

  if (typeof spaceBetween === 'string' && spaceBetween.indexOf('%') >= 0) {
    spaceBetween = parseFloat(spaceBetween.replace('%', '')) / 100 * swiperSize;
  }

  swiper.virtualSize = -spaceBetween; // reset margins

  if (rtl) slides.css({
    marginLeft: '',
    marginTop: ''
  });else slides.css({
    marginRight: '',
    marginBottom: ''
  });
  var slidesNumberEvenToRows;

  if (params.slidesPerColumn > 1) {
    if (Math.floor(slidesLength / params.slidesPerColumn) === slidesLength / swiper.params.slidesPerColumn) {
      slidesNumberEvenToRows = slidesLength;
    } else {
      slidesNumberEvenToRows = Math.ceil(slidesLength / params.slidesPerColumn) * params.slidesPerColumn;
    }

    if (params.slidesPerView !== 'auto' && params.slidesPerColumnFill === 'row') {
      slidesNumberEvenToRows = Math.max(slidesNumberEvenToRows, params.slidesPerView * params.slidesPerColumn);
    }
  } // Calc slides


  var slideSize;
  var slidesPerColumn = params.slidesPerColumn;
  var slidesPerRow = slidesNumberEvenToRows / slidesPerColumn;
  var numFullColumns = Math.floor(slidesLength / params.slidesPerColumn);

  for (var i = 0; i < slidesLength; i += 1) {
    slideSize = 0;

    var _slide = slides.eq(i);

    if (params.slidesPerColumn > 1) {
      // Set slides order
      var newSlideOrderIndex = void 0;
      var column = void 0;
      var row = void 0;

      if (params.slidesPerColumnFill === 'row' && params.slidesPerGroup > 1) {
        var groupIndex = Math.floor(i / (params.slidesPerGroup * params.slidesPerColumn));
        var slideIndexInGroup = i - params.slidesPerColumn * params.slidesPerGroup * groupIndex;
        var columnsInGroup = groupIndex === 0 ? params.slidesPerGroup : Math.min(Math.ceil((slidesLength - groupIndex * slidesPerColumn * params.slidesPerGroup) / slidesPerColumn), params.slidesPerGroup);
        row = Math.floor(slideIndexInGroup / columnsInGroup);
        column = slideIndexInGroup - row * columnsInGroup + groupIndex * params.slidesPerGroup;
        newSlideOrderIndex = column + row * slidesNumberEvenToRows / slidesPerColumn;

        _slide.css({
          '-webkit-box-ordinal-group': newSlideOrderIndex,
          '-moz-box-ordinal-group': newSlideOrderIndex,
          '-ms-flex-order': newSlideOrderIndex,
          '-webkit-order': newSlideOrderIndex,
          order: newSlideOrderIndex
        });
      } else if (params.slidesPerColumnFill === 'column') {
        column = Math.floor(i / slidesPerColumn);
        row = i - column * slidesPerColumn;

        if (column > numFullColumns || column === numFullColumns && row === slidesPerColumn - 1) {
          row += 1;

          if (row >= slidesPerColumn) {
            row = 0;
            column += 1;
          }
        }
      } else {
        row = Math.floor(i / slidesPerRow);
        column = i - row * slidesPerRow;
      }

      _slide.css("margin-".concat(swiper.isHorizontal() ? 'top' : 'left'), row !== 0 && params.spaceBetween && "".concat(params.spaceBetween, "px"));
    }

    if (_slide.css('display') === 'none') continue; // eslint-disable-line

    if (params.slidesPerView === 'auto') {
      var slideStyles = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].getComputedStyle(_slide[0], null);
      var currentTransform = _slide[0].style.transform;
      var currentWebKitTransform = _slide[0].style.webkitTransform;

      if (currentTransform) {
        _slide[0].style.transform = 'none';
      }

      if (currentWebKitTransform) {
        _slide[0].style.webkitTransform = 'none';
      }

      if (params.roundLengths) {
        slideSize = swiper.isHorizontal() ? _slide.outerWidth(true) : _slide.outerHeight(true);
      } else {
        // eslint-disable-next-line
        if (swiper.isHorizontal()) {
          var width = parseFloat(slideStyles.getPropertyValue('width'));
          var paddingLeft = parseFloat(slideStyles.getPropertyValue('padding-left'));
          var paddingRight = parseFloat(slideStyles.getPropertyValue('padding-right'));
          var marginLeft = parseFloat(slideStyles.getPropertyValue('margin-left'));
          var marginRight = parseFloat(slideStyles.getPropertyValue('margin-right'));
          var boxSizing = slideStyles.getPropertyValue('box-sizing');

          if (boxSizing && boxSizing === 'border-box') {
            slideSize = width + marginLeft + marginRight;
          } else {
            slideSize = width + paddingLeft + paddingRight + marginLeft + marginRight;
          }
        } else {
          var height = parseFloat(slideStyles.getPropertyValue('height'));
          var paddingTop = parseFloat(slideStyles.getPropertyValue('padding-top'));
          var paddingBottom = parseFloat(slideStyles.getPropertyValue('padding-bottom'));
          var marginTop = parseFloat(slideStyles.getPropertyValue('margin-top'));
          var marginBottom = parseFloat(slideStyles.getPropertyValue('margin-bottom'));

          var _boxSizing = slideStyles.getPropertyValue('box-sizing');

          if (_boxSizing && _boxSizing === 'border-box') {
            slideSize = height + marginTop + marginBottom;
          } else {
            slideSize = height + paddingTop + paddingBottom + marginTop + marginBottom;
          }
        }
      }

      if (currentTransform) {
        _slide[0].style.transform = currentTransform;
      }

      if (currentWebKitTransform) {
        _slide[0].style.webkitTransform = currentWebKitTransform;
      }

      if (params.roundLengths) slideSize = Math.floor(slideSize);
    } else {
      slideSize = (swiperSize - (params.slidesPerView - 1) * spaceBetween) / params.slidesPerView;
      if (params.roundLengths) slideSize = Math.floor(slideSize);

      if (slides[i]) {
        if (swiper.isHorizontal()) {
          slides[i].style.width = "".concat(slideSize, "px");
        } else {
          slides[i].style.height = "".concat(slideSize, "px");
        }
      }
    }

    if (slides[i]) {
      slides[i].swiperSlideSize = slideSize;
    }

    slidesSizesGrid.push(slideSize);

    if (params.centeredSlides) {
      slidePosition = slidePosition + slideSize / 2 + prevSlideSize / 2 + spaceBetween;
      if (prevSlideSize === 0 && i !== 0) slidePosition = slidePosition - swiperSize / 2 - spaceBetween;
      if (i === 0) slidePosition = slidePosition - swiperSize / 2 - spaceBetween;
      if (Math.abs(slidePosition) < 1 / 1000) slidePosition = 0;
      if (params.roundLengths) slidePosition = Math.floor(slidePosition);
      if (index % params.slidesPerGroup === 0) snapGrid.push(slidePosition);
      slidesGrid.push(slidePosition);
    } else {
      if (params.roundLengths) slidePosition = Math.floor(slidePosition);
      if ((index - Math.min(swiper.params.slidesPerGroupSkip, index)) % swiper.params.slidesPerGroup === 0) snapGrid.push(slidePosition);
      slidesGrid.push(slidePosition);
      slidePosition = slidePosition + slideSize + spaceBetween;
    }

    swiper.virtualSize += slideSize + spaceBetween;
    prevSlideSize = slideSize;
    index += 1;
  }

  swiper.virtualSize = Math.max(swiper.virtualSize, swiperSize) + offsetAfter;
  var newSlidesGrid;

  if (rtl && wrongRTL && (params.effect === 'slide' || params.effect === 'coverflow')) {
    $wrapperEl.css({
      width: "".concat(swiper.virtualSize + params.spaceBetween, "px")
    });
  }

  if (params.setWrapperSize) {
    if (swiper.isHorizontal()) $wrapperEl.css({
      width: "".concat(swiper.virtualSize + params.spaceBetween, "px")
    });else $wrapperEl.css({
      height: "".concat(swiper.virtualSize + params.spaceBetween, "px")
    });
  }

  if (params.slidesPerColumn > 1) {
    swiper.virtualSize = (slideSize + params.spaceBetween) * slidesNumberEvenToRows;
    swiper.virtualSize = Math.ceil(swiper.virtualSize / params.slidesPerColumn) - params.spaceBetween;
    if (swiper.isHorizontal()) $wrapperEl.css({
      width: "".concat(swiper.virtualSize + params.spaceBetween, "px")
    });else $wrapperEl.css({
      height: "".concat(swiper.virtualSize + params.spaceBetween, "px")
    });

    if (params.centeredSlides) {
      newSlidesGrid = [];

      for (var _i = 0; _i < snapGrid.length; _i += 1) {
        var slidesGridItem = snapGrid[_i];
        if (params.roundLengths) slidesGridItem = Math.floor(slidesGridItem);
        if (snapGrid[_i] < swiper.virtualSize + snapGrid[0]) newSlidesGrid.push(slidesGridItem);
      }

      snapGrid = newSlidesGrid;
    }
  } // Remove last grid elements depending on width


  if (!params.centeredSlides) {
    newSlidesGrid = [];

    for (var _i2 = 0; _i2 < snapGrid.length; _i2 += 1) {
      var _slidesGridItem = snapGrid[_i2];
      if (params.roundLengths) _slidesGridItem = Math.floor(_slidesGridItem);

      if (snapGrid[_i2] <= swiper.virtualSize - swiperSize) {
        newSlidesGrid.push(_slidesGridItem);
      }
    }

    snapGrid = newSlidesGrid;

    if (Math.floor(swiper.virtualSize - swiperSize) - Math.floor(snapGrid[snapGrid.length - 1]) > 1) {
      snapGrid.push(swiper.virtualSize - swiperSize);
    }
  }

  if (snapGrid.length === 0) snapGrid = [0];

  if (params.spaceBetween !== 0) {
    if (swiper.isHorizontal()) {
      if (rtl) slides.filter(slidesForMargin).css({
        marginLeft: "".concat(spaceBetween, "px")
      });else slides.filter(slidesForMargin).css({
        marginRight: "".concat(spaceBetween, "px")
      });
    } else slides.filter(slidesForMargin).css({
      marginBottom: "".concat(spaceBetween, "px")
    });
  }

  if (params.centeredSlides && params.centeredSlidesBounds) {
    var allSlidesSize = 0;
    slidesSizesGrid.forEach(function (slideSizeValue) {
      allSlidesSize += slideSizeValue + (params.spaceBetween ? params.spaceBetween : 0);
    });
    allSlidesSize -= params.spaceBetween;
    var maxSnap = allSlidesSize - swiperSize;
    snapGrid = snapGrid.map(function (snap) {
      if (snap < 0) return -offsetBefore;
      if (snap > maxSnap) return maxSnap + offsetAfter;
      return snap;
    });
  }

  if (params.centerInsufficientSlides) {
    var _allSlidesSize = 0;
    slidesSizesGrid.forEach(function (slideSizeValue) {
      _allSlidesSize += slideSizeValue + (params.spaceBetween ? params.spaceBetween : 0);
    });
    _allSlidesSize -= params.spaceBetween;

    if (_allSlidesSize < swiperSize) {
      var allSlidesOffset = (swiperSize - _allSlidesSize) / 2;
      snapGrid.forEach(function (snap, snapIndex) {
        snapGrid[snapIndex] = snap - allSlidesOffset;
      });
      slidesGrid.forEach(function (snap, snapIndex) {
        slidesGrid[snapIndex] = snap + allSlidesOffset;
      });
    }
  }

  Utils.extend(swiper, {
    slides: slides,
    snapGrid: snapGrid,
    slidesGrid: slidesGrid,
    slidesSizesGrid: slidesSizesGrid
  });

  if (slidesLength !== previousSlidesLength) {
    swiper.emit('slidesLengthChange');
  }

  if (snapGrid.length !== previousSnapGridLength) {
    if (swiper.params.watchOverflow) swiper.checkOverflow();
    swiper.emit('snapGridLengthChange');
  }

  if (slidesGrid.length !== previousSlidesGridLength) {
    swiper.emit('slidesGridLengthChange');
  }

  if (params.watchSlidesProgress || params.watchSlidesVisibility) {
    swiper.updateSlidesOffset();
  }
}

function updateAutoHeight(speed) {
  var swiper = this;
  var activeSlides = [];
  var newHeight = 0;
  var i;

  if (typeof speed === 'number') {
    swiper.setTransition(speed);
  } else if (speed === true) {
    swiper.setTransition(swiper.params.speed);
  } // Find slides currently in view


  if (swiper.params.slidesPerView !== 'auto' && swiper.params.slidesPerView > 1) {
    if (swiper.params.centeredSlides) {
      swiper.visibleSlides.each(function (index, slide) {
        activeSlides.push(slide);
      });
    } else {
      for (i = 0; i < Math.ceil(swiper.params.slidesPerView); i += 1) {
        var _index = swiper.activeIndex + i;

        if (_index > swiper.slides.length) break;
        activeSlides.push(swiper.slides.eq(_index)[0]);
      }
    }
  } else {
    activeSlides.push(swiper.slides.eq(swiper.activeIndex)[0]);
  } // Find new height from highest slide in view


  for (i = 0; i < activeSlides.length; i += 1) {
    if (typeof activeSlides[i] !== 'undefined') {
      var height = activeSlides[i].offsetHeight;
      newHeight = height > newHeight ? height : newHeight;
    }
  } // Update Height


  if (newHeight) swiper.$wrapperEl.css('height', "".concat(newHeight, "px"));
}

function updateSlidesOffset() {
  var swiper = this;
  var slides = swiper.slides;

  for (var i = 0; i < slides.length; i += 1) {
    slides[i].swiperSlideOffset = swiper.isHorizontal() ? slides[i].offsetLeft : slides[i].offsetTop;
  }
}

function updateSlidesProgress() {
  var translate = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this && this.translate || 0;
  var swiper = this;
  var params = swiper.params;
  var slides = swiper.slides,
      rtl = swiper.rtlTranslate;
  if (slides.length === 0) return;
  if (typeof slides[0].swiperSlideOffset === 'undefined') swiper.updateSlidesOffset();
  var offsetCenter = -translate;
  if (rtl) offsetCenter = translate; // Visible Slides

  slides.removeClass(params.slideVisibleClass);
  swiper.visibleSlidesIndexes = [];
  swiper.visibleSlides = [];

  for (var i = 0; i < slides.length; i += 1) {
    var _slide2 = slides[i];
    var slideProgress = (offsetCenter + (params.centeredSlides ? swiper.minTranslate() : 0) - _slide2.swiperSlideOffset) / (_slide2.swiperSlideSize + params.spaceBetween);

    if (params.watchSlidesVisibility || params.centeredSlides && params.autoHeight) {
      var slideBefore = -(offsetCenter - _slide2.swiperSlideOffset);
      var slideAfter = slideBefore + swiper.slidesSizesGrid[i];
      var isVisible = slideBefore >= 0 && slideBefore < swiper.size - 1 || slideAfter > 1 && slideAfter <= swiper.size || slideBefore <= 0 && slideAfter >= swiper.size;

      if (isVisible) {
        swiper.visibleSlides.push(_slide2);
        swiper.visibleSlidesIndexes.push(i);
        slides.eq(i).addClass(params.slideVisibleClass);
      }
    }

    _slide2.progress = rtl ? -slideProgress : slideProgress;
  }

  swiper.visibleSlides = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(swiper.visibleSlides);
}

function updateProgress(translate) {
  var swiper = this;

  if (typeof translate === 'undefined') {
    var multiplier = swiper.rtlTranslate ? -1 : 1; // eslint-disable-next-line

    translate = swiper && swiper.translate && swiper.translate * multiplier || 0;
  }

  var params = swiper.params;
  var translatesDiff = swiper.maxTranslate() - swiper.minTranslate();
  var progress = swiper.progress,
      isBeginning = swiper.isBeginning,
      isEnd = swiper.isEnd;
  var wasBeginning = isBeginning;
  var wasEnd = isEnd;

  if (translatesDiff === 0) {
    progress = 0;
    isBeginning = true;
    isEnd = true;
  } else {
    progress = (translate - swiper.minTranslate()) / translatesDiff;
    isBeginning = progress <= 0;
    isEnd = progress >= 1;
  }

  Utils.extend(swiper, {
    progress: progress,
    isBeginning: isBeginning,
    isEnd: isEnd
  });
  if (params.watchSlidesProgress || params.watchSlidesVisibility || params.centeredSlides && params.autoHeight) swiper.updateSlidesProgress(translate);

  if (isBeginning && !wasBeginning) {
    swiper.emit('reachBeginning toEdge');
  }

  if (isEnd && !wasEnd) {
    swiper.emit('reachEnd toEdge');
  }

  if (wasBeginning && !isBeginning || wasEnd && !isEnd) {
    swiper.emit('fromEdge');
  }

  swiper.emit('progress', progress);
}

function updateSlidesClasses() {
  var swiper = this;
  var slides = swiper.slides,
      params = swiper.params,
      $wrapperEl = swiper.$wrapperEl,
      activeIndex = swiper.activeIndex,
      realIndex = swiper.realIndex;
  var isVirtual = swiper.virtual && params.virtual.enabled;
  slides.removeClass("".concat(params.slideActiveClass, " ").concat(params.slideNextClass, " ").concat(params.slidePrevClass, " ").concat(params.slideDuplicateActiveClass, " ").concat(params.slideDuplicateNextClass, " ").concat(params.slideDuplicatePrevClass));
  var activeSlide;

  if (isVirtual) {
    activeSlide = swiper.$wrapperEl.find(".".concat(params.slideClass, "[data-swiper-slide-index=\"").concat(activeIndex, "\"]"));
  } else {
    activeSlide = slides.eq(activeIndex);
  } // Active classes


  activeSlide.addClass(params.slideActiveClass);

  if (params.loop) {
    // Duplicate to all looped slides
    if (activeSlide.hasClass(params.slideDuplicateClass)) {
      $wrapperEl.children(".".concat(params.slideClass, ":not(.").concat(params.slideDuplicateClass, ")[data-swiper-slide-index=\"").concat(realIndex, "\"]")).addClass(params.slideDuplicateActiveClass);
    } else {
      $wrapperEl.children(".".concat(params.slideClass, ".").concat(params.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(realIndex, "\"]")).addClass(params.slideDuplicateActiveClass);
    }
  } // Next Slide


  var nextSlide = activeSlide.nextAll(".".concat(params.slideClass)).eq(0).addClass(params.slideNextClass);

  if (params.loop && nextSlide.length === 0) {
    nextSlide = slides.eq(0);
    nextSlide.addClass(params.slideNextClass);
  } // Prev Slide


  var prevSlide = activeSlide.prevAll(".".concat(params.slideClass)).eq(0).addClass(params.slidePrevClass);

  if (params.loop && prevSlide.length === 0) {
    prevSlide = slides.eq(-1);
    prevSlide.addClass(params.slidePrevClass);
  }

  if (params.loop) {
    // Duplicate to all looped slides
    if (nextSlide.hasClass(params.slideDuplicateClass)) {
      $wrapperEl.children(".".concat(params.slideClass, ":not(.").concat(params.slideDuplicateClass, ")[data-swiper-slide-index=\"").concat(nextSlide.attr('data-swiper-slide-index'), "\"]")).addClass(params.slideDuplicateNextClass);
    } else {
      $wrapperEl.children(".".concat(params.slideClass, ".").concat(params.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(nextSlide.attr('data-swiper-slide-index'), "\"]")).addClass(params.slideDuplicateNextClass);
    }

    if (prevSlide.hasClass(params.slideDuplicateClass)) {
      $wrapperEl.children(".".concat(params.slideClass, ":not(.").concat(params.slideDuplicateClass, ")[data-swiper-slide-index=\"").concat(prevSlide.attr('data-swiper-slide-index'), "\"]")).addClass(params.slideDuplicatePrevClass);
    } else {
      $wrapperEl.children(".".concat(params.slideClass, ".").concat(params.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(prevSlide.attr('data-swiper-slide-index'), "\"]")).addClass(params.slideDuplicatePrevClass);
    }
  }
}

function updateActiveIndex(newActiveIndex) {
  var swiper = this;
  var translate = swiper.rtlTranslate ? swiper.translate : -swiper.translate;
  var slidesGrid = swiper.slidesGrid,
      snapGrid = swiper.snapGrid,
      params = swiper.params,
      previousIndex = swiper.activeIndex,
      previousRealIndex = swiper.realIndex,
      previousSnapIndex = swiper.snapIndex;
  var activeIndex = newActiveIndex;
  var snapIndex;

  if (typeof activeIndex === 'undefined') {
    for (var i = 0; i < slidesGrid.length; i += 1) {
      if (typeof slidesGrid[i + 1] !== 'undefined') {
        if (translate >= slidesGrid[i] && translate < slidesGrid[i + 1] - (slidesGrid[i + 1] - slidesGrid[i]) / 2) {
          activeIndex = i;
        } else if (translate >= slidesGrid[i] && translate < slidesGrid[i + 1]) {
          activeIndex = i + 1;
        }
      } else if (translate >= slidesGrid[i]) {
        activeIndex = i;
      }
    } // Normalize slideIndex


    if (params.normalizeSlideIndex) {
      if (activeIndex < 0 || typeof activeIndex === 'undefined') activeIndex = 0;
    }
  }

  if (snapGrid.indexOf(translate) >= 0) {
    snapIndex = snapGrid.indexOf(translate);
  } else {
    var skip = Math.min(params.slidesPerGroupSkip, activeIndex);
    snapIndex = skip + Math.floor((activeIndex - skip) / params.slidesPerGroup);
  }

  if (snapIndex >= snapGrid.length) snapIndex = snapGrid.length - 1;

  if (activeIndex === previousIndex) {
    if (snapIndex !== previousSnapIndex) {
      swiper.snapIndex = snapIndex;
      swiper.emit('snapIndexChange');
    }

    return;
  } // Get real index


  var realIndex = parseInt(swiper.slides.eq(activeIndex).attr('data-swiper-slide-index') || activeIndex, 10);
  Utils.extend(swiper, {
    snapIndex: snapIndex,
    realIndex: realIndex,
    previousIndex: previousIndex,
    activeIndex: activeIndex
  });
  swiper.emit('activeIndexChange');
  swiper.emit('snapIndexChange');

  if (previousRealIndex !== realIndex) {
    swiper.emit('realIndexChange');
  }

  if (swiper.initialized || swiper.params.runCallbacksOnInit) {
    swiper.emit('slideChange');
  }
}

function updateClickedSlide(e) {
  var swiper = this;
  var params = swiper.params;
  var slide = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target).closest(".".concat(params.slideClass))[0];
  var slideFound = false;

  if (slide) {
    for (var i = 0; i < swiper.slides.length; i += 1) {
      if (swiper.slides[i] === slide) slideFound = true;
    }
  }

  if (slide && slideFound) {
    swiper.clickedSlide = slide;

    if (swiper.virtual && swiper.params.virtual.enabled) {
      swiper.clickedIndex = parseInt(Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slide).attr('data-swiper-slide-index'), 10);
    } else {
      swiper.clickedIndex = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slide).index();
    }
  } else {
    swiper.clickedSlide = undefined;
    swiper.clickedIndex = undefined;
    return;
  }

  if (params.slideToClickedSlide && swiper.clickedIndex !== undefined && swiper.clickedIndex !== swiper.activeIndex) {
    swiper.slideToClickedSlide();
  }
}

var update = {
  updateSize: updateSize,
  updateSlides: updateSlides,
  updateAutoHeight: updateAutoHeight,
  updateSlidesOffset: updateSlidesOffset,
  updateSlidesProgress: updateSlidesProgress,
  updateProgress: updateProgress,
  updateSlidesClasses: updateSlidesClasses,
  updateActiveIndex: updateActiveIndex,
  updateClickedSlide: updateClickedSlide
};

function getTranslate() {
  var axis = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.isHorizontal() ? 'x' : 'y';
  var swiper = this;
  var params = swiper.params,
      rtl = swiper.rtlTranslate,
      translate = swiper.translate,
      $wrapperEl = swiper.$wrapperEl;

  if (params.virtualTranslate) {
    return rtl ? -translate : translate;
  }

  if (params.cssMode) {
    return translate;
  }

  var currentTranslate = Utils.getTranslate($wrapperEl[0], axis);
  if (rtl) currentTranslate = -currentTranslate;
  return currentTranslate || 0;
}

function setTranslate(translate, byController) {
  var swiper = this;
  var rtl = swiper.rtlTranslate,
      params = swiper.params,
      $wrapperEl = swiper.$wrapperEl,
      wrapperEl = swiper.wrapperEl,
      progress = swiper.progress;
  var x = 0;
  var y = 0;
  var z = 0;

  if (swiper.isHorizontal()) {
    x = rtl ? -translate : translate;
  } else {
    y = translate;
  }

  if (params.roundLengths) {
    x = Math.floor(x);
    y = Math.floor(y);
  }

  if (params.cssMode) {
    wrapperEl[swiper.isHorizontal() ? 'scrollLeft' : 'scrollTop'] = swiper.isHorizontal() ? -x : -y;
  } else if (!params.virtualTranslate) {
    $wrapperEl.transform("translate3d(".concat(x, "px, ").concat(y, "px, ").concat(z, "px)"));
  }

  swiper.previousTranslate = swiper.translate;
  swiper.translate = swiper.isHorizontal() ? x : y; // Check if we need to update progress

  var newProgress;
  var translatesDiff = swiper.maxTranslate() - swiper.minTranslate();

  if (translatesDiff === 0) {
    newProgress = 0;
  } else {
    newProgress = (translate - swiper.minTranslate()) / translatesDiff;
  }

  if (newProgress !== progress) {
    swiper.updateProgress(translate);
  }

  swiper.emit('setTranslate', swiper.translate, byController);
}

function minTranslate() {
  return -this.snapGrid[0];
}

function maxTranslate() {
  return -this.snapGrid[this.snapGrid.length - 1];
}

function translateTo() {
  var translate = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
  var speed = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.params.speed;
  var runCallbacks = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
  var translateBounds = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : true;
  var internal = arguments.length > 4 ? arguments[4] : undefined;
  var swiper = this;
  var params = swiper.params,
      wrapperEl = swiper.wrapperEl;

  if (swiper.animating && params.preventInteractionOnTransition) {
    return false;
  }

  var minTranslate = swiper.minTranslate();
  var maxTranslate = swiper.maxTranslate();
  var newTranslate;
  if (translateBounds && translate > minTranslate) newTranslate = minTranslate;else if (translateBounds && translate < maxTranslate) newTranslate = maxTranslate;else newTranslate = translate; // Update progress

  swiper.updateProgress(newTranslate);

  if (params.cssMode) {
    var isH = swiper.isHorizontal();

    if (speed === 0) {
      wrapperEl[isH ? 'scrollLeft' : 'scrollTop'] = -newTranslate;
    } else {
      // eslint-disable-next-line
      if (wrapperEl.scrollTo) {
        var _wrapperEl$scrollTo;

        wrapperEl.scrollTo((_wrapperEl$scrollTo = {}, _defineProperty(_wrapperEl$scrollTo, isH ? 'left' : 'top', -newTranslate), _defineProperty(_wrapperEl$scrollTo, "behavior", 'smooth'), _wrapperEl$scrollTo));
      } else {
        wrapperEl[isH ? 'scrollLeft' : 'scrollTop'] = -newTranslate;
      }
    }

    return true;
  }

  if (speed === 0) {
    swiper.setTransition(0);
    swiper.setTranslate(newTranslate);

    if (runCallbacks) {
      swiper.emit('beforeTransitionStart', speed, internal);
      swiper.emit('transitionEnd');
    }
  } else {
    swiper.setTransition(speed);
    swiper.setTranslate(newTranslate);

    if (runCallbacks) {
      swiper.emit('beforeTransitionStart', speed, internal);
      swiper.emit('transitionStart');
    }

    if (!swiper.animating) {
      swiper.animating = true;

      if (!swiper.onTranslateToWrapperTransitionEnd) {
        swiper.onTranslateToWrapperTransitionEnd = function transitionEnd(e) {
          if (!swiper || swiper.destroyed) return;
          if (e.target !== this) return;
          swiper.$wrapperEl[0].removeEventListener('transitionend', swiper.onTranslateToWrapperTransitionEnd);
          swiper.$wrapperEl[0].removeEventListener('webkitTransitionEnd', swiper.onTranslateToWrapperTransitionEnd);
          swiper.onTranslateToWrapperTransitionEnd = null;
          delete swiper.onTranslateToWrapperTransitionEnd;

          if (runCallbacks) {
            swiper.emit('transitionEnd');
          }
        };
      }

      swiper.$wrapperEl[0].addEventListener('transitionend', swiper.onTranslateToWrapperTransitionEnd);
      swiper.$wrapperEl[0].addEventListener('webkitTransitionEnd', swiper.onTranslateToWrapperTransitionEnd);
    }
  }

  return true;
}

var translate = {
  getTranslate: getTranslate,
  setTranslate: setTranslate,
  minTranslate: minTranslate,
  maxTranslate: maxTranslate,
  translateTo: translateTo
};

function setTransition(duration, byController) {
  var swiper = this;

  if (!swiper.params.cssMode) {
    swiper.$wrapperEl.transition(duration);
  }

  swiper.emit('setTransition', duration, byController);
}

function transitionStart() {
  var runCallbacks = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
  var direction = arguments.length > 1 ? arguments[1] : undefined;
  var swiper = this;
  var activeIndex = swiper.activeIndex,
      params = swiper.params,
      previousIndex = swiper.previousIndex;
  if (params.cssMode) return;

  if (params.autoHeight) {
    swiper.updateAutoHeight();
  }

  var dir = direction;

  if (!dir) {
    if (activeIndex > previousIndex) dir = 'next';else if (activeIndex < previousIndex) dir = 'prev';else dir = 'reset';
  }

  swiper.emit('transitionStart');

  if (runCallbacks && activeIndex !== previousIndex) {
    if (dir === 'reset') {
      swiper.emit('slideResetTransitionStart');
      return;
    }

    swiper.emit('slideChangeTransitionStart');

    if (dir === 'next') {
      swiper.emit('slideNextTransitionStart');
    } else {
      swiper.emit('slidePrevTransitionStart');
    }
  }
}

function transitionEnd() {
  var runCallbacks = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
  var direction = arguments.length > 1 ? arguments[1] : undefined;
  var swiper = this;
  var activeIndex = swiper.activeIndex,
      previousIndex = swiper.previousIndex,
      params = swiper.params;
  swiper.animating = false;
  if (params.cssMode) return;
  swiper.setTransition(0);
  var dir = direction;

  if (!dir) {
    if (activeIndex > previousIndex) dir = 'next';else if (activeIndex < previousIndex) dir = 'prev';else dir = 'reset';
  }

  swiper.emit('transitionEnd');

  if (runCallbacks && activeIndex !== previousIndex) {
    if (dir === 'reset') {
      swiper.emit('slideResetTransitionEnd');
      return;
    }

    swiper.emit('slideChangeTransitionEnd');

    if (dir === 'next') {
      swiper.emit('slideNextTransitionEnd');
    } else {
      swiper.emit('slidePrevTransitionEnd');
    }
  }
}

var transition = {
  setTransition: setTransition,
  transitionStart: transitionStart,
  transitionEnd: transitionEnd
};

function slideTo() {
  var index = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
  var speed = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.params.speed;
  var runCallbacks = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
  var internal = arguments.length > 3 ? arguments[3] : undefined;
  var swiper = this;
  var slideIndex = index;
  if (slideIndex < 0) slideIndex = 0;
  var params = swiper.params,
      snapGrid = swiper.snapGrid,
      slidesGrid = swiper.slidesGrid,
      previousIndex = swiper.previousIndex,
      activeIndex = swiper.activeIndex,
      rtl = swiper.rtlTranslate,
      wrapperEl = swiper.wrapperEl;

  if (swiper.animating && params.preventInteractionOnTransition) {
    return false;
  }

  var skip = Math.min(swiper.params.slidesPerGroupSkip, slideIndex);
  var snapIndex = skip + Math.floor((slideIndex - skip) / swiper.params.slidesPerGroup);
  if (snapIndex >= snapGrid.length) snapIndex = snapGrid.length - 1;

  if ((activeIndex || params.initialSlide || 0) === (previousIndex || 0) && runCallbacks) {
    swiper.emit('beforeSlideChangeStart');
  }

  var translate = -snapGrid[snapIndex]; // Update progress

  swiper.updateProgress(translate); // Normalize slideIndex

  if (params.normalizeSlideIndex) {
    for (var i = 0; i < slidesGrid.length; i += 1) {
      if (-Math.floor(translate * 100) >= Math.floor(slidesGrid[i] * 100)) {
        slideIndex = i;
      }
    }
  } // Directions locks


  if (swiper.initialized && slideIndex !== activeIndex) {
    if (!swiper.allowSlideNext && translate < swiper.translate && translate < swiper.minTranslate()) {
      return false;
    }

    if (!swiper.allowSlidePrev && translate > swiper.translate && translate > swiper.maxTranslate()) {
      if ((activeIndex || 0) !== slideIndex) return false;
    }
  }

  var direction;
  if (slideIndex > activeIndex) direction = 'next';else if (slideIndex < activeIndex) direction = 'prev';else direction = 'reset'; // Update Index

  if (rtl && -translate === swiper.translate || !rtl && translate === swiper.translate) {
    swiper.updateActiveIndex(slideIndex); // Update Height

    if (params.autoHeight) {
      swiper.updateAutoHeight();
    }

    swiper.updateSlidesClasses();

    if (params.effect !== 'slide') {
      swiper.setTranslate(translate);
    }

    if (direction !== 'reset') {
      swiper.transitionStart(runCallbacks, direction);
      swiper.transitionEnd(runCallbacks, direction);
    }

    return false;
  }

  if (params.cssMode) {
    var isH = swiper.isHorizontal();
    var t = -translate;

    if (rtl) {
      t = wrapperEl.scrollWidth - wrapperEl.offsetWidth - t;
    }

    if (speed === 0) {
      wrapperEl[isH ? 'scrollLeft' : 'scrollTop'] = t;
    } else {
      // eslint-disable-next-line
      if (wrapperEl.scrollTo) {
        var _wrapperEl$scrollTo2;

        wrapperEl.scrollTo((_wrapperEl$scrollTo2 = {}, _defineProperty(_wrapperEl$scrollTo2, isH ? 'left' : 'top', t), _defineProperty(_wrapperEl$scrollTo2, "behavior", 'smooth'), _wrapperEl$scrollTo2));
      } else {
        wrapperEl[isH ? 'scrollLeft' : 'scrollTop'] = t;
      }
    }

    return true;
  }

  if (speed === 0) {
    swiper.setTransition(0);
    swiper.setTranslate(translate);
    swiper.updateActiveIndex(slideIndex);
    swiper.updateSlidesClasses();
    swiper.emit('beforeTransitionStart', speed, internal);
    swiper.transitionStart(runCallbacks, direction);
    swiper.transitionEnd(runCallbacks, direction);
  } else {
    swiper.setTransition(speed);
    swiper.setTranslate(translate);
    swiper.updateActiveIndex(slideIndex);
    swiper.updateSlidesClasses();
    swiper.emit('beforeTransitionStart', speed, internal);
    swiper.transitionStart(runCallbacks, direction);

    if (!swiper.animating) {
      swiper.animating = true;

      if (!swiper.onSlideToWrapperTransitionEnd) {
        swiper.onSlideToWrapperTransitionEnd = function transitionEnd(e) {
          if (!swiper || swiper.destroyed) return;
          if (e.target !== this) return;
          swiper.$wrapperEl[0].removeEventListener('transitionend', swiper.onSlideToWrapperTransitionEnd);
          swiper.$wrapperEl[0].removeEventListener('webkitTransitionEnd', swiper.onSlideToWrapperTransitionEnd);
          swiper.onSlideToWrapperTransitionEnd = null;
          delete swiper.onSlideToWrapperTransitionEnd;
          swiper.transitionEnd(runCallbacks, direction);
        };
      }

      swiper.$wrapperEl[0].addEventListener('transitionend', swiper.onSlideToWrapperTransitionEnd);
      swiper.$wrapperEl[0].addEventListener('webkitTransitionEnd', swiper.onSlideToWrapperTransitionEnd);
    }
  }

  return true;
}

function slideToLoop() {
  var index = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
  var speed = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : this.params.speed;
  var runCallbacks = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : true;
  var internal = arguments.length > 3 ? arguments[3] : undefined;
  var swiper = this;
  var newIndex = index;

  if (swiper.params.loop) {
    newIndex += swiper.loopedSlides;
  }

  return swiper.slideTo(newIndex, speed, runCallbacks, internal);
}
/* eslint no-unused-vars: "off" */


function slideNext() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.params.speed;
  var runCallbacks = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var internal = arguments.length > 2 ? arguments[2] : undefined;
  var swiper = this;
  var params = swiper.params,
      animating = swiper.animating;
  var increment = swiper.activeIndex < params.slidesPerGroupSkip ? 1 : params.slidesPerGroup;

  if (params.loop) {
    if (animating) return false;
    swiper.loopFix(); // eslint-disable-next-line

    swiper._clientLeft = swiper.$wrapperEl[0].clientLeft;
  }

  return swiper.slideTo(swiper.activeIndex + increment, speed, runCallbacks, internal);
}
/* eslint no-unused-vars: "off" */


function slidePrev() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.params.speed;
  var runCallbacks = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var internal = arguments.length > 2 ? arguments[2] : undefined;
  var swiper = this;
  var params = swiper.params,
      animating = swiper.animating,
      snapGrid = swiper.snapGrid,
      slidesGrid = swiper.slidesGrid,
      rtlTranslate = swiper.rtlTranslate;

  if (params.loop) {
    if (animating) return false;
    swiper.loopFix(); // eslint-disable-next-line

    swiper._clientLeft = swiper.$wrapperEl[0].clientLeft;
  }

  var translate = rtlTranslate ? swiper.translate : -swiper.translate;

  function normalize(val) {
    if (val < 0) return -Math.floor(Math.abs(val));
    return Math.floor(val);
  }

  var normalizedTranslate = normalize(translate);
  var normalizedSnapGrid = snapGrid.map(function (val) {
    return normalize(val);
  });
  var normalizedSlidesGrid = slidesGrid.map(function (val) {
    return normalize(val);
  });
  var currentSnap = snapGrid[normalizedSnapGrid.indexOf(normalizedTranslate)];
  var prevSnap = snapGrid[normalizedSnapGrid.indexOf(normalizedTranslate) - 1];

  if (typeof prevSnap === 'undefined' && params.cssMode) {
    snapGrid.forEach(function (snap) {
      if (!prevSnap && normalizedTranslate >= snap) prevSnap = snap;
    });
  }

  var prevIndex;

  if (typeof prevSnap !== 'undefined') {
    prevIndex = slidesGrid.indexOf(prevSnap);
    if (prevIndex < 0) prevIndex = swiper.activeIndex - 1;
  }

  return swiper.slideTo(prevIndex, speed, runCallbacks, internal);
}
/* eslint no-unused-vars: "off" */


function slideReset() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.params.speed;
  var runCallbacks = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var internal = arguments.length > 2 ? arguments[2] : undefined;
  var swiper = this;
  return swiper.slideTo(swiper.activeIndex, speed, runCallbacks, internal);
}
/* eslint no-unused-vars: "off" */


function slideToClosest() {
  var speed = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.params.speed;
  var runCallbacks = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
  var internal = arguments.length > 2 ? arguments[2] : undefined;
  var threshold = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 0.5;
  var swiper = this;
  var index = swiper.activeIndex;
  var skip = Math.min(swiper.params.slidesPerGroupSkip, index);
  var snapIndex = skip + Math.floor((index - skip) / swiper.params.slidesPerGroup);
  var translate = swiper.rtlTranslate ? swiper.translate : -swiper.translate;

  if (translate >= swiper.snapGrid[snapIndex]) {
    // The current translate is on or after the current snap index, so the choice
    // is between the current index and the one after it.
    var currentSnap = swiper.snapGrid[snapIndex];
    var nextSnap = swiper.snapGrid[snapIndex + 1];

    if (translate - currentSnap > (nextSnap - currentSnap) * threshold) {
      index += swiper.params.slidesPerGroup;
    }
  } else {
    // The current translate is before the current snap index, so the choice
    // is between the current index and the one before it.
    var prevSnap = swiper.snapGrid[snapIndex - 1];
    var _currentSnap = swiper.snapGrid[snapIndex];

    if (translate - prevSnap <= (_currentSnap - prevSnap) * threshold) {
      index -= swiper.params.slidesPerGroup;
    }
  }

  index = Math.max(index, 0);
  index = Math.min(index, swiper.slidesGrid.length - 1);
  return swiper.slideTo(index, speed, runCallbacks, internal);
}

function slideToClickedSlide() {
  var swiper = this;
  var params = swiper.params,
      $wrapperEl = swiper.$wrapperEl;
  var slidesPerView = params.slidesPerView === 'auto' ? swiper.slidesPerViewDynamic() : params.slidesPerView;
  var slideToIndex = swiper.clickedIndex;
  var realIndex;

  if (params.loop) {
    if (swiper.animating) return;
    realIndex = parseInt(Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(swiper.clickedSlide).attr('data-swiper-slide-index'), 10);

    if (params.centeredSlides) {
      if (slideToIndex < swiper.loopedSlides - slidesPerView / 2 || slideToIndex > swiper.slides.length - swiper.loopedSlides + slidesPerView / 2) {
        swiper.loopFix();
        slideToIndex = $wrapperEl.children(".".concat(params.slideClass, "[data-swiper-slide-index=\"").concat(realIndex, "\"]:not(.").concat(params.slideDuplicateClass, ")")).eq(0).index();
        Utils.nextTick(function () {
          swiper.slideTo(slideToIndex);
        });
      } else {
        swiper.slideTo(slideToIndex);
      }
    } else if (slideToIndex > swiper.slides.length - slidesPerView) {
      swiper.loopFix();
      slideToIndex = $wrapperEl.children(".".concat(params.slideClass, "[data-swiper-slide-index=\"").concat(realIndex, "\"]:not(.").concat(params.slideDuplicateClass, ")")).eq(0).index();
      Utils.nextTick(function () {
        swiper.slideTo(slideToIndex);
      });
    } else {
      swiper.slideTo(slideToIndex);
    }
  } else {
    swiper.slideTo(slideToIndex);
  }
}

var slide = {
  slideTo: slideTo,
  slideToLoop: slideToLoop,
  slideNext: slideNext,
  slidePrev: slidePrev,
  slideReset: slideReset,
  slideToClosest: slideToClosest,
  slideToClickedSlide: slideToClickedSlide
};

function loopCreate() {
  var swiper = this;
  var params = swiper.params,
      $wrapperEl = swiper.$wrapperEl; // Remove duplicated slides

  $wrapperEl.children(".".concat(params.slideClass, ".").concat(params.slideDuplicateClass)).remove();
  var slides = $wrapperEl.children(".".concat(params.slideClass));

  if (params.loopFillGroupWithBlank) {
    var blankSlidesNum = params.slidesPerGroup - slides.length % params.slidesPerGroup;

    if (blankSlidesNum !== params.slidesPerGroup) {
      for (var i = 0; i < blankSlidesNum; i += 1) {
        var blankNode = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].createElement('div')).addClass("".concat(params.slideClass, " ").concat(params.slideBlankClass));
        $wrapperEl.append(blankNode);
      }

      slides = $wrapperEl.children(".".concat(params.slideClass));
    }
  }

  if (params.slidesPerView === 'auto' && !params.loopedSlides) params.loopedSlides = slides.length;
  swiper.loopedSlides = Math.ceil(parseFloat(params.loopedSlides || params.slidesPerView, 10));
  swiper.loopedSlides += params.loopAdditionalSlides;

  if (swiper.loopedSlides > slides.length) {
    swiper.loopedSlides = slides.length;
  }

  var prependSlides = [];
  var appendSlides = [];
  slides.each(function (index, el) {
    var slide = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(el);
    if (index < swiper.loopedSlides) appendSlides.push(el);
    if (index < slides.length && index >= slides.length - swiper.loopedSlides) prependSlides.push(el);
    slide.attr('data-swiper-slide-index', index);
  });

  for (var _i3 = 0; _i3 < appendSlides.length; _i3 += 1) {
    $wrapperEl.append(Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(appendSlides[_i3].cloneNode(true)).addClass(params.slideDuplicateClass));
  }

  for (var _i4 = prependSlides.length - 1; _i4 >= 0; _i4 -= 1) {
    $wrapperEl.prepend(Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(prependSlides[_i4].cloneNode(true)).addClass(params.slideDuplicateClass));
  }
}

function loopFix() {
  var swiper = this;
  swiper.emit('beforeLoopFix');
  var activeIndex = swiper.activeIndex,
      slides = swiper.slides,
      loopedSlides = swiper.loopedSlides,
      allowSlidePrev = swiper.allowSlidePrev,
      allowSlideNext = swiper.allowSlideNext,
      snapGrid = swiper.snapGrid,
      rtl = swiper.rtlTranslate;
  var newIndex;
  swiper.allowSlidePrev = true;
  swiper.allowSlideNext = true;
  var snapTranslate = -snapGrid[activeIndex];
  var diff = snapTranslate - swiper.getTranslate(); // Fix For Negative Oversliding

  if (activeIndex < loopedSlides) {
    newIndex = slides.length - loopedSlides * 3 + activeIndex;
    newIndex += loopedSlides;
    var slideChanged = swiper.slideTo(newIndex, 0, false, true);

    if (slideChanged && diff !== 0) {
      swiper.setTranslate((rtl ? -swiper.translate : swiper.translate) - diff);
    }
  } else if (activeIndex >= slides.length - loopedSlides) {
    // Fix For Positive Oversliding
    newIndex = -slides.length + activeIndex + loopedSlides;
    newIndex += loopedSlides;

    var _slideChanged = swiper.slideTo(newIndex, 0, false, true);

    if (_slideChanged && diff !== 0) {
      swiper.setTranslate((rtl ? -swiper.translate : swiper.translate) - diff);
    }
  }

  swiper.allowSlidePrev = allowSlidePrev;
  swiper.allowSlideNext = allowSlideNext;
  swiper.emit('loopFix');
}

function loopDestroy() {
  var swiper = this;
  var $wrapperEl = swiper.$wrapperEl,
      params = swiper.params,
      slides = swiper.slides;
  $wrapperEl.children(".".concat(params.slideClass, ".").concat(params.slideDuplicateClass, ",.").concat(params.slideClass, ".").concat(params.slideBlankClass)).remove();
  slides.removeAttr('data-swiper-slide-index');
}

var loop = {
  loopCreate: loopCreate,
  loopFix: loopFix,
  loopDestroy: loopDestroy
};

function setGrabCursor(moving) {
  var swiper = this;
  if (Support.touch || !swiper.params.simulateTouch || swiper.params.watchOverflow && swiper.isLocked || swiper.params.cssMode) return;
  var el = swiper.el;
  el.style.cursor = 'move';
  el.style.cursor = moving ? '-webkit-grabbing' : '-webkit-grab';
  el.style.cursor = moving ? '-moz-grabbin' : '-moz-grab';
  el.style.cursor = moving ? 'grabbing' : 'grab';
}

function unsetGrabCursor() {
  var swiper = this;
  if (Support.touch || swiper.params.watchOverflow && swiper.isLocked || swiper.params.cssMode) return;
  swiper.el.style.cursor = '';
}

var grabCursor = {
  setGrabCursor: setGrabCursor,
  unsetGrabCursor: unsetGrabCursor
};

function appendSlide(slides) {
  var swiper = this;
  var $wrapperEl = swiper.$wrapperEl,
      params = swiper.params;

  if (params.loop) {
    swiper.loopDestroy();
  }

  if (_typeof(slides) === 'object' && 'length' in slides) {
    for (var i = 0; i < slides.length; i += 1) {
      if (slides[i]) $wrapperEl.append(slides[i]);
    }
  } else {
    $wrapperEl.append(slides);
  }

  if (params.loop) {
    swiper.loopCreate();
  }

  if (!(params.observer && Support.observer)) {
    swiper.update();
  }
}

function prependSlide(slides) {
  var swiper = this;
  var params = swiper.params,
      $wrapperEl = swiper.$wrapperEl,
      activeIndex = swiper.activeIndex;

  if (params.loop) {
    swiper.loopDestroy();
  }

  var newActiveIndex = activeIndex + 1;

  if (_typeof(slides) === 'object' && 'length' in slides) {
    for (var i = 0; i < slides.length; i += 1) {
      if (slides[i]) $wrapperEl.prepend(slides[i]);
    }

    newActiveIndex = activeIndex + slides.length;
  } else {
    $wrapperEl.prepend(slides);
  }

  if (params.loop) {
    swiper.loopCreate();
  }

  if (!(params.observer && Support.observer)) {
    swiper.update();
  }

  swiper.slideTo(newActiveIndex, 0, false);
}

function addSlide(index, slides) {
  var swiper = this;
  var $wrapperEl = swiper.$wrapperEl,
      params = swiper.params,
      activeIndex = swiper.activeIndex;
  var activeIndexBuffer = activeIndex;

  if (params.loop) {
    activeIndexBuffer -= swiper.loopedSlides;
    swiper.loopDestroy();
    swiper.slides = $wrapperEl.children(".".concat(params.slideClass));
  }

  var baseLength = swiper.slides.length;

  if (index <= 0) {
    swiper.prependSlide(slides);
    return;
  }

  if (index >= baseLength) {
    swiper.appendSlide(slides);
    return;
  }

  var newActiveIndex = activeIndexBuffer > index ? activeIndexBuffer + 1 : activeIndexBuffer;
  var slidesBuffer = [];

  for (var i = baseLength - 1; i >= index; i -= 1) {
    var currentSlide = swiper.slides.eq(i);
    currentSlide.remove();
    slidesBuffer.unshift(currentSlide);
  }

  if (_typeof(slides) === 'object' && 'length' in slides) {
    for (var _i5 = 0; _i5 < slides.length; _i5 += 1) {
      if (slides[_i5]) $wrapperEl.append(slides[_i5]);
    }

    newActiveIndex = activeIndexBuffer > index ? activeIndexBuffer + slides.length : activeIndexBuffer;
  } else {
    $wrapperEl.append(slides);
  }

  for (var _i6 = 0; _i6 < slidesBuffer.length; _i6 += 1) {
    $wrapperEl.append(slidesBuffer[_i6]);
  }

  if (params.loop) {
    swiper.loopCreate();
  }

  if (!(params.observer && Support.observer)) {
    swiper.update();
  }

  if (params.loop) {
    swiper.slideTo(newActiveIndex + swiper.loopedSlides, 0, false);
  } else {
    swiper.slideTo(newActiveIndex, 0, false);
  }
}

function removeSlide(slidesIndexes) {
  var swiper = this;
  var params = swiper.params,
      $wrapperEl = swiper.$wrapperEl,
      activeIndex = swiper.activeIndex;
  var activeIndexBuffer = activeIndex;

  if (params.loop) {
    activeIndexBuffer -= swiper.loopedSlides;
    swiper.loopDestroy();
    swiper.slides = $wrapperEl.children(".".concat(params.slideClass));
  }

  var newActiveIndex = activeIndexBuffer;
  var indexToRemove;

  if (_typeof(slidesIndexes) === 'object' && 'length' in slidesIndexes) {
    for (var i = 0; i < slidesIndexes.length; i += 1) {
      indexToRemove = slidesIndexes[i];
      if (swiper.slides[indexToRemove]) swiper.slides.eq(indexToRemove).remove();
      if (indexToRemove < newActiveIndex) newActiveIndex -= 1;
    }

    newActiveIndex = Math.max(newActiveIndex, 0);
  } else {
    indexToRemove = slidesIndexes;
    if (swiper.slides[indexToRemove]) swiper.slides.eq(indexToRemove).remove();
    if (indexToRemove < newActiveIndex) newActiveIndex -= 1;
    newActiveIndex = Math.max(newActiveIndex, 0);
  }

  if (params.loop) {
    swiper.loopCreate();
  }

  if (!(params.observer && Support.observer)) {
    swiper.update();
  }

  if (params.loop) {
    swiper.slideTo(newActiveIndex + swiper.loopedSlides, 0, false);
  } else {
    swiper.slideTo(newActiveIndex, 0, false);
  }
}

function removeAllSlides() {
  var swiper = this;
  var slidesIndexes = [];

  for (var i = 0; i < swiper.slides.length; i += 1) {
    slidesIndexes.push(i);
  }

  swiper.removeSlide(slidesIndexes);
}

var manipulation = {
  appendSlide: appendSlide,
  prependSlide: prependSlide,
  addSlide: addSlide,
  removeSlide: removeSlide,
  removeAllSlides: removeAllSlides
};

var Device = function Device() {
  var platform = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.platform;
  var ua = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.userAgent;
  var device = {
    ios: false,
    android: false,
    androidChrome: false,
    desktop: false,
    iphone: false,
    ipod: false,
    ipad: false,
    edge: false,
    ie: false,
    firefox: false,
    macos: false,
    windows: false,
    cordova: !!(ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].cordova || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].phonegap),
    phonegap: !!(ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].cordova || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].phonegap),
    electron: false
  };
  var screenWidth = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].screen.width;
  var screenHeight = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].screen.height;
  var android = ua.match(/(Android);?[\s\/]+([\d.]+)?/); // eslint-disable-line

  var ipad = ua.match(/(iPad).*OS\s([\d_]+)/);
  var ipod = ua.match(/(iPod)(.*OS\s([\d_]+))?/);
  var iphone = !ipad && ua.match(/(iPhone\sOS|iOS)\s([\d_]+)/);
  var ie = ua.indexOf('MSIE ') >= 0 || ua.indexOf('Trident/') >= 0;
  var edge = ua.indexOf('Edge/') >= 0;
  var firefox = ua.indexOf('Gecko/') >= 0 && ua.indexOf('Firefox/') >= 0;
  var windows = platform === 'Win32';
  var electron = ua.toLowerCase().indexOf('electron') >= 0;
  var macos = platform === 'MacIntel'; // iPadOs 13 fix

  if (!ipad && macos && Support.touch && (screenWidth === 1024 && screenHeight === 1366 || // Pro 12.9
  screenWidth === 834 && screenHeight === 1194 // Pro 11
  || screenWidth === 834 && screenHeight === 1112 // Pro 10.5
  || screenWidth === 768 && screenHeight === 1024 // other
  )) {
    ipad = ua.match(/(Version)\/([\d.]+)/);
    macos = false;
  }

  device.ie = ie;
  device.edge = edge;
  device.firefox = firefox; // Android

  if (android && !windows) {
    device.os = 'android';
    device.osVersion = android[2];
    device.android = true;
    device.androidChrome = ua.toLowerCase().indexOf('chrome') >= 0;
  }

  if (ipad || iphone || ipod) {
    device.os = 'ios';
    device.ios = true;
  } // iOS


  if (iphone && !ipod) {
    device.osVersion = iphone[2].replace(/_/g, '.');
    device.iphone = true;
  }

  if (ipad) {
    device.osVersion = ipad[2].replace(/_/g, '.');
    device.ipad = true;
  }

  if (ipod) {
    device.osVersion = ipod[3] ? ipod[3].replace(/_/g, '.') : null;
    device.ipod = true;
  } // iOS 8+ changed UA


  if (device.ios && device.osVersion && ua.indexOf('Version/') >= 0) {
    if (device.osVersion.split('.')[0] === '10') {
      device.osVersion = ua.toLowerCase().split('version/')[1].split(' ')[0];
    }
  } // Webview


  device.webView = !!((iphone || ipad || ipod) && (ua.match(/.*AppleWebKit(?!.*Safari)/i) || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.standalone)) || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].matchMedia && ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].matchMedia('(display-mode: standalone)').matches;
  device.webview = device.webView;
  device.standalone = device.webView; // Desktop

  device.desktop = !(device.ios || device.android) || electron;

  if (device.desktop) {
    device.electron = electron;
    device.macos = macos;
    device.windows = windows;

    if (device.macos) {
      device.os = 'macos';
    }

    if (device.windows) {
      device.os = 'windows';
    }
  } // Pixel Ratio


  device.pixelRatio = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].devicePixelRatio || 1; // Export object

  return device;
}();

function onTouchStart(event) {
  var swiper = this;
  var data = swiper.touchEventsData;
  var params = swiper.params,
      touches = swiper.touches;

  if (swiper.animating && params.preventInteractionOnTransition) {
    return;
  }

  var e = event;
  if (e.originalEvent) e = e.originalEvent;
  var $targetEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target);

  if (params.touchEventsTarget === 'wrapper') {
    if (!$targetEl.closest(swiper.wrapperEl).length) return;
  }

  data.isTouchEvent = e.type === 'touchstart';
  if (!data.isTouchEvent && 'which' in e && e.which === 3) return;
  if (!data.isTouchEvent && 'button' in e && e.button > 0) return;
  if (data.isTouched && data.isMoved) return;

  if (params.noSwiping && $targetEl.closest(params.noSwipingSelector ? params.noSwipingSelector : ".".concat(params.noSwipingClass))[0]) {
    swiper.allowClick = true;
    return;
  }

  if (params.swipeHandler) {
    if (!$targetEl.closest(params.swipeHandler)[0]) return;
  }

  touches.currentX = e.type === 'touchstart' ? e.targetTouches[0].pageX : e.pageX;
  touches.currentY = e.type === 'touchstart' ? e.targetTouches[0].pageY : e.pageY;
  var startX = touches.currentX;
  var startY = touches.currentY; // Do NOT start if iOS edge swipe is detected. Otherwise iOS app cannot swipe-to-go-back anymore

  var edgeSwipeDetection = params.edgeSwipeDetection || params.iOSEdgeSwipeDetection;
  var edgeSwipeThreshold = params.edgeSwipeThreshold || params.iOSEdgeSwipeThreshold;

  if (edgeSwipeDetection && (startX <= edgeSwipeThreshold || startX >= ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].screen.width - edgeSwipeThreshold)) {
    return;
  }

  Utils.extend(data, {
    isTouched: true,
    isMoved: false,
    allowTouchCallbacks: true,
    isScrolling: undefined,
    startMoving: undefined
  });
  touches.startX = startX;
  touches.startY = startY;
  data.touchStartTime = Utils.now();
  swiper.allowClick = true;
  swiper.updateSize();
  swiper.swipeDirection = undefined;
  if (params.threshold > 0) data.allowThresholdMove = false;

  if (e.type !== 'touchstart') {
    var preventDefault = true;
    if ($targetEl.is(data.formElements)) preventDefault = false;

    if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement && Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement).is(data.formElements) && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement !== $targetEl[0]) {
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement.blur();
    }

    var shouldPreventDefault = preventDefault && swiper.allowTouchMove && params.touchStartPreventDefault;

    if (params.touchStartForcePreventDefault || shouldPreventDefault) {
      e.preventDefault();
    }
  }

  swiper.emit('touchStart', e);
}

function onTouchMove(event) {
  var swiper = this;
  var data = swiper.touchEventsData;
  var params = swiper.params,
      touches = swiper.touches,
      rtl = swiper.rtlTranslate;
  var e = event;
  if (e.originalEvent) e = e.originalEvent;

  if (!data.isTouched) {
    if (data.startMoving && data.isScrolling) {
      swiper.emit('touchMoveOpposite', e);
    }

    return;
  }

  if (data.isTouchEvent && e.type !== 'touchmove') return;
  var targetTouch = e.type === 'touchmove' && e.targetTouches && (e.targetTouches[0] || e.changedTouches[0]);
  var pageX = e.type === 'touchmove' ? targetTouch.pageX : e.pageX;
  var pageY = e.type === 'touchmove' ? targetTouch.pageY : e.pageY;

  if (e.preventedByNestedSwiper) {
    touches.startX = pageX;
    touches.startY = pageY;
    return;
  }

  if (!swiper.allowTouchMove) {
    // isMoved = true;
    swiper.allowClick = false;

    if (data.isTouched) {
      Utils.extend(touches, {
        startX: pageX,
        startY: pageY,
        currentX: pageX,
        currentY: pageY
      });
      data.touchStartTime = Utils.now();
    }

    return;
  }

  if (data.isTouchEvent && params.touchReleaseOnEdges && !params.loop) {
    if (swiper.isVertical()) {
      // Vertical
      if (pageY < touches.startY && swiper.translate <= swiper.maxTranslate() || pageY > touches.startY && swiper.translate >= swiper.minTranslate()) {
        data.isTouched = false;
        data.isMoved = false;
        return;
      }
    } else if (pageX < touches.startX && swiper.translate <= swiper.maxTranslate() || pageX > touches.startX && swiper.translate >= swiper.minTranslate()) {
      return;
    }
  }

  if (data.isTouchEvent && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement) {
    if (e.target === ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement && Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target).is(data.formElements)) {
      data.isMoved = true;
      swiper.allowClick = false;
      return;
    }
  }

  if (data.allowTouchCallbacks) {
    swiper.emit('touchMove', e);
  }

  if (e.targetTouches && e.targetTouches.length > 1) return;
  touches.currentX = pageX;
  touches.currentY = pageY;
  var diffX = touches.currentX - touches.startX;
  var diffY = touches.currentY - touches.startY;
  if (swiper.params.threshold && Math.sqrt(Math.pow(diffX, 2) + Math.pow(diffY, 2)) < swiper.params.threshold) return;

  if (typeof data.isScrolling === 'undefined') {
    var touchAngle;

    if (swiper.isHorizontal() && touches.currentY === touches.startY || swiper.isVertical() && touches.currentX === touches.startX) {
      data.isScrolling = false;
    } else {
      // eslint-disable-next-line
      if (diffX * diffX + diffY * diffY >= 25) {
        touchAngle = Math.atan2(Math.abs(diffY), Math.abs(diffX)) * 180 / Math.PI;
        data.isScrolling = swiper.isHorizontal() ? touchAngle > params.touchAngle : 90 - touchAngle > params.touchAngle;
      }
    }
  }

  if (data.isScrolling) {
    swiper.emit('touchMoveOpposite', e);
  }

  if (typeof data.startMoving === 'undefined') {
    if (touches.currentX !== touches.startX || touches.currentY !== touches.startY) {
      data.startMoving = true;
    }
  }

  if (data.isScrolling) {
    data.isTouched = false;
    return;
  }

  if (!data.startMoving) {
    return;
  }

  swiper.allowClick = false;

  if (!params.cssMode && e.cancelable) {
    e.preventDefault();
  }

  if (params.touchMoveStopPropagation && !params.nested) {
    e.stopPropagation();
  }

  if (!data.isMoved) {
    if (params.loop) {
      swiper.loopFix();
    }

    data.startTranslate = swiper.getTranslate();
    swiper.setTransition(0);

    if (swiper.animating) {
      swiper.$wrapperEl.trigger('webkitTransitionEnd transitionend');
    }

    data.allowMomentumBounce = false; // Grab Cursor

    if (params.grabCursor && (swiper.allowSlideNext === true || swiper.allowSlidePrev === true)) {
      swiper.setGrabCursor(true);
    }

    swiper.emit('sliderFirstMove', e);
  }

  swiper.emit('sliderMove', e);
  data.isMoved = true;
  var diff = swiper.isHorizontal() ? diffX : diffY;
  touches.diff = diff;
  diff *= params.touchRatio;
  if (rtl) diff = -diff;
  swiper.swipeDirection = diff > 0 ? 'prev' : 'next';
  data.currentTranslate = diff + data.startTranslate;
  var disableParentSwiper = true;
  var resistanceRatio = params.resistanceRatio;

  if (params.touchReleaseOnEdges) {
    resistanceRatio = 0;
  }

  if (diff > 0 && data.currentTranslate > swiper.minTranslate()) {
    disableParentSwiper = false;
    if (params.resistance) data.currentTranslate = swiper.minTranslate() - 1 + Math.pow(-swiper.minTranslate() + data.startTranslate + diff, resistanceRatio);
  } else if (diff < 0 && data.currentTranslate < swiper.maxTranslate()) {
    disableParentSwiper = false;
    if (params.resistance) data.currentTranslate = swiper.maxTranslate() + 1 - Math.pow(swiper.maxTranslate() - data.startTranslate - diff, resistanceRatio);
  }

  if (disableParentSwiper) {
    e.preventedByNestedSwiper = true;
  } // Directions locks


  if (!swiper.allowSlideNext && swiper.swipeDirection === 'next' && data.currentTranslate < data.startTranslate) {
    data.currentTranslate = data.startTranslate;
  }

  if (!swiper.allowSlidePrev && swiper.swipeDirection === 'prev' && data.currentTranslate > data.startTranslate) {
    data.currentTranslate = data.startTranslate;
  } // Threshold


  if (params.threshold > 0) {
    if (Math.abs(diff) > params.threshold || data.allowThresholdMove) {
      if (!data.allowThresholdMove) {
        data.allowThresholdMove = true;
        touches.startX = touches.currentX;
        touches.startY = touches.currentY;
        data.currentTranslate = data.startTranslate;
        touches.diff = swiper.isHorizontal() ? touches.currentX - touches.startX : touches.currentY - touches.startY;
        return;
      }
    } else {
      data.currentTranslate = data.startTranslate;
      return;
    }
  }

  if (!params.followFinger || params.cssMode) return; // Update active index in free mode

  if (params.freeMode || params.watchSlidesProgress || params.watchSlidesVisibility) {
    swiper.updateActiveIndex();
    swiper.updateSlidesClasses();
  }

  if (params.freeMode) {
    // Velocity
    if (data.velocities.length === 0) {
      data.velocities.push({
        position: touches[swiper.isHorizontal() ? 'startX' : 'startY'],
        time: data.touchStartTime
      });
    }

    data.velocities.push({
      position: touches[swiper.isHorizontal() ? 'currentX' : 'currentY'],
      time: Utils.now()
    });
  } // Update progress


  swiper.updateProgress(data.currentTranslate); // Update translate

  swiper.setTranslate(data.currentTranslate);
}

function onTouchEnd(event) {
  var swiper = this;
  var data = swiper.touchEventsData;
  var params = swiper.params,
      touches = swiper.touches,
      rtl = swiper.rtlTranslate,
      $wrapperEl = swiper.$wrapperEl,
      slidesGrid = swiper.slidesGrid,
      snapGrid = swiper.snapGrid;
  var e = event;
  if (e.originalEvent) e = e.originalEvent;

  if (data.allowTouchCallbacks) {
    swiper.emit('touchEnd', e);
  }

  data.allowTouchCallbacks = false;

  if (!data.isTouched) {
    if (data.isMoved && params.grabCursor) {
      swiper.setGrabCursor(false);
    }

    data.isMoved = false;
    data.startMoving = false;
    return;
  } // Return Grab Cursor


  if (params.grabCursor && data.isMoved && data.isTouched && (swiper.allowSlideNext === true || swiper.allowSlidePrev === true)) {
    swiper.setGrabCursor(false);
  } // Time diff


  var touchEndTime = Utils.now();
  var timeDiff = touchEndTime - data.touchStartTime; // Tap, doubleTap, Click

  if (swiper.allowClick) {
    swiper.updateClickedSlide(e);
    swiper.emit('tap click', e);

    if (timeDiff < 300 && touchEndTime - data.lastClickTime < 300) {
      swiper.emit('doubleTap doubleClick', e);
    }
  }

  data.lastClickTime = Utils.now();
  Utils.nextTick(function () {
    if (!swiper.destroyed) swiper.allowClick = true;
  });

  if (!data.isTouched || !data.isMoved || !swiper.swipeDirection || touches.diff === 0 || data.currentTranslate === data.startTranslate) {
    data.isTouched = false;
    data.isMoved = false;
    data.startMoving = false;
    return;
  }

  data.isTouched = false;
  data.isMoved = false;
  data.startMoving = false;
  var currentPos;

  if (params.followFinger) {
    currentPos = rtl ? swiper.translate : -swiper.translate;
  } else {
    currentPos = -data.currentTranslate;
  }

  if (params.cssMode) {
    return;
  }

  if (params.freeMode) {
    if (currentPos < -swiper.minTranslate()) {
      swiper.slideTo(swiper.activeIndex);
      return;
    }

    if (currentPos > -swiper.maxTranslate()) {
      if (swiper.slides.length < snapGrid.length) {
        swiper.slideTo(snapGrid.length - 1);
      } else {
        swiper.slideTo(swiper.slides.length - 1);
      }

      return;
    }

    if (params.freeModeMomentum) {
      if (data.velocities.length > 1) {
        var lastMoveEvent = data.velocities.pop();
        var velocityEvent = data.velocities.pop();
        var distance = lastMoveEvent.position - velocityEvent.position;
        var time = lastMoveEvent.time - velocityEvent.time;
        swiper.velocity = distance / time;
        swiper.velocity /= 2;

        if (Math.abs(swiper.velocity) < params.freeModeMinimumVelocity) {
          swiper.velocity = 0;
        } // this implies that the user stopped moving a finger then released.
        // There would be no events with distance zero, so the last event is stale.


        if (time > 150 || Utils.now() - lastMoveEvent.time > 300) {
          swiper.velocity = 0;
        }
      } else {
        swiper.velocity = 0;
      }

      swiper.velocity *= params.freeModeMomentumVelocityRatio;
      data.velocities.length = 0;
      var momentumDuration = 1000 * params.freeModeMomentumRatio;
      var momentumDistance = swiper.velocity * momentumDuration;
      var newPosition = swiper.translate + momentumDistance;
      if (rtl) newPosition = -newPosition;
      var doBounce = false;
      var afterBouncePosition;
      var bounceAmount = Math.abs(swiper.velocity) * 20 * params.freeModeMomentumBounceRatio;
      var needsLoopFix;

      if (newPosition < swiper.maxTranslate()) {
        if (params.freeModeMomentumBounce) {
          if (newPosition + swiper.maxTranslate() < -bounceAmount) {
            newPosition = swiper.maxTranslate() - bounceAmount;
          }

          afterBouncePosition = swiper.maxTranslate();
          doBounce = true;
          data.allowMomentumBounce = true;
        } else {
          newPosition = swiper.maxTranslate();
        }

        if (params.loop && params.centeredSlides) needsLoopFix = true;
      } else if (newPosition > swiper.minTranslate()) {
        if (params.freeModeMomentumBounce) {
          if (newPosition - swiper.minTranslate() > bounceAmount) {
            newPosition = swiper.minTranslate() + bounceAmount;
          }

          afterBouncePosition = swiper.minTranslate();
          doBounce = true;
          data.allowMomentumBounce = true;
        } else {
          newPosition = swiper.minTranslate();
        }

        if (params.loop && params.centeredSlides) needsLoopFix = true;
      } else if (params.freeModeSticky) {
        var nextSlide;

        for (var j = 0; j < snapGrid.length; j += 1) {
          if (snapGrid[j] > -newPosition) {
            nextSlide = j;
            break;
          }
        }

        if (Math.abs(snapGrid[nextSlide] - newPosition) < Math.abs(snapGrid[nextSlide - 1] - newPosition) || swiper.swipeDirection === 'next') {
          newPosition = snapGrid[nextSlide];
        } else {
          newPosition = snapGrid[nextSlide - 1];
        }

        newPosition = -newPosition;
      }

      if (needsLoopFix) {
        swiper.once('transitionEnd', function () {
          swiper.loopFix();
        });
      } // Fix duration


      if (swiper.velocity !== 0) {
        if (rtl) {
          momentumDuration = Math.abs((-newPosition - swiper.translate) / swiper.velocity);
        } else {
          momentumDuration = Math.abs((newPosition - swiper.translate) / swiper.velocity);
        }

        if (params.freeModeSticky) {
          // If freeModeSticky is active and the user ends a swipe with a slow-velocity
          // event, then durations can be 20+ seconds to slide one (or zero!) slides.
          // It's easy to see this when simulating touch with mouse events. To fix this,
          // limit single-slide swipes to the default slide duration. This also has the
          // nice side effect of matching slide speed if the user stopped moving before
          // lifting finger or mouse vs. moving slowly before lifting the finger/mouse.
          // For faster swipes, also apply limits (albeit higher ones).
          var moveDistance = Math.abs((rtl ? -newPosition : newPosition) - swiper.translate);
          var currentSlideSize = swiper.slidesSizesGrid[swiper.activeIndex];

          if (moveDistance < currentSlideSize) {
            momentumDuration = params.speed;
          } else if (moveDistance < 2 * currentSlideSize) {
            momentumDuration = params.speed * 1.5;
          } else {
            momentumDuration = params.speed * 2.5;
          }
        }
      } else if (params.freeModeSticky) {
        swiper.slideToClosest();
        return;
      }

      if (params.freeModeMomentumBounce && doBounce) {
        swiper.updateProgress(afterBouncePosition);
        swiper.setTransition(momentumDuration);
        swiper.setTranslate(newPosition);
        swiper.transitionStart(true, swiper.swipeDirection);
        swiper.animating = true;
        $wrapperEl.transitionEnd(function () {
          if (!swiper || swiper.destroyed || !data.allowMomentumBounce) return;
          swiper.emit('momentumBounce');
          swiper.setTransition(params.speed);
          setTimeout(function () {
            swiper.setTranslate(afterBouncePosition);
            $wrapperEl.transitionEnd(function () {
              if (!swiper || swiper.destroyed) return;
              swiper.transitionEnd();
            });
          }, 0);
        });
      } else if (swiper.velocity) {
        swiper.updateProgress(newPosition);
        swiper.setTransition(momentumDuration);
        swiper.setTranslate(newPosition);
        swiper.transitionStart(true, swiper.swipeDirection);

        if (!swiper.animating) {
          swiper.animating = true;
          $wrapperEl.transitionEnd(function () {
            if (!swiper || swiper.destroyed) return;
            swiper.transitionEnd();
          });
        }
      } else {
        swiper.updateProgress(newPosition);
      }

      swiper.updateActiveIndex();
      swiper.updateSlidesClasses();
    } else if (params.freeModeSticky) {
      swiper.slideToClosest();
      return;
    }

    if (!params.freeModeMomentum || timeDiff >= params.longSwipesMs) {
      swiper.updateProgress();
      swiper.updateActiveIndex();
      swiper.updateSlidesClasses();
    }

    return;
  } // Find current slide


  var stopIndex = 0;
  var groupSize = swiper.slidesSizesGrid[0];

  for (var i = 0; i < slidesGrid.length; i += i < params.slidesPerGroupSkip ? 1 : params.slidesPerGroup) {
    var _increment = i < params.slidesPerGroupSkip - 1 ? 1 : params.slidesPerGroup;

    if (typeof slidesGrid[i + _increment] !== 'undefined') {
      if (currentPos >= slidesGrid[i] && currentPos < slidesGrid[i + _increment]) {
        stopIndex = i;
        groupSize = slidesGrid[i + _increment] - slidesGrid[i];
      }
    } else if (currentPos >= slidesGrid[i]) {
      stopIndex = i;
      groupSize = slidesGrid[slidesGrid.length - 1] - slidesGrid[slidesGrid.length - 2];
    }
  } // Find current slide size


  var ratio = (currentPos - slidesGrid[stopIndex]) / groupSize;
  var increment = stopIndex < params.slidesPerGroupSkip - 1 ? 1 : params.slidesPerGroup;

  if (timeDiff > params.longSwipesMs) {
    // Long touches
    if (!params.longSwipes) {
      swiper.slideTo(swiper.activeIndex);
      return;
    }

    if (swiper.swipeDirection === 'next') {
      if (ratio >= params.longSwipesRatio) swiper.slideTo(stopIndex + increment);else swiper.slideTo(stopIndex);
    }

    if (swiper.swipeDirection === 'prev') {
      if (ratio > 1 - params.longSwipesRatio) swiper.slideTo(stopIndex + increment);else swiper.slideTo(stopIndex);
    }
  } else {
    // Short swipes
    if (!params.shortSwipes) {
      swiper.slideTo(swiper.activeIndex);
      return;
    }

    var isNavButtonTarget = swiper.navigation && (e.target === swiper.navigation.nextEl || e.target === swiper.navigation.prevEl);

    if (!isNavButtonTarget) {
      if (swiper.swipeDirection === 'next') {
        swiper.slideTo(stopIndex + increment);
      }

      if (swiper.swipeDirection === 'prev') {
        swiper.slideTo(stopIndex);
      }
    } else if (e.target === swiper.navigation.nextEl) {
      swiper.slideTo(stopIndex + increment);
    } else {
      swiper.slideTo(stopIndex);
    }
  }
}

function onResize() {
  var swiper = this;
  var params = swiper.params,
      el = swiper.el;
  if (el && el.offsetWidth === 0) return; // Breakpoints

  if (params.breakpoints) {
    swiper.setBreakpoint();
  } // Save locks


  var allowSlideNext = swiper.allowSlideNext,
      allowSlidePrev = swiper.allowSlidePrev,
      snapGrid = swiper.snapGrid; // Disable locks on resize

  swiper.allowSlideNext = true;
  swiper.allowSlidePrev = true;
  swiper.updateSize();
  swiper.updateSlides();
  swiper.updateSlidesClasses();

  if ((params.slidesPerView === 'auto' || params.slidesPerView > 1) && swiper.isEnd && !swiper.isBeginning && !swiper.params.centeredSlides) {
    swiper.slideTo(swiper.slides.length - 1, 0, false, true);
  } else {
    swiper.slideTo(swiper.activeIndex, 0, false, true);
  }

  if (swiper.autoplay && swiper.autoplay.running && swiper.autoplay.paused) {
    swiper.autoplay.run();
  } // Return locks after resize


  swiper.allowSlidePrev = allowSlidePrev;
  swiper.allowSlideNext = allowSlideNext;

  if (swiper.params.watchOverflow && snapGrid !== swiper.snapGrid) {
    swiper.checkOverflow();
  }
}

function onClick(e) {
  var swiper = this;

  if (!swiper.allowClick) {
    if (swiper.params.preventClicks) e.preventDefault();

    if (swiper.params.preventClicksPropagation && swiper.animating) {
      e.stopPropagation();
      e.stopImmediatePropagation();
    }
  }
}

function onScroll() {
  var swiper = this;
  var wrapperEl = swiper.wrapperEl,
      rtlTranslate = swiper.rtlTranslate;
  swiper.previousTranslate = swiper.translate;

  if (swiper.isHorizontal()) {
    if (rtlTranslate) {
      swiper.translate = wrapperEl.scrollWidth - wrapperEl.offsetWidth - wrapperEl.scrollLeft;
    } else {
      swiper.translate = -wrapperEl.scrollLeft;
    }
  } else {
    swiper.translate = -wrapperEl.scrollTop;
  } // eslint-disable-next-line


  if (swiper.translate === -0) swiper.translate = 0;
  swiper.updateActiveIndex();
  swiper.updateSlidesClasses();
  var newProgress;
  var translatesDiff = swiper.maxTranslate() - swiper.minTranslate();

  if (translatesDiff === 0) {
    newProgress = 0;
  } else {
    newProgress = (swiper.translate - swiper.minTranslate()) / translatesDiff;
  }

  if (newProgress !== swiper.progress) {
    swiper.updateProgress(rtlTranslate ? -swiper.translate : swiper.translate);
  }

  swiper.emit('setTranslate', swiper.translate, false);
}

var dummyEventAttached = false;

function dummyEventListener() {}

function attachEvents() {
  var swiper = this;
  var params = swiper.params,
      touchEvents = swiper.touchEvents,
      el = swiper.el,
      wrapperEl = swiper.wrapperEl;
  swiper.onTouchStart = onTouchStart.bind(swiper);
  swiper.onTouchMove = onTouchMove.bind(swiper);
  swiper.onTouchEnd = onTouchEnd.bind(swiper);

  if (params.cssMode) {
    swiper.onScroll = onScroll.bind(swiper);
  }

  swiper.onClick = onClick.bind(swiper);
  var capture = !!params.nested; // Touch Events

  if (!Support.touch && Support.pointerEvents) {
    el.addEventListener(touchEvents.start, swiper.onTouchStart, false);
    ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener(touchEvents.move, swiper.onTouchMove, capture);
    ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener(touchEvents.end, swiper.onTouchEnd, false);
  } else {
    if (Support.touch) {
      var passiveListener = touchEvents.start === 'touchstart' && Support.passiveListener && params.passiveListeners ? {
        passive: true,
        capture: false
      } : false;
      el.addEventListener(touchEvents.start, swiper.onTouchStart, passiveListener);
      el.addEventListener(touchEvents.move, swiper.onTouchMove, Support.passiveListener ? {
        passive: false,
        capture: capture
      } : capture);
      el.addEventListener(touchEvents.end, swiper.onTouchEnd, passiveListener);

      if (touchEvents.cancel) {
        el.addEventListener(touchEvents.cancel, swiper.onTouchEnd, passiveListener);
      }

      if (!dummyEventAttached) {
        ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener('touchstart', dummyEventListener);
        dummyEventAttached = true;
      }
    }

    if (params.simulateTouch && !Device.ios && !Device.android || params.simulateTouch && !Support.touch && Device.ios) {
      el.addEventListener('mousedown', swiper.onTouchStart, false);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener('mousemove', swiper.onTouchMove, capture);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener('mouseup', swiper.onTouchEnd, false);
    }
  } // Prevent Links Clicks


  if (params.preventClicks || params.preventClicksPropagation) {
    el.addEventListener('click', swiper.onClick, true);
  }

  if (params.cssMode) {
    wrapperEl.addEventListener('scroll', swiper.onScroll);
  } // Resize handler


  if (params.updateOnWindowResize) {
    swiper.on(Device.ios || Device.android ? 'resize orientationchange observerUpdate' : 'resize observerUpdate', onResize, true);
  } else {
    swiper.on('observerUpdate', onResize, true);
  }
}

function detachEvents() {
  var swiper = this;
  var params = swiper.params,
      touchEvents = swiper.touchEvents,
      el = swiper.el,
      wrapperEl = swiper.wrapperEl;
  var capture = !!params.nested; // Touch Events

  if (!Support.touch && Support.pointerEvents) {
    el.removeEventListener(touchEvents.start, swiper.onTouchStart, false);
    ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].removeEventListener(touchEvents.move, swiper.onTouchMove, capture);
    ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].removeEventListener(touchEvents.end, swiper.onTouchEnd, false);
  } else {
    if (Support.touch) {
      var passiveListener = touchEvents.start === 'onTouchStart' && Support.passiveListener && params.passiveListeners ? {
        passive: true,
        capture: false
      } : false;
      el.removeEventListener(touchEvents.start, swiper.onTouchStart, passiveListener);
      el.removeEventListener(touchEvents.move, swiper.onTouchMove, capture);
      el.removeEventListener(touchEvents.end, swiper.onTouchEnd, passiveListener);

      if (touchEvents.cancel) {
        el.removeEventListener(touchEvents.cancel, swiper.onTouchEnd, passiveListener);
      }
    }

    if (params.simulateTouch && !Device.ios && !Device.android || params.simulateTouch && !Support.touch && Device.ios) {
      el.removeEventListener('mousedown', swiper.onTouchStart, false);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].removeEventListener('mousemove', swiper.onTouchMove, capture);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].removeEventListener('mouseup', swiper.onTouchEnd, false);
    }
  } // Prevent Links Clicks


  if (params.preventClicks || params.preventClicksPropagation) {
    el.removeEventListener('click', swiper.onClick, true);
  }

  if (params.cssMode) {
    wrapperEl.removeEventListener('scroll', swiper.onScroll);
  } // Resize handler


  swiper.off(Device.ios || Device.android ? 'resize orientationchange observerUpdate' : 'resize observerUpdate', onResize);
}

var events = {
  attachEvents: attachEvents,
  detachEvents: detachEvents
};

function setBreakpoint() {
  var swiper = this;
  var activeIndex = swiper.activeIndex,
      initialized = swiper.initialized,
      _swiper$loopedSlides = swiper.loopedSlides,
      loopedSlides = _swiper$loopedSlides === void 0 ? 0 : _swiper$loopedSlides,
      params = swiper.params,
      $el = swiper.$el;
  var breakpoints = params.breakpoints;
  if (!breakpoints || breakpoints && Object.keys(breakpoints).length === 0) return; // Get breakpoint for window width and update parameters

  var breakpoint = swiper.getBreakpoint(breakpoints);

  if (breakpoint && swiper.currentBreakpoint !== breakpoint) {
    var breakpointOnlyParams = breakpoint in breakpoints ? breakpoints[breakpoint] : undefined;

    if (breakpointOnlyParams) {
      ['slidesPerView', 'spaceBetween', 'slidesPerGroup', 'slidesPerGroupSkip', 'slidesPerColumn'].forEach(function (param) {
        var paramValue = breakpointOnlyParams[param];
        if (typeof paramValue === 'undefined') return;

        if (param === 'slidesPerView' && (paramValue === 'AUTO' || paramValue === 'auto')) {
          breakpointOnlyParams[param] = 'auto';
        } else if (param === 'slidesPerView') {
          breakpointOnlyParams[param] = parseFloat(paramValue);
        } else {
          breakpointOnlyParams[param] = parseInt(paramValue, 10);
        }
      });
    }

    var breakpointParams = breakpointOnlyParams || swiper.originalParams;
    var wasMultiRow = params.slidesPerColumn > 1;
    var isMultiRow = breakpointParams.slidesPerColumn > 1;

    if (wasMultiRow && !isMultiRow) {
      $el.removeClass("".concat(params.containerModifierClass, "multirow ").concat(params.containerModifierClass, "multirow-column"));
    } else if (!wasMultiRow && isMultiRow) {
      $el.addClass("".concat(params.containerModifierClass, "multirow"));

      if (breakpointParams.slidesPerColumnFill === 'column') {
        $el.addClass("".concat(params.containerModifierClass, "multirow-column"));
      }
    }

    var directionChanged = breakpointParams.direction && breakpointParams.direction !== params.direction;
    var needsReLoop = params.loop && (breakpointParams.slidesPerView !== params.slidesPerView || directionChanged);

    if (directionChanged && initialized) {
      swiper.changeDirection();
    }

    Utils.extend(swiper.params, breakpointParams);
    Utils.extend(swiper, {
      allowTouchMove: swiper.params.allowTouchMove,
      allowSlideNext: swiper.params.allowSlideNext,
      allowSlidePrev: swiper.params.allowSlidePrev
    });
    swiper.currentBreakpoint = breakpoint;

    if (needsReLoop && initialized) {
      swiper.loopDestroy();
      swiper.loopCreate();
      swiper.updateSlides();
      swiper.slideTo(activeIndex - loopedSlides + swiper.loopedSlides, 0, false);
    }

    swiper.emit('breakpoint', breakpointParams);
  }
}

function getBreakpoint(breakpoints) {
  // Get breakpoint for window width
  if (!breakpoints) return undefined;
  var breakpoint = false;
  var points = Object.keys(breakpoints).map(function (point) {
    if (typeof point === 'string' && point.indexOf('@') === 0) {
      var minRatio = parseFloat(point.substr(1));
      var value = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].innerHeight * minRatio;
      return {
        value: value,
        point: point
      };
    }

    return {
      value: point,
      point: point
    };
  });
  points.sort(function (a, b) {
    return parseInt(a.value, 10) - parseInt(b.value, 10);
  });

  for (var i = 0; i < points.length; i += 1) {
    var _points$i = points[i],
        point = _points$i.point,
        value = _points$i.value;

    if (value <= ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].innerWidth) {
      breakpoint = point;
    }
  }

  return breakpoint || 'max';
}

var breakpoints = {
  setBreakpoint: setBreakpoint,
  getBreakpoint: getBreakpoint
};

function addClasses() {
  var swiper = this;
  var classNames = swiper.classNames,
      params = swiper.params,
      rtl = swiper.rtl,
      $el = swiper.$el;
  var suffixes = [];
  suffixes.push('initialized');
  suffixes.push(params.direction);

  if (params.freeMode) {
    suffixes.push('free-mode');
  }

  if (params.autoHeight) {
    suffixes.push('autoheight');
  }

  if (rtl) {
    suffixes.push('rtl');
  }

  if (params.slidesPerColumn > 1) {
    suffixes.push('multirow');

    if (params.slidesPerColumnFill === 'column') {
      suffixes.push('multirow-column');
    }
  }

  if (Device.android) {
    suffixes.push('android');
  }

  if (Device.ios) {
    suffixes.push('ios');
  }

  if (params.cssMode) {
    suffixes.push('css-mode');
  }

  suffixes.forEach(function (suffix) {
    classNames.push(params.containerModifierClass + suffix);
  });
  $el.addClass(classNames.join(' '));
}

function removeClasses() {
  var swiper = this;
  var $el = swiper.$el,
      classNames = swiper.classNames;
  $el.removeClass(classNames.join(' '));
}

var classes = {
  addClasses: addClasses,
  removeClasses: removeClasses
};

function loadImage(imageEl, src, srcset, sizes, checkForComplete, callback) {
  var image;

  function onReady() {
    if (callback) callback();
  }

  var isPicture = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(imageEl).parent('picture')[0];

  if (!isPicture && (!imageEl.complete || !checkForComplete)) {
    if (src) {
      image = new ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].Image();
      image.onload = onReady;
      image.onerror = onReady;

      if (sizes) {
        image.sizes = sizes;
      }

      if (srcset) {
        image.srcset = srcset;
      }

      if (src) {
        image.src = src;
      }
    } else {
      onReady();
    }
  } else {
    // image already loaded...
    onReady();
  }
}

function preloadImages() {
  var swiper = this;
  swiper.imagesToLoad = swiper.$el.find('img');

  function onReady() {
    if (typeof swiper === 'undefined' || swiper === null || !swiper || swiper.destroyed) return;
    if (swiper.imagesLoaded !== undefined) swiper.imagesLoaded += 1;

    if (swiper.imagesLoaded === swiper.imagesToLoad.length) {
      if (swiper.params.updateOnImagesReady) swiper.update();
      swiper.emit('imagesReady');
    }
  }

  for (var i = 0; i < swiper.imagesToLoad.length; i += 1) {
    var imageEl = swiper.imagesToLoad[i];
    swiper.loadImage(imageEl, imageEl.currentSrc || imageEl.getAttribute('src'), imageEl.srcset || imageEl.getAttribute('srcset'), imageEl.sizes || imageEl.getAttribute('sizes'), true, onReady);
  }
}

var images = {
  loadImage: loadImage,
  preloadImages: preloadImages
};

function checkOverflow() {
  var swiper = this;
  var params = swiper.params;
  var wasLocked = swiper.isLocked;
  var lastSlidePosition = swiper.slides.length > 0 && params.slidesOffsetBefore + params.spaceBetween * (swiper.slides.length - 1) + swiper.slides[0].offsetWidth * swiper.slides.length;

  if (params.slidesOffsetBefore && params.slidesOffsetAfter && lastSlidePosition) {
    swiper.isLocked = lastSlidePosition <= swiper.size;
  } else {
    swiper.isLocked = swiper.snapGrid.length === 1;
  }

  swiper.allowSlideNext = !swiper.isLocked;
  swiper.allowSlidePrev = !swiper.isLocked; // events

  if (wasLocked !== swiper.isLocked) swiper.emit(swiper.isLocked ? 'lock' : 'unlock');

  if (wasLocked && wasLocked !== swiper.isLocked) {
    swiper.isEnd = false;
    if (swiper.navigation) swiper.navigation.update();
  }
}

var checkOverflow$1 = {
  checkOverflow: checkOverflow
};
var defaults = {
  init: true,
  direction: 'horizontal',
  touchEventsTarget: 'container',
  initialSlide: 0,
  speed: 300,
  cssMode: false,
  updateOnWindowResize: true,
  //
  preventInteractionOnTransition: false,
  // To support iOS's swipe-to-go-back gesture (when being used in-app).
  edgeSwipeDetection: false,
  edgeSwipeThreshold: 20,
  // Free mode
  freeMode: false,
  freeModeMomentum: true,
  freeModeMomentumRatio: 1,
  freeModeMomentumBounce: true,
  freeModeMomentumBounceRatio: 1,
  freeModeMomentumVelocityRatio: 1,
  freeModeSticky: false,
  freeModeMinimumVelocity: 0.02,
  // Autoheight
  autoHeight: false,
  // Set wrapper width
  setWrapperSize: false,
  // Virtual Translate
  virtualTranslate: false,
  // Effects
  effect: 'slide',
  // 'slide' or 'fade' or 'cube' or 'coverflow' or 'flip'
  // Breakpoints
  breakpoints: undefined,
  // Slides grid
  spaceBetween: 0,
  slidesPerView: 1,
  slidesPerColumn: 1,
  slidesPerColumnFill: 'column',
  slidesPerGroup: 1,
  slidesPerGroupSkip: 0,
  centeredSlides: false,
  centeredSlidesBounds: false,
  slidesOffsetBefore: 0,
  // in px
  slidesOffsetAfter: 0,
  // in px
  normalizeSlideIndex: true,
  centerInsufficientSlides: false,
  // Disable swiper and hide navigation when container not overflow
  watchOverflow: false,
  // Round length
  roundLengths: false,
  // Touches
  touchRatio: 1,
  touchAngle: 45,
  simulateTouch: true,
  shortSwipes: true,
  longSwipes: true,
  longSwipesRatio: 0.5,
  longSwipesMs: 300,
  followFinger: true,
  allowTouchMove: true,
  threshold: 0,
  touchMoveStopPropagation: false,
  touchStartPreventDefault: true,
  touchStartForcePreventDefault: false,
  touchReleaseOnEdges: false,
  // Unique Navigation Elements
  uniqueNavElements: true,
  // Resistance
  resistance: true,
  resistanceRatio: 0.85,
  // Progress
  watchSlidesProgress: false,
  watchSlidesVisibility: false,
  // Cursor
  grabCursor: false,
  // Clicks
  preventClicks: true,
  preventClicksPropagation: true,
  slideToClickedSlide: false,
  // Images
  preloadImages: true,
  updateOnImagesReady: true,
  // loop
  loop: false,
  loopAdditionalSlides: 0,
  loopedSlides: null,
  loopFillGroupWithBlank: false,
  // Swiping/no swiping
  allowSlidePrev: true,
  allowSlideNext: true,
  swipeHandler: null,
  // '.swipe-handler',
  noSwiping: true,
  noSwipingClass: 'swiper-no-swiping',
  noSwipingSelector: null,
  // Passive Listeners
  passiveListeners: true,
  // NS
  containerModifierClass: 'swiper-container-',
  // NEW
  slideClass: 'swiper-slide',
  slideBlankClass: 'swiper-slide-invisible-blank',
  slideActiveClass: 'swiper-slide-active',
  slideDuplicateActiveClass: 'swiper-slide-duplicate-active',
  slideVisibleClass: 'swiper-slide-visible',
  slideDuplicateClass: 'swiper-slide-duplicate',
  slideNextClass: 'swiper-slide-next',
  slideDuplicateNextClass: 'swiper-slide-duplicate-next',
  slidePrevClass: 'swiper-slide-prev',
  slideDuplicatePrevClass: 'swiper-slide-duplicate-prev',
  wrapperClass: 'swiper-wrapper',
  // Callbacks
  runCallbacksOnInit: true
};
/* eslint no-param-reassign: "off" */

var prototypes = {
  update: update,
  translate: translate,
  transition: transition,
  slide: slide,
  loop: loop,
  grabCursor: grabCursor,
  manipulation: manipulation,
  events: events,
  breakpoints: breakpoints,
  checkOverflow: checkOverflow$1,
  classes: classes,
  images: images
};
var extendedDefaults = {};

var Swiper = /*#__PURE__*/function (_SwiperClass) {
  _inherits(Swiper, _SwiperClass);

  var _super = _createSuper(Swiper);

  function Swiper() {
    var _this;

    _classCallCheck(this, Swiper);

    var el;
    var params;

    for (var _len5 = arguments.length, args = new Array(_len5), _key5 = 0; _key5 < _len5; _key5++) {
      args[_key5] = arguments[_key5];
    }

    if (args.length === 1 && args[0].constructor && args[0].constructor === Object) {
      params = args[0];
    } else {
      el = args[0];
      params = args[1];
    }

    if (!params) params = {};
    params = Utils.extend({}, params);
    if (el && !params.el) params.el = el;
    _this = _super.call(this, params);
    Object.keys(prototypes).forEach(function (prototypeGroup) {
      Object.keys(prototypes[prototypeGroup]).forEach(function (protoMethod) {
        if (!Swiper.prototype[protoMethod]) {
          Swiper.prototype[protoMethod] = prototypes[prototypeGroup][protoMethod];
        }
      });
    }); // Swiper Instance

    var swiper = _assertThisInitialized(_this);

    if (typeof swiper.modules === 'undefined') {
      swiper.modules = {};
    }

    Object.keys(swiper.modules).forEach(function (moduleName) {
      var module = swiper.modules[moduleName];

      if (module.params) {
        var moduleParamName = Object.keys(module.params)[0];
        var moduleParams = module.params[moduleParamName];
        if (_typeof(moduleParams) !== 'object' || moduleParams === null) return;
        if (!(moduleParamName in params && 'enabled' in moduleParams)) return;

        if (params[moduleParamName] === true) {
          params[moduleParamName] = {
            enabled: true
          };
        }

        if (_typeof(params[moduleParamName]) === 'object' && !('enabled' in params[moduleParamName])) {
          params[moduleParamName].enabled = true;
        }

        if (!params[moduleParamName]) params[moduleParamName] = {
          enabled: false
        };
      }
    }); // Extend defaults with modules params

    var swiperParams = Utils.extend({}, defaults);
    swiper.useModulesParams(swiperParams); // Extend defaults with passed params

    swiper.params = Utils.extend({}, swiperParams, extendedDefaults, params);
    swiper.originalParams = Utils.extend({}, swiper.params);
    swiper.passedParams = Utils.extend({}, params); // Save Dom lib

    swiper.$ = dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"]; // Find el

    var $el = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(swiper.params.el);
    el = $el[0];

    if (!el) {
      return _possibleConstructorReturn(_this, undefined);
    }

    if ($el.length > 1) {
      var swipers = [];
      $el.each(function (index, containerEl) {
        var newParams = Utils.extend({}, params, {
          el: containerEl
        });
        swipers.push(new Swiper(newParams));
      });
      return _possibleConstructorReturn(_this, swipers);
    }

    el.swiper = swiper;
    $el.data('swiper', swiper); // Find Wrapper

    var $wrapperEl;

    if (el && el.shadowRoot && el.shadowRoot.querySelector) {
      $wrapperEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(el.shadowRoot.querySelector(".".concat(swiper.params.wrapperClass))); // Children needs to return slot items

      $wrapperEl.children = function (options) {
        return $el.children(options);
      };
    } else {
      $wrapperEl = $el.children(".".concat(swiper.params.wrapperClass));
    } // Extend Swiper


    Utils.extend(swiper, {
      $el: $el,
      el: el,
      $wrapperEl: $wrapperEl,
      wrapperEl: $wrapperEl[0],
      // Classes
      classNames: [],
      // Slides
      slides: Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(),
      slidesGrid: [],
      snapGrid: [],
      slidesSizesGrid: [],
      // isDirection
      isHorizontal: function isHorizontal() {
        return swiper.params.direction === 'horizontal';
      },
      isVertical: function isVertical() {
        return swiper.params.direction === 'vertical';
      },
      // RTL
      rtl: el.dir.toLowerCase() === 'rtl' || $el.css('direction') === 'rtl',
      rtlTranslate: swiper.params.direction === 'horizontal' && (el.dir.toLowerCase() === 'rtl' || $el.css('direction') === 'rtl'),
      wrongRTL: $wrapperEl.css('display') === '-webkit-box',
      // Indexes
      activeIndex: 0,
      realIndex: 0,
      //
      isBeginning: true,
      isEnd: false,
      // Props
      translate: 0,
      previousTranslate: 0,
      progress: 0,
      velocity: 0,
      animating: false,
      // Locks
      allowSlideNext: swiper.params.allowSlideNext,
      allowSlidePrev: swiper.params.allowSlidePrev,
      // Touch Events
      touchEvents: function touchEvents() {
        var touch = ['touchstart', 'touchmove', 'touchend', 'touchcancel'];
        var desktop = ['mousedown', 'mousemove', 'mouseup'];

        if (Support.pointerEvents) {
          desktop = ['pointerdown', 'pointermove', 'pointerup'];
        }

        swiper.touchEventsTouch = {
          start: touch[0],
          move: touch[1],
          end: touch[2],
          cancel: touch[3]
        };
        swiper.touchEventsDesktop = {
          start: desktop[0],
          move: desktop[1],
          end: desktop[2]
        };
        return Support.touch || !swiper.params.simulateTouch ? swiper.touchEventsTouch : swiper.touchEventsDesktop;
      }(),
      touchEventsData: {
        isTouched: undefined,
        isMoved: undefined,
        allowTouchCallbacks: undefined,
        touchStartTime: undefined,
        isScrolling: undefined,
        currentTranslate: undefined,
        startTranslate: undefined,
        allowThresholdMove: undefined,
        // Form elements to match
        formElements: 'input, select, option, textarea, button, video, label',
        // Last click time
        lastClickTime: Utils.now(),
        clickTimeout: undefined,
        // Velocities
        velocities: [],
        allowMomentumBounce: undefined,
        isTouchEvent: undefined,
        startMoving: undefined
      },
      // Clicks
      allowClick: true,
      // Touches
      allowTouchMove: swiper.params.allowTouchMove,
      touches: {
        startX: 0,
        startY: 0,
        currentX: 0,
        currentY: 0,
        diff: 0
      },
      // Images
      imagesToLoad: [],
      imagesLoaded: 0
    }); // Install Modules

    swiper.useModules(); // Init

    if (swiper.params.init) {
      swiper.init();
    } // Return app instance


    return _possibleConstructorReturn(_this, swiper);
  }

  _createClass(Swiper, [{
    key: "slidesPerViewDynamic",
    value: function slidesPerViewDynamic() {
      var swiper = this;
      var params = swiper.params,
          slides = swiper.slides,
          slidesGrid = swiper.slidesGrid,
          swiperSize = swiper.size,
          activeIndex = swiper.activeIndex;
      var spv = 1;

      if (params.centeredSlides) {
        var slideSize = slides[activeIndex].swiperSlideSize;
        var breakLoop;

        for (var i = activeIndex + 1; i < slides.length; i += 1) {
          if (slides[i] && !breakLoop) {
            slideSize += slides[i].swiperSlideSize;
            spv += 1;
            if (slideSize > swiperSize) breakLoop = true;
          }
        }

        for (var _i7 = activeIndex - 1; _i7 >= 0; _i7 -= 1) {
          if (slides[_i7] && !breakLoop) {
            slideSize += slides[_i7].swiperSlideSize;
            spv += 1;
            if (slideSize > swiperSize) breakLoop = true;
          }
        }
      } else {
        for (var _i8 = activeIndex + 1; _i8 < slides.length; _i8 += 1) {
          if (slidesGrid[_i8] - slidesGrid[activeIndex] < swiperSize) {
            spv += 1;
          }
        }
      }

      return spv;
    }
  }, {
    key: "update",
    value: function update() {
      var swiper = this;
      if (!swiper || swiper.destroyed) return;
      var snapGrid = swiper.snapGrid,
          params = swiper.params; // Breakpoints

      if (params.breakpoints) {
        swiper.setBreakpoint();
      }

      swiper.updateSize();
      swiper.updateSlides();
      swiper.updateProgress();
      swiper.updateSlidesClasses();

      function setTranslate() {
        var translateValue = swiper.rtlTranslate ? swiper.translate * -1 : swiper.translate;
        var newTranslate = Math.min(Math.max(translateValue, swiper.maxTranslate()), swiper.minTranslate());
        swiper.setTranslate(newTranslate);
        swiper.updateActiveIndex();
        swiper.updateSlidesClasses();
      }

      var translated;

      if (swiper.params.freeMode) {
        setTranslate();

        if (swiper.params.autoHeight) {
          swiper.updateAutoHeight();
        }
      } else {
        if ((swiper.params.slidesPerView === 'auto' || swiper.params.slidesPerView > 1) && swiper.isEnd && !swiper.params.centeredSlides) {
          translated = swiper.slideTo(swiper.slides.length - 1, 0, false, true);
        } else {
          translated = swiper.slideTo(swiper.activeIndex, 0, false, true);
        }

        if (!translated) {
          setTranslate();
        }
      }

      if (params.watchOverflow && snapGrid !== swiper.snapGrid) {
        swiper.checkOverflow();
      }

      swiper.emit('update');
    }
  }, {
    key: "changeDirection",
    value: function changeDirection(newDirection) {
      var needUpdate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
      var swiper = this;
      var currentDirection = swiper.params.direction;

      if (!newDirection) {
        // eslint-disable-next-line
        newDirection = currentDirection === 'horizontal' ? 'vertical' : 'horizontal';
      }

      if (newDirection === currentDirection || newDirection !== 'horizontal' && newDirection !== 'vertical') {
        return swiper;
      }

      swiper.$el.removeClass("".concat(swiper.params.containerModifierClass).concat(currentDirection)).addClass("".concat(swiper.params.containerModifierClass).concat(newDirection));
      swiper.params.direction = newDirection;
      swiper.slides.each(function (slideIndex, slideEl) {
        if (newDirection === 'vertical') {
          slideEl.style.width = '';
        } else {
          slideEl.style.height = '';
        }
      });
      swiper.emit('changeDirection');
      if (needUpdate) swiper.update();
      return swiper;
    }
  }, {
    key: "init",
    value: function init() {
      var swiper = this;
      if (swiper.initialized) return;
      swiper.emit('beforeInit'); // Set breakpoint

      if (swiper.params.breakpoints) {
        swiper.setBreakpoint();
      } // Add Classes


      swiper.addClasses(); // Create loop

      if (swiper.params.loop) {
        swiper.loopCreate();
      } // Update size


      swiper.updateSize(); // Update slides

      swiper.updateSlides();

      if (swiper.params.watchOverflow) {
        swiper.checkOverflow();
      } // Set Grab Cursor


      if (swiper.params.grabCursor) {
        swiper.setGrabCursor();
      }

      if (swiper.params.preloadImages) {
        swiper.preloadImages();
      } // Slide To Initial Slide


      if (swiper.params.loop) {
        swiper.slideTo(swiper.params.initialSlide + swiper.loopedSlides, 0, swiper.params.runCallbacksOnInit);
      } else {
        swiper.slideTo(swiper.params.initialSlide, 0, swiper.params.runCallbacksOnInit);
      } // Attach events


      swiper.attachEvents(); // Init Flag

      swiper.initialized = true; // Emit

      swiper.emit('init');
    }
  }, {
    key: "destroy",
    value: function destroy() {
      var deleteInstance = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : true;
      var cleanStyles = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
      var swiper = this;
      var params = swiper.params,
          $el = swiper.$el,
          $wrapperEl = swiper.$wrapperEl,
          slides = swiper.slides;

      if (typeof swiper.params === 'undefined' || swiper.destroyed) {
        return null;
      }

      swiper.emit('beforeDestroy'); // Init Flag

      swiper.initialized = false; // Detach events

      swiper.detachEvents(); // Destroy loop

      if (params.loop) {
        swiper.loopDestroy();
      } // Cleanup styles


      if (cleanStyles) {
        swiper.removeClasses();
        $el.removeAttr('style');
        $wrapperEl.removeAttr('style');

        if (slides && slides.length) {
          slides.removeClass([params.slideVisibleClass, params.slideActiveClass, params.slideNextClass, params.slidePrevClass].join(' ')).removeAttr('style').removeAttr('data-swiper-slide-index');
        }
      }

      swiper.emit('destroy'); // Detach emitter events

      Object.keys(swiper.eventsListeners).forEach(function (eventName) {
        swiper.off(eventName);
      });

      if (deleteInstance !== false) {
        swiper.$el[0].swiper = null;
        swiper.$el.data('swiper', null);
        Utils.deleteProps(swiper);
      }

      swiper.destroyed = true;
      return null;
    }
  }], [{
    key: "extendDefaults",
    value: function extendDefaults(newDefaults) {
      Utils.extend(extendedDefaults, newDefaults);
    }
  }, {
    key: "extendedDefaults",
    get: function get() {
      return extendedDefaults;
    }
  }, {
    key: "defaults",
    get: function get() {
      return defaults;
    }
  }, {
    key: "Class",
    get: function get() {
      return SwiperClass;
    }
  }, {
    key: "$",
    get: function get() {
      return dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"];
    }
  }]);

  return Swiper;
}(SwiperClass);

var Device$1 = {
  name: 'device',
  proto: {
    device: Device
  },
  "static": {
    device: Device
  }
};
var Support$1 = {
  name: 'support',
  proto: {
    support: Support
  },
  "static": {
    support: Support
  }
};

var Browser = function Browser() {
  function isSafari() {
    var ua = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.userAgent.toLowerCase();
    return ua.indexOf('safari') >= 0 && ua.indexOf('chrome') < 0 && ua.indexOf('android') < 0;
  }

  return {
    isEdge: !!ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.userAgent.match(/Edge/g),
    isSafari: isSafari(),
    isWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.userAgent)
  };
}();

var Browser$1 = {
  name: 'browser',
  proto: {
    browser: Browser
  },
  "static": {
    browser: Browser
  }
};
var Resize = {
  name: 'resize',
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      resize: {
        resizeHandler: function resizeHandler() {
          if (!swiper || swiper.destroyed || !swiper.initialized) return;
          swiper.emit('beforeResize');
          swiper.emit('resize');
        },
        orientationChangeHandler: function orientationChangeHandler() {
          if (!swiper || swiper.destroyed || !swiper.initialized) return;
          swiper.emit('orientationchange');
        }
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this; // Emit resize

      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].addEventListener('resize', swiper.resize.resizeHandler); // Emit orientationchange

      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].addEventListener('orientationchange', swiper.resize.orientationChangeHandler);
    },
    destroy: function destroy() {
      var swiper = this;
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].removeEventListener('resize', swiper.resize.resizeHandler);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].removeEventListener('orientationchange', swiper.resize.orientationChangeHandler);
    }
  }
};
var Observer = {
  func: ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].MutationObserver || ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].WebkitMutationObserver,
  attach: function attach(target) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var swiper = this;
    var ObserverFunc = Observer.func;
    var observer = new ObserverFunc(function (mutations) {
      // The observerUpdate event should only be triggered
      // once despite the number of mutations.  Additional
      // triggers are redundant and are very costly
      if (mutations.length === 1) {
        swiper.emit('observerUpdate', mutations[0]);
        return;
      }

      var observerUpdate = function observerUpdate() {
        swiper.emit('observerUpdate', mutations[0]);
      };

      if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].requestAnimationFrame) {
        ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].requestAnimationFrame(observerUpdate);
      } else {
        ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].setTimeout(observerUpdate, 0);
      }
    });
    observer.observe(target, {
      attributes: typeof options.attributes === 'undefined' ? true : options.attributes,
      childList: typeof options.childList === 'undefined' ? true : options.childList,
      characterData: typeof options.characterData === 'undefined' ? true : options.characterData
    });
    swiper.observer.observers.push(observer);
  },
  init: function init() {
    var swiper = this;
    if (!Support.observer || !swiper.params.observer) return;

    if (swiper.params.observeParents) {
      var containerParents = swiper.$el.parents();

      for (var i = 0; i < containerParents.length; i += 1) {
        swiper.observer.attach(containerParents[i]);
      }
    } // Observe container


    swiper.observer.attach(swiper.$el[0], {
      childList: swiper.params.observeSlideChildren
    }); // Observe wrapper

    swiper.observer.attach(swiper.$wrapperEl[0], {
      attributes: false
    });
  },
  destroy: function destroy() {
    var swiper = this;
    swiper.observer.observers.forEach(function (observer) {
      observer.disconnect();
    });
    swiper.observer.observers = [];
  }
};
var Observer$1 = {
  name: 'observer',
  params: {
    observer: false,
    observeParents: false,
    observeSlideChildren: false
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      observer: {
        init: Observer.init.bind(swiper),
        attach: Observer.attach.bind(swiper),
        destroy: Observer.destroy.bind(swiper),
        observers: []
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;
      swiper.observer.init();
    },
    destroy: function destroy() {
      var swiper = this;
      swiper.observer.destroy();
    }
  }
};
var Virtual = {
  update: function update(force) {
    var swiper = this;
    var _swiper$params = swiper.params,
        slidesPerView = _swiper$params.slidesPerView,
        slidesPerGroup = _swiper$params.slidesPerGroup,
        centeredSlides = _swiper$params.centeredSlides;
    var _swiper$params$virtua = swiper.params.virtual,
        addSlidesBefore = _swiper$params$virtua.addSlidesBefore,
        addSlidesAfter = _swiper$params$virtua.addSlidesAfter;
    var _swiper$virtual = swiper.virtual,
        previousFrom = _swiper$virtual.from,
        previousTo = _swiper$virtual.to,
        slides = _swiper$virtual.slides,
        previousSlidesGrid = _swiper$virtual.slidesGrid,
        renderSlide = _swiper$virtual.renderSlide,
        previousOffset = _swiper$virtual.offset;
    swiper.updateActiveIndex();
    var activeIndex = swiper.activeIndex || 0;
    var offsetProp;
    if (swiper.rtlTranslate) offsetProp = 'right';else offsetProp = swiper.isHorizontal() ? 'left' : 'top';
    var slidesAfter;
    var slidesBefore;

    if (centeredSlides) {
      slidesAfter = Math.floor(slidesPerView / 2) + slidesPerGroup + addSlidesBefore;
      slidesBefore = Math.floor(slidesPerView / 2) + slidesPerGroup + addSlidesAfter;
    } else {
      slidesAfter = slidesPerView + (slidesPerGroup - 1) + addSlidesBefore;
      slidesBefore = slidesPerGroup + addSlidesAfter;
    }

    var from = Math.max((activeIndex || 0) - slidesBefore, 0);
    var to = Math.min((activeIndex || 0) + slidesAfter, slides.length - 1);
    var offset = (swiper.slidesGrid[from] || 0) - (swiper.slidesGrid[0] || 0);
    Utils.extend(swiper.virtual, {
      from: from,
      to: to,
      offset: offset,
      slidesGrid: swiper.slidesGrid
    });

    function onRendered() {
      swiper.updateSlides();
      swiper.updateProgress();
      swiper.updateSlidesClasses();

      if (swiper.lazy && swiper.params.lazy.enabled) {
        swiper.lazy.load();
      }
    }

    if (previousFrom === from && previousTo === to && !force) {
      if (swiper.slidesGrid !== previousSlidesGrid && offset !== previousOffset) {
        swiper.slides.css(offsetProp, "".concat(offset, "px"));
      }

      swiper.updateProgress();
      return;
    }

    if (swiper.params.virtual.renderExternal) {
      swiper.params.virtual.renderExternal.call(swiper, {
        offset: offset,
        from: from,
        to: to,
        slides: function getSlides() {
          var slidesToRender = [];

          for (var i = from; i <= to; i += 1) {
            slidesToRender.push(slides[i]);
          }

          return slidesToRender;
        }()
      });
      onRendered();
      return;
    }

    var prependIndexes = [];
    var appendIndexes = [];

    if (force) {
      swiper.$wrapperEl.find(".".concat(swiper.params.slideClass)).remove();
    } else {
      for (var i = previousFrom; i <= previousTo; i += 1) {
        if (i < from || i > to) {
          swiper.$wrapperEl.find(".".concat(swiper.params.slideClass, "[data-swiper-slide-index=\"").concat(i, "\"]")).remove();
        }
      }
    }

    for (var _i9 = 0; _i9 < slides.length; _i9 += 1) {
      if (_i9 >= from && _i9 <= to) {
        if (typeof previousTo === 'undefined' || force) {
          appendIndexes.push(_i9);
        } else {
          if (_i9 > previousTo) appendIndexes.push(_i9);
          if (_i9 < previousFrom) prependIndexes.push(_i9);
        }
      }
    }

    appendIndexes.forEach(function (index) {
      swiper.$wrapperEl.append(renderSlide(slides[index], index));
    });
    prependIndexes.sort(function (a, b) {
      return b - a;
    }).forEach(function (index) {
      swiper.$wrapperEl.prepend(renderSlide(slides[index], index));
    });
    swiper.$wrapperEl.children('.swiper-slide').css(offsetProp, "".concat(offset, "px"));
    onRendered();
  },
  renderSlide: function renderSlide(slide, index) {
    var swiper = this;
    var params = swiper.params.virtual;

    if (params.cache && swiper.virtual.cache[index]) {
      return swiper.virtual.cache[index];
    }

    var $slideEl = params.renderSlide ? Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(params.renderSlide.call(swiper, slide, index)) : Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"".concat(swiper.params.slideClass, "\" data-swiper-slide-index=\"").concat(index, "\">").concat(slide, "</div>"));
    if (!$slideEl.attr('data-swiper-slide-index')) $slideEl.attr('data-swiper-slide-index', index);
    if (params.cache) swiper.virtual.cache[index] = $slideEl;
    return $slideEl;
  },
  appendSlide: function appendSlide(slides) {
    var swiper = this;

    if (_typeof(slides) === 'object' && 'length' in slides) {
      for (var i = 0; i < slides.length; i += 1) {
        if (slides[i]) swiper.virtual.slides.push(slides[i]);
      }
    } else {
      swiper.virtual.slides.push(slides);
    }

    swiper.virtual.update(true);
  },
  prependSlide: function prependSlide(slides) {
    var swiper = this;
    var activeIndex = swiper.activeIndex;
    var newActiveIndex = activeIndex + 1;
    var numberOfNewSlides = 1;

    if (Array.isArray(slides)) {
      for (var i = 0; i < slides.length; i += 1) {
        if (slides[i]) swiper.virtual.slides.unshift(slides[i]);
      }

      newActiveIndex = activeIndex + slides.length;
      numberOfNewSlides = slides.length;
    } else {
      swiper.virtual.slides.unshift(slides);
    }

    if (swiper.params.virtual.cache) {
      var cache = swiper.virtual.cache;
      var newCache = {};
      Object.keys(cache).forEach(function (cachedIndex) {
        var $cachedEl = cache[cachedIndex];
        var cachedElIndex = $cachedEl.attr('data-swiper-slide-index');

        if (cachedElIndex) {
          $cachedEl.attr('data-swiper-slide-index', parseInt(cachedElIndex, 10) + 1);
        }

        newCache[parseInt(cachedIndex, 10) + numberOfNewSlides] = $cachedEl;
      });
      swiper.virtual.cache = newCache;
    }

    swiper.virtual.update(true);
    swiper.slideTo(newActiveIndex, 0);
  },
  removeSlide: function removeSlide(slidesIndexes) {
    var swiper = this;
    if (typeof slidesIndexes === 'undefined' || slidesIndexes === null) return;
    var activeIndex = swiper.activeIndex;

    if (Array.isArray(slidesIndexes)) {
      for (var i = slidesIndexes.length - 1; i >= 0; i -= 1) {
        swiper.virtual.slides.splice(slidesIndexes[i], 1);

        if (swiper.params.virtual.cache) {
          delete swiper.virtual.cache[slidesIndexes[i]];
        }

        if (slidesIndexes[i] < activeIndex) activeIndex -= 1;
        activeIndex = Math.max(activeIndex, 0);
      }
    } else {
      swiper.virtual.slides.splice(slidesIndexes, 1);

      if (swiper.params.virtual.cache) {
        delete swiper.virtual.cache[slidesIndexes];
      }

      if (slidesIndexes < activeIndex) activeIndex -= 1;
      activeIndex = Math.max(activeIndex, 0);
    }

    swiper.virtual.update(true);
    swiper.slideTo(activeIndex, 0);
  },
  removeAllSlides: function removeAllSlides() {
    var swiper = this;
    swiper.virtual.slides = [];

    if (swiper.params.virtual.cache) {
      swiper.virtual.cache = {};
    }

    swiper.virtual.update(true);
    swiper.slideTo(0, 0);
  }
};
var Virtual$1 = {
  name: 'virtual',
  params: {
    virtual: {
      enabled: false,
      slides: [],
      cache: true,
      renderSlide: null,
      renderExternal: null,
      addSlidesBefore: 0,
      addSlidesAfter: 0
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      virtual: {
        update: Virtual.update.bind(swiper),
        appendSlide: Virtual.appendSlide.bind(swiper),
        prependSlide: Virtual.prependSlide.bind(swiper),
        removeSlide: Virtual.removeSlide.bind(swiper),
        removeAllSlides: Virtual.removeAllSlides.bind(swiper),
        renderSlide: Virtual.renderSlide.bind(swiper),
        slides: swiper.params.virtual.slides,
        cache: {}
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      if (!swiper.params.virtual.enabled) return;
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "virtual"));
      var overwriteParams = {
        watchSlidesProgress: true
      };
      Utils.extend(swiper.params, overwriteParams);
      Utils.extend(swiper.originalParams, overwriteParams);

      if (!swiper.params.initialSlide) {
        swiper.virtual.update();
      }
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      if (!swiper.params.virtual.enabled) return;
      swiper.virtual.update();
    }
  }
};
var Keyboard = {
  handle: function handle(event) {
    var swiper = this;
    var rtl = swiper.rtlTranslate;
    var e = event;
    if (e.originalEvent) e = e.originalEvent; // jquery fix

    var kc = e.keyCode || e.charCode;
    var pageUpDown = swiper.params.keyboard.pageUpDown;
    var isPageUp = pageUpDown && kc === 33;
    var isPageDown = pageUpDown && kc === 34;
    var isArrowLeft = kc === 37;
    var isArrowRight = kc === 39;
    var isArrowUp = kc === 38;
    var isArrowDown = kc === 40; // Directions locks

    if (!swiper.allowSlideNext && (swiper.isHorizontal() && isArrowRight || swiper.isVertical() && isArrowDown || isPageDown)) {
      return false;
    }

    if (!swiper.allowSlidePrev && (swiper.isHorizontal() && isArrowLeft || swiper.isVertical() && isArrowUp || isPageUp)) {
      return false;
    }

    if (e.shiftKey || e.altKey || e.ctrlKey || e.metaKey) {
      return undefined;
    }

    if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement.nodeName && (ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement.nodeName.toLowerCase() === 'input' || ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].activeElement.nodeName.toLowerCase() === 'textarea')) {
      return undefined;
    }

    if (swiper.params.keyboard.onlyInViewport && (isPageUp || isPageDown || isArrowLeft || isArrowRight || isArrowUp || isArrowDown)) {
      var inView = false; // Check that swiper should be inside of visible area of window

      if (swiper.$el.parents(".".concat(swiper.params.slideClass)).length > 0 && swiper.$el.parents(".".concat(swiper.params.slideActiveClass)).length === 0) {
        return undefined;
      }

      var windowWidth = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].innerWidth;
      var windowHeight = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].innerHeight;
      var swiperOffset = swiper.$el.offset();
      if (rtl) swiperOffset.left -= swiper.$el[0].scrollLeft;
      var swiperCoord = [[swiperOffset.left, swiperOffset.top], [swiperOffset.left + swiper.width, swiperOffset.top], [swiperOffset.left, swiperOffset.top + swiper.height], [swiperOffset.left + swiper.width, swiperOffset.top + swiper.height]];

      for (var i = 0; i < swiperCoord.length; i += 1) {
        var point = swiperCoord[i];

        if (point[0] >= 0 && point[0] <= windowWidth && point[1] >= 0 && point[1] <= windowHeight) {
          inView = true;
        }
      }

      if (!inView) return undefined;
    }

    if (swiper.isHorizontal()) {
      if (isPageUp || isPageDown || isArrowLeft || isArrowRight) {
        if (e.preventDefault) e.preventDefault();else e.returnValue = false;
      }

      if ((isPageDown || isArrowRight) && !rtl || (isPageUp || isArrowLeft) && rtl) swiper.slideNext();
      if ((isPageUp || isArrowLeft) && !rtl || (isPageDown || isArrowRight) && rtl) swiper.slidePrev();
    } else {
      if (isPageUp || isPageDown || isArrowUp || isArrowDown) {
        if (e.preventDefault) e.preventDefault();else e.returnValue = false;
      }

      if (isPageDown || isArrowDown) swiper.slideNext();
      if (isPageUp || isArrowUp) swiper.slidePrev();
    }

    swiper.emit('keyPress', kc);
    return undefined;
  },
  enable: function enable() {
    var swiper = this;
    if (swiper.keyboard.enabled) return;
    Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"]).on('keydown', swiper.keyboard.handle);
    swiper.keyboard.enabled = true;
  },
  disable: function disable() {
    var swiper = this;
    if (!swiper.keyboard.enabled) return;
    Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"]).off('keydown', swiper.keyboard.handle);
    swiper.keyboard.enabled = false;
  }
};
var Keyboard$1 = {
  name: 'keyboard',
  params: {
    keyboard: {
      enabled: false,
      onlyInViewport: true,
      pageUpDown: true
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      keyboard: {
        enabled: false,
        enable: Keyboard.enable.bind(swiper),
        disable: Keyboard.disable.bind(swiper),
        handle: Keyboard.handle.bind(swiper)
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;

      if (swiper.params.keyboard.enabled) {
        swiper.keyboard.enable();
      }
    },
    destroy: function destroy() {
      var swiper = this;

      if (swiper.keyboard.enabled) {
        swiper.keyboard.disable();
      }
    }
  }
};

function isEventSupported() {
  var eventName = 'onwheel';
  var isSupported = (eventName in ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"]);

  if (!isSupported) {
    var element = ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].createElement('div');
    element.setAttribute(eventName, 'return;');
    isSupported = typeof element[eventName] === 'function';
  }

  if (!isSupported && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].implementation && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].implementation.hasFeature // always returns true in newer browsers as per the standard.
  // @see http://dom.spec.whatwg.org/#dom-domimplementation-hasfeature
  && ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].implementation.hasFeature('', '') !== true) {
    // This is the only way to test support for the `wheel` event in IE9+.
    isSupported = ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].implementation.hasFeature('Events.wheel', '3.0');
  }

  return isSupported;
}

var Mousewheel = {
  lastScrollTime: Utils.now(),
  lastEventBeforeSnap: undefined,
  recentWheelEvents: [],
  event: function event() {
    if (ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].navigator.userAgent.indexOf('firefox') > -1) return 'DOMMouseScroll';
    return isEventSupported() ? 'wheel' : 'mousewheel';
  },
  normalize: function normalize(e) {
    // Reasonable defaults
    var PIXEL_STEP = 10;
    var LINE_HEIGHT = 40;
    var PAGE_HEIGHT = 800;
    var sX = 0;
    var sY = 0; // spinX, spinY

    var pX = 0;
    var pY = 0; // pixelX, pixelY
    // Legacy

    if ('detail' in e) {
      sY = e.detail;
    }

    if ('wheelDelta' in e) {
      sY = -e.wheelDelta / 120;
    }

    if ('wheelDeltaY' in e) {
      sY = -e.wheelDeltaY / 120;
    }

    if ('wheelDeltaX' in e) {
      sX = -e.wheelDeltaX / 120;
    } // side scrolling on FF with DOMMouseScroll


    if ('axis' in e && e.axis === e.HORIZONTAL_AXIS) {
      sX = sY;
      sY = 0;
    }

    pX = sX * PIXEL_STEP;
    pY = sY * PIXEL_STEP;

    if ('deltaY' in e) {
      pY = e.deltaY;
    }

    if ('deltaX' in e) {
      pX = e.deltaX;
    }

    if (e.shiftKey && !pX) {
      // if user scrolls with shift he wants horizontal scroll
      pX = pY;
      pY = 0;
    }

    if ((pX || pY) && e.deltaMode) {
      if (e.deltaMode === 1) {
        // delta in LINE units
        pX *= LINE_HEIGHT;
        pY *= LINE_HEIGHT;
      } else {
        // delta in PAGE units
        pX *= PAGE_HEIGHT;
        pY *= PAGE_HEIGHT;
      }
    } // Fall-back if spin cannot be determined


    if (pX && !sX) {
      sX = pX < 1 ? -1 : 1;
    }

    if (pY && !sY) {
      sY = pY < 1 ? -1 : 1;
    }

    return {
      spinX: sX,
      spinY: sY,
      pixelX: pX,
      pixelY: pY
    };
  },
  handleMouseEnter: function handleMouseEnter() {
    var swiper = this;
    swiper.mouseEntered = true;
  },
  handleMouseLeave: function handleMouseLeave() {
    var swiper = this;
    swiper.mouseEntered = false;
  },
  handle: function handle(event) {
    var e = event;
    var swiper = this;
    var params = swiper.params.mousewheel;

    if (swiper.params.cssMode) {
      e.preventDefault();
    }

    var target = swiper.$el;

    if (swiper.params.mousewheel.eventsTarged !== 'container') {
      target = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(swiper.params.mousewheel.eventsTarged);
    }

    if (!swiper.mouseEntered && !target[0].contains(e.target) && !params.releaseOnEdges) return true;
    if (e.originalEvent) e = e.originalEvent; // jquery fix

    var delta = 0;
    var rtlFactor = swiper.rtlTranslate ? -1 : 1;
    var data = Mousewheel.normalize(e);

    if (params.forceToAxis) {
      if (swiper.isHorizontal()) {
        if (Math.abs(data.pixelX) > Math.abs(data.pixelY)) delta = -data.pixelX * rtlFactor;else return true;
      } else if (Math.abs(data.pixelY) > Math.abs(data.pixelX)) delta = -data.pixelY;else return true;
    } else {
      delta = Math.abs(data.pixelX) > Math.abs(data.pixelY) ? -data.pixelX * rtlFactor : -data.pixelY;
    }

    if (delta === 0) return true;
    if (params.invert) delta = -delta;

    if (!swiper.params.freeMode) {
      // Register the new event in a variable which stores the relevant data
      var newEvent = {
        time: Utils.now(),
        delta: Math.abs(delta),
        direction: Math.sign(delta),
        raw: event
      }; // Keep the most recent events

      var recentWheelEvents = swiper.mousewheel.recentWheelEvents;

      if (recentWheelEvents.length >= 2) {
        recentWheelEvents.shift(); // only store the last N events
      }

      var prevEvent = recentWheelEvents.length ? recentWheelEvents[recentWheelEvents.length - 1] : undefined;
      recentWheelEvents.push(newEvent); // If there is at least one previous recorded event:
      //   If direction has changed or
      //   if the scroll is quicker than the previous one:
      //     Animate the slider.
      // Else (this is the first time the wheel is moved):
      //     Animate the slider.

      if (prevEvent) {
        if (newEvent.direction !== prevEvent.direction || newEvent.delta > prevEvent.delta || newEvent.time > prevEvent.time + 150) {
          swiper.mousewheel.animateSlider(newEvent);
        }
      } else {
        swiper.mousewheel.animateSlider(newEvent);
      } // If it's time to release the scroll:
      //   Return now so you don't hit the preventDefault.


      if (swiper.mousewheel.releaseScroll(newEvent)) {
        return true;
      }
    } else {
      // Freemode or scrollContainer:
      // If we recently snapped after a momentum scroll, then ignore wheel events
      // to give time for the deceleration to finish. Stop ignoring after 500 msecs
      // or if it's a new scroll (larger delta or inverse sign as last event before
      // an end-of-momentum snap).
      var _newEvent = {
        time: Utils.now(),
        delta: Math.abs(delta),
        direction: Math.sign(delta)
      };
      var lastEventBeforeSnap = swiper.mousewheel.lastEventBeforeSnap;
      var ignoreWheelEvents = lastEventBeforeSnap && _newEvent.time < lastEventBeforeSnap.time + 500 && _newEvent.delta <= lastEventBeforeSnap.delta && _newEvent.direction === lastEventBeforeSnap.direction;

      if (!ignoreWheelEvents) {
        swiper.mousewheel.lastEventBeforeSnap = undefined;

        if (swiper.params.loop) {
          swiper.loopFix();
        }

        var position = swiper.getTranslate() + delta * params.sensitivity;
        var wasBeginning = swiper.isBeginning;
        var wasEnd = swiper.isEnd;
        if (position >= swiper.minTranslate()) position = swiper.minTranslate();
        if (position <= swiper.maxTranslate()) position = swiper.maxTranslate();
        swiper.setTransition(0);
        swiper.setTranslate(position);
        swiper.updateProgress();
        swiper.updateActiveIndex();
        swiper.updateSlidesClasses();

        if (!wasBeginning && swiper.isBeginning || !wasEnd && swiper.isEnd) {
          swiper.updateSlidesClasses();
        }

        if (swiper.params.freeModeSticky) {
          // When wheel scrolling starts with sticky (aka snap) enabled, then detect
          // the end of a momentum scroll by storing recent (N=15?) wheel events.
          // 1. do all N events have decreasing or same (absolute value) delta?
          // 2. did all N events arrive in the last M (M=500?) msecs?
          // 3. does the earliest event have an (absolute value) delta that's
          //    at least P (P=1?) larger than the most recent event's delta?
          // 4. does the latest event have a delta that's smaller than Q (Q=6?) pixels?
          // If 1-4 are "yes" then we're near the end of a momuntum scroll deceleration.
          // Snap immediately and ignore remaining wheel events in this scroll.
          // See comment above for "remaining wheel events in this scroll" determination.
          // If 1-4 aren't satisfied, then wait to snap until 500ms after the last event.
          clearTimeout(swiper.mousewheel.timeout);
          swiper.mousewheel.timeout = undefined;
          var _recentWheelEvents = swiper.mousewheel.recentWheelEvents;

          if (_recentWheelEvents.length >= 15) {
            _recentWheelEvents.shift(); // only store the last N events

          }

          var _prevEvent = _recentWheelEvents.length ? _recentWheelEvents[_recentWheelEvents.length - 1] : undefined;

          var firstEvent = _recentWheelEvents[0];

          _recentWheelEvents.push(_newEvent);

          if (_prevEvent && (_newEvent.delta > _prevEvent.delta || _newEvent.direction !== _prevEvent.direction)) {
            // Increasing or reverse-sign delta means the user started scrolling again. Clear the wheel event log.
            _recentWheelEvents.splice(0);
          } else if (_recentWheelEvents.length >= 15 && _newEvent.time - firstEvent.time < 500 && firstEvent.delta - _newEvent.delta >= 1 && _newEvent.delta <= 6) {
            // We're at the end of the deceleration of a momentum scroll, so there's no need
            // to wait for more events. Snap ASAP on the next tick.
            // Also, because there's some remaining momentum we'll bias the snap in the
            // direction of the ongoing scroll because it's better UX for the scroll to snap
            // in the same direction as the scroll instead of reversing to snap.  Therefore,
            // if it's already scrolled more than 20% in the current direction, keep going.
            var snapToThreshold = delta > 0 ? 0.8 : 0.2;
            swiper.mousewheel.lastEventBeforeSnap = _newEvent;

            _recentWheelEvents.splice(0);

            swiper.mousewheel.timeout = Utils.nextTick(function () {
              swiper.slideToClosest(swiper.params.speed, true, undefined, snapToThreshold);
            }, 0); // no delay; move on next tick
          }

          if (!swiper.mousewheel.timeout) {
            // if we get here, then we haven't detected the end of a momentum scroll, so
            // we'll consider a scroll "complete" when there haven't been any wheel events
            // for 500ms.
            swiper.mousewheel.timeout = Utils.nextTick(function () {
              var snapToThreshold = 0.5;
              swiper.mousewheel.lastEventBeforeSnap = _newEvent;

              _recentWheelEvents.splice(0);

              swiper.slideToClosest(swiper.params.speed, true, undefined, snapToThreshold);
            }, 500);
          }
        } // Emit event


        if (!ignoreWheelEvents) swiper.emit('scroll', e); // Stop autoplay

        if (swiper.params.autoplay && swiper.params.autoplayDisableOnInteraction) swiper.autoplay.stop(); // Return page scroll on edge positions

        if (position === swiper.minTranslate() || position === swiper.maxTranslate()) return true;
      }
    }

    if (e.preventDefault) e.preventDefault();else e.returnValue = false;
    return false;
  },
  animateSlider: function animateSlider(newEvent) {
    var swiper = this; // If the movement is NOT big enough and
    // if the last time the user scrolled was too close to the current one (avoid continuously triggering the slider):
    //   Don't go any further (avoid insignificant scroll movement).

    if (newEvent.delta >= 6 && Utils.now() - swiper.mousewheel.lastScrollTime < 60) {
      // Return false as a default
      return true;
    } // If user is scrolling towards the end:
    //   If the slider hasn't hit the latest slide or
    //   if the slider is a loop and
    //   if the slider isn't moving right now:
    //     Go to next slide and
    //     emit a scroll event.
    // Else (the user is scrolling towards the beginning) and
    // if the slider hasn't hit the first slide or
    // if the slider is a loop and
    // if the slider isn't moving right now:
    //   Go to prev slide and
    //   emit a scroll event.


    if (newEvent.direction < 0) {
      if ((!swiper.isEnd || swiper.params.loop) && !swiper.animating) {
        swiper.slideNext();
        swiper.emit('scroll', newEvent.raw);
      }
    } else if ((!swiper.isBeginning || swiper.params.loop) && !swiper.animating) {
      swiper.slidePrev();
      swiper.emit('scroll', newEvent.raw);
    } // If you got here is because an animation has been triggered so store the current time


    swiper.mousewheel.lastScrollTime = new ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].Date().getTime(); // Return false as a default

    return false;
  },
  releaseScroll: function releaseScroll(newEvent) {
    var swiper = this;
    var params = swiper.params.mousewheel;

    if (newEvent.direction < 0) {
      if (swiper.isEnd && !swiper.params.loop && params.releaseOnEdges) {
        // Return true to animate scroll on edges
        return true;
      }
    } else if (swiper.isBeginning && !swiper.params.loop && params.releaseOnEdges) {
      // Return true to animate scroll on edges
      return true;
    }

    return false;
  },
  enable: function enable() {
    var swiper = this;
    var event = Mousewheel.event();

    if (swiper.params.cssMode) {
      swiper.wrapperEl.removeEventListener(event, swiper.mousewheel.handle);
      return true;
    }

    if (!event) return false;
    if (swiper.mousewheel.enabled) return false;
    var target = swiper.$el;

    if (swiper.params.mousewheel.eventsTarged !== 'container') {
      target = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(swiper.params.mousewheel.eventsTarged);
    }

    target.on('mouseenter', swiper.mousewheel.handleMouseEnter);
    target.on('mouseleave', swiper.mousewheel.handleMouseLeave);
    target.on(event, swiper.mousewheel.handle);
    swiper.mousewheel.enabled = true;
    return true;
  },
  disable: function disable() {
    var swiper = this;
    var event = Mousewheel.event();

    if (swiper.params.cssMode) {
      swiper.wrapperEl.addEventListener(event, swiper.mousewheel.handle);
      return true;
    }

    if (!event) return false;
    if (!swiper.mousewheel.enabled) return false;
    var target = swiper.$el;

    if (swiper.params.mousewheel.eventsTarged !== 'container') {
      target = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(swiper.params.mousewheel.eventsTarged);
    }

    target.off(event, swiper.mousewheel.handle);
    swiper.mousewheel.enabled = false;
    return true;
  }
};
var Mousewheel$1 = {
  name: 'mousewheel',
  params: {
    mousewheel: {
      enabled: false,
      releaseOnEdges: false,
      invert: false,
      forceToAxis: false,
      sensitivity: 1,
      eventsTarged: 'container'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      mousewheel: {
        enabled: false,
        enable: Mousewheel.enable.bind(swiper),
        disable: Mousewheel.disable.bind(swiper),
        handle: Mousewheel.handle.bind(swiper),
        handleMouseEnter: Mousewheel.handleMouseEnter.bind(swiper),
        handleMouseLeave: Mousewheel.handleMouseLeave.bind(swiper),
        animateSlider: Mousewheel.animateSlider.bind(swiper),
        releaseScroll: Mousewheel.releaseScroll.bind(swiper),
        lastScrollTime: Utils.now(),
        lastEventBeforeSnap: undefined,
        recentWheelEvents: []
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;

      if (!swiper.params.mousewheel.enabled && swiper.params.cssMode) {
        swiper.mousewheel.disable();
      }

      if (swiper.params.mousewheel.enabled) swiper.mousewheel.enable();
    },
    destroy: function destroy() {
      var swiper = this;

      if (swiper.params.cssMode) {
        swiper.mousewheel.enable();
      }

      if (swiper.mousewheel.enabled) swiper.mousewheel.disable();
    }
  }
};
var Navigation = {
  update: function update() {
    // Update Navigation Buttons
    var swiper = this;
    var params = swiper.params.navigation;
    if (swiper.params.loop) return;
    var _swiper$navigation = swiper.navigation,
        $nextEl = _swiper$navigation.$nextEl,
        $prevEl = _swiper$navigation.$prevEl;

    if ($prevEl && $prevEl.length > 0) {
      if (swiper.isBeginning) {
        $prevEl.addClass(params.disabledClass);
      } else {
        $prevEl.removeClass(params.disabledClass);
      }

      $prevEl[swiper.params.watchOverflow && swiper.isLocked ? 'addClass' : 'removeClass'](params.lockClass);
    }

    if ($nextEl && $nextEl.length > 0) {
      if (swiper.isEnd) {
        $nextEl.addClass(params.disabledClass);
      } else {
        $nextEl.removeClass(params.disabledClass);
      }

      $nextEl[swiper.params.watchOverflow && swiper.isLocked ? 'addClass' : 'removeClass'](params.lockClass);
    }
  },
  onPrevClick: function onPrevClick(e) {
    var swiper = this;
    e.preventDefault();
    if (swiper.isBeginning && !swiper.params.loop) return;
    swiper.slidePrev();
  },
  onNextClick: function onNextClick(e) {
    var swiper = this;
    e.preventDefault();
    if (swiper.isEnd && !swiper.params.loop) return;
    swiper.slideNext();
  },
  init: function init() {
    var swiper = this;
    var params = swiper.params.navigation;
    if (!(params.nextEl || params.prevEl)) return;
    var $nextEl;
    var $prevEl;

    if (params.nextEl) {
      $nextEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(params.nextEl);

      if (swiper.params.uniqueNavElements && typeof params.nextEl === 'string' && $nextEl.length > 1 && swiper.$el.find(params.nextEl).length === 1) {
        $nextEl = swiper.$el.find(params.nextEl);
      }
    }

    if (params.prevEl) {
      $prevEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(params.prevEl);

      if (swiper.params.uniqueNavElements && typeof params.prevEl === 'string' && $prevEl.length > 1 && swiper.$el.find(params.prevEl).length === 1) {
        $prevEl = swiper.$el.find(params.prevEl);
      }
    }

    if ($nextEl && $nextEl.length > 0) {
      $nextEl.on('click', swiper.navigation.onNextClick);
    }

    if ($prevEl && $prevEl.length > 0) {
      $prevEl.on('click', swiper.navigation.onPrevClick);
    }

    Utils.extend(swiper.navigation, {
      $nextEl: $nextEl,
      nextEl: $nextEl && $nextEl[0],
      $prevEl: $prevEl,
      prevEl: $prevEl && $prevEl[0]
    });
  },
  destroy: function destroy() {
    var swiper = this;
    var _swiper$navigation2 = swiper.navigation,
        $nextEl = _swiper$navigation2.$nextEl,
        $prevEl = _swiper$navigation2.$prevEl;

    if ($nextEl && $nextEl.length) {
      $nextEl.off('click', swiper.navigation.onNextClick);
      $nextEl.removeClass(swiper.params.navigation.disabledClass);
    }

    if ($prevEl && $prevEl.length) {
      $prevEl.off('click', swiper.navigation.onPrevClick);
      $prevEl.removeClass(swiper.params.navigation.disabledClass);
    }
  }
};
var Navigation$1 = {
  name: 'navigation',
  params: {
    navigation: {
      nextEl: null,
      prevEl: null,
      hideOnClick: false,
      disabledClass: 'swiper-button-disabled',
      hiddenClass: 'swiper-button-hidden',
      lockClass: 'swiper-button-lock'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      navigation: {
        init: Navigation.init.bind(swiper),
        update: Navigation.update.bind(swiper),
        destroy: Navigation.destroy.bind(swiper),
        onNextClick: Navigation.onNextClick.bind(swiper),
        onPrevClick: Navigation.onPrevClick.bind(swiper)
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;
      swiper.navigation.init();
      swiper.navigation.update();
    },
    toEdge: function toEdge() {
      var swiper = this;
      swiper.navigation.update();
    },
    fromEdge: function fromEdge() {
      var swiper = this;
      swiper.navigation.update();
    },
    destroy: function destroy() {
      var swiper = this;
      swiper.navigation.destroy();
    },
    click: function click(e) {
      var swiper = this;
      var _swiper$navigation3 = swiper.navigation,
          $nextEl = _swiper$navigation3.$nextEl,
          $prevEl = _swiper$navigation3.$prevEl;

      if (swiper.params.navigation.hideOnClick && !Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target).is($prevEl) && !Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target).is($nextEl)) {
        var isHidden;

        if ($nextEl) {
          isHidden = $nextEl.hasClass(swiper.params.navigation.hiddenClass);
        } else if ($prevEl) {
          isHidden = $prevEl.hasClass(swiper.params.navigation.hiddenClass);
        }

        if (isHidden === true) {
          swiper.emit('navigationShow', swiper);
        } else {
          swiper.emit('navigationHide', swiper);
        }

        if ($nextEl) {
          $nextEl.toggleClass(swiper.params.navigation.hiddenClass);
        }

        if ($prevEl) {
          $prevEl.toggleClass(swiper.params.navigation.hiddenClass);
        }
      }
    }
  }
};
var Pagination = {
  update: function update() {
    // Render || Update Pagination bullets/items
    var swiper = this;
    var rtl = swiper.rtl;
    var params = swiper.params.pagination;
    if (!params.el || !swiper.pagination.el || !swiper.pagination.$el || swiper.pagination.$el.length === 0) return;
    var slidesLength = swiper.virtual && swiper.params.virtual.enabled ? swiper.virtual.slides.length : swiper.slides.length;
    var $el = swiper.pagination.$el; // Current/Total

    var current;
    var total = swiper.params.loop ? Math.ceil((slidesLength - swiper.loopedSlides * 2) / swiper.params.slidesPerGroup) : swiper.snapGrid.length;

    if (swiper.params.loop) {
      current = Math.ceil((swiper.activeIndex - swiper.loopedSlides) / swiper.params.slidesPerGroup);

      if (current > slidesLength - 1 - swiper.loopedSlides * 2) {
        current -= slidesLength - swiper.loopedSlides * 2;
      }

      if (current > total - 1) current -= total;
      if (current < 0 && swiper.params.paginationType !== 'bullets') current = total + current;
    } else if (typeof swiper.snapIndex !== 'undefined') {
      current = swiper.snapIndex;
    } else {
      current = swiper.activeIndex || 0;
    } // Types


    if (params.type === 'bullets' && swiper.pagination.bullets && swiper.pagination.bullets.length > 0) {
      var bullets = swiper.pagination.bullets;
      var firstIndex;
      var lastIndex;
      var midIndex;

      if (params.dynamicBullets) {
        swiper.pagination.bulletSize = bullets.eq(0)[swiper.isHorizontal() ? 'outerWidth' : 'outerHeight'](true);
        $el.css(swiper.isHorizontal() ? 'width' : 'height', "".concat(swiper.pagination.bulletSize * (params.dynamicMainBullets + 4), "px"));

        if (params.dynamicMainBullets > 1 && swiper.previousIndex !== undefined) {
          swiper.pagination.dynamicBulletIndex += current - swiper.previousIndex;

          if (swiper.pagination.dynamicBulletIndex > params.dynamicMainBullets - 1) {
            swiper.pagination.dynamicBulletIndex = params.dynamicMainBullets - 1;
          } else if (swiper.pagination.dynamicBulletIndex < 0) {
            swiper.pagination.dynamicBulletIndex = 0;
          }
        }

        firstIndex = current - swiper.pagination.dynamicBulletIndex;
        lastIndex = firstIndex + (Math.min(bullets.length, params.dynamicMainBullets) - 1);
        midIndex = (lastIndex + firstIndex) / 2;
      }

      bullets.removeClass("".concat(params.bulletActiveClass, " ").concat(params.bulletActiveClass, "-next ").concat(params.bulletActiveClass, "-next-next ").concat(params.bulletActiveClass, "-prev ").concat(params.bulletActiveClass, "-prev-prev ").concat(params.bulletActiveClass, "-main"));

      if ($el.length > 1) {
        bullets.each(function (index, bullet) {
          var $bullet = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(bullet);
          var bulletIndex = $bullet.index();

          if (bulletIndex === current) {
            $bullet.addClass(params.bulletActiveClass);
          }

          if (params.dynamicBullets) {
            if (bulletIndex >= firstIndex && bulletIndex <= lastIndex) {
              $bullet.addClass("".concat(params.bulletActiveClass, "-main"));
            }

            if (bulletIndex === firstIndex) {
              $bullet.prev().addClass("".concat(params.bulletActiveClass, "-prev")).prev().addClass("".concat(params.bulletActiveClass, "-prev-prev"));
            }

            if (bulletIndex === lastIndex) {
              $bullet.next().addClass("".concat(params.bulletActiveClass, "-next")).next().addClass("".concat(params.bulletActiveClass, "-next-next"));
            }
          }
        });
      } else {
        var $bullet = bullets.eq(current);
        var bulletIndex = $bullet.index();
        $bullet.addClass(params.bulletActiveClass);

        if (params.dynamicBullets) {
          var $firstDisplayedBullet = bullets.eq(firstIndex);
          var $lastDisplayedBullet = bullets.eq(lastIndex);

          for (var i = firstIndex; i <= lastIndex; i += 1) {
            bullets.eq(i).addClass("".concat(params.bulletActiveClass, "-main"));
          }

          if (swiper.params.loop) {
            if (bulletIndex >= bullets.length - params.dynamicMainBullets) {
              for (var _i10 = params.dynamicMainBullets; _i10 >= 0; _i10 -= 1) {
                bullets.eq(bullets.length - _i10).addClass("".concat(params.bulletActiveClass, "-main"));
              }

              bullets.eq(bullets.length - params.dynamicMainBullets - 1).addClass("".concat(params.bulletActiveClass, "-prev"));
            } else {
              $firstDisplayedBullet.prev().addClass("".concat(params.bulletActiveClass, "-prev")).prev().addClass("".concat(params.bulletActiveClass, "-prev-prev"));
              $lastDisplayedBullet.next().addClass("".concat(params.bulletActiveClass, "-next")).next().addClass("".concat(params.bulletActiveClass, "-next-next"));
            }
          } else {
            $firstDisplayedBullet.prev().addClass("".concat(params.bulletActiveClass, "-prev")).prev().addClass("".concat(params.bulletActiveClass, "-prev-prev"));
            $lastDisplayedBullet.next().addClass("".concat(params.bulletActiveClass, "-next")).next().addClass("".concat(params.bulletActiveClass, "-next-next"));
          }
        }
      }

      if (params.dynamicBullets) {
        var dynamicBulletsLength = Math.min(bullets.length, params.dynamicMainBullets + 4);
        var bulletsOffset = (swiper.pagination.bulletSize * dynamicBulletsLength - swiper.pagination.bulletSize) / 2 - midIndex * swiper.pagination.bulletSize;
        var offsetProp = rtl ? 'right' : 'left';
        bullets.css(swiper.isHorizontal() ? offsetProp : 'top', "".concat(bulletsOffset, "px"));
      }
    }

    if (params.type === 'fraction') {
      $el.find(".".concat(params.currentClass)).text(params.formatFractionCurrent(current + 1));
      $el.find(".".concat(params.totalClass)).text(params.formatFractionTotal(total));
    }

    if (params.type === 'progressbar') {
      var progressbarDirection;

      if (params.progressbarOpposite) {
        progressbarDirection = swiper.isHorizontal() ? 'vertical' : 'horizontal';
      } else {
        progressbarDirection = swiper.isHorizontal() ? 'horizontal' : 'vertical';
      }

      var scale = (current + 1) / total;
      var scaleX = 1;
      var scaleY = 1;

      if (progressbarDirection === 'horizontal') {
        scaleX = scale;
      } else {
        scaleY = scale;
      }

      $el.find(".".concat(params.progressbarFillClass)).transform("translate3d(0,0,0) scaleX(".concat(scaleX, ") scaleY(").concat(scaleY, ")")).transition(swiper.params.speed);
    }

    if (params.type === 'custom' && params.renderCustom) {
      $el.html(params.renderCustom(swiper, current + 1, total));
      swiper.emit('paginationRender', swiper, $el[0]);
    } else {
      swiper.emit('paginationUpdate', swiper, $el[0]);
    }

    $el[swiper.params.watchOverflow && swiper.isLocked ? 'addClass' : 'removeClass'](params.lockClass);
  },
  render: function render() {
    // Render Container
    var swiper = this;
    var params = swiper.params.pagination;
    if (!params.el || !swiper.pagination.el || !swiper.pagination.$el || swiper.pagination.$el.length === 0) return;
    var slidesLength = swiper.virtual && swiper.params.virtual.enabled ? swiper.virtual.slides.length : swiper.slides.length;
    var $el = swiper.pagination.$el;
    var paginationHTML = '';

    if (params.type === 'bullets') {
      var numberOfBullets = swiper.params.loop ? Math.ceil((slidesLength - swiper.loopedSlides * 2) / swiper.params.slidesPerGroup) : swiper.snapGrid.length;

      for (var i = 0; i < numberOfBullets; i += 1) {
        if (params.renderBullet) {
          paginationHTML += params.renderBullet.call(swiper, i, params.bulletClass);
        } else {
          paginationHTML += "<".concat(params.bulletElement, " class=\"").concat(params.bulletClass, "\"></").concat(params.bulletElement, ">");
        }
      }

      $el.html(paginationHTML);
      swiper.pagination.bullets = $el.find(".".concat(params.bulletClass));
    }

    if (params.type === 'fraction') {
      if (params.renderFraction) {
        paginationHTML = params.renderFraction.call(swiper, params.currentClass, params.totalClass);
      } else {
        paginationHTML = "<span class=\"".concat(params.currentClass, "\"></span>") + ' / ' + "<span class=\"".concat(params.totalClass, "\"></span>");
      }

      $el.html(paginationHTML);
    }

    if (params.type === 'progressbar') {
      if (params.renderProgressbar) {
        paginationHTML = params.renderProgressbar.call(swiper, params.progressbarFillClass);
      } else {
        paginationHTML = "<span class=\"".concat(params.progressbarFillClass, "\"></span>");
      }

      $el.html(paginationHTML);
    }

    if (params.type !== 'custom') {
      swiper.emit('paginationRender', swiper.pagination.$el[0]);
    }
  },
  init: function init() {
    var swiper = this;
    var params = swiper.params.pagination;
    if (!params.el) return;
    var $el = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(params.el);
    if ($el.length === 0) return;

    if (swiper.params.uniqueNavElements && typeof params.el === 'string' && $el.length > 1) {
      $el = swiper.$el.find(params.el);
    }

    if (params.type === 'bullets' && params.clickable) {
      $el.addClass(params.clickableClass);
    }

    $el.addClass(params.modifierClass + params.type);

    if (params.type === 'bullets' && params.dynamicBullets) {
      $el.addClass("".concat(params.modifierClass).concat(params.type, "-dynamic"));
      swiper.pagination.dynamicBulletIndex = 0;

      if (params.dynamicMainBullets < 1) {
        params.dynamicMainBullets = 1;
      }
    }

    if (params.type === 'progressbar' && params.progressbarOpposite) {
      $el.addClass(params.progressbarOppositeClass);
    }

    if (params.clickable) {
      $el.on('click', ".".concat(params.bulletClass), function onClick(e) {
        e.preventDefault();
        var index = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(this).index() * swiper.params.slidesPerGroup;
        if (swiper.params.loop) index += swiper.loopedSlides;
        swiper.slideTo(index);
      });
    }

    Utils.extend(swiper.pagination, {
      $el: $el,
      el: $el[0]
    });
  },
  destroy: function destroy() {
    var swiper = this;
    var params = swiper.params.pagination;
    if (!params.el || !swiper.pagination.el || !swiper.pagination.$el || swiper.pagination.$el.length === 0) return;
    var $el = swiper.pagination.$el;
    $el.removeClass(params.hiddenClass);
    $el.removeClass(params.modifierClass + params.type);
    if (swiper.pagination.bullets) swiper.pagination.bullets.removeClass(params.bulletActiveClass);

    if (params.clickable) {
      $el.off('click', ".".concat(params.bulletClass));
    }
  }
};
var Pagination$1 = {
  name: 'pagination',
  params: {
    pagination: {
      el: null,
      bulletElement: 'span',
      clickable: false,
      hideOnClick: false,
      renderBullet: null,
      renderProgressbar: null,
      renderFraction: null,
      renderCustom: null,
      progressbarOpposite: false,
      type: 'bullets',
      // 'bullets' or 'progressbar' or 'fraction' or 'custom'
      dynamicBullets: false,
      dynamicMainBullets: 1,
      formatFractionCurrent: function formatFractionCurrent(number) {
        return number;
      },
      formatFractionTotal: function formatFractionTotal(number) {
        return number;
      },
      bulletClass: 'swiper-pagination-bullet',
      bulletActiveClass: 'swiper-pagination-bullet-active',
      modifierClass: 'swiper-pagination-',
      // NEW
      currentClass: 'swiper-pagination-current',
      totalClass: 'swiper-pagination-total',
      hiddenClass: 'swiper-pagination-hidden',
      progressbarFillClass: 'swiper-pagination-progressbar-fill',
      progressbarOppositeClass: 'swiper-pagination-progressbar-opposite',
      clickableClass: 'swiper-pagination-clickable',
      // NEW
      lockClass: 'swiper-pagination-lock'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      pagination: {
        init: Pagination.init.bind(swiper),
        render: Pagination.render.bind(swiper),
        update: Pagination.update.bind(swiper),
        destroy: Pagination.destroy.bind(swiper),
        dynamicBulletIndex: 0
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;
      swiper.pagination.init();
      swiper.pagination.render();
      swiper.pagination.update();
    },
    activeIndexChange: function activeIndexChange() {
      var swiper = this;

      if (swiper.params.loop) {
        swiper.pagination.update();
      } else if (typeof swiper.snapIndex === 'undefined') {
        swiper.pagination.update();
      }
    },
    snapIndexChange: function snapIndexChange() {
      var swiper = this;

      if (!swiper.params.loop) {
        swiper.pagination.update();
      }
    },
    slidesLengthChange: function slidesLengthChange() {
      var swiper = this;

      if (swiper.params.loop) {
        swiper.pagination.render();
        swiper.pagination.update();
      }
    },
    snapGridLengthChange: function snapGridLengthChange() {
      var swiper = this;

      if (!swiper.params.loop) {
        swiper.pagination.render();
        swiper.pagination.update();
      }
    },
    destroy: function destroy() {
      var swiper = this;
      swiper.pagination.destroy();
    },
    click: function click(e) {
      var swiper = this;

      if (swiper.params.pagination.el && swiper.params.pagination.hideOnClick && swiper.pagination.$el.length > 0 && !Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target).hasClass(swiper.params.pagination.bulletClass)) {
        var isHidden = swiper.pagination.$el.hasClass(swiper.params.pagination.hiddenClass);

        if (isHidden === true) {
          swiper.emit('paginationShow', swiper);
        } else {
          swiper.emit('paginationHide', swiper);
        }

        swiper.pagination.$el.toggleClass(swiper.params.pagination.hiddenClass);
      }
    }
  }
};
var Scrollbar = {
  setTranslate: function setTranslate() {
    var swiper = this;
    if (!swiper.params.scrollbar.el || !swiper.scrollbar.el) return;
    var scrollbar = swiper.scrollbar,
        rtl = swiper.rtlTranslate,
        progress = swiper.progress;
    var dragSize = scrollbar.dragSize,
        trackSize = scrollbar.trackSize,
        $dragEl = scrollbar.$dragEl,
        $el = scrollbar.$el;
    var params = swiper.params.scrollbar;
    var newSize = dragSize;
    var newPos = (trackSize - dragSize) * progress;

    if (rtl) {
      newPos = -newPos;

      if (newPos > 0) {
        newSize = dragSize - newPos;
        newPos = 0;
      } else if (-newPos + dragSize > trackSize) {
        newSize = trackSize + newPos;
      }
    } else if (newPos < 0) {
      newSize = dragSize + newPos;
      newPos = 0;
    } else if (newPos + dragSize > trackSize) {
      newSize = trackSize - newPos;
    }

    if (swiper.isHorizontal()) {
      $dragEl.transform("translate3d(".concat(newPos, "px, 0, 0)"));
      $dragEl[0].style.width = "".concat(newSize, "px");
    } else {
      $dragEl.transform("translate3d(0px, ".concat(newPos, "px, 0)"));
      $dragEl[0].style.height = "".concat(newSize, "px");
    }

    if (params.hide) {
      clearTimeout(swiper.scrollbar.timeout);
      $el[0].style.opacity = 1;
      swiper.scrollbar.timeout = setTimeout(function () {
        $el[0].style.opacity = 0;
        $el.transition(400);
      }, 1000);
    }
  },
  setTransition: function setTransition(duration) {
    var swiper = this;
    if (!swiper.params.scrollbar.el || !swiper.scrollbar.el) return;
    swiper.scrollbar.$dragEl.transition(duration);
  },
  updateSize: function updateSize() {
    var swiper = this;
    if (!swiper.params.scrollbar.el || !swiper.scrollbar.el) return;
    var scrollbar = swiper.scrollbar;
    var $dragEl = scrollbar.$dragEl,
        $el = scrollbar.$el;
    $dragEl[0].style.width = '';
    $dragEl[0].style.height = '';
    var trackSize = swiper.isHorizontal() ? $el[0].offsetWidth : $el[0].offsetHeight;
    var divider = swiper.size / swiper.virtualSize;
    var moveDivider = divider * (trackSize / swiper.size);
    var dragSize;

    if (swiper.params.scrollbar.dragSize === 'auto') {
      dragSize = trackSize * divider;
    } else {
      dragSize = parseInt(swiper.params.scrollbar.dragSize, 10);
    }

    if (swiper.isHorizontal()) {
      $dragEl[0].style.width = "".concat(dragSize, "px");
    } else {
      $dragEl[0].style.height = "".concat(dragSize, "px");
    }

    if (divider >= 1) {
      $el[0].style.display = 'none';
    } else {
      $el[0].style.display = '';
    }

    if (swiper.params.scrollbar.hide) {
      $el[0].style.opacity = 0;
    }

    Utils.extend(scrollbar, {
      trackSize: trackSize,
      divider: divider,
      moveDivider: moveDivider,
      dragSize: dragSize
    });
    scrollbar.$el[swiper.params.watchOverflow && swiper.isLocked ? 'addClass' : 'removeClass'](swiper.params.scrollbar.lockClass);
  },
  getPointerPosition: function getPointerPosition(e) {
    var swiper = this;

    if (swiper.isHorizontal()) {
      return e.type === 'touchstart' || e.type === 'touchmove' ? e.targetTouches[0].clientX : e.clientX;
    }

    return e.type === 'touchstart' || e.type === 'touchmove' ? e.targetTouches[0].clientY : e.clientY;
  },
  setDragPosition: function setDragPosition(e) {
    var swiper = this;
    var scrollbar = swiper.scrollbar,
        rtl = swiper.rtlTranslate;
    var $el = scrollbar.$el,
        dragSize = scrollbar.dragSize,
        trackSize = scrollbar.trackSize,
        dragStartPos = scrollbar.dragStartPos;
    var positionRatio;
    positionRatio = (scrollbar.getPointerPosition(e) - $el.offset()[swiper.isHorizontal() ? 'left' : 'top'] - (dragStartPos !== null ? dragStartPos : dragSize / 2)) / (trackSize - dragSize);
    positionRatio = Math.max(Math.min(positionRatio, 1), 0);

    if (rtl) {
      positionRatio = 1 - positionRatio;
    }

    var position = swiper.minTranslate() + (swiper.maxTranslate() - swiper.minTranslate()) * positionRatio;
    swiper.updateProgress(position);
    swiper.setTranslate(position);
    swiper.updateActiveIndex();
    swiper.updateSlidesClasses();
  },
  onDragStart: function onDragStart(e) {
    var swiper = this;
    var params = swiper.params.scrollbar;
    var scrollbar = swiper.scrollbar,
        $wrapperEl = swiper.$wrapperEl;
    var $el = scrollbar.$el,
        $dragEl = scrollbar.$dragEl;
    swiper.scrollbar.isTouched = true;
    swiper.scrollbar.dragStartPos = e.target === $dragEl[0] || e.target === $dragEl ? scrollbar.getPointerPosition(e) - e.target.getBoundingClientRect()[swiper.isHorizontal() ? 'left' : 'top'] : null;
    e.preventDefault();
    e.stopPropagation();
    $wrapperEl.transition(100);
    $dragEl.transition(100);
    scrollbar.setDragPosition(e);
    clearTimeout(swiper.scrollbar.dragTimeout);
    $el.transition(0);

    if (params.hide) {
      $el.css('opacity', 1);
    }

    if (swiper.params.cssMode) {
      swiper.$wrapperEl.css('scroll-snap-type', 'none');
    }

    swiper.emit('scrollbarDragStart', e);
  },
  onDragMove: function onDragMove(e) {
    var swiper = this;
    var scrollbar = swiper.scrollbar,
        $wrapperEl = swiper.$wrapperEl;
    var $el = scrollbar.$el,
        $dragEl = scrollbar.$dragEl;
    if (!swiper.scrollbar.isTouched) return;
    if (e.preventDefault) e.preventDefault();else e.returnValue = false;
    scrollbar.setDragPosition(e);
    $wrapperEl.transition(0);
    $el.transition(0);
    $dragEl.transition(0);
    swiper.emit('scrollbarDragMove', e);
  },
  onDragEnd: function onDragEnd(e) {
    var swiper = this;
    var params = swiper.params.scrollbar;
    var scrollbar = swiper.scrollbar,
        $wrapperEl = swiper.$wrapperEl;
    var $el = scrollbar.$el;
    if (!swiper.scrollbar.isTouched) return;
    swiper.scrollbar.isTouched = false;

    if (swiper.params.cssMode) {
      swiper.$wrapperEl.css('scroll-snap-type', '');
      $wrapperEl.transition('');
    }

    if (params.hide) {
      clearTimeout(swiper.scrollbar.dragTimeout);
      swiper.scrollbar.dragTimeout = Utils.nextTick(function () {
        $el.css('opacity', 0);
        $el.transition(400);
      }, 1000);
    }

    swiper.emit('scrollbarDragEnd', e);

    if (params.snapOnRelease) {
      swiper.slideToClosest();
    }
  },
  enableDraggable: function enableDraggable() {
    var swiper = this;
    if (!swiper.params.scrollbar.el) return;
    var scrollbar = swiper.scrollbar,
        touchEventsTouch = swiper.touchEventsTouch,
        touchEventsDesktop = swiper.touchEventsDesktop,
        params = swiper.params;
    var $el = scrollbar.$el;
    var target = $el[0];
    var activeListener = Support.passiveListener && params.passiveListeners ? {
      passive: false,
      capture: false
    } : false;
    var passiveListener = Support.passiveListener && params.passiveListeners ? {
      passive: true,
      capture: false
    } : false;

    if (!Support.touch) {
      target.addEventListener(touchEventsDesktop.start, swiper.scrollbar.onDragStart, activeListener);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener(touchEventsDesktop.move, swiper.scrollbar.onDragMove, activeListener);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].addEventListener(touchEventsDesktop.end, swiper.scrollbar.onDragEnd, passiveListener);
    } else {
      target.addEventListener(touchEventsTouch.start, swiper.scrollbar.onDragStart, activeListener);
      target.addEventListener(touchEventsTouch.move, swiper.scrollbar.onDragMove, activeListener);
      target.addEventListener(touchEventsTouch.end, swiper.scrollbar.onDragEnd, passiveListener);
    }
  },
  disableDraggable: function disableDraggable() {
    var swiper = this;
    if (!swiper.params.scrollbar.el) return;
    var scrollbar = swiper.scrollbar,
        touchEventsTouch = swiper.touchEventsTouch,
        touchEventsDesktop = swiper.touchEventsDesktop,
        params = swiper.params;
    var $el = scrollbar.$el;
    var target = $el[0];
    var activeListener = Support.passiveListener && params.passiveListeners ? {
      passive: false,
      capture: false
    } : false;
    var passiveListener = Support.passiveListener && params.passiveListeners ? {
      passive: true,
      capture: false
    } : false;

    if (!Support.touch) {
      target.removeEventListener(touchEventsDesktop.start, swiper.scrollbar.onDragStart, activeListener);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].removeEventListener(touchEventsDesktop.move, swiper.scrollbar.onDragMove, activeListener);
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].removeEventListener(touchEventsDesktop.end, swiper.scrollbar.onDragEnd, passiveListener);
    } else {
      target.removeEventListener(touchEventsTouch.start, swiper.scrollbar.onDragStart, activeListener);
      target.removeEventListener(touchEventsTouch.move, swiper.scrollbar.onDragMove, activeListener);
      target.removeEventListener(touchEventsTouch.end, swiper.scrollbar.onDragEnd, passiveListener);
    }
  },
  init: function init() {
    var swiper = this;
    if (!swiper.params.scrollbar.el) return;
    var scrollbar = swiper.scrollbar,
        $swiperEl = swiper.$el;
    var params = swiper.params.scrollbar;
    var $el = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(params.el);

    if (swiper.params.uniqueNavElements && typeof params.el === 'string' && $el.length > 1 && $swiperEl.find(params.el).length === 1) {
      $el = $swiperEl.find(params.el);
    }

    var $dragEl = $el.find(".".concat(swiper.params.scrollbar.dragClass));

    if ($dragEl.length === 0) {
      $dragEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"".concat(swiper.params.scrollbar.dragClass, "\"></div>"));
      $el.append($dragEl);
    }

    Utils.extend(scrollbar, {
      $el: $el,
      el: $el[0],
      $dragEl: $dragEl,
      dragEl: $dragEl[0]
    });

    if (params.draggable) {
      scrollbar.enableDraggable();
    }
  },
  destroy: function destroy() {
    var swiper = this;
    swiper.scrollbar.disableDraggable();
  }
};
var Scrollbar$1 = {
  name: 'scrollbar',
  params: {
    scrollbar: {
      el: null,
      dragSize: 'auto',
      hide: false,
      draggable: false,
      snapOnRelease: true,
      lockClass: 'swiper-scrollbar-lock',
      dragClass: 'swiper-scrollbar-drag'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      scrollbar: {
        init: Scrollbar.init.bind(swiper),
        destroy: Scrollbar.destroy.bind(swiper),
        updateSize: Scrollbar.updateSize.bind(swiper),
        setTranslate: Scrollbar.setTranslate.bind(swiper),
        setTransition: Scrollbar.setTransition.bind(swiper),
        enableDraggable: Scrollbar.enableDraggable.bind(swiper),
        disableDraggable: Scrollbar.disableDraggable.bind(swiper),
        setDragPosition: Scrollbar.setDragPosition.bind(swiper),
        getPointerPosition: Scrollbar.getPointerPosition.bind(swiper),
        onDragStart: Scrollbar.onDragStart.bind(swiper),
        onDragMove: Scrollbar.onDragMove.bind(swiper),
        onDragEnd: Scrollbar.onDragEnd.bind(swiper),
        isTouched: false,
        timeout: null,
        dragTimeout: null
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;
      swiper.scrollbar.init();
      swiper.scrollbar.updateSize();
      swiper.scrollbar.setTranslate();
    },
    update: function update() {
      var swiper = this;
      swiper.scrollbar.updateSize();
    },
    resize: function resize() {
      var swiper = this;
      swiper.scrollbar.updateSize();
    },
    observerUpdate: function observerUpdate() {
      var swiper = this;
      swiper.scrollbar.updateSize();
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      swiper.scrollbar.setTranslate();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      swiper.scrollbar.setTransition(duration);
    },
    destroy: function destroy() {
      var swiper = this;
      swiper.scrollbar.destroy();
    }
  }
};
var Parallax = {
  setTransform: function setTransform(el, progress) {
    var swiper = this;
    var rtl = swiper.rtl;
    var $el = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(el);
    var rtlFactor = rtl ? -1 : 1;
    var p = $el.attr('data-swiper-parallax') || '0';
    var x = $el.attr('data-swiper-parallax-x');
    var y = $el.attr('data-swiper-parallax-y');
    var scale = $el.attr('data-swiper-parallax-scale');
    var opacity = $el.attr('data-swiper-parallax-opacity');

    if (x || y) {
      x = x || '0';
      y = y || '0';
    } else if (swiper.isHorizontal()) {
      x = p;
      y = '0';
    } else {
      y = p;
      x = '0';
    }

    if (x.indexOf('%') >= 0) {
      x = "".concat(parseInt(x, 10) * progress * rtlFactor, "%");
    } else {
      x = "".concat(x * progress * rtlFactor, "px");
    }

    if (y.indexOf('%') >= 0) {
      y = "".concat(parseInt(y, 10) * progress, "%");
    } else {
      y = "".concat(y * progress, "px");
    }

    if (typeof opacity !== 'undefined' && opacity !== null) {
      var currentOpacity = opacity - (opacity - 1) * (1 - Math.abs(progress));
      $el[0].style.opacity = currentOpacity;
    }

    if (typeof scale === 'undefined' || scale === null) {
      $el.transform("translate3d(".concat(x, ", ").concat(y, ", 0px)"));
    } else {
      var currentScale = scale - (scale - 1) * (1 - Math.abs(progress));
      $el.transform("translate3d(".concat(x, ", ").concat(y, ", 0px) scale(").concat(currentScale, ")"));
    }
  },
  setTranslate: function setTranslate() {
    var swiper = this;
    var $el = swiper.$el,
        slides = swiper.slides,
        progress = swiper.progress,
        snapGrid = swiper.snapGrid;
    $el.children('[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]').each(function (index, el) {
      swiper.parallax.setTransform(el, progress);
    });
    slides.each(function (slideIndex, slideEl) {
      var slideProgress = slideEl.progress;

      if (swiper.params.slidesPerGroup > 1 && swiper.params.slidesPerView !== 'auto') {
        slideProgress += Math.ceil(slideIndex / 2) - progress * (snapGrid.length - 1);
      }

      slideProgress = Math.min(Math.max(slideProgress, -1), 1);
      Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slideEl).find('[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]').each(function (index, el) {
        swiper.parallax.setTransform(el, slideProgress);
      });
    });
  },
  setTransition: function setTransition() {
    var duration = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : this.params.speed;
    var swiper = this;
    var $el = swiper.$el;
    $el.find('[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]').each(function (index, parallaxEl) {
      var $parallaxEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(parallaxEl);
      var parallaxDuration = parseInt($parallaxEl.attr('data-swiper-parallax-duration'), 10) || duration;
      if (duration === 0) parallaxDuration = 0;
      $parallaxEl.transition(parallaxDuration);
    });
  }
};
var Parallax$1 = {
  name: 'parallax',
  params: {
    parallax: {
      enabled: false
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      parallax: {
        setTransform: Parallax.setTransform.bind(swiper),
        setTranslate: Parallax.setTranslate.bind(swiper),
        setTransition: Parallax.setTransition.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      if (!swiper.params.parallax.enabled) return;
      swiper.params.watchSlidesProgress = true;
      swiper.originalParams.watchSlidesProgress = true;
    },
    init: function init() {
      var swiper = this;
      if (!swiper.params.parallax.enabled) return;
      swiper.parallax.setTranslate();
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      if (!swiper.params.parallax.enabled) return;
      swiper.parallax.setTranslate();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      if (!swiper.params.parallax.enabled) return;
      swiper.parallax.setTransition(duration);
    }
  }
};
var Zoom = {
  // Calc Scale From Multi-touches
  getDistanceBetweenTouches: function getDistanceBetweenTouches(e) {
    if (e.targetTouches.length < 2) return 1;
    var x1 = e.targetTouches[0].pageX;
    var y1 = e.targetTouches[0].pageY;
    var x2 = e.targetTouches[1].pageX;
    var y2 = e.targetTouches[1].pageY;
    var distance = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
    return distance;
  },
  // Events
  onGestureStart: function onGestureStart(e) {
    var swiper = this;
    var params = swiper.params.zoom;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture;
    zoom.fakeGestureTouched = false;
    zoom.fakeGestureMoved = false;

    if (!Support.gestures) {
      if (e.type !== 'touchstart' || e.type === 'touchstart' && e.targetTouches.length < 2) {
        return;
      }

      zoom.fakeGestureTouched = true;
      gesture.scaleStart = Zoom.getDistanceBetweenTouches(e);
    }

    if (!gesture.$slideEl || !gesture.$slideEl.length) {
      gesture.$slideEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target).closest(".".concat(swiper.params.slideClass));
      if (gesture.$slideEl.length === 0) gesture.$slideEl = swiper.slides.eq(swiper.activeIndex);
      gesture.$imageEl = gesture.$slideEl.find('img, svg, canvas, picture, .swiper-zoom-target');
      gesture.$imageWrapEl = gesture.$imageEl.parent(".".concat(params.containerClass));
      gesture.maxRatio = gesture.$imageWrapEl.attr('data-swiper-zoom') || params.maxRatio;

      if (gesture.$imageWrapEl.length === 0) {
        gesture.$imageEl = undefined;
        return;
      }
    }

    if (gesture.$imageEl) {
      gesture.$imageEl.transition(0);
    }

    swiper.zoom.isScaling = true;
  },
  onGestureChange: function onGestureChange(e) {
    var swiper = this;
    var params = swiper.params.zoom;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture;

    if (!Support.gestures) {
      if (e.type !== 'touchmove' || e.type === 'touchmove' && e.targetTouches.length < 2) {
        return;
      }

      zoom.fakeGestureMoved = true;
      gesture.scaleMove = Zoom.getDistanceBetweenTouches(e);
    }

    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;

    if (Support.gestures) {
      zoom.scale = e.scale * zoom.currentScale;
    } else {
      zoom.scale = gesture.scaleMove / gesture.scaleStart * zoom.currentScale;
    }

    if (zoom.scale > gesture.maxRatio) {
      zoom.scale = gesture.maxRatio - 1 + Math.pow(zoom.scale - gesture.maxRatio + 1, 0.5);
    }

    if (zoom.scale < params.minRatio) {
      zoom.scale = params.minRatio + 1 - Math.pow(params.minRatio - zoom.scale + 1, 0.5);
    }

    gesture.$imageEl.transform("translate3d(0,0,0) scale(".concat(zoom.scale, ")"));
  },
  onGestureEnd: function onGestureEnd(e) {
    var swiper = this;
    var params = swiper.params.zoom;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture;

    if (!Support.gestures) {
      if (!zoom.fakeGestureTouched || !zoom.fakeGestureMoved) {
        return;
      }

      if (e.type !== 'touchend' || e.type === 'touchend' && e.changedTouches.length < 2 && !Device.android) {
        return;
      }

      zoom.fakeGestureTouched = false;
      zoom.fakeGestureMoved = false;
    }

    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;
    zoom.scale = Math.max(Math.min(zoom.scale, gesture.maxRatio), params.minRatio);
    gesture.$imageEl.transition(swiper.params.speed).transform("translate3d(0,0,0) scale(".concat(zoom.scale, ")"));
    zoom.currentScale = zoom.scale;
    zoom.isScaling = false;
    if (zoom.scale === 1) gesture.$slideEl = undefined;
  },
  onTouchStart: function onTouchStart(e) {
    var swiper = this;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture,
        image = zoom.image;
    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;
    if (image.isTouched) return;
    if (Device.android && e.cancelable) e.preventDefault();
    image.isTouched = true;
    image.touchesStart.x = e.type === 'touchstart' ? e.targetTouches[0].pageX : e.pageX;
    image.touchesStart.y = e.type === 'touchstart' ? e.targetTouches[0].pageY : e.pageY;
  },
  onTouchMove: function onTouchMove(e) {
    var swiper = this;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture,
        image = zoom.image,
        velocity = zoom.velocity;
    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;
    swiper.allowClick = false;
    if (!image.isTouched || !gesture.$slideEl) return;

    if (!image.isMoved) {
      image.width = gesture.$imageEl[0].offsetWidth;
      image.height = gesture.$imageEl[0].offsetHeight;
      image.startX = Utils.getTranslate(gesture.$imageWrapEl[0], 'x') || 0;
      image.startY = Utils.getTranslate(gesture.$imageWrapEl[0], 'y') || 0;
      gesture.slideWidth = gesture.$slideEl[0].offsetWidth;
      gesture.slideHeight = gesture.$slideEl[0].offsetHeight;
      gesture.$imageWrapEl.transition(0);

      if (swiper.rtl) {
        image.startX = -image.startX;
        image.startY = -image.startY;
      }
    } // Define if we need image drag


    var scaledWidth = image.width * zoom.scale;
    var scaledHeight = image.height * zoom.scale;
    if (scaledWidth < gesture.slideWidth && scaledHeight < gesture.slideHeight) return;
    image.minX = Math.min(gesture.slideWidth / 2 - scaledWidth / 2, 0);
    image.maxX = -image.minX;
    image.minY = Math.min(gesture.slideHeight / 2 - scaledHeight / 2, 0);
    image.maxY = -image.minY;
    image.touchesCurrent.x = e.type === 'touchmove' ? e.targetTouches[0].pageX : e.pageX;
    image.touchesCurrent.y = e.type === 'touchmove' ? e.targetTouches[0].pageY : e.pageY;

    if (!image.isMoved && !zoom.isScaling) {
      if (swiper.isHorizontal() && (Math.floor(image.minX) === Math.floor(image.startX) && image.touchesCurrent.x < image.touchesStart.x || Math.floor(image.maxX) === Math.floor(image.startX) && image.touchesCurrent.x > image.touchesStart.x)) {
        image.isTouched = false;
        return;
      }

      if (!swiper.isHorizontal() && (Math.floor(image.minY) === Math.floor(image.startY) && image.touchesCurrent.y < image.touchesStart.y || Math.floor(image.maxY) === Math.floor(image.startY) && image.touchesCurrent.y > image.touchesStart.y)) {
        image.isTouched = false;
        return;
      }
    }

    if (e.cancelable) {
      e.preventDefault();
    }

    e.stopPropagation();
    image.isMoved = true;
    image.currentX = image.touchesCurrent.x - image.touchesStart.x + image.startX;
    image.currentY = image.touchesCurrent.y - image.touchesStart.y + image.startY;

    if (image.currentX < image.minX) {
      image.currentX = image.minX + 1 - Math.pow(image.minX - image.currentX + 1, 0.8);
    }

    if (image.currentX > image.maxX) {
      image.currentX = image.maxX - 1 + Math.pow(image.currentX - image.maxX + 1, 0.8);
    }

    if (image.currentY < image.minY) {
      image.currentY = image.minY + 1 - Math.pow(image.minY - image.currentY + 1, 0.8);
    }

    if (image.currentY > image.maxY) {
      image.currentY = image.maxY - 1 + Math.pow(image.currentY - image.maxY + 1, 0.8);
    } // Velocity


    if (!velocity.prevPositionX) velocity.prevPositionX = image.touchesCurrent.x;
    if (!velocity.prevPositionY) velocity.prevPositionY = image.touchesCurrent.y;
    if (!velocity.prevTime) velocity.prevTime = Date.now();
    velocity.x = (image.touchesCurrent.x - velocity.prevPositionX) / (Date.now() - velocity.prevTime) / 2;
    velocity.y = (image.touchesCurrent.y - velocity.prevPositionY) / (Date.now() - velocity.prevTime) / 2;
    if (Math.abs(image.touchesCurrent.x - velocity.prevPositionX) < 2) velocity.x = 0;
    if (Math.abs(image.touchesCurrent.y - velocity.prevPositionY) < 2) velocity.y = 0;
    velocity.prevPositionX = image.touchesCurrent.x;
    velocity.prevPositionY = image.touchesCurrent.y;
    velocity.prevTime = Date.now();
    gesture.$imageWrapEl.transform("translate3d(".concat(image.currentX, "px, ").concat(image.currentY, "px,0)"));
  },
  onTouchEnd: function onTouchEnd() {
    var swiper = this;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture,
        image = zoom.image,
        velocity = zoom.velocity;
    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;

    if (!image.isTouched || !image.isMoved) {
      image.isTouched = false;
      image.isMoved = false;
      return;
    }

    image.isTouched = false;
    image.isMoved = false;
    var momentumDurationX = 300;
    var momentumDurationY = 300;
    var momentumDistanceX = velocity.x * momentumDurationX;
    var newPositionX = image.currentX + momentumDistanceX;
    var momentumDistanceY = velocity.y * momentumDurationY;
    var newPositionY = image.currentY + momentumDistanceY; // Fix duration

    if (velocity.x !== 0) momentumDurationX = Math.abs((newPositionX - image.currentX) / velocity.x);
    if (velocity.y !== 0) momentumDurationY = Math.abs((newPositionY - image.currentY) / velocity.y);
    var momentumDuration = Math.max(momentumDurationX, momentumDurationY);
    image.currentX = newPositionX;
    image.currentY = newPositionY; // Define if we need image drag

    var scaledWidth = image.width * zoom.scale;
    var scaledHeight = image.height * zoom.scale;
    image.minX = Math.min(gesture.slideWidth / 2 - scaledWidth / 2, 0);
    image.maxX = -image.minX;
    image.minY = Math.min(gesture.slideHeight / 2 - scaledHeight / 2, 0);
    image.maxY = -image.minY;
    image.currentX = Math.max(Math.min(image.currentX, image.maxX), image.minX);
    image.currentY = Math.max(Math.min(image.currentY, image.maxY), image.minY);
    gesture.$imageWrapEl.transition(momentumDuration).transform("translate3d(".concat(image.currentX, "px, ").concat(image.currentY, "px,0)"));
  },
  onTransitionEnd: function onTransitionEnd() {
    var swiper = this;
    var zoom = swiper.zoom;
    var gesture = zoom.gesture;

    if (gesture.$slideEl && swiper.previousIndex !== swiper.activeIndex) {
      if (gesture.$imageEl) {
        gesture.$imageEl.transform('translate3d(0,0,0) scale(1)');
      }

      if (gesture.$imageWrapEl) {
        gesture.$imageWrapEl.transform('translate3d(0,0,0)');
      }

      zoom.scale = 1;
      zoom.currentScale = 1;
      gesture.$slideEl = undefined;
      gesture.$imageEl = undefined;
      gesture.$imageWrapEl = undefined;
    }
  },
  // Toggle Zoom
  toggle: function toggle(e) {
    var swiper = this;
    var zoom = swiper.zoom;

    if (zoom.scale && zoom.scale !== 1) {
      // Zoom Out
      zoom.out();
    } else {
      // Zoom In
      zoom["in"](e);
    }
  },
  "in": function _in(e) {
    var swiper = this;
    var zoom = swiper.zoom;
    var params = swiper.params.zoom;
    var gesture = zoom.gesture,
        image = zoom.image;

    if (!gesture.$slideEl) {
      if (swiper.params.virtual && swiper.params.virtual.enabled && swiper.virtual) {
        gesture.$slideEl = swiper.$wrapperEl.children(".".concat(swiper.params.slideActiveClass));
      } else {
        gesture.$slideEl = swiper.slides.eq(swiper.activeIndex);
      }

      gesture.$imageEl = gesture.$slideEl.find('img, svg, canvas, picture, .swiper-zoom-target');
      gesture.$imageWrapEl = gesture.$imageEl.parent(".".concat(params.containerClass));
    }

    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;
    gesture.$slideEl.addClass("".concat(params.zoomedSlideClass));
    var touchX;
    var touchY;
    var offsetX;
    var offsetY;
    var diffX;
    var diffY;
    var translateX;
    var translateY;
    var imageWidth;
    var imageHeight;
    var scaledWidth;
    var scaledHeight;
    var translateMinX;
    var translateMinY;
    var translateMaxX;
    var translateMaxY;
    var slideWidth;
    var slideHeight;

    if (typeof image.touchesStart.x === 'undefined' && e) {
      touchX = e.type === 'touchend' ? e.changedTouches[0].pageX : e.pageX;
      touchY = e.type === 'touchend' ? e.changedTouches[0].pageY : e.pageY;
    } else {
      touchX = image.touchesStart.x;
      touchY = image.touchesStart.y;
    }

    zoom.scale = gesture.$imageWrapEl.attr('data-swiper-zoom') || params.maxRatio;
    zoom.currentScale = gesture.$imageWrapEl.attr('data-swiper-zoom') || params.maxRatio;

    if (e) {
      slideWidth = gesture.$slideEl[0].offsetWidth;
      slideHeight = gesture.$slideEl[0].offsetHeight;
      offsetX = gesture.$slideEl.offset().left;
      offsetY = gesture.$slideEl.offset().top;
      diffX = offsetX + slideWidth / 2 - touchX;
      diffY = offsetY + slideHeight / 2 - touchY;
      imageWidth = gesture.$imageEl[0].offsetWidth;
      imageHeight = gesture.$imageEl[0].offsetHeight;
      scaledWidth = imageWidth * zoom.scale;
      scaledHeight = imageHeight * zoom.scale;
      translateMinX = Math.min(slideWidth / 2 - scaledWidth / 2, 0);
      translateMinY = Math.min(slideHeight / 2 - scaledHeight / 2, 0);
      translateMaxX = -translateMinX;
      translateMaxY = -translateMinY;
      translateX = diffX * zoom.scale;
      translateY = diffY * zoom.scale;

      if (translateX < translateMinX) {
        translateX = translateMinX;
      }

      if (translateX > translateMaxX) {
        translateX = translateMaxX;
      }

      if (translateY < translateMinY) {
        translateY = translateMinY;
      }

      if (translateY > translateMaxY) {
        translateY = translateMaxY;
      }
    } else {
      translateX = 0;
      translateY = 0;
    }

    gesture.$imageWrapEl.transition(300).transform("translate3d(".concat(translateX, "px, ").concat(translateY, "px,0)"));
    gesture.$imageEl.transition(300).transform("translate3d(0,0,0) scale(".concat(zoom.scale, ")"));
  },
  out: function out() {
    var swiper = this;
    var zoom = swiper.zoom;
    var params = swiper.params.zoom;
    var gesture = zoom.gesture;

    if (!gesture.$slideEl) {
      if (swiper.params.virtual && swiper.params.virtual.enabled && swiper.virtual) {
        gesture.$slideEl = swiper.$wrapperEl.children(".".concat(swiper.params.slideActiveClass));
      } else {
        gesture.$slideEl = swiper.slides.eq(swiper.activeIndex);
      }

      gesture.$imageEl = gesture.$slideEl.find('img, svg, canvas, picture, .swiper-zoom-target');
      gesture.$imageWrapEl = gesture.$imageEl.parent(".".concat(params.containerClass));
    }

    if (!gesture.$imageEl || gesture.$imageEl.length === 0) return;
    zoom.scale = 1;
    zoom.currentScale = 1;
    gesture.$imageWrapEl.transition(300).transform('translate3d(0,0,0)');
    gesture.$imageEl.transition(300).transform('translate3d(0,0,0) scale(1)');
    gesture.$slideEl.removeClass("".concat(params.zoomedSlideClass));
    gesture.$slideEl = undefined;
  },
  // Attach/Detach Events
  enable: function enable() {
    var swiper = this;
    var zoom = swiper.zoom;
    if (zoom.enabled) return;
    zoom.enabled = true;
    var passiveListener = swiper.touchEvents.start === 'touchstart' && Support.passiveListener && swiper.params.passiveListeners ? {
      passive: true,
      capture: false
    } : false;
    var activeListenerWithCapture = Support.passiveListener ? {
      passive: false,
      capture: true
    } : true;
    var slideSelector = ".".concat(swiper.params.slideClass); // Scale image

    if (Support.gestures) {
      swiper.$wrapperEl.on('gesturestart', slideSelector, zoom.onGestureStart, passiveListener);
      swiper.$wrapperEl.on('gesturechange', slideSelector, zoom.onGestureChange, passiveListener);
      swiper.$wrapperEl.on('gestureend', slideSelector, zoom.onGestureEnd, passiveListener);
    } else if (swiper.touchEvents.start === 'touchstart') {
      swiper.$wrapperEl.on(swiper.touchEvents.start, slideSelector, zoom.onGestureStart, passiveListener);
      swiper.$wrapperEl.on(swiper.touchEvents.move, slideSelector, zoom.onGestureChange, activeListenerWithCapture);
      swiper.$wrapperEl.on(swiper.touchEvents.end, slideSelector, zoom.onGestureEnd, passiveListener);

      if (swiper.touchEvents.cancel) {
        swiper.$wrapperEl.on(swiper.touchEvents.cancel, slideSelector, zoom.onGestureEnd, passiveListener);
      }
    } // Move image


    swiper.$wrapperEl.on(swiper.touchEvents.move, ".".concat(swiper.params.zoom.containerClass), zoom.onTouchMove, activeListenerWithCapture);
  },
  disable: function disable() {
    var swiper = this;
    var zoom = swiper.zoom;
    if (!zoom.enabled) return;
    swiper.zoom.enabled = false;
    var passiveListener = swiper.touchEvents.start === 'touchstart' && Support.passiveListener && swiper.params.passiveListeners ? {
      passive: true,
      capture: false
    } : false;
    var activeListenerWithCapture = Support.passiveListener ? {
      passive: false,
      capture: true
    } : true;
    var slideSelector = ".".concat(swiper.params.slideClass); // Scale image

    if (Support.gestures) {
      swiper.$wrapperEl.off('gesturestart', slideSelector, zoom.onGestureStart, passiveListener);
      swiper.$wrapperEl.off('gesturechange', slideSelector, zoom.onGestureChange, passiveListener);
      swiper.$wrapperEl.off('gestureend', slideSelector, zoom.onGestureEnd, passiveListener);
    } else if (swiper.touchEvents.start === 'touchstart') {
      swiper.$wrapperEl.off(swiper.touchEvents.start, slideSelector, zoom.onGestureStart, passiveListener);
      swiper.$wrapperEl.off(swiper.touchEvents.move, slideSelector, zoom.onGestureChange, activeListenerWithCapture);
      swiper.$wrapperEl.off(swiper.touchEvents.end, slideSelector, zoom.onGestureEnd, passiveListener);

      if (swiper.touchEvents.cancel) {
        swiper.$wrapperEl.off(swiper.touchEvents.cancel, slideSelector, zoom.onGestureEnd, passiveListener);
      }
    } // Move image


    swiper.$wrapperEl.off(swiper.touchEvents.move, ".".concat(swiper.params.zoom.containerClass), zoom.onTouchMove, activeListenerWithCapture);
  }
};
var Zoom$1 = {
  name: 'zoom',
  params: {
    zoom: {
      enabled: false,
      maxRatio: 3,
      minRatio: 1,
      toggle: true,
      containerClass: 'swiper-zoom-container',
      zoomedSlideClass: 'swiper-slide-zoomed'
    }
  },
  create: function create() {
    var swiper = this;
    var zoom = {
      enabled: false,
      scale: 1,
      currentScale: 1,
      isScaling: false,
      gesture: {
        $slideEl: undefined,
        slideWidth: undefined,
        slideHeight: undefined,
        $imageEl: undefined,
        $imageWrapEl: undefined,
        maxRatio: 3
      },
      image: {
        isTouched: undefined,
        isMoved: undefined,
        currentX: undefined,
        currentY: undefined,
        minX: undefined,
        minY: undefined,
        maxX: undefined,
        maxY: undefined,
        width: undefined,
        height: undefined,
        startX: undefined,
        startY: undefined,
        touchesStart: {},
        touchesCurrent: {}
      },
      velocity: {
        x: undefined,
        y: undefined,
        prevPositionX: undefined,
        prevPositionY: undefined,
        prevTime: undefined
      }
    };
    'onGestureStart onGestureChange onGestureEnd onTouchStart onTouchMove onTouchEnd onTransitionEnd toggle enable disable in out'.split(' ').forEach(function (methodName) {
      zoom[methodName] = Zoom[methodName].bind(swiper);
    });
    Utils.extend(swiper, {
      zoom: zoom
    });
    var scale = 1;
    Object.defineProperty(swiper.zoom, 'scale', {
      get: function get() {
        return scale;
      },
      set: function set(value) {
        if (scale !== value) {
          var imageEl = swiper.zoom.gesture.$imageEl ? swiper.zoom.gesture.$imageEl[0] : undefined;
          var slideEl = swiper.zoom.gesture.$slideEl ? swiper.zoom.gesture.$slideEl[0] : undefined;
          swiper.emit('zoomChange', value, imageEl, slideEl);
        }

        scale = value;
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;

      if (swiper.params.zoom.enabled) {
        swiper.zoom.enable();
      }
    },
    destroy: function destroy() {
      var swiper = this;
      swiper.zoom.disable();
    },
    touchStart: function touchStart(e) {
      var swiper = this;
      if (!swiper.zoom.enabled) return;
      swiper.zoom.onTouchStart(e);
    },
    touchEnd: function touchEnd(e) {
      var swiper = this;
      if (!swiper.zoom.enabled) return;
      swiper.zoom.onTouchEnd(e);
    },
    doubleTap: function doubleTap(e) {
      var swiper = this;

      if (swiper.params.zoom.enabled && swiper.zoom.enabled && swiper.params.zoom.toggle) {
        swiper.zoom.toggle(e);
      }
    },
    transitionEnd: function transitionEnd() {
      var swiper = this;

      if (swiper.zoom.enabled && swiper.params.zoom.enabled) {
        swiper.zoom.onTransitionEnd();
      }
    },
    slideChange: function slideChange() {
      var swiper = this;

      if (swiper.zoom.enabled && swiper.params.zoom.enabled && swiper.params.cssMode) {
        swiper.zoom.onTransitionEnd();
      }
    }
  }
};
var Lazy = {
  loadInSlide: function loadInSlide(index) {
    var loadInDuplicate = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true;
    var swiper = this;
    var params = swiper.params.lazy;
    if (typeof index === 'undefined') return;
    if (swiper.slides.length === 0) return;
    var isVirtual = swiper.virtual && swiper.params.virtual.enabled;
    var $slideEl = isVirtual ? swiper.$wrapperEl.children(".".concat(swiper.params.slideClass, "[data-swiper-slide-index=\"").concat(index, "\"]")) : swiper.slides.eq(index);
    var $images = $slideEl.find(".".concat(params.elementClass, ":not(.").concat(params.loadedClass, "):not(.").concat(params.loadingClass, ")"));

    if ($slideEl.hasClass(params.elementClass) && !$slideEl.hasClass(params.loadedClass) && !$slideEl.hasClass(params.loadingClass)) {
      $images = $images.add($slideEl[0]);
    }

    if ($images.length === 0) return;
    $images.each(function (imageIndex, imageEl) {
      var $imageEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(imageEl);
      $imageEl.addClass(params.loadingClass);
      var background = $imageEl.attr('data-background');
      var src = $imageEl.attr('data-src');
      var srcset = $imageEl.attr('data-srcset');
      var sizes = $imageEl.attr('data-sizes');
      var $pictureEl = $imageEl.parent('picture');
      swiper.loadImage($imageEl[0], src || background, srcset, sizes, false, function () {
        if (typeof swiper === 'undefined' || swiper === null || !swiper || swiper && !swiper.params || swiper.destroyed) return;

        if (background) {
          $imageEl.css('background-image', "url(\"".concat(background, "\")"));
          $imageEl.removeAttr('data-background');
        } else {
          if (srcset) {
            $imageEl.attr('srcset', srcset);
            $imageEl.removeAttr('data-srcset');
          }

          if (sizes) {
            $imageEl.attr('sizes', sizes);
            $imageEl.removeAttr('data-sizes');
          }

          if ($pictureEl.length) {
            $pictureEl.children('source').each(function (sourceIndex, sourceEl) {
              var $source = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(sourceEl);

              if ($source.attr('data-srcset')) {
                $source.attr('srcset', $source.attr('data-srcset'));
                $source.removeAttr('data-srcset');
              }
            });
          }

          if (src) {
            $imageEl.attr('src', src);
            $imageEl.removeAttr('data-src');
          }
        }

        $imageEl.addClass(params.loadedClass).removeClass(params.loadingClass);
        $slideEl.find(".".concat(params.preloaderClass)).remove();

        if (swiper.params.loop && loadInDuplicate) {
          var slideOriginalIndex = $slideEl.attr('data-swiper-slide-index');

          if ($slideEl.hasClass(swiper.params.slideDuplicateClass)) {
            var originalSlide = swiper.$wrapperEl.children("[data-swiper-slide-index=\"".concat(slideOriginalIndex, "\"]:not(.").concat(swiper.params.slideDuplicateClass, ")"));
            swiper.lazy.loadInSlide(originalSlide.index(), false);
          } else {
            var duplicatedSlide = swiper.$wrapperEl.children(".".concat(swiper.params.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(slideOriginalIndex, "\"]"));
            swiper.lazy.loadInSlide(duplicatedSlide.index(), false);
          }
        }

        swiper.emit('lazyImageReady', $slideEl[0], $imageEl[0]);

        if (swiper.params.autoHeight) {
          swiper.updateAutoHeight();
        }
      });
      swiper.emit('lazyImageLoad', $slideEl[0], $imageEl[0]);
    });
  },
  load: function load() {
    var swiper = this;
    var $wrapperEl = swiper.$wrapperEl,
        swiperParams = swiper.params,
        slides = swiper.slides,
        activeIndex = swiper.activeIndex;
    var isVirtual = swiper.virtual && swiperParams.virtual.enabled;
    var params = swiperParams.lazy;
    var slidesPerView = swiperParams.slidesPerView;

    if (slidesPerView === 'auto') {
      slidesPerView = 0;
    }

    function slideExist(index) {
      if (isVirtual) {
        if ($wrapperEl.children(".".concat(swiperParams.slideClass, "[data-swiper-slide-index=\"").concat(index, "\"]")).length) {
          return true;
        }
      } else if (slides[index]) return true;

      return false;
    }

    function slideIndex(slideEl) {
      if (isVirtual) {
        return Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slideEl).attr('data-swiper-slide-index');
      }

      return Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slideEl).index();
    }

    if (!swiper.lazy.initialImageLoaded) swiper.lazy.initialImageLoaded = true;

    if (swiper.params.watchSlidesVisibility) {
      $wrapperEl.children(".".concat(swiperParams.slideVisibleClass)).each(function (elIndex, slideEl) {
        var index = isVirtual ? Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slideEl).attr('data-swiper-slide-index') : Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(slideEl).index();
        swiper.lazy.loadInSlide(index);
      });
    } else if (slidesPerView > 1) {
      for (var i = activeIndex; i < activeIndex + slidesPerView; i += 1) {
        if (slideExist(i)) swiper.lazy.loadInSlide(i);
      }
    } else {
      swiper.lazy.loadInSlide(activeIndex);
    }

    if (params.loadPrevNext) {
      if (slidesPerView > 1 || params.loadPrevNextAmount && params.loadPrevNextAmount > 1) {
        var amount = params.loadPrevNextAmount;
        var spv = slidesPerView;
        var maxIndex = Math.min(activeIndex + spv + Math.max(amount, spv), slides.length);
        var minIndex = Math.max(activeIndex - Math.max(spv, amount), 0); // Next Slides

        for (var _i11 = activeIndex + slidesPerView; _i11 < maxIndex; _i11 += 1) {
          if (slideExist(_i11)) swiper.lazy.loadInSlide(_i11);
        } // Prev Slides


        for (var _i12 = minIndex; _i12 < activeIndex; _i12 += 1) {
          if (slideExist(_i12)) swiper.lazy.loadInSlide(_i12);
        }
      } else {
        var nextSlide = $wrapperEl.children(".".concat(swiperParams.slideNextClass));
        if (nextSlide.length > 0) swiper.lazy.loadInSlide(slideIndex(nextSlide));
        var prevSlide = $wrapperEl.children(".".concat(swiperParams.slidePrevClass));
        if (prevSlide.length > 0) swiper.lazy.loadInSlide(slideIndex(prevSlide));
      }
    }
  }
};
var Lazy$1 = {
  name: 'lazy',
  params: {
    lazy: {
      enabled: false,
      loadPrevNext: false,
      loadPrevNextAmount: 1,
      loadOnTransitionStart: false,
      elementClass: 'swiper-lazy',
      loadingClass: 'swiper-lazy-loading',
      loadedClass: 'swiper-lazy-loaded',
      preloaderClass: 'swiper-lazy-preloader'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      lazy: {
        initialImageLoaded: false,
        load: Lazy.load.bind(swiper),
        loadInSlide: Lazy.loadInSlide.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;

      if (swiper.params.lazy.enabled && swiper.params.preloadImages) {
        swiper.params.preloadImages = false;
      }
    },
    init: function init() {
      var swiper = this;

      if (swiper.params.lazy.enabled && !swiper.params.loop && swiper.params.initialSlide === 0) {
        swiper.lazy.load();
      }
    },
    scroll: function scroll() {
      var swiper = this;

      if (swiper.params.freeMode && !swiper.params.freeModeSticky) {
        swiper.lazy.load();
      }
    },
    resize: function resize() {
      var swiper = this;

      if (swiper.params.lazy.enabled) {
        swiper.lazy.load();
      }
    },
    scrollbarDragMove: function scrollbarDragMove() {
      var swiper = this;

      if (swiper.params.lazy.enabled) {
        swiper.lazy.load();
      }
    },
    transitionStart: function transitionStart() {
      var swiper = this;

      if (swiper.params.lazy.enabled) {
        if (swiper.params.lazy.loadOnTransitionStart || !swiper.params.lazy.loadOnTransitionStart && !swiper.lazy.initialImageLoaded) {
          swiper.lazy.load();
        }
      }
    },
    transitionEnd: function transitionEnd() {
      var swiper = this;

      if (swiper.params.lazy.enabled && !swiper.params.lazy.loadOnTransitionStart) {
        swiper.lazy.load();
      }
    },
    slideChange: function slideChange() {
      var swiper = this;

      if (swiper.params.lazy.enabled && swiper.params.cssMode) {
        swiper.lazy.load();
      }
    }
  }
};
/* eslint no-bitwise: ["error", { "allow": [">>"] }] */

var Controller = {
  LinearSpline: function LinearSpline(x, y) {
    var binarySearch = function search() {
      var maxIndex;
      var minIndex;
      var guess;
      return function (array, val) {
        minIndex = -1;
        maxIndex = array.length;

        while (maxIndex - minIndex > 1) {
          guess = maxIndex + minIndex >> 1;

          if (array[guess] <= val) {
            minIndex = guess;
          } else {
            maxIndex = guess;
          }
        }

        return maxIndex;
      };
    }();

    this.x = x;
    this.y = y;
    this.lastIndex = x.length - 1; // Given an x value (x2), return the expected y2 value:
    // (x1,y1) is the known point before given value,
    // (x3,y3) is the known point after given value.

    var i1;
    var i3;

    this.interpolate = function interpolate(x2) {
      if (!x2) return 0; // Get the indexes of x1 and x3 (the array indexes before and after given x2):

      i3 = binarySearch(this.x, x2);
      i1 = i3 - 1; // We have our indexes i1 & i3, so we can calculate already:
      // y2 := ((x2−x1) × (y3−y1)) ÷ (x3−x1) + y1

      return (x2 - this.x[i1]) * (this.y[i3] - this.y[i1]) / (this.x[i3] - this.x[i1]) + this.y[i1];
    };

    return this;
  },
  // xxx: for now i will just save one spline function to to
  getInterpolateFunction: function getInterpolateFunction(c) {
    var swiper = this;

    if (!swiper.controller.spline) {
      swiper.controller.spline = swiper.params.loop ? new Controller.LinearSpline(swiper.slidesGrid, c.slidesGrid) : new Controller.LinearSpline(swiper.snapGrid, c.snapGrid);
    }
  },
  setTranslate: function setTranslate(_setTranslate, byController) {
    var swiper = this;
    var controlled = swiper.controller.control;
    var multiplier;
    var controlledTranslate;

    function setControlledTranslate(c) {
      // this will create an Interpolate function based on the snapGrids
      // x is the Grid of the scrolled scroller and y will be the controlled scroller
      // it makes sense to create this only once and recall it for the interpolation
      // the function does a lot of value caching for performance
      var translate = swiper.rtlTranslate ? -swiper.translate : swiper.translate;

      if (swiper.params.controller.by === 'slide') {
        swiper.controller.getInterpolateFunction(c); // i am not sure why the values have to be multiplicated this way, tried to invert the snapGrid
        // but it did not work out

        controlledTranslate = -swiper.controller.spline.interpolate(-translate);
      }

      if (!controlledTranslate || swiper.params.controller.by === 'container') {
        multiplier = (c.maxTranslate() - c.minTranslate()) / (swiper.maxTranslate() - swiper.minTranslate());
        controlledTranslate = (translate - swiper.minTranslate()) * multiplier + c.minTranslate();
      }

      if (swiper.params.controller.inverse) {
        controlledTranslate = c.maxTranslate() - controlledTranslate;
      }

      c.updateProgress(controlledTranslate);
      c.setTranslate(controlledTranslate, swiper);
      c.updateActiveIndex();
      c.updateSlidesClasses();
    }

    if (Array.isArray(controlled)) {
      for (var i = 0; i < controlled.length; i += 1) {
        if (controlled[i] !== byController && controlled[i] instanceof Swiper) {
          setControlledTranslate(controlled[i]);
        }
      }
    } else if (controlled instanceof Swiper && byController !== controlled) {
      setControlledTranslate(controlled);
    }
  },
  setTransition: function setTransition(duration, byController) {
    var swiper = this;
    var controlled = swiper.controller.control;
    var i;

    function setControlledTransition(c) {
      c.setTransition(duration, swiper);

      if (duration !== 0) {
        c.transitionStart();

        if (c.params.autoHeight) {
          Utils.nextTick(function () {
            c.updateAutoHeight();
          });
        }

        c.$wrapperEl.transitionEnd(function () {
          if (!controlled) return;

          if (c.params.loop && swiper.params.controller.by === 'slide') {
            c.loopFix();
          }

          c.transitionEnd();
        });
      }
    }

    if (Array.isArray(controlled)) {
      for (i = 0; i < controlled.length; i += 1) {
        if (controlled[i] !== byController && controlled[i] instanceof Swiper) {
          setControlledTransition(controlled[i]);
        }
      }
    } else if (controlled instanceof Swiper && byController !== controlled) {
      setControlledTransition(controlled);
    }
  }
};
var Controller$1 = {
  name: 'controller',
  params: {
    controller: {
      control: undefined,
      inverse: false,
      by: 'slide' // or 'container'

    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      controller: {
        control: swiper.params.controller.control,
        getInterpolateFunction: Controller.getInterpolateFunction.bind(swiper),
        setTranslate: Controller.setTranslate.bind(swiper),
        setTransition: Controller.setTransition.bind(swiper)
      }
    });
  },
  on: {
    update: function update() {
      var swiper = this;
      if (!swiper.controller.control) return;

      if (swiper.controller.spline) {
        swiper.controller.spline = undefined;
        delete swiper.controller.spline;
      }
    },
    resize: function resize() {
      var swiper = this;
      if (!swiper.controller.control) return;

      if (swiper.controller.spline) {
        swiper.controller.spline = undefined;
        delete swiper.controller.spline;
      }
    },
    observerUpdate: function observerUpdate() {
      var swiper = this;
      if (!swiper.controller.control) return;

      if (swiper.controller.spline) {
        swiper.controller.spline = undefined;
        delete swiper.controller.spline;
      }
    },
    setTranslate: function setTranslate(translate, byController) {
      var swiper = this;
      if (!swiper.controller.control) return;
      swiper.controller.setTranslate(translate, byController);
    },
    setTransition: function setTransition(duration, byController) {
      var swiper = this;
      if (!swiper.controller.control) return;
      swiper.controller.setTransition(duration, byController);
    }
  }
};
var a11y = {
  makeElFocusable: function makeElFocusable($el) {
    $el.attr('tabIndex', '0');
    return $el;
  },
  makeElNotFocusable: function makeElNotFocusable($el) {
    $el.attr('tabIndex', '-1');
    return $el;
  },
  addElRole: function addElRole($el, role) {
    $el.attr('role', role);
    return $el;
  },
  addElLabel: function addElLabel($el, label) {
    $el.attr('aria-label', label);
    return $el;
  },
  disableEl: function disableEl($el) {
    $el.attr('aria-disabled', true);
    return $el;
  },
  enableEl: function enableEl($el) {
    $el.attr('aria-disabled', false);
    return $el;
  },
  onEnterKey: function onEnterKey(e) {
    var swiper = this;
    var params = swiper.params.a11y;
    if (e.keyCode !== 13) return;
    var $targetEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(e.target);

    if (swiper.navigation && swiper.navigation.$nextEl && $targetEl.is(swiper.navigation.$nextEl)) {
      if (!(swiper.isEnd && !swiper.params.loop)) {
        swiper.slideNext();
      }

      if (swiper.isEnd) {
        swiper.a11y.notify(params.lastSlideMessage);
      } else {
        swiper.a11y.notify(params.nextSlideMessage);
      }
    }

    if (swiper.navigation && swiper.navigation.$prevEl && $targetEl.is(swiper.navigation.$prevEl)) {
      if (!(swiper.isBeginning && !swiper.params.loop)) {
        swiper.slidePrev();
      }

      if (swiper.isBeginning) {
        swiper.a11y.notify(params.firstSlideMessage);
      } else {
        swiper.a11y.notify(params.prevSlideMessage);
      }
    }

    if (swiper.pagination && $targetEl.is(".".concat(swiper.params.pagination.bulletClass))) {
      $targetEl[0].click();
    }
  },
  notify: function notify(message) {
    var swiper = this;
    var notification = swiper.a11y.liveRegion;
    if (notification.length === 0) return;
    notification.html('');
    notification.html(message);
  },
  updateNavigation: function updateNavigation() {
    var swiper = this;
    if (swiper.params.loop || !swiper.navigation) return;
    var _swiper$navigation4 = swiper.navigation,
        $nextEl = _swiper$navigation4.$nextEl,
        $prevEl = _swiper$navigation4.$prevEl;

    if ($prevEl && $prevEl.length > 0) {
      if (swiper.isBeginning) {
        swiper.a11y.disableEl($prevEl);
        swiper.a11y.makeElNotFocusable($prevEl);
      } else {
        swiper.a11y.enableEl($prevEl);
        swiper.a11y.makeElFocusable($prevEl);
      }
    }

    if ($nextEl && $nextEl.length > 0) {
      if (swiper.isEnd) {
        swiper.a11y.disableEl($nextEl);
        swiper.a11y.makeElNotFocusable($nextEl);
      } else {
        swiper.a11y.enableEl($nextEl);
        swiper.a11y.makeElFocusable($nextEl);
      }
    }
  },
  updatePagination: function updatePagination() {
    var swiper = this;
    var params = swiper.params.a11y;

    if (swiper.pagination && swiper.params.pagination.clickable && swiper.pagination.bullets && swiper.pagination.bullets.length) {
      swiper.pagination.bullets.each(function (bulletIndex, bulletEl) {
        var $bulletEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(bulletEl);
        swiper.a11y.makeElFocusable($bulletEl);
        swiper.a11y.addElRole($bulletEl, 'button');
        swiper.a11y.addElLabel($bulletEl, params.paginationBulletMessage.replace(/\{\{index\}\}/, $bulletEl.index() + 1));
      });
    }
  },
  init: function init() {
    var swiper = this;
    swiper.$el.append(swiper.a11y.liveRegion); // Navigation

    var params = swiper.params.a11y;
    var $nextEl;
    var $prevEl;

    if (swiper.navigation && swiper.navigation.$nextEl) {
      $nextEl = swiper.navigation.$nextEl;
    }

    if (swiper.navigation && swiper.navigation.$prevEl) {
      $prevEl = swiper.navigation.$prevEl;
    }

    if ($nextEl) {
      swiper.a11y.makeElFocusable($nextEl);
      swiper.a11y.addElRole($nextEl, 'button');
      swiper.a11y.addElLabel($nextEl, params.nextSlideMessage);
      $nextEl.on('keydown', swiper.a11y.onEnterKey);
    }

    if ($prevEl) {
      swiper.a11y.makeElFocusable($prevEl);
      swiper.a11y.addElRole($prevEl, 'button');
      swiper.a11y.addElLabel($prevEl, params.prevSlideMessage);
      $prevEl.on('keydown', swiper.a11y.onEnterKey);
    } // Pagination


    if (swiper.pagination && swiper.params.pagination.clickable && swiper.pagination.bullets && swiper.pagination.bullets.length) {
      swiper.pagination.$el.on('keydown', ".".concat(swiper.params.pagination.bulletClass), swiper.a11y.onEnterKey);
    }
  },
  destroy: function destroy() {
    var swiper = this;
    if (swiper.a11y.liveRegion && swiper.a11y.liveRegion.length > 0) swiper.a11y.liveRegion.remove();
    var $nextEl;
    var $prevEl;

    if (swiper.navigation && swiper.navigation.$nextEl) {
      $nextEl = swiper.navigation.$nextEl;
    }

    if (swiper.navigation && swiper.navigation.$prevEl) {
      $prevEl = swiper.navigation.$prevEl;
    }

    if ($nextEl) {
      $nextEl.off('keydown', swiper.a11y.onEnterKey);
    }

    if ($prevEl) {
      $prevEl.off('keydown', swiper.a11y.onEnterKey);
    } // Pagination


    if (swiper.pagination && swiper.params.pagination.clickable && swiper.pagination.bullets && swiper.pagination.bullets.length) {
      swiper.pagination.$el.off('keydown', ".".concat(swiper.params.pagination.bulletClass), swiper.a11y.onEnterKey);
    }
  }
};
var A11y = {
  name: 'a11y',
  params: {
    a11y: {
      enabled: true,
      notificationClass: 'swiper-notification',
      prevSlideMessage: 'Previous slide',
      nextSlideMessage: 'Next slide',
      firstSlideMessage: 'This is the first slide',
      lastSlideMessage: 'This is the last slide',
      paginationBulletMessage: 'Go to slide {{index}}'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      a11y: {
        liveRegion: Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<span class=\"".concat(swiper.params.a11y.notificationClass, "\" aria-live=\"assertive\" aria-atomic=\"true\"></span>"))
      }
    });
    Object.keys(a11y).forEach(function (methodName) {
      swiper.a11y[methodName] = a11y[methodName].bind(swiper);
    });
  },
  on: {
    init: function init() {
      var swiper = this;
      if (!swiper.params.a11y.enabled) return;
      swiper.a11y.init();
      swiper.a11y.updateNavigation();
    },
    toEdge: function toEdge() {
      var swiper = this;
      if (!swiper.params.a11y.enabled) return;
      swiper.a11y.updateNavigation();
    },
    fromEdge: function fromEdge() {
      var swiper = this;
      if (!swiper.params.a11y.enabled) return;
      swiper.a11y.updateNavigation();
    },
    paginationUpdate: function paginationUpdate() {
      var swiper = this;
      if (!swiper.params.a11y.enabled) return;
      swiper.a11y.updatePagination();
    },
    destroy: function destroy() {
      var swiper = this;
      if (!swiper.params.a11y.enabled) return;
      swiper.a11y.destroy();
    }
  }
};
var History = {
  init: function init() {
    var swiper = this;
    if (!swiper.params.history) return;

    if (!ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history || !ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history.pushState) {
      swiper.params.history.enabled = false;
      swiper.params.hashNavigation.enabled = true;
      return;
    }

    var history = swiper.history;
    history.initialized = true;
    history.paths = History.getPathValues();
    if (!history.paths.key && !history.paths.value) return;
    history.scrollToSlide(0, history.paths.value, swiper.params.runCallbacksOnInit);

    if (!swiper.params.history.replaceState) {
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].addEventListener('popstate', swiper.history.setHistoryPopState);
    }
  },
  destroy: function destroy() {
    var swiper = this;

    if (!swiper.params.history.replaceState) {
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].removeEventListener('popstate', swiper.history.setHistoryPopState);
    }
  },
  setHistoryPopState: function setHistoryPopState() {
    var swiper = this;
    swiper.history.paths = History.getPathValues();
    swiper.history.scrollToSlide(swiper.params.speed, swiper.history.paths.value, false);
  },
  getPathValues: function getPathValues() {
    var pathArray = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].location.pathname.slice(1).split('/').filter(function (part) {
      return part !== '';
    });
    var total = pathArray.length;
    var key = pathArray[total - 2];
    var value = pathArray[total - 1];
    return {
      key: key,
      value: value
    };
  },
  setHistory: function setHistory(key, index) {
    var swiper = this;
    if (!swiper.history.initialized || !swiper.params.history.enabled) return;
    var slide = swiper.slides.eq(index);
    var value = History.slugify(slide.attr('data-history'));

    if (!ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].location.pathname.includes(key)) {
      value = "".concat(key, "/").concat(value);
    }

    var currentState = ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history.state;

    if (currentState && currentState.value === value) {
      return;
    }

    if (swiper.params.history.replaceState) {
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history.replaceState({
        value: value
      }, null, value);
    } else {
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history.pushState({
        value: value
      }, null, value);
    }
  },
  slugify: function slugify(text) {
    return text.toString().replace(/\s+/g, '-').replace(/[^\w-]+/g, '').replace(/--+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
  },
  scrollToSlide: function scrollToSlide(speed, value, runCallbacks) {
    var swiper = this;

    if (value) {
      for (var i = 0, length = swiper.slides.length; i < length; i += 1) {
        var _slide3 = swiper.slides.eq(i);

        var slideHistory = History.slugify(_slide3.attr('data-history'));

        if (slideHistory === value && !_slide3.hasClass(swiper.params.slideDuplicateClass)) {
          var _index2 = _slide3.index();

          swiper.slideTo(_index2, speed, runCallbacks);
        }
      }
    } else {
      swiper.slideTo(0, speed, runCallbacks);
    }
  }
};
var History$1 = {
  name: 'history',
  params: {
    history: {
      enabled: false,
      replaceState: false,
      key: 'slides'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      history: {
        init: History.init.bind(swiper),
        setHistory: History.setHistory.bind(swiper),
        setHistoryPopState: History.setHistoryPopState.bind(swiper),
        scrollToSlide: History.scrollToSlide.bind(swiper),
        destroy: History.destroy.bind(swiper)
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;

      if (swiper.params.history.enabled) {
        swiper.history.init();
      }
    },
    destroy: function destroy() {
      var swiper = this;

      if (swiper.params.history.enabled) {
        swiper.history.destroy();
      }
    },
    transitionEnd: function transitionEnd() {
      var swiper = this;

      if (swiper.history.initialized) {
        swiper.history.setHistory(swiper.params.history.key, swiper.activeIndex);
      }
    },
    slideChange: function slideChange() {
      var swiper = this;

      if (swiper.history.initialized && swiper.params.cssMode) {
        swiper.history.setHistory(swiper.params.history.key, swiper.activeIndex);
      }
    }
  }
};
var HashNavigation = {
  onHashCange: function onHashCange() {
    var swiper = this;
    swiper.emit('hashChange');
    var newHash = ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].location.hash.replace('#', '');
    var activeSlideHash = swiper.slides.eq(swiper.activeIndex).attr('data-hash');

    if (newHash !== activeSlideHash) {
      var newIndex = swiper.$wrapperEl.children(".".concat(swiper.params.slideClass, "[data-hash=\"").concat(newHash, "\"]")).index();
      if (typeof newIndex === 'undefined') return;
      swiper.slideTo(newIndex);
    }
  },
  setHash: function setHash() {
    var swiper = this;
    if (!swiper.hashNavigation.initialized || !swiper.params.hashNavigation.enabled) return;

    if (swiper.params.hashNavigation.replaceState && ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history && ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history.replaceState) {
      ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"].history.replaceState(null, null, "#".concat(swiper.slides.eq(swiper.activeIndex).attr('data-hash')) || false);
      swiper.emit('hashSet');
    } else {
      var _slide4 = swiper.slides.eq(swiper.activeIndex);

      var hash = _slide4.attr('data-hash') || _slide4.attr('data-history');

      ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].location.hash = hash || '';
      swiper.emit('hashSet');
    }
  },
  init: function init() {
    var swiper = this;
    if (!swiper.params.hashNavigation.enabled || swiper.params.history && swiper.params.history.enabled) return;
    swiper.hashNavigation.initialized = true;
    var hash = ssr_window__WEBPACK_IMPORTED_MODULE_1__["document"].location.hash.replace('#', '');

    if (hash) {
      var speed = 0;

      for (var i = 0, length = swiper.slides.length; i < length; i += 1) {
        var _slide5 = swiper.slides.eq(i);

        var slideHash = _slide5.attr('data-hash') || _slide5.attr('data-history');

        if (slideHash === hash && !_slide5.hasClass(swiper.params.slideDuplicateClass)) {
          var _index3 = _slide5.index();

          swiper.slideTo(_index3, speed, swiper.params.runCallbacksOnInit, true);
        }
      }
    }

    if (swiper.params.hashNavigation.watchState) {
      Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"]).on('hashchange', swiper.hashNavigation.onHashCange);
    }
  },
  destroy: function destroy() {
    var swiper = this;

    if (swiper.params.hashNavigation.watchState) {
      Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(ssr_window__WEBPACK_IMPORTED_MODULE_1__["window"]).off('hashchange', swiper.hashNavigation.onHashCange);
    }
  }
};
var HashNavigation$1 = {
  name: 'hash-navigation',
  params: {
    hashNavigation: {
      enabled: false,
      replaceState: false,
      watchState: false
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      hashNavigation: {
        initialized: false,
        init: HashNavigation.init.bind(swiper),
        destroy: HashNavigation.destroy.bind(swiper),
        setHash: HashNavigation.setHash.bind(swiper),
        onHashCange: HashNavigation.onHashCange.bind(swiper)
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;

      if (swiper.params.hashNavigation.enabled) {
        swiper.hashNavigation.init();
      }
    },
    destroy: function destroy() {
      var swiper = this;

      if (swiper.params.hashNavigation.enabled) {
        swiper.hashNavigation.destroy();
      }
    },
    transitionEnd: function transitionEnd() {
      var swiper = this;

      if (swiper.hashNavigation.initialized) {
        swiper.hashNavigation.setHash();
      }
    },
    slideChange: function slideChange() {
      var swiper = this;

      if (swiper.hashNavigation.initialized && swiper.params.cssMode) {
        swiper.hashNavigation.setHash();
      }
    }
  }
};
/* eslint no-underscore-dangle: "off" */

var Autoplay = {
  run: function run() {
    var swiper = this;
    var $activeSlideEl = swiper.slides.eq(swiper.activeIndex);
    var delay = swiper.params.autoplay.delay;

    if ($activeSlideEl.attr('data-swiper-autoplay')) {
      delay = $activeSlideEl.attr('data-swiper-autoplay') || swiper.params.autoplay.delay;
    }

    clearTimeout(swiper.autoplay.timeout);
    swiper.autoplay.timeout = Utils.nextTick(function () {
      if (swiper.params.autoplay.reverseDirection) {
        if (swiper.params.loop) {
          swiper.loopFix();
          swiper.slidePrev(swiper.params.speed, true, true);
          swiper.emit('autoplay');
        } else if (!swiper.isBeginning) {
          swiper.slidePrev(swiper.params.speed, true, true);
          swiper.emit('autoplay');
        } else if (!swiper.params.autoplay.stopOnLastSlide) {
          swiper.slideTo(swiper.slides.length - 1, swiper.params.speed, true, true);
          swiper.emit('autoplay');
        } else {
          swiper.autoplay.stop();
        }
      } else if (swiper.params.loop) {
        swiper.loopFix();
        swiper.slideNext(swiper.params.speed, true, true);
        swiper.emit('autoplay');
      } else if (!swiper.isEnd) {
        swiper.slideNext(swiper.params.speed, true, true);
        swiper.emit('autoplay');
      } else if (!swiper.params.autoplay.stopOnLastSlide) {
        swiper.slideTo(0, swiper.params.speed, true, true);
        swiper.emit('autoplay');
      } else {
        swiper.autoplay.stop();
      }

      if (swiper.params.cssMode && swiper.autoplay.running) swiper.autoplay.run();
    }, delay);
  },
  start: function start() {
    var swiper = this;
    if (typeof swiper.autoplay.timeout !== 'undefined') return false;
    if (swiper.autoplay.running) return false;
    swiper.autoplay.running = true;
    swiper.emit('autoplayStart');
    swiper.autoplay.run();
    return true;
  },
  stop: function stop() {
    var swiper = this;
    if (!swiper.autoplay.running) return false;
    if (typeof swiper.autoplay.timeout === 'undefined') return false;

    if (swiper.autoplay.timeout) {
      clearTimeout(swiper.autoplay.timeout);
      swiper.autoplay.timeout = undefined;
    }

    swiper.autoplay.running = false;
    swiper.emit('autoplayStop');
    return true;
  },
  pause: function pause(speed) {
    var swiper = this;
    if (!swiper.autoplay.running) return;
    if (swiper.autoplay.paused) return;
    if (swiper.autoplay.timeout) clearTimeout(swiper.autoplay.timeout);
    swiper.autoplay.paused = true;

    if (speed === 0 || !swiper.params.autoplay.waitForTransition) {
      swiper.autoplay.paused = false;
      swiper.autoplay.run();
    } else {
      swiper.$wrapperEl[0].addEventListener('transitionend', swiper.autoplay.onTransitionEnd);
      swiper.$wrapperEl[0].addEventListener('webkitTransitionEnd', swiper.autoplay.onTransitionEnd);
    }
  }
};
var Autoplay$1 = {
  name: 'autoplay',
  params: {
    autoplay: {
      enabled: false,
      delay: 3000,
      waitForTransition: true,
      disableOnInteraction: true,
      stopOnLastSlide: false,
      reverseDirection: false
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      autoplay: {
        running: false,
        paused: false,
        run: Autoplay.run.bind(swiper),
        start: Autoplay.start.bind(swiper),
        stop: Autoplay.stop.bind(swiper),
        pause: Autoplay.pause.bind(swiper),
        onVisibilityChange: function onVisibilityChange() {
          if (document.visibilityState === 'hidden' && swiper.autoplay.running) {
            swiper.autoplay.pause();
          }

          if (document.visibilityState === 'visible' && swiper.autoplay.paused) {
            swiper.autoplay.run();
            swiper.autoplay.paused = false;
          }
        },
        onTransitionEnd: function onTransitionEnd(e) {
          if (!swiper || swiper.destroyed || !swiper.$wrapperEl) return;
          if (e.target !== this) return;
          swiper.$wrapperEl[0].removeEventListener('transitionend', swiper.autoplay.onTransitionEnd);
          swiper.$wrapperEl[0].removeEventListener('webkitTransitionEnd', swiper.autoplay.onTransitionEnd);
          swiper.autoplay.paused = false;

          if (!swiper.autoplay.running) {
            swiper.autoplay.stop();
          } else {
            swiper.autoplay.run();
          }
        }
      }
    });
  },
  on: {
    init: function init() {
      var swiper = this;

      if (swiper.params.autoplay.enabled) {
        swiper.autoplay.start();
        document.addEventListener('visibilitychange', swiper.autoplay.onVisibilityChange);
      }
    },
    beforeTransitionStart: function beforeTransitionStart(speed, internal) {
      var swiper = this;

      if (swiper.autoplay.running) {
        if (internal || !swiper.params.autoplay.disableOnInteraction) {
          swiper.autoplay.pause(speed);
        } else {
          swiper.autoplay.stop();
        }
      }
    },
    sliderFirstMove: function sliderFirstMove() {
      var swiper = this;

      if (swiper.autoplay.running) {
        if (swiper.params.autoplay.disableOnInteraction) {
          swiper.autoplay.stop();
        } else {
          swiper.autoplay.pause();
        }
      }
    },
    touchEnd: function touchEnd() {
      var swiper = this;

      if (swiper.params.cssMode && swiper.autoplay.paused && !swiper.params.autoplay.disableOnInteraction) {
        swiper.autoplay.run();
      }
    },
    destroy: function destroy() {
      var swiper = this;

      if (swiper.autoplay.running) {
        swiper.autoplay.stop();
      }

      document.removeEventListener('visibilitychange', swiper.autoplay.onVisibilityChange);
    }
  }
};
var Fade = {
  setTranslate: function setTranslate() {
    var swiper = this;
    var slides = swiper.slides;

    for (var i = 0; i < slides.length; i += 1) {
      var $slideEl = swiper.slides.eq(i);
      var _offset = $slideEl[0].swiperSlideOffset;
      var tx = -_offset;
      if (!swiper.params.virtualTranslate) tx -= swiper.translate;
      var ty = 0;

      if (!swiper.isHorizontal()) {
        ty = tx;
        tx = 0;
      }

      var slideOpacity = swiper.params.fadeEffect.crossFade ? Math.max(1 - Math.abs($slideEl[0].progress), 0) : 1 + Math.min(Math.max($slideEl[0].progress, -1), 0);
      $slideEl.css({
        opacity: slideOpacity
      }).transform("translate3d(".concat(tx, "px, ").concat(ty, "px, 0px)"));
    }
  },
  setTransition: function setTransition(duration) {
    var swiper = this;
    var slides = swiper.slides,
        $wrapperEl = swiper.$wrapperEl;
    slides.transition(duration);

    if (swiper.params.virtualTranslate && duration !== 0) {
      var eventTriggered = false;
      slides.transitionEnd(function () {
        if (eventTriggered) return;
        if (!swiper || swiper.destroyed) return;
        eventTriggered = true;
        swiper.animating = false;
        var triggerEvents = ['webkitTransitionEnd', 'transitionend'];

        for (var i = 0; i < triggerEvents.length; i += 1) {
          $wrapperEl.trigger(triggerEvents[i]);
        }
      });
    }
  }
};
var EffectFade = {
  name: 'effect-fade',
  params: {
    fadeEffect: {
      crossFade: false
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      fadeEffect: {
        setTranslate: Fade.setTranslate.bind(swiper),
        setTransition: Fade.setTransition.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      if (swiper.params.effect !== 'fade') return;
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "fade"));
      var overwriteParams = {
        slidesPerView: 1,
        slidesPerColumn: 1,
        slidesPerGroup: 1,
        watchSlidesProgress: true,
        spaceBetween: 0,
        virtualTranslate: true
      };
      Utils.extend(swiper.params, overwriteParams);
      Utils.extend(swiper.originalParams, overwriteParams);
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      if (swiper.params.effect !== 'fade') return;
      swiper.fadeEffect.setTranslate();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      if (swiper.params.effect !== 'fade') return;
      swiper.fadeEffect.setTransition(duration);
    }
  }
};
var Cube = {
  setTranslate: function setTranslate() {
    var swiper = this;
    var $el = swiper.$el,
        $wrapperEl = swiper.$wrapperEl,
        slides = swiper.slides,
        swiperWidth = swiper.width,
        swiperHeight = swiper.height,
        rtl = swiper.rtlTranslate,
        swiperSize = swiper.size;
    var params = swiper.params.cubeEffect;
    var isHorizontal = swiper.isHorizontal();
    var isVirtual = swiper.virtual && swiper.params.virtual.enabled;
    var wrapperRotate = 0;
    var $cubeShadowEl;

    if (params.shadow) {
      if (isHorizontal) {
        $cubeShadowEl = $wrapperEl.find('.swiper-cube-shadow');

        if ($cubeShadowEl.length === 0) {
          $cubeShadowEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])('<div class="swiper-cube-shadow"></div>');
          $wrapperEl.append($cubeShadowEl);
        }

        $cubeShadowEl.css({
          height: "".concat(swiperWidth, "px")
        });
      } else {
        $cubeShadowEl = $el.find('.swiper-cube-shadow');

        if ($cubeShadowEl.length === 0) {
          $cubeShadowEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])('<div class="swiper-cube-shadow"></div>');
          $el.append($cubeShadowEl);
        }
      }
    }

    for (var i = 0; i < slides.length; i += 1) {
      var $slideEl = slides.eq(i);
      var slideIndex = i;

      if (isVirtual) {
        slideIndex = parseInt($slideEl.attr('data-swiper-slide-index'), 10);
      }

      var slideAngle = slideIndex * 90;
      var round = Math.floor(slideAngle / 360);

      if (rtl) {
        slideAngle = -slideAngle;
        round = Math.floor(-slideAngle / 360);
      }

      var progress = Math.max(Math.min($slideEl[0].progress, 1), -1);
      var tx = 0;
      var ty = 0;
      var tz = 0;

      if (slideIndex % 4 === 0) {
        tx = -round * 4 * swiperSize;
        tz = 0;
      } else if ((slideIndex - 1) % 4 === 0) {
        tx = 0;
        tz = -round * 4 * swiperSize;
      } else if ((slideIndex - 2) % 4 === 0) {
        tx = swiperSize + round * 4 * swiperSize;
        tz = swiperSize;
      } else if ((slideIndex - 3) % 4 === 0) {
        tx = -swiperSize;
        tz = 3 * swiperSize + swiperSize * 4 * round;
      }

      if (rtl) {
        tx = -tx;
      }

      if (!isHorizontal) {
        ty = tx;
        tx = 0;
      }

      var _transform = "rotateX(".concat(isHorizontal ? 0 : -slideAngle, "deg) rotateY(").concat(isHorizontal ? slideAngle : 0, "deg) translate3d(").concat(tx, "px, ").concat(ty, "px, ").concat(tz, "px)");

      if (progress <= 1 && progress > -1) {
        wrapperRotate = slideIndex * 90 + progress * 90;
        if (rtl) wrapperRotate = -slideIndex * 90 - progress * 90;
      }

      $slideEl.transform(_transform);

      if (params.slideShadows) {
        // Set shadows
        var shadowBefore = isHorizontal ? $slideEl.find('.swiper-slide-shadow-left') : $slideEl.find('.swiper-slide-shadow-top');
        var shadowAfter = isHorizontal ? $slideEl.find('.swiper-slide-shadow-right') : $slideEl.find('.swiper-slide-shadow-bottom');

        if (shadowBefore.length === 0) {
          shadowBefore = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"swiper-slide-shadow-".concat(isHorizontal ? 'left' : 'top', "\"></div>"));
          $slideEl.append(shadowBefore);
        }

        if (shadowAfter.length === 0) {
          shadowAfter = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"swiper-slide-shadow-".concat(isHorizontal ? 'right' : 'bottom', "\"></div>"));
          $slideEl.append(shadowAfter);
        }

        if (shadowBefore.length) shadowBefore[0].style.opacity = Math.max(-progress, 0);
        if (shadowAfter.length) shadowAfter[0].style.opacity = Math.max(progress, 0);
      }
    }

    $wrapperEl.css({
      '-webkit-transform-origin': "50% 50% -".concat(swiperSize / 2, "px"),
      '-moz-transform-origin': "50% 50% -".concat(swiperSize / 2, "px"),
      '-ms-transform-origin': "50% 50% -".concat(swiperSize / 2, "px"),
      'transform-origin': "50% 50% -".concat(swiperSize / 2, "px")
    });

    if (params.shadow) {
      if (isHorizontal) {
        $cubeShadowEl.transform("translate3d(0px, ".concat(swiperWidth / 2 + params.shadowOffset, "px, ").concat(-swiperWidth / 2, "px) rotateX(90deg) rotateZ(0deg) scale(").concat(params.shadowScale, ")"));
      } else {
        var shadowAngle = Math.abs(wrapperRotate) - Math.floor(Math.abs(wrapperRotate) / 90) * 90;
        var multiplier = 1.5 - (Math.sin(shadowAngle * 2 * Math.PI / 360) / 2 + Math.cos(shadowAngle * 2 * Math.PI / 360) / 2);
        var scale1 = params.shadowScale;
        var scale2 = params.shadowScale / multiplier;
        var _offset2 = params.shadowOffset;
        $cubeShadowEl.transform("scale3d(".concat(scale1, ", 1, ").concat(scale2, ") translate3d(0px, ").concat(swiperHeight / 2 + _offset2, "px, ").concat(-swiperHeight / 2 / scale2, "px) rotateX(-90deg)"));
      }
    }

    var zFactor = Browser.isSafari || Browser.isWebView ? -swiperSize / 2 : 0;
    $wrapperEl.transform("translate3d(0px,0,".concat(zFactor, "px) rotateX(").concat(swiper.isHorizontal() ? 0 : wrapperRotate, "deg) rotateY(").concat(swiper.isHorizontal() ? -wrapperRotate : 0, "deg)"));
  },
  setTransition: function setTransition(duration) {
    var swiper = this;
    var $el = swiper.$el,
        slides = swiper.slides;
    slides.transition(duration).find('.swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left').transition(duration);

    if (swiper.params.cubeEffect.shadow && !swiper.isHorizontal()) {
      $el.find('.swiper-cube-shadow').transition(duration);
    }
  }
};
var EffectCube = {
  name: 'effect-cube',
  params: {
    cubeEffect: {
      slideShadows: true,
      shadow: true,
      shadowOffset: 20,
      shadowScale: 0.94
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      cubeEffect: {
        setTranslate: Cube.setTranslate.bind(swiper),
        setTransition: Cube.setTransition.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      if (swiper.params.effect !== 'cube') return;
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "cube"));
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "3d"));
      var overwriteParams = {
        slidesPerView: 1,
        slidesPerColumn: 1,
        slidesPerGroup: 1,
        watchSlidesProgress: true,
        resistanceRatio: 0,
        spaceBetween: 0,
        centeredSlides: false,
        virtualTranslate: true
      };
      Utils.extend(swiper.params, overwriteParams);
      Utils.extend(swiper.originalParams, overwriteParams);
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      if (swiper.params.effect !== 'cube') return;
      swiper.cubeEffect.setTranslate();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      if (swiper.params.effect !== 'cube') return;
      swiper.cubeEffect.setTransition(duration);
    }
  }
};
var Flip = {
  setTranslate: function setTranslate() {
    var swiper = this;
    var slides = swiper.slides,
        rtl = swiper.rtlTranslate;

    for (var i = 0; i < slides.length; i += 1) {
      var $slideEl = slides.eq(i);
      var progress = $slideEl[0].progress;

      if (swiper.params.flipEffect.limitRotation) {
        progress = Math.max(Math.min($slideEl[0].progress, 1), -1);
      }

      var _offset3 = $slideEl[0].swiperSlideOffset;
      var rotate = -180 * progress;
      var rotateY = rotate;
      var rotateX = 0;
      var tx = -_offset3;
      var ty = 0;

      if (!swiper.isHorizontal()) {
        ty = tx;
        tx = 0;
        rotateX = -rotateY;
        rotateY = 0;
      } else if (rtl) {
        rotateY = -rotateY;
      }

      $slideEl[0].style.zIndex = -Math.abs(Math.round(progress)) + slides.length;

      if (swiper.params.flipEffect.slideShadows) {
        // Set shadows
        var shadowBefore = swiper.isHorizontal() ? $slideEl.find('.swiper-slide-shadow-left') : $slideEl.find('.swiper-slide-shadow-top');
        var shadowAfter = swiper.isHorizontal() ? $slideEl.find('.swiper-slide-shadow-right') : $slideEl.find('.swiper-slide-shadow-bottom');

        if (shadowBefore.length === 0) {
          shadowBefore = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"swiper-slide-shadow-".concat(swiper.isHorizontal() ? 'left' : 'top', "\"></div>"));
          $slideEl.append(shadowBefore);
        }

        if (shadowAfter.length === 0) {
          shadowAfter = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"swiper-slide-shadow-".concat(swiper.isHorizontal() ? 'right' : 'bottom', "\"></div>"));
          $slideEl.append(shadowAfter);
        }

        if (shadowBefore.length) shadowBefore[0].style.opacity = Math.max(-progress, 0);
        if (shadowAfter.length) shadowAfter[0].style.opacity = Math.max(progress, 0);
      }

      $slideEl.transform("translate3d(".concat(tx, "px, ").concat(ty, "px, 0px) rotateX(").concat(rotateX, "deg) rotateY(").concat(rotateY, "deg)"));
    }
  },
  setTransition: function setTransition(duration) {
    var swiper = this;
    var slides = swiper.slides,
        activeIndex = swiper.activeIndex,
        $wrapperEl = swiper.$wrapperEl;
    slides.transition(duration).find('.swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left').transition(duration);

    if (swiper.params.virtualTranslate && duration !== 0) {
      var eventTriggered = false; // eslint-disable-next-line

      slides.eq(activeIndex).transitionEnd(function onTransitionEnd() {
        if (eventTriggered) return;
        if (!swiper || swiper.destroyed) return; // if (!$(this).hasClass(swiper.params.slideActiveClass)) return;

        eventTriggered = true;
        swiper.animating = false;
        var triggerEvents = ['webkitTransitionEnd', 'transitionend'];

        for (var i = 0; i < triggerEvents.length; i += 1) {
          $wrapperEl.trigger(triggerEvents[i]);
        }
      });
    }
  }
};
var EffectFlip = {
  name: 'effect-flip',
  params: {
    flipEffect: {
      slideShadows: true,
      limitRotation: true
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      flipEffect: {
        setTranslate: Flip.setTranslate.bind(swiper),
        setTransition: Flip.setTransition.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      if (swiper.params.effect !== 'flip') return;
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "flip"));
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "3d"));
      var overwriteParams = {
        slidesPerView: 1,
        slidesPerColumn: 1,
        slidesPerGroup: 1,
        watchSlidesProgress: true,
        spaceBetween: 0,
        virtualTranslate: true
      };
      Utils.extend(swiper.params, overwriteParams);
      Utils.extend(swiper.originalParams, overwriteParams);
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      if (swiper.params.effect !== 'flip') return;
      swiper.flipEffect.setTranslate();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      if (swiper.params.effect !== 'flip') return;
      swiper.flipEffect.setTransition(duration);
    }
  }
};
var Coverflow = {
  setTranslate: function setTranslate() {
    var swiper = this;
    var swiperWidth = swiper.width,
        swiperHeight = swiper.height,
        slides = swiper.slides,
        $wrapperEl = swiper.$wrapperEl,
        slidesSizesGrid = swiper.slidesSizesGrid;
    var params = swiper.params.coverflowEffect;
    var isHorizontal = swiper.isHorizontal();
    var transform = swiper.translate;
    var center = isHorizontal ? -transform + swiperWidth / 2 : -transform + swiperHeight / 2;
    var rotate = isHorizontal ? params.rotate : -params.rotate;
    var translate = params.depth; // Each slide offset from center

    for (var i = 0, length = slides.length; i < length; i += 1) {
      var $slideEl = slides.eq(i);
      var slideSize = slidesSizesGrid[i];
      var slideOffset = $slideEl[0].swiperSlideOffset;
      var offsetMultiplier = (center - slideOffset - slideSize / 2) / slideSize * params.modifier;
      var rotateY = isHorizontal ? rotate * offsetMultiplier : 0;
      var rotateX = isHorizontal ? 0 : rotate * offsetMultiplier; // var rotateZ = 0

      var translateZ = -translate * Math.abs(offsetMultiplier);
      var stretch = params.stretch; // Allow percentage to make a relative stretch for responsive sliders

      if (typeof stretch === 'string' && stretch.indexOf('%') !== -1) {
        stretch = parseFloat(params.stretch) / 100 * slideSize;
      }

      var translateY = isHorizontal ? 0 : stretch * offsetMultiplier;
      var translateX = isHorizontal ? stretch * offsetMultiplier : 0;
      var scale = 1 - (1 - params.scale) * Math.abs(offsetMultiplier); // Fix for ultra small values

      if (Math.abs(translateX) < 0.001) translateX = 0;
      if (Math.abs(translateY) < 0.001) translateY = 0;
      if (Math.abs(translateZ) < 0.001) translateZ = 0;
      if (Math.abs(rotateY) < 0.001) rotateY = 0;
      if (Math.abs(rotateX) < 0.001) rotateX = 0;
      if (Math.abs(scale) < 0.001) scale = 0;
      var slideTransform = "translate3d(".concat(translateX, "px,").concat(translateY, "px,").concat(translateZ, "px)  rotateX(").concat(rotateX, "deg) rotateY(").concat(rotateY, "deg) scale(").concat(scale, ")");
      $slideEl.transform(slideTransform);
      $slideEl[0].style.zIndex = -Math.abs(Math.round(offsetMultiplier)) + 1;

      if (params.slideShadows) {
        // Set shadows
        var $shadowBeforeEl = isHorizontal ? $slideEl.find('.swiper-slide-shadow-left') : $slideEl.find('.swiper-slide-shadow-top');
        var $shadowAfterEl = isHorizontal ? $slideEl.find('.swiper-slide-shadow-right') : $slideEl.find('.swiper-slide-shadow-bottom');

        if ($shadowBeforeEl.length === 0) {
          $shadowBeforeEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"swiper-slide-shadow-".concat(isHorizontal ? 'left' : 'top', "\"></div>"));
          $slideEl.append($shadowBeforeEl);
        }

        if ($shadowAfterEl.length === 0) {
          $shadowAfterEl = Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])("<div class=\"swiper-slide-shadow-".concat(isHorizontal ? 'right' : 'bottom', "\"></div>"));
          $slideEl.append($shadowAfterEl);
        }

        if ($shadowBeforeEl.length) $shadowBeforeEl[0].style.opacity = offsetMultiplier > 0 ? offsetMultiplier : 0;
        if ($shadowAfterEl.length) $shadowAfterEl[0].style.opacity = -offsetMultiplier > 0 ? -offsetMultiplier : 0;
      }
    } // Set correct perspective for IE10


    if (Support.pointerEvents || Support.prefixedPointerEvents) {
      var ws = $wrapperEl[0].style;
      ws.perspectiveOrigin = "".concat(center, "px 50%");
    }
  },
  setTransition: function setTransition(duration) {
    var swiper = this;
    swiper.slides.transition(duration).find('.swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left').transition(duration);
  }
};
var EffectCoverflow = {
  name: 'effect-coverflow',
  params: {
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      scale: 1,
      modifier: 1,
      slideShadows: true
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      coverflowEffect: {
        setTranslate: Coverflow.setTranslate.bind(swiper),
        setTransition: Coverflow.setTransition.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      if (swiper.params.effect !== 'coverflow') return;
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "coverflow"));
      swiper.classNames.push("".concat(swiper.params.containerModifierClass, "3d"));
      swiper.params.watchSlidesProgress = true;
      swiper.originalParams.watchSlidesProgress = true;
    },
    setTranslate: function setTranslate() {
      var swiper = this;
      if (swiper.params.effect !== 'coverflow') return;
      swiper.coverflowEffect.setTranslate();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      if (swiper.params.effect !== 'coverflow') return;
      swiper.coverflowEffect.setTransition(duration);
    }
  }
};
var Thumbs = {
  init: function init() {
    var swiper = this;
    var thumbsParams = swiper.params.thumbs;
    var SwiperClass = swiper.constructor;

    if (thumbsParams.swiper instanceof SwiperClass) {
      swiper.thumbs.swiper = thumbsParams.swiper;
      Utils.extend(swiper.thumbs.swiper.originalParams, {
        watchSlidesProgress: true,
        slideToClickedSlide: false
      });
      Utils.extend(swiper.thumbs.swiper.params, {
        watchSlidesProgress: true,
        slideToClickedSlide: false
      });
    } else if (Utils.isObject(thumbsParams.swiper)) {
      swiper.thumbs.swiper = new SwiperClass(Utils.extend({}, thumbsParams.swiper, {
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        slideToClickedSlide: false
      }));
      swiper.thumbs.swiperCreated = true;
    }

    swiper.thumbs.swiper.$el.addClass(swiper.params.thumbs.thumbsContainerClass);
    swiper.thumbs.swiper.on('tap', swiper.thumbs.onThumbClick);
  },
  onThumbClick: function onThumbClick() {
    var swiper = this;
    var thumbsSwiper = swiper.thumbs.swiper;
    if (!thumbsSwiper) return;
    var clickedIndex = thumbsSwiper.clickedIndex;
    var clickedSlide = thumbsSwiper.clickedSlide;
    if (clickedSlide && Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(clickedSlide).hasClass(swiper.params.thumbs.slideThumbActiveClass)) return;
    if (typeof clickedIndex === 'undefined' || clickedIndex === null) return;
    var slideToIndex;

    if (thumbsSwiper.params.loop) {
      slideToIndex = parseInt(Object(dom7_dist_dom7_modular__WEBPACK_IMPORTED_MODULE_0__["$"])(thumbsSwiper.clickedSlide).attr('data-swiper-slide-index'), 10);
    } else {
      slideToIndex = clickedIndex;
    }

    if (swiper.params.loop) {
      var currentIndex = swiper.activeIndex;

      if (swiper.slides.eq(currentIndex).hasClass(swiper.params.slideDuplicateClass)) {
        swiper.loopFix(); // eslint-disable-next-line

        swiper._clientLeft = swiper.$wrapperEl[0].clientLeft;
        currentIndex = swiper.activeIndex;
      }

      var prevIndex = swiper.slides.eq(currentIndex).prevAll("[data-swiper-slide-index=\"".concat(slideToIndex, "\"]")).eq(0).index();
      var nextIndex = swiper.slides.eq(currentIndex).nextAll("[data-swiper-slide-index=\"".concat(slideToIndex, "\"]")).eq(0).index();
      if (typeof prevIndex === 'undefined') slideToIndex = nextIndex;else if (typeof nextIndex === 'undefined') slideToIndex = prevIndex;else if (nextIndex - currentIndex < currentIndex - prevIndex) slideToIndex = nextIndex;else slideToIndex = prevIndex;
    }

    swiper.slideTo(slideToIndex);
  },
  update: function update(initial) {
    var swiper = this;
    var thumbsSwiper = swiper.thumbs.swiper;
    if (!thumbsSwiper) return;
    var slidesPerView = thumbsSwiper.params.slidesPerView === 'auto' ? thumbsSwiper.slidesPerViewDynamic() : thumbsSwiper.params.slidesPerView;
    var autoScrollOffset = swiper.params.thumbs.autoScrollOffset;
    var useOffset = autoScrollOffset && !thumbsSwiper.params.loop;

    if (swiper.realIndex !== thumbsSwiper.realIndex || useOffset) {
      var currentThumbsIndex = thumbsSwiper.activeIndex;
      var newThumbsIndex;
      var direction;

      if (thumbsSwiper.params.loop) {
        if (thumbsSwiper.slides.eq(currentThumbsIndex).hasClass(thumbsSwiper.params.slideDuplicateClass)) {
          thumbsSwiper.loopFix(); // eslint-disable-next-line

          thumbsSwiper._clientLeft = thumbsSwiper.$wrapperEl[0].clientLeft;
          currentThumbsIndex = thumbsSwiper.activeIndex;
        } // Find actual thumbs index to slide to


        var prevThumbsIndex = thumbsSwiper.slides.eq(currentThumbsIndex).prevAll("[data-swiper-slide-index=\"".concat(swiper.realIndex, "\"]")).eq(0).index();
        var nextThumbsIndex = thumbsSwiper.slides.eq(currentThumbsIndex).nextAll("[data-swiper-slide-index=\"".concat(swiper.realIndex, "\"]")).eq(0).index();
        if (typeof prevThumbsIndex === 'undefined') newThumbsIndex = nextThumbsIndex;else if (typeof nextThumbsIndex === 'undefined') newThumbsIndex = prevThumbsIndex;else if (nextThumbsIndex - currentThumbsIndex === currentThumbsIndex - prevThumbsIndex) newThumbsIndex = currentThumbsIndex;else if (nextThumbsIndex - currentThumbsIndex < currentThumbsIndex - prevThumbsIndex) newThumbsIndex = nextThumbsIndex;else newThumbsIndex = prevThumbsIndex;
        direction = swiper.activeIndex > swiper.previousIndex ? 'next' : 'prev';
      } else {
        newThumbsIndex = swiper.realIndex;
        direction = newThumbsIndex > swiper.previousIndex ? 'next' : 'prev';
      }

      if (useOffset) {
        newThumbsIndex += direction === 'next' ? autoScrollOffset : -1 * autoScrollOffset;
      }

      if (thumbsSwiper.visibleSlidesIndexes && thumbsSwiper.visibleSlidesIndexes.indexOf(newThumbsIndex) < 0) {
        if (thumbsSwiper.params.centeredSlides) {
          if (newThumbsIndex > currentThumbsIndex) {
            newThumbsIndex = newThumbsIndex - Math.floor(slidesPerView / 2) + 1;
          } else {
            newThumbsIndex = newThumbsIndex + Math.floor(slidesPerView / 2) - 1;
          }
        } else if (newThumbsIndex > currentThumbsIndex) {
          newThumbsIndex = newThumbsIndex - slidesPerView + 1;
        }

        thumbsSwiper.slideTo(newThumbsIndex, initial ? 0 : undefined);
      }
    } // Activate thumbs


    var thumbsToActivate = 1;
    var thumbActiveClass = swiper.params.thumbs.slideThumbActiveClass;

    if (swiper.params.slidesPerView > 1 && !swiper.params.centeredSlides) {
      thumbsToActivate = swiper.params.slidesPerView;
    }

    if (!swiper.params.thumbs.multipleActiveThumbs) {
      thumbsToActivate = 1;
    }

    thumbsToActivate = Math.floor(thumbsToActivate);
    thumbsSwiper.slides.removeClass(thumbActiveClass);

    if (thumbsSwiper.params.loop || thumbsSwiper.params.virtual && thumbsSwiper.params.virtual.enabled) {
      for (var i = 0; i < thumbsToActivate; i += 1) {
        thumbsSwiper.$wrapperEl.children("[data-swiper-slide-index=\"".concat(swiper.realIndex + i, "\"]")).addClass(thumbActiveClass);
      }
    } else {
      for (var _i13 = 0; _i13 < thumbsToActivate; _i13 += 1) {
        thumbsSwiper.slides.eq(swiper.realIndex + _i13).addClass(thumbActiveClass);
      }
    }
  }
};
var Thumbs$1 = {
  name: 'thumbs',
  params: {
    thumbs: {
      swiper: null,
      multipleActiveThumbs: true,
      autoScrollOffset: 0,
      slideThumbActiveClass: 'swiper-slide-thumb-active',
      thumbsContainerClass: 'swiper-container-thumbs'
    }
  },
  create: function create() {
    var swiper = this;
    Utils.extend(swiper, {
      thumbs: {
        swiper: null,
        init: Thumbs.init.bind(swiper),
        update: Thumbs.update.bind(swiper),
        onThumbClick: Thumbs.onThumbClick.bind(swiper)
      }
    });
  },
  on: {
    beforeInit: function beforeInit() {
      var swiper = this;
      var thumbs = swiper.params.thumbs;
      if (!thumbs || !thumbs.swiper) return;
      swiper.thumbs.init();
      swiper.thumbs.update(true);
    },
    slideChange: function slideChange() {
      var swiper = this;
      if (!swiper.thumbs.swiper) return;
      swiper.thumbs.update();
    },
    update: function update() {
      var swiper = this;
      if (!swiper.thumbs.swiper) return;
      swiper.thumbs.update();
    },
    resize: function resize() {
      var swiper = this;
      if (!swiper.thumbs.swiper) return;
      swiper.thumbs.update();
    },
    observerUpdate: function observerUpdate() {
      var swiper = this;
      if (!swiper.thumbs.swiper) return;
      swiper.thumbs.update();
    },
    setTransition: function setTransition(duration) {
      var swiper = this;
      var thumbsSwiper = swiper.thumbs.swiper;
      if (!thumbsSwiper) return;
      thumbsSwiper.setTransition(duration);
    },
    beforeDestroy: function beforeDestroy() {
      var swiper = this;
      var thumbsSwiper = swiper.thumbs.swiper;
      if (!thumbsSwiper) return;

      if (swiper.thumbs.swiperCreated && thumbsSwiper) {
        thumbsSwiper.destroy();
      }
    }
  }
}; // Swiper Class

var components = [Device$1, Support$1, Browser$1, Resize, Observer$1, Virtual$1, Keyboard$1, Mousewheel$1, Navigation$1, Pagination$1, Scrollbar$1, Parallax$1, Zoom$1, Lazy$1, Controller$1, A11y, History$1, HashNavigation$1, Autoplay$1, EffectFade, EffectCube, EffectFlip, EffectCoverflow, Thumbs$1];

if (typeof Swiper.use === 'undefined') {
  Swiper.use = Swiper.Class.use;
  Swiper.installModule = Swiper.Class.installModule;
}

Swiper.use(components);
/* harmony default export */ __webpack_exports__["default"] = (Swiper);

/***/ }),

/***/ "./node_modules/webpack/buildin/module.js":
/*!***********************************!*\
  !*** (webpack)/buildin/module.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function (module) {
  if (!module.webpackPolyfill) {
    module.deprecate = function () {};

    module.paths = []; // module.parent = undefined by default

    if (!module.children) module.children = [];
    Object.defineProperty(module, "loaded", {
      enumerable: true,
      get: function get() {
        return module.l;
      }
    });
    Object.defineProperty(module, "id", {
      enumerable: true,
      get: function get() {
        return module.i;
      }
    });
    module.webpackPolyfill = 1;
  }

  return module;
};

/***/ }),

/***/ "./src/js/app.js":
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _include_jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./include/jquery */ "./src/js/include/jquery.js");
/* harmony import */ var _include_jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_include_jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _include_nav__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./include/nav */ "./src/js/include/nav.js");
/* harmony import */ var _include_nav__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_include_nav__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _include_youtube__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./include/youtube */ "./src/js/include/youtube.js");
/* harmony import */ var _include_youtube__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_include_youtube__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _include_headroom__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./include/headroom */ "./src/js/include/headroom.js");
/* harmony import */ var _include_headroom__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_include_headroom__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _include_swiper__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./include/swiper */ "./src/js/include/swiper.js");
/* harmony import */ var _include_swiper__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_include_swiper__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _include_fancy__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./include/fancy */ "./src/js/include/fancy.js");
/* harmony import */ var _include_fancy__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_include_fancy__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _include_flip__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./include/flip */ "./src/js/include/flip.js");
/* harmony import */ var _include_flip__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_include_flip__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _include_expandable_grid__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./include/expandable-grid */ "./src/js/include/expandable-grid.js");
/* harmony import */ var _include_expandable_grid__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_include_expandable_grid__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _include_fitvids__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./include/fitvids */ "./src/js/include/fitvids.js");
/* harmony import */ var _include_fitvids__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_include_fitvids__WEBPACK_IMPORTED_MODULE_8__);
/*!
 * Javascript
 * ---------------------------------------------------------------------------------
 */
// jquery globally available










/***/ }),

/***/ "./src/js/include/expandable-grid.js":
/*!*******************************************!*\
  !*** ./src/js/include/expandable-grid.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var cells = $('.expandable__cell');
  cells.find('.item--basic').click(function (e) {
    var thisCell = $(this).closest('.expandable__cell');

    if (thisCell.hasClass('is-collapsed')) {
      $(cells).not(thisCell).removeClass('is-expanded').addClass('is-collapsed');
      thisCell.removeClass('is-collapsed').addClass('is-expanded');
      hash = $(thisCell).attr('id');
      history.pushState(null, null, window.location.protocol + '//' + window.location.host + window.location.pathname + '#' + hash);
      $('html, body').animate({
        scrollTop: $('#' + hash).offset().top - 130
      });
    } else {
      thisCell.removeClass('is-expanded').addClass('is-collapsed');
    }
  });
  $(".expand__close").on("click", function (e) {
    var thisCell = $(this).closest('.expandable__cell');
    thisCell.removeClass('is-expanded').addClass('is-collapsed');
  });
  $(document).ready(function () {
    var hash = window.location.hash.substring(1);

    if (hash.length && isNaN(parseFloat(hash))) {
      $('#' + hash).removeClass("is-collapsed").addClass("is-expanded");
      $('html, body').animate({
        scrollTop: $('#' + hash).offset().top - 130
      });
    }
  });
})(jQuery);

/***/ }),

/***/ "./src/js/include/fancy.js":
/*!*********************************!*\
  !*** ./src/js/include/fancy.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

// FancyApps
window.fancybox = __webpack_require__(/*! @fancyapps/fancybox */ "./node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js");
$("[data-fancybox]").fancybox({
  thumbs: false,
  slideShow: false,
  image: {
    protect: true
  },
  buttons: [// "zoom",
  //"share",
  // "slideShow",
  //"fullScreen",
  //"download",
  // "thumbs",
  "close"]
});

/***/ }),

/***/ "./src/js/include/fitvids.js":
/*!***********************************!*\
  !*** ./src/js/include/fitvids.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $("div.embed").fitVids();
});
/*jshint browser:true */

/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

;

(function ($) {
  'use strict';

  $.fn.fitVids = function (options) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if (!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if (options) {
      $.extend(settings, options);
    }

    return this.each(function () {
      var selectors = ['iframe[src*="player.vimeo.com"]', 'iframe[src*="youtube.com"]', 'iframe[src*="youtube-nocookie.com"]', 'iframe[src*="kickstarter.com"][src*="video.html"]', 'object', 'embed'];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if (settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch

      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function () {
        var $this = $(this);

        if ($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }

        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
          return;
        }

        if (!$this.css('height') && !$this.css('width') && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }

        var height = this.tagName.toLowerCase() === 'object' || $this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;

        if (!$this.attr('name')) {
          var videoName = 'fitvid' + $.fn.fitVids._count;
          $this.attr('name', videoName);
          $.fn.fitVids._count++;
        }

        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', aspectRatio * 100 + '%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  }; // Internal counter for unique video names.


  $.fn.fitVids._count = 0; // Works with either jQuery or Zepto
})(window.jQuery || window.Zepto);

/***/ }),

/***/ "./src/js/include/flip.js":
/*!********************************!*\
  !*** ./src/js/include/flip.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(".flip header").click(function () {
  $(this).next('div.flip').slideToggle('fast');
  $(this).parent().toggleClass("open");

  if ($(this).parent().hasClass("open")) {
    $(this).next("div.flip").attr("aria-expanded", true);
  } else {
    $(this).next("div.flip").attr("aria-expanded", false);
  }
});

/***/ }),

/***/ "./src/js/include/headroom.js":
/*!************************************!*\
  !*** ./src/js/include/headroom.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window.Headroom = __webpack_require__(/*! headroom.js */ "./node_modules/headroom.js/dist/headroom.js"); // init headroom.js

var myElement = document.getElementById("header");
var headroom = new Headroom(myElement, {
  "offset": 13 // halve of the difference $headerheight & $headerheight--small

});
headroom.init();

/***/ }),

/***/ "./src/js/include/jquery.js":
/*!**********************************!*\
  !*** ./src/js/include/jquery.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window.$ = window.jQuery = jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

/***/ }),

/***/ "./src/js/include/nav.js":
/*!*******************************!*\
  !*** ./src/js/include/nav.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
$(document).ready(function () {
  // burger
  var menuButton = document.getElementById('menuButton');
  menuButton.addEventListener('click', function (event) {
    $('body').toggleClass('mobile-nav--active');
    event.preventDefault();
  }); // just open and do not navigate on collapsed navi-items

  $('.menu1').on('click', '>li.has-children:not(.expanded) > a', function (event) {
    if ($('body').hasClass('mobile-nav--active')) {
      event.preventDefault();
      event.stopPropagation();
      $(this).parent().find("ul.mobile-menu2").toggleClass('expanded');
      $(this).closest("li").toggleClass('expanded');
    }
  }); // collapse/expand navi per .trigger

  $('span.trigger').on('click', function (event) {
    $(this).next("ul").toggleClass('expanded');
    $(this).closest("li").toggleClass('expanded');
  }); // if we navigate, we fade-out .menu1 a bit to indicate action

  $('.menu1').on('click', '>li:not(".has-children") > a, >li.expanded > a, .mobile-menu2 li > a', function (event) {
    if ($('body').hasClass('mobile-nav--active')) {
      // event.stopPropagation();
      $('body').fadeTo("fast", 0.6);
    }
  });
  $('body').on('click touch', '#overlaynav', function (event) {
    if ($('body').hasClass('mobile-nav--active')) {
      $('body').toggleClass('mobile-nav--active');
    }
  });
}); // we need to prevent loading from cache if back-button is used, cos ios-safari would apply the fadeTo-effect to the destination not the original

window.onpageshow = function (event) {
  if (event.persisted) {
    window.location.reload();
  }
};

/***/ }),

/***/ "./src/js/include/swiper.js":
/*!**********************************!*\
  !*** ./src/js/include/swiper.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var _Swiper$default;

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

window.Swiper = __webpack_require__(/*! swiper */ "./node_modules/swiper/js/swiper.esm.bundle.js"); // https://github.com/nolimits4web/swiper/issues/273

var heroSwiper = new Swiper["default"]('.swiper-container.hero', (_Swiper$default = {
  spaceBetween: 0,
  direction: 'horizontal',
  slidesPerView: 'auto',
  CSSWidthAndHeight: true,
  lazy: true,
  effect: 'fade',
  preloadImages: false,
  loadOnTransitionStart: true,
  speed: 3000
}, _defineProperty(_Swiper$default, "lazy", {
  loadPrevNext: true,
  elementClass: 'swiper-lazy'
}), _defineProperty(_Swiper$default, "autoplay", {
  delay: 6000,
  crossFade: true,
  disableOnInteraction: false
}), _defineProperty(_Swiper$default, "keyboard", {
  enabled: true,
  onlyInViewport: false
}), _Swiper$default)); // scroll animation on arrow home

$(".scroll").click(function (e) {
  $scrollToElement = $(this).closest("div.element").next();
  $('html,body').animate({
    scrollTop: $($scrollToElement).offset().top - 100
  }, 'slow');
});

/***/ }),

/***/ "./src/js/include/youtube.js":
/*!***********************************!*\
  !*** ./src/js/include/youtube.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// this script loads the YouTube iframe-api, gets all instances and adds enable jsapi & origin-URL to the src-URL
// after initiating the API it adds playing-mode & paused-mode to the iframes
if ($('[src^="https://www.youtube.com/"]').length) {
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
}

window.BaseUrl = function () {
  return window.location.protocol + '//' + window.location.hostname;
};

function onYouTubeIframeAPIReady() {
  $('iframe').filter(function () {
    return this.src.indexOf('https://www.youtube.com/') == 0;
  }).each(function (k, v) {
    if (!this.id) {
      this.id = 'embeddedvideoiframe' + k;
    }

    id = this.id;
    url = $('#' + id).attr("src") + '&enablejsapi=1&origin=' + BaseUrl() + '&rel=0';
    $('#' + id).attr("src", url);
    new YT.Player(id, {
      events: {
        'onStateChange': onPlayerStateChange,
        'onReady': function onReady(e) {// e.target.mute();
          // e.target.playVideo();
        }
      }
    });
  });
}

var done = false;

function onPlayerStateChange(event) {
  if (event.data == YT.PlayerState.PLAYING && !done) {
    $('#' + event.target.f.id).closest("div.embed").removeClass("paused-mode");
    $('#' + event.target.f.id).closest("div.embed").addClass("playing-mode");
  }

  if (event.data == YT.PlayerState.PAUSED && !done) {
    $('#' + event.target.f.id).closest("div.embed").removeClass("playing-mode");
    $('#' + event.target.f.id).closest("div.embed").addClass("paused-mode");
  }
}

/***/ }),

/***/ "./src/scss/editor.scss":
/*!******************************!*\
  !*** ./src/scss/editor.scss ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./src/scss/style.scss":
/*!*****************************!*\
  !*** ./src/scss/style.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!**************************************************************************!*\
  !*** multi ./src/js/app.js ./src/scss/editor.scss ./src/scss/style.scss ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/lukaserni/webroot/ootstra/themes/default/src/js/app.js */"./src/js/app.js");
__webpack_require__(/*! /Users/lukaserni/webroot/ootstra/themes/default/src/scss/editor.scss */"./src/scss/editor.scss");
module.exports = __webpack_require__(/*! /Users/lukaserni/webroot/ootstra/themes/default/src/scss/style.scss */"./src/scss/style.scss");


/***/ })

/******/ });
//# sourceMappingURL=app.js.map