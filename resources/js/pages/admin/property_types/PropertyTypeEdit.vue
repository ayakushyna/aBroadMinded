<template>
    <div class="container">
        <div>
            <b-button @click="$router.go(-1)" variant="outline-primary">Back</b-button>
        </div>

        <b-card class="mt-4">
            <div><h2>Edit property type</h2></div>
            <div>
                <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">

                    <b-form-group class="col-sm-6" id="input-group-name" label="Name:" label-for="input-name">
                        <b-form-input
                            id="input-name"
                            v-model="form.name"
                            type="text"
                            required
                            placeholder="Enter name"
                            ></b-form-input>

                        <div v-if="errors.name">
                            <ul class="alert alert-danger">
                                <li v-for="(value, key, index) in errors.name">{{ value }}</li>
                            </ul>
                        </div>
                    </b-form-group>

                    <b-button type="submit" variant="primary">Submit</b-button>
                    <b-button type="reset" variant="danger">Reset</b-button>
                </b-form>

            </div>
        </b-card>
    </div>
</template>

<script>
    import {BFormRating, BRow, BCol, BForm, BFormGroup, BFormSelect,BFormTextarea, BFormInput, BButton, BCard} from 'bootstrap-vue'
    import axios from "axios";

    export default {
        data() {
            return {
                form: {
                    name: ''
                },
                has_error: false,
                errors: {},
                show: true
            }
        },
        created() {
            this.getPropertyType();
        },
        methods: {
            async getPropertyType(){
                await axios.get(this.$route.meta.api.property_types + '/' + this.$route.params.id)
                    .then((response) => {
                        var items = response.data.items;
                        this.form.name = items.name;
                    });
            },
            onSubmit(evt) {
                this.has_error = false;
                this.errors = {}

                axios.put(this.$route.meta.api.property_types + '/' + this.$route.params.id, {
                    name: this.form.name,
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
                this.form.name= '';
                // Trick to reset/clear native browser form validation state
                this.has_error = false;
                this.errors = {}
                this.show = false
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
