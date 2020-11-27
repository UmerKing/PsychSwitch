/**
 * Js for Timings slots page created on 22 October, 2020-->
 **/

window.Vue = require('vue');

if (document.getElementById("page-book-appointment")) {
    Vue.prototype.$book_appointment = new Vue({
        el: '#page-book-appointment',
        data: {
            time_slots: [],
            treatment_types: [],
            booking: false,
            is_error: false,
            error_message: 'Something went wrong'
        },
        methods: {
            getAvailableTimeSlots(doctor_id, event) { //get available time slots against selected day
                axios.post('/doctor/get-slots', {'doctor_id': doctor_id, 'day': event.target.value})
                    .then((res) => {
                        this.time_slots = res.data.data;
                        if (this.time_slots.length === 0) {
                            this.is_error = true;
                            this.error_message = "Unfortunately! Doctor is not available on this day please choose any other day";
                        } else {
                            this.is_error = false;
                        }
                    })
                    .catch((error) => {
                        // error.response.status Check status code
                        this.is_error = true;
                    }).finally(() => {
                    //Perform action in always
                });
            },
            filterTypes(event) { //filter treatment type for dropdown against selected time slot
                var time = event.target.value.split("-");
                var array = this.time_slots
                    .filter((data) => {
                        return data.start_time.match(time[0].trim()) && data.end_time.match(time[1].trim())
                    });
                this.treatment_types = array.map(function (drink) {
                    return drink.treatment_type === "1" ? "Video Call" : "In Clinic";
                });
                this.removeDuplicates();
            },
            removeDuplicates() { //remove duplicates from array
                this.treatment_types = [...new Set(this.treatment_types)]
            },
            activateBooking(value) { //toggle booking status
                this.booking = value;
            },
            submitForm() { //submit form
                // console.log(this.form);
                // axios.post('/doctor/store', this.form)
                //     .then((res) => {
                //
                //     })
                //     .catch((error) => {
                //         // error.response.status Check status code
                //
                //     }).finally(() => {
                //     //Perform action in always
                // });
            },
        },
    });
}
