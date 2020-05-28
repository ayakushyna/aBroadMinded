<template>
    <div class="container">
        <div>
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <b-card class="mt-4">
            <div><h2>Create new calendar</h2></div>
            <div>
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                    <b-form-group class="col-sm-6" id="input-group-range" label="Date range:" label-for="input-range">
                        <el-date-picker
                            v-model="form.range"
                            type="daterange"
                            :default-time="['03:00:00', '03:00:00']"
                            :picker-options="datePickerOptions"
                            align="left"
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
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput,BFormDatepicker,BCalendar ,BButton, BCard} from 'bootstrap-vue'

    import axios from "axios";
    export default {
        data() {
            return {
                form: {
                    range: [],
                },
                dates: [],
                properties:[],
                datePickerOptions: {
                    disabledDate: this.disabledDate
                },
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getCalendars();
        },
        methods: {
            disabledDate (date) {
                return date <= new Date()
            },
            async getCalendars() {
                await axios.get(this.$route.meta.api.calendars)
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.calendars, {
                    start_date: this.form.range[0],
                    end_date: this.form.range[1],
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
                this.form.range = [];
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
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput, BFormDatepicker,BCalendar ,BButton, BCard,
        }
    }
</script>
