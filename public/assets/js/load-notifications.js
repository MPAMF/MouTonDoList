let invitationRepository = new InvitationRepository();
let countErrors = 0;
let notificationTab = [];

function callNotification(){
    invitationRepository.list()
        .then(values => {
            $("#btn-notification-count").html(values.data.length);
            notificationTab = [];
            values.data.forEach(value => {
                notificationTab.push([value.category.name,value.category.owner,value.date]);
            });
            console.log(values);
            countErrors = 0;
        })
        .catch(e => {
            console.log(e);
            countErrors++;
        });

    if(countErrors > 3){
        setTimeout(callNotification,60000);
    }
    else{
        setTimeout(callNotification,5000);
    }
}

function loadTaskToDo(){
    let notifications = [];
    let numberDays = 3;
    let userId = data.id;
    let date = new Date();
    numberDays = 24 * 3600 * 1000 * numberDays;

    data.categories.forEach(function (userCategory) {
        if(userCategory.category.subCategories !== undefined){
            (userCategory.category.subCategories).forEach(function (subCategory) {
                (subCategory.tasks).forEach(function (task) {
                    console.log(userId)
                    if((task.assigned_id === userId) && (date.getTime() - (new Date(task.due_date)).getTime() >= numberDays)){
                        notifications.push([task.name,task.category_id,task.id,task.due_date])
                    }
                })
            })
        }
    })

    return notifications;
}
