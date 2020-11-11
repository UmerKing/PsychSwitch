/**
 * Js for Timings slots page created on 22 October, 2020-->
 **/

window.Vue = require('vue');

if(document.getElementById("timing-slots-view")){
    Vue.prototype.$timing_slots = new Vue({
        el: '#timing-slots-view',
        data: {
            form: {
                day: '',
                start_time: '',
                end_time: '',
                treatment_type: '',
            },
            is_error_thrown: false,
            data_success: false,
            messages: [],
            time_slots:[]
        },
        methods: {
            //submit form
            submitForm(){
                this.form.start_time = document.getElementById("start-time").value;
                this.form.end_time = document.getElementById("end-time").value;
                axios.post('/doctor/add', this.form)
                    .then((res) => {
                        var that = this;
                        if(!res.data.success) {
                            this.is_error_thrown = true;
                            this.messages = [];
                            $.each(res.data.data, function(key, value) {
                                that.messages.push({message: value[0]});
                            });
                            if(this.messages.length === 0 ) { //if any DB error occurred
                                this.messages.push({message: "There has been an error occurred in the database please contact support."});
                            }
                        }
                        else { //in case of success
                            this.data_success = true;
                            this.is_error_thrown = false;
                        }
                    })
                    .catch((error) => {
                        // error.response.status Check status code
                        this.is_error_thrown = true;
                        this.messages = [];
                        this.messages.push({message: "There has been an error occurred in the database please contact support."});
                    }).finally(() => {
                    //Perform action in always
                });
            }
        },
    });

    //start and end time pickers for choosing time slot
    $(function () {
        var start_time = $('#start-time').timepicker({
            format: 'HH:MM'
        });
        var end_time = $('#end-time').timepicker({
            format: 'HH:MM'
        });
        //get timing slots against specified doctor
        axios.get('/doctor/timings/show')
            .then((res) => {
                //console.log(res);
                this.time_slots = res.data
            })
            .catch((error) => {
                // error.response.status Check status code
                this.is_error_thrown = true;
                this.messages = [];
                this.messages.push({message: "There has been an error occurred in the database please contact support."});
            }).finally(() => {
            //Perform action in always
        });
    });
}
