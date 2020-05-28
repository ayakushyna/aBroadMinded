<template>
    <div class="container-fluid">
        <!-- Column -->
        <div class="col-lg-12">
            <b-card>
                <div class="d-flex flex-row-reverse">
                    <b-button variant="warning" v-if="isAdmin || isSelf" :to="{name: 'ProfileEdit', params: {id: id}}"> Edit Profile</b-button>
                </div>
                <div class="card-body container">
                    <b-row >
                        <b-col>
                            <b-img thumbnail fluid v-if="photo" :src="'/storage/' + photo" alt="Profile photo"></b-img>
                        </b-col>
                        <b-col>
                            <header>
                                <h3>{{ first_name }} {{ last_name }}</h3>
                            </header>
                            <div>
                                <dl>
                                    <dt>Location:</dt>
                                    <dd>{{ city }}</dd>
                                    <dt>Gender:</dt>
                                    <dd>{{ gender }}</dd>
                                    <dt>Birthday:</dt>
                                    <dd>{{ birthday }}</dd>
                                </dl>
                            </div>
                        </b-col>
                    </b-row>
                </div>
            </b-card>
        </div>

        <div class="col-lg-12 mt-4">
            <div>
                <b-card no-body>
                    <b-tabs pills card vertical
                            active-nav-item-class="primary">
                        <b-tab title="Properties" active>

                            <div class="d-flex flex-row-reverse">
                                <b-button v-if="isSelf" :to="{name: 'PropertyCreate' }" variant="primary">Add property</b-button>
                            </div>

                            <Table name="Property"
                                   :hasShow="true"
                                   pageShow="PropertyShow"
                                   pageEdit="PropertyEdit"
                                   :actions="isAdmin || isSelf"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/properties' ,
                                           delete: this.$route.meta.api.properties }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Bookings" v-if="isAdmin || isSelf">
                            <Table name="Booking"
                                   :hasShow="true"
                                   pageShow="BookingShow"
                                   pageEdit="BookingEdit"
                                   :actions="isAdmin || isSelf"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/bookings' ,
                                           delete: this.$route.meta.api.bookings }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Feedbacks" v-if="isAdmin || isSelf">
                            <Table  name="Feedback"
                                    pageEdit="FeedbackEdit"
                                    :actions="isAdmin || isSelf"
                                    :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/feedbacks' ,
                                           delete: this.$route.meta.api.feedbacks }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Settings" v-if="isAdmin || isSelf">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3>Edit login data</h3>
                                </div>

                                <div class="panel-body">

                                    <b-form @submit.prevent="onSubmitNickname">

                                        <b-input-group id="input-group-nickname"  prepend="Nickname:">

                                            <b-form-input
                                                id="input-nickname"
                                                v-model="form.nickname"
                                                type="text"
                                                required
                                                :readonly="!show.nickname"
                                                placeholder="Enter nickname"
                                                class="col-sm-4"
                                                ></b-form-input>

                                            <b-input-group-append v-if="!show.nickname">
                                                <b-button  variant="outline-dark" @click="show.nickname = !show.nickname">
                                                    <b-icon icon="pencil" aria-label="Edit"></b-icon>
                                                </b-button>
                                            </b-input-group-append>

                                            <b-input-group-append v-else>
                                                <b-button type="submit" v-show="show.nickname" variant="primary">
                                                    <b-icon icon="check" aria-label="Submit"></b-icon>
                                                </b-button>

                                                <b-button v-show="show.nickname" @click="show.nickname = !show.nickname" variant="danger">
                                                    <b-icon icon="x" aria-label="Cancel"></b-icon>
                                                </b-button>
                                            </b-input-group-append>

                                        </b-input-group>

                                        <div v-if="errors.nickname && show.nickname">
                                            <ul class=" col-sm-6 alert alert-danger">
                                                <li v-for="(value, key, index) in errors.nickname">{{ value }}</li>
                                            </ul>
                                        </div>

                                    </b-form>

                                    <b-form @submit.prevent="onSubmitEmail" class="mt-3">

                                        <b-input-group id="input-group-email" prepend="Email:">

                                            <b-form-input
                                                id="input-email"
                                                v-model="form.email"
                                                type="email"
                                                required
                                                :readonly="!show.email"
                                                placeholder="Enter email"
                                                class="col-sm-4"
                                                ></b-form-input>

                                            <b-input-group-append v-if="!show.email">
                                                <b-button  variant="outline-dark" @click="show.email = !show.email">
                                                    <b-icon icon="pencil" aria-label="Edit"></b-icon>
                                                </b-button>
                                            </b-input-group-append>

                                            <b-input-group-append v-else>
                                                <b-button type="submit" v-show="show.email" variant="primary">
                                                    <b-icon icon="check" aria-label="Submit"></b-icon>
                                                </b-button>

                                                <b-button v-show="show.email" variant="danger">
                                                    <b-icon icon="x" aria-label="Cancel"></b-icon>
                                                </b-button>
                                            </b-input-group-append>

                                        </b-input-group>

                                        <div v-if="errors.email && show.email">
                                            <ul class="col-sm-6 alert alert-danger">
                                                <li v-for="(value, key, index) in errors.email">{{ value }}</li>
                                            </ul>
                                        </div>

                                    </b-form>

                                    <b-button  class="mt-3"
                                               @click="show.password = !show.password"
                                               variant="primary">
                                        Change password
                                    </b-button>

                                    <b-form @submit.prevent="onSubmitPassword" class="mt-3" v-show="show.password">

                                            <b-form-group id="input-group-password" label="Password:" label-for="input-password">
                                                <b-form-input
                                                    id="input-password"
                                                    v-model="form.password"
                                                    type="password"
                                                    required
                                                    class="col-sm-6"
                                                    ></b-form-input>

                                                <div v-if="errors.password">
                                                    <ul class="col-sm-6 alert alert-danger">
                                                        <li v-for="(value, key, index) in errors.password">{{ value }}</li>
                                                    </ul>
                                                </div>
                                                </b-form-group>

                                            <b-form-group id="input-group-password_confirmation" label="Password confirmation:" label-for="input-password_confirmation">
                                                <b-form-input
                                                    id="input-password_confirmation"
                                                    v-model="form.password_confirmation"
                                                    type="password"
                                                    required
                                                    class="col-sm-6"
                                                    ></b-form-input>

                                                <div v-if="errors.password_confirmation">
                                                    <ul class="col-sm-6 alert alert-danger">
                                                        <li v-for="(value, key, index) in errors.password_confirmation">{{ value }}</li>
                                                    </ul>
                                                </div>
                                            </b-form-group>

                                            <b-button type="submit" variant="primary">Submit</b-button>

                                    </b-form>

                                    <b-button  class="mt-3"
                                               @click="show.role = !show.role"
                                               variant="primary"
                                               v-if="root && !isSelf">
                                        Change role
                                    </b-button>

                                    <b-form @submit.prevent="onSubmitRole" class="mt-3" v-show="show.role">
                                        <b-form-group id="input-group-role" label="Role:" label-for="input-role">
                                            <b-form-select
                                                id="input-role"
                                                v-model="form.role"
                                                :options="roles"
                                                required
                                                class="col-sm-4">
                                                ></b-form-select>

                                        </b-form-group>

                                        <b-button type="submit" variant="primary">Submit</b-button>

                                        <div v-if="errors.role">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.role">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form>


                                    <b-card class="mt-3" header="Form Data Result">
                                        <pre class="m-0">{{ form }}</pre>
                                    </b-card>
                                </div>
                            </div>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        VBToggle,
        BCollapse,
        BTabs,
        BTab,
        BButton,
        BCard,
        BRow,
        BCol,
        BForm,
        BFormGroup,
        BFormSelect,
        BFormInput,
        BInputGroup,
        BInputGroupPrepend,
        BInputGroupAppend,
        BIcon, BIconPencil,BIconX,BIconCheck, BImg
    } from 'bootstrap-vue'

    import axios from 'axios'
    import Table from "../../../components/Table";

    export default {

        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    nickname: '',
                    role: '',
                },
                show: {
                    email: false,
                    password: false,
                    nickname: false,
                    role: false,
                },
                name: "",
                id: "",
                first_name: "",
                last_name: "",
                gender: "",
                birthday: "",
                city: "",
                roles: [],
                photo: null,
                has_error: false,
                errors: {},
            }
        },
        created() {
            this.getRoles();
            this.fetchData();
            this.$forceUpdate();
        },
        computed: {
            root: function() {
                return this.$auth.user().role === 'root';
            },
            isAdmin: function() {
                return this.$auth.user() && (this.$auth.user().role === 'admin' || this.$auth.user().role === 'root');
            },
            isSelf: function() {
                return this.$auth.user() &&  (this.$auth.user().id === this.id);
            },
        },
        methods: {
            async getRoles() {
                await axios.get(this.$route.meta.api.roles)
                    .then((response) => {
                        this.roles = response.data.items;
                    })
            },
            getUser() {
                axios.get(this.$route.meta.api.users + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.data;
                        this.form.role = items.role;
                        this.form.email = items.email;
                        this.form.nickname = items.nickname;
                    })
            },
            onSubmitEmail(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/email', {
                    email: this.form.email,
                })
                    .then(response => (
                        this.show.email = false
                    ))
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            onSubmitNickname(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/nickname', {
                    nickname: this.form.nickname,
                })
                    .then(response => (
                        this.show.nickname = false
                    ))
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            onSubmitPassword(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/password', {
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation
                })
                    .then(response => (
                        this.show.password = false
                    ))
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            onSubmitRole(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/role', {
                    role: this.form.role,
                })
                    .then(response => (
                        this.show.role = false
                    ))
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            fetchData() {
                try {
                    axios.get(this.$route.meta.api.profiles + '/' + this.$route.params.id)
                        .then(response => {
                            let items = response.data.items;

                            this.id = items.id;
                            this.first_name = items.first_name;
                            this.last_name = items.last_name;
                            this.birthday = items.birthday;
                            this.gender = items.gender;
                            this.city = items.city;
                            this.photo = items.photo;

                            this.getUser();

                        });
                } catch (err) {
                    debugger;
                }
            }
        },
        components: {
            BCollapse,
            BTabs, BTab,
            Table,
            BFormGroup,
            BRow, BCol, BForm, BFormSelect, BButton, BCard,
            BFormInput, BInputGroup, BInputGroupPrepend, BInputGroupAppend,
            BIcon, BIconPencil, BIconX,BIconCheck, BImg
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
