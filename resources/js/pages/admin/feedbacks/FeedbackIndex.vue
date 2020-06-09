<template>
    <div class="container-fluid">
        <Table :name="name"
               :hasEdit=hasEdit
               :hasDelete=hasDelete
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
                name: 'Feedback',
                hasEdit:true,
                hasDelete:true,
                pageEdit: 'FeedbackEdit',
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

