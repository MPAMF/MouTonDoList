
/* Values */
let body = document.body;
let theme = data.user.theme
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
    switchTheme(theme);
}
function setToLightMode(){
    theme = "light";
    setTheme();
    switchTheme(theme);
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