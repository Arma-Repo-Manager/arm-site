let axios = require('axios');

class App {
    constructor(init) {
        this.init = init;
    }
    run() {
        console.log('I will run now!', this.init);
    }
}

var app = new App('test');
app.run();
console.log(axios);