<template>
    <div class="container">
        <div class="form-group">
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Edit profile</h2></div>
            <div class="panel-body">
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                    <b-form-group  class="col-sm-6" id="input-group-first_name" label="First Name:" label-for="input-first_name">
                        <b-form-input
                            id="input-first_name"
                            v-model="form.first_name"
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

                    <b-form-group class="col-sm-6" id="input-group-last_name" label="Last Name:" label-for="input-last_name">
                        <b-form-input
                            id="input-last_name"
                            v-model="form.last_name"
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

                    <b-form-group class="col-sm-6" id="input-group-gender" label="Gender:" label-for="input-gender">
                        <b-form-select
                            id="input-gender"
                            v-model="form.gender"
                            :options="gender"
                            required
                            ></b-form-select>

                        <div v-if="errors.gender">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in errors.gender">{{ value }}</li>
                            </ul>
                        </div>
                    </b-form-group>

                    <b-form-group class="col-sm-6" id="input-group-birthday" label="Birthday:" label-for="input-birthday">
                        <el-date-picker
                            v-model="form.birthday"
                            type="date"
                            required
                            placeholder="Pick a Date"
                            format="yyyy/MM/dd"
                            value-format="yyyy-MM-dd"
                            :max="new Date()">
                        </el-date-picker>

                        <div v-if="errors.birthday">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in errors.birthday">{{ value }}</li>
                            </ul>
                        </div>
                    </b-form-group>

                    <b-form-group class="col-sm-6" id="input-group-country" label="Country:" label-for="input-country">
                        <b-form-select
                            id="input-country"
                            v-model="form.country_id"
                            v-on:change='getStates()'
                            required>
                            <option v-for="country in countries" v-bind:value="country.id">
                                {{ country.name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group class="col-sm-6" id="input-group-state" label="State:" label-for="input-state">
                        <b-form-select
                            id="input-state"
                            v-model="form.state_id"
                            v-on:change='getCities()'
                            required>
                            <option v-for="state in states" v-bind:value="state.id">
                                {{ state.name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group class="col-sm-6" id="input-group-city" label="City:" label-for="input-city">
                        <b-form-select
                            id="input-city"
                            v-model="form.city_id"
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

                    <b-form-group class="col-sm-6" id="input-group-photo" label="Profile image:" label-for="input-photo" accept=".jpg, .jpeg, .png, .gif">
                        <div class="col-md-3" v-if="form.photo">
                            <img :src="'/images/' + form.photo" class="img-responsive" height="140" width="180" alt="Profile image">
                        </div>
                        <div>
                            <input type="file" v-on:change="onImageChange" class="form-control">
                        </div>
                    </b-form-group>

                    <b-button type="submit" variant="primary">Submit</b-button>
                    <b-button type="reset" variant="danger">Reset</b-button>
                </b-form>
                <b-card class="mt-3" header="Form Data Result">
                    <pre class="m-0">{{ form }}</pre>
                </b-card>
            </div>
        </div>
    </div>
</template>

<script>
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BCard, BFormFile} from 'bootstrap-vue'
    import axios from "axios";

    export default {
        data() {
            return {
                form: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    birthday: '',
                    gender: '',
                    photo:null,
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
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getCountries();
            this.getGender();
            this.getProfile();
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();

                reader.onload = (e) => {
                    this.form.photo = e.target.result;
                };
                reader.readAsDataURL(file);
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
                await axios.get(this.$route.meta.api.countries + '/'+ this.form.country_id + '/states')
                    .then((response) => {
                        this.cities = []
                        this.states = response.data.items;
                    })
            },
            async getCities() {
                await axios.get(this.$route.meta.api.states + '/'+ this.form.state_id + '/cities')
                    .then((response) => {
                        this.cities = response.data.items;
                    })
            },
            async getCountry(state) {
                await axios.get(this.$route.meta.api.states + '/' + state + '/country')
                    .then((response) => {
                        this.form.country_id = response.data.items.id;
                        this.getStates();

                        this.form.state_id = this.state_id;
                        this.getCities();

                        this.form.city_id= this.city_id;
                    })
            },
            async getState(city) {
                await axios.get(this.$route.meta.api.cities + '/' + city + '/state')
                    .then((response) => {
                        this.state_id = response.data.items.id;
                        this.getCountry(this.state_id);
                    })
            },
            async getProfile() {
                await axios.get(this.$route.meta.api.profiles + '/'+ this.$route.params.id)
                    .then((response) => {
                        let items = response.data.items;

                        this.form.id = items.id;
                        this.form.first_name = items.first_name;
                        this.form.last_name = items.last_name;
                        this.form.birthday = items.birthday;
                        this.form.gender = items.gender;
                        this.form.photo = items.photo;
                        this.form.country_id = items.country_id;
                        this.form.state_id = items.state_id;
                        this.form.city_id = items.city_id;

                        this.city_id = items.city_id;
                        if(this.city_id !== null)
                            this.getState(items.city_id);
                    })
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.put(this.$route.meta.api.profiles + '/' + this.$route.params.id, {
                    id:  this.form.id,
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    birthday: this.form.birthday,
                    gender: this.form.gender,
                    photo: this.form.photo,
                    city_id: this.form.city_id ,
                    active: true
                })
                    .then(response => (
                        this.$router.go(-1)
                    ))
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.first_name = '';
                this.form.last_name = '';
                this.form.birthday = '';
                this.form.gender = null;
                this.form.country_id = null;
                this.form.state_id = null;
                this.form.city_id = null;
                this.form.photo = null;
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.has_error = false;
                this.errors = {}
                this.$nextTick(() => {
                    this.show = true
                })
            }
        },
        components: {
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BCard,BFormFile
        }
    }
</script>
