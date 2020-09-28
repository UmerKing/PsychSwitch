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
require('./../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min');
require('./../../public/theme/js/modernizr-3.5.0.min');
require('./../../public/theme/js/owl.carousel.min');
require('./../../public/theme/js/isotope.pkgd.min');
require('./../../public/theme/js/ajax-form');
require('./../../public/theme/js/jquery.counterup.min');
require('./../../public/theme/js/imagesloaded.pkgd.min');
require('./../../public/theme/js/scrollIt');
require('./../../public/theme/js/jquery.scrollUp.min');
require('./../../public/theme/js/nice-select.min');
require('./../../public/theme/js/jquery.slicknav.min');
require('./../../public/theme/js/jquery.magnific-popup.min');
require('./../../public/theme/js/plugins');
require('./../../public/theme/js/jquery.ajaxchimp.min');
require('./global');
require('./register');
require('./doctor_profile');


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