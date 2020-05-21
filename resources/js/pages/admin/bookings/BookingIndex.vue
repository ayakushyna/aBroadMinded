<template>
    <div class="container-fluid">
        <div class="form-group"  v-if="($auth.user().role === 'root')">
            <router-link :to="{path: $route.fullPath + '/create'}" :name="this.name" class="btn btn-primary">Add new booking</router-link>
        </div>

        <Table :pageEdit="pageEdit"
               :api="api"
        ></Table>
    </div>
</template>
<script>
    import Table from "../../../components/Table";
    export default {
        data(){
            return {
                pageEdit: 'BookingEdit',
                api: {
                    get: this.$route.meta.api,
                    delete: this.$route.meta.api,
                }
            }
        },
        components:{
            Table
        }
    }
</script>

