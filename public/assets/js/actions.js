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

function ArchiveCategory(id, active)
{
    let element = document.getElementById("category-archive")
    let newPlacement = element.getElementsByTagName("ul")
    let category = document.getElementById("Category"+id)
    let attribute = category.getElementsByTagName("a")
    $("#Category" + id).appendTo(newPlacement);

    if(active) {
        attribute[1].setAttribute("data-archive","trueActive");
        let categoryActive = document.getElementById("CategoryActive"+id)
        let attributeActive = categoryActive.getElementsByTagName("a")
        attributeActive[0].setAttribute("data-archive","trueActive");
    }
    else {
        attribute[1].setAttribute("data-archive","true");
    }

}

function UnarchivedCategory(id, active)
{
    let element = document.getElementById("category-active")
    let newPlacement = element.getElementsByTagName("ul")
    let category = document.getElementById("Category"+id)
    let attribute = category.getElementsByTagName("a")
    $("#Category" + id).appendTo(newPlacement);

    if(active) {
        attribute[1].setAttribute("data-archive","falseActive");
        let categoryActive = document.getElementById("CategoryActive"+id)
        let attributeActive = categoryActive.getElementsByTagName("a")
        attributeActive[0].setAttribute("data-archive","falseActive");
    }
    else {
        attribute[1].setAttribute("data-archive","false");
    }
}

function DeleteCategory(id)
{
    $("[data-bs-popover=category-popover]").popover('hide')
    let elementDown = document.getElementById("Category" + id)
    elementDown.remove();
}

function DuplicateCategory(id)
{
    $("[data-bs-popover=category-popover]").popover('hide')
    let originalElement = document.getElementById("Category" + id);
    let cloneElement = originalElement.cloneNode(true)
    cloneElement.id = "Categorietest" + (id + 7)
    originalElement.parentNode.appendChild(cloneElement)
}

function DuplicateCategoryShared(id)
{
    let originalElement = document.getElementById("Category" + id);
    let cloneElement = originalElement.cloneNode(true)
    cloneElement.id = "Category" + (id + 7)
    originalElement.parentNode.appendChild(cloneElement)
}

function LeaveCategoryShared(id)
{
    $("[data-bs-popover=category-shared-popover]").popover('hide')
    let elementDown = document.getElementById("Category" + id)
    elementDown.remove();
}

function DuplicateCategorySharedReadonly(id)
{
    let originalElement = document.getElementById("Category" + id);
    let cloneElement = originalElement.cloneNode(true)
    cloneElement.id = "Category" + (id + 7)
    originalElement.parentNode.appendChild(cloneElement)
}

function LeaveCategorySharedReadonly(id)
{
    $("[data-bs-popover=category-shared-popover]").popover('hide')
    let elementDown = document.getElementById("Category" + id)
    elementDown.remove();
}

function DeleteSubcategory(id)
{
    $("[data-bs-popover=subcategory-popover]").popover('hide')
    let elementDown = document.getElementById("Subcategory-" + id)
    elementDown.remove();
}

function ArchiveSubcategory(id)
{
    let newPlacement = document.getElementById("sub-category-archive")
    let element = $("#Subcategory-" + id)
    let subcategory = document.getElementById("Subcategory-popover-"+id)
    let attribute = subcategory.getElementsByTagName("a")

    element.appendTo(newPlacement);
    element.addClass('subcategory-archive');

    $("#Sub-categoryNewTask-" + id).addClass('d-none');

    attribute[0].setAttribute("data-archive","true");
}

function DeleteSubcategoryArchive(id)
{
    $("[data-bs-popover=subcategory-archive-popover]").popover('hide')
    let elementDown = document.getElementById("Subcategory-" + id)
    elementDown.remove();
}

function UnarchivedSubcategory(id)
{
    let newPlacement = document.getElementById("sub-category")
    let element = $("#Subcategory-" + id)
    let subcategory = document.getElementById("Subcategory-popover-"+id)
    let attribute = subcategory.getElementsByTagName("a")

    element.appendTo(newPlacement);
    element.removeClass("subcategory-archive");

    $("#Sub-categoryNewTask-" + id).removeClass('d-none');

    attribute[0].setAttribute("data-archive","false");
}

function DuplicateTask(idCat,idTask)
{
    let originalElement = document.getElementById("Task-" + idCat + "-" + idTask);
    let cloneElement = originalElement.cloneNode(true)
    cloneElement.id = "Task" + (idCat + 10) + "-" + (idTask + 10)
    originalElement.parentNode.appendChild(cloneElement)
}

