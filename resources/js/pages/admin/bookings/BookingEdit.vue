<template>
    <div class="container">
        <div>
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <b-card class="mt-4">
            <div><h2>Edit booking</h2></div>

            <div>
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
                    <b-row>
                        <b-col>

                            <b-form-group id="input-group-range" label="Date range:" label-for="input-range" v-if="isAdmin">
                                <el-date-picker
                                    v-model="form.range"
                                    type="daterange"
                                    :picker-options="datePickerOptions"
                                    :default-time="['03:00:00', '03:00:00']"
                                    align="left"
                                    start-placeholder="Start Date"
                                    end-placeholder="End Date"
                                    format="yyyy/MM/dd"
                                    value-format="yyyy-MM-dd"
                                    :readonly="!isAwaiting && isClient  && !isAdmin">
                                </el-date-picker>

                                <div v-if="errors.start_date || errors.end_date">
                                    <ul class="alert alert-danger">
                                        <li v-for="(value, key, index) in errors.start_date">{{ value }}</li>
                                        <li v-for="(value, key, index) in errors.end_date">{{ value }}</li>
                                    </ul>
                                </div>
                            </b-form-group>

                            <b-form-group id="input-group-status" label="Status:" label-for="input-status">
                                <b-form-select
                                    id="input-status"
                                    v-model="form.status"
                                    :options="statuses"
                                    required
                                    :readonly="!isAwaiting && !isClient  && !isAdmin"
                                    class="col-sm-6">
                                    ></b-form-select>

                                <div v-if="errors.status">
                                    <ul class="alert alert-danger">
                                        <li v-for="(value, key, index) in errors.status">{{ value }}</li>
                                    </ul>
                                </div>
                            </b-form-group>

                        </b-col>

                        <b-col>

                            <b-form-group class="col-sm-4" id="input-group-adults" label="Adults:" label-for="input-adults" v-if="isAdmin">
                                <b-form-input
                                    id="input-adults"
                                    v-model="form.adults"
                                    type="number"
                                    required
                                    placeholder="Enter number of adults"
                                    :readonly="!isAwaiting && isClient  && !isAdmin"
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

                            <b-form-group class="col-sm-4" id="input-group-children" label="Children:" label-for="input-children" v-if="isAdmin">
                                <b-form-input
                                    id="input-children"
                                    v-model="form.children"
                                    type="number"
                                    required
                                    placeholder="Enter number of children"
                                    :readonly="!isAwaiting && isClient  && !isAdmin"
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

                            <b-form-group class="col-sm-4" id="input-group-price" label="Price per night:" label-for="input-price" v-if="isAdmin">
                                <b-form-input
                                    id="input-price"
                                    v-model="form.price"
                                    type="number"
                                    required
                                    :readonly="!isAwaiting && isClient && !isAdmin"
                                    step="0.01"
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

                    <div class="card-body alert alert-danger" v-if="errors.server">
                        <p> Cannot make a reservation on these days</p>
                    </div>

                    <div class="card-body alert alert-warning" v-if="errors.warning">
                        <p> You can only cancel this reservation</p>
                    </div>

                    <b-button type="submit" variant="primary">Submit</b-button>
                    <b-button type="reset" variant="danger">Reset</b-button>
                </b-form>
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
                    profile_id: null,
                    property_id: null,
                    status: ""
                },
                statuses:[],
                available_dates:[],
                booked_dates:[],
                datePickerOptions: {
                    disabledDate: this.disabledDate
                },
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getBooking();
            this.getStatuses();
        },
        computed:{
            isAdmin: function(){
                return this.$auth.user().role === 'admin' || this.$auth.user().role === 'root';
            },
            isClient: function(){
                return this.form.profile_id === this.$auth.user().id;
            },

            isAwaiting: function () {
                return this.form.status === 'awaiting';
            }

        },
        methods: {
            async getAvailableDates() {
                await axios.get(this.$route.meta.api.calendars + '/dates/' +  this.form.property_id)
                    .then((response) => {
                        console.log(this.form)
                        this.available_dates = response.data.items;
                        console.log(this.available_dates)
                    })
            },
            async getBookedDates() {
                await axios.get(this.$route.meta.api.bookings + '/dates/' +  this.form.property_id)
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
            async getStatuses() {
                await axios.get(this.$route.meta.api.bookings + '/statuses')
                    .then((response) => {
                        this.statuses = response.data.items;
                    })
            },
            getBooking() {
                 axios.get(this.$route.meta.api.bookings + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.range.push(items.start_date, items.end_date);
                        this.form.adults = items.adults;
                        this.form.children = items.children;
                        this.form.price = items.price;
                        this.form.profile_id = items.profile_id;
                        this.form.property_id = items.property_id;
                        this.form.status = items.status

                        this.getAvailableDates();
                        this.getBookedDates();
                    });
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}
                this.error = false

                if(this.isClient && !this.isAdmin &&  (this.form.status === 'confirmed' || this.form.status === 'awaiting') ){
                    this.errors = { ...this.errors, warning: true }
                }
                else{
                    axios.put(this.$route.meta.api.bookings + '/' + this.$route.params.id, {
                        start_date: this.form.range[0],
                        end_date: this.form.range[1],
                        adults: this.form.adults,
                        children: this.form.children,
                        price: this.form.price,
                        status: this.form.status,
                        profile_id: this.form.profile_id,
                        property_id: this.form.property_id,
                    })
                        .then(response => (
                            this.$router.go(-1)
                            // console.log(response.data)
                        ))
                        .catch(error => {
                            this.has_error = true;
                            this.errors = error.response.data.errors;
                            if(error.response.data.error){
                                this.errors = { ...this.errors, server: error.response.data.error }
                            }
                        })
                }


            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.range = []
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
