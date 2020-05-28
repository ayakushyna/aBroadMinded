<template>
    <div class="container-fluid">
        <!-- Column -->
        <div class="col-lg-12">
            <b-card >
                <div class="d-flex flex-row-reverse">
                    <b-button variant="warning" v-if="isAdmin || isSelf" :to="{name: 'PropertyEdit', params: {id: id}}"> Edit Property</b-button>
                </div>
                <div class="card-body container">
                    <div class="card-two">
                        <header>
                            <h3>{{ title }}</h3>
                        </header>
                        <b-row>
                            <b-col>
                                <b-img v-if="images.length" class="card-img-top" :src="'/storage/' + images[0].image_path" alt="Property Image"></b-img>
                            </b-col>
                            <b-col>
                                <dl>
                                    <dt>Price per night:</dt>
                                    <dd>{{price + '$'}}</dd>
                                    <dt>Location:</dt>
                                    <dd>{{address}}, {{ city }}</dd>
                                    <dt>Owner:</dt>
                                    <dd>
                                        <router-link class="nav-link"  :to="{name: 'ProfileShow', params: {id: profile_id}}"> {{ fullname }} </router-link>
                                    </dd>
                                    <dt>Property Type:</dt>
                                    <dd>{{ property_type }}</dd>
                                    <dt>Host Type:</dt>
                                    <dd>{{ host_type }}</dd>
                                </dl>
                            </b-col>
                            <b-col>
                                <dl>
                                    <dt>Max Guests:</dt>
                                    <dd>{{max_guests}}</dd>
                                    <dt>Bedrooms:</dt>
                                    <dd>{{ max_bedrooms }}</dd>
                                    <dt>Beds:</dt>
                                    <dd>{{ max_beds }}</dd>
                                </dl>
                            </b-col>
                        </b-row>

                        <b-row class="container mt-4">
                            <div class="card card-body">
                                {{ description }}
                            </div>
                        </b-row>

                        <b-row class="mt-4">
                            <b-form-group id="input-group-permissions" label="Permissions:">
                                <b-form-checkbox-group  v-model="permissions" id="permissions">
                                        <b-form-checkbox value="children" disabled>Children</b-form-checkbox>
                                        <b-form-checkbox value="parties" disabled>Parties</b-form-checkbox>
                                       <b-form-checkbox value="pets" disabled>Pets</b-form-checkbox>
                                       <b-form-checkbox value="smoking" disabled>Smoking</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </b-row>

                        <b-row>
                            <b-form-group id="input-group-utilities" label="Utilities:">
                                <b-form-checkbox-group  v-model="utilities" id="utilities">
                                        <b-form-checkbox value="air_condition" disabled>Air condition</b-form-checkbox>
                                        <b-form-checkbox value="hair_dryer" disabled>Hair dryer</b-form-checkbox>
                                       <b-form-checkbox value="tv" disabled>TV</b-form-checkbox>
                                       <b-form-checkbox value="wifi" disabled>Wi-Fi</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </b-row>

                        <b-row  v-if="!isSelf">
                            <b-button variant="primary" class="mr-3" :to="$auth.user()? {name: 'BookingCreate', props: {booking_id: id, profile_id: $auth.user().id}} : {name: 'Login'}" >Book</b-button>
                        </b-row>
                    </div>
                </div>
            </b-card>
        </div>

        <div class="col-lg-12 mt-4">
            <div>
                <b-card no-body>
                    <b-tabs pills card vertical
                            active-nav-item-class="primary">
                        <b-tab title="Feedbacks" active>
                            <Table name="Feedback"
                                   pageEdit="FeedbackEdit"
                                   :actions="isAdmin || isSelf"
                                   :api="{ get: this.$route.meta.api.properties + '/'+ this.$route.params.id + '/feedbacks' ,
                                           delete: this.$route.meta.api.feedbacks }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Bookings" v-if="isAdmin || isSelf">
                            <Table name="Booking"
                                   :hasShow=true
                                   pageShow="BookingShow"
                                   pageEdit="BookingEdit"
                                   :actions="isAdmin || isSelf"
                                   :api="{ get: this.$route.meta.api.properties + '/'+ this.$route.params.id + '/bookings' ,
                                           delete: this.$route.meta.api.bookings }"
                            ></Table>
                        </b-tab>
                        <b-tab title="Calendars" v-if="isAdmin || isSelf">
                            <div class="d-flex flex-row-reverse" v-if="isSelf">
                                <b-button v-if="isSelf" :to="{name: 'CalendarCreate'}" variant="primary">Add available dates</b-button>
                            </div>

                            <Table name="Calendar"
                                   pageEdit="CalendarEdit"
                                   :actions="isAdmin || isSelf"
                                   :api="{ get: this.$route.meta.api.properties + '/'+ this.$route.params.id + '/calendars' ,
                                           delete: this.$route.meta.api.calendars }"
                            ></Table>
                        </b-tab>
                    </b-tabs>
                </b-card>
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
        BRow, BCol, BFormCheckboxGroup, BFormCheckbox, BFormGroup, BImg,
    } from 'bootstrap-vue'

    import axios from 'axios'
    import Table from "../../../components/Table";

    export default {

        data() {
            return {
                id: '',
                profile_id: '',
                fullname: '',
                title: '',
                description: '',
                city: '',
                address: '',
                property_type: '',
                host_type: '',
                price: '',
                max_guests: '',
                max_bedrooms: '',
                max_beds: '',
                permissions: [],
                utilities: [],
                images: []
            }
        },
        created() {
            this.fetchData();
        },
        computed: {
            isAdmin: function() {
                return this.$auth.user() && (this.$auth.user().role === 'admin' || this.$auth.user().role === 'root');
            },
            isSelf: function() {
                return this.$auth.user() &&  (this.$auth.user().id === this.profile_id);
            },
        },
        methods: {
            fetchData() {
                try {
                    axios.get(this.$route.meta.api.properties + '/' + this.$route.params.id)
                        .then(response => {
                            let items = response.data.items;

                            this.id = items.id;
                            this.profile_id = items.profile_id;
                            this.fullname = items.fullname;
                            this.title= items.title;
                            this.description= items.description;
                            this.address= items.address;
                            this.property_type= items.name;
                            this.host_type= items.host_type;
                            this.price= items.price;
                            this.max_guests= items.max_guests;
                            this.max_bedrooms= items.max_bedrooms;
                            this.max_beds= items.max_beds;
                            this.permissions= [
                                items.children? 'children': '',
                                items.parties? 'parties': '',
                                items.pets? 'pets': '',
                                items.smoking? 'smoking': '',
                            ];
                            this.utilities= [
                                items.air_condition? 'air_condition': '',
                                items.hair_dryer? 'hair_dryer': '',
                                items.tv? 'tv': '',
                                items.wifi? 'wifi': '',
                            ];
                            this.images = items.images? items.images: []
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
            Table,BImg,
            BFormCheckboxGroup, BFormCheckbox, BFormGroup,
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
