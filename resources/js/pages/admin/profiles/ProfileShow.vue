<template>
    <div class="container-fluid">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body container">
                    <b-row >
                        <b-col>
                            <b-img thumbnail fluid v-if="photo" :src="'/images/' + photo" alt="Profile photo"></b-img>
                        </b-col>
                        <b-col>
                            <header class="d-flex justify-content-between">
                                <h3>{{ first_name }} {{ last_name }}</h3>

                                <b-button variant="warning" :to="{name: 'ProfileEdit', params: {id: id}}"> Edit profile </b-button>
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
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div>
                <b-card no-body>
                    <b-tabs pills card vertical
                            active-nav-item-class="primary">
                        <b-tab title="Properties" active>
                            <Table name="Property"
                                   :hasShow="true"
                                   pageShow="PropertyShow"
                                   pageEdit="PropertyEdit"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/properties' ,
                                           delete: this.$route.meta.api.properties }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Bookings" v-if="adminOrSelf">
                            <Table name="Booking"
                                   :hasShow="true"
                                   pageShow="BookingShow"
                                   pageEdit="BookingEdit"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/bookings' ,
                                           delete: this.$route.meta.api.bookings }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Feedbacks" v-if="adminOrSelf">
                            <Table  name="Feedback"
                                    pageEdit="FeedbackEdit"
                                    :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/feedbacks' ,
                                           delete: this.$route.meta.api.feedbacks }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Settings" v-if="adminOrSelf">
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
                                                </b-form-group>

                                            <b-form-group id="input-group-password_confirmation" label="Password confirmation:" label-for="input-password_confirmation">
                                                <b-form-input
                                                    id="input-password_confirmation"
                                                    v-model="form.password_confirmation"
                                                    type="password"
                                                    required
                                                    class="col-sm-6"
                                                    ></b-form-input>
                                            </b-form-group>

                                            <b-button type="submit" variant="primary">Submit</b-button>

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
                },
                show: {
                    email: false,
                    password: false,
                    nickname: false,
                },
                name: "",
                id: "",
                first_name: "",
                last_name: "",
                gender: "",
                birthday: "",
                city: "",
                photo: null
            }
        },
        created() {
            this.fetchData();
        },
        computed: {
            adminOrSelf: function ()
            {
                return this.$auth.user().id === this.$route.params.id || this.$auth.user().role === 'admin' || this.$auth.user().role === 'root';
            },
        },
        methods: {
            getUser() {
                axios.get(this.$route.meta.api.users + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.data;
                        this.form.email = items.email;
                        this.form.password = items.password;
                        this.form.nickname = items.nickname;
                    })
            },
            onSubmitEmail(evt) {
                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/email', {
                    email: this.form.email,
                })
                    .then(response => (
                        this.show.email = false
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onSubmitNickname(evt) {
                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/nickname', {
                    nickname: this.form.nickname,
                })
                    .then(response => (
                        this.show.nickname = false
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onSubmitPassword(evt) {
                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id + '/password', {
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation
                })
                    .then(response => (
                        this.show.password = false
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
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
