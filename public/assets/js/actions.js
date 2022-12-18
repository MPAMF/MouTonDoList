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
    console.log("taskId :" + taskId)
    console.log("oldCatId :" + oldSubCategoryId)
    console.log("oldIndex :" + oldIndex)
    console.log("newCatId :" + newSubCategoryId)
    console.log("newIndex :" + newIndex)
    // TODO : store changes : tasks positions
    showToast(`Moved taskId: ${taskId} from ${oldIndex} to ${newIndex}`, 'Moved', 'success')
}

function moveSubCategory(subCatId, oldIndex, newIndex) {
    console.log("subCatId :" + subCatId)
    console.log("oldIndex :" + oldIndex)
    console.log("newIndex :" + newIndex)
    // TODO : store changes : subcategories positions
}

function archiveCategory(id) {
    let category = $('[data-sidebar-id="' + id + '"]')[0]

    popoverDispose(category)
    popoverUpdateType(category, "category-default-archive-popover")

    let newPopover = defaultPopover()
    newPopover.content = getPopoverCategoryDefaultArchiveContent(id)
    new bootstrap.Popover(category, newPopover)

    if(isCurrentCategory(id)) {
        let category = $('[data-category-id="' + id + '"]')[0]

        popoverDispose(category)
        popoverUpdateType(category, "category-default-archive-popover")

        let newPopover = defaultPopover()
        newPopover.content = getPopoverCategoryDefaultArchiveContent(id)
        new bootstrap.Popover(category, newPopover)
    }

    if(isOwnerById(id)) {
        let parentContainer = document.getElementById("category-archive")
        parentContainer.firstElementChild.prepend(category.parentElement)
    }

    // TODO : store changes : category WHERE id={id} is now archived
}

function unarchiveCategory(id) {
    let category = $('[data-sidebar-id="' + id + '"]')[0]

    popoverDispose(category)
    popoverUpdateType(category, "category-default-popover")

    let newPopover = defaultPopover()
    newPopover.content = getPopoverCategoryDefaultContent(id)
    new bootstrap.Popover(category, newPopover)

    if(isCurrentCategory(id)) {
        let category = $('[data-category-id="' + id + '"]')[0]

        popoverDispose(category)
        popoverUpdateType(category, "category-default-popover")

        let newPopover = defaultPopover()
        newPopover.content = getPopoverCategoryDefaultContent(id)
        new bootstrap.Popover(category, newPopover)
    }

    if(isOwnerById(id)) {
        let parentContainer = document.getElementById("category-default")
        parentContainer.firstElementChild.prepend(category.parentElement)
    }

    // TODO : store changes : category WHERE id={id} is now unarchived
}

function deleteCategory(id) {
    const title = getValueFromLanguage('DeleteCategoryTitle').replace('%id%', id)
    let category = $('[data-sidebar-id="' + id + '"]')[0]
    let parent = category.parentElement
    repositories.categories.delete({id: id}).then(() => {
        parent.remove();
        showToast(getValueFromLanguage('DeleteCategorySuccess'), title, 'success')
    }).catch(e => {
        console.log(e)
        showToast(getValueFromLanguage('DeleteCategoryError').replace('%code%', e.code), title, 'danger')
    }).then(() => {
        popoverDispose(category)
    });
    if(isCurrentCategory(id))
        window.location.replace(dashboard);
}

function duplicateCategory(id) {
    let newId = Math.floor(Math.random() * 10000).toString();

    let category = $('[data-sidebar-id="' + id + '"]')[0]
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
    popoverHide(category)

    // TODO : get newId from database
    // TODO : store changes : duplicate category WHERE id={id} into id={newId}
}

function leaveCategory(id) {
    let category = $('[data-sidebar-id="' + id + '"]')[0]
    category.parentElement.remove()
    popoverDispose(category)
    if(isCurrentCategory())
        window.location.replace("http://localhost:8090/dashboard");
    // TODO : remove member from category.members WHERE id={id}
}

function deleteSubcategory(id) {
    let popoverElement = $('[data-subcategory-id="' + id + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-idSubCat="' + id + '"]')[0]
    container.remove()
    // TODO : remove subcategory from category WHERE catId={data.currentCategoryId} && subCatId={id}
}

