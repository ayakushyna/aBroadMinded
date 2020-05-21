<template>
    <div class="container-fluid">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-two">
                        <header>
                            <h3>{{ first_name }} {{ last_name }}</h3>
                        </header>
                        <div class="">
                            <dl>
                                <dt>Location:</dt>
                                <dd>{{ city }}</dd>
                                <dt>Gender:</dt>
                                <dd>{{ gender }}</dd>
                                <dt>Birthday:</dt>
                                <dd>{{ birthday }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div>
                <b-card no-body>
                    <b-tabs pills card vertical
                            active-nav-item-class="primary"
                            class="text-primary"
                    >
                        <b-tab title="Properties" active>
                            <Table :hasShow="true"
                                   pageShow="PropertyShow"
                                   pageEdit="PropertyEdit"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/properties' ,
                                           delete: this.$route.meta.api.properties }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Bookings" v-if="adminOrSelf()">
                            <Table pageEdit="BookingEdit"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/bookings' ,
                                           delete: this.$route.meta.api.bookings }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Feedbacks" v-if="adminOrSelf()">
                            <Table pageEdit="FeedbackEdit"
                                   :api="{ get: this.$route.meta.api.profiles + '/'+ this.$route.params.id + '/feedbacks' ,
                                           delete: this.$route.meta.api.feedbacks }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Settings" v-if="adminOrSelf()">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h2>Edit login data</h2></div>
                                <div class="panel-body">
                                    <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                                        <b-form-group id="input-group-nickname" label="Nickname:" label-for="input-nickname">
                                            <b-form-input
                                                id="input-nickname"
                                                v-model="form.nickname"
                                                type="text"
                                                required
                                                placeholder="Enter nickname"
                                                class="col-sm-6">
                                                ></b-form-input>
                                        </b-form-group>

                                        <b-form-group id="input-group-email" label="Email:" label-for="input-email">
                                            <b-form-input
                                                id="input-email"
                                                v-model="form.email"
                                                type="email"
                                                required
                                                placeholder="Enter email"
                                                class="col-sm-6">
                                                ></b-form-input>
                                        </b-form-group>

                                        <b-form-group id="input-group-password" label="Password:" label-for="input-password">
                                            <b-form-input
                                                id="input-password"
                                                v-model="form.password"
                                                type="password"
                                                required
                                                class="col-sm-6">
                                                ></b-form-input>
                                        </b-form-group>

                                        <b-form-group id="input-group-password_confirmation" label="Password confirmation:" label-for="input-password_confirmation">
                                            <b-form-input
                                                id="input-password_confirmation"
                                                v-model="form.password_confirmation"
                                                type="password"
                                                required
                                                class="col-sm-6">
                                                ></b-form-input>
                                        </b-form-group>

                                        <b-button type="submit" variant="primary">Submit</b-button>
                                        <b-button type="reset" variant="danger">Reset</b-button>
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
        BTabs, BTab,
        BButton,
        BCard,
        BRow, BCol,
    } from 'bootstrap-vue'

    import axios from 'axios'
    import Table from "../../../components/Table";

    export default {

        data() {
            return {
                name: "",
                first_name: "",
                last_name: "",
                gender: "",
                birthday: "",
                city: "",
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            async getUser() {
                await axios.put(this.$route.meta.api.users + '/'+ this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.email = items.email;
                        this.form.password = items.password;
                        this.form.nickname = items.nickname;
                    })
            },
            onSubmit(evt) {
                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id, {
                    email: this.form.email,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                    nickname: this.form.nickname,
                })
                    .then(response => (
                        this.$router.push({name: 'ProfileIndex'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.email = '';
                this.password = '';
                this.password_confirmation = '';
                this.nickname = '';
            },
            adminOrSelf(){
                console.log(this.$auth.user())
                console.log(this.$route.params)
                console.log(this.$auth.user().id === this.$route.params.id || this.$auth.user().role === 'admin' || this.$auth.user().role === 'root')
                return this.$auth.user().id === this.$route.params.id || this.$auth.user().role === 'admin' || this.$auth.user().role === 'root';
            },
            fetchData() {
                try {
                    axios.get(this.$route.meta.api.profiles + '/' + this.$route.params.id)
                        .then(response => {
                            let items = response.data.items;

                            this.first_name = items.first_name;
                            this.last_name = items.last_name;
                            this.birthday = items.birthday;
                            this.gender = items.gender;
                            this.city = items.city;

                        });
                } catch (err) {
                    debugger;
                }
            }
        },
        components: {
            BCollapse,
            BTabs, BTab,
            BButton,
            BCard,
            BRow, BCol,
            Table
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
