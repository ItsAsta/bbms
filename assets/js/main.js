$(document).ready(function () {
    $('#bookingTable').dataTable({
        "bPaginate": true,
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aaSorting": [[4, 'asc'], [3, 'asc']],
        "columnDefs": [
            {"width": "10%", "targets": 0}
        ]
    });

    $("#bookBarbershopSelect").change(function () {
        let selectedBarbershop = $("#bookBarbershopSelect").val();

        $.ajax({
            url: 'inc/ajax.inc.php',
            data: {
                barbershopId: selectedBarbershop,
                daysDisabled: "",
                populateBarbers: "",
            },
            type: 'post',
            dataType: 'json',
            success: function (resp) {

                $("#bookBarberSelect").html(JSON.parse(resp[0]))
                $("#bookedDate").datepicker('destroy');
                $("#bookedTime").css('pointer-events', '');
                $("#bookedDate").css('pointer-events', '');
                $('#bookedDate').datepicker({
                    dateFormat: 'dd/mm/yy',
                    startDate: new Date(),
                    endDate: "+2w",
                    autoclose: true,
                    daysOfWeekDisabled: getOpenWeekdays(resp[1])
                });
            },
            error: function (resp) {
                console.log(resp)
            }
        });
    });

    $("#bookedDate").css('pointer-events', 'none');
    $("#bookedTime").css('pointer-events', 'none');
    $('#bookedDate').datepicker({
        dateFormat: 'dd/mm/yy',
        startDate: new Date(),
        endDate: "+2w",
        autoclose: true,
    }).on('change', function () {
        let selectedDate = $("#bookedDate").val().replace(/(\d\d)\/(\d\d)\/(\d{4})/, "$3-$1-$2");
        let selectedBarbershop = $("#bookBarbershopSelect").val();
        let selectedBarber = $("#bookBarberSelect").val();

        $.ajax({
            url: 'inc/ajax.inc.php',
            data: {
                barbershopId: selectedBarbershop,
                barberId: selectedBarber,
                weekday: $(this).datepicker("getDate").getDay(),
                date: selectedDate,
                bookedTimes: ""
            },
            type: 'post',
            dataType: 'json',
            success: function (resp) {
                $('#bookedTime').timepicker('remove').timepicker({
                    timeFormat: 'h:i A',
                    minTime: moment(resp[1].open_time, 'hh:mm:ss').format('LT'),
                    maxTime: moment(resp[1].close_time, 'hh:mm:ss').format('LT'),
                    step: 30,
                    useSelect: true,
                    'disableTimeRanges': buildBookedTimes(resp[0])
                });
            },
            error: function (resp) {
                console.log(resp)
            }
        });
    });

//    FAQ Toggle
    $(".question-answers").hide();
    $("#faqSection").hide();

    $(".question").click(function () {
        $(this).next("p").slideToggle();
        if ($(this).find("i").hasClass("fa-arrow-up")) {
            $(this).find("i").addClass("fa-arrow-down").removeClass("fa-arrow-up");
        } else {
            $(this).find("i").addClass("fa-arrow-up").removeClass("fa-arrow-down");
        }
    });
});

function showFaq(param) {
    $("#usSection").hide();
    $("#faqSection").slideToggle();
    $(".headingSelection").removeAttr('id');
    $(param).attr('id', 'aboutUsActive');
}

function showUs(param) {
    $("#usSection").slideToggle();
    $("#faqSection").hide();
    $(".headingSelection").removeAttr('id');
    $(param).attr('id', 'aboutUsActive');
}

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

function tConvert (time) {
    // Check correct time format and split into components
    time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

    if (time.length > 1) { // If time format correct
        time = time.slice (1);  // Remove full string match value
        time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
    }
    return time.join (''); // return adjusted time or original string
}