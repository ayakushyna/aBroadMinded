<template>
    <footer>
        <div class="container">
            <b-row>
                <div class="col-lg-3  col-md-6 col-sm-6">
                    <div class="m-3">
                        <h6>About Agency</h6>
                        <p>
                            The world has become so fast paced
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="m-3">
                        <h6>Navigation Links</h6>
                        <b-row>
                            <b-col>
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">Services</a></li>
                                </ul>
                            </b-col>
                            <b-col>
                                <ul>
                                    <li><a href="#">Blog</a></li>
                                    <li><a href="#">Contact</a></li>
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
