const dashboard = "/dashboard"

function getCommentTemplate() {
    return {
        author: null,
        author_id: null,
        content: null,
        date: null,
        id: null,
        task: null,
        task_id: null
    }
}

function getTaskTemplate() {
    return {
        assigned: null,
        assigned_id: null,
        category: null,
        category_id: null,
        checked: null,
        comments: null,
        description: null,
        due_date: null,
        id: null,
        last_editor: null,
        last_editor_id: null,
        name: null,
        position: null
    }
}

function getSubCatTemplate() {
    return {
        archived: null,
        color: null,
        id: null,
        name: null,
        owner: null,
        owner_id: null,
        parent_category: null,
        parent_category_id: null,
        position: null
    }
}

function getCatTemplate() {
    return {
        accepted: null,
        can_edit: null,
        category_id: null,
        date: null,
        id: null,
        members: null,
        user: null,
        user_id: null,
        category: getSubCatTemplate()
    }
}

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

function getGlobalCategoryById(catId) {
    return getCategoryContainerById(catId)
}

function getCurrentGlobalCategory() {
    return data.categories[data.currentCategoryIdx]
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
function userIsOwner(catId, userId) { return userId === getCategoryById(catId).owner_id }

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

function moveTaskFromData(taskId, oldSubCategoryId, oldIndex, newSubCategoryId, newIndex) {
    if(oldSubCategoryId === newSubCategoryId)
    {
        if(oldIndex < newIndex)
            newIndex++
        else if(newIndex < oldIndex)
            oldIndex++
    }
    let task = {...getTask(oldSubCategoryId, taskId)}
    let subCatIdx = getSubCategoryIdx(newSubCategoryId)
    let subCat = getSubCategoryByIdx(subCatIdx)
    subCat.tasks.splice(newIndex, 0, task)

    removeTaskFromData(oldSubCategoryId, oldIndex)
}


function moveSubCatFromData(subCatId, oldIndex, newIndex) {
    let a = getSubCategoryByIdx(oldIndex)
    a.position = newIndex
    let b = getSubCategoryByIdx(newIndex)
    b.position = oldIndex
}

function setCatToArchivedTrueFromData(catId) {
    let cat = getCategoryById(catId)
    cat.archived = true
    return cat
}

function setCatToArchivedFalseFromData(catId) {
    let cat = getCategoryById(catId)
    cat.archived = false
    return cat
}

function getCategoryIdx(catId) {
    return data.categories.findIndex(c => c.category_id === catId)
}

function removeCatFromData(catId) {
    let catIdx = getCategoryIdx(catId)
    data.categories.splice(catIdx, 1)
}

function duplicateCatFromData(id, newId) {
    newId = parseInt(newId)
    let cat = getGlobalCategoryById(id)
    let newCat = {...cat}
    newCat.category_id = newId
    newCat.category.id = newId
    newCat.category.subCategories.forEach(function (subcat) {
        subcat.parent_category_id = newId
    })
    newCat.members.forEach(function(member) {
        member.category_id = newId
        member.category.id = newId
    })
    data.categories.push(cat)
}

function removeSubCatFromData(id) {
    let cat = getCurrentCategory()
    let idx = getSubCategoryIdx(id)
    cat.subCategories.splice(idx, 1)
}

function removeMemberFromData(catId, userId) {
    if(userIsOwner(catId, userId)) {
        leaveCategory(catId)
        return
    }
    let cat = getGlobalCategoryById(catId)
    let idx = cat.members.findIndex(m => m.user_id === userId)
    cat.members.splice(idx, 1)
}

function getCommentIdx(task, id) {
    return task.comments.findIndex(c => c.id === id)
}

function removeCommentFromData(subCatId, taskId, id) {
    let task = getTask(subCatId, taskId)
    let idx = getCommentIdx(task, id)
    task.comments.splice(idx, 1)
}

function addCommentToData(subCatId, taskId, newId, content) {
    let comment = getCommentTemplate()
    comment.author = data.user
    comment.author_id = data.user.id
    comment.content = content
    comment.date = Date()
    comment.id = newId
    comment.task = null
    comment.task_id = taskId
    let task = getTask(subCatId, taskId)
    task.comments.push(comment)
}

function getTaskMaxPosition(subCatId) {
    let subcatIdx = getSubCategoryIdx(subCatId)
    let subcat = getSubCategoryByIdx(subcatIdx)
    let max = 0
    subcat.tasks.forEach(function(task) {
        if(task.position > max)
            max = task.position
    })
    return max
}

function addTaskToData(assignedId, subCatId, newId, name, desc) {
    let task = getTaskTemplate()

    if(assignedId !== 0)
        task.assigned_id = assignedId
    task.category_id = subCatId
    task.checked = false
    task.comments = []
    task.description = desc
    task.id = newId
    task.name = name
    task.position = getTaskMaxPosition(subCatId) + 1

    let subcatidx = getSubCategoryIdx(subCatId)
    getSubCategoryByIdx(subcatidx).tasks.push(task)
}

function getSubCatMaxPosition() {
    let cat = getCurrentCategory()
    let max = 0
    cat.subCategories.forEach(function(subCat) {
        if(subCat.position > max)
            max = subCat.position
    })
    return max
}

function prepareSubCatToData(id, name) {
    let subCat = getSubCatTemplate()

    subCat.archived = false
    subCat.color = "#DAF7A6" // temp
    subCat.name = name
    subCat.owner_id = data.user.id
    subCat.parent_category_id = id
    subCat.position = getSubCatMaxPosition() + 1

    return subCat
}

function addSubCatToData(subCat) {
    getCurrentCategory().subCategories.push(subCat)
}

function prepareCatForData() {
    let cat = getCatTemplate()

    cat.accepted = true
    cat.can_edit = true
    cat.date = Date()
    cat.user_id = data.user.id

    cat.category.archived = false
    cat.category.name = name
    cat.category.owner_id = data.user.id
    cat.category.position = 0
    cat.category.subCategories = []

    cat.members = []
    cat.members.push({
        user_id: data.user.id,
        user: data.user
    })

    return cat
}

function addCatToData(cat) {
    storagePushToCategories(cat.category_id, false)
    data.categories.push(cat)
}

function getMember(userId) {
    let cat = getCurrentGlobalCategory()
    let idx = cat.members.findIndex(m => m.user_id === userId)
    return cat.members[idx]
}

function updateTaskFromData(subCatId, taskId, newName, newDesc, newAssigned) {
    let task = getTask(subCatId, taskId)
    task.name = newName
    task.description = newDesc
    task.assigned_id = newAssigned
    task.assigned = newAssigned === 0 ? null : getMember(newAssigned)
}

function updateSubCatFromData(subCatId, newName) {
    let idx = getSubCategoryIdx(subCatId)
    let subcat = getSubCategoryByIdx(idx)
    subcat.name = newName
}

function updateCatFromData(catId, newName) {
    let cat = getCategoryById(catId)
    cat.name = newName
}

function setUserThemeFromData(theme) {
    data.user.theme = theme
}

function setLanguageThemeFromData(language) {
    data.user.language = language
}