<template>
    <div class="container-fluid">
        <div class="form-group" v-if="($auth.user().role === 'root')">
            <router-link :to="{path: $route.fullPath + '/create'}" class="btn btn-primary">Add new property</router-link>
        </div>

        <Table :hasShow="hasShow"
               :pageShow="pageShow"
               :pageEdit="pageEdit"
               :api="api"
        ></Table>
    </div>
</template>

<script>

    import Table from "../../../components/Table";
    export default {
        data(){
            return {
                hasShow:true,
                pageShow: 'PropertyShow',
                pageEdit: 'PropertyEdit',
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

