/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
require('admin-lte');



window.Vue = require('vue').default;
import Vue from 'vue'
import VueRouter from 'vue-router'
import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
import Swal from 'sweetalert2'
// import { vue } from 'laravel-mix';


// CommonJS

Vue.use(VueRouter)
Vue.use(require('vue-moment'));
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
window.Form=Form;
window.swal=Swal;
window.Fire=new Vue();


const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.toast=toast;


let routes = [
    { path:'/dashboard', component:  require('./components/Dashboard.vue').default},
    { path:'/profile', component: require('./components/Profile.vue').default},
    { path:'/users', component: require('./components/Users.vue').default}

  ]

  let router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })
  Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
     methods: {
    login () {
      // Submit the form via a POST request
      this.form.post('/login')
        .then(({ data }) => { console.log(data) })
    }
  }
 
});
