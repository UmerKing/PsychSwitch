/**
 * global js file - Created on 10 Sep, 2020
 * @type {{}}
 */

const app = {};

$(function () {
    var timepicker = $('#time-picker').timepicker({
        format: 'HH:MM TT'
    });
});
$(document).ready(function() {
    $('.nice-select').niceSelect();
});
