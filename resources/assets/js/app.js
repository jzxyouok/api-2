require('./bootstrap');

import Vue from 'vue'

import router from './router';
import App from './App.vue'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';

Vue.use(ElementUI);

new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: {App}
})

