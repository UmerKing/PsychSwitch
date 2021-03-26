/**
 * Js for search section created on 21 March, 2021
 **/

window.Vue = require('vue');


if (document.getElementById("search-area")) {
    doctor_profile = new Vue({
        el: '#search-area',
        data: {
            cities: [],
            specialities: [],
            errors: [],
            is_error_thrown: false,
            city_name: '',
            base_url: window.location.origin
        },
        methods: {},
        mounted() {
            //get specialities from api
            axios
                .get(this.base_url + '/api/specialities')
                .then(response => (
                    this.specialities = response.data.data,
                        this.specialities.splice(0, 0, {"id": "0", "name": "Select Speciality"})
                ))
                .catch(error => {
                    this.errors.push({message: "Their is error occurred in speciality api please contact administrator"}),
                        this.is_error_thrown = true
                });
            //get cities from api
            axios
                .get(this.base_url + '/api/cities')
                .then(response => (
                    this.cities = response.data.data,
                        this.cities.splice(0, 0, {"id": "0", "city": "Select City"})
                ))
                .catch(error => {
                    this.errors.push({message: "Their is error occurred in cities api please contact administrator"}),
                        this.is_error_thrown = true
                });
        },
    });
}
