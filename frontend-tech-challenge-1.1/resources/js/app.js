import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import UserList from './components/users/List.vue';
import { routes } from './routes';

require('./bootstrap');

window.Vue = require('vue').default;

window.Vue.use(VueRouter);
window.Vue.use(VueAxios, axios);

const router = new VueRouter({
  base: '/',
  mode: 'history',
  routes,
});

const app = new window.Vue({
  el: '#app',
  router,
  render: (h) => h(UserList),
});
