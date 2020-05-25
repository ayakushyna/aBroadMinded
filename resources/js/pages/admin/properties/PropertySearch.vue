<template>
    <div class="container">
        <b-button class="mb-3" v-b-toggle.collapse-filters> Filters </b-button>
        <b-collapse id="collapse-filters">
            <b-card class="mb-3" header="Filters">
                <Filters :fields="fields"></Filters>
                <b-row class="justify-content-end">
                    <b-button class="mr-2" size="sm" @click="onFilter" variant="primary">Filter</b-button>
                    <b-button class="mr-2" size="sm" v-b-toggle.collapse-filters>Hide Filters</b-button>
                </b-row>

            </b-card>
        </b-collapse>

        <b-row class="d-flex justify-content-center">
            <b-col class="col-md-4" v-for="(property) in items" :key=i>
                <div class="card mt-4">
                    <b-img v-if="property.images.length" class="card-img-top" :src="property.images[0].image_path" alt="Property Image"></b-img>
                    <div class="card-body">
                        <p class="card-text"><strong>{{ property.title }}</strong> <br>
                            {{ truncateText(property.description) }}
                        </p>
                    </div>
                    <b-button variant="warning" :to="{name: 'PropertyShow', params: {id: property.id}}">View Property</b-button>
                </div>
            </b-col>
        </b-row>
    </div>

</template>

<script>
    import {
        BCollapse,
        BButton,
        BCard,
        BRow, BCol, BImg, VBToggle
    } from "bootstrap-vue";
    import Filters from "../../../components/Filters";

    export default {
        data() {
            return {
                pagination: [],
                fields:[],
                filters: [],
                sortings: [],
                items: [],
                propertyDialogVisible: false,
                currentProperty: '',
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            truncateText(text) {
                if (text.length > 50) {
                    return `${text.substr(0, 50)}...`;
                }
                return text;
            },
            indexOfKey(array, key){
                for(let i in array) {
                    if(array[i].key === key)
                        return i;
                }
                return -1;
            },
            setFilters(filters) {
                this.filters = filters
                for(let i in filters) {
                    let j = this.indexOfKey(this.fields, filters[i].key)
                    this.fields[j].filter = {checked: true , value: filters[i].value}
                }
                console.log(this.filters)
            },
            setSortings(sortings) {
                this.sortings = sortings
                this.sortOrder = []
                for(let i in sortings) {
                    let j = this.indexOfKey(this.fields, sortings[i].key)
                    this.fields[j].sorting = {sorted: true , direction: (sortings[i].direction === 'DESC')}
                }
            },
            onSort(field){
                if(field.sortable){
                    if (field.sorting.sorted)
                    {
                        if(field.sorting.direction)
                        {
                            this.sortings[this.indexOfKey(this.sortings, field.key)].direction = 'ASC';
                            field.sorting.direction = false;
                        }
                        else {
                            let i = this.indexOfKey(this.sortings, field.key)
                            this.sortings.splice(i, 1);

                            field.sorting.sorted = false;
                            field.sorting.direction = true;
                        }
                    }
                    else {
                        this.sortings.push({ key:field.key, direction:'DESC', order: this.sortings.length});

                        field.sorting.direction = true;
                        field.sorting.sorted = true;
                    }

                    console.log(this.sortings)
                    this.fetchData(this.pagination.current_page);
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
            fetchData(page) {
                console.log(this.$route.meta.api.search + '?page='  )
                try {
                    if (typeof page === 'undefined') {
                        page = 1;
                    }

                    this.axios.get(this.$route.meta.api.search + '?page=' + page, {
                        params: {
                            filters: JSON.stringify(this.filters),
                            sortings: JSON.stringify(this.sortings),
                        }
                    })
                        .then(response => {
                            this.pagination = response.data.pagination;
                            this.items = response.data.items;

                            let fields = response.data.fields;
                            for(let i in fields){
                                if(Array.isArray(fields[i].comparator)){
                                    fields[i] = {...fields[i], filter: {checked:false , value:[fields[i].min, fields[i].max]}, sorting: {sorted: false, direction: true}}
                                }
                                else
                                    fields[i] = {...fields[i], filter: {checked:false , value:""}, sorting: {sorted: false, direction: true}}
                            }
                            this.fields = fields;

                            console.log(fields)

                            this.setFilters(response.data.params.filters);
                            this.setSortings(response.data.params.sortings);

                            console.log(this.$auth.user());
                        });
                } catch (err) {
                    debugger;
                }
            },
        },
        components: {
            Filters,
            BCollapse,
            BButton,
            BCard,
            BRow, BCol,BImg
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
