const authModalSelectMemberStatusValues = [1, 2, 3];

function checkSelectValuesOnSubmit(selectsName, errorId, authValues)
{
    let checkAll = true
    selectsName.forEach((select) => {
        if(authValues.includes(parseInt(select.value)))
            return
        document.getElementById(errorId).style.display = "block";
        checkAll = false
    });
    if(checkAll)
        document.getElementById(errorId).style.display = "none";
    else
        checkAll = false
}

function checkInputOnSubmit(inputId, errorId)
{
    if($(inputId).val().length < 1)
        document.getElementById(errorId).style.display = "block";
    else
        document.getElementById(errorId).style.display = "none";
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

function toggleForm(btnId, formId, inputId1, inputId2, errorId)
{
    document.getElementById(btnId).classList.toggle("btn-task-add-unactive");
    document.getElementById(formId).classList.toggle("task-new-active");
    document.getElementById(inputId1).value = "";
    document.getElementById(inputId2).value = "";
    if (errorId !== null)
        document.getElementById(errorId).style.display = "none";
}