<template>
    <footer style="max-height: 120px; height: 120px">
        <div class="container">
            <b-row>
                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="m-3">
                        <h6>About</h6>
                        <p>
                            Made by Anastasiia Yakushyna
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="m-3">
                        <h6>Navigation Links</h6>
                        <b-row>
                            <b-col>
                                <ul>
                                    <li><router-link class="light" :to="{ name: 'Home' }">Home </router-link></li>
                                </ul>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </b-row>

        </div>
    </footer>

</template>

<script>
    import {
        BCol, BRow,
    } from "bootstrap-vue";

    export default {
        components: {
            BCol, BRow,
        },
    }
</script>

<style scoped lang="scss">

</style>
