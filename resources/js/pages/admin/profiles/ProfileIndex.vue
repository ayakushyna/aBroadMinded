<template>
    <div class="container-fluid">
        <div class="form-group" v-if="($auth.user().role === 'root')">
            <router-link :to="{name: 'UserCreate'}" class="btn btn-primary">Add new {{ name }}</router-link>
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
                pageShow: 'ProfileShow',
                pageEdit: 'ProfileEdit',
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


