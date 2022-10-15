/* Drag task */
var els = document.getElementsByClassName("tasks");
Array.prototype.forEach.call(els, function(el) {
    new Sortable(el, {
        group: 'tasks-shared',
        animation: 300,
        ghostClass: "drag-ghost",  // Class name for the drop placeholder
        chosenClass: "drag-chosen",  // Class name for the chosen item
        dragClass: "drag-dragging",  // Class name for the dragging item
        handle: ".btn-task-drag",
        forceFallback: true,
        onChoose: function (e) {
            e.target.classList.add('grabbing');
        },
        onUnchoose: function (e) {
            e.target.classList.remove('grabbing');
        },
        onStart: function (e) {
            e.target.classList.add('grabbing');
        },
        onEnd: function (e) {
            e.target.classList.remove('grabbing');
        },
        onMove: function (e) {
            e.target.classList.add('grabbing');
        },
    })
});

/* Drag category */
els = document.getElementsByClassName("categories");
Array.prototype.forEach.call(els, function(el) {
    new Sortable(el, {
        group: 'categories-shared',
        animation: 300,
        ghostClass: "drag-ghost",  // Class name for the drop placeholder
        chosenClass: "drag-chosen",  // Class name for the chosen item
        dragClass: "drag-dragging",  // Class name for the dragging item
        handle: ".btn-subcategory-drag",
        forceFallback: true,
        onChoose: function (e) {
            e.target.classList.add('grabbing');
        },
        onUnchoose: function (e) {
            e.target.classList.remove('grabbing');
        },
        onStart: function (e) {
            e.target.classList.add('grabbing');
        },
        onEnd: function (e) {
            e.target.classList.remove('grabbing');
        },
        onMove: function (e) {
            e.target.classList.add('grabbing');
        },
    })
});