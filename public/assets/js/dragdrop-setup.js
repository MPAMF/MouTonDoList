/* Drag task */
var els = document.getElementsByClassName("task-tasks");
Array.prototype.forEach.call(els, function(el) {
    new Sortable(el, {
        group: 'task-tasks-shared',
        animation: 300,
        ghostClass: "task-drag-ghost",  // Class name for the drop placeholder
        chosenClass: "task-drag-chosen",  // Class name for the chosen item
        dragClass: "task-drag-dragging",  // Class name for the dragging item
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
els = document.getElementsByClassName("task-categories");
Array.prototype.forEach.call(els, function(el) {
    new Sortable(el, {
        group: 'task-categories-shared',
        animation: 300,
        ghostClass: "task-drag-ghost",  // Class name for the drop placeholder
        chosenClass: "task-drag-chosen",  // Class name for the chosen item
        dragClass: "task-drag-dragging",  // Class name for the dragging item
        handle: ".btn-category-drag",
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