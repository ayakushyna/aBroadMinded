import VueRouter from 'vue-router'
// Pages
import Home from './pages/Home'
import Register from './pages/Register'
import Login from './pages/Login'
import ProfileEdit from "./pages/admin/profiles/ProfileEdit";
import Dashboard from './pages/admin/Dashboard'
import PropertyCreate from "./pages/admin/properties/PropertyCreate";
import BookingCreate from "./pages/admin/bookings/BookingCreate";
import CalendarCreate from "./pages/admin/calendar/CalendarCreate";
import FeedbackCreate from "./pages/admin/feedbacks/FeedbackCreate";
import PropertyEdit from "./pages/admin/properties/PropertyEdit";
import BookingEdit from "./pages/admin/bookings/BookingEdit";
import FeedbackEdit from "./pages/admin/feedbacks/FeedbackEdit";
import CalendarEdit from "./pages/admin/calendar/CalendarEdit";
import PropertyTypeCreate from "./pages/admin/property_types/PropertyTypeCreate";
import PropertyTypeIndex from "./pages/admin/property_types/PropertyTypeIndex";
import FeedbackIndex from "./pages/admin/feedbacks/FeedbackIndex";
import BookingIndex from "./pages/admin/bookings/BookingIndex";
import PropertyIndex from "./pages/admin/properties/PropertyIndex";
import ProfileIndex from "./pages/admin/profiles/ProfileIndex";
import PropertyTypeEdit from "./pages/admin/property_types/PropertyTypeEdit";
import ProfileShow from "./pages/admin/profiles/ProfileShow";
import PropertyShow from "./pages/admin/properties/PropertyShow";
import PropertySearch from "./pages/admin/properties/PropertySearch";
import axios from "axios";
import BookingShow from "./pages/admin/bookings/BookingShow";

//paths
const paths = {
    profiles: '/profiles',
    properties: '/properties',
    search: '/search',
    register: '/auth/register',
    validate_user: '/auth/validate_user',
    validate_profile: '/profiles/validate_profile',
    users: '/users',
    roles: '/roles',
    cities: '/cities',
    states: '/states',
    countries: '/countries',
    gender:'/profiles/gender',
    property_types:'/property_types',
    property_images:'/property_images',
    host_types:'/properties/host_types',
    bookings: '/bookings',
    feedbacks: '/feedbacks',
    calendars: '/calendars',
}

