<template>
    <div>
       


        <div class="alert alert-danger text-center" v-show="msgShow" @click="hideALert()">
            {{deletedMsg}}
        </div>




        <!-- Radio buttons for filter by gender-->
        <div class="row mt-4 mb-4">
            <div class="col-md-3 ">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn btn-secondary ">
                        <input v-model="removelines" name="removelines" type="radio" class="cheker" v-bind:value="'all'">
                        All
                    </label>
                    <label class="btn btn btn-secondary">
                        <input v-model="removelines" name="removelines" type="radio" class="cheker" v-bind:value="'female'">
                        Female
                    </label>
                    <label class="btn btn btn-secondary">
                        <input v-model="removelines" name="removelines" type="radio" class="cheker" v-bind:value="'male'">
                        Male
                    </label>
                </div>
            </div>
            <div class="col-md-3">

                <select class="form-control" v-model="filterJop">
                    <option disabled style="color:grey">Filter By jops </option>
                    <option value="all">all</option>
                    <option v-for="jop in jops.slice(0, 10)">{{jop}}</option>
                </select>
            </div>


            <div class="col-md-6 ">
                <CButton @click="warningModal = true"
                         color="success" class="float-right ">
                    Add
                </CButton>

            </div>

        </div>

        <!-- end Radio buttons for filter by gender-->
        <!--Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" @click="fetchusers(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" @click="fetchusers(pagination.next_page_url)">Next</a></li>
            </ul>

        </nav>
        <!--end pagination-->
        <!--  Table of users -->
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">
                        Name
                        <button class="float-right btn btn-secondary btn-sm" v-model="sortNameFlag" @click="sortNameFunction()">
                            <img src="https://img.icons8.com/metro/10/000000/sort.png" />
                        </button>

                    </th>
                    <th scope="col">Email</th>
                    <th scope="col">
                        Jop
                        <button class="float-right btn btn-secondary btn-sm" v-model="sortJopFlag" @click="sortJopFunction()">
                            <img src="https://img.icons8.com/metro/10/000000/sort.png" />
                        </button>
                    </th>
                    <th scope="col">Gender</th>
                    <th scope="col">Controler</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in filter" v-bind:key="user.id">

                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.jop}}</td>
                    <td>{{user.gender}}</td>
                    <td>
                        <CButtonToolbar>
                            <CButton @click="deleteuser(user.id)" color="danger">Delete</CButton>
                            <CButton @click="edituser(user) ; warningModal = true " color="primary">Update</CButton>

                        </CButtonToolbar>

                    </td>



                </tr>

            </tbody>
        </table>
        <!-- end Table of users -->
        <!--Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" @click="fetchusers(pagination.prev_page_url)">Previous</a></li>

                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" @click="fetchusers(pagination.next_page_url)">Next</a></li>
            </ul>

        </nav>
        <!--end pagination-->
        <!-- modal for add new user-->

        <CModal title="Add new USer"
                color="warning"
                :show.sync="warningModal">
            <CRow>
                <CCol sm="12">
                    <CCard>
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
                    </CCard>
                </CCol>
            </CRow>
        </CModal>
        <!-- end modal for add new user-->
<!-- modal for add new user-->

        
        <!-- end modal for add new user-->
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
                    name: '',
                    jop: '',
                    gender: '',
                    password: '',
                   
                },
                jops : [],
                user_id: '',
                filterText: '',
                filterJop: 'all',
                removelines: 'all',
                warningModal: false,
                editModal : false,
                msgShow: false,
                deletedMsg: '',
                sortNameFlag: false,
                sortJopFlag:false ,
                pagination: {},
                edit: false
            };
        },
        computed: {

            filter() {
               
                return this.filterByJop(this.filterByGender(this.sortedArrayByName(this.sortedArrayByJop(this.users))));
            },


        },
        
        created() {
            this.fetchusers();
        },
        mounted() {
            this.loadJops();
        },
        methods: {
            hideALert() {
               this.msgShow = false
            },
            sortNameFunction() {
                this.sortJopFlag = false;
                this.sortNameFlag = !this.sortNameFlag;
                
            },
            sortJopFunction() {
                this.sortNameFlag = false;
                this.sortJopFlag = ! this.sortJopFlag
            },

            filterByGender(users) {
                // return the whole list if there is no filter value
                if (this.removelines == "all") return this.users
                // otherwise return the list filtered by gender
                return users.filter(el => el.gender == this.removelines)
            },


            filterByJop(users) {
                // return the whole list if there is no filter value
                if (this.filterJop == "all") return users
                // otherwise return the list filtered by jop
                return users.filter(el => el.jop == this.filterJop)
            },
            sortedArrayByName(users) {
                if (!this.sortNameFlag) return this.users
                return users.sort((a, b) => (a.name > b.name) ? 1 : -1)
            },
             sortedArrayByJop(users) {
                 if (!this.sortJopFlag) return this.users
                return users.sort((a, b) => (a.jop > b.jop) ? 1 : -1)
            },

            loadJops: function () {
                axios.get('http://127.0.0.1:8000/api/users/jops').then(res => {
                    if (res.status == 200) {
                        this.jops = res.data;
                    }
                }).catch(err => {
                    console.log(err)
                });
            },
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
               
                    fetch(`api/user/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                           // alert('user Removed');
                            this.msgShow = true;
                            this.deletedMsg = "Deleted"
                            this.fetchusers();
                        })
                        .catch(err => console.log(err));
                
            },
           
            adduser() {
                if (this.edit === false) {
                    // Add
                    console.log(this.user);
                    fetch('http://127.0.0.1:8000/api/user', {
                       
                        method: 'post',
                        body: JSON.stringify(this.user),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.clearForm();
                            this.msgShow = true;
                            this.deletedMsg = "User Added"
                            this.fetchusers();
                        })
                        .catch(err => console.log(err));
                } else {
                    // Update
                    fetch(`api/user`, {
                        method: 'put',
                        body: JSON.stringify(this.user),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.clearForm();
                            this.msgShow = true;
                            this.deletedMsg = "User Updated"
                        })
                        .catch(err => console.log(err));
                }
            },
            edituser(user) {
                this.edit = true;
                this.user.id = user.id;
                this.user.user_id = user.id;
                this.user.name = user.name;
                this.user.email = user.email;
                this.user.password = user.password;
                this.user.jop = user.jop;
                this.user.gender = user.gender;
            },
            clearForm() {
                this.edit = false;
                this.user.id = null;
                this.user.user_id = null;
                this.user.name = '';
                this.user.email = '';
                this.user.password = '';
                this.user.jop = '';
                this.user.gender = '';
            }

            //////
        }
    };
</script>
