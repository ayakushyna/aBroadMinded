<template>
    <b-sidebar  id="sidebar"
                sticky
                bg-variant="dark"
                width="180px"
                class="d-flex align-items-stretch">
        <b-nav vartical>
            <b-nav-item >
                <router-link :to="{ name: 'Dashboard' }">DASHBOARD</router-link>
            </b-nav-item>

            <b-nav-item-dropdown
                text="PROFILES"
                dropright
            >
                <b-dropdown-item variant="primary">
                    <router-link :to="{ name: 'ProfileIndex' }">Profiles List</router-link>
                </b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown
                text="PROPERTIES"
                dropright
            >
                <b-dropdown-item>
                    <router-link :to="{ name: 'PropertyIndex' }">Properties List</router-link>
                </b-dropdown-item>
                <b-dropdown-divider></b-dropdown-divider>
                <b-dropdown-item>
                    <router-link :to="{ name: 'PropertyTypeIndex' }">Property Types List</router-link>
                </b-dropdown-item>
                <b-dropdown-item>
                    <router-link :to="{ name: 'PropertyTypeCreate' }">Create Property Type</router-link>
                </b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown
                text="BOOKINGS"
                dropright
            >
                <b-dropdown-item>
                    <router-link :to="{ name: 'BookingIndex' }">Bookings List</router-link>
                </b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown
                text="FEEDBACKS"
                dropright
            >
                <b-dropdown-item>
                    <router-link :to="{ name: 'FeedbackIndex' }">Feedbacks List</router-link>
                </b-dropdown-item>
            </b-nav-item-dropdown>
        </b-nav>


    </b-sidebar>
</template>

<script>
    import {
        BDropdownDivider,
        BDropdown,BNav,BNavItemDropdown,BNavItem,
        BDropdownItem,
        BSidebar,
        BCollapse, BButton, BRow
    } from 'bootstrap-vue'


    export default {

        components: {
            BNav,BNavItem,BNavItemDropdown,
            BDropdownDivider, BDropdown, BDropdownItem,
            BSidebar, BCollapse, BButton, BRow
        }
    }
</script>

