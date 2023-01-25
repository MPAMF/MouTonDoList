function defaultPopover() {
    return {
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false
    }
}

function popoverHide(element) {
    bootstrap.Popover.getInstance(element).hide()
}

function popoverDispose(element) {
    bootstrap.Popover.getInstance(element).dispose()
}

function popoverUpdateType(element, dataValue) {
    element.setAttribute("data-bs-popover", dataValue)
}

function getPopoverCategoryDefaultContent(id) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverCategoryAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverCategoryEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="duplicateCategory(' + id + ')"><span class="mdi mdi-content-duplicate"> ' + getValueFromLanguage("PopoverCategoryDuplicate") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="archiveCategory(' + id + ')"><span class="mdi mdi-archive-outline"></span> ' + getValueFromLanguage("PopoverCategoryArchive") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="deleteCategory(' + id + ')"><span class="mdi mdi-trash-can"></span> ' + getValueFromLanguage("PopoverCategoryDelete") + '</button>' +
        '</div>'
}

function getPopoverCategoryDefaultArchiveContent(id) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverCategoryAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverCategoryEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="duplicateCategory(' + id + ')"><span class="mdi mdi-content-duplicate"> ' + getValueFromLanguage("PopoverCategoryDuplicate") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="unarchiveCategory(' + id + ')"><span class="mdi mdi-archive-outline"></span> ' + getValueFromLanguage("PopoverCategoryUnarchive") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="deleteCategory(' + id + ')"><span class="mdi mdi-trash-can"></span> ' + getValueFromLanguage("PopoverCategoryDelete") + '</button>' +
        '</div>'
}

function getPopoverCategorySharedContent(id) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverCategoryAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverCategoryEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="duplicateCategory(' + id + ')"><span class="mdi mdi-content-duplicate"> ' + getValueFromLanguage("PopoverCategoryDuplicate") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="leaveCategory(' + id + ')"><span class="mdi mdi-account-minus-outline"></span> ' + getValueFromLanguage("PopoverCategoryLeave") + '</button>' +
        '</div>'
}

function getPopoverCategorySharedArchiveContent(id) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverCategoryAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverCategoryEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="duplicateCategory(' + id + ')"><span class="mdi mdi-content-duplicate"> ' + getValueFromLanguage("PopoverCategoryDuplicate") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="leaveCategory(' + id + ')"><span class="mdi mdi-account-minus-outline"></span> ' + getValueFromLanguage("PopoverCategoryLeave") + '</button>' +
        '</div>'
}

function getPopoverCategoryReadonlyContent(id) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverCategoryAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverCategoryEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="duplicateCategory(' + id + ')"><span class="mdi mdi-content-duplicate"> ' + getValueFromLanguage("PopoverCategoryDuplicate") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="leaveCategory(' + id + ')"><span class="mdi mdi-account-minus-outline"></span> ' + getValueFromLanguage("PopoverCategoryLeave") + '</button>' +
        '</div>'
}

function getPopoverSubCategoryContent(id) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverSubCategoryAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalSubCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverSubCategoryEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="deleteSubcategory(' + id + ')"><span class="mdi mdi-trash-can"></span> ' + getValueFromLanguage("PopoverSubCategoryDelete") + '</button>' +
        '</div>'
}

function getPopoverTaskDefaultContent(idCat, idTask) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverTaskAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openTaskDetails(' + idCat + ',' + idTask + ')"><span class="mdi mdi-application-outline"></span> ' + getValueFromLanguage("PopoverTaskDetails") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-pencil-outline"></span> ' + getValueFromLanguage("PopoverTaskEdit") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="duplicateTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-content-duplicate"> ' + getValueFromLanguage("PopoverTaskDuplicate") + '</button>' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="deleteTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-trash-can"></span> ' + getValueFromLanguage("PopoverTaskDelete") + '</button>' +
        '</div>'
}

function getPopoverTaskReadonlyContent(idCat, idTask) {
    return '<div class="btn-group-vertical" role="group" aria-label="' + getValueFromLanguage("PopoverTaskAriaLabel") + '">' +
        '<button type="button" class="btn btn-sm btn-popover" onclick="openTaskDetails(' + idCat + ',' + idTask + ')"><span class="mdi mdi-application-outline"></span> ' + getValueFromLanguage("PopoverTaskDetails") + '</button>' +
        '</div>'
}