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
    let popoverElement = $('[data-subcategory-id="' + id + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-idSubCat="' + id + '"]')[0]
    container.remove()

    removeSubCatFromData(id)

    // TODO : remove subcategory from category WHERE catId={data.currentCategoryId} && subCatId={id}
}

function duplicateTask(idCat, idTask) {
    let newId = Math.floor(Math.random() * 10000).toString();
    let oldName = getTaskName(idCat, idTask)
    let newName = oldName + " " + getValueFromLanguage("CopyName")

    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
    let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]
    popoverHide(popoverElement)

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

    duplicateTaskFromData(idCat, idTask, newId, newName)

    /* TODO : duplicate task :
        WHERE idTask={idTask} && newIdTask={newId} && newNameTask={newName}
        + update task.comments.task_id
        from subcategory WHERE subCatId={idCat}
        from category WHERE catId={data.currentCategoryId}
     */
}

function deleteTask(idCat, idTask) {
    let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
    container.remove()

    removeTaskFromData(idCat, idTask)

    /* TODO : remove task :
        WHERE idTask={idTask}
        from subcategory WHERE subCatId={idCat}
        from category WHERE catId={data.currentCategoryId}
     */
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

    if (element.checked)
        setTaskChecked(idCat, idTask, true)
    else
        setTaskChecked(idCat, idTask, false)

    toggleTaskCheck(element, idCat, idTask)

    /* TODO : toggle task.checked :
        WHERE idTask={idTask}
        from subcategory WHERE subCatId={idCat}
        from category WHERE catId={data.currentCategoryId}
     */
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
    let error = checkInputOnSubmit("#taskNewName-" + id, "error-taskNew" + id)
    let select = document.getElementById("select-assign-member-" + id)
    let members = getCurrentCategoryMembersAsArray()
    members.push("0")
    error = error || checkSelectValueOnSubmit(select, "error-assigned", members)

    if(error) {
        showToast(`new task`, 'new', 'danger')
        return;
    }

    let assignedId = parseInt(select.value)
    let name = document.getElementById("taskNewName-" + id).value
    let desc = document.getElementById("taskNewDescription-" + id).value
    let newId = Math.floor(Math.random() * 10000).toString()

    appendTask(id, newId, select.value)
    toggleForm("taskAdd-" + id, "taskNew-" + id, null, "#taskNewCreate-" + id)
    clearElementValue("taskNewName-" + id)
    clearElementValue("taskNewDescription-" + id)
    select.selectedIndex = 0

    addTaskToData(assignedId, parseInt(id), parseInt(newId), name, desc)

    showToast(`new task`, 'new', 'success')

    /* TODO : add task to subcategory :
        WHERE subCat={id} && taskId={newId}
        from category WHERE catId={data.currentCategoryId}
     */
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

    if(checkInputOnSubmit("#subCatNewName", "error-subCatNew")) {
        showToast(`new subcat`, 'new', 'danger')
        return;
    }

    let name = document.getElementById("subCatNewName").value
    let newId = Math.floor(Math.random() * 10000).toString()
    appendSubCategory(id, newId, document.getElementById("subCatNewName").value)
    toggleForm("subCatAdd", "subCatNew", null, "#subCatNewCreate")
    clearElementValue("subCatNewName")

    addSubCatToData(id, name, parseInt(newId))

    showToast(`new subcat`, 'new', 'success')

    /* TODO : add subcategory to category :
        WHERE subCat={newId}
        from category WHERE catId={data.currentCategoryId}
     */
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

    if(error) {
        showToast(getValueFromLanguage('InvalidData').replace('%code%', e.code), title, 'danger')
        return;
    }

    const title = getValueFromLanguage('UpdateCategoryTitle').replace('%id%', catId)

    repositories.categories.update(getCategoryById(catId)).then(() => {

        let newName = document.getElementById("modal-input-name").value

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
    let error = checkInputOnSubmit("#modal-input-name", "error-modal")

    if(error) {
        showToast(`edit subcategory`, 'edit', 'danger')
        return;
    }

    let subCatId = $("#modal-body").attr("data-id")
    let newName = document.getElementById("modal-input-name").value

    let container = $('[data-idsubcat="' + subCatId + '"]')[0]
    let header = container.firstElementChild
    let button = header.getElementsByTagName('button')[1]
    button.innerHTML = newName

    updateSubCatFromData(parseInt(subCatId), newName)

    showToast(`edit subcategory`, 'edit', 'success')
    bootstrap.Modal.getInstance($("#modal")).hide()

    /* TODO : update subCategory with name={newName}
        WHERE subCatId={subCatId}
        from category WHERE catId={data.currentCategoryId}
    */
}

function submitModalTask() {
    let error = checkInputOnSubmit("#modal-input-name", "error-modal")
    let select = document.getElementById("modal-assign-member")
    let members = getCurrentCategoryMembersAsArray()
    members.push("0")
    error = error || checkSelectValueOnSubmit(select, "error-modal-members", members)

    if(error) {
        showToast(`edit task`, 'edit', 'danger')
        return;
    }

    let taskId = $("#modal-body").attr("data-id")
    let subCatId = $("#modal-body").attr("data-subcat")
    let newName = document.getElementById("modal-input-name").value
    let newDesc = document.getElementById("modal-input-description").value
    let newAssigned = parseInt(select.value)

    let task = document.getElementById("taskViewInfo-" + subCatId + "-" + taskId)
    task.firstElementChild.innerHTML = newName
    task.lastElementChild.innerHTML = newDesc
    let assigned = task.getElementsByTagName('small')[0]
    assigned.innerHTML = newAssigned === 0 ? "" : getMemberUsernameById(newAssigned)

    updateTaskFromData(parseInt(subCatId), parseInt(taskId), newName, newDesc, newAssigned)

    showToast(`edit task`, 'edit', 'success')
    bootstrap.Modal.getInstance($("#modal")).hide()

    /* TODO : update task
        WITH name={newName} && desc={newDesc} && assigned={newAssigned}
        WHERE taskId={taskId}
        from category WHERE catId={data.currentCategoryId}
    */
}

function changePassword(newPassword) {
    let userId = data.user.id;

    repositories.user.get(userId).then(u => {
        u.password = newPassword;
        repositories.user.update(u).then(u => {
            showToast(getValueFromLanguage('UpdateUserPasswordSuccess'), userId, 'success')
        }).catch(e => showToast(getValueFromLanguage('UpdateUserPasswordError').replace('%code%', e.code), userId, 'danger'))
    }).catch(e => showToast(getValueFromLanguage('GetUserError').replace('%code%', e.code), userId, 'danger'))
}

function switchTheme(theme) {
    let userId = data.user.id;
    repositories.user.patch({
        id: userId,
        theme: theme
    }).then(u => {
        setUserThemeFromData(theme)
    }).catch(e => showToast(getValueFromLanguage('UpdateUserThemeError').replace('%code%', e.code), userId, 'danger'))
}

function setUserLanguage(language) {
    let userId = data.user.id;

    repositories.user.get(userId).then(u => {
        if(u.language === language){
            return;
        }
        u.language = language;
        repositories.user.update(u).then(u => {
            setLanguageThemeFromData(language)
            // TODO : found => reload with new language
        }).catch(e => showToast(getValueFromLanguage('UpdateUserLanguageError').replace('%code%', e.code), userId, 'danger'))
    }).catch(e => showToast(getValueFromLanguage('GetUserError').replace('%code%', e.code), userId, 'danger'))
}