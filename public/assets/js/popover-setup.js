function openModalCategory(id)
{
    // get from categories where id=id
    $("#modal-title").html('Modifier le projet')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom actuel du projet" title="Nom du projet" required>' +
                '<div id="error-taskNew{{ subCatId }}" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
            '<div class="col-12 checkbox">' +
                '<input id="modal-checkbox" class="form-check-input task-checkbox" type="checkbox" value="">' +
                '<label for="modal-checkbox">Masquer les sections archivées</label>' +
            '</div>' +
            '<hr class="my-2">' +
            '<div class="row row-cols-1 row-cols-md-3 py-1 text-center align-items-center">' +
                '<div class="col py-1">' +
                    '<h6 class="my-0 fw-normal">Victor</h6>' +
                '</div>' +
                '<div class="col py-1">' +
                    '<select class="btn btn-sm btn-secondary" data-style="">' +
                        '<option>Lecteur</option>' +
                        '<option>Editeur</option>' +
                    '</select>' +
                '</div>' +
                '<div class="col py-1">' +
                    '<button type="button" class="btn btn-delete btn-sm">' +
                        '<span class="mdi mdi-14px mdi-delete-outline"></span>' +
                    '</button>' +
                '</div>' +
           '</div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openModalSubCategory(id)
{
    // get from categories where id=id
    $("#modal-title").html('Modifier la catégorie ')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom actuel de la catégorie" title="Nom de la catégorie" required>' +
                '<div id="error-taskNew{{ subCatId }}" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
            '<div class="col-12 checkbox">' +
                '<input id="modal-checkbox" class="form-check-input task-checkbox" type="checkbox" value="">' +
                '<label for="modal-checkbox">Masquer les tâches effectuées</label>' +
            '</div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openModalTask(idCat, idTask)
{
    // get from categories where id=id
    $("#modal-title").html('Modifier la tâche ')
    $("#modal-body").html('' +
        '<form class="row g-3 form-check">' +
            '<div class="col-12">' +
                '<label for="modal-input-name" class="form-label">Nom</label>' +
                '<input type="text" id="modal-input-name" class="form-control form-control-sm bg-secondary" placeholder="Nom actuel de la catégorie" title="Nom de la catégorie" required>' +
                '<div id="error-taskNew{{ subCatId }}" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>' +
            '</div>' +
            '<div class="col-12">' +
                '<label for="modal-input-description" class="form-label">Description</label>' +
                '<textarea id="modal-input-description" class="form-control form-control-sm bg-secondary" rows="3" placeholder="Description actuelle de la tâche" title="Description de la tâche"></textarea>' +
            '</div>' +
            '<div class="col-12 checkbox">' +
                '<input id="modal-checkbox" class="form-check-input task-checkbox" type="checkbox" value="">' +
                '<label for="modal-checkbox">Cette tâche a été effectuée</label>' +
            '</div>' +
        '</form>')
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

$(document).ready(
    $('html').on('click', function (e) {
        $('[data-bs=popover]').each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if ((e.target.classList.contains("btn-popover")) || !$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    })
)

$(document).ready(function () {
    $("[data-bs-popover=category-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let id = $(this)[0].activeElement.getAttribute('data-id').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="openModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> Modifier le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-content-duplicate"> Dupliquer le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-archive-outline"></span> Archiver le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-plus-circle-outline"> Ajouter une section</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-plus-circle-outline"> Ajouter une tâche</button>' +
                '</div>'
        }
    })
    $("[data-bs-popover=category-archive-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content:
            '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-content-duplicate"> Dupliquer le projet</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-archive-outline"></span> Désarchiver le projet</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer le projet</button>' +
            '</div>',

    })
    $("[data-bs-popover=subcategory-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let id = $(this)[0].activeElement.getAttribute('data-id').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="openModalSubCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> Modifier la section</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-archive-outline"></span> Archiver la section</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer la section</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-up-bold-outline"> Ajouter une section ci-dessus</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-down-bold-outline"> Ajouter une section ci-dessous</button>' +
                '</div>'
        }
    })
    $("[data-bs-popover=subcategory-archive-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content:
            '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-archive-outline"></span> Désarchiver la section</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer la section</button>' +
            '</div>',

    })
    $("[data-bs-popover=task-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let idCat = $(this)[0].activeElement.getAttribute('data-idCat').toString();
            let idTask = $(this)[0].activeElement.getAttribute('data-idTask').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="openModalTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-pencil-outline"></span> Modifier la tâche</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-content-duplicate"> Dupliquer la tâche</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer la tâche</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-up-bold-outline"> Ajouter une tâche ci-dessus</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-down-bold-outline"> Ajouter une tâche ci-dessous</button>' +
                '</div>'
        }
    })
})