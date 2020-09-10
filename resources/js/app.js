/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//importing node module packages
require('./../../node_modules/jquery/dist/jquery.min');
require('./../../node_modules/jquery.easing/jquery.easing.min');
require('./../../node_modules/chart.js/dist/Chart.min');
require('./../../node_modules/@fortawesome/fontawesome-free/css/all.min.css');
require('./../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css');
require('./../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min');
require('./global');
require('./register');


//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */