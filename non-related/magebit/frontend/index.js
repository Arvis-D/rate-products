var forms = document.getElementById("moving-forms");
var login = document.getElementById("login");
var signup = document.getElementById("signup");
var signupO = document.getElementById("signup-opt");
var loginO = document.getElementById("login-opt");
var face = document.getElementById("face");

function move(toggle) {
    var width = window.innerWidth;
    if (toggle) {
        toggle = false;
        if (width < 920) {
            moveMobile(!toggle);
        } else {
            forms.style.left = "440px";
            face.style.left = "430px";

            setTimeout(() => {
                signup.style.zIndex = 0;
                login.style.opacity = 1;
                login.style.zIndex = 1;
            }, 500);
            
            setTimeout(() => {
                signup.style.opacity = 0;
            }, 300);
        }
    } else {
        toggle = true;

        if (width < 920) {
            moveMobile(!toggle);
        } else {
            forms.style.left = "20px";
            face.style.left = "10px";

            setTimeout(() => {
                login.style.zIndex = 0;
                signup.style.opacity = 1;
                signup.style.zIndex = 1;
            }, 500);

            setTimeout(() => {
                login.style.opacity = 0;
            }, 300);
        }
    }
}



function moveMobile(toggle){
    if(toggle){
        loginO.style.opacity = 0;
        loginO.style.zIndex = 0;
        signupO.style.opacity = 1;
        signupO.style.zIndex = 1;

        login.style.opacity = 1;
        login.style.zIndex = 1;
        signup.style.opacity = 0;
        signup.style.zIndex = 0;

    }else{
        loginO.style.opacity = 1;
        loginO.style.zIndex = 1;
        signupO.style.opacity = 0;
        signupO.style.zIndex = 0;

        login.style.opacity = 0;
        login.style.zIndex = 0;
        signup.style.opacity = 1;
        signup.style.zIndex = 1;
    }
}