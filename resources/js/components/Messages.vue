<template>
    <div class="container">
        <h2>Messages</h2>
        <form @submit="addMessage" class="mb-3">
            <div class="form-group">
                <textarea type="text" class="form-control" placeholder="Messages" v-model="message.message"></textarea>
            </div>
            <button type="submit" class="btn btn-success btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a @click="fetchMessages(pagination.prev_page_url)" class="page-link" href="#">Prev</a></li>
            <li class="page-item disabled">
                <a class="page-link dark" href="#">
                    Page {{ pagination.current_page }} of {{ pagination.last_page }}
                </a>
            </li>
            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a @click="fetchMessages(pagination.next_page_url)" class="page-link" href="#">Next</a></li>
          </ul>
        </nav>
        <div class="card card-body mb-2" v-for="message in messages" v-bind:key="message.id">
            <h4>{{message.message}}</h4>
            <hr>
            <button @click="editMessage(message)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteMessage(message.id)" class="btn btn-danger">Delete</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: [],
                message: {
                    id: '',
                    user_id: '',
                    message: ''
                },
                message_id: '',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchMessages();
        },

        methods: {
            fetchMessages(page_url) {
                let __self = this;
                page_url = page_url || '/api/messages'
                fetch(page_url)
                    .then(res  => res.json())
                    .then(res  => {
                         this.messages = res.data;
                         __self.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));

            },
            makePagination(meta, links) {
                let pagination = {
                    current_page : meta.current_page,
                    last_page    : meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
            },
            deleteMessage(id) {
                fetch(`api/message/${id}`, {
                    method: 'delete'
                })
                .then(res  => res.json())
                .then(data => {
                    this.fetchMessages();
                })
                .catch(err => console.log(err));
            },
            addMessage() {
                if(this.edit === false) {
                    //Add
                    fetch('api/message', {
                        method: 'post',
                        body: JSON.stringify(this.message),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res  => res.json())
                    .then(data => {
                        this.message = '';
                        this.fetchMessages();
                    })
                    .catch(err => console.log(err));
                } else {
                    //Edit
                    fetch('api/message', {
                        method: 'put',
                        body: JSON.stringify(this.message),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res  => res.json())
                    .then(data => {
                        this.message = '';
                        this.fetchMessages();
                    })
                    .catch(err => console.log(err));
                }
            },
            editMessage(message) {
                console.log(message);
                this.edit               = true;
                this.message.id         = message.id;
                this.message.message_id = message.id;
                this.message.message    = message.message;
            }
        }
    }
</script>