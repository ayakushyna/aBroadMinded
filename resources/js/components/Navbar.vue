<template>
    <b-navbar toggleable variant="primary">
        <b-navbar-toggle class="mr-2" target="sidebar"></b-navbar-toggle>

        <b-navbar-brand >
            <router-link class="light" :to="{ name: 'Home' }">
                Home
            </router-link>
        </b-navbar-brand>

        <b-navbar-nav justify class="flex-row">
            <b-nav-item v-if="!$auth.check()" >
                <router-link class="light ml-2" :to="{ name: 'Login' }">Login</router-link>
            </b-nav-item>
            <b-nav-item v-if="!$auth.check()" >
                <router-link class="light ml-2" :to="{ name: 'Register' }">Register</router-link>
            </b-nav-item>
            <b-nav-item v-if="$auth.check()" >
                <a href="#" class="light ml-2" @click.prevent="$auth.logout()">Logout</a>
            </b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>

<script>
    import {
        BNavbar,
        BNavbarBrand,
        BNavbarNav,
        BNavItem,
        BCollapse,
        BNavbarToggle,
        BButton,
        VBToggle
    } from 'bootstrap-vue'


    export default {
        components: {
            BNavbar, BNavbarBrand, BNavbarNav ,BNavItem,BCollapse, BNavbarToggle, BButton,VBToggle
        },
        directives: {
            BToggle: VBToggle
        }
    }

</script>

