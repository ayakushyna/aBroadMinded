<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'ProfileIndex'}" class="btn btn-outline-info">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Edit user</h2></div>
            <div class="panel-body">
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                    <b-form-group id="input-group-nickname" label="Nickname:" label-for="input-nickname">
                        <b-form-input
                            id="input-nickname"
                            v-model="form.nickname"
                            type="text"
                            required
                            placeholder="Enter nickname"
                            class="col-sm-6">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-email" label="Email:" label-for="input-email">
                        <b-form-input
                            id="input-email"
                            v-model="form.email"
                            type="email"
                            required
                            placeholder="Enter email"
                            class="col-sm-6">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-password" label="Password:" label-for="input-password">
                        <b-form-input
                            id="input-password"
                            v-model="form.password"
                            type="password"
                            required
                            class="col-sm-6">
                            ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-password_confirmation" label="Password confirmation:" label-for="input-password_confirmation">
                        <b-form-input
                            id="input-password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            class="col-sm-6">
                            ></b-form-input>
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
    import {BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BCard} from 'bootstrap-vue'

    import DatePicker from 'v-calendar/lib/components/date-picker.umd'
    import axios from "axios";

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                    password_confirmation: '',
                    nickname: '',
                },
                show: true
            }
        },
        created() {
            this.getCountries();
            this.getGender();
            this.getUser();
        },
        methods: {
            async getUser() {
                await axios.put(this.$route.meta.api.users + '/'+ this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.email = items.email;
                        this.form.password = items.password;
                        this.form.nickname = items.nickname;
                    })
            },
            onSubmit(evt) {
                axios.post(this.$route.meta.api.users + '/' + this.$route.params.id, {
                    email: this.form.email,
                    password: this.form.password,
                    password_confirmation: this.form.password_confirmation,
                    nickname: this.form.nickname,
                })
                    .then(response => (
                        this.$router.push({name: 'ProfileIndex'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = '';
                this.form.password = '';
                this.form.password_confirmation = '';
                this.form.nickname = '';
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            }
        },
        components: {
            BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput ,BButton, BCard,
            DatePicker
        }
    }
</script>
