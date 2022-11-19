let loginForm = document.getElementById("form_login");

loginForm.addEventListener('submit' ,function(e){
    let email = document.getElementById("email");
    let pass = document.getElementById("password");

    let myRegex = /^[a-zA-Z-_0-9\S]*@[a-zA-Z-_\S]*\.[a-z\S]*$/;
    let myRegexMDP = /^[a-zA-Z0-9-_*.!?#]+$/;

    if(email.value.trim() === ""){
        //nomRecette.style.border="2px solid red";
        e.preventDefault();
    }
    else if(!myRegex.test(email.value)){
        //login.style.border="2px solid red";
        e.preventDefault();
    }

    if(pass.value.trim() === ""){
        e.preventDefault();
        //inpImg.style.border="2px solid red";
    }
    else if(!myRegexMDP.test(pass.value)){
        e.preventDefault();
        //pass.style.border="2px solid red";
    }
});

