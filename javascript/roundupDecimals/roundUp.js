var weirdRound = function(n) {
  var splited = n.toString().split(".");
  var res = 0;
  if(splited[1]) {
    var len = splited[1].length;
    if(len > 3) {
      splited[1] = splited[1].substr(0, 3);
      res = splited.join(".") *1;
    } else if(len == 2) {
      splited[1] = splited[1].substr(0, 1) + ((splited[1].substr(len -1, len) *1) +1);
      res = splited.join(".") *1;
    } else {
      res = n;
    }
  }
  return res.toFixed(3);
}

console.log(weirdRound(10.66));
console.log(weirdRound(10.7898));
console.log(weirdRound(1.12));
console.log(weirdRound(1.12565));
console.log(weirdRound(1.125));