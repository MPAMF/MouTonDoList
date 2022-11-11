function openModalCategory(id)
{
    // get from categories where id=id
    $("#modal-title").html('Category ' + id)
    $("#modal-body").html(id)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openModalSubCategory(id)
{
    // get from categories where id=id
    $("#modal-title").html('SubCategory ' + id)
    $("#modal-body").html(id)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

function openModalTask(idCat, idTask)
{
    // get from categories where id=id
    $("#modal-title").html('Task ' + idCat + "-" + idTask)
    $("#modal-body").html(idCat + "-" + idTask)
    const modal = new bootstrap.Modal('#modal', {})
    modal.show(document)
}

$(document).ready(function () {
    $("[data-bs-popover=category-popover]").popover({
        trigger: 'focus',
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
        trigger: 'focus',
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
        trigger: 'focus',
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
        trigger: 'focus',
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
        trigger: 'focus',
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