let currentStorage = {
    categories: []
}

function loadStorage() {
    storageRemoveFromCategories(1)
    currentStorage.categories = JSON.parse(localStorage.getItem('categories'))
    console.log(currentStorage)
}

function storageSetCategories() {
    localStorage.setItem('categories', JSON.stringify(currentStorage.categories))
}

function storagePushToCategories(id, showArchived, showChecked) {
    currentStorage.categories.push({
        id: id.toString(), showArchived: showArchived.toString(), showChecked: showChecked.toString()
    })
    storageSetCategories()
}

function storageRemoveFromCategories(id) {
    currentStorage.categories.filter(function(value, index, arr){
        return value.id !== id.toString();
    });
    storageSetCategories()
}