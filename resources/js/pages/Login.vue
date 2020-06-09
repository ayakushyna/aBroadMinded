<template>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div class="alert alert-danger" v-if="has_error && !success">
                            <p v-if="error">Error, unable to connect with these credentials.</p>
                        </div>
                        <form autocomplete="off" @submit.prevent="login" method="post">
                            <div class="form-group">
                                <label for="login">E-mail or nickname</label>
                                <input id="login" class="form-control" placeholder="user@example.com" v-model="login_data" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </form>
                        <b-row class="d-flex justify-content-center">
                            <p> No account? </p>  <router-link class="nav-link p-0 pl-1"  :to="{name: 'Register'}"> Create one </router-link>
                        </b-row>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {
        BButton,
        BCard,
        BRow, BCol,
    } from 'bootstrap-vue'

    export default {
        data() {
            return {
                login_data: null,
                password: null,
                success: false,
                has_error: false,
                error: ''
            }
        },
        mounted() {
            //
        },
        methods: {
            login() {
                // get the redirect object
                var app = this;
                let redirect = this.$auth.redirect()
                this.$auth.login({
                    data: {
                        login: this.login_data,
                        password: this.password
                    },
                    success: function() {
                        // handle redirection
                        this.success = true
                        app.$router.push({name: redirect})
                        app.error = ''
                    },
                    error: function(error) {
                        app.has_error = true
                        app.error = error.response.data.error;
                    },
                    rememberMe: true,
                    fetchUser: true
                })
            }
        },
        components: {
            BButton,
            BCard,
            BRow, BCol,
        },
    }
</script>
