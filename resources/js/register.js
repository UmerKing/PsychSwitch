/**
 * Js for registration page created on 07 sep, 2020-->
 **/

window.Vue = require('vue');

const DOCTOR = 1;
const PATIENT = 2;


app.register = new Vue({
    el: '#register-card',
    data: {
        seen: true,
        specialities: [],
        cities: [],
        errors: [],
        is_error_thrown: false,
        is_required: true
    },
    methods: {
        //switch doctor and patient register form on change of registered as dropdown
        switchForm: function (event) {
            var target_value = parseInt(event.target.value);
            if (target_value === DOCTOR) {
                this.$data.seen = true;
            } else {
                this.$data.seen = false;
                this.$is_required = false;
            }
        }
    },
    mounted() {
        //get specialities from api
        axios
            .get('api/specialities')
            .then(response => (
                this.specialities = response.data.data
            ))
            .catch(error => {
                this.errors.push({message: "Their is error occurred in speciality api please contact administrator"}),
                    this.is_error_thrown = true
            });

        //get cities from api
        axios
            .get('api/cities')
            .then(response => (
                this.cities = response.data.data
            ))
            .catch(error => {
                this.errors.push({message: "Their is error occurred in cities api please contact administrator"}),
                    this.is_error_thrown = true
            });

        //get selected registered as value on page load and set fields accordingly - in case of post request of registration errors
        var registered_as = document.getElementById("registered-as");
        if (parseInt(registered_as.value) === PATIENT) {
            this.seen = false;
        } else {
            this.seen = true;
        }
    },
});
