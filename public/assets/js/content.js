function getCommentContent(text) {

    let newId = Math.floor(Math.random() * 10000).toString();
    let author = getCurrentMemberUsername()

    let comment = document.createElement("li")
    comment.classList.add("list-group-item", "modal-comment")
    comment.setAttribute("data-comment", newId)

    let content = '' +
        '                <div class="d-flex justify-content-between align-items-center">' +
        '                    <p class="mb-1">' +
        '                        ' + author + ' <small class="form-text text-muted" title="' + getValueFromLanguage('ModalCommentDateTitle') + '">' + timeSince(new Date()) + '</small>' +
        '                    </p>'

    if(isCanEdit()) {
        content +=
            '<button id="commentRemove-' + newId + '" class="btn btn-sm modal-delete-comment" type="button" title="' + getValueFromLanguage('ModalCommentDeleteTitle') + '">' +
            '<span class="mdi mdi-18px mdi-trash-can"></span>' +
            '</button>'

        $(document).on('click', "#commentRemove-" + newId, function (e) {
            removeComment(newId)
        })
    }

    content +=
        '                </div>' +
        '                <p class="small mb-0">' + text + '</p>'

    comment.innerHTML = content
    return comment
}