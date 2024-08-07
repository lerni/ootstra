// import { CountUp } from './js/countUp.min.js';
import { CountUp } from 'countup.js';

var ElementCounters = document.querySelectorAll('.graphs .graph .counter-digit');
Array.prototype.forEach.call(ElementCounters, function (counter) {
  var counterID = counter.getAttribute('data-id');
  var counterValue = counter.getAttribute('data-value');
  var ElementCounter = new CountUp(
    counterID,
    counterValue,
    {
      enableScrollSpy: true,
      scrollSpyDelay: 100,
      scrollSpyOnce: true,
      separator: '\'',
      decimal: ','
    }
  );
});
