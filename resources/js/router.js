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
import PropertyTypeEdit from "./pages/admin/property_types/PropertyTypeEdit";
import ProfileShow from "./pages/admin/profiles/ProfileShow";
import PropertyShow from "./pages/admin/properties/PropertyShow";

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
        component: Home,
        meta: {
            auth: undefined
        }
    }, {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
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
            auth: undefined,
            api: paths.profiles
        }
    },{
        path: '/users/create',
        name: 'UserCreate',
        component: UserCreate,
        meta: {
            auth: true,
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
            auth: true,
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
            auth: true,
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
        path: '/profiles/:id',
        name: 'ProfileShow',
        component: ProfileShow,
        meta: {
            auth: undefined,
            api: {
                profiles: paths.profiles,
                properties:  paths.properties,
                bookings: paths.bookings
            }
        }
    }, {
        path: '/properties',
        name: 'PropertyIndex',
        component: PropertyIndex,
        meta: {
            auth: undefined,
            api:  paths.properties
        }
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
                host_types: paths.host_types
            }
        }
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
        }
    },{
        path: '/bookings',
        name: 'BookingIndex',
        component: BookingIndex,
        meta: {
            auth: undefined,
            api:  paths.bookings
        }
    },{
        path: '/bookings/create',
        name: 'BookingCreate',
        component: BookingCreate,
        meta: {
            auth: true,
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
            auth: true,
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
            auth: undefined,
            api: paths.feedbacks
        }
    },{
        path: '/feedbacks/create',
        name: 'FeedbackCreate',
        component: FeedbackCreate,
        meta: {
            auth: true,
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
            auth: true,
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
            auth: undefined,
            api:   paths.property_types,
        }
    },{
        path: '/property_types/create',
        name: 'PropertyTypeCreate',
        component: PropertyTypeCreate,
        meta: {
            auth: true,
            api: {
                property_types: paths.property_types,
            }
        }
    }, {
        path: '/property_types/:id',
        name: 'PropertyTypeEdit',
        component: PropertyTypeEdit,
        meta: {
            auth: true,
            api: {
                property_types: paths.property_types,
            }
        }
    }]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
