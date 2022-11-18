let activeCategories = 0
let assignValue = null

function toggleSearchScroll(){
    let searchbar = $(".searchbar")
    if(activeCategories === 0)
    {
        searchbar.addClass('searchbar-show')
        activeCategories--
    }
    else
    {
        searchbar.scrollLeft(0);
        searchbar.removeClass('searchbar-show')
        activeCategories++
    }
}

function getDropdownById(dropdownId) {
    var dropdownElement = document.getElementById(dropdownId)
    var dropdownInstanceBefore = bootstrap.Dropdown.getInstance(dropdownElement)
    if(dropdownInstanceBefore !== null)
        dropdownInstanceBefore.dispose()
    new bootstrap.Dropdown(dropdownElement)
    return dropdownElement
}

function resetSearchbar() {
    activeCategories = 0;
    toggleResearch("off")
    toggleSearchScroll()
    resetAssign()
}

function showDropdownAssign(e) {
    let assignDiv = document.getElementById("searchbar-assign")
    let assignStyle = window.getComputedStyle(assignDiv)
    if(assignStyle.getPropertyValue('display') === "none")
        assignDiv.style.display = "flex"

    e.stopPropagation();

    /* Hide input dropdown */
    let input = getDropdownById('searchbar-input')
    bootstrap.Dropdown.getInstance(input).hide()

    /* Show assign dropdown */
    let assign = getDropdownById('assign-button')
    bootstrap.Dropdown.getInstance(assign).show()

    toggleSearchScroll()
}

function resetAssign() {
    if(activeCategories !== 0)
        toggleSearchScroll()
    assignValue = null
    document.getElementById("assign-value").innerHTML = ''
    document.getElementById("assign-cancel").style.display = "none"
    document.getElementById("searchbar-assign").style.display = "none"
}

function setAssignedValue(element) {
    if(element.innerText !== "")
        assignValue = element.innerText
    document.getElementById('assign-value').innerText = element.innerText
    document.getElementById("assign-cancel").style.display = "initial"
}

$(document).ready(function() {
    $(document).on('keyup', "#searchbar-input", function (e) {
        let input = $("#searchbar-input").val();

        let dropdown = getDropdownById('searchbar-input')
        bootstrap.Dropdown.getInstance(dropdown).hide()

        if (input.length > 0)
            bootstrap.Dropdown.getInstance(dropdown).hide()
        else
            bootstrap.Dropdown.getInstance(dropdown).show()
    })

    $(document).on('keydown keypress', "#searchbar-input", function (e) {
        let keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            let result = doSearch(assignValue, $("#searchbar-input").val().split())
            displayResult(result)
        }
    });
})

function doSearch(assignValue, splitInputs) {
    const result = []
    let correspond = false
    categories.forEach(function(element) {

        switch (assignValue) {
            case null:
                break
            case element.assigned:
                correspond = true
                break
            case 'None':
                if(element.assigned === "")
                    correspond = true
                break
            default:
                break
        }

        const name = (element.name.split(" ")).some( r => splitInputs.includes(r))
        const desc = (element.desc.split(" ")).some( r => splitInputs.includes(r))

        if(name || desc)
            correspond = true

        if(correspond)
        {
            result.push(element)
            correspond = false
        }
    })
    return result
}

function toggleResearch(value) {
    let research = document.getElementById("research")
    let content = document.getElementById("default-category-content")

    if(value === "on")
    {
        research.removeAttribute("hidden")
        content.setAttribute("hidden", "")
    }
    else if(value === "off")
    {
        research.setAttribute("hidden", "")
        content.removeAttribute("hidden")
    }
}

function buildTaskElement(element) {
    let newTask = document.createElement("li")
    newTask.classList.add("list-group-item", "task-view")
    newTask.innerHTML = '' +
        '    <button class="btn btn-sm btn-task-drag" type="button" title="Attrape la tâche pour la changer d\'emplacement">' +
        '        <span class="mdi mdi-18px mdi-drag"></span>' +
        '    </button>' +
        '    <div class="form-check task-view-details">' +
        '        <input class="form-check-input task-checkbox" type="checkbox" value="" title="Etat de la tâche">' +
        '        <div class="task-view-info" id="taskViewInfo-{{ subCatId }}-{{ taskId }}" onclick="openTaskDetails({{ subCatId }},{{ taskId }})">' +
        '            <label class="form-check-label" title="Nom de la tâche">' +
        '                Nom de la tâche [{{ subCatId }}-{{ taskId }}]' +
        '            </label>' +
        '            <small class="form-text text-muted assigned-member" title="Membre assignée à la tâche">@NOM Prénom</small>' +
        '            <small class="form-text text-muted" title="Description de la tâche">Description</small>' +
        '        </div>' +
        '    </div>' +
        '    <a data-idCat="{{ subCatId }}" data-idTask="{{ taskId }}" tabindex="0" class="btn btn-sm btn-task-actions" role="button" data-bs="popover" data-bs-popover="task-popover" aria-label="Actions de la tâche">' +
        '        <span class="mdi mdi-dots-horizontal"></span>' +
        '    </a>'
    return newTask
}

function displayResult(result) {
    if(result.length > 0)
        toggleResearch("on")

    let list = document.getElementById("research").getElementsByTagName("ul")[0]
    list.innerHTML = ""

    result.forEach(function(element) {
        list.appendChild(buildTaskElement(element))
    })
}