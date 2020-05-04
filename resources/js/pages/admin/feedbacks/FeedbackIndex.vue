<template>
    <div>
        <div class="form-group">
            <router-link :to="{path: $route.fullPath + '/create'}" :name="this.name" class="btn btn-success">Create new {{ name }}</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">List</div>
            <div class="panel-body">
                <BTable striped hover responsive :items="items" :fields="primary_fields">
                    <template v-slot:cell(actions)="row" >
                        <b-button-group>
                            <b-button  variant="outline-dark" :to="{name: 'FeedbackEdit', params: {id: row.item.id}}">
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

                    <template v-slot:row-details="row" v-if="secondary_fields.length">

                        <b-card>
                            <template v-for="field in secondary_fields">
                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>{{ field }}:</b></b-col>
                                    <b-col sm="3">{{ row.item[field] }}</b-col>
                                </b-row>
                            </template>
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
    import {BTable, BButton, BCard, BRow, BCol, BButtonGroup, BIcon, BIconPencil,BIconTrashFill,BIconCaretUpFill,BIconCaretDownFill} from 'bootstrap-vue'

    import axios from 'axios'

    export default {

        data() {
            return {
                name: "",
                pagination: [],
                items: [],
                primary_fields: [],
                secondary_fields: [],
            }
        },
        created() {
            this.fetchData();
        },
        methods: {
            async fetchData(page) {
                try {
                    if (typeof page === 'undefined') {
                        page = 1;
                    }

                    await axios.get(this.$route.meta.api + '?page=' + page)
                        .then(response => {
                            this.name = response.data.name;
                            console.log(this.name)
                            this.pagination = response.data.pagination;
                            this.items = response.data.items;
                            this.secondary_fields = response.data.fields.secondary_fields;

                            let add_fields = this.secondary_fields.length ? ['actions', 'details'] : ['actions'];
                            this.primary_fields = response.data.fields.primary_fields.concat(add_fields);
                        });
                } catch (err) {
                    debugger;
                }
            },

            async deleteItem(id) {
                this.axios
                    .delete(this.$route.meta.api + '/'+ id)
                    .then(response => {
                        let i = this.items.map(item => item.id).indexOf(id);
                        this.items.splice(i, 1)
                    });
            }
        },
        components: {
            BTable,BButton, BCard, BRow, BCol, BButtonGroup, BIcon, BIconPencil,BIconTrashFill,BIconCaretUpFill,BIconCaretDownFill
        }
    }
</script>

