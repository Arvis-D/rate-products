var username = document.forms["signup-form"]["username"];
var email = document.forms["signup-form"]["email"];
var pwd = document.forms["signup-form"]["password"];

function validate(){
    if(pwd.value == "" || email.value == "" || username.value == ""){
        alert("Please fill out all the fields");
        return false;
    }
}