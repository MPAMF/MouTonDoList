class Repository {

    list(endpoint) {
        return $.ajax({
            url: `${this.endpoint}`,
            type: 'get',
            contentType: 'application/json; charset=utf-8',
        })
    }

    get(endpoint, id) {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'get',
            contentType: 'application/json; charset=utf-8',
        })
    }

    put(endpoint, id, data = {}) {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'put',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data
        })
    }

    post(endpoint, data = {}) {
        return $.ajax({
            url: this.endpoint,
            type: 'post',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data
        })
    }

    delete(endpoint, id) {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'delete',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
        })
    }

}

class TaskRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/actions/tasks'
    }

    get(id) {
        return super.get(this.endpoint, id)
    }

    create(task) {
        return super.post(this.endpoint, task)
    }

    update(task) {
        return super.put(this.endpoint, task.id, task)
    }

    delete(task) {
        return super.delete(this.endpoint, task.id)
    }
}

class CategoryRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/actions/categories'
    }

    get(id) {
        return super.get(this.endpoint, id)
    }

    create(category) {
        return super.post(this.endpoint, category)
    }

    update(category) {
        return super.put(this.endpoint, category.id, category)
    }

    delete(category) {
        return super.delete(this.endpoint, category.id)
    }
}

class CommentRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/actions/comments'
    }

    get(id) {
        return super.get(this.endpoint, id)
    }

    create(comment) {
        return super.post(this.endpoint, comment)
    }

    update(comment) {
        return super.put(this.endpoint, comment.id, comment)
    }

    delete(comment) {
        return super.delete(this.endpoint, comment.id)
    }
}

class UserRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/actions/users'
    }

    get(id) {
        return super.get(this.endpoint, id)
    }

    // Not implemented
    create(user) {
        return new Promise((resolve, reject) => reject());
    }

    update(user) {
        return super.put(this.endpoint, user.id, user)
    }

    // Not implemented
    delete(user) {
        return new Promise((resolve, reject) => reject());
    }
}

class InvitationRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/actions/invitations'
    }

    list() {
        return super.list(this.endpoint)
    }

    // Not implemented
    create(user) {
        return new Promise((resolve, reject) => reject());
    }

    update(user) {
        return super.put(this.endpoint, user.id, user)
    }

}