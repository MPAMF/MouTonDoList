class Repository {

    constructor(endpoint) {
        this.endpoint = endpoint
    }

    get(id) {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'get',
            contentType: 'application/json; charset=utf-8',
        })
    }

    put(id, data = {}) {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'put',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data
        })
    }

    post(data = {}) {
        return $.ajax({
            url: this.endpoint,
            type: 'post',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data
        })
    }

    delete(id) {
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
        super('actions/tasks');
    }

    get(id) {
        return super.get(id)
    }

    create(task) {
        return super.post(task)
    }

    update(task) {
        return super.put(task.id, task)
    }

    delete(task) {
        return super.delete(task.id)
    }
}

class CategoryRepository extends Repository {

    constructor() {
        super('actions/categories');
    }

    get(id) {
        return super.get(id)
    }

    create(category) {
        return super.post(category)
    }

    update(category) {
        return super.put(category.id, category)
    }

    delete(category) {
        return super.delete(category.id)
    }
}

class CommentRepository extends Repository {

    constructor() {
        super('actions/comments');
    }

    get(id) {
        return super.get(id)
    }

    create(comment) {
        return super.post(comment)
    }

    update(comment) {
        return super.put(comment.id, comment)
    }

    delete(comment) {
        return super.delete(comment.id)
    }
}

class UserRepository extends Repository {

    constructor() {
        super('actions/users');
    }

    get(id) {
        return super.get(id)
    }

    // Not implemented
    create(user) {
        return new Promise((resolve, reject) => reject());
    }

    update(user) {
        return super.put(user.id, user)
    }

    // Not implemented
    delete(user) {
        return new Promise((resolve, reject) => reject());
    }
}