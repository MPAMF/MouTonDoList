var popoverTriggerList = [].slice.call(document.querySelectorAll(
    '[data-bs-popover="category-popover"]',
    '[data-bs-popover="category-archive-popover"]',
    '[data-bs-popover="category-shared-popover"]',
    '[data-bs-popover="category-shared-readonly-popover"]',
    '[data-bs-popover="subcategory-popover"]',
    '[data-bs-popover="subcategory-archive-popover"]',
    '[data-bs-popover="task-popover"]',
    '[data-bs-popover="task-readonly-popover"]'
))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})