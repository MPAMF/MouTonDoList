function loadTaskToDo(){
    let notifications = [];
    let numberDays = 3;
    let userId = data.user.id;
    let date = new Date();
    date.setTime(date.getTime() - 24 * 3600 * 1000 * numberDays);

    data.categories.forEach(function (userCategory) {
        if(userCategory.category.subCategories !== undefined){
            (userCategory.category.subCategories).forEach(function (subCategory) {
                (subCategory.tasks).forEach(function (task) {
                    if((task.assigned_id === userId) && (date.getTime() >= (new Date(task.due_date)).getTime())){
                        notifications.push([task.name,task.category_id,task.id,task.due_date])
                    }
                })
            })
        }
    })

    return notifications;
}

function loadNotification(){
    return [["Math","Matthieu","2022-12-6"]];
}