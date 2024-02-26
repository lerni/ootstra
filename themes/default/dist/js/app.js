!function(){var t,n={503:function(t,n,e){"use strict";e(604);var o=e(317),i=e.n(o);function s(){new(i())(document.getElementById("header"),{offset:140}).init()}document.addEventListener("DOMContentLoaded",s),document.body.addEventListener("htmx:afterSwap",(function(t){s()}));e(310),e(790)},790:function(){function t(){var t=Array.from(document.querySelectorAll(".expandable-grid .expandable__cell"));t.length&&(t.forEach((function(n){n.addEventListener("click",(function(n){clickedCell=n.target.closest(".expandable__cell"),clickedCell.classList.contains("is--collapsed")&&(t.forEach((function(t){t.classList.remove("is--expanded"),t.classList.add("is--collapsed")})),clickedCell.classList.remove("is--collapsed"),clickedCell.classList.add("is--expanded")),hash=clickedCell.getAttribute("id"),history.pushState(null,null,window.location.protocol+"//"+window.location.host+window.location.pathname+"#"+hash)}))})),document.addEventListener("DOMContentLoaded",(function(){var t=window.location.hash.substring(1);t.length&&isNaN(parseFloat(t))&&(document.getElementById(t).classList.remove("is--collapsed"),document.getElementById(t).classList.add("is--expanded"))})));var n=Array.from(document.querySelectorAll(".expand__close"));n.length&&n.forEach((function(t){t.addEventListener("click",(function(t){t.stopPropagation(),clickedXParent=t.target.closest(".expandable__cell"),clickedXParent.classList.remove("is--expanded"),clickedXParent.classList.add("is--collapsed")}))}))}window.onload=function(){t()},document.body.addEventListener("htmx:afterSwap",(function(n){t()}))},310:function(){function t(){var t=document.querySelectorAll("h1.flip, h2.flip, h3.flip");function n(n){var e=window.location.hash.substr(1);e&&Array.prototype.forEach.call(t,(function(t){var n=t.querySelector("button"),o=t.nextElementSibling;e===t.id&&(n.setAttribute("aria-expanded","true"),o.removeAttribute("hidden"),n.focus())}))}Array.prototype.forEach.call(t,(function(t){var n=t.querySelector("button"),e=t.nextElementSibling;n.onclick=function(o){var i="true"===n.getAttribute("aria-expanded"),s=t.id,r=window.location.hash.substr(1);n.setAttribute("aria-expanded",!i),e.hidden=i,s&&!i&&history.replaceState(null,null,"#"+s),s&&i&&s==r&&history.replaceState(null,document.title,window.location.pathname+window.location.search)}})),window.addEventListener("hashchange",n),document.addEventListener("DOMContentLoaded",n)}window.onload=function(){t()},document.body.addEventListener("htmx:afterOnLoad",(function(n){t()}))},604:function(){document.addEventListener("DOMContentLoaded",(function(){document.querySelector("#menuButton").addEventListener("click",(function(t){document.querySelector("html").classList.toggle("mobile-nav--active");var n=document.querySelector("#menuButton"),e="true"===n.getAttribute("aria-expanded");n.setAttribute("aria-expanded",!e),document.getElementById("header").scrollIntoView()})),document.querySelector(".menu1").addEventListener("click",(function(t){t.target.closest("li.has-children.expanded >a")?window.location=t.target.getAttribute("href"):document.querySelector("html").classList.contains("mobile-nav--active")&&t.target.closest("li.has-children >a")&&(t.preventDefault(),t.target.parentElement.classList.toggle("expanded"))})),document.querySelectorAll("span.trigger").forEach((function(t){t.addEventListener("click",(function(t){t.target.closest("li").classList.toggle("expanded")}))})),document.querySelector(".menu1").addEventListener("mouseleave",(function(t){document.querySelector("html").classList.contains("mobile-nav--active")||document.querySelectorAll(".menu1 li").forEach((function(t){t.classList.remove("expanded")}))}))})),window.onpageshow=function(t){t.persisted&&window.location.reload()}},317:function(t){
/*!
 * headroom.js v0.12.0 - Give your page some headroom. Hide your header until you need it
 * Copyright (c) 2020 Nick Williams - http://wicky.nillia.ms/headroom.js
 * License: MIT
 */
t.exports=function(){"use strict";function t(){return"undefined"!=typeof window}function n(){var t=!1;try{var n={get passive(){t=!0}};window.addEventListener("test",n,n),window.removeEventListener("test",n,n)}catch(n){t=!1}return t}function e(){return!!(t()&&function(){}.bind&&"classList"in document.documentElement&&Object.assign&&Object.keys&&requestAnimationFrame)}function o(t){return 9===t.nodeType}function i(t){return t&&t.document&&o(t.document)}function s(t){var n=t.document,e=n.body,o=n.documentElement;return{scrollHeight:function(){return Math.max(e.scrollHeight,o.scrollHeight,e.offsetHeight,o.offsetHeight,e.clientHeight,o.clientHeight)},height:function(){return t.innerHeight||o.clientHeight||e.clientHeight},scrollY:function(){return void 0!==t.pageYOffset?t.pageYOffset:(o||e.parentNode||e).scrollTop}}}function r(t){return{scrollHeight:function(){return Math.max(t.scrollHeight,t.offsetHeight,t.clientHeight)},height:function(){return Math.max(t.offsetHeight,t.clientHeight)},scrollY:function(){return t.scrollTop}}}function c(t){return i(t)?s(t):r(t)}function a(t,e,o){var i,s=n(),r=!1,a=c(t),l=a.scrollY(),u={};function d(){var t=Math.round(a.scrollY()),n=a.height(),i=a.scrollHeight();u.scrollY=t,u.lastScrollY=l,u.direction=t>l?"down":"up",u.distance=Math.abs(t-l),u.isOutOfBounds=t<0||t+n>i,u.top=t<=e.offset[u.direction],u.bottom=t+n>=i,u.toleranceExceeded=u.distance>e.tolerance[u.direction],o(u),l=t,r=!1}function f(){r||(r=!0,i=requestAnimationFrame(d))}var h=!!s&&{passive:!0,capture:!1};return t.addEventListener("scroll",f,h),d(),{destroy:function(){cancelAnimationFrame(i),t.removeEventListener("scroll",f,h)}}}function l(t){return t===Object(t)?t:{down:t,up:t}}function u(t,n){n=n||{},Object.assign(this,u.options,n),this.classes=Object.assign({},u.options.classes,n.classes),this.elem=t,this.tolerance=l(this.tolerance),this.offset=l(this.offset),this.initialised=!1,this.frozen=!1}return u.prototype={constructor:u,init:function(){return u.cutsTheMustard&&!this.initialised&&(this.addClass("initial"),this.initialised=!0,setTimeout((function(t){t.scrollTracker=a(t.scroller,{offset:t.offset,tolerance:t.tolerance},t.update.bind(t))}),100,this)),this},destroy:function(){this.initialised=!1,Object.keys(this.classes).forEach(this.removeClass,this),this.scrollTracker.destroy()},unpin:function(){!this.hasClass("pinned")&&this.hasClass("unpinned")||(this.addClass("unpinned"),this.removeClass("pinned"),this.onUnpin&&this.onUnpin.call(this))},pin:function(){this.hasClass("unpinned")&&(this.addClass("pinned"),this.removeClass("unpinned"),this.onPin&&this.onPin.call(this))},freeze:function(){this.frozen=!0,this.addClass("frozen")},unfreeze:function(){this.frozen=!1,this.removeClass("frozen")},top:function(){this.hasClass("top")||(this.addClass("top"),this.removeClass("notTop"),this.onTop&&this.onTop.call(this))},notTop:function(){this.hasClass("notTop")||(this.addClass("notTop"),this.removeClass("top"),this.onNotTop&&this.onNotTop.call(this))},bottom:function(){this.hasClass("bottom")||(this.addClass("bottom"),this.removeClass("notBottom"),this.onBottom&&this.onBottom.call(this))},notBottom:function(){this.hasClass("notBottom")||(this.addClass("notBottom"),this.removeClass("bottom"),this.onNotBottom&&this.onNotBottom.call(this))},shouldUnpin:function(t){return"down"===t.direction&&!t.top&&t.toleranceExceeded},shouldPin:function(t){return"up"===t.direction&&t.toleranceExceeded||t.top},addClass:function(t){this.elem.classList.add.apply(this.elem.classList,this.classes[t].split(" "))},removeClass:function(t){this.elem.classList.remove.apply(this.elem.classList,this.classes[t].split(" "))},hasClass:function(t){return this.classes[t].split(" ").every((function(t){return this.classList.contains(t)}),this.elem)},update:function(t){t.isOutOfBounds||!0!==this.frozen&&(t.top?this.top():this.notTop(),t.bottom?this.bottom():this.notBottom(),this.shouldUnpin(t)?this.unpin():this.shouldPin(t)&&this.pin())}},u.options={tolerance:{up:0,down:0},offset:0,scroller:t()?window:null,classes:{frozen:"headroom--frozen",pinned:"headroom--pinned",unpinned:"headroom--unpinned",top:"headroom--top",notTop:"headroom--not-top",bottom:"headroom--bottom",notBottom:"headroom--not-bottom",initial:"headroom"}},u.cutsTheMustard=e(),u}()},682:function(){},287:function(){},50:function(){},930:function(){},422:function(){},276:function(){},130:function(){},467:function(){},569:function(){},665:function(){},97:function(){},543:function(){},335:function(){},506:function(){},666:function(){},758:function(){},55:function(){}},e={};function o(t){var i=e[t];if(void 0!==i)return i.exports;var s=e[t]={exports:{}};return n[t].call(s.exports,s,s.exports,o),s.exports}o.m=n,t=[],o.O=function(n,e,i,s){if(!e){var r=1/0;for(u=0;u<t.length;u++){e=t[u][0],i=t[u][1],s=t[u][2];for(var c=!0,a=0;a<e.length;a++)(!1&s||r>=s)&&Object.keys(o.O).every((function(t){return o.O[t](e[a])}))?e.splice(a--,1):(c=!1,s<r&&(r=s));if(c){t.splice(u--,1);var l=i();void 0!==l&&(n=l)}}return n}s=s||0;for(var u=t.length;u>0&&t[u-1][2]>s;u--)t[u]=t[u-1];t[u]=[e,i,s]},o.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return o.d(n,{a:n}),n},o.d=function(t,n){for(var e in n)o.o(n,e)&&!o.o(t,e)&&Object.defineProperty(t,e,{enumerable:!0,get:n[e]})},o.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},function(){var t={112:0,761:0,274:0,81:0,917:0,630:0,656:0,562:0,142:0,430:0,10:0,805:0,147:0,1:0,281:0,583:0,908:0,439:0};o.O.j=function(n){return 0===t[n]};var n=function(n,e){var i,s,r=e[0],c=e[1],a=e[2],l=0;if(r.some((function(n){return 0!==t[n]}))){for(i in c)o.o(c,i)&&(o.m[i]=c[i]);if(a)var u=a(o)}for(n&&n(e);l<r.length;l++)s=r[l],o.o(t,s)&&t[s]&&t[s][0](),t[s]=0;return o.O(u)},e=self.webpackChunk=self.webpackChunk||[];e.forEach(n.bind(null,0)),e.push=n.bind(null,e.push.bind(e))}(),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(503)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(335)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(506)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(666)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(758)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(55)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(682)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(287)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(50)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(930)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(422)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(276)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(130)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(467)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(569)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(665)})),o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(97)}));var i=o.O(void 0,[761,274,81,917,630,656,562,142,430,10,805,147,1,281,583,908,439],(function(){return o(543)}));i=o.O(i)}();