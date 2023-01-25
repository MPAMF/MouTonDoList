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

function getTempTaskCheck(idSubCat, idTask, value) {
    let origin = getTask(idSubCat, idTask)
    let task = {...origin}
    task.checked = value
    return task
}

function setTaskChecked(idSubCat, idTask, value) {
    let task = getTask(idSubCat, idTask)
    task.checked = value
}

function removeTaskFromData(idSubCat, taskId) {
    let subCatIdx = getSubCategoryIdx(idSubCat)
    let subCat = getSubCategoryByIdx(subCatIdx)
    let taskIdx = subCat.tasks.findIndex(t => t.id === taskId)
    let position = subCat.tasks[taskIdx].position
    subCat.tasks.splice(taskIdx, 1)
    shiftPositionsLeft(subCat.tasks, position)
}

function duplicateTaskFromData(idSubCat, idTask, newTaskName) {
    let subCatIdx = getSubCategoryIdx(idSubCat)
    let subCat = getSubCategoryByIdx(subCatIdx)
    let taskIdx = getTaskIdx(subCat, idTask)
    let task = getTaskByIdx(subCat, taskIdx)
    let newTask = {...task}
    newTask.position = getTaskMaxPosition(idSubCat) + 1
    setTaskNewName(newTask, newTaskName)
    return newTask
}

function sortByPosition(elements) {
    elements.sort(function(a, b) {
        return parseInt(a.position) - parseInt(b.position);
    })
}

function moveTaskFromData(taskId, oldSubCategoryId, oldIndex, newSubCategoryId, newIndex) {

    let oldSub = getSubInCurrentById(oldSubCategoryId)
    sortByPosition(oldSub.tasks)

    if(oldSubCategoryId === newSubCategoryId) {
        let result = structuredClone(oldSub)
        let i = -1
        if(oldIndex < newIndex) {
            result.tasks.forEach(function (task){
                i++
                if(i < oldIndex || newIndex < i) return // outside => ignore
                else if(i === oldIndex) { // element to move
                    task.position = result.tasks[newIndex].position
                } else if(i <= newIndex) { // shift to the left
                    task.position--
                }
            })
        } else {
            let temp = result.tasks[newIndex].position
            result.tasks.forEach(function (task){
                i++
                if(i < newIndex || oldIndex < i) return // outside => ignore
                else if(i === oldIndex) { // element to move
                    task.position = temp
                } else if(newIndex <= i) { // shift to the right
                    task.position++
                }
            })
        }
        sortByPosition(result.tasks)
        return {result}
    }

    let element = structuredClone(getTask(oldSubCategoryId, taskId))
    element.category_id = newSubCategoryId
    let newSub = getSubInCurrentById(newSubCategoryId)
    sortByPosition(newSub.tasks)

    let i = 0
    let found = false
    newSub.tasks.forEach(function(task) {
        if(i === newIndex)
        {
            element.position = task.position
            found = true
        }
        if(newIndex <= i )
            task.position++
        i++
    })
    if(!found)
        element.position = i
    console.log(found, i, newSub.tasks.length)
    newSub.tasks.splice(newIndex, 0, element)
    console.log(newSub)

    i = 0
    oldSub.tasks.forEach(function(task) {
        if(oldIndex <= i )
            task.position--
        i++
    })
    oldSub.tasks.splice(oldIndex, 1)

    sortByPosition(oldSub.tasks)
    sortByPosition(newSub.tasks)
    return {oldSub, newSub}
}


