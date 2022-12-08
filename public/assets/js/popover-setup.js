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
            let isArchive = $(this)[0].activeElement.getAttribute('data-archive').toString();
            let res;
            if(isArchive === "false"){
                res =  '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> Modifier le projet</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="DuplicateCategory(' + id + ')"><span class="mdi mdi-content-duplicate"> Dupliquer le projet</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="ArchiveCategory(' + id + ')"><span class="mdi mdi-archive-outline"></span> Archiver le projet</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="DeleteCategory(' + id + ')"><span class="mdi mdi-trash-can"></span> Supprimer le projet</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="AddSubcategory(' + id + ')"><span class="mdi mdi-plus-circle-outline"> Ajouter une section</button>' +
                    '</div>'
            }
            else{
                res = `<div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                    <button type="button" class="btn btn-sm btn-popover" onclick="DuplicateCategory(` + id + `)"><span class="mdi mdi-content-duplicate"> Dupliquer le projet</button>
                    <button type="button" class="btn btn-sm btn-popover" onclick="UnarchivedCategory(` + id + `)"><span class="mdi mdi-archive-outline"></span> Désarchiver le projet</button>
                    <button type="button" class="btn btn-sm btn-popover" onclick="DeleteCategory(` + id + `)"><span class="mdi mdi-trash-can"></span> Supprimer le projet</button>
                </div>`;
            }
            return res;
        }
    })
    $("[data-bs-popover=category-shared-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let id = $(this)[0].activeElement.getAttribute('data-id').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="DuplicateCategoryShared(' + id + ')"><span class="mdi mdi-content-duplicate"> Dupliquer le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="LeaveCategoryShared(' + id + ')"><span class="mdi mdi-account-minus-outline"></span> Quitter le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="AddSubcategoryShared(' + id + ')"><span class="mdi mdi-plus-circle-outline"> Ajouter une section</button>' +
                '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-plus-circle-outline"> Ajouter une tâche</button>' +
                '</div>'
        }
    })
    $("[data-bs-popover=category-shared-readonly-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let id = $(this)[0].activeElement.getAttribute('data-id').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="DuplicateCategorySharedReadonly(' + id + ')"><span class="mdi mdi-content-duplicate"> Dupliquer le projet</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="LeaveCategorySharedReadonly(' + id + ')"><span class="mdi mdi-account-minus-outline"></span> Quitter le projet</button>' +
                '</div>'
        }
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
            let isArchive = $(this)[0].activeElement.getAttribute('data-archive').toString();
            let res;
            if (isArchive === "false") {
                res = '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalSubCategory(' + id + ')"><span class="mdi mdi-pencil-outline"></span> Modifier la section</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="ArchiveSubcategory(' + id + ')"><span class="mdi mdi-archive-outline"></span> Archiver la section</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="DeleteSubcategory(' + id + ')"><span class="mdi mdi-trash-can"></span> Supprimer la section</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="AddSubcategoryBegin(' + id + ')"><span class="mdi mdi-arrow-up-bold-outline"> Ajouter une section ci-dessus</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="AddSubcategoryEnd(' + id + ')"><span class="mdi mdi-arrow-down-bold-outline"> Ajouter une section ci-dessous</button>' +
                    '</div>'
            } else {
                res = '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="UnarchivedSubcategory(' + id + ')"><span class="mdi mdi-archive-outline"></span> Désarchiver la section</button>' +
                    '<button type="button" class="btn btn-sm btn-popover" onclick="DeleteSubcategoryArchive(' + id + ')"><span class="mdi mdi-trash-can"></span> Supprimer la section</button>' +
                    '</div>'
            }
            return res;
        }
    })
    $("[data-bs-popover=task-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let idCat = $(this)[0].activeElement.parentElement.getAttribute('data-idCat').toString();
            let idTask = $(this)[0].activeElement.parentElement.getAttribute('data-idTask').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="openTaskDetails(' + idCat + ',' + idTask + ')"><span class="mdi mdi-application-outline"></span> Ouvrir le détail</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="openEditModalTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-pencil-outline"></span> Modifier la tâche</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="DuplicateTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-content-duplicate"> Dupliquer la tâche</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="DeleteTask(' + idCat + ',' + idTask + ')"><span class="mdi mdi-trash-can"></span> Supprimer la tâche</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="NewTaskBegin(' + idCat + ',' + idTask + ')"><span class="mdi mdi-arrow-up-bold-outline"> Ajouter une tâche ci-dessus</button>' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="NewTaskEnd(' + idCat + ',' + idTask + ')"><span class="mdi mdi-arrow-down-bold-outline"> Ajouter une tâche ci-dessous</button>' +
                '</div>'
        }
    })
    $("[data-bs-popover=task-readonly-popover]").popover({
        trigger: 'click',
        placement: 'left',
        customClass: 'popover',
        offset: [0, 0],
        html: true,
        sanitize: false,
        content: () => {
            let idCat = $(this)[0].activeElement.parentElement.getAttribute('data-idCat').toString();
            let idTask = $(this)[0].activeElement.parentElement.getAttribute('data-idTask').toString();
            return '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
                '<button type="button" class="btn btn-sm btn-popover" onclick="openTaskDetails(' + idCat + ',' + idTask + ')"><span class="mdi mdi-application-outline"></span> Ouvrir le détail</button>' +
                '</div>'
        }
    })
})