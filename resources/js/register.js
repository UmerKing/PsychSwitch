/**
 * Js for registration page created on 07 sep, 2020-->
 **/

window.Vue = require('vue');

const DOCTOR = 2;
const PATIENT = 1;

app.register = new Vue({
    el: '#register-card',
    data: {
        seen: false
    },
    methods: {
        switchForm: function (event) {
            var target_value = parseInt(event.target.value);
            if (target_value === DOCTOR) {
                this.$data.seen = true;
            } else {
                this.$data.seen = false;
            }
        }
    }
});