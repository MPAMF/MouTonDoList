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
        onEnd: remoteGrabbing,
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
        onEnd: remoteGrabbing,
        onMove: addGrabbing,
    })
});

function addGrabbing() {
    document.body.classList.add('grabbing')
}
function remoteGrabbing() {
    document.body.classList.remove('grabbing')
}