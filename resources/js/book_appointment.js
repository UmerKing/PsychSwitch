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
            is_booking_active: false,
            is_error: false,
            is_payment_active: false,
            db_error: "There has been an error occurred in the database please contact support.",
            messages: [],
            data_success: false,
            success_message: '',
            form: {
                appointment_date: '',
                timing_slot_id: '',
                name: '',
                email: '',
                phone: ''
            },
            weekday: {
                0: "SUNDAY",
                1: "MONDAY",
                2: "TUESDAY",
                3: "WEDNESDAY",
                4: "THURSDAY",
                5: "FRIDAY",
                6: "SATURDAY"
            }
        },
        methods: {
            getAvailableTimeSlots(doctor_id, event) { //get available time slots against selected day
                var day = new Date(event.target.value);
                this.messages = [];
                axios.post('/doctor/get-slots', {'doctor_id': doctor_id, 'day': this.weekday[day.getDay()]})
                    .then((res) => {
                        this.time_slots = res.data.data;
                        if (this.time_slots.length === 0) {
                            this.is_error = true;
                            this.messages.push({message: "Unfortunately! Doctor is not available on this day please choose any other day"});
                        } else {
                            this.is_error = false;
                        }
                        this.removeDuplicates("slot");
                    })
                    .catch((error) => { //if any error occurs on server side
                        this.is_error = true;
                        this.messages.push({message: this.db_error});
                    });
            },
            filterTypes(event) { //filter treatment type for dropdown against selected time slot
                var time = event.target.value.split("-");
                this.treatment_types = this.time_slots
                    .filter((data) => {
                        return data.start_time.match(time[0].trim()) && data.end_time.match(time[1].trim())
                    });
                this.removeDuplicates("type");
            },
            removeDuplicates(param) { //remove duplicates from arrays
                switch (param) {
                    case "slot":
                        this.time_slots = _.uniqBy(this.time_slots, function (p) {
                            return p.start_time && p.end_time;
                        });
                        break;
                    case "type":
                        this.treatment_types = _.uniqBy(this.treatment_types, function (p) {
                            return p.treatment_type;
                        });
                        break;
                    default:
                    //
                }
            },
            activateBooking(value) { //toggle booking status
                this.is_booking_active = value;
                this.is_error = false;
            },
            submitForm() { //submit form
                var e = document.getElementById("type");
                this.form.timing_slot_id = e.value;
                this.messages = [];
                axios.post('/appointment/store', this.form)
                    .then((res) => {
                        var that = this;
                        if (!res.data.success) {
                            this.is_error = true;
                            $.each(res.data.data, function (key, value) {
                                that.messages.push({message: value[0]});
                            });
                            if (this.messages.length === 0) { //if any DB error occurred
                                this.messages.push({message: this.db_error});
                            }
                        } else { //in case of success
                            this.is_error = false;
                            this.data_success = true;
                            this.success_message = res.data.message;
                            this.is_payment_active = true;
                        }
                    })
                    .catch((error) => { //if any error occurs on server side
                        this.is_error = true;
                        this.messages.push({message: this.db_error});
                    });
            },
        },
    });
}
