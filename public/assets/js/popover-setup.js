let popover = defaultPopover()

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

function setupCategoryPopover(element, getPopoverContent) {
    let id = element.getAttribute('data-category-id') === null ?
        element.getAttribute('data-sidebar-id').toString() :
        element.getAttribute('data-category-id').toString()
    popover.content = getPopoverContent(id)
    new bootstrap.Popover(element, popover)
}

function setupSubCategoryPopover(element, getPopoverContent) {
    let id = element.getAttribute('data-id').toString();
    popover.content = getPopoverContent(id)
    new bootstrap.Popover(element, popover)
}

function setupTaskPopover(element, getPopoverContent) {
    let idCat = element.parentElement.getAttribute('data-idCat').toString();
    let idTask = element.parentElement.getAttribute('data-idTask').toString();
    popover.content = getPopoverContent(idCat, idTask)
    new bootstrap.Popover(element, popover)
}

$(document).ready(function () {

    $('[data-bs-popover=category-default-popover]').each(function () {
        setupCategoryPopover($(this)[0], getPopoverCategoryDefaultContent)
    });
    $('[data-bs-popover=category-default-archive-popover]').each(function () {
        setupCategoryPopover($(this)[0], getPopoverCategoryDefaultArchiveContent)
    });

    $('[data-bs-popover=category-shared-popover]').each(function () {
        setupCategoryPopover($(this)[0], getPopoverCategorySharedContent)
    });
    $('[data-bs-popover=category-shared-archive-popover]').each(function () {
        setupCategoryPopover($(this)[0], getPopoverCategorySharedArchiveContent)
    });

    $('[data-bs-popover=category-readonly-popover]').each(function () {
        setupCategoryPopover($(this)[0], getPopoverCategoryReadonlyContent)
    });

    $('[data-bs-popover=subcategory-default-popover]').each(function () {
        setupSubCategoryPopover($(this)[0], getPopoverSubCategoryContent)
    });

    $('[data-bs-popover=task-popover]').each(function () {
        setupTaskPopover($(this)[0], getPopoverTaskDefaultContent)
    });

    $('[data-bs-popover=task-readonly-popover]').each(function () {
        setupTaskPopover($(this)[0], getPopoverTaskReadonlyContent)
    });
})