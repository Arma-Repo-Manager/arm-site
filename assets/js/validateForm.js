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
