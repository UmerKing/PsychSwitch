/**
 * Js for doctor profile page created on 22 sep, 2020
 **/

window.Vue = require('vue');


if(document.getElementById("doctor-profile")){
    doctor_profile = new Vue({
        el: '#doctor-profile',
        data: {
            cities: [],
            specialities: [],
            sub_specialities: [],
            errors: [],
            is_error_thrown: false,
            base_url : window.location.origin
        },
        methods: {
            getSubSpecialities: function () { //get sub-specialities against selected speciality
                setTimeout(function () {
                    var speciality_id = document.getElementById("speciality_id");
                    //get sub-specialities from api
                    axios
                        .get(this.base_url + '/api/sub_specialities/' + parseInt(speciality_id.options[speciality_id.selectedIndex].value))
                        .then(response => {
                                this.sub_specialities = response.data.data,
                                this.sub_specialities.length === 0 ? this.sub_specialities.push({
                                    id: '',
                                    name: "No data available"
                                }) : this.sub_specialities
                        })
                        .catch(error => {
                            this.errors.push({message: "Their is error occurred in sub-speciality api please contact administrator"}),
                                this.is_error_thrown = true
                        });
                }.bind(this), 1000);
            }
        },
        mounted() {
            //get specialities from api
            axios
                .get(this.base_url + '/api/specialities')
                .then(response => (
                    this.specialities = response.data.data,
                        this.getSubSpecialities()
                ))
                .catch(error => {
                    this.errors.push({message: "Their is error occurred in speciality api please contact administrator"}),
                        this.is_error_thrown = true
                });
            //get cities from api
            axios
                .get(this.base_url + '/api/cities')
                .then(response => (
                    this.cities = response.data.data
                ))
                .catch(error => {
                    this.errors.push({message: "Their is error occurred in cities api please contact administrator"}),
                        this.is_error_thrown = true
                });
        },
    });
}
