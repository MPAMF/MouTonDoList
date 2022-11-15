function openTaskDetails(idCat, idTask)
{
    // get from categories where id=id
    $("#modal-title").html('Commentaires de la tâche ')
    $("#modal-footer").html('' +
        '<button type="button" id="modal-cancel" class="btn btn-secondary" onclick="toggleNewCommentIfExists()" data-bs-dismiss="modal">Annuler</button>')
    $("#modal-body").html('<div class="row">' +
        '                    <div class="col">' +
        '                        <div class="modal-comment">' +
        '                            <div class="d-flex justify-content-between align-items-center">' +
        '                                <p class="mb-1">' +
        '                                    Maria Smantha <small class="form-text text-muted" title="Date du commentaire">13/11/2022 17:37</small>' +
        '                                </p>' +
        '                                <button class="btn btn-sm modal-delete-comment" type="button" title="Suppression du commentaire">' +
        '                                    <span class="mdi mdi-18px mdi-trash-can"></span>' +
        '                                </button>' +
        '                            </div>' +
        '                            <p class="small mb-0">' +
        '                                It is a long established fact that a reader will be distracted by' +
        '                                the readable content of a page.' +
        '                            </p>' +
        '                        </div>' +
        '                        <div class="modal-comment">' +
        '                            <div class="d-flex justify-content-between align-items-center">' +
        '                                <p class="mb-1">' +
        '                                    Natalie Smith <small class="form-text text-muted" title="Date du commentaire">14/11/2022 21:23</small>' +
        '                                </p>' +
        '                                <button class="btn btn-sm modal-delete-comment" type="button" title="Suppression du commentaire">' +
        '                                    <span class="mdi mdi-18px mdi-trash-can"></span>' +
        '                                </button>' +
        '                            </div>' +
        '                            <p class="small mb-0">' +
        '                                The standard chunk of Lorem Ipsum used since the 1500s is' +
        '                                reproduced below for those interested. Sections 1.10.32 and' +
        '                                1.10.33.' +
        '                            </p>' +
        '                        </div>' +
        '                        <div>' +
        '                            <button class="btn btn-task-add" type="button" id="commentAdd">' +
        '                                <span class="mdi mdi-plus-circle"></span>' +
        '                                Ajouter un commentaire' +
        '                            </button>' +
        '                        </div>' +
        '                        <form class="task-new" id="commentNew">' +
        '                            <div class="mb-2">' +
        '                                <input type="text" class="form-control form-control-sm bg-secondary" id="commentNewTitle" placeholder="Titre du commentaire" title="Nom du commentaire" required>' +
        '                                <div id="error-commentNew" class="invalid-feedback" role="alert"> Veuillez indiquer un titre. </div>' +
        '                            </div>' +
        '                            <div class="mb-2">' +
        '                                <textarea class="form-control form-control-sm bg-secondary" rows="3" id="commentNewDescription" placeholder="Description" title="Description du commentaire" ></textarea>' +
        '                            </div>' +
        '                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">' +
        '                                <button class="btn btn-secondary btn-sm me-md-2" type="button" id="commentNewCancel">Annuler</button>' +
        '                                <button class="btn btn-primary btn-sm btn-task-create" type="submit" id="commentNewCreate" disabled>Ajouter le commentaire</button>' +
        '                            </div>' +
        '                        </form>' +
        '                    </div>' +
        '                </div>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalCategory(id)
{
    // get from categories where id=id
    $("#modal-title").html('Modifier le projet')
    $("#modal-footer").html('' +
        '<button type="button" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>' +
        '<button type="button" id="modal-submit" class="btn btn-primary">Enregistrer</button>')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom du projet" title="Nom du projet" required>' +
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
                            '<ul class="list-group list-group-flush tasks">' +
                                '<li class="list-group-item list-member">' +
                                    '<div class="col py-1">' +
                                        '<label class="my-0 fw-normal">Victor</label>' +
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
                                '</li>' +
                                '<li class="list-group-item list-member">' +
                                    '<div class="col py-1">' +
                                        '<label class="my-0 fw-normal">Paul</label>' +
                                    '</div>' +
                                    '<div class="col py-1">' +
                                        '<select name="modal-member-select" id="modal-member-select-2" class="btn btn-sm btn-modal-select" aria-label="Rôle du membre" required>' +
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
                                '</li>' +
                            '</ul>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div id="error-modal-members" class="invalid-feedback" role="alert"> Le rôle d\'un des membres n\'est pas valide. </div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalSubCategory(id)
{
    // get from categories where id=id
    $("#modal-title").html('Modifier la catégorie')
    $("#modal-footer").html('' +
        '<button type="button" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>' +
        '<button type="button" id="modal-submit" class="btn btn-primary">Enregistrer</button>')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom de la catégorie" title="Nom de la catégorie" required>' +
                '<div id="error-modal" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openEditModalTask(idCat, idTask)
{
    // get from categories where id=id
    $("#modal-title").html('Modifier la tâche')
    $("#modal-footer").html('' +
        '<button type="button" id="modal-cancel" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>' +
        '<button type="button" id="modal-submit" class="btn btn-primary">Enregistrer</button>')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom de la tâche" title="Nom de la tâche" required>' +
                '<div id="error-modal" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
            '<div class="col-12">' +
                '<label for="modal-input-description" class="form-label">Description</label>' +
                '<textarea id="modal-input-description" class="form-control form-control-sm bg-secondary" rows="3" placeholder="Description de la tâche" title="Description de la tâche"></textarea>' +
            '</div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

/* Modal Events */

function toggleNewCommentIfExists() {
    if(document.getElementById("commentAdd").classList.contains("btn-task-add-unactive"))
        toggleForm("commentAdd", "commentNew", "commentNewTitle", "commentNewDescription", null)
}

$(document).ready(
    /* Comments in Modal */
    $(document).on('click', "#commentAdd", function (e) {
        toggleForm("commentAdd", "commentNew", "commentNewTitle", "commentNewDescription", null)
    }),
    $(document).on('click', "#commentNewCancel", function (e) {
        toggleForm("commentAdd", "commentNew", "commentNewTitle", "commentNewDescription", "error-commentNew")
    }),
    $(document).on('click', "#commentNewCreate", function (e) {
        checkInputOnSubmit("#commentNewTitle", "error-commentNew")
    }),
    $(document).on('keyup', "#commentNewTitle", function (e) {
        checkInputOnKeyup("#commentNewTitle", "error-commentNew", "#commentNewCreate")
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