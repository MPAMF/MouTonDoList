$(document).ready(function() {
    $("[data-bs-popover=category-popover]").popover({
        trigger: 'focus',
        placement: 'left',
        customClass: 'popover',
        offset: [0,0],
        html: true,
        sanitize: false,
        content:
            '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-pencil-outline"></span> Modifier la section</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-archive-outline"></span> Archiver la section</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer la section</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-up-bold-outline"> Ajouter une section ci-dessus</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-down-bold-outline"> Ajouter une section ci-dessous</button>' +
            '</div>',

    })
    $("[data-bs-popover=category-archive-popover]").popover({
        trigger: 'focus',
        placement: 'left',
        customClass: 'popover',
        offset: [0,0],
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
        offset: [0,0],
        html: true,
        sanitize: false,
        content:
            '<div class="btn-group-vertical" role="group" aria-label="Vertical button group">' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-pencil-outline"></span> Modifier la tâche</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-content-duplicate"> Dupliquer la tâche</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-delete-outline"></span> Supprimer la tâche</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-up-bold-outline"> Ajouter une tâche ci-dessus</button>' +
            '<button type="button" class="btn btn-sm btn-popover"><span class="mdi mdi-arrow-down-bold-outline"> Ajouter une tâche ci-dessous</button>' +
            '</div>',

    })
})