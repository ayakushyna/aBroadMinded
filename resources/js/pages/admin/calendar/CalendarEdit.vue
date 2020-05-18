<template>
    <div class="container">
        <div class="form-group">
            <router-link :to="{name: 'PropertyIndex'}" class="btn btn-outline-primary">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Edit calendar</h2></div>
            <div class="panel-body">
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

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
                            :min-date="new Date()"
                            is-inline
                        >

                        </date-picker>
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
                show: true
            }
        },
        created() {
            this.getCalendars();
            this.getProperties();
            this.getCalendar();
        },
        methods: {
            async getCalendars() {
                await axios.get(this.$route.meta.api.calendars)
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
            async getProperties() {
                await axios.get(this.$route.meta.api.properties)
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
            async getCalendar(){
                await axios.get(this.$route.meta.api.calendars + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.range['start'] = items.start_date;
                        this.form.range['end']= items.end_date;
                        this.form.property_id = items.property_id;
                    });
            },
            onSubmit(evt) {
                axios.put(this.$route.meta.api.calendars + '/' + this.$route.params.id, {
                    start_date: this.form.range['start'],
                    end_date: this.form.range['end'],
                    property_id: this.form.property_id,
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
                this.form.range['start'] = '';
                this.form.range['end']= '';
                this.form.property_id = null;
                // Trick to reset/clear native browser form validation state
                this.show = false
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
