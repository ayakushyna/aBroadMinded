<template>
    <div class="container-fluid">
        <div class="form-group">
            <router-link :to="{path: $route.fullPath + '/create'}" :name="this.name" class="btn btn-primary">Add new {{ name }}</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>{{ capitalLetter(name) }} List</h3>
                <b-button class="mb-3" v-b-toggle.collapse-filters> Filters </b-button>
                <b-collapse id="collapse-filters">
                    <b-card class="mb-3" header="Filters">
                        <b-row>
                            <template v-for="i in [0,1,2]">
                                <b-col >
                                    <template v-for="(field,index) in fields"
                                              v-if="index < (fields.length/3) * (i+1)
                                                && index >= (fields.length/3) * i">
                                        <b-input-group size="sm" class="mb-2" :key="index">
                                            <b-col md="4" class="p-0">
                                                <b-input-group-prepend>
                                                    <b-button
                                                        size="sm"
                                                        :key="index"
                                                        :pressed.sync="field.filter.checked"
                                                        variant="outline-dark-blue"
                                                        block>
                                                        {{ field.label }}
                                                    </b-button>
                                                </b-input-group-prepend>
                                            </b-col>

                                            <b-col md="6" class="p-0">
                                                <b-form-input v-if="field.comparator !== '='"
                                                              v-model="field.filter.value"
                                                              :type="field.comparator === 'like'? 'search': 'number'"
                                                              :placeholder="'Enter ' + field.label + ' filter'"
                                                              :disabled="!field.filter.checked"
                                                              :min="field.comparator !== '='? field.min: ''"
                                                              size="sm"
                                                ></b-form-input>


                                                <b-input-group-append is-text v-else >
                                                    <b-form-checkbox v-model="field.filter.value"
                                                                     :disabled="!field.filter.checked"
                                                                     class="mr-n2 mb-n1 mt-n1"
                                                                     size="sm">
                                                    </b-form-checkbox>
                                                </b-input-group-append>
                                            </b-col>

                                        </b-input-group>
                                    </template>
                                </b-col>
                            </template>
                        </b-row>
                        <b-row class="justify-content-end">
                            <b-button class="mr-2" size="sm" @click="onFilter" variant="primary">Filter</b-button>
                            <b-button class="mr-2" size="sm" v-b-toggle.collapse-filters>Hide Filters</b-button>
                        </b-row>

                    </b-card>
                </b-collapse>

            </div>
            <div class="panel-body">
                <BTable striped hover responsive
                        border fixed
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
                            <b-button  variant="outline-dark" :to="{name: 'PropertyEdit', params: {id: row.item.id}}">
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
                                                    <b-col sm="3" class="text-sm-right"><b>{{ field.label }}:</b></b-col>
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
    </div>
</template>
<script>
    import {
        VBToggle,BCollapse,
        BTable,
        BButton,
        BCard,
        BRow,
        BCol,
        BButtonGroup,
        BIcon,
        BIconPencil, BIconTrashFill,
        BIconCaretUpFill, BIconCaretDownFill,
        BIconArrowUp,BIconArrowDown,BIconBlank,
        BForm, BFormGroup, BFormCheckboxGroup, BFormCheckbox, BFormInput,
        BInputGroup, BInputGroupPrepend, BInputGroupAppend, BFormSelect,
    } from 'bootstrap-vue'


    import axios from 'axios'

    export default {

        data() {
            return {
                name: "",
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
            capitalLetter(str)
            {
                str = str.split(" ");

                for (let i = 0, x = str.length; i < x; i++) {
                    str[i] = str[i][0].toUpperCase() + str[i].substr(1);
                }

                return str.join(" ");
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

                    axios.get(this.$route.meta.api + '?page=' + page, {
                            params: {
                                filters: JSON.stringify(this.filters),
                                sortings: JSON.stringify(this.sortings),
                            }
                        })
                        .then(response => {
                            this.name = response.data.name;
                            console.log(this.name)
                            this.pagination = response.data.pagination;
                            this.table.items = response.data.items;

                            let fields = response.data.fields;
                            for(let i in fields){
                                fields[i] = {...fields[i], filter: {checked:false , value:""}, sorting: {sorted: false, direction: true}}
                            }
                            this.fields = fields;

                            console.log(fields)
                            console.log(this.table.items)

                            this.setFilters(response.data.params.filters);
                            this.setSortings(response.data.params.sortings);

                            this.table.secondary_fields = this.fields.filter(field => field.secondary === true);

                            let add_fields = this.table.secondary_fields.length ? ['actions', 'details'] : ['actions'];
                            this.table.primary_fields = this.fields.filter(field => field.secondary !== true).concat(add_fields);

                        });
                } catch (err) {
                    debugger;
                }
            },

            async deleteItem(id) {
                this.axios
                    .delete(this.$route.meta.api + '/'+ id)
                    .then(response => {
                        let i = this.table.items.map(item => item.id).indexOf(id);
                        this.table.items.splice(i, 1)
                    });
            }
        },
        components: {
            BCollapse,
            BTable,
            BButton,
            BForm, BFormGroup,
            BFormSelect,
            BFormCheckboxGroup, BFormCheckbox,
            BFormInput, BInputGroup, BInputGroupPrepend, BInputGroupAppend,
            BCard,
            BRow, BCol,
            BButtonGroup,
            BIcon, BIconPencil,BIconTrashFill,BIconCaretUpFill,BIconCaretDownFill, BIconBlank,
            BIconArrowUp,BIconArrowDown
        },
        directives: {
            BToggle: VBToggle
        }
    }
</script>

