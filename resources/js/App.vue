<template>
    <div class="d-flex align-content-stretch min-vh-100">
        <sidebar class="min-vh-100" v-if="$auth.check()"></sidebar>

        <div class="pl-0 pr-0 container-fluid position-relative min-vh-100">

            <div class="mb-2">
                <navbar></navbar>
            </div>

            <div class="p-sm-5 align-self-stretch main-content">
                    <transition>
                        <router-view :key="$route.fullPath"> </router-view>
                    </transition>
            </div>

            <div class="mt-2">
                <Footer></Footer>
            </div>
        </div>
    </div>
</template>

<script>
    import Sidebar from "./pages/admin/Sidebar";
    import Navbar from "./components/Navbar";
    import Footer from "./components/Footer";


    export default {
        components: {
            Navbar,
            Sidebar,
            Footer
        }
    }
</script>

<style scoped>

    .main-content {
        min-height: calc(100vh - 120px - 55px - 16px);
    }
</style>
