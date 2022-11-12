var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-popover="task-popover"]',
    '[data-bs-popover="subcategory-popover"]', '[data-bs-popover="subcategory-archive-popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

const popover = new bootstrap.Popover('.popover-dismiss', {
    trigger: 'focus'
})