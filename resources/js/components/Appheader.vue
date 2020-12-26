<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <router-link to="/">Home</router-link>
                        <router-link to="/about">About</router-link>
                        <router-link to="/dashboard">dashboard</router-link>
                        <router-link to="/login">login</router-link>

                    </div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
