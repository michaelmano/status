import Q from 'qoob';

const module = function module() {
  const THRESHOLD = 30;
  var seconds_passed = 0;

  const hook = function hook() {
    window.scrollTo(0, 0);
    seconds_passed = 0;
  };

  const reset = function reset(_) {
    seconds_passed = 0;
  };

  const loop = function loop() {
    seconds_passed += 1;
    if (seconds_passed >= THRESHOLD) {
      hook();
    }
    setTimeout(() => {
      loop();
    }, 1000);
  };

  Q.on(document, 'load', reset);
  Q.on(document, 'mousemove', reset);
  Q.on(document, 'mousedown', reset);
  Q.on(document, 'touchstart', reset);
  Q.on(document, 'click', reset);
  Q.on(document, 'scroll', reset);
  Q.on(document, 'keypress', reset);

  loop();
};

export default module;
