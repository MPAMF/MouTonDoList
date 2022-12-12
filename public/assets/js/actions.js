const repositories = {
    categories: new CategoryRepository(),
    tasks: new TaskRepository(),
    taskComments: new CommentRepository()
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
    showToast(`Moved taskId: ${taskId} from ${oldIndex} to ${newIndex}`, 'Moved', 'success')
}

function moveSubCategory(subCatId, oldIndex, newIndex) {
    console.log("subCatId :" + subCatId)
    console.log("oldIndex :" + oldIndex)
    console.log("newIndex :" + newIndex)
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
        window.location.replace("http://localhost:8090/dashboard");
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
}

function leaveCategory(id) {
    let category = $('[data-sidebar-id="' + id + '"]')[0]
    category.parentElement.remove()
    popoverDispose(category)
    if(isCurrentCategory())
        window.location.replace("http://localhost:8090/dashboard");
}

function deleteSubcategory(id) {
    let popoverElement = $('[data-subcategory-id="' + id + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-idSubCat="' + id + '"]')[0]
    container.remove()
}

function duplicateTask(idCat, idTask) {
    let newId = Math.floor(Math.random() * 10000).toString();

    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
    let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]
    popoverHide(popoverElement)

    let copyElement = container.cloneNode(true)
    copyElement.setAttribute("data-task", idCat + "-" + newId)
    copyElement.setAttribute("data-idTask", newId)

    let taskNameLabel = document.getElementById("taskViewInfo-" + idCat + "-" + idTask).firstElementChild
    taskNameLabel.textContent += " " + getValueFromLanguage("CopyName")

    let lastChild = copyElement.lastElementChild
    lastChild.setAttribute("data-task-id", idCat + "-" + newId)
    let newPopover = defaultPopover()
    popoverUpdateType(lastChild, "task-popover")
    newPopover.content = getPopoverTaskDefaultContent(idCat, newId)
    new bootstrap.Popover(lastChild, newPopover)

    container.parentElement.prepend(copyElement)
}

function deleteTask(idCat, idTask) {
    let popoverElement = $('[data-task-id="' + idCat + '-' + idTask + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-task="' + idCat + '-' + idTask + '"]')[0]
    container.remove()
}