function DeleteTask(idCat,idTask)
{
    $("[data-bs-popover=task-popover]").popover('hide')
    let elementDown = document.getElementById("Task-" + idCat + "-" + idTask)
    elementDown.remove();
}

function AddSubcategoryBegin(id)
{
    let subId=10
    let subcategory = getSubcategory(subId)
    let element = document.getElementById("Subcategory-" + id)
    element.insertAdjacentHTML('beforebegin',subcategory)
    subCategoryNewTask(subId)
}

function AddSubcategoryEnd(id)
{
    let subId=10
    let subcategory = getSubcategory(subId)
    let element = document.getElementById("Subcategory-" + id)
    element.insertAdjacentHTML('beforeend',subcategory)
    subCategoryNewTask(subId)
}

function AddSubcategoryActive()
{
    let subId=10
    let subcategory = getSubcategory(subId)
    let element = document.getElementById("sub-category")
    element.insertAdjacentHTML('afterbegin',subcategory)
    subCategoryNewTask(subId)
}

function AddSubcategoryShared()
{
    let subId=10
    let subcategory = getSubcategory(subId)
    let element = document.getElementById("sub-category")
    element.insertAdjacentHTML('afterbegin',subcategory)
    subCategoryNewTask(subId)
}

function NewTaskBegin(idCat,idTask)
{
    let task = getTask(idCat,idTask + 10)
    let element = document.getElementById("Task-" + idCat + "-" + idTask)
    element.insertAdjacentHTML('beforebegin',task)
}

function NewTaskEnd(idCat,idTask)
{
    let task = getTask(idCat,idTask + 10)
    let element = document.getElementById("Task-" + idCat + "-" + idTask)
    element.insertAdjacentHTML('afterend',task)
}

function getSubcategory(sub_id)
{
    return `<div class="accordion-item accordion-item-tasks" data-idSubCat="` + sub_id + `" id="Subcategory-` + sub_id + `">
        <h2 class="accordion-header subcategory-header" id="panelsStayOpen-heading-` + sub_id + `">
        <span class="category-button">
            <span class="accordion-button btn-subcategory-drag">
                <button class="btn btn-category-actions" type="button"
                        title="Attrape la sous-catégorie pour la changer d'emplacement">
                    <span class="mdi mdi-24px mdi-drag"></span>
                </button>
            </span>
        </span>
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#panelsStayOpen-collapse-` + sub_id + `" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapse-` + sub_id + `">
                    Sous-catégorie #` + sub_id + `
            </button>
            <span class="category-button" id="Subcategory-popover-` + sub_id + `">
            <span class="accordion-button">
                <a data-id="` + sub_id + `" tabIndex="0" class="btn btn-category-actions" role="button"
                   data-bs="popover" data-bs-popover="subcategory-popover"
                   aria-label="Liste d'actions d'une sous-catégorie archivée dans une todolist">
                    <span class="mdi mdi-24px mdi-dots-horizontal"></span>
                </a>
            </span>
        </span>
        </h2>
        <div id="panelsStayOpen-collapse-` + sub_id + `" class="accordion-collapse collapse show"
             aria-labelledby="panelsStayOpen-heading-` + sub_id + `">
            <div class="accordion-body">
                <ul class="list-group list-group-flush tasks" data-sortable="tasks">
                </ul>
                <ul id="Sub-categoryNewTask-` + sub_id + `" class="">
                    <li class="list-group-item task-add">
                        <div class="d-grid">
                            <button class="btn btn-task-add" type="button" id="taskAdd-` + sub_id + `">
                                <span class="mdi mdi-plus-circle"></span>
                                Ajouter une tâche [` + sub_id + `]
                            </button>
                        </div>
                        <form class="task-new" id="taskNew-` + sub_id + `">
                            <div class="mb-2">
                                <input type="text" class="form-control form-control-sm bg-secondary" id="taskNewName-` + sub_id + `" placeholder="Nom de la tâche" title="Nom de la nouvelle tâche" required>
                                <div id="error-taskNew` + sub_id + `" class="invalid-feedback" role="alert"> Veuillez indiquer un nom. </div>
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control form-control-sm bg-secondary" rows="3" id="taskNewDescription-` + sub_id + `" placeholder="Description" title="Description de la nouvelle tâche" ></textarea>
                            </div>
                            <div class="mb-2">
                                <select class="btn btn-sm btn-modal-select" aria-label="Membre assigné" required>
                                    <option value="0" selected>Non assignée</option>
                                    <option value="nomPrenom">NOM Prénom</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-secondary btn-sm me-md-2" type="reset" id="taskNewCancel-` + sub_id + `">Annuler</button>
                                <button class="btn btn-primary btn-sm btn-task-create" type="submit" id="taskNewCreate-` + sub_id + `" disabled>Ajouter une tâche</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>`
}

