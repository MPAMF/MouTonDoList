function getCurrentCategoryMembers() {
    return data.categories[data.currentCategoryIdx].members
}

function getCategoryMembersById(catId) {
    return getCategoryContainerById(catId).members
}

function getCurrentCategory() {
    return data.categories[data.currentCategoryIdx].category
}

function getCategoryContainerById(catId) {
    let catIdx = data.categories.findIndex(c => c.category_id === catId)
    return data.categories[catIdx]
}

function getCategoryById(catId) {
    return getCategoryContainerById(catId).category
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

function isCurrentCategory(id) { return id === data.currentCategoryId }

function isCanEdit() { return data.canEdit }
function isCanEditById(catId) { return getCategoryContainerById(catId).can_edit }

function isOwner() { return data.user.id === getCurrentCategory().owner_id }
function isOwnerById(catId) { return data.user.id === getCategoryById(catId).owner_id }

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