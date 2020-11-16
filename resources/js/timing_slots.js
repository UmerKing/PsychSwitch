/**
 * Js for Timings slots page created on 22 October, 2020-->
 **/

window.Vue = require('vue');

if (document.getElementById("timing-slots-view")) {
    Vue.prototype.$timing_slots = new Vue({
        el: '#timing-slots-view',
        data: {
            form: {
                day: '',
                start_time: '',
                end_time: '',
                treatment_type: '',
                is_add: true,
                form_type: "Add",
                id: ''
            },
            is_error_thrown: false,
            data_success: false,
            messages: [],
            time_slots: [],
            db_error: "There has been an error occurred in the database please contact support."
        },
        methods: {
            //submit form
            submitForm() {
                this.form.start_time = document.getElementById("start-time").value;
                this.form.end_time = document.getElementById("end-time").value;
                axios.post('/doctor/store', this.form)
                    .then((res) => {
                        var that = this;
                        if (!res.data.success) {
                            this.is_error_thrown = true;
                            this.messages = [];
                            $.each(res.data.data, function (key, value) {
                                that.messages.push({message: value[0]});
                            });
                            if (this.messages.length === 0) { //if any DB error occurred
                                this.messages.push({message: this.db_error});
                            }
                        } else { //in case of success
                            this.data_success = true;
                            this.is_error_thrown = false;
                        }
                    })
                    .catch((error) => {
                        // error.response.status Check status code
                        this.is_error_thrown = true;
                        this.messages = [];
                        this.messages.push({message: this.db_error});
                    }).finally(() => {
                    //Perform action in always
                });
            },
            formatData(data) { //concatenate start and end time to show badges in slot tables
                var startTime = data.start_time;
                var start_hour = startTime.split(":");
                start_hour = start_hour[0];
                var start_minute = start_hour[1];
                var end_time = data.end_time;
                var end_hour = end_time.split(":");
                end_hour = end_hour[0];
                var end_minute = end_hour[1];
                var start_format = start_hour >= 12 ? 'pm' : 'am';
                var end_format = end_hour >= 12 ? 'pm' : 'am';

                start_hour = start_hour % 12;
                start_hour = start_hour ? start_hour : 12;
                end_hour = end_hour % 12;
                end_hour = end_hour ? end_hour : 12;
                start_minute = start_minute < 10 ? '0' + start_minute : start_minute;
                end_minute = end_minute < 10 ? '0' + end_minute : end_minute;
                var strTime = start_hour + ':' + start_minute + ' ' + start_format;
                var endTime = end_hour + ':' + end_minute + ' ' + end_format;
                return strTime + " to " + endTime;
            },
            showDetail(data) { //update form object to bind data of selected slot in form to update record
                this.form.day = data.day;
                this.form.start_time = data.start_time;
                this.form.end_time = data.end_time;
                this.form.treatment_type = data.treatment_type;
                this.form.is_add = false;
                this.form.form_type = "Update";
                this.form.id = data.id;
            },
            resetForm() { //reset form object on closing of update form modal
                this.form.day = this.form.start_time = this.form.end_time = this.form.treatment_type = "";
                this.form.is_add = true;
                this.is_error_thrown = this.data_success = false;
                this.form.form_type = "Add";
            }
        },
        mounted() {
            //reset form when modal is closed
            $(this.$refs.slot_modal).on("hidden.bs.modal", this.resetForm);
            //get timing slots against specified doctor
            axios.get('/doctor/timings/show')
                .then((res) => {
                    if (!res.data.success) {
                        this.is_error_thrown = true;
                        this.messages = [];
                        $.each(res.data.data, function (key, value) {
                            that.messages.push({message: value[0]});
                        });
                        if (this.messages.length === 0) { //if any DB error occurred
                            this.messages.push({message: this.db_error});
                        }
                    } else { //in case of success
                        this.is_error_thrown = false;
                        this.time_slots = res.data.data;
                    }
                })
                .catch((error) => {
                    this.is_error_thrown = true;
                    this.messages = [];
                    this.messages.push({message: this.db_error});
                }).finally(() => {
                //Perform action in always
            });
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
    });
}
