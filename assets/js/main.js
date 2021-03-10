$(document).ready(function () {
    $('#bookingTable').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "aaSorting": [ [3,'asc'], [2,'asc'] ],
    });

    $('#BarbershopSearch').picker({
        search: true,
        searchAutofocus: true,
    });

    $("#bookBarbershopSelect").change(function(){
        let selectedBarbershop = $("#bookBarbershopSelect").val();

        $.ajax({
            url:'inc/ajax.inc.php',
            data:{
                barbershopId:selectedBarbershop,
                daysDisabled: "",
                populateBarbers: "",
            },
            type: 'post',
            dataType: 'json',
            success : function(resp){

                $("#bookBarberSelect").html(JSON.parse(resp[0]))
                $("#bookedDate").datepicker('destroy');
                $('#bookedDate').datepicker({
                    startDate: new Date(),
                    endDate: "+2w",
                    autoclose: true,
                    daysOfWeekDisabled: getOpenWeekdays(resp[1])
                });
            },
            error : function(resp){
                console.log(resp)
            }
        });
    });

    $('#bookedDate').datepicker({
        startDate: new Date(),
        endDate: "+2w",
        autoclose: true,
    }).on('change', function () {
        let selectedDate= new Date($("#bookedDate").val()).toISOString().split('T')[0];
        let selectedBarbershop = $("#bookBarbershopSelect").val();
        let selectedBarber = $("#bookBarberSelect").val();

        $.ajax({
            url:'inc/ajax.inc.php',
            data:{
                barbershopId:selectedBarbershop,
                barberId:selectedBarber,
                weekday: $(this).datepicker("getDate").getDay(),
                date: selectedDate,
                bookedTimes: ""
            },
            type: 'post',
            dataType: 'json',
            success : function(resp){
                $('#bookedTime').timepicker('remove').timepicker({
                    timeFormat: 'h:i A',
                    minTime: resp[1].open_time,
                    maxTime: resp[1].close_time,
                    step: 30,
                    useSelect: true,
                    'disableTimeRanges': buildBookedTimes(resp[0])
                });
            },
            error : function(resp){
                console.log(resp)
            }
        });
    });
});

function getOpenWeekdays(weekdays) {
    let weekdaysArray = [0, 1, 2, 3, 4, 5, 6];
    let jsonWeekdays = JSON.parse(weekdays);
    for (let i = 0; i < jsonWeekdays.length; i++) {
        for (let x = 0; x < weekdaysArray.length; x++) {
            if (weekdaysArray[x] === parseInt(jsonWeekdays[i]["openWeekdays"])) {
                weekdaysArray.splice(x, 1);
            }
        }
    }

    return weekdaysArray;
}

function buildBookedTimes(timeArray) {
    let parsedTime;
    let newArray = [];

    for (let i = 0; i < timeArray.length; i++) {
        parsedTime = new Date(timeArray[i].date_time_booked.split(" ")[0] + " " + timeArray[i].date_time_booked.split(" ")[1])
        let h = `${parsedTime.getHours()}`.padStart(2, '0')
        let m = `${parsedTime.getMinutes()}`.padStart(2, '0')
        let s = `${parsedTime.getSeconds()}`.padStart(2, '0')
        let sEnd = `${parsedTime.getSeconds() + 1}`.padStart(2, '0')

        let time1 = h + ":" + m + ":" + s;
        let time2 = h + ":" + m + ":" + sEnd;

        newArray.push([time1, time2])
    }

    return newArray;
}