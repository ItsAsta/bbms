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
                populateBarbers: "",
            },
            type: 'post',
            success : function(resp){
                $("#bookBarberSelect").html(resp);
            },
            error : function(resp){
                console.log(resp)
            }
        });
    });

    // $('#bookedTime').focus(function () {
    //     console.log("heeo")
    //     $('#bookedTime').timepicker('option', {
    //         timeFormat: 'h:i A',
    //         step: 60,
    //     });
    // })

    $('#bookedDate').datepicker({
        startDate: new Date(),
        endDate: "+2w",
        daysOfWeekDisabled: [0,6],
        autoclose: true,
    }).on('change', function () {
        let selectedTime = $("#bookedTime").val();
        let selectedDate= new Date($("#bookedDate").val()).toISOString().split('T')[0];
        let selectedBarbershop = $("#bookBarbershopSelect").val();
        let selectedBarber = $("#bookBarberSelect").val();

        // console.log($(this).datepicker("getDate").getFullYear() + "-" + ('0' + $(this).datepicker("getDate").getMonth()).slice(-2) + "-" + ('0' + $(this).datepicker("getDate").getDate()).slice(-2))
        $.ajax({
            url:'inc/ajax.inc.php',
            data:{
                barbershopId:selectedBarbershop,
                barberId:selectedBarber,
                weekday: $(this).datepicker("getDate").getDay(),
                date: selectedDate,
                // time: '09:30:00',
                openTime: null,
                closeTime: null,
                bookedTimes: ""
            },
            type: 'post',
            dataType: 'json',
            success : function(resp){
                // console.log(buildBookedTimes(resp[0]))
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

    // $('#bookBarberSelect').change(function () {
    //     let selectedBarbershop = $("#bookBarbershopSelect").val();
    //     let selectedBarber = $("#bookBarberSelect").val();
    //
    //     $.ajax({
    //         url:'inc/ajax.inc.php',
    //         data:{
    //             barbershopId:selectedBarbershop,
    //             barberId:selectedBarber,
    //             bookedTimes: ""
    //         },
    //         type: 'post',
    //         dataType: 'json',
    //         success : function(resp){
    //             // $('#bookedTime').timepicker('remove').timepicker({
    //             //     timeFormat: 'h:i A',
    //             //     minTime: '9:00am',
    //             //     maxTime: '6:00pm',
    //             //     step: 30,
    //             //     useSelect: true,
    //             //     'disableTimeRanges': buildBookedTimes(resp)
    //             // });
    //         },
    //         error : function(resp){
    //             console.log(resp)
    //         }
    //     });
    // });
});

function buildBookedTimes(timeArray) {
    let parsedTime;
    let newArray = [];
    let time;
    let date;

    // console.log(timeArray[0].date_time_booked)

    for (let i = 0; i < timeArray.length; i++) {
        parsedTime = new Date(timeArray[i].date_time_booked.split(" ")[0] + " " + timeArray[i].date_time_booked.split(" ")[1])
        let h = `${parsedTime.getHours()}`.padStart(2, '0')
        let m = `${parsedTime.getMinutes()}`.padStart(2, '0')
        let s = `${parsedTime.getSeconds()}`.padStart(2, '0')
        let sEnd = `${parsedTime.getSeconds() + 1}`.padStart(2, '0')

        let time1 = h + ":" + m + ":" + s;
        let time2 = h + ":" + m + ":" + sEnd;
        // console.log(parsedTime.getFullYear() + "-" + parsedTime.getMonth() + 1 + "-" + parsedTime.getDate());

        newArray.push([time1, time2])
    }

    return newArray;
}

// $("#barbershopMgmEditBtn").click(function () {
//     $("#barbershopMgmForm").find("input, select").prop("disabled", false);
//     $("#barbershopInputId").prop("disabled", true);
// });
//
// $(".view-booking-details").click(function () {
//     if (!$(".modal-details").is(":visible")) {
//         $(".modal-details").css("display", "block");
//     }
// });