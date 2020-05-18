<template>
    <div class="container">
        <div class="form-group">
            <router-link :to="{name: 'ProfileIndex'}" class="btn btn-outline-primary">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Edit profile</h2></div>
            <div class="panel-body">
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                    <b-form-group id="input-group-first_name" label="First Name:" label-for="input-first_name">
                        <b-form-input
                            id="input-first_name"
                            v-model="form.first_name"
                            type="text"
                            required
                            placeholder="Enter first name"
                            class="col-sm-6">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-last_name" label="Last Name:" label-for="input-last_name">
                        <b-form-input
                            id="input-last_name"
                            v-model="form.last_name"
                            type="text"
                            required
                            placeholder="Enter last name"
                            class="col-sm-6">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-gender" label="Gender:" label-for="input-gender">
                        <b-form-select
                            id="input-gender"
                            v-model="form.gender"
                            :options="gender"
                            required
                            class="col-sm-6">
                            ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-birthday" label="Birthday:" label-for="input-birthday">
                        <date-picker
                            color="purple"
                            v-model='form.birthday'
                            :max_date='new Date()'
                        ></date-picker>
                    </b-form-group>

                    <b-form-group id="input-group-country" label="Country:" label-for="input-country">
                        <b-form-select
                            id="input-country"
                            v-model="form.country_id"
                            v-on:change='getStates()'
                            required
                            class="col-sm-6">>
                            <option v-for="country in countries" v-bind:value="country.id">
                                {{ country.name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-state" label="State:" label-for="input-state">
                        <b-form-select
                            id="input-state"
                            v-model="form.state_id"
                            v-on:change='getCities()'
                            required
                            class="col-sm-6">>
                            <option v-for="state in states" v-bind:value="state.id">
                                {{ state.name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-city" label="City:" label-for="input-city">
                        <b-form-select
                            id="input-city"
                            v-model="form.city_id"
                            required
                            class="col-sm-6">>
                            <option v-for="city in cities" v-bind:value="city.id">
                                {{ city.name }}
                            </option>
                        </b-form-select>
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
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BCard} from 'bootstrap-vue'

    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import axios from "axios";

    export default {
        data() {
            return {
                form: {
                    first_name: '',
                    last_name: '',
                    birthday: '',
                    gender: '',
                    country_id: null,
                    state_id: null,
                    city_id: null,
                    user_id: null
                },
                state_id: null,
                city_id: null,
                gender:[],
                countries: [],
                states: [],
                cities:[],
                show: true
            }
        },
        created() {
            this.getCountries();
            this.getGender();
            this.getProfile();
        },
        methods: {
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

                        this.form.first_name = items.first_name;
                        this.form.last_name = items.last_name;
                        this.form.birthday = items.birthday;
                        this.form.gender = items.gender;
                        this.form.country_id = items.country_id;
                        this.form.state_id = items.state_id;
                        this.form.city_id = items.city_id;
                        this.form.user_id = items.user_id;

                        this.city_id = items.city_id;
                        if(this.city_id !== null)
                            this.getState(items.city_id);
                    })
            },
            onSubmit(evt) {
                axios.put(this.$route.meta.api.profiles + '/' + this.$route.params.id, {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    birthday: this.form.birthday,
                    gender: this.form.gender,
                    city_id: this.form.city_id ,
                    user_id: this.form.user_id,
                    active: true
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
                this.form.first_name = '';
                this.form.last_name = '';
                this.form.birthday = '';
                this.form.gender = null;
                this.form.country_id = null;
                this.form.state_id = null;
                this.form.city_id = null;
                this.form.user_id = null;
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            }
        },
        components: {
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BCard,
            DatePicker
        }
    }
</script>
