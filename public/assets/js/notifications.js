let invitationRepository = new InvitationRepository();
let countErrors = 0;
let invitations = [];

function fetchNotifications() {
    invitationRepository.list()
        .then(values => {
            $("#btn-notification-count").html(values.length);
            invitations = values;
            countErrors = 0;
        })
        .catch(e => {
            console.log(e);
            countErrors++;
        });

    if (countErrors > 3) {
        setTimeout(fetchNotifications, 60000);
    } else {
        setTimeout(fetchNotifications, 5000);
    }
}

function loadTaskToDo() {
    let notifications = [];
    let userId = data.user.id;

    data.categories.forEach(function (userCategory) {
        if (userCategory.category.subCategories !== undefined) {
            (userCategory.category.subCategories).forEach(function (subCategory) {
                (subCategory.tasks).forEach(function (task) {
                    if (task.assigned_id === userId) {
                        notifications.push([userCategory.category.name, subCategory.name, task.name, task.category_id, task.id])
                    }
                })
            })
        }
    })

    return notifications;
}

function updateInvitation(invitationId, hasAccepted) {
    let invitationIdx = invitations.findIndex(c => c.id === invitationId);
    invitations[invitationIdx].accepted = hasAccepted;
    let userId = data.user.id;

    if (hasAccepted) {
        invitationRepository.update(invitations[invitationIdx])
            .then(function () {
                removeInvitation(invitationId);
                showToast(getValueFromLanguage('UpdateInvitationSuccess'), userId, 'success')
            })
            .catch(() => {
                showToast(getValueFromLanguage('UpdateInvitationError'), userId, 'danger')
            });
    } else {
        invitationRepository.delete(invitations[invitationIdx])
            .then(function () {
                removeInvitation(invitationId);
            })
            .catch(() => {
                showToast(getValueFromLanguage('UpdateInvitationError'), userId, 'danger')
            });
    }
}
