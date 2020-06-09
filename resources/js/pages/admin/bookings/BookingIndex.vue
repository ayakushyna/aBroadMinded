<template>
    <div class="container-fluid">
        <Table :name="name"
               :hasShow=hasShow
               :hasEdit=hasEdit
               :hasDelete=hasDelete
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
                name: 'Booking',
                hasShow:true,
                hasEdit:true,
                hasDelete:true,
                pageShow:"BookingShow",
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