function duplicateTask(idCat, idTask) {
    let newId = Math.floor(Math.random() * 10000).toString();

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
    taskViewInfoElement.firstElementChild.textContent += " " + getValueFromLanguage("CopyName")

    let lastChild = copyElement.lastElementChild
    lastChild.setAttribute("data-task-id", idCat + "-" + newId)
    let newPopover = defaultPopover()
    popoverUpdateType(lastChild, "task-popover")
    newPopover.content = getPopoverTaskDefaultContent(idCat, newId)
    new bootstrap.Popover(lastChild, newPopover)

    container.parentElement.prepend(copyElement)

    /* TODO : duplicate task :
        WHERE idTask={idTask} && newIdTask={newId}
        from subcategory WHERE subCatId={idCat}
        from category WHERE catId={data.currentCategoryId}
     */
}

function deleteTask(idCat, idTask) {
    let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
    container.remove()

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
        checkTask(input, idCat, idTask)
    })
}

function checkTask(element, idCat, idTask) {
    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]

    if(!isHideCheckedForCategory(data.currentCategoryId))
        container.classList.remove("d-none")
    else if (element.checked)
        container.classList.add("d-none")

    /* TODO : toggle task.checked :
        WHERE idTask={idTask}
        from subcategory WHERE subCatId={idCat}
        from category WHERE catId={data.currentCategoryId}
     */
}

function removeMember(catId, userId) {
    console.log(catId, userId)
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
    let taskId = $("#modal-body").attr("data-id")
    let newId = Math.floor(Math.random() * 10000).toString()
    prependComment(newId)
    toggleForm("commentAdd", "commentNew", null, "#commentNewCreate")
    clearElementValue("commentNewDescription")
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

    let newId = Math.floor(Math.random() * 10000).toString()
    appendTask(id, select.value)
    toggleForm("taskAdd-" + id, "taskNew-" + id, null, "#taskNewCreate-" + id)
    clearElementValue("taskNewName-" + id)
    clearElementValue("taskNewDescription-" + id)
    select.selectedIndex = 0

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

    let newId = Math.floor(Math.random() * 10000).toString()
    appendSubCategory(id, document.getElementById("subCatNewName").value)
    toggleForm("subCatAdd", "subCatNew", null, "#subCatNewCreate")
    clearElementValue("subCatNewName")

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
    let newId = Math.floor(Math.random() * 10000).toString()
    let container = document.getElementById("category-default").firstElementChild
    container.prepend(getSidebarOwnedCategory(newId))

    /* TODO : add category : WHERE category={newId} */
}

function submitModalCategory() {
    let error = checkInputOnSubmit("#modal-input-name", "error-modal")
    let memberSelectsName = document.getElementsByName("modal-member-select")
    error = error || checkSelectValuesOnSubmit(memberSelectsName, "error-modal-members", authModalSelectMemberStatusValues)
    let hideChecked = document.getElementById("modal-checkbox-task").checked
    let catId = $("#modal-body").attr("data-id")
    storageUpdateCategory(catId, hideChecked)
    toggleAllTasksVisibility()

    if(error) {
        showToast(`edit category`, 'edit', 'danger')
        return;
    }

    let newName = document.getElementById("modal-input-name").value

    showToast(`edit category`, 'edit', 'success')
    bootstrap.Modal.getInstance($("#modal")).hide()

    /* TODO : update category with name={newName} WHERE id={catId} */
}

function submitModalSubCategory() {
    let error = checkInputOnSubmit("#modal-input-name", "error-modal")

    if(error) {
        showToast(`edit subcategory`, 'edit', 'danger')
        return;
    }

    let subCatId = $("#modal-body").attr("data-id")
    let newName = document.getElementById("modal-input-name").value

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
    let newName = document.getElementById("modal-input-name").value
    let newDesc = document.getElementById("modal-input-description").value
    let newAssigned = select.value

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

    repositories.user.get(userId).then(u => {
        if(u.theme === theme){
            return;
        }
        u.theme = theme;
        repositories.user.update(u).then(u => {

        }).catch(e => showToast(getValueFromLanguage('UpdateUserPasswordError').replace('%code%', e.code), userId, 'danger'))
    }).catch(e => showToast(getValueFromLanguage('GetUserError').replace('%code%', e.code), userId, 'danger'))
}

function getTheme() {
    let userId = data.user.id;

    repositories.user.get(userId).then(u => {
        return u.theme;
    }).catch(e => showToast(getValueFromLanguage('GetUserError').replace('%code%', e.code), userId, 'danger'))
}

function setUserLanguage(language) {
    let userId = data.user.id;

    repositories.user.get(userId).then(u => {
        return u.language = language;
    }).catch(e => showToast(getValueFromLanguage('GetUserError').replace('%code%', e.code), userId, 'danger'))
}