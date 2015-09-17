var MouseUtils = (function() {
  'use strict';
  // VARIABLES
  var _isScrolling = false;
  var _buttonsArray = [false, false, false, false, false, false, false, false, false]; // 0 left, 2 right, 1 middle, other.. extra buttons, gaming mouses
  var _mousePressed = false;

  //EVENT LISTENERS
  var _init = function(w, d) {
    w.onscroll = function() {
      _isScrolling = true;
    };
    d.onmousedown = function(e) {
      _buttonsArray[e.button] = true;
      _mousePressed = true;
    };
    d.onmouseup = function(e) {
      _buttonsArray[e.button] = false;
      _mousePressed = false;
    };
    d.oncontextmenu = function() { // this is mandatory for clicks down|ups works well
      return false;
    };
    return this;
  };

  // TIMERS
  var _scrollInterval = setInterval(function() {
    if(_isScrolling) {
      _isScrolling = false;
    }
  }, 500);

  // EXPOSED
  var _isLeftPressed = function() {
    return _buttonsArray[0];
  };
  var _isRightPressed = function() {
    return _buttonsArray[2];
  };
  var _isMiddlePressed = function() {
    return _buttonsArray[1];
  };
  var _isScrolling = function() {
    return _isScrolling;
  };

  var _clearScrollInterval = function() {
    clearInterval(_scrollInterval);
  };

  return {
    init: _init,
    isLeftPressed: _isLeftPressed,
    isRightPressed: _isRightPressed,
    isMiddlePressed: _isMiddlePressed,
    isScrolling: _isScrolling,
    clearScrollInterval: _clearScrollInterval
  };
})();

MouseUtils.init(window, document);