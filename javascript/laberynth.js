const symbol = '->';
const finish = 'finish';
const graph = {
    start: ['a2', 'a1'],
    a1: [],
    a2: ['a5', 'a4', 'a3', 'a1', 'a9'],
    a3: [],
    a4: ['a7'],
    a5: ['a6'],
    a6: ['a5'],
    a7: ['a3', 'a6', 'a8'],
    a8: ['finish'],
    a9: []
};

let route = '';
let noWayOut = [];
let processed = [];

const process = pos => {
    if(route.indexOf(pos) == -1) route += pos == 'start' ? `${pos}` : `${symbol}${pos}`;
    console.log("TESTING ROUTE: ", route);
    if(pos == finish) return console.log('SOLUTION: ', route);
    let hasValues = (graph[pos] && graph[pos].length) ? graph[pos].length : false;
    if(hasValues) {
        for(let i = hasValues; i--;) {
            if(processed.indexOf(graph[pos][i]) == -1) {
                processed.push(graph[pos][i]);
                return process(graph[pos][i]);
            }
        }    
    }
    return findAnotherWay();  
}

const findAnotherWay = () => {
    let way = route.split(symbol);
    noWayOut.push(way.pop());
    route = way.join(symbol);
    process(way[way.length -1]);
};

process('start');
