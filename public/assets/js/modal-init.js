function openTaskDetails(subCatId, taskId)
{
    let task = getTaskInCurrentById(subCatId, taskId)
    let isArchived = getCategoryBySubcatId(subCatId).category.archived

    // get from categories where id=id
    $("#modal-title").html(getValueFromLanguage('ModalTaskDetailsName'))
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">' + getValueFromLanguage('CancelModalNav') + '</button>')

    let content = '' +
        '<div>' +
        '    <div class="form-check task-view-details">' +
        '        <input class="form-check-input task-checkbox" type="checkbox" title="' + getValueFromLanguage('TaskCheckboxTitle') + '" ' + (task.checked ? "checked" : "") + ' ' + ' disabled>' +
        '        <div class="task-view-info">' +
        '            <label class="form-check-label" title="' + getValueFromLanguage('TaskNameTitle') + '">' + task.name + '</label>' +
        '            <small class="form-text text-muted assigned-member" title="' + getValueFromLanguage('TaskAssignedTitle') + '">' + (task.assigned === null ? '' : task.assigned.username) + '</small>' +
        '            <small class="form-text text-muted" title="' + getValueFromLanguage('TaskDescriptionTitle') + '">' + (task.description === null ? '' : task.description) + '</small>' +
        '        </div>' +
        '    </div>' +
        '</div>' +
        '<div class="accordion accordion-flush" id="accordion-comments">' +
        '           <div class="accordion-item accordion-item-tasks">' +
        '               <h2 class="accordion-header subcategory-header" id="accordion-header-comments">' +
        '                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-body-comments" aria-expanded="false" aria-controls="accordion-body-comments">' +
        getValueFromLanguage('ModalCommentsTitle') +
        '                   </button>' +
        '               </h2>' +
        '               <div id="accordion-body-comments" class="accordion-collapse collapse" aria-labelledby="accordion-header-comments" data-bs-parent="#accordion-comments">' +
        '                   <div class="accordion-body">' +
        '                       <ul id="modalComments" class="list-group list-group-flush">';

    (task.comments).forEach(function(comment) {
        content +=
            '            <li class="list-group-item modal-comment" data-comment="' + comment.id + '">' +
            '                <div class="d-flex justify-content-between align-items-center">' +
            '                    <p class="mb-1">' +
            '                        ' + (comment.author === null ? getValueFromLanguage('ModalCommentAuthorUnknown') : comment.author.username) + ' <small class="form-text text-muted" title="' + getValueFromLanguage('ModalCommentDateTitle') + '">' + timeSince(Date.parse(comment.date)) + '</small>' +
            '                    </p>'

        if(isCanEdit() && !isArchived) {
            content +=
                '<button id="commentRemove-' + comment.id + '" class="btn btn-sm modal-delete-comment" type="button" title="' + getValueFromLanguage('ModalCommentDeleteTitle') + '">' +
                '<span class="mdi mdi-18px mdi-trash-can"></span>' +
                '</button>'

            $(document).on('click', "#commentRemove-" + comment.id, function (e) {
                removeComment(task.id, comment.id)
            })
        }

        content +=
            '                </div>' +
            '                <p class="small mb-0">' + comment.content + '</p>' +
            '            </li>'
    })

    content += '</ul>'

    if(isCanEdit() && !isArchived) {
        content +=
            '        <div>' +
            '            <button class="btn btn-task-add" type="button" id="commentAdd">' +
            '                <span class="mdi mdi-plus-circle"></span>' + getValueFromLanguage('ModalCommentNewText') +
            '            </button>' +
            '        </div>' +
            '        <form class="task-new" id="commentNew">' +
            '            <div class="mb-2">' +
            '                <textarea class="form-control form-control-sm bg-secondary" rows="3" id="commentNewDescription" placeholder="' + getValueFromLanguage('ModalInputDescription') + '" title="' + getValueFromLanguage('ModalInputDescription') + '" required></textarea>' +
            '                <div id="error-commentNew" class="invalid-feedback" role="alert">' + getValueFromLanguage('ModalCommentErrorText') + '</div>' +
            '            </div>' +
            '            <div class="d-grid gap-2 d-md-flex justify-content-md-end">' +
            '                <button class="btn btn-secondary btn-sm me-md-2" type="reset" id="commentNewCancel">' + getValueFromLanguage('CancelModalNav') + '</button>' +
            '                <button class="btn btn-primary btn-sm btn-task-create" type="submit" id="commentNewCreate" disabled>' + getValueFromLanguage('ModalCommentAddText') + '</button>' +
            '            </div>' +
            '        </form>'
    }
    content +=
        '    </div>' +
        '</div>'

    $("#modal-body").html(content)
    $("#modal-body").attr("data-id", task.id)
    $("#modal-body").attr("data-subCat", task.category_id)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalCategory(catId)
{
    let category = getCategoryById(catId)

    // get from categories where id=id
    $("#modal-title").html(getValueFromLanguage('ModalCategoryEditName'))
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">' + getValueFromLanguage('CancelModalNav') + '</button>' +
        '<button type="button" id="modal-submit-category" class="btn btn-primary">' + getValueFromLanguage('SaveModalNav') + '</button>')

    let content = '<form class="row g-3 form-check">'

    if(isCanEditById(catId))
    {
        content +=
            '<div class="col-12">' +
            '<label for="modal-input-name" class="form-label">' + getValueFromLanguage('ModalInputName') + '</label>' +
            '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="' + getValueFromLanguage('ModalInputProjectName') + '" title="' + getValueFromLanguage('ModalInputProjectName') + '" value="' + category.name + '" ' + (isCatArchivedFalse(catId) ? '' : 'disabled') + ' required>' +
            '<div id="error-modal" class="invalid-feedback" role="alert">' + getValueFromLanguage('NewTaskNameError') + '</div>' +
            '</div>'
    }

    let storageCategory = storageGetCategory(catId)
    let hideChecked = storageCategory.hideChecked

    content +=
        '<div class="col-12 checkbox">' +
        '<input id="modal-checkbox-task" class="form-check-input task-checkbox" type="checkbox" value=""' + (hideChecked ? "checked" : "") + '>' +
        '<label for="modal-checkbox-task">' + getValueFromLanguage('ModalProjectHideCheckedText') + '</label>' +
        '</div>'

    let categoryMembers = getCategoryMembersById(catId)
    if(isOwnerById(catId) && (isCatArchivedFalse(catId) || categoryMembers.length > 1)) {
        content +=
            '<div class="accordion accordion-flush">' +
            '<div class="accordion-item accordion-item-tasks">' +
            '<h2 class="accordion-header subcategory-header" id="flush-headingOne">' +
            '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">' +
            getValueFromLanguage('ModalProjectMembersTitle') +
            '</button>' +
            '</h2>' +
            '<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"> ' +
            '<div class="accordion-body">' +
            '<ul class="list-group list-group-flush tasks">';

        categoryMembers.forEach(function(member) {
            if(member.user_id === data.user.id) return
            content +=
                '<li class="list-group-item list-member" data-member="' + catId + '-' + member.user.id + '">' +
                '<div class="col py-1">' +
                '<label class="my-0 fw-normal">' + member.user.username + '</label>' +
                '</div>' +
                '<div class="col py-1">' +
                '<select id="member-role-' + member.user.id + '" name="modal-member-select" class="btn btn-sm btn-modal-select" aria-label="' + getValueFromLanguage('ModalProjectMemberStatus') + '"' + (isCatArchivedFalse(catId) ? '' : 'disabled') + '>' +
                '<option value="' + authModalSelectMemberStatusValues[0] + '"' + (member.can_edit ? "" : "selected") + '>' + getValueFromLanguage('ModalProjectMemberReader') + '</option>' +
                '<option value="' + authModalSelectMemberStatusValues[1] + '"' + (member.can_edit ? "selected" : "") + '>' + getValueFromLanguage('ModalProjectMemberEditor') + '</option>' +
                '</select>' +
                '</div>'

            if(isCatArchivedFalse(catId))
            {
                content +=  '<div class="col py-1">' +
                    '<button type="button" class="btn btn-sm btn-modal-remove" id="removeMember' + catId + '-' + member.user.id + '">' +
                    '<span class="mdi mdi-14px mdi-close-thick"></span> <span class="hideMobile">' + getValueFromLanguage('ModalProjectMemberRemove') + '</span>' +
                    '</button>' +
                    '</div>'

                $(document).on('change', "#member-role-" + member.user.id, function (e) {
                    updateMember(catId, member.user.id, document.getElementById("member-role-" + member.user.id))
                })

                $(document).on('click', "#removeMember" + catId + "-" + member.user.id, function (e) {
                    e.preventDefault()
                    removeMember(catId, member.user.id)
                })
            }

            content += '</li>'
        })

        content +=
            '<li class="list-group-item list-member"></li>' +
            '</ul>' +
            '<div id="error-modal-members" class="invalid-feedback" role="alert">' + getValueFromLanguage('ModalProjectMemberStatusErrorText') + '</div>'

        if(isCatArchivedFalse(catId))
        {
            content +=
                '        <div>' +
                '            <button class="btn btn-task-add" type="button" id="memberAdd">' +
                '                <span class="mdi mdi-plus-circle"></span>' + getValueFromLanguage('ModalProjectMemberNewText') +
                '            </button>' +
                '        </div>' +
                '        <div class="task-new" id="memberNew">' +
                '            <div class="mb-2">' +
                '                <input class="form-control form-control-sm bg-secondary" id="memberNewName" placeholder="Mail du membre" title="Mail du membre" required></input>' +
                '                <div id="error-memberNew" class="invalid-feedback" role="alert">' + getValueFromLanguage('ModalProjectMemberEmailErrorText') + '</div>' +
                '            </div>' +
                '            <div class="mb-2">' +
                '                <select id="modal-member-select-new" class="btn btn-sm btn-modal-select" aria-label="' + getValueFromLanguage('ModalProjectMemberStatus') + '" required>' +
                '                    <option value="' + authModalSelectMemberStatusValues[0] + '">' + getValueFromLanguage('ModalProjectMemberReader') + '</option>' +
                '                    <option value="' + authModalSelectMemberStatusValues[1] + '">' + getValueFromLanguage('ModalProjectMemberEditor') + '</option>' +
                '                </select>' +
                '                <div id="error-memberStatusNew" class="invalid-feedback" role="alert">' + getValueFromLanguage('ModalProjectMemberErrorText') + '</div>' +
                '            </div>' +
                '            <div class="d-grid gap-2 d-md-flex justify-content-md-end">' +
                '                <button class="btn btn-secondary btn-sm me-md-2" type="reset" id="memberNewCancel">' + getValueFromLanguage('CancelModalNav') + '</button>' +
                '                <button class="btn btn-primary btn-sm btn-task-create" type="submit" id="memberNewCreate" disabled>' + getValueFromLanguage('ModalProjectMemberAddText') + '</button>' +
                '            </div>' +
                '        </div>'
        }
    }

    content +=
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</form>'

    $("#modal-body").html(content)
    $("#modal-body").attr("data-id", catId)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalSubCategory(catId)
{
    let sub = getSubInCurrentById(catId)

    // get from categories where id=id
    $("#modal-title").html(getValueFromLanguage('ModalSubCategoryEditName'))
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">' + getValueFromLanguage('CancelModalNav') + '</button>' +
        '<button type="button" id="modal-submit-subcategory" class="btn btn-primary">' + getValueFromLanguage('SaveModalNav') + '</button>')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
        '<div class="col-12">' +
        '<label for="modal-input-name" class="form-label">' + getValueFromLanguage('ModalInputName') + '</label>' +
        '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" value="' + sub.name + '" placeholder="' + getValueFromLanguage('ModalInputCategoryName') + '" title="' + getValueFromLanguage('ModalInputCategoryName') + '" required>' +
        '<div id="error-modal" class="invalid-feedback" role="alert">' + getValueFromLanguage('NewTaskNameError') + '</div>' +
        '</div>' +
        '</form>')

    $("#modal-body").attr("data-id", sub.id)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalTask(subCatId, taskId)
{
    let task = getTaskInCurrentById(subCatId, taskId)

    // get from categories where id=id
    $("#modal-title").html(getValueFromLanguage('ModalTaskEditName'))
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">' + getValueFromLanguage('CancelModalNav') + '</button>' +
        '<button type="button" id="modal-submit-task" class="btn btn-primary">' + getValueFromLanguage('SaveModalNav') + '</button>')

    let content =
        '<form class="row g-3 form-check">' +
        '<div class="col-12">' +
        '<label for="modal-input-name" class="form-label">' + getValueFromLanguage('ModalInputName') + '</label>' +
        '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" value="' + task.name + '" placeholder="' + getValueFromLanguage('ModalInputTaskName') + '" title="' + getValueFromLanguage('ModalInputTaskName') + '" required>' +
        '<div id="error-modal" class="invalid-feedback" role="alert">' + getValueFromLanguage('NewTaskNameError') + '</div>' +
        '</div>' +
        '<div class="col-12">' +
        '<label for="modal-input-description" class="form-label">' + getValueFromLanguage('ModalInputDescription') + '</label>' +
        '<textarea id="modal-input-description" class="form-control form-control-sm bg-secondary" rows="3" placeholder="' + getValueFromLanguage('TaskDescriptionTitle') + '" title="' + getValueFromLanguage('TaskDescriptionTitle') + '">' + task.description + '</textarea>' +
        '</div>' +
        '<div class="col-12 modal-form-label-select">' +
        '<label for="modal-assign-member" class="form-label">' + getValueFromLanguage('SearchTypeAssigned') + '</label>' +
        '<select id="modal-assign-member" class="mb-2 btn btn-sm btn-modal-select" aria-label="' + getValueFromLanguage('TaskAssignedTitle') + '" required>' +
        '<option value="0">' + getValueFromLanguage('TaskNotAssigned') + '</option>';

    getCurrentCategoryMembers().forEach(function(member) {
        content += '<option value="' + member.user.id + '">' + member.user.username + '</option>'
    })

    content +=
        '</select>' +
        '</div>' +
        '<div id="error-modal-members" class="invalid-feedback" role="alert">' + getValueFromLanguage('ModalProjectMemberExistenceErrorText') + '</div>' +
        '</form>'

    $("#modal-body").html(content)
    let select = document.getElementById("modal-assign-member")
    select.value = task.assigned_id === null ? '0' : task.assigned_id.toString()

    $("#modal-body").attr("data-id", task.id)
    $("#modal-body").attr("data-subCat", task.category_id)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

