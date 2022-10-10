
/* Values */
let body = document.body;
let theme = researchTheme()

body.onload = function (){
    setTheme();
}

function setToDarkMode(){
    theme = "dark";
    setTheme();
    setThemeInDataBase();
}
function setToLightMode(){
    theme = "light";
    setTheme();
    setThemeInDataBase();
}

function setTheme(){
    if((theme != "dark") && (theme != "light"))
        return;
    body.setAttribute("class",theme);
}

function researchTheme(){
    //Get the database value
    return "";
}

function setThemeInDataBase(){
    //Set the database value
}