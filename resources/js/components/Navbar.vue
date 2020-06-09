<template>
    <b-navbar toggleable variant="primary" style="max-height: 55px; height: 55px">
        <b-navbar-toggle v-if="($auth.check() && ($auth.user().role === 'admin' || $auth.user().role === 'root'))" class="mr-2" target="sidebar"></b-navbar-toggle>

        <b-navbar-brand>
            <router-link class="light" :to="{ name: 'Home' }">
                <h3><b>aBroadMinded</b></h3>
            </router-link>
        </b-navbar-brand>

        <b-navbar-nav justify class="flex-row">
            <b-nav-item>
                <router-link class="light ml-5" :to="{ name: 'PropertySearch' }">SEARCH</router-link>
            </b-nav-item>
            <b-nav-item v-if="!$auth.check()" >
                <router-link class="light ml-5" :to="{ name: 'Login' }">LOGIN</router-link>
            </b-nav-item>
            <b-nav-item v-if="!$auth.check()" >
                <router-link class="light ml-5" :to="{ name: 'Register' }">REGISTER</router-link>
            </b-nav-item>
            <b-nav-item v-if="$auth.check()" >
                <router-link class="light ml-5" style="color: white" :to="{ name: 'ProfileShow', params: {id: $auth.user().id} }">PROFILE</router-link>
            </b-nav-item>
            <b-nav-item v-if="$auth.check()" >
                <a href="#" class="light ml-5" style="color: white" @click.prevent="$auth.logout()">LOGOUT</a>
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

