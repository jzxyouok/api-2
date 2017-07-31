import Vue from 'vue';
import Router from 'vue-router';
import Example from '../components/Example';

Vue.use(Router);

const routes = [
    {path: '/', component: Example}
];

export default new Router({
    linkActiveClass: 'active',
    routes
});
