/**
 * Disconnect user due innactivity, answer to a guy in stackoverflow.
 */

(function(d) {
  var time = 15000 * 60; // 15'
  var timer;

  var setTimer = function() {
    timer = setTimeout(function() {
      deleteCookie("PHPSESSID");
      location.reload();
    }, time);
  };

  var getEvents = function() {
    var res = [];
    for(var k in d) {
      if(k.indexOf("on") === 0) {
        res.push(k.slice(2).toLowerCase());
      }
    }
    return res;
  };

  var refreshTimer = function() {
    clearTimeout(timer);
    setTimer();
  };

  var deleteCookie = function(key) {
    var date = new Date(-1);
    date.setTime(date.getTime());
    d.cookie = key + "=1; " + "expires=" + date.toUTCString();
  };

  getEvents().forEach(function(evt) {
    d.addEventListener(evt, function() {
      refreshTimer();
    });
  });

  setTimer();
})(document);