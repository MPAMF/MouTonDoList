let registerForm = document.getElementById("form_register");

registerForm.addEventListener('submit' ,function(e){
    let email = document.getElementById("email");
    let pseudo = document.getElementById("pseudo");
    let pass = document.getElementById("password");
    let passConf = document.getElementById("password-conf");
    let condition = document.getElementById("condition");

    let regex = /^[a-zA-Z-_0-9\S]*@[a-zA-Z-_\S]*\.[a-z\S]*$/;
    let regexPseudo = /^[a-zA-Z0-9-_*.!?#\S]+$/;
    let regexMdp = /^[a-zA-Z0-9-_*.!?#]+$/;

    if(email.value.trim() === ""){
        e.preventDefault();
    }
    else if(!regex.test(email.value)){
        e.preventDefault();
    }

    if(pseudo.value.trim() === ""){
        e.preventDefault();
    }
    else if(!regexPseudo.test(pseudo.value)){
        e.preventDefault();
    }

    if(pass.value.trim() === ""){
        e.preventDefault();
    }
    else if(!regexMdp.test(pass.value)){
        e.preventDefault();
    }

    if(passConf.value.trim() === ""){
        e.preventDefault();
    }
    else if(!regexMdp.test(passConf.value)){
        e.preventDefault();
    }

    if(!condition.checked){
        condition.style.border="2px solid red";
        e.preventDefault();
    }
});