function getTask(idCat,idTask)
{
    return `<li class="list-group-item task-view" data-idCat="` + idCat + `" data-idTask="` + idTask +`" id="Task-` + idCat + `-` + idTask +`">
        <button class="btn btn-sm btn-task-drag" type="button"
                title="Attrape la tâche pour la changer d'emplacement">
            <span class="mdi mdi-18px mdi-drag"></span>
        </button>
        <div class="form-check task-view-details">
            <input class="form-check-input task-checkbox" type="checkbox" value="" checked="true" title="Etat de la tâche" onclick="checkTask(` + idCat + `,` + idTask +`)">
                <div class="task-view-info" id="taskViewInfo-` + idCat + `-` + idTask +`"
                     onClick="openTaskDetails(` + idCat + `,` + idTask +`)">
                    <label class="form-check-label" title="Nom de la tâche">
                        Nom de la tâche [` + idCat + `-` + idTask +`]
                    </label>
                    <small class="form-text text-muted assigned-member" title="Membre assignée à la tâche">@NOM
                        Prénom</small>
                    <small class="form-text text-muted" title="Description de la tâche">Description</small>
                </div>
        </div>
        <a data-idCat="` + idCat + `" data-idTask="` + idTask +`" tabIndex="0" class="btn btn-sm btn-task-actions"
           role="button" data-bs="popover" data-bs-popover="task-popover" aria-label="Actions de la tâche">
            <span class="mdi mdi-dots-horizontal"></span>
        </a>
    </li>`
}

function subCategoryNewTask(sub_id)
{
    document.getElementById("taskAdd-" + sub_id).addEventListener('click', function (e) {
        toggleForm("taskAdd-" + sub_id, "taskNew-" + sub_id, "error-taskNew" + sub_id, null)
    });
    document.getElementById("taskNewCancel-" + sub_id).addEventListener('click', function (e) {
        toggleForm("taskAdd-" + sub_id, "taskNew-" + sub_id, null, "#taskNewCreate-" + sub_id)
    });

    $(document).ready(
        $(document).on('click', "#taskNewCreate-" + sub_id, function (e) {
            checkInputOnSubmit("#taskNewName-" + sub_id, "error-taskNew" + sub_id)
        }),
        $(document).on('keyup', "#taskNewName-" + sub_id, function (e) {
            checkInputOnKeyup("#taskNewName-" + sub_id, "error-taskNew" + sub_id, "#taskNewCreate-" + sub_id)
        })
    )
}

let subCategoryCheckboxState = false
let taskCheckboxState = false

function saveChangeCategoryName()
{
    let input = document.getElementById("modal-input-name").value
    const introPara = document.getElementById("title")
    introPara.innerHTML = input

    let subCategoryCheckbox = document.querySelector('input[id="modal-checkbox-subcategory"]')
    let taskCheckbox = document.querySelector('input[id="modal-checkbox-task"]')
    if(subCategoryCheckbox.checked) {
        subCategoryCheckboxState = true
        if($("#sub-category-archive").hasClass("invisible")===false)
        {
            $("#sub-category-archive").addClass('invisible')
        }
    } else {
        subCategoryCheckboxState = false
        if($("#sub-category-archive").hasClass("invisible")===true)
        {
            $("#sub-category-archive").removeClass('invisible')
        }
    }
    if(taskCheckbox.checked) {
        taskCheckboxState = true
    } else {
        taskCheckboxState = false
    }
}

function checkTask(idSub,idTask)
{
    let taskCheck = document.querySelector('input[id="TaskCheckbox-' + idSub + '-' + idTask + '"]')
    let task = document.getElementById("Task-" + idSub + "-" + idTask)
    if (taskCheckboxState){
        if (taskCheck){
            if($("#Task-" + idSub + "-" + idTask).hasClass("d-none")===false) {
                $("#Task-" + idSub + "-" + idTask).addClass('d-none')
            }
        }
        else {
            if($("#Task-" + idSub + "-" + idTask).hasClass("d-none")===true) {
                $("#Task-" + idSub + "-" + idTask).removeClass('d-none')
            }
        }
    }
    else{
        if($("#Task-" + idSub + "-" + idTask).hasClass("d-none")===true) {
            $("#Task-" + idSub + "-" + idTask).removeClass('d-none')
        }
    }
}
