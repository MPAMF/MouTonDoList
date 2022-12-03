function openTaskDetails(subCatId, taskId)
{
    let task = getTaskInCurrentById(subCatId, taskId)

    // get from categories where id=id
    $("#modal-title").html('Détail de la tâche')
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>')

    let content = '' +
        '<div>' +
        '    <div class="form-check task-view-details">' +
        '        <input class="form-check-input task-checkbox" type="checkbox" value="" title="Etat de la tâche" ' + (task.checked ? "checked" : "") +'>' +
        '        <div class="task-view-info">' +
        '            <label class="form-check-label" title="Nom de la tâche">' + task.name + '</label>' +
        '            <small class="form-text text-muted assigned-member" title="Membre assignée à la tâche">' + (task.assigned === null ? '' : task.assigned) + '</small>' +
        '            <small class="form-text text-muted" title="Description de la tâche">' + (task.description == null ? '' : task.description) + '</small>' +
        '        </div>' +
        '    </div>' +
        '</div>' +
        '<div class="accordion accordion-flush" id="accordion-comments">' +
        '           <div class="accordion-item accordion-item-tasks">' +
        '               <h2 class="accordion-header subcategory-header" id="accordion-header-comments">' +
        '                   <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-body-comments" aria-expanded="false" aria-controls="accordion-body-comments">' +
        '                       Liste des commentaires' +
        '                   </button>' +
        '               </h2>' +
        '               <div id="accordion-body-comments" class="accordion-collapse collapse" aria-labelledby="accordion-header-comments" data-bs-parent="#accordion-comments">' +
        '                   <div class="accordion-body">' +
        '                       <ul class="list-group list-group-flush">';

    (task.comments).forEach(function(comment) {
        content +=
        '            <li class="list-group-item modal-comment">' +
        '                <div class="d-flex justify-content-between align-items-center">' +
        '                    <p class="mb-1">' +
        '                        ' + (comment.author === null ? 'Unknown' : comment.author.username) + ' <small class="form-text text-muted" title="Date du commentaire">' + timeSince(Date.parse(comment.date)) + ' ago </small>' +
        '                    </p>' +
        '                    <button class="btn btn-sm modal-delete-comment" type="button" title="Suppression du commentaire">' +
        '                        <span class="mdi mdi-18px mdi-trash-can"></span>' +
        '                    </button>' +
        '                </div>' +
        '                <p class="small mb-0">' + comment.content + '</p>' +
        '            </li>'
    })

    content += '' +
        '        </ul>' +
        '        <div>' +
        '            <button class="btn btn-task-add" type="button" id="commentAdd">' +
        '                <span class="mdi mdi-plus-circle"></span>' +
        '                Ajouter un commentaire' +
        '            </button>' +
        '        </div>' +
        '        <form class="task-new" id="commentNew">' +
        '            <div class="mb-2">' +
        '                <textarea class="form-control form-control-sm bg-secondary" rows="3" id="commentNewDescription" placeholder="Description" title="Description du commentaire" ></textarea>' +
        '                <div id="error-commentNew" class="invalid-feedback" role="alert"> Veuillez indiquer un commentaire. </div>' +
        '            </div>' +
        '            <div class="d-grid gap-2 d-md-flex justify-content-md-end">' +
        '                <button class="btn btn-secondary btn-sm me-md-2" type="reset" id="commentNewCancel">Annuler</button>' +
        '                <button class="btn btn-primary btn-sm btn-task-create" type="submit" id="commentNewCreate" disabled>Ajouter le commentaire</button>' +
        '            </div>' +
        '        </form>' +
        '    </div>' +
        '</div>'

    $("#modal-body").html(content)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalCategory()
{
    let category = getCurrentCategory()

    // get from categories where id=id
    $("#modal-title").html('Modifier le projet')
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>' +
        '<button type="button" id="modal-submit" class="btn btn-primary">Enregistrer</button>')

    let content =
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom du projet" title="Nom du projet" value="' + category.name + '" required>' +
                '<div id="error-modal" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
            '<div class="col-12 checkbox">' +
                '<input id="modal-checkbox-subcategory" class="form-check-input task-checkbox" type="checkbox" value="">' +
                '<label for="modal-checkbox-subcategory">Masquer les sections archivées</label>' +
            '</div>' +
            '<div class="col-12 checkbox">' +
                '<input id="modal-checkbox-task" class="form-check-input task-checkbox" type="checkbox" value="">' +
                '<label for="modal-checkbox-task">Masquer les tâches effectuées</label>' +
            '</div>' +
            '<div class="accordion accordion-flush">' +
                '<div class="accordion-item accordion-item-tasks">' +
                    '<h2 class="accordion-header subcategory-header" id="flush-headingOne">' +
                        '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">' +
                            'Liste des membres' +
                        '</button>' +
                    '</h2>' +
                    '<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"> ' +
                        '<div class="accordion-body">' +
                            '<ul class="list-group list-group-flush tasks">';

    getCurrentCategoryMembers().forEach(function(member) {
        content +=
            '<li class="list-group-item list-member">' +
                '<div class="col py-1">' +
                    '<label class="my-0 fw-normal">' + member.username + '</label>' +
                '</div>' +
                '<div class="col py-1">' +
                    '<select name="modal-member-select" id="modal-member-select-1" class="btn btn-sm btn-modal-select" aria-label="Rôle du membre" required>' +
                        '<option value="1">Lecteur</option>' +
                        '<option value="2">Editeur</option>' +
                        '<option value="3">Propriétaire</option>' +
                    '</select>' +
                '</div>' +
                '<div class="col py-1">' +
                    '<button type="button" class="btn btn-sm btn-modal-remove">' +
                        '<span class="mdi mdi-14px mdi-close-thick"></span> Retirer' +
                    '</button>' +
                '</div>' +
            '</li>'
    })

    content +=
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div id="error-modal-members" class="invalid-feedback" role="alert"> Le rôle d\'un des membres n\'est pas valide. </div>' +
        '</form>'

    $("#modal-body").html(content)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalSubCategory(catId)
{
    let sub = getSubInCurrentById(catId)

    // get from categories where id=id
    $("#modal-title").html('Modifier la catégorie')
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>' +
        '<button type="button" id="modal-submit" class="btn btn-primary">Enregistrer</button>')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" value="' + sub.name + '" placeholder="Nom de la catégorie" title="Nom de la catégorie" required>' +
                '<div id="error-modal" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalTask(subCatId, taskId)
{
    let task = getTaskInCurrentById(subCatId, taskId)

    // get from categories where id=id
    $("#modal-title").html('Modifier la tâche')
    $("#modal-footer").html('' +
        '<button type="reset" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>' +
        '<button type="button" id="modal-submit" class="btn btn-primary">Enregistrer</button>')

    let content =
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" value="' + task.name + '" placeholder="Nom de la tâche" title="Nom de la tâche" required>' +
                '<div id="error-modal" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
            '<div class="col-12">' +
                '<label for="modal-input-description" class="form-label">Description</label>' +
                '<textarea id="modal-input-description" class="form-control form-control-sm bg-secondary" rows="3" placeholder="Description de la tâche" title="Description de la tâche">' + task.description + '</textarea>' +
            '</div>' +
            '<div class="col-12 modal-form-label-select">' +
                '<label for="modal-assign-member" class="form-label">Assigné</label>' +
                '<select id="modal-assign-member" class="mb-2 btn btn-sm btn-modal-select" aria-label="Membre assigné" required>' +
                    '<option value="0" selected>Non assignée</option>';

    getCurrentCategoryMembers().forEach(function(member) {
        content += '<option value="' + member.id + '">' + member.username + '</option>'
    })

    content +=
                '</select>' +
            '</div>' +
        '</form>'

    $("#modal-body").html(content)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

/* Modal Events */

$(document).ready(
    /* Comments in Modal */
    $(document).on('click', "#commentAdd", function (e) {
        toggleForm("commentAdd", "commentNew", "error-commentNew", null)
    }),
    $(document).on('click', "#commentNewCancel", function (e) {
        toggleForm("commentAdd", "commentNew", null, "#commentNewCreate")
    }),
    $(document).on('click', "#commentNewCreate", function (e) {
        checkInputOnSubmit("#commentNewDescription", "error-commentNew")
    }),
    $(document).on('keyup', "#commentNewDescription", function (e) {
        checkInputOnKeyup("#commentNewDescription", "error-commentNew", "#commentNewCreate")
    }),

    /* Submit Modal */
    $(document).on('click', "#modal-submit", function (e) {
        checkInputOnSubmit("#modal-input-name", "error-modal")
        let selectsName = document.getElementsByName("modal-member-select")
        checkSelectValuesOnSubmit(selectsName, "error-modal-members", authModalSelectMemberStatusValues)
    }),
    $(document).on('keyup', "#modal-input-name", function (e) {
        checkInputOnKeyup("#modal-input-name", "error-modal", "#modal-submit")
    })
);