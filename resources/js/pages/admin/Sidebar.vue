<template>
        <b-nav vertical>
            <b-list-group>
                <b-list-group-item>
                    <router-link :to="{ name: 'Dashboard' }">Dashboard</router-link>
                </b-list-group-item>

                <b-list-group-item>
                    <b-nav-item-dropdown
                        text="Profiles"
                        toggle-class="nav-link-custom"
                        dropright
                    >
                    <b-dropdown-item>
                        <router-link :to="{ name: 'ProfileIndex' }">Profiles List</router-link>
                    </b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item>
                        <router-link :to="{ name: 'UserCreate' }">Create User</router-link>
                    </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-list-group-item>

                <b-list-group-item>
                    <b-nav-item-dropdown
                        text="Properties"
                        toggle-class="nav-link-custom"
                        dropright
                    >
                    <b-dropdown-item>
                        <router-link :to="{ name: 'PropertyIndex' }">Properties List</router-link>
                    </b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item>
                        <router-link :to="{ name: 'PropertyCreate' }">Create Property</router-link>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <router-link :to="{ name: 'CalendarCreate' }">Create Calendar</router-link>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <router-link :to="{ name: 'PropertyTypeIndex' }">Property Types List</router-link>
                    </b-dropdown-item>
                    <b-dropdown-item>
                        <router-link :to="{ name: 'PropertyTypeCreate' }">Create Property Type</router-link>
                    </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-list-group-item>

                <b-list-group-item>
                    <b-nav-item-dropdown
                        text="Bookings"
                        toggle-class="nav-link-custom"
                        dropright
                    >
                    <b-dropdown-item>
                        <router-link :to="{ name: 'BookingIndex' }">Bookings List</router-link>
                    </b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item>
                        <router-link :to="{ name: 'BookingCreate' }">Create Booking</router-link>
                    </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-list-group-item>

                <b-list-group-item>
                    <b-nav-item-dropdown
                        text="Feedbacks"
                        toggle-class="nav-link-custom"
                        dropright
                    >
                        <b-dropdown-item>
                            <router-link :to="{ name: 'FeedbackIndex' }">Feedbacks List</router-link>
                        </b-dropdown-item>
                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-item>
                            <router-link :to="{ name: 'FeedbackCreate' }">Create Feedback</router-link>
                        </b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-list-group-item>
            </b-list-group>

        </b-nav>
</template>

<script>
    import {BListGroup,BListGroupItem,BNav, BDropdownDivider, BNavItemDropdown, BDropdownItem} from 'bootstrap-vue'


    export default {

        components: {
             BListGroup,BListGroupItem, BNav,  BDropdownDivider, BNavItemDropdown, BDropdownItem
        }
    }
</script>
