/**
 * Js for Timings slots page created on 22 October, 2020-->
 **/

window.Vue = require('vue');

if(document.getElementById("timing-slots-view")){
    var timing_slots = new Vue({
        el: '#timing-slots-view',
        data: {
            form: {
                day: '',
                email: '',
            }
        },
        methods: {
            //submit form
            submitForm(){
                axios.post('/contact', this.form)
                    .then((res) => {
                        //Perform Success Action
                    })
                    .catch((error) => {
                        // error.response.status Check status code
                    }).finally(() => {
                    //Perform action in always
                });
            }
        },
    });
}
