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
            storagePushToCategories(category.category_id, false, false)
    })
}

function storageSetCategories() {
    localStorage.setItem('categories', JSON.stringify(currentStorage.categories))
}

function storagePushToCategories(id, hideArchived, hideChecked) {
    currentStorage.categories.push({
        id: id, hideArchived: hideArchived, hideChecked: hideChecked
    })
    storageSetCategories()
}

function storageUpdateCategory(id, hideArchived, hideChecked) {
    let index = currentStorage.categories.findIndex(c => c.id === id)
    currentStorage.categories[index].hideArchived = hideArchived
    currentStorage.categories[index].hideChecked = hideChecked
}

function storageRemoveFromCategories(id) {
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