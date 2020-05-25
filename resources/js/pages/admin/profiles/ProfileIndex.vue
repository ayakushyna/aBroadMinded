<template>
    <div class="container-fluid">
        <Table :name="name"
               :hasShow=hasShow
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
                name: 'Profile',
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