// Routes
const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta: {
            auth: undefined
        }
    }, {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
            auth: true,
            api: {
                property_types: paths.property_types,
                properties: paths.properties,
                profiles: paths.profiles,
                cities: paths.cities,
                states: paths.states,
                countries: paths.countries,
            }
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    },{
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            auth: false,
            api: {
                validate_user: paths.validate_user,
                validate_profile: paths.validate_profile,
                cities: paths.cities,
                states: paths.states,
                countries: paths.countries,
                gender: paths.gender
            }
        }
    }, {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            auth: false
        }
    }, {
        path: '/profiles',
        name: 'ProfileIndex',
        component: ProfileIndex,
        meta: {
            auth: true,
            api: paths.profiles
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    },{
        path: '/profiles/edit/:id',
        name: 'ProfileEdit',
        component: ProfileEdit,
        meta: {
            auth: true,
            api: {
                profiles: paths.profiles,
                users:  paths.users,
                cities:  paths.cities,
                states:  paths.states,
                countries:  paths.countries,
                gender: paths.gender
            }
        },
    }, {
        path: '/profiles/:id',
        name: 'ProfileShow',
        component: ProfileShow,
        meta: {
            auth: true,
            api: {
                profiles: paths.profiles,
                properties:  paths.properties,
                bookings: paths.bookings,
                users: paths.users,
                roles: paths.roles
            }
        },
    }, {
        path: '/search',
        name: 'PropertySearch',
        component: PropertySearch,
        meta: {
            auth: undefined,
            api:  {
                search:  paths.search,
            }
        }
    },{
        path: '/properties',
        name: 'PropertyIndex',
        component: PropertyIndex,
        meta: {
            auth: true,
            api:  paths.properties
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    },{
        path: '/properties/create',
        name: 'PropertyCreate',
        component: PropertyCreate,
        meta: {
            auth: true,
            api: {
                properties:  paths.properties,
                cities:  paths.cities,
                states:  paths.states,
                countries:  paths.countries,
                profiles:  paths.profiles,
                property_types: paths.property_types,
                property_images: paths.property_images,
                host_types: paths.host_types
            }
        }
    },{
        path: '/properties/edit/:id',
        name: 'PropertyEdit',
        component: PropertyEdit,
        meta: {
            auth: true,
            api: {
                properties:  paths.properties,
                cities:  paths.cities,
                states:  paths.states,
                countries:  paths.countries,
                profiles:  paths.profiles,
                property_types:  paths.property_types,
                property_images: paths.property_images,
                host_types: paths.host_types
            }
        },
    },{
        path: '/properties/:id',
        name: 'PropertyShow',
        component: PropertyShow,
        meta: {
            auth: undefined,
            api: {
                properties:  paths.properties,
                bookings: paths.bookings,
                feedbacks: paths.feedbacks,
                calendars: paths.calendars
            }
        },
    },{
        path: '/bookings',
        name: 'BookingIndex',
        component: BookingIndex,
        meta: {
            auth: true,
            api:  paths.bookings
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    },{
        path: '/bookings/:id',
        name: 'BookingShow',
        component: BookingShow,
        meta: {
            auth: true,
            api:  {
                bookings: paths.bookings,
                feedbacks: paths.feedbacks
            }
        }
    },{
        path: '/properties/:id/booking/create',
        name: 'BookingCreate',
        component: BookingCreate,
        meta: {
            auth: true,
            api: {
                bookings:  paths.bookings,
                calendars: paths.calendars
            }
        },
    },{
        path: '/bookings/edit/:id',
        name: 'BookingEdit',
        component: BookingEdit,
        meta: {
            auth: true,
            api: {
                bookings:  paths.bookings,
                calendars: paths.calendars
            }
        }
    },{
        path: '/feedbacks',
        name: 'FeedbackIndex',
        component: FeedbackIndex,
        meta: {
            auth: true,
            api: paths.feedbacks
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    },{
        path: '/bookings/:id/feedback/create',
        name: 'FeedbackCreate',
        component: FeedbackCreate,
        meta: {
            auth: true,
            api: {
                feedbacks: paths.feedbacks,
            }
        },
    },{
        path: '/feedbacks/edit/:id',
        name: 'FeedbackEdit',
        component: FeedbackEdit,
        meta: {
            auth: true,
            api: {
                feedbacks: paths.feedbacks,
            }
        },
    },{
        path: '/properties/:id/calendar/create',
        name: 'CalendarCreate',
        component: CalendarCreate,
        meta: {
            auth: true,
            api: {
                calendars:  paths.calendars,
                properties: paths.properties,
            }
        }
    },{
        path: '/calendars/edit/:id',
        name: 'CalendarEdit',
        component: CalendarEdit,
        meta: {
            auth: true,
            api: {
                calendars:  paths.calendars,
                properties: paths.properties,
            }
        }
    },{
        path: '/property_types',
        name: 'PropertyTypeIndex',
        component: PropertyTypeIndex,
        meta: {
            auth: true,
            api:   paths.property_types,
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    },{
        path: '/property_types/create',
        name: 'PropertyTypeCreate',
        component: PropertyTypeCreate,
        meta: {
            auth: true,
            api: {
                property_types: paths.property_types,
            }
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    }, {
        path: '/property_types/:id',
        name: 'PropertyTypeEdit',
        component: PropertyTypeEdit,
        meta: {
            auth: true,
            api: {
                property_types: paths.property_types,
            }
        },
        beforeEnter: (to, from, next) => {
            if (Vue.auth.user().role !== 'root' && Vue.auth.user().role !== 'admin') next({ name: 'Home' })
            else next()
        },
    }]
const router = new VueRouter({
    history: false,
    mode: 'history',
    routes,
})
export default router
