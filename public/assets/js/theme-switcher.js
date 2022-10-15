
/* Values */
let body = document.body;
let theme = researchTheme()
let themes = [
    'dark',
    'light'
]

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
    if(body.classList.contains(theme)) return;
    if((theme != "dark") && (theme != "light"))
        return;
    themes.forEach(toggleThemes);
}

function toggleThemes(element) {
    if(element === theme)
        body.classList.add(theme);
    else
        body.classList.remove(element);
}

function researchTheme(){
    //Get the database value
    return "";
}

function setThemeInDataBase(){
    //Set the database value
}