function moveSubCatFromData(subCatId, oldIndex, newIndex) {

    let cat = getCurrentCategory()
    sortByPosition(cat.subCategories)

    let result = structuredClone(cat)
    let i = -1
    if(oldIndex < newIndex) {
        result.subCategories.forEach(function (subcat){
            i++
            if(i < oldIndex || newIndex < i) return // outside => ignore
            else if(i === oldIndex) { // element to move
                subcat.position = result.subCategories[newIndex].position
            } else if(i <= newIndex) { // shift to the left
                subcat.position--
            }
        })
    } else {
        let temp = result.subCategories[newIndex].position
        result.subCategories.forEach(function (subcat){
            i++
            if(i < newIndex || oldIndex < i) return // outside => ignore
            else if(i === oldIndex) { // element to move
                subcat.position = temp
            } else if(newIndex <= i) { // shift to the right
                subcat.position++
            }
        })
    }

    sortByPosition(result.subCategories)
    return result
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
    let position = getCategoryById(catId).position
    data.categories.splice(catIdx, 1)
    shiftCatPositionsLeft(position)
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

    let position = cat.subCategories[idx].position
    cat.subCategories.splice(idx, 1)
    shiftPositionsLeft(cat.subCategories, position)
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

function addCommentToData(subCatId, taskId, content) {
    let comment = getCommentTemplate()
    comment.author = data.user
    comment.author_id = data.user.id
    comment.content = content
    comment.date = Date()
    comment.task = null
    comment.task_id = taskId
    return comment
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

function tempAddTaskToData(assignedId, subCatId, name, desc) {
    let task = getTaskTemplate()

    if(assignedId !== 0)
        task.assigned_id = assignedId
    task.category_id = subCatId
    task.checked = false
    task.comments = []
    task.description = desc
    task.name = name
    task.position = getTaskMaxPosition(subCatId) + 1

    return task
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

function getCatMaxPosition() {
    let cat = getCurrentCategory()
    let max = 0
    cat.categories.forEach(function(cat) {
        let temp = cat.category.position
        if(temp > max)
            max = temp
    })
    return max
}

function getAllCatMaxPosition() {
    let max = 0
    data.categories.forEach(function(cat) {
        if(cat.category.archived || cat.category.owner_id !== data.user.id) return
        let temp = cat.category.position
        if(temp > max)
            max = temp
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
    subCat.tasks = []

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
    cat.category.name = getValueFromLanguage("NewCategoryName")
    cat.category.owner_id = data.user.id
    cat.category.position = getAllCatMaxPosition() + 1
    cat.category.subCategories = []
    cat.category.color = "#FF5733" // temp

    cat.members = []
    cat.members.push({
        user_id: data.user.id,
        user: data.user
    })

    return cat
}

function addCatToData(cat) {
    storagePushToCategories(cat.category_id, false)
    shiftCatPositionsRight()
    data.categories.push(cat)
}

function getMember(userId) {
    let cat = getCurrentGlobalCategory()
    let idx = cat.members.findIndex(m => m.user_id === userId)
    return cat.members[idx]
}

function getTempTaskUpdate(subCatId, taskId, newName, newDesc, newAssigned) {
    let origin = getTask(subCatId, taskId)
    let task = {...origin}
    task.name = newName
    task.description = newDesc
    task.assigned_id = newAssigned
    task.assigned = newAssigned === 0 ? null : getMember(newAssigned)
    return task
}

function updateTaskFromData(subCatId, taskId, newName, newDesc, newAssigned) {
    let task = getTask(subCatId, taskId)
    task.name = newName
    task.description = newDesc
    task.assigned_id = newAssigned
    task.assigned = newAssigned === 0 ? null : getMember(newAssigned)
}

function getTempSubCatUpdate(subCatId, newName) {
    let idx = getSubCategoryIdx(subCatId)
    let origin = getSubCategoryByIdx(idx)
    let subcat = {...origin}
    subcat.name = newName
    return subcat
}

function updateSubCatFromData(subCatId, newName) {
    let idx = getSubCategoryIdx(subCatId)
    let subcat = getSubCategoryByIdx(idx)
    subcat.name = newName
}

function getTempCatUpdate(catId, newName) {
    let origin = getCategoryById(catId)
    let cat = {...origin}
    cat.name = newName
    return cat
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

function getInvitationIdByCategoryId(categoryId) {
    let idx = data.categories.findIndex(c => c.category_id === categoryId)
    return data.categories[idx].id
}

function getInvitationIdByCategoryIdForMember(categoryId, memberId) {
    let catidx = data.categories.findIndex(c => c.category_id === categoryId)
    let memberidx = data.categories[catidx].members.findIndex(m => m.user_id === memberId)
    return data.categories[catidx].members[memberidx].id
}

function shiftPositionsLeft(elements, start) {
    elements.forEach(function (element) {
        if(element.position > start)
            element.position--
    })
}

function shiftCatPositionsLeft(start) {
    data.categories.forEach(function (element) {
        if(element.category.position > start)
            element.category.position--
    })
}

function shiftCatPositionsRight() {
    data.categories.forEach(function (element) {
        element.category.position++
    })
}

function isCatArchivedFalse(catId) {
    return getCategoryById(catId).archived === false
}

function getCategoryBySubcatId(subcatId) {
    let subcatIdx = getSubCategoryIdx(subcatId)
    let subcat = getSubCategoryByIdx(subcatIdx)
    let catId = subcat.parent_category_id
    let catIdx = data.categories.findIndex(c => c.category_id === catId)
    let cat = data.categories[catIdx]
    return cat
}