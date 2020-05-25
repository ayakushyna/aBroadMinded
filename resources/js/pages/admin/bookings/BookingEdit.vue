<template>
    <div class="container">
        <div class="form-group">
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Edit booking</h2></div>
            <div class="panel-body">
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
                    <b-row>
                        <b-col>

                            <b-form-group id="input-group-range" label="Date range:" label-for="input-range">
                                <el-date-picker
                                    v-model="form.range"
                                    type="daterange"
                                    align="right"
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
                                    type="number"
                                    required
                                    min="1"
                                    max="1000000"
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
                statuses:[],
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getBooking();
        },
        methods: {
            async getBooking() {
                await axios.get(this.$route.meta.api.bookings + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.range['start'] = items.start_date;
                        this.form.range['end'] = items.end_date;
                        this.form.adults = items.adults;
                        this.form.children = items.children;
                        this.form.price = items.price;
                        this.form.profile_id = items.profile_id;
                        this.form.property_id = items.property_id;
                    });
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.put(this.$route.meta.api.bookings + '/' + this.$route.params.id, {
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
            DatePicker
        }
    }
</script>
