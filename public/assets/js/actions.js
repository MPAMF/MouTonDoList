const repositories = {
    categories: new CategoryRepository(),
    tasks: new TaskRepository(),
    taskComments: new CommentRepository(),
    user: new UserRepository()
}

// Maybe move to another file?
/**
 * @param text Text to display
 * @param title Title
 * @param type primary, warning, ...
 * @param duration How much time before hide
 */
function showToast(text, title, type, duration = 3000) {
    const randomId = (Math.random() + 1).toString(36).substring(7);
    const betterToastHtml =
        `<div id="toast-${randomId}" class="toast text-bg-${type}" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">${title}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            ${text}
          </div>
        </div>`

    $('#toastsContainer').append(betterToastHtml)
    let toastElement = $('#toast-' + randomId)

    new bootstrap.Toast(toastElement[0], {
        delay: duration
    }).show()

    // remove html on hide
    toastElement.on('hidden.bs.toast', (e) => {
        document.getElementById(e.target.id).remove()
    })

}

function showLoader() {
    $("#loader-container").css("display", "block")
}

function hideLoader() {
    $("#loader-container").css("display", "none")
}

function moveTask(taskId, oldSubCategoryId, oldIndex, newSubCategoryId, newIndex) {
    moveTaskFromData(taskId, oldSubCategoryId, oldIndex, newSubCategoryId, newIndex)

    // TODO : store changes : tasks positions
    showToast(`Moved taskId: ${taskId} from ${oldIndex} to ${newIndex}`, 'Moved', 'success')
}

function moveSubCategory(subCatId, oldIndex, newIndex) {
    moveSubCatFromData(subCatId, oldIndex, newIndex)

    // TODO : store changes : subcategories positions
    showToast(`Moved subcatid: ${subCatId} from ${oldIndex} to ${newIndex}`, 'Moved', 'success')
}

