<template>
    <div class="d-flex justify-content-between">

        <div class="mb-md-n5 position-relative d-flex align-content-stretch">
            <sidebar></sidebar>
        </div>

        <div class="container">
                <div class="panel-heading">
                    <navbar></navbar>
                </div>

                <div class="panel-body">
                    <transition>
                        <router-view :key="$route.fullPath"> </router-view>
                    </transition>
                </div>
        </div>
    </div>
</template>

<script>
    import Sidebar from "./pages/admin/Sidebar";
    import Navbar from "./components/Navbar";

    export default {
        components: {
            Navbar,
            Sidebar
        }
    }
</script>

<style lang="scss">
    a {
        color: black;
    }
    a:link {
        color: black;
    }
    a:hover {
        color: purple;
    }

    *{
        outline: none;
        border: 0;
        background-color: transparent;
    }
</style>
