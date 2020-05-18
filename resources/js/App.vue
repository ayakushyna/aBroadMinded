<template>
    <div class="d-flex align-content-stretch position-relative">

        <sidebar></sidebar>

        <div class="container-fluid pl-0 pr-0" >
                <div class="panel-heading mb-2">
                    <navbar></navbar>
                </div>

                <div class="panel-body p-sm-5 align-self-stretch">
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
