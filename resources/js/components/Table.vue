<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>{{ name }} List</h3>
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

        </div>
        <div class="panel-body">
            <BTable striped hover responsive
                    bordered
                    no-local-sorting
                    :items="table.items"
                    :fields="table.primary_fields">

                <template v-slot:head()="scope">
                    <b-button block
                              class="text-nowrap"
                              variant="light"
                              :disabled="!scope.field.sortable"
                              @click="onSort(scope.field)">
                        {{ scope.label}}

                        <b-icon :icon="!scope.field.sorting.sorted? 'blank' : scope.field.sorting.direction? 'arrow-down':'arrow-up'"
                                aria-hidden="true"
                                variant="outline-light"
                                v-if="scope.field.sortable"></b-icon>
                    </b-button>
                </template>

                <template v-slot:cell(actions)="row" >
                    <b-button-group>
                        <b-button  v-if="hasShow" variant="outline-primary" :to="{name: pageShow, params: {id: row.item.id}}">
                            <b-icon icon="eye-fill" aria-label="Show"></b-icon>
                        </b-button>

                        <b-button  variant="outline-dark" :to="{name: pageEdit, params: {id: row.item.id}}">
                            <b-icon icon="pencil" aria-label="Edit"></b-icon>
                        </b-button>

                        <b-button  variant="outline-danger" @click="deleteItem(row.item.id)">
                            <b-icon icon="trash-fill" aria-label="Delete"></b-icon>
                        </b-button>
                    </b-button-group>
                </template>

                <template v-slot:cell(details)="row" >
                    <b-button size="sm" @click="row.toggleDetails">
                        <b-icon icon="caret-up-fill" v-if="row.detailsShowing"></b-icon>
                        <b-icon icon="caret-down-fill" v-if="!row.detailsShowing"></b-icon>
                    </b-button>
                </template>

                <template v-slot:row-details="row" v-if="table.secondary_fields.length">
                    <b-card>
                        <b-row >
                            <template v-for="i in [0,1,2]">
                                <b-col class="mb-2" >
                                    <b-row v-for="(field,index) in table.secondary_fields" v-bind:key="field.key">
                                        <template v-if="index < (table.secondary_fields.length/3) * (i+1)
                                                    && index >= (table.secondary_fields.length/3) * i">
                                            <b-col sm="4" class="text-sm-right"><b>{{ field.label }}:</b></b-col>
                                            <b-col sm="3">{{ row.item[field.key] }}</b-col>
                                        </template>
                                    </b-row>
                                </b-col>
                            </template>
                        </b-row>
                        <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
                    </b-card>
                </template>
            </BTable>
            <pagination :data="pagination" @pagination-change-page="fetchData"></pagination>
        </div>
    </div>
</template>

<script>
    import {
        VBToggle, BCollapse,
        BTable, BTd,
        BButton, BButtonGroup,
        BCard,
        BRow,
        BCol,
        BIcon,
        BIconPencil, BIconTrashFill,
        BIconCaretUpFill, BIconCaretDownFill,
        BIconArrowUp, BIconArrowDown, BIconBlank, BIconEyeFill,
    } from 'bootstrap-vue'

    import Filters from "./Filters";

    export default {
        props: {
            name: String,
            hasShow: {
                type: Boolean,
                default: false
            },
            pageShow: String,
            pageEdit: String,
            api: Object,
            actions: {
                type: Boolean,
                default: true
            },
        },
        data() {
            return {
                table:{
                    primary_fields: [],
                    secondary_fields:[],
                    items: [],
                },
                pagination: [],
                fields:[],
                filters: [],
                sortings: [],
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            truncateText(text) {
                if (text.length > 100) {
                    return `${text.substr(0, 100)}...`;
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
                try {
                    if (typeof page === 'undefined') {
                        page = 1;
                    }

                    this.axios.get(this.api.get + '?page=' + page, {
                        params: {
                            filters: JSON.stringify(this.filters),
                            sortings: JSON.stringify(this.sortings),
                        }
                    })
                        .then(response => {
                            this.pagination = response.data.pagination;

                            let items = response.data.items;
                            for(let i in items){
                                if(items[i].status === 'cancelled')
                                    items[i] = {... items[i],  _cellVariants: {status: 'danger'}}
                                else if(items[i].status === 'awaiting')
                                    items[i] = {... items[i],  _cellVariants: {status: 'warning'}}
                                else if(items[i].status === 'confirmed')
                                    items[i] = {... items[i],  _cellVariants: {status: 'success'}}
                                else if(items[i].active === false)
                                    items[i] = {... items[i],  _rowVariant: 'danger'}
                                else if(items[i].description)
                                    items[i].description = this.truncateText(items[i].description)
                                else if(items[i].body)
                                    items[i].body = this.truncateText(items[i].body)
                            }
                            this.table.items = items;

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
                            console.log(this.table.items)

                            this.setFilters(response.data.params.filters);
                            this.setSortings(response.data.params.sortings);

                            this.table.secondary_fields = this.fields.filter(field => field.secondary === true);

                            let details = this.table.secondary_fields.length ? ['details'] : [];
                            let actions = this.actions? ['actions'] : [];

                            this.table.primary_fields = this.fields.filter(field => field.secondary !== true).concat(actions, details);

                            console.log(this.$auth.user());
                        });
                } catch (err) {
                    debugger;
                }
            },

            async deleteItem(id) {
                this.axios
                    .delete(this.api.delete  + '/'+ id)
                    .then(response => {
                        let i = this.table.items.map(item => item.id).indexOf(id);
                        this.table.items.splice(i, 1)
                    });
            }
        },
        components: {
            Filters,
            BCollapse,
            BTable,BTd,
            BButton,BButtonGroup,
            BCard,
            BRow, BCol,
            BIcon, BIconPencil,BIconTrashFill,BIconCaretUpFill,BIconCaretDownFill, BIconBlank,
            BIconArrowUp,BIconArrowDown,
            BIconEyeFill,
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

<style scoped>

</style>
