window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Vue from 'vue';
import VueRoute from 'vue-router';

//import App from './App';
import Main from './Main';

Vue.use(VueRoute);

const router = new VueRoute({
    routes: [
        {
            path: '/review-idea/:id', name: 'idea', component: Main
        }
    ],
    mode: 'history'
});

new Vue({
    el: '#app',
    template: '<Main/>',
    components: {
        Main: Main,
    },
    router: router
});