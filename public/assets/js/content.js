function getCommentContent(text) {

    let newId = Math.floor(Math.random() * 10000).toString();
    let author = getCurrentMemberUsername()

    let comment = document.createElement("li")
    comment.classList.add("list-group-item", "modal-comment")
    comment.setAttribute("data-comment", newId)

    let content = '' +
        '                <div class="d-flex justify-content-between align-items-center">' +
        '                    <p class="mb-1">' +
        '                        ' + author + ' <small class="form-text text-muted" title="' + getValueFromLanguage('ModalCommentDateTitle') + '">' + timeSince(new Date()) + '</small>' +
        '                    </p>'

    if(isCanEdit()) {
        content +=
            '<button id="commentRemove-' + newId + '" class="btn btn-sm modal-delete-comment" type="button" title="' + getValueFromLanguage('ModalCommentDeleteTitle') + '">' +
            '<span class="mdi mdi-18px mdi-trash-can"></span>' +
            '</button>'

        $(document).on('click', "#commentRemove-" + newId, function () {
            removeComment(newId)
        })
    }

    content +=
        '                </div>' +
        '                <p class="small mb-0">' + text + '</p>'

    comment.innerHTML = content
    return comment
}

function getTaskContent(catId, name, desc, assigned) {

    let newId = Math.floor(Math.random() * 10000).toString();

    let task = document.createElement("li")
    task.classList.add("list-group-item", "task-view")
    task.setAttribute("data-task", catId + "-" + newId)
    task.setAttribute("data-idCat", catId)
    task.setAttribute("data-idTask", newId)

    task.innerHTML = '' +
        '<button class="btn btn-sm btn-task-drag" type="button" title="' + getValueFromLanguage("TaskDragTitle") + '">' +
        '    <span class="mdi mdi-18px mdi-drag"></span>' +
        '</button>' +
        '<div class="form-check task-view-details">' +
        '    <input class="form-check-input task-checkbox" type="checkbox" onclick="checkTask(this,' + catId + ',' + newId + ')" title="' + getValueFromLanguage("TaskCheckboxTitle") + '">' +
        '    <div class="task-view-info" id="taskViewInfo-' + catId + '-' + newId + '" onclick="openTaskDetails(' + catId + ',' + newId + ')">' +
        '        <label class="form-check-label" title="' + getValueFromLanguage("TaskNameTitle") + '">' + name + '</label>' +
        '        <small class="form-text text-muted assigned-member" title="' + getValueFromLanguage("TaskAssignedTitle") + '">' + (assigned == null ? '' : assigned) + '</small>' +
        '        <small class="form-text text-muted" title="' + getValueFromLanguage("TaskDescriptionTitle") + '">' + desc + '</small>' +
        '    </div>' +
        '</div>' +
        '<a data-task-id="' + catId + '-' + newId + '" tabindex="0" class="btn btn-sm btn-task-actions" role="button" data-bs="popover" aria-label="' + getValueFromLanguage("TaskPopoverAriaLabel") + '" data-bs-popover="task-popover">' +
        '    <span class="mdi mdi-dots-horizontal"></span>\n' +
        '</a>'

    let newPopover = defaultPopover()
    popoverUpdateType(task.lastElementChild, "task-popover")
    newPopover.content = getPopoverTaskDefaultContent(catId, newId)
    new bootstrap.Popover(task.lastElementChild, newPopover)

    return task
}

function getSubCategoryContent(catId, name) {

    let newId = Math.floor(Math.random() * 10000).toString();

    let head = document.createElement("h2")
    head.classList.add("accordion-header", "subcategory-header")
    head.id = "panelsStayOpen-heading-" + newId
    head.innerHTML = ''

    if(isCanEdit()) {
        head.innerHTML += '' +
            '<span class="category-button">' +
            '    <span class="accordion-button btn-subcategory-drag">' +
            '        <button class="btn btn-category-actions" type="button" title="' + getValueFromLanguage("SubCategoryDragTitle") + '">' +
            '            <span class="mdi mdi-24px mdi-drag"></span>' +
            '        </button>' +
            '    </span>' +
            '</span>'
    }

    head.innerHTML += '' +
            '<button class="accordion-button" type="button" data-bs-toggle="collapse"' +
            '        data-bs-target="#panelsStayOpen-collapse-' + newId + '" aria-expanded="true"' +
            '        aria-controls="panelsStayOpen-collapse-' + newId + '">' +
                name +
            '</button>'

    if(isCanEdit()) {
        head.innerHTML += '' +
            '<span class="category-button">' +
            '    <span class="accordion-button">' +
            '        <a data-subcategory-id="' + newId + '" tabIndex="0" class="btn btn-category-actions"' +
            '           role="button" data-bs="popover" data-bs-popover="subcategory-popover"' +
            '           aria-label="' + getValueFromLanguage("SubCategoryPopoverAriaLabel") + '">' +
            '            <span class="mdi mdi-24px mdi-dots-horizontal"></span>' +
            '        </a>' +
            '    </span>' +
            '</span>'
    }

    let content = document.createElement("div")
    content.classList.add("accordion-collapse", "collapse", "show")
    content.id = "panelsStayOpen-collapse-" + newId
    // aria-labelledby="panelsStayOpen-heading-" + newId

    let body = document.createElement("div")
    body.classList.add("accordion-body")
    body.innerHTML = '<ul class="list-group list-group-flush tasks" data-sortable="tasks" data-subcategory-list-id="' + newId + '"></ul>'
    if(isCanEdit()) {
        body.innerHTML += '' +
            '<ul>' + getNewTaskContent(newId) + '</ul>'
    }
    new Sortable(body.firstElementChild, getTasksSortable())
    content.append(body)

    let subCategory = document.createElement("div")
    subCategory.classList.add("accordion-item", "accordion-item-tasks")
    subCategory.setAttribute("data-idSubCat", newId)
    subCategory.prepend(head)
    subCategory.append(content)

    if(isCanEdit()) {
        let popover = head.lastElementChild.firstElementChild.firstElementChild
        let newPopover = defaultPopover()
        newPopover.content = getPopoverSubCategoryContent(newId)
        new bootstrap.Popover(popover, newPopover)
    }

    return subCategory
}

