<template>
    <div>
        <CRow>
            <CCol sm="12">
                <CCard>
                    <CCardHeader>
                        Add User
                    </CCardHeader>
                    <CCardBody>

                        <form @submit.prevent="adduser" class="mb-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="name" v-model="user.name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="email" v-model="user.email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" v-model="user.password">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="jop" v-model="user.jop">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="gender" v-model="user.gender">
                            </div>

                            <button type="submit" class="btn btn-light btn-block">Save</button>
                        </form>
                    </CCardBody>
                    <CCardFooter>
                        .
                    </CCardFooter>
                </CCard>
            </CCol>

        </CRow>




        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchusers(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchusers(pagination.next_page_url)">Next</a></li>
            </ul>

        </nav>
        <div class="row mt-4 mb-4">
            <div class="col-md-6 ">
                <input class="form-control"  v-model="filterText" placeholder="Gender" />
               

            </div>
            <div class="col-md-6 ">
               
                <input class="form-control"  v-model="filterJop" placeholder="Jop" />

            </div>

        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Jop</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Controler</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in filterByGender" v-bind:key="user.id">

                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.jop}}</td>
                    <td>{{user.gender}}</td>
                    <td>
                        <button @click="deleteuser(user.id)" class="btn btn-danger">Delete</button>
                    </td>

                </tr>

            </tbody>
        </table>
    </div> 
</template>

<script>
    export default {
        data() {
          
            return {
                users: [],
                user: {
                    id: '',
                    email: '',
                   
                },
                user_id: '',
                filterText: '',
                
                pagination: {},
                edit: false
            };
        },
        computed: {
            filterByGender() {
                // return the whole list if there is no filter value
             if (!this.filterText) return this.users
                // otherwise return the list filtered by title
                return this.users.filter(el => el.gender == this.filterText)
            } 

        },
        created() {
            this.fetchusers();
        },
        methods: {
           
           
            fetchusers(page_url) {
                let vm = this;
                 page_url = page_url || '/api/users';;
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.users = res.data;
                        vm.makePagination(res.meta, res.links);
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },
            deleteuser(id) {
                if (confirm('Are You Sure?')) {
                    fetch(`api/user/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('user Removed');
                            this.fetchusers();
                        })
                        .catch(err => console.log(err));
                }
            },
            adduser() {
                if (this.edit === false) {
                    // Add
                    fetch('api/user', {
                        method: 'post',
                        body: JSON.stringify(this.user),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.clearForm();
                            alert('user Added');
                            this.fetchusers();
                        })
                        .catch(err => console.log(err));
                } else {
                    // Update
                    fetch('api/user', {
                        method: 'put',
                        body: JSON.stringify(this.user),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.clearForm();
                            alert('user Updated');
                            this.fetchusers();
                        })
                        .catch(err => console.log(err));
                }
            },
            clearForm() {
                this.edit = false;
                this.user.id = null;
                this.user.user_id = null;
                this.user.name = '';
                this.user.email = '';
                this.user.password = '';
                this.user.gender = '';
                this.user.jop = '';
            }
        }
    };
</script>
