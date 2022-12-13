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

        $(document).on('click', "#commentRemove-" + newId, function (e) {
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