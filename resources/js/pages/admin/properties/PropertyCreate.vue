<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'PropertyIndex'}" class="btn btn-outline-info">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Create new property</h2></div>
            <div class="panel-body">
        <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
            <b-row>
                <b-col>
                    <b-form-group id="input-group-title" label="Title:" label-for="input-title">
                        <b-form-input
                            id="input-title"
                            v-model="form.title"
                            type="text"
                            required
                            placeholder="Enter title"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-description" label="Description:" label-for="input-description">
                        <b-form-textarea
                            id="input-description"
                            v-model="form.description"
                            placeholder="Enter description..."
                            rows="4"
                            max-rows="3"
                        ></b-form-textarea>
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

                    <b-form-group id="input-group-address" label="Address:" label-for="input-address">
                        <b-form-input
                            id="input-address"
                            v-model="form.address"
                            type="text"
                            required
                            placeholder="Enter address">
                        </b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-price" label="Price:" label-for="input-price">
                        <b-form-input
                            id="input-price"
                            v-model="form.price"
                            type="number"
                            required
                            placeholder="Enter price"
                            class="col-sm-4">
                            ></b-form-input>
                    </b-form-group>
                </b-col>

                <b-col>
                    <b-form-group id="input-group-profile" label="Profile:" label-for="input-profile" class="justify-content-md-left">
                        <b-form-select
                            id="input-profile"
                            v-model="form.profile_id"
                            required
                            class="col-sm-6">
                            <option v-for="profile in profiles" v-bind:value="profile.id">
                                {{ profile.first_name }} {{ profile.last_name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-property_type" label="Property Type:" label-for="input-property_type">
                        <b-form-select
                            id="input-property_type"
                            v-model="form.property_type_id"
                            required
                            class="col-sm-6">
                            <option v-for="type in property_types" v-bind:value="type.id">
                                {{ type.name }}
                            </option>
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-host_type" label="Host Type:" label-for="input-host_type">
                        <b-form-select
                            id="input-host_type"
                            v-model="form.host_type"
                            :options="host_types"
                            required
                            class="col-sm-6">
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-max_guests" label="Max guests:" label-for="input-max_guests">
                        <b-form-input
                            id="input-max_guests"
                            v-model="form.max_guests"
                            type="number"
                            required
                            placeholder="Enter max number of guests"
                            class="col-sm-4"
                            min="1"
                            max="50"
                            step="1">
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-max_bedrooms" label="Max bedrooms:" label-for="input-max_bedrooms">
                        <b-form-input
                            id="input-max_bedrooms"
                            v-model="form.max_bedrooms"
                            type="number"
                            required
                            placeholder="Enter max number of bedrooms"
                            class="col-sm-4"
                            min="1"
                            max="50"
                            step="1">
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-max_beds" label="Max beds:" label-for="input-max_beds">
                        <b-form-input
                            id="input-max_beds"
                            v-model="form.max_beds"
                            type="number"
                            required
                            placeholder="Enter max number of beds"
                            class="col-sm-4"
                            min="1"
                            max="50"
                            step="1">
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-permissions" label="Permissions:">
                        <b-form-checkbox-group v-model="form.permissions" id="permissions">
                            <b-form-checkbox value="children">Children</b-form-checkbox>
                            <b-form-checkbox value="parties">Parties</b-form-checkbox>
                            <b-form-checkbox value="pets">Pets</b-form-checkbox>
                            <b-form-checkbox value="smoking">Smoking</b-form-checkbox>
                        </b-form-checkbox-group>
                    </b-form-group>

                    <b-form-group id="input-group-utilities" label="Utilities:">
                        <b-form-checkbox-group v-model="form.utilities" id="utilities">
                            <b-form-checkbox value="air_condition">Air condition</b-form-checkbox>
                            <b-form-checkbox value="hair_dryer">Hair dryer</b-form-checkbox>
                            <b-form-checkbox value="tv">TV</b-form-checkbox>
                            <b-form-checkbox value="wifi">Wi-Fi</b-form-checkbox>
                        </b-form-checkbox-group>
                    </b-form-group>
                </b-col>
            </b-row>

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
    import {BRow, BCol, BForm, BFormGroup, BFormSelect,BFormTextarea, BFormInput, BButton, BFormCheckboxGroup, BFormCheckbox, BCard} from 'bootstrap-vue'
    import axios from "axios";
    export default {
        data() {
            return {
                form: {
                    profile_id: null,
                    title: '',
                    description: '',
                    country_id: '',
                    state_id: '',
                    city_id: null,
                    address: '',
                    property_type_id: null,
                    host_type: '',
                    price: '',
                    max_guests: '',
                    max_bedrooms: '',
                    max_beds: '',
                    permissions: [],
                    utilities: []
                },
                profiles: [],
                countries: [],
                states: [],
                cities:[],
                property_types:[],
                host_types:[],
                show: true
            }
        },
        created() {
            this.getProfiles();
            this.getCountries();
            this.getPropertyTypes();
            this.getHostTypes();
        },
        methods: {
            async getProfiles() {
                await axios.get(this.$route.meta.api.profiles)
                    .then((response) => {
                        this.profiles = response.data.items;
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
            async getPropertyTypes() {
                await axios.get(this.$route.meta.api.property_types)
                    .then((response) => {
                        this.property_types = response.data.items;
                    })
            },
            async getHostTypes() {
                await axios.get(this.$route.meta.api.host_types)
                    .then((response) => {
                        this.host_types = response.data.items;
                    })
            },
            onSubmit(evt) {
                axios.post(this.$route.meta.api.properties, {
                    profile_id: this.form.profile_id,
                    title: this.form.title,
                    description: this.form.description,
                    city_id: this.form.city_id,
                    address: this.form.address,
                    property_type_id: this.form.property_type_id,
                    host_type: this.form.host_type,
                    price: this.form.price,
                    max_guests: this.form.max_guests,
                    max_bedrooms: this.form.max_bedrooms,
                    max_beds: this.form.max_beds,
                    children: this.form.permissions.includes('children'),
                    parties: this.form.permissions.includes('parties'),
                    pets: this.form.permissions.includes('pets'),
                    smoking: this.form.permissions.includes('smoking'),
                    air_condition: this.form.utilities.includes('air_condition'),
                    hair_dryer: this.form.utilities.includes('hair_dryer'),
                    tv: this.form.utilities.includes('tv'),
                    wifi: this.form.utilities.includes('wifi'),
                    active: true
                })
                    .then(response => (
                        this.$router.push({name: 'PropertyIndex'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.profile_id= '';
                this.form.title= '';
                this.form.description= '';
                this.form.country_id= null;
                this.form.state_id= null;
                this.form.city_id= null;
                this.form.address= '';
                this.form.property_type_id= null;
                this.form.host_type= '';
                this.form.price= '';
                this.form.max_guests= '';
                this.form.max_bedrooms= '';
                this.form.max_beds= '';
                this.form.permissions= [];
                this.form.utilities= [];
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            }
        },
        components: {
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormTextarea, BFormInput, BButton, BFormCheckboxGroup, BFormCheckbox, BCard
        }
    }
</script>
