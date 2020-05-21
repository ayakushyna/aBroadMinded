<template>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form-wizard @on-complete="onComplete"
                                     shape="tab"
                                     color="#4A30D1">
                            <tab-content title="Login Data"
                                         icon="ti-user" :before-change="register">
                                <div class="alert alert-danger" v-if="has_error && !success">
                                    <p v-if="error === 'registration_validation_error'">Validation Errors.</p>
                                    <p v-else>Error, can not register at the moment. If the problem persists, please contact an administrator.</p>
                                </div>
                                <form autocomplete="off" v-if="!success" method="post">
                                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.nickname }">
                                        <label for="nickname">Nickname</label>
                                        <input type="text" id="nickname" class="form-control" placeholder="Full Name" v-model="nickname">
                                        <span class="help-block" v-if="has_error && errors.nickname">{{ errors.nickname }}</span>
                                    </div>
                                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.email }">
                                        <label for="email">E-mail</label>
                                        <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email">
                                        <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>
                                    </div>
                                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" class="form-control" v-model="password">
                                        <span class="help-block" v-if="has_error && errors.password">{{ errors.password }}</span>
                                    </div>
                                    <div class="form-group" v-bind:class="{ 'has-error': has_error && errors.password }">
                                        <label for="password_confirmation">Password confirmation</label>
                                        <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation">
                                    </div>
                                </form>
                            </tab-content>
                            <tab-content title="Personal Info"
                                         icon="ti-settings">
                                My second tab content
                            </tab-content>
                            <tab-content title="Last step"
                                         icon="ti-check">
                                Yuhuuu! This seems pretty damn simple
                            </tab-content>
                        </form-wizard>

                        <b-card class="mt-3" header="Form Data Result">
                            <pre class="m-0">{{ has_error }} ,{{error}} ,
{{errors}} ,
{{success}}</pre>
                        </b-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from "axios";

    import {FormWizard, TabContent} from 'vue-form-wizard'
    import 'vue-form-wizard/dist/vue-form-wizard.min.css'
    import {BCard} from "bootstrap-vue";

    export default {
        data() {
            return {
                id: '',
                nickname: '',
                email: '',
                password: '',
                password_confirmation: '',
                has_error: false,
                error: '',
                errors: {},
                success: false
            }
        },
        methods: {
            onComplete(){},
            createProfile(){
                axios.post(this.$route.meta.api.profiles, {
                    id: this.form.id,
                    first_name: '',
                    last_name: '',
                    birthday: '',
                    gender: '',
                    city_id: '' ,
                    active: true
                })
                    .then(response => {
                        console.log(response.data)
                        this.$router.push({name: 'ProfileEdit', params: {id: this.form.id}});
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
                    .finally(() => this.loading = false);

            },
            register() {
                this.$auth.register({
                    data: {
                            nickname: this.nickname,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation

                    },
                    success: function (res) {
                        this.success = true;
                        this.form.id = res.response.data.items.id;
                        console.log(this.form.id);
                        return true;
                    },
                    error: function (res) {
                        this.has_error = true
                        this.error = res.response.data.error
                        console.log(res.response)
                        this.errors = res.response.data.errors || {}
                        return false;
                    }
                })
            }
        },
        components: {
            BCard,
            FormWizard,
            TabContent
        }
    }
</script>
