let axios = require('axios');

class App {
    constructor(init) {
        this.init = init;
        this.depend = {};
    }
    run() {
        console.log('I will run now!', this.init, this.depend);
    }
    add(name, object) {
        this.depend[name] = object;
    }
}

var app = new App('test');
app.add('ajax', axios);
app.run();
console.log(axios);