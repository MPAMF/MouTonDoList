let loginForm = document.getElementById("form_login");

loginForm.addEventListener('submit' ,function(e){
    let email = document.getElementById("email");
    let pass = document.getElementById("password");

    let myRegex = /^[a-zA-Z-_0-9\S]*@[a-zA-Z-_\S]*\.[a-z\S]*$/;
    let myRegexMDP = /^[a-zA-Z0-9-_*.!?#@&\S]+$/;

    if(email.value.trim() === ""){
        e.preventDefault();
    }
    else if(!myRegex.test(email.value)){
        e.preventDefault();
    }

    if(pass.value.trim() === ""){
        e.preventDefault();
    }
    else if(!myRegexMDP.test(pass.value)){
        e.preventDefault();
    }
});

