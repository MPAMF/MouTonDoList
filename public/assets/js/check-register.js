let registerForm = document.getElementById("form_register");

registerForm.addEventListener('submit' ,function(e){
    let email = document.getElementById("email");
    let pseudo = document.getElementById("username");
    let pass = document.getElementById("password");
    let passConf = document.getElementById("password-conf");
    let condition = document.getElementById("condition");

    let regex = /^[a-zA-Z-_0-9\S]*@[a-zA-Z-_\S]*\.[a-z\S]*$/;
    let regexMdpSpe = /^[-_*.!?#\S]+$/;
    let regexMdpMin = /^[a-z\S]+$/;
    let regexMdpMaj = /^[A-Z\S]+$/;
    let regexMdpNum = /^[0-9\S]+$/;

    if(email.value.trim() === ""){
        displayError("email",0,"254")
        e.preventDefault();
    }
    else if(!regex.test(email.value)){
        e.preventDefault();
    }

    if(pseudo.value.trim() === ""){
        displayError("pseudo",0,"64")
        e.preventDefault();
    }

    if(pass.value.trim() === ""){
        displayError("password",0,"128")
        e.preventDefault();
    }
    else if(!regexMdpSpe.test(pass.value)){
        displayError('password',2)
        e.preventDefault();
    }
    else if(!regexMdpMin.test(pass.value)){
        displayError('password',2)
        e.preventDefault();
    }
    else if(!regexMdpMaj.test(pass.value)){
        displayError('password',2)
        e.preventDefault();
    }
    else if(!regexMdpNum.test(pass.value)){
        displayError('password',2)
        e.preventDefault();
    }
    else if((pass.value.length < 6)||(pass.value.length > 128)){
        displayError('password',2)
        e.preventDefault();
    }

    if(passConf.value !== pass.value){
        displayError("password-conf",3)
        e.preventDefault();
    }

    if(!condition.checked){
        condition.style.border="2px solid red";
        e.preventDefault();
    }
});
