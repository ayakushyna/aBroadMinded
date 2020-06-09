<template>
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-body">
                        <form-wizard @on-complete="register"
                                     shape="tab"
                                     color="#4A30D1"
                                     title="Registration"
                                     subtitle="">
                            <tab-content title="Login Data"
                                         icon="ti-user" :before-change="beforeTabChange">

                                    <b-form-group id="input-group-nickname" label="Nickname:" label-for="input-nickname">
                                        <b-form-input type="text"
                                               required
                                               id="input-nickname"
                                               placeholder="Enter nickname"
                                               v-model="form1.nickname">
                                        </b-form-input>
                                        <div v-if="errors.nickname" class="mt-2">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.nickname">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form-group>

                                    <b-form-group id="input-group-email" label="Email:" label-for="input-email">
                                        <b-form-input type="email"
                                               required
                                               id="input-email"
                                               placeholder="user@example.com"
                                               v-model="form1.email">
                                        </b-form-input>
                                        <div v-if="errors.email">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.email">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form-group>

                                    <b-form-group id="input-group-password" label="Password:" label-for="input-password">
                                        <b-form-input type="password"
                                               required
                                               id="input-password"
                                               placeholder="Enter password"
                                               v-model="form1.password">
                                        </b-form-input>
                                        <div v-if="errors.password">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.password">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form-group>

                                    <b-form-group id="input-group-password_confirmation" label="Password confirmation:" label-for="input-password_confirmation">
                                        <b-form-input type="password"
                                               required
                                               id="input-password_confirmation"
                                               placeholder="Repeat password"
                                               v-model="form1.password_confirmation">
                                        </b-form-input>
                                        <div v-if="errors.password_confirmation">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.password_confirmation">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form-group>

                            </tab-content>
                            <tab-content title="Personal Info"
                                         icon="ti-settings"
                                         :before-change="beforeRegister">

                                <div class="d-flex justify-content-between">
                                    <b-form-group class="mr-1" id="input-group-first_name" label="First Name:" label-for="input-first_name">
                                        <b-form-input
                                            id="input-first_name"
                                            v-model="form2.first_name"
                                            type="text"
                                            required
                                            placeholder="Enter first name"
                                        ></b-form-input>
                                        <div v-if="errors.first_name">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.first_name">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form-group>

                                    <b-form-group  class="ml-1" id="input-group-last_name" label="Last Name:" label-for="input-last_name">
                                        <b-form-input
                                            id="input-last_name"
                                            v-model="form2.last_name"
                                            type="text"
                                            required
                                            placeholder="Enter last name"
                                        ></b-form-input>
                                        <div v-if="errors.last_name">
                                            <ul class="alert alert-danger">
                                                <li v-for="(value, key, index) in errors.last_name">{{ value }}</li>
                                            </ul>
                                        </div>
                                    </b-form-group>
                                </div>


                                <b-form-group id="input-group-gender" label="Gender:" label-for="input-gender">
                                    <b-form-select
                                        id="input-gender"
                                        v-model="form2.gender"
                                        :options="gender"
                                        required
                                        class="col-sm-6"
                                    ></b-form-select>
                                    <div v-if="errors.м">
                                        <ul class="alert alert-danger">
                                            <li v-for="(value, key, index) in errors.gender">{{ value }}</li>
                                        </ul>
                                    </div>
                                </b-form-group>

                                <b-form-group id="input-group-birthday" label="Birthday:" label-for="input-birthday">
                                    <el-date-picker
                                        v-model="form2.birthday"
                                        type="date"
                                        required
                                        placeholder="Pick a Date"
                                        format="yyyy/MM/dd"
                                        value-format="yyyy-MM-dd"
                                        :picker-options="datePickerOptions">
                                    </el-date-picker>
                                    <div v-if="errors.birthday">
                                        <ul class="alert alert-danger">
                                            <li v-for="(value, key, index) in errors.birthday">{{ value }}</li>
                                        </ul>
                                    </div>
                                </b-form-group>

                                <b-form-group  id="input-group-country" label="Country:" label-for="input-country">
                                    <b-form-select
                                        id="input-country"
                                        v-model="form2.country_id"
                                        v-on:change='getStates()'
                                        required>
                                        <option v-for="country in countries" v-bind:value="country.id">
                                            {{ country.name }}
                                        </option>
                                    </b-form-select>
                                </b-form-group>

                                <b-form-group id="input-group-state" label="State:" label-for="input-state">
                                    <b-form-select
                                        id="input-state"
                                        v-model="form2.state_id"
                                        v-on:change='getCities()'
                                        required>
                                        <option v-for="state in states" v-bind:value="state.id">
                                            {{ state.name }}
                                        </option>
                                    </b-form-select>
                                </b-form-group>

                                <b-form-group id="input-group-city" label="City:" label-for="input-city">
                                    <b-form-select
                                        id="input-city"
                                        v-model="form2.city_id"
                                        required>
                                        <option v-for="city in cities" v-bind:value="city.id">
                                            {{ city.name }}
                                        </option>
                                    </b-form-select>
                                    <div v-if="errors.city_id">
                                        <ul class="alert alert-danger">
                                            <li v-for="(value, key, index) in errors.city_id">{{ value }}</li>
                                        </ul>
                                    </div>
                                </b-form-group>

                                <b-form-group class="col-sm-6" id="input-group-contact_info" label="Contact Info:" label-for="input-contact_info">
                                    <b-form-textarea
                                        id="input-contact_info"
                                        v-model="form2.contact_info"
                                        placeholder="Enter your contact info..."
                                        rows="4"
                                        max-rows="3"
                                    ></b-form-textarea>

                                    <div v-if="errors.contact_info">
                                        <ul class="alert alert-danger">
                                            <li v-for="(value, key, index) in errors.contact_info">{{ value }}</li>
                                        </ul>
                                    </div>
                                </b-form-group>
                            </tab-content>
                        </form-wizard>
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
    import {BButton, BCard, BCol, BForm, BFormFile, BFormGroup, BFormInput, BFormSelect, BRow, BFormTextarea} from "bootstrap-vue";

    export default {
        data() {
            return {
                form1: {
                    id: '',
                    nickname: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                form2: {
                    first_name: '',
                    last_name: '',
                    birthday: '',
                    gender: '',
                    photo:null,
                    contact_info:null,
                    country_id: null,
                    state_id: null,
                    city_id: null,
                },
                state_id: null,
                city_id: null,
                gender:[],
                countries: [],
                states: [],
                cities:[],
                datePickerOptions: {
                    disabledDate: this.disabledDate
                },
                has_error: false,
                error: '',
                errors: {},
                success: false
            }
        },
        methods: {
            disabledDate (date) {
                var limit = new Date();
                limit.setFullYear(limit.getFullYear() - 18);
                return date >= limit
            },
            async getGender() {
                await axios.get(this.$route.meta.api.gender)
                    .then((response) => {
                        this.gender = response.data.items;
                    })
            },
            async getCountries() {
                await axios.get(this.$route.meta.api.countries)
                    .then((response) => {
                        this.countries = response.data.items;

                    })
            },
            async getStates() {
                await axios.get(this.$route.meta.api.countries + '/'+ this.form2.country_id + '/states')
                    .then((response) => {
                        this.cities = []
                        this.states = response.data.items;
                    })
            },
            async getCities() {
                await axios.get(this.$route.meta.api.states + '/'+ this.form2.state_id + '/cities')
                    .then((response) => {
                        this.cities = response.data.items;
                    })
            },
            async validateUser(){
                this.has_error = false;
                this.errors = {}

                await axios.post(this.$route.meta.api.validate_user, {
                    nickname: this.form1.nickname,
                    email: this.form1.email,
                    password: this.form1.password,
                    password_confirmation: this.form1.password_confirmation
                })
                .then(response => {})
                .catch(error => {
                    this.has_error = true;
                    this.errors = error.response.data.errors;
                })
            },
            async beforeTabChange()
            {
                await this.validateUser();
                if(!this.has_error){
                    await this.getCountries();
                    await this.getGender();
                }
                return !this.has_error;
            },
            async validateProfile(){
                this.has_error = false;
                this.errors = {}

                await axios.post(this.$route.meta.api.validate_profile, {
                    first_name: this.form2.first_name,
                    last_name: this.form2.last_name,
                    birthday: this.form2.birthday,
                    gender: this.form2.gender,
                    photo: null,
                    contact_info: this.form2.contact_info,
                    country_id: this.form2.country_id,
                    state_id: this.form2.state_id,
                    city_id: this.form2.city_id,
                })
                    .then(response => {})
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            async beforeRegister()
            {
                await this.validateProfile();
                return !this.has_error;
            },
            register() {
                let app = this
                this.$auth.register({
                    data: {
                            nickname: this.form1.nickname,
                            email: this.form1.email,
                            password: this.form1.password,
                            password_confirmation: this.form1.password_confirmation,

                            first_name: this.form2.first_name,
                            last_name: this.form2.last_name,
                            birthday: this.form2.birthday,
                            gender: this.form2.gender,
                            photo: null,
                            contact_info: this.form2.contact_info,
                            country_id: this.form2.country_id,
                            state_id: this.form2.state_id,
                            city_id: this.form2.city_id,

                    },
                    success: function (res) {
                        app.$router.push({name: 'Login'})
                    },
                    error: function (error) {
                        app.has_error = true;
                        app.errors = error.response.data.errors;
                    }
                })
            }
        },
        components: {
            BCard,
            FormWizard,
            TabContent,
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BFormFile, BFormTextarea
        }
    }
</script>
