let axios = require('axios');
import {httpComponent} from './components/http-component';

/**
 * @author flaver <zerbarian@outlook.com>
 * @copyright (c) 2018 arm, flaver
 * 
 * Basic app class
 * This will take for you about creating instances etc
 */
class App {

    /**
     * constrcutor
     * 
     * @return {void}
     */
    constructor() {
        this.depend = {};
        this.components = {};
    }
    
    /**
     * will run the actual app
     * 
     * @return {void}
     */
    run() {
        console.log('I will run now!', this.depend);
    }

    /**
     * add a dependency to the app
     * 
     * @return {self}
     */
    add(name, object) {
        this.depend[name] = object;
        return this;
    }

    /**
     * return a instance of dependency
     * 
     * @return {object}
     */
    get(name) {
        return this.depend[name];
    }

    /**
     * add a component to the app
     * 
     * @return {self}
     */
    addComponent(name, object) {
        console.log(object);
        this.components[name] = object;
        return this;
    }

    /**
     * get a component
     * 
     * @return {object}
     */
    getComponent(name) {
        return this.components[name];
    }
    
}

var app = new App();
app.add('ajax', axios);
app.addComponent('http', new httpComponent(app));
app.run();

//Access for inline scripts
window.app = app;

//Form validation

function validateForm(formName) {
    var formName = formName;
    if (formName == "registerForm"){
        var username = document.forms["registerForm"]["username"].value;
        var password = document.forms["registerForm"]["password"].value;
        var password_val = document.forms["registerForm"]["password_validation"].value;
        if (username == "") {
            alert("Username cant be empty");
            return false;
        }
        if(username.length >=20){
            alert("Username cant be longer then 20 chars");
            return false;
        }
        if (password == "" || password_val == "" || password.length <=8) {
            alert("Password must be at least 8 chars");
            return false;
        }
        if (password !== password_val) {
            alert("Password retype wrong");
            return false;
        }
        return true;
    }
    else{
        alert("Form name unknown");
        return true;
    }
}
