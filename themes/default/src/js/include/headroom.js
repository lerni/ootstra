window.Headroom = require('headroom.js');

// init headroom.js
var myElement = document.getElementById("header");
var headroom  = new Headroom(myElement, {
	"offset": 13 // halve of the difference $headerheight & $headerheight--small
});
headroom.init();
