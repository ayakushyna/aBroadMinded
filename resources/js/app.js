import 'es6-promise/auto'
import axios from 'axios'
import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import App from './App'
import auth from './auth'
import router from './router'
import locale from 'element-ui/lib/locale/lang/en'
// Set Vue globally
window.Vue = Vue

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI, { locale })

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `http://127.0.0.1:8000/api`
Vue.use(VueAuth, auth)

Vue.component('pagination', require('laravel-vue-pagination'));

new Vue({
    el: '#app',
    router: router,
    render: app => app(App)
});
