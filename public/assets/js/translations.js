let languages = ["fr","en"];

function loadTranslations() {
    let language = (data.user === null || data.user.language === "") ? "fr" : data.user.language
    $.getJSON( "/assets/translations/translations." + language + ".json", function (languageData){
        data.language = languageData
    })
}

function getValueFromLanguage(key) {
    return data.language[key] === undefined ? key : data.language[key]
}

function setLanguage(language){
    if(languages.includes(language)){
        setUserLanguage(language);
    }
    else{
        showToast(getValueFromLanguage('LanguageDoNotExist'), data.user.id, 'danger')
    }
}