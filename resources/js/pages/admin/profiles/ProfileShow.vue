<template>
    <div class="container-fluid">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-two">
                        <header>
                            <h3>{{ first_name }} {{ last_name }}</h3>
                        </header>
                        <div class="">
                            <dl>
                                <dt>Location:</dt>
                                <dd>{{ city }}</dd>
                                <dt>Gender:</dt>
                                <dd>{{ gender }}</dd>
                                <dt>Birthday:</dt>
                                <dd>{{ birthday }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mt-4">
            <div>
                <b-card no-body>
                    <b-tabs pills card vertical>
                        <b-tab title="Properties" active>
                            <ProfileTable show="properties"></ProfileTable>
                        </b-tab>
                        <b-tab title="Bookings">
                            <ProfileTable show="bookings"></ProfileTable>
                        </b-tab>
                        <b-tab title="Feedbacks">
                            <ProfileTable show="feedbacks"></ProfileTable>
                        </b-tab>
                        <b-tab title="Settings">

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
        BRow, BCol,
    } from 'bootstrap-vue'




    import axios from 'axios'
    import ProfileTable from "./ProfileTable";

    export default {

        data() {
            return {
                name: "",
                first_name: "",
                last_name: "",
                gender: "",
                birthday: "",
                city: "",
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                try {
                    axios.get(this.$route.meta.api.profiles + '/' + this.$route.params.id)
                        .then(response => {
                            let items = response.data.items;

                            this.first_name = items.first_name;
                            this.last_name = items.last_name;
                            this.birthday = items.birthday;
                            this.gender = items.gender;
                            this.city = items.city;
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
            ProfileTable
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