function archiveCategory(id) {
    const title = getValueFromLanguage('ArchiveCategoryTitle').replace('%id%', id)
    let category = $('[data-sidebar-id="' + id + '"]')[0]

    let element = setCatToArchivedTrueFromData(id)
    repositories.categories.update(element).then(() => {

        popoverDispose(category)
        popoverUpdateType(category, "category-default-archive-popover")

        let newPopover = defaultPopover()
        newPopover.content = getPopoverCategoryDefaultArchiveContent(id)
        new bootstrap.Popover(category, newPopover)

        if(isCurrentCategory(id)) {
            let currentCategory = $('[data-category-id="' + id + '"]')[0]
            popoverDispose(currentCategory)
            popoverUpdateType(currentCategory, "category-default-archive-popover")

            let newPopover = defaultPopover()
            newPopover.content = getPopoverCategoryDefaultArchiveContent(id)
            new bootstrap.Popover(currentCategory, newPopover)
        }

        if(isOwnerById(id)) {
            let parentContainer = document.getElementById("category-archive")
            parentContainer.firstElementChild.prepend(category.parentElement)
        }

        showToast(getValueFromLanguage('ArchiveCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        setCatToArchivedFalseFromData(id)
        showToast(getValueFromLanguage('ArchiveCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        popoverHide(category)
    });
}

function unarchiveCategory(id) {

    const title = getValueFromLanguage('UnarchiveCategoryTitle').replace('%id%', id)
    let category = $('[data-sidebar-id="' + id + '"]')[0]

    let element = setCatToArchivedFalseFromData(id)
    repositories.categories.update(element).then(() => {

        popoverDispose(category)
        popoverUpdateType(category, "category-default-popover")

        let newPopover = defaultPopover()
        newPopover.content = getPopoverCategoryDefaultContent(id)
        new bootstrap.Popover(category, newPopover)

        if(isCurrentCategory(id)) {
            let currentCategory = $('[data-category-id="' + id + '"]')[0]
            popoverDispose(currentCategory)
            popoverUpdateType(currentCategory, "category-default-popover")

            let newPopover = defaultPopover()
            newPopover.content = getPopoverCategoryDefaultContent(id)
            new bootstrap.Popover(currentCategory, newPopover)
        }

        if(isOwnerById(id)) {
            let parentContainer = document.getElementById("category-default")
            parentContainer.firstElementChild.prepend(category.parentElement)
        }

        showToast(getValueFromLanguage('UnarchiveCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        setCatToArchivedTrueFromData(id)
        showToast(getValueFromLanguage('UnarchiveCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        popoverHide(category)
    });
}

function deleteCategory(id) {
    const title = getValueFromLanguage('DeleteCategoryTitle').replace('%id%', id)
    let category = $('[data-sidebar-id="' + id + '"]')[0]
    let parent = category.parentElement

    repositories.categories.delete(id).then(() => {
        parent.remove()
        removeCatFromData(id)
        popoverDispose(category)
        showToast(getValueFromLanguage('DeleteCategorySuccess'), title, 'success')
        if(isCurrentCategory(id))
            window.location.replace(dashboard);
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('DeleteCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        popoverHide(category)
    });
}

function duplicateCategory(id) {

    const title = getValueFromLanguage('DuplicateCategoryTitle').replace('%id%', id)
    let category = $('[data-sidebar-id="' + id + '"]')[0]

    repositories.categories.create(getCategoryById(id)).then((e) => {

        let newId = e.data.id

        let copyElement = category.parentElement.cloneNode(true)
        copyElement.classList.remove('active')

        let firstChild = copyElement.firstElementChild
        firstChild.href = firstChild.href.slice(0, firstChild.href.lastIndexOf('/')) + "/" + newId
        firstChild.textContent += " " + getValueFromLanguage("CopyName")

        let lastChild = copyElement.lastElementChild
        lastChild.setAttribute("data-sidebar-id", newId)
        popoverUpdateType(lastChild, "category-default-popover")
        let newPopover = defaultPopover()
        newPopover.content = getPopoverCategoryDefaultContent(newId)
        new bootstrap.Popover(lastChild, newPopover)

        document.getElementById("category-default").firstElementChild.prepend(copyElement)
        duplicateCatFromData(id, newId)

        showToast(getValueFromLanguage('DuplicateCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('DuplicateCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        popoverHide(category)
    });
}

function leaveCategory(id) {
    let category = $('[data-sidebar-id="' + id + '"]')[0]
    category.parentElement.remove()
    popoverDispose(category)
    if(isCurrentCategory(id))
        window.location.replace("http://localhost:8090/dashboard");

    removeCatFromData(id)

    // TODO : remove member from category.members WHERE id={id}
}

function deleteSubcategory(id) {

    const title = getValueFromLanguage('DeleteSubCategoryTitle').replace('%id%', id)
    id = parseInt(id)

    repositories.categories.delete(id).then(() => {
        let popoverElement = $('[data-subcategory-id="' + id + '"]')[0]
        popoverDispose(popoverElement)
        let container = $('[data-idSubCat="' + id + '"]')[0]
        container.remove()
        removeSubCatFromData(id)

        showToast(getValueFromLanguage('DeleteSubCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('DeleteSubCategoryError').replace('%code%', e.code), title, 'danger')
    });
}

function duplicateTask(idCat, idTask) {

    const title = getValueFromLanguage('DuplicateTaskTitle').replace('%id%', idTask)

    idCat = parseInt(idCat)
    idTask = parseInt(idTask)
    let oldName = getTaskName(idCat, idTask)
    let newName = oldName + " " + getValueFromLanguage("CopyName")
    let newTask = duplicateTaskFromData(idCat, idTask, newName)

    let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]

    repositories.tasks.create(newTask).then((e) => {
        let newId = e.id

        let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]

        let copyElement = container.cloneNode(true)
        copyElement.setAttribute("data-task", idCat + "-" + newId)
        copyElement.setAttribute("data-idTask", newId)

        let contentElement = copyElement.getElementsByTagName('div')[0]
        contentElement.firstElementChild.setAttribute('onclick',"openTaskDetails(" + idCat + "," + newId + ")")

        let taskViewInfoElement = contentElement.getElementsByTagName('div')[0]
        taskViewInfoElement.id = "taskViewInfo" + idCat + "-" + newId
        taskViewInfoElement.setAttribute('onclick',"openTaskDetails(" + idCat + "," + newId + ")")
        taskViewInfoElement.firstElementChild.textContent = newName

        let lastChild = copyElement.lastElementChild
        lastChild.setAttribute("data-task-id", idCat + "-" + newId)
        let newPopover = defaultPopover()
        popoverUpdateType(lastChild, "task-popover")
        newPopover.content = getPopoverTaskDefaultContent(idCat, newId)
        new bootstrap.Popover(lastChild, newPopover)

        container.parentElement.prepend(copyElement)

        let subCatIdx = getSubCategoryIdx(idCat)
        let subCat = getSubCategoryByIdx(subCatIdx)
        setTaskNewId(newTask, newId)
        subCat.tasks.push(newTask)

        showToast(getValueFromLanguage('DuplicateTaskSuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('DuplicateTaskError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        popoverHide(popoverElement)
    });
}

function deleteTask(idCat, idTask) {

    const title = getValueFromLanguage('DeleteTaskTitle').replace('%id%', idTask)
    idTask = parseInt(idTask)

    repositories.categories.delete(idTask).then(() => {
        let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]
        popoverDispose(popoverElement)
        let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
        container.remove()

        removeTaskFromData(idCat, idTask)

        showToast(getValueFromLanguage('DeleteTaskSuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('DeleteTaskError').replace('%code%', e.code), title, 'danger')
    });
}

function toggleAllTasksVisibility() {
    Array.from($('[data-task]')).forEach(function(task) {
        let input = task.children.item(1).firstElementChild
        let idCat = task.getAttribute("data-idCat")
        let idTask = task.getAttribute("data-idTask")
        toggleTaskCheck(input, idCat, idTask)
    })
}

function toggleTaskCheck(element, idCat, idTask) {
    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
    if(!isHideCheckedForCategory(data.currentCategoryId))
        container.classList.remove("d-none")
    else if (element.checked)
        container.classList.add("d-none")
}

function checkTask(element, idCat, idTask) {

    const title = getValueFromLanguage('CheckTaskTitle').replace('%id%', idTask)

    let task = getTempTaskCheck(idCat, idTask, element.checked)
    repositories.tasks.update(task).then(() => {

        setTaskChecked(idCat, idTask, element.checked)
        toggleTaskCheck(element, idCat, idTask)

        showToast(getValueFromLanguage('CheckTaskSuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        element.checked = !element.checked
        showToast(getValueFromLanguage('CheckTaskError').replace('%code%', e.code), title, 'danger')
    });
}

function removeMember(catId, userId) {
    $('[data-member="' + catId + '-' + userId + '"]')[0].remove()
    removeMemberFromData(catId, userId)

    showToast(`remove member`, 'member', 'success')
    /* TODO : remove member :
        WHERE id={userId}
        from category WHERE catId={catId}
     */
}

function addMemberCheck(e) {
    e.preventDefault()
    let error = checkEmailOnSubmit("#memberNewName", "error-memberNew")
    let select = document.getElementById("modal-member-select-new")
    error = error || checkSelectValueOnSubmit(select, "error-memberStatusNew", authModalSelectMemberStatusValues)

    if(error) {
        showToast(`invitation`, 'invited', 'danger')
        return;
    }

    let email = document.getElementById("memberNewName")
    let selectedValue = select.value //authModalSelectMemberStatusValues

    // not instantly added to list since the user has to accept the invitation
    /* TODO : send invitation to member :
        WHERE userEmail={email.value} && userPermission={selectedValue}
        from category WHERE catId={data.currentCategoryId}
     */

    showToast(`invitation`, 'invited', 'success')
}

function removeComment(taskId, id) {
    $('[data-comment="' + id + '"]')[0].remove()
    let subCatId = $("#modal-body").attr("data-subCat")
    removeCommentFromData(parseInt(subCatId), taskId, id)
    showToast(`remove member`, 'member', 'success')
    /* TODO : remove comment from task :
        WHERE commentId={id} && taskId={taskId}
        from category WHERE catId={data.currentCategoryId}
     */
}

function addCommentCheck(e) {
    e.preventDefault()
    let error = checkInputOnSubmit("#commentNewDescription", "error-commentNew")
    if(error) {
        showToast(`new comment`, 'comment', 'danger')
        return;
    }

    let content = document.getElementById("commentNewDescription").value
    let subCatId = $("#modal-body").attr("data-subCat")
    let taskId = $("#modal-body").attr("data-id")
    let newId = Math.floor(Math.random() * 10000).toString()
    prependComment(newId)
    toggleForm("commentAdd", "commentNew", null, "#commentNewCreate")
    clearElementValue("commentNewDescription")
    addCommentToData(parseInt(subCatId), parseInt(taskId), newId, content)
    showToast(`new comment`, 'comment', 'success')

    /* TODO : add comment to task :
        WHERE commentId={newId} && taskId={taskId}
        from category WHERE catId={data.currentCategoryId}
     */
}

function prependComment(newId) {
    let container = document.getElementById("modalComments")
    let text = document.getElementById("commentNewDescription").value
    container.prepend(getCommentContent(newId, text))
}

function newTaskCheck(e, id) {
    e.preventDefault()

    const title = getValueFromLanguage('CreateTaskTitle')

    let error = checkInputOnSubmit("#taskNewName-" + id, "error-taskNew" + id)
    let select = document.getElementById("select-assign-member-" + id)
    let members = getCurrentCategoryMembersAsArray()
    members.push("0")
    error = error || checkSelectValueOnSubmit(select, "error-assigned", members)

    if(error) {
        showToast(getValueFromLanguage('InvalidData'), title, 'danger')
        return;
    }

    id = parseInt(id)
    let assignedId = parseInt(select.value)
    let name = document.getElementById("taskNewName-" + id).value
    let desc = document.getElementById("taskNewDescription-" + id).value

    let task = tempAddTaskToData(assignedId, id, name, desc)
    repositories.tasks.create(task).then((e) => {
        let newId = e.id

        appendTask(id, newId, select.value)
        toggleForm("taskAdd-" + id, "taskNew-" + id, null, "#taskNewCreate-" + id)
        clearElementValue("taskNewName-" + id)
        clearElementValue("taskNewDescription-" + id)
        select.selectedIndex = 0

        task.id = newId
        let subCatIdx = getSubCategoryIdx(id)
        getSubCategoryByIdx(subCatIdx).tasks.push(task)

        showToast(getValueFromLanguage('CreateTaskSuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('CreateTaskError').replace('%code%', e.code), title, 'danger')
    });
}

function appendTask(catId, newId, assignedValue) {
    let container = $("[data-subcategory-list-id=" + catId +"]")[0]
    let name = document.getElementById("taskNewName-" + catId).value
    let desc = document.getElementById("taskNewDescription-" + catId).value
    let assignedName = getMemberUsernameById(assignedValue)
    container.append(getTaskContent(catId, newId, name, desc, assignedName))
}

function newSubCategoryCheck(e, id) {
    e.preventDefault()

    const title = getValueFromLanguage('CreateSubCategoryTitle')

    if(checkInputOnSubmit("#subCatNewName", "error-subCatNew")) {
        showToast(getValueFromLanguage('InvalidData'), title, 'danger')
        return;
    }

    let name = document.getElementById("subCatNewName").value
    let subCat = prepareSubCatToData(id, name)

    repositories.categories.create(subCat).then((e) => {
        let newId = e.id
        appendSubCategory(id, newId, document.getElementById("subCatNewName").value)
        toggleForm("subCatAdd", "subCatNew", null, "#subCatNewCreate")
        clearElementValue("subCatNewName")

        subCat.id = newId
        addSubCatToData(subCat)

        showToast(getValueFromLanguage('CreateSubCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('CreateSubCategoryError').replace('%code%', e.code), title, 'danger')
    });
}

function appendSubCategory(catId, newId, name) {
    let container = document.getElementById("default-category-content")
    let content = getSubCategoryContent(catId, name, newId)
    if(isCanEdit()) {
        let formAddElement = document.getElementById("newSubCatContainer")
        container.insertBefore(content, formAddElement)
    } else {
        container.append(content)
    }
}

function newCategory() {
    const title = getValueFromLanguage('CreateCategoryTitle')
    let cat = prepareCatForData()

    repositories.categories.create(cat).then((e) => {
        let newId = e.data.id
        let container = document.getElementById("category-default").firstElementChild
        container.prepend(getSidebarOwnedCategory(newId))

        let category = $('[data-sidebar-id="' + newId + '"]')[0]
        let newPopover = defaultPopover()
        newPopover.content = getPopoverCategoryDefaultContent(newId)
        new bootstrap.Popover(category, newPopover)

        cat.category_id = newId
        cat.category.id = newId
        addCatToData(cat)

        showToast(getValueFromLanguage('CreateCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('CreateCategoryError').replace('%code%', e.code), title, 'danger')
    });
}

function submitModalCategory() {

    let error = checkInputOnSubmit("#modal-input-name", "error-modal")
    let memberSelectsName = document.getElementsByName("modal-member-select")
    error = error || checkSelectValuesOnSubmit(memberSelectsName, "error-modal-members", authModalSelectMemberStatusValues)
    let hideChecked = document.getElementById("modal-checkbox-task").checked
    let catId = parseInt($("#modal-body").attr("data-id"))

    const title = getValueFromLanguage('UpdateCategoryTitle').replace('%id%', catId)

    if(error) {
        showToast(getValueFromLanguage('InvalidData'), title, 'danger')
        return;
    }

    let newName = document.getElementById("modal-input-name").value
    let cat = getTempCatUpdate(catId, newName)

    repositories.categories.update(cat).then(() => {

        document.getElementById("title").innerHTML = newName
        let category = $('[data-sidebar-id="' + catId + '"]')[0]
        category.parentElement.firstElementChild.innerHTML = newName

        updateCatFromData(catId, newName)
        storageUpdateCategory(catId, hideChecked)
        toggleAllTasksVisibility()

        showToast(getValueFromLanguage('UpdateCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('UpdateCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        bootstrap.Modal.getInstance($("#modal")).hide()
    });
}

function submitModalSubCategory() {

    let subCatId = parseInt($("#modal-body").attr("data-id"))
    const title = getValueFromLanguage('UpdateSubCategoryTitle').replace('%id%', subCatId)

    if(checkInputOnSubmit("#modal-input-name", "error-modal")) {
        showToast(getValueFromLanguage('InvalidData'), title, 'danger')
        return;
    }

    let newName = document.getElementById("modal-input-name").value
    let subCat = getTempSubCatUpdate(subCatId, newName)

    repositories.categories.update(subCat).then(() => {

        let container = $('[data-idsubcat="' + subCatId + '"]')[0]
        let header = container.firstElementChild
        let button = header.getElementsByTagName('button')[1]
        button.innerHTML = newName

        updateSubCatFromData(subCatId, newName)

        showToast(getValueFromLanguage('UpdateSubCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('UpdateSubCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        bootstrap.Modal.getInstance($("#modal")).hide()
    });
}

function submitModalTask() {

    let taskId = parseInt($("#modal-body").attr("data-id"))
    let subCatId = parseInt($("#modal-body").attr("data-subcat"))
    const title = getValueFromLanguage('UpdateTaskTitle').replace('%id%', taskId)

    let error = checkInputOnSubmit("#modal-input-name", "error-modal")
    let select = document.getElementById("modal-assign-member")
    let members = getCurrentCategoryMembersAsArray()
    members.push("0")
    error = error || checkSelectValueOnSubmit(select, "error-modal-members", members)

    if(error) {
        showToast(getValueFromLanguage('InvalidData'), title, 'danger')
        return;
    }

    let newName = document.getElementById("modal-input-name").value
    let newDesc = document.getElementById("modal-input-description").value
    let newAssigned = parseInt(select.value)

    let task = getTempTaskUpdate(subCatId, taskId, newName, newDesc, newAssigned)
    repositories.tasks.update(task).then(() => {

        let task = document.getElementById("taskViewInfo-" + subCatId + "-" + taskId)
        task.firstElementChild.innerHTML = newName
        task.lastElementChild.innerHTML = newDesc
        let assigned = task.getElementsByTagName('small')[0]
        assigned.innerHTML = newAssigned === 0 ? "" : getMemberUsernameById(newAssigned)

        updateTaskFromData(subCatId, taskId, newName, newDesc, newAssigned)

        showToast(getValueFromLanguage('UpdateTaskSuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('UpdateTaskError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        bootstrap.Modal.getInstance($("#modal")).hide()
    });
}

function changePassword(newPassword) {
    let userId = data.user.id;
    const title = getValueFromLanguage('UpdateUserPasswordTitle')

    repositories.user.patch({
        id: userId,
        password: newPassword
    }).then(() => {
        showToast(getValueFromLanguage('UpdateUserPasswordSuccess'), title, 'success')
    }).catch(e => {
        showToast(getValueFromLanguage('UpdateUserPasswordError').replace('%code%', e.code), title, 'danger')
    })
}

function switchTheme(theme) {
    let userId = data.user.id
    const title = getValueFromLanguage('UpdateUserThemeTitle')

    repositories.user.patch({
        id: userId,
        theme: theme
    }).then(() => {
        setUserThemeFromData(theme)
        showToast(getValueFromLanguage('UpdateTaskSuccess'), title, 'success')
        setTheme();
    }).catch(e => {
        showToast(getValueFromLanguage('UpdateUserThemeError').replace('%code%', e.code), title, 'danger')
    })
}

function setUserLanguage(language) {

    let userId = data.user.id
    const title = getValueFromLanguage('UpdateUserLanguageTitle')

    repositories.user.patch({
        id: userId,
        language: language
    }).then(() => {
        setLanguageThemeFromData(language)
        showToast(getValueFromLanguage('UpdateUserLanguageSuccess'), title, 'success')
        location.reload()
    }).catch(e => {
        showToast(getValueFromLanguage('UpdateUserLanguageError').replace('%code%', e.code), title, 'danger')
    })
}