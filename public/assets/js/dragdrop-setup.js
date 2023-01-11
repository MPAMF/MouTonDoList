function addGrabbing() {
    document.body.classList.add('grabbing')
}
function removeGrabbing() {
    document.body.classList.remove('grabbing')
}

function defaultSortable() {
    return {
        animation: 300,
        ghostClass: "drag-ghost",  // Class name for the drop placeholder
        chosenClass: "drag-chosen",  // Class name for the chosen item
        dragClass: "drag-dragging",  // Class name for the dragging item
        forceFallback: true,
        onChoose: addGrabbing,
        onUnchoose: removeGrabbing,
        onStart: addGrabbing,
        onMove: addGrabbing,
    }
}

function getTasksSortable() {
    let sortable = defaultSortable()
    sortable.group = "tasks-shared"
    sortable.handle = ".btn-task-drag"
    sortable.onEnd = function (e) {
        removeGrabbing()
        let taskId = e.item.getAttribute("data-idTask")
        let oldSubCategoryId = e.from.getAttribute("data-subcategory-list-id")
        let newSubCategoryId = e.to.getAttribute("data-subcategory-list-id")
        moveTask(parseInt(taskId), parseInt(oldSubCategoryId), e.oldIndex, parseInt(newSubCategoryId), e.newIndex)
    }
    return sortable
}

function getCategoriesSortable() {
    let sortable = defaultSortable()
    sortable.group = "categories-shared"
    sortable.handle = ".btn-subcategory-drag"
    sortable.onEnd = function (e) {
        removeGrabbing()
        let subCatId = e.item.getAttribute("data-idSubCat")
        moveSubCategory(subCatId, e.oldIndex, e.newIndex)
    }
    return sortable
}

Array.prototype.forEach.call($("[data-sortable=tasks]"), function(el) {
    new Sortable(el, getTasksSortable())
});

Array.prototype.forEach.call($("[data-sortable=categories]"), function(el) {
    new Sortable(el, getCategoriesSortable())
});