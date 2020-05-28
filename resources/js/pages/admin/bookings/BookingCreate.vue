<template>
    <div class="container">
        <div>
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <b-card class="mt-4">
            <div ><h2>Create new booking</h2></div>
            <div>
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
                    <b-row>
                        <b-col>

                            <b-form-group id="input-group-range" label="Date range:" label-for="input-range">
                                <el-date-picker
                                    v-model="form.range"
                                    type="daterange"
                                    align="left"
                                    inline
                                    :picker-options="datePickerOptions"
                                    :default-time="['03:00:00', '03:00:00']"
                                    start-placeholder="Start Date"
                                    end-placeholder="End Date">
                                </el-date-picker>

                                <div v-if="errors.start_date || errors.end_date">
                                    <ul class="alert alert-danger">
                                        <li v-for="(value, key, index) in errors.start_date">{{ value }}</li>
                                        <li v-for="(value, key, index) in errors.end_date">{{ value }}</li>
                                    </ul>
                                </div>
                            </b-form-group>

                        </b-col>

                        <b-col>

                            <b-form-group class="col-sm-4" id="input-group-adults" label="Adults:" label-for="input-adults">
                                <b-form-input
                                    id="input-adults"
                                    v-model="form.adults"
                                    type="number"
                                    required
                                    placeholder="Enter number of adults"
                                    min="1"
                                    max="20"
                                    step="1">
                                    ></b-form-input>

                                <div v-if="errors.adults">
                                    <ul class="alert alert-danger">
                                        <li v-for="(value, key, index) in errors.adults">{{ value }}</li>
                                    </ul>
                                </div>
                            </b-form-group>

                            <b-form-group class="col-sm-4" id="input-group-children" label="Children:" label-for="input-children">
                                <b-form-input
                                    id="input-children"
                                    v-model="form.children"
                                    type="number"
                                    required
                                    placeholder="Enter number of children"
                                    min="0"
                                    max="20"
                                    step="1">
                                    ></b-form-input>

                                <div v-if="errors.children">
                                    <ul class="alert alert-danger">
                                        <li v-for="(value, key, index) in errors.children">{{ value }}</li>
                                    </ul>
                                </div>
                            </b-form-group>

                            <b-form-group class="col-sm-4" id="input-group-price" label="Price per night:" label-for="input-price">
                                <b-form-input
                                    id="input-price"
                                    v-model="form.price"
                                    step="0.01"
                                    type="number"
                                    required
                                    min="1"
                                    max="999999"
                                    placeholder="Enter price"
                                ></b-form-input>

                                <div v-if="errors.price">
                                    <ul class="alert alert-danger">
                                        <li v-for="(value, key, index) in errors.price">{{ value }}</li>
                                    </ul>
                                </div>
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
        </b-card>
    </div>
</template>

<script>
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput,BButton, BCard} from 'bootstrap-vue'

    import axios from "axios";
    export default {
        data() {
            return {
                form: {
                    range: [],
                    adults: '',
                    children: '',
                    price: '',
                },
                statuses:[],
                available_dates:[],
                booked_dates:[],
                datePickerOptions: {
                    disabledDate: this.disabledDate
                },
                has_error: false,
                errors: {},
                show: true,
            }
        },
        created() {
            this.getAvailableDates();
            this.getBookedDates();
        },
        methods: {
            async getAvailableDates() {
                await axios.get(this.$route.meta.api.calendars + '/dates/' +  this.$route.params.id)
                    .then((response) => {
                        this.available_dates = response.data.items;
                        console.log(this.available_dates)
                    })
            },
            async getBookedDates() {
                await axios.get(this.$route.meta.api.bookings + '/dates/' +  this.$route.params.id)
                    .then((response) => {
                        this.booked_dates = response.data.items;
                        console.log(this.booked_dates)
                    })
            },
            disabledDate (date) {
                if(date <= new Date())
                    return true;

                for(const date_range of  this.booked_dates)
                    if(date >= new Date(date_range.start_date + 'T00:00:00') && date <= new Date(date_range.end_date + 'T23:59:59'))
                        return true;

                for(const date_range of  this.available_dates)
                    if(date >= new Date(date_range.start_date + 'T00:00:00') && date <= new Date(date_range.end_date + 'T23:59:59'))
                        return false;

                return true
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.bookings, {
                    start_date: this.form.range[0],
                    end_date: this.form.range[1],
                    adults: this.form.adults,
                    children: this.form.children,
                    price: this.form.price,
                    status: 'awaiting',
                    profile_id: this.$auth.user().id,
                    property_id: this.$route.params.id,
                })
                    .then(response => (
                        this.$router.go(-1)
                        // console.log(response.data)
                    ))
                    .catch(error => {
                        this.has_error = true;
                        this.errors = error.response.data.errors;
                    })
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.range=[]
                this.form.adults = '';
                this.form.children = '';
                this.form.price = '';
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
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput,BButton, BCard,
        }
    }
</script>
