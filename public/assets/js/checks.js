const authModalSelectMemberStatusValues = ['READ', 'WRITE'];
const mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

function isErrorActive(errorId) { return document.getElementById(errorId).style.display === "block"; }

function checkSelectValueOnSubmit(select, errorId, authValues) {
    if(authValues.includes(select.value.toString()))
    {
        document.getElementById(errorId).style.display = "none";
        return false
    }
    document.getElementById(errorId).style.display = "block";
    return true
}

function checkSelectValuesOnSubmit(selectsName, errorId, authValues)
{
    let checkAll = true
    selectsName.forEach((select) => {
        if(authValues.includes(select.value.toString()))
            return
        document.getElementById(errorId).style.display = "block";
        checkAll = false
    });
    if(checkAll)
        document.getElementById(errorId).style.display = "none";
    return !checkAll
}

function checkInputOnSubmit(inputId, errorId)
{
    if($(inputId).val().length < 1)
    {
        document.getElementById(errorId).style.display = "block";
        return true
    }
    document.getElementById(errorId).style.display = "none";
    return false
}

function checkInputOnKeyup(inputId, errorId, submitId)
{
    var name = $(inputId).val();
    if (name.length < 1) {
        $(submitId).prop('disabled', true);
        document.getElementById(errorId).style.display = "block";
    } else {
        $(submitId).prop('disabled', false);
        document.getElementById(errorId).style.display = "none";
    }
}

function checkEmailOnSubmit(inputId, errorId)
{
    let input = $(inputId).val()
    if(input.length < 1 || !input.match(mailformat))
    {
        document.getElementById(errorId).style.display = "block";
        return true
    }
    document.getElementById(errorId).style.display = "none";
    return false
}

function checkEmailOnKeyup(inputId, errorId, submitId)
{
    var name = $(inputId).val();
    if (name.length < 1 || !name.match(mailformat)) {
        $(submitId).prop('disabled', true);
        document.getElementById(errorId).style.display = "block";
    } else {
        $(submitId).prop('disabled', false);
        document.getElementById(errorId).style.display = "none";
    }
}

function toggleForm(btnId, formId, errorId, secondBtnId)
{
    document.getElementById(btnId).classList.toggle("btn-task-add-unactive");
    document.getElementById(formId).classList.toggle("task-new-active");
    if(errorId)
        document.getElementById(errorId).style.display = "none";
    if (secondBtnId !== null)
        $(secondBtnId).prop('disabled', true);
}

function clearElementValue(inputId) {
    document.getElementById(inputId).value = ""
}