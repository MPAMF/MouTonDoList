const dashboard = "/dashboard"

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

function getCurrentCategoryMembersAsArray() {
    let members = getCurrentCategoryMembers()
    let result = []
    members.forEach(function(member) {
        result.push(member.user_id.toString())
    })
    return result
}

function getMemberUsernameById(value) {
    let members = getCurrentCategoryMembers()
    let found = false
    let username = null
    members.forEach(function(member) {
        if(found) return
        if(member.user.id.toString() === value.toString()){
            found = true
            username = member.user.username
        }
    })
    return username
}

function getCurrentMemberUsername() {
    return data.user.username
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
        return Math.floor(interval) + " " + getValueFromLanguage("TimeYears");
    }
    interval = seconds / 2592000;
    if (interval > 1) {
        return Math.floor(interval) + " " + getValueFromLanguage("TimeMonths");
    }
    interval = seconds / 86400;
    if (interval > 1) {
        return Math.floor(interval) + " " + getValueFromLanguage("TimeDays");
    }
    interval = seconds / 3600;
    if (interval > 1) {
        return Math.floor(interval) + " " + getValueFromLanguage("TimeHours");
    }
    interval = seconds / 60;
    if (interval > 1) {
        return Math.floor(interval) + " " + getValueFromLanguage("TimeMinutes");
    }
    return getValueFromLanguage("TimeNow");;
}

function getSubCategories() {
    return data.categories[data.currentCategoryIdx].category.subCategories
}

function getSubCategoryIdx(idSubCat) {
    let subCategories = getSubCategories()
    return subCategories.findIndex(c => c.id === idSubCat)
}

function getSubCategoryByIdx(subCatIdx) {
    return data.categories[data.currentCategoryIdx].category.subCategories[subCatIdx]
}

function getTaskIdx(subCat, idTask) {
    return subCat.tasks.findIndex(t => t.id === idTask)
}

function getTaskByIdx(subCat, taskIdx) {
    return subCat.tasks[taskIdx]
}

function getTask(idSubCat, idTask) {
    let subCatIdx = getSubCategoryIdx(idSubCat)
    let subCat = getSubCategoryByIdx(subCatIdx)
    let taskIdx = getTaskIdx(subCat, idTask)
    return getTaskByIdx(subCat, taskIdx)
}

function getTaskName(idSubCat, idTask) {
    return getTask(idSubCat, idTask).name
}

function setTaskNewId(task, newId) {
    task.id = newId
    task.comments.forEach(function(comment) {
        comment.task_id = newId
    })
}

function setTaskNewName(task, newName) {
    task.name = newName
}

function setTaskChecked(idSubCat, idTask, value) {
    let task = getTask(idSubCat, idTask)
    task.checked = value
}

function removeTaskFromData(idSubCat, taskIdx) {
    let subCatIdx = getSubCategoryIdx(idSubCat)
    let subCat = getSubCategoryByIdx(subCatIdx)
    subCat.tasks.splice(taskIdx, 1)
}

function duplicateTaskFromData(idSubCat, idTask, newTaskId, newTaskName) {
    let subCatIdx = getSubCategoryIdx(idSubCat)
    let subCat = getSubCategoryByIdx(subCatIdx)
    let taskIdx = getTaskIdx(subCat, idTask)
    let task = getTaskByIdx(subCat, taskIdx)
    let newTask = {...task}
    setTaskNewId(newTask, parseInt(newTaskId))
    setTaskNewName(newTask, newTaskName)
    subCat.tasks.push(newTask)
}

function insertTaskFromData(task, idSubCat, taskIdx) {
    let subCatIdx = getSubCategoryIdx(idSubCat)
    let subCat = getSubCategoryByIdx(subCatIdx)
    console.log(subCat.tasks)
    subCat.tasks.splice(taskIdx, 0, task)
    console.log(subCat.tasks)
}

function moveTaskFromData(taskId, oldSubCategoryId, oldIndex, newSubCategoryId, newIndex) {
    if(oldSubCategoryId === newSubCategoryId)
    {
        console.log(oldIndex, newIndex)
        if(oldIndex < newIndex)
            newIndex++
        else if(newIndex < oldIndex)
            oldIndex++
    }
    let task = {...getTask(oldSubCategoryId, taskId)}
    let subCatIdx = getSubCategoryIdx(newSubCategoryId)
    let subCat = getSubCategoryByIdx(subCatIdx)
    console.log(subCat.tasks)
    subCat.tasks.splice(newIndex, 0, task)
    console.log(subCat.tasks)

    removeTaskFromData(oldSubCategoryId, oldIndex)
    console.log(subCat)
}