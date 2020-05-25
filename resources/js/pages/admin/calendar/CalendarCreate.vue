<template>
    <div class="container">
        <div class="form-group">
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Create new calendar</h2></div>
            <div class="panel-body">
        <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

            <b-form-group class="col-sm-6" id="input-group-properties" label="Property:" label-for="input-properties">
                <b-form-select
                    id="input-properties"
                    v-model="form.property_id"
                    required>
                    <option v-for="property in properties" v-bind:value="property.id">
                        {{ property.title }}
                    </option>
                    </b-form-select>

                <div v-if="errors.property_id">
                    <ul class="alert alert-danger">
                        <li v-for="(value, key, index) in errors.property_id">{{ value }}</li>
                    </ul>
                </div>
            </b-form-group>

            <b-form-group class="col-sm-6" id="input-group-range" label="Date range:" label-for="input-range">
                <el-date-picker
                    v-model="form.range"
                    type="daterange"
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
        </div>
    </div>
</template>

<script>
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput,BFormDatepicker,BCalendar ,BButton, BCard} from 'bootstrap-vue'
    //import Calendar from 'v-calendar/lib/components/calendar.umd'
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
                    property_id: null,
                },
                dates: [],
                properties:[],
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getCalendars();
            this.getProperties();
        },
        methods: {
            async getCalendars() {
                await axios.get(this.$route.meta.api.calendars)
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
            async getProperties() {
                await axios.get(this.$route.meta.api.properties + '/list')
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.post(this.$route.meta.api.calendars, {
                    start_date: this.form.range['start'],
                    end_date: this.form.range['end'],
                    property_id: this.form.property_id,
                })
                    .then(response => (
                        this.$router.push({name: 'PropertyIndex'})
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
                this.form.range['start'] = '';
                this.form.range['end']= '';
                this.form.property_id = null;
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
            DatePicker
        }
    }
</script>
