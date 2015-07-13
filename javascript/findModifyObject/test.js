function fn(arr, toReplace, newValue) {
  for(var x in arr) {
    console.log(x);
    for(var k in toReplace) {
      if(arr[x][k] == toReplace[k]) {
        console.log(arr[x])
        arr[x] = newValue;
        console.log(arr[x])
      }
    }
  }
  return arr;
};

var arr = [{ id: 1, name: "foo"}, { id: 2, name: "bar" }];
var newValue = {id: 2, name: "boop"};

arr = fn(arr, {id: 2}, newValue);
console.log(arr);