import Headroom from 'headroom.js';

// init headroom.js
const myElement = document.getElementById("header");
if (myElement) {
  const headroom = new Headroom(myElement, {
    "offset": 140
  });
  headroom.init();
}
