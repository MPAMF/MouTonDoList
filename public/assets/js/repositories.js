class Repository {

    constructor(endpoint)
    {
        this.endpoint = endpoint
    }

    get(id)
    {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'get',
            contentType: 'application/json; charset=utf-8',
        })
    }

    put(id, data = {})
    {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'put',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data
        })
    }

    post(data = {})
    {
        return $.ajax({
            url: this.endpoint,
            type: 'post',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            data: data
        })
    }

    delete(id)
    {
        return $.ajax({
            url: `${this.endpoint}/${id}`,
            type: 'delete',
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
        })
    }

}

class TaskRepository extends Repository {

    constructor()
    {
        super('actions/tasks');
    }

    get(id)
    {
        return super.get(id)
    }

    create(task)
    {
        return super.post(task)
    }

    update(task)
    {
        return super.put(task.id, task)
    }

    delete(task)
    {
        return super.delete(task.id)
    }
}