function getCurrentCategoryMembers() {
    return data.categories[data.currentCategoryIdx].members
}

function getCurrentCategory() {
    return data.categories[data.currentCategoryIdx].category
}

function getSubInCurrentById(subCatId) {
    let current = getCurrentCategory()
    let subCatIdx = current.subCategories.findIndex(c => c.id === subCatId)
    return current.subCategories[subCatIdx]
}

function getTaskInCurrentById(subCatId, taskId) {
    let currentSub = getSubInCurrentById(subCatId)
    let taskIdx = currentSub.tasks.findIndex(c => c.id === taskId)
    return currentSub.tasks[taskIdx]
}

function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);

    var interval = seconds / 31536000;

    if (interval > 1) {
        return Math.floor(interval) + " years";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
        return Math.floor(interval) + " months";
    }
    interval = seconds / 86400;
    if (interval > 1) {
        return Math.floor(interval) + " days";
    }
    interval = seconds / 3600;
    if (interval > 1) {
        return Math.floor(interval) + " hours";
    }
    interval = seconds / 60;
    if (interval > 1) {
        return Math.floor(interval) + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}

function moveTask(taskId, oldSubCategoryId, oldIndex, newSubCategoryId, newIndex) {
    console.log("taskId :" + taskId)
    console.log("oldCatId :" + oldSubCategoryId)
    console.log("oldIndex :" + oldIndex)
    console.log("newCatId :" + newSubCategoryId)
    console.log("newIndex :" + newIndex)
}

function moveSubCategory(subCatId, oldIndex, newIndex) {
    console.log("subCatId :" + subCatId)
    console.log("oldIndex :" + oldIndex)
    console.log("newIndex :" + newIndex)
}

function isCanEdit() { return data.canEdit }
function isOwner() { return data.id === getCurrentCategory().owner_id}