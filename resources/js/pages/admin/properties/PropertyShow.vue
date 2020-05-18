<template>
    <div class="container-fluid">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-two">
                        <header>
                            <h3>{{ title }}</h3>
                        </header>
                        <b-row>
                            <b-col>
                                <dl>
                                    <dt>Price per night:</dt>
                                    <dd>{{price}}</dd>
                                    <dt>Location:</dt>
                                    <dd>{{address}}, {{ city }}</dd>
                                    <dt>Owner:</dt>
                                    <dd>{{ profile }}</dd>
                                    <dt>Property Type:</dt>
                                    <dd>{{ property_type }}</dd>
                                    <dt>Host Type:</dt>
                                    <dd>{{ host_type }}</dd>
                                </dl>
                                <b-card header="Description">
                                    {{ description }}
                                </b-card>
                            </b-col>
                            <b-col>
                                <dl>
                                    <dt>Max Guests:</dt>
                                    <dd>{{max_guests}}</dd>
                                    <dt>Bedrooms:</dt>
                                    <dd>{{ max_bedrooms }}</dd>
                                    <dt>Beds:</dt>
                                    <dd>{{ max_beds }}</dd>
                                    <dt>Host Type:</dt>
                                    <dd>{{ host_type }}</dd>
                                </dl>
                                <b-form-group id="input-group-permissions" label="Permissions:">
                                    <b-form-checkbox-group v-model="permissions" id="permissions">
                                        <b-form-checkbox value="children" disabled>Children</b-form-checkbox>
                                        <b-form-checkbox value="parties" disabled>Parties</b-form-checkbox>
                                        <b-form-checkbox value="pets" disabled>Pets</b-form-checkbox>
                                        <b-form-checkbox value="smoking" disabled>Smoking</b-form-checkbox>
                                    </b-form-checkbox-group>
                                </b-form-group>

                                <b-form-group id="input-group-utilities" label="Utilities:">
                                    <b-form-checkbox-group v-model="utilities" id="utilities">
                                        <b-form-checkbox value="air_condition" disabled>Air condition</b-form-checkbox>
                                        <b-form-checkbox value="hair_dryer" disabled>Hair dryer</b-form-checkbox>
                                        <b-form-checkbox value="tv" disabled>TV</b-form-checkbox>
                                        <b-form-checkbox value="wifi" disabled>Wi-Fi</b-form-checkbox>
                                    </b-form-checkbox-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12 mt-4">
            <div>
                <b-card no-body>
                    <b-tabs pills card vertical>
                        <b-tab title="Bookings">
                            <PropertyTable show="bookings"></PropertyTable>
                        </b-tab>
                        <b-tab title="Feedbacks">
                            <PropertyTable show="feedbacks"></PropertyTable>
                        </b-tab>
                        <b-tab title="Calendars" active>
                            <PropertyTable show="calendars"></PropertyTable>
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
        BRow, BCol, BFormCheckboxGroup, BFormCheckbox, BFormGroup, BFormSelect,
    } from 'bootstrap-vue'




    import axios from 'axios'
    import PropertyTable from "./PropertyTable";

    export default {

        data() {
            return {
                profile: '',
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
                utilities: []
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                try {
                    axios.get(this.$route.meta.api.properties + '/' + this.$route.params.id)
                        .then(response => {
                            let items = response.data.items;

                            this.profile = items.fullname;
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
            PropertyTable,
            BFormCheckboxGroup, BFormCheckbox, BFormGroup,
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
