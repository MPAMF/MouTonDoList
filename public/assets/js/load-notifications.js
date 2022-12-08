let invitationRepository = new InvitationRepository();
let countErrors = 0;
let invitations = [];

function fetchNotifications(){
    invitationRepository.list()
        .then(values => {
            $("#btn-notification-count").html(values.data.length);
            invitations = values.data;
            countErrors = 0;
        })
        .catch(e => {
            console.log(e);
            countErrors++;
        });

    if(countErrors > 3){
        setTimeout(fetchNotifications,60000);
    }
    else{
        setTimeout(fetchNotifications,5000);
    }
}

function loadTaskToDo(){
    let notifications = [];
    let numberDays = 3;
    let userId = data.userId;
    let date = new Date();
    numberDays = 24 * 3600 * 1000 * numberDays;

    data.categories.forEach(function (userCategory) {
        if(userCategory.category.subCategories !== undefined){
            (userCategory.category.subCategories).forEach(function (subCategory) {
                (subCategory.tasks).forEach(function (task) {
                    if((task.assigned_id === userId) && (date.getTime() - (new Date(task.due_date)).getTime() >= numberDays)){
                        notifications.push([task.name,task.category_id,task.id,task.due_date])
                    }
                })
            })
        }
    })

    return notifications;
}

function updateInvitation(invitationId, hasAccepted){
    let invitationIdx = invitations.findIndex(c => c.id === invitationId);
    invitations[invitationIdx].accept = hasAccepted;
    invitationRepository.update(invitations[invitationIdx])
        .then( function (){
            removeInvitation(invitationId);
        })
        .catch(e => {

        });
}
