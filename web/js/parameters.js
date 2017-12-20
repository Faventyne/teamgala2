$(function(){
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 5, // Creates a dropdown of 15 years to control year,
        clear: 'Clear',
        close: 'Ok',
        min: new Date(),
        today:false,
        yearend : '31/12/2017',
        closeOnSelect: false // Close upon selecting a date,
    })

    $('.datepicker').text(new Date($('.datepicker')));


    //$('.datepicker').getDate();
    }
);







