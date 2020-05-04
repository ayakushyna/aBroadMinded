<template>
    <b-navbar toggleable="lg" variant="light">
        <b-navbar-brand >
            <router-link color="light" :to="{ name: 'Home' }">
                Home
            </router-link>
        </b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav class="ml-auto">
                <b-nav-item v-if="!$auth.check()" class="pull-right">
                    <router-link :to="{ name: 'Login' }">Login</router-link>
                </b-nav-item>
                <b-nav-item v-if="!$auth.check()" class="pull-right">
                    <router-link :to="{ name: 'Register' }">Register</router-link>
                </b-nav-item>
                <b-nav-item v-if="$auth.check()" class="pull-right">
                    <a href="#" @click.prevent="$auth.logout()">Logout</a>
                </b-nav-item>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
    import {BNavbar, BNavbarBrand, BNavbarNav ,BNavItem, BCollapse, BNavbarToggle} from 'bootstrap-vue'


    export default {
        components: {
            BNavbar, BNavbarBrand, BNavbarNav ,BNavItem,BCollapse, BNavbarToggle
        }
    }

</script>

