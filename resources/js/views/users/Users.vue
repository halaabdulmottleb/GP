<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" v-bind:key ="user.id">
                <th scope="row">1</th>
                <td>{{user.id}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
               
            </tr>
           
        </tbody>
    </table>
</template>

<script>
export default {
       
        data() {
        return {
            users: []
        }
            
        },
        mounted() {
            this.loadData();
        },
        methods: {
            loadData: function () {
                axios.get('http://127.0.0.1:8000/api/users').then(res => {
                    if (res.status == 200) {
                        this.users = res.data;
                    }
                }).catch(err => {
                    console.log(err)
                });
            }
        }
 
}
</script>
