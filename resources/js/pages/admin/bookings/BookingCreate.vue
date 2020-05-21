<template>
    <div class="container">
        <div class="form-group">
            <router-link :to="{name: 'BookingIndex'}" class="btn btn-outline-primary">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Create new booking</h2></div>
            <div class="panel-body">
        <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
            <b-row>
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

                    <b-form-group id="input-group-properties" label="Property:" label-for="input-properties">
                        <b-form-select
                            id="input-properties"
                            v-model="form.property_id"
                            required
                            class="col-sm-6">
                            <option v-for="property in properties" v-bind:value="property.id">
                                {{ property.title }}
                            </option>
                            ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-range" label="Date range:" label-for="input-range">
                        <date-picker
                            mode='range'
                            color="purple"
                            v-model='form.range'
                            is-inline
                            :columns="$screens({ lg: 2 }, 1)"
                            :min-date="new Date()"
                            :disabled-dates='{ weekdays: [1, 7] }'
                        >

                        </date-picker>
                    </b-form-group>

                </b-col>

                <b-col>

                    <b-form-group id="input-group-adults" label="Adults:" label-for="input-adults">
                        <b-form-input
                            id="input-adults"
                            v-model="form.adults"
                            type="number"
                            required
                            placeholder="Enter number of adults"
                            class="col-sm-4"
                            min="1"
                            max="50"
                            step="1">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-children" label="Max children:" label-for="input-children">
                        <b-form-input
                            id="input-children"
                            v-model="form.children"
                            type="number"
                            required
                            placeholder="Enter number of children"
                            class="col-sm-4"
                            min="1"
                            max="50"
                            step="1">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-price" label="Price per night:" label-for="input-price">
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
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput,BButton, BCard} from 'bootstrap-vue'

    import DatePicker from 'v-calendar/lib/components/date-picker.umd'

    import axios from "axios";
    export default {
        data() {
            return {
                form: {
                    range: {
                        start: '',
                        end: '',
                    },
                    adults: '',
                    children: '',
                    price: '',
                    profile_id: null,
                    property_id: null,
                },
                profiles: [],
                properties:[],
                statuses:[],
                show: true
            }
        },
        created() {
            this.getProfiles();
            this.getProperties();
        },
        methods: {
            async getProfiles() {
                await axios.get(this.$route.meta.api.profiles+ '/list')
                    .then((response) => {
                        this.profiles = response.data.items;
                    })
            },
            async getProperties() {
                await axios.get(this.$route.meta.api.properties+ '/list')
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
            onSubmit(evt) {
                axios.post(this.$route.meta.api.bookings, {
                    start_date: this.form.range['start'],
                    end_date: this.form.range['end'],
                    adults: this.form.adults,
                    children: this.form.children,
                    price: this.form.price,
                    status: 'awaiting',
                    profile_id: this.form.profile_id,
                    property_id: this.form.property_id,
                })
                    .then(response => (
                        this.$router.push({name: 'BookingIndex'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.range['start'] = '';
                this.form.range['end'] = '';
                this.form.adults = '';
                this.form.children = '';
                this.form.price = '';
                this.form.profile_id = null;
                this.form.property_id = null;
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            }
        },
        components: {
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput,BButton, BCard,
            DatePicker
        }
    }
</script>