/* Modal Events */

$(document).ready(
    /* Member in Modal */
    $(document).on('click', "#memberAdd", function (e) {
        toggleForm("memberAdd", "memberNew", "error-memberNew", null)
    }),
    $(document).on('click', "#memberNewCancel", function (e) {
        toggleForm("memberAdd", "memberNew", null, "#memberNewCreate")
    }),
    $(document).on('click', "#memberNewCreate", function (e) {
        addMemberCheck(e)
    }),
    $(document).on('keyup', "#memberNewName", function (e) {
        checkEmailOnKeyup("#memberNewName", "error-memberNew", "#memberNewCreate")
    }),

    /* Comments in Modal */
    $(document).on('click', "#commentAdd", function (e) {
        toggleForm("commentAdd", "commentNew", "error-commentNew", null)
    }),
    $(document).on('click', "#commentNewCancel", function (e) {
        toggleForm("commentAdd", "commentNew", null, "#commentNewCreate")
    }),
    $(document).on('click', "#commentNewCreate", function (e) {
        addCommentCheck(e)
    }),
    $(document).on('keyup', "#commentNewDescription", function (e) {
        checkInputOnKeyup("#commentNewDescription", "error-commentNew", "#commentNewCreate")
    }),

    /* Submit Modal */
    $(document).on('click', "#modal-submit-category", function (e) {
        submitModalCategory()
    }),
    $(document).on('click', "#modal-submit-subcategory", function (e) {
        submitModalSubCategory()
    }),
    $(document).on('click', "#modal-submit-task", function (e) {
        submitModalTask()
    }),
    $(document).on('keyup', "#modal-input-name", function (e) {
        checkInputOnKeyup("#modal-input-name", "error-modal", "#modal-submit-category")
        checkInputOnKeyup("#modal-input-name", "error-modal", "#modal-submit-subcategory")
        checkInputOnKeyup("#modal-input-name", "error-modal", "#modal-submit-task")
    })
);