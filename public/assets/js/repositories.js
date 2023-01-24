class Repository {

    list(endpoint) {
        return new Promise((resolve, reject) => $.ajax({
            url: `${endpoint}`,
            type: 'get',
            contentType: 'application/json; charset=utf-8',
        }).then(e => resolve(e.data)).catch(e => reject(e)))
    }

    get(endpoint, id) {
        return new Promise((resolve, reject) => $.ajax({
            url: `${endpoint}/${id}`,
            type: 'get',
            contentType: 'application/json; charset=utf-8',
        }).then(e => resolve(e.data)).catch(e => reject(e)))
    }

    put(endpoint, id, data = {}) {
        return new Promise((resolve, reject) => $.ajax({
            url: `${endpoint}/${id}`,
            method: 'put',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(data)
        }).then(e => resolve(e.data)).catch(e => reject(e)))
    }

    patch(endpoint, id, data = {}) {
        return new Promise((resolve, reject) => $.ajax({
            url: `${endpoint}/${id}`,
            method: 'patch',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(data)
        }).then(e => resolve(e.data)).catch(e => reject(e)))
    }

    post(endpoint, data = {}) {
        return new Promise((resolve, reject) => $.ajax({
            url: endpoint,
            type: 'post',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: JSON.stringify(data)
        }).then(e => resolve(e.data)).catch(e => reject(e)))
    }

    delete(endpoint, id) {
        return new Promise((resolve, reject) => $.ajax({
            url: `${endpoint}/${id}`,
            type: 'delete',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
        }).then(e => resolve(e)).catch(e => reject(e)))
    }

}

class TaskRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/api/tasks'
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
        this.endpoint = '/api/categories'
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

    delete(id) {
        return super.delete(this.endpoint, id)
    }
}

class CommentRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/api/comments'
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

    delete(id) {
        return super.delete(this.endpoint, id)
    }
}

class UserRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/api/users'
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

    patch(user) {
        return super.patch(this.endpoint, user.id, user)
    }

    // Not implemented
    delete(user) {
        return new Promise((resolve, reject) => reject());
    }
}

class InvitationRepository extends Repository {

    constructor() {
        super();
        this.endpoint = '/api/invitations'
    }

    list() {
        return super.list(this.endpoint)
    }

    // Not implemented
    create(user) {
        return new Promise((resolve, reject) => reject());
    }

    update(category) {
        return super.put(this.endpoint, category.id, category)
    }

    delete(id) {
        return super.delete(this.endpoint, id)
    }
}