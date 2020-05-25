<template>
    <div class="container">
        <div class="form-group">
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Edit feedback</h2></div>
            <div class="panel-body">
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                    <b-form-group class="col-sm-6" id="input-group-title" label="Title:" label-for="input-title">
                        <b-form-input
                            id="input-title"
                            v-model="form.title"
                            type="text"
                            required
                            placeholder="Enter title"
                            ></b-form-input>

                        <div v-if="errors.title">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in errors.title">{{ value }}</li>
                            </ul>
                        </div>
                    </b-form-group>

                    <b-form-group class="col-sm-6" id="input-group-body" label="Body:" label-for="input-body">
                        <b-form-textarea
                            id="input-body"
                            v-model="form.body"
                            placeholder="Enter body..."
                            rows="4"
                            max-rows="3"
                        ></b-form-textarea>

                        <div v-if="errors.body">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in errors.body">{{ value }}</li>
                            </ul>
                        </div>
                    </b-form-group>

                    <b-form-group class="col-sm-3" id="input-group-score" label="Score:" label-for="input-score" >
                        <b-form-rating
                            id="input-score"
                            v-model="form.score"
                            color="yellow"
                            inline
                            no-border
                            size="lg"
                        ></b-form-rating>

                        <div v-if="errors.score">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in errors.score">{{ value }}</li>
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
    import {BFormRating, BRow, BCol, BForm, BFormGroup, BFormSelect,BFormTextarea, BFormInput, BButton, BCard} from 'bootstrap-vue'
    import axios from "axios";

    export default {
        data() {
            return {
                form: {
                    booking_id: null,
                    title: '',
                    body: '',
                    score: '',
                },
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getFeedback();
        },
        methods: {
            async getFeedback(){
                await axios.get(this.$route.meta.api.feedbacks + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.booking_id = items.booking_id;
                        this.form.title = items.title;
                        this.form.body = items.body;
                        this.form.score = items.score;
                    });
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.put(this.$route.meta.api.feedbacks + '/' + this.$route.params.id, {
                    booking_id: this.form.booking_id,
                    title: this.form.title,
                    body: this.form.body,
                    score: this.form.score
                })
                    .then(response => (
                        this.$router.push({name: 'FeedbackIndex'})
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
                this.form.title= '';
                this.form.body= '';
                this.form.score= '';
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
            BFormRating, BRow, BCol ,BForm, BFormGroup, BFormSelect, BFormTextarea, BFormInput, BButton, BCard
        }
    }
</script>

<style scoped lang="scss">


</style>
