!function(){"use strict";var t=function(){return(t=Object.assign||function(t){for(var i,n=1,a=arguments.length;n<a;n++)for(var s in i=arguments[n])Object.prototype.hasOwnProperty.call(i,s)&&(t[s]=i[s]);return t}).apply(this,arguments)},i=function(){function i(i,n,a){var s=this;this.endVal=n,this.options=a,this.version="2.3.2",this.defaults={startVal:0,decimalPlaces:0,duration:2,useEasing:!0,useGrouping:!0,smartEasingThreshold:999,smartEasingAmount:333,separator:",",decimal:".",prefix:"",suffix:"",enableScrollSpy:!1,scrollSpyDelay:200,scrollSpyOnce:!1},this.finalEndVal=null,this.useEasing=!0,this.countDown=!1,this.error="",this.startVal=0,this.paused=!0,this.once=!1,this.count=function(t){s.startTime||(s.startTime=t);var i=t-s.startTime;s.remaining=s.duration-i,s.useEasing?s.countDown?s.frameVal=s.startVal-s.easingFn(i,0,s.startVal-s.endVal,s.duration):s.frameVal=s.easingFn(i,s.startVal,s.endVal-s.startVal,s.duration):s.frameVal=s.startVal+(s.endVal-s.startVal)*(i/s.duration);var n=s.countDown?s.frameVal<s.endVal:s.frameVal>s.endVal;s.frameVal=n?s.endVal:s.frameVal,s.frameVal=Number(s.frameVal.toFixed(s.options.decimalPlaces)),s.printValue(s.frameVal),i<s.duration?s.rAF=requestAnimationFrame(s.count):null!==s.finalEndVal?s.update(s.finalEndVal):s.callback&&s.callback()},this.formatNumber=function(t){var i,n,a,e,r=t<0?"-":"";i=Math.abs(t).toFixed(s.options.decimalPlaces);var o=(i+="").split(".");if(n=o[0],a=o.length>1?s.options.decimal+o[1]:"",s.options.useGrouping){e="";for(var l=0,u=n.length;l<u;++l)0!==l&&l%3==0&&(e=s.options.separator+e),e=n[u-l-1]+e;n=e}return s.options.numerals&&s.options.numerals.length&&(n=n.replace(/[0-9]/g,(function(t){return s.options.numerals[+t]})),a=a.replace(/[0-9]/g,(function(t){return s.options.numerals[+t]}))),r+s.options.prefix+n+a+s.options.suffix},this.easeOutExpo=function(t,i,n,a){return n*(1-Math.pow(2,-10*t/a))*1024/1023+i},this.options=t(t({},this.defaults),a),this.formattingFn=this.options.formattingFn?this.options.formattingFn:this.formatNumber,this.easingFn=this.options.easingFn?this.options.easingFn:this.easeOutExpo,this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.endVal=this.validateValue(n),this.options.decimalPlaces=Math.max(this.options.decimalPlaces),this.resetDuration(),this.options.separator=String(this.options.separator),this.useEasing=this.options.useEasing,""===this.options.separator&&(this.options.useGrouping=!1),this.el="string"==typeof i?document.getElementById(i):i,this.el?this.printValue(this.startVal):this.error="[CountUp] target is null or undefined","undefined"!=typeof window&&this.options.enableScrollSpy&&(this.error?console.error(this.error,i):(window.onScrollFns=window.onScrollFns||[],window.onScrollFns.push((function(){return s.handleScroll(s)})),window.onscroll=function(){window.onScrollFns.forEach((function(t){return t()}))},this.handleScroll(this)))}return i.prototype.handleScroll=function(t){if(t&&window&&!t.once){var i=window.innerHeight+window.scrollY,n=t.el.getBoundingClientRect(),a=n.top+n.height+window.pageYOffset;a<i&&a>window.scrollY&&t.paused?(t.paused=!1,setTimeout((function(){return t.start()}),t.options.scrollSpyDelay),t.options.scrollSpyOnce&&(t.once=!0)):window.scrollY>a&&!t.paused&&t.reset()}},i.prototype.determineDirectionAndSmartEasing=function(){var t=this.finalEndVal?this.finalEndVal:this.endVal;this.countDown=this.startVal>t;var i=t-this.startVal;if(Math.abs(i)>this.options.smartEasingThreshold&&this.options.useEasing){this.finalEndVal=t;var n=this.countDown?1:-1;this.endVal=t+n*this.options.smartEasingAmount,this.duration=this.duration/2}else this.endVal=t,this.finalEndVal=null;null!==this.finalEndVal?this.useEasing=!1:this.useEasing=this.options.useEasing},i.prototype.start=function(t){this.error||(this.callback=t,this.duration>0?(this.determineDirectionAndSmartEasing(),this.paused=!1,this.rAF=requestAnimationFrame(this.count)):this.printValue(this.endVal))},i.prototype.pauseResume=function(){this.paused?(this.startTime=null,this.duration=this.remaining,this.startVal=this.frameVal,this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count)):cancelAnimationFrame(this.rAF),this.paused=!this.paused},i.prototype.reset=function(){cancelAnimationFrame(this.rAF),this.paused=!0,this.resetDuration(),this.startVal=this.validateValue(this.options.startVal),this.frameVal=this.startVal,this.printValue(this.startVal)},i.prototype.update=function(t){cancelAnimationFrame(this.rAF),this.startTime=null,this.endVal=this.validateValue(t),this.endVal!==this.frameVal&&(this.startVal=this.frameVal,null==this.finalEndVal&&this.resetDuration(),this.finalEndVal=null,this.determineDirectionAndSmartEasing(),this.rAF=requestAnimationFrame(this.count))},i.prototype.printValue=function(t){var i=this.formattingFn(t);"INPUT"===this.el.tagName?this.el.value=i:"text"===this.el.tagName||"tspan"===this.el.tagName?this.el.textContent=i:this.el.innerHTML=i},i.prototype.ensureNumber=function(t){return"number"==typeof t&&!isNaN(t)},i.prototype.validateValue=function(t){var i=Number(t);return this.ensureNumber(i)?i:(this.error="[CountUp] invalid start or end value: ".concat(t),null)},i.prototype.resetDuration=function(){this.startTime=null,this.duration=1e3*Number(this.options.duration),this.remaining=this.duration},i}();window.onload=function(){var t=document.querySelectorAll(".graphs .graph .counter-digit");Array.prototype.forEach.call(t,(function(t){var n=t.getAttribute("data-id"),a=t.getAttribute("data-value");new i(n,a,{enableScrollSpy:!0,scrollSpyDelay:100,scrollSpyOnce:!0})}))}}();