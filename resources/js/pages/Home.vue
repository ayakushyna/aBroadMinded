<template>
<div>
    <div class="container home">
        <b-row class="align-items-center text-center text-md-left">
            <div class="col-md-6 col-lg-5 mb-5 mb-md-0 hero-banner">
                <h1>Travel More To Discover Yourself</h1>
                <p>Air seed winged lights saw kind whales in sixth dont seas dron image so fish all tree meat dont there is seed winged lights saw kind whales in sixth dont seas dron image so fish all tree meat dont there </p>
                <b-button pill size="lg" variant="primary" v-b-toggle.collapse-filters>Get Started</b-button>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-6 offset-xl-1">
                <img class="img-fluid" src="home_main.svg" alt="">
            </div>
        </b-row>
    </div>

    <div class="container">
        <b-row>
            <div>
                <b-collapse id="collapse-filters">
                    <b-card class="mb-3" header="Filters">
                        <Filters :fields="fields"></Filters>
                        <b-row class="justify-content-end">
                            <b-button class="mr-2" size="sm" @click="onFilter" variant="primary">Filter</b-button>
                            <b-button class="mr-2" size="sm" v-b-toggle.collapse-filters>Hide Filters</b-button>
                        </b-row>

                    </b-card>
                </b-collapse>
            </div>

        </b-row>
    </div>
</div>

    <!--================Search Package section End =================-->

</template>
<script>
    import {BButton, BCard, BCol, BCollapse, BRow, VBToggle} from 'bootstrap-vue'
    import Filters from "../components/Filters";

    export default {
        methods:{
            data() {
                return {
                    fields:[],
                    filters: [],
                }
            },
            onFilter(){
                console.log("filtering...")
                console.log(this.fields.length)
                this.filters=[]

                for(let i in this.fields){
                    if(this.fields[i].filter.checked)
                        this.filters.push({ key:this.fields[i].key, comparator:this.fields[i].comparator, value:this.fields[i].filter.value});
                }
                console.log(this.filters)
                this.fetchData(1);

            },
        },
        components: {
            BButton,
            BCollapse,
            BCard,
            BRow, BCol,
            Filters
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>
