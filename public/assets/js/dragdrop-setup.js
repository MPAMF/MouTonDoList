/* Drag task */
Array.prototype.forEach.call($("[data-sortable=tasks]"), function(el) {
    new Sortable(el, {
        group: 'tasks-shared',
        animation: 300,
        ghostClass: "drag-ghost",  // Class name for the drop placeholder
        chosenClass: "drag-chosen",  // Class name for the chosen item
        dragClass: "drag-dragging",  // Class name for the dragging item
        handle: ".btn-task-drag",
        forceFallback: true,
        onChoose: addGrabbing,
        onUnchoose: remoteGrabbing,
        onStart: addGrabbing,
        onEnd: function (e) {
            remoteGrabbing()
            let taskId = e.item.getAttribute("data-idTask")
            let oldSubCategoryId = e.from.getAttribute("data-subcategory-id")
            let newSubCategoryId = e.to.getAttribute("data-subcategory-id")
            moveTask(taskId, oldSubCategoryId, e.oldIndex, newSubCategoryId, e.newIndex)
        },
        onMove: addGrabbing,
    })
});

/* Drag category */
Array.prototype.forEach.call($("[data-sortable=categories]"), function(el) {
    new Sortable(el, {
        group: 'categories-shared',
        animation: 300,
        ghostClass: "drag-ghost",  // Class name for the drop placeholder
        chosenClass: "drag-chosen",  // Class name for the chosen item
        dragClass: "drag-dragging",  // Class name for the dragging item
        handle: ".btn-subcategory-drag",
        forceFallback: true,
        onChoose: addGrabbing,
        onUnchoose: remoteGrabbing,
        onStart: addGrabbing,
        onEnd: function (e) {
            remoteGrabbing()
            let subCatId = e.item.getAttribute("data-idSubCat")
            moveSubCategory(subCatId, e.oldIndex, e.newIndex)
        },
        onMove: addGrabbing,
    })
});

function addGrabbing() {
    document.body.classList.add('grabbing')
}
function remoteGrabbing() {
    document.body.classList.remove('grabbing')
}