function getNewTaskContent(id) {

    $(document).ready(

        $(document).on('click', "#taskAdd-" + id, function () {
            toggleForm("taskAdd-" + id, "taskNew-" + id, "error-taskNew" + id, null)
        }),

        $(document).on('click', "#taskNewCancel-" + id, function () {
            toggleForm("taskAdd-" + id, "taskNew-" + id, null, "#taskNewCreate-" + id)
        }),

        $(document).on('click', "#taskNewCreate-" + id, function (e) {
            newTaskCheck(e, id)
        }),
        $(document).on('keyup', "#taskNewName-" + id, function () {
            checkInputOnKeyup("#taskNewName-" + id, "error-taskNew" + id, "#taskNewCreate-" + id)
        })
    )

    let content = '<li class="list-group-item task-add">' +
        '<div class="d-grid">' +
            '<button class="btn btn-task-add" type="button" id="taskAdd-' + id + '">' +
                '<span class="mdi mdi-plus-circle"></span>' + ' ' + getValueFromLanguage("TaskNewTaskButtonName") +
            '</button>' +
        '</div>' +
        '<form class="task-new" id="taskNew-' + id + '">' +
            '<div class="mb-2">' +
                '<input type="text" class="form-control form-control-sm bg-secondary" id="taskNewName-' + id + '"' +
                       ' placeholder="' + getValueFromLanguage("NewTaskNamePlaceholder") + '"' +
                       ' title="' + getValueFromLanguage("NewTaskNameAriaLabel") + '" required>' +
                    '<div id="error-taskNew' + id + '" class="invalid-feedback" role="alert">' + getValueFromLanguage("NewTaskNameError") + '</div>' +
            '</div>' +
            '<div class="mb-2">' +
                '<textarea class="form-control form-control-sm bg-secondary" rows="3" id="taskNewDescription-' + id + '"' +
                          ' placeholder="' + getValueFromLanguage("NewTaskDescriptionPlaceholder") + '" title="' + getValueFromLanguage("NewTaskDescriptionAriaLabel") + '"></textarea>' +
            '</div>' +
            '<div class="mb-2">' +
                '<select id="select-assign-member-' + id + '" class="btn btn-sm btn-modal-select" aria-label="' + getValueFromLanguage("TaskAssignedTitle") + '" required>' +
                    '<option value="0" selected>' + getValueFromLanguage("TaskNotAssigned") + '</option>'

    getCurrentCategoryMembers().forEach(function(member) {
        content += '<option value="' + member.user.id + '">' + member.user.username + '</option>'
    })
                    /*{% for member in category.members %}
                    <option value="{{ member.user.id }}"> {{member.user.username}}</option>
                    {% endfor %}*/
    content +=
                '</select>' +
                '<div id="error-assigned" class="invalid-feedback" role="alert">' + getValueFromLanguage("ModalProjectMemberExistenceErrorText") + '</div>' +
            '</div>' +
            '<div class="d-grid gap-2 d-md-flex justify-content-md-end">' +
                '<button class="btn btn-secondary btn-sm me-md-2" type="reset" id="taskNewCancel-' + id + '">' + getValueFromLanguage("NewTaskCancel") + '</button>' +
                '<button class="btn btn-primary btn-sm btn-task-create" type="submit" id="taskNewCreate-' + id + '" disabled>' + getValueFromLanguage("NewTaskCreate") + '</button>' +
            '</div>' +
        '</form>' +
    '</li>'

    return content
}