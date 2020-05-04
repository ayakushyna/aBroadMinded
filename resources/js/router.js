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
import UserEdit from "./pages/admin/profiles/UserEdit";
import UserCreate from "./pages/admin/profiles/UserCreate";
import PropertyTypeIndex from "./pages/admin/property_types/PropertyTypeIndex";
import FeedbackIndex from "./pages/admin/feedbacks/FeedbackIndex";
import BookingIndex from "./pages/admin/bookings/BookingIndex";
import PropertyIndex from "./pages/admin/properties/PropertyIndex";
import ProfileIndex from "./pages/admin/profiles/ProfileIndex";

//paths
const paths = {
    profiles: '/profiles',
    properties: '/properties',
    register: '/auth/register',
    users: '/users',
    cities: '/cities',
    states: '/states',
    countries: '/countries',
    gender:'/profiles/gender',
    property_types:'/property_types',
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
        component: Home
    }, {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard
    },{
        path: '/auth/register',
        name: 'Register',
        component: Register,
        meta: {
            auth: false
        }
    }, {
        path: '/auth/login',
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
            auth: false,
            api: paths.profiles
        }
    },{
        path: '/users/create',
        name: 'UserCreate',
        component: UserCreate,
        meta: {
            auth: false,
            api: {
                profiles: paths.profiles,
                register: paths.register,
            }
        }
    },{
        path: '/users/edit/:id',
        name: 'UserEdit',
        component: UserEdit,
        meta: {
            auth: false,
            api: {
                profiles: paths.profiles,
                register: paths.register,
            }
        }
    },{
        path: '/profiles/edit/:id',
        name: 'ProfileEdit',
        component: ProfileEdit,
        meta: {
            auth: false,
            api: {
                profiles: paths.profiles,
                users:  paths.users,
                cities:  paths.cities,
                states:  paths.states,
                countries:  paths.countries,
                gender: paths.gender
            }
        }
    }, {
        path: '/properties',
        name: 'PropertyIndex',
        component: PropertyIndex,
        meta: {
            auth: false,
            api:  paths.properties
        }
    },{
        path: '/properties/create',
        name: 'PropertyCreate',
        component: PropertyCreate,
        meta: {
            auth: false,
            api: {
                properties:  paths.properties,
                cities:  paths.cities,
                states:  paths.states,
                countries:  paths.countries,
                profiles:  paths.profiles,
                property_types: paths.property_types,
                host_types: paths.host_types
            }
        }
    },{
        path: '/properties/edit/:id',
        name: 'PropertyEdit',
        component: PropertyEdit,
        meta: {
            auth: false,
            api: {
                properties:  paths.properties,
                cities:  paths.cities,
                states:  paths.states,
                countries:  paths.countries,
                profiles:  paths.profiles,
                property_types:  paths.property_types,
                host_types: paths.host_types
            }
        }
    },{
        path: '/bookings',
        name: 'BookingIndex',
        component: BookingIndex,
        meta: {
            auth: false,
            api:  paths.bookings
        }
    },{
        path: '/bookings/create',
        name: 'BookingCreate',
        component: BookingCreate,
        meta: {
            auth: false,
            api: {
                bookings:  paths.bookings,
                profiles:  paths.profiles,
                properties: paths.properties,
            }
        }
    },{
        path: '/bookings/edit/:id',
        name: 'BookingEdit',
        component: BookingEdit,
        meta: {
            auth: false,
            api: {
                bookings:  paths.bookings,
                profiles:  paths.profiles,
                properties: paths.properties,
            }
        }
    },{
        path: '/feedbacks',
        name: 'FeedbackIndex',
        component: FeedbackIndex,
        meta: {
            auth: false,
            api: paths.feedbacks
        }
    },{
        path: '/feedbacks/create',
        name: 'FeedbackCreate',
        component: FeedbackCreate,
        meta: {
            auth: false,
            api: {
                feedbacks: paths.feedbacks,
                profiles: paths.profiles,
                properties: paths.properties,
            }
        }
    },{
        path: '/feedbacks/edit/:id',
        name: 'FeedbackEdit',
        component: FeedbackEdit,
        meta: {
            auth: false,
            api: {
                feedbacks: paths.feedbacks,
                profiles: paths.profiles,
                properties: paths.properties,
            }
        }
    },{
        path: '/calendars/create',
        name: 'CalendarCreate',
        component: CalendarCreate,
        meta: {
            auth: false,
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
            auth: false,
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
            auth: false,
            api:   paths.property_types,
        }
    },{
        path: '/property_types/create',
        name: 'PropertyTypeCreate',
        component: PropertyTypeCreate,
        meta: {
            auth: false,
            api: {
                property_types: paths.property_types,
            }
        }
    },]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
