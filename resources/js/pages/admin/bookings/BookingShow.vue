<template>
    <div class="container">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-two">
                        <div :class="status==='confirmed'?' alert alert-success': status === 'awaiting'? ' alert alert-warning': 'alert alert-danger'">
                            {{ status }}
                        </div>
                        <b-row>
                            <b-col>
                                <dl>
                                    <dt>Property:</dt>
                                    <dd>
                                        <router-link class="nav-link p-0" :to="{name: 'PropertyShow', params: {id: property_id}}"> {{ property }} </router-link>
                                    </dd>
                                    <dt>Client:</dt>
                                    <dd>
                                        <router-link class="nav-link p-0"  :to="{name: 'ProfileShow', params: {id: profile_id}}"> {{ fullname }} </router-link>
                                    </dd>
                                    <dt>Date range:</dt>
                                    <dd>{{ range['start'] }} - {{range['end']}}</dd>
                                </dl>
                            </b-col>

                            <b-col>
                                <dl>
                                    <dt>Adults:</dt>
                                    <dd>{{ adults }}</dd>
                                    <dt>Children:</dt>
                                    <dd>{{ children }}</dd>
                                    <dt>Price:</dt>
                                    <dd>{{ price }}</dd>
                                </dl>
                            </b-col>
                        </b-row>

                        <b-row class="card card-body m-5" v-if="feedback">
                            <div class="d-flex flex-row-reverse">
                                <b-button variant="warning" v-if="isAdmin || isSelf" :to="{name: 'FeedbackEdit', params: {id: feedback.id}}"> Edit Feedback</b-button>
                            </div>
                            <b-col>
                                <dl>
                                    <dt>Title:</dt>
                                    <dd>
                                        {{ feedback.title }}
                                    </dd>
                                    <dt>Body:</dt>
                                    <dd>
                                        {{ feedback.body }}
                                    </dd>
                                    <dt>Score:</dt>
                                    <dd>
                                        <b-form-rating
                                            class="col-sm-3"
                                            v-model="feedback.score"
                                            color="#FDE12D"
                                            inline
                                            no-border
                                            size="lg"
                                            readonly
                                        ></b-form-rating>
                                    </dd>
                                </dl>
                            </b-col>
                        </b-row>



                        <b-row class="m-1" >
                            <b-button variant="warning" v-if="canLeaveFeedback" v-b-toggle.collapse-feedback >Leave Feedback</b-button>
                        </b-row>

                        <b-collapse id="collapse-feedback">
                            <b-card class="m-3">
                                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
                                    <b-form-group id="input-group-title" label="Title:" label-for="input-title">
                                        <b-form-input
                                            id="input-title"
                                            v-model="form.title"
                                            type="text"
                                            required
                                            placeholder="Enter title"
                                            class="col-sm-6">
                                            ></b-form-input>
                                    </b-form-group>

                                    <b-form-group id="input-group-body" label="Body:" label-for="input-body">
                                        <b-form-textarea
                                            id="input-body"
                                            v-model="form.body"
                                            placeholder="Enter body..."
                                            rows="4"
                                            max-rows="3"
                                            class="col-sm-6"
                                        ></b-form-textarea>
                                    </b-form-group>

                                    <b-form-group id="input-group-score" label="Score:" label-for="input-score" class="col-sm-3">
                                        <b-form-rating
                                            id="input-score"
                                            v-model="form.score"
                                            color="yellow"
                                            inline
                                            no-border
                                            size="lg"
                                        ></b-form-rating>
                                    </b-form-group>

                                    <b-button type="submit" variant="primary">Submit</b-button>
                                    <b-button type="reset" variant="danger">Reset</b-button>
                                </b-form>
                            </b-card>
                        </b-collapse>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import {
        VBToggle,
        BCollapse,
        BTabs, BTab,
        BButton,
        BCard,
        BRow, BCol, BFormCheckboxGroup, BFormCheckbox, BFormGroup, BFormSelect,
        BFormRating,BForm, BFormTextarea, BFormInput
    } from 'bootstrap-vue'

    import axios from 'axios'
    import Table from "../../../components/Table";

    export default {

        data() {
            return {
                form: {
                    title: '',
                    body: '',
                    score: 5,
                },
                range: {
                    start: '',
                    end: '',
                },
                adults: '',
                children: '',
                price: '',
                profile_id: '',
                fullname: '',
                property_id: '',
                property: '',
                status: '',
                feedback: null,
                statuses:[],
                show: true
            }
        },
        created() {
            this.fetchData();
        },
        computed: {
            isAdmin: function() {
                return this.$auth.user().role === 'admin' || this.$auth.user().role === 'root';
            },
            isSelf: function() {
                return this.$auth.user().id === this.profile_id;
            },
            canLeaveFeedback: function(){
                return this.$auth.user().id === this.profile_id &&
                    !this.feedback &&
                    new Date(this.range['end']) < new Date() &&
                    this.status === 'confirmed';
            }
        },
        methods: {
            onSubmit(evt) {
                axios.post(this.$route.meta.api.feedbacks, {
                    booking_id: this.$route.params.id,
                    title: this.form.title,
                    body: this.form.body,
                    score: this.form.score
                })
                    .then(response => (
                        this.$router.go(-1)
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.title= '';
                this.form.body= '';
                this.form.score= '';
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            fetchData() {
                try {
                    axios.get(this.$route.meta.api.bookings + '/' + this.$route.params.id)
                        .then(response => {
                            let items = response.data.items;

                            this.range['start'] = items.start_date;
                            this.range['end'] = items.end_date;
                            this.adults = items.adults;
                            this.children = items.children;
                            this.price = items.price;
                            this.profile_id = items.profile_id;
                            this.fullname = items.fullname;
                            this.property_id = items.property_id;
                            this.property = items.property;
                            this.status = items.status;
                            this.feedback = items.feedback;
                        });
                } catch (err) {
                    debugger;
                }
            }
        },
        components: {
            BCollapse,
            BTabs, BTab,
            BButton,
            BCard,
            BRow, BCol,
            Table,
            BFormCheckboxGroup, BFormCheckbox, BFormGroup,
            BFormRating,BForm, BFormSelect, BFormTextarea, BFormInput
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
