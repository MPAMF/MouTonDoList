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
    let popoverElement = $('[data-id="' + id + '"]')[0]
    popoverDispose(popoverElement)
    let container = $('[data-idSubCat="' + id + '"]')[0]
    container.remove()
}





function DuplicateTask(idCat, idTask) {
    let originalElement = document.getElementById("Task-" + idCat + "-" + idTask);
    let cloneElement = originalElement.cloneNode(true)
    cloneElement.id = "Task" + (idCat + 10) + "-" + (idTask + 10)
    originalElement.parentNode.appendChild(cloneElement)
}

function DeleteTask(idCat, idTask) {
    $("[data-bs-popover=task-popover]").popover('hide')
    let elementDown = document.getElementById("Task-" + idCat + "-" + idTask)
    elementDown.remove();
}

function AddSubcategoryBegin(id) {
    /*let subId = 10
    let subcategory = getSubcategory(subId)
    let element = document.getElementById("Subcategory-" + id)
    element.insertAdjacentHTML('beforebegin', subcategory)
    subCategoryNewTask(subId)*/
}

function AddSubcategoryEnd(id) {
    /*let subId = 10
    let subcategory = getSubcategory(subId)
    let element = document.getElementById("Subcategory-" + id)
    element.insertAdjacentHTML('beforeend', subcategory)
    subCategoryNewTask(subId)*/
}

function NewTaskBegin(idCat, idTask) {
    let task = getTask(idCat, idTask + 10)
    let element = document.getElementById("Task-" + idCat + "-" + idTask)
    element.insertAdjacentHTML('beforebegin', task)
}

function NewTaskEnd(idCat, idTask) {
    let task = getTask(idCat, idTask + 10)
    let element = document.getElementById("Task-" + idCat + "-" + idTask)
    element.insertAdjacentHTML('afterend', task)
}

function getTask(idCat, idTask) {
    return `<li class="list-group-item task-view" data-idCat="` + idCat + `" data-idTask="` + idTask + `" id="Task-` + idCat + `-` + idTask + `">
        <button class="btn btn-sm btn-task-drag" type="button"
                title="Attrape la tâche pour la changer d'emplacement">
            <span class="mdi mdi-18px mdi-drag"></span>
        </button>
        <div class="form-check task-view-details">
            <input class="form-check-input task-checkbox" type="checkbox" value="" checked="true" title="Etat de la tâche" onclick="checkTask(` + idCat + `,` + idTask + `)">
                <div class="task-view-info" id="taskViewInfo-` + idCat + `-` + idTask + `"
                     onClick="openTaskDetails(` + idCat + `,` + idTask + `)">
                    <label class="form-check-label" title="Nom de la tâche">
                        Nom de la tâche [` + idCat + `-` + idTask + `]
                    </label>
                    <small class="form-text text-muted assigned-member" title="Membre assignée à la tâche">@NOM
                        Prénom</small>
                    <small class="form-text text-muted" title="Description de la tâche">Description</small>
                </div>
        </div>
        <a data-idCat="` + idCat + `" data-idTask="` + idTask + `" tabIndex="0" class="btn btn-sm btn-task-actions"
           role="button" data-bs="popover" data-bs-popover="task-popover" aria-label="Actions de la tâche">
            <span class="mdi mdi-dots-horizontal"></span>
        </a>
    </li>`
}

function subCategoryNewTask(sub_id) {
    document.getElementById("taskAdd-" + sub_id).addEventListener('click', function (e) {
        toggleForm("taskAdd-" + sub_id, "taskNew-" + sub_id, "error-taskNew" + sub_id, null)
    });
    document.getElementById("taskNewCancel-" + sub_id).addEventListener('click', function (e) {
        toggleForm("taskAdd-" + sub_id, "taskNew-" + sub_id, null, "#taskNewCreate-" + sub_id)
    });

    $(document).ready(
        $(document).on('click', "#taskNewCreate-" + sub_id, function (e) {
            checkInputOnSubmit("#taskNewName-" + sub_id, "error-taskNew" + sub_id)
        }),
        $(document).on('keyup', "#taskNewName-" + sub_id, function (e) {
            checkInputOnKeyup("#taskNewName-" + sub_id, "error-taskNew" + sub_id, "#taskNewCreate-" + sub_id)
        })
    )
}

let subCategoryCheckboxState = false
let taskCheckboxState = false

function saveChangeCategoryName() {
    let input = document.getElementById("modal-input-name").value
    const introPara = document.getElementById("title")
    introPara.innerHTML = input

    let subCategoryCheckbox = document.querySelector('input[id="modal-checkbox-subcategory"]')
    let taskCheckbox = document.querySelector('input[id="modal-checkbox-task"]')
    if (subCategoryCheckbox.checked) {
        subCategoryCheckboxState = true
        if ($("#sub-category-archive").hasClass("invisible") === false) {
            $("#sub-category-archive").addClass('invisible')
        }
    } else {
        subCategoryCheckboxState = false
        if ($("#sub-category-archive").hasClass("invisible") === true) {
            $("#sub-category-archive").removeClass('invisible')
        }
    }
    if (taskCheckbox.checked) {
        taskCheckboxState = true
    } else {
        taskCheckboxState = false
    }
}

function checkTask(idSub, idTask) {
    let taskCheck = document.querySelector('input[id="TaskCheckbox-' + idSub + '-' + idTask + '"]')
    let task = document.getElementById("Task-" + idSub + "-" + idTask)
    if (taskCheckboxState) {
        if (taskCheck) {
            if ($("#Task-" + idSub + "-" + idTask).hasClass("d-none") === false) {
                $("#Task-" + idSub + "-" + idTask).addClass('d-none')
            }
        } else {
            if ($("#Task-" + idSub + "-" + idTask).hasClass("d-none") === true) {
                $("#Task-" + idSub + "-" + idTask).removeClass('d-none')
            }
        }
    } else {
        if ($("#Task-" + idSub + "-" + idTask).hasClass("d-none") === true) {
            $("#Task-" + idSub + "-" + idTask).removeClass('d-none')
        }
    }
}
