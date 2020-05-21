 <template>
    <div class="container">
        <div class="form-group">
            <router-link :to="{name: 'FeedbackIndex'}" class="btn btn-outline-primary">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><h2>Create new feedback</h2></div>
            <div class="panel-body">
        <b-form @submit.prevent="onSubmit" @reset="onReset" v-if="show">
                    <b-form-group id="input-group-profile" label="Profile:" label-for="input-profile" class="justify-content-md-left">
                        <b-form-select
                            id="input-profile"
                            v-model="form.profile_id"
                            required
                            class="col-sm-6">
                            <option v-for="profile in profiles" v-bind:value="profile.id">
                                {{ profile.first_name }} {{ profile.last_name }}
                            </option>
                        </b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-property" label="Property:" label-for="input-property" class="justify-content-md-left">
                        <b-form-select
                            id="input-property"
                            v-model="form.property_id"
                            required
                            class="col-sm-6">
                            <option v-for="property in properties" v-bind:value="property.id">
                                {{ property.title }}
                            </option>
                        </b-form-select>
                    </b-form-group>

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
                            color="orange"
                            inline
                            no-border
                            size="lg"
                        ></b-form-rating>
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
                    profile_id: null,
                    property_id: null,
                    title: '',
                    body: '',
                    score: ''
                },
                profiles: [],
                properties:[],
                show: true
            }
        },
        created() {
            this.getProfiles();
            this.getProperties();
        },
        methods: {
            async getProfiles() {
                await axios.get(this.$route.meta.api.profiles)
                    .then((response) => {
                        this.profiles = response.data.items;
                    })
            },
            async getProperties() {
                await axios.get(this.$route.meta.api.properties)
                    .then((response) => {
                        this.properties = response.data.items;
                    })
            },
             onSubmit(evt) {
                 axios.post(this.$route.meta.api.feedbacks, {
                    profile_id: this.form.profile_id,
                    property_id: this.form.property_id,
                    title: this.form.title,
                    body: this.form.body,
                    score: this.form.score
                })
                    .then(response => (
                        this.$router.push({name: 'FeedbackIndex'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.profile_id= null;
                this.form.property_id= null;
                this.form.title= '';
                this.form.body= '';
                this.form.score= '';
                // Trick to reset/clear native browser form validation state
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
