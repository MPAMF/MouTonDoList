let currentStorage = {
    categories: []
}

function clearStorage() { localStorage.clear() }

function loadStorage() {
    currentStorage.categories = localStorage.getItem('categories') ?
        JSON.parse(localStorage.getItem('categories')) : []
}

function updateStorageFromData() {
    loadStorage()
    data.categories.forEach(function (category) {
        if(!storageCategoryExists(category.category_id))
            storagePushToCategories(category.category_id, false)
    })
}

function storageSetCategories() {
    localStorage.setItem('categories', JSON.stringify(currentStorage.categories))
}

function storagePushToCategories(id, hideChecked) {
    currentStorage.categories.push({
        id: id, hideChecked: hideChecked
    })
    storageSetCategories()
}

function storageUpdateCategory(id, hideChecked) {
    let index = currentStorage.categories.findIndex(c => c.id.toString() === id.toString())
    currentStorage.categories[index] = {
        id: parseInt(id), hideChecked: hideChecked
    }
    storageSetCategories()
}

function storageGetCategory(id) {
    let index = currentStorage.categories.findIndex(c => c.id.toString() === id.toString())
    return currentStorage.categories[index]
}

function storageRemoveCategory(id) {
    currentStorage.categories.filter(function(value, index, arr){
        return value.id !== id.toString();
    });
    storageSetCategories()
}

function storageCategoryExists(id) {
    if(storageCategoriesEmpty()) return false
    return currentStorage.categories.findIndex(c => c.id === id) !== -1
}

function storageCategoriesEmpty() {
    return currentStorage.categories === null || currentStorage.categories.length === 0
}

function isHideCheckedForCategory(id) {
    return storageGetCategory(id).hideChecked
}